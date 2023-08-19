<div id="update-leurreModal-<?php echo $leurre->getIdProduit() ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5">
                <h3 class="text-lg font-semibold text-gray-900 ">Modifier un leurre</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-target="update-leurreModal-<?php echo $leurre->getIdProduit() ?>" data-modal-toggle="update-leurreModal-<?php echo $leurre->getIdProduit() ?>">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="admin.php?action=updateLeurreTraitement" method="post" enctype="multipart/form-data">

                <div class="grid gap-4 mb-4 sm:grid-cols-2">

                    <div>
                        <label for="nom" class="block mb-2 text-sm font-medium text-gray-900">Nom du leurre :</label>
                        <input type="text" value="<?php echo $leurre->getNomProduit(); ?>" name="nom_produit" id="nom_produit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " placeholder="Nom de la leurre" required>
                    </div>

                    <div>
                        <label for="images" class="block mb-2 text-sm font-medium text-gray-900 ">Image</label>
                        <input type="file" id="images" name="images" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full" required>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description_images" class="block mb-2 text-sm font-medium text-gray-900 ">Description de l'image :</label>
                        <textarea name="description_images" value="<?php echo $leurre->getDescriptionImage(); ?>" id="description_images" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Écrire une description"><?php echo $leurre->getDescriptionImage(); ?></textarea>
                    </div>

                    <div>
                        <label for="couleur_leurre" class="block mb-2 text-sm font-medium text-gray-900 ">Couleur :</label>
                        <input type="text" name="couleur_leurre" value="<?php echo $leurre->getCouleurLeurre(); ?>" id="couleur_leurre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Poids en kg" required>
                    </div>

                    <div>
                        <label for="poids_leurre" class="block mb-2 text-sm font-medium text-gray-900 ">Poids :</label>
                        <input type="number" step="0.01" name="poids_leurre" value="<?php echo $leurre->getPoidsLeurre(); ?>" id="poids_leurre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " placeholder="Couleur" required>
                    </div>

                    <div>
                        <label for="prix_produit" class="block mb-2 text-sm font-medium text-gray-900 ">Prix :</label>
                        <input type="number" step="0.01" name="prix_produit" id="prix_produit" value="<?php echo $leurre->getPrixProduit(); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " placeholder="Prix en euro" required>
                    </div>

                    <div>
                        <label for="categorie_produit" class="block mb-2 text-sm font-medium text-gray-900 ">Categorie :</label>
                        <select id="categorie_produit" name="categorie_produit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                            <?php foreach ($categories as $categorie) { ?>
                                <option value="<?php echo $categorie->getIdCategorie(); ?>"><?php echo $categorie->getNomCategorie(); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label for="type_leurre" class="block mb-2 text-sm font-medium text-gray-900 ">Type :</label>
                        <select id="type_leurre" name="type_leurre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <?php foreach ($allTypes['leurre'] as $typeLeurre) { ?>
                                <option value="<?php echo $typeLeurre->getIdTypeLeurre(); ?>"><?php echo $typeLeurre->getNomTypeLeurre(); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label for="marque_produit" class="block mb-2 text-sm font-medium text-gray-900 ">Marque :</label>
                        <select id="marque_produit" name="marque_produit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <?php foreach ($marques as $marque) { ?>
                                <option value="<?php echo $marque->getIdMarque(); ?>"><?php echo $marque->getNomMarque(); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label for="promo_produit" class="block mb-2 text-sm font-medium text-gray-900 ">En promotion :</label>
                        <input type="number" id="promo_produit" value="<?php echo $produit->getPromoProduit() ?>" name="promo_produit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                    </div>

                    <div>
                        <label for="stock_produit" class="block mb-2 text-sm font-medium text-gray-900 ">En stock :</label>
                        <select id="stock_produit" name="stock_produit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                            <option value="stock">Oui</option>
                            <option value="hors_stock">Non</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description_produit" class="block mb-2 text-sm font-medium text-gray-900 ">Description :</label>
                        <textarea name="description_produit" id="description_produit" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Write product description here"><?php echo $leurre->getDescriptionProduit(); ?></textarea>
                    </div>

                </div>
                <input type="hidden" value="<?php echo $leurre->getIdProduit(); ?>" name="id_produit">

                <button type="submit" class="text-white inline-flex items-center bg-[#426EC2] hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Modifier un leurre
                </button>

            </form>

        </div>

    </div>

</div>
