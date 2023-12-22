((Backdrop, once) => {
  Backdrop.behaviors.ginTableHeader = {
    attach: (context) => {
      Backdrop.ginTableHeader.init(context);
    },
  };

  Backdrop.ginTableHeader = {
    init: function (context) {
      once('ginTableHeader', '.sticky-enabled', context).forEach(el => {
        // Watch sticky table header.
        const observer = new IntersectionObserver(
          ([e]) => {
            if (context.querySelector('.gin-table-scroll-wrapper')) {
              if (!e.isIntersecting && e.intersectionRect.top === Backdrop.displace.offsets.top) {
                context.querySelector('.gin-table-scroll-wrapper').classList.add('--is-sticky');
              } else {
                context.querySelector('.gin-table-scroll-wrapper').classList.remove('--is-sticky');
              }

              Backdrop.displace(true);
            }
          },
          { threshold: 1.0, rootMargin: `-${Backdrop.displace.offsets.top}px 0px 0px 0px` }
        );
        observer.observe(el.querySelector('thead'));
      });
    },

  };

})(Backdrop, once);
