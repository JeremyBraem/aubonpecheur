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
        }
    } 
    else 
    {
        echo '';
    }
    ?>
</tbody>