<?php
require_once 'src/config/connectBdd.php';

class TypeAppat
{
    private $id_type_appat;
    private $nom_type_appat;

    public function createToInserTypeAppat($type_appatForm):bool
    {
        if(!isset($type_appatForm['nom_type_appat']) OR $type_appatForm['nom_type_appat'] == '')
        {
            return false;
        }
    
        $this->nom_type_appat = $type_appatForm['nom_type_appat'];

        return true;
    }

    public function getIdTypeAppat():int
    {
        return $this->id_type_appat;
    }

    public function setIdTypeAppat($id_type_appat):void
    {
        $this->id_type_appat = $id_type_appat;
    }

    public function getNomTypeAppat():string
    {
        return $this->nom_type_appat;
    }

    public function setNomTypeAppat($nom_type_appat):void
    {
        $this->nom_type_appat = $nom_type_appat;
    }
}

class TypeAppatRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllTypeAppat()
    {
        $req = $this->bdd->prepare("SELECT * FROM type_appat");
        $req->execute();
        $datas = $req->fetchAll();
        $type_appats = [];
        foreach ($datas as $data) 
        {
            $type_appat = new TypeAppat();
            $type_appat->setIdTypeAppat($data['id_type_appat']);
            $type_appat->setNomTypeAppat($data['nom_type_appat']);
           
            $type_appats[] = $type_appat;
        }
        return $type_appats;
    }

    public function insertTypeAppat(TypeAppat $type_appat)
    {
        $req = $this->bdd->prepare("INSERT INTO type_appat(nom_type_appat) VALUES (?)");
        
        $req->execute
        ([
            $type_appat->getNomTypeAppat()
        ]);
    }

    public function deleteTypeAppat($id_type_appat):bool
    {
        try 
        {
            $req = $this->bdd->prepare('DELETE FROM type_appat WHERE id_type_appat = ?');
            $req->execute([$id_type_appat]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }
}