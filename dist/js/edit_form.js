var $;

$ = jQuery, Backdrop.behaviors.ginEditForm = {
  attach: function(context, settings) {
    $(".block-page-title-block").append($(".form-actions")), $(".form-actions input").attr("form", "page-node-form");
  }
};