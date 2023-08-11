const numberElements = document.querySelectorAll(".number");

numberElements.forEach(element => {
    const originalNumber = parseFloat(element.textContent);
    const limitedNumber = Math.round(originalNumber * 100) / 100;
    element.textContent = limitedNumber.toFixed(2)+ "€";
});
