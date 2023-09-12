(function ($) {
  /**
   * Move action buttons to the sticky area, vertical tabs into the sidebar.
   */

  Backdrop.behaviors.ginEditForm = {
    attach: function (context, settings) {
      $(document).ready(function () {
        $('.node-form').once('gin-edit-form').each(function () {
          $('> div', this).addClass('layout-region-node-main');
          $(this).append('<div class="layout-region-node-secondary"></div>');
          $('.layout-region-node-secondary').append($('.node-edit-settings'));
          $('.block-page-title-block').append($('.form-actions'));
          $('.form-actions input').attr('form', $(this).attr('id'));
        });
      });
    }
  };

})(jQuery);
