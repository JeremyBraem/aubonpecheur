// Sélectionner toutes les cases à cocher
const checkboxes = document.querySelectorAll('input[type="checkbox"]');

// Ajouter un gestionnaire d'événement pour chaque case à cocher
checkboxes.forEach((checkbox) => {
  checkbox.addEventListener('change', filterArticles);
});

// Fonction de filtrage des articles
function filterArticles() {
  // Récupérer les filtres sélectionnés
  const selectedFilters = Array.from(checkboxes)
    .filter((checkbox) => checkbox.checked)
    .map((checkbox) => checkbox.value);

  // Filtrer les articles en fonction des filtres sélectionnés
  const filteredArticles = articles.filter((article) => {
    // Vérifier si l'article correspond à au moins un filtre sélectionné
    return selectedFilters.some((filter) => articleMatchesFilter(article, filter));
  });

  // Mettre à jour les résultats affichés sur la page
  updateResults(filteredArticles);
}

// Fonction pour vérifier si un article correspond à un filtre donné
function articleMatchesFilter(article, filter) {
  // Modifier cette fonction en fonction de la structure de vos articles et des filtres

  // Exemple de vérification basée sur la catégorie de l'article
  return article.category === filter;
}

// Fonction pour mettre à jour les résultats affichés sur la page
function updateResults(filteredArticles) {
  // Sélectionner l'élément où les résultats seront affichés
  const resultsContainer = document.getElementById('articles');

  // Effacer les résultats précédents
  resultsContainer.innerHTML = '';

  // Vérifier s'il y a des articles filtrés
  if (filteredArticles.length > 0) {
    // Créer les éléments HTML pour les articles filtrés
    const ul = document.createElement('ul');
    filteredArticles.forEach((article) => {
      const li = document.createElement('li');
      li.textContent = article.title; // Modifier en fonction de la propriété de l'article à afficher
      ul.appendChild(li);
    });

    // Ajouter les éléments au conteneur des résultats
    resultsContainer.appendChild(ul);
  } else {
    // Afficher un message si aucun article n'est trouvé
    resultsContainer.textContent = 'Aucun article trouvé.';
  }
}
