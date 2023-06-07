/* To inject this as early as possible
 * we use native JS instead of Drupal's behaviors.
*/

// Legacy Check: Transform old localStorage items to newer ones.
function checkLegacy() {
  if (localStorage.getItem('TonicDarkMode')) {
    localStorage.setItem('Drupal.tonic.darkmode', localStorage.getItem('TonicDarkMode'));
    localStorage.removeItem('TonicDarkMode');
  }

  if (localStorage.getItem('TonicSidebarOpen')) {
    localStorage.setItem('Drupal.tonic.toolbarExpanded', localStorage.getItem('TonicSidebarOpen'));
    localStorage.removeItem('TonicSidebarOpen');
  }
}

checkLegacy();

// Darkmode Check.
function tonicInitDarkmode() {
  const darkModeClass = 'tonic--dark-mode';
  if (
    localStorage.getItem('Drupal.tonic.darkmode') == 1 ||
    (localStorage.getItem('Drupal.tonic.darkmode') === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches)
  ) {
    document.documentElement.classList.add(darkModeClass);
  } else {
    document.documentElement.classList.contains(darkModeClass) === true && document.documentElement.classList.remove(darkModeClass);
  }
}

ginInitDarkmode();

// TonicDarkMode is not set yet.
window.addEventListener('DOMContentLoaded', () => {
  if (!localStorage.getItem('Drupal.tonic.darkmode')) {
    localStorage.setItem('Drupal.tonic.darkmode', drupalSettings.tonic.darkmode);
    tonicInitDarkmode();
  }
});

// Toolbar Check.
if (localStorage.getItem('Drupal.tonic.toolbarExpanded')) {
  const style = document.createElement('style');
  const className = 'tonic-toolbar-inline-styles';
  style.className = className;

  if (localStorage.getItem('Drupal.tonic.toolbarExpanded') === 'true') {
    style.innerHTML = `
    @media (min-width: 976px) {
      body.tonic--vertical-toolbar:not([data-toolbar-menu=open]) {
        padding-inline-start: 256px;
        transition: none;
      }

      .tonic--vertical-toolbar .toolbar-menu-administration {
        min-width: var(--tonic-toolbar-width, 256px);
        transition: none;
      }

      .tonic--vertical-toolbar .toolbar-menu-administration > .toolbar-menu > .menu-item > .toolbar-icon,
      .tonic--vertical-toolbar .toolbar-menu-administration > .toolbar-menu > .menu-item > .toolbar-box > .toolbar-icon {
        min-width: calc(var(--tonic-toolbar-width, 256px) - 16px);
      }
    }
    `;

    const scriptTag = document.querySelector('script');
    scriptTag.parentNode.insertBefore(style, scriptTag);
  } else if (document.getElementsByClassName(className).length > 0) {
    document.getElementsByClassName(className)[0].remove();
  }
}

// Sidebar check.
if (localStorage.getItem('Drupal.tonic.sidebarExpanded.desktop')) {
  const style = document.createElement('style');
  const className = 'tonic-sidebar-inline-styles';
  style.className = className;

  if (window.innerWidth < 1024 || localStorage.getItem('Drupal.tonic.sidebarExpanded.desktop') === 'false') {
    style.innerHTML = `
    body {
      --tonic-sidebar-offset: 0px;
      padding-inline-end: 0;
      transition: none;
    }

    .layout-region-node-secondary {
      transform: translateX(var(--tonic-sidebar-width, 360px));
      transition: none;
    }

    .meta-sidebar__overlay {
      display: none;
    }
    `;

    const scriptTag = document.querySelector('script');
    scriptTag.parentNode.insertBefore(style, scriptTag);
  } else if (document.getElementsByClassName(className).length > 0) {
    document.getElementsByClassName(className)[0].remove();
  }
}
