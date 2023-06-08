((Drupal, once) => {
  Drupal.behaviors.tonicMessages = {
    attach: context => {
      Drupal.tonicMessages.dismissMessages(context);
    }
  }, Drupal.tonicMessages = {
    dismissMessages: function() {
      let context = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : document;
      once("tonic-messages-dismiss", ".messages .button--dismiss", context).forEach((dismissButton => {
        dismissButton.addEventListener("click", (e => {
          e.preventDefault();
          const message = e.currentTarget.closest(".messages-list__item");
          Drupal.tonicMessages.hideMessage(message);
        }));
      }));
    },
    hideMessage: message => {
      message.style.opacity = 0, message.classList.add("visually-hidden");
    }
  };
})(Drupal, once);