<?php
require_once 'src/config/connectBdd.php';

class Ligne
{
    private $id_ligne;
    private $nom_ligne;
    private $poids_ligne;
    private $longueur_ligne;
    private $diametre_ligne;
    private $description_ligne;
    private $promo_ligne;
    private $stock_ligne;
    private $hors_stock_ligne;
    private $id_categorie;
    private $id_type_ligne;
    private $id_marque;

    public function createToInsertLigne($ligneForm): bool
    {

        if (!isset($ligneForm['nom_ligne']) or $ligneForm['nom_ligne'] == '') 
        {
            return false;
        }

        if (!isset($ligneForm['poids_ligne']) or $ligneForm['poids_ligne'] == '') 
        {
            return false;
        }

        if (!isset($ligneForm['longueur_ligne']) or $ligneForm['longueur_ligne'] == '') 
        {
            return false;
        }

        if (!isset($ligneForm['diametre_ligne']) or $ligneForm['diametre_ligne'] == '') 
        {
            return false;
        }

        if (!isset($ligneForm['description_ligne']) or $ligneForm['description_ligne'] == '') 
        {
            return false;
        }

        if (!isset($ligneForm['promo_ligne']) or $ligneForm['promo_ligne'] == '') 
        {
            return false;
        }

        if (!isset($ligneForm['stock_ligne']) or $ligneForm['stock_ligne'] == '') 
        {
            return false;
        }

        if (!isset($ligneForm['hors_stock_ligne']) or $ligneForm['hors_stock_ligne'] == '') 
        {
            return false;
        }

        if (!isset($ligneForm['categorie_ligne']) or $ligneForm['categorie_ligne'] == '') 
        {
            return false;
        }

        if (!isset($ligneForm['type_ligne']) or $ligneForm['type_ligne'] == '') 
        {
            return false;
        }

        if (!isset($ligneForm['marque_ligne']) or $ligneForm['marque_ligne'] == '') 
        {
            return false;
        }

        $this->nom_ligne = $ligneForm['nom_ligne'];
        $this->poids_ligne = $ligneForm['poids_ligne'];
        $this->longueur_ligne = $ligneForm['longueur_ligne'];
        $this->diametre_ligne = $ligneForm['diametre_ligne'];
        $this->description_ligne = $ligneForm['description_ligne'];
        $this->promo_ligne = $ligneForm['promo_ligne'];
        $this->stock_ligne = $ligneForm['stock_ligne'];
        $this->hors_stock_ligne = $ligneForm['hors_stock_ligne'];
        $this->id_categorie = $ligneForm['categorie_ligne'];
        $this->id_type_ligne = $ligneForm['type_ligne'];
        $this->id_marque = $ligneForm['marque_ligne'];

        return true;
    }

    public function getIdLigne(): int
    {
        return $this->id_ligne;
    }

    public function setIdLigne($id_ligne): void
    {
        $this->id_ligne = $id_ligne;
    }


    public function getNomLigne(): string
    {
        return $this->nom_ligne;
    }

    public function setNomLigne($nom_ligne): void
    {
        $this->nom_ligne = $nom_ligne;
    }

    public function getPoidsLigne(): string
    {
        return $this->poids_ligne;
    }

    public function setPoidsLigne($poids_ligne): void
    {
        $this->poids_ligne = $poids_ligne;
    }

    public function getLongueurLigne(): string
    {
        return $this->longueur_ligne;
    }

    public function setLongueurLigne($longueur_ligne): void
    {
        $this->longueur_ligne = $longueur_ligne;
    }

    public function getDiametreLigne(): string
    {
        return $this->diametre_ligne;
    }

    public function setDiametreLigne($diametre_ligne): void
    {
        $this->diametre_ligne = $diametre_ligne;
    }

    public function getDescriptionLigne(): string
    {
        return $this->description_ligne;
    }

    public function setDescriptionLigne($description_ligne): void
    {
        $this->description_ligne = $description_ligne;
    }

    public function getPromoLigne(): int
    {
        return $this->promo_ligne;
    }

    public function setPromoLigne($promo_ligne): void
    {
        $this->promo_ligne = $promo_ligne;
    }

    public function getStockLigne(): int
    {
        return $this->stock_ligne;
    }

    public function setStockLigne($stock_ligne): void
    {
        $this->stock_ligne = $stock_ligne;
    }

    public function getHorsStockLigne(): int
    {
        return $this->hors_stock_ligne;
    }

    public function setHorsStockLigne($hors_stock_ligne): void
    {
        $this->hors_stock_ligne = $hors_stock_ligne;
    }

    public function getCategorieLigne(): string
    {
        return $this->id_categorie;
    }

    public function setCategorieLigne($id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

    public function getTypeLigne(): string
    {
        return $this->id_type_ligne;
    }

    public function setTypeLigne($id_type_ligne): void
    {
        $this->id_type_ligne = $id_type_ligne;
    }

    public function getMarqueLigne(): string
    {
        return $this->id_marque;
    }

    public function setMarqueLigne($id_marque): void
    {
        $this->id_marque = $id_marque;
    }
}

class LigneRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertLigne(Ligne $ligne)
    {
        $req = $this->bdd->prepare("INSERT INTO ligne (nom_ligne, longueur_ligne, diametre_ligne, poids_ligne, description_ligne, promo_ligne, stock_ligne, hors_stock_ligne, id_categorie, id_type_ligne, id_marque)
        VALUES (?,?,?,?,?,?,?,?,?,?,?)");

        $req->execute
        ([
            $ligne->getNomLigne(),
            $ligne->getLongueurLigne(),
            $ligne->getDiametreLigne(),
            $ligne->getPoidsLigne(),
            $ligne->getDescriptionLigne(),
            $ligne->getPromoLigne(),
            $ligne->getStockLigne(),
            $ligne->getHorsStockLigne(),
            $ligne->getCategorieLigne(),
            $ligne->getTypeLigne(),
            $ligne->getMarqueLigne()
        ]);
        
        return $ligne;
    }

    public function getAllLigne()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_ligne.*, marque.*
        FROM ligne
        INNER JOIN categorie ON ligne.id_categorie = categorie.id_categorie
        INNER JOIN type_ligne ON ligne.id_type_ligne = type_ligne.id_type_ligne
        INNER JOIN marque ON ligne.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $lignes = [];

        foreach ($datas as $data) 
        {
            $ligne = new Ligne();
            $ligne->setIdLigne($data['id_ligne']);
            $ligne->setNomLigne($data['nom_ligne']);
            $ligne->setLongueurLigne($data['longueur_ligne']);
            $ligne->setPoidsLigne($data['diametre_ligne']);
            $ligne->setPoidsLigne($data['poids_ligne']);
            $ligne->setDescriptionLigne($data['description_ligne']);
            $ligne->setPromoLigne($data['promo_ligne']);
            $ligne->setStockLigne($data['stock_ligne']);
            $ligne->setHorsStockLigne($data['hors_stock_ligne']);
            $ligne->setCategorieLigne($data['nom_categorie']);
            $ligne->setTypeLigne($data['nom_type_ligne']);
            $ligne->setMarqueLigne($data['nom_marque']);

            $lignes[] = $ligne;
        }
        return $lignes;
    }

    public function getPromoLigne()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_ligne.*, marque.*
        FROM ligne
        INNER JOIN categorie ON ligne.id_categorie = categorie.id_categorie
        INNER JOIN type_ligne ON ligne.id_type_ligne = type_ligne.id_type_ligne
        INNER JOIN marque ON ligne.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $lignes = [];

        foreach ($datas as $data) 
        {
            if($data['promo_ligne'] == 1)
            {
                $ligne = new Ligne();
                $ligne->setIdLigne($data['id_ligne']);
                $ligne->setNomLigne($data['nom_ligne']);
                $ligne->setLongueurLigne($data['longueur_ligne']);
                $ligne->setPoidsLigne($data['diametre_ligne']);
                $ligne->setPoidsLigne($data['poids_ligne']);
                $ligne->setDescriptionLigne($data['description_ligne']);
                $ligne->setPromoLigne($data['promo_ligne']);
                $ligne->setStockLigne($data['stock_ligne']);
                $ligne->setHorsStockLigne($data['hors_stock_ligne']);
                $ligne->setCategorieLigne($data['nom_categorie']);
                $ligne->setTypeLigne($data['nom_type_ligne']);
                $ligne->setMarqueLigne($data['nom_marque']);

                $lignes[] = $ligne;
            }
        }
        return $lignes;
    }

    public function getLigneById($id_ligne)
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_ligne.*, marque.*
        FROM ligne
        INNER JOIN categorie ON ligne.id_categorie = categorie.id_categorie
        INNER JOIN type_ligne ON ligne.id_type_ligne = type_ligne.id_type_ligne
        INNER JOIN marque ON ligne.id_marque = marque.id_marque
        WHERE id_ligne = ?
        ");

        $req->execute([$id_ligne]);
        $datas = $req->fetchAll();

        foreach ($datas as $data)
        {
            $ligne = new Ligne();
            $ligne->setIdLigne($data['id_ligne']);
            $ligne->setNomLigne($data['nom_ligne']);
            $ligne->setPoidsLigne($data['poids_ligne']);
            $ligne->setLongueurLigne($data['longueur_ligne']);
            $ligne->setDiametreLigne($data['diametre_ligne']);
            $ligne->setDescriptionLigne($data['description_ligne']);
            $ligne->setPromoLigne($data['promo_ligne']);
            $ligne->setStockLigne($data['stock_ligne']);
            $ligne->setHorsStockLigne($data['hors_stock_ligne']);
            $ligne->setCategorieLigne($data['nom_categorie']);
            $ligne->setTypeLigne($data['nom_type_ligne']);
            $ligne->setMarqueLigne($data['nom_marque']);
        }
        return $ligne;
    }

    public function getLastLigne()
    {
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_ligne.*, marque.*
        FROM ligne
        INNER JOIN categorie ON ligne.id_categorie = categorie.id_categorie
        INNER JOIN type_ligne ON ligne.id_type_ligne = type_ligne.id_type_ligne
        INNER JOIN marque ON ligne.id_marque = marque.id_marque");

        $req->execute();
        $datas = $req->fetchAll();
        $lignes = [];

        foreach ($datas as $data) 
        {
            $ligne = new Ligne();
            $ligne->setIdLigne($data['id_ligne']);
            $ligne->setNomLigne($data['nom_ligne']);
            $ligne->setLongueurLigne($data['longueur_ligne']);
            $ligne->setPoidsLigne($data['diametre_ligne']);
            $ligne->setPoidsLigne($data['poids_ligne']);
            $ligne->setDescriptionLigne($data['description_ligne']);
            $ligne->setPromoLigne($data['promo_ligne']);
            $ligne->setStockLigne($data['stock_ligne']);
            $ligne->setHorsStockLigne($data['hors_stock_ligne']);
            $ligne->setCategorieLigne($data['nom_categorie']);
            $ligne->setTypeLigne($data['nom_type_ligne']);
            $ligne->setMarqueLigne($data['nom_marque']);

            $lignes[] = $ligne;
        }
        return $lignes;
    }

    public function deleteLigne($id_ligne):bool
    {
        try 
        {
            $imageLigneRepo = new ImageLigneRepository;
            $oldImg = $imageLigneRepo->getImageByLigne($_POST['id_ligne']);
           
            $cheminFichier = $oldImg->getNomImageLigne();

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
            $imageLigneRepo->deleteImageByLigne($id_ligne);

            $req = $this->bdd->prepare('DELETE FROM ligne WHERE id_ligne = ?');
            $req->execute([$id_ligne]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function updateLigne($id_ligne, $nom_ligne, $longueur_ligne, $diametre_ligne, $poids_ligne, $description_ligne, $promo_ligne, $stock_ligne, $hors_stock_ligne, $id_categorie, $id_type_ligne, $id_marque)
    {
        try 
        {
            $req = $this->bdd->prepare("UPDATE ligne SET nom_ligne = ?, longueur_ligne = ?, diametre_ligne = ?, poids_ligne = ?, description_ligne = ?, promo_ligne = ?, stock_ligne = ?, hors_stock_ligne = ?, id_categorie = ?, id_type_ligne = ?, id_marque = ? WHERE id_ligne = ?");
            $req->execute([$nom_ligne,  $longueur_ligne, $diametre_ligne, $poids_ligne, $description_ligne, $promo_ligne, $stock_ligne, $hors_stock_ligne, $id_categorie, $id_type_ligne, $id_marque, $id_ligne]);
            
            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function getLastInsertId()
    {
        $query = "SELECT MAX(id_ligne) AS last_id FROM ligne";
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

    public function getLigneByCategorie($id_categorie)
    {
    
        $req = $this->bdd->prepare("SELECT *, categorie.*, type_ligne.*, marque.*
        FROM ligne
        INNER JOIN categorie ON ligne.id_categorie = categorie.id_categorie
        INNER JOIN type_ligne ON ligne.id_type_ligne = type_ligne.id_type_ligne
        INNER JOIN marque ON ligne.id_marque = marque.id_marque
        WHERE ligne.id_categorie = ?");

        $req->execute([$id_categorie]);
        $datas = $req->fetchAll();

        $lignes = [];

        foreach ($datas as $data)
        {
            $ligne = new Ligne();
            $ligne->setIdLigne($data['id_ligne']);
            $ligne->setNomLigne($data['nom_ligne']);
            $ligne->setPoidsLigne($data['poids_ligne']);
            $ligne->setLongueurLigne($data['longueur_ligne']);
            $ligne->setDiametreLigne($data['diametre_ligne']);
            $ligne->setDescriptionLigne($data['description_ligne']);
            $ligne->setPromoLigne($data['promo_ligne']);
            $ligne->setStockLigne($data['stock_ligne']);
            $ligne->setHorsStockLigne($data['hors_stock_ligne']);
            $ligne->setCategorieLigne($data['nom_categorie']);
            $ligne->setTypeLigne($data['nom_type_ligne']);
            $ligne->setMarqueLigne($data['nom_marque']);

            $lignes[] = $ligne;
        }
        return $lignes;
    }
}


