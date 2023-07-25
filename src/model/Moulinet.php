<?php 
require_once 'src/model/Produit.php';
require_once 'src/config/connectBdd.php';

class Moulinet extends Produit
{
    private $ratio_moulinet;
    private $poids_moulinet;
    private $id_type_moulinet;    

    // Getter et Setter pour ratio_moulinet
    public function getRatioMoulinet(): float {
        return $this->ratio_moulinet;
    }

    public function setRatioMoulinet(float $ratio_moulinet): void {
        $this->ratio_moulinet = $ratio_moulinet;
    }

    // Getter et Setter pour poids_moulinet
    public function getPoidsMoulinet(): float {
        return $this->poids_moulinet;
    }

    public function setPoidsMoulinet(float $poids_moulinet): void {
        $this->poids_moulinet = $poids_moulinet;
    }

    public function getIdTypeMoulinet()
    {
        return $this->id_type_moulinet;
    }

    public function setIdTypeMoulinet($id_type_moulinet)
    {
        $this->id_type_moulinet = $id_type_moulinet;
    }
}

class MoulinetRepository extends connectBdd
{
    public function getAllMoulinets()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.nom_marque, categorie.nom_categorie as categorie, 
                image.*, genre.nom_genre as genre, caracteristiques_moulinet.*, type_moulinet.nom_type_moulinet
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_moulinet ON caracteristiques_moulinet.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                INNER JOIN image_produit ON image_produit.id_produit = produit.id_produit
                INNER JOIN image ON image.id_image = image_produit.id_image
                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_moulinet ON type_moulinet.id_type_moulinet = caracteristiques_moulinet.id_type_moulinet
                WHERE produit.id_genre = 2
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $moulinetsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $moulinets = [];
            foreach ($moulinetsData as $moulinetData) 
            {
                $moulinet = new Moulinet();
                $moulinet->setIdProduit($moulinetData['id_produit']);
                $moulinet->setNomProduit($moulinetData['nom_produit']);
                $moulinet->setDescriptionProduit($moulinetData['description_produit']);
                $moulinet->setPrixProduit($moulinetData['prix_produit']);
                $moulinet->setPromoProduit($moulinetData['promo_produit']);
                $moulinet->setPrixPromoProduit($moulinetData['prix_promo_produit']);
                $moulinet->setStockProduit($moulinetData['stock_produit']);
                $moulinet->setIdCategorie($moulinetData['id_categorie']);
                $moulinet->setIdMarque($moulinetData['id_marque']);
                $moulinet->setIdGenre($moulinetData['id_genre']);

                $moulinet->setRatioMoulinet($moulinetData['ratio_moulinet']);
                $moulinet->setPoidsMoulinet($moulinetData['poids_moulinet']);
                $moulinet->setIdTypeMoulinet($moulinetData['id_type_moulinet']);

                $moulinets[] = $moulinet;
            }

            return $moulinets;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des moulinets : " . $e->getMessage());
        }
    }
}