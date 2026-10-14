((Backdrop, once, _ref) => {
  let {computePosition, offset, shift, flip} = _ref;
  Backdrop.theme.ginTooltipWrapper = (dataset, title) => {
    const el = document.createElement("div");
    return el.classList.add("gin-tooltip"), dataset.backdropTooltipClass && dataset.backdropTooltipClass.split(/\s+/).filter((token => "" !== token)).forEach((token => {
      el.classList.add(token);
    })), el.textContent = dataset.drupalTooltip || title || "", el;
  }, Backdrop.behaviors.ginTooltip = {
    attach: context => {
      Backdrop.ginTooltip.init(context);
    }
  }, Backdrop.ginTooltip = {
    init: function(context) {
      once("ginTooltipInit", "[data-gin-tooltip]", context).forEach((trigger => {
        const title = trigger.title;
        title && (trigger.title = ""), trigger.insertAdjacentElement("afterend", Backdrop.theme.ginTooltipWrapper(trigger.dataset, title));
        const tooltip = trigger.nextElementSibling, updatePosition = () => {
          this.computePosition(trigger, tooltip);
        };
        new ResizeObserver(updatePosition).observe(trigger), new MutationObserver(updatePosition).observe(trigger, {
          attributes: !0,
          childList: !0,
          subtree: !0
        }), trigger.addEventListener("mouseover", updatePosition), trigger.addEventListener("focus", updatePosition);
      }));
    },
    computePosition: function(trigger, tooltip) {
      let placement = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : "bottom-end";
      computePosition(trigger, tooltip, {
        strategy: "absolute",
        placement: trigger.dataset.drupalTooltipPosition || placement,
        middleware: [ flip({
          padding: 16
        }), offset(6), shift({
          padding: 16
        }) ]
      }).then((_ref2 => {
        let {x, y} = _ref2;
        Object.assign(tooltip.style, {
          "inset-inline-start": `${x}px`,
          "inset-block-start": `${y}px`
        });
      }));
    }
  };
})(Backdrop, once, FloatingUIDOM);
