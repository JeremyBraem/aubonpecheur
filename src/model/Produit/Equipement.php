<?php
require_once 'src/config/connectBdd.php';

class Equipement
{
    private $id_equipement;
    private $nom_equipement;
    private $detail_equipement;
    private $description_equipement;
    private $promo_equipement;
    private $stock_equipement;
    private $hors_stock_equipement;
    private $id_categorie;
    private $id_type_equipement;
    private $id_marque;

    public function createToInsertEquipement($equipementForm): bool
    {

        if (!isset($equipementForm['nom_equipement']) or $equipementForm['nom_equipement'] == '') 
        {
            return false;
        }

        if (!isset($equipementForm['detail_equipement']) or $equipementForm['detail_equipement'] == '') 
        {
            return false;
        }

        if (!isset($equipementForm['description_equipement']) or $equipementForm['description_equipement'] == '') 
        {
            return false;
        }

        if (!isset($equipementForm['promo_equipement']) or $equipementForm['promo_equipement'] == '') 
        {
            return false;
        }

        if (!isset($equipementForm['stock_equipement']) or $equipementForm['stock_equipement'] == '') 
        {
            return false;
        }

        if (!isset($equipementForm['hors_stock_equipement']) or $equipementForm['hors_stock_equipement'] == '') 
        {
            return false;
        }

        if (!isset($equipementForm['categorie_equipement']) or $equipementForm['categorie_equipement'] == '') 
        {
            return false;
        }

        if (!isset($equipementForm['type_equipement']) or $equipementForm['type_equipement'] == '') 
        {
            return false;
        }

        if (!isset($equipementForm['marque_equipement']) or $equipementForm['marque_equipement'] == '') 
        {
            return false;
        }

        $this->nom_equipement = $equipementForm['nom_equipement'];
        $this->detail_equipement = $equipementForm['detail_equipement'];
        $this->description_equipement = $equipementForm['description_equipement'];
        $this->promo_equipement = $equipementForm['promo_equipement'];
        $this->stock_equipement = $equipementForm['stock_equipement'];
        $this->hors_stock_equipement = $equipementForm['hors_stock_equipement'];
        $this->id_categorie = $equipementForm['categorie_equipement'];
        $this->id_type_equipement = $equipementForm['type_equipement'];
        $this->id_marque = $equipementForm['marque_equipement'];

        return true;
    }

    public function getIdEquipement(): int
    {
        return $this->id_equipement;
    }

    public function setIdEquipement($id_equipement): void
    {
        $this->id_equipement = $id_equipement;
    }


    public function getNomEquipement(): string
    {
        return $this->nom_equipement;
    }

    public function setNomEquipement($nom_equipement): void
    {
        $this->nom_equipement = $nom_equipement;
    }

    public function getDetailEquipement(): string
    {
        return $this->detail_equipement;
    }

    public function setDetailEquipement($detail_equipement): void
    {
        $this->detail_equipement = $detail_equipement;
    }

    public function getDescriptionEquipement(): string
    {
        return $this->description_equipement;
    }

    public function setDescriptionEquipement($description_equipement): void
    {
        $this->description_equipement = $description_equipement;
    }

    public function getPromoEquipement(): int
    {
        return $this->promo_equipement;
    }

    public function setPromoEquipement($promo_equipement): void
    {
        $this->promo_equipement = $promo_equipement;
    }

    public function getStockEquipement(): int
    {
        return $this->stock_equipement;
    }

    public function setStockEquipement($stock_equipement): void
    {
        $this->stock_equipement = $stock_equipement;
    }

    public function getHorsStockEquipement(): int
    {
        return $this->hors_stock_equipement;
    }

    public function setHorsStockEquipement($hors_stock_equipement): void
    {
        $this->hors_stock_equipement = $hors_stock_equipement;
    }

    public function getCategorieEquipement(): string
    {
        return $this->id_categorie;
    }

    public function setCategorieEquipement($id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

    public function getTypeEquipement(): string
    {
        return $this->id_type_equipement;
    }

    public function setTypeEquipement($id_type_equipement): void
    {
        $this->id_type_equipement = $id_type_equipement;
    }

    public function getMarqueEquipement(): string
    {
        return $this->id_marque;
    }

    public function setMarqueEquipement($id_marque): void
    {
        $this->id_marque = $id_marque;
    }
}

class EquipementRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertEquipement(Equipement $equipement)
    {
        $req = $this->bdd->prepare("INSERT INTO equipement (nom_equipement, detail_equipement, description_equipement, promo_equipement, stock_equipement, hors_stock_equipement, id_categorie, id_type_equipement, id_marque)
        VALUES (?,?,?,?,?,?,?,?,?)");

        $req->execute
        ([
            $equipement->getNomEquipement(),
            $equipement->getDetailEquipement(),
            $equipement->getDescriptionEquipement(),
            $equipement->getPromoEquipement(),
            $equipement->getStockEquipement(),
            $equipement->getHorsStockEquipement(),
            $equipement->getCategorieEquipement(),
            $equipement->getTypeEquipement(),
            $equipement->getMarqueEquipement()
        ]);
        
        return $equipement;
    }

    public function getAllEquipement()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_equipement.*, marque.*
        FROM equipement
        INNER JOIN categorie ON equipement.id_categorie = categorie.id_categorie
        INNER JOIN type_equipement ON equipement.id_type_equipement = type_equipement.id_type_equipement
        INNER JOIN marque ON equipement.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $equipements = [];

        foreach ($datas as $data) 
        {
            $equipement = new Equipement();
            $equipement->setIdEquipement($data['id_equipement']);
            $equipement->setNomEquipement($data['nom_equipement']);
            $equipement->setDetailEquipement($data['detail_equipement']);
            $equipement->setDescriptionEquipement($data['description_equipement']);
            $equipement->setPromoEquipement($data['promo_equipement']);
            $equipement->setStockEquipement($data['stock_equipement']);
            $equipement->setHorsStockEquipement($data['hors_stock_equipement']);
            $equipement->setCategorieEquipement($data['nom_categorie']);
            $equipement->setTypeEquipement($data['nom_type_equipement']);
            $equipement->setMarqueEquipement($data['nom_marque']);

            $equipements[] = $equipement;
        }
        return $equipements;
    }

    public function getLastEquipement()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_equipement.*, marque.*
        FROM equipement
        INNER JOIN categorie ON equipement.id_categorie = categorie.id_categorie
        INNER JOIN type_equipement ON equipement.id_type_equipement = type_equipement.id_type_equipement
        INNER JOIN marque ON equipement.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $equipements = [];

        foreach ($datas as $data) 
        {
            $equipement = new Equipement();
            $equipement->setIdEquipement($data['id_equipement']);
            $equipement->setNomEquipement($data['nom_equipement']);
            $equipement->setDetailEquipement($data['detail_equipement']);
            $equipement->setDescriptionEquipement($data['description_equipement']);
            $equipement->setPromoEquipement($data['promo_equipement']);
            $equipement->setStockEquipement($data['stock_equipement']);
            $equipement->setHorsStockEquipement($data['hors_stock_equipement']);
            $equipement->setCategorieEquipement($data['nom_categorie']);
            $equipement->setTypeEquipement($data['nom_type_equipement']);
            $equipement->setMarqueEquipement($data['nom_marque']);

            $equipements[] = $equipement;
        }
        return $equipements;
    }

    public function deleteEquipement($id_equipement):bool
    {
        try 
        {
            
            $imageEquipementRepo = new ImageEquipementRepository;
            $oldImg = $imageEquipementRepo->getImageByEquipement($_POST['id_equipement']);
           
            $cheminFichier = $oldImg->getNomImageEquipement();

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
            $imageEquipementRepo->deleteImageByEquipement($id_equipement);

            $req = $this->bdd->prepare('DELETE FROM equipement WHERE id_equipement = ?');
            $req->execute([$id_equipement]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function updateEquipement($id_equipement, $nom_equipement, $detail_equipement, $description_equipement, $promo_equipement, $stock_equipement, $hors_stock_equipement, $id_categorie, $id_type_equipement, $id_marque)
    {
        try 
        {
            
            $req = $this->bdd->prepare("UPDATE equipement SET nom_equipement = ?, detail_equipement = ?, description_equipement = ?, promo_equipement = ?, stock_equipement = ?, hors_stock_equipement = ?, id_categorie = ?, id_type_equipement = ?, id_marque = ? WHERE id_equipement = ?");
            $req->execute([$nom_equipement, $detail_equipement, $description_equipement, $promo_equipement, $stock_equipement, $hors_stock_equipement, $id_categorie, $id_type_equipement, $id_marque, $id_equipement]);
            
            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function getLastInsertId()
    {
        $query = "SELECT MAX(id_equipement) AS last_id FROM equipement";
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


