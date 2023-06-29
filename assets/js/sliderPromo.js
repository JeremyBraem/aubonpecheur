document.addEventListener("DOMContentLoaded", function() 
{
let nextPromo = document.getElementById("nextPromo");
let prevPromo = document.getElementById("prevPromo");

let defaultTransform = 0;
function goNextPromo() 
{
    defaultTransform = defaultTransform - 263;
    let sliderPromo = document.getElementById("sliderPromo");
    if (Math.abs(defaultTransform) >= sliderPromo.scrollWidth / 1) defaultTransform = 0;
    sliderPromo.style.transform = "translateX(" + defaultTransform + "px)";
}
nextPromo.addEventListener("click", goNextPromo);
function goPrevPromo() 
{
    let sliderPromo = document.getElementById("sliderPromo");
    if (Math.abs(defaultTransform) === 0) defaultTransform = 0;
    else defaultTransform = defaultTransform + 263;
    sliderPromo.style.transform = "translateX(" + defaultTransform + "px)";
}
prevPromo.addEventListener("click", goPrevPromo);
});
  
