<?php

namespace App\controllers\Clients;

use App\models\Clients\ClientDAO;
use App\models\ModelException;
use App\controllers\ControllerException;
use App\config\Router;

class LoginController implements \App\controllers\ControllerInterface {


    private ClientDAO $model;

    public function __construct() {
        $this->model = new ClientDAO();
    }


    public function doGET() {
        $email = $_GET["email"];
        $password  = $_GET["password"];
        try {
            // $client = $this->model->login($email, $password);
            // $_SESSION["client"] = $client;
            // Router::redirect("GET", "");
            header('Content-Type: application/json');
            echo json_encode(["email" => $email, "password" => $password]);
        } catch (ModelException $exc){
            exit($exc->getMessage());
        }
    }

    
    public function doPOST() {
        $email = $_POST["email"];
        $password  = $_POST["password"];
        try {
            // $client = $this->model->login($email, $password);
            // $_SESSION["client"] = $client;
            // Router::redirect("GET", "");
            header('Content-Type: application/json');
            echo json_encode(["email" => $email, "password" => $password]);
        } catch (ModelException $exc){
            header('Content-Type: application/json');
            echo json_encode(["message" => $exc->getMessage()]);
            exit();
        }
        
    }
}