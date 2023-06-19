<?php
require_once 'src/config/connectBdd.php';

class TypeCanne
{
    private $id_type_canne;
    private $nom_type_canne;

    public function createToInserTypeCanne($type_canneForm):bool
    {
        if(!isset($type_canneForm['nom_type_canne']) OR $type_canneForm['nom_type_canne'] == '')
        {
            return false;
        }
    
        $this->nom_type_canne = $type_canneForm['nom_type_canne'];

        return true;
    }

    public function getIdTypeCanne():int
    {
        return $this->id_type_canne;
    }

    public function setIdTypeCanne($id_type_canne):void
    {
        $this->id_type_canne = $id_type_canne;
    }

    public function getNomTypeCanne():string
    {
        return $this->nom_type_canne;
    }

    public function setNomTypeCanne($nom_type_canne):void
    {
        $this->nom_type_canne = $nom_type_canne;
    }
}

class TypeCanneRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllTypeCanne()
    {
        $req = $this->bdd->prepare("SELECT * FROM type_canne");
        $req->execute();
        $datas = $req->fetchAll();
        $type_cannes = [];
        foreach ($datas as $data) 
        {
            $type_canne = new TypeCanne();
            $type_canne->setIdTypeCanne($data['id_type_canne']);
            $type_canne->setNomTypeCanne($data['nom_type_canne']);
           
            $type_cannes[] = $type_canne;
        }
        return $type_cannes;
    }

}