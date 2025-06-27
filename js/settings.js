/* eslint-disable func-names, no-mutable-exports, comma-dangle, strict */

((Backdrop) => {
  Backdrop.behaviors.ginSettings = {
    attach: function attach(context) {
      Backdrop.ginSettings.init(context);
    },
  };

  Backdrop.ginSettings = {
    init: function (context) {
      // Watch Darkmode setting has changed.
      context.querySelectorAll('input[name="enable_darkmode"]')
        .forEach(el => el.addEventListener('change', e => {
          const darkmode = e.currentTarget.value;
          const accentColorPreset = document.querySelector('#edit-preset-accent-color input:checked').value;
          const focusColorPreset = document.querySelector('select[name="preset_focus_color"]').value;

          // Toggle Darkmode.
          this.darkmode(darkmode);

          // Set custom color if 'custom' is set.
          if (accentColorPreset === 'custom') {
            const accentColorSetting = document.querySelector('input[name="accent_color"]').value;

            Backdrop.ginAccent.setCustomAccentColor(accentColorSetting);
          } else {
            Backdrop.ginAccent.setAccentColor(accentColorPreset);
          }

          // Toggle Focus color.
          if (focusColorPreset === 'custom') {
            const focusColorSetting = document.querySelector('input[name="focus_color"]').value;

            Backdrop.ginAccent.setCustomFocusColor(focusColorSetting);
          } else {
            Backdrop.ginAccent.setFocusColor(focusColorPreset);
          }
        }));

      // Watch Accent color setting has changed.
      context.querySelectorAll('#edit-preset-accent-color input')
        .forEach(el => el.addEventListener('change', e => {
          const accentColorPreset = e.currentTarget.value;

          // Update.
          Backdrop.ginAccent.clearAccentColor();
          Backdrop.ginAccent.setAccentColor(accentColorPreset);

          // Set custom color if 'custom' is set.
          if (accentColorPreset === 'custom') {
            const accentColorSetting = document.querySelector('input[name="accent_color"]').value;

            Backdrop.ginAccent.setCustomAccentColor(accentColorSetting);
          }
        }));

      // Watch Accent color picker has changed.
      context.querySelectorAll('input[name="accent_picker"]')
        .forEach(el => el.addEventListener('change', e => {
          const accentColorSetting = e.currentTarget.value;

          // Sync fields.
          document.querySelector('input[name="accent_color"]').value = accentColorSetting;

          // Update.
          Backdrop.ginAccent.setCustomAccentColor(accentColorSetting);
        }));

      // Watch Accent color setting has changed.
      context.querySelectorAll('input[name="accent_color"]')
        .forEach(el => el.addEventListener('change', e => {
          const accentColorSetting = e.currentTarget.value;

          // Sync fields.
          document.querySelector('input[name="accent_picker"]').value = accentColorSetting;

          // Update.
          Backdrop.ginAccent.setCustomAccentColor(accentColorSetting);
        }));

      // Watch Focus color setting has changed.
      document.querySelector('select[name="preset_focus_color"]').addEventListener('change', e => {
        const focusColorPreset = e.currentTarget.value;

        // Update.
        Backdrop.ginAccent.clearFocusColor();
        Backdrop.ginAccent.setFocusColor(focusColorPreset);

        // Set custom color if 'custom' is set.
        if (focusColorPreset === 'custom') {
          const focusColorSetting = document.querySelector('input[name="focus_color"]').value;

          Backdrop.ginAccent.setCustomFocusColor(focusColorSetting);
        }
      });

      // Watch Focus color picker has changed.
      document.querySelector('input[name="focus_picker"]').addEventListener('change', e => {
        const focusColorSetting = e.currentTarget.value;

        // Sync fields.
        document.querySelector('input[name="focus_color"]').value = focusColorSetting;

        // Update.
        Backdrop.ginAccent.setCustomFocusColor(focusColorSetting);
      });

      // Watch Accent color setting has changed.
      document.querySelector('input[name="focus_color"]').addEventListener('change', e => {
        const focusColorSetting = e.currentTarget.value;

        // Sync fields.
        document.querySelector('input[name="focus_picker"]').value = focusColorSetting;

        // Update.
        Backdrop.ginAccent.setCustomFocusColor(focusColorSetting);
      });

      // Watch High contrast mode setting has changed.
      document.querySelector('input[name="high_contrast_mode"]').addEventListener('change', e => {
        const highContrastMode = e.currentTarget.matches(':checked');

        // Update.
        this.setHighContrastMode(highContrastMode);
      });

    },

    darkmode: function (darkmodeParam = null) {
      const darkmodeEnabled = darkmodeParam != null ? darkmodeParam : Backdrop.settings.gin.darkmode;
      const darkmodeClass = Backdrop.settings.gin.darkmode_class;
      if (
        darkmodeEnabled == 1 ||
        (darkmodeEnabled === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches)
      ) {
        document.querySelector('html').classList.add(darkmodeClass);
      }
      else {
        document.querySelector('html').classList.remove(darkmodeClass);
      }

      // Change to Darkmode.
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (e.matches && document.querySelector('input[name="enable_darkmode"]:checked').value === 'auto') {
          document.querySelector('html').classList.add(darkmodeClass);
        }
      });

      // Change to Lightmode.
      window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', e => {
        if (e.matches && document.querySelector('input[name="enable_darkmode"]:checked').value === 'auto') {
          document.querySelector('html').classList.remove(darkmodeClass);
        }
      });
    },

    setHighContrastMode: function (param = null) {
      const enabled = param != null ? param : Backdrop.settings.gin.highcontrastmode;
      const className = Backdrop.settings.gin.highcontrastmode_class;

      // Needs to check for both: backwards compatibility.
      if (enabled === true || enabled === 1) {
        document.body.classList.add(className);
      }
      else {
        document.body.classList.remove(className);
      }
    },

  };
})(Backdrop);
