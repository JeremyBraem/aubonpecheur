const listeArticlesDiv = document.getElementById("listeArticles");
const prevButton = document.getElementById("prevButton");
const nextButton = document.getElementById("nextButton");
let currentPage = 1;

async function loadAndDisplayProducts(page) {
  try {
    const response = await fetch(`article/Coup&page=${page}`);
    const produits = await response.json();

    listeArticlesDiv.innerHTML = "";

    produits.forEach(produit => {
      const produitElement = document.createElement("div");
      produitElement.textContent = produit.nom;
      listeArticlesDiv.appendChild(produitElement);
    });
  } catch (error) {
    console.error("Erreur lors de la récupération des produits :", error);
  }
}

prevButton.addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    loadAndDisplayProducts(currentPage);
  }
});

nextButton.addEventListener("click", () => {
  currentPage++;
  loadAndDisplayProducts(currentPage);
});

loadAndDisplayProducts(currentPage);
