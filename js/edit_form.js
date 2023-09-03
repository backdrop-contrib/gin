(function ($) {
  /**
   * Move action buttons to the sticky area, vertical tabs into the sidebar.
   */

  Backdrop.behaviors.ginEditForm = {
    attach: function (context, settings) {
      $(document).ready(function () {
        $('.node-form > div').addClass('layout-region-node-main');
        $('.node-form').append('<div class="layout-region-node-secondary"></div>');
        $('.layout-region-node-secondary').append($('.node-edit-settings'));
        // $('.layout-region-node-secondary .vertical-tabs-pane').addClass('collapsible');
        // $('.layout-region-node-secondary .vertical-tabs-pane').removeClass('vertical-tabs-pane');
        $('.block-page-title-block').append($('.form-actions'));
        $('.form-actions input').attr('form', $('.node-form').attr('id'));
      });
    }
  };

})(jQuery);
