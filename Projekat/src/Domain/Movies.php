<?php

namespace Cinema\Domain;

class Movies{
    private $id;
	private $title;
	private $picture;
	private $duration;
	private $genre;
	private $date;
	private $price;
	private $content;
	private $max_tickets;

    private $comments;
    


    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }
    public function getPicture(){
        return $this->picture;
    }

    public function getDuration(){
        return $this->duration;
    }
    public function getGenre(){
        return $this->genre;
    }
    public function getDate(){
        return $this->date;
    }
    public function getPrice(){
        return $this->price;
    }
    public function getContent(){
        return $this->content;
    }
    public function getMaxTickets(){
        return $this->max_tickets;
    }
    public function getComments(){
        return $this->comments;
    }


    public function setID(int $id){
        $this->id = $id;
    }
    public function setTitle(string $title){
        $this->title = $title;
    }
    public function setPicture(string $picture){
        $this->picture = $picture;
    }
    public function setDuration(string $duration){
        $this->duration = $duration;
    }
    public function setGenre(string $genre){
        $this->genre = $genre;
    }
    public function setDate($date){
        $this->date = $date;
    }
    public function setPrice(int $price){
        $this->price = $price;
    }
    public function setContent(string $content){
        $this->content = $content;
    }
    public function setMaxTickets(string $max_tickets){
        $this->max_tickets = $max_tickets;
    }

    public function setComments($comments){
        $this->comments = $comments;
    }

    


}