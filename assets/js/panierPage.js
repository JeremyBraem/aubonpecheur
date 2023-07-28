const cartItemsJSON = sessionStorage.getItem("cart");
const cartItems = cartItemsJSON ? JSON.parse(cartItemsJSON) : [];

function generateCartItemElement(item) {
  const cartItem = document.createElement("div");
  cartItem.className =
    "justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start";

  const cartImage = document.createElement("img");
  cartImage.src = item.image;
  cartImage.alt = item.name;
  cartImage.className = "w-full rounded-lg sm:w-40";
  cartItem.appendChild(cartImage);

  const cartItemInfo = document.createElement("div");
  cartItemInfo.className = "sm:ml-4 sm:flex sm:w-full sm:justify-between";

  const itemInfo = document.createElement("div");
  itemInfo.className = "mt-5 sm:mt-0";

  const itemName = document.createElement("h2");
  itemName.className = "text-lg font-bold text-gray-900";
  itemName.textContent = item.name;
  itemInfo.appendChild(itemName);

  const itemDetails = document.createElement("p");
  itemDetails.className = "mt-1 text-xs text-gray-700";
  itemDetails.textContent = item.genre;
  itemInfo.appendChild(itemDetails);

  cartItemInfo.appendChild(itemInfo);

  const quantityContainer = document.createElement("div");
  quantityContainer.className =
    "mt-4 flex justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6";

  const quantityDiv = document.createElement("div");
  quantityDiv.className = "flex items-center border-gray-100";

  const decreaseButton = document.createElement("span");
  decreaseButton.setAttribute("id", "decreaseButton");
  decreaseButton.className =
    "cursor-pointer rounded-l bg-gray-100 py-1 px-3.5 duration-100 hover:bg-blue-500 hover:text-blue-50";
  decreaseButton.textContent = "-";
  quantityDiv.appendChild(decreaseButton);

  const quantityInput = document.createElement("p");
  quantityInput.setAttribute("id", "quantityInput");
  quantityInput.className = "p-3 border text-center text-sm outline-none";
  quantityInput.textContent = item.quantity;
  quantityInput.min = "1";
  quantityDiv.appendChild(quantityInput);

  const increaseButton = document.createElement("span");
  increaseButton.setAttribute("id", "increaseButton");
  increaseButton.className =
    "cursor-pointer rounded-r bg-gray-100 py-1 px-3 duration-100 hover:bg-blue-500 hover:text-blue-50";
  increaseButton.textContent = "+";
  quantityDiv.appendChild(increaseButton);

  quantityContainer.appendChild(quantityDiv);

  const priceDiv = document.createElement("div");
  priceDiv.className = "flex items-center space-x-4";

  const price = document.createElement("p");
  price.textContent = `${item.price} €`;
  price.className = "text-sm font-semibold";
  priceDiv.appendChild(price);

  const removeIcon = document.createElement("div");
  removeIcon.setAttribute("id", "deleteButton");
  removeIcon.innerHTML = `<img class="h-4 w-4 cursor-pointer" src="assets/img/site/icons8-close.svg">`;
  priceDiv.appendChild(removeIcon);

  quantityContainer.appendChild(priceDiv);

  cartItemInfo.appendChild(quantityContainer);
  cartItem.appendChild(cartItemInfo);

  return cartItem;
}

function updateCartUI() {
  const cartItemsContainer = document.getElementById("cartItemsContainer");
  cartItemsContainer.innerHTML = "";

  cartItems.forEach((item) => {
    const cartItemElement = generateCartItemElement(item);
    cartItemsContainer.appendChild(cartItemElement);

    const quantityInput = cartItemElement.querySelector("#quantityInput");
    quantityInput.addEventListener("change", (event) => {
      const newQuantity = parseInt(event.target.value);
      if (!isNaN(newQuantity) && newQuantity >= 1) {
        item.quantity = newQuantity;
        updateCartUI();
        sessionStorage.setItem("cart", JSON.stringify(cartItems));
      }
    });

    const decreaseButton = cartItemElement.querySelector("#decreaseButton");
    decreaseButton.addEventListener("click", () => {
      if (item.quantity > 1) {
        item.quantity--;
        updateCartUI();
        sessionStorage.setItem("cart", JSON.stringify(cartItems));
      }
    });

    const increaseButton = cartItemElement.querySelector("#increaseButton");
    increaseButton.addEventListener("click", () => {
      item.quantity++;
      updateCartUI();
      sessionStorage.setItem("cart", JSON.stringify(cartItems));
    });

    const removeIcon = cartItemElement.querySelector("#deleteButton");
    removeIcon.addEventListener("click", () => {
      const index = cartItems.indexOf(item);
      if (index !== -1) {
        cartItems.splice(index, 1);
        updateCartUI();
        sessionStorage.setItem("cart", JSON.stringify(cartItems));
      }
    });
  });

  const totalElement = document.getElementById("total");
  let total = 0;
  cartItems.forEach((item) => {
    total += item.price * item.quantity;
  });
  totalElement.textContent = `${total.toFixed(2)} €`;
}

document.addEventListener("DOMContentLoaded", () => {
  updateCartUI();
});
