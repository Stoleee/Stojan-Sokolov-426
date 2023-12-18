<?php

namespace Cinema\Models;


use Cinema\Exceptions\NotFoundException;
use PDO;
use Exception;

class AdminModel extends AbstractModel{
    const CLASSNAME = '\Cinema\Domain\Admin';


    public function getById(int $id){
        $query = "SELECT * FROM admin WHERE id= :id";
        $statement = $this->db->prepare($query);
        $statement->bindValue("id", $id, PDO::PARAM_INT);
        $statement->execute();
        $admins = $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        if (empty($admins)) {
            throw new NotFoundException();
        }
        return $admins[0];
    }

    public function getByUserId(int $id){
        $query = "SELECT * FROM admin WHERE user_id= :id";
        $statement = $this->db->prepare($query);
        $statement->bindValue("id", $id, PDO::PARAM_INT);
        $statement->execute();
        $admins = $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        if (empty($admins)) {
            throw new NotFoundException();
        }
        return $admins[0];
    }

   
 


    public function register($email, $password, $name, $surname){
        $this->db->beginTransaction();
        try {
            $query = <<<SQL
                    INSERT INTO `user`( `email`, `password`, `type`) 
                    VALUES (:email,:password,'admin')
             SQL;
            $statement = $this->db->prepare($query);
            $statement->bindValue("email", $email, PDO::PARAM_STR);
            $statement->bindValue("password", $password, PDO::PARAM_STR);
            if (!$statement->execute()) {
                throw new Exception((string)$statement->errorInfo()[2]);
            }
            $userId = $this->db->lastInsertId();

            $query = <<<SQL
                INSERT INTO `admin`( `name`, `surname`, `user_id`) 
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
    public function export() {
        $result = '';

        $query = "SELECT * FROM movies";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $rez = $statement->fetchAll();
        
        if (!empty($rez)) {
            $result .= '
            <table border=1>  
                <tr> 
                    <th>ID</th>
                    <th>Title</th>
                    <th>Duration</th>
                    <th>Gengre</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Picture</th>
                    <th>Max tickets</th>
                    <th>Description</th>
                </tr>';
                foreach($rez as $row) {
                    $result .= '
                    <tr>  
                        <td>'.$row["id"].'</td>  
                        <td>'.$row["title"].'</td> 
                        <td>'.$row["duration"].'</td>  
                        <td>'.$row["genre"].'</td>  
                        <td>'.$row["date"].'</td>
                        <td>'.$row["price"].'</td>
                        <td>'.$row["picture"].'</td>
                        <td>'.$row["max_tickets"].'</td>
                        <td>'.$row["content"].'</td>
                    </tr>';
                }
            $result .= '</table>';
            
            header('Content-Type: application/xls');
            header('Content-Disposition: attachment; filename=AllMovies.xls');
            echo $result;
            
            return $result;
        }
    }




}
