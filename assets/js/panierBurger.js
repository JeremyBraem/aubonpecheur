document.addEventListener("DOMContentLoaded", () => {
    const cartButton = document.querySelector('#cart-button');
    const cartSlide = document.getElementById('cart');
    const closeButton = document.getElementById('close-button');

    cartButton.addEventListener('click', (event) => {
        cartSlide.classList.toggle('hidden');
        cartSlide.classList.add('block');
        event.stopPropagation();
    });

    closeButton.addEventListener('click', () => {
        cartSlide.classList.add('hidden');
    });

    document.addEventListener('click', (event) => {
        if (!cartSlide.contains(event.target) || !cartButton.contains(event.target)) {
            cartSlide.classList.add('hidden');
        }
    });
});