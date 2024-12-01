<?php

namespace src\Entity\Utilisateur;

use DateTime, Exception;

/**
 * Classe abstraite Utilisateur permettant de gérer les utilisateurs
 */
abstract class Utilisateur {
    /**
     * Identifiant de l'utilisateur
     * @var int
     */
    protected int $id;
    /**
     * Nom de l'utilisateur
     * @var string
     */
    protected string $nom;
    /**
     * Adresse mail de l'utilisateur
     * @var string
     */
    protected string $email;
    /**
     * Mot de passe de l'utilisateur
     * @var string
     */
    protected string $motDePasse;
    /**
     * Date d'inscription de l'utilisateur
     * @var DateTime
     */
    protected DateTime $dateInscription;

    /**
     * Role de l'utilisateur
     * @var array
     */
    protected array $roles;

    abstract public function afficherRoles();

    public function __construct(string $nom, string $email, string $motDePasse, DateTime $dateInscription, string $roles) {
        $this->nom = $nom;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
        $this->dateInscription = $dateInscription;
        $this->roles = $roles;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void{
        $this->id = $id;
    }

    public function getNom(): string {    
        return $this->nom;
    }

    public function setNom(string $nom): void {
        if(!is_null($nom)) {
            $this->nom = $nom;
        } else {
            throw new Exception("Le nom ne peut pas être vide");
        }
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->email = $email;
        } else {
            throw new Exception("L'adresse email n'est pas valide");
        }
    }

    public function getMotDePasse(): string {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): void {
        $this->motDePasse = $motDePasse;
    }
    
    public function getDateInscription(): DateTime {
        return $this->dateInscription;
    }

    public function setDateInscription(DateTime $dateInscription): void {
        $this->dateInscription = $dateInscription;
    }

    public function verifierMotDePasse(string $motDePasse) : bool {
        return password_verify($motDePasse, $this->motDePasse);
    }

    public function  mettreAJourProfil(string $nom, string $email, string $motDePasse) : void {
        $this->nom = $nom;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
    }
}
?>