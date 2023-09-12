/* eslint-disable func-names, no-mutable-exports, comma-dangle, strict */

(function ($) {
  const breakpoint = 1024;
  const storageMobile = 'Backdrop.gin.sidebarExpanded.mobile';
  const storageDesktop = 'Backdrop.gin.sidebarExpanded.desktop';

  Backdrop.behaviors.ginSidebar = {
    attach: function (context, settings) {
      Backdrop.ginSidebar.init(context);
    },
  };

  Backdrop.ginSidebar = {
    init: function (context) {
      $('#gin_sidebar').once('ginSidebarInit', context).each(() => {
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

        window.onresize = Backdrop.debounce(this.handleResize, 150)();
      });

      // Toolbar toggle
      $('.meta-sidebar__trigger').once('ginSidebarToggle', context).on("click", e => {
        e.preventDefault();
        this.removeInlineStyles();
        this.toggleSidebar();
      });

      // Toolbar close
      $('.meta-sidebar__close, .meta-sidebar__overlay').once('ginSidebarClose', context).on("click", e => {
        e.preventDefault();
        this.removeInlineStyles();
        this.collapseSidebar();
      });
    },

    toggleSidebar: () => {
      // Set active state.
      if ($('.meta-sidebar__trigger').hasClass('is-active')) {
        Backdrop.ginSidebar.collapseSidebar();
      }
      else {
        Backdrop.ginSidebar.showSidebar();
      }
    },

    showSidebar: () => {
      const chooseStorage = window.innerWidth < breakpoint ? storageMobile : storageDesktop;
      const showLabel = Backdrop.t('Hide sidebar panel');
      const sidebarTrigger = $('.meta-sidebar__trigger');

      sidebarTrigger.attr('title', showLabel);
      $('span', sidebarTrigger).innerHTML = showLabel;
      sidebarTrigger.attr('aria-expanded', 'true');
      sidebarTrigger.addClass('is-active');

      $('body').attr('data-meta-sidebar', 'open');

      // Expose to localStorage.
      localStorage.setItem(chooseStorage, 'true');
    },

    collapseSidebar: () => {
      const chooseStorage = window.innerWidth < breakpoint ? storageMobile : storageDesktop;
      const hideLabel = Backdrop.t('Show sidebar panel');
      const sidebarTrigger = $('.meta-sidebar__trigger');

      sidebarTrigger.attr('title', hideLabel);
      $('span', sidebarTrigger).innerHTML = hideLabel;
      sidebarTrigger.attr('aria-expanded', 'false');
      sidebarTrigger.removeClass('is-active');

      $('body').attr('data-meta-sidebar', 'closed');

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
      const elementToRemove = $('.gin-sidebar-inline-styles');
      if (elementToRemove) {
        elementToRemove.remove();
      }
    },

  };
})(jQuery);
