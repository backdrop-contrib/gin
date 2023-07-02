<?php

/**
 * @file
 * messages.php
 */

/**
 * Returns HTML for status and/or error messages, grouped by type.
 *
 * An invisible heading identifies the messages for assistive technology.
 * Sighted users see a colored box. See http://www.w3.org/TR/WCAG-TECHS/H69.html
 * for info.
 *
 * @param $variables
 *   An associative array containing:
 *   - display: (optional) Set to 'status' or 'error' to display only messages
 *     of that type.
 */
function gin_status_messages($variables) {
  $display = $variables['display'];
  $message_types = (empty($variables['messages']))? backdrop_get_messages($display) : $variables['messages'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
    'info' => t('Info message'),
  );

  foreach ($message_types as $type => $messages) {
    $output .= "<div class=\"messages messages--$type\">\n";
    if (!empty($status_heading[$type])) {
      $output .= '  <h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= "  <ul>\n";
      foreach ($messages as $message) {
        $output .= '    <li>' . $message . "</li>\n";
      }
      $output .= "  </ul>\n";
    }
    else {
      $output .= "<div class=\"messages__header\">\n<div class=\"messages__content\">" . reset($messages) . "</div>\n</div>\n";
    }
    if (config_get('system.core', 'messages_dismissible')) {
      // Add the 'Dismiss' library and place a 'Dismiss' link on messages.
      backdrop_add_library('system', 'backdrop.dismiss');
      $output .= '<a href="#" class="button button--dismiss dismiss" title="' . t('Dismiss') . '"><span class="icon-close">' . t('Dismiss') . '</span></a>' . "\n";
    }
    $output .= "</div>\n";
  }

  return $output;
}
