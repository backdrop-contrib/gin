/* eslint-disable no-bitwise, no-nested-ternary, no-mutable-exports, comma-dangle, strict */

'use strict';

((Backdrop) => {
  Backdrop.behaviors.ginSticky = {
    attach: (context) => {
      const ginSticky = once('ginSticky', document.querySelectorAll('.region-sticky-watcher'));
      ginSticky.forEach(() => {
        // Watch sticky header
        const observer = new IntersectionObserver(
          ([e]) => {
            const regionSticky = context.querySelector('.region-sticky');
            regionSticky.classList.toggle('region-sticky--is-sticky', e.intersectionRatio < 1);
          },
          { threshold: [1] }
        );
        const element = context.querySelector('.region-sticky-watcher');
        if (element) {
          observer.observe(element);
        }
      });
    }
  };
})(Backdrop);
