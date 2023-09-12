!function($) {
  const storageDesktop = "Backdrop.gin.sidebarExpanded.desktop";
  Backdrop.behaviors.ginSidebar = {
    attach: function(context, settings) {
      Backdrop.ginSidebar.init(context);
    }
  }, Backdrop.ginSidebar = {
    init: function(context) {
      $("#gin_sidebar").once("ginSidebarInit", context).each((() => {
        localStorage.getItem(storageDesktop) || localStorage.setItem(storageDesktop, "true"), 
        window.innerWidth >= 1024 && ("true" === localStorage.getItem(storageDesktop) ? this.showSidebar() : this.collapseSidebar()), 
        document.addEventListener("keydown", (e => {
          !0 === e.altKey && "KeyS" === e.code && this.toggleSidebar();
        })), window.onresize = Backdrop.debounce(this.handleResize, 150)();
      })), $(".meta-sidebar__trigger").once("ginSidebarToggle", context).on("click", (e => {
        e.preventDefault(), this.removeInlineStyles(), this.toggleSidebar();
      })), $(".meta-sidebar__close, .meta-sidebar__overlay").once("ginSidebarClose", context).on("click", (e => {
        e.preventDefault(), this.removeInlineStyles(), this.collapseSidebar();
      }));
    },
    toggleSidebar: () => {
      $(".meta-sidebar__trigger").hasClass("is-active") ? Backdrop.ginSidebar.collapseSidebar() : Backdrop.ginSidebar.showSidebar();
    },
    showSidebar: () => {
      const chooseStorage = window.innerWidth < 1024 ? "Backdrop.gin.sidebarExpanded.mobile" : storageDesktop, showLabel = Backdrop.t("Hide sidebar panel"), sidebarTrigger = $(".meta-sidebar__trigger");
      sidebarTrigger.attr("title", showLabel), $("span", sidebarTrigger).innerHTML = showLabel, 
      sidebarTrigger.attr("aria-expanded", "true"), sidebarTrigger.addClass("is-active"), 
      $("body").attr("data-meta-sidebar", "open"), localStorage.setItem(chooseStorage, "true");
    },
    collapseSidebar: () => {
      const chooseStorage = window.innerWidth < 1024 ? "Backdrop.gin.sidebarExpanded.mobile" : storageDesktop, hideLabel = Backdrop.t("Show sidebar panel"), sidebarTrigger = $(".meta-sidebar__trigger");
      sidebarTrigger.attr("title", hideLabel), $("span", sidebarTrigger).innerHTML = hideLabel, 
      sidebarTrigger.attr("aria-expanded", "false"), sidebarTrigger.removeClass("is-active"), 
      $("body").attr("data-meta-sidebar", "closed"), localStorage.setItem(chooseStorage, "false");
    },
    handleResize: () => {
      Backdrop.ginSidebar.removeInlineStyles(), window.innerWidth < 1024 ? Backdrop.ginSidebar.collapseSidebar() : "true" === localStorage.getItem(storageDesktop) ? Backdrop.ginSidebar.showSidebar() : Backdrop.ginSidebar.collapseSidebar();
    },
    removeInlineStyles: () => {
      const elementToRemove = $(".gin-sidebar-inline-styles");
      elementToRemove && elementToRemove.remove();
    }
  };
}(jQuery);