<?php
require_once 'src/config/connectBdd.php';

class ImageMoulinet
{
    private $id_image_moulinet;
    private $nom_image_moulinet;
    private $id_moulinet;

    public function addImageMoulinet($newMoulinet):bool
    {
        if (!empty($newMoulinet))
        {
            $path = 'assets/img/article/moulinet';
            $nameFile = $newMoulinet['name'];
            $typeFile = $newMoulinet['type'];
            $tmpFile = $newMoulinet['tmp_name'];
            $errorFile = $newMoulinet['error'];
            $sizeFile = $newMoulinet['size'];

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
                        if (move_uploaded_file($tmpFile, $image_moulinet = 'assets/img/article/moulinet/' . uniqid() . '.' . end($extension))) 
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

        $this->nom_image_moulinet = $image_moulinet;
        return true;
    }

    public function getIdImageMoulinet(): int
    {
        return $this->id_image_moulinet;
    }

    public function setIdImageMoulinet($id_image_moulinet): void
    {
        $this->id_image_moulinet = $id_image_moulinet;
    }


    public function getNomImageMoulinet(): string
    {
        return $this->nom_image_moulinet;
    }

    public function setNomImageMoulinet($nom_image_moulinet): void
    {
        $this->nom_image_moulinet = $nom_image_moulinet;
    }

    public function getIdMoulinet(): string
    {
        return $this->id_moulinet;
    }

    public function setIdMoulinet($id_moulinet): void
    {
        $this->id_moulinet = $id_moulinet;
    }
}

class ImageMoulinetRepository extends ConnectBdd
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getImageByMoulinet($id_moulinet)
    {
        $req =  $this->bdd->prepare('SELECT * FROM image_moulinet WHERE id_moulinet = ?');
        $req->execute([$id_moulinet]);

        $dataImage = $req->fetch();

        $imageMoulinet = new ImageMoulinet();

        $imageMoulinet->setIdImageMoulinet($dataImage['id_image_moulinet']);
        $imageMoulinet->setNomImageMoulinet($dataImage['nom_image_moulinet']);
        $imageMoulinet->setIdMoulinet($dataImage['id_moulinet']);

        return $imageMoulinet;
    }

    public function insertImageMoulinet($image_moulinet)
    {
        $req = $this->bdd->prepare("INSERT INTO image_moulinet (nom_image_moulinet, id_moulinet)
        VALUES (?,?)");

        $req->execute
        ([
            $image_moulinet->getNomImageMoulinet(),
            $image_moulinet->getIdMoulinet()
        ]);
    }

    public function deleteImageByMoulinet($id_moulinet)
    {
        $req = $this->bdd->prepare('DELETE FROM image_moulinet WHERE id_moulinet = ?');
        $req->execute([$id_moulinet]);
    }

    public function updateImageByMoulinet($newImageMoulinet, $id_moulinet)
    {
        if (!empty($newImageMoulinet))
        {
            $path = 'assets/img/article/moulinet';
            $nameFile = $newImageMoulinet['name'];
            $typeFile = $newImageMoulinet['type'];
            $tmpFile = $newImageMoulinet['tmp_name'];
            $errorFile = $newImageMoulinet['error'];
            $sizeFile = $newImageMoulinet['size'];

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
                        if (move_uploaded_file($tmpFile, $image_moulinet = 'assets/img/article/moulinet/' . uniqid() . '.' . end($extension))) 
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
            $reqImage = $this->bdd->prepare("UPDATE image_moulinet SET nom_image_moulinet = ? WHERE id_moulinet = ?");
            $reqImage->execute([$image_moulinet, $id_moulinet]);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}