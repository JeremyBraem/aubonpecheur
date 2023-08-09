<?php 
require_once 'src/model/Produit.php';
require_once 'src/config/connectBdd.php';

class Ligne extends Produit
{
    private $longueur_ligne;
    private $diametre_ligne;
    private $id_type_ligne;    
    private $nom_type_ligne;    

    public function getLongueurLigne(): float 
    {
        return $this->longueur_ligne;
    }

    public function setLongueurLigne(float $longueur_ligne): void 
    {
        $this->longueur_ligne = $longueur_ligne;
    }

    public function getDiametreLigne(): float 
    {
        return $this->diametre_ligne;
    }

    public function setDiametreLigne(float $diametre_ligne): void {
        $this->diametre_ligne = $diametre_ligne;
    }

    public function getIdTypeLigne()
    {
        return $this->id_type_ligne;
    }

    public function setIdTypeLigne($id_type_ligne)
    {
        $this->id_type_ligne = $id_type_ligne;
    }

    public function getNomTypeLigne()
    {
        return $this->nom_type_ligne;
    }

    public function setNomTypeLigne($nom_type_ligne)
    {
        $this->nom_type_ligne = $nom_type_ligne;
    }
}

class LigneRepository extends connectBdd
{
    public function getAllLignes()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_ligne.*, type_ligne.*
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_ligne ON caracteristiques_ligne.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit

                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_ligne ON type_ligne.id_type_ligne = caracteristiques_ligne.id_type_ligne
                WHERE produit.id_genre = 5
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $lignesData = $req->fetchAll(PDO::FETCH_ASSOC);

            $lignes = [];
            foreach ($lignesData as $ligneData) 
            {
                $ligne = new Ligne();
                $ligne->setIdProduit($ligneData['id_produit']);
                $ligne->setNomProduit($ligneData['nom_produit']);
                $ligne->setDescriptionProduit($ligneData['description_produit']);
                $ligne->setPrixProduit($ligneData['prix_produit']);
                $ligne->setPromoProduit($ligneData['promo_produit']);
                $ligne->setPrixPromoProduit($ligneData['prix_promo_produit']);
                $ligne->setStockProduit($ligneData['stock_produit']);
                $ligne->setIdCategorie($ligneData['id_categorie']);
                $ligne->setNomCategorie($ligneData['nom_categorie']);
                $ligne->setIdMarque($ligneData['id_marque']);
                $ligne->setNomMarque($ligneData['nom_marque']);
                $ligne->setIdGenre($ligneData['id_genre']);
                $ligne->setNomGenre($ligneData['nom_genre']);
                $ligne->setIdImage($ligneData['id_image']);
                $ligne->setNomImage($ligneData['nom_image']);
                $ligne->setDescriptionImage($ligneData['description_image']);

                $ligne->setLongueurLigne($ligneData['longueur_ligne']);
                $ligne->setDiametreLigne($ligneData['diametre_ligne']);
                $ligne->setIdTypeLigne($ligneData['id_type_ligne']);
                $ligne->setNomTypeLigne($ligneData['nom_type_ligne']);

                $lignes[] = $ligne;
            }

            return $lignes;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des lignes : " . $e->getMessage());
        }
    }

    public function getLigne()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_ligne.*, type_ligne.*
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_ligne ON caracteristiques_ligne.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit

                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_ligne ON type_ligne.id_type_ligne = caracteristiques_ligne.id_type_ligne
                WHERE produit.id_genre = 5
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $ligneData = $req->fetch(PDO::FETCH_ASSOC);

            $ligne = new Ligne();
            $ligne->setIdProduit($ligneData['id_produit']);
            $ligne->setNomProduit($ligneData['nom_produit']);
            $ligne->setDescriptionProduit($ligneData['description_produit']);
            $ligne->setPrixProduit($ligneData['prix_produit']);
            $ligne->setPromoProduit($ligneData['promo_produit']);
            $ligne->setPrixPromoProduit($ligneData['prix_promo_produit']);
            $ligne->setStockProduit($ligneData['stock_produit']);
            $ligne->setIdCategorie($ligneData['id_categorie']);
            $ligne->setNomCategorie($ligneData['nom_categorie']);
            $ligne->setIdMarque($ligneData['id_marque']);
            $ligne->setNomMarque($ligneData['nom_marque']);
            $ligne->setIdGenre($ligneData['id_genre']);
            $ligne->setNomGenre($ligneData['nom_genre']);
            $ligne->setIdImage($ligneData['id_image']);
            $ligne->setNomImage($ligneData['nom_image']);
            $ligne->setDescriptionImage($ligneData['description_image']);

            $ligne->setLongueurLigne($ligneData['longueur_ligne']);
            $ligne->setDiametreLigne($ligneData['diametre_ligne']);
            $ligne->setIdTypeLigne($ligneData['id_type_ligne']);
            $ligne->setNomTypeLigne($ligneData['nom_type_ligne']);

            return $ligne;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des lignes : " . $e->getMessage());
        }
    }

    public function addLigne(Ligne $ligne)
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
                $ligne->getNomProduit(),
                $ligne->getDescriptionProduit(),
                $ligne->getPrixProduit(),
                $ligne->getStockProduit(),
                $ligne->getPromoProduit(),
                $ligne->getPrixPromoProduit(),
                $ligne->getIdCategorie(),
                $ligne->getIdMarque(),
                $ligne->getIdGenre(),
            ]);

            $idProduit = $this->bdd->lastInsertId();

            $reqCaracteristiquesLigne = $this->bdd->prepare
            ("
                INSERT INTO caracteristiques_ligne (id_produit, longueur_ligne, diametre_ligne, id_type_ligne)
                VALUES (?,?,?,?)
            ");

            $reqCaracteristiquesLigne->execute
            ([
                $idProduit,
                $ligne->getLongueurLigne(),
                $ligne->getDiametreLigne(),
                $ligne->getIdTypeLigne(),
            ]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de l'ajout de la ligne : " . $e->getMessage());
        }
    }

    public function updateLigne(Ligne $ligne)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqProduit = $this->bdd->prepare("UPDATE produit 
            SET nom_produit = ?, description_produit = ?, prix_produit = ?, stock_produit = ?, promo_produit = ?, prix_promo_produit = ?, id_categorie = ?, id_marque = ?, id_genre = ?
            WHERE id_produit = ?");

            $reqProduit->execute
            ([
                $ligne->getNomProduit(),
                $ligne->getDescriptionProduit(),
                $ligne->getPrixProduit(),
                $ligne->getStockProduit(),
                $ligne->getPromoProduit(),
                $ligne->getPrixPromoProduit(),
                $ligne->getIdCategorie(),
                $ligne->getIdMarque(),
                $ligne->getIdGenre(),
                $ligne->getIdProduit(),
            ]);

            $reqCaracteristiquesLigne = $this->bdd->prepare("UPDATE caracteristiques_ligne 
            SET longueur_ligne = ?, diametre_ligne = ?, id_type_ligne = ? WHERE id_produit = ?");

            $reqCaracteristiquesLigne->execute
            ([
                $ligne->getLongueurLigne(),
                $ligne->getDiametreLigne(),
                $ligne->getIdTypeLigne(),
                $ligne->getIdProduit(),
            ]);

            $this->bdd->commit();
        }
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la mise à jour de la ligne : " . $e->getMessage());
        }
    }

    public function deleteLigne($id_produit)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqCaracteristiquesLigne = $this->bdd->prepare("DELETE FROM caracteristiques_ligne WHERE id_produit = ?");
            $reqCaracteristiquesLigne->execute([$id_produit]);

            $reqProduit = $this->bdd->prepare("DELETE FROM produit WHERE id_produit = ?");
            $reqProduit->execute([$id_produit]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la suppression de la ligne : " . $e->getMessage());
        }
    }
}
