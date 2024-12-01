<?php

namespace src\Repository;

use src\Database\DatabaseConnection;
use src\Entity\Produit\Produit;
use Categorie;
use src\Entity\Produit\ProduitNumerique;
use src\Entity\Produit\ProduitPhysique;
use src\Entity\Produit\ProduitPerissable;
use PDO;

class CategorieRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    /**
     * Crée une nouvelle catégorie dans la base de données.
     */
    public function create(Categorie $categorie): int
    {
        $query = "INSERT INTO Categorie (nom, description) VALUES (:nom, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'nom' => $categorie->getNom(),
            'description' => $categorie->getDescription(),
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Lit une catégorie par son ID.
     */
    public function read(int $id): ?Categorie
    {
        $query = "SELECT * FROM Categorie WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return $this->mapCategorie($result);
    }

    /**
     * Met à jour une catégorie existante.
     */
    public function update(Categorie $categorie): void
    {
        $query = "UPDATE Categorie SET nom = :nom, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'nom' => $categorie->getNom(),
            'description' => $categorie->getDescription(),
            'id' => $categorie->getId(),
        ]);
    }

    /**
     * Supprime une catégorie par son ID.
     */
    public function delete(int $id): void
    {
        $query = "DELETE FROM Categorie WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
    }

    /**
     * Récupère toutes les catégories.
     */
    public function findAll(): array
    {
        $query = "SELECT * FROM Categorie";
        $stmt = $this->db->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categories = [];
        foreach ($result as $row) {
            $categories[] = $this->mapCategorie($row);
        }

        return $categories;
    }

    /**
     * Récupère des catégories selon des critères spécifiques.
     */
    public function findBy(array $criteria): array
    {
        $conditions = [];
        $parameters = [];

        foreach ($criteria as $field => $value) {
            $conditions[] = "$field = :$field";
            $parameters[$field] = $value;
        }

        $query = "SELECT * FROM Categorie";
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($parameters);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categories = [];
        foreach ($result as $row) {
            $categories[] = $this->mapCategorie($row);
        }

        return $categories;
    }

    /**
     * Mappe un tableau SQL vers une instance de Categorie.
     */
    private function mapCategorie(array $row): Categorie
    {
        $categorie = new Categorie(
            $row['id'],
            $row['nom'],
            $row['description']
        );

        // Charger les produits associés si nécessaire
        $produits = $this->findProduitsByCategorieId($row['id']);
        $categorie->setProduits($produits);

        return $categorie;
    }

    /**
     * Récupère les produits associés à une catégorie donnée.
     */
    private function findProduitsByCategorieId(int $categorieId): array
    {
        $query = "SELECT * FROM Produit WHERE categorie_id = :categorie_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['categorie_id' => $categorieId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $produits = [];
        foreach ($result as $row) {
            // Mapper le produit selon sa structure (Physique, Numérique, etc.)
            $produits[] = $this->mapProduit($row);
        }

        return $produits;
    }

    /**
     * Mappe un tableau SQL vers une instance de Produit.
     */
    private function mapProduit(array $row): Produit
    {
        switch ($row['type']) {
            case 'physique':
                return new ProduitPhysique(
                    $row['id'],
                    $row['nom'],
                    $row['description'],
                    $row['prix'],
                    $row['stock'],
                    $row['poids'],
                    $row['longueur'],
                    $row['largeur'],
                    $row['hauteur']
                );
            case 'numerique':
                return new ProduitNumerique(
                    $row['id'],
                    $row['nom'],
                    $row['description'],
                    $row['prix'],
                    $row['stock'],
                    $row['lienTelechargement'],
                    $row['tailleFichier'],
                    $row['formatFichier']
                );
            case 'perissable':
                return new ProduitPerissable(
                    $row['id'],
                    $row['nom'],
                    $row['description'],
                    $row['prix'],
                    $row['stock'],
                    $row['poids'],
                    $row['longueur'],
                    $row['largeur'],
                    $row['hauteur'],
                    $row['dateExpiration'],
                    $row['temperatureStockage']
                );
            default:
                throw new \Exception("Type de produit inconnu : " . $row['type']);
        }
    }

}
