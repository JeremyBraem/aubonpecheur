<?php
require_once 'src/config/connectBdd.php';

class Categorie
{
    private $id_categorie;
    private $nom_categorie;

    public function createToInsertCategorie($categorieForm):bool
    {
        if(!isset($categorieForm['nom_categorie']) OR $categorieForm['nom_categorie'] == '')
        {
            return false;
        }
    
        $this->nom_categorie = $categorieForm['nom_categorie'];

        return true;
    }

    public function getIdCategorie():int
    {
        return $this->id_categorie;
    }

    public function setIdCategorie($id_categorie):void
    {
        $this->id_categorie = $id_categorie;
    }

    public function getNomcategorie():string
    {
        return $this->nom_categorie;
    }

    public function setNomCategorie($nom_categorie):void
    {
        $this->nom_categorie = $nom_categorie;
    }
}

class CategorieRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllCategorie()
    {
        $req = $this->bdd->prepare("SELECT * FROM categorie");
        $req->execute();
        $datas = $req->fetchAll();
        $categories = [];
        foreach ($datas as $data) 
        {
            $categorie = new Categorie();
            $categorie->setIdCategorie($data['id_categorie']);
            $categorie->setNomCategorie($data['nom_categorie']);
            
            $categories[] = $categorie;
        }
        return $categories;
    }

}