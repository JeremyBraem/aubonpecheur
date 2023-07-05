<tbody>
    <?php if ($articlesSelectionnes) 
    {
        foreach ($articlesSelectionnes as $article) 
        {
            if ($article['genre'] === 'canne') 
            {
                include('src/view/adminCrud/viewArticle/viewCanne.php');
            }

            if ($article['genre'] === 'moulinet') 
            {
                include('src/view/adminCrud/viewArticle/viewMoulinet.php');
            }

            if ($article['genre'] === 'hamecon') 
            {
                include('src/view/adminCrud/viewArticle/viewHamecon.php');
            }

            if ($article['genre'] === 'leurre') 
            {
                include('src/view/adminCrud/viewArticle/viewLeurre.php');
            }

            if ($article['genre'] === 'appat') 
            {
                include('src/view/adminCrud/viewArticle/viewAppat.php');
            }

            if ($article['genre'] === 'equipement') 
            {
                include('src/view/adminCrud/viewArticle/viewEquipement.php');
            }

            if ($article['genre'] === 'ligne') 
            {
                include('src/view/adminCrud/viewArticle/viewLigne.php');
            }

            if ($article['genre'] === 'plomb') 
            {
                include('src/view/adminCrud/viewArticle/viewFeeder.php');
            }
        }
    } 
    else 
    {
        echo '';
    }
    ?>
</tbody>