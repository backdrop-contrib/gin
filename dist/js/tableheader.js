((Backdrop, once) => {
  Backdrop.behaviors.ginTableHeader = {
    attach: context => {
      Backdrop.ginTableHeader.init(context);
    }
  }, Backdrop.ginTableHeader = {
    init: function(context) {
      once("ginTableHeader", ".sticky-enabled", context).forEach((el => {
        new IntersectionObserver((_ref => {
          let [e] = _ref;
          context.querySelector(".gin-table-scroll-wrapper") && (e.isIntersecting || e.intersectionRect.top !== Backdrop.displace.offsets.top ? context.querySelector(".gin-table-scroll-wrapper").classList.remove("--is-sticky") : context.querySelector(".gin-table-scroll-wrapper").classList.add("--is-sticky"), 
          Backdrop.displace(!0));
        }), {
          threshold: 1,
          rootMargin: `-${Backdrop.displace.offsets.top}px 0px 0px 0px`
        }).observe(el.querySelector("thead"));
      }));
    }
  };
})(Backdrop, once);