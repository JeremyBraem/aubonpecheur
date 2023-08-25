import { addToCartEvent, updateCartUI } from "./addToCartEvent.js";
import { getCartFromSession } from "./utils.js";

document.addEventListener("DOMContentLoaded", () => {
//   const addToCartButtons = document.querySelectorAll(".add-to-cart-btn");
  const cartCountElementMobile = document.getElementById("cart-count-mobile");

  function updateCartCountMobile() {
    const cartItems = getCartFromSession();
    const totalQuantity = cartItems.reduce(
      (total, item) => total + item.quantity,
      0
    );
    cartCountElementMobile.textContent = totalQuantity;
  }

  updateCartCountMobile();

  document.getElementById("cart-button-mobile")
    .addEventListener("click", () => {
      updateCartCountMobile();
    });

  addToCartEvent();
  updateCartUI();
});

export { addToCartEvent, updateCartUI };
