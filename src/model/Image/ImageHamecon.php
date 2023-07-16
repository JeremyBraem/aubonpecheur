<?php
require_once 'src/config/connectBdd.php';

class ImageHamecon
{
    private $id_image_hamecon;
    private $nom_image_hamecon;
    private $id_hamecon;

    public function addImageHamecon($newHamecon):bool
    {
        if (!empty($newHamecon))
        {
            $path = 'assets/img/article/hamecon';
            $nameFile = $newHamecon['name'];
            $typeFile = $newHamecon['type'];
            $tmpFile = $newHamecon['tmp_name'];
            $errorFile = $newHamecon['error'];
            $sizeFile = $newHamecon['size'];

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
                        if (move_uploaded_file($tmpFile, $image_hamecon = 'assets/img/article/hamecon/' . uniqid() . '.' . end($extension))) 
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

        $this->nom_image_hamecon = $image_hamecon;
        return true;
    }

    public function getIdImageHamecon(): int
    {
        return $this->id_image_hamecon;
    }

    public function setIdImageHamecon($id_image_hamecon): void
    {
        $this->id_image_hamecon = $id_image_hamecon;
    }


    public function getNomImageHamecon(): string
    {
        return $this->nom_image_hamecon;
    }

    public function setNomImageHamecon($nom_image_hamecon): void
    {
        $this->nom_image_hamecon = $nom_image_hamecon;
    }

    public function getIdHamecon(): string
    {
        return $this->id_hamecon;
    }

    public function setIdHamecon($id_hamecon): void
    {
        $this->id_hamecon = $id_hamecon;
    }
}

class ImageHameconRepository extends ConnectBdd
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getImageByHamecon($id_hamecon)
    {
        $req =  $this->bdd->prepare('SELECT * FROM image_hamecon WHERE id_hamecon = ?');
        $req->execute([$id_hamecon]);

        $dataImage = $req->fetch();

        $imageHamecon = new ImageHamecon();
        
        $imageHamecon->setIdImageHamecon($dataImage['id_image_hamecon']);
        $imageHamecon->setNomImageHamecon($dataImage['nom_image_hamecon']);
        $imageHamecon->setIdHamecon($dataImage['id_hamecon']);

        return $imageHamecon;
    }

    public function insertImageHamecon($image_hamecon)
    {
        $req = $this->bdd->prepare("INSERT INTO image_hamecon (nom_image_hamecon, id_hamecon)
        VALUES (?,?)");

        $req->execute
        ([
            $image_hamecon->getNomImageHamecon(),
            $image_hamecon->getIdHamecon()
        ]);
    }

    public function deleteImageByHamecon($id_hamecon)
    {
        $req = $this->bdd->prepare('DELETE FROM image_hamecon WHERE id_hamecon = ?');
        $req->execute([$id_hamecon]);
    }

    public function updateImageByHamecon($newImageHamecon, $id_hamecon)
    {
        if (!empty($newImageHamecon))
        {
            $path = 'assets/img/article/hamecon';
            $nameFile = $newImageHamecon['name'];
            $typeFile = $newImageHamecon['type'];
            $tmpFile = $newImageHamecon['tmp_name'];
            $errorFile = $newImageHamecon['error'];
            $sizeFile = $newImageHamecon['size'];

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
                        if (move_uploaded_file($tmpFile, $image_hamecon = 'assets/img/article/hamecon/' . uniqid() . '.' . end($extension))) 
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
            $reqImage = $this->bdd->prepare("UPDATE image_hamecon SET nom_image_hamecon = ? WHERE id_hamecon = ?");
            $reqImage->execute([$image_hamecon, $id_hamecon]);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}