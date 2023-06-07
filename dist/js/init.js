(() => {
  function tonicInitDarkmode() {
    1 == localStorage.getItem("Drupal.tonic.darkmode") || "auto" === localStorage.getItem("Drupal.tonic.darkmode") && window.matchMedia("(prefers-color-scheme: dark)").matches ? document.documentElement.classList.add("tonic--dark-mode") : !0 === document.documentElement.classList.contains("tonic--dark-mode") && document.documentElement.classList.remove("tonic--dark-mode");
  }
  if (localStorage.getItem("TonicDarkMode") && (localStorage.setItem("Drupal.tonic.darkmode", localStorage.getItem("TonicDarkMode")),
  localStorage.removeItem("TonicDarkMode")), localStorage.getItem("TonicSidebarOpen") && (localStorage.setItem("Drupal.tonic.toolbarExpanded", localStorage.getItem("TonicSidebarOpen")),
  localStorage.removeItem("TonicSidebarOpen")), tonicInitDarkmode(), window.addEventListener("DOMContentLoaded", (() => {
    localStorage.getItem("Drupal.tonic.darkmode") || (localStorage.setItem("Drupal.tonic.darkmode", drupalSettings.tonic.darkmode),
    tonicInitDarkmode());
  })), localStorage.getItem("Drupal.tonic.toolbarExpanded")) {
    const style = document.createElement("style"), className = "tonic-toolbar-inline-styles";
    if (style.className = className, "true" === localStorage.getItem("Drupal.tonic.toolbarExpanded")) {
      style.innerHTML = "\n    @media (min-width: 976px) {\n      body.tonic--vertical-toolbar:not([data-toolbar-menu=open]) {\n        padding-inline-start: 256px;\n        transition: none;\n      }\n\n      .tonic--vertical-toolbar .toolbar-menu-administration {\n        min-width: var(--tonic-toolbar-width, 256px);\n        transition: none;\n      }\n\n      .tonic--vertical-toolbar .toolbar-menu-administration > .toolbar-menu > .menu-item > .toolbar-icon,\n      .tonic--vertical-toolbar .toolbar-menu-administration > .toolbar-menu > .menu-item > .toolbar-box > .toolbar-icon {\n        min-width: calc(var(--tonic-toolbar-width, 256px) - 16px);\n      }\n    }\n    ";
      const scriptTag = document.querySelector("script");
      scriptTag.parentNode.insertBefore(style, scriptTag);
    } else document.getElementsByClassName(className).length > 0 && document.getElementsByClassName(className)[0].remove();
  }
  if (localStorage.getItem("Drupal.tonic.sidebarExpanded.desktop")) {
    const style = document.createElement("style"), className = "tonic-sidebar-inline-styles";
    if (style.className = className, window.innerWidth < 1024 || "false" === localStorage.getItem("Drupal.tonic.sidebarExpanded.desktop")) {
      style.innerHTML = "\n    body {\n      --tonic-sidebar-offset: 0px;\n      padding-inline-end: 0;\n      transition: none;\n    }\n\n    .layout-region-node-secondary {\n      transform: translateX(var(--tonic-sidebar-width, 360px));\n      transition: none;\n    }\n\n    .meta-sidebar__overlay {\n      display: none;\n    }\n    ";
      const scriptTag = document.querySelector("script");
      scriptTag.parentNode.insertBefore(style, scriptTag);
    } else document.getElementsByClassName(className).length > 0 && document.getElementsByClassName(className)[0].remove();
  }
})();
