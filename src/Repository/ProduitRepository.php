<?php

namespace src\Repository;

use src\Database\DatabaseConnection;
use src\Entity\Produit\ProduitPhysique;
use src\Entity\Produit\ProduitNumerique;
use PDO;

class ProduitRepository
{
    private PDO $db;

    private function mapProduit(array $row)
    {
        switch ($row['type']) {
            case 'physique':
                return new ProduitPhysique(
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
                    $row['nom'],
                    $row['description'],
                    $row['prix'],
                    $row['stock'],
                    $row['lienTelechargement'],
                    $row['tailleFichier'],
                    $row['formatFichier']
                );
            default:
                throw new \Exception("Type de produit inconnu : " . $row['type']);
        }
    }


    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    public function create($produit): int
    {
        $query = "INSERT INTO Produit (nom, description, prix, stock, type, poids, longueur, largeur, hauteur) 
            VALUES (:nom, :description, :prix, :stock, :type, :poids, :longueur, :largeur, :hauteur)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'nom' => $produit->getNom(),
            'description' => $produit->getDescription(),
            'prix' => $produit->getPrix(),
            'stock' => $produit->getStock(),
            'type' => $produit instanceof ProduitPhysique ? 'physique' : 'numerique',
            'poids' => $produit instanceof ProduitPhysique ? $produit->getPoids() : null,
            'longueur' => $produit instanceof ProduitPhysique ? $produit->getLongueur() : null,
            'largeur' => $produit instanceof ProduitPhysique ? $produit->getLargeur() : null,
            'hauteur' => $produit instanceof ProduitPhysique ? $produit->getHauteur() : null
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update($produit): void
    {
        $query = "UPDATE Produit 
                SET nom = :nom, 
                    description = :description, 
                    prix = :prix, 
                    stock = :stock, 
                    poids = :poids, 
                    longueur = :longueur, 
                    largeur = :largeur, 
                    hauteur = :hauteur 
                WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'nom' => $produit->getNom(),
            'description' => $produit->getDescription(),
            'prix' => $produit->getPrix(),
            'stock' => $produit->getStock(),
            'poids' => $produit instanceof ProduitPhysique ? $produit->getPoids() : null,
            'longueur' => $produit instanceof ProduitPhysique ? $produit->getLongueur() : null,
            'largeur' => $produit instanceof ProduitPhysique ? $produit->getLargeur() : null,
            'hauteur' => $produit instanceof ProduitPhysique ? $produit->getHauteur() : null,
            'id' => $produit->getId()
        ]);
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM Produit WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
    }

    public function findAll(): array
    {
        $query = "SELECT * FROM Produit";
        $stmt = $this->db->query($query);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $produits = [];
        foreach ($result as $row) {
            $produits[] = $this->mapProduit($row);
        }

        return $produits;
    }

    public function findBy(array $criteria): array
    {
        $conditions = [];
        $parameters = [];

        foreach ($criteria as $field => $value) {
            $conditions[] = "$field = :$field";
            $parameters[$field] = $value;
        }

        $query = "SELECT * FROM Produit";
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($parameters);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $produits = [];
        foreach ($result as $row) {
            $produits[] = $this->mapProduit($row);
        }

        return $produits;
    }




    public function read(int $id)
    {
        $query = "SELECT * FROM Produit WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            switch ($result['type']) {
                case 'physique':
                    return new ProduitPhysique(
                        $result['nom'],
                        $result['description'],
                        $result['prix'],
                        $result['stock'],
                        $result['poids'],  
                        $result['longueur'],
                        $result['largeur'],
                        $result['hauteur']
                    );
                case 'numerique':
                    return new ProduitNumerique(
                        $result['nom'],
                        $result['description'],
                        $result['prix'],
                        $result['stock'],
                        $result['lienTelechargement'],
                        $result['tailleFichier'],
                        $result['formatFichier'] 
                    );
                default:
                    throw new \Exception("Type de produit inconnu : " . $result['type']);
            }
        }

        return null;
    }
}