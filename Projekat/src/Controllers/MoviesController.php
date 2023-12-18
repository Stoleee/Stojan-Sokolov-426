<?php


namespace Cinema\Controllers;

use Cinema\Models\MoviesModel;
use Cinema\Models\ReservedTicketsModel;


class MoviesController extends AbstractController
{
    public function all()
    {
        $properties = [];
        $search="";
        if ($this->request->isPost()) {
           $search=$this->request->getParams()->getString("search");
        }
       
        $model = new MoviesModel($this->db);
        $movies=$model->getAll($search);
        $properties+=["movies"=>$movies];

        return $this->render('movies.twig', $properties);
    }


    public function buyTicket()
    {
        $properties = [];

        if (!$this->request->getParams()->has("movieId")) {
            header("Location: /movies");
        }
        
        $movieId = $this->request->getParams()->getNumber("movieId");
        $model = new MoviesModel($this->db);

        $reservedTicketsModel=new ReservedTicketsModel($this->db);
        $movie=$model->getById($movieId);
        $ticketLeft=$movie->getMaxTickets()-$reservedTicketsModel->ticketReserved($movieId);
        
        if (!$this->request->isPost()) {
            $properties+=["movie"=>$movie];
            $properties+=["ticketLeft"=>$ticketLeft];
  
            return $this->render('movie.twig', $properties);
            
        }
        if($ticketLeft==0){
            $properties+=["errorMsg"=>"Sorry we are out of tickets"];
            $properties+=["movie"=>$movie];
            $properties+=["ticketLeft"=>$ticketLeft];
            $this->log->warning("Customer tried buy ticket for movie (ID:". $movieId .") but ticket not left");
            return $this->render('movie.twig', $properties);
        }
        if( $reservedTicketsModel->customerBoughtTicket($movieId,$this->userId)){
            $properties+=["errorMsg"=>"You already bought ticket for this movie"];
            $properties+=["movie"=>$movie];
            $properties+=["ticketLeft"=>$ticketLeft];
            $this->log->warning("Customer tried buy ticket for movie (ID:". $movieId .") but he already buy it");
            return $this->render('movie.twig', $properties);
        }

        $reservedTicketsModel->addTicket($movieId,$this->userId);

        $this->log->info("Customer buy ticket for movie (ID:". $movieId .")");

        header("Location: /myTickets");
        
    }

    public function add()
    {
        $properties = [];


        if (!$this->request->isPost()) {
            return $this->render('addMovie.twig', $properties);
        }


        $params = $this->request->getParams();
        if (!$params->has('title') || $params->getString('title') == "") {
            $properties = ['errorMsg' => 'Enter  title.'];
           
            return $this->render('addMovie.twig', $properties);
        }
        if (!$params->has('picture') || $params->getString('picture') == "") {
            $properties = ['errorMsg' => 'Enter  picture src.'];
           
            return $this->render('addMovie.twig', $properties);
        }
        if (!$params->has('duration') || $params->getString('duration') == "") {
            $properties = ['errorMsg' => 'Enter  duration.'];
           
            return $this->render('addMovie.twig', $properties);
        }
        if (!$params->has('genre') || $params->getString('genre') == "") {
            $properties = ['errorMsg' => 'Enter  genre.'];
           
            return $this->render('addMovie.twig', $properties);
        }
        if (!$params->has('date') || $params->getString('date') == "") {
            $properties = ['errorMsg' => 'Enter  date.'];
           
            return $this->render('addMovie.twig', $properties);
        }
        if (!$params->has('price') || $params->getString('price') == "") {
            $properties = ['errorMsg' => 'Enter  price.'];
           
            return $this->render('addMovie.twig', $properties);
        }
        if (!$params->has('content') || $params->getString('content') == "") {
            $properties = ['errorMsg' => 'Enter  content.'];
           
            return $this->render('addMovie.twig', $properties);
        }
        if (!$params->has('maxTickets') || $params->getString('maxTickets') == "") {
            $properties = ['errorMsg' => 'Enter  number of tickets.'];
           
            return $this->render('addMovie.twig', $properties);
        }
        

        $title = $params->getString('title');
        
        $picture = $params->getString('picture');
        $duration = $params->getString('duration');
        $genre = $params->getString('genre');
        $date = $params->getString('date');
        $price = $params->getString('price');
        $content = $params->getString('content');
        $maxTickets = $params->getString('maxTickets');
       
        $model = new MoviesModel($this->db);
        try {
            $model->add($title ,$picture,$duration,$genre,$date,$price,$content, $maxTickets);
        } catch (\Exception $e) {
            $this->render("error.twig", ['errorMsg' => (string)$e]);
        }
        $this->log->info("Manager successfully added new movie");
        
        header("Location: /movies");
    }
}
