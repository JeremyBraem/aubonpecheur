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
            case 'addFeederTraitement':
                addFeederTraitement();
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
            case 'addTypeFeederTraitement':
                addTypeFeederTraitement();
                break;
            case 'addTypeAppatTraitement':
                addTypeAppatTraitement();
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
            case 'deleteFeeder':
                deleteFeeder();
                break;
            case 'deleteAppat':
                deleteAppat();
                break;
            case 'deleteEquipement':
                deleteEquipement();
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
            case 'deleteTypeLeurre':
                deleteTypeLeurre();
                break;
            case 'deleteTypeLigne':
                deleteTypeLigne();
                break;
            case 'deleteTypeFeeder':
                deleteTypeFeeder();
                break;
            case 'deleteTypeAppat':
                deleteTypeAppat();
                break;
            case 'deleteTypeEquipement':
                deleteTypeEquipement();
                break;
            case 'UpdateMoulinetTraitement':
                UpdateMoulinetTraitement();
                break;
            case 'UpdateHameconTraitement':
                UpdateHameconTraitement();
                break;
            case 'UpdateLeurreTraitement':
                UpdateLeurreTraitement();
                break;
            case 'UpdateLigneTraitement':
                UpdateLigneTraitement();
                break;
            case 'UpdateFeederTraitement':
                UpdateFeederTraitement();
                break;
            case 'UpdateEquipementTraitement':
                UpdateEquipementTraitement();
                break;
            case 'UpdateAppatTraitement':
                UpdateAppatTraitement();
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