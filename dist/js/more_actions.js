var $;

$ = jQuery, Backdrop.behaviors.ginFormActions = {
  attach: (context, settings) => {
    Backdrop.ginStickyFormActions.init(context, settings);
  }
}, Backdrop.ginStickyFormActions = {
  init: function(context, settings) {
    const actionsFormId = settings.Gin.actions_form_id;
    $("#backdrop-modal form").once("ginEditModalForm").addClass("gin-edit-modal-form"), 
    $("#" + actionsFormId + ":not(.gin-edit-modal-form)").once("ginEditForm").each((function() {
      $(".form-actions input", this).attr("form", actionsFormId), $("body > .layout > .region-sticky .block-page-title-block").append($(".form-actions", this));
    })), $(".gin-more-actions__trigger").once("ginMoreActionsToggle").each((function(el) {
      el.addEventListener("click", (e => {
        e.preventDefault(), Backdrop.ginStickyFormActions.toggleMoreActions(), document.addEventListener("click", this.closeMoreActionsOnClickOutside, !1);
      }));
    }));
  },
  updateFormId: function(newParent, formId) {
    const actionButtons = newParent.querySelectorAll("button, input, select, textarea");
    actionButtons.length > 0 && actionButtons.forEach((el => {
      el.setAttribute("form", formId);
    }));
  },
  moveFocus: function(newParent, formId) {
    $("#" + formId).once("ginMoveFocusToStickyBar").each((function(el) {
      el.addEventListener("focus", (e => {
        e.preventDefault(), newParent.querySelector([ "button, input, select, textarea" ]).focus();
        let element = document.createElement("div");
        element.style.display = "contents", element.innerHTML = '<a href="#" class="visually-hidden" role="button" gin-move-focus-to-end-of-form>Moves focus back to form</a>', 
        newParent.appendChild(element), document.querySelector("[gin-move-focus-to-end-of-form]").addEventListener("focus", (eof => {
          eof.preventDefault(), element.remove(), e.target.nextElementSibling ? e.target.nextElementSibling.focus() : e.target.parentNode.nextElementSibling && e.target.parentNode.nextElementSibling.focus();
        }));
      }));
    }));
  },
  toggleMoreActions: function() {
    document.querySelector(".gin-more-actions__trigger").classList.contains("is-active") ? this.hideMoreActions() : this.showMoreActions();
  },
  showMoreActions: function() {
    const trigger = document.querySelector(".gin-more-actions__trigger");
    trigger.setAttribute("aria-expanded", "true"), trigger.classList.add("is-active");
  },
  hideMoreActions: function() {
    const trigger = document.querySelector(".gin-more-actions__trigger");
    trigger.setAttribute("aria-expanded", "false"), trigger.classList.remove("is-active"), 
    document.removeEventListener("click", this.closeMoreActionsOnClickOutside);
  },
  closeMoreActionsOnClickOutside: function(e) {
    "false" !== document.querySelector(".gin-more-actions__trigger").getAttribute("aria-expanded") && (e.target.closest(".gin-more-actions") || Backdrop.ginStickyFormActions.hideMoreActions());
  }
};