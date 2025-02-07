<?php

namespace App\controllers;

use App\models\Clients\ClientDAO;


use App\config\Router;


class LogoutController implements \App\controllers\ControllerInterface {
   
    private ClientDAO $model;

    public function __construct() {
        $this->model = new ClientDAO();
    }

    public function doGET() {
        session_start();
        session_destroy();
        Router::redirect("GET", "home");
    }
    
    public function doPOST() {
        throw new ControllerException("Cette action n'est pas supportée");
    }

}