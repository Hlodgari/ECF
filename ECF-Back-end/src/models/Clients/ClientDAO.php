<?php

namespace App\models\Clients;

use App\config\Database;
use App\models\AbstractEntity;
use App\models\ModelException;
use PDOException;

class ClientDAO {

    public function create(Client &$entity): AbstractEntity {
        $client = $entity;
        
        try {
            $db = Database::getInstance();
            $req = $db->prepare("INSERT INTO `client` (`nom_client`, `prenom_client`, `adresse_client`, `telephone_client`, `email_client`, `mot_de_passe_client`) VALUES (:nom, :prenom, :adresse, :telephone, :email, :mot_de_passe)");
            $done = $req->execute([
                'nom' => $client->getNom(),
                'prenom' => $client->getPrenom(),
                'adresse' => $client->getAdresse(),
                'telephone' => $client->getTelephone(),
                'email' => $client->getEmail(),
                'mot_de_passe' => password_hash($client->getMot_de_passe(), PASSWORD_BCRYPT)
            ]);
            if (!$done) {
                throw new ModelException("Erreur à l'inscription de l'utilisateur");
            }
            $client->setId($db->lastInsertId());
            return $client;
        } catch (PDOException $exc) {
            throw new ModelException("Erreur à l'inscription: " . $exc->getMessage());
        }
    }
    
    public function readOne(int $id): ?Client {
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
    
    public function update(AbstractEntity $entity): bool {
        /** @var Client $client */
        $client = $entity;
        try {
            $db = Database::getInstance();
            $req = $db->prepare("UPDATE `client` SET `nom_client` = :nom, `prenom_client` = :prenom, `adresse_client` = :adresse, `telephone_client` = :telephone, `email_client` = :email, `mot_de_passe_client` = :mot_de_passe WHERE `id` = :id");
            $done = $req->execute([
                'nom' => $client->getNom(),
                'prenom' => $client->getPrenom(),
                'adresse' => $client->getAdresse(),
                'telephone' => $client->getTelephone(),
                'email' => $client->getEmail(),
                'mot_de_passe' => password_hash($client->getMot_de_passe(), PASSWORD_BCRYPT),
                'id' => $client->getId()
            ]);
            if (!$done) {
                throw new ModelException("Erreur à la mise à jour de l'utilisateur");
            }
            return true;
        } catch (PDOException $exc) {
            throw new ModelException("Erreur à la mise à jour: " . $exc->getMessage());
        }
    }

    public function delete(Client $entity): bool {
        $client = $entity;
        try {
            $db = Database::getInstance();
            $req = $db->prepare("DELETE FROM `client` WHERE `id` = :id");
            $done = $req->execute(['id' => $client->getId()]);
            if (!$done) {
                throw new ModelException("Erreur à la suppression de l'utilisateur");
            }
            return true;
        } catch (PDOException $exc) {
            throw new ModelException("Erreur à la suppression: " . $exc->getMessage());
        }
    }

    public function login(string $email, string $password): ?Client {
        try {
            $db = Database::getInstance();
            $req = $db->prepare("SELECT * FROM `client` WHERE email_client = :email");
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
    
    public function findByEmail(string $email): ?Client {
        try {
            $db = Database::getInstance();
            $req = $db->prepare("SELECT * FROM `client` WHERE email_client = :email");
            $req->execute(['email' => $email]);
            $req->setFetchMode(\PDO::FETCH_CLASS, Client::class);
            return $req->fetch();
        } catch (PDOException $exc) {
            throw new ModelException("Erreur durant la requête à la BDD: " . $exc->getMessage());
        }
    }
}
