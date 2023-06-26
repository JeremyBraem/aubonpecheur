<?php
require_once 'src/config/connectBdd.php';

class ImageFeeder
{
    private $id_image_feeder;
    private $nom_image_feeder;
    private $id_feeder;

    public function addImageFeeder($newFeeder):bool
    {
        if (!empty($newFeeder))
        {
            $path = 'assets/img/article/feeder';
            $nameFile = $newFeeder['name'];
            $typeFile = $newFeeder['type'];
            $tmpFile = $newFeeder['tmp_name'];
            $errorFile = $newFeeder['error'];
            $sizeFile = $newFeeder['size'];

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
                        if (move_uploaded_file($tmpFile, $image_feeder = 'assets/img/article/feeder/' . uniqid() . '.' . end($extension))) 
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

        $this->nom_image_feeder = $image_feeder;
        return true;
    }

    public function getIdImageFeeder(): int
    {
        return $this->id_image_feeder;
    }

    public function setIdImageFeeder($id_image_feeder): void
    {
        $this->id_image_feeder = $id_image_feeder;
    }


    public function getNomImageFeeder(): string
    {
        return $this->nom_image_feeder;
    }

    public function setNomImageFeeder($nom_image_feeder): void
    {
        $this->nom_image_feeder = $nom_image_feeder;
    }

    public function getIdFeeder(): string
    {
        return $this->id_feeder;
    }

    public function setIdFeeder($id_feeder): void
    {
        $this->id_feeder = $id_feeder;
    }
}

class ImageFeederRepository extends ConnectBdd
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getImageByFeeder($id_feeder)
    {
        $req =  $this->bdd->prepare('SELECT * FROM image_feeder WHERE id_feeder = ?');
        $req->execute([$id_feeder]);

        $dataImage = $req->fetch();

        $imageFeeder = new ImageFeeder();

        $imageFeeder->setIdImageFeeder($dataImage['id_image_feeder']);
        $imageFeeder->setNomImageFeeder($dataImage['nom_image_feeder']);
        $imageFeeder->setIdFeeder($dataImage['id_feeder']);

        return $imageFeeder;
    }

    public function insertImageFeeder($image_feeder)
    {
        $req = $this->bdd->prepare("INSERT INTO image_feeder (nom_image_feeder, id_feeder)
        VALUES (?,?)");

        $req->execute
        ([
            $image_feeder->getNomImageFeeder(),
            $image_feeder->getIdFeeder()
        ]);
    }

    public function deleteImageByFeeder($id_feeder)
    {
        $req = $this->bdd->prepare('DELETE FROM image_feeder WHERE id_feeder = ?');
        $req->execute([$id_feeder]);
    }

    public function updateImageByFeeder($newImageFeeder, $id_feeder)
    {
        if (!empty($newImageFeeder))
        {
            $path = 'assets/img/article/feeder';
            $nameFile = $newImageFeeder['name'];
            $typeFile = $newImageFeeder['type'];
            $tmpFile = $newImageFeeder['tmp_name'];
            $errorFile = $newImageFeeder['error'];
            $sizeFile = $newImageFeeder['size'];

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
                        if (move_uploaded_file($tmpFile, $image_feeder = 'assets/img/article/feeder/' . uniqid() . '.' . end($extension))) 
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
            $reqImage = $this->bdd->prepare("UPDATE image_feeder SET nom_image_feeder = ? WHERE id_feeder = ?");
            $reqImage->execute([$image_feeder, $id_feeder]);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}