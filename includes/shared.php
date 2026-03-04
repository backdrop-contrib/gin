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
  return [
    'gin_admin_bar' => [
      'title' => 'Admin Bar',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/layout/gin_admin_bar.css' => [],
      ],
      'module' => 'admin_bar',
    ],
    'gin_chosen' => [
      'title' => 'Chosen',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_chosen.css' => [],
      ],
      'module' => 'chosen',
    ],
    'gin_civicrm' => [
      'title' => 'CiviCRM',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_civicrm.css' => [
          'type' => 'file',
          'media' => 'screen',
        ],
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
        $basethemeurl . '/dist/css/components/ckeditor.css' => [],
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
        $basethemeurl . '/dist/css/components/gin_ckeditor5.css' => [],
      ],
      'module' => 'ckeditor5',
    ],
    'gin_coffee' => [
      'title' => 'Coffee',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_coffee.css' => [
          'type' => 'file',
          'media' => 'screen',
        ],
      ],
      'module' => 'coffee',
    ],
    'gin_dashboard' => [
      'title' => 'Dashboard',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_dashboard.css' => [],
      ],
      'module' => 'dashboard',
    ],
    'gin_devel' => [
      'title' => 'Devel',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_devel.css' => [
          'type' => 'file',
          'media' => 'screen',
        ],
      ],
      'module' => 'devel',
    ],
    'gin_inline_entity_form' => [
      'title' => 'Inline entity form',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/inline_entity_form.css' => [],
      ],
      'module' => 'inline_entity_form',
    ],
    'project_installer' => [
      'title' => 'Project Installer',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/project_installer.css' => [],
      ],
      'module' => 'installer',
    ],
    'gin_layout_paragraphs' => [
      'title' => 'Layout Paragraphs',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_layout_paragraphs.css' => [],
      ],
      'module' => 'layout_paragraphs',
    ],
    'gin_module_filter' => [
      'title' => 'Module filter',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/module_filter.css' => [],
      ],
      'module' => 'module_filter',
    ],
    'gin_paragraphs' => [
      'title' => 'Paragraphs',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_paragraphs.css' => [],
      ],
      'module' => 'paragraphs',
    ],
    'gin_references_dialog' => [
      'title' => 'References Dialog',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_references_dialog.css' => [],
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
        $basethemeurl . '/dist/css/components/gin_select2.css' => [],
      ],
      'module' => 'select2',
    ],
    'gin_simplei' => [
      'title' => 'Simple Environment Indicator',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_simplei.css' => [],
      ],
      'module' => 'simplei',
    ],
    'gin_taxonomy_manager' => [
      'title' => 'Taxonomy Manager',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/gin_taxonomy_manager.css' => [],
      ],
      'module' => 'taxonomy_manager',
    ],
    'gin_webform' => [
      'title' => 'Webform',
      'version' => BACKDROP_VERSION,
      'css' => [
        $basethemeurl . '/dist/css/components/webform.css' => [],
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
