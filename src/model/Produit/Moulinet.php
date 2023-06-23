<?php
require_once 'src/config/connectBdd.php';

class Moulinet
{
    private $id_moulinet;
    private $nom_moulinet;
    private $poids_moulinet;
    private $ratio_moulinet;
    private $description_moulinet;
    private $promo_moulinet;
    private $stock_moulinet;
    private $hors_stock_moulinet;
    private $id_categorie;
    private $id_type_moulinet;
    private $id_marque;

    public function createToInsertMoulinet($moulinetForm): bool
    {

        if (!isset($moulinetForm['nom_moulinet']) or $moulinetForm['nom_moulinet'] == '') 
        {
            return false;
        }

        if (!isset($moulinetForm['poids_moulinet']) or $moulinetForm['poids_moulinet'] == '') 
        {
            return false;
        }

        if (!isset($moulinetForm['ratio_moulinet']) or $moulinetForm['ratio_moulinet'] == '') 
        {
            return false;
        }

        if (!isset($moulinetForm['description_moulinet']) or $moulinetForm['description_moulinet'] == '') 
        {
            return false;
        }

        if (!isset($moulinetForm['promo_moulinet']) or $moulinetForm['promo_moulinet'] == '') 
        {
            return false;
        }

        if (!isset($moulinetForm['stock_moulinet']) or $moulinetForm['stock_moulinet'] == '') 
        {
            return false;
        }

        if (!isset($moulinetForm['hors_stock_moulinet']) or $moulinetForm['hors_stock_moulinet'] == '') 
        {
            return false;
        }

        if (!isset($moulinetForm['categorie_moulinet']) or $moulinetForm['categorie_moulinet'] == '') 
        {
            return false;
        }

        if (!isset($moulinetForm['type_moulinet']) or $moulinetForm['type_moulinet'] == '') 
        {
            return false;
        }

        if (!isset($moulinetForm['marque_moulinet']) or $moulinetForm['marque_moulinet'] == '') 
        {
            return false;
        }

        $this->nom_moulinet = $moulinetForm['nom_moulinet'];
        $this->poids_moulinet = $moulinetForm['poids_moulinet'];
        $this->ratio_moulinet = $moulinetForm['ratio_moulinet'];
        $this->description_moulinet = $moulinetForm['description_moulinet'];
        $this->promo_moulinet = $moulinetForm['promo_moulinet'];
        $this->stock_moulinet = $moulinetForm['stock_moulinet'];
        $this->hors_stock_moulinet = $moulinetForm['hors_stock_moulinet'];
        $this->id_categorie = $moulinetForm['categorie_moulinet'];
        $this->id_type_moulinet = $moulinetForm['type_moulinet'];
        $this->id_marque = $moulinetForm['marque_moulinet'];

        return true;
    }

    public function getIdMoulinet(): int
    {
        return $this->id_moulinet;
    }

    public function setIdMoulinet($id_moulinet): void
    {
        $this->id_moulinet = $id_moulinet;
    }


    public function getNomMoulinet(): string
    {
        return $this->nom_moulinet;
    }

    public function setNomMoulinet($nom_moulinet): void
    {
        $this->nom_moulinet = $nom_moulinet;
    }

    public function getPoidsMoulinet(): string
    {
        return $this->poids_moulinet;
    }

    public function setPoidsMoulinet($poids_moulinet): void
    {
        $this->poids_moulinet = $poids_moulinet;
    }

    public function getLongueurMoulinet(): string
    {
        return $this->ratio_moulinet;
    }

    public function setLongueurMoulinet($ratio_moulinet): void
    {
        $this->ratio_moulinet = $ratio_moulinet;
    }

    public function getDescriptionMoulinet(): string
    {
        return $this->description_moulinet;
    }

    public function setDescriptionMoulinet($description_moulinet): void
    {
        $this->description_moulinet = $description_moulinet;
    }

    public function getPromoMoulinet(): int
    {
        return $this->promo_moulinet;
    }

    public function setPromoMoulinet($promo_moulinet): void
    {
        $this->promo_moulinet = $promo_moulinet;
    }

    public function getStockMoulinet(): int
    {
        return $this->stock_moulinet;
    }

    public function setStockMoulinet($stock_moulinet): void
    {
        $this->stock_moulinet = $stock_moulinet;
    }

    public function getHorsStockMoulinet(): int
    {
        return $this->hors_stock_moulinet;
    }

    public function setHorsStockMoulinet($hors_stock_moulinet): void
    {
        $this->hors_stock_moulinet = $hors_stock_moulinet;
    }

    public function getCategorieMoulinet(): string
    {
        return $this->id_categorie;
    }

    public function setCategorieMoulinet($id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

    public function getTypeMoulinet(): string
    {
        return $this->id_type_moulinet;
    }

    public function setTypeMoulinet($id_type_moulinet): void
    {
        $this->id_type_moulinet = $id_type_moulinet;
    }

    public function getMarqueMoulinet(): string
    {
        return $this->id_marque;
    }

    public function setMarqueMoulinet($id_marque): void
    {
        $this->id_marque = $id_marque;
    }
}

class MoulinetRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertMoulinet(Moulinet $moulinet)
    {
        $req = $this->bdd->prepare("INSERT INTO moulinet (nom_moulinet, poids_moulinet, ratio_moulinet, description_moulinet, promo_moulinet, stock_moulinet, hors_stock_moulinet, id_categorie, id_type_moulinet, id_marque)
        VALUES (?,?,?,?,?,?,?,?,?,?)");

        $req->execute
        ([
            $moulinet->getNomMoulinet(),
            $moulinet->getPoidsMoulinet(),
            $moulinet->getLongueurMoulinet(),
            $moulinet->getDescriptionMoulinet(),
            $moulinet->getPromoMoulinet(),
            $moulinet->getStockMoulinet(),
            $moulinet->getHorsStockMoulinet(),
            $moulinet->getCategorieMoulinet(),
            $moulinet->getTypeMoulinet(),
            $moulinet->getMarqueMoulinet()
        ]);
        
        return $moulinet;
    }

    public function getAllMoulinet()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_moulinet.*, marque.*
        FROM moulinet
        INNER JOIN categorie ON moulinet.id_categorie = categorie.id_categorie
        INNER JOIN type_moulinet ON moulinet.id_type_moulinet = type_moulinet.id_type_moulinet
        INNER JOIN marque ON moulinet.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $moulinets = [];

        foreach ($datas as $data) 
        {
            $moulinet = new Moulinet();
            $moulinet->setIdMoulinet($data['id_moulinet']);
            $moulinet->setNomMoulinet($data['nom_moulinet']);
            $moulinet->setPoidsMoulinet($data['poids_moulinet']);
            $moulinet->setLongueurMoulinet($data['ratio_moulinet']);
            $moulinet->setDescriptionMoulinet($data['description_moulinet']);
            $moulinet->setPromoMoulinet($data['promo_moulinet']);
            $moulinet->setStockMoulinet($data['stock_moulinet']);
            $moulinet->setHorsStockMoulinet($data['hors_stock_moulinet']);
            $moulinet->setCategorieMoulinet($data['nom_categorie']);
            $moulinet->setTypeMoulinet($data['nom_type_moulinet']);
            $moulinet->setMarqueMoulinet($data['nom_marque']);

            $moulinets[] = $moulinet;
        }
        return $moulinets;
    }

    public function deleteMoulinet($id_moulinet):bool
    {
        try 
        {
            
            $imageMoulinetRepo = new ImageMoulinetRepository;
            $oldImg = $imageMoulinetRepo->getImageByMoulinet($_POST['id_moulinet']);
           
            $cheminFichier = $oldImg->getNomImageMoulinet();

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
            $imageMoulinetRepo->deleteImageByMoulinet($id_moulinet);

            $req = $this->bdd->prepare('DELETE FROM moulinet WHERE id_moulinet = ?');
            $req->execute([$id_moulinet]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function updateMoulinet($id_moulinet, $nom_moulinet, $poids_moulinet, $ratio_moulinet, $description_moulinet, $promo_moulinet, $stock_moulinet, $hors_stock_moulinet, $id_categorie, $id_type_moulinet, $id_marque)
    {
        try 
        {
            
            $req = $this->bdd->prepare("UPDATE moulinet SET nom_moulinet = ?, poids_moulinet = ?, ratio_moulinet = ?, description_moulinet = ?, promo_moulinet = ?, stock_moulinet = ?, hors_stock_moulinet = ?, id_categorie = ?, id_type_moulinet = ?, id_marque = ? WHERE id_moulinet = ?");
            $req->execute([$nom_moulinet, $poids_moulinet, $ratio_moulinet, $description_moulinet, $promo_moulinet, $stock_moulinet, $hors_stock_moulinet, $id_categorie, $id_type_moulinet, $id_marque, $id_moulinet]);
            
            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function getLastInsertId()
    {
        $query = "SELECT MAX(id_moulinet) AS last_id FROM moulinet";
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


