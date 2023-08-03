document.addEventListener("DOMContentLoaded", function () 
{
    let filtres = document.querySelectorAll(".filtre");
    let urlParams = new URLSearchParams(window.location.search);

    // Récupérer la valeur de "marque" dans l'URL
    let marque = window.location.pathname.split("/").pop();

    for (let i = 0; i < filtres.length; i++) {
        filtres[i].addEventListener("change", function () {
            handleFiltre(marque);
        });
    }

    function handleFiltre(marque) {
        let valeursFiltres = Array.from(filtres)
            .filter(function (filtre) 
            {
                console.log(filtre.checked);
                return filtre.checked;
            })
            .map(function (filtre) {
                return filtre.value;
            });

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/index.php?action=filtrePageMarque&marque=" + encodeURIComponent(marque), true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () 
        {
            if (xhr.readyState === 4 && xhr.status === 200) 
            {
                document.getElementById("listeArticles").innerHTML = xhr.responseText;
            }
        };
        xhr.send("filtres=" + encodeURIComponent(JSON.stringify(valeursFiltres)));
    }
});