<?php
/**
 * @file
 * Shared Gin functions that can be included in (for example) Tonic.
 */

/**
 * Helper function to get an array of Gin libraries for particular modules. This
 * is used to define the libraries and also to process them for addition when
 * modules are detected as active. There is an added 'module' key to make it
 * easy to check against active modules, which don't share the same namespace
 * as the libraries.
 */
function gin_get_module_libraries() {
  $basethemeurl = backdrop_get_path('theme', 'gin');
  $css_options = [
    'type' => 'file',
    'media' => 'screen',
    'weight' => 999,
    'group' => CSS_THEME,
  ];
  return [
    'gin_admin_bar' => [
      'title' => 'Admin Bar',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/layout/gin_admin_bar.css' => $css_options,
      ],
      'module' => 'admin_bar',
    ],
    'gin_chosen' => [
      'title' => 'Chosen',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_chosen.css' => $css_options,
      ],
      'module' => 'chosen',
    ],
    'gin_civicrm' => [
      'title' => 'CiviCRM',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_civicrm.css' => $css_options,
      ],
      'module' => 'civicrm',
    ],
    'gin_ckeditor' => [
      'title' => 'CKEditor',
      'version' => BACKDROP_VERSION,
      'js' => [
        $basethemeurl . '/dist/js/ckeditor.js' => ['weight' => 0],
      ],
      'css' => [
        $basethemeurl . '/dist/css/components/ckeditor.css' => $css_options,
      ],
      'dependencies' => [
        ['gin', 'gin_once'],
      ],
      'module' => 'ckeditor',
    ],
    'gin_ckeditor5' => [
      'title' => 'CKEditor 5',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_ckeditor5.css' => $css_options,
      ],
      'module' => 'ckeditor5',
    ],
    'gin_coffee' => [
      'title' => 'Coffee',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_coffee.css' => $css_options,
      ],
      'module' => 'coffee',
    ],
    'gin_dashboard' => [
      'title' => 'Dashboard',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_dashboard.css' => $css_options,
      ],
      'module' => 'dashboard',
    ],
    'gin_devel' => [
      'title' => 'Devel',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_devel.css' => $css_options,
      ],
      'module' => 'devel',
    ],
    'gin_inline_entity_form' => [
      'title' => 'Inline entity form',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/inline_entity_form.css' => $css_options,
      ],
      'module' => 'inline_entity_form',
    ],
    'project_installer' => [
      'title' => 'Project Installer',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/project_installer.css' => $css_options,
      ],
      'module' => 'installer',
    ],
    'gin_layout_paragraphs' => [
      'title' => 'Layout Paragraphs',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_layout_paragraphs.css' => $css_options,
      ],
      'module' => 'layout_paragraphs',
    ],
    'gin_module_filter' => [
      'title' => 'Module filter',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/module_filter.css' => $css_options,
      ],
      'module' => 'module_filter',
    ],
    'gin_paragraphs' => [
      'title' => 'Paragraphs',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_paragraphs.css' => $css_options,
      ],
      'module' => 'paragraphs',
    ],
    'gin_references_dialog' => [
      'title' => 'References Dialog',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_references_dialog.css' => $css_options,
      ],
      'icons' => [
        'plus',
        'magnifying-glass',
        'pencil-fill',
      ],
      'module' => 'references_dialog',
    ],
    'gin_select2' => [
      'title' => 'Select2',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_select2.css' => $css_options,
      ],
      'module' => 'select2',
    ],
    'gin_simplei' => [
      'title' => 'Simple Environment Indicator',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_simplei.css' => $css_options,
      ],
      'module' => 'simplei',
    ],
    'gin_simpletest' => [
      'title' => 'Simpletest',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_simpletest.css' => $css_options,
      ],
      'module' => 'simpletest',
    ],
    'gin_taxonomy_manager' => [
      'title' => 'Taxonomy Manager',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_taxonomy_manager.css' => $css_options,
      ],
      'module' => 'taxonomy_manager',
    ],
    'gin_webform' => [
      'title' => 'Webform',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/webform.css' => $css_options,
      ],
      'module' => 'webform',
    ],
  ];
}

/**
 * Helper function to activate Gin libraries for enabled modules.
 */
function gin_add_module_libraries() {
  $module_libraries = gin_get_module_libraries();

  foreach ($module_libraries as $library => $library_info) {
    if (module_exists($library_info['module'])) {
      backdrop_add_library('gin', $library);
    }
  }
}
