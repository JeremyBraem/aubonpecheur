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
            case 'addMoulinetTraitement':
                addMoulinetTraitement();
                break;
            case 'addHameconTraitement':
                addHameconTraitement();
                break;
            case 'addCategorieTraitement':
                addCategorieTraitement();
                break;
            case 'addTypeCanneTraitement':
                addTypeCanneTraitement();
                break;
            case 'addTypeMoulinetTraitement':
                addTypeMoulinetTraitement();
                break;
            case 'addTypeHameconTraitement':
                addTypeHameconTraitement();
                break;
            case 'addMarqueTraitement':
                addMarqueTraitement();
                break;
            case 'deleteCanne':
                deleteCanne();
                break;
            case 'deleteMoulinet':
                deleteMoulinet();
                break;
            case 'deleteHamecon':
                deleteHamecon();
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
            case 'deleteTypeMoulinet':
                deleteTypeMoulinet();
                break;
            case 'deleteTypeHamecon':
                deleteTypeHamecon();
                break;
            case 'UpdateMoulinetTraitement':
                UpdateMoulinetTraitement();
                break;
            case 'UpdateHameconTraitement':
                UpdateHameconTraitement();
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