<?php

require_once('src/model/User.php');

require_once('src/model/Produit/Canne.php');
require_once('src/model/Produit/Moulinet.php');
require_once('src/model/Produit/Hamecon.php');
require_once('src/model/Produit/Leurre.php');
require_once('src/model/Produit/Ligne.php');
require_once('src/model/Produit/Equipement.php');
require_once('src/model/Produit/Plomb.php');
require_once('src/model/Produit/Appat.php');
require_once('src/model/Produit/Autre.php');

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
require_once('src/model/Type/TypeAutre.php');

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

function notfound()
{
    require_once('src/view/404.php');
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
        header('location: /404');
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
        header('location: /404');
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
            
                            header('location: /accueil');
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
            header('location: /login');
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

            if (empty($user))
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
            header('Location: /404');
        }
    }
    else
    {
        header('Location: /404');
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
        header('location: /404');
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
            header('location: /404');
        }
    }
    else
    {
        header('location: /404');
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
        header('location: /404');
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

                header('Location: /404');
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
        header('location: /404');
    }
}

//TRAITEMENT DE DECONNEXION
function disconnectUser()
{
    session_destroy();
    header('location: /accueil');
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
                header('location: /404');
            }
        }
        else
        {
            header('location: /login');
        }
    }
    else
    {
        header('location: /404');
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

        include('src/config/mailCommande.php');

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
        $keywords = htmlspecialchars($_GET['keywords']);

        $produitRepo = new ProduitRepository;
        $produits = $produitRepo->getSearchProduit($keywords);

        $marqueRepo = new MarqueRepository;
        $marques = $marqueRepo->getAllMarque();

        $categorieRepo = new CategorieRepository;
        $categories = $categorieRepo->getAllCategorie();
        
        require('src/view/searchPage.php');
    }
    else
    {
        header('location: /404');
    }
}

function contactPage()
{
    if(!empty($_SESSION['id_user']))
    {
        require_once('src/view/contactPage.php');
    }
    else
    {
        header('location: /404');
    }
}

function Cookies()
{
    require_once('src/view/rgpd/Cookies.php');
}

function ConditionsGeneralesVente()
{
    require_once('src/view/rgpd/ConditionsGeneralesVente.php');
}

function PolitiqueConfidentialite()
{
    require_once('src/view/rgpd/PolitiqueConfidentialite.php');
}

function InformationsPersonnelles()
{
    require_once('src/view/rgpd/InformationsPersonnelles.php');
}

function sendMessage()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $nom = $_SESSION["nom_user"];
        $email = $_SESSION["email_user"];
        $message = $_POST["message"];
        
        include('src/config/mailMessage.php');
    }
    else
    {
        header('location: /404');
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
    $totalPromoProducts = $produitRepo->getTotalPromoProducts();

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();

    $productsPerPage = 20;

    $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;

    if(isset($_GET['page']))
    {
        if($_GET['page'] != 0)
        {
            $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
        }
        else
        {
            $currentpage = 1;
        }
    }
    
    $offset = ($currentpage - 1) * $productsPerPage;
    $promoProduits = $produitRepo->getPromoProductsPaginated($offset, $productsPerPage);
    $totalPages = ceil($totalPromoProducts / $productsPerPage);
    
    include('src/view/promoPage.php');
}

//AFFICHAGE DE LA PAGE D'ARTICLE EN FONCTION DE LA CATEGORIE EN GET
function viewPageCategorie()
{
    $produitRepo = new ProduitRepository;
    $marqueRepo = new MarqueRepository;
    $categorieRepo = new CategorieRepository;
    
    $marques = $marqueRepo->getAllMarque();

    if ($categorieRepo->existCategorie($_GET['categorie'])) 
    {
        $categorie = $categorieRepo->existCategorie($_GET['categorie']);
    }
    else
    {
        header('location: /404');
    }

    $totalCateProducts = $produitRepo->getTotalCateProducts($categorie->getIdCategorie());

    $productsPerPage = 20;

    $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;    

    if(isset($_GET['page']))
    {
        if($_GET['page'] != 0)
        {
            $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
        }
        else
        {
            $currentpage = 1;
        }
    }

    $offset = ($currentpage - 1) * $productsPerPage;
    $produits = $produitRepo->getCateProductsPaginated($offset, $productsPerPage, $categorie->getIdCategorie());

    $totalPages = ceil($totalCateProducts / $productsPerPage);

    include('src/view/articlePageByCat.php');
}

function filtrePageCate()
{
    $produitRepo = new ProduitRepository;

    $categorieRepo = new CategorieRepository;

    if ($categorieRepo->existCategorie($_GET['categorie']))
    {
        $categorie = $categorieRepo->existCategorie($_GET['categorie']);
    }
    else
    {
        header('location: /404');
    }

    $produit = $produitRepo->getAllProductsByCategory($categorie->getIdCategorie());

    $filtres = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

    $articlesFiltres = [];

    $genresFiltres = [];

    $marquesFiltres = [];

    foreach ($filtres as $filtre) 
    {
        if (isGenre($filtre)) 
        {
            $genresFiltres[] = $filtre;
        }
        elseif(isMarque($filtre)) 
        {
            $marquesFiltres[] = $filtre;
        }
    }

    $isGenresSelected = !empty($genresFiltres);

    $isMarquesSelected = !empty($marquesFiltres);

    foreach($produit as $article)
    {
        if (($article != ['']))
        {
            $isGenreMatch = in_array($article->getIdGenre(), $genresFiltres) || !$isGenresSelected;

            $isMarqueMatch = in_array($article->getNomMarque(), $marquesFiltres) || !$isMarquesSelected;
            
            if($isGenreMatch && $isMarqueMatch) 
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
            echo '<div class="flex flex-col justify-center">';
                echo '<div class="relative m-3 flex flex-wrap mx-auto justify-center ">';
                    echo '<div class="relative bg-white shadow-md p-2 my-3 rounded">';
                        echo '<div class="overflow-x-hidden rounded-2xl relative w-56 h-56">';
                            if ($articleFiltred->getPromoProduit() > 0) {
                                echo '<span class="original-number absolute text-[#fcfcfc] text-sm left-2 top-2 z-40 p-1 px-[9px] w-auto text-center font-semibold rounded-full bg-[#e8330d]">-' . $articleFiltred->getPromoProduit() . '%</span>';
                            }
                            echo '<img class="h-full rounded-2xl w-full object-cover" src="/' . $articleFiltred->getNomImage() . '">';
                            echo '<p class="absolute right-2 top-2 bg-[#426EC2] rounded-full p-2 cursor-pointer group">';
                                echo '<img class="add-to-cart-btn w-6 h-6" data-name="' . $articleFiltred->getNomProduit() . '" data-price="' . ($articleFiltred->getPromoProduit() > 0 ? $articleFiltred->getPrixPromoProduit() : $articleFiltred->getPrixProduit()) . '" data-image="' . $articleFiltred->getNomImage() . '" data-genre="' . $articleFiltred->getNomGenre() . '" data-id="' . $articleFiltred->getIdProduit() . '" src="/assets/img/site/addCart.png">';
                            echo '</p>';
                        echo '</div>';
                        echo '<div class="mt-4 pl-2 mb-2 flex justify-between ">';
                            echo '<a href="/' . $articleFiltred->getNomGenre() . 'Page/' . $articleFiltred->getIdProduit() . '">';
                                echo '<p class="text-lg font-semibold text-gray-900 mb-0">' . $articleFiltred->getNomProduit() . '</p>';
                                echo '<p class="text-lg text-gray-900 mb-0">' . $articleFiltred->getNomMarque() . '</p>';
                                echo '<div class="flex gap-10">';
                                    if ($articleFiltred->getPromoProduit() > 0) {
                                        echo '<p class="text-md text-gray-800 mt-0 line-through">' . number_format($articleFiltred->getPrixProduit(), 2, '.', '') . '€</p>';
                                        echo '<p class="number text-md text-gray-800 mt-0">' . number_format($articleFiltred->getPrixPromoProduit(), 2, '.', '') . '€</p>';
                                    } else {
                                        echo '<p class="text-md text-gray-800 mt-0">' . number_format($articleFiltred->getPrixProduit(), 2, '.', '') . '€</p>';
                                    }
                                echo '</div>';
                            echo '</a>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
}

function filtrePromo()
{
    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();

    $produitRepo = new ProduitRepository;

    $categorieRepo = new CategorieRepository;

    $produit = $produitRepo->getAllPromoProducts();

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
        elseif(isMarque($filtre)) 
        {
            $marquesFiltres[] = $filtre;
        }
        elseif(isCategorie($filtre)) 
        {
            $categoriesFiltres[] = $filtre;
        }
    }

    $isGenresSelected = !empty($genresFiltres);

    $isMarquesSelected = !empty($marquesFiltres);

    $isCategoriesSelected = !empty($categoriesFiltres);

    foreach($produit as $article) 
    {
        if (($article != ['']))
        {
            $isGenreMatch = in_array($article->getIdGenre(), $genresFiltres) || !$isGenresSelected;

            $isMarqueMatch = in_array($article->getNomMarque(), $marquesFiltres) || !$isMarquesSelected;

            $isCategorieMatch = in_array($article->getNomCategorie(), $categoriesFiltres) || !$isCategoriesSelected;
            
            if($isGenreMatch && $isMarqueMatch && $isCategorieMatch) 
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
            echo '<div class="flex flex-col justify-center">';
                echo '<div class="relative m-3 flex flex-wrap mx-auto justify-center ">';
                    echo '<div class="relative bg-white shadow-md p-2 my-3 rounded">';
                        echo '<div class="overflow-x-hidden rounded-2xl relative w-56 h-56">';
                            if ($articleFiltred->getPromoProduit() > 0) {
                                echo '<span class="original-number absolute text-[#fcfcfc] text-sm left-2 top-2 z-40 p-1 px-[9px] w-auto text-center font-semibold rounded-full bg-[#e8330d]">-' . $articleFiltred->getPromoProduit() . '%</span>';
                            }
                            echo '<img class="h-full rounded-2xl w-full object-cover" src="' . $articleFiltred->getNomImage() . '">';
                            echo '<p class="absolute right-2 top-2 bg-[#426EC2] rounded-full p-2 cursor-pointer group">';
                                echo '<img class="add-to-cart-btn w-6 h-6" data-name="' . $articleFiltred->getNomProduit() . '" data-price="' . ($articleFiltred->getPromoProduit() > 0 ? $articleFiltred->getPrixPromoProduit() : $articleFiltred->getPrixProduit()) . '" data-image="' . $articleFiltred->getNomImage() . '" data-genre="' . $articleFiltred->getNomGenre() . '" data-id="' . $articleFiltred->getIdProduit() . '" src="/assets/img/site/addCart.png">';
                            echo '</p>';
                        echo '</div>';
                        echo '<div class="mt-4 pl-2 mb-2 flex justify-between ">';
                            echo '<a href="/' . $articleFiltred->getNomGenre() . 'Page/' . $articleFiltred->getIdProduit() . '">';
                                echo '<p class="text-lg font-semibold text-gray-900 mb-0">' . $articleFiltred->getNomProduit() . '</p>';
                                echo '<p class="text-lg text-gray-900 mb-0">' . $articleFiltred->getNomMarque() . '</p>';
                                echo '<div class="flex gap-10">';
                                    if ($articleFiltred->getPromoProduit() > 0) {
                                        echo '<p class="text-md text-gray-800 mt-0 line-through">' . number_format($articleFiltred->getPrixProduit(), 2, '.', '') . '€</p>';
                                        echo '<p class="number text-md text-gray-800 mt-0">' . number_format($articleFiltred->getPrixPromoProduit(), 2, '.', '') . '€</p>';
                                    } else {
                                        echo '<p class="text-md text-gray-800 mt-0">' . number_format($articleFiltred->getPrixProduit(), 2, '.', '') . '€</p>';
                                    }
                                echo '</div>';
                            echo '</a>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
}

//AFFICHAGE DE LA PAGE D'ARTICLE EN FONCTION DE LA MARQUE EN GET
function viewPageMarque()
{
    if(!empty($_GET['marque']))
    {
        $produitRepo = new ProduitRepository();
        $marqueRepo = new MarqueRepository;
        $categorieRepo = new CategorieRepository;
    
        if($marqueRepo->existMarque($_GET['marque']) != false)
        {
            $marque = $marqueRepo->existMarque($_GET['marque']);
        }
        else 
        {
            header('location: /accueil');
        }
    
        $totalCateProducts = $produitRepo->getTotalMarqueProducts($marque->getIdMarque());
    
        $productsPerPage = 20;
    
        $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;    
    
        if(isset($_GET['page']))
        {
            if($_GET['page'] != 0)
            {
                $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
            }
            else
            {
                $currentpage = 1;
            }
        }
    
        $offset = ($currentpage - 1) * $productsPerPage;
        $produits = $produitRepo->getMarqueProductsPaginated($offset, $productsPerPage, $marque->getIdMarque());
    
        $totalPages = ceil($totalCateProducts / $productsPerPage);    
    
        $categories = getAllCategorie();
    
        include('src/view/articlePageByMarque.php');
    }
    else
    {
        header('location: /404');
    }
    
}

//RECUPERATION DE TOUTE LES MARQUES
function getAllMarque()
{
    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    return $marques;
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

// //TRAITEMENT POUR LES FILTRES DES ARTICLES EN FONCTION DE LA MARQUE PRIT EN GET
function filtrePageMarque()
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
        header('location: /404');
    }

    $produit = $produitRepo->getAllProductsByMarque($marque->getIdMarque());

    $filtres = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

    $articlesFiltres = [];

    $genresFiltres = [];

    $categoriesFiltres = [];

    foreach ($filtres as $filtre) 
    {
        if (isGenre($filtre)) 
        {
            $genresFiltres[] = $filtre;
        }
        elseif(isCategorie($filtre)) 
        {
            $categoriesFiltres[] = $filtre;
        }
    }

    $isGenresSelected = !empty($genresFiltres);

    $isCategoriesSelected = !empty($categoriesFiltres);

    foreach($produit as $article) 
    {
        if (($article != ['']))
        {
            $isGenreMatch = in_array($article->getIdGenre(), $genresFiltres) || !$isGenresSelected;

            $isCategorieMatch = in_array($article->getNomCategorie(), $categoriesFiltres) || !$isCategoriesSelected;
            
            if($isGenreMatch && $isCategorieMatch) 
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
            echo '<div class="flex flex-col justify-center">';
                echo '<div class="relative m-3 flex flex-wrap mx-auto justify-center ">';
                    echo '<div class="relative bg-white shadow-md p-2 my-3 rounded">';
                        echo '<div class="overflow-x-hidden rounded-2xl relative w-56 h-56">';
                            if ($articleFiltred->getPromoProduit() > 0) {
                                echo '<span class="original-number absolute text-[#fcfcfc] text-sm left-2 top-2 z-40 p-1 px-[9px] w-auto text-center font-semibold rounded-full bg-[#e8330d]">-' . $articleFiltred->getPromoProduit() . '%</span>';
                            }
                            echo '<img class="h-full rounded-2xl w-full object-cover" src="/' . $articleFiltred->getNomImage() . '">';
                           
                            echo '<p class="absolute right-2 top-2 bg-[#426EC2] rounded-full p-2 cursor-pointer group">';
                            echo '<img class="add-to-cart-btn w-6 h-6" data-name="' . $articleFiltred->getNomProduit() . '" data-price="' . ($articleFiltred->getPromoProduit() > 0 ? $articleFiltred->getPrixPromoProduit() : $articleFiltred->getPrixProduit()) . '" data-image="' . $articleFiltred->getNomImage() . '" data-genre="' . $articleFiltred->getNomGenre() . '" data-id="' . $articleFiltred->getIdProduit() . '" src="/assets/img/site/addCart.png">';                            echo '</p>';
                        echo '</div>';
                        echo '<div class="mt-4 pl-2 mb-2 flex justify-between ">';
                            echo '<a href="/' . $articleFiltred->getNomGenre() . 'Page/' . $articleFiltred->getIdProduit() . '">';
                                echo '<p class="text-lg font-semibold text-gray-900 mb-0">' . $articleFiltred->getNomProduit() . '</p>';
                                echo '<p class="text-lg text-gray-900 mb-0">' . $articleFiltred->getNomMarque() . '</p>';
                                echo '<div class="flex gap-10">';
                                    if ($articleFiltred->getPromoProduit() > 0) {
                                        echo '<p class="text-md text-gray-800 mt-0 line-through">' . number_format($articleFiltred->getPrixProduit(), 2, '.', '') . '€</p>';
                                        echo '<p class="number text-md text-gray-800 mt-0">' . number_format($articleFiltred->getPrixPromoProduit(), 2, '.', '') . '€</p>';
                                    } else {
                                        echo '<p class="text-md text-gray-800 mt-0">' . number_format($articleFiltred->getPrixProduit(), 2, '.', '') . '€</p>';
                                    }
                                echo '</div>';
                            echo '</a>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
}

//CREER UN TABLEAU DE GENRE POUR LES FILTRES
function isGenre($filtre)
{
    $genres = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];

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

function appatPage()
{
    $appatRepo = new AppatRepository();

    $produitRepo = new ProduitRepository();

    if($produitRepo->existProduit(htmlspecialchars($_GET['id'])))
    {
        $id_produit = htmlspecialchars($_GET['id']);
    }
    else
    {
        header('location: /404');
    }

    $appat = $appatRepo->getAppat($id_produit);

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();

    include('src/view/articlePage/appatPage.php');
}

function cannePage()
{
    $canneRepo = new CanneRepository();

    $produitRepo = new ProduitRepository();

    if($produitRepo->existProduit(htmlspecialchars($_GET['id'])))
    {
        $id_produit = htmlspecialchars($_GET['id']);
    }
    else
    {
        header('location: /404');
    }
    $canne = $canneRepo->getCanne($id_produit);

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();

    include('src/view/articlePage/cannePage.php');
}

function moulinetPage()
{
    $moulinetRepo = new MoulinetRepository();

    $produitRepo = new ProduitRepository();

    if($produitRepo->existProduit(htmlspecialchars($_GET['id'])))
    {
        $id_produit = htmlspecialchars($_GET['id']);
    }
    else
    {
        header('location: /404');
    }
    $moulinet = $moulinetRepo->getMoulinet($id_produit);

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();

    include('src/view/articlePage/moulinetPage.php');
}

function leurrePage()
{
    $leurreRepo = new LeurreRepository();

    $produitRepo = new ProduitRepository();

    if($produitRepo->existProduit(htmlspecialchars($_GET['id'])))
    {
        $id_produit = htmlspecialchars($_GET['id']);
    }
    else
    {
        header('location: /404');
    }
    $leurre = $leurreRepo->getLeurre($id_produit);

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();

    include('src/view/articlePage/leurrePage.php');
}

function lignePage()
{
    $ligneRepo = new LigneRepository();

    $produitRepo = new ProduitRepository();

    if($produitRepo->existProduit(htmlspecialchars($_GET['id'])))
    {
        $id_produit = htmlspecialchars($_GET['id']);
    }
    else
    {
        header('location: /404');
    }
    $ligne = $ligneRepo->getLigne($id_produit);

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();

    include('src/view/articlePage/lignePage.php');
}

function plombPage()
{
    $plombRepo = new PlombRepository();

    $produitRepo = new ProduitRepository();

    if($produitRepo->existProduit(htmlspecialchars($_GET['id'])))
    {
        $id_produit = htmlspecialchars($_GET['id']);
    }
    else
    {
        header('location: /404');
    }
    $plomb = $plombRepo->getPlomb($id_produit);

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();

    include('src/view/articlePage/plombPage.php');
}

function equipementPage()
{
    $equipementRepo = new EquipementRepository();

    $produitRepo = new ProduitRepository();

    if($produitRepo->existProduit(htmlspecialchars($_GET['id'])))
    {
        $id_produit = htmlspecialchars($_GET['id']);
    }
    else
    {
        header('location: /404');
    }
    $equipement = $equipementRepo->getEquipement($id_produit);

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();

    include('src/view/articlePage/equipementPage.php');
}

function autrePage()
{
    $autreRepo = new AutreRepository();

    $produitRepo = new ProduitRepository();

    if($produitRepo->existProduit(htmlspecialchars($_GET['id'])))
    {
        $id_produit = htmlspecialchars($_GET['id']);
    }
    else
    {
        header('location: /404');
    }
    $autre = $autreRepo->getAutre($id_produit);

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();

    include('src/view/articlePage/autrePage.php');
}

function hameconPage()
{
    $hameconRepo = new HameconRepository();

    $produitRepo = new ProduitRepository();

    if($produitRepo->existProduit(htmlspecialchars($_GET['id'])))
    {
        $id_produit = htmlspecialchars($_GET['id']);
    }
    else
    {
        header('location: /404');
    }
    $hamecon = $hameconRepo->getHamecon($id_produit);

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $allTypes = getAllType();

    include('src/view/articlePage/hameconPage.php');
}