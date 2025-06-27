((Backdrop, once) => {
  Backdrop.behaviors.ginTableHeader = {
    attach: context => {
      Backdrop.ginTableHeader.init(context);
    }
  }, Backdrop.ginTableHeader = {
    init: function(context) {
      once("ginTableHeaderSticky", ".sticky-enabled", context).forEach((el => {
        this.updateTableHeader(el), this.showTableHeaderOnInit(), new ResizeObserver((() => {
          Backdrop.debounce(this.updateTableHeader(el), 150);
        })).observe(el), document.querySelectorAll('.gin--sticky-bulk-select > input[type="checkbox"]').forEach((checkbox => {
          checkbox.addEventListener("click", (event => {
            event.stopImmediatePropagation(), event.checked = !event.checked, document.querySelector(".gin-table-scroll-wrapper table.sticky-enabled thead .select-all > input, .gin-table-scroll-wrapper table.sticky-header thead .select-all > input").click();
          }));
        }));
      }));
    },
    showTableHeaderOnInit: function() {
      const tableHeader = document.querySelector(".gin--sticky-table-header");
      tableHeader && (tableHeader.hidden = !1, tableHeader.style.display = "block", tableHeader.style.visibility = "visible", 
      document.body.style.overflowX = "hidden");
    },
    updateTableHeader: function(el) {
      const tableHeader = document.querySelector(".gin--sticky-table-header");
      if (!tableHeader) return;
      const offset = el.classList.contains("sticky-enabled") ? -7 : 1;
      tableHeader.style.marginBottom = `-${el.querySelector("thead").getBoundingClientRect().height + offset}px`, 
      el.classList.add("--is-processed"), tableHeader.querySelectorAll("thead th").forEach(((th, index) => {
        th.style.width = `${el.querySelectorAll("thead th")[index].getBoundingClientRect().width}px`;
      }));
    }
  };
})(Backdrop, once);