<?php

require_once ('src/config/connectBdd.php');

class Favoris
{
    private $id_favoris;
    private $date_ajout_favoris;
    private $note_favoris;
    private $id_user;

    public function createToInsertFavoris($favorisForm):bool
    {
        if(!isset($favorisForm['date_ajout_favoris']) OR $favorisForm['date_ajout_favoris'] == '')
        {
            return false;
        }

        if(!isset($favorisForm['id_user']) OR $favorisForm['id_user'] == '')
        {
            return false;
        }

        $this->date_ajout_favoris = $favorisForm['date_ajout_favoris'];
        $this->id_user = $favorisForm['id_user'];

        return true;
    }

    public function getIdFavoris():int
    {
        return $this->id_favoris;
    }

    public function setIdFavoris($id_favoris):void
    {
        $this->id_favoris = $id_favoris;
    }

    public function getDateFavoris():string
    {
        return $this->date_ajout_favoris;
    }

    public function setDateFavoris($date_ajout_favoris):void
    {
        $this->date_ajout_favoris = $date_ajout_favoris;
    }

    public function getNoteFavoris():string
    {
        return $this->note_favoris;
    }

    public function setNoteFavoris($note_favoris):void
    {
        $this->note_favoris = $note_favoris;
    }

    public function getIdUser():string
    {
        return $this->id_user;
    }

    public function setIdUser($id_user):void
    {
        $this->id_user = $id_user;
    }
}

class FavorisRepository extends connectBdd
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertFavoris(Favoris $favoris)
    {
        $req = $this->bdd->prepare("INSERT INTO favoris (date_ajout_favoris, id_user)
        VALUES (?,?)");

        $req->execute
        ([
            $favoris->getDateFavoris(),
            $favoris->getIdUser(),
           
        ]);
    }

    public function getLastInsertIdFavoris()
    {
        $query = "SELECT MAX(id_favoris) AS last_id FROM favoris";
        $result = $this->bdd->prepare($query);

        if ($result->execute()) 
        {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $lastId = $row['last_id'];

            return $lastId;
        }
    }

    public function insertFavCanneAndUser($id_favoris, $id_canne)
    {
        $checkQuery = $this->bdd->prepare("SELECT COUNT(*) FROM canne WHERE id_canne = ?");
        $checkQuery->execute([$id_canne]);
        $rowCount = $checkQuery->fetchColumn();

        if ($rowCount > 0)
        {
            $insertQuery = $this->bdd->prepare("INSERT INTO favoris_canne (id_canne, id_favoris) VALUES (?,?)");
            $insertQuery->execute([$id_canne, $id_favoris]);
        }
        else
        {
            echo 'erreur';
        }
    }

}

?>