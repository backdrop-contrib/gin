((Drupal, drupalSettings, once) => {
  Drupal.behaviors.tonicToolbar = {
    attach: context => {
      Drupal.tonicToolbar.init(context);
    }
  }, Drupal.tonicToolbar = {
    init: function(context) {
      once("tonicToolbarInit", "#gin-toolbar-bar", context).forEach((() => {
        const toolbarTrigger = document.querySelector(".toolbar-menu__trigger");
        "classic" != drupalSettings.tonic.toolbar_variant && localStorage.getItem("Drupal.toolbar.trayVerticalLocked") && localStorage.removeItem("Drupal.toolbar.trayVerticalLocked"), 
        "true" === localStorage.getItem("Drupal.tonic.toolbarExpanded") ? (document.body.setAttribute("data-toolbar-menu", "open"), 
        toolbarTrigger.classList.add("is-active")) : (document.body.setAttribute("data-toolbar-menu", ""), 
        toolbarTrigger.classList.remove("is-active")), document.addEventListener("keydown", (e => {
          !0 === e.altKey && "KeyT" === e.code && this.toggleToolbar();
        }));
      })), once("tonicToolbarToggle", ".toolbar-menu__trigger", context).forEach((el => el.addEventListener("click", (e => {
        e.preventDefault(), this.toggleToolbar();
      }))));
    },
    toggleToolbar: () => {
      const toolbarTrigger = document.querySelector(".toolbar-menu__trigger");
      toolbarTrigger.classList.toggle("is-active");
      let active = "true";
      if (toolbarTrigger.classList.contains("is-active")) document.body.setAttribute("data-toolbar-menu", "open"); else {
        document.body.setAttribute("data-toolbar-menu", ""), active = "false";
        const elementToRemove = document.querySelector(".tonic-toolbar-inline-styles");
        elementToRemove && elementToRemove.parentNode.removeChild(elementToRemove);
      }
      localStorage.setItem("Drupal.tonic.toolbarExpanded", active);
      const event = new CustomEvent("toolbar-toggle", {
        detail: "true" === active
      });
      document.dispatchEvent(event);
    }
  };
})(Drupal, drupalSettings, once);