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

    <title>Page d'articles</title>
</head>

<body class="bg-[#fcfcfc]">

    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?>
    </header>

    <main>

        <section>

            <div class="bg-[#fcfcfc] w-2/3 m-auto p-6">
                <h1 class="text-center font-semibold">Tous les articles</h1>
            </div>

            <div class="bg-[#426EC2] p-1">
                <?php require_once('src/include/filtre.php'); ?>
            </div>

            <div>

                <div id="listeArticles" class="p-3 md:p-5 relative flex flex-wrap gap-5 md:gap-7 items-center justify-center">

                    <?php foreach ($articles as $article) { ?>

                        <?php if ($article != ['']) { ?>

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
                        } ?>

                    <?php } ?>

                </div>

            </div>

        </section>

    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once('src/include/footer.php') ?>
    </footer>

    <script src="assets/js/filtre.js"></script>

</body>

</html>