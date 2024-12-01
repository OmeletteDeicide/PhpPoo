<?php

require __DIR__ . '/../vendor/autoload.php';

use src\Factory\ProduitFactory;
use src\Config\ConfigurationManager;
use src\Database\DatabaseConnection;
use src\Repository\ProduitRepository;
use src\Entity\Produit\ProduitPhysique;

try {
    // _________________________________________________________________
    // Création d'un produit via la Factory
    $produitPhysique = ProduitFactory::creerProduit('physique', [
        'nom' => 'Table en bois',
        'description' => 'Table robuste',
        'prix' => 100.0,
        'stock' => 10,
        'poids' => 15.0,
        'longueur' => 120.0,
        'largeur' => 80.0,
        'hauteur' => 75.0
    ]);

    echo "Produit physique créé : " . $produitPhysique->getNom() . "\n";

    // _________________________________________________________________
    // Gestion de la configuration globale
    $config = ConfigurationManager::getInstance();
    $config->load([
        'TVA' => 20,
        'devise' => 'EUR',
        'fraisLivraison' => 5.99,
    ]);

    echo "TVA : " . $config->get('TVA') . "%\n";
    echo "Devise : " . $config->get('devise') . "\n";

    // _________________________________________________________________
    // Connexion à la base de données
    $db = DatabaseConnection::getInstance()->getConnection();
    echo "Connexion à la base de données réussie !\n";

    // _________________________________________________________________
    // Utilisation du Repository pour la persistance des produits
    $repo = new ProduitRepository();

    // Création d'un produit via le Repository
    $produit = new ProduitPhysique(
        "Chaise en métal",
        "Chaise solide et durable",
        50.0,
        20,
        5.0, 
        50.0,
        45.0,
        90.0 
    );
    $id = $repo->create($produit);
    echo "Produit créé avec l'ID : $id\n";

    // Lecture du produit
    $produitLu = $repo->read($id);
    if ($produitLu) {
        echo "Produit lu : " . $produitLu->getNom() . "\n";
    }

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
