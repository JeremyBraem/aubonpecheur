<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/css/reset.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <link rel="icon" href="/assets/img/site/icon.png" />

    <!--FLowbite-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <!--Tailwind -->
    <link href="/dist/output.css" rel="stylesheet">
    <title>Contact</title>
</head>

<body class="bg-[#fcfcfc]">

    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?>
    </header>

    <main>

        <section class="w-2/3 m-auto py-5">

            <div class="bg-[#fcfcfc] w-2/3 m-auto py-4 md:p-6">
                <h1 class="text-center font-semibold">Conditions Générales de Vente</h1>
            </div>

            <p class="md:w-2/3 m-auto">

                1. Dispositions Générales
                Lorem ipsum dolor sit amet, consectetur adipiscing elit...

                2. Commandes
                Lorem ipsum dolor sit amet, consectetur adipiscing elit...

                3. Paiement
                Lorem ipsum dolor sit amet, consectetur adipiscing elit...

                4. Livraison
                Lorem ipsum dolor sit amet, consectetur adipiscing elit...

                5. Retours et Remboursements
                Lorem ipsum dolor sit amet, consectetur adipiscing elit...

                6. Droits de Propriété Intellectuelle
                Lorem ipsum dolor sit amet, consectetur adipiscing elit...

                7. Limitation de Responsabilité
                Lorem ipsum dolor sit amet, consectetur adipiscing elit...

                8. Lois Applicables
                Lorem ipsum dolor sit amet, consectetur adipiscing elit...

                Pour plus de détails, veuillez consulter nos Conditions Générales de Vente complètes sur [insérer le lien vers la page CGV].

            </p>

        </section>

        <section class="bg-[url('/assets/img/site/devanture-103.jpg')] bg-no-repeat bg-cover w-full">
            
            <div class="bg-[#426EC2] bg-opacity-90 pb-14">

                <div>

                    <div>

                        <div class="pt-7 pb-5">
                            <h2 class="font-medium text-l lg:text-2xl text-[#fcfcfc] text-center mb-5 ">Pour nous contacter</h2>
                            <hr class="border-b border-[#fcfcfc] w-2/3 m-auto">
                        </div>

                        <div class="w-2/3 m-auto flex flex-col gap-4 md:flex-row md:px-12 md:justify-center md:gap-20">

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

                    <div>

                        <div class="pt-7 pb-5 ml-auto">
                            <h2 class="font-medium text-l lg:text-2xl text-[#fcfcfc] text-center mb-5">Notre magasin</h2>
                            <hr class="border-b border-[#fcfcfc] w-2/3 m-auto">
                        </div>

                        <div class="flex flex-col gap-3 md:flex-row md:px-24 md:justify-center md:gap-32">

                            <div class="m-auto flex flex-col gap-3 w-2/3 md:m-1 md:w-auto">

                                <p class="text-[#fcfcfc] md:text-xl font-semibold">Horaires :</p>

                                <div class="flex flex-col gap-2">
                                    <p class="text-[#fcfcfc] text-xs md:text-base font-semibold">Ouvert du Lundi au Vendredi 
                                    De 6h30 à 11h45-13h à 18h45</p>
                                    <p class="text-[#fcfcfc] text-xs md:text-base font-semibold">Samedi 6h à 12h-13h à 19h</p>
                                    <p class="text-[#fcfcfc] text-xs md:text-base font-semibold">Dimanche matin 6h à 11h30
                                    Fermé les jours fériés</p>
                                </div>
                                
                            </div>

                            <div class="m-auto flex flex-col gap-3 w-2/3 md:m-1 md:w-auto">

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
        <?php require_once('src/include/footer.php') ?>
    </footer>

</body>

</html>