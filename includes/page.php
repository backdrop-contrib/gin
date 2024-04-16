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

  // Node add or edit.
  if (theme_get_setting('edit_form_sidebar', 'gin') || (arg(0) == 'node' && (arg(1) == 'add' || arg(2) == 'edit'))) {
    $variables['classes'][] = 'gin--edit-form';
  }

  backdrop_add_library('gin', 'gin_init');
  backdrop_add_library('gin', 'gin_accent');
  backdrop_add_library('gin', 'gin_sticky');
  backdrop_add_library('gin', 'gin_tableselect');

  $module_libraries = [
    'dashboard' => 'gin_dashboard',
    'ckeditor' => 'gin_ckeditor',
    'ckeditor5' => 'gin_ckeditor5',
    'coffee' => 'gin_coffee',
    'node_preview' => 'gin_node_preview',
    'webform' => 'gin_webform',
    'module_filter' => 'gin_module_filter',
    'chosen' => 'gin_chosen',
    'inline_entity_form' => 'gin_inline_entity_form',
    'installer' => 'project_installer',
    'paragraphs' => 'gin_paragraphs',
    'admin_bar' => 'gin_admin_bar',
  ];

  foreach ($module_libraries as $module => $library) {
    if (module_exists($module)) {
      backdrop_add_library('gin', $library);
    }
  }

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

  // Expose paths to JS.
  $settings['current_path'] = current_path();
  $settings['variables_css_path'] = $basethemeurl . '/dist/css/theme/variables.css';
  $settings['accent_css_path'] = $basethemeurl . '/dist/css/theme/accent.css';
  $settings['ckeditor_css_path'] = $basethemeurl . '/dist/css/theme/ckeditor.css';

  backdrop_add_js(array('gin' => $settings), 'setting');
}
