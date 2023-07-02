(() => {
  function ginInitDarkmode() {
    1 == localStorage.getItem("Backdrop.gin.darkmode") || "auto" === localStorage.getItem("Backdrop.gin.darkmode") && window.matchMedia("(prefers-color-scheme: dark)").matches ? document.documentElement.classList.add("gin--dark-mode") : !0 === document.documentElement.classList.contains("gin--dark-mode") && document.documentElement.classList.remove("gin--dark-mode");
  }
  ginInitDarkmode(), window.addEventListener("DOMContentLoaded", (() => {
    localStorage.getItem("Backdrop.gin.darkmode") || (localStorage.setItem("Backdrop.gin.darkmode", Backdrop.settings.gin.darkmode), 
    ginInitDarkmode());
  }));
})();