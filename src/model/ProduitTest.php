<?php
require_once 'src/config/connectBdd.php';

class Produit
{
    // Autres propriétés de la classe Produit
    private $id_produit;
    private $nom_produit;
    private $description_produit;
    private $prix_produit;
    private $stock_produit;
    private $promo_produit;
    private $prix_promo_produit;
    private $id_categorie;
    private $id_marque;
    private $id_genre;
    private $images = [];

    // Propriété pour stocker l'objet Canne
    private $canne;

    // Le constructeur de la classe Produit
    public function __construct($produitForm, $canne)
    {
        // Vérifier que les données nécessaires existent et ne sont pas vides
        if (!isset($produitForm['nom_produit']) || $produitForm['nom_produit'] === '') {
            throw new Exception("Le nom du produit est requis.");
        }

        if (!isset($produitForm['description_produit']) || $produitForm['description_produit'] === '') {
            throw new Exception("La description du produit est requise.");
        }

        if (!isset($produitForm['prix_produit']) || $produitForm['prix_produit'] === '') {
            throw new Exception("Le prix du produit est requis.");
        }

        if (!isset($produitForm['promo_produit']) || $produitForm['promo_produit'] === '') {
            throw new Exception("Le statut de promotion du produit est requis.");
        }

        if (!isset($produitForm['prix_promo_produit']) || $produitForm['prix_promo_produit'] === '') {
            throw new Exception("Le prix promotionnel du produit est requis.");
        }

        if (!isset($produitForm['stock_produit']) || $produitForm['stock_produit'] === '') {
            throw new Exception("Le stock du produit est requis.");
        }

        if (!isset($produitForm['categorie_produit']) || $produitForm['categorie_produit'] === '') {
            throw new Exception("La catégorie du produit est requise.");
        }

        if (!isset($produitForm['genre_produit']) || $produitForm['genre_produit'] === '') {
            throw new Exception("Le genre du produit est requis.");
        }

        if (!isset($produitForm['marque_produit']) || $produitForm['marque_produit'] === '') {
            throw new Exception("La marque du produit est requise.");
        }

        if (!isset($produitForm['images']) || empty($produitForm['images'])) {
            throw new Exception("Au moins une image du produit est requise.");
        }

        $this->nom_produit = $produitForm['nom_produit'];
        $this->description_produit = $produitForm['description_produit'];
        $this->prix_produit = $produitForm['prix_produit'];
        $this->promo_produit = $produitForm['promo_produit'];
        $this->prix_promo_produit = $produitForm['prix_promo_produit'];
        $this->stock_produit = $produitForm['stock_produit'];
        $this->id_categorie = $produitForm['categorie_produit'];
        $this->id_genre = $produitForm['genre_produit'];
        $this->id_marque = $produitForm['marque_produit'];
        $this->images = $produitForm['images'];

        $this->canne = $canne;
    }
    public function addImage($image)
    {
        $this->images[] = $image;
    }

    public function removeImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
        }
    }

    public function clearImages()
    {
        $this->images = [];
    }

    public function getIdProduit(): int
    {
        return $this->id_produit;
    }

    public function getNomProduit(): string
    {
        return $this->nom_produit;
    }

    public function getDescriptionProduit(): string
    {
        return $this->description_produit;
    }

    public function getPrixProduit(): float
    {
        return $this->prix_produit;
    }

    public function getPromoProduit(): int
    {
        return $this->promo_produit;
    }

    public function getPrixPromoProduit(): float
    {
        return $this->prix_promo_produit;
    }

    public function getStockProduit(): int
    {
        return $this->stock_produit;
    }

    public function getCategorieProduit(): string
    {
        return $this->id_categorie;
    }

    public function getMarqueProduit(): string
    {
        return $this->id_marque;
    }

    public function getGenreProduit(): string
    {
        return $this->id_genre;
    }

    public function getImages(): array
    {
        return $this->images;
    }
    
    public function getCanne()
    {
        return $this->canne;
    }
}

class ProduitRepository extends connectBdd
{
    public function getAllCanne()
    {
        try
        {
            $req = $this->bdd->prepare
            (
                "SELECT produit.*, marque.nom_marque, categorie.nom_categorie as categorie, image.*, genre.nom_genre as genre, caracteristiques_canne.*
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_canne ON caracteristiques_canne.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                INNER JOIN image_produit ON image_produit.id_produit = produit.id_produit
                INNER JOIN image ON image.id_image = image_produit.id_image
                INNER JOIN genre ON genre.id_genre = produit.id_genre
                WHERE produit.id_genre = 1
                GROUP BY produit.id_produit"
            );

            $req->execute();

            $cannesData = $req->fetchAll(PDO::FETCH_ASSOC);

            return $cannesData;
        }
        catch (PDOException $e)
        {
            die("Erreur lors de la récupération des cannes : " . $e->getMessage());
        }
    }
}


