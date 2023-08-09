<?php
require_once 'src/config/connectBdd.php';

class Image
{
    private $id_image;
    private $nom_image;
    private $description_image;

    public function getIdImage(): int
    {
        return $this->id_image;
    }

    public function setIdImage($id_image): void
    {
        $this->id_image = $id_image;
    }

    public function getNomImage(): string
    {
        return $this->nom_image;
    }

    public function setNomImage($nom_image): void
    {
        $this->nom_image = $nom_image;
    }

    public function getDescriptionImage(): string
    {
        return $this->description_image;
    }

    public function setDescriptionImage($description_image): void
    {
        $this->description_image = $description_image;
    }

    public function addImage($newProduit, $description_image):bool
    {
        if (!empty($newProduit))
        {
            $path = 'assets/img/article';
            $nameFile = $newProduit['name'];
            $typeFile = $newProduit['type'];
            $tmpFile = $newProduit['tmp_name'];
            $errorFile = $newProduit['error'];
            $sizeFile = $newProduit['size'];
           
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
                        if (move_uploaded_file($tmpFile, $nom_image = 'assets/img/article/' . uniqid() . '.' . end($extension))) 
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

        $this->nom_image = $nom_image;
        $this->description_image = $description_image;
        return true;
    }
}

class ImageRepository extends ConnectBdd
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getImageByProduit($id_produit)
    {
        $reqImg = $this->bdd->prepare('SELECT * FROM image WHERE id_image = ?');
        $reqImg->execute([$id_produit['id_image']]);

        $infoImg = $reqImg->fetch();

        $image = new Image();

        $image->setIdImage($infoImg['id_image']);
        $image->setNomImage($infoImg['nom_image']);
        $image->setDescriptionImage($infoImg['description_image']);

        return $image;
    }

    public function insertImage($nom_image, $description_image, $id_produit)
    {
        if (!empty($image))
        {
            $path = 'assets/img/article';
            $nameFile = $image['name'];
            $typeFile = $image['type'];
            $tmpFile = $image['tmp_name'];
            $errorFile = $image['error'];
            $sizeFile = $image['size'];

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
                        if (move_uploaded_file($tmpFile, $image = 'assets/img/article/' . uniqid() . '.' . end($extension))) 
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
        $req = $this->bdd->prepare("INSERT INTO image (nom_image, description_image, id_produit) VALUES (?, ?, ?)");
        $req->execute([$nom_image, $description_image, $id_produit]);
    }

    public function deleteImagesByProduit($id_produit)
    {
        $reqImages = $this->bdd->prepare("SELECT id_image FROM image WHERE id_produit = ?");
        $reqImages->execute([$id_produit]);

        $imageIds = $reqImages->fetch(PDO::FETCH_COLUMN);

        $reqNomImages = $this->bdd->prepare("SELECT nom_image FROM image WHERE id_image = ?");
        $reqNomImages->execute([$imageIds]);

        $imageNom = $reqNomImages->fetch(PDO::FETCH_COLUMN);

        $reqImage = $this->bdd->prepare("DELETE FROM image WHERE id_image = ?");
        $reqImage->execute([$imageIds]);

        if (file_exists($imageNom)) 
        {
            unlink($imageNom);
        }
        else 
        {
            echo "Le fichier n'existe pas ou ne peut pas être supprimé.";
        }
    }

    public function updateImage($newImage, $id_produit)
    {
        try
        {
            $reqImage = $this->bdd->prepare("SELECT id_image FROM image WHERE id_produit = ?");
            $reqImage->execute([$id_produit]);

            $imageId = $reqImage->fetch(PDO::FETCH_COLUMN);

            $reqNomImages = $this->bdd->prepare("SELECT nom_image FROM image WHERE id_image = ?");
            $reqNomImages->execute([$imageId]);

            $imageNom = $reqNomImages->fetch(PDO::FETCH_COLUMN);
            
            if (file_exists($imageNom))
            {
                unlink($imageNom);
            }
            else 
            {
                echo "Le fichier n'existe pas ou ne peut pas être supprimé.";
            }

            $reqImage = $this->bdd->prepare("UPDATE image SET nom_image = ?, description_image = ? WHERE id_image = ?");
            $reqImage->execute([$newImage->getNomImage(), $newImage->getDescriptionImage(), $imageId]);

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
        
    }
}