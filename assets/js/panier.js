// dropdown.js
document.addEventListener("DOMContentLoaded", function () {
    const dropdownBtn = document.querySelector(".relative > button");
    const dropdown = document.querySelector(".relative > .hidden");
  
    dropdownBtn.addEventListener("click", function () {
      dropdown.classList.toggle("hidden");
    });
  
    // Hide the dropdown if the user clicks outside of it
    document.addEventListener("click", function (event) {
      if (!dropdownBtn.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.add("hidden");
      }
    });
  });  