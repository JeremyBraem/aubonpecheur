<div id="updateAppatModal-<?php echo $appat->getIdAppat() ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Modifier un appat</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateAppatModal-<?php echo $appat->getIdAppat() ?>">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="admin.php?action=UpdateAppatTraitement" method="post" enctype="multipart/form-data">
                
                <div class="grid gap-4 mb-4 sm:grid-cols-2">

                    <div>
                        <label for="nom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom de la appat</label>
                        <input type="text" name="nom_appat" id="nom_appat" value="<?php echo $appat->getNomAppat() ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 " placeholder="Type product name" required>
                    </div>

                    <div>
                        <label for="image_appat" class="block mb-2 text-sm font-medium text-gray-900">Image de la appat</label>
                        <input type="file" name="image_appat" id="image_appat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full" required>
                    </div>

                    <div>
                        <label for="detail_appat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Poids</label>
                        <input type="number" name="detail_appat" id="detail_appat" value="<?php echo $appat->getTypeAppat() ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 " placeholder="Poids en kg" required>
                    </div>

                    <div>
                        <label for="categorie_appat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categorie</label>
                        <select id="categorie_appat" name="categorie_appat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                            <?php foreach ($categories as $categorie) { ?>
                                <option value="<?php echo $categorie->getIdCategorie(); ?>"><?php echo $categorie->getNomCategorie(); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label for="type_appat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>
                        <select id="type_appat" name="type_appat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <?php foreach ($typeAppats as $typeAppat) { ?>
                                <option value="<?php echo $typeAppat->getIdTypeAppat(); ?>"><?php echo $typeAppat->getNomTypeAppat(); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label for="marque_appat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Marque</label>
                        <select id="marque_appat" name="marque_appat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <?php foreach ($marques as $marque) { ?>
                                <option value="<?php echo $marque->getIdMarque(); ?>"><?php echo $marque->getNomMarque(); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label for="promo_appat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">En promotion</label>
                        <select id="promo_appat" name="promo_appat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 ">
                            <option value="promo">Oui</option>
                            <option value="noPromo">Non</option>
                        </select>
                    </div>

                    <div>
                        <label for="stock_appat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">En stock</label>
                        <select id="stock_appat" name="stock_appat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 ">
                            <option value="stock">Oui</option>
                            <option value="hors_stock">Non</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description_appat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea name="description_appat" id="description_appat" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 " placeholder="Write product description here"></textarea>
                    </div>

                    <input type="hidden" name="id_appat" value="<?php echo $appat->getIdAppat() ?>">

                </div>

                <button type="submit" class="text-white inline-flex items-center bg-[#426EC2] hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    Modifier une appat
                </button>

            </form>

        </div>

    </div>

</div>