<?php

namespace App\controllers;

use App\models\Clients\ClientDAO;
use App\models\Clients\Client;
use App\config\Router;

class RegisterController implements \App\controllers\ControllerInterface {

    private ClientDAO $model;

    public function __construct(){
        $this->model = new ClientDAO();
    }

    public function doGET(): void {
        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            $client = $this->model->findByEmail($email);
            if ($client) {
                echo json_encode(['exists' => true]);
            } else {
                echo json_encode(['exists' => false]);
            }
        } else {
            echo json_encode(['error' => 'Email parameter is missing']);
        }
    }

    public function doPOST(): void {
        if (isset($_POST["nom"], $_POST["prenom"], $_POST["email"], $_POST["telephone"], $_POST["password"], $_POST["adresse"])) {
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $email = $_POST["email"];
            $telephone = $_POST["telephone"];
            $mot_de_passe = $_POST["password"];
            $adresse = $_POST["adresse"];

            $newClient = new Client();
            $newClient
                ->setNom($nom)
                ->setPrenom($prenom)
                ->setEmail($email)
                ->setTelephone($telephone)
                ->setMot_de_passe($mot_de_passe)
                ->setAdresse($adresse);

            $this->model->create($newClient);
            Router::redirect("POST", "login");
        } else {
            echo json_encode(['error' => 'Missing parameters']);
        }
    }
}