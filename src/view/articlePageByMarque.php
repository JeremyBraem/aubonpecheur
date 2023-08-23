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

    <title>Page d'articles <?php echo $_GET['marque'] ?> - Au Bon Pêcheur</title>
</head>

<body class="bg-[#fcfcfc]">

    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?>
    </header>

    <main>

        <section>

            <div class="bg-[#fcfcfc] w-2/3 m-auto p-6">
                <h1 class="text-center font-semibold">Tous les articles "<?php echo $_GET['marque'] ?>"</h1>
            </div>

            <div class="bg-[#426EC2] p-1">
                <?php require_once('src/include/filtreMarque.php'); ?>
            </div>

            <div>
                <div id="listeArticles" class="p-3 md:p-20 relative flex flex-wrap gap-5 md:gap-7 items-center justify-center">

                    <?php foreach ($produits as $produit) { ?>

                    <?php if ($produit != ['']) { ?>

                    <div class="w-56">

                        <div class="flex flex-col justify-center">

                            <div class="relative m-3 flex flex-wrap mx-auto justify-center ">

                                <div class="relative bg-white shadow-md p-2 my-3 rounded">

                                    <div class="overflow-x-hidden rounded-2xl relative w-56 h-56">
                                        <?php if ($produit->getPromoProduit() > 0) { ?>
                                            <span class="original-number absolute text-[#fcfcfc] text-sm left-2 top-2 z-40 p-1 px-[9px] w-auto text-center font-semibold rounded-full bg-[#e8330d]">-<?php echo $produit->getPromoProduit(); ?>%</span>
                                        <?php } ?>
                                        <img class="h-full rounded-2xl w-full object-cover" src="/<?php echo $produit->getNomImage() ?>">
                                        <p class="absolute right-2 top-2 bg-[#426EC2] rounded-full p-2 cursor-pointer group">
                                            <img class="add-to-cart-btn w-6 h-6" data-name="<?php echo $produit->getNomProduit(); ?>" 
                                            data-price="<?php if ($produit->getPromoProduit() > 0) 
                                            {
                                                echo $produit->getPrixPromoProduit();
                                            } 
                                            else 
                                            {
                                                echo $produit->getPrixProduit();
                                            } ?>" 
                                            data-image="<?php echo $produit->getNomImage(); ?>" 
                                            data-genre="<?php echo $produit->getNomGenre(); ?>" 
                                            data-id="<?php echo $produit->getIdProduit(); ?>" src="/assets/img/site/addCart.png">
                                        </p>
                                    </div>

                                    <div class="mt-4 pl-2 mb-2 flex justify-between ">
                                        <a href="/<?php echo $produit->getNomGenre(); ?>Page/<?php echo $produit->getIdProduit(); ?>">
                                            <p class="text-lg font-semibold text-gray-900 mb-0"><?php echo $produit->getNomProduit(); ?></p>
                                            <p class="text-lg text-gray-900 mb-0"><?php echo $produit->getNomMarque(); ?></p>
                                            <div class="flex gap-10">
                                                <?php if ($produit->getPromoProduit() > 0) { ?>
                                                    <p class="text-md text-gray-800 mt-0 line-through"><?php echo number_format($produit->getPrixProduit(), 2, '.', '') ?>€</p>
                                                    <p class="number text-md text-gray-800 mt-0"><?php echo number_format($produit->getPrixPromoProduit(), 2, '.', '') ?>€</p>
                                                <?php } else { ?>
                                                    <p class="text-md text-gray-800 mt-0"><?php echo number_format($produit->getPrixProduit(), 2, '.', '') ?>€</p>
                                                <?php } ?>
                                            </div>

                                        </a>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <?php } else {
                            echo '';
                        }
                    } ?>

                </div>

                <div id="pagination">
                    <div class="flex justify-center mb-10">
                        <div class="flex items-center justify-between px-4 py-3 sm:px-6">
                            <div class="sm:flex sm:flex-1 sm:items-center sm:justify-between">
                                <div>
                                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination" >
                                        <?php if ($currentpage > 1) { ?>
                                            <a href="/marque/<?php echo $_GET['marque'] ?>&page=<?php echo $_GET['page'] - 1 ?>" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                                <span class="sr-only">Previous</span>
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        <?php } ?>

                                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                            <a class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 focus:z-20 focus:outline-offset-0" href="/marque/<?php echo $_GET['marque'] ?>&page=<?php echo $i ?>"><?php echo $i ?></a>
                                        <?php } ?>

                                        <?php if ($currentpage < $totalPages) { ?>
                                            <a href="/marque/<?php echo $_GET['marque'] ?>&page=<?php if(isset($_GET['page'])){ echo $_GET['page'] + 1; }else{ echo 2;}  ?>" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
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

            </div>

        </section>

    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once('src/include/footer.php') ?>
    </footer>

    <script type="module" src="/assets/js/filtreByMarque.js"></script>

</body>

</html>