<?php

use src\Entity\Produit\Produit;

class Categorie {
    /**
     * Identifiant de la catégorie
     * @var int
     */
    private int $id;

    /**
     * Nom de la catégorie
     * @var string
     */
    private string $nom;

    /**
     * Description de la catégorie
     * @var string
     */
    private string $description;

    /**
     * Liste des produits de la catégorie
     * @var Produit[]
     */
    private array $produits = [];

    public function __construct(int $id, string $nom, string $description) {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->produits = [];
    }

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
        $this->nom = $nom;
    }
    public function getDescription(): string {
        return $this->description;
    }
    public function setDescription(string $description): void {
        $this->description = $description;
    }
    public function getProduits(): array { 
        return $this->produits;
    }
    public function setProduits(array $produits): void {
        $this->produits = $produits;
    }


    public function ajouterProduit(Produit $produit): void {
        $this->produits[] = $produit;
    }

    public function retirerProduit(Produit $produit): void {
        $this->produits = array_filter($this->produits, function($p) use ($produit) {
            return $p !== $produit;
        });
    }

    public function listerProduits(): array {
        return $this->produits;
    }
}
?>