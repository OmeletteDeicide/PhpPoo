<?php

namespace src\Entity\Utilisateur;
use src\Entity\Produit\Produit;
use DateTime;


class Vendeur extends Utilisateur
{
    private string $boutique;
    private float $commission;

    public function __construct(string $boutique, float $commission, string $nom, string $email, string $motDePasse, DateTime $dateInscription, string $roles)
    {
        parent::__construct($nom, $email, $motDePasse, $dateInscription, $roles);
        $this->boutique = $boutique;
        $this->commission = $commission;
    }

    public function ajouterProduit(Produit $produit): void
    {
    }

    public function gererStock(Produit $produit, int $quantite): void
    {
    }

    // Getters and setters for boutique and commission
    public function getBoutique(): string
    {
        return $this->boutique;
    }

    public function setBoutique(string $boutique): void
    {
        $this->boutique = $boutique;
    }

    public function getCommission(): float
    {
        return $this->commission;
    }

    public function setCommission(float $commission): void
    {
        $this->commission = $commission;
    }

    public function afficherRoles(): void
    {
        echo $this->roles;
    }
}