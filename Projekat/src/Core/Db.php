<?php

namespace Cinema\Core;

use PDO;
use Cinema\Core\Config;

class Db
{
    private static $instance;
    private static function connect(): PDO
    {
        
        $dbConfig = Config::getInstance()->get('db');
        return new PDO(
            'mysql:host=localhost;dbname=cinema',
            $dbConfig['user'],
            $dbConfig['password']
        );
    }
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = self::connect();
        }
        return self::$instance;
    }
}
