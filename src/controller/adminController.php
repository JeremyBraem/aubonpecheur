<?php
require_once('src/model/Produit.php');
require_once('src/model/Canne.php');
require_once('src/model/Moulinet.php');
require_once('src/model/Hamecon.php');
require_once('src/model/Image.php');

require_once('src/model/Produit/Leurre.php');
require_once('src/model/Produit/Ligne.php');
require_once('src/model/Produit/Equipement.php');
require_once('src/model/Produit/Feeder.php');
require_once('src/model/Produit/Appat.php');

require_once('src/model/Marque.php');
require_once('src/model/Categorie.php');

require_once('src/model/Type/TypeCanne.php');
require_once('src/model/Type/TypeMoulinet.php');
require_once('src/model/Type/TypeHamecon.php');
require_once('src/model/Type/TypeLeurre.php');
require_once('src/model/Type/TypeLigne.php');
require_once('src/model/Type/TypeEquipement.php');
require_once('src/model/Type/TypeFeeder.php');
require_once('src/model/Type/TypeAppat.php');

require_once('src/model/Image/ImageCanne.php');
require_once('src/model/Image/ImageMoulinet.php');
require_once('src/model/Image/ImageHamecon.php');
require_once('src/model/Image/ImageLeurre.php');
require_once('src/model/Image/ImageLigne.php');
require_once('src/model/Image/ImageEquipement.php');
require_once('src/model/Image/ImageFeeder.php');
require_once('src/model/Image/ImageAppat.php');

function adminPage()
{
    $produitRepo = new ProduitRepository();

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();

    $allProduits = getAllProducts();

    $canneRepo = new CanneRepository;
    $cannes = $canneRepo->getAllCanne();

    foreach($cannes as $canne)
    {
        $idPCannes[] = $canne['id_produit'];
    }

    foreach($idPCannes as $idPCanne)
    {
        $canneInfo = $canneRepo->getInfoCanne($idPCanne);
    }
    
    $moulinetRepo = new MoulinetRepository;
    $moulinets = $moulinetRepo->getAllMoulinet();

    foreach($moulinets as $moulinet)
    {
        $idPMoulinets[] = $moulinet['id_produit'];
    }

    foreach($idPMoulinets as $idPMoulinet)
    {
        $moulinetInfo = $moulinetRepo->getInfoMoulinet($idPMoulinet);
    }

    $hameconRepo = new HameconRepository;
    $hamecons = $hameconRepo->getAllHamecon();

    foreach($hamecons as $hamecon)
    {
        $idPHamecons[] = $hamecon['id_produit'];
    }

    foreach($idPHamecons as $idPHamecon)
    {
        $hameconInfo = $hameconRepo->getInfoHamecon($idPHamecon);
    }
    require('src/view/adminPage.php');
}

function addCanneTraitement()
{
    if (isset($_POST)) 
    {
        if (!empty($_POST['nom_produit']) && !empty($_POST['poids_canne']) && !empty($_POST['longueur_canne']) && !empty($_POST['categorie_produit']) && !empty($_POST['type_canne']) && !empty($_POST['marque_produit']) && !empty($_POST['promo_produit']) && !empty($_POST['stock_produit']) && !empty($_POST['description_produit']) && !empty($_POST['prix_produit']) && !empty($_FILES['images'])) 
        {
            $genre = 3;
            $prixPromo = 12;
            $newCanne = new Canne
            (
                htmlspecialchars($_POST['nom_produit']),
                htmlspecialchars($_POST['description_produit']),
                htmlspecialchars($_POST['prix_produit']),
                htmlspecialchars($_POST['stock_produit']),
                htmlspecialchars($_POST['promo_produit']),
                htmlspecialchars($prixPromo),
                htmlspecialchars($_POST['categorie_produit']),
                htmlspecialchars($_POST['marque_produit']),
                htmlspecialchars($genre),
                htmlspecialchars($_POST['longueur_canne']),
                htmlspecialchars($_POST['poids_canne']),
                htmlspecialchars($_POST['type_canne'])
            );

            if ($_POST['stock_produit'] === 'stock') 
            {
                $stock = 1;
            } else {
                $stock = 0;
            }

            if ($_POST['promo_produit'] === 'promo') 
            {
                $promo = 1;
            } 
            else 
            {
                $promo = 0;
            }

            $newCanne->setNomProduit(htmlspecialchars($_POST['nom_produit']));
            $newCanne->setDescriptionProduit(htmlspecialchars($_POST['description_produit']));
            $newCanne->setPrixProduit(htmlspecialchars($_POST['prix_produit']));
            $newCanne->setStockProduit(htmlspecialchars($stock));
            $newCanne->setPromoProduit(htmlspecialchars($promo));
            $newCanne->setCategorieProduit(htmlspecialchars($_POST['categorie_produit']));
            $newCanne->setMarqueProduit(htmlspecialchars($_POST['marque_produit']));
            $newCanne->setCategorieProduit(htmlspecialchars($_POST['categorie_produit']));
            $newCanne->setGenreProduit(htmlspecialchars($genre));
            $newCanne->setPrixPromoProduit(htmlspecialchars($prixPromo));

            $produitRepo = new ProduitRepository();
            $canneRepo = new CanneRepository();
            
            $canneRepo->addCanne($newCanne);

            if (isset($_FILES['images']) && $_FILES['images']['name']) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    $image_repo = new ImageRepository;
                    $image_repo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }

                $image_repo = new ImageRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastInsertId();
                $idImage = $image_repo->getLastInsertId();
                $image_repo->addImageToProduit($idProduit, $idImage);
            }

            header('Location: admin.php');
            exit();
        }
    }
}

function updateCanneTraitement()
{if (isset($_POST)) 
    {
        if (!empty($_POST['nom_produit']) && !empty($_POST['poids_canne']) && !empty($_POST['longueur_canne']) && !empty($_POST['categorie_produit']) && !empty($_POST['type_canne']) && !empty($_POST['marque_produit']) && !empty($_POST['promo_produit']) && !empty($_POST['stock_produit']) && !empty($_POST['description_produit']) && !empty($_POST['prix_produit']) && !empty($_FILES['images'])) 
        {
            $genre = 3;
            $prixPromo = 12;
            $newCanne = new Canne
            (
                htmlspecialchars($_POST['nom_produit']),
                htmlspecialchars($_POST['description_produit']),
                htmlspecialchars($_POST['prix_produit']),
                htmlspecialchars($_POST['stock_produit']),
                htmlspecialchars($_POST['promo_produit']),
                htmlspecialchars($prixPromo),
                htmlspecialchars($_POST['categorie_produit']),
                htmlspecialchars($_POST['marque_produit']),
                htmlspecialchars($genre),
                htmlspecialchars($_POST['longueur_canne']),
                htmlspecialchars($_POST['poids_canne']),
                htmlspecialchars($_POST['type_canne'])
            );

            if ($_POST['stock_produit'] === 'stock') 
            {
                $stock = 1;
            } else {
                $stock = 0;
            }

            
            if ($_POST['promo_produit'] === 'promo') 
            {
                $promo = 1;
            } 
            else 
            {
                $promo = 0;
            }

            $newCanne->setIdProduit(htmlspecialchars($_POST['id_produit']));
            $newCanne->setNomProduit(htmlspecialchars($_POST['nom_produit']));
            $newCanne->setDescriptionProduit(htmlspecialchars($_POST['description_produit']));
            $newCanne->setPrixProduit(htmlspecialchars($_POST['prix_produit']));
            $newCanne->setStockProduit(htmlspecialchars($stock));
            $newCanne->setPromoProduit(htmlspecialchars($promo));
            $newCanne->setCategorieProduit(htmlspecialchars($_POST['categorie_produit']));
            $newCanne->setMarqueProduit(htmlspecialchars($_POST['marque_produit']));
            $newCanne->setCategorieProduit(htmlspecialchars($_POST['categorie_produit']));
            $newCanne->setGenreProduit(htmlspecialchars($genre));
            $newCanne->setPrixPromoProduit(htmlspecialchars($prixPromo));

            $produitRepo = new ProduitRepository();
            $canneRepo = new CanneRepository();
            
            $canneRepo->updateCanne($newCanne);

            if (isset($_FILES['images']) && $_FILES['images']['name']) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    $image_repo = new ImageRepository;
                    $image_repo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }

                $image_repo = new ImageRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastInsertId();
                $idImage = $image_repo->getLastInsertId();
                $image_repo->addImageToProduit($idProduit, $idImage);
            }

            header('Location: admin.php');
            exit();
        }
    }
}

function deleteCanne()
{
    if (isset($_POST['id_produit']))
    {
        $id_produit = $_POST['id_produit'];

        $canneRepo = new CanneRepository();
        $imageRepo = new ImageRepository();
        $produitRepo = new ProduitRepository();

        $imageRepo->deleteImagesByProduit($id_produit);

        $canneRepo->deleteCanne($id_produit);

        $produitRepo->deleteProduit($id_produit);

        header('Location: admin.php');
    } 
    else 
    {
        echo "ID de la canne manquant.";
    }
}

function addMoulinetTraitement()
{
    if (isset($_POST)) 
    {
       
        if (!empty($_POST['nom_produit']) && !empty($_POST['poids_moulinet']) && !empty($_POST['ratio_moulinet']) && !empty($_POST['categorie_produit']) && !empty($_POST['type_moulinet']) && !empty($_POST['marque_produit']) && !empty($_POST['promo_produit']) && !empty($_POST['stock_produit']) && !empty($_POST['description_produit']) && !empty($_POST['prix_produit']) && !empty($_FILES['images'])) 
        {
            $genre = 2;
            $prixPromo = 12;
            $newMoulinet = new Moulinet
            (
                htmlspecialchars($_POST['nom_produit']),
                htmlspecialchars($_POST['description_produit']),
                htmlspecialchars($_POST['prix_produit']),
                htmlspecialchars($_POST['stock_produit']),
                htmlspecialchars($_POST['promo_produit']),
                htmlspecialchars($prixPromo),
                htmlspecialchars($_POST['categorie_produit']),
                htmlspecialchars($_POST['marque_produit']),
                htmlspecialchars($genre),
                htmlspecialchars($_POST['ratio_moulinet']),
                htmlspecialchars($_POST['poids_moulinet']),
                htmlspecialchars($_POST['type_moulinet'])
            );

            if ($_POST['stock_produit'] === 'stock') 
            {
                $stock = 1;
            } else {
                $stock = 0;
            }

            if ($_POST['promo_produit'] === 'promo') 
            {
                $promo = 1;
            } 
            else 
            {
                $promo = 0;
            }

            $newMoulinet->setNomProduit(htmlspecialchars($_POST['nom_produit']));
            $newMoulinet->setDescriptionProduit(htmlspecialchars($_POST['description_produit']));
            $newMoulinet->setPrixProduit(htmlspecialchars($_POST['prix_produit']));
            $newMoulinet->setStockProduit(htmlspecialchars($stock));
            $newMoulinet->setPromoProduit(htmlspecialchars($promo));
            $newMoulinet->setMarqueProduit(htmlspecialchars($_POST['marque_produit']));
            $newMoulinet->setCategorieProduit(htmlspecialchars($_POST['categorie_produit']));
            $newMoulinet->setGenreProduit(htmlspecialchars($genre));
            $newMoulinet->setPrixPromoProduit(htmlspecialchars($prixPromo));

            $produitRepo = new ProduitRepository();
            $moulinetRepo = new MoulinetRepository();
            
            $moulinetRepo->addMoulinet($newMoulinet);

            if (isset($_FILES['images']) && $_FILES['images']['name']) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    $image_repo = new ImageRepository;
                    $image_repo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }

                $image_repo = new ImageRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastInsertId();
                $idImage = $image_repo->getLastInsertId();
                $image_repo->addImageToProduit($idProduit, $idImage);
            }

            header('Location: admin.php');
            exit();
        }
    }
}

function updateMoulinetTraitement()
{
    if (isset($_POST)) 
    {
        if (!empty($_POST['nom_produit']) && !empty($_POST['poids_moulinet']) && !empty($_POST['ratio_moulinet']) && !empty($_POST['categorie_produit']) && !empty($_POST['type_moulinet']) && !empty($_POST['marque_produit']) && !empty($_POST['promo_produit']) && !empty($_POST['stock_produit']) && !empty($_POST['description_produit']) && !empty($_POST['prix_produit']) && !empty($_FILES['images'])) 
        {
            $genre = 2;
            $prixPromo = 12;
            $newMoulinet = new Moulinet
            (
                htmlspecialchars($_POST['nom_produit']),
                htmlspecialchars($_POST['description_produit']),
                htmlspecialchars($_POST['prix_produit']),
                htmlspecialchars($_POST['stock_produit']),
                htmlspecialchars($_POST['promo_produit']),
                htmlspecialchars($prixPromo),
                htmlspecialchars($_POST['categorie_produit']),
                htmlspecialchars($_POST['marque_produit']),
                htmlspecialchars($genre),
                htmlspecialchars($_POST['ratio_moulinet']),
                htmlspecialchars($_POST['poids_moulinet']),
                htmlspecialchars($_POST['type_moulinet'])
            );

            if ($_POST['stock_produit'] === 'stock') 
            {
                $stock = 1;
            } else {
                $stock = 0;
            }

            
            if ($_POST['promo_produit'] === 'promo') 
            {
                $promo = 1;
            } 
            else 
            {
                $promo = 0;
            }

            $newMoulinet->setIdProduit(htmlspecialchars($_POST['id_produit']));
            $newMoulinet->setNomProduit(htmlspecialchars($_POST['nom_produit']));
            $newMoulinet->setDescriptionProduit(htmlspecialchars($_POST['description_produit']));
            $newMoulinet->setPrixProduit(htmlspecialchars($_POST['prix_produit']));
            $newMoulinet->setStockProduit(htmlspecialchars($stock));
            $newMoulinet->setPromoProduit(htmlspecialchars($promo));
            $newMoulinet->setCategorieProduit(htmlspecialchars($_POST['categorie_produit']));
            $newMoulinet->setMarqueProduit(htmlspecialchars($_POST['marque_produit']));
            $newMoulinet->setCategorieProduit(htmlspecialchars($_POST['categorie_produit']));
            $newMoulinet->setGenreProduit(htmlspecialchars($genre));
            $newMoulinet->setPrixPromoProduit(htmlspecialchars($prixPromo));

            $produitRepo = new ProduitRepository();
            $moulinetRepo = new MoulinetRepository();
            
            $moulinetRepo->updateMoulinet($newMoulinet);

            if (isset($_FILES['images']) && $_FILES['images']['name']) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    $image_repo = new ImageRepository;
                    $image_repo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }

                $image_repo = new ImageRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastInsertId();
                $idImage = $image_repo->getLastInsertId();
                $image_repo->addImageToProduit($idProduit, $idImage);
            }

            header('Location: admin.php');
            exit();
        }
    }
}

function deleteMoulinet()
{
    if (isset($_POST['id_produit']))
    {
        $id_produit = $_POST['id_produit'];

        $moulinetRepo = new MoulinetRepository();
        $imageRepo = new ImageRepository();
        $produitRepo = new ProduitRepository();

        $imageRepo->deleteImagesByProduit($id_produit);

        $moulinetRepo->deleteMoulinet($id_produit);

        $produitRepo->deleteProduit($id_produit);

        header('Location: admin.php');
    } 
    else 
    {
        echo "ID de la moulinet manquant.";
    }
}

function addHameconTraitement()
{
    if (isset($_POST)) 
    {
        if (!empty($_POST['nom_produit']) && !empty($_POST['poids_hamecon']) && !empty($_POST['longueur_hamecon']) && !empty($_POST['categorie_produit']) && !empty($_POST['type_hamecon']) && !empty($_POST['marque_produit']) && !empty($_POST['promo_produit']) && !empty($_POST['stock_produit']) && !empty($_POST['description_produit']) && !empty($_POST['prix_produit']) && !empty($_FILES['images'])) 
        {
            $genre = 1;
            $prixPromo = 12;
            $newHamecon = new Hamecon
            (
                htmlspecialchars($_POST['nom_produit']),
                htmlspecialchars($_POST['description_produit']),
                htmlspecialchars($_POST['prix_produit']),
                htmlspecialchars($_POST['stock_produit']),
                htmlspecialchars($_POST['promo_produit']),
                htmlspecialchars($prixPromo),
                htmlspecialchars($_POST['categorie_produit']),
                htmlspecialchars($_POST['marque_produit']),
                htmlspecialchars($genre),
                htmlspecialchars($_POST['longueur_hamecon']),
                htmlspecialchars($_POST['poids_hamecon']),
                htmlspecialchars($_POST['type_hamecon'])
            );

            if ($_POST['stock_produit'] === 'stock') 
            {
                $stock = 1;
            } else {
                $stock = 0;
            }

            if ($_POST['promo_produit'] === 'promo') 
            {
                $promo = 1;
            } 
            else 
            {
                $promo = 0;
            }

            $newHamecon->setNomProduit(htmlspecialchars($_POST['nom_produit']));
            $newHamecon->setDescriptionProduit(htmlspecialchars($_POST['description_produit']));
            $newHamecon->setPrixProduit(htmlspecialchars($_POST['prix_produit']));
            $newHamecon->setStockProduit(htmlspecialchars($stock));
            $newHamecon->setPromoProduit(htmlspecialchars($promo));
            $newHamecon->setCategorieProduit(htmlspecialchars($_POST['categorie_produit']));
            $newHamecon->setMarqueProduit(htmlspecialchars($_POST['marque_produit']));
            $newHamecon->setCategorieProduit(htmlspecialchars($_POST['categorie_produit']));
            $newHamecon->setGenreProduit(htmlspecialchars($genre));
            $newHamecon->setPrixPromoProduit(htmlspecialchars($prixPromo));

            $produitRepo = new ProduitRepository();
            $hameconRepo = new HameconRepository();
            
            $hameconRepo->addHamecon($newHamecon);

            if (isset($_FILES['images']) && $_FILES['images']['name']) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    $image_repo = new ImageRepository;
                    $image_repo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }

                $image_repo = new ImageRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastInsertId();
                $idImage = $image_repo->getLastInsertId();
                $image_repo->addImageToProduit($idProduit, $idImage);
            }

            header('Location: admin.php');
            exit();
        }
    }
}

function updateHameconTraitement()
{if (isset($_POST)) 
    {
        if (!empty($_POST['nom_produit']) && !empty($_POST['poids_hamecon']) && !empty($_POST['longueur_hamecon']) && !empty($_POST['categorie_produit']) && !empty($_POST['type_hamecon']) && !empty($_POST['marque_produit']) && !empty($_POST['promo_produit']) && !empty($_POST['stock_produit']) && !empty($_POST['description_produit']) && !empty($_POST['prix_produit']) && !empty($_FILES['images'])) 
        {
            $genre = 1;
            $prixPromo = 12;
            $newHamecon = new Hamecon
            (
                htmlspecialchars($_POST['nom_produit']),
                htmlspecialchars($_POST['description_produit']),
                htmlspecialchars($_POST['prix_produit']),
                htmlspecialchars($_POST['stock_produit']),
                htmlspecialchars($_POST['promo_produit']),
                htmlspecialchars($prixPromo),
                htmlspecialchars($_POST['categorie_produit']),
                htmlspecialchars($_POST['marque_produit']),
                htmlspecialchars($genre),
                htmlspecialchars($_POST['longueur_hamecon']),
                htmlspecialchars($_POST['poids_hamecon']),
                htmlspecialchars($_POST['type_hamecon'])
            );

            if ($_POST['stock_produit'] === 'stock') 
            {
                $stock = 1;
            } else {
                $stock = 0;
            }

            
            if ($_POST['promo_produit'] === 'promo') 
            {
                $promo = 1;
            } 
            else 
            {
                $promo = 0;
            }

            $newHamecon->setIdProduit(htmlspecialchars($_POST['id_produit']));
            $newHamecon->setNomProduit(htmlspecialchars($_POST['nom_produit']));
            $newHamecon->setDescriptionProduit(htmlspecialchars($_POST['description_produit']));
            $newHamecon->setPrixProduit(htmlspecialchars($_POST['prix_produit']));
            $newHamecon->setStockProduit(htmlspecialchars($stock));
            $newHamecon->setPromoProduit(htmlspecialchars($promo));
            $newHamecon->setCategorieProduit(htmlspecialchars($_POST['categorie_produit']));
            $newHamecon->setMarqueProduit(htmlspecialchars($_POST['marque_produit']));
            $newHamecon->setCategorieProduit(htmlspecialchars($_POST['categorie_produit']));
            $newHamecon->setGenreProduit(htmlspecialchars($genre));
            $newHamecon->setPrixPromoProduit(htmlspecialchars($prixPromo));

            $produitRepo = new ProduitRepository();
            $hameconRepo = new HameconRepository();
            
            $hameconRepo->updateHamecon($newHamecon);

            if (isset($_FILES['images']) && $_FILES['images']['name']) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    $image_repo = new ImageRepository;
                    $image_repo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }

                $image_repo = new ImageRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastInsertId();
                $idImage = $image_repo->getLastInsertId();
                $image_repo->addImageToProduit($idProduit, $idImage);
            }

            header('Location: admin.php');
            exit();
        }
    }
}

function deleteHamecon()
{
    if (isset($_POST['id_produit']))
    {
        $id_produit = $_POST['id_produit'];

        $hameconRepo = new HameconRepository();
        $imageRepo = new ImageRepository();
        $produitRepo = new ProduitRepository();

        $imageRepo->deleteImagesByProduit($id_produit);

        $hameconRepo->deleteHamecon($id_produit);

        $produitRepo->deleteProduit($id_produit);

        header('Location: admin.php');
    } 
    else 
    {
        echo "ID de la hamecon manquant.";
    }
}

function getAllProducts()
{
    $produitRepo = new ProduitRepository();

    $products = $produitRepo->getAllProduct();
    return $products;
}

function addLeurreTraitement()
{
    
    if(isset($_POST))
    {   
        if(!empty($_POST['nom_leurre']) && !empty($_POST['poids_leurre']) && !empty($_POST['couleur_leurre']) && !empty($_POST['categorie_leurre']) && !empty($_POST['type_leurre']) && !empty($_POST['marque_leurre']) && !empty($_POST['promo_leurre']) && !empty($_POST['stock_leurre']) && !empty($_POST['description_leurre'] && !empty($_FILES['image_leurre'])))
        {
            $newLeurre = [];
            $newLeurre['nom_leurre'] = htmlspecialchars($_POST['nom_leurre']);
            $newLeurre['couleur_leurre'] = htmlspecialchars($_POST['couleur_leurre']);
            $newLeurre['poids_leurre'] = htmlspecialchars($_POST['poids_leurre']);
            $newLeurre['categorie_leurre'] = htmlspecialchars($_POST['categorie_leurre']);
            $newLeurre['type_leurre'] = htmlspecialchars($_POST['type_leurre']);
            $newLeurre['marque_leurre'] = htmlspecialchars($_POST['marque_leurre']);
            $newLeurre['description_leurre'] = htmlspecialchars($_POST['description_leurre']);
            $newLeurre['promo_leurre'] = htmlspecialchars($_POST['promo_leurre']);
            $newLeurre['stock_leurre'] = htmlspecialchars($_POST['stock_leurre']);
            $newLeurre['image_leurre'] = $_FILES['image_leurre'];
            
            if($newLeurre['stock_leurre'] === 'stock') 
            {
                $newLeurre['stock_leurre'] = 1;
                $newLeurre['hors_stock_leurre'] = 0;
            }
            else
            {
                $newLeurre['stock_leurre'] = 0;
                $newLeurre['hors_stock_leurre'] = 1;
            }

            if($newLeurre['promo_leurre'] === 'promo')
            {
                $newLeurre['promo_leurre'] = 1;
            }
            else
            {
                $newLeurre['promo_leurre'] = 0;
            }
            
            $imageLeurre = new ImageLeurre;
            $leurre = new Leurre;
            $leurre->createToInsertLeurre($newLeurre);
            
            if($leurre == true)
            {
                $imageLeurre->addImageLeurre($newLeurre['image_leurre']);

                $imageLeurreRepo = new ImageLeurreRepository;
                $leurreRepo = new LeurreRepository;

                $leurreRepo->insertLeurre($leurre);
            
                $lastInsertIdLeurre = $leurreRepo->getLastInsertId();
                
                $imageLeurre->setIdLeurre($lastInsertIdLeurre);
                $imageLeurreRepo->insertImageLeurre($imageLeurre);

                header('location: admin.php');
            }
        }
    }
}

function addLigneTraitement()
{
    if(isset($_POST))
    {
        
        if(!empty($_POST['nom_ligne']) && !empty($_POST['poids_ligne']) && !empty($_POST['diametre_ligne']) && !empty($_POST['longueur_ligne']) && !empty($_POST['categorie_ligne']) && !empty($_POST['type_ligne']) && !empty($_POST['marque_ligne']) && !empty($_POST['promo_ligne']) && !empty($_POST['stock_ligne']) && !empty($_POST['description_ligne'] && !empty($_FILES['image_ligne'])))
        {
            
            $newLigne = [];
            $newLigne['nom_ligne'] = htmlspecialchars($_POST['nom_ligne']);
            $newLigne['longueur_ligne'] = htmlspecialchars($_POST['longueur_ligne']);
            $newLigne['diametre_ligne'] = htmlspecialchars($_POST['diametre_ligne']);
            $newLigne['poids_ligne'] = htmlspecialchars($_POST['poids_ligne']);
            $newLigne['categorie_ligne'] = htmlspecialchars($_POST['categorie_ligne']);
            $newLigne['type_ligne'] = htmlspecialchars($_POST['type_ligne']);
            $newLigne['marque_ligne'] = htmlspecialchars($_POST['marque_ligne']);
            $newLigne['description_ligne'] = htmlspecialchars($_POST['description_ligne']);
            $newLigne['promo_ligne'] = htmlspecialchars($_POST['promo_ligne']);
            $newLigne['stock_ligne'] = htmlspecialchars($_POST['stock_ligne']);
            $newLigne['image_ligne'] = $_FILES['image_ligne'];
            
            if($newLigne['stock_ligne'] === 'stock') 
            {
                $newLigne['stock_ligne'] = 1;
                $newLigne['hors_stock_ligne'] = 0;
            }
            else
            {
                $newLigne['stock_ligne'] = 0;
                $newLigne['hors_stock_ligne'] = 1;
            }

            if($newLigne['promo_ligne'] === 'promo')
            {
                $newLigne['promo_ligne'] = 1;
            }
            else
            {
                $newLigne['promo_ligne'] = 0;
            }
            
            $imageLigne = new ImageLigne;
            $ligne = new Ligne;
            $ligne->createToInsertLigne($newLigne);
            
            if($ligne == true)
            {
                $imageLigne->addImageLigne($newLigne['image_ligne']);

                $imageLigneRepo = new ImageLigneRepository;
                $ligneRepo = new LigneRepository;

                $ligneRepo->insertLigne($ligne);
            
                $lastInsertIdLigne = $ligneRepo->getLastInsertId();
                
                $imageLigne->setIdLigne($lastInsertIdLigne);
                $imageLigneRepo->insertImageLigne($imageLigne);

                header('location: admin.php');
            }
        }
    }
}

function addEquipementTraitement()
{
    if(isset($_POST))
    {
        
        if(!empty($_POST['nom_equipement']) && !empty($_POST['detail_equipement']) && !empty($_POST['categorie_equipement']) && !empty($_POST['type_equipement']) && !empty($_POST['marque_equipement']) && !empty($_POST['promo_equipement']) && !empty($_POST['stock_equipement']) && !empty($_POST['description_equipement'] && !empty($_FILES['image_equipement'])))
        {
            $newEquipement = [];
            $newEquipement['nom_equipement'] = htmlspecialchars($_POST['nom_equipement']);
            $newEquipement['detail_equipement'] = htmlspecialchars($_POST['detail_equipement']);
            $newEquipement['categorie_equipement'] = htmlspecialchars($_POST['categorie_equipement']);
            $newEquipement['type_equipement'] = htmlspecialchars($_POST['type_equipement']);
            $newEquipement['marque_equipement'] = htmlspecialchars($_POST['marque_equipement']);
            $newEquipement['description_equipement'] = htmlspecialchars($_POST['description_equipement']);
            $newEquipement['promo_equipement'] = htmlspecialchars($_POST['promo_equipement']);
            $newEquipement['stock_equipement'] = htmlspecialchars($_POST['stock_equipement']);
            $newEquipement['image_equipement'] = $_FILES['image_equipement'];
            
            if($newEquipement['stock_equipement'] === 'stock') 
            {
                $newEquipement['stock_equipement'] = 1;
                $newEquipement['hors_stock_equipement'] = 0;
            }
            else
            {
                $newEquipement['stock_equipement'] = 0;
                $newEquipement['hors_stock_equipement'] = 1;
            }

            if($newEquipement['promo_equipement'] === 'promo')
            {
                $newEquipement['promo_equipement'] = 1;
            }
            else
            {
                $newEquipement['promo_equipement'] = 0;
            }
            
            $imageEquipement = new ImageEquipement;
            $equipement = new Equipement;
            $equipement->createToInsertEquipement($newEquipement);
            
            if($equipement == true)
            {
                $imageEquipement->addImageEquipement($newEquipement['image_equipement']);

                $imageEquipementRepo = new ImageEquipementRepository;
                $equipementRepo = new EquipementRepository;

                $equipementRepo->insertEquipement($equipement);
            
                $lastInsertIdEquipement = $equipementRepo->getLastInsertId();
                
                $imageEquipement->setIdEquipement($lastInsertIdEquipement);
                $imageEquipementRepo->insertImageEquipement($imageEquipement);

                header('location: admin.php');
            }
        }
    }
}

function addAppatTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_appat']) && !empty($_POST['detail_appat']) && !empty($_POST['categorie_appat']) && !empty($_POST['type_appat']) && !empty($_POST['marque_appat']) && !empty($_POST['promo_appat']) && !empty($_POST['stock_appat']) && !empty($_POST['description_appat'] && !empty($_FILES['image_appat'])))
        {
            $newAppat = [];
            $newAppat['nom_appat'] = htmlspecialchars($_POST['nom_appat']);
            $newAppat['detail_appat'] = htmlspecialchars($_POST['detail_appat']);
            $newAppat['categorie_appat'] = htmlspecialchars($_POST['categorie_appat']);
            $newAppat['type_appat'] = htmlspecialchars($_POST['type_appat']);
            $newAppat['marque_appat'] = htmlspecialchars($_POST['marque_appat']);
            $newAppat['description_appat'] = htmlspecialchars($_POST['description_appat']);
            $newAppat['promo_appat'] = htmlspecialchars($_POST['promo_appat']);
            $newAppat['stock_appat'] = htmlspecialchars($_POST['stock_appat']);
            $newAppat['image_appat'] = $_FILES['image_appat'];
            
            if($newAppat['stock_appat'] === 'stock') 
            {
                $newAppat['stock_appat'] = 1;
                $newAppat['hors_stock_appat'] = 0;
            }
            else
            {
                $newAppat['stock_appat'] = 0;
                $newAppat['hors_stock_appat'] = 1;
            }

            if($newAppat['promo_appat'] === 'promo')
            {
                $newAppat['promo_appat'] = 1;
            }
            else
            {
                $newAppat['promo_appat'] = 0;
            }
            
            $imageAppat = new ImageAppat;
            $appat = new Appat;
            $appat->createToInsertAppat($newAppat);
            
            if($appat == true)
            {
                $imageAppat->addImageAppat($newAppat['image_appat']);

                $imageAppatRepo = new ImageAppatRepository;
                $appatRepo = new AppatRepository;

                $appatRepo->insertAppat($appat);
            
                $lastInsertIdAppat = $appatRepo->getLastInsertId();
                
                $imageAppat->setIdAppat($lastInsertIdAppat);
                $imageAppatRepo->insertImageAppat($imageAppat);

                header('location: admin.php');
            }
        }
    }
}

function addFeederTraitement()
{
    if(isset($_POST))
    {
        
        if(!empty($_POST['nom_feeder']) && !empty($_POST['poids_feeder']) && !empty($_POST['diametre_feeder']) && !empty($_POST['longueur_feeder']) && !empty($_POST['categorie_feeder']) && !empty($_POST['type_feeder']) && !empty($_POST['marque_feeder']) && !empty($_POST['promo_feeder']) && !empty($_POST['stock_feeder']) && !empty($_POST['description_feeder'] && !empty($_FILES['image_feeder'])))
        {
            
            $newFeeder = [];
            $newFeeder['nom_feeder'] = htmlspecialchars($_POST['nom_feeder']);
            $newFeeder['longueur_feeder'] = htmlspecialchars($_POST['longueur_feeder']);
            $newFeeder['diametre_feeder'] = htmlspecialchars($_POST['diametre_feeder']);
            $newFeeder['poids_feeder'] = htmlspecialchars($_POST['poids_feeder']);
            $newFeeder['categorie_feeder'] = htmlspecialchars($_POST['categorie_feeder']);
            $newFeeder['type_feeder'] = htmlspecialchars($_POST['type_feeder']);
            $newFeeder['marque_feeder'] = htmlspecialchars($_POST['marque_feeder']);
            $newFeeder['description_feeder'] = htmlspecialchars($_POST['description_feeder']);
            $newFeeder['promo_feeder'] = htmlspecialchars($_POST['promo_feeder']);
            $newFeeder['stock_feeder'] = htmlspecialchars($_POST['stock_feeder']);
            $newFeeder['image_feeder'] = $_FILES['image_feeder'];
            
            if($newFeeder['stock_feeder'] === 'stock') 
            {
                $newFeeder['stock_feeder'] = 1;
                $newFeeder['hors_stock_feeder'] = 0;
            }
            else
            {
                $newFeeder['stock_feeder'] = 0;
                $newFeeder['hors_stock_feeder'] = 1;
            }

            if($newFeeder['promo_feeder'] === 'promo')
            {
                $newFeeder['promo_feeder'] = 1;
            }
            else
            {
                $newFeeder['promo_feeder'] = 0;
            }
            
            $imageFeeder = new ImageFeeder;
            $feeder = new Feeder;
            $feeder->createToInsertFeeder($newFeeder);
            
            if($feeder == true)
            {
                $imageFeeder->addImageFeeder($newFeeder['image_feeder']);

                $imageFeederRepo = new ImageFeederRepository;
                $feederRepo = new FeederRepository;

                $feederRepo->insertFeeder($feeder);
            
                $lastInsertIdFeeder = $feederRepo->getLastInsertId();
                
                $imageFeeder->setIdFeeder($lastInsertIdFeeder);
                $imageFeederRepo->insertImageFeeder($imageFeeder);

                header('location: admin.php');
            }
        }
    }
}

function addCategorieTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_categorie']))
        {
            $newCategorie = [];
            $newCategorie['nom_categorie'] = htmlspecialchars($_POST['nom_categorie']);

            $categorie = new Categorie;
            $categorie->createToInsertCategorie($newCategorie);

            if($categorie == true)
            {
                $categorieRepo = new CategorieRepository;
                $categorieRepo->insertCategorie($categorie);
                header('location: admin.php');
            }
        }
    }
}

function addMarqueTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_marque']) && !empty($_FILES['image_marque']))
        {
            
            $newMarque = [];
            $newMarque['nom_marque'] = htmlspecialchars($_POST['nom_marque']);
            $newMarque['image_marque'] = $_FILES['image_marque'];
            
            $marque = new Marque;
            $marque->createToInsertMarque($newMarque);
            
            if($marque == true)
            {
                $marqueRepo = new MarqueRepository;
                $marqueRepo->insertMarque($marque);
                header('location:admin.php');
            }
        }
    }
}

function addTypeCanneTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_type_canne']))
        {
            $newTypeCanne = [];
            $newTypeCanne['nom_type_canne'] = htmlspecialchars($_POST['nom_type_canne']);

            $typeCanne = new TypeCanne;
            $typeCanne->createToInserTypeCanne($newTypeCanne);

            if($typeCanne == true)
            {
                $typeCanneRepo = new TypeCanneRepository;
                $typeCanneRepo->insertTypeCanne($typeCanne);
                header('location: admin.php');
            }
        }
    }
}

function addTypeMoulinetTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_type_moulinet']))
        {
            $newTypeMoulinet = [];
            $newTypeMoulinet['nom_type_moulinet'] = htmlspecialchars($_POST['nom_type_moulinet']);

            $typeMoulinet = new TypeMoulinet;
            $typeMoulinet->createToInserTypeMoulinet($newTypeMoulinet);

            if($typeMoulinet == true)
            {
                $typeMoulinetRepo = new TypeMoulinetRepository;
                $typeMoulinetRepo->insertTypeMoulinet($typeMoulinet);
                header('location: admin.php');
            }
        }
    }
}

function addTypeHameconTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_type_hamecon']))
        {
            $newTypeHamecon = [];
            $newTypeHamecon['nom_type_hamecon'] = htmlspecialchars($_POST['nom_type_hamecon']);

            $typeHamecon = new TypeHamecon;
            $typeHamecon->createToInserTypeHamecon($newTypeHamecon);

            if($typeHamecon == true)
            {
                $typeHameconRepo = new TypeHameconRepository;
                $typeHameconRepo->insertTypeHamecon($typeHamecon);
                header('location: admin.php');
            }
        }
    }
}

function addTypeLeurreTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_type_leurre']))
        {
            $newTypeLeurre = [];
            $newTypeLeurre['nom_type_leurre'] = htmlspecialchars($_POST['nom_type_leurre']);

            $typeLeurre = new TypeLeurre;
            $typeLeurre->createToInserTypeLeurre($newTypeLeurre);

            if($typeLeurre == true)
            {
                $typeLeurreRepo = new TypeLeurreRepository;
                $typeLeurreRepo->insertTypeLeurre($typeLeurre);
                header('location: admin.php');
            }
        }
    }
}

function addTypeLigneTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_type_ligne']))
        {
            $newTypeLigne = [];
            $newTypeLigne['nom_type_ligne'] = htmlspecialchars($_POST['nom_type_ligne']);

            $typeLigne = new TypeLigne;
            $typeLigne->createToInserTypeLigne($newTypeLigne);

            if($typeLigne == true)
            {
                $typeLigneRepo = new TypeLigneRepository;
                $typeLigneRepo->insertTypeLigne($typeLigne);
                header('location: admin.php');
            }
        }
    }
}

function addTypeFeederTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_type_feeder']))
        {
            $newTypeFeeder = [];
            $newTypeFeeder['nom_type_feeder'] = htmlspecialchars($_POST['nom_type_feeder']);

            $typeFeeder = new TypeFeeder;
            $typeFeeder->createToInserTypeFeeder($newTypeFeeder);

            if($typeFeeder == true)
            {
                $typeFeederRepo = new TypeFeederRepository;
                $typeFeederRepo->insertTypeFeeder($typeFeeder);
                header('location: admin.php');
            }
        }
    }
}

function addTypeEquipementTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_type_equipement']))
        {
            $newTypeEquipement = [];
            $newTypeEquipement['nom_type_equipement'] = htmlspecialchars($_POST['nom_type_equipement']);

            $typeEquipement = new TypeEquipement;
            $typeEquipement->createToInserTypeEquipement($newTypeEquipement);

            if($typeEquipement == true)
            {
                $typeEquipementRepo = new TypeEquipementRepository;
                $typeEquipementRepo->insertTypeEquipement($typeEquipement);
                header('location: admin.php');
            }
        }
    }
}

function addTypeAppatTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_type_appat']))
        {
            $newTypeAppat = [];
            $newTypeAppat['nom_type_appat'] = htmlspecialchars($_POST['nom_type_appat']);

            $typeAppat = new TypeAppat;
            $typeAppat->createToInserTypeAppat($newTypeAppat);

            if($typeAppat == true)
            {
                $typeAppatRepo = new TypeAppatRepository;
                $typeAppatRepo->insertTypeAppat($typeAppat);
                header('location: admin.php');
            }
        }
    }
}

function deleteLeurre()
{
        if(!empty($_POST['id_leurre']) && isset($_POST['id_leurre']))
        {
            var_dump($_POST);
            die;
            $id_leurre = isset($_POST['id_leurre']) ? $_POST['id_leurre'] : null;
            $leurreRepository = new LeurreRepository();
            $deleteLeurre = $leurreRepository->deleteLeurre($id_leurre);
    
            if ($deleteLeurre)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de l\'article échoué';
                header('location: admin.php');
            }
        }
}

function deleteLigne()
{
        if(!empty($_POST['id_ligne']) && isset($_POST['id_ligne']))
        {
            var_dump($_POST);
            die;
            $id_ligne = isset($_POST['id_ligne']) ? $_POST['id_ligne'] : null;
            $ligneRepository = new LigneRepository();
            $deleteLigne = $ligneRepository->deleteLigne($id_ligne);
    
            if ($deleteLigne)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de l\'article échoué';
                header('location: admin.php');
            }
        }
}

function deleteFeeder()
{
        if(!empty($_POST['id_feeder']) && isset($_POST['id_feeder']))
        {
            var_dump($_POST);
            die;
            $id_feeder = isset($_POST['id_feeder']) ? $_POST['id_feeder'] : null;
            $feederRepository = new FeederRepository();
            $deleteFeeder = $feederRepository->deleteFeeder($id_feeder);
    
            if ($deleteFeeder)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de l\'article échoué';
                header('location: admin.php');
            }
        }
}

function deleteEquipement()
{
        if(!empty($_POST['id_equipement']) && isset($_POST['id_equipement']))
        {
            var_dump($_POST);
            die;
            $id_equipement = isset($_POST['id_equipement']) ? $_POST['id_equipement'] : null;
            $equipementRepository = new EquipementRepository();
            $deleteEquipement = $equipementRepository->deleteEquipement($id_equipement);
    
            if ($deleteEquipement)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de l\'article échoué';
                header('location: admin.php');
            }
        }
}

function deleteAppat()
{
        if(!empty($_POST['id_appat']) && isset($_POST['id_appat']))
        {
            var_dump($_POST);
            die;
            $id_appat = isset($_POST['id_appat']) ? $_POST['id_appat'] : null;
            $appatRepository = new AppatRepository();
            $deleteAppat = $appatRepository->deleteAppat($id_appat);
    
            if ($deleteAppat)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de l\'article échoué';
                header('location: admin.php');
            }
        }
}


function deleteCategorie()
{
        if(!empty($_POST['id_categorie']) && isset($_POST['id_categorie']))
        {
            $id_categorie = isset($_POST['id_categorie']) ? $_POST['id_categorie'] : null;
            $categorieRepository = new CategorieRepository();
            $deleteCategorie = $categorieRepository->deleteCategorie($id_categorie);
    
            if ($deleteCategorie)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de la catégorie échoué';
                header('location: admin.php');
            }
        }
}

function deleteMarque()
{
        if(!empty($_POST['id_marque']) && isset($_POST['id_marque']))
        {
            $id_marque = isset($_POST['id_marque']) ? $_POST['id_marque'] : null;
            $marqueRepository = new MarqueRepository;
            $marque = new Marque;
            $oldImg = $marqueRepository->getMarque($id_marque);
            
            $deleteMarque = $marqueRepository->deleteMarque($id_marque, $oldImg);
    
            if ($deleteMarque)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de la marque échoué';
                header('location: admin.php');
            }
        }
}

function deleteTypeCanne()
{
        if(!empty($_POST['id_type_canne']) && isset($_POST['id_type_canne']))
        {
            $id_type_canne = isset($_POST['id_type_canne']) ? $_POST['id_type_canne'] : null;
            $typeCanneRepository = new TypeCanneRepository();
            $deleteTypeCanne = $typeCanneRepository->deleteTypeCanne($id_type_canne);
    
            if ($deleteTypeCanne)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression du type de canne échoué';
                header('location: admin.php');
            }
        }
}

function deleteTypeMoulinet()
{
        if(!empty($_POST['id_type_moulinet']) && isset($_POST['id_type_moulinet']))
        {
            $id_type_moulinet = isset($_POST['id_type_moulinet']) ? $_POST['id_type_moulinet'] : null;
            $typeMoulinetRepository = new TypeMoulinetRepository();
            $deleteTypeMoulinet = $typeMoulinetRepository->deleteTypeMoulinet($id_type_moulinet);
    
            if ($deleteTypeMoulinet)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression du type de moulinet échoué';
                header('location: admin.php');
            }
        }
}

function deleteTypeHamecon()
{
        if(!empty($_POST['id_type_hamecon']) && isset($_POST['id_type_hamecon']))
        {
            $id_type_hamecon = isset($_POST['id_type_hamecon']) ? $_POST['id_type_hamecon'] : null;
            $typeHameconRepository = new TypeHameconRepository();
            $deleteTypeHamecon = $typeHameconRepository->deleteTypeHamecon($id_type_hamecon);
    
            if ($deleteTypeHamecon)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression du type de hamecon échoué';
                header('location: admin.php');
            }
        }
}

function deleteTypeLeurre()
{
        if(!empty($_POST['id_type_leurre']) && isset($_POST['id_type_leurre']))
        {
            $id_type_leurre = isset($_POST['id_type_leurre']) ? $_POST['id_type_leurre'] : null;
            $typeLeurreRepository = new TypeLeurreRepository();
            $deleteTypeLeurre = $typeLeurreRepository->deleteTypeLeurre($id_type_leurre);
    
            if ($deleteTypeLeurre)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression du type de leurre échoué';
                header('location: admin.php');
            }
        }
}

function deleteTypeLigne()
{
        if(!empty($_POST['id_type_ligne']) && isset($_POST['id_type_ligne']))
        {
            $id_type_ligne = isset($_POST['id_type_ligne']) ? $_POST['id_type_ligne'] : null;
            $typeLigneRepository = new TypeLigneRepository();
            $deleteTypeLigne = $typeLigneRepository->deleteTypeLigne($id_type_ligne);
    
            if ($deleteTypeLigne)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression du type de ligne échoué';
                header('location: admin.php');
            }
        }
}

function deleteTypeFeeder()
{

        if(!empty($_POST['id_type_feeder']) && isset($_POST['id_type_feeder']))
        {
            $id_type_feeder = isset($_POST['id_type_feeder']) ? $_POST['id_type_feeder'] : null;
            $typeFeederRepository = new TypeFeederRepository();
            $deleteTypeFeeder = $typeFeederRepository->deleteTypeFeeder($id_type_feeder);
    
            if ($deleteTypeFeeder)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression du type de feeder échoué';
                header('location: admin.php');
            }
        }
}

function deleteTypeEquipement()
{
        if(!empty($_POST['id_type_equipement']) && isset($_POST['id_type_equipement']))
        {
            $id_type_equipement = isset($_POST['id_type_equipement']) ? $_POST['id_type_equipement'] : null;
            $typeEquipementRepository = new TypeEquipementRepository();
            $deleteTypeEquipement = $typeEquipementRepository->deleteTypeEquipement($id_type_equipement);
    
            if ($deleteTypeEquipement)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression du type de equipement échoué';
                header('location: admin.php');
            }
        }
}

function deleteTypeAppat()
{
        if(!empty($_POST['id_type_appat']) && isset($_POST['id_type_appat']))
        {
            $id_type_appat = isset($_POST['id_type_appat']) ? $_POST['id_type_appat'] : null;
            $typeAppatRepository = new TypeAppatRepository();
            $deleteTypeAppat = $typeAppatRepository->deleteTypeAppat($id_type_appat);
    
            if ($deleteTypeAppat)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression du type de appat échoué';
                header('location: admin.php');
            }
        }
}

function UpdateLeurreTraitement()
{ 
    $img = new ImageLeurreRepository;
    $oldImg = $img->getImageByLeurre($_POST['id_leurre']);

    $cheminFichier = $oldImg->getNomImageLeurre();

    if (file_exists($cheminFichier)) 
    {
        if (unlink($cheminFichier)) 
        {
            echo "Le fichier a été supprimé avec succès.";
        }
        else 
        {
            echo "Une erreur s'est produite lors de la suppression du fichier.";
            die;
        }
    }

    if(isset($_POST['id_leurre']) && isset($_POST['nom_leurre']) && isset($_POST['poids_leurre']) && isset($_POST['couleur_leurre']) && isset($_POST['description_leurre']) && isset($_POST['promo_leurre']) && isset($_POST['stock_leurre']) && isset($_POST['categorie_leurre']) && isset($_POST['type_leurre']) && isset($_POST['marque_leurre']) && isset($_FILES['image_leurre']))
    {
        $id_leurre = isset($_POST['id_leurre']) ? htmlspecialchars($_POST['id_leurre']) : null;
        $nom_leurre = isset($_POST['nom_leurre']) ? htmlspecialchars($_POST['nom_leurre']) : null;
        $poids_leurre = isset($_POST['poids_leurre']) ? htmlspecialchars($_POST['poids_leurre']) : null;
        $couleur_leurre = isset($_POST['couleur_leurre']) ? htmlspecialchars($_POST['couleur_leurre']) : null;
        $description_leurre = isset($_POST['description_leurre']) ? htmlspecialchars($_POST['description_leurre']) : null;
        $promo_leurre = isset($_POST['promo_leurre']) ? htmlspecialchars($_POST['promo_leurre']) : null;
        $stock_leurre = isset($_POST['stock_leurre']) ? htmlspecialchars($_POST['stock_leurre']) : null;
        $id_categorie = isset($_POST['categorie_leurre']) ? htmlspecialchars($_POST['categorie_leurre']) : null;
        $id_type_leurre = isset($_POST['type_leurre']) ? htmlspecialchars($_POST['type_leurre']) : null;
        $id_marque = isset($_POST['marque_leurre']) ? htmlspecialchars($_POST['marque_leurre']) : null;
        $image_leurre = isset($_FILES['image_leurre']) ? $_FILES['image_leurre'] : null;

        if($stock_leurre === 'stock') 
        {
            $stock_leurre = 1;
            $hors_stock_leurre = 0;
        }
        else
        {
            $stock_leurre = 0;
            $hors_stock_leurre = 1;
        }

        if($promo_leurre === 'promo')
        {
            $promo_leurre = 1;
        }
        else
        {
            $promo_leurre = 0;
        }

        $leurreRepository = new LeurreRepository;
        $imageLeurreRepo = new ImageLeurreRepository;
        
        $update = $leurreRepository->updateLeurre($id_leurre, $nom_leurre, $poids_leurre, $couleur_leurre, $description_leurre, $promo_leurre, $stock_leurre, $hors_stock_leurre, $id_categorie, $id_type_leurre, $id_marque);
        $updateImageLeurre = $imageLeurreRepo->updateImageByLeurre($image_leurre, $id_leurre);
        
        if ($update && $updateImageLeurre)
        {
            header("location:admin.php");
        }
        else 
        {
            echo 'non';
        }
    }
}

function UpdateLigneTraitement()
{
    // if($_SESSION['id_role'] === 1)
    // { 
    $img = new ImageLigneRepository;
    $oldImg = $img->getImageByLigne($_POST['id_ligne']);

    $cheminFichier = $oldImg->getNomImageLigne();

    if (file_exists($cheminFichier)) 
    {
        if (unlink($cheminFichier)) 
        {
            echo "Le fichier a été supprimé avec succès.";
        }
        else 
        {
            echo "Une erreur s'est produite lors de la suppression du fichier.";
            die;
        }
    }

    if(isset($_POST['id_ligne']) && isset($_POST['nom_ligne']) && isset($_POST['poids_ligne']) && isset($_POST['longueur_ligne']) && isset($_POST['diametre_ligne']) && isset($_POST['description_ligne']) && isset($_POST['promo_ligne']) && isset($_POST['stock_ligne']) && isset($_POST['categorie_ligne']) && isset($_POST['type_ligne']) && isset($_POST['marque_ligne']) && isset($_FILES['image_ligne']))
    {
        $id_ligne = isset($_POST['id_ligne']) ? htmlspecialchars($_POST['id_ligne']) : null;
        $nom_ligne = isset($_POST['nom_ligne']) ? htmlspecialchars($_POST['nom_ligne']) : null;
        $poids_ligne = isset($_POST['poids_ligne']) ? htmlspecialchars($_POST['poids_ligne']) : null;
        $longueur_ligne = isset($_POST['longueur_ligne']) ? htmlspecialchars($_POST['longueur_ligne']) : null;
        $diametre_ligne = isset($_POST['diametre_ligne']) ? htmlspecialchars($_POST['diametre_ligne']) : null;
        $description_ligne = isset($_POST['description_ligne']) ? htmlspecialchars($_POST['description_ligne']) : null;
        $promo_ligne = isset($_POST['promo_ligne']) ? htmlspecialchars($_POST['promo_ligne']) : null;
        $stock_ligne = isset($_POST['stock_ligne']) ? htmlspecialchars($_POST['stock_ligne']) : null;
        $id_categorie = isset($_POST['categorie_ligne']) ? htmlspecialchars($_POST['categorie_ligne']) : null;
        $id_type_ligne = isset($_POST['type_ligne']) ? htmlspecialchars($_POST['type_ligne']) : null;
        $id_marque = isset($_POST['marque_ligne']) ? htmlspecialchars($_POST['marque_ligne']) : null;
        $image_ligne = isset($_FILES['image_ligne']) ? $_FILES['image_ligne'] : null;

        if($stock_ligne === 'stock') 
        {
            $stock_ligne = 1;
            $hors_stock_ligne = 0;
        }
        else
        {
            $stock_ligne = 0;
            $hors_stock_ligne = 1;
        }

        if($promo_ligne === 'promo')
        {
            $promo_ligne = 1;
        }
        else
        {
            $promo_ligne = 0;
        }

        $ligneRepository = new LigneRepository;
        $imageLigneRepo = new ImageLigneRepository;
        
        $update = $ligneRepository->updateLigne($id_ligne, $nom_ligne, $longueur_ligne, $diametre_ligne, $poids_ligne, $description_ligne, $promo_ligne, $stock_ligne, $hors_stock_ligne, $id_categorie, $id_type_ligne, $id_marque);
        $updateImageLigne = $imageLigneRepo->updateImageByLigne($image_ligne, $id_ligne);
        
        if ($update && $updateImageLigne)
        {
            header("location:admin.php");
        }
        else 
        {
            echo 'non';
        }
    }
}

function UpdateFeederTraitement()
{
    $img = new ImageFeederRepository;
    $oldImg = $img->getImageByFeeder($_POST['id_feeder']);

    $cheminFichier = $oldImg->getNomImageFeeder();

    if (file_exists($cheminFichier)) 
    {
        if (unlink($cheminFichier)) 
        {
            echo "Le fichier a été supprimé avec succès.";
        }
        else 
        {
            echo "Une erreur s'est produite lors de la suppression du fichier.";
            die;
        }
    }

    if(isset($_POST['id_feeder']) && isset($_POST['nom_feeder']) && isset($_POST['poids_feeder']) && isset($_POST['longueur_feeder']) && isset($_POST['diametre_feeder']) && isset($_POST['description_feeder']) && isset($_POST['promo_feeder']) && isset($_POST['stock_feeder']) && isset($_POST['categorie_feeder']) && isset($_POST['type_feeder']) && isset($_POST['marque_feeder']) && isset($_FILES['image_feeder']))
    {
        $id_feeder = isset($_POST['id_feeder']) ? htmlspecialchars($_POST['id_feeder']) : null;
        $nom_feeder = isset($_POST['nom_feeder']) ? htmlspecialchars($_POST['nom_feeder']) : null;
        $poids_feeder = isset($_POST['poids_feeder']) ? htmlspecialchars($_POST['poids_feeder']) : null;
        $longueur_feeder = isset($_POST['longueur_feeder']) ? htmlspecialchars($_POST['longueur_feeder']) : null;
        $diametre_feeder = isset($_POST['diametre_feeder']) ? htmlspecialchars($_POST['diametre_feeder']) : null;
        $description_feeder = isset($_POST['description_feeder']) ? htmlspecialchars($_POST['description_feeder']) : null;
        $promo_feeder = isset($_POST['promo_feeder']) ? htmlspecialchars($_POST['promo_feeder']) : null;
        $stock_feeder = isset($_POST['stock_feeder']) ? htmlspecialchars($_POST['stock_feeder']) : null;
        $id_categorie = isset($_POST['categorie_feeder']) ? htmlspecialchars($_POST['categorie_feeder']) : null;
        $id_type_feeder = isset($_POST['type_feeder']) ? htmlspecialchars($_POST['type_feeder']) : null;
        $id_marque = isset($_POST['marque_feeder']) ? htmlspecialchars($_POST['marque_feeder']) : null;
        $image_feeder = isset($_FILES['image_feeder']) ? $_FILES['image_feeder'] : null;

        if($stock_feeder === 'stock') 
        {
            $stock_feeder = 1;
            $hors_stock_feeder = 0;
        }
        else
        {
            $stock_feeder = 0;
            $hors_stock_feeder = 1;
        }

        if($promo_feeder === 'promo')
        {
            $promo_feeder = 1;
        }
        else
        {
            $promo_feeder = 0;
        }

        $feederRepository = new FeederRepository;
        $imageFeederRepo = new ImageFeederRepository;
        
        $update = $feederRepository->updateFeeder($id_feeder, $nom_feeder, $longueur_feeder, $diametre_feeder, $poids_feeder, $description_feeder, $promo_feeder, $stock_feeder, $hors_stock_feeder, $id_categorie, $id_type_feeder, $id_marque);
        $updateImageFeeder = $imageFeederRepo->updateImageByFeeder($image_feeder, $id_feeder);
        
        if ($update && $updateImageFeeder)
        {
            header("location:admin.php");
        }
        else 
        {
            echo 'non';
        }
    }
}

function UpdateEquipementTraitement()
{
    $img = new ImageEquipementRepository;
    $oldImg = $img->getImageByEquipement($_POST['id_equipement']);

    $cheminFichier = $oldImg->getNomImageEquipement();

    if (file_exists($cheminFichier)) 
    {
        if (unlink($cheminFichier)) 
        {
            echo "Le fichier a été supprimé avec succès.";
        }
        else
        {
            echo "Une erreur s'est produite lors de la suppression du fichier.";
            die;
        }
    }

    if(isset($_POST['id_equipement']) && isset($_POST['nom_equipement']) && isset($_POST['detail_equipement']) && isset($_POST['description_equipement']) && isset($_POST['promo_equipement']) && isset($_POST['stock_equipement']) && isset($_POST['categorie_equipement']) && isset($_POST['type_equipement']) && isset($_POST['marque_equipement']) && isset($_FILES['image_equipement']))
    {
        $id_equipement = isset($_POST['id_equipement']) ? htmlspecialchars($_POST['id_equipement']) : null;
        $nom_equipement = isset($_POST['nom_equipement']) ? htmlspecialchars($_POST['nom_equipement']) : null;
        $detail_equipement = isset($_POST['detail_equipement']) ? htmlspecialchars($_POST['detail_equipement']) : null;
        $description_equipement = isset($_POST['description_equipement']) ? htmlspecialchars($_POST['description_equipement']) : null;
        $promo_equipement = isset($_POST['promo_equipement']) ? htmlspecialchars($_POST['promo_equipement']) : null;
        $stock_equipement = isset($_POST['stock_equipement']) ? htmlspecialchars($_POST['stock_equipement']) : null;
        $id_categorie = isset($_POST['categorie_equipement']) ? htmlspecialchars($_POST['categorie_equipement']) : null;
        $id_type_equipement = isset($_POST['type_equipement']) ? htmlspecialchars($_POST['type_equipement']) : null;
        $id_marque = isset($_POST['marque_equipement']) ? htmlspecialchars($_POST['marque_equipement']) : null;
        $image_equipement = isset($_FILES['image_equipement']) ? $_FILES['image_equipement'] : null;

        if($stock_equipement === 'stock') 
        {
            $stock_equipement = 1;
            $hors_stock_equipement = 0;
        }
        else
        {
            $stock_equipement = 0;
            $hors_stock_equipement = 1;
        }

        if($promo_equipement === 'promo')
        {
            $promo_equipement = 1;
        }
        else
        {
            $promo_equipement = 0;
        }

        $equipementRepository = new EquipementRepository;
        $imageEquipementRepo = new ImageEquipementRepository;
        
        $update = $equipementRepository->updateEquipement($id_equipement, $nom_equipement, $detail_equipement, $description_equipement, $promo_equipement, $stock_equipement, $hors_stock_equipement, $id_categorie, $id_type_equipement, $id_marque);
        $updateImageEquipement = $imageEquipementRepo->updateImageByEquipement($image_equipement, $id_equipement);
        
        if ($update && $updateImageEquipement)
        {
            header("location:admin.php");
        }
        else 
        {
            echo 'non';
        }
    }
}

function UpdateAppatTraitement()
{
    $img = new ImageAppatRepository;
    $oldImg = $img->getImageByAppat($_POST['id_appat']);

    $cheminFichier = $oldImg->getNomImageAppat();

    if (file_exists($cheminFichier)) 
    {
        if (unlink($cheminFichier)) 
        {
            echo "Le fichier a été supprimé avec succès.";
        }
        else 
        {
            echo "Une erreur s'est produite lors de la suppression du fichier.";
            die;
        }
    }

    if(isset($_POST['id_appat']) && isset($_POST['nom_appat']) && isset($_POST['detail_appat']) && isset($_POST['description_appat']) && isset($_POST['promo_appat']) && isset($_POST['stock_appat']) && isset($_POST['categorie_appat']) && isset($_POST['type_appat']) && isset($_POST['marque_appat']) && isset($_FILES['image_appat']))
    {
        $id_appat = isset($_POST['id_appat']) ? htmlspecialchars($_POST['id_appat']) : null;
        $nom_appat = isset($_POST['nom_appat']) ? htmlspecialchars($_POST['nom_appat']) : null;
        $detail_appat = isset($_POST['detail_appat']) ? htmlspecialchars($_POST['detail_appat']) : null;
        $description_appat = isset($_POST['description_appat']) ? htmlspecialchars($_POST['description_appat']) : null;
        $promo_appat = isset($_POST['promo_appat']) ? htmlspecialchars($_POST['promo_appat']) : null;
        $stock_appat = isset($_POST['stock_appat']) ? htmlspecialchars($_POST['stock_appat']) : null;
        $id_categorie = isset($_POST['categorie_appat']) ? htmlspecialchars($_POST['categorie_appat']) : null;
        $id_type_appat = isset($_POST['type_appat']) ? htmlspecialchars($_POST['type_appat']) : null;
        $id_marque = isset($_POST['marque_appat']) ? htmlspecialchars($_POST['marque_appat']) : null;
        $image_appat = isset($_FILES['image_appat']) ? $_FILES['image_appat'] : null;

        if($stock_appat === 'stock') 
        {
            $stock_appat = 1;
            $hors_stock_appat = 0;
        }
        else
        {
            $stock_appat = 0;
            $hors_stock_appat = 1;
        }

        if($promo_appat === 'promo')
        {
            $promo_appat = 1;
        }
        else
        {
            $promo_appat = 0;
        }

        $appatRepository = new AppatRepository;
        $imageAppatRepo = new ImageAppatRepository;
        
        $update = $appatRepository->updateAppat($id_appat, $nom_appat, $detail_appat, $description_appat, $promo_appat, $stock_appat, $hors_stock_appat, $id_categorie, $id_type_appat, $id_marque);
        $updateImageAppat = $imageAppatRepo->updateImageByAppat($image_appat, $id_appat);
        
        if ($update && $updateImageAppat)
        {
            header("location:admin.php");
        }
        else 
        {
            echo 'non';
        }
    }
}

function combinedArticle($articles)
{
    $combinedArticles = [];

    foreach ($articles['cannes'] as $canne) 
    {
        if ($canne) 
        {
            $imgCanneRepo = new ImageCanneRepository;
            $imgCannes = $imgCanneRepo->getImageByCanne($canne->getIdCanne());
            $combinedArticles[] =
            [
                'genre' => 'canne',
                'id' => $canne->getIdCanne(),
                'nom' => $canne->getNomCanne(),
                'image' => $imgCannes->getNomImageCanne(),
                'marque' => $canne->getMarqueCanne(),
                'type' => $canne->getTypeCanne(),
                'categorie' => $canne->getCategorieCanne(),
                'description' => $canne->getDescriptionCanne(),
                'prix' => $canne->getPrixCanne(),
                'poids' => $canne->getPoidsCanne(),
                'longueur' => $canne->getLongueurCanne(),
                'stock' => $canne->getStockCanne(),
                'promo' => $canne->getPromoCanne(),
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['moulinets'] as $moulinet) 
    {
        if ($moulinet) 
        {
            $imgMoulinetRepo = new ImageMoulinetRepository;
            $imgMoulinet = $imgMoulinetRepo->getImageByMoulinet($moulinet->getIdMoulinet());
            $combinedArticles[] =
            [
                'genre' => 'moulinet',
                'id' => $moulinet->getIdMoulinet(),
                'nom' => $moulinet->getNomMoulinet(),
                'image' => $imgMoulinet->getNomImageMoulinet(),
                'marque' => $moulinet->getMarqueMoulinet(),
                'type' => $moulinet->getTypeMoulinet(),
                'categorie' => $moulinet->getCategorieMoulinet(),
                'promo' => $moulinet->getPromoMoulinet(),
                'stock' => $moulinet->getStockMoulinet(),
                'description' => $moulinet->getDescriptionMoulinet(),                
                'poids' => $moulinet->getPoidsMoulinet(),                
                'ratio' => $moulinet->getRatioMoulinet(),                
            ];
        }
        else 
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['hamecons'] as $hamecon) 
    {
        if ($hamecon) 
        {
            $imgHameconRepo = new ImageHameconRepository;
            $imgHamecon = $imgHameconRepo->getImageByHamecon($hamecon->getIdHamecon());

            $combinedArticles[] =
            [
                'genre' => 'hamecon',
                'id' => $hamecon->getIdHamecon(),
                'nom' => $hamecon->getNomHamecon(),
                'image' => $imgHamecon->getNomImageHamecon(),
                'marque' => $hamecon->getMarqueHamecon(),
                'type' => $hamecon->getTypeHamecon(),
                'categorie' => $hamecon->getCategorieHamecon(),
                'description' => $hamecon->getDescriptionHamecon(),
                'poids' => $hamecon->getPoidsHamecon(),
                'longueur' => $hamecon->getLongueurHamecon(),
                'stock' => $hamecon->getStockHamecon(),
                'promo' => $hamecon->getPromoHamecon(),
            ];
        } 
        else 
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['leurres'] as $leurre) 
    {
        if ($leurre) 
        {
            $imgLeurreRepo = new ImageLeurreRepository;
            $imgLeurre = $imgLeurreRepo->getImageByLeurre($leurre->getIdLeurre());

            $combinedArticles[] =
            [
                'genre' => 'leurre',
                'id' => $leurre->getIdLeurre(),
                'nom' => $leurre->getNomLeurre(),
                'image' => $imgLeurre->getNomImageLeurre(),
                'marque' => $leurre->getMarqueLeurre(),
                'type' => $leurre->getTypeLeurre(),
                'categorie' => $leurre->getCategorieLeurre(),
                'description' => $leurre->getDescriptionLeurre(),
                'couleur' => $leurre->getCouleurLeurre(),
                'poids' => $leurre->getPoidsLeurre(),
                'promo' => $leurre->getPromoLeurre(),
                'stock' => $leurre->getStockLeurre(),
            ];
        }
        else 
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['lignes'] as $ligne) 
    {
        if ($ligne) 
        {
            $imgLigneRepo = new ImageLigneRepository;
            $imgLigne = $imgLigneRepo->getImageByLigne($ligne->getIdLigne());

            $combinedArticles[] =
            [
                'genre' => 'ligne',
                'id' => $ligne->getIdLigne(),
                'nom' => $ligne->getNomLigne(),
                'image' => $imgLigne->getNomImageLigne(),
                'marque' => $ligne->getMarqueLigne(),
                'type' => $ligne->getTypeLigne(),
                'categorie' => $ligne->getCategorieLigne(),
                'description' => $ligne->getDescriptionLigne(),
                'stock' => $ligne->getStockLigne(),
                'promo' => $ligne->getPromoLigne(),
                'longueur' => $ligne->getLongueurLigne(),
                'diametre' => $ligne->getDiametreLigne(),
                'poids' => $ligne->getPoidsLigne(),
            ];
        } 
        else 
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['equipements'] as $equipement) 
    {
        if ($equipement) 
        {
            $imgEquipementRepo = new ImageEquipementRepository;
            $imgEquipement = $imgEquipementRepo->getImageByEquipement($equipement->getIdEquipement());

            $combinedArticles[] =
            [
                'genre' => 'equipement',
                'id' => $equipement->getIdEquipement(),
                'nom' => $equipement->getNomEquipement(),
                'image' => $imgEquipement->getNomImageEquipement(),
                'marque' => $equipement->getMarqueEquipement(),
                'type' => $equipement->getTypeEquipement(),
                'categorie' => $equipement->getCategorieEquipement(),
                'promo' => $equipement->getPromoEquipement(),
                'stock' => $equipement->getStockEquipement(),
                'description' => $equipement->getDescriptionEquipement(),
                'detail' => $equipement->getDetailEquipement(),
            ];
        }
        else 
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['feeders'] as $feeder) 
    {
        if ($feeder) 
        {
            $imgFeederRepo = new ImageFeederRepository;
            $imgFeeder = $imgFeederRepo->getImageByFeeder($feeder->getIdFeeder());

            $combinedArticles[] =
            [
                'genre' => 'plomb',
                'id' => $feeder->getIdFeeder(),
                'nom' => $feeder->getNomFeeder(),
                'image' => $imgFeeder->getNomImageFeeder(),
                'marque' => $feeder->getMarqueFeeder(),
                'type' => $feeder->getTypeFeeder(),
                'categorie' => $feeder->getCategorieFeeder(),
                'promo' => $feeder->getPromoFeeder(),
                'stock' => $feeder->getStockFeeder(),
                'description' => $feeder->getDescriptionFeeder(),
                'poids' => $feeder->getPoidsFeeder(),
                'longueur' => $feeder->getLongueurFeeder(),
                'diametre' => $feeder->getDiametreFeeder(),
            ];
        } 
        else 
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['appats'] as $appat)
    {
        if ($appat) 
        {
            $imgAppatRepo = new ImageAppatRepository;
            $imgAppat = $imgAppatRepo->getImageByAppat($appat->getIdAppat());

            $combinedArticles[] =
            [
                'genre' => 'appat',
                'id' => $appat->getIdAppat(),
                'nom' => $appat->getNomAppat(),
                'image' => $imgAppat->getNomImageAppat(),
                'marque' => $appat->getMarqueAppat(),
                'type' => $appat->getTypeAppat(),
                'categorie' => $appat->getCategorieAppat(),
                'description' => $appat->getDescriptionAppat(),
                'promo' => $appat->getPromoAppat(),
                'stock' => $appat->getStockAppat(),
                'detail' => $appat->getDetailAppat(),
            ];
        }
        else 
        {
            $combinedArticles[] = [''];
        }
    }
    return $combinedArticles;
}

function getAllType()
{
    $allTypes = [];

    $typeMoulinetRepo = new TypemoulinetRepository;
    $allTypes['moulinet'] = $typeMoulinetRepo->getAllTypeMoulinet();

    $typeCanneRepo = new TypeCanneRepository;
    $allTypes['canne'] = $typeCanneRepo->getAllTypeCanne();

    $typeHameconRepo = new TypeHameconRepository;
    $allTypes['hamecon'] = $typeHameconRepo->getAllTypeHamecon();

    $typeLeurreRepo = new TypeLeurreRepository;
    $allTypes['leurre'] = $typeLeurreRepo->getAllTypeLeurre();

    $typeLigneRepo = new TypeLigneRepository;
    $allTypes['ligne'] = $typeLigneRepo->getAllTypeLigne();

    $typePlombRepo = new TypePlombRepository;
    $allTypes['plomb'] = $typePlombRepo->getAllTypePlomb();

    $typeEquipementRepo = new TypeEquipementRepository;
    $allTypes['equipement'] = $typeEquipementRepo->getAllTypeEquipement();

    $typeAppatRepo = new TypeAppatRepository;
    $allTypes['appat'] = $typeAppatRepo->getAllTypeAppat();

    return $allTypes;
}

function searchPage()
{
    $article = [];

    $canneRepo = new CanneRepository;
    $article['cannes'] = $canneRepo->getAllCanne();

    $typeCanneRepo = new TypeCanneRepository;
    $typeCannes = $typeCanneRepo->getAllTypeCanne();

    $moulinetRepo = new MoulinetRepository;
    $article['moulinets'] = $moulinetRepo->getAllmoulinet();

    $typeMoulinetRepo = new TypemoulinetRepository;
    $typeMoulinets = $typeMoulinetRepo->getAllTypemoulinet();

    $hameconRepo = new HameconRepository;
    $article['hamecons'] = $hameconRepo->getAllHamecon();

    $typeHameconRepo = new TypeHameconRepository;
    $typeHamecons = $typeHameconRepo->getAllTypeHamecon();

    $leurreRepo = new LeurreRepository;
    $article['leurres'] = $leurreRepo->getAllleurre();

    $typeLeurreRepo = new TypeLeurreRepository;
    $typeLeurres = $typeLeurreRepo->getAllTypeLeurre();

    $ligneRepo = new LigneRepository;
    $article['lignes'] = $ligneRepo->getAllLigne();

    $typeLigneRepo = new TypeLigneRepository;
    $typeLignes = $typeLigneRepo->getAllTypeLigne();

    $feederRepo = new FeederRepository;
    $article['feeders'] = $feederRepo->getAllFeeder();

    $typeFeederRepo = new TypeFeederRepository;
    $typeFeeders = $typeFeederRepo->getAllTypeFeeder();

    $equipementRepo = new EquipementRepository;
    $article['equipements'] = $equipementRepo->getAllEquipement();

    $typeEquipementRepo = new TypeEquipementRepository;
    $typeEquipements = $typeEquipementRepo->getAllTypeEquipement();

    $appatRepo = new AppatRepository;
    $article['appats'] = $appatRepo->getAllAppat();

    $typeAppatRepo = new TypeAppatRepository;
    $typeAppats = $typeAppatRepo->getAllTypeAppat();

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $articles = combinedArticle($article);

    $searchResults = [];
    if(!empty($_POST['keywords']))
    {
        $keywords[] = $_POST['keywords']; 

        if ($keywords != null)
        {
            $keywords = array_map('strtolower', $keywords);
        }

        foreach ($articles as $article)
        {
            $nom = strtolower($article['nom']);
            $description = strtolower($article['description']);
            $type = strtolower($article['type']);
            $marque = strtolower($article['marque']);
            $categorie = strtolower($article['categorie']);
            $genre = strtolower($article['genre']);
    
            foreach ($keywords as $keyword) 
            {
                if (strpos($nom, $keyword) !== false || strpos($description, $keyword) !== false || strpos($type, $keyword) !== false || strpos($marque, $keyword) !== false || strpos($categorie, $keyword) !== false || strpos($genre, $keyword) !== false ) 
                {
                    $articlesSelectionnes[] = $article;
                }
            }
        }
    }
    else
    {
        header('location:admin.php');
    }
    
    require('src/view/adminCrud/adminSearchPage.php');
}