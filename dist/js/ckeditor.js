((Backdrop, once) => {
  Backdrop.behaviors.ginCKEditor = {
    attach: () => {
      Backdrop.ginCKEditor.init();
    }
  }, Backdrop.ginCKEditor = {
    init: () => {
      once("ginCKEditors", "body").forEach((() => {
        if (window.CKEDITOR && void 0 !== CKEDITOR) {
          if (Backdrop.settings.gin.current_path.indexOf("/admin/config/content/formats") > -1) return;
          const variablesCss = Backdrop.settings.gin.variables_css_path, accentCss = Backdrop.settings.gin.accent_css_path, contentsCss = Backdrop.settings.gin.ckeditor_css_path, accentColorPreset = Backdrop.settings.gin.preset_accent_color, accentColor = Backdrop.settings.gin.accent_color, darkmodeClass = Backdrop.settings.gin.darkmode_class;
          (1 == window.ginDarkmode || "auto" === window.ginDarkmode && window.matchMedia("(prefers-color-scheme: dark)").matches) && (CKEDITOR.config.bodyClass = darkmodeClass), 
          void 0 === CKEDITOR.config.contextmenu_contentsCss && (CKEDITOR.config.contextmenu_contentsCss = new Array, 
          void 0 === CKEDITOR.skinName && (CKEDITOR.skinName = CKEDITOR.skin.name), CKEDITOR.config.contextmenu_contentsCss.push(CKEDITOR.skin.getPath("editor"), variablesCss, accentCss, contentsCss)), 
          CKEDITOR.on("instanceReady", (element => {
            const editor = element.editor;
            editor.document.$.head.innerHTML += '<link rel="stylesheet" href=/' + variablesCss + ' type="text/css"/>', 
            editor.document.$.head.innerHTML += '<link rel="stylesheet" href=/' + accentCss + ' type="text/css"/>', 
            editor.document.$.head.innerHTML += '<link rel="stylesheet" href=/' + contentsCss + ' type="text/css"/>', 
            editor.document.$.body.setAttribute("data-gin-accent", accentColorPreset), "custom" === accentColorPreset && accentColor && Backdrop.ginAccent.setCustomAccentColor(accentColor, editor.document.$.head), 
            editor.on("mode", (function() {
              "wysiwyg" == this.mode && (editor.document.$.body.setAttribute("data-gin-accent", accentColorPreset), 
              "custom" === accentColorPreset && accentColor && Backdrop.ginAccent.setCustomAccentColor(accentColor, editor.document.$.head), 
              "auto" === window.ginDarkmode && (window.matchMedia("(prefers-color-scheme: dark)").matches ? editor.document.$.body.classList.add(darkmodeClass) : editor.document.$.body.classList.remove(darkmodeClass)), 
              editor.document.$.head.innerHTML += '<link rel="stylesheet" href=/' + variablesCss + ' type="text/css"/>', 
              editor.document.$.head.innerHTML += '<link rel="stylesheet" href=/' + accentCss + ' type="text/css"/>', 
              editor.document.$.head.innerHTML += '<link rel="stylesheet" href=/' + contentsCss + ' type="text/css"/>');
            })), editor.on("menuShow", (function(element) {
              const darkModeClass = 1 == window.ginDarkmode || "auto" === window.ginDarkmode && window.matchMedia("(prefers-color-scheme: dark)").matches ? darkmodeClass : "", iframeElement = element.data[0].element.$.childNodes[0].contentWindow.document;
              darkModeClass && iframeElement.body.classList.add(darkModeClass), iframeElement.body.setAttribute("data-gin-accent", accentColorPreset), 
              "custom" === accentColorPreset && accentColor && Backdrop.ginAccent.setCustomAccentColor(accentColor, iframeElement.head);
            })), window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", (e => {
              e.matches && "auto" === window.ginDarkmode && (editor.document.$.body.classList.add(darkmodeClass), 
              document.querySelectorAll(`.${editor.id}.cke_panel`).length > 0) && document.querySelector(`.${editor.id}.cke_panel`).childNodes[0].contentWindow.document.body.classList.add(darkmodeClass);
            })), window.matchMedia("(prefers-color-scheme: light)").addEventListener("change", (e => {
              e.matches && "auto" === window.ginDarkmode && (editor.document.$.body.classList.remove(darkmodeClass), 
              document.querySelectorAll(`.${editor.id}.cke_panel`).length > 0) && document.querySelector(`.${editor.id}.cke_panel`).childNodes[0].contentWindow.document.body.classList.remove(darkmodeClass);
            }));
          }));
        }
      }));
    }
  };
})(Backdrop, once);