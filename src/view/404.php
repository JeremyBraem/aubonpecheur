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
    <title>404</title>
</head>

<body class="bg-[#fcfcfc]">

    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?>
    </header>

    <main>

        <section class="md:w-2/3 m-auto py-5">
            
            <div class="px-4 py-12 items-center flex justify-center flex-col-reverse lg:flex-row md:gap-28 gap-16">
                <div class="w-full xl:w-1/2 relative pb-12 lg:pb-0">
                    <div class="relative">
                        <div class="absolute">
                            <div class="">
                                <h1 class="my-2 text-gray-800 font-bold text-2xl">
                                    La page où vous souhaitez aller n'existe pas !
                                </h1>
                                <p class="my-2 text-gray-800">Désolé ! Veuillez visiter notre page d'accueil pour savoir où vous devez aller.</p>
                            </div>
                        </div>
                        <div>
                            <img src="/assets/img/site/notfound.png" alt="Image 404"/>
                        </div>
                    </div>
                    <div class="md:hidden">
                        <img src="/assets/img/site/break404.png" alt="Image 404 débrancher"/>
                    </div>
                </div>
                <div class="hidden md:block">
                    <img src="/assets/img/site/break404.png" alt="Image 404 débrancher"/>
                </div>
            </div>

        </section>

    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once('src/include/footer.php') ?>
    </footer>

</body>

</html>