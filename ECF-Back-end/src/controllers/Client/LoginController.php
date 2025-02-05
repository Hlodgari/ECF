<?php

namespace App\controller;

use App\models\Client\ClientDAO;
use App\models\ModelException;
use App\Router;

/**
 * Contrôlleur responsable de la connexion utilisateur
 */
class LoginController implements ControllerInterface {

    /**
     * Instance de la classe ClientDAO
     * @var ClientDAO $model
     */
    private ClientDAO $model;

    /**
     * Construit une nouvelle instance
     */
    public function __construct() {
        $this->model = new ClientDAO();
    }

    /**
     * Traite les requêtes HTTP envoyées par la méthode GET
     * @return void
     */
    public function doGET() {
        // affiche un formulaire pour connexion 
        $title = "Connexion";
        include("./view/login.php");
    }

    /**
     * Traite les requêtes HTTP envoyées par la méthode POST
     * @return void
     */
    public function doPOST() {
        // traite les données du formulaire de connexion
        $email = $_POST["email"];
        $password  = $_POST["password"];
        try {
            $client = $this->model->login($email, $password);
            $_SESSION["client"] = $client;
            Router::redirect("GET", "home");
        } catch (ModelException $exc){
            exit($exc->getMessage());
        }
    }
}