<?php

require_once('autoload/autoloader.php');
require_once('src/model/Produit/Canne.php');
require_once('src/model/Produit/Moulinet.php');
require_once('src/model/Produit/Hamecon.php');
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
    $canneRepo = new CanneRepository;
    $cannes = $canneRepo->getAllCanne();

    $typeCanneRepo = new TypeCanneRepository;
    $typeCannes = $typeCanneRepo->getAllTypeCanne();

    $moulinetRepo = new MoulinetRepository;
    $moulinets = $moulinetRepo->getAllmoulinet();

    $typeMoulinetRepo = new TypemoulinetRepository;
    $typeMoulinets = $typeMoulinetRepo->getAllTypemoulinet();

    $hameconRepo = new HameconRepository;
    $hamecons = $hameconRepo->getAllHamecon();

    $typeHameconRepo = new TypeHameconRepository;
    $typeHamecons = $typeHameconRepo->getAllTypeHamecon();

    $leurreRepo = new LeurreRepository;
    $leurres = $leurreRepo->getAllleurre();

    $typeLeurreRepo = new TypeLeurreRepository;
    $typeLeurres = $typeLeurreRepo->getAllTypeLeurre();

    $ligneRepo = new LigneRepository;
    $lignes = $ligneRepo->getAllLigne();

    $typeLigneRepo = new TypeLigneRepository;
    $typeLignes = $typeLigneRepo->getAllTypeLigne();

    $feederRepo = new FeederRepository;
    $feeders = $feederRepo->getAllFeeder();

    $typeFeederRepo = new TypeFeederRepository;
    $typeFeeders = $typeFeederRepo->getAllTypeFeeder();

    $equipementRepo = new EquipementRepository;
    $equipements = $equipementRepo->getAllEquipement();

    $typeEquipementRepo = new TypeEquipementRepository;
    $typeEquipements = $typeEquipementRepo->getAllTypeEquipement();

    $appatRepo = new AppatRepository;
    $appats = $appatRepo->getAllAppat();

    $typeAppatRepo = new TypeAppatRepository;
    $typeAppats = $typeAppatRepo->getAllTypeAppat();

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    require('src/view/adminPage.php');
}

function addCanneTraitement()
{
    if(isset($_POST))
    
    {
        if(!empty($_POST['nom_canne']) && !empty($_POST['poids_canne']) && !empty($_POST['longueur_canne']) && !empty($_POST['categorie_canne']) && !empty($_POST['type_canne']) && !empty($_POST['marque_canne']) && !empty($_POST['promo_canne']) && !empty($_POST['stock_canne']) && !empty($_POST['description_canne'] && !empty($_FILES['image_canne'])))
        {
            $newCanne = [];
            $newCanne['nom_canne'] = htmlspecialchars($_POST['nom_canne']);
            $newCanne['poids_canne'] = htmlspecialchars($_POST['poids_canne']);
            $newCanne['longueur_canne'] = htmlspecialchars($_POST['longueur_canne']);
            $newCanne['categorie_canne'] = htmlspecialchars($_POST['categorie_canne']);
            $newCanne['type_canne'] = htmlspecialchars($_POST['type_canne']);
            $newCanne['marque_canne'] = htmlspecialchars($_POST['marque_canne']);
            $newCanne['description_canne'] = htmlspecialchars($_POST['description_canne']);
            $newCanne['promo_canne'] = htmlspecialchars($_POST['promo_canne']);
            $newCanne['stock_canne'] = htmlspecialchars($_POST['stock_canne']);
            $newCanne['image_canne'] = $_FILES['image_canne'];
            
            if($newCanne['stock_canne'] === 'stock') 
            {
                $newCanne['stock_canne'] = 1;
                $newCanne['hors_stock_canne'] = 0;
            }
            else
            {
                $newCanne['stock_canne'] = 0;
                $newCanne['hors_stock_canne'] = 1;
            }

            if($newCanne['promo_canne'] === 'promo')
            {
                $newCanne['promo_canne'] = 1;
            }
            else
            {
                $newCanne['promo_canne'] = 0;
            }
            
            $imageCanne = new ImageCanne;
            $canne = new Canne;
            $canne->createToInsertCanne($newCanne);
            
            if($canne == true)
            {
                $imageCanne->addImageCanne($newCanne['image_canne']);

                $imageCanneRepo = new ImageCanneRepository;
                $canneRepo = new CanneRepository;

                $canneRepo->insertCanne($canne);
            
                $lastInsertIdCanne = $canneRepo->getLastInsertId();
                
                $imageCanne->setIdCanne($lastInsertIdCanne);
                $imageCanneRepo->insertImageCanne($imageCanne);

                header('location: admin.php');
            }
        }
    }
}

function addMoulinetTraitement()
{
    if(isset($_POST))
    
    {
        if(!empty($_POST['nom_moulinet']) && !empty($_POST['poids_moulinet']) && !empty($_POST['ratio_moulinet']) && !empty($_POST['categorie_moulinet']) && !empty($_POST['type_moulinet']) && !empty($_POST['marque_moulinet']) && !empty($_POST['promo_moulinet']) && !empty($_POST['stock_moulinet']) && !empty($_POST['description_moulinet'] && !empty($_FILES['image_moulinet'])))
        {
            $newMoulinet = [];
            $newMoulinet['nom_moulinet'] = htmlspecialchars($_POST['nom_moulinet']);
            $newMoulinet['poids_moulinet'] = htmlspecialchars($_POST['poids_moulinet']);
            $newMoulinet['ratio_moulinet'] = htmlspecialchars($_POST['ratio_moulinet']);
            $newMoulinet['categorie_moulinet'] = htmlspecialchars($_POST['categorie_moulinet']);
            $newMoulinet['type_moulinet'] = htmlspecialchars($_POST['type_moulinet']);
            $newMoulinet['marque_moulinet'] = htmlspecialchars($_POST['marque_moulinet']);
            $newMoulinet['description_moulinet'] = htmlspecialchars($_POST['description_moulinet']);
            $newMoulinet['promo_moulinet'] = htmlspecialchars($_POST['promo_moulinet']);
            $newMoulinet['stock_moulinet'] = htmlspecialchars($_POST['stock_moulinet']);
            $newMoulinet['image_moulinet'] = $_FILES['image_moulinet'];
            
            if($newMoulinet['stock_moulinet'] === 'stock') 
            {
                $newMoulinet['stock_moulinet'] = 1;
                $newMoulinet['hors_stock_moulinet'] = 0;
            }
            else
            {
                $newMoulinet['stock_moulinet'] = 0;
                $newMoulinet['hors_stock_moulinet'] = 1;
            }

            if($newMoulinet['promo_moulinet'] === 'promo')
            {
                $newMoulinet['promo_moulinet'] = 1;
            }
            else
            {
                $newMoulinet['promo_moulinet'] = 0;
            }
            
            $imageMoulinet = new ImageMoulinet;
            $moulinet = new Moulinet;
            $moulinet->createToInsertMoulinet($newMoulinet);
            
            if($moulinet == true)
            {
                $imageMoulinet->addImageMoulinet($newMoulinet['image_moulinet']);

                $imageMoulinetRepo = new ImageMoulinetRepository;
                $moulinetRepo = new MoulinetRepository;

                $moulinetRepo->insertMoulinet($moulinet);
            
                $lastInsertIdMoulinet = $moulinetRepo->getLastInsertId();
                
                $imageMoulinet->setIdMoulinet($lastInsertIdMoulinet);
                $imageMoulinetRepo->insertImageMoulinet($imageMoulinet);

                header('location: admin.php');
            }
        }
    }
}

function addHameconTraitement()
{
    if(isset($_POST))
    
    {
        if(!empty($_POST['nom_hamecon']) && !empty($_POST['poids_hamecon']) && !empty($_POST['longueur_hamecon']) && !empty($_POST['categorie_hamecon']) && !empty($_POST['type_hamecon']) && !empty($_POST['marque_hamecon']) && !empty($_POST['promo_hamecon']) && !empty($_POST['stock_hamecon']) && !empty($_POST['description_hamecon'] && !empty($_FILES['image_hamecon'])))
        {
            
            $newHamecon = [];
            $newHamecon['nom_hamecon'] = htmlspecialchars($_POST['nom_hamecon']);
            $newHamecon['poids_hamecon'] = htmlspecialchars($_POST['poids_hamecon']);
            $newHamecon['longueur_hamecon'] = htmlspecialchars($_POST['longueur_hamecon']);
            $newHamecon['categorie_hamecon'] = htmlspecialchars($_POST['categorie_hamecon']);
            $newHamecon['type_hamecon'] = htmlspecialchars($_POST['type_hamecon']);
            $newHamecon['marque_hamecon'] = htmlspecialchars($_POST['marque_hamecon']);
            $newHamecon['description_hamecon'] = htmlspecialchars($_POST['description_hamecon']);
            $newHamecon['promo_hamecon'] = htmlspecialchars($_POST['promo_hamecon']);
            $newHamecon['stock_hamecon'] = htmlspecialchars($_POST['stock_hamecon']);
            $newHamecon['image_hamecon'] = $_FILES['image_hamecon'];
            
            if($newHamecon['stock_hamecon'] === 'stock') 
            {
                $newHamecon['stock_hamecon'] = 1;
                $newHamecon['hors_stock_hamecon'] = 0;
            }
            else
            {
                $newHamecon['stock_hamecon'] = 0;
                $newHamecon['hors_stock_hamecon'] = 1;
            }

            if($newHamecon['promo_hamecon'] === 'promo')
            {
                $newHamecon['promo_hamecon'] = 1;
            }
            else
            {
                $newHamecon['promo_hamecon'] = 0;
            }
            
            $imageHamecon = new ImageHamecon;
            $hamecon = new Hamecon;
            $hamecon->createToInsertHamecon($newHamecon);
            
            if($hamecon == true)
            {
                $imageHamecon->addImageHamecon($newHamecon['image_hamecon']);

                $imageHameconRepo = new ImageHameconRepository;
                $hameconRepo = new HameconRepository;

                $hameconRepo->insertHamecon($hamecon);
            
                $lastInsertIdHamecon = $hameconRepo->getLastInsertId();
                
                $imageHamecon->setIdHamecon($lastInsertIdHamecon);
                $imageHameconRepo->insertImageHamecon($imageHamecon);

                header('location: admin.php');
            }
        }
    }
}

function addLeurreTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['nom_leurre']) && !empty($_POST['poids_leurre']) && !empty($_POST['diametre_leurre']) && !empty($_POST['longueur_leurre']) && !empty($_POST['categorie_leurre']) && !empty($_POST['type_leurre']) && !empty($_POST['marque_leurre']) && !empty($_POST['promo_leurre']) && !empty($_POST['stock_leurre']) && !empty($_POST['description_leurre'] && !empty($_FILES['image_leurre'])))
        {
            $newLeurre = [];
            $newLeurre['nom_leurre'] = htmlspecialchars($_POST['nom_leurre']);
            $newLeurre['longueur_leurre'] = htmlspecialchars($_POST['longueur_leurre']);
            $newLeurre['diametre_leurre'] = htmlspecialchars($_POST['diametre_leurre']);
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

function deleteCanne()
{
    // if($_SESSION['id_role'] === 1)
    // {
        if(!empty($_POST['id_canne']) && isset($_POST['id_canne']))
        {
            var_dump($_POST);
            die;
            $id_canne = isset($_POST['id_canne']) ? $_POST['id_canne'] : null;
            $canneRepository = new CanneRepository();
            $deleteCanne = $canneRepository->deleteCanne($id_canne);
    
            if ($deleteCanne)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de l\'article échoué';
                header('location: admin.php');
            }
        }
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteMoulinet()
{
    // if($_SESSION['id_role'] === 1)
    // {
        if(!empty($_POST['id_moulinet']) && isset($_POST['id_moulinet']))
        {
            var_dump($_POST);
            die;
            $id_moulinet = isset($_POST['id_moulinet']) ? $_POST['id_moulinet'] : null;
            $moulinetRepository = new MoulinetRepository();
            $deleteMoulinet = $moulinetRepository->deleteMoulinet($id_moulinet);
    
            if ($deleteMoulinet)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de l\'article échoué';
                header('location: admin.php');
            }
        }
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteHamecon()
{
    // if($_SESSION['id_role'] === 1)
    // {
        if(!empty($_POST['id_hamecon']) && isset($_POST['id_hamecon']))
        {
            var_dump($_POST);
            die;
            $id_hamecon = isset($_POST['id_hamecon']) ? $_POST['id_hamecon'] : null;
            $hameconRepository = new HameconRepository();
            $deleteHamecon = $hameconRepository->deleteHamecon($id_hamecon);
    
            if ($deleteHamecon)
            {
                header('location: admin.php');
            }
            else 
            {
                $_SESSION['messageError'] = 'Suppression de l\'article échoué';
                header('location: admin.php');
            }
        }
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteLeurre()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteLigne()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteFeeder()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteEquipement()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteAppat()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}


function deleteCategorie()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteMarque()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteTypeCanne()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteTypeMoulinet()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteTypeHamecon()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteTypeLeurre()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteTypeLigne()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteTypeFeeder()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteTypeEquipement()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function deleteTypeAppat()
{
    // if($_SESSION['id_role'] === 1)
    // {
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
        
    // }
    // else
    // {
    //     home();
    // }
}

function UpdateCanneTraitement()
{
    // if($_SESSION['id_role'] === 1)
    // { 
    $img = new ImageCanneRepository;
    $oldImg = $img->getImageByCanne($_POST['id_canne']);

    $cheminFichier = $oldImg->getNomImageCanne();

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

    if(isset($_POST['id_canne']) && isset($_POST['nom_canne']) && isset($_POST['poids_canne']) && isset($_POST['longueur_canne']) && isset($_POST['description_canne']) && isset($_POST['promo_canne']) && isset($_POST['stock_canne']) && isset($_POST['categorie_canne']) && isset($_POST['type_canne']) && isset($_POST['marque_canne']) && isset($_FILES['image_canne']))
    {
        $id_canne = isset($_POST['id_canne']) ? htmlspecialchars($_POST['id_canne']) : null;
        $nom_canne = isset($_POST['nom_canne']) ? htmlspecialchars($_POST['nom_canne']) : null;
        $poids_canne = isset($_POST['poids_canne']) ? htmlspecialchars($_POST['poids_canne']) : null;
        $longueur_canne = isset($_POST['longueur_canne']) ? htmlspecialchars($_POST['longueur_canne']) : null;
        $description_canne = isset($_POST['description_canne']) ? htmlspecialchars($_POST['description_canne']) : null;
        $promo_canne = isset($_POST['promo_canne']) ? htmlspecialchars($_POST['promo_canne']) : null;
        $stock_canne = isset($_POST['stock_canne']) ? htmlspecialchars($_POST['stock_canne']) : null;
        $id_categorie = isset($_POST['categorie_canne']) ? htmlspecialchars($_POST['categorie_canne']) : null;
        $id_type_canne = isset($_POST['type_canne']) ? htmlspecialchars($_POST['type_canne']) : null;
        $id_marque = isset($_POST['marque_canne']) ? htmlspecialchars($_POST['marque_canne']) : null;
        $image_canne = isset($_FILES['image_canne']) ? $_FILES['image_canne'] : null;

        if($stock_canne === 'stock') 
        {
            $stock_canne = 1;
            $hors_stock_canne = 0;
        }
        else
        {
            $stock_canne = 0;
            $hors_stock_canne = 1;
        }

        if($promo_canne === 'promo')
        {
            $promo_canne = 1;
        }
        else
        {
            $promo_canne = 0;
        }

        $canneRepository = new CanneRepository;
        $imageCanneRepo = new ImageCanneRepository;
        
        $update = $canneRepository->updateCanne($id_canne, $nom_canne, $poids_canne, $longueur_canne, $description_canne, $promo_canne, $stock_canne, $hors_stock_canne, $id_categorie, $id_type_canne, $id_marque);
        $updateImageCanne = $imageCanneRepo->updateImageByCanne($image_canne, $id_canne);
        
        if ($update && $updateImageCanne)
        {
            header("location:admin.php");
        }
        else 
        {
            echo 'non';
        }
    } 
    // }
    // else
    // {
    //     home();
    // }
}

function UpdateMoulinetTraitement()
{
    // if($_SESSION['id_role'] === 1)
    // { 
    $img = new ImageMoulinetRepository;
    $oldImg = $img->getImageByMoulinet($_POST['id_moulinet']);

    $cheminFichier = $oldImg->getNomImageMoulinet();

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

    if(isset($_POST['id_moulinet']) && isset($_POST['nom_moulinet']) && isset($_POST['poids_moulinet']) && isset($_POST['ratio_moulinet']) && isset($_POST['description_moulinet']) && isset($_POST['promo_moulinet']) && isset($_POST['stock_moulinet']) && isset($_POST['categorie_moulinet']) && isset($_POST['type_moulinet']) && isset($_POST['marque_moulinet']) && isset($_FILES['image_moulinet']))
    {
        $id_moulinet = isset($_POST['id_moulinet']) ? htmlspecialchars($_POST['id_moulinet']) : null;
        $nom_moulinet = isset($_POST['nom_moulinet']) ? htmlspecialchars($_POST['nom_moulinet']) : null;
        $poids_moulinet = isset($_POST['poids_moulinet']) ? htmlspecialchars($_POST['poids_moulinet']) : null;
        $ratio_moulinet = isset($_POST['ratio_moulinet']) ? htmlspecialchars($_POST['ratio_moulinet']) : null;
        $description_moulinet = isset($_POST['description_moulinet']) ? htmlspecialchars($_POST['description_moulinet']) : null;
        $promo_moulinet = isset($_POST['promo_moulinet']) ? htmlspecialchars($_POST['promo_moulinet']) : null;
        $stock_moulinet = isset($_POST['stock_moulinet']) ? htmlspecialchars($_POST['stock_moulinet']) : null;
        $id_categorie = isset($_POST['categorie_moulinet']) ? htmlspecialchars($_POST['categorie_moulinet']) : null;
        $id_type_moulinet = isset($_POST['type_moulinet']) ? htmlspecialchars($_POST['type_moulinet']) : null;
        $id_marque = isset($_POST['marque_moulinet']) ? htmlspecialchars($_POST['marque_moulinet']) : null;
        $image_moulinet = isset($_FILES['image_moulinet']) ? $_FILES['image_moulinet'] : null;

        if($stock_moulinet === 'stock')
        {
            $stock_moulinet = 1;
            $hors_stock_moulinet = 0;
        }
        else
        {
            $stock_moulinet = 0;
            $hors_stock_moulinet = 1;
        }

        if($promo_moulinet === 'promo')
        {
            $promo_moulinet = 1;
        }
        else
        {
            $promo_moulinet = 0;
        }

        $moulinetRepository = new MoulinetRepository;
        $imageMoulinetRepo = new ImageMoulinetRepository;
        
        $update = $moulinetRepository->updateMoulinet($id_moulinet, $nom_moulinet, $poids_moulinet, $ratio_moulinet, $description_moulinet, $promo_moulinet, $stock_moulinet, $hors_stock_moulinet, $id_categorie, $id_type_moulinet, $id_marque);
        $updateImageMoulinet = $imageMoulinetRepo->updateImageByMoulinet($image_moulinet, $id_moulinet);
        
        if ($update && $updateImageMoulinet)
        {
            header("location:admin.php");
        }
        else 
        {
            echo 'non';
        }
    } 
    // }
    // else
    // {
    //     home();
    // }
}

function UpdateHameconTraitement()
{
    // if($_SESSION['id_role'] === 1)
    // { 
    $img = new ImageHameconRepository;
    $oldImg = $img->getImageByHamecon($_POST['id_hamecon']);

    $cheminFichier = $oldImg->getNomImageHamecon();

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

    if(isset($_POST['id_hamecon']) && isset($_POST['nom_hamecon']) && isset($_POST['poids_hamecon']) && isset($_POST['ratio_hamecon']) && isset($_POST['description_hamecon']) && isset($_POST['promo_hamecon']) && isset($_POST['stock_hamecon']) && isset($_POST['categorie_hamecon']) && isset($_POST['type_hamecon']) && isset($_POST['marque_hamecon']) && isset($_FILES['image_hamecon']))
    {
        $id_hamecon = isset($_POST['id_hamecon']) ? htmlspecialchars($_POST['id_hamecon']) : null;
        $nom_hamecon = isset($_POST['nom_hamecon']) ? htmlspecialchars($_POST['nom_hamecon']) : null;
        $poids_hamecon = isset($_POST['poids_hamecon']) ? htmlspecialchars($_POST['poids_hamecon']) : null;
        $ratio_hamecon = isset($_POST['ratio_hamecon']) ? htmlspecialchars($_POST['ratio_hamecon']) : null;
        $description_hamecon = isset($_POST['description_hamecon']) ? htmlspecialchars($_POST['description_hamecon']) : null;
        $promo_hamecon = isset($_POST['promo_hamecon']) ? htmlspecialchars($_POST['promo_hamecon']) : null;
        $stock_hamecon = isset($_POST['stock_hamecon']) ? htmlspecialchars($_POST['stock_hamecon']) : null;
        $id_categorie = isset($_POST['categorie_hamecon']) ? htmlspecialchars($_POST['categorie_hamecon']) : null;
        $id_type_hamecon = isset($_POST['type_hamecon']) ? htmlspecialchars($_POST['type_hamecon']) : null;
        $id_marque = isset($_POST['marque_hamecon']) ? htmlspecialchars($_POST['marque_hamecon']) : null;
        $image_hamecon = isset($_FILES['image_hamecon']) ? $_FILES['image_hamecon'] : null;

        if($stock_hamecon === 'stock') 
        {
            $stock_hamecon = 1;
            $hors_stock_hamecon = 0;
        }
        else
        {
            $stock_hamecon = 0;
            $hors_stock_hamecon = 1;
        }

        if($promo_hamecon === 'promo')
        {
            $promo_hamecon = 1;
        }
        else
        {
            $promo_hamecon = 0;
        }

        $hameconRepository = new HameconRepository;
        $imageHameconRepo = new ImageHameconRepository;
        
        $update = $hameconRepository->updateHamecon($id_hamecon, $nom_hamecon, $poids_hamecon, $ratio_hamecon, $description_hamecon, $promo_hamecon, $stock_hamecon, $hors_stock_hamecon, $id_categorie, $id_type_hamecon, $id_marque);
        $updateImageHamecon = $imageHameconRepo->updateImageByHamecon($image_hamecon, $id_hamecon);
        
        if ($update && $updateImageHamecon)
        {
            header("location:admin.php");
        }
        else 
        {
            echo 'non';
        }
    } 
    // }
    // else
    // {
    //     home();
    // }
}

function UpdateLeurreTraitement()
{
    // if($_SESSION['id_role'] === 1)
    // { 
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
    // }
    // else
    // {
    //     home();
    // }
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
    // }
    // else
    // {
    //     home();
    // }
}

function UpdateFeederTraitement()
{
    // if($_SESSION['id_role'] === 1)
    // { 
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
    // }
    // else
    // {
    //     home();
    // }
}

function UpdateEquipementTraitement()
{
    // if($_SESSION['id_role'] === 1)
    // { 
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
    // }
    // else
    // {
    //     home();
    // }
}

function UpdateAppatTraitement()
{
    // if($_SESSION['id_role'] === 1)
    // { 
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
    // }
    // else
    // {
    //     home();
    // }
}