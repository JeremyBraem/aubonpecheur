<?php
require_once 'src/config/connectBdd.php';

class TypeEquipement
{
    private $id_type_equipement;
    private $nom_type_equipement;

    public function createToInserTypeEquipement($type_equipementForm):bool
    {
        if(!isset($type_equipementForm['nom_type_equipement']) OR $type_equipementForm['nom_type_equipement'] == '')
        {
            return false;
        }
    
        $this->nom_type_equipement = $type_equipementForm['nom_type_equipement'];

        return true;
    }

    public function getIdTypeEquipement():int
    {
        return $this->id_type_equipement;
    }

    public function setIdTypeEquipement($id_type_equipement):void
    {
        $this->id_type_equipement = $id_type_equipement;
    }

    public function getNomTypeEquipement():string
    {
        return $this->nom_type_equipement;
    }

    public function setNomTypeEquipement($nom_type_equipement):void
    {
        $this->nom_type_equipement = $nom_type_equipement;
    }
}

class TypeEquipementRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllTypeEquipement()
    {
        $req = $this->bdd->prepare("SELECT * FROM type_equipement");
        $req->execute();
        $datas = $req->fetchAll();
        $type_equipements = [];
        foreach ($datas as $data) 
        {
            $type_equipement = new TypeEquipement();
            $type_equipement->setIdTypeEquipement($data['id_type_equipement']);
            $type_equipement->setNomTypeEquipement($data['nom_type_equipement']);
           
            $type_equipements[] = $type_equipement;
        }
        return $type_equipements;
    }

    public function insertTypeEquipement(TypeEquipement $type_equipement)
    {
        $req = $this->bdd->prepare("INSERT INTO type_equipement(nom_type_equipement) VALUES (?)");
        
        $req->execute
        ([
            $type_equipement->getNomTypeEquipement()
        ]);
    }

    public function deleteTypeEquipement($id_type_equipement):bool
    {
        try 
        {
            $req = $this->bdd->prepare('DELETE FROM type_equipement WHERE id_type_equipement = ?');
            $req->execute([$id_type_equipement]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }
}