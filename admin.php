<?php
session_start();
require('src/controller/adminController.php');

if ($_SESSION['id_role'] == 1) 
{
    if (isset($_GET['action']) && $_GET['action'] !== '') 
    {
        switch ($_GET['action']) 
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
            case 'addLigneTraitement':
                addLigneTraitement();
                break;
            case 'addPlombTraitement':
                addPlombTraitement();
                break;
            case 'addAppatTraitement':
                addAppatTraitement();
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
            case 'addTypeLeurreTraitement':
                addTypeLeurreTraitement();
                break;
            case 'addTypeEquipementTraitement':
                addTypeEquipementTraitement();
                break;
            case 'addTypeLigneTraitement':
                addTypeLigneTraitement();
                break;
            case 'addTypePlombTraitement':
                addTypePlombTraitement();
                break;
            case 'addTypeAppatTraitement':
                addTypeAppatTraitement();
                break;
            case 'addTypeAutreTraitement':
                addTypeAutreTraitement();
                break;
            case 'addMarqueTraitement':
                addMarqueTraitement();
                break;
            case 'addLeurreTraitement':
                addLeurreTraitement();
                break;
            case 'addEquipementTraitement':
                addEquipementTraitement();
                break;
            case 'addAutreTraitement':
                addAutreTraitement();
                break;
            case 'deleteCanne':
                deleteCanne();
                break;
            case 'deleteMoulinet':
                deleteMoulinet();
                break;
            case 'deleteLeurre':
                deleteLeurre();
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
            case 'deleteLigne':
                deleteLigne();
                break;
            case 'deletePlomb':
                deletePlomb();
                break;
            case 'deleteAppat':
                deleteAppat();
                break;
            case 'deleteAutre':
                deleteAutre();
                break;
            case 'deleteEquipement':
                deleteEquipement();
                break;
            case 'deleteTypeCanne':
                deleteTypeCanne();
                break;
            case 'updateCanneTraitement':
                updateCanneTraitement();
                break;
            case 'deleteTypeMoulinet':
                deleteTypeMoulinet();
                break;
            case 'deleteTypeHamecon':
                deleteTypeHamecon();
                break;
            case 'deleteTypeLeurre':
                deleteTypeLeurre();
                break;
            case 'deleteTypeLigne':
                deleteTypeLigne();
                break;
            case 'deleteTypePlomb':
                deleteTypePlomb();
                break;
            case 'deleteTypeAppat':
                deleteTypeAppat();
                break;
            case 'deleteTypeAutre':
                deleteTypeAutre();
                break;
            case 'deleteTypeEquipement':
                deleteTypeEquipement();
                break;
            case 'updateMoulinetTraitement':
                updateMoulinetTraitement();
                break;
            case 'UpdateHameconTraitement':
                UpdateHameconTraitement();
                break;
            case 'updateLeurreTraitement':
                updateLeurreTraitement();
                break;
            case 'UpdateLigneTraitement':
                updateLigneTraitement();
                break;
            case 'UpdatePlombTraitement':
                UpdatePlombTraitement();
                break;
            case 'updateEquipementTraitement':
                updateEquipementTraitement();
                break;
            case 'updateAppatTraitement':
                updateAppatTraitement();
                break;
            case 'updateAutreTraitement':
                updateAutreTraitement();
                break;
            case 'search':
                searchPage();
                break;
           
            default:
                adminPage();
        }
    }
    else 
    {
        adminPage();
    }
}
else
{
    header('location: /home');
}
?>