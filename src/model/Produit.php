<?php
require_once 'src/config/connectBdd.php';

class Produit
{
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

    public function __construct($produitForm)
    {
        if (!isset($produitForm['nom_produit']) or $produitForm['nom_produit'] == '') 
        {
            return false;
        }

        if (!isset($produitForm['description_produit']) or $produitForm['description_produit'] == '') 
        {
            return false;
        }

        if (!isset($produitForm['prix_produit']) or $produitForm['prix_produit'] == '') 
        {
            return false;
        }

        if (!isset($produitForm['promo_produit']) or $produitForm['promo_produit'] == '') 
        {
            return false;
        }

        if (!isset($produitForm['prix_promo_produit']) or $produitForm['prix_promo_produit'] == '') 
        {
            return false;
        }

        if (!isset($produitForm['stock_produit']) or $produitForm['stock_produit'] == '') 
        {
            return false;
        }

        if (!isset($produitForm['categorie_produit']) or $produitForm['categorie_produit'] == '') 
        {
            return false;
        }

        if (!isset($produitForm['genre_produit']) or $produitForm['genre_produit'] == '') 
        {
            return false;
        }

        if (!isset($produitForm['marque_produit']) or $produitForm['marque_produit'] == '') 
        {
            return false;
        }

        if (!isset($produitForm['images']) or $produitForm['images'] == '') 
        {
            return false;
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
        
        return true;
    }

    public function getIdProduit(): int
    {
        return $this->id_produit;
    }

    public function setIdProduit($id_produit): void
    {
        $this->id_produit = $id_produit;
    }

    public function getNomProduit(): string
    {
        return $this->nom_produit;
    }

    public function setNomProduit($nom_produit): void
    {
        $this->nom_produit = $nom_produit;
    }

    public function getDescriptionProduit(): string
    {
        return $this->description_produit;
    }

    public function setDescriptionProduit($description_produit): void
    {
        $this->description_produit = $description_produit;
    }

    public function getPrixProduit(): float
    {
        return $this->prix_produit;
    }

    public function setPrixProduit($prix_produit): void
    {
        $this->prix_produit = $prix_produit;
    }

    public function getPromoProduit(): int
    {
        return $this->promo_produit;
    }

    public function setPromoProduit($promo_produit): void
    {
        $this->promo_produit = $promo_produit;
    }

    public function getPrixPromoProduit(): float
    {
        return $this->prix_promo_produit;
    }

    public function setPrixPromoProduit($prix_promo_produit): void
    {
        $this->prix_promo_produit = $prix_promo_produit;
    }

    public function getStockProduit(): int
    {
        return $this->stock_produit;
    }

    public function setStockProduit($stock_produit): void
    {
        $this->stock_produit = $stock_produit;
    }

    public function getCategorieProduit(): string
    {
        return $this->id_categorie;
    }

    public function setCategorieProduit($id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

    public function getMarqueProduit(): string
    {
        return $this->id_marque;
    }

    public function setMarqueProduit($id_marque): void
    {
        $this->id_marque = $id_marque;
    }

    public function getGenreProduit(): string
    {
        return $this->id_genre;
    }

    public function setGenreProduit($id_genre): void
    {
        $this->id_genre = $id_genre;
    }

    public function setImage($image)
    {
        $this->images[] = $image;
    }

    public function getImages()
    {
        return $this->images;
    }
}

class ProduitRepository extends connectBdd
{
    public function getLastInsertId()
    {
        $query = "SELECT MAX(id_produit) AS last_id FROM produit";
        $result = $this->bdd->prepare($query);

        if ($result->execute())
        {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $lastId = $row['last_id'];

            return $lastId;
        }
    }

    public function getAllProduct()
    {
        try 
        {
            $req = $this->bdd->prepare
            (
                "SELECT produit.*, marque.nom_marque, categorie.nom_categorie as categorie, image.*, genre.nom_genre as genre
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                INNER JOIN image_produit ON image_produit.id_produit = produit.id_produit
                INNER JOIN image ON image.id_image = image_produit.id_image
                INNER JOIN genre ON genre.id_genre = produit.id_genre
                GROUP BY produit.id_produit"
            );

            $req->execute();

            $products = $req->fetchAll(PDO::FETCH_ASSOC);

            return $products;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des produits : " . $e->getMessage());
        }
    }

    

    public function deleteProduit($id_produit)
    {
        try 
        {
            $reqProduit = $this->bdd->prepare("DELETE FROM produit WHERE id_produit = ?");
            $reqProduit->execute([$id_produit]);
    
            echo "La canne a été supprimée avec succès de la base de données !";
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la suppression de la canne de la base de données: " . $e->getMessage());
        }
    }

}