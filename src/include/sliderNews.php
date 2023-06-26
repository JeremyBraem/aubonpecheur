<div class="flex items-center justify-center">

    <button aria-label="slide backward" class="absolute z-30 left-3 xl:left-24 2xl:left-72 cursor-pointer" id="prev">
        <img class="w-5" src="assets/img/site/fleche.png">
    </button>

    <div class="w-full p-10 relative flex items-center justify-center">

        <div class="m-auto overflow-x-hidden overflow-y-hidden">

            <div id="slider" class="h-full ml-2 flex md:w-[1000px] 2xl:w-[1600px] lg:gap-8 md:gap-6 gap-10 items-center justify-start transition ease-out duration-700">
                <?php foreach($combinedArticles as $article) { ?>
                    <div class="relative w-56 md:h-80">

                        <div class="w-56">
                            <img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" 
                                src="
                                <?php echo $article['image']; ?>"
                            />
                        </div>

                        <div class="md:w-56">
                            <p class="text-xs md:text-lg text-center"><?php echo $article['nom']; ?></p>
                            <p class="text-2xs md:text-sm text-center uppercase"><?php echo $article['marque']; ?></p>
                        </div>
                        
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>

    <button aria-label="slide forward" class="absolute z-30 right-3 xl:right-24 2xl:right-72 cursor-pointer" id="next">
        <img class="w-5" src="assets/img/site/159606.png">
    </button>

</div>