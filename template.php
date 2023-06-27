<?php
/**
 * @file
 * Gin preprocess functions and theme function overrides.
 */

/**
 * Prepares variables for node templates.
 *
 * @see node.tpl.php
 */
function gin_preprocess_node(&$variables) {
  $variables['classes'][] = 'content';
}

/**
 * Implements hook_preprocess_page().
 */
function gin_preprocess_page(&$variables) {
  $data = array(
    '#tag' => 'link',
    '#value' => '',
    '#attributes' => array(
      'href' => url('https://fonts.gstatic.com'),
      'rel' => 'preconnect',
      'crossorigin' => 'anonymous',
    ),
  );
  backdrop_add_html_head($data, 'gin_gstatic');
  $data = array(
    '#tag' => 'link',
    '#value' => '',
    '#attributes' => array(
      'href' => url('https://fonts.googleapis.com'),
      'rel' => 'preconnect',
    ),
  );
  backdrop_add_html_head($data, 'gin_googlefont_preconnect');
  $data = array(
    '#tag' => 'link',
    '#value' => '',
    '#attributes' => array(
      'href' => url('https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100;0,400;0,500;0,600;0,700;1,400&display=swap'),
      'rel' => 'stylesheet',
    ),
  );
  backdrop_add_html_head($data, 'gin_googlefont');
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
    'admin/structure/*',
    'admin/config/*',
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
 * Returns HTML for a textfield form element.
 *
 * @param $variables
 *   An associative array containing:
 *   - element: An associative array containing the properties of the element.
 *     Properties used: #title, #value, #description, #size, #maxlength,
 *     #placeholder, #required, #attributes, #autocomplete_path.
 *
 * @ingroup themeable
 */
function gin_textfield($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'text';
  element_set_attributes($element, array('id', 'name', 'value', 'size', 'maxlength', 'placeholder'));
  _form_set_class($element, array(
    'form-text',
    'form-element',
  ));

  $extra = '';
  if ($element['#autocomplete_path'] && !empty($element['#autocomplete_input'])) {
    backdrop_add_library('system', 'backdrop.autocomplete');
    $element['#attributes']['class'][] = 'form-autocomplete';

    $attributes = array();
    $attributes['type'] = 'hidden';
    $attributes['id'] = $element['#autocomplete_input']['#id'];
    $attributes['value'] = $element['#autocomplete_input']['#url_value'];
    $attributes['disabled'] = 'disabled';
    $attributes['class'][] = 'autocomplete';
    $extra = '<input' . backdrop_attributes($attributes) . ' />';
  }

  $output = '<input' . backdrop_attributes($element['#attributes']) . ' />';

  return $output . $extra;
}

/**
 * Returns HTML for an email form element.
 *
 * @param $variables
 *   An associative array containing:
 *   - element: An associative array containing the properties of the element.
 *     Properties used: #title, #value, #description, #size, #maxlength,
 *     #placeholder, #required, #attributes, #autocomplete_path.
 *
 * @ingroup themeable
 */
function gin_email($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'email';
  element_set_attributes($element, array('id', 'name', 'value', 'size', 'maxlength', 'placeholder'));
  _form_set_class($element, array(
    'form-email',
    'form-element',
  ));

  $extra = '';
  if ($element['#autocomplete_path'] && backdrop_valid_path($element['#autocomplete_path'])) {
    backdrop_add_library('system', 'backdrop.autocomplete');
    $element['#attributes']['class'][] = 'form-autocomplete';

    $attributes = array();
    $attributes['type'] = 'hidden';
    $attributes['id'] = $element['#attributes']['id'] . '-autocomplete';
    $attributes['value'] = url($element['#autocomplete_path'], array('absolute' => TRUE));
    $attributes['disabled'] = 'disabled';
    $attributes['class'][] = 'autocomplete';
    $extra = '<input' . backdrop_attributes($attributes) . ' />';
  }

  $output = '<input' . backdrop_attributes($element['#attributes']) . ' />';

  return $output . $extra;
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
