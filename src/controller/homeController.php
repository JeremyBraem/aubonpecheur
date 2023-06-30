<?php

require_once('autoload/autoloader.php');
require_once('src/model/User.php');

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

// PAGE D'ACCUEIL
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

    $marques = getAllMarque();

    $categories = getAllCategorie();

    $combinedArticles = getLastArticles();

    $promoArticles = getPromoArticles();

    include('src/view/homePage.php');
}

//PAGE DE CONNEXION
function loginPage()
{
    if (!isset($_SESSION['id_role'])) 
    {
        include('src/view/connexionPage.php');
    } 
    else 
    {
        header('location: index.php');
    }
}

// PAGE D'INSCRIPTION
function signUpPage()
{
    if (!isset($_SESSION['id_role'])) 
    {
        include('src/view/inscriptionPage.php');
    } 
    else 
    {
        header('location: index.php');
    }
}

//TRAITEMENT DE CONNEXION
function loginTraitement()
{
    if (isset($_POST)) 
    {
        if (isset($_POST['password']) && isset($_POST['email'])) 
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

//TRAITEMENT D'INSCRIPTION
function signUpTraitement()
{
    if (isset($_POST))
    {
        if (!empty($_POST['email'])) 
        {
            $emailUser = htmlspecialchars($_POST['email']);

            $userRepository = new UserRepository();

            $user = $userRepository->findByEmail($emailUser);

            if ($user == []) 
            {
                if (!empty($_POST['email']) && !empty($_POST['lastname']) && !empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['verif_password'])) 
                {
                    if ($userRepository->verifyPassword($_POST['password']))
                    {
                        if ($_POST['password'] === $_POST['verif_password']) {
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

//TRAITEMENT DE DECONNEXION
function disconnectUser()
{
    session_destroy();
    header('location:index.php');
}

//AFFICHAGE DE LA PAGE DE TOUS LES ARTICLES
function articlePage()
{
    $articles = getLastArticles();

    $marques = getAllMarque();

    $categories = getAllCategorie();

    include('src/view/articlePage.php');
}

//AFFICHAGE DE LA PAGE DE TOUS LES ARTICLES EN PROMOTION
function promoPage()
{
    $articlesPromo = getPromoArticles();

    $marques = getAllMarque();

    $categories = getAllCategorie();

    include('src/view/promoPage.php');
}

//AFFICHAGE DE LA PAGE D'ARTICLE EN FONCTION DE LA CATEGORIE EN GET
function viewPageCategorie()
{
    $categorieRepo = new CategorieRepository;

    if($categorieRepo->existCategorie($_GET['categorie']))
    {
        $categorie = $categorieRepo->existCategorie($_GET['categorie']);
    }
    else
    {
        header('location:index.php');
    }

    $allCanneRepo = new CanneRepository;
    $allMoulinetRepo = new MoulinetRepository;
    $allHameconRepo = new HameconRepository;
    $allLeurreRepo = new LeurreRepository;
    $allLigneRepo = new LigneRepository;
    $allEquipementRepo = new EquipementRepository;
    $allFeederRepo = new FeederRepository;
    $allAppatRepo = new AppatRepository;

    $marques = getAllMarque();

    foreach($categorie as $idCategories)
    {
        $idCategorie = $idCategories->getIdCategorie();
    }

    $articles = [];

    $articles['cannes'] = $allCanneRepo->getCanneByCategorie($idCategorie);
    $articles['moulinets'] = $allMoulinetRepo->getMoulinetByCategorie($idCategorie);
    $articles['hamecons'] = $allHameconRepo->getHameconByCategorie($idCategorie);
    $articles['leurres'] = $allLeurreRepo->getLeurreByCategorie($idCategorie);
    $articles['equipements'] = $allEquipementRepo->getEquipementByCategorie($idCategorie);
    $articles['lignes'] = $allLigneRepo->getLigneByCategorie($idCategorie);
    $articles['appats'] = $allAppatRepo->getAppatByCategorie($idCategorie);
    $articles['feeders'] = $allFeederRepo->getFeederByCategorie($idCategorie);

    $combinedArticles = combinedArticle($articles);

    include('src/view/articlePageByCat.php');
}

//PAGE D'AFFICHAGE DE TOUTES LES CANNES
function allCannePage()
{
    $canneRepo = new CanneRepository;
    $cannes = $canneRepo->getAllCanne();

    foreach ($cannes as $canne) 
    {
        if ($canne) 
        {
            $imgCanneRepo = new ImageCanneRepository;
            $imgCannes = $imgCanneRepo->getImageByCanne($canne->getIdCanne());
            $allCannes[] =
            [
                'genre' => 'canne',
                'id' => $canne->getIdCanne(),
                'nom' => $canne->getNomCanne(),
                'image' => $imgCannes->getNomImageCanne(),
                'marque' => $canne->getMarqueCanne(),
                'type' => $canne->getTypeCanne(),
                'categorie' => $canne->getCategorieCanne(),
            ];
        } 
        else 
        {
            $allCannes[] = [''];
        }
    }

    $categories = getAllCategorie();

    $typeCanneRepo = new TypeCanneRepository;
    $typeCannes = $typeCanneRepo->getAllTypeCanne();

    $marques = getAllMarque();

    foreach ($cannes as $canne) 
    {
        $longueursCanne[] = $canne->getLongueurCanne();
    }

    foreach ($cannes as $canne) 
    {
        $poidsCanne[] = $canne->getPoidsCanne();
    }

    include('src/view/allArticlePage/articlePageCanne.php');
}

//PAGE D'AFFICHAGE DES INFOS D'UNE CANNE EN FONCTION DE L'ID EN GET
function cannePage()
{
    $canneRepo = new CanneRepository;
    $imageCanneRepo = new ImageCanneRepository;

    $imageCanne = $imageCanneRepo->getImageByCanne($_GET['id']);
    $canne = $canneRepo->getCanneById($_GET['id']);

    require_once('src/view/articlePage/cannePage.php');
}

//PAGE D'AFFICHAGE DES INFOS D'UN MOULINET EN FONCTION DE L'ID EN GET
function moulinetPage()
{
    $moulinetRepo = new MoulinetRepository;
    $imageMoulinetRepo = new ImageMoulinetRepository;

    $imageMoulinet = $imageMoulinetRepo->getImageByMoulinet($_GET['id']);
    $moulinet = $moulinetRepo->getMoulinetById($_GET['id']);

    require_once('src/view/articlePage/moulinetPage.php');
}

//PAGE D'AFFICHAGE DES INFOS D'UN HAMECON EN FONCTION DE L'ID EN GET
function hameconPage()
{
    $hameconRepo = new HameconRepository;
    $imageHameconRepo = new ImageHameconRepository;

    $imageHamecon = $imageHameconRepo->getImageByHamecon($_GET['id']);
    $hamecon = $hameconRepo->getHameconById($_GET['id']);

    require_once('src/view/articlePage/hameconPage.php');
}

//PAGE D'AFFICHAGE DES INFOS D'UN LEURRE EN FONCTION DE L'ID EN GET
function leurrePage()
{
    $leurreRepo = new LeurreRepository;
    $imageLeurreRepo = new ImageLeurreRepository;

    $imageLeurre = $imageLeurreRepo->getImageByLeurre($_GET['id']);
    $leurre = $leurreRepo->getLeurreById($_GET['id']);

    require_once('src/view/articlePage/leurrePage.php');
}

//PAGE D'AFFICHAGE DES INFOS D'UN PLOMB EN FONCTION DE L'ID EN GET
function plombPage()
{
    $feederRepo = new FeederRepository;
    $imageFeederRepo = new ImageFeederRepository;

    $imageFeeder = $imageFeederRepo->getImageByFeeder($_GET['id']);
    $feeder = $feederRepo->getFeederById($_GET['id']);

    require_once('src/view/articlePage/feederPage.php');
}

//PAGE D'AFFICHAGE DES INFOS D'UN APPAT EN FONCTION DE L'ID EN GET
function appatPage()
{
    $appatRepo = new AppatRepository;
    $imageAppatRepo = new ImageAppatRepository;

    $imageAppat = $imageAppatRepo->getImageByAppat($_GET['id']);
    $appat = $appatRepo->getAppatById($_GET['id']);

    require_once('src/view/articlePage/appatPage.php');
}

//PAGE D'AFFICHAGE DES INFOS D'UN EQUIPEMENT EN FONCTION DE L'ID EN GET
function equipementPage()
{
    $equipementRepo = new EquipementRepository;
    $imageEquipementRepo = new ImageEquipementRepository;

    $imageEquipement = $imageEquipementRepo->getImageByEquipement($_GET['id']);
    $equipement = $equipementRepo->getEquipementById($_GET['id']);

    require_once('src/view/articlePage/equipementPage.php');
}

//PAGE D'AFFICHAGE DES INFOS D'UNE LIGNE EN FONCTION DE L'ID EN GET
function lignePage()
{
    $ligneRepo = new LigneRepository;
    $imageLigneRepo = new ImageLigneRepository;

    $imageLigne = $imageLigneRepo->getImageByLigne($_GET['id']);
    $ligne = $ligneRepo->getLigneById($_GET['id']);

    require_once('src/view/articlePage/lignePage.php');
}

//TRAITEMENT DE RECUPERATION DES DERNIERS ARTICLES
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

    $combinedArticles = combinedArticle($articles);

    $articles = array_reverse($combinedArticles);

    return $articles;
}

//TRAITEMENT DE RECUPERATION DE TOUS LES ARTICLES
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

    $articles['cannes'] = $allCanneRepo->getAllCanne();
    $articles['moulinets'] = $allMoulinetRepo->getAllMoulinet();
    $articles['hamecons'] = $allHameconRepo->getAllHamecon();
    $articles['leurres'] = $allLeurreRepo->getAllLeurre();
    $articles['lignes'] = $allLigneRepo->getAllLigne();
    $articles['equipements'] = $allEquipementRepo->getAllEquipement();
    $articles['feeders'] = $allFeederRepo->getAllFeeder();
    $articles['appats'] = $allAppatRepo->getAllAppat();

    $combinedArticles = [];

    $combinedArticles = combinedArticle($articles);

    $articles = array_reverse($combinedArticles);

    return $articles;
}

//TRAITEMENT DE RECUPERATION DE TOUS LES ARTICLES EN PROMOTION
function getPromoArticles()
{
    $promoCanneRepo = new CanneRepository;
    $promoMoulinetRepo = new MoulinetRepository;
    $promoHameconRepo = new HameconRepository;
    $promoLeurreRepo = new LeurreRepository;
    $promoLigneRepo = new LigneRepository;
    $promoEquipementRepo = new EquipementRepository;
    $promoFeederRepo = new FeederRepository;
    $promoAppatRepo = new AppatRepository;

    $articles = [];

    $articles['cannes'] = $promoCanneRepo->getPromoCanne();
    $articles['moulinets'] = $promoMoulinetRepo->getPromoMoulinet();
    $articles['hamecons'] = $promoHameconRepo->getPromoHamecon();
    $articles['leurres'] = $promoLeurreRepo->getPromoLeurre();
    $articles['lignes'] = $promoLigneRepo->getPromoLigne();
    $articles['equipements'] = $promoEquipementRepo->getPromoEquipement();
    $articles['feeders'] = $promoFeederRepo->getPromoFeeder();
    $articles['appats'] = $promoAppatRepo->getPromoAppat();

    $promoArticles = combinedArticle($articles);

    $articles = array_reverse($promoArticles);

    return $articles;
}

//RECUPERATION DE TOUTE LES MARQUES
function getAllMarque()
{
    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    return $marques;
}

//RECUPERATION D'ID DE CATEGORIE EN FONCTION DES NOM DE CATEGORIE EN GET
function getIdCategorie()
{
    $categorieRepo = new CategorieRepository;

    $categorie = $categorieRepo->existCategorie($_GET['categorie']);

    foreach ($categorie as $idCategories) 
    {
        $idCategorie = $idCategories->getIdCategorie();
    }

    return $idCategorie;
}

//RECUPERATION DE TOUS LES TYPE D'ARTICLE
function getAllType()
{
    $allTypes = [];

    $typeMoulinetRepo = new TypemoulinetRepository;
    $allTypes[] = $typeMoulinetRepo->getAllTypemoulinet();

    $typeCanneRepo = new TypeCanneRepository;
    $allTypes[] = $typeCanneRepo->getAllTypeCanne();

    $typeHameconRepo = new TypeHameconRepository;
    $allTypes[] = $typeHameconRepo->getAllTypeHamecon();

    $typeLeurreRepo = new TypeLeurreRepository;
    $allTypes[] = $typeLeurreRepo->getAllTypeLeurre();

    $typeLigneRepo = new TypeLigneRepository;
    $allTypes[] = $typeLigneRepo->getAllTypeLigne();

    $typeFeederRepo = new TypeFeederRepository;
    $allTypes[] = $typeFeederRepo->getAllTypeFeeder();

    $typeEquipementRepo = new TypeEquipementRepository;
    $allTypes[] = $typeEquipementRepo->getAllTypeEquipement();

    $typeAppatRepo = new TypeAppatRepository;
    $allTypes[] = $typeAppatRepo->getAllTypeAppat();

    return $allTypes;
}

//RECUPETATION DE TOUTES LES CATEGORIES
function getAllCategorie()
{
    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    return $categories;
}

//CREE UN TABLEAU AVEC TOUS LES ARTICLES EN LEUR DONNANT AVEC DES ATRIBUTS
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
            ];
        }
        else 
        {
            $combinedArticles[] = [''];
        }
    }
    return $combinedArticles;
}

//TRAITEMENT POUR LES FILTRE DE LA PAGE DE TOUS LES ARTICLES
function filtre()
{
    $articles = getLastArticles();

    $filtres = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

    $articlesFiltres = [];

    $genresFiltres = [];
    $marquesFiltres = [];
    $categoriesFiltres = [];

    foreach ($filtres as $filtre) 
    {
        if (isGenre($filtre)) 
        {
            $genresFiltres[] = $filtre;
        } 
        elseif (isMarque($filtre)) 
        {
            $marquesFiltres[] = $filtre;
        } 
        elseif (isCategorie($filtre)) 
        {
            $categoriesFiltres[] = $filtre;
        }
    }

    $isGenresSelected = !empty($genresFiltres);

    $isMarquesSelected = !empty($marquesFiltres);

    $isCategoriesSelected = !empty($categoriesFiltres);


    foreach ($articles as $article) 
    {
        $isGenreMatch = in_array($article['genre'], $genresFiltres) || !$isGenresSelected;

        $isMarqueMatch = in_array($article['marque'], $marquesFiltres) || !$isMarquesSelected;

        $isCategorieMatch = in_array($article['categorie'], $categoriesFiltres) || !$isCategoriesSelected;

        if ($isGenreMatch && $isMarqueMatch && $isCategorieMatch) 
        {
            $articlesFiltres[] = $article;
        }
    }

    foreach ($articlesFiltres as $articleFiltred) 
    {
        echo '<a href="index.php?action=' . $articleFiltred['genre'] . 'Page&id=' . $articleFiltred['id'] . '">';
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

//TRAITEMENT POUR LES FILTRE DE LA PAGE DE TOUS LES ARTICLES EN PROMOTION
function filtrePromo()
{
    $articles = getPromoArticles();

    $filtres = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

    $articlesFiltres = [];

    $genresFiltres = [];
    $marquesFiltres = [];
    $categoriesFiltres = [];

    foreach ($filtres as $filtre) 
    {
        if (isGenre($filtre)) 
        {
            $genresFiltres[] = $filtre;
        } 
        elseif (isMarque($filtre)) 
        {
            $marquesFiltres[] = $filtre;
        } 
        elseif (isCategorie($filtre)) 
        {
            $categoriesFiltres[] = $filtre;
        }
    }

    $isGenresSelected = !empty($genresFiltres);

    $isMarquesSelected = !empty($marquesFiltres);

    $isCategoriesSelected = !empty($categoriesFiltres);


    foreach ($articles as $article) 
    {
        $isGenreMatch = in_array($article['genre'], $genresFiltres) || !$isGenresSelected;

        $isMarqueMatch = in_array($article['marque'], $marquesFiltres) || !$isMarquesSelected;

        $isCategorieMatch = in_array($article['categorie'], $categoriesFiltres) || !$isCategoriesSelected;

        if ($isGenreMatch && $isMarqueMatch && $isCategorieMatch) 
        {
            $articlesFiltres[] = $article;
        }
    }

    foreach ($articlesFiltres as $articleFiltred) 
    {
        echo '<a href="index.php?action=' . $articleFiltred['genre'] . 'Page&id=' . $articleFiltred['id'] . '">';
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

//TRAITEMENT POUR LES FILTRES DES PAGES D'ARTICLES EN FONCTION DE LA CATEGORIE PRIT EN GET
function filtrePageCate()
{
    $allCanneRepo = new CanneRepository;
    $allMoulinetRepo = new MoulinetRepository;
    $allHameconRepo = new HameconRepository;
    $allLeurreRepo = new LeurreRepository;
    $allLigneRepo = new LigneRepository;
    $allEquipementRepo = new EquipementRepository;
    $allFeederRepo = new FeederRepository;
    $allAppatRepo = new AppatRepository;

    $idCategorie = getIdCategorie();

    $articles = [];

    $articles['cannes'] = $allCanneRepo->getCanneByCategorie($idCategorie);
    $articles['moulinets'] = $allMoulinetRepo->getMoulinetByCategorie($idCategorie);
    $articles['hamecons'] = $allHameconRepo->getHameconByCategorie($idCategorie);
    $articles['leurres'] = $allLeurreRepo->getLeurreByCategorie($idCategorie);
    $articles['equipements'] = $allEquipementRepo->getEquipementByCategorie($idCategorie);
    $articles['lignes'] = $allLigneRepo->getLigneByCategorie($idCategorie);
    $articles['appats'] = $allAppatRepo->getAppatByCategorie($idCategorie);
    $articles['feeders'] = $allFeederRepo->getFeederByCategorie($idCategorie);

    $combinedArticles = combinedArticle($articles);

    $filtres = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

    $articlesFiltres = [];

    $genresFiltres = [];
    $marquesFiltres = [];
    $categoriesFiltres = [];

    foreach ($filtres as $filtre) 
    {
        if (isGenre($filtre)) 
        {
            $genresFiltres[] = $filtre;
        } 
        elseif (isMarque($filtre)) 
        {
            $marquesFiltres[] = $filtre;
        } 
        elseif (isCategorie($filtre)) 
        {
            $categoriesFiltres[] = $filtre;
        }
    }

    $isGenresSelected = !empty($genresFiltres);

    $isMarquesSelected = !empty($marquesFiltres);

    $isCategoriesSelected = !empty($categoriesFiltres);

    foreach ($combinedArticles as $article) 
    {
        if (($article != ['']))
        {
            $isGenreMatch = in_array($article['genre'], $genresFiltres) || !$isGenresSelected;

            $isMarqueMatch = in_array($article['marque'], $marquesFiltres) || !$isMarquesSelected;

            $isCategorieMatch = in_array($article['categorie'], $categoriesFiltres) || !$isCategoriesSelected;

            if ($isGenreMatch && $isMarqueMatch && $isCategorieMatch) 
            {
                $articlesFiltres[] = $article;
            }
        } 
        else 
        {
            echo '';
        }
    }

    foreach ($articlesFiltres as $articleFiltred) 
    {
        echo '<a href="index.php?action=' . $articleFiltred['genre'] . 'Page&id=' . $articleFiltred['id'] . '">';
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

//TRAITEMENT POUR LES FILTRES DES PAGES DE CANNE
function filtreCanne()
{
    $canneRepo = new CanneRepository;
    $articlesCanne = $canneRepo->getAllCanne();

    foreach ($articlesCanne as $canne) 
    {
        if ($canne) 
        {
            $imgCanneRepo = new ImageCanneRepository;
            $imgCannes = $imgCanneRepo->getImageByCanne($canne->getIdCanne());
            $allCannes[] = 
            [
                'genre' => 'canne',
                'id' => $canne->getIdCanne(),
                'nom' => $canne->getNomCanne(),
                'image' => $imgCannes->getNomImageCanne(),
                'marque' => $canne->getMarqueCanne(),
                'type' => $canne->getTypeCanne(),
                'categorie' => $canne->getCategorieCanne(),
                'longueur' => $canne->getLongueurCanne(),
                'poids' => $canne->getPoidsCanne(),
            ];
        } 
        else 
        {
            $allCannes[] = [''];
        }
    }

    $filtresCanne = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

    $articlesFiltresCanne = [];

    $typesFiltresCanne = [];
    $marquesFiltresCanne = [];
    $categoriesFiltresCanne = [];
    $longueursFiltresCanne = [];
    $longueurFiltre = null;
    $poidsFiltresCanne = [];
    $poidFiltre = null;

    foreach ($filtresCanne as $filtreCanne) 
    {
        if (isCategorie($filtreCanne))
        {
            $categoriesFiltresCanne[] = $filtreCanne;
        } 
        elseif (isMarque($filtreCanne)) 
        {
            $marquesFiltresCanne[] = $filtreCanne;
        } 
        elseif (isTypeCanne($filtreCanne)) 
        {
            $typesFiltresCanne[] = $filtreCanne;
        }
        elseif (isLongueurCanne($filtreCanne)) 
        {
            $longueursFiltresCanne[] = $filtreCanne;
        }
        elseif (isPoidsCanne($filtreCanne)) 
        {
            $poidsFiltresCanne[] = $filtreCanne;
        }
    }

    $isTypesFiltresCanne = !empty($typesFiltresCanne);

    $isMarquesSelected = !empty($marquesFiltresCanne);

    $isCategoriesSelected = !empty($categoriesFiltresCanne);

    foreach ($allCannes as $article) 
    {
        $isTypeMatch = in_array($article['type'], $typesFiltresCanne) || !$isTypesFiltresCanne;

        $isMarqueMatch = in_array($article['marque'], $marquesFiltresCanne) || !$isMarquesSelected;

        $isCategorieMatch = in_array($article['categorie'], $categoriesFiltresCanne) || !$isCategoriesSelected;

        $isLongueurMatch = true;

        $isPoidMatch = true;

        if ($longueursFiltresCanne) 
        {
            $isLongueurMatch = false;
            foreach ($longueursFiltresCanne as $longueurFiltre) 
            {
                $longueurArticle = $article['longueur'];
                $longueurRange = explode('-', $longueurFiltre);
                $longueurMin = intval($longueurRange[0]);
                $longueurMax = intval($longueurRange[1]);
                if ($longueurArticle >= $longueurMin && $longueurArticle <= $longueurMax) 
                {
                    $isLongueurMatch = true;
                    break;
                }
            }
        }

        if ($poidsFiltresCanne) 
        {
            $isPoidMatch = false;
            foreach ($poidsFiltresCanne as $poidFiltre) 
            {
                $poidArticle = $article['poids'];
                $poidRange = explode('-', $poidFiltre);
                $poidMin = intval($poidRange[0]);
                $poidMax = intval($poidRange[1]);
                if ($poidArticle >= $poidMin && $poidArticle <= $poidMax) 
                {
                    $isPoidMatch = true;
                    break;
                }
            }
        }


        if ($isTypeMatch && $isMarqueMatch && $isCategorieMatch && $isLongueurMatch && $isPoidMatch) 
        {
            $articlesFiltresCanne[] = $article;
        }
    }

    foreach ($articlesFiltresCanne as $articleFiltred) 
    {
        echo '<a href="index.php?action=' . $articleFiltred['genre'] . 'Page&id=' . $articleFiltred['id'] . '">';
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

//CREER UN TABLEAU DE GENRE POUR LES FILTRES
function isGenre($filtre)
{
    $genres = ['canne', 'moulinet', 'leurre', 'hamecon', 'ligne', 'appat', 'equipement', 'plomb'];

    return in_array($filtre, $genres);
}

//CREER UN TABLEAU DE CATEGORIE POUR LES FILTRES
function isCategorie($filtre)
{
    $allCategories = getAllCategorie();

    $nomCategorie = [];

    foreach ($allCategories as $categorie) 
    {
        $nomCategorie[] = $categorie->getNomCategorie();
    }

    $categories = $nomCategorie;

    return in_array($filtre, $categories);
}

//CREER UN TABLEAU DE MARQUE POUR LES FILTRES
function isMarque($filtre)
{
    $allMarques = getAllMarque();

    $nomMarque = [];

    foreach ($allMarques as $marque) 
    {
        $nomMarque[] = $marque->getNomMarque();
    }

    $marques = $nomMarque;

    return in_array($filtre, $marques);
}

//CREE UN TABLEAU AVEC LES TYPES DE CANNE POUR LES FILTRES
function isTypeCanne($filtre)
{
    $typeCanneRepo = new TypeCanneRepository;
    $allTypeCannes = $typeCanneRepo->getAllTypeCanne();

    $nomType = [];

    foreach ($allTypeCannes as $type) 
    {
        $nomType[] = $type->getNomTypeCanne();
    }

    $types = $nomType;

    return in_array($filtre, $types);
}

//CREE UN TABLEAU AVEC LES LONGUEURS POUR LES FILTRES
function isLongueurCanne($filtre)
{
    $pattern = '/^\d+m-\d+m$/';
    return preg_match($pattern, $filtre);
}

//CREE UN TABLEAU AVEC LES POIDS POUR LES FILTRES
function isPoidsCanne($filtre)
{
    $pattern = '/^\d+kg-\d+kg$/';
    return preg_match($pattern, $filtre);
}