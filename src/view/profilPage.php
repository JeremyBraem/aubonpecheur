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
    <link rel="icon" href="assets/img/site/icon.png"/>

    <!--FLowbite-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet"/>
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

            <div class="w-full lg:h-[150px] h-[120px]">
                <image src="assets/img/site/pexels-lumn-294674.jpg" class="w-full h-full object-cover">
            </div>

        </section>

        <section>

            <div class="w-2/3 m-auto p-10">

                <div class="flex justify-center">
                    <h2 class="font-semibold text-[20px]">Profil de <?php echo $_SESSION['nom_user'] ?></h2>
                </div>

                <div>
                    <div class="flex justify-center gap-20 p-5">

                        <div>
                            <p class="mb-5">Nom : <span class="font-semibold"><?php echo $_SESSION['nom_user'] ?></span></p>
                            <p class="mb-5">Prénom : <span class="font-semibold"><?php echo $_SESSION['prenom_user'] ?></span></p>
                        </div>

                        <div>
                            <p class="mb-5">E-mail : <span class="font-semibold"><?php echo $_SESSION['email_user'] ?></span></p>
                            <p class="mb-5">Mot de passe : <span class="font-semibold">**********</span></p>
                        </div>

                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="py-3 px-10 text-[#fcfcfc] rounded bg-[#426EC2]">Modifier</button>
                    </div>

                </div>

            </div>

        </section>

        <section class="bg-[#426EC2] pt-5">

            <div class="text-center">
                <h2 class=" text-[#fcfcfc] font-semibold text-[20px]">Favoris : </h2>
            </div>

            <div>
                <?php include('src/include/sliderFavorie.php'); ?>
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