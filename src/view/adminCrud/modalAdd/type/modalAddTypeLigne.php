<div id="createTypeLigneModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5">
                <h3 class="text-lg font-semibold text-gray-900">Ajouter un type de ligne</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-target="createTypeLigneModal" data-modal-toggle="createTypeLigneModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="flex flex-row justify-between gap-10 p-5">
                <!-- Modal body -->
                <form action="admin.php?action=addTypeLigneTraitement" method="post">

                    <div class="gap-4 mb-4">

                        <div>
                            <label for="nom_type_ligne" class="block mb-2 text-sm font-medium text-gray-900">Nom du type de ligne</label>
                            <input type="text" name="nom_type_ligne" id="nom_type_ligne" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Ajouter un nom" required>
                        </div>

                    </div>

                    <button type="submit" class="text-white inline-flex items-center bg-[#426EC2] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Ajouter un type de ligne
                    </button>

                </form>

                <div>

                    <h6 for="nom_type_ligne" class="block mb-2 text-sm font-medium text-gray-900">Nom des types de ligne</h6>
                    
                    <div class="grid grid-cols-2">

                        <?php foreach ($typeLignes as $typeLigne) { ?>
                        <div class="text-sm flex">

                            <p class="py-2"><?php echo $typeLigne->getNomTypeLigne(); ?></p>
                            <form class="flex" action="admin.php?action=deleteTypeLigne" method="post">

                                <input type="hidden" value="<?php echo $typeLigne->getIdTypeLigne(); ?>">

                                <button type="button" data-modal-target="deleteTypeLigneModal-<?php echo $typeLigne->getIdTypeLigne(); ?>" data-modal-toggle="deleteTypeLigneModal-<?php echo $typeLigne->getIdTypeLigne(); ?>" class="m-2 items-center text-red-500">
                                    <svg class="w-4 h-4 mr-2" viewbox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" d="M6.09922 0.300781C5.93212 0.30087 5.76835 0.347476 5.62625 0.435378C5.48414 0.523281 5.36931 0.649009 5.29462 0.798481L4.64302 2.10078H1.59922C1.36052 2.10078 1.13161 2.1956 0.962823 2.36439C0.79404 2.53317 0.699219 2.76209 0.699219 3.00078C0.699219 3.23948 0.79404 3.46839 0.962823 3.63718C1.13161 3.80596 1.36052 3.90078 1.59922 3.90078V12.9008C1.59922 13.3782 1.78886 13.836 2.12643 14.1736C2.46399 14.5111 2.92183 14.7008 3.39922 14.7008H10.5992C11.0766 14.7008 11.5344 14.5111 11.872 14.1736C12.2096 13.836 12.3992 13.3782 12.3992 12.9008V3.90078C12.6379 3.90078 12.8668 3.80596 13.0356 3.63718C13.2044 3.46839 13.2992 3.23948 13.2992 3.00078C13.2992 2.76209 13.2044 2.53317 13.0356 2.36439C12.8668 2.1956 12.6379 2.10078 12.3992 2.10078H9.35542L8.70382 0.798481C8.62913 0.649009 8.5143 0.523281 8.37219 0.435378C8.23009 0.347476 8.06631 0.30087 7.89922 0.300781H6.09922ZM4.29922 5.70078C4.29922 5.46209 4.39404 5.23317 4.56282 5.06439C4.73161 4.8956 4.96052 4.80078 5.19922 4.80078C5.43791 4.80078 5.66683 4.8956 5.83561 5.06439C6.0044 5.23317 6.09922 5.46209 6.09922 5.70078V11.1008C6.09922 11.3395 6.0044 11.5684 5.83561 11.7372C5.66683 11.906 5.43791 12.0008 5.19922 12.0008C4.96052 12.0008 4.73161 11.906 4.56282 11.7372C4.39404 11.5684 4.29922 11.3395 4.29922 11.1008V5.70078ZM8.79922 4.80078C8.56052 4.80078 8.33161 4.8956 8.16282 5.06439C7.99404 5.23317 7.89922 5.46209 7.89922 5.70078V11.1008C7.89922 11.3395 7.99404 11.5684 8.16282 11.7372C8.33161 11.906 8.56052 12.0008 8.79922 12.0008C9.03791 12.0008 9.26683 11.906 9.43561 11.7372C9.6044 11.5684 9.69922 11.3395 9.69922 11.1008V5.70078C9.69922 5.46209 9.6044 5.23317 9.43561 5.06439C9.26683 4.8956 9.03791 4.80078 8.79922 4.80078Z" />
                                    </svg>
                                </button>

                            </form>
                        </div>
                        <?php include('src/view/adminCrud/modalDelete/type/modalDeleteTypeLigne.php'); ?>

                        <?php } ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
