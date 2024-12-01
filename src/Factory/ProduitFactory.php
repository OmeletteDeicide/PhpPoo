<?php

namespace src\Factory;

use src\Entity\Produit\Produit;
use src\Entity\Produit\ProduitNumerique;
use src\Entity\Produit\ProduitPhysique;
use src\Entity\Produit\ProduitPerissable;
use Exception;

class ProduitFactory
{
    public static function creerProduit(string $type, array $data): Produit
    {
        switch ($type) {
            case 'numerique':
                return new ProduitNumerique(
                    $data['nom'],
                    $data['description'],
                    $data['prix'],
                    $data['stock'],
                    $data['lienTelechargement'],
                    $data['tailleFichier'],
                    $data['formatFichier']
                );

            case 'physique':
                return new ProduitPhysique(
                    $data['nom'],
                    $data['description'],
                    $data['prix'],
                    $data['stock'],
                    $data['poids'],
                    $data['longueur'],
                    $data['largeur'],
                    $data['hauteur']
                );

            case 'perissable':
                return new ProduitPerissable(
                    $data['nom'],
                    $data['description'],
                    $data['prix'],
                    $data['stock'],
                    $data['dateExpiration'],
                    $data['temperatureStockage'],
                    $data['poids'],
                    $data['longueur'],
                    $data['largeur'],
                    $data['hauteur']
                );

            default:
                throw new Exception("Type de produit invalide : $type");
        }
    }
}
