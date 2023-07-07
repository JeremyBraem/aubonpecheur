<div class="flex items-center justify-center">

    <button aria-label="slide backward" class="absolute z-30 left-3 xl:left-12 2xl:left-72 2xl:left-72 cursor-pointer" id="prev">
        <img class="w-5" src="assets/img/site/fleche.png">
    </button>

    <div class="w-full p-10 relative flex items-center justify-center">

        <div class="m-auto">

            <div id="slider" class="h-full ml-2 flex md:w-[1000px] xl:w-[1100px] 2xl:w-[1800px] lg:gap-8 md:gap-6 gap-10 items-center justify-start transition ease-out duration-700">

                <?php foreach ($combinedArticles as $article) { ?>

                    <div class="relative w-56 md:h-80">

                        <a href="index.php?action=<?php echo $article['genre']; ?>Page&id=<?php echo $article['id']; ?>">

                            <div class="w-56">
                                <img class="object-cover object-center w-56 h-56" style="border: 1px solid #000000;" src="<?php echo $article['image']; ?>" />
                            </div>

                            <div class="md:w-56">
                                <p class="text-xs md:text-lg text-center"><?php echo $article['nom']; ?></p>
                                <p class="text-2xs md:text-sm text-center uppercase"><?php echo $article['marque']; ?></p>
                            </div>

                        </a>

                        <?php if($_SESSION) { ?>

                            <div>

                                <form id="favorisForm" method="post" action="index.php?action=addFavorisTraitement">
                                    <input type="hidden" name="id_<?php echo $article['genre']; ?>" value="<?php echo $article['id']; ?>">
                                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
                                    <input type="hidden" name="genre" value="<?php echo $article['genre']; ?>">
                                    <input type="hidden" name="date_ajout_favoris" value="<?php echo $today = date("d/m/y"); ?>">
                                    <?php if (isset($_SESSION[$article['genre']]))
                                    {
                                        $favorisIds = array_column($_SESSION[$article['genre']], 'favoriscanne'); ?>

                                        <?php if (in_array($article['id'], $favorisIds)) { ?>
                                            <button type="submit">
                                                <img class="w-6 h-6" src="assets/img/site/liked.png">
                                            </button>
                                        <?php } else { ?>
                                            <button type="submit">
                                                <img class="w-6 h-6" src="assets/img/site/like.png">
                                            </button>
                                        <?php }
                                    } else { ?>
                                        <button type="submit">
                                            <img class="w-6 h-6" src="assets/img/site/like.png">
                                        </button>

                                    <?php } ?>

                                </form>

                            </div>

                        <?php } ?>

                    </div>

                <?php } ?>

            </div>

        </div>

    </div>

    <button aria-label="slide forward" class="absolute z-30 right-3 xl:right-12 2xl:right-72 2xl:right-72 cursor-pointer" id="next">
        <img class="w-5" src="assets/img/site/159606.png">
    </button>

</div>