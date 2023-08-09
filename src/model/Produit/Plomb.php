<?php 
require_once 'src/model/Produit.php';
require_once 'src/config/connectBdd.php';

class Plomb extends Produit
{
    private $longueur_plomb;
    private $poids_plomb;
    private $diametre_plomb;
    private $id_type_plomb;    
    private $nom_type_plomb;    

    public function getLongueurPlomb(): float 
    {
        return $this->longueur_plomb;
    }

    public function setLongueurPlomb(float $longueur_plomb): void 
    {
        $this->longueur_plomb = $longueur_plomb;
    }

    public function getPoidsPlomb(): float 
    {
        return $this->poids_plomb;
    }

    public function setPoidsPlomb(float $poids_plomb): void 
    {
        $this->poids_plomb = $poids_plomb;
    }

    public function getDiametrePlomb(): float 
    {
        return $this->diametre_plomb;
    }

    public function setDiametrePlomb(float $diametre_plomb): void 
    {
        $this->diametre_plomb = $diametre_plomb;
    }

    public function getIdTypePlomb()
    {
        return $this->id_type_plomb;
    }

    public function setIdTypePlomb($id_type_plomb)
    {
        $this->id_type_plomb = $id_type_plomb;
    }

    public function getNomTypePlomb()
    {
        return $this->nom_type_plomb;
    }

    public function setNomTypePlomb($nom_type_plomb)
    {
        $this->nom_type_plomb = $nom_type_plomb;
    }
}

class PlombRepository extends connectBdd
{
    public function getAllPlombs()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_plomb.*, type_plomb.*
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_plomb ON caracteristiques_plomb.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit

                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_plomb ON type_plomb.id_type_plomb = caracteristiques_plomb.id_type_plomb
                WHERE produit.id_genre = 6
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $plombsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $plombs = [];

            foreach ($plombsData as $plombData) 
            {
                $plomb = new Plomb();
                $plomb->setIdProduit($plombData['id_produit']);
                $plomb->setNomProduit($plombData['nom_produit']);
                $plomb->setDescriptionProduit($plombData['description_produit']);
                $plomb->setPrixProduit($plombData['prix_produit']);
                $plomb->setPromoProduit($plombData['promo_produit']);
                $plomb->setPrixPromoProduit($plombData['prix_promo_produit']);
                $plomb->setStockProduit($plombData['stock_produit']);
                $plomb->setIdCategorie($plombData['id_categorie']);
                $plomb->setNomCategorie($plombData['nom_categorie']);
                $plomb->setIdMarque($plombData['id_marque']);
                $plomb->setNomMarque($plombData['nom_marque']);
                $plomb->setIdGenre($plombData['id_genre']);
                $plomb->setNomGenre($plombData['nom_genre']);
                $plomb->setIdImage($plombData['id_image']);
                $plomb->setNomImage($plombData['nom_image']);
                $plomb->setDescriptionImage($plombData['description_image']);
                $plomb->setDiametrePlomb($plombData['diametre_plomb']);
                $plomb->setPoidsPlomb($plombData['poids_plomb']);
                $plomb->setLongueurPlomb($plombData['longueur_plomb']);
                $plomb->setIdTypePlomb($plombData['id_type_plomb']);
                $plomb->setNomTypePlomb($plombData['nom_type_plomb']);

                $plombs[] = $plomb;
            }

            return $plombs;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des plombs : " . $e->getMessage());
        }
    }

    public function getPlomb()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_plomb.*, type_plomb.*
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_plomb ON caracteristiques_plomb.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit

                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_plomb ON type_plomb.id_type_plomb = caracteristiques_plomb.id_type_plomb
                WHERE produit.id_genre = 6
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $plombData = $req->fetch(PDO::FETCH_ASSOC);
        
            $plomb = new Plomb();
            $plomb->setIdProduit($plombData['id_produit']);
            $plomb->setNomProduit($plombData['nom_produit']);
            $plomb->setDescriptionProduit($plombData['description_produit']);
            $plomb->setPrixProduit($plombData['prix_produit']);
            $plomb->setPromoProduit($plombData['promo_produit']);
            $plomb->setPrixPromoProduit($plombData['prix_promo_produit']);
            $plomb->setStockProduit($plombData['stock_produit']);
            $plomb->setIdCategorie($plombData['id_categorie']);
            $plomb->setNomCategorie($plombData['nom_categorie']);
            $plomb->setIdMarque($plombData['id_marque']);
            $plomb->setNomMarque($plombData['nom_marque']);
            $plomb->setIdGenre($plombData['id_genre']);
            $plomb->setNomGenre($plombData['nom_genre']);
            $plomb->setIdImage($plombData['id_image']);
            $plomb->setNomImage($plombData['nom_image']);
            $plomb->setDescriptionImage($plombData['description_image']);

            $plomb->setDiametrePlomb($plombData['diametre_plomb']);
            $plomb->setPoidsPlomb($plombData['poids_plomb']);
            $plomb->setLongueurPlomb($plombData['longueur_plomb']);
            $plomb->setIdTypePlomb($plombData['id_type_plomb']);
            $plomb->setNomTypePlomb($plombData['nom_type_plomb']);

            return $plomb;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des plombs : " . $e->getMessage());
        }
    }

    public function addPlomb(Plomb $plomb)
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
                $plomb->getNomProduit(),
                $plomb->getDescriptionProduit(),
                $plomb->getPrixProduit(),
                $plomb->getStockProduit(),
                $plomb->getPromoProduit(),
                $plomb->getPrixPromoProduit(),
                $plomb->getIdCategorie(),
                $plomb->getIdMarque(),
                $plomb->getIdGenre(),
            ]);

            $idProduit = $this->bdd->lastInsertId();

            $reqCaracteristiquesPlomb = $this->bdd->prepare
            ("
                INSERT INTO caracteristiques_plomb (id_produit, poids_plomb, longueur_plomb, diametre_plomb, id_type_plomb)
                VALUES (?,?,?,?,?)
            ");

            $reqCaracteristiquesPlomb->execute
            ([
                $idProduit,
                $plomb->getPoidsPlomb(),
                $plomb->getLongueurPlomb(),
                $plomb->getDiametrePlomb(),
                $plomb->getIdTypePlomb(),
            ]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de l'ajout de la plomb : " . $e->getMessage());
        }
    }

    public function updatePlomb(Plomb $plomb)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqProduit = $this->bdd->prepare("UPDATE produit 
            SET nom_produit = ?, description_produit = ?, prix_produit = ?, stock_produit = ?, promo_produit = ?, prix_promo_produit = ?, id_categorie = ?, id_marque = ?, id_genre = ?
            WHERE id_produit = ?");

            $reqProduit->execute
            ([
                $plomb->getNomProduit(),
                $plomb->getDescriptionProduit(),
                $plomb->getPrixProduit(),
                $plomb->getStockProduit(),
                $plomb->getPromoProduit(),
                $plomb->getPrixPromoProduit(),
                $plomb->getIdCategorie(),
                $plomb->getIdMarque(),
                $plomb->getIdGenre(),
                $plomb->getIdProduit(),
            ]);

            $reqCaracteristiquesPlomb = $this->bdd->prepare("UPDATE caracteristiques_plomb 
            SET poids_plomb = ?, longueur_plomb = ?, diametre_plomb = ?, id_type_plomb = ? WHERE id_produit = ?");

            $reqCaracteristiquesPlomb->execute
            ([              
                $plomb->getPoidsPlomb(),
                $plomb->getLongueurPlomb(),
                $plomb->getDiametrePlomb(),  
                $plomb->getIdTypePlomb(),
                $plomb->getIdProduit(),
            ]);

            $this->bdd->commit();
        }
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la mise à jour de la plomb : " . $e->getMessage());
        }
    }

    public function deletePlomb($id_produit)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqCaracteristiquesPlomb = $this->bdd->prepare("DELETE FROM caracteristiques_plomb WHERE id_produit = ?");
            $reqCaracteristiquesPlomb->execute([$id_produit]);

            $reqProduit = $this->bdd->prepare("DELETE FROM produit WHERE id_produit = ?");
            $reqProduit->execute([$id_produit]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la suppression de la plomb : " . $e->getMessage());
        }
    }
}
