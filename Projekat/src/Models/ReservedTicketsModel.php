<?php

namespace Cinema\Models;


use Cinema\Exceptions\NotFoundException;
use Cinema\Models\MoviesModel;
use Cinema\Models\CustomerModel;
use Cinema\Domain\ReservedTickets;
use Cinema\Core\Db;
use PDO;

class ReservedTicketsModel extends AbstractModel{


    const CLASSNAME = '\Cinema\Domain\ReservedTickets';

    public function getAll(){
        $query = "SELECT * FROM `reserved tickets`";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $array = [];
        foreach ($result as $row) {
            $ticket = new ReservedTickets();
            $ticket->setId($row['id']);

            $model=new MoviesModel(Db::getInstance());
            $ticket->setMovie($model->getById($row['movie_id']));
            
            $model=new CustomerModel(Db::getInstance());
            $ticket->setCustomer($model->getById($row['customer_id']));              
            $array[] = $ticket;
        }
        
        
        return $array;
    }



    public function getByCustomerId($customerId){
        


        $query = "SELECT * FROM `reserved tickets` WHERE customer_id=:customerId ";
        $statement = $this->db->prepare($query);
        $statement->bindValue("customerId", $customerId, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();
        $array = [];

        foreach ($result as $row) {
            $ticket = new ReservedTickets();
            $ticket->setId($row['id']);

            $model=new MoviesModel(Db::getInstance());
            $ticket->setMovie($model->getById($row['movie_id']));
            
            $model=new CustomerModel(Db::getInstance());
            $ticket->setCustomer($model->getById($row['customer_id']));
           
            

            
            $array[] = $ticket;
        }
        
        
        return $array;
    }

    
    public function addTicket($movieId, $customerId){
   
   
        $query = <<<SQL
                INSERT INTO `reserved tickets`(`movie_id`,`customer_id`) 
                VALUES (:movieId,:customerId);
               
         SQL;
        $statement = $this->db->prepare($query);
        $statement->bindValue("movieId", $movieId, PDO::PARAM_STR);
        $statement->bindValue("customerId", $customerId, PDO::PARAM_STR);
        if (!$statement->execute()) {
            throw new Exception((string)$statement->errorInfo()[2]);
        }
}

    public function delete($id){
    $query = "DELETE FROM `reserved tickets` WHERE id=:id;";
    $statement = $this->db->prepare($query);
    $statement->bindParam("id", $id, PDO::PARAM_INT);
    $statement->execute();
    return;
}


    public function ticketReserved($id):int{
    $query = "SELECT COUNT(id) AS `total` FROM `reserved tickets` WHERE movie_id=:id ";
    $statement = $this->db->prepare($query);
    $statement->bindValue("id", $id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll();
    $array = [];

    foreach ($result as $row) {
        return $row['total'];
    }  
}

        public function customerBoughtTicket($movieId,$customerId):bool{
        $query = "SELECT * FROM `reserved tickets` WHERE movie_id= :movieId AND customer_id= :customerId ";
        $statement = $this->db->prepare($query);
        $statement->bindValue("movieId", $movieId, PDO::PARAM_STR);
        $statement->bindValue("customerId", $customerId, PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        if (empty($row)) {
            return false;
        }
        return true;
     }
    
 }
