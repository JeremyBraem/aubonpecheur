<div id="updateCommandeModal-<?php echo $commande->getIdCommande() ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative p-4 bg-white rounded-lg shadow">
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5">
                <h3 class="text-lg font-semibold text-gray-900 ">Modifier l'état une commande</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-target="updateCommandeModal-<?php echo $commande->getIdCommande() ?>" data-modal-toggle="updateCommandeModal-<?php echo $commande->getIdCommande() ?>">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div>

                <div class="grid gap-4 mb-4 sm:grid-cols-2">

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Numéro de commande :</label>
                        <p class="block w-full "><?php echo $commande->getNumeroCommande() ?></p>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Client :</label>
                        <p class="block w-full "><?php echo $user->getLastNameUser() . ' ' . $user->getNameUser(); ?></p>
                    </div>

                    <div class="text-left mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Article de la commande :</label>
                        <div class="space-y-2">
                            <?php foreach ($resumeCommande as $article) { ?>
                                <div class="border  rounded-lg">
                                    <p class="mb-1"><?php echo $article->name . " - Quantité : " . $article->quantity . " - Prix unitaire : " . $article->price . " €"; ?></p>
                                    <?php $totalCommande += $article->price * $article->quantity; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>

                <form class="" action="admin.php?action=updateCommande" method="post">

                    <div class="mb-5">
                        <label for="etat_commande" class="mb-2  text-sm font-medium text-gray-900 ">État de la commande :</label>
                        <select id="etat_commande" name="etat_commande" class="w-1/2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5">
                            <option value="en_cours">En cours</option>
                            <option value="pret">Prête</option>
                            <option value="recup">Récupérer</option>
                            <option value="attente">En attente</option>
                            <option value="annule">Annulé</option>
                        </select>
                    </div>

                    <input type="hidden" value="<?php echo $commande->getIdCommande(); ?>" name="id_commande">

                    <button type="submit" class="text-white inline-flex items-center bg-[#426EC2] hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-auto">
                        Modifier l'état de la commande
                    </button>
                </form>

            </div>

        </div>

    </div>

</div>