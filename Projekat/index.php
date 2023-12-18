<?php


use Cinema\Core\Router;
use Cinema\Core\Request;

use Cinema\Models\MoviesModel;
use Cinema\Models\CommentModel;
use Cinema\Core\Db;


require_once __DIR__ . '/vendor/autoload.php';


$router = new Router();
$response = $router->route(new Request());
echo $response;

/*
$model = new CommentModel(Db::getInstance());
$movies=$model->getByCustomerId(1);
var_dump($movies);*/