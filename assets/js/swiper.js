let defaultTransform = 0;
function goNext() {
    defaultTransform = defaultTransform - 263;
    let slider = document.getElementById("slider");
    if (Math.abs(defaultTransform) >= slider.scrollWidth / 1) defaultTransform = 0;
    slider.style.transform = "translateX(" + defaultTransform + "px)";
}
next.addEventListener("click", goNext);
function goPrev() {
    var slider = document.getElementById("slider");
    if (Math.abs(defaultTransform) === 0) defaultTransform = 0;
    else defaultTransform = defaultTransform + 263;
    slider.style.transform = "translateX(" + defaultTransform + "px)";
}
prev.addEventListener("click", goPrev);