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
      array('gin', 'base'),
    ),
  );

  $libraries['base'] = array(
    'title' => 'Base',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/theme/font.css' => array(),
      $basethemeurl . '/dist/css/theme/variables.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'tabs'),
      array('gin', 'dialog'),
    ),
  );

  $libraries['init'] = array(
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

  $libraries['accent'] = array(
    'title' => 'Accent',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/dist/js/accent.js' => array(),
    ),
    'css' => array(
      $basethemeurl . '/dist/css/theme/accent.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'once'),
    ),
  );

  $libraries['dialog'] = array(
    'title' => 'Dialog',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/theme/dialog.css' => array(),
      $basethemeurl . '/dist/css/components/dialog.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'base'),
      array('gin', 'accent'),
    ),
  );

  $libraries['description_toggle'] = array(
    'title' => 'Description Toggle',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/description_toggle.css' => array(),
    ),
    'js' => array(
      $basethemeurl . '/dist/js/description_toggle.js' => array(),
    ),
    'dependencies' => array(
      array('gin', 'base'),
      array('gin', 'accent'),
    ),
  );

  // #########################
  //
  // TODO:
  // Add Custom CSS library here.
  //
  // #########################

  $libraries['once'] = array(
    'title' => 'Once',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/js/libs/once.js' => array(),
    ),
  );

  $libraries['sticky'] = array(
    'title' => 'Sticky',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/dist/js/sticky.js' => array(),
    ),
  );

  $libraries['sidebar'] = array(
    'title' => 'Sidebar',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/dist/js/sidebar.js' => array(),
    ),
    'css' => array(
      $basethemeurl . '/dist/css/components/sidebar.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'once'),
    ),
  );

  $libraries['settings'] = array(
    'title' => 'Settings',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/dist/js/settings.js' => array(),
    ),
    'css' => array(
      $basethemeurl . '/dist/css/components/settings.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'once'),
    ),
  );

  # Components

  $libraries['dashboard'] = array(
    'title' => 'Dashboard',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/gin_dashboard.css' => array(),
    ),
  );

  $libraries['tabs'] = array(
    'title' => 'Tabs',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/tabs.css' => array(),
    ),
  );

  $libraries['tableselect'] = array(
    'title' => 'Tableselect',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/js/overrides/tableselect.js' => array(),
    ),
    'css' => array(
      $basethemeurl . '/dist/css/components/tableselect.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'once'),
    ),
  );

  $libraries['edit_form'] = array(
    'title' => 'Edit form',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/dist/js/edit_form.js' => array(),
    ),
    'css' => array(
      $basethemeurl . '/dist/css/components/edit_form.css' => array(),
    ),
  );

  $libraries['contextual_links'] = array(
    'title' => 'Contextual links',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/contextual_links.css' => array(),
    ),
  );

  $libraries['ckeditor'] = array(
    'title' => 'CKEditor',
    'version' => BACKDROP_VERSION,
    'js' => array(
      $basethemeurl . '/dist/js/gin_ckeditor.js' => array(),
    ),
    'css' => array(
      $basethemeurl . '/dist/css/components/ckeditor.css' => array(),
    ),
    'dependencies' => array(
      array('gin', 'once'),
    ),
  );

  $libraries['ajax'] = array(
    'title' => 'Ajax',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/ajax.css' => array(),
    ),
  );

  $libraries['revisions'] = array(
    'title' => 'Revisions',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/revisions.css' => array(),
    ),
  );

  $libraries['autocomplete'] = array(
    'title' => 'Autocomplete',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/autocomplete.css' => array(),
    ),
  );

  $libraries['breadcrumb'] = array(
    'title' => 'Breadcrumb',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/breadcrumb.css' => array(),
    ),
  );

  $libraries['coffee'] = array(
    'title' => 'Coffee',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/coffee.css' => array(),
    ),
  );

  $libraries['node_preview'] = array(
    'title' => 'Node preview',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/node_preview.css' => array(),
    ),
  );

  # Modules

  $libraries['paragraphs'] = array(
    'title' => 'Paragraphs',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/paragraphs.css' => array(),
    ),
  );

  $libraries['webform'] = array(
    'title' => 'Webform',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/webform.css' => array(),
    ),
  );

  $libraries['module_filter'] = array(
    'title' => 'Module filter',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/module_filter.css' => array(),
    ),
  );

  $libraries['chosen'] = array(
    'title' => 'Chosen',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/chosen.css' => array(),
    ),
  );

  $libraries['inline_entity_form'] = array(
    'title' => 'Inline entity form',
    'version' => BACKDROP_VERSION,
    'css' => array(
      $basethemeurl . '/dist/css/components/inline_entity_form.css' => array(),
    ),
  );

  return $libraries;

}
