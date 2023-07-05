<?php
require_once 'src/config/connectBdd.php';

class Marque
{
    private $id_marque;
    private $nom_marque;
    private $image_marque;

    public function createToInsertMarque($marqueForm):bool
    {
        if(!isset($marqueForm['nom_marque']) OR $marqueForm['nom_marque'] == '')
        {
            return false;
        }

        if (!empty($marqueForm['image_marque']))
        {
            $path = 'assets/img/article/marque';
            $nameFile = $marqueForm['image_marque']['name'];
            $typeFile = $marqueForm['image_marque']['type'];
            $tmpFile = $marqueForm['image_marque']['tmp_name'];
            $errorFile = $marqueForm['image_marque']['error'];
            $sizeFile = $marqueForm['image_marque']['size'];

            $extensions = ['png', 'jpg', 'jpeg', 'webp'];
            $type = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];

            $extension = explode('.', $nameFile);

            $max_size = 500000;

            if(in_array($typeFile, $type))
            {
                if(count($extension) <= 2 && in_array(strtolower(end($extension)), $extensions))
                {
                    if($sizeFile <= $max_size && $errorFile == 0) 
                    {
                        if (move_uploaded_file($tmpFile, $image_marque = 'assets/img/marque/' . uniqid() . '.' . end($extension))) 
                        {
                            echo "upload  effectué !";
                        }
                        else 
                        {
                            echo "Echec de l'upload de l'image !";
                            return false;
                        }
                    } 
                    else 
                    {
                        echo "Erreur le poids de l'image est trop élevé !";
                        return false;
                    }
                }
                else 
                {
                    echo "Merci d'upload une image !";
                    return false;
                }
            }
            else 
            {
                echo "Type non autorisé !";
                return false;
            }
    
            $this->nom_marque = $marqueForm['nom_marque'];
            $this->image_marque = $image_marque;

        return true;
        }
    }

    public function getIdMarque():int
    {
        return $this->id_marque;
    }

    public function setIdMarque($id_marque):void
    {
        $this->id_marque = $id_marque;
    }

    public function getNomMarque():string
    {
        return $this->nom_marque;
    }

    public function setNomMarque($nom_marque):void
    {
        $this->nom_marque = $nom_marque;
    }

    public function getImageMarque():string
    {
        return $this->image_marque;
    }

    public function setImageMarque($image_marque):void
    {
        $this->image_marque = $image_marque;
    }
}

class MarqueRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllMarque()
    {
        $req = $this->bdd->prepare("SELECT * FROM marque");
        $req->execute();
        $datas = $req->fetchAll();
        $marques = [];
        foreach ($datas as $data) 
        {
            $marque = new Marque();
            $marque->setIdMarque($data['id_marque']);
            $marque->setNomMarque($data['nom_marque']);
            $marque->setImageMarque($data['image_marque']);

            $marques[] = $marque;
        }
        return $marques;
    }

    public function getMarque($id_marque)
    {
        $req = $this->bdd->prepare("SELECT * FROM marque WHERE id_marque = ?");
        $req->execute([$id_marque]);
        $data = $req->fetch();
        
        $marque = new Marque();
        $marque->setIdMarque($data['id_marque']);
        $marque->setNomMarque($data['nom_marque']);
        $marque->setImageMarque($data['image_marque']);

        return $marque;
    }

    public function insertMarque(Marque $marque)
    {
        $req = $this->bdd->prepare("INSERT INTO marque(nom_marque, image_marque) VALUES (?,?)");
        
        $req->execute
        ([
            $marque->getNomMarque(),
            $marque->getImageMarque()
        ]);
    }

    public function deleteMarque($id_marque, $image_marque):bool
    {
        try 
        {
            $cheminFichier = $image_marque->getImageMarque();
           
            if (file_exists($cheminFichier))
            {
                if (unlink($cheminFichier))
                {
                    echo "Le fichier a été supprimé avec succès.";
                }
                else 
                {
                    echo "Une erreur s'est produite lors de la suppression du fichier.";
                    die;
                }
            }

            $req = $this->bdd->prepare('DELETE FROM marque WHERE id_marque = ?');
            $req->execute([$id_marque]);

            return true;
        }
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function existMarque($nom_marque)
    {
        $req = $this->bdd->prepare("SELECT * FROM marque WHERE nom_marque = ?");
        $req->execute([$nom_marque]);
        $datas = $req->fetchAll();
        
        foreach ($datas as $data)
        {
            $marque = new Marque();
            $marque->setIdMarque($data['id_marque']);
            $marque->setNomMarque($data['nom_marque']);
            
            $marques[] = $marque;
        }
        return $marques;
    }

}