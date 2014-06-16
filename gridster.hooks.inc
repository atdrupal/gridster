<?php

/**
 * Implements hook_library()
 */
function gridster_library() {
  return json_decode(
    str_replace(
      '%base',
      drupal_get_path('module', 'gridster'),
      file_get_contents(drupal_get_path('module', 'gridster') . '/misc/fixtures/libraries.json')
    ),
    true
  );
}

/**
 * Implements hook_ctools_plugin_directory()
 */
function gridster_ctools_plugin_directory($module, $plugin) {
  if ('panels' === $module) {
    switch ($plugin) {
      case 'display_renderers':
        return 'plugins/' . $plugin;
    }
  }
}

/**
 * Implementation of hook_ctools_plugin_api().
 *
 * Inform CTools about version information for various plugins implemented by
 * Panels.
 *
 * @param string $owner
 *   The system name of the module owning the API about which information is
 *   being requested.
 * @param string $api
 *   The name of the API about which information is being requested.
 */
function gridster_ctools_plugin_api($owner, $api) {
  if ($owner === 'panels' && $api === 'pipelines') {
    return array(
      'version' => 1,
      'path' => drupal_get_path('module', 'gridster') . '/includes',
    );
  }
}
