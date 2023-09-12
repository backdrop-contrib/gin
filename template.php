<?php
/**
 * @file
 * Gin preprocess functions and theme function overrides.
 */

/**
 * Load include files which contain additional theming logic.
 */
foreach (glob(path_to_theme('gin') . '/includes/*.php') as $file) {
  include $file;
}

/**
 * Implements hook_preprocess_layout().
 */
function gin_preprocess_layout(&$variables) {
  // Some pages need a flag added so we can wrap the main content visually.
  $pages_to_wrap = array(
    'admin/dashboard/settings',
    'admin/content/comment',
    'admin/people/create',
    'admin/appearance',
    'admin/appearance/*',
    'admin/modules',
    'admin/modules/*',
    'admin/structure/types',
    'admin/structure/types/manage/*',
    'admin/structure/block',
    'admin/structure/file-types',
    'admin/structure/layouts',
    'admin/structure/layouts/manage/*',
    'admin/structure/layouts/settings/flexible-template/*',
    'admin/structure/menu',
    'admin/structure/paragraphs',
    'admin/structure/taxonomy',
    'admin/structure/views',
    'admin/config/*/*',
    'node/*/edit',
    'node/add/*',
    'admin/reports/*',
  );
  $current_path = request_path();
  if (backdrop_match_path($current_path, implode("\n", $pages_to_wrap))) {
    $variables['wrap_prefix'] = '<div class="gin-layer-wrapper">';
    $variables['wrap_suffix'] = '</div>';
  } else {
    $variables['wrap_prefix'] = '';
    $variables['wrap_suffix'] = '';
  }
  $node_edit_pages = array(
    'node/*/edit',
    'node/add/*',
  );
  if (backdrop_match_path($current_path, implode("\n", $node_edit_pages)) && (theme_get_setting('edit_form_sidebar', 'gin'))) {
    $variables['classes'][] = 'edit-form--sidebar';
  }
}

/**
 * Overrides theme_breadcrumb().
 */
function gin_breadcrumb($variables) {
  $breadcrumbs = $variables['breadcrumb'];
  $output = '';
  if (!empty($breadcrumbs)) {
    $output .= '<nav role="navigation" class="gin-breadcrumb" aria-labelledby="system-breadcrumb">';
    $output .= '<h2 id="system-breadcrumb" class="visually-hidden">Breadcrumb</h2>';
    $output .= '<ol class="gin-breadcrumb__list">';
    foreach ($breadcrumbs as $breadcrumb) {
      $breadcrumb = str_replace('<a ', '<a class="gin-breadcrumb__link" ', $breadcrumb);
      $output .= '<li class="gin-breadcrumb__item">' . $breadcrumb . '</li>';
    }
    $output .= '</ol>';
    $output .= '</nav>';
  }
  return $output;
}

/**
 * Overrides theme_tablesort_indicator().
 *
 * @param $variables
 *   An associative array containing:
 *   - style: Set to either 'asc' or 'desc', this determines which icon to
 *     show.
 */
function gin_tablesort_indicator($variables) {
  return '<span class="tablesort tablesort--' . $variables['style'] . '">
    <span class="visually-hidden">
      Sort ' . $variables['style'] . 'ending
        </span>
    </span>';
}


/**
 * Overrides theme_menu_local_action().
 */
function gin_menu_local_action($variables) {
  $link = $variables['element']['#link'];
  $classes = array(
    'button',
    'button-action',
    'button-primary',
  );
  if (!empty($link['localized_options']['attributes']['class']) && is_array($link['localized_options']['attributes']['class'])) {
    $link['localized_options']['attributes']['class'][] += $classes;
  }
  else {
    $link['localized_options']['attributes']['class'] = $classes;
  }

  $output = '<li class="local-actions__item">';
  if (isset($link['href'])) {
    $output .= l($link['title'], $link['href'], isset($link['localized_options']) ? $link['localized_options'] : array());
  }
  elseif (!empty($link['localized_options']['html'])) {
    $output .= $link['title'];
  }
  else {
    $output .= check_plain($link['title']);
  }
  $output .= "</li>\n";

  return $output;
}

/**
 * Overrides theme_menu_local_actions().
 */
function gin_menu_local_actions($variables) {
  $output = backdrop_render($variables['actions']);
  if ($output) {
    $output = '<ul class="local-actions">' . $output . '</ul>';
  }
  return $output;
}

/**
 * Overrides theme_menu_local_task().
 */
function gin_menu_local_task($variables) {
  $link = $variables['element']['#link'];
  $link_text = $link['title'];

  if (!empty($variables['element']['#active'])) {
    // Add text to indicate active tab for non-visual users.
    $active = '<span class="visually-hidden">' . t('(active tab)') . '</span>';

    // If the link does not contain HTML already, check_plain() it now.
    // After we set 'html'=TRUE the link will not be sanitized by l().
    if (empty($link['localized_options']['html'])) {
      $link['title'] = check_plain($link['title']);
    }
    $link['localized_options']['html'] = TRUE;
    $link_text = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));
    $link['localized_options']['attributes']['class'][] = 'is-active';
  }
  $link['localized_options']['attributes']['class'][] = 'tabs__link';
  $link['localized_options']['attributes']['class'][] = 'js-tabs-link';
  $output = '<li class="tabs__tab js-tab' . (!empty($variables['element']['#active']) ? ' is-active js-active-tab' : '') . '">';
  $output .= l($link_text, $link['href'], $link['localized_options']);
  $output .= "</li>\n";
  return  $output;
}

/**
 * Overrides theme_menu_local_tasks().
 */
function gin_menu_local_tasks($variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 id="primary-tabs-title" class="visually-hidden">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs tabs--primary clearfix">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= backdrop_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 id="secondary-tabs-title" class="visually-hidden">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs tabs--secondary clearfix">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= backdrop_render($variables['secondary']);
  }

  return $output;
}

/**
 * Implements hook_preprocess_block().
 *
 * Add classes for Gin theming.
 */
function gin_preprocess_block(&$variables) {
  $variables['panel'] = FALSE;
  /* @var Layout $layout */
  $layout = $variables['layout'];
  if (is_a($layout, 'Layout') && $layout->hasContexts(array('dashboard'))) {
    $block = $variables['block'];
    $region_name = $layout->getBlockPosition($block->uuid);
    if (!in_array($region_name, array('header', 'footer'))) {
      $variables['classes'][] = 'panel';
      $variables['classes'][] = 'gin-layer-wrapper';
      $variables['panel'] = TRUE;
    }
  }
}

/**
 * Overrides theme_admin_block().
 * Returns HTML for an administrative block for display.
 *
 * @param $variables
 *   An associative array containing:
 *   - block: An array containing information about the block:
 *     - show: A Boolean whether to output the block. Defaults to FALSE.
 *     - title: The block's title.
 *     - content: (optional) Formatted content for the block.
 *     - description: (optional) Description of the block. Only output if
 *       'content' is not set.
 *
 * @ingroup themeable
 */
function gin_admin_block($variables) {
  $block = $variables['block'];
  $classes = array(
    'admin-panel',
    'panel',
    'gin-layer-wrapper',
    );
  // Construct a more specific class.
  if (isset($variables['block']['path'])) {
    $path_parts = explode('/', $variables['block']['path']);
    $class_suffix = end($path_parts);
    $classes[] = ' ' . backdrop_clean_css_identifier('admin-panel-' . $class_suffix);
  }

  $output = '';
  // Don't display the block if it has no content to display.
  if (empty($block['show'])) {
    return $output;
  }

  $output .= '<div class="' . implode(' ', $classes) . '">';
  if (!empty($block['title'])) {
    $output .= '<h3 class="panel__title">' . $block['title'] . '</h3>';
  }
  if (!empty($block['content'])) {
    $output .= '<div class="panel__content body">' . $block['content'] . '</div>';
  }
  else {
    $output .= '<div class="panel__content description">' . $block['description'] . '</div>';
  }
  $output .= '</div>';

  return $output;
}

/**
 * Implements hook_admin_bar_output_build().
 */
function gin_admin_bar_output_build(&$content) {
  // dpm($content);
}

/**
 * Returns HTML for the content of an administrative block.
 * Overrides theme_admin_block_content().
 *
 * @param $variables
 *   An associative array containing:
 *   - content: An array containing information about the block. Each element
 *     of the array represents an administrative menu item, and must at least
 *     contain the keys 'title', 'href', and 'localized_options', which are
 *     passed to l(). A 'description' key may also be provided.
 *
 * @ingroup themeable
 */
function gin_admin_block_content($variables) {
  $content = $variables['content'];

  return _gin_admin_list($content, '');
}

/**
 * Returns HTML for a list of available node types for node creation.
 *
 * @param $variables
 *   An associative array containing:
 *   - content: An array of content types.
 *
 * @see node_add_page()
 * @ingroup themeable
 */
function gin_node_add_list($variables) {
  $content = $variables['content'];
  $empty_message = t('You have not created any content types yet. Go to the <a href="@create-content">content type creation page</a> to add a new content type.', array('@create-content' => url('admin/structure/types/add')));
  return _gin_admin_list($content, $empty_message);
}

/**
 * Helper function to generate an admin list.
 * @todo This could be moved into a theme hook and tpl file.
 */
function _gin_admin_list($content, $empty_message = '') {
  $output = '';

  if (!empty($content)) {
    $output .= '<dl class="admin-list gin-layer-wrapper">';
    foreach ($content as $item) {
      $desc = filter_xss_admin($item['description']);
      $item['localized_options']['attributes']['class'][] = 'admin-item__link';
      $item['localized_options']['attributes']['title'] = $desc;
      $output .= '<div class="admin-item">';
      $output .= l($item['title'], $item['href'], $item['localized_options']);
      $output .= '<dt class="admin-item__title">' . $item['title'] . '</dt>';
      if (isset($item['description'])) {
        $output .= '<dd class="admin-item__description">' . $desc . '</dd>';
      }
      $output .= '</div>';
    }
    $output .= '</dl>';
  }
  elseif (!empty($empty_message)) {
    $output = '<p>' . filter_xss_admin($empty_message) . '</p>';
  }
  return $output;
}

/**
 * Implements hook_css_alter().
 */
function gin_css_alter(&$css) {
    unset($css[backdrop_get_path('module','system').'/css/messages.theme.css']);
}

/**
 * Implements hook_form_BASE_FORM_ID_alter() for node_form.
 *
 * Changes vertical tabs to container.
 */
function gin_form_node_form_alter(&$form, &$form_state, $form_id) {
  if (theme_get_setting('edit_form_sidebar', 'gin')) {
    foreach (element_children($form) as $key) {
      if (!empty($form[$key]['#group']) && $form[$key]['#group'] == 'additional_settings') {
          $form[$key]['#collapsed'] = TRUE;
        }
    }
    $form['options']['#collapsed'] = FALSE;
    $form['additional_settings']['#type'] = 'fieldset';
    $form['additional_settings']['#attributes']['class'][] = 'node-edit-settings';
    $form['#attached']['js'][] = backdrop_get_path('theme', 'gin') . '/dist/js/edit_form.js';
  }
  $form['#attached']['css'][] = backdrop_get_path('theme', 'gin') . '/dist/css/components/edit_form.css';
}
