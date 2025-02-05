<?php

namespace App\models\Pizzas;

use App\config\Database;
use App\models\ModelException;

class ImageDAO {

    public function findByPizzaId(int $pizzaId): Image {
        try {
            $db = Database::getInstance();
            $sql = "SELECT
                    i.id_image as id,
                    i.chemin_image as chemin,
                    i.description_image as descr
                    FROM images i
                    JOIN pizza p ON i.id_pizza = p.id_pizza
                    WHERE p.id_pizza = :pizzaId";
            $req = $db->prepare($sql);
            $req->bindValue("pizzaId", $pizzaId);
            $req->execute();

            return $req->fetchObject(\App\models\Pizzas\Image::class);

        } catch (\PDOException $exc) {
            throw new ModelException("Erreur de lecture des images de la pizza");
        }
    }
}