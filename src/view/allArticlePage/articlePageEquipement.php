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
    <title>Page allEquipement</title>
</head>

<body class="bg-[#fcfcfc]">

    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?>
    </header>

    <main>

        <section>

            <div class="bg-[#fcfcfc] w-2/3 m-auto p-6">
                <h1 class="text-center font-semibold">Touts les "Equipements"</h1>
            </div>

            <div class="bg-[#426EC2] p-1">
                <?php require_once('src/include/filtreArticle/filtreEquipement.php'); ?>
            </div>

            <div>
                <div id="listeArticles" class="p-3 md:p-5 relative flex flex-wrap gap-5 md:gap-7 items-center justify-center">
                    <?php foreach ($allEquipements as $allEquipement) { ?>
                        <a href="/<?php echo $allEquipement['genre']; ?>Page/<?php echo $allEquipement['id']; ?>">
                            <div class="<?php echo $allEquipement['type']; ?> allEquipement">

                                <div>
                                    <img src="<?php echo $allEquipement['image']; ?>" class="object-cover object-center w-32 h-32 md:w-56 md:h-56" style="border: 1px solid #000000;" />
                                </div>

                                <div>
                                    <p class="text-xs md:text-lg text-center"><?php echo $allEquipement['nom']; ?></p>
                                    <p class="text-2xs md:text-sm text-center uppercase"><?php echo $allEquipement['marque']; ?></p>
                                </div>

                            </div>
                        </a>
                    <?php } ?>

                </div>

            </div>

        </section>

    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once('src/include/footer.php') ?>
    </footer>

    <script src="assets/js/filtreArticle/filtreEquipement.js"></script>

</body>
</html>