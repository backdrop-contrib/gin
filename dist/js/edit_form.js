var $;

$ = jQuery, Backdrop.behaviors.ginEditForm = {
  attach: function(context, settings) {
    $(document).ready((function() {
      $(".node-form > div").addClass("layout-region-node-main"), $(".node-form").append('<div class="layout-region-node-secondary"></div>'), 
      $(".layout-region-node-secondary").append($(".node-edit-settings")), $(".block-page-title-block").append($(".form-actions")), 
      $(".form-actions input").attr("form", $(".node-form").attr("id"));
    }));
  }
};