document.addEventListener("DOMContentLoaded", function () 
{
    let filtres = document.querySelectorAll(".filtre");
    let urlParams = new URLSearchParams(window.location.search);

    // Récupérer la valeur de "categorie" dans l'URL
    let categorie = window.location.pathname.split("/").pop();

    for (let i = 0; i < filtres.length; i++) {
        filtres[i].addEventListener("change", function () 
        {
            handleFiltre(categorie);
        });
    }

    function handleFiltre(categorie) {
        let valeursFiltres = Array.from(filtres)
            .filter(function (filtre) 
            {
                return filtre.checked;
            })
            .map(function (filtre) 
            {
                return filtre.value;
            });

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/index.php?action=filtrePageCate&categorie=" + encodeURIComponent(categorie), true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("listeArticles").innerHTML = xhr.responseText;
                updatePagination();
            }
        };
        xhr.send("filtres=" + encodeURIComponent(JSON.stringify(valeursFiltres)));
    }

    function updatePagination() {
        const paginationContainer = document.getElementById('pagination');
        paginationContainer.innerHTML = '';
    
        return;
    }
});
