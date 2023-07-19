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
    <link rel="icon" href="assets/img/site/icon.png" />
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

                                <a href="/<?php echo $article['genre']; ?>Page/<?php echo $article['id']; ?>">

                                    <div class="w-56">
                                        <img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="<?php echo $article['image']; ?>" />
                                    </div>

                                </a>

                                <div class="flex justify-center gap-10 py-3">

                                    <div>
                                        <p class="text-s md:text-lg">
                                            <?php
                                            $nom = $article['nom'];
                                            if (strlen($nom) > 20) {
                                                echo substr($nom, 0, 17) . '...';
                                            } else {
                                                echo $nom;
                                            }
                                            ?>
                                        </p>
                                        <p class="text-xs md:text-sm uppercase">
                                            <?php
                                            $marque = $article['marque'];
                                            if (strlen($marque) > 50) {
                                                echo substr($marque, 0, 47) . '...';
                                            } else {
                                                echo $marque;
                                            }
                                            ?>
                                        </p>
                                    </div>

                                    <?php if ($_SESSION) { ?>

                                        <div>

                                            <form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">
                                                <input type="hidden" name="id_<?php echo $article['genre']; ?>" value="<?php echo $article['id']; ?>">
                                                <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
                                                <input type="hidden" name="genre" value="<?php echo $article['genre']; ?>">
                                                <input type="hidden" name="date_ajout_favoris" value="<?php echo $today = date("d/m/y"); ?>">
                                                <?php if(isset($_GET['action'])) { ?>
                                                <input type="hidden" name="page" value="<?php echo $_GET['action'] ?>">
                                                <?php }else{ echo ''; } ?>
                                                <?php if ($_SESSION[$article['genre']]) { ?>

                                                    <?php foreach ($_SESSION[$article['genre']] as $idTab) { ?>

                                                        <?php if (in_array($article['id'], $idTab)) { ?>

                                                            <button class="favoris-button" type="submit">
                                                                <img class="w-6 h-6 mt-1" src="assets/img/site/liked.png">
                                                            </button>

                                                        <?php } else { ?>

                                                            <button class="favoris-button" type="submit">
                                                                <img class="w-6 h-6 mt-1" src="assets/img/site/like.png">
                                                            </button>

                                                        <?php } ?>

                                                    <?php } ?>

                                                <?php } else { ?>

                                                    <button class="favoris-button" type="submit">
                                                        <img class="w-6 h-6 mt-1" src="assets/img/site/like.png">
                                                    </button>

                                                <?php } ?>

                                            </form>

                                        </div>

                                    <?php } ?>

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