<?php 
require_once 'src/model/Produit.php';
require_once 'src/config/connectBdd.php';

class Leurre extends Produit
{
    private $longueur_leurre;
    private $poids_leurre;
    private $couleur_leurre;
    private $id_type_leurre;    
    private $nom_type_leurre;    

    public function getLongueurLeurre(): float 
    {
        return $this->longueur_leurre;
    }

    public function setLongueurLeurre(float $longueur_leurre): void 
    {
        $this->longueur_leurre = $longueur_leurre;
    }

    public function getPoidsLeurre(): float 
    {
        return $this->poids_leurre;
    }

    public function setPoidsLeurre(float $poids_leurre): void 
    {
        $this->poids_leurre = $poids_leurre;
    }

    public function getCouleurLeurre(): string 
    {
        return $this->couleur_leurre;
    }

    public function setCouleurLeurre(string $couleur_leurre): void 
    {
        $this->couleur_leurre = $couleur_leurre;
    }

    public function getIdTypeLeurre()
    {
        return $this->id_type_leurre;
    }

    public function setIdTypeLeurre($id_type_leurre)
    {
        $this->id_type_leurre = $id_type_leurre;
    }

    public function getNomTypeLeurre()
    {
        return $this->nom_type_leurre;
    }

    public function setNomTypeLeurre($nom_type_leurre)
    {
        $this->nom_type_leurre = $nom_type_leurre;
    }
}

class LeurreRepository extends connectBdd
{
    public function getAllLeurres()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_leurre.*, type_leurre.nom_type_leurre
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_leurre ON caracteristiques_leurre.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                INNER JOIN image_produit ON image_produit.id_produit = produit.id_produit
                INNER JOIN image ON image.id_image = image_produit.id_image
                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_leurre ON type_leurre.id_type_leurre = caracteristiques_leurre.id_type_leurre
                WHERE produit.id_genre = 4
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $leurresData = $req->fetchAll(PDO::FETCH_ASSOC);

            $leurres = [];

            foreach ($leurresData as $leurreData) 
            {
                $leurre = new Leurre();
                $leurre->setIdProduit($leurreData['id_produit']);
                $leurre->setNomProduit($leurreData['nom_produit']);
                $leurre->setDescriptionProduit($leurreData['description_produit']);
                $leurre->setPrixProduit($leurreData['prix_produit']);
                $leurre->setPromoProduit($leurreData['promo_produit']);
                $leurre->setPrixPromoProduit($leurreData['prix_promo_produit']);
                $leurre->setStockProduit($leurreData['stock_produit']);
                $leurre->setIdCategorie($leurreData['id_categorie']);
                $leurre->setNomCategorie($leurreData['nom_categorie']);
                $leurre->setIdMarque($leurreData['id_marque']);
                $leurre->setNomMarque($leurreData['nom_marque']);
                $leurre->setIdGenre($leurreData['id_genre']);
                $leurre->setNomGenre($leurreData['nom_genre']);
                $leurre->setIdImage($leurreData['id_image']);
                $leurre->setNomImage($leurreData['nom_image']);
                $leurre->setDescriptionImage($leurreData['description_image']);

                $leurre->setCouleurLeurre($leurreData['couleur_leurre']);
                $leurre->setPoidsLeurre($leurreData['poids_leurre']);
                $leurre->setLongueurLeurre($leurreData['longueur_leurre']);
                $leurre->setIdTypeLeurre($leurreData['id_type_leurre']);
                $leurre->setNomTypeLeurre($leurreData['nom_type_leurre']);

                $leurres[] = $leurre;
            }

            return $leurres;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des leurres : " . $e->getMessage());
        }
    }

    public function addLeurre(Leurre $leurre)
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
                $leurre->getNomProduit(),
                $leurre->getDescriptionProduit(),
                $leurre->getPrixProduit(),
                $leurre->getStockProduit(),
                $leurre->getPromoProduit(),
                $leurre->getPrixPromoProduit(),
                $leurre->getIdCategorie(),
                $leurre->getIdMarque(),
                $leurre->getIdGenre(),
            ]);

            $idProduit = $this->bdd->lastInsertId();

            $reqCaracteristiquesLeurre = $this->bdd->prepare
            ("
                INSERT INTO caracteristiques_leurre (id_produit, couleur_leurre, poids_leurre, longueur_leurre, id_type_leurre)
                VALUES (?,?,?,?,?)
            ");

            $reqCaracteristiquesLeurre->execute
            ([
                $idProduit,
                $leurre->getCouleurLeurre(),
                $leurre->getPoidsLeurre(),
                $leurre->getLongueurLeurre(),
                $leurre->getIdTypeLeurre(),
            ]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de l'ajout de la leurre : " . $e->getMessage());
        }
    }

    public function updateLeurre(Leurre $leurre)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqProduit = $this->bdd->prepare("UPDATE produit 
            SET nom_produit = ?, description_produit = ?, prix_produit = ?, stock_produit = ?, promo_produit = ?, prix_promo_produit = ?, id_categorie = ?, id_marque = ?, id_genre = ?
            WHERE id_produit = ?");

            $reqProduit->execute
            ([
                $leurre->getNomProduit(),
                $leurre->getDescriptionProduit(),
                $leurre->getPrixProduit(),
                $leurre->getStockProduit(),
                $leurre->getPromoProduit(),
                $leurre->getPrixPromoProduit(),
                $leurre->getIdCategorie(),
                $leurre->getIdMarque(),
                $leurre->getIdGenre(),
                $leurre->getIdProduit(),
            ]);

            $reqCaracteristiquesLeurre = $this->bdd->prepare("UPDATE caracteristiques_leurre 
            SET  couleur_leurre = ?, poids_leurre = ?, longueur_leurre = ?, id_type_leurre = ? WHERE id_produit = ?");

            $reqCaracteristiquesLeurre->execute
            ([              
                $leurre->getCouleurLeurre(),  
                $leurre->getPoidsLeurre(),
                $leurre->getLongueurLeurre(),
                $leurre->getIdTypeLeurre(),
                $leurre->getIdProduit(),
            ]);

            $this->bdd->commit();
        }
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la mise à jour de la leurre : " . $e->getMessage());
        }
    }

    public function deleteLeurre($id_produit)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqCaracteristiquesLeurre = $this->bdd->prepare("DELETE FROM caracteristiques_leurre WHERE id_produit = ?");
            $reqCaracteristiquesLeurre->execute([$id_produit]);

            $reqProduit = $this->bdd->prepare("DELETE FROM produit WHERE id_produit = ?");
            $reqProduit->execute([$id_produit]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la suppression de la leurre : " . $e->getMessage());
        }
    }
}
