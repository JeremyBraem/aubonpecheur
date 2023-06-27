<?php
require_once 'src/config/connectBdd.php';

class ImageAppat
{
    private $id_image_appat;
    private $nom_image_appat;
    private $id_appat;

    public function addImageAppat($newAppat):bool
    {
        if (!empty($newAppat))
        {
            $path = 'assets/img/article/appat';
            $nameFile = $newAppat['name'];
            $typeFile = $newAppat['type'];
            $tmpFile = $newAppat['tmp_name'];
            $errorFile = $newAppat['error'];
            $sizeFile = $newAppat['size'];

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
                        if (move_uploaded_file($tmpFile, $image_appat = 'assets/img/article/appat/' . uniqid() . '.' . end($extension))) 
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

        $this->nom_image_appat = $image_appat;
        return true;
    }

    public function getIdImageAppat(): int
    {
        return $this->id_image_appat;
    }

    public function setIdImageAppat($id_image_appat): void
    {
        $this->id_image_appat = $id_image_appat;
    }


    public function getNomImageAppat(): string
    {
        return $this->nom_image_appat;
    }

    public function setNomImageAppat($nom_image_appat): void
    {
        $this->nom_image_appat = $nom_image_appat;
    }

    public function getIdAppat(): string
    {
        return $this->id_appat;
    }

    public function setIdAppat($id_appat): void
    {
        $this->id_appat = $id_appat;
    }
}

class ImageAppatRepository extends ConnectBdd
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getImageByAppat($id_appat)
    {
        $req =  $this->bdd->prepare('SELECT * FROM image_appat WHERE id_appat = ?');
        $req->execute([$id_appat]);

        $dataImage = $req->fetch();

        $imageAppat = new ImageAppat();

        $imageAppat->setIdImageAppat($dataImage['id_image_appat']);
        $imageAppat->setNomImageAppat($dataImage['nom_image_appat']);
        $imageAppat->setIdAppat($dataImage['id_appat']);

        return $imageAppat;
    }

    public function insertImageAppat($image_appat)
    {
        $req = $this->bdd->prepare("INSERT INTO image_appat (nom_image_appat, id_appat)
        VALUES (?,?)");

        $req->execute
        ([
            $image_appat->getNomImageAppat(),
            $image_appat->getIdAppat()
        ]);
    }

    public function deleteImageByAppat($id_appat)
    {
        $req = $this->bdd->prepare('DELETE FROM image_appat WHERE id_appat = ?');
        $req->execute([$id_appat]);
    }

    public function updateImageByAppat($newImageAppat, $id_appat)
    {
        if (!empty($newImageAppat))
        {
            $path = 'assets/img/article/appat';
            $nameFile = $newImageAppat['name'];
            $typeFile = $newImageAppat['type'];
            $tmpFile = $newImageAppat['tmp_name'];
            $errorFile = $newImageAppat['error'];
            $sizeFile = $newImageAppat['size'];

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
                        if (move_uploaded_file($tmpFile, $image_appat = 'assets/img/article/appat/' . uniqid() . '.' . end($extension))) 
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
            $reqImage = $this->bdd->prepare("UPDATE image_appat SET nom_image_appat = ? WHERE id_appat = ?");
            $reqImage->execute([$image_appat, $id_appat]);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}