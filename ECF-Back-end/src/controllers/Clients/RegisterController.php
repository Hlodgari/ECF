<?php

namespace App\controllers;

use App\models\Clients\ClientDAO;
use App\models\Clients\Client;

class RegisterController implements \App\controllers\ControllerInterface {

    private ClientDAO $model;

    public function __construct(){
        $this->model = new ClientDAO();
    }

    public function doGET(): void {
        header('Content-Type: application/json');
        if (isset($_GET['email'])) {
            $email = filter_var($_GET['email'], FILTER_VALIDATE_EMAIL);
            if ($email === false) {
                echo json_encode(['error' => 'Invalid email format']);
                return;
            }
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
        header('Content-Type: application/json');
        $requiredFields = ['nom', 'prenom', 'email', 'telephone', 'motdepasse', 'adresse'];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field])) {
                echo json_encode(['error' => 'Missing parameters']);
                return;
            }
        }

        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            echo json_encode(['error' => 'Invalid email format']);
            return;
        }

        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $telephone = htmlspecialchars($_POST['telephone']);
        $mot_de_passe = password_hash($_POST['motdepasse'], PASSWORD_BCRYPT);
        $adresse = htmlspecialchars($_POST['adresse']);

        $newClient = new Client();
        $newClient
            ->setNom($nom)
            ->setPrenom($prenom)
            ->setEmail($email)
            ->setTelephone($telephone)
            ->setMot_de_passe($mot_de_passe)
            ->setAdresse($adresse);

        try {
            $this->model->create($newClient);
            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            echo json_encode(['error' => 'Failed to create client']);
        }
    }
}