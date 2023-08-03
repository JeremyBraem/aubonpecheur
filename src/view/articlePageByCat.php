<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/reset.css" rel="stylesheet">
    <link href="assets/css/swiper.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <link rel="icon" href="/assets/img/site/icon.png" />
    <!--FLowbite-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <!--Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        clifford: '#da373d',
                    }
                }
            }
        }
    </script>
    <title>Page article</title>
</head>

<body class="bg-[#fcfcfc]">

    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?>
    </header>

    <main>

        <section>

            <div class="bg-[#fcfcfc] w-2/3 m-auto p-6">
                <h1 class="text-center font-semibold">Tous les articles "<?php echo $_GET['categorie'] ?>"</h1>
            </div>

            <div class="bg-[#426EC2] p-1">
                <?php require_once('src/include/filtreCate.php'); ?>
            </div>

            <div>
                <div id="listeArticles" class="p-3 md:p-5 relative flex flex-wrap gap-5 md:gap-7 items-center justify-center">

                    <?php foreach ($produits as $produit) { ?>

                        <?php if ($produit != ['']) { ?>

                            <div class="w-56">

                                <a href="/<?php echo $produit->getNomGenre(); ?>Page/<?php echo $produit->getIdProduit(); ?>">

                                    <div class="w-56">
                                        <img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/<?php echo $produit->getNomImage(); ?>" />
                                    </div>

                                </a>

                                <div class="flex justify-center gap-10 py-3">

                                    <div>

                                        <div class="flex">

                                            <p class="text-s md:text-lg">
                                                <?php
                                                $nom = $produit->getNomProduit();
                                                if (strlen($nom) > 20) {
                                                    echo substr($nom, 0, 17) . '...';
                                                } else {
                                                    echo $nom;
                                                }
                                                ?>
                                            </p>

                                            <p class="ml-10 text-s md:text-xl uppercase">
                                                <?php
                                                $prix = $produit->getPrixProduit() . '€';
                                                if (strlen($prix) > 50) {
                                                    echo substr($prix, 0, 47) . '...';
                                                } else {
                                                    echo $prix;
                                                }
                                                ?>
                                            </p>

                                        </div>
                                        <p class="text-xs md:text-sm uppercase">
                                            <?php
                                            $marque = $produit->getNomMarque();
                                            if (strlen($marque) > 50) {
                                                echo substr($marque, 0, 47) . '...';
                                            } else {
                                                echo $marque;
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                                <button class="add-to-cart-btn" data-name="<?php echo $produit->getNomProduit(); ?>" data-price="<?php echo $produit->getPrixProduit(); ?>" data-image="<?php echo $produit->getNomImage(); ?>" data-genre="<?php echo $produit->getNomGenre(); ?>" data-id="<?php echo $produit->getIdProduit(); ?>">Ajouter au panier</button>
                            </div>

                    <?php } else {
                            echo '';
                        }
                    } ?>

                </div>

            </div>

        </section>

    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once('src/include/footer.php') ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Ajoutez ce script dans la balise <head> ou avant la balise </body> -->
    <script>
        $(document).ready(function() {
            // Fonction pour charger les produits filtrés via AJAX
            function loadFilteredProducts() {
                const marques = [];
                const types = [];

                // Récupérer les valeurs de filtre sélectionnées
                const marqueCheckbox = document.querySelectorAll('.marque-checkbox:checked');
                marqueCheckbox.forEach(checkbox => {
                    marques.push(checkbox.value);
                });

                const typeCheckbox = document.querySelectorAll('.type-checkbox:checked');
                typeCheckbox.forEach(checkbox => {
                    types.push(checkbox.value);
                });

                $.ajax({
                    url: '/', // Remplacez "/path/vers/votre/script_php.php" par le chemin vers votre script PHP de récupération des produits filtrés
                    type: 'POST', // Vous pouvez utiliser 'GET' si vous préférez, mais POST est généralement préféré pour les requêtes qui modifient des données
                    data: {
                        marques: JSON.stringify(marques),
                        types: JSON.stringify(types)
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Mettre à jour le contenu des produits filtrés
                        const filteredProductsContainer = $('#listeArticles');
                        filteredProductsContainer.empty();

                        response.forEach(product => {
                            // Créer un élément HTML pour chaque produit filtré et l'ajouter au conteneur des produits
                            const productHtml = `
                        <div class="w-56">

                            <a href="/<?php echo $produit->getNomGenre(); ?>Page/<?php echo $produit->getIdProduit(); ?>">

                                <div class="w-56">
                                    <img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="/<?php echo $produit->getNomImage(); ?>" />
                                </div>

                            </a>

                            <div class="flex justify-center gap-10 py-3">

                                <div>

                                    <div class="flex">

                                        <p class="text-s md:text-lg">
                                            <?php
                                            $nom = $produit->getNomProduit();
                                            if (strlen($nom) > 20) {
                                                echo substr($nom, 0, 17) . '...';
                                            } else {
                                                echo $nom;
                                            }
                                            ?>
                                        </p>

                                        <p class="ml-10 text-s md:text-xl uppercase">
                                            <?php
                                            $prix = $produit->getPrixProduit() . '€';
                                            if (strlen($prix) > 50) {
                                                echo substr($prix, 0, 47) . '...';
                                            } else {
                                                echo $prix;
                                            }
                                            ?>
                                        </p>

                                    </div>
                                    <p class="text-xs md:text-sm uppercase">
                                        <?php
                                        $marque = $produit->getNomMarque();
                                        if (strlen($marque) > 50) {
                                            echo substr($marque, 0, 47) . '...';
                                        } else {
                                            echo $marque;
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <button class="add-to-cart-btn" data-name="<?php echo $produit->getNomProduit(); ?>" data-price="<?php echo $produit->getPrixProduit(); ?>" data-image="<?php echo $produit->getNomImage(); ?>" data-genre="<?php echo $produit->getNomGenre(); ?>" data-id="<?php echo $produit->getIdProduit(); ?>">Ajouter au panier</button>
                        </div>
                        `;
                            filteredProductsContainer.append(productHtml);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de la récupération des produits filtrés.');
                    }
                });
            }

            // Fonction pour gérer le changement d'état des checkbox de filtre
            function handleFilterChange(event) {
                loadFilteredProducts();
            }

            // Ajouter des écouteurs d'événement pour les checkbox de filtre
            $('.marque-checkbox, .type-checkbox').on('change', handleFilterChange);
        });
    </script>


</body>

</html>