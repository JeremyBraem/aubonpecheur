<nav class="lg:py-7 relative lg:p-2 flex justify-between items-center bg-[#426EC2]">

    <div class="lg:hidden">

        <button class="navbar-burger items-center text-white p-3">
            <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
            </svg>
        </button>

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
        <li><a class="text-m text-white" href="/Equipement">Equipement</a></li>
        <?php 
        if(isset($_SESSION['id_role']))
        {
            if(!empty($_SESSION['id_role']))
            {
                if($_SESSION['id_role'] == 1)
                {
        ?>
        <li><a class="text-m text-white" href="/admin">Admin</a></li>
        <?php } } } ?>
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

                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="/Equipement">Equipement</a>
                </li>

                <?php 
                    if(isset($_SESSION['id_role']))
                    {
                        if(!empty($_SESSION['id_role']))
                        {
                            if($_SESSION['id_role'] == 1)
                            {
                ?>
                <li class="mb-1">
                    <a class="block pl-4 p-2 text-sm font-semibold text-gray-600" href="/admin.php">Admin</a>
                </li>
                <?php } } } ?>

            </ul>

            <div class="items-center p-4">
                <?php 
                    if(empty($_SESSION['id_role']))
                    { 
                    ?>
                    <div class="flex flex-col">
                        <a class="py-1 text-sm font-semibold text-gray-600" href="/login">Connexion</a>
                        <a class="py-1 text-sm font-semibold text-gray-600" href="/signUp">Inscription</a>  
                    </div>
                    <?php 
                    }
                    else
                    { 
                    ?>
                    <div class="flex flex-col">
                        <a class="py-1 text-sm font-semibold text-gray-600" href="/action=">Favoris</a>
                        <a class="py-1 text-sm font-semibold text-gray-600" href="/action=deconnexion">Déconnexion</a>
                    </div>
                    <?php 
                    }
                ?>
            </div>
            
        </div>

    </nav>

</div>

<script src="/assets/js/navbarBurger.js"></script>