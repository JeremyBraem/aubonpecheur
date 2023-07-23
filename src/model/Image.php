<?php
require_once 'src/config/connectBdd.php';

class Image
{
    private $id_image;
    private $nom_image;
    private $description_image;

    public function addImage($newProduit):bool
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

        $this->nom_image = $image;
        return true;
    }

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
}

class ImageRepository extends ConnectBdd
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getImageByProduit($id_produit)
    {
        $req =  $this->bdd->prepare('SELECT * FROM image WHERE id_produit = ?');
        $req->execute([$id_produit]);

        $dataImage = $req->fetch();

        $image = new Image();

        $image->setIdImage($dataImage['id_image']);
        $image->setNomImage($dataImage['nom_image']);
        $image->setDescriptionImage($dataImage['description_image']);

        return $image;
    }

    public function insertImage($image, $description_image)
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
        
        // Utilisation de marqueurs de paramètres dans la requête
        $req = $this->bdd->prepare("INSERT INTO image (nom_image, description_image) VALUES (?, ?)");

        // Passage des valeurs dans un tableau lors de l'exécution de la requête
        $req->execute([$image, $description_image]);
    }

    public function addImageToProduit(int $idProduit, int $idImage)
    {
        try
        {
            $reqImageProduit = $this->bdd->prepare("INSERT INTO image_produit (id_image, id_produit) VALUES (?, ?)");
            $reqImageProduit->execute([$idImage, $idProduit]);
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de l'ajout de l'image au produit : " . $e->getMessage());
        }
    }

    public function getLastInsertId()
    {
        $query = "SELECT MAX(id_image) AS last_id FROM image";
        $result = $this->bdd->prepare($query);

        if ($result->execute())
        {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $lastId = $row['last_id'];

            return $lastId;
        }
    }

    public function deleteImagesByProduit($id_produit)
    {
        $reqImages = $this->bdd->prepare("SELECT id_image FROM image_produit WHERE id_produit = ?");
        $reqImages->execute([$id_produit]);

        $imageIds = $reqImages->fetch(PDO::FETCH_COLUMN);
        
        $reqImageProduit = $this->bdd->prepare("DELETE FROM image_produit WHERE id_produit = ?");
        $reqImageProduit->execute([$id_produit]);

        $reqImage = $this->bdd->prepare("DELETE FROM image WHERE id_image = ?");
        $reqImage->execute([$imageIds]);
    }

    public function updateImageByProduit($newImageCanne, $id_produit)
    {
        if (!empty($newImageCanne))
        {
            $path = 'assets/img/article';
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
                        if (move_uploaded_file($tmpFile, $image_produit = 'assets/img/article/' . uniqid() . '.' . end($extension))) 
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
            $reqImages = $this->bdd->prepare("SELECT id_image FROM image_produit WHERE id_produit = ?");
            $reqImages->execute([$id_produit]);

            $reqImage = $this->bdd->prepare("UPDATE image SET nom_image = ? WHERE id_produit = ?");
            $reqImage->execute([$image_produit, $id_produit]);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}