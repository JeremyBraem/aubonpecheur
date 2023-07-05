<?php
require_once 'src/config/connectBdd.php';

class Feeder
{
    private $id_feeder;
    private $nom_feeder;
    private $poids_feeder;
    private $longueur_feeder;
    private $diametre_feeder;
    private $description_feeder;
    private $promo_feeder;
    private $stock_feeder;
    private $hors_stock_feeder;
    private $id_categorie;
    private $id_type_feeder;
    private $id_marque;

    public function createToInsertFeeder($feederForm): bool
    {

        if (!isset($feederForm['nom_feeder']) or $feederForm['nom_feeder'] == '') 
        {
            return false;
        }

        if (!isset($feederForm['poids_feeder']) or $feederForm['poids_feeder'] == '') 
        {
            return false;
        }

        if (!isset($feederForm['longueur_feeder']) or $feederForm['longueur_feeder'] == '') 
        {
            return false;
        }

        if (!isset($feederForm['diametre_feeder']) or $feederForm['diametre_feeder'] == '') 
        {
            return false;
        }

        if (!isset($feederForm['description_feeder']) or $feederForm['description_feeder'] == '') 
        {
            return false;
        }

        if (!isset($feederForm['promo_feeder']) or $feederForm['promo_feeder'] == '') 
        {
            return false;
        }

        if (!isset($feederForm['stock_feeder']) or $feederForm['stock_feeder'] == '') 
        {
            return false;
        }

        if (!isset($feederForm['hors_stock_feeder']) or $feederForm['hors_stock_feeder'] == '') 
        {
            return false;
        }

        if (!isset($feederForm['categorie_feeder']) or $feederForm['categorie_feeder'] == '') 
        {
            return false;
        }

        if (!isset($feederForm['type_feeder']) or $feederForm['type_feeder'] == '') 
        {
            return false;
        }

        if (!isset($feederForm['marque_feeder']) or $feederForm['marque_feeder'] == '') 
        {
            return false;
        }

        $this->nom_feeder = $feederForm['nom_feeder'];
        $this->poids_feeder = $feederForm['poids_feeder'];
        $this->longueur_feeder = $feederForm['longueur_feeder'];
        $this->diametre_feeder = $feederForm['diametre_feeder'];
        $this->description_feeder = $feederForm['description_feeder'];
        $this->promo_feeder = $feederForm['promo_feeder'];
        $this->stock_feeder = $feederForm['stock_feeder'];
        $this->hors_stock_feeder = $feederForm['hors_stock_feeder'];
        $this->id_categorie = $feederForm['categorie_feeder'];
        $this->id_type_feeder = $feederForm['type_feeder'];
        $this->id_marque = $feederForm['marque_feeder'];

        return true;
    }

    public function getIdFeeder(): int
    {
        return $this->id_feeder;
    }

    public function setIdFeeder($id_feeder): void
    {
        $this->id_feeder = $id_feeder;
    }


    public function getNomFeeder(): string
    {
        return $this->nom_feeder;
    }

    public function setNomFeeder($nom_feeder): void
    {
        $this->nom_feeder = $nom_feeder;
    }

    public function getPoidsFeeder(): string
    {
        return $this->poids_feeder;
    }

    public function setPoidsFeeder($poids_feeder): void
    {
        $this->poids_feeder = $poids_feeder;
    }

    public function getLongueurFeeder(): string
    {
        return $this->longueur_feeder;
    }

    public function setLongueurFeeder($longueur_feeder): void
    {
        $this->longueur_feeder = $longueur_feeder;
    }

    public function getDiametreFeeder(): string
    {
        return $this->diametre_feeder;
    }

    public function setDiametreFeeder($diametre_feeder): void
    {
        $this->diametre_feeder = $diametre_feeder;
    }

    public function getDescriptionFeeder(): string
    {
        return $this->description_feeder;
    }

    public function setDescriptionFeeder($description_feeder): void
    {
        $this->description_feeder = $description_feeder;
    }

    public function getPromoFeeder(): int
    {
        return $this->promo_feeder;
    }

    public function setPromoFeeder($promo_feeder): void
    {
        $this->promo_feeder = $promo_feeder;
    }

    public function getStockFeeder(): int
    {
        return $this->stock_feeder;
    }

    public function setStockFeeder($stock_feeder): void
    {
        $this->stock_feeder = $stock_feeder;
    }

    public function getHorsStockFeeder(): int
    {
        return $this->hors_stock_feeder;
    }

    public function setHorsStockFeeder($hors_stock_feeder): void
    {
        $this->hors_stock_feeder = $hors_stock_feeder;
    }

    public function getCategorieFeeder(): string
    {
        return $this->id_categorie;
    }

    public function setCategorieFeeder($id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

    public function getTypeFeeder(): string
    {
        return $this->id_type_feeder;
    }

    public function setTypeFeeder($id_type_feeder): void
    {
        $this->id_type_feeder = $id_type_feeder;
    }

    public function getMarqueFeeder(): string
    {
        return $this->id_marque;
    }

    public function setMarqueFeeder($id_marque): void
    {
        $this->id_marque = $id_marque;
    }
}

class FeederRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertFeeder(Feeder $feeder)
    {
        $req = $this->bdd->prepare("INSERT INTO feeder (nom_feeder, longueur_feeder, diametre_feeder, poids_feeder, description_feeder, promo_feeder, stock_feeder, hors_stock_feeder, id_categorie, id_type_feeder, id_marque)
        VALUES (?,?,?,?,?,?,?,?,?,?,?)");

        $req->execute
        ([
            $feeder->getNomFeeder(),
            $feeder->getLongueurFeeder(),
            $feeder->getDiametreFeeder(),
            $feeder->getPoidsFeeder(),
            $feeder->getDescriptionFeeder(),
            $feeder->getPromoFeeder(),
            $feeder->getStockFeeder(),
            $feeder->getHorsStockFeeder(),
            $feeder->getCategorieFeeder(),
            $feeder->getTypeFeeder(),
            $feeder->getMarqueFeeder()
        ]);
        
        return $feeder;
    }

    public function getAllFeeder()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_feeder.*, marque.*
        FROM feeder
        INNER JOIN categorie ON feeder.id_categorie = categorie.id_categorie
        INNER JOIN type_feeder ON feeder.id_type_feeder = type_feeder.id_type_feeder
        INNER JOIN marque ON feeder.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $feeders = [];

        foreach ($datas as $data) 
        {
            $feeder = new Feeder();
            $feeder->setIdFeeder($data['id_feeder']);
            $feeder->setNomFeeder($data['nom_feeder']);
            $feeder->setLongueurFeeder($data['longueur_feeder']);
            $feeder->setDiametreFeeder($data['diametre_feeder']);
            $feeder->setPoidsFeeder($data['poids_feeder']);
            $feeder->setDescriptionFeeder($data['description_feeder']);
            $feeder->setPromoFeeder($data['promo_feeder']);
            $feeder->setStockFeeder($data['stock_feeder']);
            $feeder->setHorsStockFeeder($data['hors_stock_feeder']);
            $feeder->setCategorieFeeder($data['nom_categorie']);
            $feeder->setTypeFeeder($data['nom_type_feeder']);
            $feeder->setMarqueFeeder($data['nom_marque']);

            $feeders[] = $feeder;
        }
        return $feeders;
    }

    public function getLastFeeder()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_feeder.*, marque.*
        FROM feeder
        INNER JOIN categorie ON feeder.id_categorie = categorie.id_categorie
        INNER JOIN type_feeder ON feeder.id_type_feeder = type_feeder.id_type_feeder
        INNER JOIN marque ON feeder.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $feeders = [];

        foreach ($datas as $data) 
        {
            $feeder = new Feeder();
            $feeder->setIdFeeder($data['id_feeder']);
            $feeder->setNomFeeder($data['nom_feeder']);
            $feeder->setLongueurFeeder($data['longueur_feeder']);
            $feeder->setDiametreFeeder($data['diametre_feeder']);
            $feeder->setPoidsFeeder($data['poids_feeder']);
            $feeder->setDescriptionFeeder($data['description_feeder']);
            $feeder->setPromoFeeder($data['promo_feeder']);
            $feeder->setStockFeeder($data['stock_feeder']);
            $feeder->setHorsStockFeeder($data['hors_stock_feeder']);
            $feeder->setCategorieFeeder($data['nom_categorie']);
            $feeder->setTypeFeeder($data['nom_type_feeder']);
            $feeder->setMarqueFeeder($data['nom_marque']);

            $feeders[] = $feeder;
        }
        return $feeders;
    }

    public function getPromoFeeder()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_feeder.*, marque.*
        FROM feeder
        INNER JOIN categorie ON feeder.id_categorie = categorie.id_categorie
        INNER JOIN type_feeder ON feeder.id_type_feeder = type_feeder.id_type_feeder
        INNER JOIN marque ON feeder.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $feeders = [];

        foreach ($datas as $data) 
        {
            if($data['promo_feeder'] == 1)
            {
                $feeder = new Feeder();
                $feeder->setIdFeeder($data['id_feeder']);
                $feeder->setNomFeeder($data['nom_feeder']);
                $feeder->setLongueurFeeder($data['longueur_feeder']);
                $feeder->setDiametreFeeder($data['diametre_feeder']);
                $feeder->setPoidsFeeder($data['poids_feeder']);
                $feeder->setDescriptionFeeder($data['description_feeder']);
                $feeder->setPromoFeeder($data['promo_feeder']);
                $feeder->setStockFeeder($data['stock_feeder']);
                $feeder->setHorsStockFeeder($data['hors_stock_feeder']);
                $feeder->setCategorieFeeder($data['nom_categorie']);
                $feeder->setTypeFeeder($data['nom_type_feeder']);
                $feeder->setMarqueFeeder($data['nom_marque']);

                $feeders[] = $feeder;
            }
        }
        return $feeders;
    }

    public function getFeederById($id_feeder)
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_feeder.*, marque.*
        FROM feeder
        INNER JOIN categorie ON feeder.id_categorie = categorie.id_categorie
        INNER JOIN type_feeder ON feeder.id_type_feeder = type_feeder.id_type_feeder
        INNER JOIN marque ON feeder.id_marque = marque.id_marque
        WHERE id_feeder = ?
        ");

        $req->execute([$id_feeder]);
        $datas = $req->fetchAll();

        foreach ($datas as $data)
        {
            $feeder = new Feeder();
            $feeder->setIdFeeder($data['id_feeder']);
            $feeder->setNomFeeder($data['nom_feeder']);
            $feeder->setPoidsFeeder($data['poids_feeder']);
            $feeder->setLongueurFeeder($data['longueur_feeder']);
            $feeder->setDiametreFeeder($data['diametre_feeder']);
            $feeder->setDescriptionFeeder($data['description_feeder']);
            $feeder->setPromoFeeder($data['promo_feeder']);
            $feeder->setStockFeeder($data['stock_feeder']);
            $feeder->setHorsStockFeeder($data['hors_stock_feeder']);
            $feeder->setCategorieFeeder($data['nom_categorie']);
            $feeder->setTypeFeeder($data['nom_type_feeder']);
            $feeder->setMarqueFeeder($data['nom_marque']);
        }
        return $feeder;
    }

    public function deleteFeeder($id_feeder):bool
    {
        try 
        {
            $imageFeederRepo = new ImageFeederRepository;
            $oldImg = $imageFeederRepo->getImageByFeeder($_POST['id_feeder']);
           
            $cheminFichier = $oldImg->getNomImageFeeder();

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
            $imageFeederRepo->deleteImageByFeeder($id_feeder);

            $req = $this->bdd->prepare('DELETE FROM feeder WHERE id_feeder = ?');
            $req->execute([$id_feeder]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function updateFeeder($id_feeder, $nom_feeder, $longueur_feeder, $diametre_feeder, $poids_feeder, $description_feeder, $promo_feeder, $stock_feeder, $hors_stock_feeder, $id_categorie, $id_type_feeder, $id_marque)
    {
        try 
        {
            $req = $this->bdd->prepare("UPDATE feeder SET nom_feeder = ?, longueur_feeder = ?, diametre_feeder = ?, poids_feeder = ?, description_feeder = ?, promo_feeder = ?, stock_feeder = ?, hors_stock_feeder = ?, id_categorie = ?, id_type_feeder = ?, id_marque = ? WHERE id_feeder = ?");
            $req->execute([$nom_feeder,  $longueur_feeder, $diametre_feeder, $poids_feeder, $description_feeder, $promo_feeder, $stock_feeder, $hors_stock_feeder, $id_categorie, $id_type_feeder, $id_marque, $id_feeder]);
            
            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function getLastInsertId()
    {
        $query = "SELECT MAX(id_feeder) AS last_id FROM feeder";
        $result = $this->bdd->prepare($query);

        if ($result->execute())
        { 
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $lastId = $row['last_id'];

            return $lastId;
        } 
        else 
        {
            echo 'fail';
        }
    }

    public function getFeederByCategorie($id_categorie)
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_feeder.*, marque.*
        FROM feeder
        INNER JOIN categorie ON feeder.id_categorie = categorie.id_categorie
        INNER JOIN type_feeder ON feeder.id_type_feeder = type_feeder.id_type_feeder
        INNER JOIN marque ON feeder.id_marque = marque.id_marque
        WHERE feeder.id_categorie = ?");

        $req->execute([$id_categorie]);
        $datas = $req->fetchAll();

        $feeders = [];

        foreach ($datas as $data)
        {
            $feeder = new Feeder();
            $feeder->setIdFeeder($data['id_feeder']);
            $feeder->setNomFeeder($data['nom_feeder']);
            $feeder->setPoidsFeeder($data['poids_feeder']);
            $feeder->setLongueurFeeder($data['longueur_feeder']);
            $feeder->setDiametreFeeder($data['diametre_feeder']);
            $feeder->setDescriptionFeeder($data['description_feeder']);
            $feeder->setPromoFeeder($data['promo_feeder']);
            $feeder->setStockFeeder($data['stock_feeder']);
            $feeder->setHorsStockFeeder($data['hors_stock_feeder']);
            $feeder->setCategorieFeeder($data['nom_categorie']);
            $feeder->setTypeFeeder($data['nom_type_feeder']);
            $feeder->setMarqueFeeder($data['nom_marque']);

            $feeders[] = $feeder;
        }
        return $feeders;
    }

    public function getFeederByMarque($id_marque)
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_feeder.*, marque.*
        FROM feeder
        INNER JOIN categorie ON feeder.id_categorie = categorie.id_categorie
        INNER JOIN type_feeder ON feeder.id_type_feeder = type_feeder.id_type_feeder
        INNER JOIN marque ON feeder.id_marque = marque.id_marque
        WHERE feeder.id_marque = ?");

        $req->execute([$id_marque]);
        $datas = $req->fetchAll();

        $feeders = [];

        foreach ($datas as $data)
        {
            $feeder = new Feeder();
            $feeder->setIdFeeder($data['id_feeder']);
            $feeder->setNomFeeder($data['nom_feeder']);
            $feeder->setPoidsFeeder($data['poids_feeder']);
            $feeder->setLongueurFeeder($data['longueur_feeder']);
            $feeder->setDiametreFeeder($data['diametre_feeder']);
            $feeder->setDescriptionFeeder($data['description_feeder']);
            $feeder->setPromoFeeder($data['promo_feeder']);
            $feeder->setStockFeeder($data['stock_feeder']);
            $feeder->setHorsStockFeeder($data['hors_stock_feeder']);
            $feeder->setCategorieFeeder($data['nom_categorie']);
            $feeder->setTypeFeeder($data['nom_type_feeder']);
            $feeder->setMarqueFeeder($data['nom_marque']);

            $feeders[] = $feeder;
        }
        return $feeders;
    }
}


