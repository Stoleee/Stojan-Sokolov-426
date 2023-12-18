<?php


namespace Cinema\Domain;


class ReservedTickets{
    private $id;
	private $movie;
    private $customer;

    public function getId(){
        return $this->id;
    }
    public function getMovie(){
        return $this->movie;
    }
    public function getCustomer(){
        return $this->customer;
    }
    public function setMovie($movie){
        $this->movie=$movie;
    }
    public function setCustomer($customer){
        $this->customer=$customer;
    }
    public function setId($id){
        $this->id=$id;
    }
    

}