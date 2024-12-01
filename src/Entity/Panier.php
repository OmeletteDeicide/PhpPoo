<?php

namespace src\Entity;

use DateTime;
use src\Entity\Produit\Produit;

class Panier
{
    private array $articles = [];
    private DateTime $dateCreation;

    public function __construct(array $articles, DateTime $dateCreation)
    {
        $this->articles = $articles;
        $this->dateCreation = $dateCreation;
    }

    public function getArticles(): array
    {
        return $this->articles;
    }

    public function setArticles(array $articles): void
    {
        $this->articles = $articles;
    }

    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

    public function setDateCreation(DateTime $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    public function ajouterArticle(Produit $produit, int $quantite): void
    {
        $id = $produit->getId();
        if (isset($this->articles[$id])) {
            $this->articles[$id]['quantite'] += $quantite;
        } else {
            $this->articles[$id] = [
                'produit' => $produit,
                'quantite' => $quantite
            ];
        }
    }

    public function retirerArticle(Produit $produit, int $quantite): void
    {
        $id = $produit->getId();
        if (isset($this->articles[$id])) {
            $this->articles[$id]['quantite'] -= $quantite;
            if ($this->articles[$id]['quantite'] <= 0) {
                unset($this->articles[$id]);
            }
        }
    }

    public function vider(): void
    {
        $this->articles = [];
    }

    public function calculerTotal(): float
    {
        $total = 0.0;
        foreach ($this->articles as $article) {
            $total += $article['produit']->calculerPrixTTC() * $article['quantite'];
        }
        return $total;
    }

    public function compterArticles(): int
    {
        $totalQuantite = 0;
        foreach ($this->articles as $article) {
            $totalQuantite += $article['quantite'];
        }
        return $totalQuantite;
    }
}