document.addEventListener("DOMContentLoaded", () => {
    const profilButton = document.querySelector('#profil-button');
    const profilTab = document.getElementById('profil-tab');

    profilButton.addEventListener('click', (event) => {
        profilTab.classList.toggle('hidden');
        profilTab.classList.add('absolute');
        event.stopPropagation();
    });

    document.addEventListener('click', (event) => {
        if (!profilTab.contains(event.target) || !profilButton.contains(event.target)) {
            profilTab.classList.add('hidden');
        }
    });

    
});