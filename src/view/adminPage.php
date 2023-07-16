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

                            <form class="flex items-center" action="admin.php?action=search" method="post">

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
                                        <button type="button" id="createTypeFeederModalButton" data-modal-target="createTypeFeederModal" data-modal-toggle="createTypeFeederModal" class="flex items-center justify-center font-semibold">
                                            Type de plomb
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createTypeAppatModalButton" data-modal-target="createTypeAppatModal" data-modal-toggle="createTypeAppatModal" class="flex items-center justify-center font-semibold">
                                            Type d'appat
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
                                        <button type="button" id="createFeederModalButton" data-modal-target="createFeederModal" data-modal-toggle="createFeederModal" class="flex items-center justify-center font-semibold">
                                            Plomb
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createAppatModalButton" data-modal-target="createAppatModal" data-modal-toggle="createAppatModal" class="flex items-center justify-center font-semibold">
                                            Appat
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
                                    <th scope="col" class="px-4 py-3">Catégorie</th>
                                    <th scope="col" class="px-4 py-3">Type</th>
                                    <th scope="col" class="px-4 py-3">Marque</th>
                                    <th scope="col" class="px-4 py-3">Image</th>
                                    <th scope="col" class="px-4 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>

                            <?php

                            $articlesParPage = 5;

                            $totalArticles = count($articles);

                            $nombreDePages = ceil($totalArticles / $articlesParPage);

                            if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nombreDePages) 
                            {
                                $selectedPage = $_GET['page'];
                            } 
                            else 
                            {
                                $selectedPage = 1;
                            }

                            $indexDebut = ($selectedPage - 1) * $articlesParPage;
                            $indexFin = $indexDebut + $articlesParPage;

                            $articlesSelectionnes = array_slice($articles, $indexDebut, $articlesParPage);

                            if (!empty($articlesSelectionnes))
                            {
                                include('src/view/adminCrud/viewAllArticles.php');
                            } 
                            else 
                            {
                                echo '<tbody></tbody>';
                            }

                            ?>

                        </table>

                    </div>

                    <nav class="flex flex-col md:flex-row justify-center items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">

                        <ul class="inline-flex items-stretch -space-x-px">
                            
                            <?php if ($selectedPage > 1) { ?>
                                <li>
                                    <a href="admin.php?page=<?php echo $selectedPage - 1; ?>" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                                        <span class="sr-only">Précédent</span>
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php for ($page = 1; $page <= $nombreDePages; $page++) { ?>
                                <li>
                                    <a href="admin.php?page=<?php echo $page; ?>" class="flex items-center justify-center text-sm py-2 px-3 leading-tight <?php if ($page === $selectedPage) echo 'text-gray-700 bg-gray-100';
                                                                                                                                                            else echo 'text-gray-500 bg-white'; ?> border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                                        <?php echo $page; ?>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ($selectedPage < $nombreDePages) { ?>
                                <li>
                                    <a href="admin.php?page=<?php echo $selectedPage + 1; ?>" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                                        <span class="sr-only">Suivant</span>
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                        
                    </nav>

                </div>

            </div>

        </section>
        <!-- Create modal -->
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

        <?php include('src/view/adminCrud/modalAdd/type/modalAddTypeFeeder.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/modalAddFeeder.php'); ?>

        <?php include('src/view/adminCrud/modalAdd/type/modalAddTypeAppat.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/modalAddAppat.php'); ?>
    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once('src/include/footer.php') ?>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>