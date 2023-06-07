/* eslint-disable no-bitwise, no-nested-ternary, no-mutable-exports, comma-dangle, strict */

((Drupal, drupalSettings, once) => {
  Drupal.behaviors.tonicAccent = {
    attach: function attach(context) {
      once('tonicAccent', 'body', context).forEach(() => {
        // Check Darkmode.
        Drupal.tonicAccent.checkDarkmode();

        // Set accent color.
        Drupal.tonicAccent.setAccentColor();

        // Set focus color.
        Drupal.tonicAccent.setFocusColor();
      });
    },
  };

  Drupal.tonicAccent = {
    setAccentColor: function setAccentColor(preset = null, color = null) {
      const accentColorPreset = preset != null ? preset : drupalSettings.tonic.preset_accent_color;
      document.body.setAttribute('data-tonic-accent', accentColorPreset);

      if (accentColorPreset === 'custom') {
        this.setCustomAccentColor(color);
      }
    },

    setCustomAccentColor: function setCustomAccentColor(color = null, element = document.body) {
      // If custom color is set, generate colors through JS.
      const accentColor = color != null ? color : drupalSettings.tonic.accent_color;
      if (accentColor) {
        this.clearAccentColor(element);

        const strippedAccentColor = accentColor.replace('#', '');
        const darkAccentColor = this.mixColor('ffffff', strippedAccentColor, 65).replace('#', '');
        const style = document.createElement('style');
        style.className = 'tonic-custom-colors';
        style.innerHTML = `
          [data-tonic-accent="custom"] {\n\
            --tonic-color-primary-rgb: ${this.hexToRgb(accentColor)};\n\
            --tonic-color-primary-hover: ${this.shadeColor(accentColor, -10)};\n\
            --tonic-color-primary-active: ${this.shadeColor(accentColor, -15)};\n\
            --tonic-bg-app-rgb: ${this.hexToRgb(this.mixColor('ffffff', strippedAccentColor, 97))};\n\
            --tonic-bg-header: ${this.mixColor('ffffff', strippedAccentColor, 85)};\n\
            --tonic-color-sticky-rgb: ${this.hexToRgb(this.mixColor('ffffff', strippedAccentColor, 92))};\n\
          }\n\
          .tonic--dark-mode[data-tonic-accent="custom"],\n\
          .tonic--dark-mode [data-tonic-accent="custom"] {\n\
            --tonic-color-primary-rgb: ${this.hexToRgb(darkAccentColor)};\n\
            --tonic-color-primary-hover: ${this.mixColor('ffffff', strippedAccentColor, 55)};\n\
            --tonic-color-primary-active: ${this.mixColor('ffffff', strippedAccentColor, 50)};\n\
            --tonic-bg-header: ${this.mixColor('2A2A2D', darkAccentColor, 88)};\n\
          }\n\
        `;

        element.append(style);
      }
    },

    clearAccentColor: (element = document.body) => {
      if (element.querySelectorAll('.tonic-custom-colors').length > 0) {
        const removeElement = element.querySelector('.tonic-custom-colors');
        removeElement.parentNode.removeChild(removeElement);
      }
    },

    setFocusColor: function setFocusColor(preset = null, color = null) {
      const focusColorPreset = preset != null ? preset : drupalSettings.tonic.preset_focus_color;
      document.body.setAttribute('data-tonic-focus', focusColorPreset);

      if (focusColorPreset === 'custom') {
       this.setCustomFocusColor(color);
      }
    },

    setCustomFocusColor: function setCustomFocusColor(color = null, element = document.body) {
      const accentColor = color != null ? color : drupalSettings.tonic.focus_color;

      // Set preset color.
      if (accentColor) {
        this.clearFocusColor(element);

        const strippedAccentColor = accentColor.replace('#', '');
        const darkAccentColor = this.mixColor('ffffff', strippedAccentColor, 65);
        const style = document.createElement('style');
        style.className = 'tonic-custom-focus';
        style.innerHTML = `
          [data-tonic-focus="custom"] {\n\
            --tonic-color-focus: ${accentColor};\n\
          }\n\
          .tonic--dark-mode[data-tonic-focus="custom"],\n\
          .tonic--dark-mode [data-tonic-focus="custom"] {\n\
            --tonic-color-focus: ${darkAccentColor};\n\
          }`;

        element.append(style);
      }
    },

    clearFocusColor: (element = document.body) => {
      if (element.querySelectorAll('.tonic-custom-focus').length > 0) {
        const removeElement = element.querySelector('.tonic-custom-focus');
        removeElement.parentNode.removeChild(removeElement);
      }
    },

    checkDarkmode: () => {
      const darkmodeClass = drupalSettings.tonic.darkmode_class;

      // Change to Darkmode.
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (e.matches && localStorage.getItem('Drupal.tonic.darkmode') === 'auto') {
          document.querySelector('html').classList.add(darkmodeClass);
        }
      });

      // Change to Lightmode.
      window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', e => {
        if (e.matches && localStorage.getItem('Drupal.tonic.darkmode') === 'auto') {
          document.querySelector('html').classList.remove(darkmodeClass);
        }
      });
    },

    // https://stackoverflow.com/questions/5623838/rgb-to-hex-and-hex-to-rgb
    hexToRgb: (hex) => {
      var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
      hex = hex.replace(shorthandRegex, function(m, r, g, b) {
        return r + r + g + g + b + b;
      });

      var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
      return result ? `${parseInt(result[1], 16)}, ${parseInt(result[2], 16)}, ${parseInt(result[3], 16)}` : null;
    },

    // https://gist.github.com/jedfoster/7939513
    mixColor: (color_1, color_2, weight) => {
      function d2h(d) { return d.toString(16); }
      function h2d(h) { return parseInt(h, 16); }

      weight = (typeof(weight) !== 'undefined') ? weight : 50;

      var color = "#";

      for (var i = 0; i <= 5; i += 2) {
        var v1 = h2d(color_1.substr(i, 2)),
            v2 = h2d(color_2.substr(i, 2)),
            val = d2h(Math.floor(v2 + (v1 - v2) * (weight / 100.0)));

        while(val.length < 2) { val = '0' + val; }
        color += val;
      }

      return color;
    },

    shadeColor: (color, percent) => {
      const num = parseInt(color.replace('#', ''), 16);
      const amt = Math.round(2.55 * percent);
      const R = (num >> 16) + amt;
      const B = ((num >> 8) & 0x00ff) + amt;
      const G = (num & 0x0000ff) + amt;

      return `#${(
        0x1000000
        + (R < 255 ? (R < 1 ? 0 : R) : 255) * 0x10000
        + (B < 255 ? (B < 1 ? 0 : B) : 255) * 0x100
        + (G < 255 ? (G < 1 ? 0 : G) : 255)
      )
        .toString(16)
        .slice(1)}`;
    },

  };
})(Drupal, drupalSettings, once);
