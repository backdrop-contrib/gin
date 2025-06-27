/* eslint-disable func-names, no-mutable-exports, comma-dangle, strict */

((Backdrop, once) => {
  Backdrop.behaviors.ginCKEditor = {
    attach: () => {
      Backdrop.ginCKEditor.init();
    }
  };

  Backdrop.ginCKEditor = {
    init: () => {
      once('ginCKEditors', 'body').forEach(() => {
        if (window.CKEDITOR && CKEDITOR !== undefined) {
          // If on CKEditor config, do nothing.
          if (Backdrop.settings.gin.current_path.indexOf('/admin/config/content/formats') > -1) {
            return;
          }

          // Get configs.
          const variablesCss = Backdrop.settings.gin.variables_css_path;
          const accentCss = Backdrop.settings.gin.accent_css_path;
          const contentsCss = Backdrop.settings.gin.ckeditor_css_path;
          const accentColorPreset = Backdrop.settings.gin.preset_accent_color;
          const accentColor = Backdrop.settings.gin.accent_color;
          const darkmodeClass = Backdrop.settings.gin.darkmode_class;

          // Class for Darkmode.
          if (
            window.ginDarkmode == 1 ||
            window.ginDarkmode === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches
          ) {
            CKEDITOR.config.bodyClass = darkmodeClass;
          }

          // Contextmenu stylesheets.
          if (CKEDITOR.config.contextmenu_contentsCss === undefined) {
            CKEDITOR.config.contextmenu_contentsCss = new Array();

            // Check if skinName is set.
            if (typeof CKEDITOR.skinName === 'undefined') {
              CKEDITOR.skinName = CKEDITOR.skin.name;
            }

            CKEDITOR.config.contextmenu_contentsCss.push(
              CKEDITOR.skin.getPath('editor'),
              variablesCss,
              accentCss,
              contentsCss
            );
          }

          CKEDITOR.on('instanceReady', (element) => {
            const editor = element.editor;

            // Adding CSS to head.
            editor.document.$.head.innerHTML += '<link rel="stylesheet" href=/' + variablesCss + ' type="text/css"/>';
            editor.document.$.head.innerHTML += '<link rel="stylesheet" href=/' + accentCss + ' type="text/css"/>';
            editor.document.$.head.innerHTML += '<link rel="stylesheet" href=/' + contentsCss + ' type="text/css"/>';

            // Initial accent color.
            editor.document.$.body.setAttribute('data-gin-accent', accentColorPreset);

            if (accentColorPreset === 'custom' && accentColor) {
              Backdrop.ginAccent.setCustomAccentColor(accentColor, editor.document.$.head);
            }

            // Change from Code to Editor.
            editor.on('mode', function() {
              if (this.mode == 'wysiwyg') {
                editor.document.$.body.setAttribute('data-gin-accent', accentColorPreset);

                if (accentColorPreset === 'custom' && accentColor) {
                  Backdrop.ginAccent.setCustomAccentColor(accentColor, editor.document.$.head);
                }

                if (window.ginDarkmode === 'auto') {
                  if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    editor.document.$.body.classList.add(darkmodeClass);
                  } else {
                    editor.document.$.body.classList.remove(darkmodeClass);
                  }
                }

                // Re-add CSS to head.
                editor.document.$.head.innerHTML += '<link rel="stylesheet" href=/' + variablesCss + ' type="text/css"/>';
                editor.document.$.head.innerHTML += '<link rel="stylesheet" href=/' + accentCss + ' type="text/css"/>';
                editor.document.$.head.innerHTML += '<link rel="stylesheet" href=/' + contentsCss + ' type="text/css"/>';
              }
            });

            // Contextual menu.
            editor.on('menuShow', function(element) {
              const darkModeClass = window.ginDarkmode == 1 || window.ginDarkmode === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches
                ? darkmodeClass
                : '';
              const iframeElement = element.data[0].element.$.childNodes[0].contentWindow.document;

              if (darkModeClass) {
                iframeElement.body.classList.add(darkModeClass);
              }

              iframeElement.body.setAttribute('data-gin-accent', accentColorPreset);

              if (accentColorPreset === 'custom' && accentColor) {
                Backdrop.ginAccent.setCustomAccentColor(accentColor, iframeElement.head);
              }
            });

            // Toggle Darkmode.
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
              if (e.matches && window.ginDarkmode === 'auto') {
                editor.document.$.body.classList.add(darkmodeClass);

                if (document.querySelectorAll(`.${editor.id}.cke_panel`).length > 0) {
                  const iframeElement = document.querySelector(`.${editor.id}.cke_panel`).childNodes[0].contentWindow.document;
                  iframeElement.body.classList.add(darkmodeClass);
                }
              }
            });

            // Change to Lightmode.
            window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', e => {
              if (e.matches && window.ginDarkmode === 'auto') {
                editor.document.$.body.classList.remove(darkmodeClass);

                if (document.querySelectorAll(`.${editor.id}.cke_panel`).length > 0) {
                  const iframeElement = document.querySelector(`.${editor.id}.cke_panel`).childNodes[0].contentWindow.document;
                  iframeElement.body.classList.remove(darkmodeClass);
                }
              }
            });
          });
        }
      });
    },

  };
})(Backdrop, once);
