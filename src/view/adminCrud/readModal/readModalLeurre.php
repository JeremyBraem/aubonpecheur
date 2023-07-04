<div id="readLeurreModal-<?php echo $article['id'] ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-xl max-h-full">
                <!-- Modal content -->
                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                    <!-- Modal header -->
                    <div class="flex justify-between mb-4 rounded-t sm:mb-5">
                        <div class="text-lg text-gray-900 md:text-xl ">
                            <h3 class="font-semibold"><?php echo $article['nom'] ?></h3>
                            <p class=""><?php echo $article['marque'] ?></p>
                        </div>
                        <div>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="readLeurreModal-<?php echo $article['id'] ?>">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex gap-20">
                        <dl>
                            <dt class="mb-2 font-semibold leading-none text-gray-900">Description :</dt>
                            <dd class="mb-4 sm:mb-5"><?php echo $article['description'] ?></dd>
                            <dt class="mb-2 font-semibold leading-none text-gray-900">Categorie :</dt>
                            <dd class="mb-4 sm:mb-5"><?php echo $article['description'] ?></dd>
                            <dt class="mb-2 font-semibold leading-none text-gray-900">Type :</dt>
                            <dd class="mb-4 sm:mb-5"><?php echo $article['type'] ?></dd>
                        </dl>

                        <dl>
                            <dt class="mb-2 font-semibold leading-none text-gray-900">Poids :</dt>
                            <dd class="mb-4 sm:mb-5"><?php echo $article['poids'] ?></dd>
                            <dt class="mb-2 font-semibold leading-none text-gray-900">Couleur :</dt>
                            <dd class="mb-4 sm:mb-5"><?php echo $article['couleur'] ?></dd>
                        </dl>
                    </div>
                    
                </div>
            </div>
        </div>