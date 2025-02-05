<?php

namespace App\controllers;

use App\models\Pizzas\PizzaDAO;

class PizzaController implements ControllerInterface {

    private PizzaDAO $model;

    public function __construct() {
        $this->model = new PizzaDAO();
    }

    public function doGET() {
        header('Content-Type: application/json');
        echo json_encode($this->model->readAll());
    }

    public function doPOST() {
        throw new ControllerException("Cette action n'est pas supportée");
    }
}