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

  <title>Panier - Au Bon Pêcheur</title>
</head>
<body class="bg-[#fcfcfc]">
  <header class="sticky top-0 bg-white shadow z-[999]">
    <?php require_once('src/include/headerPanier.php'); ?>
  </header>
  <h1 class="p-10 text-center text-2xl font-bold">Panier</h1>
  <div class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0 mb-20">
    <div class="rounded-lg md:w-2/3">
      <div id="cartItemsContainer">

      </div>
    </div>

    <div class="mt-6 h-full rounded-lg border bg-white p-6 shadow-md md:mt-0 md:w-1/3">
      <div class="flex justify-between">
        <p class="text-lg font-bold">Total</p>
        <div class="">
          <p class="mb-1 text-lg font-bold" id="total"></p>
          <p class="text-sm text-gray-700"></p>
        </div>
      </div>
      <div id="paypal-button-container"></div>
    </div>
  </div>
  <footer class="bg-[#fcfcfc]">
    <?php require_once('src/include/footer.php') ?>
  </footer>

  <script src="/assets/js/panierPage.js"></script>
  <script src="https://www.paypal.com/sdk/js?client-id=AUYMI_h7bSTPPu_Go8Paa31wzzpJ6pVAMmcl3vNVZBWWiLpMqQZ0x8KytNiQtYp6EtSqvu_6T2-juv7B&currency=EUR"></script>

</body>