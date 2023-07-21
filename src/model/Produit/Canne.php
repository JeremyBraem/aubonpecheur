<?php
require_once 'src/config/connectBdd.php';

class Canne
{
    private $id_canne;
    private $nom_canne;
    private $poids_canne;
    private $longueur_canne;
    private $description_canne;
    private $prix_canne;
    private $promo_canne;
    private $stock_canne;
    private $hors_stock_canne;
    private $id_categorie;
    private $id_type_canne;
    private $id_marque;

    public function createToInsertCanne($canneForm): bool
    {

        if (!isset($canneForm['nom_canne']) or $canneForm['nom_canne'] == '') 
        {
            return false;
        }

        if (!isset($canneForm['poids_canne']) or $canneForm['poids_canne'] == '') 
        {
            return false;
        }

        if (!isset($canneForm['longueur_canne']) or $canneForm['longueur_canne'] == '') 
        {
            return false;
        }

        if (!isset($canneForm['description_canne']) or $canneForm['description_canne'] == '') 
        {
            return false;
        }

        if (!isset($canneForm['prix_canne']) or $canneForm['prix_canne'] == '') 
        {
            return false;
        }

        if (!isset($canneForm['promo_canne']) or $canneForm['promo_canne'] == '') 
        {
            return false;
        }

        if (!isset($canneForm['stock_canne']) or $canneForm['stock_canne'] == '') 
        {
            return false;
        }

        if (!isset($canneForm['hors_stock_canne']) or $canneForm['hors_stock_canne'] == '') 
        {
            return false;
        }

        if (!isset($canneForm['categorie_canne']) or $canneForm['categorie_canne'] == '') 
        {
            return false;
        }

        if (!isset($canneForm['type_canne']) or $canneForm['type_canne'] == '') 
        {
            return false;
        }

        if (!isset($canneForm['marque_canne']) or $canneForm['marque_canne'] == '') 
        {
            return false;
        }

        $this->nom_canne = $canneForm['nom_canne'];
        $this->poids_canne = $canneForm['poids_canne'];
        $this->longueur_canne = $canneForm['longueur_canne'];
        $this->description_canne = $canneForm['description_canne'];
        $this->prix_canne = $canneForm['prix_canne'];
        $this->promo_canne = $canneForm['promo_canne'];
        $this->stock_canne = $canneForm['stock_canne'];
        $this->hors_stock_canne = $canneForm['hors_stock_canne'];
        $this->id_categorie = $canneForm['categorie_canne'];
        $this->id_type_canne = $canneForm['type_canne'];
        $this->id_marque = $canneForm['marque_canne'];

        return true;
    }

    public function getIdCanne(): int
    {
        return $this->id_canne;
    }

    public function setIdCanne($id_canne): void
    {
        $this->id_canne = $id_canne;
    }

    public function getNomCanne(): string
    {
        return $this->nom_canne;
    }

    public function setNomCanne($nom_canne): void
    {
        $this->nom_canne = $nom_canne;
    }

    public function getPoidsCanne(): string
    {
        return $this->poids_canne;
    }

    public function setPoidsCanne($poids_canne): void
    {
        $this->poids_canne = $poids_canne;
    }

    public function getLongueurCanne(): string
    {
        return $this->longueur_canne;
    }

    public function setLongueurCanne($longueur_canne): void
    {
        $this->longueur_canne = $longueur_canne;
    }

    public function getDescriptionCanne(): string
    {
        return $this->description_canne;
    }

    public function setDescriptionCanne($description_canne): void
    {
        $this->description_canne = $description_canne;
    }

    public function getPrixCanne(): string
    {
        return $this->prix_canne;
    }

    public function setPrixCanne($prix_canne): void
    {
        $this->prix_canne = $prix_canne;
    }

    public function getPromoCanne(): int
    {
        return $this->promo_canne;
    }

    public function setPromoCanne($promo_canne): void
    {
        $this->promo_canne = $promo_canne;
    }

    public function getStockCanne(): int
    {
        return $this->stock_canne;
    }

    public function setStockCanne($stock_canne): void
    {
        $this->stock_canne = $stock_canne;
    }

    public function getHorsStockCanne(): int
    {
        return $this->hors_stock_canne;
    }

    public function setHorsStockCanne($hors_stock_canne): void
    {
        $this->hors_stock_canne = $hors_stock_canne;
    }

    public function getCategorieCanne(): string
    {
        return $this->id_categorie;
    }

    public function setCategorieCanne($id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

    public function getTypeCanne(): string
    {
        return $this->id_type_canne;
    }

    public function setTypeCanne($id_type_canne): void
    {
        $this->id_type_canne = $id_type_canne;
    }

    public function getMarqueCanne(): string
    {
        return $this->id_marque;
    }

    public function setMarqueCanne($id_marque): void
    {
        $this->id_marque = $id_marque;
    }
}

class CanneRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertCanne(Canne $canne)
    {
        $req = $this->bdd->prepare("INSERT INTO canne (nom_canne, poids_canne, longueur_canne, description_canne, prix_canne, promo_canne, stock_canne, hors_stock_canne, id_categorie, id_type_canne, id_marque)
        VALUES (?,?,?,?,?,?,?,?,?,?,?)");

        $req->execute
        ([
            $canne->getNomCanne(),
            $canne->getPoidsCanne(),
            $canne->getLongueurCanne(),
            $canne->getDescriptionCanne(),
            $canne->getPrixCanne(),
            $canne->getPromoCanne(),
            $canne->getStockCanne(),
            $canne->getHorsStockCanne(),
            $canne->getCategorieCanne(),
            $canne->getTypeCanne(),
            $canne->getMarqueCanne()
        ]);

        return $canne;
    }

    public function getAllCanne()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_canne.*, marque.*
        FROM canne
        INNER JOIN categorie ON canne.id_categorie = categorie.id_categorie
        INNER JOIN type_canne ON canne.id_type_canne = type_canne.id_type_canne
        INNER JOIN marque ON canne.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $cannes = [];

        foreach ($datas as $data)
        {
            $canne = new Canne();
            $canne->setIdCanne($data['id_canne']);
            $canne->setNomCanne($data['nom_canne']);
            $canne->setPoidsCanne($data['poids_canne']);
            $canne->setLongueurCanne($data['longueur_canne']);
            $canne->setDescriptionCanne($data['description_canne']);
            $canne->setPrixCanne($data['prix_canne']);
            $canne->setPromoCanne($data['promo_canne']);
            $canne->setStockCanne($data['stock_canne']);
            $canne->setHorsStockCanne($data['hors_stock_canne']);
            $canne->setCategorieCanne($data['nom_categorie']);
            $canne->setTypeCanne($data['nom_type_canne']);
            $canne->setMarqueCanne($data['nom_marque']);

            $cannes[] = $canne;
        }
        return $cannes;
    }

    public function getCanneById($id_canne)
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_canne.*, marque.*
        FROM canne
        INNER JOIN categorie ON canne.id_categorie = categorie.id_categorie
        INNER JOIN type_canne ON canne.id_type_canne = type_canne.id_type_canne
        INNER JOIN marque ON canne.id_marque = marque.id_marque
        WHERE id_canne = ?
        ");

        $req->execute([$id_canne]);
        $datas = $req->fetchAll();

        foreach ($datas as $data)
        {
            $canne = new Canne();
            $canne->setIdCanne($data['id_canne']);
            $canne->setNomCanne($data['nom_canne']);
            $canne->setPoidsCanne($data['poids_canne']);
            $canne->setLongueurCanne($data['longueur_canne']);
            $canne->setDescriptionCanne($data['description_canne']);
            $canne->setPrixCanne($data['prix_canne']);
            $canne->setPromoCanne($data['promo_canne']);
            $canne->setStockCanne($data['stock_canne']);
            $canne->setHorsStockCanne($data['hors_stock_canne']);
            $canne->setCategorieCanne($data['nom_categorie']);
            $canne->setTypeCanne($data['nom_type_canne']);
            $canne->setMarqueCanne($data['nom_marque']);
        }
        return $canne;
    }

    public function getLastCanne()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_canne.*, marque.*
        FROM canne
        INNER JOIN categorie ON canne.id_categorie = categorie.id_categorie
        INNER JOIN type_canne ON canne.id_type_canne = type_canne.id_type_canne
        INNER JOIN marque ON canne.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();

        $cannes = [];

        foreach ($datas as $data)
        {
            $canne = new Canne();
            $canne->setIdCanne($data['id_canne']);
            $canne->setNomCanne($data['nom_canne']);
            $canne->setPoidsCanne($data['poids_canne']);
            $canne->setLongueurCanne($data['longueur_canne']);
            $canne->setDescriptionCanne($data['description_canne']);
            $canne->setPrixCanne($data['prix_canne']);
            $canne->setPromoCanne($data['promo_canne']);
            $canne->setStockCanne($data['stock_canne']);
            $canne->setHorsStockCanne($data['hors_stock_canne']);
            $canne->setCategorieCanne($data['nom_categorie']);
            $canne->setTypeCanne($data['nom_type_canne']);
            $canne->setMarqueCanne($data['nom_marque']);

            $cannes[] = $canne;
        }
        return $cannes;
    }

    public function getPromoCanne()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_canne.*, marque.*
        FROM canne
        INNER JOIN categorie ON canne.id_categorie = categorie.id_categorie
        INNER JOIN type_canne ON canne.id_type_canne = type_canne.id_type_canne
        INNER JOIN marque ON canne.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();

        $cannesPromo = [];
        
        foreach ($datas as $data)
        {
            if($data['promo_canne'] == 1)
            {
                $canne = new Canne();
                $canne->setIdCanne($data['id_canne']);
                $canne->setNomCanne($data['nom_canne']);
                $canne->setPoidsCanne($data['poids_canne']);
                $canne->setLongueurCanne($data['longueur_canne']);
                $canne->setDescriptionCanne($data['description_canne']);
                $canne->setPrixCanne($data['prix_canne']);
                $canne->setPromoCanne($data['promo_canne']);
                $canne->setStockCanne($data['stock_canne']);
                $canne->setHorsStockCanne($data['hors_stock_canne']);
                $canne->setCategorieCanne($data['nom_categorie']);
                $canne->setTypeCanne($data['nom_type_canne']);
                $canne->setMarqueCanne($data['nom_marque']);
    
                $cannesPromo[] = $canne;
            }
        }
        return $cannesPromo;
    }

    public function deleteCanne($id_canne):bool
    {
        try
        {
            $imageCanneRepo = new ImageCanneRepository;
            $oldImg = $imageCanneRepo->getImageByCanne($_POST['id_canne']);
           
            $cheminFichier = $oldImg->getNomImageCanne();

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
            $imageCanneRepo->deleteImageByCanne($id_canne);

            $req = $this->bdd->prepare('DELETE FROM canne WHERE id_canne = ?');
            $req->execute([$id_canne]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function updateCanne($id_canne, $nom_canne, $poids_canne, $longueur_canne, $prix_canne, $description_canne, $promo_canne, $stock_canne, $hors_stock_canne, $id_categorie, $id_type_canne, $id_marque)
    {
        try 
        {
            $req = $this->bdd->prepare("UPDATE canne SET nom_canne = ?, poids_canne = ?, longueur_canne = ?, prix_canne = ?, description_canne = ?, promo_canne = ?, stock_canne = ?, hors_stock_canne = ?, id_categorie = ?, id_type_canne = ?, id_marque = ? WHERE id_canne = ?");
            $req->execute([$nom_canne, $poids_canne, $longueur_canne, $description_canne, $prix_canne, $promo_canne, $stock_canne, $hors_stock_canne, $id_categorie, $id_type_canne, $id_marque, $id_canne]);
            
            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function getLastInsertId()
    {
        $query = "SELECT MAX(id_canne) AS last_id FROM canne";
        $result = $this->bdd->prepare($query);

        if ($result->execute()) 
        {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $lastId = $row['last_id'];

            return $lastId;
        }
    }

    public function getCanneByCategorie($id_categorie)
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_canne.*, marque.*
        FROM canne
        INNER JOIN categorie ON canne.id_categorie = categorie.id_categorie
        INNER JOIN type_canne ON canne.id_type_canne = type_canne.id_type_canne
        INNER JOIN marque ON canne.id_marque = marque.id_marque
        WHERE canne.id_categorie = ?");

        $req->execute([$id_categorie]);
        $datas = $req->fetchAll();

        $cannes = [];

        foreach ($datas as $data)
        {
            $canne = new Canne();
            $canne->setIdCanne($data['id_canne']);
            $canne->setNomCanne($data['nom_canne']);
            $canne->setPoidsCanne($data['poids_canne']);
            $canne->setLongueurCanne($data['longueur_canne']);
            $canne->setDescriptionCanne($data['description_canne']);
            $canne->setPrixCanne($data['prix_canne']);
            $canne->setPromoCanne($data['promo_canne']);
            $canne->setStockCanne($data['stock_canne']);
            $canne->setHorsStockCanne($data['hors_stock_canne']);
            $canne->setCategorieCanne($data['nom_categorie']);
            $canne->setTypeCanne($data['nom_type_canne']);
            $canne->setMarqueCanne($data['nom_marque']);

            $cannes[] = $canne;
        }
        return $cannes;
    }

    public function getCanneByMarque($id_marque)
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_canne.*, marque.*
        FROM canne
        INNER JOIN categorie ON canne.id_categorie = categorie.id_categorie
        INNER JOIN type_canne ON canne.id_type_canne = type_canne.id_type_canne
        INNER JOIN marque ON canne.id_marque = marque.id_marque
        WHERE canne.id_marque = ?");

        $req->execute([$id_marque]);
        $datas = $req->fetchAll();

        $cannes = [];

        foreach ($datas as $data)
        {
            $canne = new Canne();
            $canne->setIdCanne($data['id_canne']);
            $canne->setNomCanne($data['nom_canne']);
            $canne->setPoidsCanne($data['poids_canne']);
            $canne->setLongueurCanne($data['longueur_canne']);
            $canne->setDescriptionCanne($data['description_canne']);
            $canne->setPrixCanne($data['prix_canne']);
            $canne->setPromoCanne($data['promo_canne']);
            $canne->setStockCanne($data['stock_canne']);
            $canne->setHorsStockCanne($data['hors_stock_canne']);
            $canne->setCategorieCanne($data['nom_categorie']);
            $canne->setTypeCanne($data['nom_type_canne']);
            $canne->setMarqueCanne($data['nom_marque']);

            $cannes[] = $canne;
        }
        return $cannes;
    }
}