<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/css/reset.css" rel="stylesheet">
    <link href="/assets/css/font.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <link rel="icon" href="/assets/img/site/icon.png" />
    <!--FLowbite-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <!--Tailwind -->
    <link href="/dist/output.css" rel="stylesheet">
    <title>Page des Promotions</title>
</head>

<body class="bg-[#fcfcfc]">

    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?>
    </header>

    <main>

        <section>

            <div class="bg-[#fcfcfc] w-2/3 m-auto p-6">
                <h1 class="text-center font-semibold">Tous les articles en Promotion</h1>
            </div>

            <div class="bg-[#426EC2] p-1">
                <?php require_once('src/include/filtre.php'); ?>
            </div>

            <div>

                <div id="listeArticles" class="p-3 md:p-20 relative flex flex-wrap gap-5 md:gap-7 items-center justify-center">

                    <?php foreach ($promoProduits as $produit) { ?>

                        <?php if ($produit != ['']) { ?>

                            <div class="w-56">

                                <a href="/<?php echo $produit->getNomGenre(); ?>Page/<?php echo $produit->getIdProduit(); ?>">

                                    <div class="w-56">
                                        <img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="<?php echo $produit->getNomImage(); ?>" />
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
                                <button id="profil-button" class="bg-[#426EC2] rounded-full p-2">
                                    <img class="add-to-cart-btn w-6 h-6" data-name="<?php echo $produit->getNomProduit(); ?>" data-price="<?php echo $produit->getPrixProduit(); ?>" data-image="<?php echo $produit->getNomImage(); ?>" data-genre="<?php echo $produit->getNomGenre(); ?>" data-id="<?php echo $produit->getIdProduit(); ?>" src="/assets/img/site/addCart.png">
                                </button>
                            </div>

                        <?php } else {
                            echo '';
                        } ?>

                    <?php } ?>

                </div>
                <div class="flex justify-center mb-10">
                    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                        <div class="flex flex-1 justify-between sm:hidden">
                            <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                            <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                        </div>
                        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                            <div>
                                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination" id="pagination">
                                    <?php if ($currentpage > 1) { ?>
                                        <a href="/promotion&page=<?php echo $_GET['page'] - 1 ?>" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    <?php } ?>

                                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                        <a class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 focus:z-20 focus:outline-offset-0" href="/promotion&page=<?php echo $i ?>"><?php echo $i ?></a>
                                    <?php } ?>

                                    <?php if ($currentpage < $totalPages) { ?>
                                        <a href="/promotion&page=<?php echo $_GET['page'] + 1 ?>" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    <?php } ?>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once('src/include/footer.php') ?>
    </footer>

    <script src="/assets/js/filtrePromo.js"></script>
</body>

</html>