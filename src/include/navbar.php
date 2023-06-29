<nav class="lg:py-7 relative lg:p-2 flex justify-between items-center bg-[#426EC2]">

    <div class="lg:hidden">

        <button class="navbar-burger items-center text-white p-3">
            <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
            </svg>
        </button>

    </div>

    <ul class="hidden gap-4 absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 lg:flex lg:mx-auto lg:flex lg:items-center lg:w-auto lg:space-x-6">
        <li><a class="text-m text-white" href="index.php">Accueil</a></li>
        <li><a class="text-m text-white" href="">Promotion</a></li>
        <li><a class="text-m text-white" href="">Marque</a></li>
        <li><a class="text-m text-white" href="">Carpe</a></li>
        <li><a class="text-m text-white" href="">Coup</a></li>
        <li><a class="text-m text-white" href="">Truite</a></li>
        <li><a class="text-m text-white" href="">Carnassier</a></li>
        <li><a class="text-m text-white" href="">Sillure</a></li>
        <li><a class="text-m text-white" href="">Feeder</a></li>
        <li><a class="text-m text-white" href="">Equipement</a></li>
    </ul>

</nav>

<div class="navbar-menu relative z-50 hidden">
    <div class="navbar-backdrop fixed inset-0 bg-[#FCFCFC] opacity-25"></div>
    <nav class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-white border-r overflow-y-auto">
        <div class="flex items-center mb-8">
            <a class="m-auto text-3xl font-bold leading-none" href="#">
                <img class="w-[100px]" src="assets/img/site/logo_au_bon_pecheur.svg">
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
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="#">Accueil</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="#">Promotion</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="#">Marque</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="">Carpe</a>
                </li>

                <li class="mb-1">
                    <a data-value="Coup" class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="">Coup</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="#">Carnassier</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="#">Truite</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="#">Sillure</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="#">Feeder</a>
                </li>

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="#">Equipement</a>
                </li>

            </ul>

            <div class="items-center p-4">
                <div class="flex flex-col">
                    <a class="py-1 text-sm font-semibold text-gray-600" href="#">Connexion</a>
                    <a class="py-1 text-sm font-semibold text-gray-600" href="#">Inscription</a>  
                </div>
            </div>

        </div>

    </nav>

</div>

<script src="assets/js/navbarBurger.js"></script>