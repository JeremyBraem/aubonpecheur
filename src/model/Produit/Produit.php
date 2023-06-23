<?php
require_once 'src/config/connectBdd.php';

class Produit
{
    private $id_produit;

    public function createToInsertProduit($id_produit): bool
    {
        if (!isset($id_produit) or $id_produit == '') {
            return false;
        }

        $this->id_produit = $id_produit;

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
}

class ProduitRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllProducts()
    {
        $cannes = $this->getAllCannes();
        $hamecons = $this->getAllHamecons();
        $moulinets = $this->getAllMoulinets();

        $products = [
            'cannes' => $cannes,
            'hamecons' => $hamecons,
            'moulinets' => $moulinets,
        ];

        return $products;
    }

    public function getAllCannes()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_canne.*, marque.*
        FROM canne
        INNER JOIN categorie ON canne.id_categorie = categorie.id_categorie
        INNER JOIN type_canne ON canne.id_type_canne = type_canne.id_type_canne
        INNER JOIN marque ON canne.id_marque = marque.id_marque");

        $req->execute();
        $cannes = $req->fetchAll();
        
        return $cannes;
    }

    public function getAllMoulinets()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_moulinet.*, marque.*
        FROM moulinet
        INNER JOIN categorie ON moulinet.id_categorie = categorie.id_categorie
        INNER JOIN type_moulinet ON moulinet.id_type_moulinet = type_moulinet.id_type_moulinet
        INNER JOIN marque ON moulinet.id_marque = marque.id_marque");

        $req->execute();
        $moulinets = $req->fetchAll();

        return $moulinets;
    }

    public function getAllHamecons()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_hamecon.*, marque.*
        FROM hamecon
        INNER JOIN categorie ON hamecon.id_categorie = categorie.id_categorie
        INNER JOIN type_hamecon ON hamecon.id_type_hamecon = type_hamecon.id_type_hamecon
        INNER JOIN marque ON hamecon.id_marque = marque.id_marque");

        $req->execute();
        $hamecons = $req->fetchAll();
    
        return $hamecons;
    }
}
