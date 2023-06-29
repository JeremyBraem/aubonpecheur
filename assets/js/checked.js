// Récupérer tous les liens correspondant aux filtres
const filterLinks = document.querySelectorAll('.filter-link');

// Ajouter un gestionnaire d'événement de clic sur chaque lien
filterLinks.forEach(link => {
  link.addEventListener('click', function(event) {
    event.preventDefault(); // Empêcher le comportement par défaut du lien

    const checkboxValue = this.getAttribute('data-value'); // Récupérer la valeur du filtre

    // Cocher ou décocher la checkbox correspondante
    const checkbox = document.querySelector(`input[value="${checkboxValue}"]`);
    checkbox.checked = !checkbox.checked;
    
    // Soumettre le formulaire (si nécessaire)
    const filterForm = document.getElementById('filter-form');
    filterForm.submit();
  });
});
