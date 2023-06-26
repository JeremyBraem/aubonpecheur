<?php
require_once 'src/config/connectBdd.php';

class Leurre
{
    private $id_leurre;
    private $nom_leurre;
    private $poids_leurre;
    private $couleur_leurre;
    private $description_leurre;
    private $promo_leurre;
    private $stock_leurre;
    private $hors_stock_leurre;
    private $id_categorie;
    private $id_type_leurre;
    private $id_marque;

    public function createToInsertLeurre($leurreForm): bool
    {

        if (!isset($leurreForm['nom_leurre']) or $leurreForm['nom_leurre'] == '') 
        {
            return false;
        }

        if (!isset($leurreForm['poids_leurre']) or $leurreForm['poids_leurre'] == '') 
        {
            return false;
        }

        if (!isset($leurreForm['couleur_leurre']) or $leurreForm['couleur_leurre'] == '') 
        {
            return false;
        }

        if (!isset($leurreForm['description_leurre']) or $leurreForm['description_leurre'] == '') 
        {
            return false;
        }

        if (!isset($leurreForm['promo_leurre']) or $leurreForm['promo_leurre'] == '') 
        {
            return false;
        }

        if (!isset($leurreForm['stock_leurre']) or $leurreForm['stock_leurre'] == '') 
        {
            return false;
        }

        if (!isset($leurreForm['hors_stock_leurre']) or $leurreForm['hors_stock_leurre'] == '') 
        {
            return false;
        }

        if (!isset($leurreForm['categorie_leurre']) or $leurreForm['categorie_leurre'] == '') 
        {
            return false;
        }

        if (!isset($leurreForm['type_leurre']) or $leurreForm['type_leurre'] == '') 
        {
            return false;
        }

        if (!isset($leurreForm['marque_leurre']) or $leurreForm['marque_leurre'] == '') 
        {
            return false;
        }

        $this->nom_leurre = $leurreForm['nom_leurre'];
        $this->poids_leurre = $leurreForm['poids_leurre'];
        $this->couleur_leurre = $leurreForm['couleur_leurre'];
        $this->description_leurre = $leurreForm['description_leurre'];
        $this->promo_leurre = $leurreForm['promo_leurre'];
        $this->stock_leurre = $leurreForm['stock_leurre'];
        $this->hors_stock_leurre = $leurreForm['hors_stock_leurre'];
        $this->id_categorie = $leurreForm['categorie_leurre'];
        $this->id_type_leurre = $leurreForm['type_leurre'];
        $this->id_marque = $leurreForm['marque_leurre'];

        return true;
    }

    public function getIdLeurre(): int
    {
        return $this->id_leurre;
    }

    public function setIdLeurre($id_leurre): void
    {
        $this->id_leurre = $id_leurre;
    }


    public function getNomLeurre(): string
    {
        return $this->nom_leurre;
    }

    public function setNomLeurre($nom_leurre): void
    {
        $this->nom_leurre = $nom_leurre;
    }

    public function getPoidsLeurre(): string
    {
        return $this->poids_leurre;
    }

    public function setPoidsLeurre($poids_leurre): void
    {
        $this->poids_leurre = $poids_leurre;
    }

    public function getCouleurLeurre(): string
    {
        return $this->couleur_leurre;
    }

    public function setCouleurLeurre($couleur_leurre): void
    {
        $this->couleur_leurre = $couleur_leurre;
    }

    public function getDescriptionLeurre(): string
    {
        return $this->description_leurre;
    }

    public function setDescriptionLeurre($description_leurre): void
    {
        $this->description_leurre = $description_leurre;
    }

    public function getPromoLeurre(): int
    {
        return $this->promo_leurre;
    }

    public function setPromoLeurre($promo_leurre): void
    {
        $this->promo_leurre = $promo_leurre;
    }

    public function getStockLeurre(): int
    {
        return $this->stock_leurre;
    }

    public function setStockLeurre($stock_leurre): void
    {
        $this->stock_leurre = $stock_leurre;
    }

    public function getHorsStockLeurre(): int
    {
        return $this->hors_stock_leurre;
    }

    public function setHorsStockLeurre($hors_stock_leurre): void
    {
        $this->hors_stock_leurre = $hors_stock_leurre;
    }

    public function getCategorieLeurre(): string
    {
        return $this->id_categorie;
    }

    public function setCategorieLeurre($id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

    public function getTypeLeurre(): string
    {
        return $this->id_type_leurre;
    }

    public function setTypeLeurre($id_type_leurre): void
    {
        $this->id_type_leurre = $id_type_leurre;
    }

    public function getMarqueLeurre(): string
    {
        return $this->id_marque;
    }

    public function setMarqueLeurre($id_marque): void
    {
        $this->id_marque = $id_marque;
    }
}

class LeurreRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertLeurre(Leurre $leurre)
    {
        $req = $this->bdd->prepare("INSERT INTO leurre (nom_leurre, poids_leurre, couleur_leurre, description_leurre, promo_leurre, stock_leurre, hors_stock_leurre, id_categorie, id_type_leurre, id_marque)
        VALUES (?,?,?,?,?,?,?,?,?,?)");

        $req->execute([
            $leurre->getNomLeurre(),
            $leurre->getPoidsLeurre(),
            $leurre->getCouleurLeurre(),
            $leurre->getDescriptionLeurre(),
            $leurre->getPromoLeurre(),
            $leurre->getStockLeurre(),
            $leurre->getHorsStockLeurre(),
            $leurre->getCategorieLeurre(),
            $leurre->getTypeLeurre(),
            $leurre->getMarqueLeurre()
        ]);
        
        return $leurre;
    }

    public function getAllLeurre()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_leurre.*, marque.*
        FROM leurre
        INNER JOIN categorie ON leurre.id_categorie = categorie.id_categorie
        INNER JOIN type_leurre ON leurre.id_type_leurre = type_leurre.id_type_leurre
        INNER JOIN marque ON leurre.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $leurres = [];

        foreach ($datas as $data)
        {
            $leurre = new Leurre();
            $leurre->setIdLeurre($data['id_leurre']);
            $leurre->setNomLeurre($data['nom_leurre']);
            $leurre->setPoidsLeurre($data['poids_leurre']);
            $leurre->setCouleurLeurre($data['couleur_leurre']);
            $leurre->setDescriptionLeurre($data['description_leurre']);
            $leurre->setPromoLeurre($data['promo_leurre']);
            $leurre->setStockLeurre($data['stock_leurre']);
            $leurre->setHorsStockLeurre($data['hors_stock_leurre']);
            $leurre->setCategorieLeurre($data['nom_categorie']);
            $leurre->setTypeLeurre($data['nom_type_leurre']);
            $leurre->setMarqueLeurre($data['nom_marque']);

            $leurres[] = $leurre;
        }
        return $leurres;
    }

    public function getLastLeurre()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_leurre.*, marque.*
        FROM leurre
        INNER JOIN categorie ON leurre.id_categorie = categorie.id_categorie
        INNER JOIN type_leurre ON leurre.id_type_leurre = type_leurre.id_type_leurre
        INNER JOIN marque ON leurre.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();

        $leurres = [];

        foreach ($datas as $data)
        {
            $leurre = new Leurre();
            $leurre->setIdLeurre($data['id_leurre']);
            $leurre->setNomLeurre($data['nom_leurre']);
            $leurre->setPoidsLeurre($data['poids_leurre']);
            $leurre->setCouleurLeurre($data['couleur_leurre']);
            $leurre->setDescriptionLeurre($data['description_leurre']);
            $leurre->setPromoLeurre($data['promo_leurre']);
            $leurre->setStockLeurre($data['stock_leurre']);
            $leurre->setHorsStockLeurre($data['hors_stock_leurre']);
            $leurre->setCategorieLeurre($data['nom_categorie']);
            $leurre->setTypeLeurre($data['nom_type_leurre']);
            $leurre->setMarqueLeurre($data['nom_marque']);

            $leurres[] = $leurre;
        }
        return $leurres;
    }

    public function getPromoLeurre()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_leurre.*, marque.*
        FROM leurre
        INNER JOIN categorie ON leurre.id_categorie = categorie.id_categorie
        INNER JOIN type_leurre ON leurre.id_type_leurre = type_leurre.id_type_leurre
        INNER JOIN marque ON leurre.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();

        $leurres = [];

        foreach ($datas as $data)
        {
            if($data['promo_leurre'] == 1)
            {
                $leurre = new Leurre();
                $leurre->setIdLeurre($data['id_leurre']);
                $leurre->setNomLeurre($data['nom_leurre']);
                $leurre->setPoidsLeurre($data['poids_leurre']);
                $leurre->setCouleurLeurre($data['couleur_leurre']);
                $leurre->setDescriptionLeurre($data['description_leurre']);
                $leurre->setPromoLeurre($data['promo_leurre']);
                $leurre->setStockLeurre($data['stock_leurre']);
                $leurre->setHorsStockLeurre($data['hors_stock_leurre']);
                $leurre->setCategorieLeurre($data['nom_categorie']);
                $leurre->setTypeLeurre($data['nom_type_leurre']);
                $leurre->setMarqueLeurre($data['nom_marque']);

                $leurres[] = $leurre;
            }
        }
        return $leurres;
    }

    public function deleteLeurre($id_leurre):bool
    {
        try 
        {
            var_dump($_POST);
            die;
            $imageLeurreRepo = new ImageLeurreRepository;
            $oldImg = $imageLeurreRepo->getImageByLeurre($_POST['id_leurre']);
           
            $cheminFichier = $oldImg->getNomImageLeurre();

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
            $imageLeurreRepo->deleteImageByLeurre($id_leurre);

            $req = $this->bdd->prepare('DELETE FROM leurre WHERE id_leurre = ?');
            $req->execute([$id_leurre]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function updateLeurre($id_leurre, $nom_leurre, $poids_leurre, $couleur_leurre, $description_leurre, $promo_leurre, $stock_leurre, $hors_stock_leurre, $id_categorie, $id_type_leurre, $id_marque)
    {
        try 
        {
            
            $req = $this->bdd->prepare("UPDATE leurre SET nom_leurre = ?, poids_leurre = ?, couleur_leurre = ?, description_leurre = ?, promo_leurre = ?, stock_leurre = ?, hors_stock_leurre = ?, id_categorie = ?, id_type_leurre = ?, id_marque = ? WHERE id_leurre = ?");
            $req->execute([$nom_leurre, $poids_leurre, $couleur_leurre, $description_leurre, $promo_leurre, $stock_leurre, $hors_stock_leurre, $id_categorie, $id_type_leurre, $id_marque, $id_leurre]);
            
            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function getLastInsertId()
    {
        $query = "SELECT MAX(id_leurre) AS last_id FROM leurre";
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


