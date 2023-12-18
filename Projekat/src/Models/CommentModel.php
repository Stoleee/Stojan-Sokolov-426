<?php

namespace Cinema\Models;


use Cinema\Exceptions\NotFoundException;
use Cinema\Domain\Comment;
use Cinema\Core\Db;
use PDO;
use Cinema\Models\CustomerModel;

class CommentModel extends AbstractModel{

    const CLASSNAME = '\Cinema\Domain\Movies';

 
    public function getByCustomerId($id,$amount=20){
        
        $query = "SELECT * FROM comment WHERE movie_id=:id ORDER BY id DESC ";
        $statement = $this->db->prepare($query);
        $statement->bindValue("id", $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();
        $array = [];
         $i=0;
        foreach ($result as $row) {
            $comment = new Comment();
            $comment->setId($row['id']);
            $comment->setComment($row['comment']);
            $comment->setCreated($row['created']);
           

            $customerModel = new CustomerModel(Db::getInstance());
            $comment->setCustomer($customerModel->getById($row['customer_id']));
            $array[] = $comment;
            $i++;
            if($i==2){
                break;
            }

        }
        
        
        return $array;
        
        
        
    }

    public function getByMovieId($id){
        


        $query = "SELECT *  FROM `comment` WHERE movie_id=:id ";
        $statement = $this->db->prepare($query);
        $statement->bindValue("id", $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();
        $array = [];

        foreach ($result as $row) {
            $comment = new Comment();
            $comment->setId($row['id']);
            $comment->setComment($row['comment']);
            $comment->setCreated($row['created']);
           

            $customerModel = new CustomerModel(Db::getInstance());
            $comment->setCustomer($customerModel->getById($row['customer_id']));
            $array[] = $comment;
        }
        
        
        return $array;
        

        
        
        
       
    }


    public function makeComment( $comment,$customer,$movie){
        $query = "INSERT INTO `comment`(`comment`, `customer_id`,`movie_id`, `created`) VALUES (:comment ,:customer,:movie,curdate())";
        $statement = $this->db->prepare($query);
        $statement->bindParam("comment", $comment, PDO::PARAM_STR);
        $statement->bindParam("customer", $customer, PDO::PARAM_STR);
        $statement->bindParam("movie", $movie, PDO::PARAM_STR);
        $statement->execute();
        return;
    }

    public function getAll(){
        


        $query = "SELECT *  FROM `comment`" ;
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $array = [];

        foreach ($result as $row) {
            $comment = new Comment();
            $comment->setId($row['id']);
            $comment->setComment($row['comment']);
            $comment->setCreated($row['created']);
           

            $customerModel = new CustomerModel(Db::getInstance());
            $comment->setCustomer($customerModel->getById($row['customer_id']));
            $array[] = $comment;
        }
        
        
        return $array;
        

        
        
        
       
    }

    public function delete($id){
    $query = "DELETE FROM `comment` WHERE id=:id;";
    $statement = $this->db->prepare($query);
    $statement->bindParam("id", $id, PDO::PARAM_INT);
    $statement->execute();
    return;
}

    
}
