<?php

namespace App\Entity;

use App\Repository\LacarteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LacarteRepository::class)]
class Lacarte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomDuPlat = null;

    #[ORM\Column(length: 255)]
    private ?string $ingredient = null;

    #[ORM\Column(length: 255)]
    private ?string $prix = null;

    #[ORM\Column]
    private ?int $poids = null;

    #[ORM\Column(length: 255)]
    private ?string $unite = null;


    #[ORM\ManyToOne(inversedBy: 'categorie')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDuPlat(): ?string
    {
        return $this->NomDuPlat;
    }

    public function setNomDuPlat(string $NomDuPlat): self
    {
        $this->NomDuPlat = $NomDuPlat;

        return $this;
    }


    public function getIngredient(): ?string
    {
        return $this->ingredient;
    }

    public function setIngredient(string $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

 

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
