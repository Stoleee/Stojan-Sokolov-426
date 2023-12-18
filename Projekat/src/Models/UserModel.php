<?php

namespace Cinema\Models;


use Cinema\Exceptions\NotFoundException;
use PDO;

class UserModel extends AbstractModel{
    const CLASSNAME = '\Cinema\Domain\User';

    public function getById(int $id){
        $query = "SELECT * FROM user WHERE id= :id";
        $statement = $this->db->prepare($query);
        $statement->bindValue("id", $id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        if (empty($row)) {
            throw new NotFoundException();
        }
        return $row[0];
    }

    public function getByEmail(string $email){
        $query = "SELECT * FROM user WHERE email= :email";
        $statement = $this->db->prepare($query);
        $statement->bindValue("email", $email, PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        if (empty($row)) {
            throw new NotFoundException();
        }
        return $row[0];
    }
    public function checkEmail(string $email){
        $query = "SELECT * FROM user WHERE email= :email";
        $statement = $this->db->prepare($query);
        $statement->bindValue("email", $email, PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        if (empty($row)) {
            return false;
        }
        return true;
    }

    
    public function getAll() {
        $query = "SELECT * FROM user ";
        $statement = $this->db->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }
    
}
