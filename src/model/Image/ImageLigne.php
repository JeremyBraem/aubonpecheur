<?php
require_once 'src/config/connectBdd.php';

class ImageLigne
{
    private $id_image_ligne;
    private $nom_image_ligne;
    private $id_ligne;

    public function addImageLigne($newLigne):bool
    {
        if (!empty($newLigne))
        {
            $path = 'assets/img/article/ligne';
            $nameFile = $newLigne['name'];
            $typeFile = $newLigne['type'];
            $tmpFile = $newLigne['tmp_name'];
            $errorFile = $newLigne['error'];
            $sizeFile = $newLigne['size'];

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
                        if (move_uploaded_file($tmpFile, $image_ligne = 'assets/img/article/ligne/' . uniqid() . '.' . end($extension))) 
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

        $this->nom_image_ligne = $image_ligne;
        return true;
    }

    public function getIdImageLigne(): int
    {
        return $this->id_image_ligne;
    }

    public function setIdImageLigne($id_image_ligne): void
    {
        $this->id_image_ligne = $id_image_ligne;
    }


    public function getNomImageLigne(): string
    {
        return $this->nom_image_ligne;
    }

    public function setNomImageLigne($nom_image_ligne): void
    {
        $this->nom_image_ligne = $nom_image_ligne;
    }

    public function getIdLigne(): string
    {
        return $this->id_ligne;
    }

    public function setIdLigne($id_ligne): void
    {
        $this->id_ligne = $id_ligne;
    }
}

class ImageLigneRepository extends ConnectBdd
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getImageByLigne($id_ligne)
    {
        $req =  $this->bdd->prepare('SELECT * FROM image_ligne WHERE id_ligne = ?');
        $req->execute([$id_ligne]);

        $dataImage = $req->fetch();

        $imageLigne = new ImageLigne();

        $imageLigne->setIdImageLigne($dataImage['id_image_ligne']);
        $imageLigne->setNomImageLigne($dataImage['nom_image_ligne']);
        $imageLigne->setIdLigne($dataImage['id_ligne']);

        return $imageLigne;
    }

    public function insertImageLigne($image_ligne)
    {
        $req = $this->bdd->prepare("INSERT INTO image_ligne (nom_image_ligne, id_ligne)
        VALUES (?,?)");

        $req->execute
        ([
            $image_ligne->getNomImageLigne(),
            $image_ligne->getIdLigne()
        ]);
    }

    public function deleteImageByLigne($id_ligne)
    {
        $req = $this->bdd->prepare('DELETE FROM image_ligne WHERE id_ligne = ?');
        $req->execute([$id_ligne]);
    }

    public function updateImageByLigne($newImageLigne, $id_ligne)
    {
        if (!empty($newImageLigne))
        {
            $path = 'assets/img/article/ligne';
            $nameFile = $newImageLigne['name'];
            $typeFile = $newImageLigne['type'];
            $tmpFile = $newImageLigne['tmp_name'];
            $errorFile = $newImageLigne['error'];
            $sizeFile = $newImageLigne['size'];

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
                        if (move_uploaded_file($tmpFile, $image_ligne = 'assets/img/article/ligne/' . uniqid() . '.' . end($extension))) 
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
            $reqImage = $this->bdd->prepare("UPDATE image_ligne SET nom_image_ligne = ? WHERE id_ligne = ?");
            $reqImage->execute([$image_ligne, $id_ligne]);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}