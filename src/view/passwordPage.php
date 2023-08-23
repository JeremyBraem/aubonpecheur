<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/css/reset.css" rel="stylesheet">
    <link href="/assets/css/font.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <link rel="icon" href="/assets/img/site/icon.png"/>
    <!--FLowbite-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <!--Tailwind -->
    <link href="/dist/output.css" rel="stylesheet">

    <title>Réinitialisation du mot de passe - Au Bon Pêcheur</title>
</head>

<body class="bg-[#fcfcfc]">

    <header class="sticky top-0 bg-white shadow z-50">
        <?php require_once('src/include/searchBar.php'); ?>
        <?php require_once('src/include/navbar.php'); ?> 
    </header>

    <main>

        <div class="flex flex-col md:flex-row">

            <div class="w-full h-[100px] md:w-2/5 md:h-[500px]">
                <img class="w-full h-full object-cover" src="/assets/img/site/pexels-lumn-294674.jpg">
            </div>

            <div class="md:w-3/5">

                <div class="p-5 mt-5 mb-3">
                    <h1 class="text-center text-xl font-semibold">Modifier votre mot de passe</h1>
                </div>

                <form class="flex flex-col w-2/3 m-auto mb-8 md:mb-10" action="/updatePass" method="post">

                    <label class="ml-1 mb-1">Nouveau mot de passe : </label>
                    <input type="password" placeholder="Veillez rentrer votre mot de passe" name="pass_user" class="mb-7 md:mb-10 border rounded border-black px-2 py-1" required>
            
                    <label class="ml-1 mb-1">Verification du nouveau mot de passe :</label>
                    <input type="password" placeholder="Veillez verifier votre mot de passe" name="verifpass_user" class="mb-3 border rounded border-black px-2 py-1" required>
                                        
                    <?php if(isset($_SESSION['messageError']))
                    { ?>
                    <p class="text-sm text-red-500 mb-5 font-semibold"><?php echo $_SESSION['messageError']; ?></p>
                    <?php session_unset(); 
                    } ?>

                    <input type="hidden" value="<?php echo $_GET['token'] ?>" name="token_user"required>
                    <input type="hidden" value="<?php echo $_GET['id'] ?>" name="id_user"required>
                    <button type="submit" class="py-2 mx-5 text-[#fcfcfc] rounded bg-[#426EC2]">Connexion</button>

                </form>

                <div>
                    <p class="text-center mb-5">Pas de compte ? <a class="text-[#426EC2] underline" href="/signUp">Inscrivez-vous !</a></p>
                </div>

            </div>

        </div>

    </main>

    <footer class="bg-[#fcfcfc]">
        <?php require_once ('src/include/footer.php') ?>
    </footer>

</body>

</html>