var $;

$ = jQuery, Backdrop.behaviors.ginEditForm = {
  attach: function(context, settings) {
    const hideLabel = Backdrop.t("Hide sidebar panel");
    $(".node-form").once("gin-edit-form").each((function() {
      $("> div:first-child", this).addClass("layout-region-node-main"), $("> .layout-region-node-main > .form-actions", this).prepend('<a href="#toggle-sidebar" class="meta-sidebar__trigger trigger" role="button" title="' + hideLabel + '" aria-controls="gin_sidebar"><span class="visually-hidden">' + hideLabel + "</span></a>"), 
      $("> .layout-region-node-main > .form-actions input", this).attr("form", $(this).attr("id")), 
      $(".block-page-title-block").append($("> .layout-region-node-main > .form-actions", this)), 
      $(this).append('<div id="gin_sidebar" class="layout-region-node-secondary"></div>'), 
      $(".layout-region-node-secondary", this).append($(".node-edit-settings"));
    }));
  }
};