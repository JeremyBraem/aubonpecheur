<?php
require_once 'src/config/connectBdd.php';

class Plomb
{
    private $id_plomb;
    private $nom_plomb;
    private $poids_plomb;
    private $longueur_plomb;
    private $diametre_plomb;
    private $description_plomb;
    private $promo_plomb;
    private $stock_plomb;
    private $hors_stock_plomb;
    private $id_categorie;
    private $id_type_plomb;
    private $id_marque;

    public function createToInsertPlomb($plombForm): bool
    {

        if (!isset($plombForm['nom_plomb']) or $plombForm['nom_plomb'] == '') 
        {
            return false;
        }

        if (!isset($plombForm['poids_plomb']) or $plombForm['poids_plomb'] == '') 
        {
            return false;
        }

        if (!isset($plombForm['longueur_plomb']) or $plombForm['longueur_plomb'] == '') 
        {
            return false;
        }

        if (!isset($plombForm['diametre_plomb']) or $plombForm['diametre_plomb'] == '') 
        {
            return false;
        }

        if (!isset($plombForm['description_plomb']) or $plombForm['description_plomb'] == '') 
        {
            return false;
        }

        if (!isset($plombForm['promo_plomb']) or $plombForm['promo_plomb'] == '') 
        {
            return false;
        }

        if (!isset($plombForm['stock_plomb']) or $plombForm['stock_plomb'] == '') 
        {
            return false;
        }

        if (!isset($plombForm['hors_stock_plomb']) or $plombForm['hors_stock_plomb'] == '') 
        {
            return false;
        }

        if (!isset($plombForm['categorie_plomb']) or $plombForm['categorie_plomb'] == '') 
        {
            return false;
        }

        if (!isset($plombForm['type_plomb']) or $plombForm['type_plomb'] == '') 
        {
            return false;
        }

        if (!isset($plombForm['marque_plomb']) or $plombForm['marque_plomb'] == '') 
        {
            return false;
        }

        $this->nom_plomb = $plombForm['nom_plomb'];
        $this->poids_plomb = $plombForm['poids_plomb'];
        $this->longueur_plomb = $plombForm['longueur_plomb'];
        $this->diametre_plomb = $plombForm['diametre_plomb'];
        $this->description_plomb = $plombForm['description_plomb'];
        $this->promo_plomb = $plombForm['promo_plomb'];
        $this->stock_plomb = $plombForm['stock_plomb'];
        $this->hors_stock_plomb = $plombForm['hors_stock_plomb'];
        $this->id_categorie = $plombForm['categorie_plomb'];
        $this->id_type_plomb = $plombForm['type_plomb'];
        $this->id_marque = $plombForm['marque_plomb'];

        return true;
    }

    public function getIdPlomb(): int
    {
        return $this->id_plomb;
    }

    public function setIdPlomb($id_plomb): void
    {
        $this->id_plomb = $id_plomb;
    }


    public function getNomPlomb(): string
    {
        return $this->nom_plomb;
    }

    public function setNomPlomb($nom_plomb): void
    {
        $this->nom_plomb = $nom_plomb;
    }

    public function getPoidsPlomb(): string
    {
        return $this->poids_plomb;
    }

    public function setPoidsPlomb($poids_plomb): void
    {
        $this->poids_plomb = $poids_plomb;
    }

    public function getLongueurPlomb(): string
    {
        return $this->longueur_plomb;
    }

    public function setLongueurPlomb($longueur_plomb): void
    {
        $this->longueur_plomb = $longueur_plomb;
    }

    public function getDiametrePlomb(): string
    {
        return $this->diametre_plomb;
    }

    public function setDiametrePlomb($diametre_plomb): void
    {
        $this->diametre_plomb = $diametre_plomb;
    }

    public function getDescriptionPlomb(): string
    {
        return $this->description_plomb;
    }

    public function setDescriptionPlomb($description_plomb): void
    {
        $this->description_plomb = $description_plomb;
    }

    public function getPromoPlomb(): int
    {
        return $this->promo_plomb;
    }

    public function setPromoPlomb($promo_plomb): void
    {
        $this->promo_plomb = $promo_plomb;
    }

    public function getStockPlomb(): int
    {
        return $this->stock_plomb;
    }

    public function setStockPlomb($stock_plomb): void
    {
        $this->stock_plomb = $stock_plomb;
    }

    public function getHorsStockPlomb(): int
    {
        return $this->hors_stock_plomb;
    }

    public function setHorsStockPlomb($hors_stock_plomb): void
    {
        $this->hors_stock_plomb = $hors_stock_plomb;
    }

    public function getCategoriePlomb(): string
    {
        return $this->id_categorie;
    }

    public function setCategoriePlomb($id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

    public function getTypePlomb(): string
    {
        return $this->id_type_plomb;
    }

    public function setTypePlomb($id_type_plomb): void
    {
        $this->id_type_plomb = $id_type_plomb;
    }

    public function getMarquePlomb(): string
    {
        return $this->id_marque;
    }

    public function setMarquePlomb($id_marque): void
    {
        $this->id_marque = $id_marque;
    }
}

class PlombRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertPlomb(Plomb $plomb)
    {
        $req = $this->bdd->prepare("INSERT INTO plomb (nom_plomb, longueur_plomb, diametre_plomb, poids_plomb, description_plomb, promo_plomb, stock_plomb, hors_stock_plomb, id_categorie, id_type_plomb, id_marque)
        VALUES (?,?,?,?,?,?,?,?,?,?,?)");

        $req->execute
        ([
            $plomb->getNomPlomb(),
            $plomb->getLongueurPlomb(),
            $plomb->getDiametrePlomb(),
            $plomb->getPoidsPlomb(),
            $plomb->getDescriptionPlomb(),
            $plomb->getPromoPlomb(),
            $plomb->getStockPlomb(),
            $plomb->getHorsStockPlomb(),
            $plomb->getCategoriePlomb(),
            $plomb->getTypePlomb(),
            $plomb->getMarquePlomb()
        ]);
        
        return $plomb;
    }

    public function getAllPlomb()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_plomb.*, marque.*
        FROM plomb
        INNER JOIN categorie ON plomb.id_categorie = categorie.id_categorie
        INNER JOIN type_plomb ON plomb.id_type_plomb = type_plomb.id_type_plomb
        INNER JOIN marque ON plomb.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $plombs = [];

        foreach ($datas as $data) 
        {
            $plomb = new Plomb();
            $plomb->setIdPlomb($data['id_plomb']);
            $plomb->setNomPlomb($data['nom_plomb']);
            $plomb->setLongueurPlomb($data['longueur_plomb']);
            $plomb->setDiametrePlomb($data['diametre_plomb']);
            $plomb->setPoidsPlomb($data['poids_plomb']);
            $plomb->setDescriptionPlomb($data['description_plomb']);
            $plomb->setPromoPlomb($data['promo_plomb']);
            $plomb->setStockPlomb($data['stock_plomb']);
            $plomb->setHorsStockPlomb($data['hors_stock_plomb']);
            $plomb->setCategoriePlomb($data['nom_categorie']);
            $plomb->setTypePlomb($data['nom_type_plomb']);
            $plomb->setMarquePlomb($data['nom_marque']);

            $plombs[] = $plomb;
        }
        return $plombs;
    }

    public function getLastPlomb()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_plomb.*, marque.*
        FROM plomb
        INNER JOIN categorie ON plomb.id_categorie = categorie.id_categorie
        INNER JOIN type_plomb ON plomb.id_type_plomb = type_plomb.id_type_plomb
        INNER JOIN marque ON plomb.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $plombs = [];

        foreach ($datas as $data) 
        {
            $plomb = new Plomb();
            $plomb->setIdPlomb($data['id_plomb']);
            $plomb->setNomPlomb($data['nom_plomb']);
            $plomb->setLongueurPlomb($data['longueur_plomb']);
            $plomb->setDiametrePlomb($data['diametre_plomb']);
            $plomb->setPoidsPlomb($data['poids_plomb']);
            $plomb->setDescriptionPlomb($data['description_plomb']);
            $plomb->setPromoPlomb($data['promo_plomb']);
            $plomb->setStockPlomb($data['stock_plomb']);
            $plomb->setHorsStockPlomb($data['hors_stock_plomb']);
            $plomb->setCategoriePlomb($data['nom_categorie']);
            $plomb->setTypePlomb($data['nom_type_plomb']);
            $plomb->setMarquePlomb($data['nom_marque']);

            $plombs[] = $plomb;
        }
        return $plombs;
    }

    public function getPromoPlomb()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_plomb.*, marque.*
        FROM plomb
        INNER JOIN categorie ON plomb.id_categorie = categorie.id_categorie
        INNER JOIN type_plomb ON plomb.id_type_plomb = type_plomb.id_type_plomb
        INNER JOIN marque ON plomb.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $plombs = [];

        foreach ($datas as $data) 
        {
            if($data['promo_plomb'] == 1)
            {
                $plomb = new Plomb();
                $plomb->setIdPlomb($data['id_plomb']);
                $plomb->setNomPlomb($data['nom_plomb']);
                $plomb->setLongueurPlomb($data['longueur_plomb']);
                $plomb->setDiametrePlomb($data['diametre_plomb']);
                $plomb->setPoidsPlomb($data['poids_plomb']);
                $plomb->setDescriptionPlomb($data['description_plomb']);
                $plomb->setPromoPlomb($data['promo_plomb']);
                $plomb->setStockPlomb($data['stock_plomb']);
                $plomb->setHorsStockPlomb($data['hors_stock_plomb']);
                $plomb->setCategoriePlomb($data['nom_categorie']);
                $plomb->setTypePlomb($data['nom_type_plomb']);
                $plomb->setMarquePlomb($data['nom_marque']);

                $plombs[] = $plomb;
            }
        }
        return $plombs;
    }

    public function getPlombById($id_plomb)
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_plomb.*, marque.*
        FROM plomb
        INNER JOIN categorie ON plomb.id_categorie = categorie.id_categorie
        INNER JOIN type_plomb ON plomb.id_type_plomb = type_plomb.id_type_plomb
        INNER JOIN marque ON plomb.id_marque = marque.id_marque
        WHERE id_plomb = ?
        ");

        $req->execute([$id_plomb]);
        $datas = $req->fetchAll();

        foreach ($datas as $data)
        {
            $plomb = new Plomb();
            $plomb->setIdPlomb($data['id_plomb']);
            $plomb->setNomPlomb($data['nom_plomb']);
            $plomb->setPoidsPlomb($data['poids_plomb']);
            $plomb->setLongueurPlomb($data['longueur_plomb']);
            $plomb->setDiametrePlomb($data['diametre_plomb']);
            $plomb->setDescriptionPlomb($data['description_plomb']);
            $plomb->setPromoPlomb($data['promo_plomb']);
            $plomb->setStockPlomb($data['stock_plomb']);
            $plomb->setHorsStockPlomb($data['hors_stock_plomb']);
            $plomb->setCategoriePlomb($data['nom_categorie']);
            $plomb->setTypePlomb($data['nom_type_plomb']);
            $plomb->setMarquePlomb($data['nom_marque']);
        }
        return $plomb;
    }

    public function deletePlomb($id_plomb):bool
    {
        try 
        {
            $imagePlombRepo = new ImagePlombRepository;
            $oldImg = $imagePlombRepo->getImageByPlomb($_POST['id_plomb']);
           
            $cheminFichier = $oldImg->getNomImagePlomb();

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
            $imagePlombRepo->deleteImageByPlomb($id_plomb);

            $req = $this->bdd->prepare('DELETE FROM plomb WHERE id_plomb = ?');
            $req->execute([$id_plomb]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function updatePlomb($id_plomb, $nom_plomb, $longueur_plomb, $diametre_plomb, $poids_plomb, $description_plomb, $promo_plomb, $stock_plomb, $hors_stock_plomb, $id_categorie, $id_type_plomb, $id_marque)
    {
        try 
        {
            $req = $this->bdd->prepare("UPDATE plomb SET nom_plomb = ?, longueur_plomb = ?, diametre_plomb = ?, poids_plomb = ?, description_plomb = ?, promo_plomb = ?, stock_plomb = ?, hors_stock_plomb = ?, id_categorie = ?, id_type_plomb = ?, id_marque = ? WHERE id_plomb = ?");
            $req->execute([$nom_plomb,  $longueur_plomb, $diametre_plomb, $poids_plomb, $description_plomb, $promo_plomb, $stock_plomb, $hors_stock_plomb, $id_categorie, $id_type_plomb, $id_marque, $id_plomb]);
            
            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function getLastInsertId()
    {
        $query = "SELECT MAX(id_plomb) AS last_id FROM plomb";
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

    public function getPlombByCategorie($id_categorie)
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_plomb.*, marque.*
        FROM plomb
        INNER JOIN categorie ON plomb.id_categorie = categorie.id_categorie
        INNER JOIN type_plomb ON plomb.id_type_plomb = type_plomb.id_type_plomb
        INNER JOIN marque ON plomb.id_marque = marque.id_marque
        WHERE plomb.id_categorie = ?");

        $req->execute([$id_categorie]);
        $datas = $req->fetchAll();

        $plombs = [];

        foreach ($datas as $data)
        {
            $plomb = new Plomb();
            $plomb->setIdPlomb($data['id_plomb']);
            $plomb->setNomPlomb($data['nom_plomb']);
            $plomb->setPoidsPlomb($data['poids_plomb']);
            $plomb->setLongueurPlomb($data['longueur_plomb']);
            $plomb->setDiametrePlomb($data['diametre_plomb']);
            $plomb->setDescriptionPlomb($data['description_plomb']);
            $plomb->setPromoPlomb($data['promo_plomb']);
            $plomb->setStockPlomb($data['stock_plomb']);
            $plomb->setHorsStockPlomb($data['hors_stock_plomb']);
            $plomb->setCategoriePlomb($data['nom_categorie']);
            $plomb->setTypePlomb($data['nom_type_plomb']);
            $plomb->setMarquePlomb($data['nom_marque']);

            $plombs[] = $plomb;
        }
        return $plombs;
    }

    public function getPlombByMarque($id_marque)
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_plomb.*, marque.*
        FROM plomb
        INNER JOIN categorie ON plomb.id_categorie = categorie.id_categorie
        INNER JOIN type_plomb ON plomb.id_type_plomb = type_plomb.id_type_plomb
        INNER JOIN marque ON plomb.id_marque = marque.id_marque
        WHERE plomb.id_marque = ?");

        $req->execute([$id_marque]);
        $datas = $req->fetchAll();

        $plombs = [];

        foreach ($datas as $data)
        {
            $plomb = new Plomb();
            $plomb->setIdPlomb($data['id_plomb']);
            $plomb->setNomPlomb($data['nom_plomb']);
            $plomb->setPoidsPlomb($data['poids_plomb']);
            $plomb->setLongueurPlomb($data['longueur_plomb']);
            $plomb->setDiametrePlomb($data['diametre_plomb']);
            $plomb->setDescriptionPlomb($data['description_plomb']);
            $plomb->setPromoPlomb($data['promo_plomb']);
            $plomb->setStockPlomb($data['stock_plomb']);
            $plomb->setHorsStockPlomb($data['hors_stock_plomb']);
            $plomb->setCategoriePlomb($data['nom_categorie']);
            $plomb->setTypePlomb($data['nom_type_plomb']);
            $plomb->setMarquePlomb($data['nom_marque']);

            $plombs[] = $plomb;
        }
        return $plombs;
    }
}


