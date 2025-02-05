<?php

namespace App\models\Client;

use App\Database;
use App\models\ModelException;
use App\models\DAOInterface;
use PDOException;

/**
 * Cette classe est en charge de opérations CRUD pour un utilisateur de l'application
 */
class ClientDAO implements DAOInterface {

    /**
     * Ajoute un utilisateur en BDD
     * @param Client $entity Instance contenant les informations de l'utilisateur
     * @return Client
     * @throws ModelException Dans le cas où l'enregistrement a rencontré une erreur
     */
    public function create(AbstractEntity &$entity): AbstractEntity
        /** @var Client $client */
        $client = $entity;
        
        try {
            $db = Database::getInstance();
            $req = $db->prepare("INSERT INTO `client` (`nom_client`, `prenom_client`, `adresse_client`, `telephone_client`, `email_client`, `mot_de_passe_client`) VALUES (:nom, :email, :addresse, :telephone, :email, :mot_de_passe)");
            $done = $req->execute([
                'nom' => $client->getNom(),
                'prenom' => $client->getPrenom(),
                'addresse' => $client->getAddresse(),
                'telephone' => $client->getTelephone(),
                'email' => $client->getEmail(),
                'mot_de_passe' => password_hash($client->getMot_de_passe(), PASSWORD_BCRYPT)
            ]);
            if ($done == false){
                throw new ModelException("Erreur à l'inscription de l'utilisateur");
            }
            $client->setId($db->lastInsertId());
            return $client;
        } catch (PDOException $exc) {
            throw new ModelException("Erreur à l'inscription: ".$exc->getMessage());
        }
    }
    
    /**
     * Lis les informations d'un utilisateur en BDD
     * @param int $id Identifiant de l'utilisateur
     * @throws ModelException
     * @return Client
     */
    public function readOne(int $id): Client {
        try {
            $db = Database::getInstance();
            $req = $db->prepare("SELECT * FROM `client` WHERE id = :id");
            $req->execute(['id' => $id]);
            $req->setFetchMode(\PDO::FETCH_CLASS, Client::class);
            $client = $req->fetch();
            if (!$client) {
                throw new ModelException("Utilisateur non trouvé");
            }
            return $client;
        } catch (PDOException $exc) {
            throw new ModelException("Erreur de lecture de l'utilisateur: " . $exc->getMessage());
        }
    }
    
    /**
     * Lis les informations de tous les utilisateurs en BDD
     * @throws ModelException
     * @return array
     */
    public function readAll(): array {
        try {
            $db = Database::getInstance();
            $sql = "SELECT * FROM `client`";
            $req = $db->query($sql);
            $req->setFetchMode(\PDO::FETCH_CLASS, Client::class);
            return $req->fetchAll();
        } catch (PDOException $exc) {
            throw new ModelException("Erreur de lecture de la liste des utilisateurs: " . $exc->getMessage());
        }
    }
    
    /**
     * Met à jour les informations d'un utilisateur en BDD
     * @param Client $entity Instance contenant les informations de l'utilisateur
     * @return bool
     * @throws ModelException
     */
    public function update(Client $entity): bool {
        /** @var Client $client */
        $client = $entity;
        try {
            $db = Database::getInstance();
            $req = $db->prepare("INSERT INTO `client` (`nom_client`, `prenom_client`, `adresse_client`, `telephone_client`, `email_client`, `mot_de_passe_client`) VALUES (:nom, :email, :addresse, :telephone, :email, :mot_de_passe)");
            $done = $req->execute([
                'nom' => $client->getNom(),
                'prenom' => $client->getPrenom(),
                'addresse' => $client->getAddresse(),
                'telephone' => $client->getTelephone(),
                'email' => $client->getEmail(),
                'mot_de_passe' => password_hash($client->getMot_de_passe(), PASSWORD_BCRYPT)
            ]);
            if ($done == false){
                throw new ModelException("Erreur à la mise à jour de l'utilisateur");
            }
            return true;
        } catch (PDOException $exc) {
            throw new ModelException("Erreur à la mise à jour: " . $exc->getMessage());
        }
    }

    /**
     * Supprime un utilisateur en BDD
     * @param Client $entity Instance contenant les informations de l'utilisateur
     * @return bool
     * @throws ModelException
     */
    public function delete(Client $entity): bool {
        /** @var Client $client */
        $client = $entity;
        try {
            $db = Database::getInstance();
            $req = $db->prepare("DELETE FROM `client` WHERE `id` = :id");
            $done = $req->execute(['id' => $client->getId()]);
            if ($done == false){
                throw new ModelException("Erreur à la suppression de l'utilisateur");
            }
            return true;
        } catch (PDOException $exc) {
            throw new ModelException("Erreur à la suppression: " . $exc->getMessage());
        }
    }

    /**
     * Vérifie les identifiants de connexion d'un utilisateur
     * @param string $email
     * @param string $password
     * @throws ModelException
     * @return Client
     */
    public function login(string $email, string $password): Client {
        try {
            $db = Database::getInstance();
            $req = $db->prepare("SELECT * FROM `client` WHERE email = :email");
            $req->execute(['email' => $email]);
            $req->setFetchMode(\PDO::FETCH_CLASS, Client::class);
            $client = $req->fetch();
            if (!$client || !password_verify($password, $client->getMot_de_passe())) {
                throw new ModelException("Un utilisateur avec ces identifiants n'existe pas dans le système");
            }
            return $client;
        } catch (PDOException $exc) {
            throw new ModelException("Erreur durant la requête à la BDD: " . $exc->getMessage());
        }
    }
}