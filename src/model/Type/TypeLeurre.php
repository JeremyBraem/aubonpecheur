<?php
require_once 'src/config/connectBdd.php';

class TypeLeurre
{
    private $id_type_leurre;
    private $nom_type_leurre;

    public function createToInserTypeLeurre($type_leurreForm):bool
    {
        if(!isset($type_leurreForm['nom_type_leurre']) OR $type_leurreForm['nom_type_leurre'] == '')
        {
            return false;
        }
    
        $this->nom_type_leurre = $type_leurreForm['nom_type_leurre'];

        return true;
    }

    public function getIdTypeLeurre():int
    {
        return $this->id_type_leurre;
    }

    public function setIdTypeLeurre($id_type_leurre):void
    {
        $this->id_type_leurre = $id_type_leurre;
    }

    public function getNomTypeLeurre():string
    {
        return $this->nom_type_leurre;
    }

    public function setNomTypeLeurre($nom_type_leurre):void
    {
        $this->nom_type_leurre = $nom_type_leurre;
    }
}

class TypeLeurreRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllTypeLeurre()
    {
        $req = $this->bdd->prepare("SELECT * FROM type_leurre");
        $req->execute();
        $datas = $req->fetchAll();
        $type_leurres = [];
        foreach ($datas as $data) 
        {
            $type_leurre = new TypeLeurre();
            $type_leurre->setIdTypeLeurre($data['id_type_leurre']);
            $type_leurre->setNomTypeLeurre($data['nom_type_leurre']);
           
            $type_leurres[] = $type_leurre;
        }
        return $type_leurres;
    }

    public function insertTypeLeurre(TypeLeurre $type_leurre)
    {
        $req = $this->bdd->prepare("INSERT INTO type_leurre(nom_type_leurre) VALUES (?)");
        
        $req->execute
        ([
            $type_leurre->getNomTypeLeurre()
        ]);
    }

    public function deleteTypeLeurre($id_type_leurre):bool
    {
        try 
        {
            $req = $this->bdd->prepare('DELETE FROM type_leurre WHERE id_type_leurre = ?');
            $req->execute([$id_type_leurre]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }
}