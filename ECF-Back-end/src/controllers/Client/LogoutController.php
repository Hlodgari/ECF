<?php

namespace App\controller;

use App\Router;

/**
 * Contrôlleur responsable de la déconnexion utilisateur
 */
class LogoutController implements ControllerInterface {

    public function __construct() {}

    /**
     * Méthode appelée lors d'une requête GET
     * @return void
     */
    public function doGET() {
        session_start();
        session_destroy();
        Router::redirect("GET", "home");
    }
    
    /**
     * Méthode appelée lors d'une requête POST
     * @return void
     */
    public function doPOST() {
        throw new ControllerException("Cette action n'est pas supportée");
    }

}