<?php

require_once ('autoload/autoloader.php');
require_once ('src/model/User.php');

function home() 
{
    include ('src/view/homePage.php');
}

function articlePage()
{
    include ('src/view/articlePage.php');
}

function loginPage() 
{
    include ('src/view/connexionPage.php');
}

function signUpPage() 
{
    include ('src/view/inscriptionPage.php');
}

function signUpTraitement() 
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
                        header("Location: index.php?action=signUp");
                    }
                }
                else
                {
                    header("Location: index.php?action=signUp");
                }
                    
            }
            else
            {
                header("Location:index.php?action=signUp");
            } 
        }
        else
        {
            header("Location:index.php?action=signUp");
        }    
    }
    else
    {
        header("Location:index.php?action=404");
    }
}

function loginTraitement()
{
    if(isset($_POST['password']) && isset($_POST['email']))
    {
        if ($_POST['password'] !== "" && $_POST['email'] !== "")
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
                    header("Location:index.php?&message1=Une des informations est incorrectes");
                }
            } 
            else 
            {
                header("Location:index.php?&message2=Une des informations est incorrectes");
            }
        }
        else 
        {
            header("Location:index.php?&message3=Un des champ est vide");
        }
    }
    else
    {
        
    }
}

function disconnectUser()
{
    session_destroy();
    header('location:index.php');
}
?>