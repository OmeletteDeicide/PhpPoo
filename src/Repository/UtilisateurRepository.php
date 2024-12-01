<?php

namespace src\Repository;

use src\Database\DatabaseConnection;
use src\Entity\Utilisateur\Admin;
use src\Entity\Utilisateur\Client;
use src\Entity\Utilisateur\Vendeur;
use src\Entity\Utilisateur\Utilisateur;
use PDO;

class UtilisateurRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    /**
     * Crée un nouvel utilisateur dans la base de données.
     */
    public function create($utilisateur): int
    {
        $query = "INSERT INTO Utilisateur 
                  (nom, email, motDePasse, type, adresseLivraison, boutique, commission, niveauAcces, derniereConnexion, role) 
                  VALUES 
                  (:nom, :email, :motDePasse, :type, :adresseLivraison, :boutique, :commission, :niveauAcces, :derniereConnexion, :role)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'nom' => $utilisateur->getNom(),
            'email' => $utilisateur->getEmail(),
            'motDePasse' => $utilisateur->getMotDePasse(),
            'type' => $utilisateur->getType(),
            'adresseLivraison' => $utilisateur instanceof Client ? $utilisateur->getAdresseLivraison() : null,
            'boutique' => $utilisateur instanceof Vendeur ? $utilisateur->getBoutique() : null,
            'commission' => $utilisateur instanceof Vendeur ? $utilisateur->getCommission() : null,
            'niveauAcces' => $utilisateur instanceof Admin ? $utilisateur->getNiveauAcces() : null,
            'derniereConnexion' => $utilisateur->getDerniereConnexion(),
            'role' => $utilisateur->getRole(),
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Lit un utilisateur par son ID.
     */
    public function read(int $id): ?Utilisateur
    {
        $query = "SELECT * FROM Utilisateur WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return $this->mapUtilisateur($result);
    }

    /**
     * Met à jour un utilisateur existant.
     */
    public function update($utilisateur): void
    {
        $query = "UPDATE Utilisateur 
                  SET nom = :nom, 
                      email = :email, 
                      motDePasse = :motDePasse, 
                      adresseLivraison = :adresseLivraison, 
                      boutique = :boutique, 
                      commission = :commission, 
                      niveauAcces = :niveauAcces, 
                      derniereConnexion = :derniereConnexion,
                      role = :role
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'nom' => $utilisateur->getNom(),
            'email' => $utilisateur->getEmail(),
            'motDePasse' => $utilisateur->getMotDePasse(),
            'adresseLivraison' => $utilisateur instanceof Client ? $utilisateur->getAdresseLivraison() : null,
            'boutique' => $utilisateur instanceof Vendeur ? $utilisateur->getBoutique() : null,
            'commission' => $utilisateur instanceof Vendeur ? $utilisateur->getCommission() : null,
            'niveauAcces' => $utilisateur instanceof Admin ? $utilisateur->getNiveauAcces() : null,
            'derniereConnexion' => $utilisateur->getDerniereConnexion(),
            'role' => $utilisateur->getRole(),
            'id' => $utilisateur->getId(),
        ]);
    }

    /**
     * Supprime un utilisateur par son ID.
     */
    public function delete(int $id): void
    {
        $query = "DELETE FROM Utilisateur WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
    }

    /**
     * Récupère tous les utilisateurs.
     */
    public function findAll(): array
    {
        $query = "SELECT * FROM Utilisateur";
        $stmt = $this->db->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $utilisateurs = [];
        foreach ($result as $row) {
            $utilisateurs[] = $this->mapUtilisateur($row);
        }

        return $utilisateurs;
    }

    /**
     * Mappe un tableau SQL vers une instance d'Utilisateur.
     */
    private function mapUtilisateur(array $row): Utilisateur
    {
        switch ($row['type']) {
            case 'client':
                return new Client(
                    $row['nom'],
                    $row['email'],
                    $row['motDePasse'],
                    $row['adresseLivraison'],
                    $row['dateInscription'],
                    $row['derniereConnexion'],
                    $row['role']
                );
            case 'vendeur':
                return new Vendeur(
                    $row['nom'],
                    $row['email'],
                    $row['motDePasse'],
                    $row['boutique'],
                    $row['commission'],
                    $row['dateInscription'],
                    $row['derniereConnexion'],
                    $row['role']
                );
            case 'admin':
                return new Admin(
                    $row['nom'],
                    $row['email'],
                    $row['motDePasse'],
                    $row['niveauAcces'],
                    $row['dateInscription'],
                    $row['derniereConnexion'],
                    $row['role']
                );
            default:
                throw new \Exception("Type d'utilisateur inconnu : " . $row['type']);
        }
    }
}
