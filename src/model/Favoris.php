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

    public function getFavorisByIdUser($id_user)
    {
        $req = $this->bdd->prepare("SELECT * FROM favoris WHERE id_user = ?");

        $req->execute([$id_user]);

        $datas = $req->fetchAll();

        $favoris = [];

        foreach($datas as $data)
        {
            $favorie = new Favoris();
            $favorie->setIdFavoris($data['id_favoris']);
            $favorie->setDateFavoris($data['date_ajout_favoris']);
            $favorie->setNoteFavoris($data['note_favoris']);
            $favorie->setIdUser($data['id_user']);

            $favoris[] = $favorie;
        }
        return $favoris;
    }

    public function getCanneByIdFav($id_favoris)
    {
        $req = $this->bdd->prepare("SELECT * FROM favoris_canne WHERE id_favoris = ?");

        $req->execute([$id_favoris]);

        $datas = $req->fetchAll();

        foreach($datas as $data)
        {
            $info = $data['id_canne'];
        }
        return $info;
    }

    public function deleteFavCanneAndUser($id_favoris, $id_canne)
    {
        $deleteQuery = $this->bdd->prepare("DELETE FROM favoris_canne WHERE id_canne = ? AND id_favoris = ?");
        $deleteQuery->execute([$id_canne, $id_favoris]);

        $deleteFav = $this->bdd->prepare("DELETE FROM favoris WHERE id_favoris = ?");
        $deleteFav->execute([$id_favoris]);
    }

    public function getFavorisByIdCanne($id_canne)
    {
        $req = $this->bdd->prepare("SELECT favoris.id_favoris, favoris.date_ajout_favoris, favoris.id_user
            FROM favoris_canne
            INNER JOIN favoris ON favoris_canne.id_favoris = favoris.id_favoris
            WHERE favoris_canne.id_canne = ?");

        $req->execute([$id_canne]);

        $datas = $req->fetchAll(PDO::FETCH_ASSOC);

        $favoris = [];

        foreach($datas as $data)
        {
            $favori = new Favoris();
            $favori->setIdFavoris($data['id_favoris']);
            $favori->setDateFavoris($data['date_ajout_favoris']);
            $favori->setIdUser($data['id_user']);

            $favoris[] = $favori;
        }

        return $favoris;
    }


    public function insertFavMoulinetAndUser($id_favoris, $id_moulinet)
    {
        $checkQuery = $this->bdd->prepare("SELECT COUNT(*) FROM moulinet WHERE id_moulinet = ?");
        $checkQuery->execute([$id_moulinet]);
        $rowCount = $checkQuery->fetchColumn();

        if ($rowCount > 0)
        {
            $insertQuery = $this->bdd->prepare("INSERT INTO favoris_moulinet (id_moulinet, id_favoris) VALUES (?,?)");
            $insertQuery->execute([$id_moulinet, $id_favoris]);
        }
        else
        {
            echo 'erreur';
        }
    }

    public function getMoulinetByIdFav($id_favoris)
    {
        $req = $this->bdd->prepare("SELECT * FROM favoris_moulinet WHERE id_favoris = ?");

        $req->execute([$id_favoris]);

        $datas = $req->fetchAll();

        foreach($datas as $data)
        {
            $info = $data['id_moulinet'];
        }
        return $info;
    }

    public function getFavorisByIdMoulinet($id_moulinet)
    {
        $req = $this->bdd->prepare("SELECT favoris.id_favoris, favoris.date_ajout_favoris, favoris.id_user
            FROM favoris_moulinet
            INNER JOIN favoris ON favoris_moulinet.id_favoris = favoris.id_favoris
            WHERE favoris_moulinet.id_moulinet = ?");

        $req->execute([$id_moulinet]);

        $datas = $req->fetchAll(PDO::FETCH_ASSOC);

        $favoris = [];

        foreach($datas as $data)
        {
            $favori = new Favoris();
            $favori->setIdFavoris($data['id_favoris']);
            $favori->setDateFavoris($data['date_ajout_favoris']);
            $favori->setIdUser($data['id_user']);

            $favoris[] = $favori;
        }

        return $favoris;
    }

    public function deleteFavMoulinetAndUser($id_favoris, $id_moulinet)
    {
        $deleteQuery = $this->bdd->prepare("DELETE FROM favoris_moulinet WHERE id_moulinet = ? AND id_favoris = ?");
        $deleteQuery->execute([$id_moulinet, $id_favoris]);

        $deleteFav = $this->bdd->prepare("DELETE FROM favoris WHERE id_favoris = ?");
        $deleteFav->execute([$id_favoris]);
    }
}


?>