(Backdrop => {
  Backdrop.behaviors.formDescriptionToggle = {
    attach: function(context, settings) {
      $(".help-icon__description-toggle", context).once("formDescriptionToggle").each((function() {
        if (this.dataset.formDescriptionToggleAttached) return;
        this.dataset.formDescriptionToggleAttached = !0;
        const a11yLabel = "help-icon-label--" + Math.floor(1e4 * Math.random());
        this.setAttribute("id", a11yLabel), this.setAttribute("aria-expanded", "false"), 
        this.setAttribute("aria-controls", "target"), this.closest(".help-icon__description-container").querySelectorAll(".description").forEach((description => {
          description.setAttribute("aria-labelledby", a11yLabel);
        })), this.addEventListener("click", (event => {
          event.preventDefault(), event.stopPropagation(), "SUMMARY" === event.currentTarget.parentElement.tagName && !1 === event.currentTarget.parentElement.parentElement.open && (event.currentTarget.parentElement.parentElement.open = !0), 
          event.currentTarget.focus(), event.currentTarget.closest(".help-icon__description-container").querySelectorAll(".description").forEach(((description, index) => {
            if (index > 1) return;
            const setStatus = description.classList.contains("visually-hidden");
            event.currentTarget.setAttribute("aria-expanded", setStatus), description.classList.toggle("visually-hidden"), 
            description.setAttribute("aria-hidden", !setStatus);
          }));
        }));
      }));
    }
  };
})(Backdrop);