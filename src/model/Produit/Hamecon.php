<?php
require_once 'src/config/connectBdd.php';

class Hamecon
{
    private $id_hamecon;
    private $nom_hamecon;
    private $poids_hamecon;
    private $longueur_hamecon;
    private $description_hamecon;
    private $promo_hamecon;
    private $stock_hamecon;
    private $hors_stock_hamecon;
    private $id_categorie;
    private $id_type_hamecon;
    private $id_marque;

    public function createToInsertHamecon($hameconForm): bool
    {

        if (!isset($hameconForm['nom_hamecon']) or $hameconForm['nom_hamecon'] == '') 
        {
            return false;
        }

        if (!isset($hameconForm['poids_hamecon']) or $hameconForm['poids_hamecon'] == '') 
        {
            return false;
        }

        if (!isset($hameconForm['longueur_hamecon']) or $hameconForm['longueur_hamecon'] == '') 
        {
            return false;
        }

        if (!isset($hameconForm['description_hamecon']) or $hameconForm['description_hamecon'] == '') 
        {
            return false;
        }

        if (!isset($hameconForm['promo_hamecon']) or $hameconForm['promo_hamecon'] == '') 
        {
            return false;
        }

        if (!isset($hameconForm['stock_hamecon']) or $hameconForm['stock_hamecon'] == '') 
        {
            return false;
        }

        if (!isset($hameconForm['hors_stock_hamecon']) or $hameconForm['hors_stock_hamecon'] == '') 
        {
            return false;
        }

        if (!isset($hameconForm['categorie_hamecon']) or $hameconForm['categorie_hamecon'] == '') 
        {
            return false;
        }

        if (!isset($hameconForm['type_hamecon']) or $hameconForm['type_hamecon'] == '') 
        {
            return false;
        }

        if (!isset($hameconForm['marque_hamecon']) or $hameconForm['marque_hamecon'] == '') 
        {
            return false;
        }

        $this->nom_hamecon = $hameconForm['nom_hamecon'];
        $this->poids_hamecon = $hameconForm['poids_hamecon'];
        $this->longueur_hamecon = $hameconForm['longueur_hamecon'];
        $this->description_hamecon = $hameconForm['description_hamecon'];
        $this->promo_hamecon = $hameconForm['promo_hamecon'];
        $this->stock_hamecon = $hameconForm['stock_hamecon'];
        $this->hors_stock_hamecon = $hameconForm['hors_stock_hamecon'];
        $this->id_categorie = $hameconForm['categorie_hamecon'];
        $this->id_type_hamecon = $hameconForm['type_hamecon'];
        $this->id_marque = $hameconForm['marque_hamecon'];

        return true;
    }

    public function getIdHamecon(): int
    {
        return $this->id_hamecon;
    }

    public function setIdHamecon($id_hamecon): void
    {
        $this->id_hamecon = $id_hamecon;
    }


    public function getNomHamecon(): string
    {
        return $this->nom_hamecon;
    }

    public function setNomHamecon($nom_hamecon): void
    {
        $this->nom_hamecon = $nom_hamecon;
    }

    public function getPoidsHamecon(): string
    {
        return $this->poids_hamecon;
    }

    public function setPoidsHamecon($poids_hamecon): void
    {
        $this->poids_hamecon = $poids_hamecon;
    }

    public function getLongueurHamecon(): string
    {
        return $this->longueur_hamecon;
    }

    public function setLongueurHamecon($longueur_hamecon): void
    {
        $this->longueur_hamecon = $longueur_hamecon;
    }

    public function getDescriptionHamecon(): string
    {
        return $this->description_hamecon;
    }

    public function setDescriptionHamecon($description_hamecon): void
    {
        $this->description_hamecon = $description_hamecon;
    }

    public function getPromoHamecon(): int
    {
        return $this->promo_hamecon;
    }

    public function setPromoHamecon($promo_hamecon): void
    {
        $this->promo_hamecon = $promo_hamecon;
    }

    public function getStockHamecon(): int
    {
        return $this->stock_hamecon;
    }

    public function setStockHamecon($stock_hamecon): void
    {
        $this->stock_hamecon = $stock_hamecon;
    }

    public function getHorsStockHamecon(): int
    {
        return $this->hors_stock_hamecon;
    }

    public function setHorsStockHamecon($hors_stock_hamecon): void
    {
        $this->hors_stock_hamecon = $hors_stock_hamecon;
    }

    public function getCategorieHamecon(): string
    {
        return $this->id_categorie;
    }

    public function setCategorieHamecon($id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

    public function getTypeHamecon(): string
    {
        return $this->id_type_hamecon;
    }

    public function setTypeHamecon($id_type_hamecon): void
    {
        $this->id_type_hamecon = $id_type_hamecon;
    }

    public function getMarqueHamecon(): string
    {
        return $this->id_marque;
    }

    public function setMarqueHamecon($id_marque): void
    {
        $this->id_marque = $id_marque;
    }
}

class HameconRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertHamecon(Hamecon $hamecon)
    {
        $req = $this->bdd->prepare("INSERT INTO hamecon (nom_hamecon, poids_hamecon, longueur_hamecon, description_hamecon, promo_hamecon, stock_hamecon, hors_stock_hamecon, id_categorie, id_type_hamecon, id_marque)
        VALUES (?,?,?,?,?,?,?,?,?,?)");

        $req->execute([
            $hamecon->getNomHamecon(),
            $hamecon->getPoidsHamecon(),
            $hamecon->getLongueurHamecon(),
            $hamecon->getDescriptionHamecon(),
            $hamecon->getPromoHamecon(),
            $hamecon->getStockHamecon(),
            $hamecon->getHorsStockHamecon(),
            $hamecon->getCategorieHamecon(),
            $hamecon->getTypeHamecon(),
            $hamecon->getMarqueHamecon()
        ]);
        
        return $hamecon;
    }

    public function getAllHamecon()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_hamecon.*, marque.*
        FROM hamecon
        INNER JOIN categorie ON hamecon.id_categorie = categorie.id_categorie
        INNER JOIN type_hamecon ON hamecon.id_type_hamecon = type_hamecon.id_type_hamecon
        INNER JOIN marque ON hamecon.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $hamecons = [];

        foreach ($datas as $data) 
        {
            $hamecon = new Hamecon();
            $hamecon->setIdHamecon($data['id_hamecon']);
            $hamecon->setNomHamecon($data['nom_hamecon']);
            $hamecon->setPoidsHamecon($data['poids_hamecon']);
            $hamecon->setLongueurHamecon($data['longueur_hamecon']);
            $hamecon->setDescriptionHamecon($data['description_hamecon']);
            $hamecon->setPromoHamecon($data['promo_hamecon']);
            $hamecon->setStockHamecon($data['stock_hamecon']);
            $hamecon->setHorsStockHamecon($data['hors_stock_hamecon']);
            $hamecon->setCategorieHamecon($data['nom_categorie']);
            $hamecon->setTypeHamecon($data['nom_type_hamecon']);
            $hamecon->setMarqueHamecon($data['nom_marque']);

            $hamecons[] = $hamecon;
        }
        return $hamecons;
    }

    public function deleteHamecon($id_hamecon):bool
    {
        try 
        {
            
            $imageHameconRepo = new ImageHameconRepository;
            $oldImg = $imageHameconRepo->getImageByHamecon($_POST['id_hamecon']);
           
            $cheminFichier = $oldImg->getNomImageHamecon();

            if (file_exists($cheminFichier)) 
            {
                if (unlink($cheminFichier)) 
                {
                    echo "Le fichier a été supprimé avec succès.";
                } 
                else 
                {
                    echo "Une erreur s'est produite lors de la suppression du fichier.";
                }
            } 
            else 
            {
                echo "Le fichier spécifié n'existe pas.";
            }
            $imageHameconRepo->deleteImageByHamecon($id_hamecon);

            $req = $this->bdd->prepare('DELETE FROM hamecon WHERE id_hamecon = ?');
            $req->execute([$id_hamecon]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function updateHamecon($id_hamecon, $nom_hamecon, $poids_hamecon, $longueur_hamecon, $description_hamecon, $promo_hamecon, $stock_hamecon, $hors_stock_hamecon, $id_categorie, $id_type_hamecon, $id_marque)
    {
        try 
        {
            
            $req = $this->bdd->prepare("UPDATE hamecon SET nom_hamecon = ?, poids_hamecon = ?, longueur_hamecon = ?, description_hamecon = ?, promo_hamecon = ?, stock_hamecon = ?, hors_stock_hamecon = ?, id_categorie = ?, id_type_hamecon = ?, id_marque = ? WHERE id_hamecon = ?");
            $req->execute([$nom_hamecon, $poids_hamecon, $longueur_hamecon, $description_hamecon, $promo_hamecon, $stock_hamecon, $hors_stock_hamecon, $id_categorie, $id_type_hamecon, $id_marque, $id_hamecon]);
            
            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function getLastInsertId()
    {
        $query = "SELECT MAX(id_hamecon) AS last_id FROM hamecon";
        $result = $this->bdd->prepare($query);

        if ($result->execute()) { // Exécutez la requête ici
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $lastId = $row['last_id'];

            return $lastId;
        } else {
            // Gérez l'erreur de la requête
            // Retournez une valeur par défaut ou lancez une exception, selon vos besoins
        }
        
    }
}


