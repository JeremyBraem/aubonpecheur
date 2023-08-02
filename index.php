<?php
session_start();
require_once('src/controller/homeController.php');

if(isset($_GET['action']) && $_GET['action'] !== '')
{
    switch($_GET['action'])
    {
        case 'accueil':
            home();
            break;
        case 'articlePage':
            articlePage();
            break;
        case 'promotion':
            promoPage();
            break;
        case 'login':
            loginPage();
            break;
        case 'loginTraitement':
            loginTraitement();
            break;
        case 'signUp':
            signUpPage();
            break;
        case 'signUpTraitement':
            signUpTraitement();
            break;
        case 'deconnexion':
            disconnectUser();
            break;
        case 'cannePage':
            cannePage();
            break;
        case 'moulinetPage':
            moulinetPage();
            break;
        case 'hameconPage':
            hameconPage();
            break;
        case 'leurrePage':
            leurrePage();
            break;
        case 'plombPage':
            plombPage();
            break;
        case 'appatPage':
            appatPage();
            break;
        case 'equipementPage':
            equipementPage();
            break;
        case 'lignePage':
            lignePage();
            break;
        case 'filtre':
            filtre();
            break;
        case 'allCanne':
            allCannePage();
            break;
        case 'Equipement':
            allEquipementPage();
            break;
        case 'filtreCanne':
            filtreCanne();
            break;
        case 'filtreEquipement':
            filtreEquipement();
            break;
        case 'article':
            viewPageCategorie();
            break;
        case 'marque':
            viewPageMarque();
            break;
        case 'filtrePageCate':
            filtrePageCate();
            break;
        case 'filtrePageMarque':
            filtrePageMarque();
            break;
        case 'filtrePromo':
            filtrePromo();
            break;
        case 'Marque':
            marquePage();
            break;
        case 'profil':
            profilPage();
            break;
        case 'search':
            searchPage();
            break;
        case 'panier':
            pagePanier();
            break;
        case 'commande':
            pageCommande();
            break;
        case 'addCommande':
            addCommande();
            break;
        case 'updateUser':
            updateUser();
            break;
        default:
        home();
    }
}
else
{
    home();
}

?>