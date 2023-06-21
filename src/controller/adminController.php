<?php

require_once('autoload/autoloader.php');
require_once('src/model/Canne.php');
require_once('src/model/Marque.php');
require_once('src/model/Categorie.php');
require_once('src/model/Type/TypeCanne.php');

function adminPage()
{
    $canneRepo = new CanneRepository;
    $cannes = $canneRepo->getAllCanne();
    $typeCanneRepo = new TypeCanneRepository;
    $typeCannes = $typeCanneRepo->getAllTypeCanne();
    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();
    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();
    require('src/view/adminPage.php');
}

function viewAllProduct()
{
    $canneRepo = new CanneRepository;
    $canneRepo->getAllCanne();
}

function addCanneTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_canne']) && !empty($_POST['poids_canne']) && !empty($_POST['longueur_canne']) && !empty($_POST['categorie_canne']) && !empty($_POST['type_canne']) && !empty($_POST['marque_canne']) && !empty($_POST['promo_canne']) && !empty($_POST['stock_canne']) && !empty($_POST['description_canne']))
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

            $canne = new Canne;
            $canne->createToInsertCanne($newCanne);

            if($canne == true)
            {
                $canneRepo = new CanneRepository;
                $canneRepo->insertCanne($canne);
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
        if(!empty($_POST['nom_marque']))
        {
            $newMarque = [];
            $newMarque['nom_marque'] = htmlspecialchars($_POST['nom_marque']);

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

function deleteCanne()
{
    // if($_SESSION['id_role'] === 1)
    // {
        if(!empty($_POST['id_canne']) && isset($_POST['id_canne']))
        {
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
            $marqueRepository = new MarqueRepository();
            $deleteMarque = $marqueRepository->deleteMarque($id_marque);
    
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

function UpdateCanneTraitement()
{
    // if($_SESSION['id_role'] === 1)
    // {
        if(isset($_POST['id_canne']) && isset($_POST['nom_canne']) && isset($_POST['poids_canne']) && isset($_POST['longueur_canne']) && isset($_POST['description_canne']) && isset($_POST['promo_canne']) && isset($_POST['stock_canne']) && isset($_POST['categorie_canne']) && isset($_POST['type_canne']) && isset($_POST['marque_canne']))
        {
            $id_canne = isset($_POST['id_canne']) ? htmlspecialchars($_POST['id_canne']) : null;
            $nom_canne = isset($_POST['nom_canne']) ? htmlspecialchars($_POST['nom_canne']) : null;
            $poids_canne = isset($_POST['poids_canne']) ? htmlspecialchars($_POST['poids_canne']) : null;
            $longueur_canne = isset($_POST['longueur_canne']) ? htmlspecialchars($_POST['longueur_canne']) : null;
            $description_canne = isset($_POST['description_canne']) ? htmlspecialchars($_POST['nom_canne']) : null;
            $promo_canne = isset($_POST['promo_canne']) ? htmlspecialchars($_POST['promo_canne']) : null;
            $stock_canne = isset($_POST['stock_canne']) ? htmlspecialchars($_POST['stock_canne']) : null;
            $hors_stock_canne = isset($_POST['hors_stock_canne']) ? htmlspecialchars($_POST['hors_stock_canne']) : null;
            $id_categorie = isset($_POST['id_categorie']) ? htmlspecialchars($_POST['id_categorie']) : null;
            $id_type_canne = isset($_POST['id_type_canne']) ? htmlspecialchars($_POST['id_type_canne']) : null;
            $id_marque = isset($_POST['id_marque']) ? htmlspecialchars($_POST['id_marque']) : null;
            $canneRepository = new CanneRepository();
            $update = $canneRepository->updateCanne($id_canne, $nom_canne, $poids_canne, $longueur_canne, $description_canne, $promo_canne, $stock_canne, $hors_stock_canne, $id_categorie, $id_type_canne, $id_marque);
            
            if ($update)
            {
                header("location:admin.php");
            }
            else 
            {
                header("location:admin.php");
            }
        }
      
    // }
    // else
    // {
    //     home();
    // }
}
