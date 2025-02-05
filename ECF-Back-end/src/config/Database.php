<?php

namespace App\config;

/**
 * La classe Database implémente le pattern singleton
 * pour s'assurer qu'il n'y ai qu'une seule connection à la BDD
 */
class Database extends \PDO {
    /**
     * La propriété instance stocke l'unique connexion à la BDD
     * @var $instance
     */
    private static $instance = null;

    /**
     * Le constructeur est privé pour forcer l'utilisation de la méthode statique getInstance
     */
    private final function __construct() {
        try {
            $dsn = "mysql:dbname=" . $_ENV["DBNAME"] . ";host=" . $_ENV["DBHOST"];
            $options = [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ];
            parent::__construct($dsn, $_ENV["DBUSER"], $_ENV["DBPASS"], $options);
        } catch (\PDOException $exc) {
            exit($exc->getMessage());
        }
    }

    /**
     * Méthode pour obtenir l'instance qui représente la connexion à la BDD
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

}