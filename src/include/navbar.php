<nav class="lg:py-7 relative lg:p-2 flex justify-between items-center bg-[#426EC2]">

    <div class="lg:hidden">

        <button class="navbar-burger items-center text-white p-3">
            <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
            </svg>
        </button>

    </div>
    <div class="w-2/3 relative lg:hidden m-auto">
        <div class="relative flex items-center">
            <input type="search" class="relative m-0 block min-w-0 flex-auto rounded-full border border-solid border-neutral-300 bg-[#fcfcfc] bg-clip-padding py-[0.05rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_#426EC2] focus:outline-none" placeholder="Recherche" aria-label="Search" aria-describedby="button-addon2" />
            <span class="absolute right-0 top-0 bottom-0 flex items-center pr-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </span>
        </div>
    </div>
    <ul class="hidden gap-4 absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 lg:flex lg:mx-auto lg:flex lg:items-center lg:w-auto lg:space-x-6">
        <li><a class="text-m text-white" href="/home">Accueil</a></li>
        <li><a class="text-m text-white" href="/promotion">Promotion</a></li>
        <li><a class="text-m text-white" href="/Marque">Marque</a></li>
        <li><a class="text-m text-white" href="/article/Carpe">Carpe</a></li>
        <li><a class="text-m text-white" href="/article/Coup">Coup</a></li>
        <li><a class="text-m text-white" href="/article/Truite">Truite</a></li>
        <li><a class="text-m text-white" href="/article/Carnassier">Carnassier</a></li>
        <li><a class="text-m text-white" href="/article/Silure">Silure</a></li>
        <li><a class="text-m text-white" href="/article/Plomb">Plomb</a></li>
        <?php
        if (isset($_SESSION['id_role'])) {
            if (!empty($_SESSION['id_role'])) {
                if ($_SESSION['id_role'] == 1) {
        ?>
                    <li><a class="text-m text-white" href="/admin">Admin</a></li>
        <?php }
            }
        } ?>
    </ul>

</nav>

<div class="navbar-menu relative z-50 hidden">

    <div class="navbar-backdrop fixed inset-0 bg-[#FCFCFC] opacity-25"></div>

    <nav class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-white border-r overflow-y-auto">

        <div class="flex items-center mb-8">
            <a class="m-auto text-3xl font-bold leading-none" href="/home">
                <img class="w-[100px]" src="/assets/img/site/logo_au_bon_pecheur.svg">
            </a>
            <button class="navbar-close">
                <svg class="h-6 w-6 text-gray-400 cursor-pointer hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div>
            <ul>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="/index">Accueil</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="/promotion">Promotion</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="/marque">Marque</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="/article/Carpe">Carpe</a>
                </li>

                <li class="mb-1">
                    <a data-value="Coup" class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="/article/Coup">Coup</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="/article/Carnassier">Carnassier</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="/article/Truite">Truite</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="/article/Silure">Sillure</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="/article/Plomb">Plomb</a>
                </li>
                <?php
                if (isset($_SESSION['id_role'])) {
                    if (!empty($_SESSION['id_role'])) {
                        if ($_SESSION['id_role'] == 1) {
                ?>
                            <li class="mb-1">
                                <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="/admin.php">Admin</a>
                            </li>
                <?php }
                    }
                } ?>

            </ul>

        </div>
    </nav>

</div>

<script src="/assets/js/navbarBurger.js"></script>