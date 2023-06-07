/* eslint-disable func-names, no-mutable-exports, comma-dangle, strict */

'use strict';

((Drupal) => {
  Drupal.behaviors.tonicEditForm = {
    attach: (context) => {
      once('tonicEditForm', '.region-content form.tonic-node-edit-form', context).forEach(form => {
        const sticky = context.querySelector('.tonic-sticky');
        const newParent = context.querySelector('.region-sticky__items__inner');

        if (newParent && newParent.querySelectorAll('.tonic-sticky').length === 0) {
          newParent.appendChild(sticky);

          // Attach form elements to main form
          const actionButtons = newParent.querySelectorAll('button, input, select, textarea');

          if (actionButtons.length > 0) {
            actionButtons.forEach((el) => {
              el.setAttribute('form', form.getAttribute('id'));
              el.setAttribute('id', el.getAttribute('id') + '--tonic-edit-form');
            });
          }
        }
      });
    }
  };
})(Drupal);
