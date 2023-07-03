/* eslint-disable func-names, no-mutable-exports, comma-dangle, strict */

((Backdrop, once) => {
  const breakpoint = 1024;
  const storageMobile = 'Backdrop.gin.sidebarExpanded.mobile';
  const storageDesktop = 'Backdrop.gin.sidebarExpanded.desktop';

  Backdrop.behaviors.ginSidebar = {
    attach: function attach(context) {
      Backdrop.ginSidebar.init(context);
    },
  };

  Backdrop.ginSidebar = {
    init: function (context) {
      once('ginSidebarInit', '#gin_sidebar', context).forEach(() => {
        // If variable does not exist, create it, default being to show sidebar.
        if (!localStorage.getItem(storageDesktop)) {
          localStorage.setItem(storageDesktop, 'true');
        }

        // Set mobile initial to false.
        if (window.innerWidth >= breakpoint) {
          if (localStorage.getItem(storageDesktop) === 'true') {
            this.showSidebar();
          }
          else {
            this.collapseSidebar();
          }
        }

        // Show navigation with shortcut:
        // OPTION + S (Mac) / ALT + S (Windows)
        document.addEventListener('keydown', e => {
          if (e.altKey === true && e.code === 'KeyS') {
            this.toggleSidebar();
          }
        });

        window.onresize = Backdrop.debounce(this.handleResize, 150);
      });

      // Toolbar toggle
      once('ginSidebarToggle', '.meta-sidebar__trigger', context).forEach(el => el.addEventListener('click', e => {
        e.preventDefault();
        this.removeInlineStyles();
        this.toggleSidebar();
      }));

      // Toolbar close
      once('ginSidebarClose', '.meta-sidebar__close, .meta-sidebar__overlay', context).forEach(el => el.addEventListener('click', e => {
        e.preventDefault();
        this.removeInlineStyles();
        this.collapseSidebar();
      }));
    },

    toggleSidebar: () => {
      // Set active state.
      if (document.querySelector('.meta-sidebar__trigger').classList.contains('is-active')) {
        Backdrop.ginSidebar.collapseSidebar();
      }
      else {
        Backdrop.ginSidebar.showSidebar();
      }
    },

    showSidebar: () => {
      const chooseStorage = window.innerWidth < breakpoint ? storageMobile : storageDesktop;
      const showLabel = Backdrop.t('Hide sidebar panel');
      const sidebarTrigger = document.querySelector('.meta-sidebar__trigger');

      sidebarTrigger.setAttribute('title', showLabel);
      sidebarTrigger.querySelector('span').innerHTML = showLabel;
      sidebarTrigger.setAttribute('aria-expanded', 'true');
      sidebarTrigger.classList.add('is-active');

      document.body.setAttribute('data-meta-sidebar', 'open');

      // Expose to localStorage.
      localStorage.setItem(chooseStorage, 'true');
    },

    collapseSidebar: () => {
      const chooseStorage = window.innerWidth < breakpoint ? storageMobile : storageDesktop;
      const hideLabel = Backdrop.t('Show sidebar panel');
      const sidebarTrigger = document.querySelector('.meta-sidebar__trigger');

      sidebarTrigger.setAttribute('title', hideLabel);
      sidebarTrigger.querySelector('span').innerHTML = hideLabel;
      sidebarTrigger.setAttribute('aria-expanded', 'false');
      sidebarTrigger.classList.remove('is-active');

      document.body.setAttribute('data-meta-sidebar', 'closed');

      // Expose to localStorage.
      localStorage.setItem(chooseStorage, 'false');
    },

    handleResize: () => {
      Backdrop.ginSidebar.removeInlineStyles();

      // If small viewport, always collapse sidebar.
      if (window.innerWidth < breakpoint) {
        Backdrop.ginSidebar.collapseSidebar();
      } else {
        // If large viewport, show sidebar if it was open before.
        if (localStorage.getItem(storageDesktop) === 'true') {
          Backdrop.ginSidebar.showSidebar();
        } else {
          Backdrop.ginSidebar.collapseSidebar();
        }
      }
    },

    removeInlineStyles: () => {
      // Remove init styles.
      const elementToRemove = document.querySelector('.gin-sidebar-inline-styles');
      if (elementToRemove) {
        elementToRemove.parentNode.removeChild(elementToRemove);
      }
    },

  };
})(Backdrop, once);
