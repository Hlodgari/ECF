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
        $email = $_GET["email"] ?? null;
        $password = $_GET["password"] ?? null;

        if ($email === null || $password === null) {
            header('Content-Type: application/json');
            echo json_encode(["message" => "Email et mot de passe sont requis"]);
            exit();
        }

        try {
            // $client = $this->model->login($email, $password);
            // $_SESSION["client"] = $client;
            // Router::redirect("GET", "");
            header('Content-Type: application/json');
            echo json_encode(["email" => $email, "password" => $password]);
        } catch (ModelException $exc) {
            header('Content-Type: application/json');
            echo json_encode(["message" => $exc->getMessage()]);
            exit();
        }
    }

    public function doPOST() {
        $email = $_POST["email"] ?? null;
        $password = $_POST["password"] ?? null;

        if ($email === null || $password === null) {
            header('Content-Type: application/json');
            echo json_encode(["message" => "Email et mot de passe sont requis"]);
            exit();
        }

        try {
            // $client = $this->model->login($email, $password);
            // $_SESSION["client"] = $client;
            // Router::redirect("GET", "");
            header('Content-Type: application/json');
            echo json_encode(["email" => $email, "password" => $password]);
        } catch (ModelException $exc) {
            header('Content-Type: application/json');
            echo json_encode(["message" => $exc->getMessage()]);
            exit();
        }
    }
}