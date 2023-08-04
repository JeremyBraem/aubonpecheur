<details class="bg-[#fcfcfc] p-3 m-5 md:hidden">

    <summary class="list-none flex flex-wrap items-center justify-center">
        <h3 class="text-xl">Filtre ▼</h3>
    </summary>

    <details class="bg-[#fcfcfc] py-3 mt-1" style="border-top: 1px solid #000000;">

        <summary class="list-none flex flex-wrap">
            <h3 class="">Marques ▼</h3>
        </summary>

        <div class="py-3">

            <div class="flex flex-col bg-white">

                <?php foreach ($marques as $marque) { ?>
                    <div>
                        <input type="checkbox" value="<?php echo $marque->getNomMarque(); ?>" class="filtre">
                        <label><?php echo $marque->getNomMarque(); ?></label>
                    </div>
                <?php } ?>

            </div>

        </div>

    </details>

    <details class="bg-[#fcfcfc] py-3" style="border-top: 1px solid #000000;">

        <summary class="list-none flex flex-wrap items-center">
            <h3 class="">Categories ▼</h3>
        </summary>

        <div class="py-3">

            <div class="flex flex-col bg-white">

                <?php foreach ($categories as $categorie) { ?>
                    <div>
                        <input type="checkbox" value="<?php echo $categorie->getNomCategorie(); ?>" class="filtre">
                        <label><?php echo $categorie->getNomCategorie(); ?></label>
                    </div>
                <?php } ?>

            </div>

        </div>

    </details>

    <details class="bg-[#fcfcfc] py-3" style="border-top: 1px solid #000000;">

        <summary class="list-none flex flex-wrap items-center">
            <h3 class="">Types ▼</h3>
        </summary>

        <div class="py-3">

            <div class="flex flex-col bg-white ">

                <div>
                    <input type="checkbox" value="1" class="filtre">
                    <label for="cat-canne">Canne</label>
                </div>
                <div>
                    <input type="checkbox" value="2" class="filtre">
                    <label for="cat-moulinet">Moulinet</label>
                </div>
                <div>
                    <input type="checkbox" value="3" class="filtre">
                    <label for="cat-moulinet">Hamecon</label>
                </div>
                <div>
                    <input type="checkbox" value="8" class="filtre">
                    <label for="cat-moulinet">Appat</label>
                </div>
                <div>
                    <input type="checkbox" value="7" class="filtre">
                    <label for="cat-moulinet">Equipement</label>
                </div>
                <div>
                    <input type="checkbox" value="4" class="filtre">
                    <label for="cat-moulinet">Leurre</label>
                </div>
                <div>
                    <input type="checkbox" value="5" class="filtre">
                    <label for="cat-moulinet">Ligne</label>
                </div>
                <div>
                    <input type="checkbox" value="6" class="filtre">
                    <label for="cat-moulinet">Plomb</label>
                </div>
                <div>
                    <input type="checkbox" value="9" class="filtre">
                    <label for="cat-moulinet">Autre</label>
                </div>

            </div>

        </div>

    </details>

</details>

<div class="hidden md:flex flex-wrap gap-10 p-5 justify-center">
    <div>
        <details class="bg-[#fcfcfc] py-3 p-5 w-52">
            <summary class="list-none flex flex-wrap justify-center">
                <h3 class="cursor-pointer">Marques ▼</h3>
            </summary>
            <div class="py-3">
                <div class="flex flex-col bg-white">
                    <?php foreach ($marques as $marque) { ?>
                        <div>
                            <input type="checkbox" value="<?php echo $marque->getNomMarque(); ?>" class="filtre">
                            <label><?php echo $marque->getNomMarque(); ?></label>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </details>
    </div>
    <div>
        <details class="bg-[#fcfcfc] py-3 p-5 w-52">
            <summary class="cursor-pointer list-none flex flex-wrap justify-center">
                <h3 class="">Catégories ▼</h3>
            </summary>
            <div class="py-3">
                <div class="flex flex-col bg-white">
                    <?php foreach ($categories as $categorie) { ?>
                        <div>
                            <input type="checkbox" value="<?php echo $categorie->getNomCategorie(); ?>" class="filtre">
                            <label><?php echo $categorie->getNomCategorie(); ?></label>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </details>
    </div>
    <div>
        <details class="bg-[#fcfcfc] py-3 p-5 w-52">
            <summary class="list-none flex flex-wrap justify-center">
                <h3 class="cursor-pointer">Types ▼</h3>
            </summary>
            <div class="py-3">
                <div class="flex flex-col bg-white">
                    <div>
                        <input type="checkbox" value="1" class="filtre">
                        <label for="cat-canne">Canne</label>
                    </div>
                    <div>
                        <input type="checkbox" value="2" class="filtre">
                        <label for="cat-moulinet">Moulinet</label>
                    </div>
                    <div>
                        <input type="checkbox" value="3" class="filtre">
                        <label for="cat-moulinet">Hamecon</label>
                    </div>
                    <div>
                        <input type="checkbox" value="8" class="filtre">
                        <label for="cat-moulinet">Appat</label>
                    </div>
                    <div>
                        <input type="checkbox" value="7" class="filtre">
                        <label for="cat-moulinet">Equipement</label>
                    </div>
                    <div>
                        <input type="checkbox" value="4" class="filtre">
                        <label for="cat-moulinet">Leurre</label>
                    </div>
                    <div>
                        <input type="checkbox" value="5" class="filtre">
                        <label for="cat-moulinet">Ligne</label>
                    </div>
                    <div>
                        <input type="checkbox" value="6" class="filtre">
                        <label for="cat-moulinet">Plomb</label>
                    </div>
                    <div>
                        <input type="checkbox" value="9" class="filtre">
                        <label for="cat-moulinet">Autre</label>
                    </div>
                </div>
            </div>
        </details>
    </div>
</div>