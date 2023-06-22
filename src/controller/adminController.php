<?php

require_once('autoload/autoloader.php');
require_once('src/model/Produit/Canne.php');
require_once('src/model/Produit/Moulinet.php');
require_once('src/model/Marque.php');
require_once('src/model/Categorie.php');
require_once('src/model/Type/TypeCanne.php');
require_once('src/model/Type/TypeMoulinet.php');
require_once('src/model/Image/ImageCanne.php');
require_once('src/model/Image/ImageMoulinet.php');

function adminPage()
{
    $canneRepo = new CanneRepository;
    $cannes = $canneRepo->getAllCanne();

    $typeCanneRepo = new TypeCanneRepository;
    $typeCannes = $typeCanneRepo->getAllTypeCanne();

    $moulinetRepo = new MoulinetRepository;
    $moulinets = $moulinetRepo->getAllmoulinet();

    $typeMoulinetRepo = new TypemoulinetRepository;
    $typeMoulinets = $typeMoulinetRepo->getAllTypemoulinet();

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    require('src/view/adminPage.php');
}

function addCanneTraitement()
{
    if(isset($_POST))
    
    {
        if(!empty($_POST['nom_canne']) && !empty($_POST['poids_canne']) && !empty($_POST['longueur_canne']) && !empty($_POST['categorie_canne']) && !empty($_POST['type_canne']) && !empty($_POST['marque_canne']) && !empty($_POST['promo_canne']) && !empty($_POST['stock_canne']) && !empty($_POST['description_canne'] && !empty($_FILES['image_canne'])))
        {
            $newCanne = [];
            $newCanne['nom_canne'] = htmlspecialchars($_POST['nom_canne']);
            $newCanne['poids_canne'] = htmlspecialchars($_POST['poids_canne']);
            $newCanne['longueur_canne'] = htmlspecialchars($_POST['longueur_canne']);
            $newCanne['categorie_canne'] = htmlspecialchars($_POST['categorie_canne']);
            $newCanne['type_canne'] = htmlspecialchars($_POST['type_canne']);
            $newCanne['marque_canne'] = htmlspecialchars($_POST['marque_canne']);
            $newCanne['description_canne'] = htmlspecialchars($_POST['description_canne']);
            $newCanne['promo_canne'] = htmlspecialchars($_POST['promo_canne']);
            $newCanne['stock_canne'] = htmlspecialchars($_POST['stock_canne']);
            $newCanne['image_canne'] = $_FILES['image_canne'];
            
            if($newCanne['stock_canne'] === 'stock') 
            {
                $newCanne['stock_canne'] = 1;
                $newCanne['hors_stock_canne'] = 0;
            }
            else
            {
                $newCanne['stock_canne'] = 0;
                $newCanne['hors_stock_canne'] = 1;
            }

            if($newCanne['promo_canne'] === 'promo')
            {
                $newCanne['promo_canne'] = 1;
            }
            else
            {
                $newCanne['promo_canne'] = 0;
            }
            
            $imageCanne = new ImageCanne;
            $canne = new Canne;
            $canne->createToInsertCanne($newCanne);
            
            if($canne == true)
            {
                $imageCanne->addImageCanne($newCanne['image_canne']);

                $imageCanneRepo = new ImageCanneRepository;
                $canneRepo = new CanneRepository;

                $canneRepo->insertCanne($canne);
            
                $lastInsertIdCanne = $canneRepo->getLastInsertId();
                
                $imageCanne->setIdCanne($lastInsertIdCanne);
                $imageCanneRepo->insertImageCanne($imageCanne);

                header('location: admin.php');
            }
        }
    }
}

function addMoulinetTraitement()
{
    if(isset($_POST))
    
    {
        if(!empty($_POST['nom_moulinet']) && !empty($_POST['poids_moulinet']) && !empty($_POST['ratio_moulinet']) && !empty($_POST['categorie_moulinet']) && !empty($_POST['type_moulinet']) && !empty($_POST['marque_moulinet']) && !empty($_POST['promo_moulinet']) && !empty($_POST['stock_moulinet']) && !empty($_POST['description_moulinet'] && !empty($_FILES['image_moulinet'])))
        {
            
            $newMoulinet = [];
            $newMoulinet['nom_moulinet'] = htmlspecialchars($_POST['nom_moulinet']);
            $newMoulinet['poids_moulinet'] = htmlspecialchars($_POST['poids_moulinet']);
            $newMoulinet['ratio_moulinet'] = htmlspecialchars($_POST['ratio_moulinet']);
            $newMoulinet['categorie_moulinet'] = htmlspecialchars($_POST['categorie_moulinet']);
            $newMoulinet['type_moulinet'] = htmlspecialchars($_POST['type_moulinet']);
            $newMoulinet['marque_moulinet'] = htmlspecialchars($_POST['marque_moulinet']);
            $newMoulinet['description_moulinet'] = htmlspecialchars($_POST['description_moulinet']);
            $newMoulinet['promo_moulinet'] = htmlspecialchars($_POST['promo_moulinet']);
            $newMoulinet['stock_moulinet'] = htmlspecialchars($_POST['stock_moulinet']);
            $newMoulinet['image_moulinet'] = $_FILES['image_moulinet'];
            
            if($newMoulinet['stock_moulinet'] === 'stock') 
            {
                $newMoulinet['stock_moulinet'] = 1;
                $newMoulinet['hors_stock_moulinet'] = 0;
            }
            else
            {
                $newMoulinet['stock_moulinet'] = 0;
                $newMoulinet['hors_stock_moulinet'] = 1;
            }

            if($newMoulinet['promo_moulinet'] === 'promo')
            {
                $newMoulinet['promo_moulinet'] = 1;
            }
            else
            {
                $newMoulinet['promo_moulinet'] = 0;
            }
            
            $imageMoulinet = new ImageMoulinet;
            $moulinet = new Moulinet;
            $moulinet->createToInsertMoulinet($newMoulinet);
            
            if($moulinet == true)
            {
                $imageMoulinet->addImageMoulinet($newMoulinet['image_moulinet']);

                $imageMoulinetRepo = new ImageMoulinetRepository;
                $moulinetRepo = new MoulinetRepository;

                $moulinetRepo->insertMoulinet($moulinet);
            
                $lastInsertIdMoulinet = $moulinetRepo->getLastInsertId();
                
                $imageMoulinet->setIdMoulinet($lastInsertIdMoulinet);
                $imageMoulinetRepo->insertImageMoulinet($imageMoulinet);

                header('location: admin.php');
            }
        }
    }
}

function addCategorieTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_categorie']))
        {
            $newCategorie = [];
            $newCategorie['nom_categorie'] = htmlspecialchars($_POST['nom_categorie']);

            $categorie = new Categorie;
            $categorie->createToInsertCategorie($newCategorie);

            if($categorie == true)
            {
                $categorieRepo = new CategorieRepository;
                $categorieRepo->insertCategorie($categorie);
                header('location: admin.php');
            }
        }
    }
}

function addMarqueTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_marque']) && !empty($_FILES['image_marque']))
        {
            
            $newMarque = [];
            $newMarque['nom_marque'] = htmlspecialchars($_POST['nom_marque']);
            $newMarque['image_marque'] = $_FILES['image_marque'];
            
            $marque = new Marque;
            $marque->createToInsertMarque($newMarque);
            
            if($marque == true)
            {
                $marqueRepo = new MarqueRepository;
                $marqueRepo->insertMarque($marque);
                header('location:admin.php');
            }
        }
    }
}

function addTypeCanneTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_type_canne']))
        {
            $newTypeCanne = [];
            $newTypeCanne['nom_type_canne'] = htmlspecialchars($_POST['nom_type_canne']);

            $typeCanne = new TypeCanne;
            $typeCanne->createToInserTypeCanne($newTypeCanne);

            if($typeCanne == true)
            {
                $typeCanneRepo = new TypeCanneRepository;
                $typeCanneRepo->insertTypeCanne($typeCanne);
                header('location: admin.php');
            }
        }
    }
}

function addTypeMoulinetTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_type_moulinet']))
        {
            $newTypeMoulinet = [];
            $newTypeMoulinet['nom_type_moulinet'] = htmlspecialchars($_POST['nom_type_moulinet']);

            $typeMoulinet = new TypeMoulinet;
            $typeMoulinet->createToInserTypeMoulinet($newTypeMoulinet);

            if($typeMoulinet == true)
            {
                $typeMoulinetRepo = new TypeMoulinetRepository;
                $typeMoulinetRepo->insertTypeMoulinet($typeMoulinet);
                header('location: admin.php');
            }
        }
    }
}

function deleteCanne()
{
    // if($_SESSION['id_role'] === 1)
    // {
        if(!empty($_POST['id_canne']) && isset($_POST['id_canne']))
        {
            var_dump($_POST);
            die;
            $id_canne = isset($_POST['id_canne']) ? $_POST['id_canne'] : null;
            $canneRepository = new CanneRepository();
            $deleteCanne = $canneRepository->deleteCanne($id_canne);
    
            if ($deleteCanne)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de l\'article échoué';
                header('location: admin.php');
            }
        }
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteMoulinet()
{
    // if($_SESSION['id_role'] === 1)
    // {
        if(!empty($_POST['id_moulinet']) && isset($_POST['id_moulinet']))
        {
            var_dump($_POST);
            die;
            $id_moulinet = isset($_POST['id_moulinet']) ? $_POST['id_moulinet'] : null;
            $moulinetRepository = new MoulinetRepository();
            $deleteMoulinet = $moulinetRepository->deleteMoulinet($id_moulinet);
    
            if ($deleteMoulinet)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de l\'article échoué';
                header('location: admin.php');
            }
        }
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteCategorie()
{
    // if($_SESSION['id_role'] === 1)
    // {
        if(!empty($_POST['id_categorie']) && isset($_POST['id_categorie']))
        {
            $id_categorie = isset($_POST['id_categorie']) ? $_POST['id_categorie'] : null;
            $categorieRepository = new CategorieRepository();
            $deleteCategorie = $categorieRepository->deleteCategorie($id_categorie);
    
            if ($deleteCategorie)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de la catégorie échoué';
                header('location: admin.php');
            }
        }
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteMarque()
{
    // if($_SESSION['id_role'] === 1)
    // {
        if(!empty($_POST['id_marque']) && isset($_POST['id_marque']))
        {
            $id_marque = isset($_POST['id_marque']) ? $_POST['id_marque'] : null;
            $marqueRepository = new MarqueRepository;
            $marque = new Marque;
            $oldImg = $marqueRepository->getMarque($id_marque);
            
            $deleteMarque = $marqueRepository->deleteMarque($id_marque, $oldImg);
    
            if ($deleteMarque)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de la marque échoué';
                header('location: admin.php');
            }
        }
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteTypeCanne()
{
    // if($_SESSION['id_role'] === 1)
    // {
        if(!empty($_POST['id_type_canne']) && isset($_POST['id_type_canne']))
        {
            $id_type_canne = isset($_POST['id_type_canne']) ? $_POST['id_type_canne'] : null;
            $typeCanneRepository = new TypeCanneRepository();
            $deleteTypeCanne = $typeCanneRepository->deleteTypeCanne($id_type_canne);
    
            if ($deleteTypeCanne)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression du type de canne échoué';
                header('location: admin.php');
            }
        }
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteTypeMoulinet()
{
    // if($_SESSION['id_role'] === 1)
    // {
        if(!empty($_POST['id_type_moulinet']) && isset($_POST['id_type_moulinet']))
        {
            $id_type_moulinet = isset($_POST['id_type_moulinet']) ? $_POST['id_type_moulinet'] : null;
            $typeMoulinetRepository = new TypeMoulinetRepository();
            $deleteTypeMoulinet = $typeMoulinetRepository->deleteTypeMoulinet($id_type_moulinet);
    
            if ($deleteTypeMoulinet)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression du type de moulinet échoué';
                header('location: admin.php');
            }
        }
        
    // }
    // else
    // {
    //     home();
    // }
}

function UpdateCanneTraitement()
{
    // if($_SESSION['id_role'] === 1)
    // { 
    $img = new ImageCanneRepository;
    $oldImg = $img->getImageByCanne($_POST['id_canne']);

    $cheminFichier = $oldImg->getNomImageCanne();

    if (file_exists($cheminFichier)) 
    {
        if (unlink($cheminFichier)) 
        {
            echo "Le fichier a été supprimé avec succès.";
        }
        else 
        {
            echo "Une erreur s'est produite lors de la suppression du fichier.";
            die;
        }
    }

    if(isset($_POST['id_canne']) && isset($_POST['nom_canne']) && isset($_POST['poids_canne']) && isset($_POST['longueur_canne']) && isset($_POST['description_canne']) && isset($_POST['promo_canne']) && isset($_POST['stock_canne']) && isset($_POST['categorie_canne']) && isset($_POST['type_canne']) && isset($_POST['marque_canne']) && isset($_FILES['image_canne']))
    {
        $id_canne = isset($_POST['id_canne']) ? htmlspecialchars($_POST['id_canne']) : null;
        $nom_canne = isset($_POST['nom_canne']) ? htmlspecialchars($_POST['nom_canne']) : null;
        $poids_canne = isset($_POST['poids_canne']) ? htmlspecialchars($_POST['poids_canne']) : null;
        $longueur_canne = isset($_POST['longueur_canne']) ? htmlspecialchars($_POST['longueur_canne']) : null;
        $description_canne = isset($_POST['description_canne']) ? htmlspecialchars($_POST['description_canne']) : null;
        $promo_canne = isset($_POST['promo_canne']) ? htmlspecialchars($_POST['promo_canne']) : null;
        $stock_canne = isset($_POST['stock_canne']) ? htmlspecialchars($_POST['stock_canne']) : null;
        $id_categorie = isset($_POST['categorie_canne']) ? htmlspecialchars($_POST['categorie_canne']) : null;
        $id_type_canne = isset($_POST['type_canne']) ? htmlspecialchars($_POST['type_canne']) : null;
        $id_marque = isset($_POST['marque_canne']) ? htmlspecialchars($_POST['marque_canne']) : null;
        $image_canne = isset($_FILES['image_canne']) ? $_FILES['image_canne'] : null;

        if($stock_canne === 'stock') 
        {
            $stock_canne = 1;
            $hors_stock_canne = 0;
        }
        else
        {
            $stock_canne = 0;
            $hors_stock_canne = 1;
        }

        if($promo_canne === 'promo')
        {
            $promo_canne = 1;
        }
        else
        {
            $promo_canne = 0;
        }

        $canneRepository = new CanneRepository;
        $imageCanneRepo = new ImageCanneRepository;
        
        $update = $canneRepository->updateCanne($id_canne, $nom_canne, $poids_canne, $longueur_canne, $description_canne, $promo_canne, $stock_canne, $hors_stock_canne, $id_categorie, $id_type_canne, $id_marque);
        $updateImageCanne = $imageCanneRepo->updateImageByCanne($image_canne, $id_canne);
        
        if ($update && $updateImageCanne)
        {
            header("location:admin.php");
        }
        else 
        {
            echo 'non';
        }
    } 
    // }
    // else
    // {
    //     home();
    // }
}

function UpdateMoulinetTraitement()
{
    // if($_SESSION['id_role'] === 1)
    // { 
    $img = new ImageMoulinetRepository;
    $oldImg = $img->getImageByMoulinet($_POST['id_moulinet']);

    $cheminFichier = $oldImg->getNomImageMoulinet();

    if (file_exists($cheminFichier)) 
    {
        if (unlink($cheminFichier)) 
        {
            echo "Le fichier a été supprimé avec succès.";
        }
        else 
        {
            echo "Une erreur s'est produite lors de la suppression du fichier.";
            die;
        }
    }

    if(isset($_POST['id_moulinet']) && isset($_POST['nom_moulinet']) && isset($_POST['poids_moulinet']) && isset($_POST['ratio_moulinet']) && isset($_POST['description_moulinet']) && isset($_POST['promo_moulinet']) && isset($_POST['stock_moulinet']) && isset($_POST['categorie_moulinet']) && isset($_POST['type_moulinet']) && isset($_POST['marque_moulinet']) && isset($_FILES['image_moulinet']))
    {
        $id_moulinet = isset($_POST['id_moulinet']) ? htmlspecialchars($_POST['id_moulinet']) : null;
        $nom_moulinet = isset($_POST['nom_moulinet']) ? htmlspecialchars($_POST['nom_moulinet']) : null;
        $poids_moulinet = isset($_POST['poids_moulinet']) ? htmlspecialchars($_POST['poids_moulinet']) : null;
        $ratio_moulinet = isset($_POST['ratio_moulinet']) ? htmlspecialchars($_POST['ratio_moulinet']) : null;
        $description_moulinet = isset($_POST['description_moulinet']) ? htmlspecialchars($_POST['description_moulinet']) : null;
        $promo_moulinet = isset($_POST['promo_moulinet']) ? htmlspecialchars($_POST['promo_moulinet']) : null;
        $stock_moulinet = isset($_POST['stock_moulinet']) ? htmlspecialchars($_POST['stock_moulinet']) : null;
        $id_categorie = isset($_POST['categorie_moulinet']) ? htmlspecialchars($_POST['categorie_moulinet']) : null;
        $id_type_moulinet = isset($_POST['type_moulinet']) ? htmlspecialchars($_POST['type_moulinet']) : null;
        $id_marque = isset($_POST['marque_moulinet']) ? htmlspecialchars($_POST['marque_moulinet']) : null;
        $image_moulinet = isset($_FILES['image_moulinet']) ? $_FILES['image_moulinet'] : null;

        if($stock_moulinet === 'stock') 
        {
            $stock_moulinet = 1;
            $hors_stock_moulinet = 0;
        }
        else
        {
            $stock_moulinet = 0;
            $hors_stock_moulinet = 1;
        }

        if($promo_moulinet === 'promo')
        {
            $promo_moulinet = 1;
        }
        else
        {
            $promo_moulinet = 0;
        }

        $moulinetRepository = new MoulinetRepository;
        $imageMoulinetRepo = new ImageMoulinetRepository;
        
        $update = $moulinetRepository->updateMoulinet($id_moulinet, $nom_moulinet, $poids_moulinet, $ratio_moulinet, $description_moulinet, $promo_moulinet, $stock_moulinet, $hors_stock_moulinet, $id_categorie, $id_type_moulinet, $id_marque);
        $updateImageMoulinet = $imageMoulinetRepo->updateImageByMoulinet($image_moulinet, $id_moulinet);
        
        if ($update && $updateImageMoulinet)
        {
            header("location:admin.php");
        }
        else 
        {
            echo 'non';
        }
    } 
    // }
    // else
    // {
    //     home();
    // }
}
