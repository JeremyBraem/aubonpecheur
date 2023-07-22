<?php 
require_once 'src/model/Produit.php';

class Canne extends Produit
{
    private $longueur_canne;
    private $poids_canne;
    private $id_type_canne;

    public function __construct($nom_produit, $description_produit, $prix_produit, $stock_produit, $promo_produit, $prix_promo_produit, $id_categorie, $id_marque, $id_genre, $longueur_canne, $poids_canne, $id_type_canne)
    {
        parent::__construct($nom_produit, $description_produit, $prix_produit, $stock_produit, $promo_produit, $prix_promo_produit, $id_categorie, $id_marque, $id_genre);
        $this->longueur_canne = $longueur_canne;
        $this->poids_canne = $poids_canne;
        $this->id_type_canne = $id_type_canne;
    }

    public function getLongueurCanne(): float
    {
        return $this->longueur_canne;
    }

    public function setLongueurCanne($longueur_canne): void
    {
        $this->longueur_canne = $longueur_canne;
    }

    public function getPoidsCanne(): float
    {
        return $this->poids_canne;
    }

    public function setPoidsCanne($poids_canne): void
    {
        $this->poids_canne = $poids_canne;
    }

    public function getTypeCanne(): int
    {
        return $this->id_type_canne;
    }

    public function setTypeCanne($id_type_canne): void
    {
        $this->id_type_canne = $id_type_canne;
    }

    
}
