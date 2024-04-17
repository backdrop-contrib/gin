<?php
/**
 * @file
 * Theme settings for Gin.
 */

// Attach custom library.
backdrop_add_library('gin', 'gin_settings');

$experimental_label = ' <span class="gin-experimental-flag">Experimental</span>';
$beta_label = ' <span class="gin-beta-flag">Beta</span>';
$new_label = ' <span class="gin-new-flag">New</span>';

if (module_exists('tonic')) {
  $form['tonic'] = [
    '#type' => 'container',
    '#attributes' => [
      'class' => ['tonic-settings', 'gin-layer-wrapper'],
    ],
  ];
  $form['tonic']['title'] = [
    '#markup' => '<h2>' . t('Tonic') . '</h2>',
  ];
  $form['tonic']['description'] = [
    '#markup' => '<p class="description">' . t('Tonic allows you to bring some Gin to the front end, such as the admin menu and modal styles.') . '</p>',
  ];
  $form['tonic']['admin_menu'] = [
    '#type' => 'checkbox',
    '#title' => t('Admin menu'),
    '#default_value' => config_get('tonic.settings', 'admin_menu'),
  ];

}

// Darkmode.
$form['enable_darkmode'] = array(
  '#type' => 'radios',
  '#title' => t('Appearance'),
  '#description' => t('Enables Darkmode for the admin interface.'),
  '#default_value' => theme_get_setting('enable_darkmode', 'gin'),
  '#options' => [
    0 => t('Light'),
    1 => t('Dark'),
    'auto' => t('Auto'),
  ],
);

// Accent color setting.
$form['preset_accent_color'] = [
  '#type' => 'radios',
  '#title' => t('Accent color'),
  '#default_value' => theme_get_setting('preset_accent_color', 'gin'),
  '#options' => [
    'blue' => t('Gin Blue (Default)'),
    'light_blue' => t('Light Blue'),
    'dark_purple' => t('Dark Purple'),
    'purple' => t('Purple'),
    'teal' => t('Teal'),
    'green' => t('Green'),
    'pink' => t('Pink'),
    'red' => t('Red'),
    'orange' => t('Orange'),
    'yellow' => t('Yellow'),
    'neutral' => t('Neutral'),
    'custom' => t('Custom'),
  ],
];
if (config_get('system.core', 'admin_theme') == 'gin') {
  $form['preset_accent_color']['#after_build'] = ['_gin_accent_radios'];
}

// Accent color group.
$form['accent_group'] = [
  '#type' => 'fieldset',
  '#title' => t('Custom Accent color'),
  '#description' => t('Use with caution, values should meet a11y criteria.'),
  '#states' => [
    // Show if met.
    'visible' => [
      ':input[name="preset_accent_color"]' => ['value' => 'custom'],
    ],
  ],
];

// Main Accent color setting.
$form['accent_group']['accent_color'] = [
  '#type' => 'textfield',
  '#placeholder' => '#777777',
  '#maxlength' => 7,
  '#size' => 7,
  '#title' => t('Custom Accent color'),
  '#title_display' => 'invisible',
  '#default_value' => theme_get_setting('accent_color', 'gin'),
  '#attributes' => [
    'pattern' => '^#[a-fA-F0-9]{6}',
  ],
];

// Accent color picker (helper field).
$form['accent_group']['accent_picker'] = [
  '#type' => 'color',
  '#placeholder' => '#777777',
  '#default_value' => theme_get_setting('accent_color', 'gin'),
];

// Focus color setting.
$form['preset_focus_color'] = [
  '#type' => 'select',
  '#title' => t('Focus color'),
  '#default_value' => theme_get_setting('preset_focus_color', 'gin'),
  '#options' => [
    'gin' => t('Gin Focus color (Default)'),
    'green' => t('Green'),
    'claro' => t('Claro Green'),
    'orange' => t('Orange'),
    'dark' => t('Neutral'),
    'accent' => t('Same as Accent color'),
    'custom' => t('Custom'),
  ],
];

// Focus color group.
$form['focus_group'] = [
  '#type' => 'fieldset',
  '#title' => t('Custom Focus color') . $beta_label,
  '#description' => t('Use with caution, values should meet a11y criteria.'),
  '#states' => [
    // Show if met.
    'visible' => [
      ':input[name="preset_focus_color"]' => ['value' => 'custom'],
    ],
  ],
];

// Focus color picker (helper).
$form['focus_group']['focus_picker'] = [
  '#type' => 'color',
  '#placeholder' => '#777777',
  '#default_value' => theme_get_setting('focus_color', 'gin'),
];

// Custom Focus color setting.
$form['focus_group']['focus_color'] = [
  '#type' => 'textfield',
  '#title' => t('Custom Focus color') . $beta_label,
  '#title_display' => 'invisible',
  '#placeholder' => '#777777',
  '#maxlength' => 7,
  '#size' => 7,
  '#default_value' => theme_get_setting('focus_color', 'gin'),
  '#attributes' => [
    'pattern' => '^#[a-fA-F0-9]{6}',
  ],
];

// High contrast mode.
$form['high_contrast_mode'] = [
  '#type' => 'checkbox',
  '#title' => t('Increase contrast') . $experimental_label,
  '#description' => t('Enables high contrast mode.'),
  '#default_value' => theme_get_setting('high_contrast_mode', 'gin'),
];

// Edit form sidebar.
$form['edit_form_sidebar'] = [
  '#type' => 'checkbox',
  '#title' => t('Sidebar on edit form') . $beta_label,
  '#description' => t('Move the vertical tabs to the sidebar panel on content edit forms.'),
  '#default_value' => theme_get_setting('edit_form_sidebar', 'gin'),
];

// Toolbar setting.
// $form['classic_toolbar'] = [
//   '#type' => 'radios',
//   '#title' => t('Navigation (Drupal Toolbar)'),
//   '#default_value' => theme_get_setting('classic_toolbar', 'gin'),
//   '#options' => [
//     'vertical' => t('Sidebar, Vertical Toolbar (Default)'),
//     'horizontal' => t('Horizontal, Modern Toolbar'),
//     'classic' => t('Legacy, Classic Drupal Toolbar'),
//   ],
//   '#after_build' => [
//     '_gin_toolbar_radios',
//   ],
// ];

// Layout density setting.
$form['layout_density'] = [
  '#type' => 'radios',
  '#title' => t('Layout density') . $beta_label,
  '#description' => t('Changes the layout density for tables in the admin interface.'),
  '#default_value' => theme_get_setting('layout_density', 'gin'),
  '#options' => [
    'default' => t('Default'),
    'medium' => t('Compact'),
    'small' => t('Narrow'),
  ],
];

// Description toggle.
$form['show_description_toggle'] = [
  '#type' => 'checkbox',
  '#title' => t('Enable form description toggle'),
  '#description' => t('Show a help icon to show/hide form descriptions on content forms.'),
  '#default_value' => theme_get_setting('show_description_toggle', 'gin'),
];
