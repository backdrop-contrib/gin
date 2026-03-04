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

  $libraries = array(
    'gin' => array(
      'title' => 'Default',
      'version' => BACKDROP_VERSION,
      'css' => array(
        $basethemeurl . '/dist/css/base/gin.css' => array(),
      ),
      'dependencies' => array(
        array('gin', 'gin_base'),
      ),
    ),
    'gin_base' => array(
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
    ),
    'gin_init' => array(
      'title' => 'Init',
      'version' => BACKDROP_VERSION,
      'header' => TRUE,
      'js' => array(
        $basethemeurl . '/dist/js/init.js' => array(),
      ),
    ),
  );

  // #########################
  //
  // TODO:
  // Add Toolbar library here.
  //
  // #########################

  $libraries += array(
    'gin_accent' => array(
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
    ),
    'gin_dialog' => array(
      'title' => 'Dialog',
      'version' => BACKDROP_VERSION,
      'css' => array(
        $basethemeurl . '/dist/css/components/gin_dialog.css' => array(),
        $basethemeurl . '/dist/css/theme/dialog.css' => array(),
      ),
    ),
    'gin_description_toggle' => array(
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
    ),
  );

  // #########################
  //
  // TODO:
  // Add Custom CSS library here.
  //
  // #########################

  $libraries += array(
    'gin_once' => array(
      'title' => 'Once',
      'version' => BACKDROP_VERSION,
      'js' => array(
        $basethemeurl . '/js/libs/once.js' => array('weight' => -1),
      ),
    ),
    'gin_sticky' => array(
      'title' => 'Sticky',
      'version' => BACKDROP_VERSION,
      'js' => array(
        $basethemeurl . '/dist/js/sticky.js' => array(),
      ),
      'dependencies' => array(
        array('gin', 'gin_once'),
      ),
    ),
    'gin_sidebar' => array(
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
    ),
    'gin_settings' => array(
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
    ),
  );

  # Components

  $libraries += array(
    'gin_tabs' => array(
      'title' => 'Tabs',
      'version' => BACKDROP_VERSION,
      'css' => array(
        $basethemeurl . '/dist/css/components/tabs.css' => array(),
      ),
    ),
    'gin_tableselect' => array(
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
    ),
    'gin_tabledrag' => array(
      'title' => 'Tabledrag',
      'version' => BACKDROP_VERSION,
      'js' => array(
        $basethemeurl . '/js/overrides/tabledrag.js' => array(),
      ),
      'dependencies' => array(
        array('gin', 'gin_once'),
      ),
    ),
    'gin_edit_form' => array(
      'title' => 'Edit form',
      'version' => BACKDROP_VERSION,
      'css' => array(
        $basethemeurl . '/dist/css/components/edit_form.css' => array(),
      ),
      'dependencies' => array(
        array('gin', 'gin_once'),
        array('gin', 'gin_more_actions'),
        array('gin', 'gin_sidebar'),
      ),
    ),
    'gin_sidebar' => array(
      'title' => 'Sidebar edit UI',
      'version' => BACKDROP_VERSION,
      'js' => array(
        $basethemeurl . '/dist/js/sidebar.js' => array(),
      ),
    ),
    'gin_more_actions' => array(
      'title' => 'Sticky actions',
      'version' => BACKDROP_VERSION,
      'js' => array(
        $basethemeurl . '/dist/js/more_actions.js' => array(),
      ),
      'css' => array(
        $basethemeurl . '/dist/css/components/more_actions.css' => array(),
      ),
    ),
    'gin_contextual_links' => array(
      'title' => 'Contextual links',
      'version' => BACKDROP_VERSION,
      'css' => array(
        $basethemeurl . '/dist/css/components/contextual_links.css' => array(),
      ),
    ),
    'gin_ajax' => array(
      'title' => 'Ajax',
      'version' => BACKDROP_VERSION,
      'css' => array(
        $basethemeurl . '/dist/css/components/ajax.css' => array(),
      ),
    ),
    'gin_revisions' => array(
      'title' => 'Revisions',
      'version' => BACKDROP_VERSION,
      'css' => array(
        $basethemeurl . '/dist/css/components/revisions.css' => array(),
      ),
    ),
    'gin_autocomplete' => array(
      'title' => 'Autocomplete',
      'version' => BACKDROP_VERSION,
      'css' => array(
        $basethemeurl . '/dist/css/components/autocomplete.css' => array(),
      ),
    ),
    'gin_breadcrumb' => array(
      'title' => 'Breadcrumb',
      'version' => BACKDROP_VERSION,
      'css' => array(
        $basethemeurl . '/dist/css/components/breadcrumb.css' => array(),
      ),
    ),
    'gin_node_preview' => array(
      'title' => 'Node preview',
      'version' => BACKDROP_VERSION,
      'css' => array(
        $basethemeurl . '/dist/css/components/node_preview.css' => array(),
      ),
    ),
  );

  # Modules

  $libraries += gin_get_module_libraries();

  return $libraries;

}
