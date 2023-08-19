<?php 
require_once 'src/model/Produit.php';
require_once 'src/config/connectBdd.php';

class Hamecon extends Produit
{
    private $longueur_hamecon;
    private $poids_hamecon;
    private $id_type_hamecon;    
    private $nom_type_hamecon;    

    public function getLongueurHamecon(): float 
    {
        return $this->longueur_hamecon;
    }

    public function setLongueurHamecon(float $longueur_hamecon): void 
    {
        $this->longueur_hamecon = $longueur_hamecon;
    }

    public function getPoidsHamecon(): float 
    {
        return $this->poids_hamecon;
    }

    public function setPoidsHamecon(float $poids_hamecon): void {
        $this->poids_hamecon = $poids_hamecon;
    }

    public function getIdTypeHamecon()
    {
        return $this->id_type_hamecon;
    }

    public function setIdTypeHamecon($id_type_hamecon)
    {
        $this->id_type_hamecon = $id_type_hamecon;
    }

    public function getNomTypeHamecon()
    {
        return $this->nom_type_hamecon;
    }

    public function setNomTypeHamecon($nom_type_hamecon)
    {
        $this->nom_type_hamecon = $nom_type_hamecon;
    }
}

class HameconRepository extends connectBdd
{
    public function getAllHamecons()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_hamecon.*, type_hamecon.nom_type_hamecon
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_hamecon ON caracteristiques_hamecon.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit

                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_hamecon ON type_hamecon.id_type_hamecon = caracteristiques_hamecon.id_type_hamecon
                WHERE produit.id_genre = 3
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $hameconsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $hamecons = [];
            foreach ($hameconsData as $hameconData) 
            {
                $hamecon = new Hamecon();
                $hamecon->setIdProduit($hameconData['id_produit']);
                $hamecon->setNomProduit($hameconData['nom_produit']);
                $hamecon->setDescriptionProduit($hameconData['description_produit']);
                $hamecon->setPrixProduit($hameconData['prix_produit']);
                $hamecon->setPromoProduit($hameconData['promo_produit']);
                $hamecon->setPrixPromoProduit($hameconData['prix_promo_produit']);
                $hamecon->setStockProduit($hameconData['stock_produit']);
                $hamecon->setIdCategorie($hameconData['id_categorie']);
                $hamecon->setNomCategorie($hameconData['nom_categorie']);
                $hamecon->setIdMarque($hameconData['id_marque']);
                $hamecon->setNomMarque($hameconData['nom_marque']);
                $hamecon->setIdGenre($hameconData['id_genre']);
                $hamecon->setNomGenre($hameconData['nom_genre']);
                $hamecon->setIdImage($hameconData['id_image']);
                $hamecon->setNomImage($hameconData['nom_image']);
                $hamecon->setDescriptionImage($hameconData['description_image']);

                $hamecon->setLongueurHamecon($hameconData['longueur_hamecon']);
                $hamecon->setPoidsHamecon($hameconData['poids_hamecon']);
                $hamecon->setIdTypeHamecon($hameconData['id_type_hamecon']);
                $hamecon->setNomTypeHamecon($hameconData['nom_type_hamecon']);

                $hamecons[] = $hamecon;
            }

            return $hamecons;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des hamecons : " . $e->getMessage());
        }
    }

    public function getHamecon($id_produit)
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_hamecon.*, type_hamecon.nom_type_hamecon
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_hamecon ON caracteristiques_hamecon.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit

                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_hamecon ON type_hamecon.id_type_hamecon = caracteristiques_hamecon.id_type_hamecon
                WHERE produit.id_genre = 3 AND produit.id_produit = ?
                GROUP BY produit.id_produit
            ");

            $req->execute([$id_produit]);

            $hameconData = $req->fetch(PDO::FETCH_ASSOC);

            $hamecon = new Hamecon();
            $hamecon->setIdProduit($hameconData['id_produit']);
            $hamecon->setNomProduit($hameconData['nom_produit']);
            $hamecon->setDescriptionProduit($hameconData['description_produit']);
            $hamecon->setPrixProduit($hameconData['prix_produit']);
            $hamecon->setPromoProduit($hameconData['promo_produit']);
            $hamecon->setPrixPromoProduit($hameconData['prix_promo_produit']);
            $hamecon->setStockProduit($hameconData['stock_produit']);
            $hamecon->setIdCategorie($hameconData['id_categorie']);
            $hamecon->setNomCategorie($hameconData['nom_categorie']);
            $hamecon->setIdMarque($hameconData['id_marque']);
            $hamecon->setNomMarque($hameconData['nom_marque']);
            $hamecon->setIdGenre($hameconData['id_genre']);
            $hamecon->setNomGenre($hameconData['nom_genre']);
            $hamecon->setIdImage($hameconData['id_image']);
            $hamecon->setNomImage($hameconData['nom_image']);
            $hamecon->setDescriptionImage($hameconData['description_image']);

            $hamecon->setLongueurHamecon($hameconData['longueur_hamecon']);
            $hamecon->setPoidsHamecon($hameconData['poids_hamecon']);
            $hamecon->setIdTypeHamecon($hameconData['id_type_hamecon']);
            $hamecon->setNomTypeHamecon($hameconData['nom_type_hamecon']);

            return $hamecon;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des hamecons : " . $e->getMessage());
        }
    }

    public function addHamecon(Hamecon $hamecon)
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
                $hamecon->getNomProduit(),
                $hamecon->getDescriptionProduit(),
                $hamecon->getPrixProduit(),
                $hamecon->getStockProduit(),
                $hamecon->getPromoProduit(),
                $hamecon->getPrixPromoProduit(),
                $hamecon->getIdCategorie(),
                $hamecon->getIdMarque(),
                $hamecon->getIdGenre(),
            ]);

            $idProduit = $this->bdd->lastInsertId();

            $reqCaracteristiquesHamecon = $this->bdd->prepare
            ("
                INSERT INTO caracteristiques_hamecon (id_produit, longueur_hamecon, poids_hamecon, id_type_hamecon)
                VALUES (?,?,?,?)
            ");

            $reqCaracteristiquesHamecon->execute
            ([
                $idProduit,
                $hamecon->getLongueurHamecon(),
                $hamecon->getPoidsHamecon(),
                $hamecon->getIdTypeHamecon(),
            ]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de l'ajout de la hamecon : " . $e->getMessage());
        }
    }

    public function updateHamecon(Hamecon $hamecon)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqProduit = $this->bdd->prepare("UPDATE produit 
            SET nom_produit = ?, description_produit = ?, prix_produit = ?, stock_produit = ?, promo_produit = ?, prix_promo_produit = ?, id_categorie = ?, id_marque = ?, id_genre = ?
            WHERE id_produit = ?");

            $reqProduit->execute
            ([
                $hamecon->getNomProduit(),
                $hamecon->getDescriptionProduit(),
                $hamecon->getPrixProduit(),
                $hamecon->getStockProduit(),
                $hamecon->getPromoProduit(),
                $hamecon->getPrixPromoProduit(),
                $hamecon->getIdCategorie(),
                $hamecon->getIdMarque(),
                $hamecon->getIdGenre(),
                $hamecon->getIdProduit(),
            ]);

            $reqCaracteristiquesHamecon = $this->bdd->prepare("UPDATE caracteristiques_hamecon 
            SET longueur_hamecon = ?, poids_hamecon = ?, id_type_hamecon = ? WHERE id_produit = ?");

            $reqCaracteristiquesHamecon->execute
            ([
                $hamecon->getLongueurHamecon(),
                $hamecon->getPoidsHamecon(),
                $hamecon->getIdTypeHamecon(),
                $hamecon->getIdProduit(),
            ]);

            $this->bdd->commit();
        }
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la mise à jour de la hamecon : " . $e->getMessage());
        }
    }

    public function deleteHamecon($id_produit)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqCaracteristiquesHamecon = $this->bdd->prepare("DELETE FROM caracteristiques_hamecon WHERE id_produit = ?");
            $reqCaracteristiquesHamecon->execute([$id_produit]);

            $reqProduit = $this->bdd->prepare("DELETE FROM produit WHERE id_produit = ?");
            $reqProduit->execute([$id_produit]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la suppression de la hamecon : " . $e->getMessage());
        }
    }
}
