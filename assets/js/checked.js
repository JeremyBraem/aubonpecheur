// Récupérer tous les liens du menu correspondant aux filtres
const filterLinks = document.querySelectorAll('.filter-link');

// Ajouter un gestionnaire d'événement de clic sur chaque lien du menu
filterLinks.forEach(link => {
  link.addEventListener('click', function(event) {
    event.preventDefault(); // Empêcher le comportement par défaut du lien

    const checkboxValue = this.getAttribute('data-value'); // Récupérer la valeur du filtre

    // Trouver la case à cocher correspondante en utilisant la valeur du filtre
    const checkbox = document.querySelector(`input[value="${checkboxValue}"]`);
    
    // Cocher ou décocher la case à cocher correspondante
    checkbox.checked = !checkbox.checked;
  });
});
