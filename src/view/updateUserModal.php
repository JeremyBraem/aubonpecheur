<div id="updateUserModal" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 right-0 bottom-0 left-0 items-center justify-center z-50">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Mettre à jour le profil
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-close>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form action="/updateUser" method="post">
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="nom_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom :</label>
                        <input type="text" name="nom_user" id="nom_user" value="<?php echo $_SESSION['nom_user'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nom">
                    </div>
                    <div>
                        <label for="prenom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prénom :</label>
                        <input type="text" name="prenom_user" id="prenom_user" value="<?php echo $_SESSION['prenom_user'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Prénom">
                    </div>
                    <div>
                        <label for="email_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">E-mail :</label>
                        <input type="email" value="<?php echo $_SESSION['email_user'] ?>" name="email_user" id="email_user" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="E-mail">
                    </div>
                    <div>
                        <label for="pass_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot de passe :</label>
                        <input type="password" id="pass_user" name="pass_user" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ancien mot de passe pour ne pas changer">
                    </div>
                    <div>
                        <label for="verifpass" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vérification du mot de passe :</label>
                        <input type="password" id="verifpass_user" value="" name="verifpass_user" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ancien mot de passe pour ne pas changer">
                    </div>
                    <input type="hidden" id="id_user" value="<?php echo $_SESSION['id_user'] ?>" name="id_user">
                </div>
                <div class="flex items-center space-x-4">
                    <button type="submit" class="text-white bg-blue-500 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>