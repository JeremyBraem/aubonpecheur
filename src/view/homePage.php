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
        tailwind.config = 
        {
            theme: 
            {
                extend: 
                {
                    colors: 
                    {
                        clifford: '#da373d',
                    }
                }
            }
        }
    </script>
    <title>Accueil</title>
</head>

<body class="bg-[#fcfcfc]">

    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?> 
    </header>

    <main>

        <section>

            <div class="w-full lg:h-[300px] h-[120px]">
                <video class="w-full h-full object-cover" loop muted autoplay>
                    <source src="assets/video/homeVideo.mp4" type="video/mp4">
                </video>
            </div>

        </section>

        <section>

            <div class="pt-7 pb-1">
                <h2 class="font-medium text-l lg:text-2xl text-[#426EC2] text-center mb-5">Nos Nouveautés</h2>
                <hr class="border-b border-[#426EC2] w-2/3 m-auto">

                <?php require_once ('src/include/sliderNews.php'); ?>
            </div>
   
        </section>

        <section class="bg-[#426EC2] pb-5 md:pb-10">

            <div class="pt-7 pb-1">
                <h2 class="font-medium text-l lg:text-2xl text-[#fcfcfc] text-center mb-5">Nos Marques</h2>
                <hr class="border-b border-[#fcfcfc] w-2/3 m-auto">
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-y-3 p-5 md:px-14 lg:px-32">

                <div class="bg-[#fcfcfc] w-32 h-16 md:w-40 md:h-20 m-auto flex">

                    <div class="w-28 h-16 md:w-36 md:h-20 m-auto overflow-hidden">
                        <img src="assets/img/marque/quantum-fishing-logo-0171ECF49E-seeklogo.com.png" class="w-full h-full object-contain" />
                    </div>

                </div>

                <div class="bg-[#fcfcfc] w-32 h-16 md:w-40 md:h-20 m-auto flex">

                    <div class="w-28 h-16 md:w-36 md:h-20 m-auto overflow-hidden">
                        <img src="assets/img/marque/Browning_text_logo-removebg-preview.png" class="w-full h-full object-contain" />
                    </div>

                </div>

                <div class="bg-[#fcfcfc] w-32 h-16 md:w-40 md:h-20 m-auto flex">

                    <div class="w-28 h-16 md:w-36 md:h-20 m-auto overflow-hidden">
                        <img src="assets/img/marque/rhino-black-cat-x0.png" class="w-full h-full object-contain" />
                    </div>

                </div>

                <div class="bg-[#fcfcfc] w-32 h-16 md:w-40 md:h-20 m-auto flex">

                    <div class="w-28 h-16 md:w-36 md:h-20 m-auto overflow-hidden">
                        <img src="assets/img/marque/zebco-fishing-vector-logo-removebg-preview.png" class="w-full h-full object-contain" />
                    </div>

                </div>

                <div class="bg-[#fcfcfc] w-32 h-16 md:w-40 md:h-20 m-auto flex">

                    <div class="w-28 h-16 md:w-36 md:h-20 m-auto overflow-hidden">
                        <img src="assets/img/marque/logo_footer_rhino.png" class="w-full h-full object-contain" />
                    </div>

                </div>

            </div>

        </section>

        <section>
            <div class="pt-7 pb-1">
                <h2 class="font-medium text-l lg:text-2xl text-[#426EC2] text-center mb-5">Actuellement en Promotion</h2>
                <hr class="border-b border-[#426EC2] w-2/3 m-auto">
                <?php require_once ('src/include/sliderPromo.php'); ?>

            </div>

        </section>

        <section class="bg-[url('assets/img/site/devanture-103.jpg')] w-full">
            
            <div class="bg-[#426EC2] bg-opacity-80 pb-14">

                <div>

                    <div>

                        <div class="pt-7 pb-5">
                            <h2 class="font-medium text-l lg:text-2xl text-[#fcfcfc] text-center mb-5 ">Pour nous contacter</h2>
                            <hr class="border-b border-[#fcfcfc] w-2/3 m-auto">
                        </div>

                        <div class="w-2/3 m-auto flex flex-col gap-4 md:flex-row md:w-2/3 md:m-auto md:px-12 md:justify-between">

                            <div class="flex flex-col gap-1">
                                <p class="text-[#fcfcfc] md:text-xl font-semibold">Téléphone :</p>
                                <p class="text-[#fcfcfc] text-xs md:text-base font-semibold">03-24-26-69-80</p>
                            </div>
                            
                            <div class="flex flex-col gap-1">
                                <p class="text-[#fcfcfc] md:text-xl font-semibold">E-mail :</p>
                                <p class="text-[#fcfcfc] text-xs md:text-base font-semibold">aubonpecheur2013@yahoo.fr</p>
                            </div>
                            
                        </div>

                    </div>

                    <div class="">

                        <div class="pt-7 pb-5 ml-auto">
                            <h2 class="font-medium text-l lg:text-2xl text-[#fcfcfc] text-center mb-5">Notre magasin</h2>
                            <hr class="border-b border-[#fcfcfc] w-2/3 m-auto">
                        </div>

                        <div class="flex flex-col gap-3 md:flex-row md:m-auto md:px-24 md:justify-between">

                            <div class="m-auto flex flex-col gap-3 w-2/3 md:w-auto">

                                <p class="text-[#fcfcfc] md:text-xl font-semibold">Horaires :</p>

                                <div class="flex flex-col gap-2">
                                    <p class="text-[#fcfcfc] text-xs md:text-base font-semibold">Ouvert du Lundi au Vendredi 
                                    De 6h30 à 11h45-13h à 18h45</p>
                                    <p class="text-[#fcfcfc] text-xs md:text-base font-semibold">Samedi 6h à 12h-13h à 19h</p>
                                    <p class="text-[#fcfcfc] text-xs md:text-base font-semibold">Dimanche matin 6h à 11h30
                                    Fermé les jours fériés</p>
                                </div>
                                
                            </div>

                            <div class="m-auto flex flex-col gap-3 w-2/3 md:w-auto">

                                <p class="text-[#fcfcfc] md:text-xl font-semibold">Adresse :</p>

                                <div class="flex flex-row gap-5 md:flex-col md:gap-1">
                                    <p class="text-[#fcfcfc] text-xs md:text-base font-semibold">78 rue Jean Jaurès</p>
                                    <p class="text-[#fcfcfc] text-xs md:text-base font-semibold">08200 Sedan</p>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
                
        </section>
                
    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once ('src/include/footer.php') ?>
    </footer>

    <script src="assets/js/swiper.js"></script>
    <script src="assets/js/sliderPromo.js"></script>

</body>
</html>