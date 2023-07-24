<?php 
require_once 'src/model/Produit.php';
require_once 'src/config/connectBdd.php';

class Hamecon extends Produit
{
    private $longueur_hamecon;
    private $poids_hamecon;
    private $id_type_hamecon;

    public function __construct($nom_produit, $description_produit, $prix_produit, $stock_produit, $promo_produit, $prix_promo_produit, $id_categorie, $id_marque, $id_genre, $longueur_hamecon, $poids_hamecon, $id_type_hamecon)
    {
        parent::__construct($nom_produit, $description_produit, $prix_produit, $stock_produit, $promo_produit, $prix_promo_produit, $id_categorie, $id_marque, $id_genre);
        $this->longueur_hamecon = $longueur_hamecon;
        $this->poids_hamecon = $poids_hamecon;
        $this->id_type_hamecon = $id_type_hamecon;
    }

    public function getLongueurHamecon(): float
    {
        return $this->longueur_hamecon;
    }

    public function setLongueurHamecon($longueur_hamecon): void
    {
        $this->longueur_hamecon = $longueur_hamecon;
    }

    public function getPoidsHamecon(): float
    {
        return $this->poids_hamecon;
    }

    public function setPoidsHamecon($poids_hamecon): void
    {
        $this->poids_hamecon = $poids_hamecon;
    }

    public function getTypeHamecon(): int
    {
        return $this->id_type_hamecon;
    }

    public function setTypeHamecon($id_type_hamecon): void
    {
        $this->id_type_hamecon = $id_type_hamecon;
    }
}

class HameconRepository extends ConnectBdd
{
    function addHamecon(Hamecon $hamecon)
    {
        try
        {
            $req = $this->bdd->prepare("INSERT INTO produit (nom_produit, description_produit, prix_produit, promo_produit, prix_promo_produit, stock_produit, id_categorie, id_marque, id_genre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $req->execute
            ([
                $hamecon->getNomProduit(),
                $hamecon->getDescriptionProduit(),
                $hamecon->getPrixProduit(),
                $hamecon->getPromoProduit(),
                $hamecon->getPrixPromoProduit(),
                $hamecon->getStockProduit(),
                $hamecon->getCategorieProduit(),
                $hamecon->getMarqueProduit(),
                $hamecon->getGenreProduit(),
            ]);

            $produitRepo = new ProduitRepository;
            $nouvelArticleId = $produitRepo->getLastInsertId();

            $reqHamecon = $this->bdd->prepare("INSERT INTO caracteristiques_hamecon (longueur_hamecon, poids_hamecon, id_produit, id_type_hamecon) VALUES (?, ?, ?, ?)");

            $reqHamecon->execute
            ([
                $hamecon->getLongueurHamecon(),
                $hamecon->getPoidsHamecon(),
                $nouvelArticleId,
                $hamecon->getTypeHamecon(),
            ]);

          

            foreach ($hamecon->getImages() as $image)
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

            echo "La hamecon a été ajoutée avec succès à la base de données !";
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de l'ajout de la hamecon à la base de données: " . $e->getMessage());
        }
    }

    public function updateHamecon(Hamecon $hamecon)
    {
        try 
        {
            $req = $this->bdd->prepare("UPDATE produit SET nom_produit=?, description_produit=?, prix_produit=?, promo_produit=?, prix_promo_produit=?, stock_produit=?, id_categorie=?, id_marque=?, id_genre=? WHERE id_produit=?");

            $req->execute
            ([
                $hamecon->getNomProduit(),
                $hamecon->getDescriptionProduit(),
                $hamecon->getPrixProduit(),
                $hamecon->getPromoProduit(),
                $hamecon->getPrixPromoProduit(),
                $hamecon->getStockProduit(),
                $hamecon->getCategorieProduit(),
                $hamecon->getMarqueProduit(),
                $hamecon->getGenreProduit(),
                $hamecon->getIdProduit(),
            ]);
         
            $reqHamecon = $this->bdd->prepare("UPDATE caracteristiques_hamecon SET longueur_hamecon=?, poids_hamecon=?, id_type_hamecon=? WHERE id_produit=?");
            
            $reqHamecon->execute
            ([
                $hamecon->getLongueurHamecon(),
                $hamecon->getPoidsHamecon(),
                $hamecon->getTypeHamecon(),
                $hamecon->getIdProduit(),
            ]);

            
            foreach ($hamecon->getImages() as $image) 
            {
                $reqImage = $this->bdd->prepare("INSERT INTO image (nom_image, description_image) VALUES (?, ?)");
                $reqImage->execute
                ([
                    $image->getNomImage(),
                    $image->getDescriptionImage(),
                ]);

                $nouvelleImageId = $this->getLastInsertId();

                $reqImageProduit = $this->bdd->prepare("INSERT INTO image_produit (id_image, id_produit) VALUES (?, ?)");
                $reqImageProduit->execute([$nouvelleImageId, $hamecon->getIdProduit()]);
            }

            echo "La hamecon a été mise à jour avec succès dans la base de données !";
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la mise à jour de la hamecon dans la base de données: " . $e->getMessage());
        }
    }

    public function deleteHamecon($id_produit)
    {
        try 
        {
            $reqCaracteristiques = $this->bdd->prepare("DELETE FROM caracteristiques_hamecon WHERE id_produit = ?");
            $reqCaracteristiques->execute([$id_produit]);
           
            echo "La hamecon a été supprimée avec succès de la base de données !";
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la suppression de la hamecon de la base de données: " . $e->getMessage());
        }
    }

    public function getLastInsertId()
    {
        $query = "SELECT MAX(id_hamecon) AS last_id FROM caracteristique_hamecon";
        $result = $this->bdd->prepare($query);

        if ($result->execute()) 
        {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $lastId = $row['last_id'];

            return $lastId;
        }
    }

    public function getAllHamecon()
    {
        $req = $this->bdd->prepare("SELECT * FROM produit WHERE id_genre = ?");
        $req->execute([1]);

        $produitHamecon = $req->fetchAll(PDO::FETCH_ASSOC);

        return $produitHamecon;
    }

    public function getInfoHamecon($id_produit)
    {
        $req = $this->bdd->prepare("SELECT caracteristiques_hamecon.*, type_hamecon.nom_type_hamecon as type
        FROM caracteristiques_hamecon 
        INNER JOIN type_hamecon ON type_hamecon.id_type_hamecon = caracteristiques_hamecon.id_type_hamecon
        WHERE id_produit = ?");
        $req->execute([$id_produit]);

        $hamecon = $req->fetchAll(PDO::FETCH_ASSOC);

        return $hamecon;
    }
}
