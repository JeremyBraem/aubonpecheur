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

  <title>Commande - Au Bon Pêcheur</title>
</head>

<body class="bg-gray-100">
  <header class="sticky top-0 bg-white shadow z-50">
    <?php require_once('src/include/searchbar.php'); ?>
    <?php require_once('src/include/navbar.php'); ?>
  </header>

  <main>
    <div class="container mx-auto px-4 py-8">
      <div class="bg-[#fcfcfc] rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold text-center mb-6">Merci pour votre commande !</h1>
        <p class="text-center mb-4">Votre commande a été traitée avec succès. Rendez-vous dans votre Au Bon Pêcheur magasin quand votre colis est prêt. <br>Voici les détails de votre commande :</p>
        <div class="border-t border-gray-300 pt-4 mt-4">
          <p class="mb-2"><strong>Nom :</strong> <?php echo $_SESSION['nom_user']; ?></p>
          <p class="mb-2"><strong>Prénom :</strong> <?php echo $_SESSION['prenom_user']; ?></p>
          <p class="mb-2"><strong>Email :</strong> <?php echo $_SESSION['email_user']; ?></p>
          <p class="mb-2"><strong>Numéro de commande :</strong> <?php echo $commande->getNumeroCommande(); ?></p>
          <p class="mb-2"><strong>Date de commande :</strong> <?php echo $date; ?></p>
          <p class="mb-2"><strong>Total de la commande :</strong> <?php echo $totalPrice; ?>€</p>
          <p class="mb-2"><strong>Articles commandés : </strong></p>
          <ul class="list-disc ml-6 mb-2">
            <?php foreach($resume as $produit) { ?>
            <li><?php echo $produit->name; ?> - <?php echo $produit->price; ?> € (Quantité: <?php echo $produit->quantity; ?>)</li>
            <?php } ?>
          </ul>
          <p class="mb-2"><strong>Etat de la commande : </strong><?php echo $commande->getEtatCommande(); ?></p>
        </div>
      </div>
    </div>
  </main>

  <footer class="bg-[#fcfcfc]">
    <?php require_once('src/include/footer.php') ?>
  </footer>
</body>

</html>