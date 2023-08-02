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

document.addEventListener("DOMContentLoaded", () => {
    const profilButtonMobile = document.querySelector('#profil-button-mobile');
    const profilTabMobile = document.getElementById('profil-tab-mobile');

    profilButtonMobile.addEventListener('click', (event) => {
        profilTabMobile.classList.toggle('hidden');
        profilTabMobile.classList.add('absolute');
        event.stopPropagation();
    });

    document.addEventListener('click', (event) => {
        if (!profilTabMobile.contains(event.target) || !profilButtonMobile.contains(event.target)) {
            profilTabMobile.classList.add('hidden');
        }
    });  
});