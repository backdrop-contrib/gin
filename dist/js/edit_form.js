var $;

$ = jQuery, Backdrop.behaviors.ginEditForm = {
  attach: function(context, settings) {
    $(".node-form").once("gin-edit-form").each((function() {
      $("> div", this).addClass("layout-region-node-main"), $(this).append('<div id="gin_sidebar" class="layout-region-node-secondary"></div>'), 
      $(".layout-region-node-secondary").append($(".node-edit-settings")), $(".block-page-title-block").append($(".form-actions"));
      const hideLabel = Backdrop.t("Hide sidebar panel");
      $(".form-actions").prepend('<a href="#toggle-sidebar" class="meta-sidebar__trigger trigger" role="button" title="' + hideLabel + '" aria-controls="gin_sidebar"><span class="visually-hidden">' + hideLabel + "</span></a>"), 
      $(".form-actions input").attr("form", $(this).attr("id"));
    }));
  }
};