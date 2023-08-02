<?php

require_once ('src/config/connectBdd.php');

class User
{
    private $id_user;
    private $email_user;
    private $lastname_user;
    private $name_user;
    private $password_user;
    private $token_user;
    private $actif_user;
    private $id_role;

    public function createToSignin($userForm):bool
    {
        if(!isset($userForm['email']) OR $userForm['email'] == '')
        {
            return false;
        }
        
        if(!isset($userForm['lastname']) OR $userForm['lastname'] == '')
        {
            return false;
        }

        if(!isset($userForm['name']) OR $userForm['name'] == '')
        {
            return false;
        }

        if(isset($userForm['password']) && $userForm['password'] === $userForm['verif_password'])
        {
            $this->password_user = $userForm['password'];
        }
        else
        {
            return false;
        }
    
        $this->email_user = $userForm['email'];
        $this->lastname_user = $userForm['lastname'];
        $this->name_user = $userForm['name'];
        $this->password_user = $userForm['password'];

        return true;
    }

    public function getIdUser():int
    {
        return $this->id_user;
    }

    public function setIdUser($id_user):void
    {
        $this->id_user = $id_user;
    }

    public function getEmailUser():string
    {
        return $this->email_user;
    }

    public function setEmailUser($email_user):void
    {
        $this->email_user = $email_user;
    }

    public function getLastnameUser():string
    {
        return $this->lastname_user;
    }

    public function setLastnameUser($lastname_user):void
    {
        $this->lastname_user = $lastname_user;
    }

    public function getNameUser():string
    {
        return $this->name_user;
    }

    public function setNameUser($name_user):void
    {
        $this->name_user = $name_user;
    }

    public function getPasswordUser():string
    {
        return $this->password_user;
    }

    public function setPasswordUser($password_user):void
    {
        $this->password_user = $password_user;
    }

    public function getTokenUser():string
    {
        return $this->token_user;
    }

    public function setTokenUser($token_user):void
    {
        $this->token_user = $token_user;
    }

    public function getActifUser():string
    {
        return $this->actif_user;
    }

    public function setActifUser($actif_user):void
    {
        $this->actif_user = $actif_user;
    }

    public function getIdRole():string
    {
        return $this->id_role;
    }

    public function setIdRole($id_role):void
    {
        $this->id_role = $id_role;
    }

}

class UserRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertUser(User $user)
    {
        $token = bin2hex(random_bytes(25));

        $req = $this->bdd->prepare("INSERT INTO user (email_user, nom_user, prenom_user, password_user, token_user, actif_user, id_role)
        VALUES (?,?,?,?,?,?,?)");

        $req->execute
        ([
            $user->getEmailUser(),
            $user->getLastnameUser(),
            $user->getNameUser(),
            $user->getPasswordUser(),
            $token,
            0,
            2
        ]);
    }

    public function findByEmail (string $email)
    {
        $req = $this->bdd->prepare('SELECT id_user FROM user WHERE email_user = ? LIMIT 1');
        $req->execute([$email]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail(string $email):mixed
    {
        $req = $this->bdd->prepare('SELECT * FROM user WHERE email_user = ?');
        $req->execute([$email]);
        $data = $req->fetch();
        
        if($data != false)
        {
            $user = new User();
            $user->setIdUser($data['id_user']);
            $user->setEmailUser($data['email_user']);
            $user->setLastnameUser($data['nom_user']);
            $user->setNameUser($data['prenom_user']);
            $user->setPasswordUser($data['password_user']);
            $user->setActifUser($data['actif_user']);
            $user->setIdRole($data['id_role']);
            
            return $user;
        }
        else
        {
            return [];
        }
    }

    public function verifyPassword(string $password):bool
    {
        if(preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/', $password))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getUserById($id_user)
    {
        $req = $this->bdd->prepare("SELECT * FROM user WHERE id_user = ?");
        $req->execute([$id_user]);
        $user = $req->fetch(PDO::FETCH_ASSOC);

        if ($user) 
        {
            return new User($user['email_user'], $user['nom_user'], $user['prenom_user'], $user['password_user'], $user['token_user'], $user['actif_user'], $user['id_role']);
        } 
        else 
        {
            return null;
        }
    }

    public function updateUser(User $user)
    {
        $req = $this->bdd->prepare("UPDATE user SET email_user = ?, nom_user = ?, prenom_user = ?, password_user = ? WHERE id_user = ?");
        $req->execute([$user->getEmailUser(), $user->getLastnameUser(), $user->getNameUser(), $user->getPasswordUser(), $user->getIdUser()]);
    }
}

?>