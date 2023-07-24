<?php
require_once 'src/config/connectBdd.php';

class TypePlomb
{
    private $id_type_plomb;
    private $nom_type_plomb;

    public function createToInserTypePlomb($type_plombForm):bool
    {
        if(!isset($type_plombForm['nom_type_plomb']) OR $type_plombForm['nom_type_plomb'] == '')
        {
            return false;
        }
    
        $this->nom_type_plomb = $type_plombForm['nom_type_plomb'];

        return true;
    }

    public function getIdTypePlomb():int
    {
        return $this->id_type_plomb;
    }

    public function setIdTypePlomb($id_type_plomb):void
    {
        $this->id_type_plomb = $id_type_plomb;
    }

    public function getNomTypePlomb():string
    {
        return $this->nom_type_plomb;
    }

    public function setNomTypePlomb($nom_type_plomb):void
    {
        $this->nom_type_plomb = $nom_type_plomb;
    }
}

class TypePlombRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllTypePlomb()
    {
        $req = $this->bdd->prepare("SELECT * FROM type_plomb");
        $req->execute();
        $datas = $req->fetchAll();
        $type_plombs = [];
        foreach ($datas as $data)
        {
            $type_plomb = new TypePlomb();
            $type_plomb->setIdTypePlomb($data['id_type_plomb']);
            $type_plomb->setNomTypePlomb($data['nom_type_plomb']);
           
            $type_plombs[] = $type_plomb;
        }
        return $type_plombs;
    }

    public function insertTypePlomb(TypePlomb $type_plomb)
    {
        $req = $this->bdd->prepare("INSERT INTO type_plomb(nom_type_plomb) VALUES (?)");
        
        $req->execute
        ([
            $type_plomb->getNomTypePlomb()
        ]);
    }

    public function deleteTypePlomb($id_type_plomb):bool
    {
        try 
        {
            $req = $this->bdd->prepare('DELETE FROM type_plomb WHERE id_type_plomb = ?');
            $req->execute([$id_type_plomb]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }
}