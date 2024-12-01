<?php

namespace src\Entity\Produit;

use Exception;

/**
 * Classe Produit permettant de gérer les produits
 */
abstract class Produit {
    /**
     * Identifiant du produit
     * @var int
     */
    protected int $id;
    /**
     * Nom du produit
     * @var string
     */
    protected string $nom;
    /**
     * Description détaillée produit
     * @var string
     */
    protected string $description;
    /**
     * Prix du produit
     * @var float
     */
    protected float $prix;
    /**
     * Stock restant du produit
     * @var int
     */
    protected int $stock;

    public function __construct(string $nom, string $description, float $prix, int $stock) {
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
        $this->stock = $stock;
    }

    abstract public function calculerFraisLivraison() : float;

    abstract public function afficherDetails() : string;
    
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
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

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {      
        $this->description = $description;
    }

    public function getPrix(): float {
        return $this->prix;
    }

    public function setPrix(float $prix): void {   
        if ($prix > 0) {
            $this->prix = $prix;
        } else {
            throw new Exception("Le prix doit être supérieur à 0");
        }
    }

    public function getStock(): int {
        return $this->stock;
    }

    public function setStock(int $stock): void {
        if ($stock >= 0) {
            $this->stock = $stock;
        } else { 
            throw new Exception("Le stock doit être supérieur ou égal à 0");
        }
    }

    public function calculerPrixTTC() : float {
        return $this->prix * 1.2;
    }

    public function verifierStock(int $quantite) :bool {
        return $this->stock >= $quantite;
    }

}
?>