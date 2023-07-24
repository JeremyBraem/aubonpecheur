<?php
require_once 'src/config/connectBdd.php';

class Canne
{
    // Les propriétés privées de la classe
    private $id;
    private $longueur;
    private $poids;
    private $type;

    // Le constructeur de la classe pour initialiser les propriétés
    public function __construct($id, $longueur, $poids, $type)
    {
        $this->id = $id;
        $this->longueur = $longueur;
        $this->poids = $poids;
        $this->type = $type;
    }

    // Les getters pour accéder aux propriétés
    public function getId()
    {
        return $this->id;
    }

    public function getLongueur()
    {
        return $this->longueur;
    }

    public function getPoids()
    {
        return $this->poids;
    }

    public function getType()
    {
        return $this->type;
    }
}
