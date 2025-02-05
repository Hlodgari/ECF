<?php

namespace App\models\Pizzas;

use App\config\Database;
use App\models\AbstractEntity;
use App\models\ModelException;

class PizzaDAO implements \App\models\DAOInterface
{

    public function create(AbstractEntity &$entity): AbstractEntity
    {
        throw new ModelException("Cette action n'est pas supportée");
    }

    public function readOne(int $id): AbstractEntity
    {
        throw new ModelException("Cette action n'est pas supportée");
    }

    public function readAll(): array
    {
        try {
            $db = Database::getInstance();
            $sql = "SELECT
                    id_pizza as id,
                    nom_pizza as nom,
                    prix_pizza as prix
                    FROM `pizza`";
            $req = $db->query($sql);
            $req->setFetchMode(\PDO::FETCH_CLASS, \App\models\Pizzas\Pizza::class);
            $pizzas =  $req->fetchAll();

            foreach ($pizzas as $pizza) {
                $ingredients = (new IngredientDAO())->findByPizzaId($pizza->getId());
                $pizza->setIngredients($ingredients);
                $base = (new BaseDAO())->findByPizzaId($pizza->getId());
                $pizza->setBase($base);
                $image = (new ImageDAO())->findByPizzaId($pizza->getId());
                $pizza->setImage($image);
            }

            return $pizzas;
        } catch (\PDOException $exc) {
            throw new ModelException("Erreur de lecture de la liste des pizzas");
        }
    }

    public function update(AbstractEntity $entity): bool
    {
        throw new ModelException("Cette action n'est pas supportée");
    }

    public function delete(AbstractEntity $entity): bool
    {
        throw new ModelException("Cette action n'est pas supportée");
    }
}
