import { getCartFromSession, calculateTotal, formatPrice, removeFromCart, clearCart, changeQuantity} from "./utils";

export function addToCartEvent() {
  const addToCartButtons = document.querySelectorAll(".add-to-cart-btn");

  addToCartButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const name = button.getAttribute("data-name");
      const price = parseFloat(button.getAttribute("data-price"));
      const image = button.getAttribute("data-image");
      const genre = button.getAttribute("data-genre");
      const id = button.getAttribute("data-id");
      addToCart(name, price, image, genre, id);
    });
  });
}

function addToCart(name, price, image, genre, id) {
  let cart = JSON.parse(sessionStorage.getItem("cart")) || [];

  const itemId = generateItemId();

  let existingItem = cart.find((item) => item.name === name);

  if (existingItem) {
    existingItem.quantity++;
  } else {
    cart.push({ itemId, name, price, quantity: 1, image, genre, id });
  }

  sessionStorage.setItem("cart", JSON.stringify(cart));
  updateCartUI();
}

function generateItemId() {
  return Date.now().toString(36) + Math.random().toString(36).substr(2, 5);
}

export function updateCartUI() {
  const cartItems = getCartFromSession();
  const cartItemsContainer = document.getElementById("cart-items");
  const totalElement = document.getElementById("cart-total");
  const cartCountElement = document.getElementById("cart-count");

  cartItemsContainer.innerHTML = "";
  totalElement.textContent = "Total : " + calculateTotal(cartItems) + "€";

  cartCountElement.textContent = cartItems.reduce(
    (total, item) => total + item.quantity,
    0
  );

  cartItems.forEach((item) => {
    const cartItem = document.createElement("li");
    cartItem.className = "flex py-6";

    const cartItemImage = document.createElement("div");
    cartItemImage.className =
      "h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200";
    const image = document.createElement("img");
    image.src = "/" + item.image;
    image.alt = item.name;
    image.className = "h-full w-full object-cover object-center";
    cartItemImage.appendChild(image);
    const cartItemDetails = document.createElement("div");
    cartItemDetails.className = "ml-4 flex flex-1 flex-col";

    const itemName = document.createElement("div");
    itemName.className =
      "flex justify-between text-base font-medium text-gray-900";
    const nameLink = document.createElement("a");
    nameLink.href = `/${item.genre}Page/${item.id}`;
    nameLink.textContent =
      item.name.length > 20 ? `${item.name.substring(0, 17)}...` : item.name;
    const itemPrice = document.createElement("p");
    itemPrice.className = "ml-4 text-base font-medium uppercase";
    itemPrice.textContent = `${formatPrice(item.price)}€`;

    itemName.appendChild(nameLink);
    itemName.appendChild(itemPrice);

    const itemQuantity = document.createElement("p");
    itemQuantity.className = "mt-1 text-sm text-gray-500";
    itemQuantity.textContent = `Quantité ${item.quantity}`;

    const removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.className =
      "font-medium mt-7 text-indigo-600 hover:text-indigo-500";
    removeButton.textContent = "Supprimer";
    removeButton.addEventListener("click", (event) => {
      removeFromCart(item.itemId, event);
    });

    const quantityControls = document.createElement("div");
    quantityControls.className = "flex items-center mt-2";

    const decreaseButton = document.createElement("button");
    decreaseButton.type = "button";
    decreaseButton.textContent = "-";
    decreaseButton.className =
      "w-6 h-6 bg-gray-300 text-gray-600 rounded-full hover:bg-gray-400 focus:outline-none";
    decreaseButton.addEventListener("click", (event) => {
      event.stopPropagation();
      changeQuantity(item.itemId, -1);
    });

    const quantityDisplay = document.createElement("span");
    quantityDisplay.textContent = item.quantity;
    quantityDisplay.className = "mx-3 font-medium";

    const increaseButton = document.createElement("button");
    increaseButton.type = "button";
    increaseButton.textContent = "+";
    increaseButton.className =
      "w-6 h-6 bg-gray-300 text-gray-600 rounded-full hover:bg-gray-400 focus:outline-none";
    increaseButton.addEventListener("click", (event) => {
      event.stopPropagation();
      changeQuantity(item.itemId, 1);
    });

    quantityControls.appendChild(decreaseButton);
    quantityControls.appendChild(quantityDisplay);
    quantityControls.appendChild(increaseButton);

    cartItemDetails.appendChild(itemName);
    cartItemDetails.appendChild(itemQuantity);
    cartItemDetails.appendChild(quantityControls);
    cartItemDetails.appendChild(removeButton);

    cartItem.appendChild(cartItemImage);
    cartItem.appendChild(cartItemDetails);

    cartItemsContainer.appendChild(cartItem);
  });

  let lienPanier = document.getElementById("validePanier");

  if(cartItems.length == 0)
  {
      lienPanier.removeAttribute("href");
  
      lienPanier.style.pointerEvents = "none";
      lienPanier.style.opacity = "0.5";
  }
  else
  {
    lienPanier.setAttribute("href", "/panier");
    lienPanier.style.pointerEvents = "auto";
    lienPanier.style.opacity = "1";
  }

  const removeAllButton = document.createElement("button");
  removeAllButton.type = "button";
  removeAllButton.className = "font-medium text-red-600 hover:text-red-500";
  removeAllButton.textContent = "Vider le panier";
  removeAllButton.addEventListener("click", () => {
    clearCart();
  });
  cartItemsContainer.appendChild(removeAllButton);
}
