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
    <title>Marques - Au Bon Pêcheur</title>
</head>

<body class="bg-[#fcfcfc]">

    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?>
    </header>

    <main>

        <section>

            <div class="bg-[#fcfcfc] w-2/3 m-auto p-6">
                <h1 class="text-center font-semibold">Toutes les marques</h1>
            </div>

            <div class="bg-[#426EC2] p-3 md:p-5 relative flex flex-wrap gap-5 md:gap-7 items-center justify-center">

                <?php foreach ($marques as $marque) { ?>

                    <?php if ($marque) { ?>
                        
                        <a href="marque/<?php echo $marque->getNomMarque() ?>">
                            <div class="bg-[#fcfcfc] w-32 h-16 md:w-40 md:h-20 m-auto flex rounded">

                                <div class="w-28 h-16 md:w-36 md:h-20 m-auto overflow-hidden">
                                    <img src="/<?php echo $marque->getImageMarque(); ?>" class="w-full h-full object-contain" />
                                </div>

                            </div>
                        </a>

                    <?php } else { ?>

                <?php echo ''; } } ?>

            </div>

        </section>

    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once('src/include/footer.php') ?>
    </footer>

    <script src="assets/js/filtre.js"></script>

</body>

</html>