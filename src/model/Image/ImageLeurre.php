<?php
require_once 'src/config/connectBdd.php';

class ImageLeurre
{
    private $id_image_leurre;
    private $nom_image_leurre;
    private $id_leurre;

    public function addImageLeurre($newLeurre):bool
    {
        if (!empty($newLeurre))
        {
            $path = 'assets/img/article/leurre';
            $nameFile = $newLeurre['name'];
            $typeFile = $newLeurre['type'];
            $tmpFile = $newLeurre['tmp_name'];
            $errorFile = $newLeurre['error'];
            $sizeFile = $newLeurre['size'];

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
                        if (move_uploaded_file($tmpFile, $image_leurre = 'assets/img/article/leurre/' . uniqid() . '.' . end($extension))) 
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

        $this->nom_image_leurre = $image_leurre;
        return true;
    }

    public function getIdImageLeurre(): int
    {
        return $this->id_image_leurre;
    }

    public function setIdImageLeurre($id_image_leurre): void
    {
        $this->id_image_leurre = $id_image_leurre;
    }


    public function getNomImageLeurre(): string
    {
        return $this->nom_image_leurre;
    }

    public function setNomImageLeurre($nom_image_leurre): void
    {
        $this->nom_image_leurre = $nom_image_leurre;
    }

    public function getIdLeurre(): string
    {
        return $this->id_leurre;
    }

    public function setIdLeurre($id_leurre): void
    {
        $this->id_leurre = $id_leurre;
    }
}

class ImageLeurreRepository extends ConnectBdd
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getImageByLeurre($id_leurre)
    {
        $req =  $this->bdd->prepare('SELECT * FROM image_leurre WHERE id_leurre = ?');
        $req->execute([$id_leurre]);

        $dataImage = $req->fetch();

        $imageLeurre = new ImageLeurre();

        $imageLeurre->setIdImageLeurre($dataImage['id_image_leurre']);
        $imageLeurre->setNomImageLeurre($dataImage['nom_image_leurre']);
        $imageLeurre->setIdLeurre($dataImage['id_leurre']);

        return $imageLeurre;
    }

    public function insertImageLeurre($image_leurre)
    {
        $req = $this->bdd->prepare("INSERT INTO image_leurre (nom_image_leurre, id_leurre)
        VALUES (?,?)");

        $req->execute
        ([
            $image_leurre->getNomImageLeurre(),
            $image_leurre->getIdLeurre()
        ]);
    }

    public function deleteImageByLeurre($id_leurre)
    {
        $req = $this->bdd->prepare('DELETE FROM image_leurre WHERE id_leurre = ?');
        $req->execute([$id_leurre]);
    }

    public function updateImageByLeurre($newImageLeurre, $id_leurre)
    {
        if (!empty($newImageLeurre))
        {
            $path = 'assets/img/article/leurre';
            $nameFile = $newImageLeurre['name'];
            $typeFile = $newImageLeurre['type'];
            $tmpFile = $newImageLeurre['tmp_name'];
            $errorFile = $newImageLeurre['error'];
            $sizeFile = $newImageLeurre['size'];

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
                        if (move_uploaded_file($tmpFile, $image_leurre = 'assets/img/article/leurre/' . uniqid() . '.' . end($extension))) 
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
            $reqImage = $this->bdd->prepare("UPDATE image_leurre SET nom_image_leurre = ? WHERE id_leurre = ?");
            $reqImage->execute([$image_leurre, $id_leurre]);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}