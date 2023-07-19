<div class="flex items-center relative md:w-5/6 m-auto">

    <div class="flex items-center justify-center overflow-hidden p-10">

        <div class="overflow-hidden">

            <button aria-label="slide backward" class="absolute z-30 left-1 top-1/2 transform -translate-y-1/2 cursor-pointer" id="prev">
                <img class="w-5" src="/assets/img/site/favPrev.png">
            </button>

            <div id="slider" class="h-full ml-2 flex lg:gap-8 md:gap-6 gap-10 items-center justify-start transition ease-out duration-700">

                <?php foreach ($combinedArticles as $article) { ?>

                    <div class="w-56">

                        <a href="/<?php echo $article['genre']; ?>Page/<?php echo $article['id']; ?>">

                            <div class="w-56">
                                <img class="object-cover object-center w-56 h-56" style="border: 1px solid #fcfcfc;" src="<?php echo $article['image']; ?>"/>
                            </div>

                        </a>

                        <div class="flex justify-center gap-10 py-3">

                            <div>
                                <p class="text-s md:text-lg text-[#fcfcfc]">
                                    <?php
                                    $nom = $article['nom'];
                                    if (strlen($nom) > 20) 
                                    {
                                        echo substr($nom, 0, 17) . '...';
                                    } 
                                    else 
                                    {
                                        echo $nom;
                                    }
                                    ?>
                                </p>
                                <p class="text-xs md:text-sm uppercase text-[#fcfcfc]">
                                    <?php
                                        $marque = $article['marque'];
                                        if (strlen($marque) > 50) {
                                            echo substr($marque, 0, 47) . '...';
                                        } else {
                                            echo $marque;
                                        }
                                    ?>
                                </p>
                            </div>

                            <?php if($_SESSION) { ?>

                                <div>

                                    <form class="favoris-form" method="post" action="index.php?action=addFavorisTraitement">
                                        <input type="hidden" name="id_<?php echo $article['genre']; ?>" value="<?php echo $article['id']; ?>">
                                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
                                        <input type="hidden" name="genre" value="<?php echo $article['genre']; ?>">
                                        <input type="hidden" name="date_ajout_favoris" value="<?php echo $today = date("d/m/y"); ?>">
                                        <?php if(isset($_GET['action'])) { ?>
                                        <input type="hidden" name="page" value="<?php echo $_GET['action'] ?>">
                                        <?php }else{ echo ''; } ?>
                                        
                                        <?php if ($_SESSION[$article['genre']]) { ?>

                                            <?php foreach($_SESSION[$article['genre']] as $idTab) { ?>

                                                <?php if(in_array($article['id'], $idTab)) { ?>

                                                    <button class="favoris-button" type="submit">
                                                        <img class="w-6 h-6 mt-1" src="/assets/img/site/likedFav.png">
                                                    </button>

                                                <?php } else { ?>

                                                    <button class="favoris-button" type="submit">
                                                        <img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">
                                                    </button>
                                                    
                                                <?php } ?>

                                            <?php } ?>

                                        <?php } else { ?>

                                            <button class="favoris-button" type="submit">
                                                <img class="w-6 h-6 mt-1" src="/assets/img/site/like.png">
                                            </button>

                                        <?php } ?>

                                    </form>

                                </div>

                                <?php } ?>

                        </div>
                        

                    </div>

                <?php } ?>

            </div>

            <button aria-label="slide forward" class="absolute z-30 right-1 top-1/2 transform -translate-y-1/2 cursor-pointer" id="next">
                <img class="w-5" src="/assets/img/site/favNext.png">
            </button>

        </div>

    </div>

</div>