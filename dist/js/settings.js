(Backdrop => {
  Backdrop.behaviors.ginSettings = {
    attach: function(context) {
      Backdrop.ginSettings.init(context);
    }
  }, Backdrop.ginSettings = {
    init: function(context) {
      context.querySelectorAll('input[name="enable_darkmode"]').forEach((el => el.addEventListener("change", (e => {
        const darkmode = e.currentTarget.value, accentColorPreset = document.querySelector("#edit-preset-accent-color input:checked").value, focusColorPreset = document.querySelector('select[name="preset_focus_color"]').value;
        if (this.darkmode(darkmode), "custom" === accentColorPreset) {
          const accentColorSetting = document.querySelector('input[name="accent_color"]').value;
          Backdrop.ginAccent.setCustomAccentColor(accentColorSetting);
        } else Backdrop.ginAccent.setAccentColor(accentColorPreset);
        if ("custom" === focusColorPreset) {
          const focusColorSetting = document.querySelector('input[name="focus_color"]').value;
          Backdrop.ginAccent.setCustomFocusColor(focusColorSetting);
        } else Backdrop.ginAccent.setFocusColor(focusColorPreset);
      })))), context.querySelectorAll("#edit-preset-accent-color input").forEach((el => el.addEventListener("change", (e => {
        const accentColorPreset = e.currentTarget.value;
        if (Backdrop.ginAccent.clearAccentColor(), Backdrop.ginAccent.setAccentColor(accentColorPreset), 
        "custom" === accentColorPreset) {
          const accentColorSetting = document.querySelector('input[name="accent_color"]').value;
          Backdrop.ginAccent.setCustomAccentColor(accentColorSetting);
        }
      })))), context.querySelectorAll('input[name="accent_picker"]').forEach((el => el.addEventListener("change", (e => {
        const accentColorSetting = e.currentTarget.value;
        document.querySelector('input[name="accent_color"]').value = accentColorSetting, 
        Backdrop.ginAccent.setCustomAccentColor(accentColorSetting);
      })))), context.querySelectorAll('input[name="accent_color"]').forEach((el => el.addEventListener("change", (e => {
        const accentColorSetting = e.currentTarget.value;
        document.querySelector('input[name="accent_picker"]').value = accentColorSetting, 
        Backdrop.ginAccent.setCustomAccentColor(accentColorSetting);
      })))), document.querySelector('select[name="preset_focus_color"]').addEventListener("change", (e => {
        const focusColorPreset = e.currentTarget.value;
        if (Backdrop.ginAccent.clearFocusColor(), Backdrop.ginAccent.setFocusColor(focusColorPreset), 
        "custom" === focusColorPreset) {
          const focusColorSetting = document.querySelector('input[name="focus_color"]').value;
          Backdrop.ginAccent.setCustomFocusColor(focusColorSetting);
        }
      })), document.querySelector('input[name="focus_picker"]').addEventListener("change", (e => {
        const focusColorSetting = e.currentTarget.value;
        document.querySelector('input[name="focus_color"]').value = focusColorSetting, Backdrop.ginAccent.setCustomFocusColor(focusColorSetting);
      })), document.querySelector('input[name="focus_color"]').addEventListener("change", (e => {
        const focusColorSetting = e.currentTarget.value;
        document.querySelector('input[name="focus_picker"]').value = focusColorSetting, 
        Backdrop.ginAccent.setCustomFocusColor(focusColorSetting);
      })), document.querySelector('input[name="high_contrast_mode"]').addEventListener("change", (e => {
        const highContrastMode = e.currentTarget.matches(":checked");
        this.setHighContrastMode(highContrastMode);
      })), document.querySelector("#edit-submit").addEventListener("click", (() => {
        localStorage.setItem("Backdrop.gin.darkmode", "");
      }));
    },
    darkmode: function() {
      let darkmodeParam = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : null;
      const darkmodeEnabled = null != darkmodeParam ? darkmodeParam : Backdrop.settings.gin.darkmode, darkmodeClass = Backdrop.settings.gin.darkmode_class;
      1 == darkmodeEnabled || "auto" === darkmodeEnabled && window.matchMedia("(prefers-color-scheme: dark)").matches ? document.querySelector("html").classList.add(darkmodeClass) : document.querySelector("html").classList.remove(darkmodeClass), 
      localStorage.setItem("Backdrop.gin.darkmode", ""), window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", (e => {
        e.matches && "auto" === document.querySelector('input[name="enable_darkmode"]:checked').value && document.querySelector("html").classList.add(darkmodeClass);
      })), window.matchMedia("(prefers-color-scheme: light)").addEventListener("change", (e => {
        e.matches && "auto" === document.querySelector('input[name="enable_darkmode"]:checked').value && document.querySelector("html").classList.remove(darkmodeClass);
      }));
    },
    setHighContrastMode: function() {
      let param = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : null;
      const enabled = null != param ? param : Backdrop.settings.gin.highcontrastmode, className = Backdrop.settings.gin.highcontrastmode_class;
      !0 === enabled || 1 === enabled ? document.body.classList.add(className) : document.body.classList.remove(className);
    }
  };
})(Backdrop);