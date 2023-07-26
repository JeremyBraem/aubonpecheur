function getCartFromSession() {
    return JSON.parse(sessionStorage.getItem("cart")) || [];
  }
  
  function calculateTotal(cartItems) {
    let total = 0;
    cartItems.forEach((item) => {
      total += item.price * item.quantity;
    });
    return total;
  }
  
  function addToCart(name, price, image, genre, id) {
    let cart = JSON.parse(sessionStorage.getItem("cart")) || [];
  
    // Generate a unique identifier for the item
    const itemId = generateItemId();
  
    let existingItem = cart.find((item) => item.name === name);
  
    if (existingItem) {
      existingItem.quantity++;
    } else {
      cart.push({ itemId, name, price, quantity: 1, image, genre, id });
    }
  
    sessionStorage.setItem("cart", JSON.stringify(cart));
    displayCart();
  }
  
  function generateItemId() {
    return Date.now().toString(36) + Math.random().toString(36).substr(2, 5);
  }
  
  function removeFromCart(itemId) {
    let cart = JSON.parse(sessionStorage.getItem("cart")) || [];
    cart = cart.filter((item) => item.itemId !== itemId);
    sessionStorage.setItem("cart", JSON.stringify(cart));
    displayCart();
  }
  
  function clearCart() {
    sessionStorage.removeItem("cart");
    displayCart();
  }
  
  function displayCart() {
    const cartItems = getCartFromSession();
    const cartItemsContainer = document.getElementById("cart-items");
    const totalElement = document.getElementById("cart-total");
  
    cartItemsContainer.innerHTML = "";
    totalElement.textContent = "Total : " + calculateTotal(cartItems) + "€";
  
    cartItems.forEach((item) => {
      const cartItem = document.createElement("li");
      cartItem.className = "flex py-6";
  
      const cartItemImage = document.createElement("div");
      cartItemImage.className =
        "h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200";
      const image = document.createElement("img");
      image.src = item.image;
      image.alt = item.name;
      image.className = "h-full w-full object-cover object-center";
      cartItemImage.appendChild(image);
  
      const cartItemDetails = document.createElement("div");
      cartItemDetails.className = "ml-4 flex flex-1 flex-col";
  
      const itemName = document.createElement("div");
      itemName.className = "flex justify-between text-base font-medium text-gray-900";
      const nameLink = document.createElement("a");
      nameLink.href = `/${item.genre}Page/${item.id}`;
      nameLink.textContent =
        item.name.length > 20 ? `${item.name.substring(0, 17)}...` : item.name;
      const itemPrice = document.createElement("p");
      itemPrice.className = "ml-4 text-base font-medium uppercase";
      itemPrice.textContent = `${item.price}€`;
  
      itemName.appendChild(nameLink);
      itemName.appendChild(itemPrice);
  
      const itemQuantity = document.createElement("p");
      itemQuantity.className = "mt-1 text-sm text-gray-500";
      itemQuantity.textContent = `Quantité ${item.quantity}`;
  
      const removeButton = document.createElement("button");
      removeButton.type = "button";
      removeButton.className = "font-medium text-indigo-600 hover:text-indigo-500";
      removeButton.textContent = "Remove";
      removeButton.addEventListener("click", () => {
        removeFromCart(item.itemId); // Utilisez l'identifiant unique pour supprimer l'article du panier
      });
  
      cartItemDetails.appendChild(itemName);
      cartItemDetails.appendChild(itemQuantity);
      cartItemDetails.appendChild(removeButton);
  
      cartItem.appendChild(cartItemImage);
      cartItem.appendChild(cartItemDetails);
  
      cartItemsContainer.appendChild(cartItem);
    });
  
    // Ajoutez le bouton "Vider le panier" en dehors de la boucle forEach
    const removeAllButton = document.createElement("button");
    removeAllButton.type = "button";
    removeAllButton.className = "font-medium text-red-600 hover:text-red-500";
    removeAllButton.textContent = "Vider le panier";
    removeAllButton.addEventListener("click", () => {
      clearCart();
    });
    cartItemsContainer.appendChild(removeAllButton);
  }
  
  document.addEventListener("DOMContentLoaded", () => {
    const addToCartButtons = document.querySelectorAll(".add-to-cart-btn");
  
    addToCartButtons.forEach((button) => {
      button.addEventListener("click", () => {
        const name = button.getAttribute("data-name");
        const price = parseFloat(button.getAttribute("data-price"));
        const image = button.getAttribute("data-image");
        const genre = button.getAttribute("data-genre"); // Ajoutez l'attribut "data-genre" à chaque bouton
        const id = button.getAttribute("data-id"); // Ajoutez l'attribut "data-id" à chaque bouton
  
        addToCart(name, price, image, genre, id); // Appel de la fonction d'ajout au panier avec les données de l'article
      });
    });
  });
  
  displayCart();
  