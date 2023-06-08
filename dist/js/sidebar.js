((Drupal, once) => {
  const storageDesktop = "Drupal.tonic.sidebarExpanded.desktop";
  Drupal.behaviors.tonicSidebar = {
    attach: function(context) {
      Drupal.tonicSidebar.init(context);
    }
  }, Drupal.tonicSidebar = {
    init: function(context) {
      once("tonicSidebarInit", "#tonic_sidebar", context).forEach((() => {
        localStorage.getItem(storageDesktop) || localStorage.setItem(storageDesktop, "true"), 
        window.innerWidth >= 1024 && ("true" === localStorage.getItem(storageDesktop) ? this.showSidebar() : this.collapseSidebar()), 
        document.addEventListener("keydown", (e => {
          !0 === e.altKey && "KeyS" === e.code && this.toggleSidebar();
        })), window.onresize = Drupal.debounce(this.handleResize, 150);
      })), once("tonicSidebarToggle", ".meta-sidebar__trigger", context).forEach((el => el.addEventListener("click", (e => {
        e.preventDefault(), this.removeInlineStyles(), this.toggleSidebar();
      })))), once("tonicSidebarClose", ".meta-sidebar__close, .meta-sidebar__overlay", context).forEach((el => el.addEventListener("click", (e => {
        e.preventDefault(), this.removeInlineStyles(), this.collapseSidebar();
      }))));
    },
    toggleSidebar: () => {
      document.querySelector(".meta-sidebar__trigger").classList.contains("is-active") ? Drupal.tonicSidebar.collapseSidebar() : Drupal.tonicSidebar.showSidebar();
    },
    showSidebar: () => {
      const chooseStorage = window.innerWidth < 1024 ? "Drupal.tonic.sidebarExpanded.mobile" : storageDesktop, showLabel = Drupal.t("Hide sidebar panel"), sidebarTrigger = document.querySelector(".meta-sidebar__trigger");
      sidebarTrigger.setAttribute("title", showLabel), sidebarTrigger.querySelector("span").innerHTML = showLabel, 
      sidebarTrigger.setAttribute("aria-expanded", "true"), sidebarTrigger.classList.add("is-active"), 
      document.body.setAttribute("data-meta-sidebar", "open"), localStorage.setItem(chooseStorage, "true");
    },
    collapseSidebar: () => {
      const chooseStorage = window.innerWidth < 1024 ? "Drupal.tonic.sidebarExpanded.mobile" : storageDesktop, hideLabel = Drupal.t("Show sidebar panel"), sidebarTrigger = document.querySelector(".meta-sidebar__trigger");
      sidebarTrigger.setAttribute("title", hideLabel), sidebarTrigger.querySelector("span").innerHTML = hideLabel, 
      sidebarTrigger.setAttribute("aria-expanded", "false"), sidebarTrigger.classList.remove("is-active"), 
      document.body.setAttribute("data-meta-sidebar", "closed"), localStorage.setItem(chooseStorage, "false");
    },
    handleResize: () => {
      Drupal.tonicSidebar.removeInlineStyles(), window.innerWidth < 1024 ? Drupal.tonicSidebar.collapseSidebar() : "true" === localStorage.getItem(storageDesktop) ? Drupal.tonicSidebar.showSidebar() : Drupal.tonicSidebar.collapseSidebar();
    },
    removeInlineStyles: () => {
      const elementToRemove = document.querySelector(".tonic-sidebar-inline-styles");
      elementToRemove && elementToRemove.parentNode.removeChild(elementToRemove);
    }
  };
})(Drupal, once);