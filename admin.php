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
            default:
            home();
        }
    }
    else
    {
        adminPage();
    }
?>