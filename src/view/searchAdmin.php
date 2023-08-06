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
    <!-- flowbite -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <title>Admin</title>
</head>

<body class="bg-[#fcfcfc]">
    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?>
    </header>

    <main>

        <section class="bg-gray-50 p-3 sm:p-5 antialiased">

            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">

                <div class="relative">

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

                        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">

                            <button type="button" id="createCategorieModalButton" data-modal-target="createCategorieModal" data-modal-toggle="createCategorieModal" class="flex items-center justify-center border border-gray-200 bg-primary-700 text-gray-900 font-medium rounded-lg text-sm px-4 py-2">
                                Ajouter une catégorie
                            </button>

                            <button type="button" id="createMarqueModalButton" data-modal-target="createMarqueModal" data-modal-toggle="createMarqueModal" class="flex items-center justify-center border border-gray-200 bg-primary-700 text-gray-900 font-medium rounded-lg text-sm px-4 py-2">
                                Ajouter une marque
                            </button>
                            <button id="typeDropdownButton" data-dropdown-toggle="typeDropdown" class="w-full md:w-auto bg-primary-700 text-gray-900 flex items-center justify-center py-2 px-4 text-sm font-medium  rounded-lg border border-gray-200" type="button">
                                Ajouter un type
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>

                            <div id="typeDropdown" class="z-10 hidden w-44 p-3 bg-white rounded-lg shadow">

                                <ul class="space-y-2 text-sm" aria-labelledby="typeDropdownButton">

                                    <li class="flex items-center">
                                        <button type="button" id="createTypeCanneModalButton" data-modal-target="createTypeCanneModal" data-modal-toggle="createTypeCanneModal" class="flex items-center justify-center font-semibold">
                                            Type de canne
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createTypeMoulinetModalButton" data-modal-target="createTypeMoulinetModal" data-modal-toggle="createTypeMoulinetModal" class="flex items-center justify-center font-semibold">
                                            Type de moulinet
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createTypeHameconModalButton" data-modal-target="createTypeHameconModal" data-modal-toggle="createTypeHameconModal" class="flex items-center justify-center font-semibold">
                                            Type d'hameçon
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createTypeLeurreModalButton" data-modal-target="createTypeLeurreModal" data-modal-toggle="createTypeLeurreModal" class="flex items-center justify-center font-semibold">
                                            Type de leurre
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createTypeLigneModalButton" data-modal-target="createTypeLigneModal" data-modal-toggle="createTypeLigneModal" class="flex items-center justify-center font-semibold">
                                            Type de ligne
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createTypeEquipementModalButton" data-modal-target="createTypeEquipementModal" data-modal-toggle="createTypeEquipementModal" class="flex items-center justify-center font-semibold">
                                            Type d'équipement
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createTypePlombModalButton" data-modal-target="createTypePlombModal" data-modal-toggle="createTypePlombModal" class="flex items-center justify-center font-semibold">
                                            Type de plomb
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createTypeAppatModalButton" data-modal-target="createTypeAppatModal" data-modal-toggle="createTypeAppatModal" class="flex items-center justify-center font-semibold">
                                            Type d'appat
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createTypeAutreModalButton" data-modal-target="createTypeAutreModal" data-modal-toggle="createTypeAutreModal" class="flex items-center justify-center font-semibold">
                                            Type d'autre
                                        </button>
                                    </li>

                                </ul>

                            </div>

                            <button id="articleDropdownButton" data-dropdown-toggle="articleDropdown" class="w-full md:w-auto bg-[#426EC2] text-white flex items-center justify-center py-2 px-4 text-sm font-medium  rounded-lg border border-gray-200" type="button">
                                Ajouter un article
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>

                            <div id="articleDropdown" class="z-10 hidden w-44 p-3 bg-white rounded-lg shadow">

                                <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">

                                    <li class="flex items-center">
                                        <button type="button" id="createCanneModalButton" data-modal-target="createCanneModal" data-modal-toggle="createCanneModal" class="flex items-center justify-center font-semibold">
                                            Canne
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createMoulinetModalButton" data-modal-target="createMoulinetModal" data-modal-toggle="createMoulinetModal" class="flex items-center justify-center font-semibold">
                                            Moulinet
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createHameconModalButton" data-modal-target="createHameconModal" data-modal-toggle="createHameconModal" class="flex items-center justify-center font-semibold">
                                            Hameçon
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createLeurreModalButton" data-modal-target="createLeurreModal" data-modal-toggle="createLeurreModal" class="flex items-center justify-center font-semibold">
                                            Leurre
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createLigneModalButton" data-modal-target="createLigneModal" data-modal-toggle="createLigneModal" class="flex items-center justify-center font-semibold">
                                            Ligne
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createEquipementModalButton" data-modal-target="createEquipementModal" data-modal-toggle="createEquipementModal" class="flex items-center justify-center font-semibold">
                                            Equipement
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createPlombModalButton" data-modal-target="createPlombModal" data-modal-toggle="createPlombModal" class="flex items-center justify-center font-semibold">
                                            Plomb
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createAppatModalButton" data-modal-target="createAppatModal" data-modal-toggle="createAppatModal" class="flex items-center justify-center font-semibold">
                                            Appat
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createAutreModalButton" data-modal-target="createAutreModal" data-modal-toggle="createAutreModal" class="flex items-center justify-center font-semibold">
                                            Autre
                                        </button>
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full text-sm text-left text-gray-500">

                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-4">Nom du produit</th>
                                    <th scope="col" class="px-4 py-3">Genre</th>
                                    <th scope="col" class="px-4 py-3">Categorie</th>
                                    <th scope="col" class="px-4 py-3">Marque</th>
                                    <th scope="col" class="px-4 py-3">Image</th>
                                    <th scope="col" class="px-4 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($produits as $produit) { ?>
                                    <tr>

                                        <td scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap"><?php echo $produit->getNomProduit() ?></td>

                                        <td class="px-4 py-3"><?php echo $produit->getNomGenre() ?></td>

                                        <td class="px-4 py-3"><?php echo $produit->getNomCategorie() ?></td>

                                        <td class="px-4 py-3"><?php echo $produit->getNomMarque() ?></td>

                                        <td class="px-4 py-3">
                                            <img class="w-10 h-10" src="/<?php echo $produit->getNomImage(); ?>">
                                        </td>

                                        <td class="px-4 py-3 flex items-center justify-end">

                                            <button id="<?php echo $produit->getNomGenre() ?>-dropdown-button-<?php echo $produit->getIdProduit() ?>" data-dropdown-toggle="<?php echo $produit->getNomGenre() ?>-dropdown-<?php echo $produit->getIdProduit() ?>" class="inline-flex items-center text-sm font-medium hover:bg-gray-100  text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none " type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>

                                            <div id="<?php echo $produit->getNomGenre() ?>-dropdown-<?php echo $produit->getIdProduit() ?>" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow">

                                                <ul class="py-1 text-sm" aria-labelledby="<?php echo $produit->getNomGenre() ?>-dropdown-button-<?php echo $produit->getIdProduit() ?>">

                                                    <li>
                                                        <button type="button" value="<?php echo $produit->getIdProduit() ?>" name="id_produit" data-modal-target="update-<?php echo $produit->getNomGenre() ?>Modal-<?php echo $produit->getIdProduit() ?>" data-modal-toggle="update-<?php echo $produit->getNomGenre() ?>Modal-<?php echo $produit->getIdProduit() ?>" class="edit-button flex w-full items-center py-2 px-4 hover:bg-gray-100">
                                                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                                            </svg>
                                                            Modifier
                                                        </button>
                                                    </li>

                                                    <li>
                                                        <button type="button" value="<?php echo $produit->getIdProduit() ?>" name="id_produit" data-modal-target="read-<?php echo $produit->getNomGenre() ?>Modal-<?php echo $produit->getIdProduit() ?>" data-modal-toggle="read-<?php echo $produit->getNomGenre() ?>Modal-<?php echo $produit->getIdProduit() ?>" class="flex w-full items-center py-2 px-4 hover:bg-gray-100">
                                                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" />
                                                            </svg>
                                                            Voir
                                                        </button>
                                                    </li>

                                                    <li>
                                                        <button type="button" value="<?php echo $produit->getIdProduit() ?>" name="id_produit" data-modal-target="delete-<?php echo $produit->getNomGenre() ?>Modal-<?php echo $produit->getIdProduit() ?>" data-modal-toggle="delete-<?php echo $produit->getNomGenre() ?>Modal-<?php echo $produit->getIdProduit() ?>" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 text-red-500">
                                                            <svg class="w-4 h-4 mr-2" viewbox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" d="M6.09922 0.300781C5.93212 0.30087 5.76835 0.347476 5.62625 0.435378C5.48414 0.523281 5.36931 0.649009 5.29462 0.798481L4.64302 2.10078H1.59922C1.36052 2.10078 1.13161 2.1956 0.962823 2.36439C0.79404 2.53317 0.699219 2.76209 0.699219 3.00078C0.699219 3.23948 0.79404 3.46839 0.962823 3.63718C1.13161 3.80596 1.36052 3.90078 1.59922 3.90078V12.9008C1.59922 13.3782 1.78886 13.836 2.12643 14.1736C2.46399 14.5111 2.92183 14.7008 3.39922 14.7008H10.5992C11.0766 14.7008 11.5344 14.5111 11.872 14.1736C12.2096 13.836 12.3992 13.3782 12.3992 12.9008V3.90078C12.6379 3.90078 12.8668 3.80596 13.0356 3.63718C13.2044 3.46839 13.2992 3.23948 13.2992 3.00078C13.2992 2.76209 13.2044 2.53317 13.0356 2.36439C12.8668 2.1956 12.6379 2.10078 12.3992 2.10078H9.35542L8.70382 0.798481C8.62913 0.649009 8.5143 0.523281 8.37219 0.435378C8.23009 0.347476 8.06631 0.30087 7.89922 0.300781H6.09922ZM4.29922 5.70078C4.29922 5.46209 4.39404 5.23317 4.56282 5.06439C4.73161 4.8956 4.96052 4.80078 5.19922 4.80078C5.43791 4.80078 5.66683 4.8956 5.83561 5.06439C6.0044 5.23317 6.09922 5.46209 6.09922 5.70078V11.1008C6.09922 11.3395 6.0044 11.5684 5.83561 11.7372C5.66683 11.906 5.43791 12.0008 5.19922 12.0008C4.96052 12.0008 4.73161 11.906 4.56282 11.7372C4.39404 11.5684 4.29922 11.3395 4.29922 11.1008V5.70078ZM8.79922 4.80078C8.56052 4.80078 8.33161 4.8956 8.16282 5.06439C7.99404 5.23317 7.89922 5.46209 7.89922 5.70078V11.1008C7.89922 11.3395 7.99404 11.5684 8.16282 11.7372C8.33161 11.906 8.56052 12.0008 8.79922 12.0008C9.03791 12.0008 9.26683 11.906 9.43561 11.7372C9.6044 11.5684 9.69922 11.3395 9.69922 11.1008V5.70078C9.69922 5.46209 9.6044 5.23317 9.43561 5.06439C9.26683 4.8956 9.03791 4.80078 8.79922 4.80078Z" />
                                                            </svg>
                                                            Supprimer
                                                        </button>
                                                    </li>

                                                </ul>

                                            </div>

                                        </td>

                                    </tr>
                                    
                                <?php } ?>
                                
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </section>
        <?php include('src/view/adminCrud/modalAdd/modalAddCategorie.php'); ?>

        <?php include('src/view/adminCrud/modalAdd/modalAddMarque.php'); ?>

        <?php include('src/view/adminCrud/modalAdd/type/modalAddTypeCanne.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/modalAddCanne.php'); ?>

        <?php include('src/view/adminCrud/modalAdd/type/modalAddTypeMoulinet.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/modalAddMoulinet.php'); ?>

        <?php include('src/view/adminCrud/modalAdd/type/modalAddTypeHamecon.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/modalAddHamecon.php'); ?>

        <?php include('src/view/adminCrud/modalAdd/type/modalAddTypeLeurre.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/modalAddLeurre.php'); ?>

        <?php include('src/view/adminCrud/modalAdd/type/modalAddTypeLigne.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/modalAddLigne.php'); ?>

        <?php include('src/view/adminCrud/modalAdd/type/modalAddTypeEquipement.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/modalAddEquipement.php'); ?>

        <?php include('src/view/adminCrud/modalAdd/type/modalAddTypePlomb.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/modalAddPlomb.php'); ?>

        <?php include('src/view/adminCrud/modalAdd/type/modalAddTypeAppat.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/modalAddAppat.php'); ?>

        <?php include('src/view/adminCrud/modalAdd/type/modalAddTypeAutre.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/modalAddAutre.php'); ?>

        <?php 
        foreach($cannes as $canne)
        {
            include('src/view/adminCrud/modalUpdate/modalCanneUpdate.php');
            include('src/view/adminCrud/readModal/readModalCanne.php');
            include('src/view/adminCrud/modalDelete/modalDeleteCanne.php');
        }

        foreach($moulinets as $moulinet)
        {
            include('src/view/adminCrud/modalUpdate/modalMoulinetUpdate.php');
            include('src/view/adminCrud/readModal/readModalMoulinet.php');
            include('src/view/adminCrud/modalDelete/modalDeleteMoulinet.php');
        }

        foreach($appats as $appat)
        {
            include('src/view/adminCrud/modalUpdate/modalAppatUpdate.php');
            include('src/view/adminCrud/readModal/readModalAppat.php');
            include('src/view/adminCrud/modalDelete/modalDeleteAppat.php');
        }

        foreach($equipements as $equipement)
        {
            include('src/view/adminCrud/modalUpdate/modalEquipementUpdate.php');
            include('src/view/adminCrud/readModal/readModalEquipement.php');
            include('src/view/adminCrud/modalDelete/modalDeleteEquipement.php');
        }

        foreach($autres as $autre)
        {
            include('src/view/adminCrud/modalUpdate/modalAutreUpdate.php');
            include('src/view/adminCrud/readModal/readModalAutre.php');
            include('src/view/adminCrud/modalDelete/modalDeleteAutre.php');
        }

        foreach($hamecons as $hamecon)
        {
            include('src/view/adminCrud/modalUpdate/modalHameconUpdate.php');
            include('src/view/adminCrud/readModal/readModalHamecon.php');
            include('src/view/adminCrud/modalDelete/modalDeleteHamecon.php');
        }

        foreach($leurres as $leurre)
        {
            include('src/view/adminCrud/modalUpdate/modalLeurreUpdate.php');
            include('src/view/adminCrud/readModal/readModalLeurre.php');
            include('src/view/adminCrud/modalDelete/modalDeleteLeurre.php');
        }
        foreach($lignes as $ligne)
        {
            include('src/view/adminCrud/modalUpdate/modalLigneUpdate.php');
            include('src/view/adminCrud/readModal/readModalLigne.php');
            include('src/view/adminCrud/modalDelete/modalDeleteLigne.php');
        }

        foreach($plombs as $plomb)
        {
            include('src/view/adminCrud/modalUpdate/modalPlombUpdate.php');
            include('src/view/adminCrud/readModal/readModalPlomb.php');
            include('src/view/adminCrud/modalDelete/modalDeletePlomb.php');
        }

        ?>

    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once('src/include/footer.php') ?>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>