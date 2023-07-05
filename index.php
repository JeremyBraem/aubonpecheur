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
        case 'promoPage':
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
        case 'filtreCanne':
            filtreCanne();
            break;
        case 'article':
            viewPageCategorie();
            break;
        case 'articleM':
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
        case 'marquePage':
            marquePage();
            break;
        case 'profil':
            profilPage();
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