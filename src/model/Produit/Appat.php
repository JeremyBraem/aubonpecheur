<?php
require_once 'src/config/connectBdd.php';

class Appat
{
    private $id_appat;
    private $nom_appat;
    private $detail_appat;
    private $description_appat;
    private $promo_appat;
    private $stock_appat;
    private $hors_stock_appat;
    private $id_categorie;
    private $id_type_appat;
    private $id_marque;

    public function createToInsertAppat($appatForm): bool
    {

        if (!isset($appatForm['nom_appat']) or $appatForm['nom_appat'] == '') 
        {
            return false;
        }

        if (!isset($appatForm['detail_appat']) or $appatForm['detail_appat'] == '') 
        {
            return false;
        }

        if (!isset($appatForm['description_appat']) or $appatForm['description_appat'] == '') 
        {
            return false;
        }

        if (!isset($appatForm['promo_appat']) or $appatForm['promo_appat'] == '') 
        {
            return false;
        }

        if (!isset($appatForm['stock_appat']) or $appatForm['stock_appat'] == '') 
        {
            return false;
        }

        if (!isset($appatForm['hors_stock_appat']) or $appatForm['hors_stock_appat'] == '') 
        {
            return false;
        }

        if (!isset($appatForm['categorie_appat']) or $appatForm['categorie_appat'] == '') 
        {
            return false;
        }

        if (!isset($appatForm['type_appat']) or $appatForm['type_appat'] == '') 
        {
            return false;
        }

        if (!isset($appatForm['marque_appat']) or $appatForm['marque_appat'] == '') 
        {
            return false;
        }

        $this->nom_appat = $appatForm['nom_appat'];
        $this->detail_appat = $appatForm['detail_appat'];
        $this->description_appat = $appatForm['description_appat'];
        $this->promo_appat = $appatForm['promo_appat'];
        $this->stock_appat = $appatForm['stock_appat'];
        $this->hors_stock_appat = $appatForm['hors_stock_appat'];
        $this->id_categorie = $appatForm['categorie_appat'];
        $this->id_type_appat = $appatForm['type_appat'];
        $this->id_marque = $appatForm['marque_appat'];

        return true;
    }

    public function getIdAppat(): int
    {
        return $this->id_appat;
    }

    public function setIdAppat($id_appat): void
    {
        $this->id_appat = $id_appat;
    }


    public function getNomAppat(): string
    {
        return $this->nom_appat;
    }

    public function setNomAppat($nom_appat): void
    {
        $this->nom_appat = $nom_appat;
    }

    public function getDetailAppat(): string
    {
        return $this->detail_appat;
    }

    public function setDetailAppat($detail_appat): void
    {
        $this->detail_appat = $detail_appat;
    }

    public function getDescriptionAppat(): string
    {
        return $this->description_appat;
    }

    public function setDescriptionAppat($description_appat): void
    {
        $this->description_appat = $description_appat;
    }

    public function getPromoAppat(): int
    {
        return $this->promo_appat;
    }

    public function setPromoAppat($promo_appat): void
    {
        $this->promo_appat = $promo_appat;
    }

    public function getStockAppat(): int
    {
        return $this->stock_appat;
    }

    public function setStockAppat($stock_appat): void
    {
        $this->stock_appat = $stock_appat;
    }

    public function getHorsStockAppat(): int
    {
        return $this->hors_stock_appat;
    }

    public function setHorsStockAppat($hors_stock_appat): void
    {
        $this->hors_stock_appat = $hors_stock_appat;
    }

    public function getCategorieAppat(): string
    {
        return $this->id_categorie;
    }

    public function setCategorieAppat($id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

    public function getTypeAppat(): string
    {
        return $this->id_type_appat;
    }

    public function setTypeAppat($id_type_appat): void
    {
        $this->id_type_appat = $id_type_appat;
    }

    public function getMarqueAppat(): string
    {
        return $this->id_marque;
    }

    public function setMarqueAppat($id_marque): void
    {
        $this->id_marque = $id_marque;
    }
}

class AppatRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertAppat(Appat $appat)
    {
        $req = $this->bdd->prepare("INSERT INTO appat (nom_appat, detail_appat, description_appat, promo_appat, stock_appat, hors_stock_appat, id_categorie, id_type_appat, id_marque)
        VALUES (?,?,?,?,?,?,?,?,?)");

        $req->execute
        ([
            $appat->getNomAppat(),
            $appat->getDetailAppat(),
            $appat->getDescriptionAppat(),
            $appat->getPromoAppat(),
            $appat->getStockAppat(),
            $appat->getHorsStockAppat(),
            $appat->getCategorieAppat(),
            $appat->getTypeAppat(),
            $appat->getMarqueAppat()
        ]);
        
        return $appat;
    }

    public function getAllAppat()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_appat.*, marque.*
        FROM appat
        INNER JOIN categorie ON appat.id_categorie = categorie.id_categorie
        INNER JOIN type_appat ON appat.id_type_appat = type_appat.id_type_appat
        INNER JOIN marque ON appat.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $appats = [];

        foreach ($datas as $data) 
        {
            $appat = new Appat();
            $appat->setIdAppat($data['id_appat']);
            $appat->setNomAppat($data['nom_appat']);
            $appat->setDetailAppat($data['detail_appat']);
            $appat->setDescriptionAppat($data['description_appat']);
            $appat->setPromoAppat($data['promo_appat']);
            $appat->setStockAppat($data['stock_appat']);
            $appat->setHorsStockAppat($data['hors_stock_appat']);
            $appat->setCategorieAppat($data['nom_categorie']);
            $appat->setTypeAppat($data['nom_type_appat']);
            $appat->setMarqueAppat($data['nom_marque']);

            $appats[] = $appat;
        }
        return $appats;
    }

    public function getLastAppat()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_appat.*, marque.*
        FROM appat
        INNER JOIN categorie ON appat.id_categorie = categorie.id_categorie
        INNER JOIN type_appat ON appat.id_type_appat = type_appat.id_type_appat
        INNER JOIN marque ON appat.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $appats = [];

        foreach ($datas as $data) 
        {
            $appat = new Appat();
            $appat->setIdAppat($data['id_appat']);
            $appat->setNomAppat($data['nom_appat']);
            $appat->setDetailAppat($data['detail_appat']);
            $appat->setDescriptionAppat($data['description_appat']);
            $appat->setPromoAppat($data['promo_appat']);
            $appat->setStockAppat($data['stock_appat']);
            $appat->setHorsStockAppat($data['hors_stock_appat']);
            $appat->setCategorieAppat($data['nom_categorie']);
            $appat->setTypeAppat($data['nom_type_appat']);
            $appat->setMarqueAppat($data['nom_marque']);

            $appats[] = $appat;
        }
        return $appats;
    }

    public function getPromoAppat()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_appat.*, marque.*
        FROM appat
        INNER JOIN categorie ON appat.id_categorie = categorie.id_categorie
        INNER JOIN type_appat ON appat.id_type_appat = type_appat.id_type_appat
        INNER JOIN marque ON appat.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $appats = [];

        foreach ($datas as $data) 
        {
            if($data['promo_appat'] == 1)
            {
                $appat = new Appat();
                $appat->setIdAppat($data['id_appat']);
                $appat->setNomAppat($data['nom_appat']);
                $appat->setDetailAppat($data['detail_appat']);
                $appat->setDescriptionAppat($data['description_appat']);
                $appat->setPromoAppat($data['promo_appat']);
                $appat->setStockAppat($data['stock_appat']);
                $appat->setHorsStockAppat($data['hors_stock_appat']);
                $appat->setCategorieAppat($data['nom_categorie']);
                $appat->setTypeAppat($data['nom_type_appat']);
                $appat->setMarqueAppat($data['nom_marque']);

                $appats[] = $appat;
            }
        }
        return $appats;
    }

    public function getAppatById($id_appat)
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_appat.*, marque.*
        FROM appat
        INNER JOIN categorie ON appat.id_categorie = categorie.id_categorie
        INNER JOIN type_appat ON appat.id_type_appat = type_appat.id_type_appat
        INNER JOIN marque ON appat.id_marque = marque.id_marque
        WHERE id_appat = ?
        ");

        $req->execute([$id_appat]);
        $datas = $req->fetchAll();

        foreach ($datas as $data)
        {
            $appat = new Appat();
            $appat->setIdAppat($data['id_appat']);
            $appat->setNomAppat($data['nom_appat']);
            $appat->setDetailAppat($data['detail_appat']);
            $appat->setDescriptionAppat($data['description_appat']);
            $appat->setPromoAppat($data['promo_appat']);
            $appat->setStockAppat($data['stock_appat']);
            $appat->setHorsStockAppat($data['hors_stock_appat']);
            $appat->setCategorieAppat($data['nom_categorie']);
            $appat->setTypeAppat($data['nom_type_appat']);
            $appat->setMarqueAppat($data['nom_marque']);
        }
        return $appat;
    }

    public function deleteAppat($id_appat):bool
    {
        try 
        {
            
            $imageAppatRepo = new ImageAppatRepository;
            $oldImg = $imageAppatRepo->getImageByAppat($_POST['id_appat']);
           
            $cheminFichier = $oldImg->getNomImageAppat();

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
            $imageAppatRepo->deleteImageByAppat($id_appat);

            $req = $this->bdd->prepare('DELETE FROM appat WHERE id_appat = ?');
            $req->execute([$id_appat]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function updateAppat($id_appat, $nom_appat, $detail_appat, $description_appat, $promo_appat, $stock_appat, $hors_stock_appat, $id_categorie, $id_type_appat, $id_marque)
    {
        try 
        {
            
            $req = $this->bdd->prepare("UPDATE appat SET nom_appat = ?, detail_appat = ?, description_appat = ?, promo_appat = ?, stock_appat = ?, hors_stock_appat = ?, id_categorie = ?, id_type_appat = ?, id_marque = ? WHERE id_appat = ?");
            $req->execute([$nom_appat, $detail_appat, $description_appat, $promo_appat, $stock_appat, $hors_stock_appat, $id_categorie, $id_type_appat, $id_marque, $id_appat]);
            
            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function getLastInsertId()
    {
        $query = "SELECT MAX(id_appat) AS last_id FROM appat";
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


