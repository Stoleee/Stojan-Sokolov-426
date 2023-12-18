<?php

namespace Cinema\Controllers;
use Cinema\Models\ReservedTicketsModel;

class ReservedTicketsController extends AbstractController
{
    

    public function customerTickets()
    {
        $properties = [];

        $model = new ReservedTicketsModel($this->db);

        if ($this->request->isPost()) {
            $params = $this->request->getParams();
            $ticketId = $params->getString('ticketId');
            $model->delete($ticketId);
            $this->log->info("Customer canceled reservation: " . $ticketId);
        }
        
       
       
        $tickets= $model->getByCustomerId($this->userId);
        $properties+=["tickets"=>$tickets];
        

        return $this->render('myTickets.twig', $properties);
    }

    
}
