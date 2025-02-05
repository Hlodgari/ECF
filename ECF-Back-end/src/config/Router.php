<?php

namespace App\config;

use App\controllers\ControllerInterface;
use App\controllers\ControllerException;

/**
 * La class Router implémente un routeur simple basé sur le paramètre GET nommé "route"
 */
class Router
{
    /**
     * Stocke le mapping entre nom de routes et contrôlleurs
     * @var array
     */
    private static array $routes = [];

    /**
     * Enregistre une route dans le système
     * @param string $route Nom de la route utilisé en paramètre GET dans l'URL
     * @param \App\controller\ControllerInterface $controller Instance du contrôlleur en charge de cette route
     * @return void
     */
    public static function addRoute(string $route, ControllerInterface $controller): void {
        self::$routes[$route] = $controller;
    }

    /**
     * Redirige l'application vers une route avec la méthode spécifiée
     * @param string $method Méthode HTTP
     * @param string $route
     * @throws \App\controller\ControllerException
     * @return void
     */
    public static function redirect(string $method, string $route){
        if (array_key_exists($route, self::$routes)) {
            $controller = self::$routes[$route];
            if ($method == "POST"){
                $controller->doPOST();
            } else {
                $controller->doGET();
            }
        } else {
            throw new ControllerException("La route demandée n'existe pas");
        }
    }

    /**
     * Délegue le traitement de la requête au contrôlleur et à sa méthode appropriée
     * @throws ControllerException Si la route demandée n'existe pas
     * @return void
     */
    public static function delegate() {
        $method = $_SERVER["REQUEST_METHOD"];
        $route  = isset($_GET["route"]) ? $_GET["route"] : "home";
        self::redirect($method, $route);
    }

    /**
    * Gère le routage basé sur l'URI et la méthode HTTP
     * @return void
     */
    public static function route() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($uri) {
            case '/register':
                $controller = new \App\controller\RegisterController();
                break;
            case '/login':
                $controller = new \App\controller\LoginController();
                break;
            case '/logout':
                $controller = new \App\controller\LogoutController();
                break;
            default:
                // Gérer d'autres routes ou afficher une page 404
                throw new ControllerException("La route demandée n'existe pas");
        }

        if ($method == 'POST') {
            $controller->doPOST();
        } else {
            $controller->doGET();
        }
    }
}
