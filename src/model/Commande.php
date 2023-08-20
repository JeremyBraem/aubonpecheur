<?php

require_once ('src/config/connectBdd.php');

class Commande
{
    private $id_commande;
    private $resume_commande;
    private $numero_commande;
    private $date_commande;
    private $etat_commande;
    private $id_user;

    public function getIdUser():int
    {
        return $this->id_user;
    }

    public function setIdUser($id_user):void
    {
        $this->id_user = $id_user;
    }

    public function getIdCommande():int
    {
        return $this->id_commande;
    }

    public function setIdCommande($id_commande):void
    {
        $this->id_commande = $id_commande;
    }

    public function getNumeroCommande():string
    {
        return $this->numero_commande;
    }

    public function setNumeroCommande($numero_commande):void
    {
        $this->numero_commande = $numero_commande;
    }

    public function getResumeCommande()
    {
        return $this->resume_commande;
    }

    public function setResumeCommande($resume_commande):void
    {
        $this->resume_commande = $resume_commande;
    }

    public function getDateCommande():string
    {
        return $this->date_commande;
    }

    public function setDateCommande($date_commande):void
    {
        $this->date_commande = $date_commande;
    }

    public function getEtatCommande():string
    {
        return $this->etat_commande;
    }

    public function setEtatCommande($etat_commande):void
    {
        $this->etat_commande = $etat_commande;
    }
}

class CommandeRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    function addCommande(Commande $commande)
    {
        try
        {
            $this->bdd->beginTransaction();
            $req = $this->bdd->prepare
            ("INSERT INTO commande (resume_commande, numero_commande, date_commande, etat_commande, id_user) VALUES (?,?,?,?,?)");

            $req->execute
            ([
                $commande->getResumeCommande(),
                $commande->getNumeroCommande(),
                $commande->getDateCommande(),
                0,
                $commande->getIdUser()
            ]);

            $this->bdd->commit();
        } 
        catch (PDOException $e) 
        {
            $this->bdd->rollBack();
            die("Erreur: " . $e->getMessage());
        }
    }

    function getUserCommande($id_user, $numero_commande)
    {
        try
        {
            $req = $this->bdd->prepare
            ("SELECT * FROM commande WHERE id_user = ? && numero_commande = ?");

            $req->execute
            ([
                $id_user,
                $numero_commande
            ]);
          
            $commandeData = $req->fetch(PDO::FETCH_ASSOC);
            
            $commande = new Commande;
           
            $commande->setIdCommande($commandeData['id_commande']);
            $commande->setResumeCommande($commandeData['resume_commande']);
            $commande->setNumeroCommande($commandeData['numero_commande']);
            $commande->setDateCommande($commandeData['date_commande']);
            $commande->setEtatCommande($commandeData['etat_commande']);
            $commande->setIdUser($commandeData['id_user']);
            
            return $commande;
        } 
        catch (PDOException $e) 
        {
            die("Erreur: " . $e->getMessage());
        }
    }

    function getAllUserCommande($id_user)
    {
        try
        {
            $req = $this->bdd->prepare
            ("SELECT * FROM commande WHERE id_user = ? ORDER BY date_commande DESC");

            $req->execute
            ([
                $id_user,
            ]);
          
            $commandesData = $req->fetchAll(PDO::FETCH_ASSOC);
            
            $commandes = [];

            foreach($commandesData as $commandeData)
            {
                $commande = new Commande;
                $commande->setIdCommande($commandeData['id_commande']);
                $commande->setResumeCommande($commandeData['resume_commande']);
                $commande->setNumeroCommande($commandeData['numero_commande']);
                $commande->setDateCommande($commandeData['date_commande']);
                $commande->setEtatCommande($commandeData['etat_commande']);
                $commande->setIdUser($commandeData['id_user']);
                
                $commandes[] = $commande;
            }

            return $commandes;
        } 
        catch (PDOException $e) 
        {
            die("Erreur: " . $e->getMessage());
        }
    }

    function getAllCommande()
    {
        try
        {
            $req = $this->bdd->prepare("SELECT * FROM commande ORDER BY date_commande DESC");

            $req->execute();
          
            $commandesData = $req->fetchAll(PDO::FETCH_ASSOC);
            
            $commandes = [];

            foreach($commandesData as $commandeData)
            {
                $commande = new Commande;
                $commande->setIdCommande($commandeData['id_commande']);
                $commande->setResumeCommande($commandeData['resume_commande']);
                $commande->setNumeroCommande($commandeData['numero_commande']);
                $commande->setDateCommande($commandeData['date_commande']);
                $commande->setEtatCommande($commandeData['etat_commande']);
                $commande->setIdUser($commandeData['id_user']);
                
                $commandes[] = $commande;
            }
            
            return $commandes;
        } 
        catch (PDOException $e) 
        {
            die("Erreur: " . $e->getMessage());
        }
    }

    public function updateEtat($etat_commande, $id_commande)
    {
        $req = $this->bdd->prepare("UPDATE commande SET etat_commande = ? WHERE id_commande = ?");
        $req->execute([$etat_commande, $id_commande]);
    }

    public function verifNumero($id_user, $numero)
    {
        try
        {
            $req = $this->bdd->prepare
            ("SELECT id_user FROM commande WHERE numero_commande = ?");

            $req->execute
            ([
                $numero
            ]);

            $commandeData = $req->fetch(PDO::FETCH_ASSOC);

            if(!empty($commandeData) || $commandeData === !null)
            {
                if($id_user == $commandeData['id_user'])
                {
                    return true;
                }
            }
            else
            {
                return false;
            }
        }
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des cannes : " . $e->getMessage());
        }
    }
    
}

?>