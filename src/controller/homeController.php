<?php

require_once ('autoload/autoloader.php');
require_once ('src/model/User.php');

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

function home()
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

    $marques = viewAllMarque();

    $categories = viewAllCategorie();
    
    $combinedArticles = getLastArticles();

    $promoArticles = getPromoArticles();
    
    include ('src/view/homePage.php');
}

function getLastArticles()
{
    $lastCanneRepo = new CanneRepository;
    $lastMoulinetRepo = new MoulinetRepository;
    $lastHameconRepo = new HameconRepository;
    $lastLeurreRepo = new LeurreRepository;
    $lastLigneRepo = new LigneRepository;
    $lastEquipementRepo = new EquipementRepository;
    $lastFeederRepo = new FeederRepository;
    $lastAppatRepo = new AppatRepository;
    
    $articles = [];

    $articles['cannes'] = $lastCanneRepo->getLastCanne();
    $articles['moulinets'] = $lastMoulinetRepo->getLastMoulinet();
    $articles['hamecons'] = $lastHameconRepo->getLastHamecon();
    $articles['leurres'] = $lastLeurreRepo->getLastLeurre();
    $articles['lignes'] = $lastLigneRepo->getLastLigne();
    $articles['equipements'] = $lastEquipementRepo->getLastEquipement();
    $articles['feeders'] = $lastFeederRepo->getLastFeeder();
    $articles['appats'] = $lastAppatRepo->getLastAppat();

    $combinedArticles = [];

    foreach ($articles['cannes'] as $canne) 
    {
        if($canne)
        {
            $imgCanneRepo = new ImageCanneRepository;
            $imgCannes = $imgCanneRepo->getImageByCanne($canne->getIdCanne());
            $combinedArticles[] = [
                'type' => 'canne',
                'id' => $canne->getIdCanne(),
                'nom' => $canne->getNomCanne(),
                'image' => $imgCannes->getNomImageCanne(),
                'marque' => $canne->getMarqueCanne()
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['moulinets'] as $moulinet)
    {
        if($moulinet)
        {
            $imgMoulinetRepo = new ImageMoulinetRepository;
            $imgMoulinet = $imgMoulinetRepo->getImageByMoulinet($moulinet->getIdMoulinet());
            $combinedArticles[] = [
                'type' => 'moulinet',
                'id' => $moulinet->getIdMoulinet(),
                'nom' => $moulinet->getNomMoulinet(),
                'image' => $imgMoulinet->getNomImageMoulinet(),
                'marque' => $moulinet->getMarqueMoulinet()
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['hamecons'] as $hamecon) 
    {
        if($hamecon)
        {
            $imgHameconRepo = new ImageHameconRepository;
            $imgHamecon = $imgHameconRepo->getImageByHamecon($hamecon->getIdHamecon());
        
            $combinedArticles[] = 
            [
                'type' => 'hamecon',
                'id' => $hamecon->getIdHamecon(),
                'nom' => $hamecon->getNomHamecon(),
                'image' => $imgHamecon->getNomImageHamecon(),
                'marque' => $hamecon->getMarqueHamecon()
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['leurres'] as $leurre) 
    {
        if($leurre)
        {
            $imgLeurreRepo = new ImageLeurreRepository;
            $imgLeurre = $imgLeurreRepo->getImageByLeurre($leurre->getIdLeurre());
        
            $combinedArticles[] = 
            [
                'type' => 'leurre',
                'id' => $leurre->getIdLeurre(),
                'nom' => $leurre->getNomLeurre(),
                'image' => $imgLeurre->getNomImageLeurre(),
                'marque' => $leurre->getMarqueLeurre()
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['lignes'] as $ligne) 
    {
        if($ligne)
        {
            $imgLigneRepo = new ImageLigneRepository;
            $imgLigne = $imgLigneRepo->getImageByLigne($ligne->getIdLigne());
        
            $combinedArticles[] = 
            [
                'type' => 'ligne',
                'id' => $ligne->getIdLigne(),
                'nom' => $ligne->getNomLigne(),
                'image' => $imgLigne->getNomImageLigne(),
                'marque' => $ligne->getMarqueLigne()
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['equipements'] as $equipement) 
    {
        if($equipement)
        {
            $imgEquipementRepo = new ImageEquipementRepository;
            $imgEquipement = $imgEquipementRepo->getImageByEquipement($equipement->getIdEquipement());
        
            $combinedArticles[] = 
            [
                'type' => 'equipement',
                'id' => $equipement->getIdEquipement(),
                'nom' => $equipement->getNomEquipement(),
                'image' => $imgEquipement->getNomImageEquipement(),
                'marque' => $equipement->getMarqueEquipement()
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['feeders'] as $feeder) 
    {
        if($feeder)
        {
            $imgFeederRepo = new ImageFeederRepository;
            $imgFeeder = $imgFeederRepo->getImageByFeeder($feeder->getIdFeeder());
        
            $combinedArticles[] = 
            [
                'type' => 'plomb',
                'id' => $feeder->getIdFeeder(),
                'nom' => $feeder->getNomFeeder(),
                'image' => $imgFeeder->getNomImageFeeder(),
                'marque' => $feeder->getMarqueFeeder()
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['appats'] as $appat) 
    {
        if($appat)
        {
            $imgAppatRepo = new ImageAppatRepository;
            $imgAppat = $imgAppatRepo->getImageByAppat($appat->getIdAppat());
        
            $combinedArticles[] = 
            [
                'type' => 'appat',
                'id' => $appat->getIdAppat(),
                'nom' => $appat->getNomAppat(),
                'image' => $imgAppat->getNomImageAppat(),
                'marque' => $appat->getMarqueAppat()
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    $articles = array_reverse($combinedArticles);
    return $articles;
}

function getAllArticles()
{
    $allCanneRepo = new CanneRepository;
    $allMoulinetRepo = new MoulinetRepository;
    $allHameconRepo = new HameconRepository;
    $allLeurreRepo = new LeurreRepository;
    $allLigneRepo = new LigneRepository;
    $allEquipementRepo = new EquipementRepository;
    $allFeederRepo = new FeederRepository;
    $allAppatRepo = new AppatRepository;
    
    $articles = [];

    $articles['cannes'] = $allCanneRepo->getLastCanne();
    $articles['moulinets'] = $allMoulinetRepo->getLastMoulinet();
    $articles['hamecons'] = $allHameconRepo->getLastHamecon();
    $articles['leurres'] = $allLeurreRepo->getLastLeurre();
    $articles['lignes'] = $allLigneRepo->getLastLigne();
    $articles['equipements'] = $allEquipementRepo->getLastEquipement();
    $articles['feeders'] = $allFeederRepo->getLastFeeder();
    $articles['appats'] = $allAppatRepo->getLastAppat();

    $combinedArticles = [];

    foreach ($articles['cannes'] as $canne) 
    {
        if($canne)
        {
            $imgCanneRepo = new ImageCanneRepository;
            $imgCannes = $imgCanneRepo->getImageByCanne($canne->getIdCanne());
            $combinedArticles[] = [
                'genre' => 'canne',
                'id' => $canne->getIdCanne(),
                'nom' => $canne->getNomCanne(),
                'image' => $imgCannes->getNomImageCanne(),
                'marque' => $canne->getMarqueCanne(),
                'type' => $canne->getTypeCanne(),
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['moulinets'] as $moulinet)
    {
        if($moulinet)
        {
            $imgMoulinetRepo = new ImageMoulinetRepository;
            $imgMoulinet = $imgMoulinetRepo->getImageByMoulinet($moulinet->getIdMoulinet());
            $combinedArticles[] = [
                'genre' => 'moulinet',
                'id' => $moulinet->getIdMoulinet(),
                'nom' => $moulinet->getNomMoulinet(),
                'image' => $imgMoulinet->getNomImageMoulinet(),
                'marque' => $moulinet->getMarqueMoulinet(),
                'type' => $moulinet->getTypeMoulinet(),
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['hamecons'] as $hamecon) 
    {
        if($hamecon)
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
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['leurres'] as $leurre) 
    {
        if($leurre)
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
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['lignes'] as $ligne) 
    {
        if($ligne)
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
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['equipements'] as $equipement) 
    {
        if($equipement)
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
                'type' => $equipement->getTypeEquipement()
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['feeders'] as $feeder) 
    {
        if($feeder)
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
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    foreach ($articles['appats'] as $appat) 
    {
        if($appat)
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
                'type' => $appat->getTypeAppat()
            ];
        }
        else
        {
            $combinedArticles[] = [''];
        }
    }

    $articles = array_reverse($combinedArticles);
    return $articles;
}

function getPromoArticles()
{
    $lastCanneRepo = new CanneRepository;
    $lastMoulinetRepo = new MoulinetRepository;
    $lastHameconRepo = new HameconRepository;
    $lastLeurreRepo = new LeurreRepository;
    $lastLigneRepo = new LigneRepository;
    $lastEquipementRepo = new EquipementRepository;
    $lastFeederRepo = new FeederRepository;
    $lastAppatRepo = new AppatRepository;
    
    $articles = [];

    $articles['cannes'] = $lastCanneRepo->getPromoCanne();
    $articles['moulinets'] = $lastMoulinetRepo->getPromoMoulinet();
    $articles['hamecons'] = $lastHameconRepo->getPromoHamecon();
    $articles['leurres'] = $lastLeurreRepo->getPromoLeurre();
    $articles['lignes'] = $lastLigneRepo->getPromoLigne();
    $articles['equipements'] = $lastEquipementRepo->getPromoEquipement();
    $articles['feeders'] = $lastFeederRepo->getPromoFeeder();
    $articles['appats'] = $lastAppatRepo->getPromoAppat();

    $promoArticles = [];

    foreach ($articles['cannes'] as $canne) 
    {
        if($canne)
        {
            $imgCanneRepo = new ImageCanneRepository;
            $imgCannes = $imgCanneRepo->getImageByCanne($canne->getIdCanne());
            $promoArticles[] = [
                'type' => 'canne',
                'id' => $canne->getIdCanne(),
                'nom' => $canne->getNomCanne(),
                'image' => $imgCannes->getNomImageCanne(),
                'marque' => $canne->getMarqueCanne()
            ];
        }
        else
        {
            $promoArticles[] = [''];
        }
    }

    foreach ($articles['moulinets'] as $moulinet) 
    {
        if($moulinet)
        {
            $imgMoulinetRepo = new ImageMoulinetRepository;
            $imgMoulinet = $imgMoulinetRepo->getImageByMoulinet($moulinet->getIdMoulinet());
            $promoArticles[] = [
                'type' => 'moulinet',
                'id' => $moulinet->getIdMoulinet(),
                'nom' => $moulinet->getNomMoulinet(),
                'image' => $imgMoulinet->getNomImageMoulinet(),
                'marque' => $moulinet->getMarqueMoulinet()
            ];
        }
        else
        {
            $promoArticles[] = [''];
        }
    }

    foreach ($articles['hamecons'] as $hamecon) 
    {
        if($hamecon)
        {
            $imgHameconRepo = new ImageHameconRepository;
            $imgHamecon = $imgHameconRepo->getImageByHamecon($hamecon->getIdHamecon());
        
            $promoArticles[] = 
            [
                'type' => 'hamecon',
                'id' => $hamecon->getIdHamecon(),
                'nom' => $hamecon->getNomHamecon(),
                'image' => $imgHamecon->getNomImageHamecon(),
                'marque' => $hamecon->getMarqueHamecon()
            ];
        }
        else
        {
            $promoArticles[] = [''];
        }
    }

    foreach ($articles['leurres'] as $leurre) 
    {
        if($leurre)
        {
            $imgLeurreRepo = new ImageLeurreRepository;
            $imgLeurre = $imgLeurreRepo->getImageByLeurre($leurre->getIdLeurre());
        
            $promoArticles[] = 
            [
                'type' => 'leurre',
                'id' => $leurre->getIdLeurre(),
                'nom' => $leurre->getNomLeurre(),
                'image' => $imgLeurre->getNomImageLeurre(),
                'marque' => $leurre->getMarqueLeurre()
            ];
        }
        else
        {
            $promoArticles[] = [''];
        }
    }

    foreach ($articles['lignes'] as $ligne) 
    {
        if($ligne)
        {
            $imgLigneRepo = new ImageLigneRepository;
            $imgLigne = $imgLigneRepo->getImageByLigne($ligne->getIdLigne());
        
            $promoArticles[] = 
            [
                'type' => 'ligne',
                'id' => $ligne->getIdLigne(),
                'nom' => $ligne->getNomLigne(),
                'image' => $imgLigne->getNomImageLigne(),
                'marque' => $ligne->getMarqueLigne()
            ];
        }
        else
        {
            $promoArticles[] = [''];
        }
    }

    foreach ($articles['equipements'] as $equipement) 
    {
        if($equipement)
        {
            $imgEquipementRepo = new ImageEquipementRepository;
            $imgEquipement = $imgEquipementRepo->getImageByEquipement($equipement->getIdEquipement());
        
            $promoArticles[] = 
            [
                'type' => 'equipement',
                'id' => $equipement->getIdEquipement(),
                'nom' => $equipement->getNomEquipement(),
                'image' => $imgEquipement->getNomImageEquipement(),
                'marque' => $equipement->getMarqueEquipement()
            ];
        }
        else
        {
            $promoArticles[] = [''];
        }
    }

    foreach ($articles['feeders'] as $feeder) 
    {
        if($feeder)
        {
            $imgFeederRepo = new ImageFeederRepository;
            $imgFeeder = $imgFeederRepo->getImageByFeeder($feeder->getIdFeeder());
        
            $promoArticles[] = 
            [
                'type' => 'plomb',
                'id' => $feeder->getIdFeeder(),
                'nom' => $feeder->getNomFeeder(),
                'image' => $imgFeeder->getNomImageFeeder(),
                'marque' => $feeder->getMarqueFeeder()
            ];
        }
        else
        {
            $promoArticles[] = [''];
        }
    }

    foreach ($articles['appats'] as $appat) 
    {
        if($appat)
        {
            $imgAppatRepo = new ImageAppatRepository;
            $imgAppat = $imgAppatRepo->getImageByAppat($appat->getIdAppat());
        
            $promoArticles[] = 
            [
                'type' => 'appat',
                'id' => $appat->getIdAppat(),
                'nom' => $appat->getNomAppat(),
                'image' => $imgAppat->getNomImageAppat(),
                'marque' => $appat->getMarqueAppat()
            ];
        }
        else
        {
            $promoArticles[] = [''];
        }
    }

    $articles = array_reverse($promoArticles);
    return $articles;
}

function viewAllMarque()
{
    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    return $marques;
}

function viewAllType()
{
    $typeMoulinetRepo = new TypemoulinetRepository;
    $typeMoulinets = $typeMoulinetRepo->getAllTypemoulinet();

    $typeCanneRepo = new TypeCanneRepository;
    $typeCannes = $typeCanneRepo->getAllTypeCanne();
}

function viewAllCategorie()
{
    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    return $categories;
}

function articlePage()
{
    $articles = getAllArticles();

    $marques = viewAllMarque();

    $categories = viewAllCategorie();
    
    include ('src/view/articlePage.php');
}

function filtre()
{
    $articles = getAllArticles();
    // Récupérer les valeurs des filtres
    $filtres = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];
    // Filtrer les articles en fonction des filtres sélectionnés
    $articlesFiltres = [];
    foreach ($articles as $article) {
        // Vérifier si la marque de l'article ou le genre de l'article font partie des filtres sélectionnés
        if (in_array($article['marque'], $filtres) || in_array($article['genre'], $filtres)) {
            // Vérifier si les deux filtres sont cochés
            if (count($filtres) >= 2) {
                // Vérifier si l'article satisfait les deux filtres sans être de même type (marque ou genre)
                if (in_array($article['marque'], $filtres) && in_array($article['genre'], $filtres) && $article['marque'] !== $article['genre']) {
                    // Ajouter l'article à la liste des articles filtrés
                    $articlesFiltres[] = $article;
                }
            } else {
                // Ajouter l'article à la liste des articles filtrés
                $articlesFiltres[] = $article;
            }
        }
    }

    foreach ($articlesFiltres as $articleFiltred) {
        // Ajouter ici le code HTML pour afficher les détails de l'article
        echo '<a href="index.php?action='. $articleFiltred['genre'] . 'Page&id=' . $articleFiltred['id'] .'">';
        echo '<div class="' . $articleFiltred['type'] . ' article" >';
        echo '<div>';
        echo '<img src="' . $articleFiltred['image'] . '" alt="' . $articleFiltred['nom'] . '" class="object-cover object-center w-32 h-32 md:w-56 md:h-56" style="border: 1px solid #000000;">';
        echo '</div>';
        echo '<div>';
        echo '<p class="text-xs md:text-lg text-center">' . $articleFiltred['nom'] . '</p>';
        echo '<p class="text-2xs md:text-sm text-center uppercase">' . $articleFiltred['marque'] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</a>';
    }
}

function loginPage()
{
    if(!isset($_SESSION['id_role']))
    {
        include ('src/view/connexionPage.php');
    }
    else
    {
        header('location: index.php');
    }
}

function signUpPage()
{
    if(!isset($_SESSION['id_role']))
    {
        include ('src/view/inscriptionPage.php');
    }
    else
    {
        header('location: index.php');
    }
}

function signUpTraitement()
{
    if(isset($_POST))
    {
        if(!empty($_POST['email']))
        {
            $emailUser = htmlspecialchars($_POST['email']);
            $userRepository = new UserRepository();
            $user = $userRepository->findByEmail($emailUser);

            if ($user == [])
            {
                if(!empty($_POST['email']) && !empty($_POST['lastname']) && !empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['verif_password']))
                {
                    if($userRepository->verifyPassword($_POST['password']))
                    {
                        if($_POST['password'] === $_POST['verif_password'])
                        {
                            $_POST['email'] = htmlspecialchars($_POST['email']);
                            $_POST['lastname'] = htmlspecialchars($_POST['lastname']);
                            $_POST['name'] = htmlspecialchars($_POST['name']);
                            $_POST['password'] = htmlspecialchars($_POST['password']);
                            $_POST['verif_password'] = htmlspecialchars($_POST['verif_password']);
                            
                            $user = new User();
                        
                            $tmp = $user->createToSignin($_POST);
                            
                            if ($tmp == true)
                            {
                                $hash = password_hash($user->getPasswordUser(), PASSWORD_BCRYPT);
                                $user->setPasswordUser($hash);
                                
                                $userRepository->insertUser($user);
                                // $token =  $userRepository['token'];
                                // $email_user = $user->email;
                                header('Location: index.php?action=login');
                            }
                            else
                            {
                                $_SESSION['messageError'] = "Erreur lors de l'inscription.";
                                header("Location: index.php?action=signUp");
                            }
                        }
                        else
                        {
                            $_SESSION['messageError'] = "Les mots de passe ne sont pas identiques.";
                            header("Location: index.php?action=signUp");
                        }
                    }
                    else
                    {
                        $_SESSION['messageError'] = "Votre mot de passe doit contenir au minimum 8 caractères avec au moins une lettre minuscule et une lettre majuscule et un chiffre.";
                        header("Location: index.php?action=signUp");
                    }
                }
                else
                {
                    $_SESSION['messageError'] = "Un des champs est vide.";
                    header("Location: index.php?action=signUp");            
                }
            }
            else
            {
                $_SESSION['messageError'] = "Cette email est déjà utilisé.";
                header("Location: index.php?action=signUp");        
            }
        }
        else
        {
            $_SESSION['messageError'] = "Un des champs est vide.";
            header("Location: index.php?action=signUp");
        }
    }
    else
    {
        header("Location: index.php?action=404");    
    }
}

function loginTraitement()
{
    if(isset($_POST))
    {
        if(isset($_POST['password']) && isset($_POST['email']))
        {
            if (!empty($_POST['password']) && !empty($_POST['email']))
            {
                $password = htmlspecialchars($_POST['password']);
                $email = htmlspecialchars($_POST['email']);
                $user = new User();
                $userRepo = new UserRepository();
                $user = $userRepo->getUserByEmail($email);

                if ($user)
                {
                    if (password_verify($password, $user->getPasswordUser()))
                    {
                        $_SESSION['id_role'] = $user->getIdRole();
                        $_SESSION['id_user'] = $user->getIdUser();
                        header('location: index.php');
                    }
                    else 
                    {
                        $_SESSION['messageError'] = "Informations incorrects.";
                        header("Location:index.php?action=login");
                    }
                }
                else
                {
                    $_SESSION['messageError'] = "Informations incorrects.";
                    header("Location:index.php?action=login");
                }
            }
            else 
            {
                $_SESSION['messageError'] = "Un des champs est vide.";
                header("Location:index.php?action=login");
            }
        }
        else
        {
            $_SESSION['messageError'] = "Un des champs est vide.";
            header('location:index.php?action=signUp');
        }
    }
    else
    {
        header('location:index.php?action=404');
    }
}

function disconnectUser()
{
    session_destroy();
    header('location:index.php');
}

function cannePage()
{
    $canneRepo = new CanneRepository;
    $imageCanneRepo = new ImageCanneRepository;

    $imageCanne = $imageCanneRepo->getImageByCanne($_GET['id']);
    $canne = $canneRepo->getCanneById($_GET['id']);

    require_once('src/view/articlePage/cannePage.php');
}

function moulinetPage()
{
    $moulinetRepo = new MoulinetRepository;
    $imageMoulinetRepo = new ImageMoulinetRepository;
    
    $imageMoulinet = $imageMoulinetRepo->getImageByMoulinet($_GET['id']);
    $moulinet = $moulinetRepo->getMoulinetById($_GET['id']);

    require_once('src/view/articlePage/moulinetPage.php');
}

function hameconPage()
{
    $hameconRepo = new HameconRepository;
    $imageHameconRepo = new ImageHameconRepository;
    
    $imageHamecon = $imageHameconRepo->getImageByHamecon($_GET['id']);
    $hamecon = $hameconRepo->getHameconById($_GET['id']);

    require_once('src/view/articlePage/hameconPage.php');
}

function leurrePage()
{
    $leurreRepo = new LeurreRepository;
    $imageLeurreRepo = new ImageLeurreRepository;
    
    $imageLeurre = $imageLeurreRepo->getImageByLeurre($_GET['id']);
    $leurre = $leurreRepo->getLeurreById($_GET['id']);

    require_once('src/view/articlePage/leurrePage.php');
}

function plombPage()
{
    $feederRepo = new FeederRepository;
    $imageFeederRepo = new ImageFeederRepository;
    
    $imageFeeder = $imageFeederRepo->getImageByFeeder($_GET['id']);
    $feeder = $feederRepo->getFeederById($_GET['id']);

    require_once('src/view/articlePage/feederPage.php');
}

function appatPage()
{
    $appatRepo = new AppatRepository;
    $imageAppatRepo = new ImageAppatRepository;
    
    $imageAppat = $imageAppatRepo->getImageByAppat($_GET['id']);
    $appat = $appatRepo->getAppatById($_GET['id']);

    require_once('src/view/articlePage/appatPage.php');
}

function equipementPage()
{
    $equipementRepo = new EquipementRepository;
    $imageEquipementRepo = new ImageEquipementRepository;
    
    $imageEquipement = $imageEquipementRepo->getImageByEquipement($_GET['id']);
    $equipement = $equipementRepo->getEquipementById($_GET['id']);

    require_once('src/view/articlePage/equipementPage.php');
}

function lignePage()
{
    $ligneRepo = new LigneRepository;
    $imageLigneRepo = new ImageLigneRepository;
    
    $imageLigne = $imageLigneRepo->getImageByLigne($_GET['id']);
    $ligne = $ligneRepo->getLigneById($_GET['id']);

    require_once('src/view/articlePage/lignePage.php');
}
