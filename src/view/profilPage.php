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
    <link rel="icon" href="/assets/img/site/icon.png" />
    <!--FLowbite-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <!--Tailwind -->
    <link href="/dist/output.css" rel="stylesheet">

    <title>Profil</title>
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

            <div class="w-2/3 m-auto py-10 md:p-10">

                <div class="flex justify-center">
                    <h2 class="font-semibold text-[20px]">Profil de <?php echo $_SESSION['prenom_user'] ?></h2>
                </div>

                <div>
                    <div class="flex flex-col md:flex-row justify-center md:gap-20 py-5 md:p-5">

                        <div class="">
                            <p class="mb-5">Nom : <span class="font-semibold"><?php echo $_SESSION['nom_user'] ?></span></p>
                            <p class="mb-5">Prénom : <span class="font-semibold"><?php echo $_SESSION['prenom_user'] ?></span></p>
                        </div>

                        <div>
                            <p class="mb-5">E-mail : <span class="font-semibold"><?php echo $_SESSION['email_user'] ?></span></p>
                            <p class="mb-5">Mot de passe : <span class="font-semibold">**********</span></p>
                        </div>

                    </div>

                    <div class="flex justify-center">
                        <button id="updateUserButton" onclick="toggleModal('updateUserModal')" type="button" class="py-3 px-10 text-[#fcfcfc] rounded bg-[#426EC2] hover:bg-[#424EC2]">Modifier</button>
                    </div>

                </div>

            </div>

        </section>

        <section class="pt-5">
            <div class="text-center">
                <h2 class="font-semibold text-[20px] mb-10">Commandes :</h2>
            </div>

            <div class="w-3/4 m-auto grid grid-cols-1 md:grid-cols-2">
                <?php foreach ($commandes as $commande) {
                    $resumeCommande = json_decode($commande->getResumeCommande());
                    $totalCommande = 0;
                ?>
                    <div class="mb-10 border border-3">
                        <div class="mb-5">
                            <a class="font-bold" href="/commande/numero=<?php echo $commande->getNumeroCommande() ?>">
                                <p class="mr-10">Numéro de commande : <span class="text-[#426EC2] underline underline-[#426EC2]"><?php echo $commande->getNumeroCommande() ?></span></p>
                            </a>
                            <p><strong>Date de commande :</strong> <?php echo $commande->getDateCommande() ?></p>
                        </div>

                        <div>
                            <p><strong>Article :</strong></p>
                            <?php foreach ($resumeCommande as $article) { ?>
                                <ul class="mb-1">
                                    <li><?php echo $article->name . " - Quantité : " . $article->quantity . " - Prix unitaire : " . $article->price . " €"; ?></li>
                                </ul>
                                <?php $totalCommande += $article->price * $article->quantity; ?>
                            <?php } ?>

                            <p class="mt-5"><strong>Total :</strong> <?php echo $totalCommande; ?> €</p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>

    <?php include('src/view/updateUserModal.php'); ?>

    <footer class="bg-[#fcfcfc]">
        <?php require_once('src/include/footer.php') ?>
    </footer>

    <script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
        if (!modal.classList.contains('hidden')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    }

    const closeButton = document.querySelector('[data-modal-close]');
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            toggleModal('updateUserModal');
        });
    }
    </script>

</body>

</html>