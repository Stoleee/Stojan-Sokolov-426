<?php

namespace Cinema\Domain;

class Comment{
    private $id;
    private $comment;
    private $created;
    private $customer;


    public function getId(){
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getComment(){
        return $this->comment;
    }

    public function setComment($comment){
        $this->comment = $comment;
    }

    public function getCreated()
    {
        return $this->created;
    }
    


    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getCustomer(){
        return $this->customer;
    }

    public function setCustomer($customer){
        $this->customer= $customer;
    }
    
    
    

}
