<?php

namespace Cinema\Controllers;

use Cinema\Core\Config;
use Cinema\Core\Db;
use Cinema\Core\Request;
use Monolog\Logger;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Monolog\Handler\StreamHandler;

abstract class AbstractController{
    protected $request;
    protected $db;
    protected $config;
    protected $view;
    protected $log;


    protected $userId; 
    protected $userType;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->db = Db::getInstance();
        $this->config = Config::getInstance();
        $loader = new FilesystemLoader(
            __DIR__ . '/../../src/Views'
        );
        $this->view = new Environment($loader);
        $this->log = new Logger('cinema');
        $logFile = $this->config->get('log');
        $this->log->pushHandler(
            new StreamHandler($logFile, Logger::DEBUG)
        );
    }
    public function setUser(int $id, string $type)
    {
        $this->userId = $id;
        $this->userType = $type;
    }
    protected function render(string $template, array $params): string
    {
        if ($this->request->getCookies()->has('userType')) {
            $type = $this->request->getCookies()->getString('userType');
            $params += ['userType' => $type];
        }
        return $this->view->load($template)->render($params);
    }
}
