<?php
require_once 'src/config/connectBdd.php';

class TypeFeeder
{
    private $id_type_feeder;
    private $nom_type_feeder;

    public function createToInserTypeFeeder($type_feederForm):bool
    {
        if(!isset($type_feederForm['nom_type_feeder']) OR $type_feederForm['nom_type_feeder'] == '')
        {
            return false;
        }
    
        $this->nom_type_feeder = $type_feederForm['nom_type_feeder'];

        return true;
    }

    public function getIdTypeFeeder():int
    {
        return $this->id_type_feeder;
    }

    public function setIdTypeFeeder($id_type_feeder):void
    {
        $this->id_type_feeder = $id_type_feeder;
    }

    public function getNomTypeFeeder():string
    {
        return $this->nom_type_feeder;
    }

    public function setNomTypeFeeder($nom_type_feeder):void
    {
        $this->nom_type_feeder = $nom_type_feeder;
    }
}

class TypeFeederRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllTypeFeeder()
    {
        $req = $this->bdd->prepare("SELECT * FROM type_feeder");
        $req->execute();
        $datas = $req->fetchAll();
        $type_feeders = [];
        foreach ($datas as $data) 
        {
            $type_feeder = new TypeFeeder();
            $type_feeder->setIdTypeFeeder($data['id_type_feeder']);
            $type_feeder->setNomTypeFeeder($data['nom_type_feeder']);
           
            $type_feeders[] = $type_feeder;
        }
        return $type_feeders;
    }

    public function insertTypeFeeder(TypeFeeder $type_feeder)
    {
        $req = $this->bdd->prepare("INSERT INTO type_feeder(nom_type_feeder) VALUES (?)");
        
        $req->execute
        ([
            $type_feeder->getNomTypeFeeder()
        ]);
    }

    public function deleteTypeFeeder($id_type_feeder):bool
    {
        try 
        {
            $req = $this->bdd->prepare('DELETE FROM type_feeder WHERE id_type_feeder = ?');
            $req->execute([$id_type_feeder]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }
}