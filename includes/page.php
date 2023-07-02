<?php

/**
 * @file
 * page.php
 */

/**
 * Implements hook_preprocess_page().
 */
function gin_preprocess_page(&$variables) {
  // Are we relevant?
  $gin_activated = _gin_is_active();

  if (!$gin_activated) {
    return;
  }

  // Performance: Skip this entirely for AJAX requests.
  if (!backdrop_is_html()) {
    return;
  }

  $variables['html_classes'] = [];
  $config = config('gin.settings');
  $basethemeurl = backdrop_get_path('theme', 'gin');

  // Darkmode
  if (theme_get_setting('enable_darkmode')) {
    $variables['html_classes'][] = 'gin--dark-mode';
  }

  // Set accent color.
  $variables['body_attributes']['data-gin-accent'] =  theme_get_setting('preset_accent_color');

  // Set focus color.
  $variables['body_attributes']['data-gin-focus'] = theme_get_setting('preset_focus_color');

  // High contrast mode.
  if (theme_get_setting('high_contrast_mode')) {
    $variables['classes'][] = 'gin--high-contrast-mode';
  }

  // Set layout density.
  $variables['body_attributes']['data-gin-layout-density'] = theme_get_setting('layout_density');

  // Set toolbar class.
  // $toolbar = theme_get_setting('classic_toolbar');
  // $variables['classes'][] = 'gin--' . $toolbar . '-toolbar';
  $variables['classes'][] = 'gin--horizontal-toolbar';

  // $drupal_version = (float) Drupal::VERSION;

  backdrop_add_library('gin', 'init');
  backdrop_add_library('gin', 'accent');
  backdrop_add_library('gin', 'sticky');
  // backdrop_add_library('gin', 'messages');
  backdrop_add_library('gin', 'tableselect');

  // Modules
  if (module_exists('dashboard')) {
    backdrop_add_library('gin', 'dashboard');
  }
  if (module_exists('paragraphs')) {
    backdrop_add_library('gin', 'paragraphs');
  }
  if (module_exists('coffee')) {
    backdrop_add_library('gin', 'coffee');
  }
  if (module_exists('node_preview')) {
    backdrop_add_library('gin', 'node_preview');
  }
  if (module_exists('webform')) {
    backdrop_add_library('gin', 'webform');
  }
  if (module_exists('module_filter')) {
    backdrop_add_library('gin', 'module_filter');
  }
  if (module_exists('chosen')) {
    backdrop_add_library('gin', 'chosen');
  }
  if (module_exists('inline_entity_form')) {
    backdrop_add_library('gin', 'inline_entity_form');
  }

  $options = array('every_page' => TRUE);
  backdrop_add_css($basethemeurl . '/dist/css/layout/gin_admin_bar.css', $options);

  // Custom CSS file.
  // if (file_exists('public://gin-custom.css')) {
  //   $page['#attached']['library'][] = 'gin/gin_custom_css';
  // }

  // Expose settings to JS.
  $settings['darkmode'] = $config->get('enable_darkmode');
  $settings['darkmode_class'] = 'gin--dark-mode';
  $settings['preset_accent_color'] = $config->get('preset_accent_color');
  $settings['accent_color'] = $config->get('accent_color');
  $settings['preset_focus_color'] = $config->get('preset_focus_color');
  $settings['focus_color'] = $config->get('focus_color');
  $settings['highcontrastmode'] = $config->get('high_contrast_mode');
  $settings['highcontrastmode_class'] = 'gin--high-contrast-mode';
  $settings['toolbar_variant'] = $config->get('classic_toolbar');

  // Expose stylesheets to JS.
  $settings['variables_css_path'] = $basethemeurl . '/dist/css/theme/variables.css';
  $settings['accent_css_path'] = $basethemeurl . '/dist/css/theme/accent.css';
  $settings['ckeditor_css_path'] = $basethemeurl . '/dist/css/theme/ckeditor.css';

  backdrop_add_js(array('gin' => $settings), 'setting');
}
