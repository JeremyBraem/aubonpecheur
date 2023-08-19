<div class="flex items-center relative md:w-5/6 m-auto">

    <div class="flex items-center justify-center overflow-hidden p-8">

        <div class="overflow-hidden">

            <button aria-label="slide backward" class="absolute z-30 left-1 top-1/2 transform -translate-y-1/2 cursor-pointer" id="prevPromo">
                <img class="w-5" src="/assets/img/site/fleche.png">
            </button>

            <div id="sliderPromo" class="h-full ml-2 flex lg:gap-8 md:gap-6 gap-10 items-center justify-start transition ease-out duration-700">

                <?php foreach ($promoProduits as $produit) { ?>
                    <div class="w-56">

                        <div class="flex flex-col justify-center">

                            <div class="relative m-3 flex flex-wrap mx-auto justify-center ">

                                <div class="relative bg-white shadow-md p-2 my-3 rounded">

                                    <div class="overflow-x-hidden rounded-2xl relative w-56 h-56">
                                        <?php if ($produit->getPromoProduit() > 0) { ?>
                                            <span class="original-number absolute text-[#fcfcfc] text-sm left-2 top-2 z-40 p-1 px-[9px] w-auto text-center font-semibold rounded-full bg-[#e8330d]">-<?php echo $produit->getPromoProduit(); ?>%</span>
                                        <?php } ?>
                                        <img class="h-full rounded-2xl w-full object-cover" src="/<?php echo $produit->getNomImage() ?>">
                                        <p class="absolute right-2 top-2 bg-[#426EC2] rounded-full p-2 cursor-pointer group">
                                            <img class="add-to-cart-btn w-6 h-6" data-name="<?php echo $produit->getNomProduit(); ?>" 
                                            data-price="<?php if ($produit->getPromoProduit() > 0) 
                                            {
                                                echo $produit->getPrixPromoProduit();
                                            } 
                                            else 
                                            {
                                                echo $produit->getPrixProduit();
                                            } ?>" 
                                            data-image="<?php echo $produit->getNomImage(); ?>" 
                                            data-genre="<?php echo $produit->getNomGenre(); ?>" 
                                            data-id="<?php echo $produit->getIdProduit(); ?>" src="/assets/img/site/addCart.png">
                                        </p>
                                    </div>

                                    <div class="mt-4 pl-2 mb-2 flex justify-between ">
                                        <a href="/<?php echo $produit->getNomGenre(); ?>Page/<?php echo $produit->getIdProduit(); ?>">
                                            <p class="text-lg font-semibold text-gray-900 mb-0"><?php echo $produit->getNomProduit(); ?></p>
                                            <p class="text-lg text-gray-900 mb-0"><?php echo $produit->getNomMarque(); ?></p>
                                            <div class="flex gap-10">
                                                <?php if ($produit->getPromoProduit() > 0) { ?>
                                                    <p class="text-md text-gray-800 mt-0 line-through"><?php echo number_format($produit->getPrixProduit(), 2, '.', '') ?>€</p>
                                                    <p class="number text-md text-gray-800 mt-0"><?php echo number_format($produit->getPrixPromoProduit(), 2, '.', '') ?>€</p>
                                                <?php } else { ?>
                                                    <p class="text-md text-gray-800 mt-0"><?php echo number_format($produit->getPrixProduit(), 2, '.', '') ?>€</p>
                                                <?php } ?>
                                            </div>

                                        </a>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                <?php } ?>

            </div>

            <button aria-label="slide forward" class="absolute z-30 right-1 top-1/2 transform -translate-y-1/2 cursor-pointer" id="nextPromo">
                <img class="w-5" src="/assets/img/site/159606.png">
            </button>

        </div>

    </div>

</div>