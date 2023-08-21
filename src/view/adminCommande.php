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

    <title>Admin</title>
</head>

<body class="bg-[#fcfcfc]">
    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?>
    </header>

    <main>

        <section class="bg-gray-50 p-3 sm:p-5 antialiased">

            <!-- <div class="mx-auto max-w-screen-xl px-4 lg:px-12">

                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">

                    <div class="w-full md:w-1/2">

                        <form class="relative flex items-center" method="get" action="/searchAdmin/">

                            <label for="simple-search" class="sr-only">Rechercher</label>

                            <div class="relative w-full">

                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>

                                <input type="text" id="simple-search" name="keywords" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2" placeholder="Rechercher" required="">
                            </div>

                        </form>

                    </div>

                </div> -->

                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left text-gray-500">

                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-4">Etat de la commande</th>
                                <th scope="col" class="px-4 py-4">Numéro de commande</th>
                                <th scope="col" class="px-4 py-3">Articles de la commande</th>
                                <th scope="col" class="px-4 py-3">Total</th>
                                <th scope="col" class="px-4 py-3">Date</th>
                                <th scope="col" class="px-4 py-3">Client</th>
                                <th scope="col" class="px-4 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            foreach ($allCommandes as $commande) {
                                $resumeCommande = json_decode($commande->getResumeCommande());
                                $totalCommande = 0;
                            ?>
                                <tr>
                                    <td scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap flex items-center justify-center">
                                        <?php
                                        if ($commande->getEtatCommande() == 'attente') {
                                        ?>
                                            <img class="h-10 w-10" src="/assets/img/site/point-dexclamation.png">
                                        <?php
                                        } elseif ($commande->getEtatCommande() == 'en_cours') {
                                        ?>
                                            <img class="h-10 w-10" src="/assets/img/site/boite-ouverte.png">
                                        <?php
                                        } elseif ($commande->getEtatCommande() == 'recup') {
                                        ?>
                                            <img class="h-10 w-10" src="/assets/img/site/droite.png">
                                        <?php
                                        } elseif ($commande->getEtatCommande() == 'annule') {
                                        ?>
                                            <img class="h-9 w-9" src="/assets/img/site/annuler.png">
                                        <?php
                                        } elseif ($commande->getEtatCommande() == 'pret') {
                                        ?>
                                            <img class="h-10 w-10" src="assets/img/site/boite.png">
                                        <?php
                                        }
                                        ?>
                                    </td>

                                    <td scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap"><?php echo $commande->getNumeroCommande() ?></td>

                                    <td class="px-4 py-3">
                                        <?php foreach ($resumeCommande as $article) { ?>
                                            <ul class="mb-1">
                                                <li><?php echo $article->name . " - Quantité : " . $article->quantity . " - Prix unitaire : " . $article->price . " €"; ?></li>
                                            </ul>
                                            <?php $totalCommande += $article->price * $article->quantity; ?>
                                        <?php } ?>
                                    </td>

                                    <td class="px-4 py-3"><?php echo $totalCommande; ?> €</td>

                                    <td class="px-4 py-3"><?php echo $commande->getDateCommande() ?></td>

                                    <td class="px-4 py-3">
                                        <?php

                                        $id_user = $commande->getIdUser();

                                        $user = $userRepo->getUserById($id_user);

                                        echo $user->getLastNameUser() . ' ' . $user->getNameUser();
                                        ?>
                                    </td>

                                    <td class="px-4 py-3 flex items-center justify-end">

                                        <button type="button" value="<?php echo $commande->getIdCommande() ?>" name="id_commande" data-modal-target="updateCommandeModal-<?php echo $commande->getIdCommande() ?>" data-modal-toggle="updateCommandeModal-<?php echo $commande->getIdCommande() ?>" class="edit-button flex w-full items-center py-2 px-4 hover:bg-gray-100">
                                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                            </svg>
                                        </button>
                                        <?php include('src/view/adminCrud/modalUpdate/modalUpdateCommande.php'); ?>

                                    </td>


                                </tr>

                            <?php } ?>

                        </tbody>


                    </table>

                </div>

            </div>

        </section>

    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once('src/include/footer.php') ?>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>