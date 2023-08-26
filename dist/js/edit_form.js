var $;

$ = jQuery, Backdrop.behaviors.ginEditForm = {
  attach: function(context, settings) {
    $(".block-page-title-block").append($(".form-actions"));
  }
};