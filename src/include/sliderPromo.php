<div class="flex items-center relative md:w-5/6 m-auto">

    <div class="flex items-center justify-center overflow-hidden p-10">

        <div class="overflow-hidden">

            <button aria-label="slide backward" class="absolute z-30 left-1 top-1/2 transform -translate-y-1/2 cursor-pointer" id="prevPromo">
                <img class="w-5" src="/assets/img/site/fleche.png">
            </button>

            <div id="sliderPromo" class="h-full ml-2 flex lg:gap-8 md:gap-6 gap-10 items-center justify-start transition ease-out duration-700">

                <?php foreach ($promoProduits as $produit) { ?>

                    <div class="w-56">

                        <a href="/<?php echo $produit->getNomGenre(); ?>Page/<?php echo $produit->getIdProduit(); ?>">

                            <div class="w-56">
                                <img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="<?php echo $produit->getNomImage(); ?>" />
                            </div>

                        </a>

                        <div class="flex justify-center gap-10 py-3">

                            <div>

                                <div class="flex">

                                    <p class="text-s md:text-lg">
                                        <?php
                                        $nom = $produit->getNomProduit();
                                        if (strlen($nom) > 20) {
                                            echo substr($nom, 0, 17) . '...';
                                        } else {
                                            echo $nom;
                                        }
                                        ?>
                                    </p>

                                    <p class="ml-10 text-s md:text-xl uppercase">
                                        <?php
                                        $prix = $produit->getPrixProduit() . '€';
                                        if (strlen($prix) > 50) {
                                            echo substr($prix, 0, 47) . '...';
                                        } else {
                                            echo $prix;
                                        }
                                        ?>
                                    </p>

                                </div>
                                <p class="text-xs md:text-sm uppercase">
                                    <?php
                                    $marque = $produit->getNomMarque();
                                    if (strlen($marque) > 50) {
                                        echo substr($marque, 0, 47) . '...';
                                    } else {
                                        echo $marque;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <button id="profil-button" class="bg-[#426EC2] rounded-full p-2">
                            <img class="add-to-cart-btn w-6 h-6" data-name="<?php echo $produit->getNomProduit(); ?>" data-price="<?php echo $produit->getPrixProduit(); ?>" data-image="<?php echo $produit->getNomImage(); ?>" data-genre="<?php echo $produit->getNomGenre(); ?>" data-id="<?php echo $produit->getIdProduit(); ?>" src="assets/img/site/addCart.png">
                        </button>
                    </div>

                <?php } ?>

            </div>

            <button aria-label="slide forward" class="absolute z-30 right-1 top-1/2 transform -translate-y-1/2 cursor-pointer" id="nextPromo">
                <img class="w-5" src="/assets/img/site/159606.png">
            </button>

        </div>

    </div>

</div>