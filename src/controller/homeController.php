<?php

require_once('src/model/User.php');
require_once('src/model/Favoris.php');

require_once('src/model/Produit/Canne.php');
require_once('src/model/Produit/Moulinet.php');
require_once('src/model/Produit/Hamecon.php');
require_once('src/model/Produit/Leurre.php');
require_once('src/model/Produit/Ligne.php');
require_once('src/model/Produit/Equipement.php');
require_once('src/model/Produit/Plomb.php');
require_once('src/model/Produit/Appat.php');

require_once('src/model/Marque.php');
require_once('src/model/Categorie.php');
require_once('src/model/Commande.php');

require_once('src/model/Type/TypeCanne.php');
require_once('src/model/Type/TypeMoulinet.php');
require_once('src/model/Type/TypeHamecon.php');
require_once('src/model/Type/TypeLeurre.php');
require_once('src/model/Type/TypeLigne.php');
require_once('src/model/Type/TypeEquipement.php');
require_once('src/model/Type/TypePlomb.php');
require_once('src/model/Type/TypeAppat.php');

// PAGE D'ACCUEIL
function home()
{
    $produitRepo = new ProduitRepository();
    $produits = $produitRepo->getAllProducts();
    $promoProduits = $produitRepo->getAllPromoProducts();

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();

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

                if($user)
                {
                    if (password_verify($password, $user->getPasswordUser())) 
                    {
                        if($user->getActifUser() == 1)
                        {
                            $_SESSION['id_role'] = $user->getIdRole();
                            $_SESSION['id_user'] = $user->getIdUser();
                            $_SESSION['prenom_user'] = $user->getNameUser();
                            $_SESSION['nom_user'] = $user->getLastnameUser();
                            $_SESSION['email_user'] = $user->getEmailUser();
            
                            header('location: /home');
                        }
                        else
                        {
                            $_SESSION['messageError'] = "Votre compte n'est pas activé.";
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
                                $hash = password_hash($user->getPasswordUser(), PASSWORD_DEFAULT);
                                $user->setPasswordUser($hash);

                                $token = bin2hex(random_bytes(25));
                                $user->setTokenUser($token);

                                $userRepository->insertUser($user);

                                $id_user = $userRepository->getUserByToken($user->getTokenUser());
                                
                                require_once('src/config/mailActif.php');
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

function updateUser()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") 
    {
        if (
            isset($_POST['email_user']) && isset($_POST['prenom_user']) &&
            isset($_POST['nom_user']) && isset($_POST['pass_user']) &&
            isset($_POST['verifpass_user'])) 
        {
            
            $email = htmlspecialchars($_POST['email_user']);
            $prenom = htmlspecialchars($_POST['prenom_user']);
            $nom = htmlspecialchars($_POST['nom_user']);
            $password = htmlspecialchars($_POST['pass_user']);
            $verifPassword = htmlspecialchars($_POST['verifpass_user']);
    
            if($password !== $verifPassword)
            {
                echo "Les mots de passe ne correspondent pas.";
                exit;
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $userRepository = new UserRepository();
           
            $userRepository->updateUser($nom, $prenom, $email, $hash, $_SESSION['id_user']);

            $user = $userRepository->getUserById($_SESSION['id_user']);

            $_SESSION['id_role'] = $user->getIdRole();
            $_SESSION['id_user'] = $user->getIdUser();
            $_SESSION['prenom_user'] = $user->getNameUser();
            $_SESSION['nom_user'] = $user->getLastnameUser();
            $_SESSION['email_user'] = $user->getEmailUser();
    
            header('Location: /profil');
            exit;
        }
    }
}

function updateActif()
{
    if (isset($_GET['token']) && !empty($_GET['token']) && isset($_GET['id']) && !empty($_GET['id'])) 
    {
        $token = htmlspecialchars($_GET['token']);
        $id_user = htmlspecialchars($_GET['id']);

        $userRepo = new UserRepository();
        
        $verif = $userRepo->verifToken($token, $id_user);

        if($verif == true)
        {
            $userRepo->updateActif($id_user, $token);
            header('Location: /login');
            exit;
        }
        else
        {
            header('Location: /home');
        }
    }
    else
    {
        header('Location: /home');
    }
}


function passwordMail()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") 
    {
        if (!empty($_POST['email_user'])) 
        {
            $email_user = htmlspecialchars($_POST['email_user']);

            $userRepo = new UserRepository;

            $user = $userRepo->getUserByEmail($email_user);

            if($user != [])
            {
                $newToken = $userRepo->AddToken($user->getEmailUser());

                $user->setTokenUser($newToken);

                $token = $user->getTokenUser();

                $id = $user->getIdUser();

                include('src/config/mailPassword.php');
                header('location: /login');
            }
            else
            {
                echo 'Utilisateur inconnu';
            }
        }
        else
        {
            echo 'Rentrer une adresse e-mail';
        }
    }
    else
    {
        header('location: /home');
    }
}

function updatePasswordPage()
{
    if(!empty($_GET['token']) && !empty($_GET['id']))
    {
        $token = htmlspecialchars($_GET['token']);
        $id_user = htmlspecialchars($_GET['id']);

        $userRepo = new UserRepository;
        $verif = $userRepo->verifToken($token, $id_user);

        if($verif == true)
        {
            require_once('src/view/passwordPage.php');
        }
        else
        {
            header('location: /home');
        }
    }
    else
    {
        header('location: /home');
    }
}

function forgetPassPage()
{
    if(!isset($_SESSION))
    {
        require_once('src/view/emailPage.php');
    }
    else
    {
        header('location: /home');
    }
}

function updatePassword()
{
    if ($_POST) 
    {
        $token = htmlspecialchars($_POST['token_user']);
        $id = htmlspecialchars($_POST['id_user']);

        if (!empty($_POST['pass_user']) && !empty($_POST['verifpass_user']))
        {
            $userRepository = new UserRepository();

            if ($userRepository->verifyPassword($_POST['pass_user']))
            {
                $password = htmlspecialchars($_POST['pass_user']);
                $verifPassword = htmlspecialchars($_POST['verifpass_user']);

                if($password !== $verifPassword)
                {
                    $_SESSION['messageError'] = "Les mots de passe ne sont pas identiques.";
                    header('Location: /newPass/token=' . $token . '&id='.$id.'');
                }

                $hash = password_hash($password, PASSWORD_DEFAULT);

                $userRepository->updatePassword($hash, $token);

                header('Location: /login');
                exit;
            }
            else 
            {
                $_SESSION['messageError'] = "Votre mot de passe doit contenir au minimum 8 caractères avec au moins une lettre minuscule et une lettre majuscule et un chiffre.";
                header('Location: /newPass/token=' . $token . '&id='.$id.'');
            }
        }
        else 
        {
            $_SESSION['messageError'] = "Un des champs est vide.";
            header('Location: /newPass/token=' . $token . '&id='.$id.'');
        }
    }
    else
    {
        header('location: /home');
    }
}

//TRAITEMENT DE DECONNEXION
function disconnectUser()
{
    session_destroy();
    header('location: /home');
}

function profilPage()
{
    if($_SESSION['id_user'])
    {
        $id_user = $_SESSION['id_user'];

        $commandeRepo = new CommandeRepository;

        $commandes = $commandeRepo->getAllUserCommande($_SESSION['id_user']);
       
        require_once('src/view/profilPage.php');
    }
    else
    {
        header('location: /login');
    }
}

//AFFICHAGE DE LA PAGE PANIER
function pagePanier()
{
    if(!empty($_SESSION['id_user']))
    {
        require_once('src/view/pagePanier.php');
    }
    else
    {
        header('location: /login');
    }
}

//AFFICHAGE DE LA PAGE COMMANDE
function pageCommande()
{
    if(!empty($_GET['numero']))
    {
        if($_SESSION['id_user'])
        {
            $numero = htmlspecialchars($_GET['numero']);
            $id_user = $_SESSION['id_user'];

            $commandeRepo = new CommandeRepository;

            $verif = $commandeRepo->verifNumero($id_user, $numero);

            if($verif === true)
            {
                $commande = $commandeRepo->getUserCommande($_SESSION['id_user'], $_GET['numero']);
                $resume = json_decode($commande->getResumeCommande());
                $dateCommande = $commande->getDateCommande();
                $totalPrice = 0;

                foreach ($resume as $item) 
                {
                    $totalPrice += $item->quantity * $item->price;
                }

                $date = date('d-m-Y H:i', strtotime($dateCommande));

                require_once('src/view/pageCommande.php');
            }
            else
            {
                header('location: /home');
            }
        }
        else
        {
            header('location: /login');
        }
    }
    else
    {
        header('location: /home');
    }
}

function addCommande() 
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") 
    {   
        function generateRandomString($length) 
        {
            $bytes = random_bytes($length);
            return bin2hex($bytes);
        }

        $requestData = json_decode(file_get_contents("php://input"), true);
        $resumeCommande = json_encode($requestData);

        $numero = generateRandomString(10);
        $date = date("Y-m-d H:i:s");
        $id_user = $_SESSION['id_user'];

        $commande = new Commande;

        $commande->setResumeCommande($resumeCommande);
        $commande->setNumeroCommande($numero);
        $commande->setDateCommande($date);
        $commande->setIdUser($id_user);

        $commandeRepo = new CommandeRepository;

        $commandeRepo->addCommande($commande);
        
        
        
        echo json_encode(['success' => true, 'numero' => $numero]);
    }
    else 
    {
        http_response_code(405);
        header('Content-Type: application/json');
        json_encode(['error' => 'Method Not Allowed']);
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
        
        require('src/view/searchPage.php');
    }
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
    $produitRepo = new ProduitRepository();
    $promoProduits = $produitRepo->getAllPromoProducts();

    include('src/view/promoPage.php');
}

//AFFICHAGE DE LA PAGE D'ARTICLE EN FONCTION DE LA CATEGORIE EN GET
function viewPageCategorie()
{
    $produitRepo = new ProduitRepository();
    $marqueRepo = new MarqueRepository;
    $categorieRepo = new CategorieRepository;

    if ($categorieRepo->existCategorie($_GET['categorie'])) 
    {
        $categorie = $categorieRepo->existCategorie($_GET['categorie']);
    } 
    else 
    {
        header('location: /home');
    }

    foreach ($categorie as $idCategories) 
    {
        $idCategorie = $idCategories->getIdCategorie();
    }

    $produits = $produitRepo->getAllProductsByCategory($idCategorie);

    $marques = $marqueRepo->getAllMarque();

    include('src/view/articlePageByCat.php');
}

//AFFICHAGE DE LA PAGE D'ARTICLE EN FONCTION DE LA MARQUE EN GET
function viewPageMarque()
{
    $produitRepo = new ProduitRepository();
    $marqueRepo = new MarqueRepository;
    $categorieRepo = new CategorieRepository;

    if ($marqueRepo->existMarque($_GET['marque'])) 
    {
        $marque = $marqueRepo->existMarque($_GET['marque']);
    } 
    else 
    {
        header('location: /home');
    }

    foreach ($marque as $idMarques) 
    {
        $idMarque = $idMarques->getIdMarque();
    }

    $produits = $produitRepo->getAllProductsByMarque($idMarque);

    $marques = $marqueRepo->getAllMarque();

    include('src/view/articlePageByMarque.php');
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

    $typePlombRepo = new TypePlombRepository;
    $allTypes[] = $typePlombRepo->getAllTypePlomb();

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

// //TRAITEMENT POUR LES FILTRE DE LA PAGE DE TOUS LES ARTICLES
// function filtre()
// {
//     $articles = getLastArticles();

//     $filtres = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

//     $articlesFiltres = [];

//     $genresFiltres = [];
//     $marquesFiltres = [];
//     $categoriesFiltres = [];

//     foreach ($filtres as $filtre) 
//     {
//         if (isGenre($filtre)) 
//         {
//             $genresFiltres[] = $filtre;
//         } 
//         elseif (isMarque($filtre)) 
//         {
//             $marquesFiltres[] = $filtre;
//         } 
//         elseif (isCategorie($filtre)) 
//         {
//             $categoriesFiltres[] = $filtre;
//         }
//     }

//     $isGenresSelected = !empty($genresFiltres);

//     $isMarquesSelected = !empty($marquesFiltres);

//     $isCategoriesSelected = !empty($categoriesFiltres);


//     foreach ($articles as $article) 
//     {
//         $isGenreMatch = in_array($article['genre'], $genresFiltres) || !$isGenresSelected;

//         $isMarqueMatch = in_array($article['marque'], $marquesFiltres) || !$isMarquesSelected;

//         $isCategorieMatch = in_array($article['categorie'], $categoriesFiltres) || !$isCategoriesSelected;

//         if ($isGenreMatch && $isMarqueMatch && $isCategorieMatch) 
//         {
//             $articlesFiltres[] = $article;
//         }
//     }

//     foreach ($articlesFiltres as $articleFiltred) 
//     {
//         echo '<div class="w-56">';
//         echo '<a href="/' . $articleFiltred['genre'] . 'Page/' . $articleFiltred['id'] . '">';
//         echo '<div class="w-56">';
//         echo '<img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/' . $articleFiltred['image'] . '"/>';
//         echo '</div>';
//         echo '</a>';
//         echo '<div class="flex justify-center gap-10 py-3">';
//         echo '<div>';
//         echo '<p class="text-s md:text-lg">';
//         echo $articleFiltred['nom'];
//         echo '</p>';
//         echo '<p class="text-xs md:text-sm uppercase">';
//         echo $articleFiltred['marque'];
//         echo '</p>';
//         echo '</div>';
        
//         if ($_SESSION) {
//             echo '<div>';
//             echo '<form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">';
//             echo '<input type="hidden" name="id_' . $articleFiltred['genre'] . '" value="' . $articleFiltred['id'] . '">';
//             echo '<input type="hidden" name="id_user" value="' . $_SESSION['id_user'] . '">';
//             echo '<input type="hidden" name="genre" value="' . $articleFiltred['genre'] . '">';
//             echo '<input type="hidden" name="date_ajout_favoris" value="' . date("d/m/y") . '">';
            
//             if ($_SESSION[$articleFiltred['genre']]) {
//                 foreach ($_SESSION[$articleFiltred['genre']] as $idTab) {
//                     if (in_array($articleFiltred['id'], $idTab)) {
//                         echo '<button class="favoris-button" type="submit">';
//                         echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/liked.png">';
//                         echo '</button>';
//                     } else {
//                         echo '<button class="favoris-button" type="submit">';
//                         echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
//                         echo '</button>';
//                     }
//                 }
//             } else {
//                 echo '<button class="favoris-button" type="submit">';
//                 echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
//                 echo '</button>';
//             }
            
//             echo '</form>';
//             echo '</div>';
//         }
        
//         echo '</div>';
//         echo '</div>';
//     }
    
// }

// //TRAITEMENT POUR LES FILTRE DE LA PAGE DE TOUS LES ARTICLES EN PROMOTION
// function filtrePromo()
// {
//     $articles = getPromoArticles();

//     $filtres = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

//     $articlesFiltres = [];

//     $genresFiltres = [];
//     $marquesFiltres = [];
//     $categoriesFiltres = [];

//     foreach ($filtres as $filtre) 
//     {
//         if (isGenre($filtre)) 
//         {
//             $genresFiltres[] = $filtre;
//         } 
//         elseif (isMarque($filtre)) 
//         {
//             $marquesFiltres[] = $filtre;
//         } 
//         elseif (isCategorie($filtre)) 
//         {
//             $categoriesFiltres[] = $filtre;
//         }
//     }

//     $isGenresSelected = !empty($genresFiltres);

//     $isMarquesSelected = !empty($marquesFiltres);

//     $isCategoriesSelected = !empty($categoriesFiltres);


//     foreach ($articles as $article) 
//     {
//         $isGenreMatch = in_array($article['genre'], $genresFiltres) || !$isGenresSelected;

//         $isMarqueMatch = in_array($article['marque'], $marquesFiltres) || !$isMarquesSelected;

//         $isCategorieMatch = in_array($article['categorie'], $categoriesFiltres) || !$isCategoriesSelected;

//         if ($isGenreMatch && $isMarqueMatch && $isCategorieMatch) 
//         {
//             $articlesFiltres[] = $article;
//         }
//     }

//     foreach ($articlesFiltres as $articleFiltred) {
//         echo '<div class="w-56">';
//         echo '<a href="/' . $articleFiltred['genre'] . 'Page/' . $articleFiltred['id'] . '">';
//         echo '<div class="w-56">';
//         echo '<img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/' . $articleFiltred['image'] . '"/>';
//         echo '</div>';
//         echo '</a>';
//         echo '<div class="flex justify-center gap-10 py-3">';
//         echo '<div>';
//         echo '<p class="text-s md:text-lg">';
//         echo $articleFiltred['nom'];
//         echo '</p>';
//         echo '<p class="text-xs md:text-sm uppercase">';
//         echo $articleFiltred['marque'];
//         echo '</p>';
//         echo '</div>';
        
//         if ($_SESSION) {
//             echo '<div>';
//             echo '<form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">';
//             echo '<input type="hidden" name="id_' . $articleFiltred['genre'] . '" value="' . $articleFiltred['id'] . '">';
//             echo '<input type="hidden" name="id_user" value="' . $_SESSION['id_user'] . '">';
//             echo '<input type="hidden" name="genre" value="' . $articleFiltred['genre'] . '">';
//             echo '<input type="hidden" name="date_ajout_favoris" value="' . date("d/m/y") . '">';
            
//             if ($_SESSION[$articleFiltred['genre']]) {
//                 foreach ($_SESSION[$articleFiltred['genre']] as $idTab) {
//                     if (in_array($articleFiltred['id'], $idTab)) {
//                         echo '<button class="favoris-button" type="submit">';
//                         echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/liked.png">';
//                         echo '</button>';
//                     } else {
//                         echo '<button class="favoris-button" type="submit">';
//                         echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
//                         echo '</button>';
//                     }
//                 }
//             } else {
//                 echo '<button class="favoris-button" type="submit">';
//                 echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
//                 echo '</button>';
//             }
            
//             echo '</form>';
//             echo '</div>';
//         }
        
//         echo '</div>';
//         echo '</div>';
//     }
    
// }

// //TRAITEMENT POUR LES FILTRES DES PAGES D'ARTICLES EN FONCTION DE LA CATEGORIE PRIT EN GET
// function filtrePageCate()
// {
//     $allCanneRepo = new CanneRepository;
//     $allMoulinetRepo = new MoulinetRepository;
//     $allHameconRepo = new HameconRepository;
//     $allLeurreRepo = new LeurreRepository;
//     $allLigneRepo = new LigneRepository;
//     $allEquipementRepo = new EquipementRepository;
//     $allPlombRepo = new PlombRepository;
//     $allAppatRepo = new AppatRepository;

//     $idCategorie = getIdCategorie();

//     $articles = [];

//     $articles['cannes'] = $allCanneRepo->getCanneByCategorie($idCategorie);
//     $articles['moulinets'] = $allMoulinetRepo->getMoulinetByCategorie($idCategorie);
//     $articles['hamecons'] = $allHameconRepo->getHameconByCategorie($idCategorie);
//     $articles['leurres'] = $allLeurreRepo->getLeurreByCategorie($idCategorie);
//     $articles['equipements'] = $allEquipementRepo->getEquipementByCategorie($idCategorie);
//     $articles['lignes'] = $allLigneRepo->getLigneByCategorie($idCategorie);
//     $articles['appats'] = $allAppatRepo->getAppatByCategorie($idCategorie);
//     $articles['plombs'] = $allPlombRepo->getPlombByCategorie($idCategorie);

//     $combinedArticles = combinedArticle($articles);

//     $filtres = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

//     $articlesFiltres = [];

//     $genresFiltres = [];
//     $marquesFiltres = [];
//     $categoriesFiltres = [];

//     foreach ($filtres as $filtre) 
//     {
//         if (isGenre($filtre)) 
//         {
//             $genresFiltres[] = $filtre;
//         } 
//         elseif (isMarque($filtre)) 
//         {
//             $marquesFiltres[] = $filtre;
//         } 
//         elseif (isCategorie($filtre)) 
//         {
//             $categoriesFiltres[] = $filtre;
//         }
//     }

//     $isGenresSelected = !empty($genresFiltres);

//     $isMarquesSelected = !empty($marquesFiltres);

//     $isCategoriesSelected = !empty($categoriesFiltres);

//     foreach ($combinedArticles as $article) 
//     {
//         if (($article != ['']))
//         {
//             $isGenreMatch = in_array($article['genre'], $genresFiltres) || !$isGenresSelected;

//             $isMarqueMatch = in_array($article['marque'], $marquesFiltres) || !$isMarquesSelected;

//             $isCategorieMatch = in_array($article['categorie'], $categoriesFiltres) || !$isCategoriesSelected;

//             if ($isGenreMatch && $isMarqueMatch && $isCategorieMatch) 
//             {
//                 $articlesFiltres[] = $article;
//             }
//         } 
//         else 
//         {
//             echo '';
//         }
//     }

//     foreach ($articlesFiltres as $articleFiltred) 
//     {
//         echo '<div class="w-56">';
//         echo '<a href="/' . $articleFiltred['genre'] . 'Page/' . $articleFiltred['id'] . '">';
//         echo '<div class="w-56">';
//         echo '<img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/' . $articleFiltred['image'] . '"/>';
//         echo '</div>';
//         echo '</a>';
//         echo '<div class="flex justify-center gap-10 py-3">';
//         echo '<div>';
//         echo '<p class="text-s md:text-lg">';
//         echo $articleFiltred['nom'];
//         echo '</p>';
//         echo '<p class="text-xs md:text-sm uppercase">';
//         echo $articleFiltred['marque'];
//         echo '</p>';
//         echo '</div>';
        
//         if ($_SESSION) {
//             echo '<div>';
//             echo '<form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">';
//             echo '<input type="hidden" name="id_' . $articleFiltred['genre'] . '" value="' . $articleFiltred['id'] . '">';
//             echo '<input type="hidden" name="id_user" value="' . $_SESSION['id_user'] . '">';
//             echo '<input type="hidden" name="genre" value="' . $articleFiltred['genre'] . '">';
//             echo '<input type="hidden" name="date_ajout_favoris" value="' . date("d/m/y") . '">';
            
//             if ($_SESSION[$articleFiltred['genre']]) {
//                 foreach ($_SESSION[$articleFiltred['genre']] as $idTab) {
//                     if (in_array($articleFiltred['id'], $idTab)) {
//                         echo '<button class="favoris-button" type="submit">';
//                         echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/liked.png">';
//                         echo '</button>';
//                     } else {
//                         echo '<button class="favoris-button" type="submit">';
//                         echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
//                         echo '</button>';
//                     }
//                 }
//             } else {
//                 echo '<button class="favoris-button" type="submit">';
//                 echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
//                 echo '</button>';
//             }
            
//             echo '</form>';
//             echo '</div>';
//         }
        
//         echo '</div>';
//         echo '</div>';
//     }
    
// }

// //TRAITEMENT POUR LES FILTRES DES ARTICLES EN FONCTION DE LA MARQUE PRIT EN GET
// function filtrePageMarque()
// {
//     $allCanneRepo = new CanneRepository;
//     $allMoulinetRepo = new MoulinetRepository;
//     $allHameconRepo = new HameconRepository;
//     $allLeurreRepo = new LeurreRepository;
//     $allLigneRepo = new LigneRepository;
//     $allEquipementRepo = new EquipementRepository;
//     $allPlombRepo = new PlombRepository;
//     $allAppatRepo = new AppatRepository;

//     $idMarque = getIdMarque();

//     $articles = [];

//     $articles['cannes'] = $allCanneRepo->getCanneByMarque($idMarque);
//     $articles['moulinets'] = $allMoulinetRepo->getMoulinetByMarque($idMarque);
//     $articles['hamecons'] = $allHameconRepo->getHameconByMarque($idMarque);
//     $articles['leurres'] = $allLeurreRepo->getLeurreByMarque($idMarque);
//     $articles['equipements'] = $allEquipementRepo->getEquipementByMarque($idMarque);
//     $articles['lignes'] = $allLigneRepo->getLigneByMarque($idMarque);
//     $articles['appats'] = $allAppatRepo->getAppatByMarque($idMarque);
//     $articles['plombs'] = $allPlombRepo->getPlombByMarque($idMarque);

//     $combinedArticles = combinedArticle($articles);

//     $filtres = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

//     $articlesFiltres = [];

//     $genresFiltres = [];
//     $marquesFiltres = [];
//     $categoriesFiltres = [];

//     foreach ($filtres as $filtre) 
//     {
//         if (isGenre($filtre)) 
//         {
//             $genresFiltres[] = $filtre;
//         } 
//         elseif (isMarque($filtre)) 
//         {
//             $marquesFiltres[] = $filtre;
//         } 
//         elseif (isCategorie($filtre)) 
//         {
//             $categoriesFiltres[] = $filtre;
//         }
//     }

//     $isGenresSelected = !empty($genresFiltres);

//     $isMarquesSelected = !empty($marquesFiltres);

//     $isCategoriesSelected = !empty($categoriesFiltres);

//     foreach ($combinedArticles as $article) 
//     {
//         if (($article != ['']))
//         {
//             $isGenreMatch = in_array($article['genre'], $genresFiltres) || !$isGenresSelected;

//             $isMarqueMatch = in_array($article['marque'], $marquesFiltres) || !$isMarquesSelected;

//             $isCategorieMatch = in_array($article['categorie'], $categoriesFiltres) || !$isCategoriesSelected;

//             if ($isGenreMatch && $isMarqueMatch && $isCategorieMatch) 
//             {
//                 $articlesFiltres[] = $article;
//             }
//         } 
//         else 
//         {
//             echo '';
//         }
//     }

//     foreach ($articlesFiltres as $articleFiltred) 
//     {
//         echo '<div class="w-56">';
//         echo '<a href="/' . $articleFiltred['genre'] . 'Page/' . $articleFiltred['id'] . '">';
//         echo '<div class="w-56">';
//         echo '<img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/' . $articleFiltred['image'] . '"/>';
//         echo '</div>';
//         echo '</a>';
//         echo '<div class="flex justify-center gap-10 py-3">';
//         echo '<div>';
//         echo '<p class="text-s md:text-lg">';
//         echo $articleFiltred['nom'];
//         echo '</p>';
//         echo '<p class="text-xs md:text-sm uppercase">';
//         echo $articleFiltred['marque'];
//         echo '</p>';
//         echo '</div>';
        
//         if ($_SESSION) 
//         {
//             echo '<div>';
//             echo '<form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">';
//             echo '<input type="hidden" name="id_' . $articleFiltred['genre'] . '" value="' . $articleFiltred['id'] . '">';
//             echo '<input type="hidden" name="id_user" value="' . $_SESSION['id_user'] . '">';
//             echo '<input type="hidden" name="genre" value="' . $articleFiltred['genre'] . '">';
//             echo '<input type="hidden" name="date_ajout_favoris" value="' . date("d/m/y") . '">';
            
//             if ($_SESSION[$articleFiltred['genre']]) {
//                 foreach ($_SESSION[$articleFiltred['genre']] as $idTab) {
//                     if (in_array($articleFiltred['id'], $idTab)) {
//                         echo '<button class="favoris-button" type="submit">';
//                         echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/liked.png">';
//                         echo '</button>';
//                     } else {
//                         echo '<button class="favoris-button" type="submit">';
//                         echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
//                         echo '</button>';
//                     }
//                 }
//             } else {
//                 echo '<button class="favoris-button" type="submit">';
//                 echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
//                 echo '</button>';
//             }
            
//             echo '</form>';
//             echo '</div>';
//         }
        
//         echo '</div>';
//         echo '</div>';
//     }
// }

// //TRAITEMENT POUR LES FILTRES DES PAGES DE CANNE
// function filtreCanne()
// {
//     $canneRepo = new CanneRepository;
//     $articlesCanne = $canneRepo->getAllCanne();

//     foreach ($articlesCanne as $canne) 
//     {
//         if ($canne) 
//         {
//             $imgCanneRepo = new ImageCanneRepository;
//             $imgCannes = $imgCanneRepo->getImageByCanne($canne->getIdCanne());
//             $allCannes[] = 
//             [
//                 'genre' => 'canne',
//                 'id' => $canne->getIdCanne(),
//                 'nom' => $canne->getNomCanne(),
//                 'image' => $imgCannes->getNomImageCanne(),
//                 'marque' => $canne->getMarqueCanne(),
//                 'type' => $canne->getTypeCanne(),
//                 'categorie' => $canne->getCategorieCanne(),
//                 'longueur' => $canne->getLongueurCanne(),
//                 'poids' => $canne->getPoidsCanne(),
//             ];
//         } 
//         else 
//         {
//             $allCannes[] = [''];
//         }
//     }

//     $filtresCanne = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

//     $articlesFiltresCanne = [];

//     $typesFiltresCanne = [];
//     $marquesFiltresCanne = [];
//     $categoriesFiltresCanne = [];
//     $longueursFiltresCanne = [];
//     $longueurFiltre = null;
//     $poidsFiltresCanne = [];
//     $poidFiltre = null;

//     foreach ($filtresCanne as $filtreCanne) 
//     {
//         if (isCategorie($filtreCanne))
//         {
//             $categoriesFiltresCanne[] = $filtreCanne;
//         } 
//         elseif (isMarque($filtreCanne)) 
//         {
//             $marquesFiltresCanne[] = $filtreCanne;
//         } 
//         elseif (isTypeCanne($filtreCanne)) 
//         {
//             $typesFiltresCanne[] = $filtreCanne;
//         }
//         elseif (isLongueurCanne($filtreCanne)) 
//         {
//             $longueursFiltresCanne[] = $filtreCanne;
//         }
//         elseif (isPoidsCanne($filtreCanne)) 
//         {
//             $poidsFiltresCanne[] = $filtreCanne;
//         }
//     }

//     $isTypesFiltresCanne = !empty($typesFiltresCanne);

//     $isMarquesSelected = !empty($marquesFiltresCanne);

//     $isCategoriesSelected = !empty($categoriesFiltresCanne);

//     foreach ($allCannes as $article) 
//     {
//         $isTypeMatch = in_array($article['type'], $typesFiltresCanne) || !$isTypesFiltresCanne;

//         $isMarqueMatch = in_array($article['marque'], $marquesFiltresCanne) || !$isMarquesSelected;

//         $isCategorieMatch = in_array($article['categorie'], $categoriesFiltresCanne) || !$isCategoriesSelected;

//         $isLongueurMatch = true;

//         $isPoidMatch = true;

//         if ($longueursFiltresCanne) 
//         {
//             $isLongueurMatch = false;
//             foreach ($longueursFiltresCanne as $longueurFiltre) 
//             {
//                 $longueurArticle = $article['longueur'];
//                 $longueurRange = explode('-', $longueurFiltre);
//                 $longueurMin = intval($longueurRange[0]);
//                 $longueurMax = intval($longueurRange[1]);
//                 if ($longueurArticle >= $longueurMin && $longueurArticle <= $longueurMax) 
//                 {
//                     $isLongueurMatch = true;
//                     break;
//                 }
//             }
//         }

//         if ($poidsFiltresCanne) 
//         {
//             $isPoidMatch = false;
//             foreach ($poidsFiltresCanne as $poidFiltre) 
//             {
//                 $poidArticle = $article['poids'];
//                 $poidRange = explode('-', $poidFiltre);
//                 $poidMin = intval($poidRange[0]);
//                 $poidMax = intval($poidRange[1]);
//                 if ($poidArticle >= $poidMin && $poidArticle <= $poidMax) 
//                 {
//                     $isPoidMatch = true;
//                     break;
//                 }
//             }
//         }


//         if ($isTypeMatch && $isMarqueMatch && $isCategorieMatch && $isLongueurMatch && $isPoidMatch) 
//         {
//             $articlesFiltresCanne[] = $article;
//         }
//     }

//     foreach ($articlesFiltresCanne as $articleFiltred) 
//     {
//         echo '<div class="w-56">';
//         echo '<a href="/' . $articleFiltred['genre'] . 'Page/' . $articleFiltred['id'] . '">';
//         echo '<div class="w-56">';
//         echo '<img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/' . $articleFiltred['image'] . '"/>';
//         echo '</div>';
//         echo '</a>';
//         echo '<div class="flex justify-center gap-10 py-3">';
//         echo '<div>';
//         echo '<p class="text-s md:text-lg">';
//         echo $articleFiltred['nom'];
//         echo '</p>';
//         echo '<p class="text-xs md:text-sm uppercase">';
//         echo $articleFiltred['marque'];
//         echo '</p>';
//         echo '</div>';
        
//         if ($_SESSION) {
//             echo '<div>';
//             echo '<form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">';
//             echo '<input type="hidden" name="id_' . $articleFiltred['genre'] . '" value="' . $articleFiltred['id'] . '">';
//             echo '<input type="hidden" name="id_user" value="' . $_SESSION['id_user'] . '">';
//             echo '<input type="hidden" name="genre" value="' . $articleFiltred['genre'] . '">';
//             echo '<input type="hidden" name="date_ajout_favoris" value="' . date("d/m/y") . '">';
            
//             if ($_SESSION[$articleFiltred['genre']]) {
//                 foreach ($_SESSION[$articleFiltred['genre']] as $idTab) {
//                     if (in_array($articleFiltred['id'], $idTab)) {
//                         echo '<button class="favoris-button" type="submit">';
//                         echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/liked.png">';
//                         echo '</button>';
//                     } else {
//                         echo '<button class="favoris-button" type="submit">';
//                         echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
//                         echo '</button>';
//                     }
//                 }
//             } else {
//                 echo '<button class="favoris-button" type="submit">';
//                 echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
//                 echo '</button>';
//             }
            
//             echo '</form>';
//             echo '</div>';
//         }
        
//         echo '</div>';
//         echo '</div>';
//     }
    
// }

// //TRAITEMENT POUR LES FILTRES DES PAGES D'EQUIPEMENT
// function filtreEquipement()
// {
//     $equipementRepo = new EquipementRepository;
//     $articlesEquipement = $equipementRepo->getAllEquipement();

//     foreach ($articlesEquipement as $equipement) 
//     {
//         if ($equipement) 
//         {
//             $imgEquipementRepo = new ImageEquipementRepository;
//             $imgEquipements = $imgEquipementRepo->getImageByEquipement($equipement->getIdEquipement());
//             $allEquipements[] = 
//             [
//                 'genre' => 'equipement',
//                 'id' => $equipement->getIdEquipement(),
//                 'nom' => $equipement->getNomEquipement(),
//                 'image' => $imgEquipements->getNomImageEquipement(),
//                 'marque' => $equipement->getMarqueEquipement(),
//                 'type' => $equipement->getTypeEquipement(),
//                 'categorie' => $equipement->getCategorieEquipement(),
//                 'detail' => $equipement->getDetailEquipement(),
//             ];
//         }
//         else 
//         {
//             $allEquipements[] = [''];
//         }
//     }

//     $filtresEquipement = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

//     $articlesFiltresEquipement = [];

//     $typesFiltresEquipement = [];
//     $marquesFiltresEquipement = [];
//     $categoriesFiltresEquipement = [];

//     foreach ($filtresEquipement as $filtreEquipement) 
//     {
//         if (isCategorie($filtreEquipement))
//         {
//             $categoriesFiltresEquipement[] = $filtreEquipement;
//         } 
//         elseif (isMarque($filtreEquipement)) 
//         {
//             $marquesFiltresEquipement[] = $filtreEquipement;
//         } 
//         elseif (isTypeEquipement($filtreEquipement)) 
//         {
//             $typesFiltresEquipement[] = $filtreEquipement;
//         }
//     }

//     $isTypesFiltresEquipement = !empty($typesFiltresEquipement);

//     $isMarquesSelected = !empty($marquesFiltresEquipement);

//     $isCategoriesSelected = !empty($categoriesFiltresEquipement);

//     foreach ($allEquipements as $article) 
//     {
//         $isTypeMatch = in_array($article['type'], $typesFiltresEquipement) || !$isTypesFiltresEquipement;

//         $isMarqueMatch = in_array($article['marque'], $marquesFiltresEquipement) || !$isMarquesSelected;

//         $isCategorieMatch = in_array($article['categorie'], $categoriesFiltresEquipement) || !$isCategoriesSelected;

//         $isLongueurMatch = true;

//         $isPoidMatch = true;

//         if ($isTypeMatch && $isMarqueMatch && $isCategorieMatch && $isLongueurMatch && $isPoidMatch) 
//         {
//             $articlesFiltresEquipement[] = $article;
//         }
//     }

//     foreach ($articlesFiltresEquipement as $articleFiltred) 
//     {
//         echo '<div class="w-56">';
//         echo '<a href="/' . $articleFiltred['genre'] . 'Page/' . $articleFiltred['id'] . '">';
//         echo '<div class="w-56">';
//         echo '<img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/' . $articleFiltred['image'] . '"/>';
//         echo '</div>';
//         echo '</a>';
//         echo '<div class="flex justify-center gap-10 py-3">';
//         echo '<div>';
//         echo '<p class="text-s md:text-lg">';
//         echo $articleFiltred['nom'];
//         echo '</p>';
//         echo '<p class="text-xs md:text-sm uppercase">';
//         echo $articleFiltred['marque'];
//         echo '</p>';
//         echo '</div>';
        
//         if ($_SESSION) {
//             echo '<div>';
//             echo '<form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">';
//             echo '<input type="hidden" name="id_' . $articleFiltred['genre'] . '" value="' . $articleFiltred['id'] . '">';
//             echo '<input type="hidden" name="id_user" value="' . $_SESSION['id_user'] . '">';
//             echo '<input type="hidden" name="genre" value="' . $articleFiltred['genre'] . '">';
//             echo '<input type="hidden" name="date_ajout_favoris" value="' . date("d/m/y") . '">';
            
//             if ($_SESSION[$articleFiltred['genre']]) {
//                 foreach ($_SESSION[$articleFiltred['genre']] as $idTab) {
//                     if (in_array($articleFiltred['id'], $idTab)) {
//                         echo '<button class="favoris-button" type="submit">';
//                         echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/liked.png">';
//                         echo '</button>';
//                     } else {
//                         echo '<button class="favoris-button" type="submit">';
//                         echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
//                         echo '</button>';
//                     }
//                 }
//             } else {
//                 echo '<button class="favoris-button" type="submit">';
//                 echo '<img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">';
//                 echo '</button>';
//             }
            
//             echo '</form>';
//             echo '</div>';
//         }
        
//         echo '</div>';
//         echo '</div>';
//     }
    
// }

// //CREER UN TABLEAU DE GENRE POUR LES FILTRES
// function isGenre($filtre)
// {
//     $genres = ['canne', 'moulinet', 'leurre', 'hamecon', 'ligne', 'appat', 'equipement', 'plomb'];

//     return in_array($filtre, $genres);
// }

// //CREER UN TABLEAU DE CATEGORIE POUR LES FILTRES
// function isCategorie($filtre)
// {
//     $allCategories = getAllCategorie();

//     $nomCategorie = [];

//     foreach ($allCategories as $categorie) 
//     {
//         $nomCategorie[] = $categorie->getNomCategorie();
//     }

//     $categories = $nomCategorie;

//     return in_array($filtre, $categories);
// }

// //CREER UN TABLEAU DE MARQUE POUR LES FILTRES
// function isMarque($filtre)
// {
//     $allMarques = getAllMarque();

//     $nomMarque = [];

//     foreach ($allMarques as $marque) 
//     {
//         $nomMarque[] = $marque->getNomMarque();
//     }

//     $marques = $nomMarque;

//     return in_array($filtre, $marques);
// }

// //CREE UN TABLEAU AVEC LES TYPES DE CANNE POUR LES FILTRES
// function isTypeCanne($filtre)
// {
//     $typeCanneRepo = new TypeCanneRepository;
//     $allTypeCannes = $typeCanneRepo->getAllTypeCanne();

//     $nomType = [];

//     foreach ($allTypeCannes as $type) 
//     {
//         $nomType[] = $type->getNomTypeCanne();
//     }

//     $types = $nomType;

//     return in_array($filtre, $types);
// }

// //CREE UN TABLEAU AVEC LES TYPES D'EQUIPEMENT POUR LES FILTRES
// function isTypeEquipement($filtre)
// {
//     $typeEquipementRepo = new TypeEquipementRepository;
//     $allTypeEquipements = $typeEquipementRepo->getAllTypeEquipement();

//     $nomType = [];

//     foreach ($allTypeEquipements as $type)
//     {
//         $nomType[] = $type->getNomTypeEquipement();
//     }

//     $types = $nomType;

//     return in_array($filtre, $types);
// }

// //CREE UN TABLEAU AVEC LES LONGUEURS POUR LES FILTRES
// function isLongueurCanne($filtre)
// {
//     $pattern = '/^\d+m-\d+m$/';
//     return preg_match($pattern, $filtre);
// }

// //CREE UN TABLEAU AVEC LES POIDS POUR LES FILTRES
// function isPoidsCanne($filtre)
// {
//     $pattern = '/^\d+kg-\d+kg$/';
//     return preg_match($pattern, $filtre);
// }