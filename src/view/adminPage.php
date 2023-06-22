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
        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 antialiased">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <!-- Start coding here -->
                <div class="relative overflow-hidden">
                    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 " placeholder="Search" required="">
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
                                        <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center font-semibold">
                                            Type de moulinet
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center font-semibold">
                                            Type d'hameçon
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center font-semibold">
                                            Type de leurre
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center font-semibold">
                                            Type de ligne
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center font-semibold">
                                            Type d'équipement
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center font-semibold">
                                            Type de feeder
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
                                        <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center font-semibold">
                                            Moulinet
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center font-semibold">
                                            Hameçon
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center font-semibold">
                                            Leurre
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center font-semibold">
                                            Ligne
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center font-semibold">
                                            Equipement
                                        </button>
                                    </li>

                                    <li class="flex items-center">
                                        <button type="button" id="createProductModalButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center font-semibold">
                                            Feeder
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
                                    <th scope="col" class="px-4 py-4">Id du produit</th>
                                    <th scope="col" class="px-4 py-4">Nom du produit</th>
                                    <th scope="col" class="px-4 py-3">Catégorie</th>
                                    <th scope="col" class="px-4 py-3">Type</th>
                                    <th scope="col" class="px-4 py-3">Marque</th>
                                    <th scope="col" class="px-4 py-3">Image</th>
                                    <th scope="col" class="px-4 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($cannes as $canne) { ?>
                                    <tr class="border-b" data-canne-id="<?php echo $canne->getIdCanne() ?>">
                                        <td class="px-4 py-3"><?php echo $canne->getIdCanne() ?></td>
                                        <td scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap"><?php echo $canne->getNomCanne() ?></td>
                                        <td class="px-4 py-3"><?php echo $canne->getCategorieCanne() ?></td>
                                        <td class="px-4 py-3"><?php echo $canne->getTypeCanne() ?></td>
                                        <td class="px-4 py-3"><?php echo $canne->getMarqueCanne() ?></td>
                                        <td class="px-4 py-3">
                                            <img class="w-10 h-10" src="
                                            <?php
                                                $imgCanneRepo = new ImageCanneRepository;
                                                $imgCannes = $imgCanneRepo->getImageByCanne($canne->getIdCanne());
                                                echo $imgCannes->getNomImageCanne();
                                            ?>">
                                        </td>
                                        <td class="px-4 py-3 flex items-center justify-end">

                                            <button id="menu-dropdown-button" data-dropdown-toggle="menu-dropdown" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>

                                            <div id="menu-dropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow">

                                                <ul class="py-1 text-sm" aria-labelledby="menu-dropdown-button">

                                                    <li>
                                                        <button type="button" data-modal-target="updateCanneModal" data-modal-toggle="updateCanneModal" class="flex w-full items-center py-2 px-4 hover:bg-gray-100">
                                                            <svg class="w-4 h-4 mr-2" name="canne_id" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                                            </svg>
                                                            Modifier
                                                        </button>
                                                    </li>

                                                    <li>
                                                        <form>

                                                            <input type="hidden" name="canne_id" value="<?php echo $canne->getIdCanne() ?>">
                                                            <button type="button" data-modal-target="readProductModal" data-modal-toggle="readProductModal" class="flex w-full items-center py-2 px-4 hover:bg-gray-100">
                                                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" />
                                                                </svg>
                                                                Voir
                                                            </button>

                                                        </form>
                                                    </li>

                                                    <li>
                                                        <form>

                                                            <input type="hidden" name="canne_id" value="<?php echo $canne->getIdCanne() ?>">
                                                            <button type="button" name="canne_id" data-modal-target="deleteCanneModal" data-modal-toggle="deleteCanneModal" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400">
                                                                <svg class="w-4 h-4 mr-2" viewbox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" d="M6.09922 0.300781C5.93212 0.30087 5.76835 0.347476 5.62625 0.435378C5.48414 0.523281 5.36931 0.649009 5.29462 0.798481L4.64302 2.10078H1.59922C1.36052 2.10078 1.13161 2.1956 0.962823 2.36439C0.79404 2.53317 0.699219 2.76209 0.699219 3.00078C0.699219 3.23948 0.79404 3.46839 0.962823 3.63718C1.13161 3.80596 1.36052 3.90078 1.59922 3.90078V12.9008C1.59922 13.3782 1.78886 13.836 2.12643 14.1736C2.46399 14.5111 2.92183 14.7008 3.39922 14.7008H10.5992C11.0766 14.7008 11.5344 14.5111 11.872 14.1736C12.2096 13.836 12.3992 13.3782 12.3992 12.9008V3.90078C12.6379 3.90078 12.8668 3.80596 13.0356 3.63718C13.2044 3.46839 13.2992 3.23948 13.2992 3.00078C13.2992 2.76209 13.2044 2.53317 13.0356 2.36439C12.8668 2.1956 12.6379 2.10078 12.3992 2.10078H9.35542L8.70382 0.798481C8.62913 0.649009 8.5143 0.523281 8.37219 0.435378C8.23009 0.347476 8.06631 0.30087 7.89922 0.300781H6.09922ZM4.29922 5.70078C4.29922 5.46209 4.39404 5.23317 4.56282 5.06439C4.73161 4.8956 4.96052 4.80078 5.19922 4.80078C5.43791 4.80078 5.66683 4.8956 5.83561 5.06439C6.0044 5.23317 6.09922 5.46209 6.09922 5.70078V11.1008C6.09922 11.3395 6.0044 11.5684 5.83561 11.7372C5.66683 11.906 5.43791 12.0008 5.19922 12.0008C4.96052 12.0008 4.73161 11.906 4.56282 11.7372C4.39404 11.5684 4.29922 11.3395 4.29922 11.1008V5.70078ZM8.79922 4.80078C8.56052 4.80078 8.33161 4.8956 8.16282 5.06439C7.99404 5.23317 7.89922 5.46209 7.89922 5.70078V11.1008C7.89922 11.3395 7.99404 11.5684 8.16282 11.7372C8.33161 11.906 8.56052 12.0008 8.79922 12.0008C9.03791 12.0008 9.26683 11.906 9.43561 11.7372C9.6044 11.5684 9.69922 11.3395 9.69922 11.1008V5.70078C9.69922 5.46209 9.6044 5.23317 9.43561 5.06439C9.26683 4.8956 9.03791 4.80078 8.79922 4.80078Z" />
                                                                </svg>
                                                                Supprimer
                                                            </button>

                                                        </form>
                                                    </li>

                                                </ul>

                                            </div>

                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>

                    </div>

                    <nav class="flex flex-col md:flex-row justify-center items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">

                        <ul class="inline-flex items-stretch -space-x-px">
                            <li>
                                <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <span class="sr-only">Previous</span>
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                            </li>
                            <li>
                                <a href="#" aria-current="page" class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 ">3</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <span class="sr-only">Next</span>
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
        <!-- End block -->

        <!-- Create modal -->
        <?php include('src/view/adminCrud/modalAdd/modalAddCategorie.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/modalAddMarque.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/type/modalAddTypeCanne.php'); ?>
        <?php include('src/view/adminCrud/modalAdd/modalAddCanne.php'); ?>
        <!-- Update modal -->
        <?php include('src/view/adminCrud/modalUpdate/modalCanneUpdate.php'); ?>
        <!-- Read modal -->
        <?php include('src/view/adminCrud/readModal/readModalCanne.php'); ?>
        <!-- Delete modal -->
        <?php include('src/view/adminCrud/modalDelete/modalDeleteCanne.php'); ?>
        <?php include('src/view/adminCrud/modalDelete/modalDeleteCategorie.php'); ?>
        <?php include('src/view/adminCrud/modalDelete/modalDeleteMarque.php'); ?>
        <?php include('src/view/adminCrud/modalDelete/type/modalDeleteTypeCanne.php'); ?>

    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once('src/include/footer.php') ?>
    </footer>

    <script src="assets/js/recupId.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

</body>

</html>