<?php
require_once 'src/config/connectBdd.php';

class ImageCanne
{
    private $id_image_canne;
    private $nom_image_canne;
    private $id_canne;

    public function addImageCanne($newCanne):bool
    {
        if (!empty($newCanne))
        {
            $path = 'assets/img/article/canne';
            $nameFile = $newCanne['name'];
            $typeFile = $newCanne['type'];
            $tmpFile = $newCanne['tmp_name'];
            $errorFile = $newCanne['error'];
            $sizeFile = $newCanne['size'];

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
                        if (move_uploaded_file($tmpFile, $image_canne = 'assets/img/article/canne/' . uniqid() . '.' . end($extension))) 
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

        $this->nom_image_canne = $image_canne;
        return true;
    }

    public function getIdImageCanne(): int
    {
        return $this->id_image_canne;
    }

    public function setIdImageCanne($id_image_canne): void
    {
        $this->id_image_canne = $id_image_canne;
    }


    public function getNomImageCanne(): string
    {
        return $this->nom_image_canne;
    }

    public function setNomImageCanne($nom_image_canne): void
    {
        $this->nom_image_canne = $nom_image_canne;
    }

    public function getIdCanne(): string
    {
        return $this->id_canne;
    }

    public function setIdCanne($id_canne): void
    {
        $this->id_canne = $id_canne;
    }
}

class ImageCanneRepository extends ConnectBdd
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getImageByCanne($id_canne)
    {
        $req =  $this->bdd->prepare('SELECT * FROM image_canne WHERE id_canne = ?');
        $req->execute([$id_canne]);

        $dataImage = $req->fetch();

        $imageCanne = new ImageCanne();

        $imageCanne->setIdImageCanne($dataImage['id_image_canne']);
        $imageCanne->setNomImageCanne($dataImage['nom_image_canne']);
        $imageCanne->setIdCanne($dataImage['id_canne']);

        return $imageCanne;
    }

    public function insertImageCanne($image_canne)
    {
        $req = $this->bdd->prepare("INSERT INTO image_canne (nom_image_canne, id_canne)
        VALUES (?,?)");

        $req->execute
        ([
            $image_canne->getNomImageCanne(),
            $image_canne->getIdCanne()
        ]);
    }

    public function deleteImageByCanne($id_canne)
    {
        $req = $this->bdd->prepare('DELETE FROM image_canne WHERE id_canne = ?');
        $req->execute([$id_canne]);
    }

    public function updateImageByCanne($newImageCanne, $id_canne)
    {
        if (!empty($newImageCanne))
        {
            $path = 'assets/img/article/canne';
            $nameFile = $newImageCanne['name'];
            $typeFile = $newImageCanne['type'];
            $tmpFile = $newImageCanne['tmp_name'];
            $errorFile = $newImageCanne['error'];
            $sizeFile = $newImageCanne['size'];

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
                        if (move_uploaded_file($tmpFile, $image_canne = 'assets/img/article/canne/' . uniqid() . '.' . end($extension))) 
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
            $reqImage = $this->bdd->prepare("UPDATE image_canne SET nom_image_canne = ? WHERE id_canne = ?");
            $reqImage->execute([$image_canne, $id_canne]);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}