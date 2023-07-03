((Backdrop, once) => {
  Backdrop.behaviors.ginSticky = {
    attach: () => {
      once("ginSticky", ".region-sticky-watcher").forEach((() => {
        const observer = new IntersectionObserver((_ref => {
          let [e] = _ref;
          document.querySelector(".region-sticky").classList.toggle("region-sticky--is-sticky", e.intersectionRatio < 1);
        }), {
          threshold: [ 1 ]
        }), element = document.querySelector(".region-sticky-watcher");
        element && observer.observe(element);
      }));
    }
  };
})(Backdrop, once);