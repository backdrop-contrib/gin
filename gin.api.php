<?php
/**
 * @file
 * Hooks for the Gin theme.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Register paths to apply Gin’s content edit form layout.
 *
 * Leverage this hook to achieve a consistent user interface layout on
 * administrative edit forms, similar to the node edit forms. Any module
 * providing a custom entity type or form mode may wish to implement this
 * hook for their form paths. Please note that not every content entity
 * form path should enable the Gin edit form layout, for example the
 * delete entity form does not need it.
 *
 * @return array
 *   An array of paths that are considered to be content forms. Wildcards may
 *   be used to match multiple paths.
 *
 * @see gin_content_form_paths()
 * @see hook_gin_content_form_paths_alter()
 */
function hook_gin_content_form_paths() {
  return array(
    'custom_entity/*/edit',
  );
}

/**
 * Alters the list of paths for content forms.
 *
 * This function allows modules to alter the list of paths that are considered
 * to be content forms in the gin theme. The list of paths is defined by modules
 * implementing the hook_gin_content_form_paths() hook.
 *
 * @param array $paths
 *   An array of paths that are considered to be content forms. Modify this array
 *   to alter the list of paths.
 *
 * @see gin_content_form_paths()
 * @see hook_gin_content_form_paths()
 */
function hook_gin_content_form_paths_alter(&$paths) {
  // Example: disable Gin edit form customizations for user account paths.
  $remove_paths = array(
    'user/*/edit',
    'admin/people/create',
  );
  $paths = array_diff($paths, $remove_paths);
}


/**
 * @} End of "addtogroup hooks".
 */

