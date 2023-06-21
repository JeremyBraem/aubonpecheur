<?php
require_once 'src/config/connectBdd.php';

class Image
{
    private $id_image;
    private $nom_image;
    private $image;


    public function addImageCanne()
    {
        if (!empty($_FILES['image'])) 
        {
            $path = 'assets/img/article/canne';
            $nameFile = $_FILES['image']['name'];
            $typeFile = $_FILES['image']['type'];
            $tmpFile = $_FILES['image']['tmp_name'];
            $errorFile = $_FILES['image']['error'];
            $sizeFile = $_FILES['image']['size'];

            $extensions = ['png', 'jpg', 'jpeg', 'gif', 'jiff'];
            $type = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/jiff'];

            $extension = explode('.', $nameFile);

            $max_size = 500000;

            if (in_array($typeFile, $type)) 
            {
                if (count($extension) <= 2 && in_array(strtolower(end($extension)), $extensions))
                 {
                    if ($sizeFile <= $max_size && $errorFile == 0) {
                        if (move_uploaded_file($tmpFile, $image = 'upload/' . uniqid() . '.' . end($extension))) 
                        {
                            echo "upload  effectué !";
                        } 
                        else 
                        {
                            echo "Echec de l'upload de l'image !";
                            die;
                        }
                    } 
                    else 
                    {
                        echo "Erreur le poids de l'image est trop élevé !";
                        die;
                    }
                }
                else 
                {
                    echo "Merci d'upload une image !";
                    die;
                }
            } 
            else 
            {
                echo "Type non autorisé !";
                die;

            }
        }

        $this->nom_image = $_POST['nom_image'];
        $this->image = $image;
    }
}
