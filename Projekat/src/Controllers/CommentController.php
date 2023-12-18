<?php


namespace Cinema\Controllers;

use Cinema\Models\CommentModel;
use Cinema\Models\MoviesModel;



class CommentController extends AbstractController
{
    


    public function getByMovie()
    {
        $properties = [];

        if (!$this->request->getParams()->has("movieId")) {
            header("Location: /movies");
        }
        
        $movieId = $this->request->getParams()->getNumber("movieId");
        //$model = new MoviesModel($this->db);

        //$reservedTicketsModel=new ReservedTicketsModel($this->db);
        //$movie=$model->getById($movieId);
        //$ticketLeft=$movie->getMaxTickets()-$reservedTicketsModel->ticketReserved($movieId);
        
        $model=new CommentModel($this->db);
        $comments=$model->getByMovieId($movieId);
        $properties+=["comments"=>$comments];
        $movieModel=new MoviesModel($this->db);
        $movie=$movieModel->getById($movieId);
        $properties+=["movie"=>$movie];
        if (!$this->request->isPost()) {
           
            return $this->render('comments.twig', $properties);
            
        }
        $params = $this->request->getParams();
        if (!$params->has('comment') || $params->getString('comment')=="") {
            $properties += ['errorMsg' => 'Enter your comment.'];
            return $this->render('comments.twig', $properties);
        }
        
        $comment=$params->getString('comment');
    
        $model->makeComment($comment,$this->userId,$movie->getId() );

        $this->log->info("Customer  successfully added new comment");
        header("Location: /allComments?movieId=".$movie->getId());
        
    }


    public function manage()
    {
        $properties = [];

       
        
        
        $model=new CommentModel($this->db);
        $comments=$model->getAll();
        $properties+=["comments"=>$comments];
        if (!$this->request->isPost()) {
            return $this->render('manageComments.twig', $properties);
            
        }
        $params = $this->request->getParams();
        
        
        $commentId=$params->getString('commentId');
    
        $model->delete($commentId );

        $this->log->info("Manager successfully deleted comement (ID:". $commentId. ")");
        header("Location: /manageComments");
        
    }
}