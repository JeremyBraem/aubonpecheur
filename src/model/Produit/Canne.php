<?php 
require_once 'src/model/Produit.php';
require_once 'src/config/connectBdd.php';

class Canne extends Produit
{
    private $longueur_canne;
    private $poids_canne;
    private $id_type_canne;    
    private $nom_type_canne;    

    public function getLongueurCanne(): float 
    {
        return $this->longueur_canne;
    }

    public function setLongueurCanne(float $longueur_canne): void 
    {
        $this->longueur_canne = $longueur_canne;
    }

    public function getPoidsCanne(): float 
    {
        return $this->poids_canne;
    }

    public function setPoidsCanne(float $poids_canne): void 
    {
        $this->poids_canne = $poids_canne;
    }

    public function getIdTypeCanne()
    {
        return $this->id_type_canne;
    }

    public function setIdTypeCanne($id_type_canne)
    {
        $this->id_type_canne = $id_type_canne;
    }

    public function getNomTypeCanne()
    {
        return $this->nom_type_canne;
    }

    public function setNomTypeCanne($nom_type_canne)
    {
        $this->nom_type_canne = $nom_type_canne;
    }
}

class CanneRepository extends connectBdd
{
    public function getAllCannes()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_canne.*, type_canne.*
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_canne ON caracteristiques_canne.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                INNER JOIN image ON image.id_produit = produit.id_produit
                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_canne ON type_canne.id_type_canne = caracteristiques_canne.id_type_canne
                WHERE produit.id_genre = 1
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $cannesData = $req->fetchAll(PDO::FETCH_ASSOC);

            $cannes = [];
            foreach ($cannesData as $canneData) 
            {
                $canne = new Canne();
                $canne->setIdProduit($canneData['id_produit']);
                $canne->setNomProduit($canneData['nom_produit']);
                $canne->setDescriptionProduit($canneData['description_produit']);
                $canne->setPrixProduit($canneData['prix_produit']);
                $canne->setPromoProduit($canneData['promo_produit']);
                $canne->setPrixPromoProduit($canneData['prix_promo_produit']);
                $canne->setStockProduit($canneData['stock_produit']);
                $canne->setIdCategorie($canneData['id_categorie']);
                $canne->setNomCategorie($canneData['nom_categorie']);
                $canne->setIdMarque($canneData['id_marque']);
                $canne->setNomMarque($canneData['nom_marque']);
                $canne->setIdGenre($canneData['id_genre']);
                $canne->setNomGenre($canneData['nom_genre']);
                $canne->setIdImage($canneData['id_image']);
                $canne->setNomImage($canneData['nom_image']);
                $canne->setDescriptionImage($canneData['description_image']);
                $canne->setLongueurCanne($canneData['longueur_canne']);
                $canne->setPoidsCanne($canneData['poids_canne']);
                $canne->setIdTypeCanne($canneData['id_type_canne']);
                $canne->setNomTypeCanne($canneData['nom_type_canne']);

                $cannes[] = $canne;
            }

            return $cannes;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des cannes : " . $e->getMessage());
        }
    }

    public function getCanne()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_canne.*, type_canne.*
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_canne ON caracteristiques_canne.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                INNER JOIN image ON image.id_produit = produit.id_produit
                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_canne ON type_canne.id_type_canne = caracteristiques_canne.id_type_canne
                WHERE produit.id_genre = 1
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $canneData = $req->fetch(PDO::FETCH_ASSOC);

            $canne = new Canne();
            $canne->setIdProduit($canneData['id_produit']);
            $canne->setNomProduit($canneData['nom_produit']);
            $canne->setDescriptionProduit($canneData['description_produit']);
            $canne->setPrixProduit($canneData['prix_produit']);
            $canne->setPromoProduit($canneData['promo_produit']);
            $canne->setPrixPromoProduit($canneData['prix_promo_produit']);
            $canne->setStockProduit($canneData['stock_produit']);
            $canne->setIdCategorie($canneData['id_categorie']);
            $canne->setNomCategorie($canneData['nom_categorie']);
            $canne->setIdMarque($canneData['id_marque']);
            $canne->setNomMarque($canneData['nom_marque']);
            $canne->setIdGenre($canneData['id_genre']);
            $canne->setNomGenre($canneData['nom_genre']);
            $canne->setIdImage($canneData['id_image']);
            $canne->setNomImage($canneData['nom_image']);
            $canne->setDescriptionImage($canneData['description_image']);

            $canne->setLongueurCanne($canneData['longueur_canne']);
            $canne->setPoidsCanne($canneData['poids_canne']);
            $canne->setIdTypeCanne($canneData['id_type_canne']);
            $canne->setNomTypeCanne($canneData['nom_type_canne']);

            return $canne;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des cannes : " . $e->getMessage());
        }
    }

    public function addCanne(Canne $canne)
    {
        try {
            $this->bdd->beginTransaction();

            $reqProduit = $this->bdd->prepare
            ("
                INSERT INTO produit 
                (nom_produit, description_produit, prix_produit, stock_produit, promo_produit, prix_promo_produit, id_categorie, id_marque, id_genre)
                VALUES (?,?,?,?,?,?,?,?,?)
            ");

            $reqProduit->execute
            ([
                $canne->getNomProduit(),
                $canne->getDescriptionProduit(),
                $canne->getPrixProduit(),
                $canne->getStockProduit(),
                $canne->getPromoProduit(),
                $canne->getPrixPromoProduit(),
                $canne->getIdCategorie(),
                $canne->getIdMarque(),
                $canne->getIdGenre(),
            ]);

            $idProduit = $this->bdd->lastInsertId();

            $reqCaracteristiquesCanne = $this->bdd->prepare
            ("
                INSERT INTO caracteristiques_canne (id_produit, longueur_canne, poids_canne, id_type_canne)
                VALUES (?,?,?,?)
            ");

            $reqCaracteristiquesCanne->execute
            ([
                $idProduit,
                $canne->getLongueurCanne(),
                $canne->getPoidsCanne(),
                $canne->getIdTypeCanne(),
            ]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de l'ajout de la canne : " . $e->getMessage());
        }
    }

    public function updateCanne(Canne $canne)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqProduit = $this->bdd->prepare("UPDATE produit 
            SET nom_produit = ?, description_produit = ?, prix_produit = ?, stock_produit = ?, promo_produit = ?, prix_promo_produit = ?, id_categorie = ?, id_marque = ?, id_genre = ?
            WHERE id_produit = ?");

            $reqProduit->execute
            ([
                $canne->getNomProduit(),
                $canne->getDescriptionProduit(),
                $canne->getPrixProduit(),
                $canne->getStockProduit(),
                $canne->getPromoProduit(),
                $canne->getPrixPromoProduit(),
                $canne->getIdCategorie(),
                $canne->getIdMarque(),
                $canne->getIdGenre(),
                $canne->getIdProduit(),
            ]);

            $reqCaracteristiquesCanne = $this->bdd->prepare("UPDATE caracteristiques_canne 
            SET longueur_canne = ?, poids_canne = ?, id_type_canne = ? WHERE id_produit = ?");

            $reqCaracteristiquesCanne->execute
            ([
                $canne->getLongueurCanne(),
                $canne->getPoidsCanne(),
                $canne->getIdTypeCanne(),
                $canne->getIdProduit(),
            ]);

            $this->bdd->commit();
        }
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la mise à jour de la canne : " . $e->getMessage());
        }
    }

    public function deleteCanne($id_produit)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqCaracteristiquesCanne = $this->bdd->prepare("DELETE FROM caracteristiques_canne WHERE id_produit = ?");
            $reqCaracteristiquesCanne->execute([$id_produit]);

            $reqProduit = $this->bdd->prepare("DELETE FROM produit WHERE id_produit = ?");
            $reqProduit->execute([$id_produit]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la suppression de la canne : " . $e->getMessage());
        }
    }
}
