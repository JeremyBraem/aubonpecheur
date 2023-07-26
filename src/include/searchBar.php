<div class="hidden lg:flex w-full flex-row justify-between items-center px-6">
    <div>
        <a href="/home"><img class="w-[90px] h-[90px]" src="/assets/img/site/logo_au_bon_pecheur.svg"></a>
    </div>
    <div class="w-3/5 relative">
        <form class="relative flex items-center" method="get" action="/search/">
            <input type="search" name="keywords" class="relative m-0 block min-w-0 flex-auto rounded-full border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none" placeholder="Recherche" aria-label="Search" aria-describedby="button-addon2" />
            <!-- Search icon -->
            <span class="absolute right-0 top-0 bottom-0 flex items-center pr-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </span>
        </form>
    </div>

    <div class="flex items-center gap-5 mr-10">

        <div class="relative">

            <button class="bg-[#426EC2] rounded-full p-2">
                <img src="/assets/img/site/3106773.png" class="w-[25px] h-[25px]">
            </button>

            <div id="cart" class="hidden absolute z-50 right-0 mt-2 w-64 bg-white rounded-lg shadow-lg">
                <div class="p-4">
                    <div class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
                        <div class="fixed inset-0 overflow-hidden">
                            <div class="absolute inset-0 overflow-hidden">
                                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                                    <div class="pointer-events-auto w-screen max-w-md">
                                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                                            <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                                                <div class="flex items-start justify-between">
                                                    <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Panier</h2>
                                                    <div class="ml-3 flex h-7 items-center">
                                                        <button id="close-button" type="button" class="m-2 p-2 text-gray-400 hover:text-gray-500">
                                                            <span class="sr-only">Close Cart</span>
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="mt-8">
                                                    <div class="flow-root">
                                                        <ul role="list" class="-my-6 divide-y divide-gray-200" id="cart-items">
                                                            <li class="flex py-6">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                                <div class="flex justify-between text-base font-medium text-gray-900">
                                                    <p>Total :</p>
                                                    <p id="cart-total">Total : 0€</p>
                                                </div>
                                                <div class="mt-6">
                                                    <a href="#" class="flex items-center justify-center rounded-md border border-transparent bg-[#426EC2] px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-[#425EC2]">Voir mon panier</a>
                                                </div>
                                                <div class="mt-6 flex justify-center text-center text-sm text-gray-500">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div>
            <button id="profil-button" class="bg-[#426EC2] rounded-full p-2">
                <img src="/assets/img/site/profil.png" class="w-[25px] h-[25px]">
            </button>
            <div class="hidden">
                <?php
                if (empty($_SESSION['id_role'])) {
                ?>
                    <div class="flex flex-col pl-3 pr-8">
                        <a class="px-3 py-1 text-l text-black" href="/login">Connexion</a>
                        <a class="px-3 py-1 text-l text-black" href="/signUp">Inscription</a>
                    </div>
                <?php
                } else {
                ?>
                    <div class="flex flex-col pl-3 pr-8">
                        <a class="px-3 py-1 text-l text-black" href="/profil">Compte</a>
                        <a class="px-3 py-1 text-l text-black" href="/deconnexion">Déconnexion</a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>

    </div>
</div>

<div class="lg:hidden w-full flex flex-row justify-between items-center px-3">
    <a href="/home">
        <img class="w-[60px] h-[60px]" src="assets/img/site/logo_au_bon_pecheur.svg">
    </a>
    <div class="w-2/3 relative">
        <div class="relative flex items-center">
            <input type="search" class="relative m-0 block min-w-0 flex-auto rounded-full border border-solid border-neutral-300 bg-transparent bg-clip-padding py-[0.05rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_#426EC2] focus:outline-none" placeholder="Recherche" aria-label="Search" aria-describedby="button-addon2" />
            <span class="absolute right-0 top-0 bottom-0 flex items-center pr-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </span>
        </div>
    </div>
    <button class="bg-[#426EC2] rounded-full p-2">
        <img src="/assets/img/site/3106773.png" class="w-[25px] h-[25px]">
    </button>
</div>
<script>
    const cartButton = document.querySelector('.relative button');
    const cartSlide = document.getElementById('cart');
    const closeButton = document.getElementById('close-button');

    cartButton.addEventListener('click', () => 
    {
        cartSlide.classList.toggle('hidden');
    });

    closeButton.addEventListener('click', () => 
    {
        cartSlide.classList.add('hidden');
    });
</script>