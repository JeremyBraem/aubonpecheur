<?php

require ('src/controller/homeController.php');

if(isset($_GET['action']) && $_GET['action'] !== '')
    {
        switch($_GET['action']) 
        {
            case 'accueil':
                home();
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