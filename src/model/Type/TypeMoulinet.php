<?php
require_once 'src/config/connectBdd.php';

class TypeMoulinet
{
    private $id_type_moulinet;
    private $nom_type_moulinet;

    public function createToInserTypeMoulinet($type_moulinetForm):bool
    {
        if(!isset($type_moulinetForm['nom_type_moulinet']) OR $type_moulinetForm['nom_type_moulinet'] == '')
        {
            return false;
        }
    
        $this->nom_type_moulinet = $type_moulinetForm['nom_type_moulinet'];

        return true;
    }

    public function getIdTypeMoulinet():int
    {
        return $this->id_type_moulinet;
    }

    public function setIdTypeMoulinet($id_type_moulinet):void
    {
        $this->id_type_moulinet = $id_type_moulinet;
    }

    public function getNomTypeMoulinet():string
    {
        return $this->nom_type_moulinet;
    }

    public function setNomTypeMoulinet($nom_type_moulinet):void
    {
        $this->nom_type_moulinet = $nom_type_moulinet;
    }
}

class TypeMoulinetRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllTypeMoulinet()
    {
        $req = $this->bdd->prepare("SELECT * FROM type_moulinet");
        $req->execute();
        $datas = $req->fetchAll();
        $type_moulinets = [];
        foreach ($datas as $data) 
        {
            $type_moulinet = new TypeMoulinet();
            $type_moulinet->setIdTypeMoulinet($data['id_type_moulinet']);
            $type_moulinet->setNomTypeMoulinet($data['nom_type_moulinet']);
           
            $type_moulinets[] = $type_moulinet;
        }
        return $type_moulinets;
    }

    public function insertTypeMoulinet(TypeMoulinet $type_moulinet)
    {
        $req = $this->bdd->prepare("INSERT INTO type_moulinet(nom_type_moulinet) VALUES (?)");
        
        $req->execute
        ([
            $type_moulinet->getNomTypeMoulinet()
        ]);
    }

    public function deleteTypeMoulinet($id_type_moulinet):bool
    {
        try 
        {
            $req = $this->bdd->prepare('DELETE FROM type_moulinet WHERE id_type_moulinet = ?');
            $req->execute([$id_type_moulinet]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }
}