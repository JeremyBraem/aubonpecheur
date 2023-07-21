<?php

require_once('autoload/autoloader.php');
require_once('src/model/User.php');
require_once('src/model/Favoris.php');

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
        header('location: /home');
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
        header('location: /home');
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
                        $_SESSION['prenom_user'] = $user->getNameUser();
                        $_SESSION['nom_user'] = $user->getLastnameUser();
                        $_SESSION['email_user'] = $user->getEmailUser();

                        $favorisRepo = new FavorisRepository(); 
                        $favoris = new Favoris();

                        $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

                        if(!empty($favUser))
                        {
                            foreach ($favUser as $idFavo)
                            {
                                $allIdFav[] = $idFavo->getIdFavoris();
                            }
            
                            foreach ($allIdFav as $idFavoris)
                            {
                                $idCanneFav[] = $favorisRepo->getCanneByIdFav($idFavoris);
                            }
    
                            foreach ($allIdFav as $idFavoris)
                            {
                                $idMoulinetFav[] = $favorisRepo->getMoulinetByIdFav($idFavoris);
                            }

                            foreach ($allIdFav as $idFavoris)
                            {
                                $idHameconFav[] = $favorisRepo->getHameconByIdFav($idFavoris);
                            }

                            foreach ($allIdFav as $idFavoris)
                            {
                                $idLeurreFav[] = $favorisRepo->getLeurreByIdFav($idFavoris);
                            }

                            foreach ($allIdFav as $idFavoris)
                            {
                                $idLigneFav[] = $favorisRepo->getLigneByIdFav($idFavoris);
                            }

                            foreach ($allIdFav as $idFavoris)
                            {
                                $idEquipementFav[] = $favorisRepo->getEquipementByIdFav($idFavoris);
                            }

                            foreach ($allIdFav as $idFavoris)
                            {
                                $idFeederFav[] = $favorisRepo->getFeederByIdFav($idFavoris);
                            }

                            foreach ($allIdFav as $idFavoris)
                            {
                                $idAppatFav[] = $favorisRepo->getAppatByIdFav($idFavoris);
                            }
    
                            $_SESSION['canne'] = [$idCanneFav];
                            $_SESSION['moulinet'] = [$idMoulinetFav];
                            $_SESSION['hamecon'] = [$idHameconFav];
                            $_SESSION['leurre'] = [$idLeurreFav];
                            $_SESSION['ligne'] = [$idLigneFav];
                            $_SESSION['equipement'] = [$idEquipementFav];
                            $_SESSION['plomb'] = [$idFeederFav];
                            $_SESSION['appat'] = [$idAppatFav];
                        }
                        else
                        {
                            $_SESSION['canne'] = [];
                            $_SESSION['moulinet'] = [];
                            $_SESSION['hamecon'] = [];
                            $_SESSION['leurre'] = [];
                            $_SESSION['ligne'] = [];
                            $_SESSION['equipement'] = [];
                            $_SESSION['plomb'] = [];
                            $_SESSION['appat'] = [];
                        }
                        
        
                        header('location: /home');

                    }
                    else
                    {
                        $_SESSION['messageError'] = "Informations incorrects.";
                        header("Location: /login");
                    }
                } 
                else 
                {
                    $_SESSION['messageError'] = "Informations incorrects.";
                    header("Location: /login");
                }
            } 
            else 
            {
                $_SESSION['messageError'] = "Un des champs est vide.";
                header("Location: /login");
            }
        } 
        else 
        {
            $_SESSION['messageError'] = "Un des champs est vide.";
            header('location: /signUp');
        }
    } 
    else 
    {
        header('location:/404');
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
                                header('Location: /login');
                            } 
                            else 
                            {
                                $_SESSION['messageError'] = "Erreur lors de l'inscription.";
                                header("Location: /signUp");
                            }
                        } 
                        else 
                        {
                            $_SESSION['messageError'] = "Les mots de passe ne sont pas identiques.";
                            header("Location: /signUp");
                        }
                    } 
                    else 
                    {
                        $_SESSION['messageError'] = "Votre mot de passe doit contenir au minimum 8 caractères avec au moins une lettre minuscule et une lettre majuscule et un chiffre.";
                        header("Location: /signUp");
                    }
                } 
                else 
                {
                    $_SESSION['messageError'] = "Un des champs est vide.";
                    header("Location: /signUp");
                }
            } 
            else 
            {
                $_SESSION['messageError'] = "Cette email est déjà utilisé.";
                header("Location: /signUp");
            }
        } 
        else 
        {
            $_SESSION['messageError'] = "Un des champs est vide.";
            header("Location: /signUp");
        }
    } 
    else 
    {
        header("Location: /404");
    }
}

//TRAITEMENT DE DECONNEXION
function disconnectUser()
{
    session_destroy();
    header('location: /home');
}

//TRAITEMENT POUR AJOUTER DES FAVORIS
function addFavorisTraitement()
{
    if ($_POST['genre'] === 'canne')
    {
        $id_canne = $_POST['id_canne'];

        $favorisRepo = new FavorisRepository(); 
        $favoris = new Favoris();

        if (isset($_SESSION['canne']) && !empty($_SESSION['canne']))
        {
            foreach ($_SESSION['canne'] as $key => $canne)
            {
                if (in_array($id_canne, $canne))
                {
                    $favByIdCanne = $favorisRepo->getFavorisByIdCanne($id_canne);
                    
                    $idFavByIdUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);
    
                    foreach ($favByIdCanne as $favCannes)
                    {
                        $favIdCanne = $favCannes->getIdFavoris();
                    }
                    
                    foreach ($idFavByIdUser as $favCannesUser)
                    {
                        $favIdCanneUser[] = $favCannesUser->getIdFavoris();
                    }
    
                    if (in_array($favIdCanne, $favIdCanneUser))
                    {
                        $deleteFavAndCanne = $favorisRepo->deleteFavCanneAndUser($favIdCanne, $id_canne);
                        $isFavorite = false;
                    }
                    
                    foreach ($_SESSION['canne'] as $key => $subArray)
                    {
                        foreach ($subArray as $subKey => $subValue)
                        {
                            if ($id_canne == $subValue)
                            {
                                unset($_SESSION['canne'][$key][$subKey]);
                                session_write_close();

                                $_SESSION['canne'][$key] = array_values($_SESSION['canne'][$key]);

                                if (empty($_SESSION['canne'][$key])) 
                                {
                                    unset($_SESSION['canne'][$key]);
                                    session_write_close();
                                }
                                break;
                            }
                        }
                    }
                }
                else
                {
                    $favoris->createToInsertFavoris($_POST);
                    $favorisRepo->insertFavoris($favoris);
                    $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
                    $favorisRepo->insertFavCanneAndUser($lastIdFav, $id_canne);
                    $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);
    
                    foreach ($favUser as $idFavo)
                    {
                        $allIdFav[] = $idFavo->getIdFavoris();
                    }
    
                    foreach ($allIdFav as $idFavoris)
                    {
                        $idCanneFav[] = $favorisRepo->getCanneByIdFav($idFavoris);
                    }

                    $_SESSION['canne'] = [$idCanneFav];
                    session_write_close();
                }
            }
        }
        else
        {
            $favoris->createToInsertFavoris($_POST);
            $favorisRepo->insertFavoris($favoris);
            $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
            $favorisRepo->insertFavCanneAndUser($lastIdFav, $id_canne);
            $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

            foreach ($favUser as $idFavo)
            {
                $allIdFav[] = $idFavo->getIdFavoris();
            }

            foreach ($allIdFav as $idFavoris)
            {
                $idCanneFav[] = $favorisRepo->getCanneByIdFav($idFavoris);
            }
            
            $_SESSION['canne'] = [$idCanneFav];
            session_write_close();
        }
    }

    if ($_POST['genre'] === 'moulinet')
    {
        $id_moulinet = $_POST['id_moulinet'];

        $favorisRepo = new FavorisRepository(); 
        $favoris = new Favoris();

        if (isset($_SESSION['moulinet']) && !empty($_SESSION['moulinet']))
        {
            foreach ($_SESSION['moulinet'] as $key => $moulinet)
            {
                if (in_array($id_moulinet, $moulinet))
                {
                    $favByIdMoulinet = $favorisRepo->getFavorisByIdMoulinet($id_moulinet);
                    
                    $idFavByIdUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

                    foreach ($favByIdMoulinet as $favMoulinets)
                    {
                        $favIdMoulinet = $favMoulinets->getIdFavoris();
                    }
                    
                    foreach ($idFavByIdUser as $favMoulinetsUser)
                    {
                        $favIdMoulinetUser[] = $favMoulinetsUser->getIdFavoris();
                    }
    
                    if (in_array($favIdMoulinet, $favIdMoulinetUser))
                    {
                        $deleteFavAndMoulinet = $favorisRepo->deleteFavMoulinetAndUser($favIdMoulinet, $id_moulinet);
                    }
                    
                    foreach ($_SESSION['moulinet'] as $key => $subArray)
                    {
                        foreach ($subArray as $subKey => $subValue)
                        {
                            if ($id_moulinet == $subValue)
                            {
                                unset($_SESSION['moulinet'][$key][$subKey]);
                                session_write_close();

                                $_SESSION['moulinet'][$key] = array_values($_SESSION['moulinet'][$key]);

                                if (empty($_SESSION['moulinet'][$key])) 
                                {
                                    unset($_SESSION['moulinet'][$key]);
                                    session_write_close();
                                }
                                break;
                            }
                        }
                    }
                }
                else
                {
                    $favoris->createToInsertFavoris($_POST);
                    $favorisRepo->insertFavoris($favoris);
                    $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
                    $favorisRepo->insertFavMoulinetAndUser($lastIdFav, $id_moulinet);
                    $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);
    
                    foreach ($favUser as $idFavo)
                    {
                        $allIdFav[] = $idFavo->getIdFavoris();
                    }
    
                    foreach ($allIdFav as $idFavoris)
                    {
                        $idMoulinetFav[] = $favorisRepo->getMoulinetByIdFav($idFavoris);
                    }

                    $_SESSION['moulinet'] = [$idMoulinetFav];
                    session_write_close();
                }
            }
        }
        else
        {
            $favoris->createToInsertFavoris($_POST);
            $favorisRepo->insertFavoris($favoris);
            $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
            $favorisRepo->insertFavMoulinetAndUser($lastIdFav, $id_moulinet);
            $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

            foreach ($favUser as $idFavo)
            {
                $allIdFav[] = $idFavo->getIdFavoris();
            }

            foreach ($allIdFav as $idFavoris)
            {
                $idMoulinetFav[] = $favorisRepo->getMoulinetByIdFav($idFavoris);
            }
            
            $_SESSION['moulinet'] = [$idMoulinetFav];
            session_write_close();
        }
    }

    if ($_POST['genre'] === 'hamecon')
    {
        $id_hamecon = $_POST['id_hamecon'];

        $favorisRepo = new FavorisRepository(); 
        $favoris = new Favoris();

        if (isset($_SESSION['hamecon']) && !empty($_SESSION['hamecon']))
        {
            foreach ($_SESSION['hamecon'] as $key => $hamecon)
            {
                if (in_array($id_hamecon, $hamecon))
                {
                    $favByIdHamecon = $favorisRepo->getFavorisByIdHamecon($id_hamecon);
                    
                    $idFavByIdUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

                    foreach ($favByIdHamecon as $favHamecons)
                    {
                        $favIdHamecon = $favHamecons->getIdFavoris();
                    }
                    
                    foreach ($idFavByIdUser as $favHameconsUser)
                    {
                        $favIdHameconUser[] = $favHameconsUser->getIdFavoris();
                    }
    
                    if (in_array($favIdHamecon, $favIdHameconUser))
                    {
                        $deleteFavAndHamecon = $favorisRepo->deleteFavHameconAndUser($favIdHamecon, $id_hamecon);
                    }
                    
                    foreach ($_SESSION['hamecon'] as $key => $subArray)
                    {
                        foreach ($subArray as $subKey => $subValue)
                        {
                            if ($id_hamecon == $subValue)
                            {
                                unset($_SESSION['hamecon'][$key][$subKey]);
                                session_write_close();

                                $_SESSION['hamecon'][$key] = array_values($_SESSION['hamecon'][$key]);

                                if (empty($_SESSION['hamecon'][$key])) 
                                {
                                    unset($_SESSION['hamecon'][$key]);
                                    session_write_close();
                                }
                                break;
                            }
                        }
                    }
                }
                else
                {
                    $favoris->createToInsertFavoris($_POST);
                    $favorisRepo->insertFavoris($favoris);
                    $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
                    $favorisRepo->insertFavHameconAndUser($lastIdFav, $id_hamecon);
                    $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);
    
                    foreach ($favUser as $idFavo)
                    {
                        $allIdFav[] = $idFavo->getIdFavoris();
                    }
    
                    foreach ($allIdFav as $idFavoris)
                    {
                        $idHameconFav[] = $favorisRepo->getHameconByIdFav($idFavoris);
                    }

                    $_SESSION['hamecon'] = [$idHameconFav];
                    session_write_close();
                }
            }
        }
        else
        {
            $favoris->createToInsertFavoris($_POST);
            $favorisRepo->insertFavoris($favoris);
            $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
            $favorisRepo->insertFavHameconAndUser($lastIdFav, $id_hamecon);
            $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

            foreach ($favUser as $idFavo)
            {
                $allIdFav[] = $idFavo->getIdFavoris();
            }

            foreach ($allIdFav as $idFavoris)
            {
                $idHameconFav[] = $favorisRepo->getHameconByIdFav($idFavoris);
            }
            
            $_SESSION['hamecon'] = [$idHameconFav];
            session_write_close();
        }
    }

    if ($_POST['genre'] === 'leurre')
    {
        $id_leurre = $_POST['id_leurre'];

        $favorisRepo = new FavorisRepository(); 
        $favoris = new Favoris();

        if (isset($_SESSION['leurre']) && !empty($_SESSION['leurre']))
        {
            foreach ($_SESSION['leurre'] as $key => $leurre)
            {
                if (in_array($id_leurre, $leurre))
                {
                    $favByIdLeurre = $favorisRepo->getFavorisByIdLeurre($id_leurre);
                    
                    $idFavByIdUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

                    foreach ($favByIdLeurre as $favLeurres)
                    {
                        $favIdLeurre = $favLeurres->getIdFavoris();
                    }
                    
                    foreach ($idFavByIdUser as $favLeurresUser)
                    {
                        $favIdLeurreUser[] = $favLeurresUser->getIdFavoris();
                    }
    
                    if (in_array($favIdLeurre, $favIdLeurreUser))
                    {
                        $deleteFavAndLeurre = $favorisRepo->deleteFavLeurreAndUser($favIdLeurre, $id_leurre);
                    }
                    
                    foreach ($_SESSION['leurre'] as $key => $subArray)
                    {
                        foreach ($subArray as $subKey => $subValue)
                        {
                            if ($id_leurre == $subValue)
                            {
                                unset($_SESSION['leurre'][$key][$subKey]);
                                session_write_close();

                                $_SESSION['leurre'][$key] = array_values($_SESSION['leurre'][$key]);

                                if (empty($_SESSION['leurre'][$key])) 
                                {
                                    unset($_SESSION['leurre'][$key]);
                                    session_write_close();
                                }
                                break;
                            }
                        }
                    }
                }
                else
                {
                    $favoris->createToInsertFavoris($_POST);
                    $favorisRepo->insertFavoris($favoris);
                    $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
                    $favorisRepo->insertFavLeurreAndUser($lastIdFav, $id_leurre);
                    $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);
    
                    foreach ($favUser as $idFavo)
                    {
                        $allIdFav[] = $idFavo->getIdFavoris();
                    }
    
                    foreach ($allIdFav as $idFavoris)
                    {
                        $idLeurreFav[] = $favorisRepo->getLeurreByIdFav($idFavoris);
                    }

                    $_SESSION['leurre'] = [$idLeurreFav];
                    session_write_close();
                }
            }
        }
        else
        {
            $favoris->createToInsertFavoris($_POST);
            $favorisRepo->insertFavoris($favoris);
            $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
            $favorisRepo->insertFavLeurreAndUser($lastIdFav, $id_leurre);
            $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

            foreach ($favUser as $idFavo)
            {
                $allIdFav[] = $idFavo->getIdFavoris();
            }

            foreach ($allIdFav as $idFavoris)
            {
                $idLeurreFav[] = $favorisRepo->getLeurreByIdFav($idFavoris);
            }
            
            $_SESSION['leurre'] = [$idLeurreFav];
            session_write_close();
        }
    }

    if ($_POST['genre'] === 'ligne')
    {
        $id_ligne = $_POST['id_ligne'];

        $favorisRepo = new FavorisRepository(); 
        $favoris = new Favoris();

        if (isset($_SESSION['ligne']) && !empty($_SESSION['ligne']))
        {
            foreach ($_SESSION['ligne'] as $key => $ligne)
            {
                if (in_array($id_ligne, $ligne))
                {
                    $favByIdLigne = $favorisRepo->getFavorisByIdLigne($id_ligne);
                    
                    $idFavByIdUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

                    foreach ($favByIdLigne as $favLignes)
                    {
                        $favIdLigne = $favLignes->getIdFavoris();
                    }
                    
                    foreach ($idFavByIdUser as $favLignesUser)
                    {
                        $favIdLigneUser[] = $favLignesUser->getIdFavoris();
                    }
    
                    if (in_array($favIdLigne, $favIdLigneUser))
                    {
                        $deleteFavAndLigne = $favorisRepo->deleteFavLigneAndUser($favIdLigne, $id_ligne);
                    }
                    
                    foreach ($_SESSION['ligne'] as $key => $subArray)
                    {
                        foreach ($subArray as $subKey => $subValue)
                        {
                            if ($id_ligne == $subValue)
                            {
                                unset($_SESSION['ligne'][$key][$subKey]);
                                session_write_close();

                                $_SESSION['ligne'][$key] = array_values($_SESSION['ligne'][$key]);

                                if (empty($_SESSION['ligne'][$key])) 
                                {
                                    unset($_SESSION['ligne'][$key]);
                                    session_write_close();
                                }
                                break;
                            }
                        }
                    }
                }
                else
                {
                    $favoris->createToInsertFavoris($_POST);
                    $favorisRepo->insertFavoris($favoris);
                    $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
                    $favorisRepo->insertFavLigneAndUser($lastIdFav, $id_ligne);
                    $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);
    
                    foreach ($favUser as $idFavo)
                    {
                        $allIdFav[] = $idFavo->getIdFavoris();
                    }
    
                    foreach ($allIdFav as $idFavoris)
                    {
                        $idLigneFav[] = $favorisRepo->getLigneByIdFav($idFavoris);
                    }

                    $_SESSION['ligne'] = [$idLigneFav];
                    session_write_close();
                }
            }
        }
        else
        {
            $favoris->createToInsertFavoris($_POST);
            $favorisRepo->insertFavoris($favoris);
            $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
            $favorisRepo->insertFavLigneAndUser($lastIdFav, $id_ligne);
            $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

            foreach ($favUser as $idFavo)
            {
                $allIdFav[] = $idFavo->getIdFavoris();
            }

            foreach ($allIdFav as $idFavoris)
            {
                $idLigneFav[] = $favorisRepo->getLigneByIdFav($idFavoris);
            }
            
            $_SESSION['ligne'] = [$idLigneFav];
            session_write_close();
        }
    }

    if ($_POST['genre'] === 'equipement')
    {
        $id_equipement = $_POST['id_equipement'];

        $favorisRepo = new FavorisRepository(); 
        $favoris = new Favoris();

        if (isset($_SESSION['equipement']) && !empty($_SESSION['equipement']))
        {
            foreach ($_SESSION['equipement'] as $key => $equipement)
            {
                if (in_array($id_equipement, $equipement))
                {
                    $favByIdEquipement = $favorisRepo->getFavorisByIdEquipement($id_equipement);
                    
                    $idFavByIdUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

                    foreach ($favByIdEquipement as $favEquipements)
                    {
                        $favIdEquipement = $favEquipements->getIdFavoris();
                    }
                    
                    foreach ($idFavByIdUser as $favEquipementsUser)
                    {
                        $favIdEquipementUser[] = $favEquipementsUser->getIdFavoris();
                    }
    
                    if (in_array($favIdEquipement, $favIdEquipementUser))
                    {
                        $deleteFavAndEquipement = $favorisRepo->deleteFavEquipementAndUser($favIdEquipement, $id_equipement);
                    }
                    
                    foreach ($_SESSION['equipement'] as $key => $subArray)
                    {
                        foreach ($subArray as $subKey => $subValue)
                        {
                            if ($id_equipement == $subValue)
                            {
                                unset($_SESSION['equipement'][$key][$subKey]);
                                session_write_close();

                                $_SESSION['equipement'][$key] = array_values($_SESSION['equipement'][$key]);

                                if (empty($_SESSION['equipement'][$key])) 
                                {
                                    unset($_SESSION['equipement'][$key]);
                                    session_write_close();
                                }
                                break;
                            }
                        }
                    }
                }
                else
                {
                    $favoris->createToInsertFavoris($_POST);
                    $favorisRepo->insertFavoris($favoris);
                    $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
                    $favorisRepo->insertFavEquipementAndUser($lastIdFav, $id_equipement);
                    $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);
    
                    foreach ($favUser as $idFavo)
                    {
                        $allIdFav[] = $idFavo->getIdFavoris();
                    }
    
                    foreach ($allIdFav as $idFavoris)
                    {
                        $idEquipementFav[] = $favorisRepo->getEquipementByIdFav($idFavoris);
                    }

                    $_SESSION['equipement'] = [$idEquipementFav];
                    session_write_close();
                }
            }
        }
        else
        {
            $favoris->createToInsertFavoris($_POST);
            $favorisRepo->insertFavoris($favoris);
            $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
            $favorisRepo->insertFavEquipementAndUser($lastIdFav, $id_equipement);
            $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

            foreach ($favUser as $idFavo)
            {
                $allIdFav[] = $idFavo->getIdFavoris();
            }

            foreach ($allIdFav as $idFavoris)
            {
                $idEquipementFav[] = $favorisRepo->getEquipementByIdFav($idFavoris);
            }
            
            $_SESSION['equipement'] = [$idEquipementFav];
            session_write_close();
        }
    }

    if ($_POST['genre'] === 'plomb')
    {
        $id_plomb = $_POST['id_plomb'];

        $favorisRepo = new FavorisRepository(); 
        $favoris = new Favoris();

        if (isset($_SESSION['plomb']) && !empty($_SESSION['plomb']))
        {
            foreach ($_SESSION['plomb'] as $key => $plomb)
            {
                if (in_array($id_plomb, $plomb))
                {
                    $favByIdFeeder = $favorisRepo->getFavorisByIdFeeder($id_plomb);
                    
                    $idFavByIdUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

                    foreach ($favByIdFeeder as $favFeeders)
                    {
                        $favIdFeeder = $favFeeders->getIdFavoris();
                    }
                    
                    foreach ($idFavByIdUser as $favFeedersUser)
                    {
                        $favIdFeederUser[] = $favFeedersUser->getIdFavoris();
                    }
    
                    if (in_array($favIdFeeder, $favIdFeederUser))
                    {
                        $deleteFavAndFeeder = $favorisRepo->deleteFavFeederAndUser($favIdFeeder, $id_plomb);
                    }
                    
                    foreach ($_SESSION['plomb'] as $key => $subArray)
                    {
                        foreach ($subArray as $subKey => $subValue)
                        {
                            if ($id_plomb == $subValue)
                            {
                                unset($_SESSION['plomb'][$key][$subKey]);
                                session_write_close();

                                $_SESSION['plomb'][$key] = array_values($_SESSION['plomb'][$key]);

                                if (empty($_SESSION['plomb'][$key])) 
                                {
                                    unset($_SESSION['plomb'][$key]);
                                    session_write_close();
                                }
                                break;
                            }
                        }
                    }
                }
                else
                {
                    $favoris->createToInsertFavoris($_POST);
                    $favorisRepo->insertFavoris($favoris);
                    $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
                    $favorisRepo->insertFavFeederAndUser($lastIdFav, $id_plomb);
                    $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);
    
                    foreach ($favUser as $idFavo)
                    {
                        $allIdFav[] = $idFavo->getIdFavoris();
                    }
    
                    foreach ($allIdFav as $idFavoris)
                    {
                        $idFeederFav[] = $favorisRepo->getFeederByIdFav($idFavoris);
                    }

                    $_SESSION['plomb'] = [$idFeederFav];
                    session_write_close();
                }
            }
        }
        else
        {
            $favoris->createToInsertFavoris($_POST);
            $favorisRepo->insertFavoris($favoris);
            $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
            $favorisRepo->insertFavFeederAndUser($lastIdFav, $id_plomb);
            $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

            foreach ($favUser as $idFavo)
            {
                $allIdFav[] = $idFavo->getIdFavoris();
            }

            foreach ($allIdFav as $idFavoris)
            {
                $idFeederFav[] = $favorisRepo->getFeederByIdFav($idFavoris);
            }
            
            $_SESSION['plomb'] = [$idFeederFav];
            session_write_close();
        }
    }

    if ($_POST['genre'] === 'appat')
    {
        $id_appat = $_POST['id_appat'];

        $favorisRepo = new FavorisRepository(); 
        $favoris = new Favoris();

        if (isset($_SESSION['appat']) && !empty($_SESSION['appat']))
        {
            foreach ($_SESSION['appat'] as $key => $appat)
            {
                if (in_array($id_appat, $appat))
                {
                    $favByIdAppat = $favorisRepo->getFavorisByIdAppat($id_appat);
                    
                    $idFavByIdUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

                    foreach ($favByIdAppat as $favAppats)
                    {
                        $favIdAppat = $favAppats->getIdFavoris();
                    }
                    
                    foreach ($idFavByIdUser as $favAppatsUser)
                    {
                        $favIdAppatUser[] = $favAppatsUser->getIdFavoris();
                    }
    
                    if (in_array($favIdAppat, $favIdAppatUser))
                    {
                        $deleteFavAndAppat = $favorisRepo->deleteFavAppatAndUser($favIdAppat, $id_appat);
                    }
                    
                    foreach ($_SESSION['appat'] as $key => $subArray)
                    {
                        foreach ($subArray as $subKey => $subValue)
                        {
                            if ($id_appat == $subValue)
                            {
                                unset($_SESSION['appat'][$key][$subKey]);
                                session_write_close();

                                $_SESSION['appat'][$key] = array_values($_SESSION['appat'][$key]);

                                if (empty($_SESSION['appat'][$key])) 
                                {
                                    unset($_SESSION['appat'][$key]);
                                    session_write_close();
                                }
                                break;
                            }
                        }
                    }
                }
                else
                {
                    $favoris->createToInsertFavoris($_POST);
                    $favorisRepo->insertFavoris($favoris);
                    $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
                    $favorisRepo->insertFavAppatAndUser($lastIdFav, $id_appat);
                    $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);
    
                    foreach ($favUser as $idFavo)
                    {
                        $allIdFav[] = $idFavo->getIdFavoris();
                    }
    
                    foreach ($allIdFav as $idFavoris)
                    {
                        $idAppatFav[] = $favorisRepo->getAppatByIdFav($idFavoris);
                    }

                    $_SESSION['appat'] = [$idAppatFav];
                    session_write_close();
                }
            }
        }
        else
        {
            $favoris->createToInsertFavoris($_POST);
            $favorisRepo->insertFavoris($favoris);
            $lastIdFav = $favorisRepo->getLastInsertIdFavoris();
            $favorisRepo->insertFavAppatAndUser($lastIdFav, $id_appat);
            $favUser = $favorisRepo->getFavorisByIdUser($_SESSION['id_user']);

            foreach ($favUser as $idFavo)
            {
                $allIdFav[] = $idFavo->getIdFavoris();
            }

            foreach ($allIdFav as $idFavoris)
            {
                $idAppatFav[] = $favorisRepo->getAppatByIdFav($idFavoris);
            }
            
            $_SESSION['appat'] = [$idAppatFav];
            session_write_close();
        }
    }

    $page = $_POST['page'];

    if(!empty($page))
    {
        header('location: /'. $page);
    }
    else
    {
        header('location: /home');
    }
    exit();
}

//AFFICHAGE DE LA PAGE DE PROFIL
function profilPage()
{
    if($_SESSION)
    {
        $cannes = getFavorisCanneId();

        $combinedArticles = [];

        if($cannes != false)
        {
            foreach($cannes as $canne)
            {
                if($canne != null)
                {
                    $canneRepo = new CanneRepository;
                    $canneFav = $canneRepo->getCanneById($canne);
            
                    $imgCanneRepo = new ImageCanneRepository;
                    $imgCannes = $imgCanneRepo->getImageByCanne($canne);

                    $combinedArticles[] = 
                    [
                        'genre' => 'canne',
                        'id' => $canneFav->getIdCanne(),
                        'nom' => $canneFav->getNomCanne(),
                        'image' => $imgCannes->getNomImageCanne(),
                        'marque' => $canneFav->getMarqueCanne(),
                        'type' => $canneFav->getTypeCanne(),
                        'categorie' => $canneFav->getCategorieCanne(),
                        'longueur' => $canneFav->getLongueurCanne(),
                        'poids' => $canneFav->getPoidsCanne(),
                    ];
                }
            }
        }

        $moulinets = getFavorisMoulinetId();

        if($moulinets != false)
        {
            foreach($moulinets as $moulinet)
            {
                if($moulinet != null)
                {
                    $moulinetRepo = new MoulinetRepository;
                    $moulinetFav = $moulinetRepo->getMoulinetById($moulinet);
                
                    $imgMoulinetRepo = new ImageMoulinetRepository;
                    $imgMoulinets = $imgMoulinetRepo->getImageByMoulinet($moulinet);
                    $combinedArticles[] = 
                    [
                        'genre' => 'moulinet',
                        'id' => $moulinetFav->getIdMoulinet(),
                        'nom' => $moulinetFav->getNomMoulinet(),
                        'image' => $imgMoulinets->getNomImageMoulinet(),
                        'marque' => $moulinetFav->getMarqueMoulinet(),
                        'type' => $moulinetFav->getTypeMoulinet(),
                        'categorie' => $moulinetFav->getCategorieMoulinet(),
                        'ratio' => $moulinetFav->getRatioMoulinet(),
                        'poids' => $moulinetFav->getPoidsMoulinet(),
                    ];
                }
            }
        }

        $hamecons = getFavorisHameconId();

        if($hamecons != false)
        {
            foreach($hamecons as $hamecon)
            {
                if($hamecon != null)
                {
                    $hameconRepo = new HameconRepository;
                    $hameconFav = $hameconRepo->getHameconById($hamecon);
                
                    $imgHameconRepo = new ImageHameconRepository;
                    $imgHamecons = $imgHameconRepo->getImageByHamecon($hamecon);
                    $combinedArticles[] = 
                    [
                        'genre' => 'hamecon',
                        'id' => $hameconFav->getIdHamecon(),
                        'nom' => $hameconFav->getNomHamecon(),
                        'image' => $imgHamecons->getNomImageHamecon(),
                        'marque' => $hameconFav->getMarqueHamecon(),
                        'type' => $hameconFav->getTypeHamecon(),
                        'categorie' => $hameconFav->getCategorieHamecon(),
                        'longueur' => $hameconFav->getLongueurHamecon(),
                        'poids' => $hameconFav->getPoidsHamecon(),
                    ];
                }
            }
        }

        $leurres = getFavorisLeurreId();

        if($leurres != false)
        {
            foreach($leurres as $leurre)
            {
                if($leurre != null)
                {
                    $leurreRepo = new LeurreRepository;
                    $leurreFav = $leurreRepo->getLeurreById($leurre);
                
                    $imgLeurreRepo = new ImageLeurreRepository;
                    $imgLeurres = $imgLeurreRepo->getImageByLeurre($leurre);
                    $combinedArticles[] = 
                    [
                        'genre' => 'leurre',
                        'id' => $leurreFav->getIdLeurre(),
                        'nom' => $leurreFav->getNomLeurre(),
                        'image' => $imgLeurres->getNomImageLeurre(),
                        'marque' => $leurreFav->getMarqueLeurre(),
                        'type' => $leurreFav->getTypeLeurre(),
                        'categorie' => $leurreFav->getCategorieLeurre(),
                        'longueur' => $leurreFav->getLongueurLeurre(),
                        'diametre' => $leurreFav->getDiametreLeurre(),
                        'poids' => $leurreFav->getPoidsLeurre(),
                    ];
                }
            }
        }

        $lignes = getFavorisLigneId();

        if($lignes != false)
        {
            foreach($lignes as $ligne)
            {
                if($ligne != null)
                {
                    $ligneRepo = new LigneRepository;
                    $ligneFav = $ligneRepo->getLigneById($ligne);
                
                    $imgLigneRepo = new ImageLigneRepository;
                    $imgLignes = $imgLigneRepo->getImageByLigne($ligne);
                    $combinedArticles[] = 
                    [
                        'genre' => 'ligne',
                        'id' => $ligneFav->getIdLigne(),
                        'nom' => $ligneFav->getNomLigne(),
                        'image' => $imgLignes->getNomImageLigne(),
                        'marque' => $ligneFav->getMarqueLigne(),
                        'type' => $ligneFav->getTypeLigne(),
                        'categorie' => $ligneFav->getCategorieLigne(),
                        'longueur' => $ligneFav->getLongueurLigne(),
                        'poids' => $ligneFav->getPoidsLigne(),
                        'diametre' => $leurreFav->getDiametreLigne(),
                    ];
                }
            }
        }

        $equipements = getFavorisEquipementId();

        if($equipements != false)
        {
            foreach($equipements as $equipement)
            {
                if($equipement != null)
                {
                    $equipementRepo = new EquipementRepository;
                    $equipementFav = $equipementRepo->getEquipementById($equipement);
                
                    $imgEquipementRepo = new ImageEquipementRepository;
                    $imgEquipements = $imgEquipementRepo->getImageByEquipement($equipement);
                    $combinedArticles[] = 
                    [
                        'genre' => 'equipement',
                        'id' => $equipementFav->getIdEquipement(),
                        'nom' => $equipementFav->getNomEquipement(),
                        'image' => $imgEquipements->getNomImageEquipement(),
                        'marque' => $equipementFav->getMarqueEquipement(),
                        'type' => $equipementFav->getTypeEquipement(),
                        'categorie' => $equipementFav->getCategorieEquipement(),
                        'detail' => $equipementFav->getDetailEquipement(),
                    ];
                }
            }
        }

        $plombs = getFavorisPlombId();

        if($plombs != false)
        {
            foreach($plombs as $plomb)
            {
                if($plomb != null)
                {
                    $plombRepo = new FeederRepository;
                    $plombFav = $plombRepo->getFeederById($plomb);
                
                    $imgFeederRepo = new ImageFeederRepository;
                    $imgFeeders = $imgFeederRepo->getImageByFeeder($plomb);
                    $combinedArticles[] = 
                    [
                        'genre' => 'plomb',
                        'id' => $plombFav->getIdFeeder(),
                        'nom' => $plombFav->getNomFeeder(),
                        'image' => $imgFeeders->getNomImageFeeder(),
                        'marque' => $plombFav->getMarqueFeeder(),
                        'type' => $plombFav->getTypeFeeder(),
                        'categorie' => $plombFav->getCategorieFeeder(),
                        'longueur' => $plombFav->getLongueurFeeder(),
                        'poids' => $plombFav->getPoidsFeeder(),
                        'diametre' => $plombFav->getDiametreFeeder(),
                    ];
                }
            }
        }

        $appats = getFavorisAppatId();

        if($appats != false)
        {
            foreach($appats as $appat)
            {
                if($appat != null)
                {
                    $appatRepo = new AppatRepository;
                    $appatFav = $appatRepo->getAppatById($appat);
                
                    $imgAppatRepo = new ImageAppatRepository;
                    $imgAppats = $imgAppatRepo->getImageByAppat($appat);
                    $combinedArticles[] = 
                    [
                        'genre' => 'appat',
                        'id' => $appatFav->getIdAppat(),
                        'nom' => $appatFav->getNomAppat(),
                        'image' => $imgAppats->getNomImageAppat(),
                        'marque' => $appatFav->getMarqueAppat(),
                        'type' => $appatFav->getTypeAppat(),
                        'categorie' => $appatFav->getCategorieAppat(),
                        'detail' => $appatFav->getDetailAppat(),
                    ];
                }
            }
        }

        include('src/view/profilPage.php');
    }
    else
    {
        header('location: /login');
    }
}

function getFavorisCanneId()
{
    $articles = getAllArticles();

    foreach($articles as $article)
    {
        if($article['genre'] == 'canne')
        {
            if(isset($_SESSION['moulinet']))
            {
                foreach($_SESSION['canne'] as $cannes)
                {
                    return $cannes;
                }
            }
            else
            {
                return false;
            }
        }
    }
}

function getFavorisMoulinetId()
{
    $articles = getAllArticles();

    foreach($articles as $article)
    {
        if($article['genre'] == 'moulinet')
        {
            if(isset($_SESSION['moulinet']))
            {
                foreach($_SESSION['moulinet'] as $moulinets)
                {
                    return $moulinets;
                }
            }
            else
            {
                return false;
            }
        }
    }
}

function getFavorisHameconId()
{
    $articles = getAllArticles();

    foreach($articles as $article)
    {
        if($article['genre'] == 'hamecon')
        {
            if(isset($_SESSION['hamecon']))
            {
                foreach($_SESSION['hamecon'] as $hamecons)
                {
                    return $hamecons;
                }
            }
            else
            {
                return false;
            }
        }
    }
}

function getFavorisLeurreId()
{
    $articles = getAllArticles();

    foreach($articles as $article)
    {
        if($article['genre'] == 'leurre')
        {
            if(isset($_SESSION['leurre']))
            {
                foreach($_SESSION['leurre'] as $leurres)
                {
                    return $leurres;
                }
            }
            else
            {
                return false;
            }
        }
    }
}

function getFavorisLigneId()
{
    $articles = getAllArticles();

    foreach($articles as $article)
    {
        if($article['genre'] == 'ligne')
        {
            if(isset($_SESSION['ligne']))
            {
                foreach($_SESSION['ligne'] as $lignes)
                {
                    return $lignes;
                }
            }
            else
            {
                return false;
            }
        }
    }
}

function getFavorisEquipementId()
{
    $articles = getAllArticles();

    foreach($articles as $article)
    {
        if($article['genre'] == 'equipement')
        {
            if(isset($_SESSION['equipement']))
            {
                foreach($_SESSION['equipement'] as $equipements)
                {
                    return $equipements;
                }
            }
            else
            {
                return false;
            }
        }
    }
}

function getFavorisPlombId()
{
    $articles = getAllArticles();

    foreach($articles as $article)
    {
        if($article['genre'] == 'plomb')
        {
            if(isset($_SESSION['plomb']))
            {
                foreach($_SESSION['plomb'] as $plombs)
                {
                    return $plombs;
                }
            }
            else
            {
                return false;
            }
        }
    }
}

function getFavorisAppatId()
{
    $articles = getAllArticles();

    foreach($articles as $article)
    {
        if($article['genre'] == 'appat')
        {
            if(isset($_SESSION['appat']))
            {
                foreach($_SESSION['appat'] as $appats)
                {
                    return $appats;
                }
            }
            else
            {
                return false;
            }
        }
    }
}

//AFFICHAGE DES RECHERCHES
function searchPage()
{
    if(isset($_GET['keywords']))
    {
        $marqueRepo = new MarqueRepository;
        $marques = $marqueRepo->getAllMarque();

        $categorieRepo = new CategorieRepository;
        $categories = $categorieRepo->getAllCategorie();

        $articlesSelectionnes = searchResult();
        
        require('src/view/searchPage.php');
    }
}

function searchResult()
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

    $articles = combinedArticle($article);

    if(!empty($_GET['keywords']))
    {
        $keywords[] = htmlspecialchars($_GET['keywords']); 

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
        return $articlesSelectionnes;
    }
    else
    {
        header('location: /home');
    }
}

//AFFICHAGE DE LA PAGE DE TOUS LES ARTICLES
function articlePage()
{
    $articles = getLastArticles();

    $marques = getAllMarque();

    $categories = getAllCategorie();

    include('src/view/articlePage.php');
}

//AFFICHAGE DE LA PAGE DE TOUTES LES MARQUES
function marquePage()
{
    $marques = getAllMarque();

    include('src/view/marquePage.php');
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
        header('location: /home');
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

//AFFICHAGE DE LA PAGE D'ARTICLE EN FONCTION DE LA MARQUE EN GET
function viewPageMarque()
{
    $marqueRepo = new MarqueRepository;

    if($marqueRepo->existMarque($_GET['marque']))
    {
        $marque = $marqueRepo->existMarque($_GET['marque']);
    }
    else
    {
        header('location: /home');
    }

    $allCanneRepo = new CanneRepository;
    $allMoulinetRepo = new MoulinetRepository;
    $allHameconRepo = new HameconRepository;
    $allLeurreRepo = new LeurreRepository;
    $allLigneRepo = new LigneRepository;
    $allEquipementRepo = new EquipementRepository;
    $allFeederRepo = new FeederRepository;
    $allAppatRepo = new AppatRepository;

    $categories = getAllCategorie();

    foreach($marque as $idMarques)
    {
        $idMarque = $idMarques->getIdMarque();
    }

    $articles = [];

    $articles['cannes'] = $allCanneRepo->getCanneByMarque($idMarque);
    $articles['moulinets'] = $allMoulinetRepo->getMoulinetByMarque($idMarque);
    $articles['hamecons'] = $allHameconRepo->getHameconByMarque($idMarque);
    $articles['leurres'] = $allLeurreRepo->getLeurreByMarque($idMarque);
    $articles['equipements'] = $allEquipementRepo->getEquipementByMarque($idMarque);
    $articles['lignes'] = $allLigneRepo->getLigneByMarque($idMarque);
    $articles['appats'] = $allAppatRepo->getAppatByMarque($idMarque);
    $articles['feeders'] = $allFeederRepo->getFeederByMarque($idMarque);

    $combinedArticles = combinedArticle($articles);

    include('src/view/articlePageByMarque.php');
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
                'favorie' => 'non',
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

//PAGE D'AFFICHAGE DE TOUTES LES CANNES
function allEquipementPage()
{
    $equipementRepo = new EquipementRepository;
    $equipements = $equipementRepo->getAllEquipement();

    foreach ($equipements as $equipement) 
    {
        if ($equipement) 
        {
            $imgEquipementRepo = new ImageEquipementRepository;
            $imgEquipements = $imgEquipementRepo->getImageByEquipement($equipement->getIdEquipement());
            $allEquipements[] =
            [
                'genre' => 'equipement',
                'id' => $equipement->getIdEquipement(),
                'nom' => $equipement->getNomEquipement(),
                'image' => $imgEquipements->getNomImageEquipement(),
                'marque' => $equipement->getMarqueEquipement(),
                'type' => $equipement->getTypeEquipement(),
                'categorie' => $equipement->getCategorieEquipement(),
                'favorie' => 'non',
            ];
        } 
        else 
        {
            $allEquipements[] = [''];
        }
    }

    $categories = getAllCategorie();

    $typeEquipementRepo = new TypeEquipementRepository;
    $typeEquipements = $typeEquipementRepo->getAllTypeEquipement();

    $marques = getAllMarque();

    // foreach ($equipements as $equipement) 
    // {
    //     $longueursEquipement[] = $equipement->getDetailEquipement();
    // }

    include('src/view/allArticlePage/articlePageEquipement.php');
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

//RECUPERATION D'ID DE MARQUE EN FONCTION DES NOM DE MARQUE EN GET
function getIdMarque()
{
    $marqueRepo = new MarqueRepository;

    $marque = $marqueRepo->existMarque($_GET['marque']);

    foreach ($marque as $idMarques)
    {
        $idMarque = $idMarques->getIdMarque();
    }

    return $idMarque;
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
        echo '<div class="w-56">';
        echo '<a href="/' . $articleFiltred['genre'] . 'Page/' . $articleFiltred['id'] . '">';
        echo '<div class="w-56">';
        echo '<img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/' . $articleFiltred['image'] . '"/>';
        echo '</div>';
        echo '</a>';
        echo '<div class="flex justify-center gap-10 py-3">';
        echo '<div>';
        echo '<p class="text-s md:text-lg">';
        echo $articleFiltred['nom'];
        echo '</p>';
        echo '<p class="text-xs md:text-sm uppercase">';
        echo $articleFiltred['marque'];
        echo '</p>';
        echo '</div>';
        
        if ($_SESSION) {
            echo '<div>';
            echo '<form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">';
            echo '<input type="hidden" name="id_' . $articleFiltred['genre'] . '" value="' . $articleFiltred['id'] . '">';
            echo '<input type="hidden" name="id_user" value="' . $_SESSION['id_user'] . '">';
            echo '<input type="hidden" name="genre" value="' . $articleFiltred['genre'] . '">';
            echo '<input type="hidden" name="date_ajout_favoris" value="' . date("d/m/y") . '">';
            
            if ($_SESSION[$articleFiltred['genre']]) {
                foreach ($_SESSION[$articleFiltred['genre']] as $idTab) {
                    if (in_array($articleFiltred['id'], $idTab)) {
                        echo '<button class="favoris-button" type="submit">';
                        echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/liked.png">';
                        echo '</button>';
                    } else {
                        echo '<button class="favoris-button" type="submit">';
                        echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
                        echo '</button>';
                    }
                }
            } else {
                echo '<button class="favoris-button" type="submit">';
                echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
                echo '</button>';
            }
            
            echo '</form>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
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

    foreach ($articlesFiltres as $articleFiltred) {
        echo '<div class="w-56">';
        echo '<a href="/' . $articleFiltred['genre'] . 'Page/' . $articleFiltred['id'] . '">';
        echo '<div class="w-56">';
        echo '<img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/' . $articleFiltred['image'] . '"/>';
        echo '</div>';
        echo '</a>';
        echo '<div class="flex justify-center gap-10 py-3">';
        echo '<div>';
        echo '<p class="text-s md:text-lg">';
        echo $articleFiltred['nom'];
        echo '</p>';
        echo '<p class="text-xs md:text-sm uppercase">';
        echo $articleFiltred['marque'];
        echo '</p>';
        echo '</div>';
        
        if ($_SESSION) {
            echo '<div>';
            echo '<form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">';
            echo '<input type="hidden" name="id_' . $articleFiltred['genre'] . '" value="' . $articleFiltred['id'] . '">';
            echo '<input type="hidden" name="id_user" value="' . $_SESSION['id_user'] . '">';
            echo '<input type="hidden" name="genre" value="' . $articleFiltred['genre'] . '">';
            echo '<input type="hidden" name="date_ajout_favoris" value="' . date("d/m/y") . '">';
            
            if ($_SESSION[$articleFiltred['genre']]) {
                foreach ($_SESSION[$articleFiltred['genre']] as $idTab) {
                    if (in_array($articleFiltred['id'], $idTab)) {
                        echo '<button class="favoris-button" type="submit">';
                        echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/liked.png">';
                        echo '</button>';
                    } else {
                        echo '<button class="favoris-button" type="submit">';
                        echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
                        echo '</button>';
                    }
                }
            } else {
                echo '<button class="favoris-button" type="submit">';
                echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
                echo '</button>';
            }
            
            echo '</form>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
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
        echo '<div class="w-56">';
        echo '<a href="/' . $articleFiltred['genre'] . 'Page/' . $articleFiltred['id'] . '">';
        echo '<div class="w-56">';
        echo '<img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/' . $articleFiltred['image'] . '"/>';
        echo '</div>';
        echo '</a>';
        echo '<div class="flex justify-center gap-10 py-3">';
        echo '<div>';
        echo '<p class="text-s md:text-lg">';
        echo $articleFiltred['nom'];
        echo '</p>';
        echo '<p class="text-xs md:text-sm uppercase">';
        echo $articleFiltred['marque'];
        echo '</p>';
        echo '</div>';
        
        if ($_SESSION) {
            echo '<div>';
            echo '<form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">';
            echo '<input type="hidden" name="id_' . $articleFiltred['genre'] . '" value="' . $articleFiltred['id'] . '">';
            echo '<input type="hidden" name="id_user" value="' . $_SESSION['id_user'] . '">';
            echo '<input type="hidden" name="genre" value="' . $articleFiltred['genre'] . '">';
            echo '<input type="hidden" name="date_ajout_favoris" value="' . date("d/m/y") . '">';
            
            if ($_SESSION[$articleFiltred['genre']]) {
                foreach ($_SESSION[$articleFiltred['genre']] as $idTab) {
                    if (in_array($articleFiltred['id'], $idTab)) {
                        echo '<button class="favoris-button" type="submit">';
                        echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/liked.png">';
                        echo '</button>';
                    } else {
                        echo '<button class="favoris-button" type="submit">';
                        echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
                        echo '</button>';
                    }
                }
            } else {
                echo '<button class="favoris-button" type="submit">';
                echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
                echo '</button>';
            }
            
            echo '</form>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
    }
    
}

//TRAITEMENT POUR LES FILTRES DES ARTICLES EN FONCTION DE LA MARQUE PRIT EN GET
function filtrePageMarque()
{
    $allCanneRepo = new CanneRepository;
    $allMoulinetRepo = new MoulinetRepository;
    $allHameconRepo = new HameconRepository;
    $allLeurreRepo = new LeurreRepository;
    $allLigneRepo = new LigneRepository;
    $allEquipementRepo = new EquipementRepository;
    $allFeederRepo = new FeederRepository;
    $allAppatRepo = new AppatRepository;

    $idMarque = getIdMarque();

    $articles = [];

    $articles['cannes'] = $allCanneRepo->getCanneByMarque($idMarque);
    $articles['moulinets'] = $allMoulinetRepo->getMoulinetByMarque($idMarque);
    $articles['hamecons'] = $allHameconRepo->getHameconByMarque($idMarque);
    $articles['leurres'] = $allLeurreRepo->getLeurreByMarque($idMarque);
    $articles['equipements'] = $allEquipementRepo->getEquipementByMarque($idMarque);
    $articles['lignes'] = $allLigneRepo->getLigneByMarque($idMarque);
    $articles['appats'] = $allAppatRepo->getAppatByMarque($idMarque);
    $articles['feeders'] = $allFeederRepo->getFeederByMarque($idMarque);

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
        echo '<div class="w-56">';
        echo '<a href="/' . $articleFiltred['genre'] . 'Page/' . $articleFiltred['id'] . '">';
        echo '<div class="w-56">';
        echo '<img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/' . $articleFiltred['image'] . '"/>';
        echo '</div>';
        echo '</a>';
        echo '<div class="flex justify-center gap-10 py-3">';
        echo '<div>';
        echo '<p class="text-s md:text-lg">';
        echo $articleFiltred['nom'];
        echo '</p>';
        echo '<p class="text-xs md:text-sm uppercase">';
        echo $articleFiltred['marque'];
        echo '</p>';
        echo '</div>';
        
        if ($_SESSION) 
        {
            echo '<div>';
            echo '<form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">';
            echo '<input type="hidden" name="id_' . $articleFiltred['genre'] . '" value="' . $articleFiltred['id'] . '">';
            echo '<input type="hidden" name="id_user" value="' . $_SESSION['id_user'] . '">';
            echo '<input type="hidden" name="genre" value="' . $articleFiltred['genre'] . '">';
            echo '<input type="hidden" name="date_ajout_favoris" value="' . date("d/m/y") . '">';
            
            if ($_SESSION[$articleFiltred['genre']]) {
                foreach ($_SESSION[$articleFiltred['genre']] as $idTab) {
                    if (in_array($articleFiltred['id'], $idTab)) {
                        echo '<button class="favoris-button" type="submit">';
                        echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/liked.png">';
                        echo '</button>';
                    } else {
                        echo '<button class="favoris-button" type="submit">';
                        echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
                        echo '</button>';
                    }
                }
            } else {
                echo '<button class="favoris-button" type="submit">';
                echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
                echo '</button>';
            }
            
            echo '</form>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
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
        echo '<div class="w-56">';
        echo '<a href="/' . $articleFiltred['genre'] . 'Page/' . $articleFiltred['id'] . '">';
        echo '<div class="w-56">';
        echo '<img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/' . $articleFiltred['image'] . '"/>';
        echo '</div>';
        echo '</a>';
        echo '<div class="flex justify-center gap-10 py-3">';
        echo '<div>';
        echo '<p class="text-s md:text-lg">';
        echo $articleFiltred['nom'];
        echo '</p>';
        echo '<p class="text-xs md:text-sm uppercase">';
        echo $articleFiltred['marque'];
        echo '</p>';
        echo '</div>';
        
        if ($_SESSION) {
            echo '<div>';
            echo '<form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">';
            echo '<input type="hidden" name="id_' . $articleFiltred['genre'] . '" value="' . $articleFiltred['id'] . '">';
            echo '<input type="hidden" name="id_user" value="' . $_SESSION['id_user'] . '">';
            echo '<input type="hidden" name="genre" value="' . $articleFiltred['genre'] . '">';
            echo '<input type="hidden" name="date_ajout_favoris" value="' . date("d/m/y") . '">';
            
            if ($_SESSION[$articleFiltred['genre']]) {
                foreach ($_SESSION[$articleFiltred['genre']] as $idTab) {
                    if (in_array($articleFiltred['id'], $idTab)) {
                        echo '<button class="favoris-button" type="submit">';
                        echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/liked.png">';
                        echo '</button>';
                    } else {
                        echo '<button class="favoris-button" type="submit">';
                        echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
                        echo '</button>';
                    }
                }
            } else {
                echo '<button class="favoris-button" type="submit">';
                echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
                echo '</button>';
            }
            
            echo '</form>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
    }
    
}

//TRAITEMENT POUR LES FILTRES DES PAGES D'EQUIPEMENT
function filtreEquipement()
{
    $equipementRepo = new EquipementRepository;
    $articlesEquipement = $equipementRepo->getAllEquipement();

    foreach ($articlesEquipement as $equipement) 
    {
        if ($equipement) 
        {
            $imgEquipementRepo = new ImageEquipementRepository;
            $imgEquipements = $imgEquipementRepo->getImageByEquipement($equipement->getIdEquipement());
            $allEquipements[] = 
            [
                'genre' => 'equipement',
                'id' => $equipement->getIdEquipement(),
                'nom' => $equipement->getNomEquipement(),
                'image' => $imgEquipements->getNomImageEquipement(),
                'marque' => $equipement->getMarqueEquipement(),
                'type' => $equipement->getTypeEquipement(),
                'categorie' => $equipement->getCategorieEquipement(),
                'detail' => $equipement->getDetailEquipement(),
            ];
        }
        else 
        {
            $allEquipements[] = [''];
        }
    }

    $filtresEquipement = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

    $articlesFiltresEquipement = [];

    $typesFiltresEquipement = [];
    $marquesFiltresEquipement = [];
    $categoriesFiltresEquipement = [];

    foreach ($filtresEquipement as $filtreEquipement) 
    {
        if (isCategorie($filtreEquipement))
        {
            $categoriesFiltresEquipement[] = $filtreEquipement;
        } 
        elseif (isMarque($filtreEquipement)) 
        {
            $marquesFiltresEquipement[] = $filtreEquipement;
        } 
        elseif (isTypeEquipement($filtreEquipement)) 
        {
            $typesFiltresEquipement[] = $filtreEquipement;
        }
    }

    $isTypesFiltresEquipement = !empty($typesFiltresEquipement);

    $isMarquesSelected = !empty($marquesFiltresEquipement);

    $isCategoriesSelected = !empty($categoriesFiltresEquipement);

    foreach ($allEquipements as $article) 
    {
        $isTypeMatch = in_array($article['type'], $typesFiltresEquipement) || !$isTypesFiltresEquipement;

        $isMarqueMatch = in_array($article['marque'], $marquesFiltresEquipement) || !$isMarquesSelected;

        $isCategorieMatch = in_array($article['categorie'], $categoriesFiltresEquipement) || !$isCategoriesSelected;

        $isLongueurMatch = true;

        $isPoidMatch = true;

        if ($isTypeMatch && $isMarqueMatch && $isCategorieMatch && $isLongueurMatch && $isPoidMatch) 
        {
            $articlesFiltresEquipement[] = $article;
        }
    }

    foreach ($articlesFiltresEquipement as $articleFiltred) 
    {
        echo '<div class="w-56">';
        echo '<a href="/' . $articleFiltred['genre'] . 'Page/' . $articleFiltred['id'] . '">';
        echo '<div class="w-56">';
        echo '<img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/' . $articleFiltred['image'] . '"/>';
        echo '</div>';
        echo '</a>';
        echo '<div class="flex justify-center gap-10 py-3">';
        echo '<div>';
        echo '<p class="text-s md:text-lg">';
        echo $articleFiltred['nom'];
        echo '</p>';
        echo '<p class="text-xs md:text-sm uppercase">';
        echo $articleFiltred['marque'];
        echo '</p>';
        echo '</div>';
        
        if ($_SESSION) {
            echo '<div>';
            echo '<form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">';
            echo '<input type="hidden" name="id_' . $articleFiltred['genre'] . '" value="' . $articleFiltred['id'] . '">';
            echo '<input type="hidden" name="id_user" value="' . $_SESSION['id_user'] . '">';
            echo '<input type="hidden" name="genre" value="' . $articleFiltred['genre'] . '">';
            echo '<input type="hidden" name="date_ajout_favoris" value="' . date("d/m/y") . '">';
            
            if ($_SESSION[$articleFiltred['genre']]) {
                foreach ($_SESSION[$articleFiltred['genre']] as $idTab) {
                    if (in_array($articleFiltred['id'], $idTab)) {
                        echo '<button class="favoris-button" type="submit">';
                        echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/liked.png">';
                        echo '</button>';
                    } else {
                        echo '<button class="favoris-button" type="submit">';
                        echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
                        echo '</button>';
                    }
                }
            } else {
                echo '<button class="favoris-button" type="submit">';
                echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
                echo '</button>';
            }
            
            echo '</form>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
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

//CREE UN TABLEAU AVEC LES TYPES D'EQUIPEMENT POUR LES FILTRES
function isTypeEquipement($filtre)
{
    $typeEquipementRepo = new TypeEquipementRepository;
    $allTypeEquipements = $typeEquipementRepo->getAllTypeEquipement();

    $nomType = [];

    foreach ($allTypeEquipements as $type)
    {
        $nomType[] = $type->getNomTypeEquipement();
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