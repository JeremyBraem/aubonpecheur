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
    <link rel="icon" href="/assets/img/site/icon.png"/>
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
    <title><?php echo $autre->getNomProduit(); ?></title>
</head>

<body class="bg-[#fcfcfc]">

    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?>
    </header>

    <main>

        <section>

            <div class="md:flex md:flex-col">

                <div class="md:flex md:flex-row">

                    <div class="md:w-2/4 lg:w-2/5 h-[500px] md:p-5">
                        <img src="/<?php echo $autre->getNomImage(); ?>" class="h-full rounded-2xl w-full object-cover">
                    </div>

                    <div class="md:w-2/4 lg:w-3/5 md:py-10 md:px-5">

                        <div class="w-2/3 m-auto md:w-auto text-center md:text-left ">
                            <h1 class="text-[20px] md:text-[24px] font-semibold"><?php echo $autre->getNomProduit(); ?></h1>
                            <h2 class="text-[16px] md:text-[20px]"><?php echo $autre->getNomMarque(); ?></h2>
                        </div>

                        <div class="p-6 md:px-0 py-5 flex">
                            <?php if($autre->getPromoProduit() > 0)
                            { ?>
                            <p><strong>Prix : </strong></p>
                            <p class="text-[12px] md:text-[14px] mr-5 line-through lg:text-[16px]"><?php echo number_format($autre->getPrixProduit(), 2, '.', '') ?> €</p>
                            <p class="text-[12px] md:text-[14px] lg:text-[16px]"><?php echo number_format($autre->getPrixPromoProduit(), 2, '.', '') ?> €</p>
                            <?php }else{ ?>
                            <p class="text-[12px] md:text-[14px] lg:text-[16px]"><strong>Prix : </strong><?php echo number_format($autre->getPrixProduit(), 2, '.', '') ?> €</p>
                            <?php } ?>
                        </div>

                        <div class="p-6 md:px-0 py-5">
                            <p class="text-[12px] md:text-[14px] lg:text-[16px]"><strong>Description : </strong><?php echo $autre->getDescriptionProduit(); ?></p>
                        </div>
                        
                        <div class="">

                            <div class="flex flex-col w-2/3 m-auto md:w-auto md:flex-row">

                                <?php if ($autre->getStockProduit() == 1) { ?>
                                    <div class="add-to-cart-btn cursor-pointer text-center py-2 mx-5 md:ml-0 md:mr-10 md:py-3 md:text-[12px] lg:text-[16px] md:px-5 mt-5 text-[#fcfcfc] rounded bg-[#426EC2]" data-name="<?php echo $autre->getNomProduit(); ?>" data-price="<?php if($autre->getPromoProduit() > 0) { echo $autre->getPrixPromoProduit(); }else{ echo $autre->getPrixProduit(); } ?>" data-image="<?php echo $autre->getNomImage(); ?>" data-genre="<?php echo $autre->getNomGenre(); ?>" data-id="<?php echo $autre->getIdProduit(); ?>">Ajouter au panier</div>
                                <?php } else { ?>
                                    <div class="text-center py-2 mx-5 md:ml-0 md:mr-10 md:py-3 md:w-[180px] md:text-[12px] lg:text-[16px] md:px-5 mt-5 rounded bg-[#fcfcfc]" style="border: 1px solid #000000;">Hors Stock</div>
                                <?php } ?>
                                <?php if ($autre->getPromoProduit() > 0) { ?>
                            <div class="text-center py-2 mx-5 md:ml-0 md:mr-10 md:py-3 md:text-[12px] lg:text-[16px] md:px-5 mt-5 text-[#fcfcfc] rounded bg-[#ff4545]">Promotion : -<?php echo $autre->getPromoProduit() ?>%</div>
                            <?php } ?>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="bg-[#426EC2]">

                    <div class="mt-10 p-5 md:my-2 w-2/3 md:p-5 md:mx-10">

                        <h3 class="text-[#fcfcfc] mb-2 md:text-[24px]">Détails</h3>
                        <div class="flex">
                            <p class="text-[#fcfcfc] text-[12px] md:text-[20px] mr-5"><?php echo $autre->getDetailAutre(); ?></p>
                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once('src/include/footer.php') ?>
    </footer>

    <script src="assets/js/swiper.js"></script>
    <script src="assets/js/sliderPromo.js"></script>

</body>

</html>