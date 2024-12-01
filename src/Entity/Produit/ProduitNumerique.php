<?php

namespace src\Entity\Produit;

use src\Entity\Produit\Produit;

class ProduitNumerique extends Produit {

    /**
     * Lient pour telecharger le prduit numerique
     * @var string
     */
    protected string $lienTelechargement;

    /**
     * Taille du fichier en Mb
     * @var float
     */
    protected float $tailleFichier;

    /**
     * Format du produit numerique
     * @var string
     */
    protected string $formatFichier;

    public function __construct($nom, $description, $prix, $stock, $lienTelechargement, $tailleFichier, $formatFichier) {
        parent::__construct($nom, $description, $prix, $stock);
        $this->lienTelechargement = $lienTelechargement;
        $this->tailleFichier = $tailleFichier;
        $this->formatFichier = $formatFichier;
    }

    public function afficherDetails(): string {
        return "Details of ProduitNumerique";
    }

    public function calculerFraisLivraison(): float {
        return 0;
    }

    public function genererLienTelechargement(): string {
        return "Lien de telechargement";
    }
}
?>