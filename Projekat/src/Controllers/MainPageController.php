<?php


namespace Cinema\Controllers;



class MainPageController extends AbstractController
{
    public function home()
    {
        $properties = [];

        return $this->render('home.twig', $properties);
    }
}
