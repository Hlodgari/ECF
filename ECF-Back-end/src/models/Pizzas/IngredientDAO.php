<?php

namespace App\models\Pizzas;

use App\config\Database;
use App\models\ModelException;

class IngredientDAO {

    public function findByPizzaId(int $pizzaId): array {
        try {
            $db = Database::getInstance();
            $sql = "SELECT
                    i.id_ingredient as id,
                    i.nom_ingredient as nom
                    FROM ingredient i
                    JOIN compose c ON i.id_ingredient = c.id_ingredient
                    WHERE c.id_pizza = :pizzaId";
            $req = $db->prepare($sql);
            $req->bindValue("pizzaId", $pizzaId);
            $req->execute();

            return $req->fetchAll(\PDO::FETCH_CLASS, \App\models\Pizzas\Ingredient::class);

        } catch (\PDOException $exc) {
            throw new ModelException("Erreur de lecture de la liste des ingredients");
        }
    }
}