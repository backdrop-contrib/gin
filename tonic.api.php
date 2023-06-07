<?php

/**
 * @file
 * Hooks for tonic theme.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Register routes to apply Tonic’s content edit form layout.
 *
 * Leverage this hook to achieve a consistent user interface layout on
 * administrative edit forms, similar to the node edit forms. Any module
 * providing a custom entity type or form mode may wish to implement this
 * hook for their form routes. Please note that not every content entity
 * form route should enable the Tonic edit form layout, for example the
 * delete entity form does not need it.
 *
 * @return array
 *   An array of route names.
 *
 * @see TonicContentFormHelper->isContentForm()
 * @see hook_tonic_content_form_routes_alter()
 */
function hook_tonic_content_form_routes() {
  return [
    // Layout a custom node form.
    'entity.node.my_custom_form',

    // Layout a custom entity type edit form.
    'entity.my_type.edit_form',
  ];
}

/**
 * Alter the registered routes to enable or disable Tonic’s edit form layout.
 *
 * @param array $routes
 *   The list of routes.
 *
 * @see TonicContentFormHelper->isContentForm()
 * @see hook_tonic_content_form_routes()
 */
function hook_tonic_content_form_routes_alter(array &$routes) {
  // Example: disable Tonic edit form layout customizations for an entity type.
  $routes = array_diff($routes, ['entity.my_type.edit_form']);
}

/**
 * @} End of "addtogroup hooks".
 */
