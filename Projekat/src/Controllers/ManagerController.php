<?php

namespace Cinema\Controllers;

use Cinema\Models\ManagerModel;
use Cinema\Models\UserModel;

class ManagerController extends AbstractController
{
    public function get()
    {
        $properties = [];


        $model = new ManagerModel($this->db);
        $manager = $model->getById($this->userId);
        $properties += ['manager' => $manager];
        return $this->render('manager.twig', $properties);
    }

    public function add()
    {
        $properties = [];


        if (!$this->request->isPost()) {
            return $this->render('addManager.twig', $properties);
        }
        $params = $this->request->getParams();
        if (!$params->has('email') || $params->getString('email') == "") {
            $properties = ['errorMsg' => 'Enter  email.'];
            
            return $this->render('addManager.twig', $properties);
        }
        $userModel = new UserModel($this->db);
        if ($userModel->checkEmail($params->getString('email'))) {
            $properties += ['errorMsg' => 'Email already taken.'];
            
            return $this->render('addManager.twig', $properties);
        }
        if (!$params->has('password') || $params->getString('password') == "") {
            $properties += ['errorMsg' => 'Enter  password.'];
           
            return $this->render('addManager.twig', $properties);
        }
        if (!$params->has('retype') || $params->getString('password') != $params->getString('retype')) {
            $properties += ['errorMsg' => 'Retype pasword does not match.'];
          
            return $this->render('addManager.twig', $properties);
        }
        
        if (!$params->has('name') || $params->getString('name') == "") {
            $properties += ['errorMsg' => 'Enter  name.'];
            
            return $this->render('addManager.twig', $properties);
        }
        if (!$params->has('surname') || $params->getString('surname') == "") {
            $properties += ['errorMsg' => 'Enter  surname.'];
            
            return $this->render('addManager.twig', $properties);
        }

        $email = $params->getString('email');
        $password = $params->getString('password');
        $name = $params->getString('name');
        $surname = $params->getString('surname');
        $model = new ManagerModel($this->db);
        
        try {
            
            $model->register($email, $password, $name, $surname);
            
        } catch (\Exception $e) {
            $this->render("error.twig", ['errorMsg' => (string)$e]);
        }
        $this->log->info("Admin successfully added new manager");
        header("Location: /login");
    }
}
