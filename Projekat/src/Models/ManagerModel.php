<?php

namespace Cinema\Models;


use Cinema\Exceptions\NotFoundException;
use Cinema\Models\UserModel;
use PDO;
use Exception;

class ManagerModel extends AbstractModel
{
    const CLASSNAME = '\Cinema\Domain\Manager';


    public function getById(int $id){
        $query = "SELECT * FROM manager WHERE id= :id";
        $statement = $this->db->prepare($query);
        $statement->bindValue("id", $id, PDO::PARAM_INT);
        $statement->execute();
        $manager = $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        if (empty($manager)) {
            throw new NotFoundException();
        }
        return $manager[0];
    }

    public function getByUserId(int $id){
        $query = "SELECT * FROM manager WHERE user_id= :id";
        $statement = $this->db->prepare($query);
        $statement->bindValue("id", $id, PDO::PARAM_INT);
        $statement->execute();
        $manager = $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        if (empty($manager)) {
            throw new NotFoundException();
        }
        return $manager[0];
    }

   
    public function getAll(){
        $query = "SELECT * FROM manager ";
        $statement = $this->db->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }


    public function register($email, $password, $name, $surname){
        
        $this->db->beginTransaction();
        try {
            
            $query = <<<SQL
                    INSERT INTO `user`( `email`, `password`, `type`) 
                    VALUES (:email,:password,'manager')
             SQL;
            $statement = $this->db->prepare($query);
            $statement->bindValue("email", $email, PDO::PARAM_STR);
            $statement->bindValue("password", $password, PDO::PARAM_STR);
            if (!$statement->execute()) {
                throw new Exception((string)$statement->errorInfo()[2]);
            }

          
            $userId = $this->db->lastInsertId();
            $model=new UserModel($this->db);

            $query = <<<SQL
                INSERT INTO `manager`( `name`, `surname`,`user_id`) 
                VALUES (:name,:surname,:userId);
             SQL;
            $statement = $this->db->prepare($query);
            $statement->bindValue("name", $name, PDO::PARAM_STR);
            $statement->bindValue("surname", $surname, PDO::PARAM_STR);
            $statement->bindValue("userId", $userId, PDO::PARAM_STR);
          
            
            if (!$statement->execute()) {
                throw new Exception((string)$statement->errorInfo()[2]);
            }
           
            $this->db->commit();
            
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
