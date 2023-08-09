<?php 
require_once 'src/model/Produit.php';
require_once 'src/config/connectBdd.php';

class Autre extends Produit
{
    private $detail_autre;
    private $id_type_autre;    
    private $nom_type_autre;    

    public function getDetailAutre(): string 
    {
        return $this->detail_autre;
    }

    public function setDetailAutre(string $detail_autre): void 
    {
        $this->detail_autre = $detail_autre;
    }

    public function getIdTypeAutre()
    {
        return $this->id_type_autre;
    }

    public function setIdTypeAutre($id_type_autre)
    {
        $this->id_type_autre = $id_type_autre;
    }

    public function getNomTypeAutre()
    {
        return $this->nom_type_autre;
    }

    public function setNomTypeAutre($nom_type_autre)
    {
        $this->nom_type_autre = $nom_type_autre;
    }
}

class AutreRepository extends connectBdd
{
    public function getAllAutres()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_autre.*, type_autre.nom_type_autre
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_autre ON caracteristiques_autre.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit

                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_autre ON type_autre.id_type_autre = caracteristiques_autre.id_type_autre
                WHERE produit.id_genre = 9
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $autresData = $req->fetchAll(PDO::FETCH_ASSOC);

            $autres = [];
            foreach ($autresData as $autreData) 
            {
                $autre = new Autre();
                $autre->setIdProduit($autreData['id_produit']);
                $autre->setNomProduit($autreData['nom_produit']);
                $autre->setDescriptionProduit($autreData['description_produit']);
                $autre->setPrixProduit($autreData['prix_produit']);
                $autre->setPromoProduit($autreData['promo_produit']);
                $autre->setPrixPromoProduit($autreData['prix_promo_produit']);
                $autre->setStockProduit($autreData['stock_produit']);
                $autre->setIdCategorie($autreData['id_categorie']);
                $autre->setNomCategorie($autreData['nom_categorie']);
                $autre->setIdMarque($autreData['id_marque']);
                $autre->setNomMarque($autreData['nom_marque']);
                $autre->setIdGenre($autreData['id_genre']);
                $autre->setNomGenre($autreData['nom_genre']);
                $autre->setIdImage($autreData['id_image']);
                $autre->setNomImage($autreData['nom_image']);
                $autre->setDescriptionImage($autreData['description_image']);

                $autre->setDetailAutre($autreData['detail_autre']);
                $autre->setIdTypeAutre($autreData['id_type_autre']);
                $autre->setNomTypeAutre($autreData['nom_type_autre']);

                $autres[] = $autre;
            }

            return $autres;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des autres : " . $e->getMessage());
        }
    }

    public function getAutre()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_autre.*, type_autre.nom_type_autre
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_autre ON caracteristiques_autre.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit

                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_autre ON type_autre.id_type_autre = caracteristiques_autre.id_type_autre
                WHERE produit.id_genre = 9
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $autreData = $req->fetch(PDO::FETCH_ASSOC);

            $autre = new Autre();
            $autre->setIdProduit($autreData['id_produit']);
            $autre->setNomProduit($autreData['nom_produit']);
            $autre->setDescriptionProduit($autreData['description_produit']);
            $autre->setPrixProduit($autreData['prix_produit']);
            $autre->setPromoProduit($autreData['promo_produit']);
            $autre->setPrixPromoProduit($autreData['prix_promo_produit']);
            $autre->setStockProduit($autreData['stock_produit']);
            $autre->setIdCategorie($autreData['id_categorie']);
            $autre->setNomCategorie($autreData['nom_categorie']);
            $autre->setIdMarque($autreData['id_marque']);
            $autre->setNomMarque($autreData['nom_marque']);
            $autre->setIdGenre($autreData['id_genre']);
            $autre->setNomGenre($autreData['nom_genre']);
            $autre->setIdImage($autreData['id_image']);
            $autre->setNomImage($autreData['nom_image']);
            $autre->setDescriptionImage($autreData['description_image']);

            $autre->setDetailAutre($autreData['detail_autre']);
            $autre->setIdTypeAutre($autreData['id_type_autre']);
            $autre->setNomTypeAutre($autreData['nom_type_autre']);

            return $autre;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des autres : " . $e->getMessage());
        }
    }

    public function addAutre(Autre $autre)
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
                $autre->getNomProduit(),
                $autre->getDescriptionProduit(),
                $autre->getPrixProduit(),
                $autre->getStockProduit(),
                $autre->getPromoProduit(),
                $autre->getPrixPromoProduit(),
                $autre->getIdCategorie(),
                $autre->getIdMarque(),
                $autre->getIdGenre(),
            ]);

            $idProduit = $this->bdd->lastInsertId();

            $reqCaracteristiquesAutre = $this->bdd->prepare
            ("
                INSERT INTO caracteristiques_autre (id_produit, detail_autre, id_type_autre)
                VALUES (?,?,?)
            ");

            $reqCaracteristiquesAutre->execute
            ([
                $idProduit,
                $autre->getDetailAutre(),
                $autre->getIdTypeAutre(),
            ]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de l'ajout de la autre : " . $e->getMessage());
        }
    }

    public function updateAutre(Autre $autre)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqProduit = $this->bdd->prepare("UPDATE produit 
            SET nom_produit = ?, description_produit = ?, prix_produit = ?, stock_produit = ?, promo_produit = ?, prix_promo_produit = ?, id_categorie = ?, id_marque = ?, id_genre = ?
            WHERE id_produit = ?");

            $reqProduit->execute
            ([
                $autre->getNomProduit(),
                $autre->getDescriptionProduit(),
                $autre->getPrixProduit(),
                $autre->getStockProduit(),
                $autre->getPromoProduit(),
                $autre->getPrixPromoProduit(),
                $autre->getIdCategorie(),
                $autre->getIdMarque(),
                $autre->getIdGenre(),
                $autre->getIdProduit(),
            ]);

            $reqCaracteristiquesAutre = $this->bdd->prepare("UPDATE caracteristiques_autre 
            SET detail_autre = ?, id_type_autre = ? WHERE id_produit = ?");

            $reqCaracteristiquesAutre->execute
            ([
                $autre->getDetailAutre(),
                $autre->getIdTypeAutre(),
                $autre->getIdProduit(),
            ]);

            $this->bdd->commit();
        }
        catch (PDOException $e)
        {
            $this->bdd->rollBack();
            die("Erreur lors de la mise à jour de la autre : " . $e->getMessage());
        }
    }

    public function deleteAutre($id_produit)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqCaracteristiquesAutre = $this->bdd->prepare("DELETE FROM caracteristiques_autre WHERE id_produit = ?");
            $reqCaracteristiquesAutre->execute([$id_produit]);

            $reqProduit = $this->bdd->prepare("DELETE FROM produit WHERE id_produit = ?");
            $reqProduit->execute([$id_produit]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la suppression de la autre : " . $e->getMessage());
        }
    }
}
