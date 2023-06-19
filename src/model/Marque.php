<?php
require_once 'src/config/connectBdd.php';

class Marque
{
    private $id_marque;
    private $nom_marque;

    public function createToInsertMarque($marqueForm):bool
    {
        if(!isset($marqueForm['nom_marque']) OR $marqueForm['nom_marque'] == '')
        {
            return false;
        }
    
        $this->nom_marque = $marqueForm['nom_marque'];

        return true;
    }

    public function getIdMarque():int
    {
        return $this->id_marque;
    }

    public function setIdMarque($id_marque):void
    {
        $this->id_marque = $id_marque;
    }

    public function getNomMarque():string
    {
        return $this->nom_marque;
    }

    public function setNomMarque($nom_marque):void
    {
        $this->nom_marque = $nom_marque;
    }
}

class MarqueRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllMarque()
    {
        $req = $this->bdd->prepare("SELECT * FROM marque");
        $req->execute();
        $datas = $req->fetchAll();
        $marques = [];
        foreach ($datas as $data) 
        {
            $marque = new Marque();
            $marque->setIdMarque($data['id_marque']);
            $marque->setNomMarque($data['nom_marque']);
           
            $marques[] = $marque;
        }
        return $marques;
    }

}