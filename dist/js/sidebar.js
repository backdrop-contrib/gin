!function($) {
  const storageDesktop = "Backdrop.gin.sidebarExpanded.desktop";
  var resizer = document.getElementById("gin-sidebar-draggable"), resizable = document.getElementById("gin_sidebar");
  let startX, startWidth, isResizing = !1;
  Backdrop.behaviors.ginSidebar = {
    attach: function(context, settings) {
      Backdrop.ginSidebar.init(context, settings);
    }
  }, Backdrop.ginSidebar = {
    init: function(context, settings) {
      const hideLabel = Backdrop.t("Hide sidebar panel"), sidebarFormId = settings.Gin.sidebar_form_id, actionsFormId = settings.Gin.actions_form_id, sidebarToggler = '<a href="#toggle-sidebar" class="meta-sidebar__trigger trigger" role="button" title="' + hideLabel + '" aria-controls="gin_sidebar"><span class="visually-hidden">' + hideLabel + "</span></a>";
      $("#backdrop-modal form").once("ginEditModalForm").addClass("gin-edit-modal-form"), 
      $("#ckeditor5-modal form").once("ginEditModalForm").addClass("gin-edit-modal-form"), 
      $("#" + sidebarFormId + ":not(.gin-edit-modal-form)").once("gin-sidebar").each((function() {
        $("> div:first-child", this).addClass("layout-region-node-main"), actionsFormId ? $(".region-sticky .form-actions").prepend(sidebarToggler) : $(".form-actions", this).append(sidebarToggler), 
        $(this).append('<div id="gin_sidebar" class="layout-region-node-secondary"><span class="gin-sidebar-draggable" id="gin-sidebar-draggable"></span></div>'), 
        $(".layout-region-node-secondary", this).append($(".content-edit-settings"));
      })), resizer = document.getElementById("gin-sidebar-draggable"), resizable = document.getElementById("gin_sidebar"), 
      $("#gin_sidebar").once("ginSidebarInit", context).each((() => {
        localStorage.getItem(storageDesktop) || localStorage.setItem(storageDesktop, "true"), 
        window.innerWidth >= 1024 && ("true" === localStorage.getItem(storageDesktop) ? this.showSidebar() : this.collapseSidebar()), 
        document.addEventListener("keydown", (e => {
          !0 === e.altKey && "KeyS" === e.code && this.toggleSidebar();
        })), new ResizeObserver((entries => {
          for (let entry of entries) Backdrop.debounce(this.handleResize(entry.contentRect), 150);
        })).observe(document.querySelector("html")), this.resizeInit();
      })), $(".meta-sidebar__trigger").once("ginSidebarToggle", context).on("click", (e => {
        e.preventDefault(), this.removeInlineStyles(), this.toggleSidebar();
      })), $(".meta-sidebar__close, .meta-sidebar__overlay").once("ginSidebarClose", context).on("click", (e => {
        e.preventDefault(), this.removeInlineStyles(), this.collapseSidebar();
      }));
    },
    toggleSidebar: () => {
      $(".meta-sidebar__trigger").hasClass("is-active") ? (Backdrop.ginSidebar.collapseSidebar(), 
      Backdrop.ginStickyFormActions?.hideMoreActions()) : (Backdrop.ginSidebar.showSidebar(), 
      Backdrop.ginStickyFormActions?.hideMoreActions());
    },
    showSidebar: () => {
      const chooseStorage = window.innerWidth < 1024 ? "Backdrop.gin.sidebarExpanded.mobile" : storageDesktop, hideLabel = Backdrop.t("Hide sidebar panel"), sidebarTrigger = document.querySelector(".meta-sidebar__trigger");
      sidebarTrigger && (sidebarTrigger.querySelector("span").innerHTML = hideLabel, sidebarTrigger.setAttribute("title", hideLabel), 
      sidebarTrigger.nextSibling && (sidebarTrigger.nextSibling.innerHTML = hideLabel), 
      sidebarTrigger.setAttribute("aria-expanded", "true"), sidebarTrigger.classList.add("is-active"), 
      $("body").attr("data-meta-sidebar", "open"), localStorage.setItem(chooseStorage, "true"));
    },
    collapseSidebar: () => {
      const chooseStorage = window.innerWidth < 1024 ? "Backdrop.gin.sidebarExpanded.mobile" : storageDesktop, showLabel = Backdrop.t("Show sidebar panel"), sidebarTrigger = document.querySelector(".meta-sidebar__trigger");
      sidebarTrigger.querySelector("span").innerHTML = showLabel, sidebarTrigger.setAttribute("title", showLabel), 
      sidebarTrigger.nextSibling && (sidebarTrigger.nextSibling.innerHTML = showLabel), 
      sidebarTrigger.setAttribute("aria-expanded", "false"), sidebarTrigger.classList.remove("is-active"), 
      $("body").attr("data-meta-sidebar", "closed"), localStorage.setItem(chooseStorage, "false");
    },
    handleResize: function() {
      let windowSize = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : window;
      Backdrop.ginSidebar.removeInlineStyles(), windowSize.width < 1024 ? Backdrop.ginSidebar.collapseSidebar() : "true" === localStorage.getItem(storageDesktop) ? Backdrop.ginSidebar.showSidebar() : Backdrop.ginSidebar.collapseSidebar();
    },
    removeInlineStyles: () => {
      const elementToRemove = $(".gin-sidebar-inline-styles");
      elementToRemove && elementToRemove.remove();
    },
    resizeInit: function() {
      resizer.addEventListener("mousedown", this.resizeStart), document.addEventListener("mousemove", this.resizeWidth), 
      document.addEventListener("mouseup", this.resizeEnd), resizer.addEventListener("touchstart", this.resizeStart), 
      document.addEventListener("touchmove", this.resizeWidth), document.addEventListener("touchend", this.resizeEnd);
    },
    resizeStart: e => {
      e.preventDefault(), isResizing = !0, startX = e.clientX, startWidth = parseInt(document.defaultView.getComputedStyle(resizable).width, 10);
    },
    resizeEnd: () => {
      isResizing = !1;
      const setWidth = document.documentElement.style.getPropertyValue("--gin-sidebar-width"), currentWidth = setWidth || resizable.style.width;
      localStorage.setItem("Backdrop.gin.sidebarWidth", currentWidth), document.removeEventListener("mousemove", this.resizeWidth), 
      document.removeEventListener("touchend", this.resizeWidth);
    },
    resizeWidth: e => {
      if (isResizing) {
        let sidebarWidth = startWidth - (e.clientX - startX);
        sidebarWidth <= 240 ? sidebarWidth = 240 : sidebarWidth >= 560 && (sidebarWidth = 560), 
        sidebarWidth = `${sidebarWidth}px`, document.documentElement.style.setProperty("--gin-sidebar-width", sidebarWidth);
      }
    }
  };
}(jQuery);