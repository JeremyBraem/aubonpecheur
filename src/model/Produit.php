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
                "SELECT produit.*, marque.nom_marque, categorie.nom_categorie as categorie, image.*, genre.nom_genre as genre, caracteristiques_canne.*,caracteristiques_moulinet.*,caracteristiques_hamecon.*,caracteristiques_leurre.*,caracteristiques_ligne.*,caracteristiques_ligne.*,caracteristiques_equipement.*,caracteristiques_plomb.*,caracteristiques_autre.*, type_canne.*,type_moulinet.*,type_hamecon.*,type_leurre.*,type_ligne.*,type_plomb.*,type_equipement.*,type_appat.*,type_autre.*
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_canne ON caracteristiques_canne.id_produit = produit.id_produit
                INNER JOIN caracteristiques_moulinet ON caracteristiques_moulinet.id_produit = produit.id_produit
                INNER JOIN caracteristiques_appat ON caracteristiques_appat.id_produit = produit.id_produit
                INNER JOIN caracteristiques_autre ON caracteristiques_autre.id_produit = produit.id_produit
                INNER JOIN caracteristiques_equipement ON caracteristiques_equipement.id_produit = produit.id_produit
                INNER JOIN caracteristiques_hamecon ON caracteristiques_hamecon.id_produit = produit.id_produit
                INNER JOIN caracteristiques_leurre ON caracteristiques_leurre.id_produit = produit.id_produit
                INNER JOIN caracteristiques_ligne ON caracteristiques_ligne.id_produit = produit.id_produit
                INNER JOIN caracteristiques_plomb ON caracteristiques_plomb.id_produit = produit.id_produit
                INNER JOIN type_canne ON type_canne.id_type_canne = caracteristiques_canne.id_type_canne
                INNER JOIN type_moulinet ON type_moulinet.id_type_moulinet = caracteristiques_moulinet.id_type_moulinet
                INNER JOIN type_hamecon ON type_hamecon.id_type_hamecon = caracteristiques_hamecon.id_type_hamecon
                INNER JOIN type_appat ON type_appat.id_type_appat = caracteristiques_appat.id_type_appat
                INNER JOIN type_equipement ON type_equipement.id_type_equipement = caracteristiques_equipement.id_type_equipement
                INNER JOIN type_leurre ON type_leurre.id_type_leurre = caracteristiques_leurre.id_type_leurre
                INNER JOIN type_ligne ON type_ligne.id_type_ligne = caracteristiques_ligne.id_type_ligne
                INNER JOIN type_plomb ON type_plomb.id_type_plomb = caracteristiques_plomb.id_type_plomb
                INNER JOIN type_autre ON type_autre.id_type_autre = caracteristiques_autre.id_type_autre
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                INNER JOIN image_produit ON image_produit.id_produit = produit.id_produit
                INNER JOIN image ON image.id_image = image_produit.id_image
                INNER JOIN genre ON genre.id_genre = produit.id_genre
                GROUP BY produit.id_produit"
            );

            $req->execute();

            $products = $req->fetchAll(PDO::FETCH_ASSOC);

            var_dump($products);
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