<?php

namespace src\Entity\Utilisateur;
use src\Entity\Panier;
use DateTime;

class Client extends Utilisateur
{
    private string $adresseLivraison;
    private Panier $panier;

    public function __construct(string $adresseLivraison, Panier $panier, int $id, string $nom, string $motDePasse, DateTime $dateInscription, string $roles)
    {
        parent::__construct($id, $nom, $motDePasse, $dateInscription, $roles);
        $this->adresseLivraison = $adresseLivraison;
        $this->panier = $panier;
    }
    
    public function getAdresseLivraison(): string
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(string $adresseLivraison): void
    {
        $this->adresseLivraison = $adresseLivraison;
    }

    public function passerCommande(): void
    {
    }

    public function consulterHistorique(): array
    {
        return [];
    }

    public function afficherRoles(): void
    {
        echo $this->roles;
    }
}