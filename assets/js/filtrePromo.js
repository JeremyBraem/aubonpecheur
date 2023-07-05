document.addEventListener("DOMContentLoaded", function ()
{
    let filtres = document.querySelectorAll(".filtre");

    for (let i = 0; i < filtres.length; i++)
    {
        filtres[i].addEventListener("change", function () 
        {
            handleFiltre();
        });
    }

    function handleFiltre() 
    {
        let valeursFiltres = Array.from(filtres)
        .filter(function (filtre) 
        {
            return filtre.checked;
        })
        .map(function (filtre) 
        {
            console.log(filtre.value);
            return filtre.value;
        });

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "index.php?action=filtrePromo", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function ()
        {
            if (xhr.readyState === 4 && xhr.status === 200) 
            {
                // Mettre à jour le contenu du conteneur avec les nouveaux articles
                document.getElementById("listeArticles").innerHTML = xhr.responseText;
            }
        };
        xhr.send("filtres=" + encodeURIComponent(JSON.stringify(valeursFiltres)));
    }
});
