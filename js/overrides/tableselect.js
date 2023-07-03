((Backdrop, once) => {
  Backdrop.behaviors.ginTableSelect = {
    attach: () => {
      once('tableSelect', 'th.select-all').forEach((el) => {
        if (el.closest('table')) {
          Backdrop.ginTableSelect(el);
        }
      });
    },
  };

  Backdrop.ginTableSelect = (el) => {
    const table = el.closest('table');

    if (table.querySelector('td input[type="checkbox"]') === null) {
      return;
    }

    const setClass = 'is-sticky';
    const stickyHeader = table
      .closest('form')
      .querySelector('.views-bulk-form');

    const updateSticky = (state) => {
      if (stickyHeader) {
        if (state === true) {
          stickyHeader.classList.add(setClass);
        }
        else {
          stickyHeader.classList.remove(setClass);
        }
      }
    };

    // Watch select-all
    el.addEventListener('change', () => {
      const selectedItems = Boolean(table.querySelectorAll('td input[type="checkbox"]:checked').length);
      updateSticky(selectedItems);
    });

    // Watch items
    table.querySelectorAll('td input[type="checkbox"]').forEach(item => {
      item.addEventListener('change', () => {
        const selectedItems = Boolean(table.querySelectorAll('td input[type="checkbox"]:checked').length);
        updateSticky(selectedItems);
        item.closest('tr').classList.toggle('selected');
      });
    });
  };

})(Backdrop, once);
