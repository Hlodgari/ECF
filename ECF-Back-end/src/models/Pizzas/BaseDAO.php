<?php

namespace App\models\Pizzas;

use App\config\Database;
use App\models\ModelException;

class BaseDAO {

    public function findByPizzaId(int $pizzaId): Base {
        try {
            $db = Database::getInstance();
            $sql = "SELECT
                    b.id_base as id,
                    b.nom_base as nom
                    FROM base b
                    JOIN pizza p ON b.id_base = p.id_base
                    WHERE p.id_pizza = :pizzaId";
            $req = $db->prepare($sql);
            $req->bindValue("pizzaId", $pizzaId);
            $req->execute();

            return $req->fetchObject(\App\models\Pizzas\Base::class);

        } catch (\PDOException $exc) {
            throw new ModelException("Erreur de lecture de la liste des ingredients");
        }
    }
}