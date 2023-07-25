<?php 
require_once 'src/model/Produit.php';
require_once 'src/config/connectBdd.php';

class Appat extends Produit
{
    private $detail_appat;
    private $id_type_appat;    

    public function getDetailAppat(): string 
    {
        return $this->detail_appat;
    }

    public function setDetailAppat(string $detail_appat): void 
    {
        $this->detail_appat = $detail_appat;
    }

    public function getIdTypeAppat()
    {
        return $this->id_type_appat;
    }

    public function setIdTypeAppat($id_type_appat)
    {
        $this->id_type_appat = $id_type_appat;
    }
}

class AppatRepository extends connectBdd
{
    public function getAllAppats()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_appat.*, type_appat.nom_type_appat
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_appat ON caracteristiques_appat.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                INNER JOIN image_produit ON image_produit.id_produit = produit.id_produit
                INNER JOIN image ON image.id_image = image_produit.id_image
                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_appat ON type_appat.id_type_appat = caracteristiques_appat.id_type_appat
                WHERE produit.id_genre = 1
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $appatsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $appats = [];
            foreach ($appatsData as $appatData) 
            {
                $appat = new Appat();
                $appat->setIdProduit($appatData['id_produit']);
                $appat->setNomProduit($appatData['nom_produit']);
                $appat->setDescriptionProduit($appatData['description_produit']);
                $appat->setPrixProduit($appatData['prix_produit']);
                $appat->setPromoProduit($appatData['promo_produit']);
                $appat->setPrixPromoProduit($appatData['prix_promo_produit']);
                $appat->setStockProduit($appatData['stock_produit']);
                $appat->setIdCategorie($appatData['id_categorie']);
                $appat->setNomCategorie($appatData['nom_categorie']);
                $appat->setIdMarque($appatData['id_marque']);
                $appat->setNomMarque($appatData['nom_marque']);
                $appat->setIdGenre($appatData['id_genre']);
                $appat->setNomGenre($appatData['nom_genre']);
                $appat->setIdImage($appatData['id_image']);
                $appat->setNomImage($appatData['nom_image']);
                $appat->setDescriptionImage($appatData['description_image']);

                $appat->setDetailAppat($appatData['detail_appat']);
                $appat->setIdTypeAppat($appatData['id_type_appat']);

                $appats[] = $appat;
            }

            return $appats;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des appats : " . $e->getMessage());
        }
    }

    public function addAppat(Appat $appat)
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
                $appat->getNomProduit(),
                $appat->getDescriptionProduit(),
                $appat->getPrixProduit(),
                $appat->getStockProduit(),
                $appat->getPromoProduit(),
                $appat->getPrixPromoProduit(),
                $appat->getIdCategorie(),
                $appat->getIdMarque(),
                $appat->getIdGenre(),
            ]);

            $idProduit = $this->bdd->lastInsertId();

            $reqCaracteristiquesAppat = $this->bdd->prepare
            ("
                INSERT INTO caracteristiques_appat (id_produit, detail_appat, id_type_appat)
                VALUES (?,?,?)
            ");

            $reqCaracteristiquesAppat->execute
            ([
                $idProduit,
                $appat->getDetailAppat(),
                $appat->getIdTypeAppat(),
            ]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de l'ajout de la appat : " . $e->getMessage());
        }
    }

    public function updateAppat(Appat $appat)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqProduit = $this->bdd->prepare("UPDATE produit 
            SET nom_produit = ?, description_produit = ?, prix_produit = ?, stock_produit = ?, promo_produit = ?, prix_promo_produit = ?, id_categorie = ?, id_marque = ?, id_genre = ?
            WHERE id_produit = ?");

            $reqProduit->execute
            ([
                $appat->getNomProduit(),
                $appat->getDescriptionProduit(),
                $appat->getPrixProduit(),
                $appat->getStockProduit(),
                $appat->getPromoProduit(),
                $appat->getPrixPromoProduit(),
                $appat->getIdCategorie(),
                $appat->getIdMarque(),
                $appat->getIdGenre(),
                $appat->getIdProduit(),
            ]);

            $reqCaracteristiquesAppat = $this->bdd->prepare("UPDATE caracteristiques_appat 
            SET detail_appat = ?, id_type_appat = ? WHERE id_produit = ?");

            $reqCaracteristiquesAppat->execute
            ([
                $appat->getDetailAppat(),
                $appat->getIdTypeAppat(),
                $appat->getIdProduit(),
            ]);

            $this->bdd->commit();
        }
        catch (PDOException $e)
        {
            $this->bdd->rollBack();
            die("Erreur lors de la mise à jour de la appat : " . $e->getMessage());
        }
    }

    public function deleteAppat($id_produit)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqCaracteristiquesAppat = $this->bdd->prepare("DELETE FROM caracteristiques_appat WHERE id_produit = ?");
            $reqCaracteristiquesAppat->execute([$id_produit]);

            $reqProduit = $this->bdd->prepare("DELETE FROM produit WHERE id_produit = ?");
            $reqProduit->execute([$id_produit]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la suppression de la appat : " . $e->getMessage());
        }
    }
}
