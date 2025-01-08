/* eslint-disable func-names, no-mutable-exports, comma-dangle, strict */

(function ($) {
  const breakpoint = 1024;
  const breakpointLarge = 1280;
  const storageMobile = 'Backdrop.gin.sidebarExpanded.mobile';
  const storageDesktop = 'Backdrop.gin.sidebarExpanded.desktop';
  const storageWidth = "Backdrop.gin.sidebarWidth";
  var resizer = document.getElementById('gin-sidebar-draggable');
  var resizable = document.getElementById('gin_sidebar');
  let isResizing = false;
  let startX, startWidth;
  Backdrop.behaviors.ginSidebar = {
    attach: function (context, settings) {
      Backdrop.ginSidebar.init(context, settings);
    },
  };

  Backdrop.ginSidebar = {
    init: function (context, settings) {
      const hideLabel = Backdrop.t('Hide sidebar panel');
      const sidebarFormId = settings.Gin.sidebar_form_id;
      const actionsFormId = settings.Gin.actions_form_id;
      const sidebarToggler = '<a href="#toggle-sidebar" class="meta-sidebar__trigger trigger" role="button" title="' + hideLabel + '" aria-controls="gin_sidebar"><span class="visually-hidden">' + hideLabel + '</span></a>';
      $('#backdrop-modal form').once('ginEditModalForm').addClass('gin-edit-modal-form');
      $("#ckeditor5-modal form").once("ginEditModalForm").addClass("gin-edit-modal-form"),
      $('#' + sidebarFormId + ':not(.gin-edit-modal-form)').once('gin-sidebar').each(function () {
        $('> div:first-child', this).addClass('layout-region-node-main');

        if (actionsFormId) {
          // Actions behavior may have run first.
          $('.region-sticky .form-actions').prepend(sidebarToggler);
        }
        else {
          $('.form-actions', this).append(sidebarToggler);
        }

        $(this).append('<div id="gin_sidebar" class="layout-region-node-secondary"><span class="gin-sidebar-draggable" id="gin-sidebar-draggable"></span></div>');
        $('.layout-region-node-secondary', this).append($('.content-edit-settings'));
      });

      resizer = document.getElementById('gin-sidebar-draggable');
      resizable = document.getElementById('gin_sidebar');

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

        // Resize observer.
        const resizeHandler = new ResizeObserver(entries => {
          for (let entry of entries) {
            Backdrop.debounce(this.handleResize(entry.contentRect), 150);
          }
        });
        resizeHandler.observe(document.querySelector('html'));

        // Init resizable sidebar.
        this.resizeInit();
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
        Backdrop.ginStickyFormActions?.hideMoreActions();
      }
      else {
        Backdrop.ginSidebar.showSidebar();
        Backdrop.ginStickyFormActions?.hideMoreActions();
      }
    },

    showSidebar: () => {
      const chooseStorage = window.innerWidth < breakpoint ? storageMobile : storageDesktop;
      const hideLabel = Backdrop.t('Hide sidebar panel');
      const sidebarTrigger = document.querySelector('.meta-sidebar__trigger');

      if (!sidebarTrigger) {
        return;
      }

      sidebarTrigger.querySelector('span').innerHTML = hideLabel;
      sidebarTrigger.setAttribute('title', hideLabel);
      if (sidebarTrigger.nextSibling) {
        sidebarTrigger.nextSibling.innerHTML = hideLabel;
      }
      sidebarTrigger.setAttribute('aria-expanded', 'true');
      sidebarTrigger.classList.add('is-active');

      $('body').attr('data-meta-sidebar', 'open');

      // Expose to localStorage.
      localStorage.setItem(chooseStorage, 'true');

      // Check which toolbar is active.
      /*
      if (window.innerWidth < breakpointLarge) {
        Backdrop.ginCoreNavigation?.collapseToolbar();

        if (toolbarVariant === 'vertical') {
          Backdrop.ginToolbar.collapseToolbar();
        } else if (toolbarVariant === 'new') {
          Backdrop.behaviors.ginNavigation?.collapseSidebar();
        }
      }
      */
    },

    collapseSidebar: () => {
      const chooseStorage = window.innerWidth < breakpoint ? storageMobile : storageDesktop;
      const showLabel = Backdrop.t('Show sidebar panel');
      const sidebarTrigger = document.querySelector('.meta-sidebar__trigger');

      sidebarTrigger.querySelector('span').innerHTML = showLabel;
      sidebarTrigger.setAttribute('title', showLabel);
      if (sidebarTrigger.nextSibling) {
        sidebarTrigger.nextSibling.innerHTML = showLabel;
      }
      sidebarTrigger.setAttribute('aria-expanded', 'false');
      sidebarTrigger.classList.remove('is-active');

      $('body').attr('data-meta-sidebar', 'closed');

      // Expose to localStorage.
      localStorage.setItem(chooseStorage, 'false');
    },

    handleResize: (windowSize = window) => {
      Backdrop.ginSidebar.removeInlineStyles();

      // If small viewport, always collapse sidebar.
      if (windowSize.width < breakpoint) {
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

    resizeInit: function () {
      // Mouse
      resizer.addEventListener('mousedown', this.resizeStart);
      document.addEventListener('mousemove', this.resizeWidth);
      document.addEventListener('mouseup', this.resizeEnd);

      // Touch
      resizer.addEventListener('touchstart', this.resizeStart);
      document.addEventListener('touchmove', this.resizeWidth);
      document.addEventListener('touchend', this.resizeEnd);
    },

    resizeStart: (e) => {
      e.preventDefault();
      isResizing = true;
      startX = e.clientX;
      startWidth = parseInt(document.defaultView.getComputedStyle(resizable).width, 10);
    },

    resizeEnd: () => {
      isResizing = false;
      const setWidth = document.documentElement.style.getPropertyValue('--gin-sidebar-width');
      const currentWidth = setWidth ? setWidth : resizable.style.width;
      localStorage.setItem(storageWidth, currentWidth);
      document.removeEventListener('mousemove', this.resizeWidth);
      document.removeEventListener('touchend', this.resizeWidth);
    },

    resizeWidth: (e) => {
      if (isResizing) {
        let sidebarWidth = startWidth - (e.clientX - startX);

        if (sidebarWidth <= 240) {
          sidebarWidth = 240;
        } else if (sidebarWidth >= 560) {
          sidebarWidth = 560;
        }

        sidebarWidth = `${sidebarWidth}px`;
        // resizable.style.width = sidebarWidth;
        document.documentElement.style.setProperty('--gin-sidebar-width', sidebarWidth);
      }
    }

  };
})(jQuery);
