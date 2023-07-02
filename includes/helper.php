<?php

/**
 * @file
 * helper.php
 */

/**
 * Accent color element.
 */
function _gin_accent_radios($element) {
  $options = array_keys($element['#options']);

  foreach ($options as $values) {
    $element[$values]['#attributes']['data-gin-accent'] = $element[$values]['#return_value'];
  }

  return $element;
}

/**
 * Toolbar element.
 */
function _gin_toolbar_radios($element) {
  $options = array_keys($element['#options']);

  $element['#attributes']['class'][] = 'toolbar-option';

  foreach ($options as $values) {
    $element[$values]['#attributes']['class'][] = 'toolbar-option__' . $element[$values]['#return_value'];
    $element[$values]['#attributes']['data-gin-toolbar'] = $element[$values]['#return_value'];
  }

  return $element;
}

/**
 * Helper function for check if Gin is active.
 */
function _gin_is_active() {
  $admin_theme = config_get('system.core', 'admin_theme');

  // Check if set as admin theme.
  if ($admin_theme === 'gin') {
    return true;
  }

  return false;
}
