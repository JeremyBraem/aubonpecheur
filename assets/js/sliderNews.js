document.addEventListener("DOMContentLoaded", function () {
  let nextNews = document.getElementById("nextNews");
  let prevNews = document.getElementById("prevNews");

  let defaultTransform = 0;
  function goNextNews() {
    defaultTransform = defaultTransform - 263;
    let sliderNews = document.getElementById("sliderNews");
    if (Math.abs(defaultTransform) >= sliderNews.scrollWidth / 1)
      defaultTransform = 0;
    sliderNews.style.transform = "translateX(" + defaultTransform + "px)";
  }
  nextNews.addEventListener("click", goNextNews);
  function goPrevNews() {
    let sliderNews = document.getElementById("sliderNews");
    if (Math.abs(defaultTransform) === 0) defaultTransform = 0;
    else defaultTransform = defaultTransform + 263;
    sliderNews.style.transform = "translateX(" + defaultTransform + "px)";
  }
  prevNews.addEventListener("click", goPrevNews);
});
