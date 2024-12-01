<?php

namespace src\Entity\Produit;

use src\Entity\Produit\ProduitPhysique;
use DateTime, Exception;

class ProduitPerissable extends ProduitPhysique {
    /**
     * Date de peremption du produit
     * @var DateTime
     */
    protected DateTime $dateExpiration;

    /**
     * Température optimale de stockage du produit
     * @var float
     */
    protected float $temperatureStockage;

    public function __construct($nom, $description, $prix, $stock, $dateExpiration, $temperatureStockage, $poids, $longueur, $largeur, $hauteur) {
        parent::__construct($nom, $description, $prix, $stock, $poids, $longueur, $largeur, $hauteur);
        $this->dateExpiration = new DateTime($dateExpiration);
        $this->temperatureStockage = $temperatureStockage;
    }

    public function afficherDetails(): string {
        return "Details of ProduitPerissable";
    }

    public function calculerFraisLivraison(): float {
        switch (true) {
            case $this-> poids = null:
                throw new Exception("Le poids ne peut pas être vide");

            case $this->poids <= 0:
                throw new Exception("Le poids ne peut pas être négatif");

            case $this->poids <= 5:
                return 5;
        
            case $this->poids <= 10:
                return 7.5;
        
            case $this->poids <= 25:
                return 9.99;
            
            case $this->poids >25:
                return 13.99;
        
            default:
                throw new Exception("Erreur lors du calcul des frais de livraison");
        }
    }

    /**
     * Renvoie True si le produit est périmé, False sinon
     * @return bool
     */
    public function estPerime(): bool {
        $currentDate = new DateTime();
        return $this->dateExpiration < $currentDate;
    }
}
?>