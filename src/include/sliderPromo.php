<div class="flex items-center justify-center">

    <button aria-label="slide backward" class="absolute z-30 left-3 xl:left-12 2xl:left-72 cursor-pointer" id="prevPromo">
        <img class="w-5" src="assets/img/site/fleche.png">
    </button>

    <div class="w-full p-10 relative flex items-center justify-center">

        <div class=" m-auto overflow-x-hidden overflow-y-hidden">

            <div id="sliderPromo" class="h-full ml-2 flex md:w-[1000px] lg:w-[1100px] 2xl:w-[1800px] lg:gap-8 md:gap-6 gap-10 items-center justify-start transition ease-out duration-700">
                
                <?php foreach($promoArticles as $article) { ?>

                    <a href="index.php?action=<?php echo $article['genre']; ?>Page&id=<?php echo $article['id']; ?>">
                        
                        <div class="w-56 md:h-80">

                            <div class="w-56">
                                <img src="<?php echo $article['image']; ?>" class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;"/>
                            </div>

                            <div class="md:w-56">
                                <p class="text-xs md:text-lg text-center"><?php echo $article['nom']; ?></p>
                                <p class="text-2xs md:text-sm text-center uppercase"><?php echo $article['marque']; ?></p>
                            </div>

                        </div>

                    </a>
                    
                <?php } ?>

            </div>

        </div>

    </div>

    <button aria-label="slide forward" class="absolute z-30 right-3 xl:right-12 2xl:right-72 cursor-pointer" id="nextPromo">
        <img class="w-5" src="assets/img/site/159606.png">
    </button>

</div>