<?php

namespace Cinema\Models;


use Cinema\Exceptions\NotFoundException;
use Cinema\Domain\Movies;
use Cinema\Core\Db;
use PDO;

class MoviesModel extends AbstractModel{

    const CLASSNAME = '\Cinema\Domain\Movies';

    public function getAll($search){
        
        $query = "SELECT * FROM movies  WHERE title LIKE :search AND date >= NOW()";
        $statement = $this->db->prepare($query);
        $statement->bindValue("search", "%$search%");
        $statement->execute();
        $result = $statement->fetchAll();
        $array = [];

        foreach ($result as $row) {
            $movie = new Movies();
            $movie->setId($row['id']);
            $movie->setTitle($row['title']);
            $movie->setPicture($row['picture']);
            $movie->setDuration($row['duration']);
            $movie->setGenre($row['genre']);
            $movie->setDate($row['date']);
            $movie->setPrice($row['price']);
            $movie->setContent($row['content']);
            $movie->setMaxTickets($row['max_tickets']);

            $commentModel = new CommentModel(Db::getInstance());
            $movie->setComments($commentModel->getByCustomerId($row['id']),2);
            $array[] = $movie;
        }
        
        
        return $array;
    }

    public function getById($id){

        $query = "SELECT * FROM movies WHERE id=:id ";
        $statement = $this->db->prepare($query);
        $statement->bindValue("id", $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();
        $array = [];

        foreach ($result as $row) {
            $movie = new Movies();
            $movie->setId($row['id']);
            $movie->setTitle($row['title']);
            $movie->setPicture($row['picture']);
            $movie->setDuration($row['duration']);
            $movie->setGenre($row['genre']);
            $movie->setDate($row['date']);
            $movie->setPrice($row['price']);
            $movie->setContent($row['content']);
            $movie->setMaxTickets($row['max_tickets']);

            $commentModel = new CommentModel(Db::getInstance());
            $movie->setComments($commentModel->getByCustomerId($row['id']));
            $array[] = $movie;
        }
        
        
        return $array[0];
    }
    public function add($title, $picture,$duration,$genre,$date,$price,$content, $maxTickets){

        $query = "INSERT INTO `movies`(`title`,`picture`,`duration`,`genre`,`date`,`price`,`content`,`max_tickets`) VALUES
        (:title, :picture,:duration,:genre,:date,:price,:content,:maxTickets)";
       
        $statement = $this->db->prepare($query);
        $statement->bindParam("title", $title, PDO::PARAM_STR);
        $statement->bindParam("picture", $picture, PDO::PARAM_STR);
        $statement->bindParam("duration", $duration, PDO::PARAM_STR);
        $statement->bindParam("genre", $genre, PDO::PARAM_STR);
        $statement->bindParam("date", $date, PDO::PARAM_STR);
        $statement->bindParam("price", $price, PDO::PARAM_STR);
        $statement->bindParam("content", $content, PDO::PARAM_STR);
        $statement->bindParam("maxTickets", $maxTickets, PDO::PARAM_STR);
        $statement->execute();
        return;
    }
    
}
