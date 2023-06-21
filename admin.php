<?php
session_start();
require ('src/controller/adminController.php');

if(isset($_GET['action']) && $_GET['action'] !== '')
    {
        switch($_GET['action'])
        {
            case 'admin':
                adminPage();
                break;
            case 'addCanneTraitement':
                addCanneTraitement();
                break;
            case 'addCategorieTraitement':
                addCategorieTraitement();
                break;
            case 'addTypeCanneTraitement':
                addTypeCanneTraitement();
                break;
            case 'addMarqueTraitement':
                addMarqueTraitement();
                break;
            case 'deleteCanne':
                deleteCanne();
                break;
            case 'deleteCategorie':
                deleteCategorie();
                break;
            case 'deleteMarque':
                deleteMarque();
                break;
            case 'deleteTypeCanne':
                deleteTypeCanne();
                break;
            case 'UpdateCanneTraitement':
                UpdateCanneTraitement();
                break;
            default:
            adminPage();
        }
    }
    else
    {
        adminPage();
    }
?>