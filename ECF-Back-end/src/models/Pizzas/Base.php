<?php

namespace App\models\Pizzas;

use JsonSerializable;

class Base extends \App\models\AbstractEntity implements JsonSerializable
{
    private int $id;
    private string $nom;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }


    public function jsonSerialize(): string
    {
        return  $this->nom;
    }
}
