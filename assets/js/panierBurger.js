document.addEventListener("DOMContentLoaded", () => {
    const cartButton = document.querySelector('#cart-button');
    const cartSlide = document.getElementById('cart');
    const closeButton = document.getElementById('close-button');
    const overlay = document.querySelectorAll('cart-backdrop');

    cartButton.addEventListener('click', (event) => {
        cartSlide.classList.toggle('hidden');
        cartSlide.classList.add('block');
        event.stopPropagation();
    });

    closeButton.addEventListener('click', () => {
        cartSlide.classList.add('hidden');
    });

    overlay.addEventListener('click', (event) => {
        if (!cartSlide.contains(event.target)) {
            cartSlide.classList.add('hidden');
        }
    });
});