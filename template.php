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
  $current_path = current_path();
  $node_edit_pages = array(
    'node/*/edit',
    'node/add/*',
  );
  if (backdrop_match_path($current_path, implode("\n", $node_edit_pages)) && (theme_get_setting('edit_form_sidebar', 'gin'))) {
    $variables['classes'][] = 'edit-form--sidebar';
  }
  if (config_get('admin_bar.settings', 'position_fixed')) {
    $variables['classes'][] = 'admin-bar--fixed';
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
    $link['localized_options']['attributes']['class'] += $classes;
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
      $item['localized_options']['attributes']['class'][] = 'admin-item__link';
      $output .= '<div class="admin-item">';
      $output .= l($item['title'], $item['href'], $item['localized_options']);
      $output .= '<dt class="admin-item__title">' . $item['title'] . '</dt>';
      if (isset($item['description'])) {
        $desc = filter_xss_admin($item['description']);
        $item['localized_options']['attributes']['title'] = $desc;
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
    unset($css[backdrop_get_path('module','admin_bar').'/css/admin_bar.css']);
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
    $form['#attached']['css'][] = backdrop_get_path('theme', 'gin') . '/dist/css/components/sidebar.css';
    $form['#attached']['js'][] = backdrop_get_path('theme', 'gin') . '/dist/js/sidebar.js';
  }
  $form['#attached']['css'][] = backdrop_get_path('theme', 'gin') . '/dist/css/components/edit_form.css';
}

/**
 * Overrides theme_pager().
 *
 * @param array $variables
 *  An associative array containing variables for the pager.
 * @return string
 *   The rendered pager.
 */
function gin_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = empty($variables['quantity']) ? 0 : (int) $variables['quantity'];
  global $pager_page_array, $pager_total;

  // Return if there is no pager to be rendered.
  if (!isset($pager_page_array[$element]) || empty($pager_total)) {
    return '';
  }

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('« First')), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ Previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('Next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('Last »')), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => array('pager__item--first'),
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => array('pager__item--previous'),
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager__item'),
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array(
              'pager__item--current',
              'pager__item',
            ),
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager__item'),
            'data' => theme('pager_next', array(
              'text' => $i,
              'element' => $element,
              'interval' => ($i - $pager_current),
              'parameters' => $parameters,
            )),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array(
          'pager__item--next',
            'pager__item',
          ),
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => array(
          'pager__item--last',
            'pager__item',
          ),
        'data' => $li_last,
      );
    }
    $output = '<nav class="pager" role="navigation" aria-labelledby="pagination-heading">';
    $output .= '<h4 id="pagination-heading" class="element-invisible">' . t('Pagination') . '</h4>';
    $output .= theme('item_list', array(
      'items' => $items,
      'attributes' => array('class' => array('pager__items')),
    ));
    $output .= '</nav>';
    return $output;
  }

  // Single page of contents, no pager needed.
  return '';
}

/**
 * Overrides theme_pager_link().
 *
 * @param array $variables
 *  An associative array containing variables for the pager link.
 * @return string
 *  The rendered pager link.
 */
function gin_pager_link($variables) {
  $text = $variables['text'];
  $page_new = $variables['page_new'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $attributes = $variables['attributes'];
  $attributes['class'][] = 'pager__link';

  $page = isset($_GET['page']) ? $_GET['page'] : '';
  if ($new_page = implode(',', pager_load_array($page_new[$element], $element, explode(',', $page)))) {
    $parameters['page'] = $new_page;
  }

  $query = array();
  if (count($parameters)) {
    $query = backdrop_get_query_parameters($parameters, array());
  }
  if ($query_pager = pager_get_query_parameters()) {
    $query = array_merge($query, $query_pager);
  }

  // Set each pager link title
  if (!isset($attributes['title'])) {
    static $titles = NULL;
    if (!isset($titles)) {
      $titles = array(
        t('« First') => t('Go to first page'),
        t('‹ Previous') => t('Go to previous page'),
        t('Next ›') => t('Go to next page'),
        t('Last »') => t('Go to last page'),
      );
    }
    if (isset($titles[$text])) {
      $attributes['title'] = $titles[$text];
    }
    elseif (is_numeric($text)) {
      $attributes['title'] = t('Go to page @number', array('@number' => $text));
    }
  }

  // @todo l() cannot be used here, since it adds an 'active' class based on the
  //   path only (which is always the current path for pager links). Apparently,
  //   none of the pager links is active at any time - but it should still be
  //   possible to use l() here.
  // @see http://drupal.org/node/1410574
  $attributes['href'] = url($_GET['q'], array('query' => $query));
  return '<a' . backdrop_attributes($attributes) . '>' . check_plain($text) . '</a>';
}

/**
 * Implements hook_views_pre_render().
 */
function gin_views_pre_render(&$view) {
  if ($view->name == 'image_library') {
    $view->field["uri"]->options["image_style"] = 'medium';
    $view->field["uri"]->options["thumbnail_style"] = 'medium';
  }
}

/**
 * Implements theme_form_element().
 *
 * We're overriding/duplicating this function to allow adjustments to the
 * description and implement Gin's description toggle functionality.
 */
function gin_form_element($variables) {
  $element = &$variables['element'];

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
    '#wrapper_attributes' => array(),
  );
  $attributes = $element['#wrapper_attributes'];

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes['class'][] = 'form-item';
  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
    if (isset($element['#parents']) && form_get_error($element) !== NULL && !empty($element['#validated'])) {
      $attributes['class'][] = 'form-error';
    }
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }
  // Add indentation.
  if (isset($element['#indentation'])) {
    $attributes['class'][] = 'form-item-indentation';
    $attributes['class'][] = 'form-item-indentation-' . $element['#indentation'];
    $attributes['data-indentation-depth'] = $element['#indentation'];
  }
  // Add description toggle classes if settings call for them.
  $show_description_toggle = theme_get_setting('show_description_toggle', 'gin');
  $help_icon_open = '';
  $help_icon_close = '';
  if (!empty($element['#description'])) {
    $description_attributes['class'][] = 'description';
    if ($show_description_toggle) {
      backdrop_add_library('gin', 'gin_description_toggle');
      $attributes['class'][] = 'help-icon__description-container';
      $description_attributes['class'][] = 'visually-hidden';
      $help_icon_open = '<div class="help-icon">';
      $help_icon_close = '<button class="help-icon__description-toggle"></button></div>';
    }
  }
  $output = '<div' . backdrop_attributes($attributes) . '>' . "\n";

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= $help_icon_open;
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      $output .= $help_icon_close;
      break;

    case 'after':
      $output .= $help_icon_open;
      $output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      $output .= $help_icon_close;
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }

  if (!empty($element['#description'])) {
    $show_description_toggle = theme_get_setting('show_description_toggle', 'gin');
    $output .= '<div' . backdrop_attributes($description_attributes) . '>' . $element['#description'] . "</div>\n";
  }

  $output .= "</div>\n";

  return $output;
}
