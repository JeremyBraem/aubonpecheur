<?php
require_once 'src/config/connectBdd.php';
require_once 'src/model/Image.php';

class Produit extends Image
{
    private $id_article;
    private $nom_article;
    private $description_article;
    private $prix_article;
    private $stock_article;
    private $promo_article;
    private $prix_promo_article;
    private $id_categorie;
    private $nom_categorie;
    private $id_genre;
    private $nom_genre;
    private $id_marque;
    private $nom_marque;

    public function getIdProduit(): int
    {
        return $this->id_article;
    }

    public function setIdProduit(int $id_article): void 
    {
        $this->id_article = $id_article;
    }

    public function getNomProduit(): string 
    {
        return $this->nom_article;
    }

    public function setNomProduit(string $nom_article): void 
    {
        $this->nom_article = $nom_article;
    }

    public function getDescriptionProduit(): string 
    {
        return $this->description_article;
    }

    public function setDescriptionProduit(string $description_article): void 
    {
        $this->description_article = $description_article;
    }

    public function getPrixProduit(): float 
    {
        return $this->prix_article;
    }

    public function setPrixProduit(float $prix_article): void 
    {
        $this->prix_article = $prix_article;
    }

    public function getStockProduit(): int 
    {
        return $this->stock_article;
    }

    public function setStockProduit(int $stock_article): void 
    {
        $this->stock_article = $stock_article;
    }

    public function getPromoProduit(): int 
    {
        return $this->promo_article;
    }

    public function setPromoProduit(int $promo_article): void 
    {
        $this->promo_article = $promo_article;
    }

    public function getPrixPromoProduit(): float 
    {
        return $this->prix_promo_article;
    }

    public function setPrixPromoProduit(float $prix_promo_article): void 
    {
        $this->prix_promo_article = $prix_promo_article;
    }

    public function getIdCategorie(): int 
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(int $id_categorie): void 
    {
        $this->id_categorie = $id_categorie;
    }

    public function getNomCategorie(): string 
    {
        return $this->nom_categorie;
    }

    public function setNomCategorie(string $nom_categorie): void 
    {
        $this->nom_categorie = $nom_categorie;
    }

    public function getIdGenre(): int 
    {
        return $this->id_genre;
    }

    public function setIdGenre(int $id_genre): void 
    {
        $this->id_genre = $id_genre;
    }

    public function getNomGenre(): string 
    {
        return $this->nom_genre;
    }

    public function setNomGenre(string $nom_genre): void 
    {
        $this->nom_genre = $nom_genre;
    }

    public function getIdMarque(): int 
    {
        return $this->id_marque;
    }

    public function setIdMarque(int $id_marque): void 
    {
        $this->id_marque = $id_marque;
    }

    public function getNomMarque(): string 
    {
        return $this->nom_marque;
    }

    public function setNomMarque(string $nom_marque): void 
    {
        $this->nom_marque = $nom_marque;
    }
}

class ProduitRepository extends connectBdd
{
    public function getAllProducts()
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*
                FROM produit
                LEFT JOIN marque ON produit.id_marque = marque.id_marque
                LEFT JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit
                LEFT JOIN genre ON genre.id_genre = produit.id_genre
                ORDER BY produit.id_produit DESC
            ");

            $req->execute();

            $productsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($productsData as $productData)
            {
                $product = new Produit();
                $product->setIdProduit($productData['id_produit']);
                $product->setNomProduit($productData['nom_produit']);
                $product->setDescriptionProduit($productData['description_produit']);
                $product->setPrixProduit($productData['prix_produit']);
                $product->setPromoProduit($productData['promo_produit']);
                $product->setPrixPromoProduit($productData['prix_promo_produit']);
                $product->setStockProduit($productData['stock_produit']);
                $product->setIdCategorie($productData['id_categorie']);
                $product->setNomCategorie($productData['nom_categorie']);
                $product->setIdMarque($productData['id_marque']);
                $product->setNomMarque($productData['nom_marque']);
                $product->setIdGenre($productData['id_genre']);
                $product->setNomGenre($productData['nom_genre']);
                $product->setNomImage($productData['nom_image']);
                $product->setIdImage($productData['id_image']);
                $product->setDescriptionImage($productData['description_image']);

                $products[] = $product;
            }

            return $products;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des produits : " . $e->getMessage());
        }
    }

    public function getAllPromoProducts()
    {
        try 
        {
            $req = $this->bdd->prepare("
                SELECT produit.*, marque.*, categorie.*, 
                image.*, genre.*
                FROM produit
                LEFT JOIN marque ON produit.id_marque = marque.id_marque
                LEFT JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit
                LEFT JOIN genre ON genre.id_genre = produit.id_genre
                WHERE produit.promo_produit > 0
                ORDER BY produit.id_produit DESC
            ");

            $req->execute();

            $productsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($productsData as $productData)
            {
                $product = new Produit();
                $product->setIdProduit($productData['id_produit']);
                $product->setNomProduit($productData['nom_produit']);
                $product->setDescriptionProduit($productData['description_produit']);
                $product->setPrixProduit($productData['prix_produit']);
                $product->setPromoProduit($productData['promo_produit']);
                $product->setPrixPromoProduit($productData['prix_promo_produit']);
                $product->setStockProduit($productData['stock_produit']);
                $product->setIdCategorie($productData['id_categorie']);
                $product->setNomCategorie($productData['nom_categorie']);
                $product->setIdMarque($productData['id_marque']);
                $product->setNomMarque($productData['nom_marque']);
                $product->setIdGenre($productData['id_genre']);
                $product->setNomGenre($productData['nom_genre']);
                $product->setNomImage($productData['nom_image']);
                $product->setIdImage($productData['id_image']);
                $product->setDescriptionImage($productData['description_image']);

                $products[] = $product;
            }
            return $products;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des produits en promo : " . $e->getMessage());
        }
    }

    public function getLastId()
    {
        $req = $this->bdd->prepare("SELECT MAX(id_produit) AS last_id FROM produit");
        
        $req->execute();

        $result = $req->fetch(PDO::FETCH_ASSOC);

        $lastId = $result['last_id'];

        return $lastId;
    }

    public function getAllProductsByCategory($id_categorie)
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.nom_marque, categorie.*, 
                image.*, genre.*
                FROM produit
                LEFT JOIN marque ON produit.id_marque = marque.id_marque
                LEFT JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit
                LEFT JOIN genre ON genre.id_genre = produit.id_genre
                WHERE produit.id_categorie = ?
                ORDER BY produit.id_produit DESC
            ");

            $req->execute([$id_categorie]);

            $productsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($productsData as $productData)
            {
                $product = new Produit();
                $product->setIdProduit($productData['id_produit']);
                $product->setNomProduit($productData['nom_produit']);
                $product->setDescriptionProduit($productData['description_produit']);
                $product->setPrixProduit($productData['prix_produit']);
                $product->setPromoProduit($productData['promo_produit']);
                $product->setPrixPromoProduit($productData['prix_promo_produit']);
                $product->setStockProduit($productData['stock_produit']);
                $product->setIdCategorie($productData['id_categorie']);
                $product->setNomCategorie($productData['nom_categorie']);
                $product->setIdMarque($productData['id_marque']);
                $product->setNomMarque($productData['nom_marque']);
                $product->setIdGenre($productData['id_genre']);
                $product->setNomGenre($productData['nom_genre']);
                $product->setNomImage($productData['nom_image']);
                $product->setIdImage($productData['id_image']);
                $product->setDescriptionImage($productData['description_image']);

                $products[] = $product;
            }

            return $products;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des produits : " . $e->getMessage());
        }
    }

    public function getAllProductsByMarque($id_marque)
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.nom_marque, categorie.*, 
                image.*, genre.*
                FROM produit
                LEFT JOIN marque ON produit.id_marque = marque.id_marque
                LEFT JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit
                LEFT JOIN genre ON genre.id_genre = produit.id_genre
                WHERE produit.id_marque = ?
                ORDER BY produit.id_produit DESC
            ");

            $req->execute([$id_marque]);

            $productsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($productsData as $productData)
            {
                $product = new Produit();
                $product->setIdProduit($productData['id_produit']);
                $product->setNomProduit($productData['nom_produit']);
                $product->setDescriptionProduit($productData['description_produit']);
                $product->setPrixProduit($productData['prix_produit']);
                $product->setPromoProduit($productData['promo_produit']);
                $product->setPrixPromoProduit($productData['prix_promo_produit']);
                $product->setStockProduit($productData['stock_produit']);
                $product->setIdCategorie($productData['id_categorie']);
                $product->setNomCategorie($productData['nom_categorie']);
                $product->setIdMarque($productData['id_marque']);
                $product->setNomMarque($productData['nom_marque']);
                $product->setIdGenre($productData['id_genre']);
                $product->setNomGenre($productData['nom_genre']);
                $product->setNomImage($productData['nom_image']);
                $product->setIdImage($productData['id_image']);
                $product->setDescriptionImage($productData['description_image']);

                $products[] = $product;
            }

            return $products;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des produits : " . $e->getMessage());
        }
    }

    public function getProductsByGenre($id_genre)
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.nom_marque, categorie.*, 
                image.*, genre.*
                FROM produit
                LEFT JOIN marque ON produit.id_marque = marque.id_marque
                LEFT JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit
                LEFT JOIN genre ON genre.id_genre = produit.id_genre
                WHERE produit.id_genre = ?
                ORDER BY produit.id_produit DESC
            ");

            $req->execute([$id_genre]);

            $productsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($productsData as $productData)
            {
                $product = new Produit();
                $product->setIdProduit($productData['id_produit']);
                $product->setNomProduit($productData['nom_produit']);
                $product->setDescriptionProduit($productData['description_produit']);
                $product->setPrixProduit($productData['prix_produit']);
                $product->setPromoProduit($productData['promo_produit']);
                $product->setPrixPromoProduit($productData['prix_promo_produit']);
                $product->setStockProduit($productData['stock_produit']);
                $product->setIdCategorie($productData['id_categorie']);
                $product->setNomCategorie($productData['nom_categorie']);
                $product->setIdMarque($productData['id_marque']);
                $product->setNomMarque($productData['nom_marque']);
                $product->setIdGenre($productData['id_genre']);
                $product->setNomGenre($productData['nom_genre']);
                $product->setNomImage($productData['nom_image']);
                $product->setIdImage($productData['id_image']);
                $product->setDescriptionImage($productData['description_image']);

                $products[] = $product;
            }

            return $products;
        } 
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des produits : " . $e->getMessage());
        }
    }

    public function getSearchProduit($search)
    {    
        $req = $this->bdd->prepare("SELECT produit.*, marque.nom_marque, categorie.*, image.*, genre.*
        FROM produit

        LEFT JOIN marque ON produit.id_marque = marque.id_marque
        LEFT JOIN categorie ON produit.id_categorie = categorie.id_categorie
        LEFT JOIN image ON image.id_produit = produit.id_produit
        LEFT JOIN genre ON genre.id_genre = produit.id_genre
        WHERE nom_produit LIKE ? OR description_produit LIKE ? OR nom_marque LIKE ? OR nom_genre LIKE ? OR nom_categorie LIKE ?

        ORDER BY produit.id_produit DESC");
    
        
        $searchTerm = '%' . $search . '%';

        $req->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);

        $data = $req->fetchAll(PDO::FETCH_ASSOC);

        $products = [];

        foreach ($data as $productData)
        {
            $product = new Produit();
            $product->setIdProduit($productData['id_produit']);
            $product->setNomProduit($productData['nom_produit']);
            $product->setDescriptionProduit($productData['description_produit']);
            $product->setPrixProduit($productData['prix_produit']);
            $product->setPromoProduit($productData['promo_produit']);
            $product->setPrixPromoProduit($productData['prix_promo_produit']);
            $product->setStockProduit($productData['stock_produit']);
            $product->setIdCategorie($productData['id_categorie']);
            $product->setNomCategorie($productData['nom_categorie']);
            $product->setIdMarque($productData['id_marque']);
            $product->setNomMarque($productData['nom_marque']);
            $product->setIdGenre($productData['id_genre']);
            $product->setNomGenre($productData['nom_genre']);
            $product->setNomImage($productData['nom_image']);
            $product->setIdImage($productData['id_image']);
            $product->setDescriptionImage($productData['description_image']);

            $products[] = $product;
        }

        return $products;
    }

    public function getTotalPromoProducts()
    {
        $query = "SELECT COUNT(*) as total FROM produit WHERE promo_produit > 0";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function getPromoProductsPaginated($offset, $limit)
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.nom_marque, categorie.*, 
                image.*, genre.*
                FROM produit
                LEFT JOIN marque ON produit.id_marque = marque.id_marque
                LEFT JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit
                LEFT JOIN genre ON genre.id_genre = produit.id_genre
                WHERE produit.promo_produit > 0
                ORDER BY produit.id_produit DESC LIMIT ?, ? 
            ");

            $req->bindValue(1, $offset, PDO::PARAM_INT);
            $req->bindValue(2, $limit, PDO::PARAM_INT);
            $req->execute();
            
            $productsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($productsData as $productData)
            {
                $product = new Produit();
                $product->setIdProduit($productData['id_produit']);
                $product->setNomProduit($productData['nom_produit']);
                $product->setDescriptionProduit($productData['description_produit']);
                $product->setPrixProduit($productData['prix_produit']);
                $product->setPromoProduit($productData['promo_produit']);
                $product->setPrixPromoProduit($productData['prix_promo_produit']);
                $product->setStockProduit($productData['stock_produit']);
                $product->setIdCategorie($productData['id_categorie']);
                $product->setNomCategorie($productData['nom_categorie']);
                $product->setIdMarque($productData['id_marque']);
                $product->setNomMarque($productData['nom_marque']);
                $product->setIdGenre($productData['id_genre']);
                $product->setNomGenre($productData['nom_genre']);
                $product->setNomImage($productData['nom_image']);
                $product->setIdImage($productData['id_image']);
                $product->setDescriptionImage($productData['description_image']);

                $products[] = $product;
            }
           
            return $products;
        }   
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des produits en promo : " . $e->getMessage());
        }
    }

    public function getTotalCateProducts($id_categorie)
    {
        $query = "SELECT COUNT(*) as total FROM produit WHERE produit.id_categorie = ?";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute([$id_categorie]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function getCateProductsPaginated($offset, $limit, $id_categorie)
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.nom_marque, categorie.*, 
                image.*, genre.*
                FROM produit
                LEFT JOIN marque ON produit.id_marque = marque.id_marque
                LEFT JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit
                LEFT JOIN genre ON genre.id_genre = produit.id_genre
                WHERE produit.id_categorie = ?
                ORDER BY produit.id_produit DESC LIMIT ?, ? 
            ");

            $req->bindValue(1, $id_categorie, PDO::PARAM_STR);
            $req->bindValue(2, $offset, PDO::PARAM_INT);
            $req->bindValue(3, $limit, PDO::PARAM_INT);
            $req->execute();
            
            $productsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($productsData as $productData)
            {
                $product = new Produit();
                $product->setIdProduit($productData['id_produit']);
                $product->setNomProduit($productData['nom_produit']);
                $product->setDescriptionProduit($productData['description_produit']);
                $product->setPrixProduit($productData['prix_produit']);
                $product->setPromoProduit($productData['promo_produit']);
                $product->setPrixPromoProduit($productData['prix_promo_produit']);
                $product->setStockProduit($productData['stock_produit']);
                $product->setIdCategorie($productData['id_categorie']);
                $product->setNomCategorie($productData['nom_categorie']);
                $product->setIdMarque($productData['id_marque']);
                $product->setNomMarque($productData['nom_marque']);
                $product->setIdGenre($productData['id_genre']);
                $product->setNomGenre($productData['nom_genre']);
                $product->setNomImage($productData['nom_image']);
                $product->setIdImage($productData['id_image']);
                $product->setDescriptionImage($productData['description_image']);

                $products[] = $product;
            }
           
            return $products;
        }   
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des produits en promo : " . $e->getMessage());
        }
    }

    public function getTotalMarqueProducts($id_marque)
    {
        $query = "SELECT COUNT(*) as total FROM produit WHERE produit.id_marque = ?";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute([$id_marque]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function getMarqueProductsPaginated($offset, $limit, $id_marque)
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.nom_marque, categorie.*, 
                image.*, genre.*
                FROM produit
                LEFT JOIN marque ON produit.id_marque = marque.id_marque
                LEFT JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit
                LEFT JOIN genre ON genre.id_genre = produit.id_genre
                WHERE produit.id_marque = ?
                ORDER BY produit.id_produit DESC LIMIT ?, ? 
            ");

            $req->bindValue(1, $id_marque, PDO::PARAM_STR);
            $req->bindValue(2, $offset, PDO::PARAM_INT);
            $req->bindValue(3, $limit, PDO::PARAM_INT);
            $req->execute();
            
            $productsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($productsData as $productData)
            {
                $product = new Produit();
                $product->setIdProduit($productData['id_produit']);
                $product->setNomProduit($productData['nom_produit']);
                $product->setDescriptionProduit($productData['description_produit']);
                $product->setPrixProduit($productData['prix_produit']);
                $product->setPromoProduit($productData['promo_produit']);
                $product->setPrixPromoProduit($productData['prix_promo_produit']);
                $product->setStockProduit($productData['stock_produit']);
                $product->setIdCategorie($productData['id_categorie']);
                $product->setNomCategorie($productData['nom_categorie']);
                $product->setIdMarque($productData['id_marque']);
                $product->setNomMarque($productData['nom_marque']);
                $product->setIdGenre($productData['id_genre']);
                $product->setNomGenre($productData['nom_genre']);
                $product->setNomImage($productData['nom_image']);
                $product->setIdImage($productData['id_image']);
                $product->setDescriptionImage($productData['description_image']);

                $products[] = $product;
            }
           
            return $products;
        }   
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des produits en promo : " . $e->getMessage());
        }
    }

    public function getAllProductsPaginated($offset, $limit)
    {
        try 
        {
            $req = $this->bdd->prepare
            ("
                SELECT produit.*, marque.nom_marque, categorie.*, 
                image.*, genre.*
                FROM produit
                LEFT JOIN marque ON produit.id_marque = marque.id_marque
                LEFT JOIN categorie ON produit.id_categorie = categorie.id_categorie
                LEFT JOIN image ON image.id_produit = produit.id_produit
                LEFT JOIN genre ON genre.id_genre = produit.id_genre
                ORDER BY produit.id_produit DESC LIMIT ?, ? 
            ");

            $req->bindValue(1, $offset, PDO::PARAM_INT);
            $req->bindValue(2, $limit, PDO::PARAM_INT);
            $req->execute();
            
            $productsData = $req->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($productsData as $productData)
            {
                $product = new Produit();
                $product->setIdProduit($productData['id_produit']);
                $product->setNomProduit($productData['nom_produit']);
                $product->setDescriptionProduit($productData['description_produit']);
                $product->setPrixProduit($productData['prix_produit']);
                $product->setPromoProduit($productData['promo_produit']);
                $product->setPrixPromoProduit($productData['prix_promo_produit']);
                $product->setStockProduit($productData['stock_produit']);
                $product->setIdCategorie($productData['id_categorie']);
                $product->setNomCategorie($productData['nom_categorie']);
                $product->setIdMarque($productData['id_marque']);
                $product->setNomMarque($productData['nom_marque']);
                $product->setIdGenre($productData['id_genre']);
                $product->setNomGenre($productData['nom_genre']);
                $product->setNomImage($productData['nom_image']);
                $product->setIdImage($productData['id_image']);
                $product->setDescriptionImage($productData['description_image']);

                $products[] = $product;
            }
            return $products;
        }   
        catch (PDOException $e) 
        {
            die("Erreur lors de la récupération des produits en promo : " . $e->getMessage());
        }
    }

    public function existProduit($id_produit)
    {
        $req = $this->bdd->prepare("SELECT id_produit FROM produit WHERE id_produit = ?");
        $req->execute([$id_produit]);
        $data = $req->fetch();
        
        if($data)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}