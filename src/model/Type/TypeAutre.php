<?php
require_once 'src/config/connectBdd.php';

class TypeAutre
{
    private $id_type_autre;
    private $nom_type_autre;

    public function createToInserTypeAutre($type_autreForm):bool
    {
        if(!isset($type_autreForm['nom_type_autre']) OR $type_autreForm['nom_type_autre'] == '')
        {
            return false;
        }
    
        $this->nom_type_autre = $type_autreForm['nom_type_autre'];

        return true;
    }

    public function getIdTypeAutre():int
    {
        return $this->id_type_autre;
    }

    public function setIdTypeAutre($id_type_autre):void
    {
        $this->id_type_autre = $id_type_autre;
    }

    public function getNomTypeAutre():string
    {
        return $this->nom_type_autre;
    }

    public function setNomTypeAutre($nom_type_autre):void
    {
        $this->nom_type_autre = $nom_type_autre;
    }
}

class TypeAutreRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllTypeAutre()
    {
        $req = $this->bdd->prepare("SELECT * FROM type_autre");
        $req->execute();
        $datas = $req->fetchAll();
        $type_autres = [];
        foreach ($datas as $data) 
        {
            $type_autre = new TypeAutre();
            $type_autre->setIdTypeAutre($data['id_type_autre']);
            $type_autre->setNomTypeAutre($data['nom_type_autre']);
           
            $type_autres[] = $type_autre;
        }
        return $type_autres;
    }

    public function insertTypeAutre(TypeAutre $type_autre)
    {
        $req = $this->bdd->prepare("INSERT INTO type_autre(nom_type_autre) VALUES (?)");
        
        $req->execute
        ([
            $type_autre->getNomTypeAutre()
        ]);
    }

    public function deleteTypeAutre($id_type_autre):bool
    {
        try 
        {
            $req = $this->bdd->prepare('DELETE FROM type_autre WHERE id_type_autre = ?');
            $req->execute([$id_type_autre]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }
}