<?php
require_once 'src/config/connectBdd.php';

class ImagePlomb
{
    private $id_image_plomb;
    private $nom_image_plomb;
    private $id_plomb;

    public function addImagePlomb($newPlomb):bool
    {
        if (!empty($newPlomb))
        {
            $path = 'assets/img/article/plomb';
            $nameFile = $newPlomb['name'];
            $typeFile = $newPlomb['type'];
            $tmpFile = $newPlomb['tmp_name'];
            $errorFile = $newPlomb['error'];
            $sizeFile = $newPlomb['size'];

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
                        if (move_uploaded_file($tmpFile, $image_plomb = 'assets/img/article/plomb/' . uniqid() . '.' . end($extension))) 
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

        $this->nom_image_plomb = $image_plomb;
        return true;
    }

    public function getIdImagePlomb(): int
    {
        return $this->id_image_plomb;
    }

    public function setIdImagePlomb($id_image_plomb): void
    {
        $this->id_image_plomb = $id_image_plomb;
    }


    public function getNomImagePlomb(): string
    {
        return $this->nom_image_plomb;
    }

    public function setNomImagePlomb($nom_image_plomb): void
    {
        $this->nom_image_plomb = $nom_image_plomb;
    }

    public function getIdPlomb(): string
    {
        return $this->id_plomb;
    }

    public function setIdPlomb($id_plomb): void
    {
        $this->id_plomb = $id_plomb;
    }
}

class ImagePlombRepository extends ConnectBdd
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getImageByPlomb($id_plomb)
    {
        $req =  $this->bdd->prepare('SELECT * FROM image_plomb WHERE id_plomb = ?');
        $req->execute([$id_plomb]);

        $dataImage = $req->fetch();

        $imagePlomb = new ImagePlomb();

        $imagePlomb->setIdImagePlomb($dataImage['id_image_plomb']);
        $imagePlomb->setNomImagePlomb($dataImage['nom_image_plomb']);
        $imagePlomb->setIdPlomb($dataImage['id_plomb']);

        return $imagePlomb;
    }

    public function insertImagePlomb($image_plomb)
    {
        $req = $this->bdd->prepare("INSERT INTO image_plomb (nom_image_plomb, id_plomb)
        VALUES (?,?)");

        $req->execute
        ([
            $image_plomb->getNomImagePlomb(),
            $image_plomb->getIdPlomb()
        ]);
    }

    public function deleteImageByPlomb($id_plomb)
    {
        $req = $this->bdd->prepare('DELETE FROM image_plomb WHERE id_plomb = ?');
        $req->execute([$id_plomb]);
    }

    public function updateImageByPlomb($newImagePlomb, $id_plomb)
    {
        if (!empty($newImagePlomb))
        {
            $path = 'assets/img/article/plomb';
            $nameFile = $newImagePlomb['name'];
            $typeFile = $newImagePlomb['type'];
            $tmpFile = $newImagePlomb['tmp_name'];
            $errorFile = $newImagePlomb['error'];
            $sizeFile = $newImagePlomb['size'];

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
                        if (move_uploaded_file($tmpFile, $image_plomb = 'assets/img/article/plomb/' . uniqid() . '.' . end($extension))) 
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
            $reqImage = $this->bdd->prepare("UPDATE image_plomb SET nom_image_plomb = ? WHERE id_plomb = ?");
            $reqImage->execute([$image_plomb, $id_plomb]);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}