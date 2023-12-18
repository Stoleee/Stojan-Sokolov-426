<?php

namespace Cinema\Controllers;

use Cinema\Models\AdminModel;
use Cinema\Models\CarModel;
use Cinema\Models\UserModel;
use Cinema\Models\ReservedTicketsModel;
use Mpdf\Mpdf;

class AdminController extends AbstractController
{
    public function get()
    {
        $properties = [];


        $model = new AdminModel($this->db);
        $admin = $model->getById($this->userId);
        $properties += ['admin' => $admin];


        return $this->render('admin.twig', $properties);
    }

    public function add()
    {
        $properties = [];


        if (!$this->request->isPost()) {
            return $this->render('addAdmin.twig', $properties);
        }
        $params = $this->request->getParams();
        if (!$params->has('email') || $params->getString('email') == "") {
            $properties = ['errorMsg' => 'Enter  email.'];
            return $this->render('addAdmin.twig', $properties);
        }
        $userModel = new UserModel($this->db);
        if ($userModel->checkEmail($params->getString('email'))) {
            $properties += ['errorMsg' => 'Email already taken.'];
            return $this->render('addAdmin.twig', $properties);
        }
        if (!$params->has('password') || $params->getString('password') == "") {
            $properties += ['errorMsg' => 'Enter  password.'];
            return $this->render('addAdmin.twig', $properties);
        }
        if (!$params->has('retype') || $params->getString('password') != $params->getString('retype')) {
            $properties += ['errorMsg' => 'Retype pasword does not match.'];
            return $this->render('addAdmin.twig', $properties);
        }
       
        if (!$params->has('name') || $params->getString('name') == "") {
            $properties += ['errorMsg' => 'Enter  name.'];
            return $this->render('addAdmin.twig', $properties);
        }
        if (!$params->has('surname') || $params->getString('surname') == "") {
            $properties += ['errorMsg' => 'Enter  surname.'];
            return $this->render('addAdmin.twig', $properties);
        }

        $email = $params->getString('email');
        $password = $params->getString('password');
        $name = $params->getString('name');
        $surname = $params->getString('surname');
        $model = new AdminModel($this->db);
        try {
            $model->register($email, $password, $name, $surname);
        } catch (\Exception $e) {
            $this->render("error.twig", ['errorMsg' => (string)$e]);
        }
        $this->log->info("Admin successfully added new admin");
        header("Location: /login");
    }

    public function export() {
        $adminModel = new AdminModel($this->db);
        $adminModel->export();
        return "";
    }

    public function exportReservations() {
        $model = new ReservedTicketsModel($this->db);
        $reservations=$model->getAll();
        
        $mpdf = new Mpdf();
        $mpdf->WriteHTML('<!DOCTYPE html>
          <html>
            <head>
                 <style>
                   table ,th,td{border-collapse: collapse; border: 1px solid;}
                </style>
            </head>
            <body>
                        
            <h1 style="text-align: center;">All reservations </h1>
                        
            <table> 
            <tr>
            <th> Id reservation</th>
            <th> Name</th>
            <th> Surname</th>
            <th> Movie</th>
            <th> Date</th>
            </tr>');
                foreach ($reservations as $rents ) {
                    $mpdf->WriteHTML('<tr>
                        <td> ' .$rents->getId() . ' </td>
                        <td>' . $rents->getCustomer()->getName() .'</td>
                        <td>' . $rents->getCustomer()->getSurname() . '</td>
                        <td> ' .$rents->getMovie()->getTitle() . ' </td>
                        <td>' . $rents->getMovie()->getDate() . '</td>
            </tr>');
                }
            $mpdf->WriteHTML('</table>
                </body>
                </html>');
            $fileName = "allReservations_" . date("Y-m-d") . ".pdf";
            $mpdf->Output($fileName, 'D');
                }


 }

    




