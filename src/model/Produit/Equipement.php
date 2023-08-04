<?php 
require_once 'src/model/Produit.php';
require_once 'src/config/connectBdd.php';

class Equipement extends Produit
{
    private $detail_equipement;
    private $id_type_equipement;    
    private $nom_type_equipement;    

    public function getDetailEquipement(): string 
    {
        return $this->detail_equipement;
    }

    public function setDetailEquipement(string $detail_equipement): void 
    {
        $this->detail_equipement = $detail_equipement;
    }

    public function getIdTypeEquipement()
    {
        return $this->id_type_equipement;
    }

    public function setIdTypeEquipement($id_type_equipement)
    {
        $this->id_type_equipement = $id_type_equipement;
    }

    public function getNomTypeEquipement()
    {
        return $this->nom_type_equipement;
    }

    public function setNomTypeEquipement($nom_type_equipement)
    {
        $this->nom_type_equipement = $nom_type_equipement;
    }
}

class EquipementRepository extends connectBdd
{
    public function getAllEquipements()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_equipement.*, type_equipement.nom_type_equipement
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_equipement ON caracteristiques_equipement.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                INNER JOIN image_produit ON image_produit.id_produit = produit.id_produit
                INNER JOIN image ON image.id_image = image_produit.id_image
                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_equipement ON type_equipement.id_type_equipement = caracteristiques_equipement.id_type_equipement
                WHERE produit.id_genre = 7
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $equipementsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $equipements = [];
            foreach ($equipementsData as $equipementData) 
            {
                $equipement = new Equipement();
                $equipement->setIdProduit($equipementData['id_produit']);
                $equipement->setNomProduit($equipementData['nom_produit']);
                $equipement->setDescriptionProduit($equipementData['description_produit']);
                $equipement->setPrixProduit($equipementData['prix_produit']);
                $equipement->setPromoProduit($equipementData['promo_produit']);
                $equipement->setPrixPromoProduit($equipementData['prix_promo_produit']);
                $equipement->setStockProduit($equipementData['stock_produit']);
                $equipement->setIdCategorie($equipementData['id_categorie']);
                $equipement->setNomCategorie($equipementData['nom_categorie']);
                $equipement->setIdMarque($equipementData['id_marque']);
                $equipement->setNomMarque($equipementData['nom_marque']);
                $equipement->setIdGenre($equipementData['id_genre']);
                $equipement->setNomGenre($equipementData['nom_genre']);
                $equipement->setIdImage($equipementData['id_image']);
                $equipement->setNomImage($equipementData['nom_image']);
                $equipement->setDescriptionImage($equipementData['description_image']);

                $equipement->setDetailEquipement($equipementData['detail_equipement']);
                $equipement->setIdTypeEquipement($equipementData['id_type_equipement']);
                $equipement->setNomTypeEquipement($equipementData['nom_type_equipement']);

                $equipements[] = $equipement;
            }

            return $equipements;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des equipements : " . $e->getMessage());
        }
    }

    public function getEquipement()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*, caracteristiques_equipement.*, type_equipement.nom_type_equipement
                FROM produit
                INNER JOIN marque ON produit.id_marque = marque.id_marque
                INNER JOIN caracteristiques_equipement ON caracteristiques_equipement.id_produit = produit.id_produit
                INNER JOIN categorie ON produit.id_categorie = categorie.id_categorie
                INNER JOIN image_produit ON image_produit.id_produit = produit.id_produit
                INNER JOIN image ON image.id_image = image_produit.id_image
                INNER JOIN genre ON genre.id_genre = produit.id_genre
                INNER JOIN type_equipement ON type_equipement.id_type_equipement = caracteristiques_equipement.id_type_equipement
                WHERE produit.id_genre = 7
                GROUP BY produit.id_produit
            ");

            $req->execute();

            $equipementData = $req->fetch(PDO::FETCH_ASSOC);
         
            $equipement = new Equipement();
            $equipement->setIdProduit($equipementData['id_produit']);
            $equipement->setNomProduit($equipementData['nom_produit']);
            $equipement->setDescriptionProduit($equipementData['description_produit']);
            $equipement->setPrixProduit($equipementData['prix_produit']);
            $equipement->setPromoProduit($equipementData['promo_produit']);
            $equipement->setPrixPromoProduit($equipementData['prix_promo_produit']);
            $equipement->setStockProduit($equipementData['stock_produit']);
            $equipement->setIdCategorie($equipementData['id_categorie']);
            $equipement->setNomCategorie($equipementData['nom_categorie']);
            $equipement->setIdMarque($equipementData['id_marque']);
            $equipement->setNomMarque($equipementData['nom_marque']);
            $equipement->setIdGenre($equipementData['id_genre']);
            $equipement->setNomGenre($equipementData['nom_genre']);
            $equipement->setIdImage($equipementData['id_image']);
            $equipement->setNomImage($equipementData['nom_image']);
            $equipement->setDescriptionImage($equipementData['description_image']);

            $equipement->setDetailEquipement($equipementData['detail_equipement']);
            $equipement->setIdTypeEquipement($equipementData['id_type_equipement']);
            $equipement->setNomTypeEquipement($equipementData['nom_type_equipement']);

            return $equipement;
        }
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des equipements : " . $e->getMessage());
        }
    }


    public function addEquipement(Equipement $equipement)
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
                $equipement->getNomProduit(),
                $equipement->getDescriptionProduit(),
                $equipement->getPrixProduit(),
                $equipement->getStockProduit(),
                $equipement->getPromoProduit(),
                $equipement->getPrixPromoProduit(),
                $equipement->getIdCategorie(),
                $equipement->getIdMarque(),
                $equipement->getIdGenre(),
            ]);

            $idProduit = $this->bdd->lastInsertId();

            $reqCaracteristiquesEquipement = $this->bdd->prepare
            ("
                INSERT INTO caracteristiques_equipement (id_produit, detail_equipement, id_type_equipement)
                VALUES (?,?,?)
            ");

            $reqCaracteristiquesEquipement->execute
            ([
                $idProduit,
                $equipement->getDetailEquipement(),
                $equipement->getIdTypeEquipement(),
            ]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de l'ajout de la equipement : " . $e->getMessage());
        }
    }

    public function updateEquipement(Equipement $equipement)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqProduit = $this->bdd->prepare("UPDATE produit 
            SET nom_produit = ?, description_produit = ?, prix_produit = ?, stock_produit = ?, promo_produit = ?, prix_promo_produit = ?, id_categorie = ?, id_marque = ?, id_genre = ?
            WHERE id_produit = ?");

            $reqProduit->execute
            ([
                $equipement->getNomProduit(),
                $equipement->getDescriptionProduit(),
                $equipement->getPrixProduit(),
                $equipement->getStockProduit(),
                $equipement->getPromoProduit(),
                $equipement->getPrixPromoProduit(),
                $equipement->getIdCategorie(),
                $equipement->getIdMarque(),
                $equipement->getIdGenre(),
                $equipement->getIdProduit(),
            ]);

            $reqCaracteristiquesEquipement = $this->bdd->prepare("UPDATE caracteristiques_equipement 
            SET detail_equipement = ?, id_type_equipement = ? WHERE id_produit = ?");

            $reqCaracteristiquesEquipement->execute
            ([
                $equipement->getDetailEquipement(),
                $equipement->getIdTypeEquipement(),
                $equipement->getIdProduit(),
            ]);

            $this->bdd->commit();
        }
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la mise à jour de la equipement : " . $e->getMessage());
        }
    }

    public function deleteEquipement($id_produit)
    {
        try 
        {
            $this->bdd->beginTransaction();

            $reqCaracteristiquesEquipement = $this->bdd->prepare("DELETE FROM caracteristiques_equipement WHERE id_produit = ?");
            $reqCaracteristiquesEquipement->execute([$id_produit]);

            $reqProduit = $this->bdd->prepare("DELETE FROM produit WHERE id_produit = ?");
            $reqProduit->execute([$id_produit]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur lors de la suppression de la equipement : " . $e->getMessage());
        }
    }
}
