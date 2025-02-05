<?php

namespace App\models;


//use App\model\AbstractEntity;

interface DAOInterface {

    /**
     * Enregistre une entité en BDD
     * @param AbstractEntity $entity Instande de l'entité à enregistrer
     * @return AbstractEntity
     * @throws ModelException
     */
    public function create(AbstractEntity &$entity): AbstractEntity;
    
    /**
     * Lis une entité en BDD
     * @param int $id Identifiant de l'entité
     * @return void
     */

    public function readOne(int $id): AbstractEntity;
    
    /**
     * Lis la liste des entités en BDD
     * @return array
     */
    public function readAll(): array;
    
    /**
     * Mets à jour une entité en BDD
     * @param AbstractEntity $entity Instance de l'entité à mettre à jour
     * @return bool
     */
    public function update(AbstractEntity $entity): bool;

    /**
     * Supprime une entité de la BDD
     * @param AbstractEntity $entity Instance de l'entité à supprimer
     * @return bool
     */
    public function delete(AbstractEntity $entity): bool;

}