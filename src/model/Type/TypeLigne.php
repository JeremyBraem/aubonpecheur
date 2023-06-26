<?php
require_once 'src/config/connectBdd.php';

class TypeLigne
{
    private $id_type_ligne;
    private $nom_type_ligne;

    public function createToInserTypeLigne($type_ligneForm):bool
    {
        if(!isset($type_ligneForm['nom_type_ligne']) OR $type_ligneForm['nom_type_ligne'] == '')
        {
            return false;
        }
    
        $this->nom_type_ligne = $type_ligneForm['nom_type_ligne'];

        return true;
    }

    public function getIdTypeLigne():int
    {
        return $this->id_type_ligne;
    }

    public function setIdTypeLigne($id_type_ligne):void
    {
        $this->id_type_ligne = $id_type_ligne;
    }

    public function getNomTypeLigne():string
    {
        return $this->nom_type_ligne;
    }

    public function setNomTypeLigne($nom_type_ligne):void
    {
        $this->nom_type_ligne = $nom_type_ligne;
    }
}

class TypeLigneRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllTypeLigne()
    {
        $req = $this->bdd->prepare("SELECT * FROM type_ligne");
        $req->execute();
        $datas = $req->fetchAll();
        $type_lignes = [];
        foreach ($datas as $data) 
        {
            $type_ligne = new TypeLigne();
            $type_ligne->setIdTypeLigne($data['id_type_ligne']);
            $type_ligne->setNomTypeLigne($data['nom_type_ligne']);
           
            $type_lignes[] = $type_ligne;
        }
        return $type_lignes;
    }

    public function insertTypeLigne(TypeLigne $type_ligne)
    {
        $req = $this->bdd->prepare("INSERT INTO type_ligne(nom_type_ligne) VALUES (?)");
        
        $req->execute
        ([
            $type_ligne->getNomTypeLigne()
        ]);
    }

    public function deleteTypeLigne($id_type_ligne):bool
    {
        try 
        {
            $req = $this->bdd->prepare('DELETE FROM type_ligne WHERE id_type_ligne = ?');
            $req->execute([$id_type_ligne]);

            return true;
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }
}