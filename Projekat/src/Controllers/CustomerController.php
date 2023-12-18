<?php

namespace Cinema\Controllers;

use Cinema\Models\CustomerModel;
use Cinema\Models\RentCarModel;
use Cinema\Models\UserModel;

class CustomerController extends AbstractController
{
    public function get()
    {
        $properties = [];


        $model = new CustomerModel($this->db);
        $customer = $model->getById($this->userId);
        $properties += ['customer' => $customer];
        return $this->render('customer.twig', $properties);
    }

    public function register()
    {
        $properties = [];


        if (!$this->request->isPost()) {
            return $this->render('register.twig', $properties);
        }
        $params = $this->request->getParams();
        if (!$params->has('email') || $params->getString('email') == "") {
            $properties = ['errorMessage' => 'Enter  email.'];          
            return $this->render('register.twig', $properties);
        }
        $userModel = new UserModel($this->db);
        if ($userModel->checkEmail($params->getString('email'))) {
            $properties += ['errorMessage' => 'Email already taken.'];          
            return $this->render('register.twig', $properties);
        }
        if (!$params->has('password') || $params->getString('password') == "") {
            $properties += ['errorMessage' => 'Enter  password.'];          
            return $this->render('register.twig', $properties);
        }
        if (!$params->has('retype') || $params->getString('password') != $params->getString('retype')) {
            $properties += ['errorMessage' => 'Retype pasword does not match.'];          
            return $this->render('register.twig', $properties);
        }
        
        if (!$params->has('name') || $params->getString('name') == "") {
            $properties += ['errorMessage' => 'Enter your name.'];          
            return $this->render('register.twig', $properties);
        }
        if (!$params->has('surname') || $params->getString('surname') == "") {
            $properties += ['errorMessage' => 'Enter your surname.'];         
            return $this->render('register.twig', $properties);
        }

        

        $email = $params->getString('email');
        $password = $params->getString('password');
        $name = $params->getString('name');
        $surname = $params->getString('surname');
        $model = new CustomerModel($this->db);
        try {
            $model->register($email, $password, $name, $surname);
        } catch (\Exception $e) {
            $this->render("error.twig", ['errorMessage' => (string)$e]);
        }

        $this->log->info("Customer successfully registered");
        header("Location: /login");
    }
}
