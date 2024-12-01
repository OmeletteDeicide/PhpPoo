<?php 

namespace src\Entity\Produit;

use src\Entity\Produit\Produit;
use Exception;

class ProduitPhysique extends Produit {

    /**
     * Poids du produit en kg
     * @var float
     */
    protected float $poids;

    /**
     * Longeueur du produit en cm
     * @var float
     */
    protected float $longueur;

    /**
     * Largeur du produit en cm
     * @var float
     */
    protected float $largeur;

    /**
     * Hauteur du produit en cm
     * @var float
     */
    protected float $hauteur;

    public function __construct($nom, $description, $prix, $stock, $poids, $longueur, $largeur, $hauteur) {
        parent::__construct($nom, $description, $prix, $stock);
        $this->poids = $poids;
        $this->longueur = $longueur;
        $this->largeur = $largeur;
        $this->hauteur = $hauteur;
    }

    public function getPoids(): float {
        return $this->poids;
    }

    public function setPoids($poids): void {
        $this->poids = $poids;
    }

    public function getLongueur(): float { 
        return $this->longueur;
    }

    public function setLongueur($longueur): void {
        $this->longueur = $longueur;
    }

    public function getlargeur(): float {
        return $this->largeur;
    }

    public function setlargeur($largeur): void {
        $this->largeur = $largeur;
    }

    public function gethauteur(): float {
        return $this->hauteur;
    }

    public function sethauteur($hauteur): void {
        $this->hauteur = $hauteur;
    }

    
    

    public function afficherDetails(): string {
        return "Details of ProduitPhysique";
    }

    public function calculerFraisLivraison(): float {
        switch (true) {
            case $this-> poids = null:
                throw new Exception("Le poids ne peut pas être vide");

            case $this->poids <= 0:
                throw new Exception("Le poids ne peut pas être négatif");

            case $this->poids <= 5:
                return 0;
        
            case $this->poids <= 10:
                return 2.5;
        
            case $this->poids <= 25:
                return 4.99;
            
            case $this->poids >25:
                return 6.99;
        
            default:
                throw new Exception("Erreur lors du calcul des frais de livraison");
        }
    }
}
?>