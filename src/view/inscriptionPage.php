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
    <title>Inscription</title>
</head>

<body class="bg-[#fcfcfc]">

    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?> 
    </header>

    <main>

        <div class="flex flex-col md:flex-row">

            <div class="w-full h-[100px] md:w-2/5 md:h-full">
                <img class="hidden md:block w-full h-full object-cover" src="assets/img/site/pexels-luqmaan-tootla-3104444.jpg">
                <img class="block md:hidden w-full h-full object-cover" src="assets/img/site/pexels-lumn-294674.jpg">
            </div>

            <div class="md:w-3/5">

                <div class="p-5 mt-5 mb-3">
                    <h1 class="text-center text-xl font-semibold">Inscrivez-vous</h1>
                </div>

                <form class="flex flex-col w-2/3 m-auto mb-8 md:mb-10" method="post" action="index.php?action=signUpTraitement">

                    <label class="ml-1 mb-1">E-mail</label>
                    <input type="email" placeholder="Veillez rentrer votre e-mail" name="email" class="mb-7 border rounded border-black px-2 py-1">
                    
                    <label class="ml-1 mb-1">Nom</label>
                    <input placeholder="Veillez rentrer votre nom" name="lastname" class="mb-7 border rounded border-black px-2 py-1">
                    
                    <label class="ml-1 mb-1">Prénom</label>
                    <input placeholder="Veillez rentrer votre prénom" name="name" class="mb-7  border rounded border-black px-2 py-1">
                    
                    <label class="ml-1 mb-1">Mot de passe</label>
                    <input type="password" placeholder="Veillez rentrer votre mot de passe" name="password" class="mb-7 border rounded border-black px-2 py-1">
                    
                    <label class="ml-1 mb-1">Verification du mot de passe</label>
                    <input type="password" placeholder="Veillez confirmer votre mot de passe" name="verif_password" class="mb-7 border rounded border-black px-2 py-1">
                    
                    <?php if(isset($_SESSION['messageError']))
                    { ?>
                    <p class="text-sm text-red-500 mb-5 font-semibold"><?php echo $_SESSION['messageError']; ?></p>
                    <?php session_unset(); 
                    } ?>
                    
                    <button type="submit" class="py-2 mx-5 md:mx-24 lg:mx-32 mt-5 text-[#fcfcfc] rounded bg-[#426EC2]">Inscription</button>

                </form>

                <div>
                    <p class="text-center my-5">Déjà inscrit ? <a class="text-[#426EC2] underline" href="index.php?action=login">Connectez-vous !</a></p>
                </div>

            </div>

        </div>

    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once ('src/include/footer.php') ?>
    </footer>

</body>

</html>