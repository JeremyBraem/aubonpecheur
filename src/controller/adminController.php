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

function viewAllMarque()
{
    $marqueRepo = new MarqueRepository;
    $marqueRepo->getAllMarque();
}


