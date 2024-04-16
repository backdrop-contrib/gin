(function ($) {
  /**
   * Move action buttons to the sticky area, vertical tabs into the sidebar.
   */

  Backdrop.behaviors.ginEditForm = {
    attach: function (context, settings) {
      const hideLabel = Backdrop.t('Hide sidebar panel');
      const formId = settings.Gin.sidebar_form_id;
      $('#' + formId).once('gin-edit-form').each(function () {
        $('> div:first-child', this).addClass('layout-region-content-main');
        $('> .layout-region-content-main > .form-actions', this).prepend('<a href="#toggle-sidebar" class="meta-sidebar__trigger trigger" role="button" title="' + hideLabel + '" aria-controls="gin_sidebar"><span class="visually-hidden">' + hideLabel + '</span></a>');
        $('> .layout-region-content-main > .form-actions input', this).attr('form', $(this).attr('id'));
        $('.block-page-title-block').append($('> .layout-region-content-main > .form-actions', this));
        $(this).append('<div id="gin_sidebar" class="layout-region-content-secondary"></div>');
        $('.layout-region-content-secondary', this).append($('.content-edit-settings'));
      });
    }
  };

})(jQuery);
