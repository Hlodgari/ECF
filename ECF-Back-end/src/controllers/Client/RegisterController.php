<?php

namespace App\controller;

use App\models\Client\ClientDAO;
use App\models\Client\Client;
use App\Router;

/**
 *  Contrôlleur responsable de l'inscription d'un nouvel utilisateur
 */
class RegisterController implements ControllerInterface {

    /**
     * Instance de la classe ClientDAO
     * @var ClientDAO $model
     */
    private ClientDAO $model;

    /**
     * Construit une nouvelle instance
     */
    public function __construct(){
        $this->model = new ClientDAO();
    }

    /**
     * Traite les requêtes HTTP envoyées par la méthode GET
     * @return void
     */
    public function doGET(): void {
        // affiche le formulaire d'inscription
        $title = "Inscription";
        include("./view/register.php");
    }
    
    /**
     * Traite les requêtes HTTP envoyées par la méthode POST
     * @return void
     */
    public function doPOST(): void {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $telephone = $_POST["telephone"];
        $password = $_POST["password"];
        $address = $_POST["address"];
        
        $newClient = new Client();
        $newClient
            ->setNom($nom)
            ->setPrenom($prenom)
            ->setEmail($email)
            ->setPhone($telephone)
            ->setPassword($password)
            ->setAddress($address);
        
        $this->model->create($newClient);
        Router::redirect("POST", "login");
    }
}