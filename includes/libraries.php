<?php

/**
 * @file
 * libraries.php
 */


/**
 * Implements hook_library_info().
 */
function gin_library_info() {
  $basethemeurl = backdrop_get_path('theme', 'gin');

  $libraries['gin'] = array(
    'title' => 'Default',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/base/gin.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'gin_base'),
    ),
  );

  $libraries['gin_base'] = array(
    'title' => 'Base',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/theme/font.css' => array(),
      $basethemeurl . '/dist/css/theme/variables.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'gin_tabs'),
      array('gin', 'gin_dialog'),
    ),
  );

  $libraries['gin_init'] = array(
    'title' => 'Init',
    'version' => BACKDROP_VERSION,
    'header' => TRUE,
    'js' => array(
      $basethemeurl . '/dist/js/init.js' => array(),
    ),
  );

  // #########################
  //
  // TODO:
  // Add Toolbar library here.
  //
  // #########################

  $libraries['gin_accent'] = array(
    'title' => 'Accent',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/dist/js/accent.js' => array(),
    ),
    'css' => array(
      $basethemeurl . '/dist/css/theme/accent.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'gin_once'),
    ),
  );

  $libraries['gin_dialog'] = array(
    'title' => 'Dialog',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/gin_dialog.css' => array(),
      $basethemeurl . '/dist/css/theme/dialog.css' => array(),
    ),
  );

  $libraries['gin_description_toggle'] = array(
    'title' => 'Description Toggle',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/description_toggle.css' => array(),
    ),
    'js' => array(
      $basethemeurl . '/dist/js/description_toggle.js' => array(),
    ),
    'dependencies' => array(
      array('gin', 'gin_base'),
      array('gin', 'gin_accent'),
    ),
  );

  // #########################
  //
  // TODO:
  // Add Custom CSS library here.
  //
  // #########################

  $libraries['gin_once'] = array(
    'title' => 'Once',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/js/libs/once.js' => array('weight' => -1),
    ),
  );

  $libraries['gin_sticky'] = array(
    'title' => 'Sticky',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/dist/js/sticky.js' => array(),
    ),
    'dependencies' => array(
      array('gin', 'gin_once'),
    ),
  );

  $libraries['gin_sidebar'] = array(
    'title' => 'Sidebar',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/dist/js/sidebar.js' => array(),
    ),
    'css' => array(
      $basethemeurl . '/dist/css/components/sidebar.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'gin_once'),
    ),
  );

  $libraries['gin_settings'] = array(
    'title' => 'Settings',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/dist/js/settings.js' => array(),
    ),
    'css' => array(
      $basethemeurl . '/dist/css/components/settings.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'gin_once'),
    ),
  );

  # Components

  $libraries['gin_dashboard'] = array(
    'title' => 'Dashboard',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/gin_dashboard.css' => array(),
    ),
  );

  $libraries['gin_tabs'] = array(
    'title' => 'Tabs',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/tabs.css' => array(),
    ),
  );

  $libraries['gin_tableselect'] = array(
    'title' => 'Tableselect',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/js/overrides/tableselect.js' => array(),
    ),
    'css' => array(
      $basethemeurl . '/dist/css/components/tableselect.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'gin_once'),
    ),
  );

  $libraries['gin_edit_form'] = array(
    'title' => 'Edit form',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/dist/js/edit_form.js' => array(),
    ),
    'css' => array(
      $basethemeurl . '/dist/css/components/edit_form.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'gin_once'),
    ),
  );

  $libraries['gin_contextual_links'] = array(
    'title' => 'Contextual links',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/contextual_links.css' => array(),
    ),
  );

  $libraries['gin_ckeditor'] = array(
    'title' => 'CKEditor',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/dist/js/ckeditor.js' => array('weight' => 0),
    ),
    'css' => array(
      $basethemeurl . '/dist/css/components/ckeditor.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'gin_once'),
    ),
  );

  $libraries['gin_ckeditor5'] = array(
    'title' => 'CKEditor5',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/ckeditor5.css' => array(),
    ),
  );

  $libraries['gin_ajax'] = array(
    'title' => 'Ajax',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/ajax.css' => array(),
    ),
  );

  $libraries['gin_revisions'] = array(
    'title' => 'Revisions',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/revisions.css' => array(),
    ),
  );

  $libraries['gin_autocomplete'] = array(
    'title' => 'Autocomplete',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/autocomplete.css' => array(),
    ),
  );

  $libraries['gin_breadcrumb'] = array(
    'title' => 'Breadcrumb',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/breadcrumb.css' => array(),
    ),
  );

  $libraries['gin_coffee'] = array(
    'title' => 'Coffee',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/coffee.css' => array(),
    ),
  );

  $libraries['gin_node_preview'] = array(
    'title' => 'Node preview',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/node_preview.css' => array(),
    ),
  );

  # Modules

  $libraries['gin_paragraphs'] = array(
    'title' => 'Paragraphs',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/paragraphs.css' => array(),
    ),
  );

  $libraries['gin_webform'] = array(
    'title' => 'Webform',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/webform.css' => array(),
    ),
  );

  $libraries['gin_module_filter'] = array(
    'title' => 'Module filter',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/module_filter.css' => array(),
    ),
  );

  $libraries['gin_chosen'] = array(
    'title' => 'Chosen',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/chosenjs.css' => array(),
    ),
  );

  $libraries['gin_inline_entity_form'] = array(
    'title' => 'Inline entity form',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/inline_entity_form.css' => array(),
    ),
  );

  return $libraries;

}
