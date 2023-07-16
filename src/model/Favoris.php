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

        $info = '';

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

        $info = '';

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

    public function insertFavHameconAndUser($id_favoris, $id_hamecon)
    {
        $checkQuery = $this->bdd->prepare("SELECT COUNT(*) FROM hamecon WHERE id_hamecon = ?");
        $checkQuery->execute([$id_hamecon]);
        $rowCount = $checkQuery->fetchColumn();

        if ($rowCount > 0)
        {
            $insertQuery = $this->bdd->prepare("INSERT INTO favoris_hamecon (id_hamecon, id_favoris) VALUES (?,?)");
            $insertQuery->execute([$id_hamecon, $id_favoris]);
        }
        else
        {
            echo 'erreur';
        }
    }

    public function getHameconByIdFav($id_favoris)
    {
        $req = $this->bdd->prepare("SELECT * FROM favoris_hamecon WHERE id_favoris = ?");

        $req->execute([$id_favoris]);

        $datas = $req->fetchAll();

        $info = '';
        
        foreach($datas as $data)
        {
            $info = $data['id_hamecon'];
        }
        
        return $info;
    }

    public function getFavorisByIdHamecon($id_hamecon)
    {
        $req = $this->bdd->prepare("SELECT favoris.id_favoris, favoris.date_ajout_favoris, favoris.id_user
            FROM favoris_hamecon
            INNER JOIN favoris ON favoris_hamecon.id_favoris = favoris.id_favoris
            WHERE favoris_hamecon.id_hamecon = ?");

        $req->execute([$id_hamecon]);

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

    public function deleteFavHameconAndUser($id_favoris, $id_hamecon)
    {
        $deleteQuery = $this->bdd->prepare("DELETE FROM favoris_hamecon WHERE id_hamecon = ? AND id_favoris = ?");
        $deleteQuery->execute([$id_hamecon, $id_favoris]);

        $deleteFav = $this->bdd->prepare("DELETE FROM favoris WHERE id_favoris = ?");
        $deleteFav->execute([$id_favoris]);
    }


    public function insertFavLeurreAndUser($id_favoris, $id_leurre)
    {
        $checkQuery = $this->bdd->prepare("SELECT COUNT(*) FROM leurre WHERE id_leurre = ?");
        $checkQuery->execute([$id_leurre]);
        $rowCount = $checkQuery->fetchColumn();

        if ($rowCount > 0)
        {
            $insertQuery = $this->bdd->prepare("INSERT INTO favoris_leurre (id_leurre, id_favoris) VALUES (?,?)");
            $insertQuery->execute([$id_leurre, $id_favoris]);
        }
        else
        {
            echo 'erreur';
        }
    }

    public function getLeurreByIdFav($id_favoris)
    {
        $req = $this->bdd->prepare("SELECT * FROM favoris_leurre WHERE id_favoris = ?");

        $req->execute([$id_favoris]);

        $datas = $req->fetchAll();

        $info = '';
        
        foreach($datas as $data)
        {
            $info = $data['id_leurre'];
        }
        
        return $info;
    }

    public function getFavorisByIdLeurre($id_leurre)
    {
        $req = $this->bdd->prepare("SELECT favoris.id_favoris, favoris.date_ajout_favoris, favoris.id_user
            FROM favoris_leurre
            INNER JOIN favoris ON favoris_leurre.id_favoris = favoris.id_favoris
            WHERE favoris_leurre.id_leurre = ?");

        $req->execute([$id_leurre]);

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

    public function deleteFavLeurreAndUser($id_favoris, $id_leurre)
    {
        $deleteQuery = $this->bdd->prepare("DELETE FROM favoris_leurre WHERE id_leurre = ? AND id_favoris = ?");
        $deleteQuery->execute([$id_leurre, $id_favoris]);

        $deleteFav = $this->bdd->prepare("DELETE FROM favoris WHERE id_favoris = ?");
        $deleteFav->execute([$id_favoris]);
    }


    public function insertFavLigneAndUser($id_favoris, $id_ligne)
    {
        $checkQuery = $this->bdd->prepare("SELECT COUNT(*) FROM ligne WHERE id_ligne = ?");
        $checkQuery->execute([$id_ligne]);
        $rowCount = $checkQuery->fetchColumn();

        if ($rowCount > 0)
        {
            $insertQuery = $this->bdd->prepare("INSERT INTO favoris_ligne (id_ligne, id_favoris) VALUES (?,?)");
            $insertQuery->execute([$id_ligne, $id_favoris]);
        }
        else
        {
            echo 'erreur';
        }
    }

    public function getLigneByIdFav($id_favoris)
    {
        $req = $this->bdd->prepare("SELECT * FROM favoris_ligne WHERE id_favoris = ?");

        $req->execute([$id_favoris]);

        $datas = $req->fetchAll();

        $info = '';
        
        foreach($datas as $data)
        {
            $info = $data['id_ligne'];
        }
        
        return $info;
    }

    public function getFavorisByIdLigne($id_ligne)
    {
        $req = $this->bdd->prepare("SELECT favoris.id_favoris, favoris.date_ajout_favoris, favoris.id_user
            FROM favoris_ligne
            INNER JOIN favoris ON favoris_ligne.id_favoris = favoris.id_favoris
            WHERE favoris_ligne.id_ligne = ?");

        $req->execute([$id_ligne]);

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

    public function deleteFavLigneAndUser($id_favoris, $id_ligne)
    {
        $deleteQuery = $this->bdd->prepare("DELETE FROM favoris_ligne WHERE id_ligne = ? AND id_favoris = ?");
        $deleteQuery->execute([$id_ligne, $id_favoris]);

        $deleteFav = $this->bdd->prepare("DELETE FROM favoris WHERE id_favoris = ?");
        $deleteFav->execute([$id_favoris]);
    }

    public function insertFavEquipementAndUser($id_favoris, $id_equipement)
    {
        $checkQuery = $this->bdd->prepare("SELECT COUNT(*) FROM equipement WHERE id_equipement = ?");
        $checkQuery->execute([$id_equipement]);
        $rowCount = $checkQuery->fetchColumn();

        if ($rowCount > 0)
        {
            $insertQuery = $this->bdd->prepare("INSERT INTO favoris_equipement (id_equipement, id_favoris) VALUES (?,?)");
            $insertQuery->execute([$id_equipement, $id_favoris]);
        }
        else
        {
            echo 'erreur';
        }
    }

    public function getEquipementByIdFav($id_favoris)
    {
        $req = $this->bdd->prepare("SELECT * FROM favoris_equipement WHERE id_favoris = ?");

        $req->execute([$id_favoris]);

        $datas = $req->fetchAll();

        $info = '';
        
        foreach($datas as $data)
        {
            $info = $data['id_equipement'];
        }
        
        return $info;
    }

    public function getFavorisByIdEquipement($id_equipement)
    {
        $req = $this->bdd->prepare("SELECT favoris.id_favoris, favoris.date_ajout_favoris, favoris.id_user
            FROM favoris_equipement
            INNER JOIN favoris ON favoris_equipement.id_favoris = favoris.id_favoris
            WHERE favoris_equipement.id_equipement = ?");

        $req->execute([$id_equipement]);

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

    public function deleteFavEquipementAndUser($id_favoris, $id_equipement)
    {
        $deleteQuery = $this->bdd->prepare("DELETE FROM favoris_equipement WHERE id_equipement = ? AND id_favoris = ?");
        $deleteQuery->execute([$id_equipement, $id_favoris]);

        $deleteFav = $this->bdd->prepare("DELETE FROM favoris WHERE id_favoris = ?");
        $deleteFav->execute([$id_favoris]);
    }

    public function insertFavFeederAndUser($id_favoris, $id_feeder)
    {
        $checkQuery = $this->bdd->prepare("SELECT COUNT(*) FROM feeder WHERE id_feeder = ?");
        $checkQuery->execute([$id_feeder]);
        $rowCount = $checkQuery->fetchColumn();

        if ($rowCount > 0)
        {
            $insertQuery = $this->bdd->prepare("INSERT INTO favoris_feeder (id_feeder, id_favoris) VALUES (?,?)");
            $insertQuery->execute([$id_feeder, $id_favoris]);
        }
        else
        {
            echo 'erreur';
        }
    }

    public function getFeederByIdFav($id_favoris)
    {
        $req = $this->bdd->prepare("SELECT * FROM favoris_feeder WHERE id_favoris = ?");

        $req->execute([$id_favoris]);

        $datas = $req->fetchAll();

        $info = '';
        
        foreach($datas as $data)
        {
            $info = $data['id_feeder'];
        }
        
        return $info;
    }

    public function getFavorisByIdFeeder($id_feeder)
    {
        $req = $this->bdd->prepare("SELECT favoris.id_favoris, favoris.date_ajout_favoris, favoris.id_user
            FROM favoris_feeder
            INNER JOIN favoris ON favoris_feeder.id_favoris = favoris.id_favoris
            WHERE favoris_feeder.id_feeder = ?");

        $req->execute([$id_feeder]);

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

    public function deleteFavFeederAndUser($id_favoris, $id_feeder)
    {
        $deleteQuery = $this->bdd->prepare("DELETE FROM favoris_feeder WHERE id_feeder = ? AND id_favoris = ?");
        $deleteQuery->execute([$id_feeder, $id_favoris]);

        $deleteFav = $this->bdd->prepare("DELETE FROM favoris WHERE id_favoris = ?");
        $deleteFav->execute([$id_favoris]);
    }

    public function insertFavAppatAndUser($id_favoris, $id_appat)
    {
        $checkQuery = $this->bdd->prepare("SELECT COUNT(*) FROM appat WHERE id_appat = ?");
        $checkQuery->execute([$id_appat]);
        $rowCount = $checkQuery->fetchColumn();

        if ($rowCount > 0)
        {
            $insertQuery = $this->bdd->prepare("INSERT INTO favoris_appat (id_appat, id_favoris) VALUES (?,?)");
            $insertQuery->execute([$id_appat, $id_favoris]);
        }
        else
        {
            echo 'erreur';
        }
    }

    public function getAppatByIdFav($id_favoris)
    {
        $req = $this->bdd->prepare("SELECT * FROM favoris_appat WHERE id_favoris = ?");

        $req->execute([$id_favoris]);

        $datas = $req->fetchAll();

        $info = '';
        
        foreach($datas as $data)
        {
            $info = $data['id_appat'];
        }
        
        return $info;
    }

    public function getFavorisByIdAppat($id_appat)
    {
        $req = $this->bdd->prepare("SELECT favoris.id_favoris, favoris.date_ajout_favoris, favoris.id_user
            FROM favoris_appat
            INNER JOIN favoris ON favoris_appat.id_favoris = favoris.id_favoris
            WHERE favoris_appat.id_appat = ?");

        $req->execute([$id_appat]);

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

    public function deleteFavAppatAndUser($id_favoris, $id_appat)
    {
        $deleteQuery = $this->bdd->prepare("DELETE FROM favoris_appat WHERE id_appat = ? AND id_favoris = ?");
        $deleteQuery->execute([$id_appat, $id_favoris]);

        $deleteFav = $this->bdd->prepare("DELETE FROM favoris WHERE id_favoris = ?");
        $deleteFav->execute([$id_favoris]);
    }
}


?>