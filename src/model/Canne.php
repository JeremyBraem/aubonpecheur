<?php 
require_once 'src/model/Produit.php';
require_once 'src/config/connectBdd.php';

class Canne extends Produit
{
    private $longueur_canne;
    private $poids_canne;
    private $id_type_canne;

    public function __construct($nom_produit, $description_produit, $prix_produit, $stock_produit, $promo_produit, $prix_promo_produit, $id_categorie, $id_marque, $id_genre, $longueur_canne, $poids_canne, $id_type_canne)
    {
        parent::__construct($nom_produit, $description_produit, $prix_produit, $stock_produit, $promo_produit, $prix_promo_produit, $id_categorie, $id_marque, $id_genre);
        $this->longueur_canne = $longueur_canne;
        $this->poids_canne = $poids_canne;
        $this->id_type_canne = $id_type_canne;
    }

    public function getLongueurCanne(): float
    {
        return $this->longueur_canne;
    }

    public function setLongueurCanne($longueur_canne): void
    {
        $this->longueur_canne = $longueur_canne;
    }

    public function getPoidsCanne(): float
    {
        return $this->poids_canne;
    }

    public function setPoidsCanne($poids_canne): void
    {
        $this->poids_canne = $poids_canne;
    }

    public function getTypeCanne(): int
    {
        return $this->id_type_canne;
    }

    public function setTypeCanne($id_type_canne): void
    {
        $this->id_type_canne = $id_type_canne;
    }
}

class CanneRepository extends ConnectBdd
{
    function addCanne(Canne $canne)
    {
        try
        {
            $req = $this->bdd->prepare("INSERT INTO produit (nom_produit, description_produit, prix_produit, promo_produit, prix_promo_produit, stock_produit, id_categorie, id_marque, id_genre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $req->execute
            ([
                $canne->getNomProduit(),
                $canne->getDescriptionProduit(),
                $canne->getPrixProduit(),
                $canne->getPromoProduit(),
                $canne->getPrixPromoProduit(),
                $canne->getStockProduit(),
                $canne->getCategorieProduit(),
                $canne->getMarqueProduit(),
                $canne->getGenreProduit(),
            ]);

            $produitRepo = new ProduitRepository;
            $nouvelArticleId = $produitRepo->getLastInsertId();

            $reqCanne = $this->bdd->prepare("INSERT INTO caracteristiques_canne (longueur_canne, poids_canne, id_produit, id_type_canne) VALUES (?, ?, ?, ?)");

            $reqCanne->execute
            ([
                $canne->getLongueurCanne(),
                $canne->getPoidsCanne(),
                $nouvelArticleId,
                $canne->getTypeCanne(),
            ]);

          

            foreach ($canne->getImages() as $image)
            {
                $reqImage = $this->bdd->prepare("INSERT INTO image (nom_image, description_image) VALUES (?, ?)");
                $reqImage->execute([
                    $image->getNomImage(),
                    $image->getDescriptionImage(),
                ]);
    
                $nouvelleImageId = $this->getLastInsertId();
    
                $reqImageProduit = $this->bdd->prepare("INSERT INTO image_produit (id_image, id_produit) VALUES (?, ?)");
                $reqImageProduit->execute([$nouvelleImageId, $nouvelArticleId]);
            }

            echo "La canne a été ajoutée avec succès à la base de données !";
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de l'ajout de la canne à la base de données: " . $e->getMessage());
        }
    }

    public function updateCanne(Canne $canne)
    {
        try 
        {
            $req = $this->bdd->prepare("UPDATE produit SET nom_produit=?, description_produit=?, prix_produit=?, promo_produit=?, prix_promo_produit=?, stock_produit=?, id_categorie=?, id_marque=?, id_genre=? WHERE id_produit=?");

            $req->execute
            ([
                $canne->getNomProduit(),
                $canne->getDescriptionProduit(),
                $canne->getPrixProduit(),
                $canne->getPromoProduit(),
                $canne->getPrixPromoProduit(),
                $canne->getStockProduit(),
                $canne->getCategorieProduit(),
                $canne->getMarqueProduit(),
                $canne->getGenreProduit(),
                $canne->getIdProduit(),
            ]);
         
            $reqCanne = $this->bdd->prepare("UPDATE caracteristiques_canne SET longueur_canne=?, poids_canne=?, id_type_canne=? WHERE id_produit=?");
            
            $reqCanne->execute
            ([
                $canne->getLongueurCanne(),
                $canne->getPoidsCanne(),
                $canne->getTypeCanne(),
                $canne->getIdProduit(),
            ]);

            
            foreach ($canne->getImages() as $image) 
            {
                $reqImage = $this->bdd->prepare("INSERT INTO image (nom_image, description_image) VALUES (?, ?)");
                $reqImage->execute
                ([
                    $image->getNomImage(),
                    $image->getDescriptionImage(),
                ]);

                $nouvelleImageId = $this->getLastInsertId();

                $reqImageProduit = $this->bdd->prepare("INSERT INTO image_produit (id_image, id_produit) VALUES (?, ?)");
                $reqImageProduit->execute([$nouvelleImageId, $canne->getIdProduit()]);
            }

            echo "La canne a été mise à jour avec succès dans la base de données !";
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la mise à jour de la canne dans la base de données: " . $e->getMessage());
        }
    }

    public function deleteCanne($id_produit)
    {
        try 
        {
            $reqCaracteristiques = $this->bdd->prepare("DELETE FROM caracteristiques_canne WHERE id_produit = ?");
            $reqCaracteristiques->execute([$id_produit]);
           
            echo "La canne a été supprimée avec succès de la base de données !";
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la suppression de la canne de la base de données: " . $e->getMessage());
        }
    }
    
}
