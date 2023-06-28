<?php
// Récupérer les valeurs des filtres
$filtres = isset($_POST['filtres']) ? json_decode($_POST['filtres']) : [];

// Filtrer les articles en fonction des filtres sélectionnés
$articlesFiltres = [];
foreach ($articles as $article) {
  // Vérifier si la marque de l'article fait partie des filtres sélectionnés
  if (in_array($article['marque'], $filtres)) {
    // Ajouter l'article à la liste des articles filtrés
    $articlesFiltres[] = $article;
  }
}

// Générer le contenu HTML de la nouvelle liste d'articles
$htmlArticles = '';
foreach ($articlesFiltres as $article) {
  $htmlArticles .= '<div class="article">';
  // Ajouter ici le code HTML pour afficher les détails de l'article
  $htmlArticles .= '</div>';
}

// Renvoyer le contenu HTML de la nouvelle liste d'articles
echo $htmlArticles;
?>
