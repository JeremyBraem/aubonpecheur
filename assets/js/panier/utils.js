import { updateCartUI } from "./index.js";

export function getCartFromSession() {
  return JSON.parse(sessionStorage.getItem("cart")) || [];
}

export function calculateTotal(cartItems) {
  let baseTotal = 0;
  cartItems.forEach((item) => {
    baseTotal += item.price * item.quantity;
  });

  const total = baseTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
  return total;
}

export function removeFromCart(itemId, event) {
  let cart = JSON.parse(sessionStorage.getItem("cart")) || [];
  cart = cart.filter((item) => item.itemId !== itemId);
  sessionStorage.setItem("cart", JSON.stringify(cart));
  updateCartUI();
  event.stopPropagation();
}

export function clearCart() {
  sessionStorage.removeItem("cart");
  updateCartUI();
}

export function formatPrice(price) {
  const formattedPrice = price.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
  return formattedPrice;
}

export function changeQuantity(itemId, change) {
  let cart = JSON.parse(sessionStorage.getItem("cart")) || [];
  const itemIndex = cart.findIndex((item) => item.itemId === itemId);

  if (itemIndex !== -1) {
    cart[itemIndex].quantity += change;

    if (cart[itemIndex].quantity <= 0) {
      cart.splice(itemIndex, 1);
    }

    sessionStorage.setItem("cart", JSON.stringify(cart));
    updateCartUI();
  }
}
