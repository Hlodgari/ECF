<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Dotenv\Dotenv;
use App\config\Router;
use App\controllers\PizzaController;
use App\controllers\Clients\LoginController;
use App\controllers\LogoutController;
use App\controllers\RegisterController;

// Ajouter cet en-tête pour permettre les requêtes CORS
header("Access-Control-Allow-Origin: *");

// Si vous avez besoin de permettre des méthodes spécifiques, ajoutez cet en-tête
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Si vous avez besoin de permettre des en-têtes spécifiques, ajoutez cet en-tête
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Charger les variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Ajouter les routes
Router::addRoute("pizzas", new PizzaController());
// Router::addRoute("register", new RegisterController());
// Router::addRoute("logout", new LogoutController());
Router::addRoute("login", new LoginController());

// Déléguer la requête au contrôleur approprié
Router::delegate();
