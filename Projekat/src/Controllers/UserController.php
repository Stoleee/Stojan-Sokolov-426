<?php

namespace Cinema\Controllers;

use Cinema\Models\UserModel;
use Cinema\Models\CustomerModel;
use Cinema\Models\ManagerModel;
use Cinema\Models\AdminModel;
use Cinema\Exceptions\NotFoundException;

class UserController extends AbstractController
{
    public function login(): string
    {
        if ($this->request->getCookies()->has('userType')) {
            switch ($this->request->getCookies()->getString('userType')) {
                case 'customer':
                    header("Location: /customer");
                    break;
                case 'manager':
                    header("Location: /manager");
                    break;
                case 'admin':
                    header("Location: /admin");
                    break;
                default:

                    break;
            }
        }


        $properties = [];



        if (!$this->request->isPost()) {
            return $this->render('login.twig', $properties);
        }
        $params = $this->request->getParams();
        if (!$params->has('email') || $params->getString('email') == "") {
            $properties += ['errorMessage' => 'Enter your email.'];
            return $this->render('login.twig', $properties);
        }
        $email = $params->getString('email');
        $userModel = new UserModel($this->db);
        $user = null;
        try {
            $user = $userModel->getByEmail($email);
        } catch (NotFoundException $e) {
            $properties += ['errorMessage' => 'Wrong email.'];
            return $this->render('login.twig', $properties);
        }

        if (!$params->has('password') || $params->getString('password') == "") {
            $properties += ['errorMessage' => 'Enter your password.'];
            return $this->render('login.twig', $properties);
        }
        $password = $params->getString('password');
        if ($password !== $user->getPassword()) {
            $properties += ['errorMessage' => 'Wrong password.'];           
            return $this->render('login.twig', $properties);
        }

        setcookie('userType', $user->getType());

        $this->log->info("User " . $user->getId() . " successfully loged in");


        switch ($user->getType()) {
            case 'customer':
                $model = new CustomerModel($this->db);
                $customer = $model->getByUserId($user->getId());
                setcookie('userId', $customer->getId());
                header("Location: /customer");
                break;
            case 'manager':
                $model = new ManagerModel($this->db);
                $manager = $model->getByUserId($user->getId());
                setcookie('userId', $manager->getId());
                header("Location: /manager");
                break;
            case 'admin':
                $model = new AdminModel($this->db);
                $admin = $model->getByUserId($user->getId());
                setcookie('userId', $admin->getId());
                header("Location: /admin");
                break;
            default:
                return
                    $this->render('login.twig', $properties);
                break;
        }
    }
    public function logout()
    {
        if (isset($_COOKIE['userId']) &&  isset($_COOKIE['userType'])) {
            unset($_COOKIE['userId']);
            setcookie('userId', '', time() - 3600, '/');
            unset($_COOKIE['userType']);
            setcookie('userType', '', time() - 3600, '/');
        }
        $this->log->info("User loged out");
       
        header("Location: /");
    }

    
}
