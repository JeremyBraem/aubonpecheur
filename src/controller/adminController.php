<?php
require_once('src/model/Produit.php');
require_once('src/model/Canne.php');
require_once('src/model/Moulinet.php');
require_once('src/model/Hamecon.php');
require_once('src/model/Leurre.php');
require_once('src/model/Ligne.php');
require_once('src/model/Equipement.php');
require_once('src/model/Plomb.php');
require_once('src/model/Autre.php');
require_once('src/model/Appat.php');
require_once('src/model/Image.php');

require_once('src/model/Marque.php');
require_once('src/model/Categorie.php');

require_once('src/model/Type/TypeCanne.php');
require_once('src/model/Type/TypeMoulinet.php');
require_once('src/model/Type/TypeHamecon.php');
require_once('src/model/Type/TypeLeurre.php');
require_once('src/model/Type/TypeLigne.php');
require_once('src/model/Type/TypeEquipement.php');
require_once('src/model/Type/TypePlomb.php');
require_once('src/model/Type/TypeAppat.php');
require_once('src/model/Type/TypeAutre.php');

function adminPage()
{
    $canneRepo = new CanneRepository;
    $cannes = $canneRepo->getAllCannes();

    $moulinetRepo = new MoulinetRepository;
    $moulinets = $moulinetRepo->getAllMoulinets();

    $produitRepo = new ProduitRepository();
    $produits = $produitRepo->getAllProducts();

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();
    
    require('src/view/adminPage.php');
}

function addCanneTraitement()
{
    if (isset($_POST))
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['longueur_canne']) &&
            isset($_POST['poids_canne']) &&
            isset($_POST['type_canne']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 1;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleCanne = new Canne();

            $nouvelleCanne->setNomProduit($_POST['nom_produit']);
            $nouvelleCanne->setDescriptionProduit($_POST['description_produit']);
            $nouvelleCanne->setPrixProduit($_POST['prix_produit']);
            $nouvelleCanne->setStockProduit($stock);
            $nouvelleCanne->setPromoProduit($_POST['promo_produit']);
            $nouvelleCanne->setPrixPromoProduit($prix_promo_produit);
            $nouvelleCanne->setIdCategorie($_POST['categorie_produit']);
            $nouvelleCanne->setIdGenre($genre);
            $nouvelleCanne->setIdMarque($_POST['marque_produit']);
            $nouvelleCanne->setLongueurCanne($_POST['longueur_canne']);
            $nouvelleCanne->setPoidsCanne($_POST['poids_canne']);
            $nouvelleCanne->setNomImage($_FILES['images']['name']);
            $nouvelleCanne->setDescriptionImage($_POST['description_images']);
            $nouvelleCanne->setIdTypeCanne($_POST['type_canne']);
            
            if ($nouvelleCanne) 
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

                    $imageRepo = new ImageRepository;
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                else
                {
                    echo 'Aucune image trouvé';
                    die;
                }

                $canneRepo = new CanneRepository();
                $canneRepo->addCanne($nouvelleCanne);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit;
            } 
            else 
            {
                echo "Les données de la nouvelle canne ne sont pas valides.";
                die;
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter une nouvelle canne.";
            die;
        }

        header('Location: admin.php');
        exit();
    }
}

function updateCanneTraitement()
{
    if (isset($_POST)) 
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['longueur_canne']) &&
            isset($_POST['poids_canne']) &&
            isset($_POST['type_canne']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 1;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleCanne = new Canne();

            $nouvelleCanne->setIdProduit($_POST['id_produit']);
            $nouvelleCanne->setNomProduit($_POST['nom_produit']);
            $nouvelleCanne->setDescriptionProduit($_POST['description_produit']);
            $nouvelleCanne->setPrixProduit($_POST['prix_produit']);
            $nouvelleCanne->setStockProduit($stock);
            $nouvelleCanne->setPromoProduit($_POST['promo_produit']);
            $nouvelleCanne->setPrixPromoProduit($prix_promo_produit);
            $nouvelleCanne->setIdCategorie($_POST['categorie_produit']);
            $nouvelleCanne->setIdGenre($genre);
            $nouvelleCanne->setIdMarque($_POST['marque_produit']);
            $nouvelleCanne->setLongueurCanne($_POST['longueur_canne']);
            $nouvelleCanne->setPoidsCanne($_POST['poids_canne']);
            $nouvelleCanne->setNomImage($_FILES['images']['name']);
            $nouvelleCanne->setDescriptionImage($_POST['description_images']);
            $nouvelleCanne->setIdTypeCanne($_POST['type_canne']);
          
            if ($nouvelleCanne) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $imageRepo = new ImageRepository;

                    $imageRepo->deleteImagesByProduit($_POST['id_produit']);

                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                    

                $canneRepo = new CanneRepository();
                $canneRepo->updateCanne($nouvelleCanne);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']);

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit;
            }
            else 
            {
                echo "Les données de la nouvelle canne ne sont pas valides.";
                die;
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter une nouvelle canne.";
            die;
        }

        header('Location: admin.php');
        exit();
    }
}

function deleteCanne()
{
    if (isset($_POST['id_produit']))
    {
        $id_produit = $_POST['id_produit'];

        $canneRepo = new CanneRepository();
        $imageRepo = new ImageRepository();

        $imageRepo->deleteImagesByProduit($id_produit);

        $canneRepo->deleteCanne($id_produit);

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
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['ratio_moulinet']) &&
            isset($_POST['poids_moulinet']) &&
            isset($_POST['type_moulinet']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 2;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleMoulinet = new Moulinet();

            $nouvelleMoulinet->setNomProduit($_POST['nom_produit']);
            $nouvelleMoulinet->setDescriptionProduit($_POST['description_produit']);
            $nouvelleMoulinet->setPrixProduit($_POST['prix_produit']);
            $nouvelleMoulinet->setStockProduit($stock);
            $nouvelleMoulinet->setPromoProduit($_POST['promo_produit']);
            $nouvelleMoulinet->setPrixPromoProduit($prix_promo_produit);
            $nouvelleMoulinet->setIdCategorie($_POST['categorie_produit']);
            $nouvelleMoulinet->setIdGenre($genre);
            $nouvelleMoulinet->setIdMarque($_POST['marque_produit']);
            $nouvelleMoulinet->setRatioMoulinet($_POST['ratio_moulinet']);
            $nouvelleMoulinet->setPoidsMoulinet($_POST['poids_moulinet']);
            $nouvelleMoulinet->setNomImage($_FILES['images']['name']);
            $nouvelleMoulinet->setDescriptionImage($_POST['description_images']);
            $nouvelleMoulinet->setIdTypeMoulinet($_POST['type_moulinet']);
            
            if ($nouvelleMoulinet) 
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

                    $imageRepo = new ImageRepository;
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                else
                {
                    echo 'Aucune image trouvé';
                    die;
                }

                $moulinetRepo = new MoulinetRepository();
                $moulinetRepo->addMoulinet($nouvelleMoulinet);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit;
            } 
            else 
            {
                echo "Les données du nouveau moulinet ne sont pas valides.";
                die;
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter un nouveau moulinet.";
            die;
        }

        header('Location: admin.php');
        exit();
    }
}

function updateMoulinetTraitement()
{
    if (isset($_POST)) 
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['ratio_moulinet']) &&
            isset($_POST['poids_moulinet']) &&
            isset($_POST['type_moulinet']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 1;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleMoulinet = new Moulinet();

            $nouvelleMoulinet->setIdProduit($_POST['id_produit']);
            $nouvelleMoulinet->setNomProduit($_POST['nom_produit']);
            $nouvelleMoulinet->setDescriptionProduit($_POST['description_produit']);
            $nouvelleMoulinet->setPrixProduit($_POST['prix_produit']);
            $nouvelleMoulinet->setStockProduit($stock);
            $nouvelleMoulinet->setPromoProduit($_POST['promo_produit']);
            $nouvelleMoulinet->setPrixPromoProduit($prix_promo_produit);
            $nouvelleMoulinet->setIdCategorie($_POST['categorie_produit']);
            $nouvelleMoulinet->setIdGenre($genre);
            $nouvelleMoulinet->setIdMarque($_POST['marque_produit']);
            $nouvelleMoulinet->setRatioMoulinet($_POST['ratio_moulinet']);
            $nouvelleMoulinet->setPoidsMoulinet($_POST['poids_moulinet']);
            $nouvelleMoulinet->setNomImage($_FILES['images']['name']);
            $nouvelleMoulinet->setDescriptionImage($_POST['description_images']);
            $nouvelleMoulinet->setIdTypeMoulinet($_POST['type_moulinet']);
          
            if ($nouvelleMoulinet) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $imageRepo = new ImageRepository;

                    $imageRepo->deleteImagesByProduit($_POST['id_produit']);

                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                    

                $moulinetRepo = new MoulinetRepository();
                $moulinetRepo->updateMoulinet($nouvelleMoulinet);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']);

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit;
            }
            else 
            {
                echo "Les nouvelles données du  moulinet ne sont pas valides.";
                die;
            }
        }
        else 
        {
            echo "Certaines nouvelle données sont manquantes pour ajouter un moulinet.";
            die;
        }

        header('Location: admin.php');
        exit();
    }
}

function deleteMoulinet()
{
    if (isset($_POST['id_produit']))
    {
        $id_produit = $_POST['id_produit'];

        $moulinetRepo = new MoulinetRepository();
        $imageRepo = new ImageRepository();

        $imageRepo->deleteImagesByProduit($id_produit);

        $moulinetRepo->deleteMoulinet($id_produit);

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
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['longueur_hamecon']) &&
            isset($_POST['poids_hamecon']) &&
            isset($_POST['type_hamecon']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 3;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleHamecon = new Hamecon();

            $nouvelleHamecon->setNomProduit($_POST['nom_produit']);
            $nouvelleHamecon->setDescriptionProduit($_POST['description_produit']);
            $nouvelleHamecon->setPrixProduit($_POST['prix_produit']);
            $nouvelleHamecon->setStockProduit($stock);
            $nouvelleHamecon->setPromoProduit($_POST['promo_produit']);
            $nouvelleHamecon->setPrixPromoProduit($prix_promo_produit);
            $nouvelleHamecon->setIdCategorie($_POST['categorie_produit']);
            $nouvelleHamecon->setIdGenre($genre);
            $nouvelleHamecon->setIdMarque($_POST['marque_produit']);
            $nouvelleHamecon->setLongueurHamecon($_POST['longueur_hamecon']);
            $nouvelleHamecon->setPoidsHamecon($_POST['poids_hamecon']);
            $nouvelleHamecon->setNomImage($_FILES['images']['name']);
            $nouvelleHamecon->setDescriptionImage($_POST['description_images']);
            $nouvelleHamecon->setIdTypeHamecon($_POST['type_hamecon']);
            
            if ($nouvelleHamecon) 
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

                    $imageRepo = new ImageRepository;
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                else
                {
                    echo 'Aucune image trouvé';
                    die;
                }

                $hameconRepo = new HameconRepository();
                $hameconRepo->addHamecon($nouvelleHamecon);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit;
            } 
            else 
            {
                echo "Les données de la nouvelle hamecon ne sont pas valides.";
                die;
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter une nouvelle hamecon.";
            die;
        }

        header('Location: admin.php');
        exit();
    }
}

function updateHameconTraitement()
{
    if (isset($_POST)) 
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['longueur_hamecon']) &&
            isset($_POST['poids_hamecon']) &&
            isset($_POST['type_hamecon']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 3;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleHamecon = new Hamecon();

            $nouvelleHamecon->setIdProduit($_POST['id_produit']);
            $nouvelleHamecon->setNomProduit($_POST['nom_produit']);
            $nouvelleHamecon->setDescriptionProduit($_POST['description_produit']);
            $nouvelleHamecon->setPrixProduit($_POST['prix_produit']);
            $nouvelleHamecon->setStockProduit($stock);
            $nouvelleHamecon->setPromoProduit($_POST['promo_produit']);
            $nouvelleHamecon->setPrixPromoProduit($prix_promo_produit);
            $nouvelleHamecon->setIdCategorie($_POST['categorie_produit']);
            $nouvelleHamecon->setIdGenre($genre);
            $nouvelleHamecon->setIdMarque($_POST['marque_produit']);
            $nouvelleHamecon->setLongueurHamecon($_POST['longueur_hamecon']);
            $nouvelleHamecon->setPoidsHamecon($_POST['poids_hamecon']);
            $nouvelleHamecon->setNomImage($_FILES['images']['name']);
            $nouvelleHamecon->setDescriptionImage($_POST['description_images']);
            $nouvelleHamecon->setIdTypeHamecon($_POST['type_hamecon']);
          
            if ($nouvelleHamecon) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $imageRepo = new ImageRepository;

                    $imageRepo->deleteImagesByProduit($_POST['id_produit']);

                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                    

                $hameconRepo = new HameconRepository();
                $hameconRepo->updateHamecon($nouvelleHamecon);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']);

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit();
            }
            else 
            {
                echo "Les données de la nouvelle hamecon ne sont pas valides.";
                exit();
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter une nouvelle hamecon.";
            exit();
        }

        header('Location: admin.php');
        exit();
    }
}

function deleteHamecon()
{
    if (isset($_POST['id_produit']))
    {
        $id_produit = $_POST['id_produit'];

        $hameconRepo = new HameconRepository();
        $imageRepo = new ImageRepository();

        $imageRepo->deleteImagesByProduit($id_produit);

        $hameconRepo->deleteHamecon($id_produit);

        header('Location: admin.php');
    } 
    else 
    {
        echo "ID de l'hamecon manquant.";
    }
}

function addLeurreTraitement()
{
    if (isset($_POST))
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['longueur_leurre']) &&
            isset($_POST['poids_leurre']) &&
            isset($_POST['couleur_leurre']) &&
            isset($_POST['type_leurre']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 4;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleLeurre = new Leurre();

            $nouvelleLeurre->setNomProduit($_POST['nom_produit']);
            $nouvelleLeurre->setDescriptionProduit($_POST['description_produit']);
            $nouvelleLeurre->setPrixProduit($_POST['prix_produit']);
            $nouvelleLeurre->setStockProduit($stock);
            $nouvelleLeurre->setPromoProduit($_POST['promo_produit']);
            $nouvelleLeurre->setPrixPromoProduit($prix_promo_produit);
            $nouvelleLeurre->setIdCategorie($_POST['categorie_produit']);
            $nouvelleLeurre->setIdGenre($genre);
            $nouvelleLeurre->setIdMarque($_POST['marque_produit']);
            $nouvelleLeurre->setLongueurLeurre($_POST['longueur_leurre']);
            $nouvelleLeurre->setPoidsLeurre($_POST['poids_leurre']);
            $nouvelleLeurre->setCouleurLeurre($_POST['couleur_leurre']);
            $nouvelleLeurre->setNomImage($_FILES['images']['name']);
            $nouvelleLeurre->setDescriptionImage($_POST['description_images']);
            $nouvelleLeurre->setIdTypeLeurre($_POST['type_leurre']);
            
            if ($nouvelleLeurre) 
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

                    $imageRepo = new ImageRepository;
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                else
                {
                    echo 'Aucune image trouvé';
                    die;
                }

                $leurreRepo = new LeurreRepository();
                $leurreRepo->addLeurre($nouvelleLeurre);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit;
            } 
            else 
            {
                echo "Les données de la nouvelle leurre ne sont pas valides.";
                die;
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter une nouvelle leurre.";
            die;
        }

        header('Location: admin.php');
        exit();
    }
}

function updateLeurreTraitement()
{
    if (isset($_POST)) 
    {
      
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['longueur_leurre']) &&
            isset($_POST['poids_leurre']) &&
            isset($_POST['couleur_leurre']) &&
            isset($_POST['type_leurre']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 3;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleLeurre = new Leurre();

            $nouvelleLeurre->setIdProduit($_POST['id_produit']);
            $nouvelleLeurre->setNomProduit($_POST['nom_produit']);
            $nouvelleLeurre->setDescriptionProduit($_POST['description_produit']);
            $nouvelleLeurre->setPrixProduit($_POST['prix_produit']);
            $nouvelleLeurre->setStockProduit($stock);
            $nouvelleLeurre->setPromoProduit($_POST['promo_produit']);
            $nouvelleLeurre->setPrixPromoProduit($prix_promo_produit);
            $nouvelleLeurre->setIdCategorie($_POST['categorie_produit']);
            $nouvelleLeurre->setIdGenre($genre);
            $nouvelleLeurre->setIdMarque($_POST['marque_produit']);
            $nouvelleLeurre->setLongueurLeurre($_POST['longueur_leurre']);
            $nouvelleLeurre->setPoidsLeurre($_POST['poids_leurre']);
            $nouvelleLeurre->setCouleurLeurre($_POST['couleur_leurre']);
            $nouvelleLeurre->setNomImage($_FILES['images']['name']);
            $nouvelleLeurre->setDescriptionImage($_POST['description_images']);
            $nouvelleLeurre->setIdTypeLeurre($_POST['type_leurre']);
          
            if ($nouvelleLeurre) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $imageRepo = new ImageRepository;

                    $imageRepo->deleteImagesByProduit($_POST['id_produit']);

                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                    

                $leurreRepo = new LeurreRepository();
                $leurreRepo->updateLeurre($nouvelleLeurre);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']);

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit;
            }
            else 
            {
                echo "Les données de la nouvelle leurre ne sont pas valides.";
                die;
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter un nouveaux leurre.";
            die;
        }

        header('Location: admin.php');
        exit();
    }
}

function deleteLeurre()
{
    if (isset($_POST['id_produit']))
    {
        $id_produit = $_POST['id_produit'];

        $leurreRepo = new LeurreRepository();
        $imageRepo = new ImageRepository();

        $imageRepo->deleteImagesByProduit($id_produit);

        $leurreRepo->deleteLeurre($id_produit);

        header('Location: admin.php');
    } 
    else 
    {
        echo "ID de la leurre manquant.";
    }
}

function addLigneTraitement()
{
    if (isset($_POST))
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['longueur_ligne']) &&
            isset($_POST['diametre_ligne']) &&
            isset($_POST['type_ligne']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 5;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleLigne = new Ligne();

            $nouvelleLigne->setNomProduit($_POST['nom_produit']);
            $nouvelleLigne->setDescriptionProduit($_POST['description_produit']);
            $nouvelleLigne->setPrixProduit($_POST['prix_produit']);
            $nouvelleLigne->setStockProduit($stock);
            $nouvelleLigne->setPromoProduit($_POST['promo_produit']);
            $nouvelleLigne->setPrixPromoProduit($prix_promo_produit);
            $nouvelleLigne->setIdCategorie($_POST['categorie_produit']);
            $nouvelleLigne->setIdGenre($genre);
            $nouvelleLigne->setIdMarque($_POST['marque_produit']);
            $nouvelleLigne->setLongueurLigne($_POST['longueur_ligne']);
            $nouvelleLigne->setDiametreLigne($_POST['diametre_ligne']);
            $nouvelleLigne->setNomImage($_FILES['images']['name']);
            $nouvelleLigne->setDescriptionImage($_POST['description_images']);
            $nouvelleLigne->setIdTypeLigne($_POST['type_ligne']);
            
            if ($nouvelleLigne) 
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

                    $imageRepo = new ImageRepository;
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                else
                {
                    echo 'Aucune image trouvé';
                    die;
                }

                $ligneRepo = new LigneRepository();
                $ligneRepo->addLigne($nouvelleLigne);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit;
            } 
            else 
            {
                echo "Les données de la nouvelle ligne ne sont pas valides.";
                die;
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter une nouvelle ligne.";
            die;
        }

        header('Location: admin.php');
        exit();
    }
}

function updateLigneTraitement()
{
    if (isset($_POST)) 
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['longueur_ligne']) &&
            isset($_POST['diametre_ligne']) &&
            isset($_POST['type_ligne']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 5;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleLigne = new Ligne();

            $nouvelleLigne->setIdProduit($_POST['id_produit']);
            $nouvelleLigne->setNomProduit($_POST['nom_produit']);
            $nouvelleLigne->setDescriptionProduit($_POST['description_produit']);
            $nouvelleLigne->setPrixProduit($_POST['prix_produit']);
            $nouvelleLigne->setStockProduit($stock);
            $nouvelleLigne->setPromoProduit($_POST['promo_produit']);
            $nouvelleLigne->setPrixPromoProduit($prix_promo_produit);
            $nouvelleLigne->setIdCategorie($_POST['categorie_produit']);
            $nouvelleLigne->setIdGenre($genre);
            $nouvelleLigne->setIdMarque($_POST['marque_produit']);
            $nouvelleLigne->setLongueurLigne($_POST['longueur_ligne']);
            $nouvelleLigne->setDiametreLigne($_POST['diametre_ligne']);
            $nouvelleLigne->setNomImage($_FILES['images']['name']);
            $nouvelleLigne->setDescriptionImage($_POST['description_images']);
            $nouvelleLigne->setIdTypeLigne($_POST['type_ligne']);
          
            if ($nouvelleLigne) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $imageRepo = new ImageRepository;

                    $imageRepo->deleteImagesByProduit($_POST['id_produit']);

                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                    

                $ligneRepo = new LigneRepository();
                $ligneRepo->updateLigne($nouvelleLigne);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']);

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit();
            }
            else 
            {
                echo "Les données de la nouvelle ligne ne sont pas valides.";
                exit();
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter une nouvelle ligne.";
            exit();
        }

        header('Location: admin.php');
        exit();
    }
}

function deleteLigne()
{
    if (isset($_POST['id_produit']))
    {
        $id_produit = $_POST['id_produit'];

        $ligneRepo = new LigneRepository();
        $imageRepo = new ImageRepository();

        $imageRepo->deleteImagesByProduit($id_produit);

        $ligneRepo->deleteLigne($id_produit);

        header('Location: admin.php');
    } 
    else 
    {
        echo "ID de l'ligne manquant.";
    }
}

function addEquipementTraitement()
{
    if (isset($_POST))
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['detail_equipement']) &&
            isset($_POST['type_equipement']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 7;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleEquipement = new Equipement();

            $nouvelleEquipement->setNomProduit($_POST['nom_produit']);
            $nouvelleEquipement->setDescriptionProduit($_POST['description_produit']);
            $nouvelleEquipement->setPrixProduit($_POST['prix_produit']);
            $nouvelleEquipement->setStockProduit($stock);
            $nouvelleEquipement->setPromoProduit($_POST['promo_produit']);
            $nouvelleEquipement->setPrixPromoProduit($prix_promo_produit);
            $nouvelleEquipement->setIdCategorie($_POST['categorie_produit']);
            $nouvelleEquipement->setIdGenre($genre);
            $nouvelleEquipement->setIdMarque($_POST['marque_produit']);
            $nouvelleEquipement->setDetailEquipement($_POST['detail_equipement']);
            $nouvelleEquipement->setNomImage($_FILES['images']['name']);
            $nouvelleEquipement->setDescriptionImage($_POST['description_images']);
            $nouvelleEquipement->setIdTypeEquipement($_POST['type_equipement']);
            
            if ($nouvelleEquipement) 
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

                    $imageRepo = new ImageRepository;
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                else
                {
                    echo 'Aucune image trouvé';
                    die;
                }

                $equipementRepo = new EquipementRepository();
                $equipementRepo->addEquipement($nouvelleEquipement);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit;
            } 
            else 
            {
                echo "Les données de la nouvelle equipement ne sont pas valides.";
                die;
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter une nouvelle equipement.";
            die;
        }

        header('Location: admin.php');
        exit();
    }
}

function updateEquipementTraitement()
{
    if (isset($_POST)) 
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['detail_equipement']) &&
            isset($_POST['type_equipement']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 7;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleEquipement = new Equipement();

            $nouvelleEquipement->setIdProduit($_POST['id_produit']);
            $nouvelleEquipement->setNomProduit($_POST['nom_produit']);
            $nouvelleEquipement->setDescriptionProduit($_POST['description_produit']);
            $nouvelleEquipement->setPrixProduit($_POST['prix_produit']);
            $nouvelleEquipement->setStockProduit($stock);
            $nouvelleEquipement->setPromoProduit($_POST['promo_produit']);
            $nouvelleEquipement->setPrixPromoProduit($prix_promo_produit);
            $nouvelleEquipement->setIdCategorie($_POST['categorie_produit']);
            $nouvelleEquipement->setIdGenre($genre);
            $nouvelleEquipement->setIdMarque($_POST['marque_produit']);
            $nouvelleEquipement->setDetailEquipement($_POST['detail_equipement']);
            $nouvelleEquipement->setNomImage($_FILES['images']['name']);
            $nouvelleEquipement->setDescriptionImage($_POST['description_images']);
            $nouvelleEquipement->setIdTypeEquipement($_POST['type_equipement']);
          
            if ($nouvelleEquipement) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $imageRepo = new ImageRepository;

                    $imageRepo->deleteImagesByProduit($_POST['id_produit']);

                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                    

                $equipementRepo = new EquipementRepository();
                $equipementRepo->updateEquipement($nouvelleEquipement);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']);

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit();
            }
            else 
            {
                echo "Les données du nouvel equipement ne sont pas valides.";
                exit();
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter une nouvelle equipement.";
            exit();
        }

        header('Location: admin.php');
        exit();
    }
}

function deleteEquipement()
{
    if (isset($_POST['id_produit']))
    {
        $id_produit = $_POST['id_produit'];

        $equipementRepo = new EquipementRepository();
        $imageRepo = new ImageRepository();

        $imageRepo->deleteImagesByProduit($id_produit);

        $equipementRepo->deleteEquipement($id_produit);

        header('Location: admin.php');
    } 
    else 
    {
        echo "ID de l'equipement manquant.";
    }
}

function addPlombTraitement()
{
    if (isset($_POST))
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['longueur_plomb']) &&
            isset($_POST['poids_plomb']) &&
            isset($_POST['diametre_plomb']) &&
            isset($_POST['type_plomb']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 6;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvellePlomb = new Plomb();

            $nouvellePlomb->setNomProduit($_POST['nom_produit']);
            $nouvellePlomb->setDescriptionProduit($_POST['description_produit']);
            $nouvellePlomb->setPrixProduit($_POST['prix_produit']);
            $nouvellePlomb->setStockProduit($stock);
            $nouvellePlomb->setPromoProduit($_POST['promo_produit']);
            $nouvellePlomb->setPrixPromoProduit($prix_promo_produit);
            $nouvellePlomb->setIdCategorie($_POST['categorie_produit']);
            $nouvellePlomb->setIdGenre($genre);
            $nouvellePlomb->setIdMarque($_POST['marque_produit']);
            $nouvellePlomb->setLongueurPlomb($_POST['longueur_plomb']);
            $nouvellePlomb->setPoidsPlomb($_POST['poids_plomb']);
            $nouvellePlomb->setDiametrePlomb($_POST['diametre_plomb']);
            $nouvellePlomb->setNomImage($_FILES['images']['name']);
            $nouvellePlomb->setDescriptionImage($_POST['description_images']);
            $nouvellePlomb->setIdTypePlomb($_POST['type_plomb']);
            
            if ($nouvellePlomb) 
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

                    $imageRepo = new ImageRepository;
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                else
                {
                    echo 'Aucune image trouvé';
                    die;
                }

                $plombRepo = new PlombRepository();
                $plombRepo->addPlomb($nouvellePlomb);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit;
            } 
            else 
            {
                echo "Les données de la nouvelle plomb ne sont pas valides.";
                die;
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter une nouvelle plomb.";
            die;
        }

        header('Location: admin.php');
        exit();
    }
}

function updatePlombTraitement()
{
    if (isset($_POST)) 
    {
      
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['longueur_plomb']) &&
            isset($_POST['poids_plomb']) &&
            isset($_POST['diametre_plomb']) &&
            isset($_POST['type_plomb']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 6;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvellePlomb = new Plomb();

            $nouvellePlomb->setIdProduit($_POST['id_produit']);
            $nouvellePlomb->setNomProduit($_POST['nom_produit']);
            $nouvellePlomb->setDescriptionProduit($_POST['description_produit']);
            $nouvellePlomb->setPrixProduit($_POST['prix_produit']);
            $nouvellePlomb->setStockProduit($stock);
            $nouvellePlomb->setPromoProduit($_POST['promo_produit']);
            $nouvellePlomb->setPrixPromoProduit($prix_promo_produit);
            $nouvellePlomb->setIdCategorie($_POST['categorie_produit']);
            $nouvellePlomb->setIdGenre($genre);
            $nouvellePlomb->setIdMarque($_POST['marque_produit']);
            $nouvellePlomb->setLongueurPlomb($_POST['longueur_plomb']);
            $nouvellePlomb->setPoidsPlomb($_POST['poids_plomb']);
            $nouvellePlomb->setDiametrePlomb($_POST['diametre_plomb']);
            $nouvellePlomb->setNomImage($_FILES['images']['name']);
            $nouvellePlomb->setDescriptionImage($_POST['description_images']);
            $nouvellePlomb->setIdTypePlomb($_POST['type_plomb']);
          
            if ($nouvellePlomb) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $imageRepo = new ImageRepository;

                    $imageRepo->deleteImagesByProduit($_POST['id_produit']);

                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                    

                $plombRepo = new PlombRepository();
                $plombRepo->updatePlomb($nouvellePlomb);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']);

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit;
            }
            else 
            {
                echo "Les données de la nouvelle plomb ne sont pas valides.";
                die;
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter un nouveaux plomb.";
            die;
        }

        header('Location: admin.php');
        exit();
    }
}

function deletePlomb()
{
    if (isset($_POST['id_produit']))
    {
        $id_produit = $_POST['id_produit'];

        $plombRepo = new PlombRepository();
        $imageRepo = new ImageRepository();

        $imageRepo->deleteImagesByProduit($id_produit);

        $plombRepo->deletePlomb($id_produit);

        header('Location: admin.php');
    } 
    else 
    {
        echo "ID de la plomb manquant.";
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

function addAppatTraitement()
{
    if (isset($_POST))
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['detail_appat']) &&
            isset($_POST['type_appat']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 8;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleAppat = new Appat();

            $nouvelleAppat->setNomProduit($_POST['nom_produit']);
            $nouvelleAppat->setDescriptionProduit($_POST['description_produit']);
            $nouvelleAppat->setPrixProduit($_POST['prix_produit']);
            $nouvelleAppat->setStockProduit($stock);
            $nouvelleAppat->setPromoProduit($_POST['promo_produit']);
            $nouvelleAppat->setPrixPromoProduit($prix_promo_produit);
            $nouvelleAppat->setIdCategorie($_POST['categorie_produit']);
            $nouvelleAppat->setIdGenre($genre);
            $nouvelleAppat->setIdMarque($_POST['marque_produit']);
            $nouvelleAppat->setDetailAppat($_POST['detail_appat']);
            $nouvelleAppat->setNomImage($_FILES['images']['name']);
            $nouvelleAppat->setDescriptionImage($_POST['description_images']);
            $nouvelleAppat->setIdTypeAppat($_POST['type_appat']);
            
            if ($nouvelleAppat) 
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

                    $imageRepo = new ImageRepository;
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                else
                {
                    echo 'Aucune image trouvé';
                    die;
                }

                $appatRepo = new AppatRepository();
                $appatRepo->addAppat($nouvelleAppat);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit;
            } 
            else 
            {
                echo "Les données de la nouvelle appat ne sont pas valides.";
                die;
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter une nouvelle appat.";
            die;
        }

        header('Location: admin.php');
        exit();
    }
}

function updateAppatTraitement()
{
    if (isset($_POST)) 
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['detail_appat']) &&
            isset($_POST['type_appat']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 8;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleAppat = new Appat();

            $nouvelleAppat->setIdProduit($_POST['id_produit']);
            $nouvelleAppat->setNomProduit($_POST['nom_produit']);
            $nouvelleAppat->setDescriptionProduit($_POST['description_produit']);
            $nouvelleAppat->setPrixProduit($_POST['prix_produit']);
            $nouvelleAppat->setStockProduit($stock);
            $nouvelleAppat->setPromoProduit($_POST['promo_produit']);
            $nouvelleAppat->setPrixPromoProduit($prix_promo_produit);
            $nouvelleAppat->setIdCategorie($_POST['categorie_produit']);
            $nouvelleAppat->setIdGenre($genre);
            $nouvelleAppat->setIdMarque($_POST['marque_produit']);
            $nouvelleAppat->setDetailAppat($_POST['detail_appat']);
            $nouvelleAppat->setNomImage($_FILES['images']['name']);
            $nouvelleAppat->setDescriptionImage($_POST['description_images']);
            $nouvelleAppat->setIdTypeAppat($_POST['type_appat']);
          
            if ($nouvelleAppat) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $imageRepo = new ImageRepository;

                    $imageRepo->deleteImagesByProduit($_POST['id_produit']);

                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                    

                $appatRepo = new AppatRepository();
                $appatRepo->updateAppat($nouvelleAppat);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']);

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit();
            }
            else 
            {
                echo "Les données du nouvel appat ne sont pas valides.";
                exit();
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter un nouvel appat.";
            exit();
        }

        header('Location: admin.php');
        exit();
    }
}

function deleteAppat()
{
    if (isset($_POST['id_produit']))
    {
        $id_produit = $_POST['id_produit'];

        $appatRepo = new AppatRepository();
        $imageRepo = new ImageRepository();

        $imageRepo->deleteImagesByProduit($id_produit);

        $appatRepo->deleteAppat($id_produit);

        header('Location: admin.php');
    } 
    else 
    {
        echo "ID de l'appat manquant.";
    }
}

function addAutreTraitement()
{
    if (isset($_POST))
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['detail_autre']) &&
            isset($_POST['type_autre']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 9;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleAutre = new Autre();

            $nouvelleAutre->setNomProduit($_POST['nom_produit']);
            $nouvelleAutre->setDescriptionProduit($_POST['description_produit']);
            $nouvelleAutre->setPrixProduit($_POST['prix_produit']);
            $nouvelleAutre->setStockProduit($stock);
            $nouvelleAutre->setPromoProduit($_POST['promo_produit']);
            $nouvelleAutre->setPrixPromoProduit($prix_promo_produit);
            $nouvelleAutre->setIdCategorie($_POST['categorie_produit']);
            $nouvelleAutre->setIdGenre($genre);
            $nouvelleAutre->setIdMarque($_POST['marque_produit']);
            $nouvelleAutre->setDetailAutre($_POST['detail_autre']);
            $nouvelleAutre->setNomImage($_FILES['images']['name']);
            $nouvelleAutre->setDescriptionImage($_POST['description_images']);
            $nouvelleAutre->setIdTypeAutre($_POST['type_autre']);
            
            if ($nouvelleAutre) 
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

                    $imageRepo = new ImageRepository;
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                else
                {
                    echo 'Aucune image trouvé';
                    die;
                }

                $autreRepo = new AutreRepository();
                $autreRepo->addAutre($nouvelleAutre);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']); 

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit;
            } 
            else 
            {
                echo "Les données de la nouvelle autre ne sont pas valides.";
                die;
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter une nouvelle autre.";
            die;
        }

        header('Location: admin.php');
        exit();
    }
}

function updateAutreTraitement()
{
    if (isset($_POST)) 
    {
        if (isset($_POST['nom_produit']) &&
            isset($_POST['description_produit']) &&
            isset($_POST['prix_produit']) &&
            isset($_POST['stock_produit']) &&
            isset($_POST['promo_produit']) &&
            isset($_POST['categorie_produit']) &&
            isset($_POST['marque_produit']) &&
            isset($_POST['detail_autre']) &&
            isset($_POST['type_autre']) &&
            isset($_POST['description_images']) &&
            isset($_FILES['images'])
        )
        {
            $genre = 9;

            $prix_promo_produit = $_POST['prix_produit'] - ($_POST['prix_produit'] * ($_POST['promo_produit'] / 100));

            if($_POST['stock_produit'] === 'stock')
            {
                $stock = 1;
            }
            else
            {
                $stock = 0;
            }

            $nouvelleAutre = new Autre();

            $nouvelleAutre->setIdProduit($_POST['id_produit']);
            $nouvelleAutre->setNomProduit($_POST['nom_produit']);
            $nouvelleAutre->setDescriptionProduit($_POST['description_produit']);
            $nouvelleAutre->setPrixProduit($_POST['prix_produit']);
            $nouvelleAutre->setStockProduit($stock);
            $nouvelleAutre->setPromoProduit($_POST['promo_produit']);
            $nouvelleAutre->setPrixPromoProduit($prix_promo_produit);
            $nouvelleAutre->setIdCategorie($_POST['categorie_produit']);
            $nouvelleAutre->setIdGenre($genre);
            $nouvelleAutre->setIdMarque($_POST['marque_produit']);
            $nouvelleAutre->setDetailAutre($_POST['detail_autre']);
            $nouvelleAutre->setNomImage($_FILES['images']['name']);
            $nouvelleAutre->setDescriptionImage($_POST['description_images']);
            $nouvelleAutre->setIdTypeAutre($_POST['type_autre']);
          
            if ($nouvelleAutre) 
            {
                if (isset($_FILES['images']) && !empty($_FILES['images']['name']))
                {
                    $imageRepo = new ImageRepository;

                    $imageRepo->deleteImagesByProduit($_POST['id_produit']);

                    $fileName = $_FILES['images']['name'];
                    $fileTmpName = $_FILES['images']['tmp_name'];
                    $fileType = $_FILES['images']['type'];
                    $fileSize = $_FILES['images']['size'];
                    $fileError = $_FILES['images']['error'];

                    $image = new Image();
                    $image->setNomImage($fileName);
                    $image->setDescriptionImage($_POST['description_images']);

                    
                    $imageRepo->insertImage($_FILES['images'], $_POST['description_images']);
                    $image->addImage($_FILES['images']);
                }
                    

                $autreRepo = new AutreRepository();
                $autreRepo->updateAutre($nouvelleAutre);

                $produitRepo = new ProduitRepository;
                $descriptionImage = htmlspecialchars($_POST['description_images']);

                $imagePath = $image->addImage($_FILES['images']);

                $image = new Image();
                $image->setNomImage($imagePath);
                $image->setDescriptionImage($descriptionImage);

                $idProduit = $produitRepo->getLastId();
                $idImage = $imageRepo->getLastId();

                $imageRepo->addImageToProduit($idProduit, $idImage);

                header('Location: admin.php');
                exit();
            }
            else 
            {
                echo "Les données du nouvel autre ne sont pas valides.";
                exit();
            }
        }
        else 
        {
            echo "Certaines données sont manquantes pour ajouter un nouvel autre.";
            exit();
        }

        header('Location: admin.php');
        exit();
    }
}

function deleteAutre()
{
    if (isset($_POST['id_produit']))
    {
        $id_produit = $_POST['id_produit'];

        $autreRepo = new AutreRepository();
        $imageRepo = new ImageRepository();

        $imageRepo->deleteImagesByProduit($id_produit);

        $autreRepo->deleteAutre($id_produit);

        header('Location: admin.php');
    } 
    else 
    {
        echo "ID de l'autre manquant.";
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

function addTypePlombTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_type_plomb']))
        {
            $newTypePlomb = [];
            $newTypePlomb['nom_type_plomb'] = htmlspecialchars($_POST['nom_type_plomb']);

            $typePlomb = new TypePlomb;
            $typePlomb->createToInserTypePlomb($newTypePlomb);

            if($typePlomb == true)
            {
                $typePlombRepo = new TypePlombRepository;
                $typePlombRepo->insertTypePlomb($typePlomb);
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

function addTypeAutreTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_type_autre']))
        {
            $newTypeAutre = [];
            $newTypeAutre['nom_type_autre'] = htmlspecialchars($_POST['nom_type_autre']);

            $typeAutre = new TypeAutre;
            $typeAutre->createToInserTypeAutre($newTypeAutre);

            if($typeAutre == true)
            {
                $typeAutreRepo = new TypeAutreRepository;
                $typeAutreRepo->insertTypeAutre($typeAutre);
                header('location: admin.php');
            }
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

function deleteTypePlomb()
{

        if(!empty($_POST['id_type_plomb']) && isset($_POST['id_type_plomb']))
        {
            $id_type_plomb = isset($_POST['id_type_plomb']) ? $_POST['id_type_plomb'] : null;
            $typePlombRepository = new TypePlombRepository();
            $deleteTypePlomb = $typePlombRepository->deleteTypePlomb($id_type_plomb);
    
            if ($deleteTypePlomb)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression du type de plomb échoué';
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

function deleteTypeAutre()
{
        if(!empty($_POST['id_type_autre']) && isset($_POST['id_type_autre']))
        {
            $id_type_autre = isset($_POST['id_type_autre']) ? $_POST['id_type_autre'] : null;
            $typeAutreRepository = new TypeAutreRepository();
            $deleteTypeAutre = $typeAutreRepository->deleteTypeAutre($id_type_autre);
    
            if ($deleteTypeAutre)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression du type de autre échoué';
                header('location: admin.php');
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

    foreach ($articles['plombs'] as $plomb) 
    {
        if ($plomb) 
        {
            $imgPlombRepo = new ImagePlombRepository;
            $imgPlomb = $imgPlombRepo->getImageByPlomb($plomb->getIdPlomb());

            $combinedArticles[] =
            [
                'genre' => 'plomb',
                'id' => $plomb->getIdPlomb(),
                'nom' => $plomb->getNomPlomb(),
                'image' => $imgPlomb->getNomImagePlomb(),
                'marque' => $plomb->getMarquePlomb(),
                'type' => $plomb->getTypePlomb(),
                'categorie' => $plomb->getCategoriePlomb(),
                'promo' => $plomb->getPromoPlomb(),
                'stock' => $plomb->getStockPlomb(),
                'description' => $plomb->getDescriptionPlomb(),
                'poids' => $plomb->getPoidsPlomb(),
                'longueur' => $plomb->getLongueurPlomb(),
                'diametre' => $plomb->getDiametrePlomb(),
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

    $typeAutreRepo = new TypeAutreRepository;
    $allTypes['autre'] = $typeAutreRepo->getAllTypeAutre();

    return $allTypes;
}