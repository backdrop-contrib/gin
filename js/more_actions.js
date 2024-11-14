/* eslint-disable func-names, no-mutable-exports, comma-dangle, strict */

'use strict';

(function ($) {

  Backdrop.behaviors.ginFormActions = {
    attach: (context, settings) => {
      Backdrop.ginStickyFormActions.init(context, settings);
    },
  };

  Backdrop.ginStickyFormActions = {

    init: function (context, settings) {
      const actionsFormId = settings.Gin.actions_form_id;
      $('#backdrop-modal form').once('ginEditModalForm').addClass('gin-edit-modal-form');
      $('#ckeditor5-modal form').once('ginEditModalForm').addClass('gin-edit-modal-form');
      $('#' + actionsFormId + ':not(.gin-edit-modal-form)').once('ginEditForm').each(function () {
        // Sync form ID.
        // Backdrop.ginStickyFormActions.updateFormId(newParent, $(this).attr('id'));
        $('.form-actions input', this).attr('form', actionsFormId);
        $('body > .layout > .region-sticky .block-page-title-block').append($('.form-actions', this));

        // Move focus to sticky header.
        // Backdrop.ginStickyFormActions.moveFocus(newParent, $(this).attr('id'));
      });

      // More actions menu toggle
      $('.gin-more-actions__trigger').once('ginMoreActionsToggle').each(function (el) {
        el.addEventListener('click', e => {
          e.preventDefault();
          Backdrop.ginStickyFormActions.toggleMoreActions();
          document.addEventListener('click', this.closeMoreActionsOnClickOutside, false);
        });
      });
    },

    updateFormId: function (newParent, formId) {
      // Attach form elements to main form
      const actionButtons = newParent.querySelectorAll('button, input, select, textarea');

      if (actionButtons.length > 0) {
        actionButtons.forEach((el) => {
          el.setAttribute('form', formId);
        });
      }
    },

    moveFocus: function (newParent, formId) {
      $('#' + formId).once('ginMoveFocusToStickyBar').each(function (el) {
        el.addEventListener('focus', e => {
          e.preventDefault();
          const focusableElements = ['button, input, select, textarea'];

          // Moves focus to first item.
          newParent.querySelector(focusableElements).focus();

          // Add temporary element to handle moving focus back to end of form.
          const markup = '<a href="#" class="visually-hidden" role="button" gin-move-focus-to-end-of-form>Moves focus back to form</a>';
          let element = document.createElement('div');
          element.style.display = 'contents';
          element.innerHTML = markup;
          newParent.appendChild(element);

          document.querySelector('[gin-move-focus-to-end-of-form]').addEventListener('focus', eof => {
            eof.preventDefault();

            // Let's remove ourselves.
            element.remove();

            // Let's try to move focus back to end of form.
            if (e.target.nextElementSibling) {
              e.target.nextElementSibling.focus();
            } else if (e.target.parentNode.nextElementSibling) {
              e.target.parentNode.nextElementSibling.focus();
            }
          });
        });
      });
    },

    toggleMoreActions: function () {
      const trigger = document.querySelector('.gin-more-actions__trigger');
      const value = trigger.classList.contains('is-active');

      if (value) {
        this.hideMoreActions();
      } else {
        this.showMoreActions();
      }
    },

    showMoreActions: function () {
      const trigger = document.querySelector('.gin-more-actions__trigger');
      trigger.setAttribute('aria-expanded', 'true');
      trigger.classList.add('is-active');
    },

    hideMoreActions: function () {
      const trigger = document.querySelector('.gin-more-actions__trigger');
      trigger.setAttribute('aria-expanded', 'false');
      trigger.classList.remove('is-active');
      document.removeEventListener('click', this.closeMoreActionsOnClickOutside);
    },

    closeMoreActionsOnClickOutside: function (e) {
      const trigger = document.querySelector('.gin-more-actions__trigger');

      if (trigger.getAttribute('aria-expanded') === "false") return;

      if (!e.target.closest('.gin-more-actions')) {
        Backdrop.ginStickyFormActions.hideMoreActions();
      }
    },

  };
})(jQuery);
