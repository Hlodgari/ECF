<?php

namespace App\models\Pizzas;

use JsonSerializable;

class Image extends \App\models\AbstractEntity implements JsonSerializable
{
    private int $id;
    private string $chemin;
    private string $descr;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getChemin(): string
    {
        return $this->chemin;
    }

    public function setChemin(string $chemin): void
    {
        $this->chemin = $chemin;
    }

    public function getDescr(): string
    {
        return $this->descr;
    }

    public function setDescr(string $descr): void
    {
        $this->descr = $descr;
    }

    public function jsonSerialize(): array
    {
        return [
            'chemin' => $this->chemin,
            'descr' => $this->descr,
        ];
    }
}
