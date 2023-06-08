(Drupal => {
  Drupal.behaviors.tonicEditForm = {
    attach: context => {
      once("tonicEditForm", ".l-content form.tonic-node-edit-form", context).forEach((form => {
        const sticky = context.querySelector(".tonic-sticky"), newParent = context.querySelector(".region-sticky__items__inner");
        if (newParent && 0 === newParent.querySelectorAll(".tonic-sticky").length) {
          newParent.appendChild(sticky);
          const actionButtons = newParent.querySelectorAll("button, input, select, textarea");
          actionButtons.length > 0 && actionButtons.forEach((el => {
            el.setAttribute("form", form.getAttribute("id")), el.setAttribute("id", el.getAttribute("id") + "--tonic-edit-form");
          }));
        }
      }));
    }
  };
})(Drupal);