<?php
require_once 'src/config/connectBdd.php';

class TypeHamecon
{
    private $id_type_hamecon;
    private $nom_type_hamecon;

    public function createToInserTypeHamecon($type_hameconForm):bool
    {
        if(!isset($type_hameconForm['nom_type_hamecon']) OR $type_hameconForm['nom_type_hamecon'] == '')
        {
            return false;
        }
    
        $this->nom_type_hamecon = $type_hameconForm['nom_type_hamecon'];

        return true;
    }

    public function getIdTypeHamecon():int
    {
        return $this->id_type_hamecon;
    }

    public function setIdTypeHamecon($id_type_hamecon):void
    {
        $this->id_type_hamecon = $id_type_hamecon;
    }

    public function getNomTypeHamecon():string
    {
        return $this->nom_type_hamecon;
    }

    public function setNomTypeHamecon($nom_type_hamecon):void
    {
        $this->nom_type_hamecon = $nom_type_hamecon;
    }
}

class TypeHameconRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllTypeHamecon()
    {
        $req = $this->bdd->prepare("SELECT * FROM type_hamecon");
        $req->execute();
        $datas = $req->fetchAll();
        $type_hamecons = [];
        foreach ($datas as $data) 
        {
            $type_hamecon = new TypeHamecon();
            $type_hamecon->setIdTypeHamecon($data['id_type_hamecon']);
            $type_hamecon->setNomTypeHamecon($data['nom_type_hamecon']);
           
            $type_hamecons[] = $type_hamecon;
        }
        return $type_hamecons;
    }

    public function insertTypeHamecon(TypeHamecon $type_hamecon)
    {
        $req = $this->bdd->prepare("INSERT INTO type_hamecon(nom_type_hamecon) VALUES (?)");
        
        $req->execute
        ([
            $type_hamecon->getNomTypeHamecon()
        ]);
    }

    public function deleteTypeHamecon($id_type_hamecon):bool
    {
        try 
        {
            $req = $this->bdd->prepare('DELETE FROM type_hamecon WHERE id_type_hamecon = ?');
            $req->execute([$id_type_hamecon]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }
}