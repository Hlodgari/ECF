<?php

namespace App\models\Pizzas;

use JsonSerializable;

class Pizza extends \App\models\AbstractEntity implements JsonSerializable
{
    private int $id;
    private string $nom;
    private float $prix;
    private string $devise = "€";
    private array $ingredients = [];
    private Base $base;
    private Image $image;

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

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }
    public function getDevise(): string
    {
        return $this->devise;
    }

    public function addIngredient(array $ingredient): void
    {
        $this->ingredients[] = $ingredient;
    }

    public function setIngredients(array $ingredients): void
    {
        $this->ingredients = $ingredients;
    }
    public function getBase(): Base
    {
        return $this->base;
    }
    public function setBase(Base $base): void
    {
        $this->base = $base;
    }

    public function getImage(): Image
    {
        return $this->image;
    }
    public function setImage(Image $image): void
    {
        $this->image = $image;
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prix' => $this->prix,
            'devise' => $this->devise,
            'ingredients' => $this->ingredients,
            'base' => $this->base,
            'image'=> $this->image,
        ];
    }
}
