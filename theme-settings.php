<?php
/**
 * @file
 * Theme settings for Gin.
 */

$form['dark_mode'] = array(
  '#type' => 'checkbox',
  '#title' => t('Enable dark mode'),
  '#default_value' => theme_get_setting('dark_mode', 'gin'),
);
