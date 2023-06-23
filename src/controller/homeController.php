<?php

require_once ('autoload/autoloader.php');
require_once ('src/model/User.php');
require_once('src/model/Produit/Produit.php');
require_once('src/model/Produit/Canne.php');
require_once('src/model/Produit/Moulinet.php');
require_once('src/model/Produit/Hamecon.php');
require_once('src/model/Marque.php');
require_once('src/model/Categorie.php');
require_once('src/model/Type/TypeCanne.php');
require_once('src/model/Type/TypeMoulinet.php');
require_once('src/model/Type/TypeHamecon.php');
require_once('src/model/Image/ImageCanne.php');
require_once('src/model/Image/ImageMoulinet.php');
require_once('src/model/Image/ImageHamecon.php');

// function allProduct()
// {
//     $produitModel = new ProduitRepository();
//     $products = $produitModel->getAllProducts();
    
//     $result = [];

//     // Canne
//     foreach ($products['cannes'] as $canne) {
//         $idCanne = $canne[0];
//         $nomCanne = $canne[1];
        
//         $canneInfo = [
//             'id' => $idCanne,
//             'nom' => $nomCanne
//         ];
        
//         $result['cannes'][] = $canneInfo;
//     }

//     // Moulinet
//     foreach ($products['moulinets'] as $moulinet) {
//         $idMoulinet = $moulinet[0];
//         $nomMoulinet = $moulinet[1];
        
//         $moulinetInfo = [
//             'id' => $idMoulinet,
//             'nom' => $nomMoulinet
//         ];
        
//         $result['moulinets'][] = $moulinetInfo;
//     }

//     // Hameçon
//     foreach ($products['hamecons'] as $hamecon) {
//         $idHamecon = $hamecon[0];
//         $nomHamecon = $hamecon[1];
        
//         $hameconInfo = [
//             'id' => $idHamecon,
//             'nom' => $nomHamecon
//         ];
        
//         $result['hamecons'][] = $hameconInfo;
//     }
//     return $result;
// }


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

    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();

    $categorieRepo = new CategorieRepository;
    $categories = $categorieRepo->getAllCategorie();

    $articles = [];
    
    $articles['cannes'] = $cannes;
    
    $articles['typeCannes'] = $typeCannes;
    
    $articles['moulinets'] = $moulinets;
    
    $articles['typeMoulinets'] = $typeMoulinets;
    
    $articles['hamecons'] = $hamecons;
    
    $articles['typeHamecons'] = $typeHamecons;
    
    $articles['marques'] = $marques;
    
    $articles['categories'] = $categories;
    
    include ('src/view/homePage.php');
}

function viewAllMarque()
{
    $marqueRepo = new MarqueRepository;
    $marques = $marqueRepo->getAllMarque();
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
}

function articlePage()
{
    include ('src/view/articlePage.php');
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

?>