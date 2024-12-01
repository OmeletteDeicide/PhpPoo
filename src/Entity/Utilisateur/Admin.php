<?php

namespace src\Entity\Utilisateur;

use DateTime;

class Admin extends Utilisateur
{
    private int $niveauAcces;
    private DateTime $derniereConnexion;

    public function __construct(int $niveauAcces, DateTime $derniereConnexion, string $nom, string $email, string $motDePasse, DateTime $dateInscription, string $roles)
    {
        parent::__construct($nom, $email, $motDePasse, $dateInscription, $roles);
        $this->niveauAcces = $niveauAcces;
        $this->derniereConnexion = $derniereConnexion;
    }

    public function gererUtilisateurs(): void
    {
    }

    public function accederJournalSysteme(): array
    {
        return [];
    }

    // Getters and setters for niveauAcces and derniereConnexion
    public function getNiveauAcces(): int
    {
        return $this->niveauAcces;
    }

    public function setNiveauAcces(int $niveauAcces): void
    {
        $this->niveauAcces = $niveauAcces;
    }

    public function getDerniereConnexion(): DateTime
    {
        return $this->derniereConnexion;
    }

    public function setDerniereConnexion(DateTime $derniereConnexion): void
    {
        $this->derniereConnexion = $derniereConnexion;
    }

    public function afficherRoles(): void
    {
        echo $this->roles;
    }
}