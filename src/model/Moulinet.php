<?php 
require_once 'src/model/Produit.php';
require_once 'src/config/connectBdd.php';

class Moulinet extends Produit
{
    private $ratio_moulinet;
    private $poids_moulinet;
    private $id_type_moulinet;

    public function __construct($nom_produit, $description_produit, $prix_produit, $stock_produit, $promo_produit, $prix_promo_produit, $id_categorie, $id_marque, $id_genre, $ratio_moulinet, $poids_moulinet, $id_type_moulinet)
    {
        parent::__construct($nom_produit, $description_produit, $prix_produit, $stock_produit, $promo_produit, $prix_promo_produit, $id_categorie, $id_marque, $id_genre);
        $this->ratio_moulinet = $ratio_moulinet;
        $this->poids_moulinet = $poids_moulinet;
        $this->id_type_moulinet = $id_type_moulinet;
    }

    public function getLongueurMoulinet(): float
    {
        return $this->ratio_moulinet;
    }

    public function setLongueurMoulinet($ratio_moulinet): void
    {
        $this->ratio_moulinet = $ratio_moulinet;
    }

    public function getPoidsMoulinet(): float
    {
        return $this->poids_moulinet;
    }

    public function setPoidsMoulinet($poids_moulinet): void
    {
        $this->poids_moulinet = $poids_moulinet;
    }

    public function getTypeMoulinet(): int
    {
        return $this->id_type_moulinet;
    }

    public function setTypeMoulinet($id_type_moulinet): void
    {
        $this->id_type_moulinet = $id_type_moulinet;
    }
}

class MoulinetRepository extends ConnectBdd
{
    function addMoulinet(Moulinet $moulinet)
    {
        try
        {
            $req = $this->bdd->prepare("INSERT INTO produit (nom_produit, description_produit, prix_produit, promo_produit, prix_promo_produit, stock_produit, id_categorie, id_marque, id_genre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $req->execute
            ([
                $moulinet->getNomProduit(),
                $moulinet->getDescriptionProduit(),
                $moulinet->getPrixProduit(),
                $moulinet->getPromoProduit(),
                $moulinet->getPrixPromoProduit(),
                $moulinet->getStockProduit(),
                $moulinet->getCategorieProduit(),
                $moulinet->getMarqueProduit(),
                $moulinet->getGenreProduit(),
            ]);

            $produitRepo = new ProduitRepository;
            $nouvelArticleId = $produitRepo->getLastInsertId();

            $reqMoulinet = $this->bdd->prepare("INSERT INTO caracteristiques_moulinet (ratio_moulinet, poids_moulinet, id_produit, id_type_moulinet) VALUES (?, ?, ?, ?)");

            $reqMoulinet->execute
            ([
                $moulinet->getLongueurMoulinet(),
                $moulinet->getPoidsMoulinet(),
                $nouvelArticleId,
                $moulinet->getTypeMoulinet(),
            ]);

          

            foreach ($moulinet->getImages() as $image)
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

            echo "La moulinet a été ajoutée avec succès à la base de données !";
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de l'ajout de la moulinet à la base de données: " . $e->getMessage());
        }
    }

    public function updateMoulinet(Moulinet $moulinet)
    {
        try 
        {
            $req = $this->bdd->prepare("UPDATE produit SET nom_produit=?, description_produit=?, prix_produit=?, promo_produit=?, prix_promo_produit=?, stock_produit=?, id_categorie=?, id_marque=?, id_genre=? WHERE id_produit=?");

            $req->execute
            ([
                $moulinet->getNomProduit(),
                $moulinet->getDescriptionProduit(),
                $moulinet->getPrixProduit(),
                $moulinet->getPromoProduit(),
                $moulinet->getPrixPromoProduit(),
                $moulinet->getStockProduit(),
                $moulinet->getCategorieProduit(),
                $moulinet->getMarqueProduit(),
                $moulinet->getGenreProduit(),
                $moulinet->getIdProduit(),
            ]);
         
            $reqMoulinet = $this->bdd->prepare("UPDATE caracteristiques_moulinet SET ratio_moulinet=?, poids_moulinet=?, id_type_moulinet=? WHERE id_produit=?");
            
            $reqMoulinet->execute
            ([
                $moulinet->getLongueurMoulinet(),
                $moulinet->getPoidsMoulinet(),
                $moulinet->getTypeMoulinet(),
                $moulinet->getIdProduit(),
            ]);

            
            foreach ($moulinet->getImages() as $image) 
            {
                $reqImage = $this->bdd->prepare("INSERT INTO image (nom_image, description_image) VALUES (?, ?)");
                $reqImage->execute
                ([
                    $image->getNomImage(),
                    $image->getDescriptionImage(),
                ]);

                $nouvelleImageId = $this->getLastInsertId();

                $reqImageProduit = $this->bdd->prepare("INSERT INTO image_produit (id_image, id_produit) VALUES (?, ?)");
                $reqImageProduit->execute([$nouvelleImageId, $moulinet->getIdProduit()]);
            }

            echo "La moulinet a été mise à jour avec succès dans la base de données !";
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la mise à jour de la moulinet dans la base de données: " . $e->getMessage());
        }
    }

    public function deleteMoulinet($id_produit)
    {
        try 
        {
            $reqCaracteristiques = $this->bdd->prepare("DELETE FROM caracteristiques_moulinet WHERE id_produit = ?");
            $reqCaracteristiques->execute([$id_produit]);
           
            echo "La moulinet a été supprimée avec succès de la base de données !";
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la suppression de la moulinet de la base de données: " . $e->getMessage());
        }
    }

    public function getLastInsertId()
    {
        $query = "SELECT MAX(id_moulinet) AS last_id FROM caracteristique_moulinet";
        $result = $this->bdd->prepare($query);

        if ($result->execute()) 
        {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $lastId = $row['last_id'];

            return $lastId;
        }
    }

    public function getAllMoulinet()
    {
        $req = $this->bdd->prepare("SELECT * FROM produit WHERE id_genre = ?");
        $req->execute([1]);

        $produitMoulinet = $req->fetchAll(PDO::FETCH_ASSOC);

        return $produitMoulinet;
    }

    public function getInfoMoulinet($id_produit)
    {
        $req = $this->bdd->prepare("SELECT * FROM caracteristiques_moulinet WHERE id_produit = ?");
        $req->execute([$id_produit]);

        $moulinet = $req->fetchAll(PDO::FETCH_ASSOC);

        return $moulinet;
    }
    
}
