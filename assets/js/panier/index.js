import { addToCartEvent, updateCartUI } from "./addToCartEvent.js";
import { getCartFromSession } from "./utils.js";

document.addEventListener("DOMContentLoaded", () => {
  addToCartEvent();
  updateCartUI();
});

export { addToCartEvent, updateCartUI };
