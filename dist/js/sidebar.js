((Backdrop, once) => {
  const storageDesktop = "Backdrop.gin.sidebarExpanded.desktop";
  Backdrop.behaviors.ginSidebar = {
    attach: function(context) {
      Backdrop.ginSidebar.init(context);
    }
  }, Backdrop.ginSidebar = {
    init: function(context) {
      once("ginSidebarInit", "#gin_sidebar", context).forEach((() => {
        localStorage.getItem(storageDesktop) || localStorage.setItem(storageDesktop, "true"), 
        window.innerWidth >= 1024 && ("true" === localStorage.getItem(storageDesktop) ? this.showSidebar() : this.collapseSidebar()), 
        document.addEventListener("keydown", (e => {
          !0 === e.altKey && "KeyS" === e.code && this.toggleSidebar();
        })), window.onresize = Backdrop.debounce(this.handleResize, 150);
      })), once("ginSidebarToggle", ".meta-sidebar__trigger", context).forEach((el => el.addEventListener("click", (e => {
        e.preventDefault(), this.removeInlineStyles(), this.toggleSidebar();
      })))), once("ginSidebarClose", ".meta-sidebar__close, .meta-sidebar__overlay", context).forEach((el => el.addEventListener("click", (e => {
        e.preventDefault(), this.removeInlineStyles(), this.collapseSidebar();
      }))));
    },
    toggleSidebar: () => {
      document.querySelector(".meta-sidebar__trigger").classList.contains("is-active") ? Backdrop.ginSidebar.collapseSidebar() : Backdrop.ginSidebar.showSidebar();
    },
    showSidebar: () => {
      const chooseStorage = window.innerWidth < 1024 ? "Backdrop.gin.sidebarExpanded.mobile" : storageDesktop, showLabel = Backdrop.t("Hide sidebar panel"), sidebarTrigger = document.querySelector(".meta-sidebar__trigger");
      sidebarTrigger.setAttribute("title", showLabel), sidebarTrigger.querySelector("span").innerHTML = showLabel, 
      sidebarTrigger.setAttribute("aria-expanded", "true"), sidebarTrigger.classList.add("is-active"), 
      document.body.setAttribute("data-meta-sidebar", "open"), localStorage.setItem(chooseStorage, "true");
    },
    collapseSidebar: () => {
      const chooseStorage = window.innerWidth < 1024 ? "Backdrop.gin.sidebarExpanded.mobile" : storageDesktop, hideLabel = Backdrop.t("Show sidebar panel"), sidebarTrigger = document.querySelector(".meta-sidebar__trigger");
      sidebarTrigger.setAttribute("title", hideLabel), sidebarTrigger.querySelector("span").innerHTML = hideLabel, 
      sidebarTrigger.setAttribute("aria-expanded", "false"), sidebarTrigger.classList.remove("is-active"), 
      document.body.setAttribute("data-meta-sidebar", "closed"), localStorage.setItem(chooseStorage, "false");
    },
    handleResize: () => {
      Backdrop.ginSidebar.removeInlineStyles(), window.innerWidth < 1024 ? Backdrop.ginSidebar.collapseSidebar() : "true" === localStorage.getItem(storageDesktop) ? Backdrop.ginSidebar.showSidebar() : Backdrop.ginSidebar.collapseSidebar();
    },
    removeInlineStyles: () => {
      const elementToRemove = document.querySelector(".gin-sidebar-inline-styles");
      elementToRemove && elementToRemove.parentNode.removeChild(elementToRemove);
    }
  };
})(Backdrop, once);