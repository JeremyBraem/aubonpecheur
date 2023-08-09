<?php 
require_once 'src/model/Produit.php';
require_once 'src/config/connectBdd.php';

class Moulinet extends Produit
{
    private $ratio_moulinet;
    private $poids_moulinet;
    private $id_type_moulinet;    
    private $nom_type_moulinet;    

    public function getRatioMoulinet(): float 
    {
        return $this->ratio_moulinet;
    }

    public function setRatioMoulinet(float $ratio_moulinet): void 
    {
        $this->ratio_moulinet = $ratio_moulinet;
    }

    public function getPoidsMoulinet(): float 
    {
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

    public function getNomTypeMoulinet()
    {
        return $this->nom_type_moulinet;
    }

    public function setNomTypeMoulinet($nom_type_moulinet)
    {
        $this->nom_type_moulinet = $nom_type_moulinet;
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
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_moulinet.*, type_moulinet.nom_type_moulinet
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_moulinet ON caracteristiques_moulinet.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit

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
                $moulinet->setNomCategorie($moulinetData['nom_categorie']);
                $moulinet->setIdMarque($moulinetData['id_marque']);
                $moulinet->setNomMarque($moulinetData['nom_marque']);
                $moulinet->setIdGenre($moulinetData['id_genre']);
                $moulinet->setNomGenre($moulinetData['nom_genre']);
                $moulinet->setIdImage($moulinetData['id_image']);
                $moulinet->setNomImage($moulinetData['nom_image']);
                $moulinet->setDescriptionImage($moulinetData['description_image']);

                $moulinet->setRatioMoulinet($moulinetData['ratio_moulinet']);
                $moulinet->setPoidsMoulinet($moulinetData['poids_moulinet']);
                $moulinet->setIdTypeMoulinet($moulinetData['id_type_moulinet']);
                $moulinet->setNomTypeMoulinet($moulinetData['nom_type_moulinet']);

                $moulinets[] = $moulinet;
            }
           
            return $moulinets;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des moulinets : " . $e->getMessage());
        }
    }

    public function getMoulinet()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_moulinet.*, type_moulinet.nom_type_moulinet
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_moulinet ON caracteristiques_moulinet.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit

                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_moulinet ON type_moulinet.id_type_moulinet = caracteristiques_moulinet.id_type_moulinet
                WHERE produit.id_genre = 2
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $moulinetData = $req->fetch(PDO::FETCH_ASSOC);

            $moulinet = new Moulinet();
            $moulinet->setIdProduit($moulinetData['id_produit']);
            $moulinet->setNomProduit($moulinetData['nom_produit']);
            $moulinet->setDescriptionProduit($moulinetData['description_produit']);
            $moulinet->setPrixProduit($moulinetData['prix_produit']);
            $moulinet->setPromoProduit($moulinetData['promo_produit']);
            $moulinet->setPrixPromoProduit($moulinetData['prix_promo_produit']);
            $moulinet->setStockProduit($moulinetData['stock_produit']);
            $moulinet->setIdCategorie($moulinetData['id_categorie']);
            $moulinet->setNomCategorie($moulinetData['nom_categorie']);
            $moulinet->setIdMarque($moulinetData['id_marque']);
            $moulinet->setNomMarque($moulinetData['nom_marque']);
            $moulinet->setIdGenre($moulinetData['id_genre']);
            $moulinet->setNomGenre($moulinetData['nom_genre']);
            $moulinet->setIdImage($moulinetData['id_image']);
            $moulinet->setNomImage($moulinetData['nom_image']);
            $moulinet->setDescriptionImage($moulinetData['description_image']);

            $moulinet->setRatioMoulinet($moulinetData['ratio_moulinet']);
            $moulinet->setPoidsMoulinet($moulinetData['poids_moulinet']);
            $moulinet->setIdTypeMoulinet($moulinetData['id_type_moulinet']);
            $moulinet->setNomTypeMoulinet($moulinetData['nom_type_moulinet']);
           
            return $moulinet;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des moulinets : " . $e->getMessage());
        }
    }

    public function addMoulinet(Moulinet $moulinet)
    {
        try {
            $this->bdd->beginTransaction();

            $reqProduit = $this->bdd->prepare
            ("
                INSERT INTO produit (nom_produit, description_produit, prix_produit, stock_produit, promo_produit, prix_promo_produit, id_categorie, id_marque, id_genre)
                VALUES (?,?,?,?,?,?,?,?,?)
            ");

            $reqProduit->execute
            ([
                $moulinet->getNomProduit(),
                $moulinet->getDescriptionProduit(),
                $moulinet->getPrixProduit(),
                $moulinet->getStockProduit(),
                $moulinet->getPromoProduit(),
                $moulinet->getPrixPromoProduit(),
                $moulinet->getIdCategorie(),
                $moulinet->getIdMarque(),
                $moulinet->getIdGenre(),
            ]);

            $idProduit = $this->bdd->lastInsertId();

            $reqCaracteristiquesMoulinet = $this->bdd->prepare
            ("
                INSERT INTO caracteristiques_moulinet (id_produit, ratio_moulinet, poids_moulinet, id_type_moulinet)
                VALUES (?,?,?,?)
            ");

            $reqCaracteristiquesMoulinet->execute
            ([
                $idProduit,
                $moulinet->getRatioMoulinet(),
                $moulinet->getPoidsMoulinet(),
                $moulinet->getIdTypeMoulinet(),
            ]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de l'ajout de la moulinet : " . $e->getMessage());
        }
    }

    public function updateMoulinet(Moulinet $moulinet)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqProduit = $this->bdd->prepare("UPDATE produit 
            SET nom_produit = ?, description_produit = ?, prix_produit = ?, stock_produit = ?, promo_produit = ?, prix_promo_produit = ?, id_categorie = ?, id_marque = ?, id_genre = ?
            WHERE id_produit = ?");

            $reqProduit->execute
            ([
                $moulinet->getNomProduit(),
                $moulinet->getDescriptionProduit(),
                $moulinet->getPrixProduit(),
                $moulinet->getStockProduit(),
                $moulinet->getPromoProduit(),
                $moulinet->getPrixPromoProduit(),
                $moulinet->getIdCategorie(),
                $moulinet->getIdMarque(),
                $moulinet->getIdGenre(),
                $moulinet->getIdProduit(),
            ]);

            $reqCaracteristiquesMoulinet = $this->bdd->prepare("UPDATE caracteristiques_moulinet 
            SET ratio_moulinet = ?, poids_moulinet = ?, id_type_moulinet = ? WHERE id_produit = ?");

            $reqCaracteristiquesMoulinet->execute
            ([
                $moulinet->getRatioMoulinet(),
                $moulinet->getPoidsMoulinet(),
                $moulinet->getIdTypeMoulinet(),
                $moulinet->getIdProduit(),
            ]);

            $this->bdd->commit();
        }
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la mise à jour de la moulinet : " . $e->getMessage());
        }
    }

    public function deleteMoulinet($id_produit)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqCaracteristiquesMoulinet = $this->bdd->prepare("DELETE FROM caracteristiques_moulinet WHERE id_produit = ?");
            $reqCaracteristiquesMoulinet->execute([$id_produit]);

            $reqProduit = $this->bdd->prepare("DELETE FROM produit WHERE id_produit = ?");
            $reqProduit->execute([$id_produit]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la suppression de la moulinet : " . $e->getMessage());
        }
    }
}
