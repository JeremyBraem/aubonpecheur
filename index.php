<?php
session_start();
require ('src/controller/homeController.php');

if(isset($_GET['action']) && $_GET['action'] !== '')
    {
        switch($_GET['action'])
        {
            case 'accueil':
                home();
                break;
            case 'page':
                articlePage();
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
            default:
            home();
        }
    }
    else
    {
        home();
    }
?>