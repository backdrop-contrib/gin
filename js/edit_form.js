(function ($) {

  /**
   * Move action buttons to the sticky area.
   */

  Backdrop.behaviors.ginEditForm = {
    attach: function (context, settings) {
      $('.block-page-title-block').append($('.form-actions'));
      $('.form-actions input').attr('form', $('.node-form').attr('id'));
    }
  };

})(jQuery);
