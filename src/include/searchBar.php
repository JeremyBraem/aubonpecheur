<div class="hidden lg:flex w-full flex-row justify-between items-center px-6">
    <div>
        <a href="index.php?action=home"><img class="w-[105px] h-[105px]" src="assets/img/site/logo_au_bon_pecheur.svg"></a>
    </div>
    <div class="w-3/5 relative">
        <div class="relative flex items-center">
            <input
                type="search"
                class="relative m-0 block min-w-0 flex-auto rounded-full border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                placeholder="Recherche"
                aria-label="Search"
                aria-describedby="button-addon2" 
            />
            <!-- Search icon -->
            <span class="absolute right-0 top-0 bottom-0 flex items-center pr-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </span>
        </div>
    </div>
    <div class="flex items-center">
        <div>
            <img src="assets/img/site/3106773.png" class="w-[30px] h-[30px]">
        </div>
        <?php 
        if(empty($_SESSION['id_role']))
        { 
        ?>
        <div class="flex flex-col pl-3 pr-8">
            <a class="px-3 py-1 text-l text-black" href="index.php?action=login">Connexion</a>
            <a class="px-3 py-1 text-l text-black" href="index.php?action=signUp">Inscription</a>
        </div>
        <?php 
        }
        else
        { 
        ?>
        <div class="flex flex-col pl-3 pr-8">
            <a class="px-3 py-1 text-l text-black" href="index.php?action=">Favoris</a>
            <a class="px-3 py-1 text-l text-black" href="index.php?action=deconnexion">Déconnexion</a>
        </div>
        <?php 
        }
        ?>

    </div>
</div>


<div class="lg:hidden w-full flex flex-row justify-between items-center px-3">
    <div>
        <img class="w-[60px] h-[60px]" src="assets/img/site/logo_au_bon_pecheur.svg">
    </div>
    <div class="w-2/3 relative">
        <div class="relative flex items-center">
            <input
                type="search"
                class="relative m-0 block min-w-0 flex-auto rounded-full border border-solid border-neutral-300 bg-transparent bg-clip-padding py-[0.05rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_#426EC2] focus:outline-none"
                placeholder="Recherche"
                aria-label="Search"
                aria-describedby="button-addon2" 
            />
            <!-- Search icon -->
            <span class="absolute right-0 top-0 bottom-0 flex items-center pr-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </span>
        </div>
    </div>
    <div>
        <img src="assets/img/site/3106773.png" class="w-[30px] h-[30px]">
    </div>
</div>
