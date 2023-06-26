<?php
require_once 'src/config/connectBdd.php';

class ImageEquipement
{
    private $id_image_equipement;
    private $nom_image_equipement;
    private $id_equipement;

    public function addImageEquipement($newEquipement):bool
    {
        if (!empty($newEquipement))
        {
            $path = 'assets/img/article/equipement';
            $nameFile = $newEquipement['name'];
            $typeFile = $newEquipement['type'];
            $tmpFile = $newEquipement['tmp_name'];
            $errorFile = $newEquipement['error'];
            $sizeFile = $newEquipement['size'];

            $extensions = ['png', 'jpg', 'jpeg', 'webp'];
            $type = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];

            $extension = explode('.', $nameFile);

            $max_size = 500000;

            if (in_array($typeFile, $type))
            {
                if (count($extension) <= 2 && in_array(strtolower(end($extension)), $extensions))
                {
                    if ($sizeFile <= $max_size && $errorFile == 0) 
                    {
                        if (move_uploaded_file($tmpFile, $image_equipement = 'assets/img/article/equipement/' . uniqid() . '.' . end($extension))) 
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
        }

        $this->nom_image_equipement = $image_equipement;
        return true;
    }

    public function getIdImageEquipement(): int
    {
        return $this->id_image_equipement;
    }

    public function setIdImageEquipement($id_image_equipement): void
    {
        $this->id_image_equipement = $id_image_equipement;
    }


    public function getNomImageEquipement(): string
    {
        return $this->nom_image_equipement;
    }

    public function setNomImageEquipement($nom_image_equipement): void
    {
        $this->nom_image_equipement = $nom_image_equipement;
    }

    public function getIdEquipement(): string
    {
        return $this->id_equipement;
    }

    public function setIdEquipement($id_equipement): void
    {
        $this->id_equipement = $id_equipement;
    }
}

class ImageEquipementRepository extends ConnectBdd
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getImageByEquipement($id_equipement)
    {
        $req =  $this->bdd->prepare('SELECT * FROM image_equipement WHERE id_equipement = ?');
        $req->execute([$id_equipement]);

        $dataImage = $req->fetch();

        $imageEquipement = new ImageEquipement();

        $imageEquipement->setIdImageEquipement($dataImage['id_image_equipement']);
        $imageEquipement->setNomImageEquipement($dataImage['nom_image_equipement']);
        $imageEquipement->setIdEquipement($dataImage['id_equipement']);

        return $imageEquipement;
    }

    public function insertImageEquipement($image_equipement)
    {
        $req = $this->bdd->prepare("INSERT INTO image_equipement (nom_image_equipement, id_equipement)
        VALUES (?,?)");

        $req->execute
        ([
            $image_equipement->getNomImageEquipement(),
            $image_equipement->getIdEquipement()
        ]);
    }

    public function deleteImageByEquipement($id_equipement)
    {
        $req = $this->bdd->prepare('DELETE FROM image_equipement WHERE id_equipement = ?');
        $req->execute([$id_equipement]);
    }

    public function updateImageByEquipement($newImageEquipement, $id_equipement)
    {
        if (!empty($newImageEquipement))
        {
            $path = 'assets/img/article/equipement';
            $nameFile = $newImageEquipement['name'];
            $typeFile = $newImageEquipement['type'];
            $tmpFile = $newImageEquipement['tmp_name'];
            $errorFile = $newImageEquipement['error'];
            $sizeFile = $newImageEquipement['size'];

            $extensions = ['png', 'jpg', 'jpeg', 'webp'];
            $type = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];

            $extension = explode('.', $nameFile);

            $max_size = 500000;

            if (in_array($typeFile, $type))
            {
                if (count($extension) <= 2 && in_array(strtolower(end($extension)), $extensions))
                {
                    if ($sizeFile <= $max_size && $errorFile == 0) 
                    {
                        if (move_uploaded_file($tmpFile, $image_equipement = 'assets/img/article/equipement/' . uniqid() . '.' . end($extension))) 
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
        }

        try
        {
            $reqImage = $this->bdd->prepare("UPDATE image_equipement SET nom_image_equipement = ? WHERE id_equipement = ?");
            $reqImage->execute([$image_equipement, $id_equipement]);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}