/**
 * @file
 * Table select functionality.
 */

(function ($, Backdrop) {
  /**
   * Initialize tableSelects.
   *
   * @type {Backdrop~behavior}
   *
   * @prop {Backdrop~behaviorAttach} attach
   *   Attaches tableSelect functionality.
   */
  Backdrop.behaviors.tableSelect = {
    attach(context, settings) {
      // Select the inner-most table in case of nested tables.
      once(
        'table-select',
        $(context).find('th.select-all').closest('table'),
      ).forEach((table) => Backdrop.tableSelect.call(table));
    },
  };

  /**
   * Callback used in {@link Backdrop.behaviors.tableSelect}.
   */
  Backdrop.tableSelect = function () {
    // Do not add a "Select all" checkbox if there are no rows with checkboxes
    // in the table.
    if ($(this).find('td input[type="checkbox"]').length === 0) {
      return;
    }

    // Keep track of the table, which checkbox is checked and alias the
    // settings.
    const table = this;
    let checkboxes;
    let lastChecked;

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

    const $table = $(table);
    const strings = {
      selectAll: Backdrop.t('Select all rows in this table'),
      selectNone: Backdrop.t('Deselect all rows in this table'),
    };
    const updateSelectAll = function (state) {
      // Update table's select-all checkbox (and sticky headers if available).
      $table
        .parents('.gin-table-scroll-wrapper')
        .prev('table.sticky-header')
        .addBack()
        .find('th.select-all input[type="checkbox"]')
        .each(function () {
          const $checkbox = $(this);
          const stateChanged = $checkbox.prop('checked') !== state;

          $checkbox.attr(
            'title',
            state ? strings.selectNone : strings.selectAll,
          );

          /**
           * @checkbox {HTMLElement}
           */
          if (stateChanged) {
            $checkbox.prop('checked', state).trigger('change');

            // Update status in Gin sticky table header.
            $table
              .parents('.gin-table-scroll-wrapper')
              .prev('table.gin--sticky-table-header')
              .find('th.select-all input[type="checkbox"]')
              .prop('checked', state);
          }
        });
    };

    // Gin: Check if select-all already exists, if not add it.
    if ($table.find('th.select-all').find('input[type="checkbox"]').length === 0) {
      $table.find('th.select-all').prepend($('<input type="checkbox" class="form-checkbox" />').attr('title', strings.selectAll));
    }

    // Find all <th> with class select-all, and insert the check all checkbox.
    $table
      .find('th.select-all input[type="checkbox"]')
      .on('click', (event) => {
        if (event.target.matches('input[type="checkbox"]')) {
          // Loop through all checkboxes and set their state to the select all
          // checkbox' state.
          checkboxes.each(function () {
            const $checkbox = $(this);
            const stateChanged =
              $checkbox.prop('checked') !== event.target.checked;

            /**
             * @checkbox {HTMLElement}
             */
            if (stateChanged) {
              $checkbox.prop('checked', event.target.checked).trigger('change');
            }
            // Either add or remove the selected class based on the state of the
            // check all checkbox.

            /**
             * @checkbox {HTMLElement}
             */
            $checkbox.closest('tr').toggleClass('selected', this.checked);
          });
          // Update the title and the state of the check all box.
          updateSelectAll(event.target.checked);
          updateSticky(
            checkboxes.filter(':checked').length > 0,
          );
        }
      });

    // For each of the checkboxes within the table that are not disabled.
    checkboxes = $table
      .find('td input[type="checkbox"]:enabled')
      .on('click', function (e) {
        // Either add or remove the selected class based on the state of the
        // check all checkbox.

        /**
         * @this {HTMLElement}
         */
        $(this).closest('tr').toggleClass('selected', this.checked);

        // If this is a shift click, we need to highlight everything in the
        // range. Also make sure that we are actually checking checkboxes
        // over a range and that a checkbox has been checked or unchecked before.
        if (e.shiftKey && lastChecked && lastChecked !== e.target) {
          // We use the checkbox's parent <tr> to do our range searching.
          Backdrop.tableSelectRange(
            $(e.target).closest('tr')[0],
            $(lastChecked).closest('tr')[0],
            e.target.checked,
          );
        }

        // If all checkboxes are checked, make sure the select-all one is checked
        // too, otherwise keep unchecked.
        updateSelectAll(
          checkboxes.length === checkboxes.filter(':checked').length,
        );
        // Update sticky actions.
        updateSticky(
          checkboxes.filter(':checked').length > 0,
        );

        // Keep track of the last checked checkbox.
        lastChecked = e.target;
      });

    // If all checkboxes are checked on page load, make sure the select-all one
    // is checked too, otherwise keep unchecked.
    updateSelectAll(checkboxes.length === checkboxes.filter(':checked').length);
    // Update sticky actions.
    updateSticky(checkboxes.filter(':checked').length > 0);
  };

  /**
   * @param {HTMLElement} from
   *   The HTML element representing the "from" part of the range.
   * @param {HTMLElement} to
   *   The HTML element representing the "to" part of the range.
   * @param {boolean} state
   *   The state to set on the range.
   */
  Backdrop.tableSelectRange = function (from, to, state) {
    // We determine the looping mode based on the order of from and to.
    const mode =
      from.rowIndex > to.rowIndex ? 'previousSibling' : 'nextSibling';

    // Traverse through the sibling nodes.
    for (let i = from[mode]; i; i = i[mode]) {
      const $i = $(i);
      // Make sure that we're only dealing with elements.
      if (i.nodeType !== 1) {
        continue;
      }
      // Either add or remove the selected class based on the state of the
      // target checkbox.
      $i.toggleClass('selected', state);
      $i.find('input[type="checkbox"]').prop('checked', state);

      if (to.nodeType) {
        // If we are at the end of the range, stop.
        if (i === to) {
          break;
        }
      }
      // A faster alternative to doing $(i).filter(to).length.
      else if ($.filter(to, [i]).r.length) {
        break;
      }
    }
  };
})(jQuery, Backdrop);
