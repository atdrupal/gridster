<?php

/**
 * Implements hook_library()
 */
function gridster_library() {
  $base = drupal_get_path('module', 'gridster');

  $libraries['gogridster'] = array(
    'title' => '[AngularJS] GoGridster',
    'website' => 'http://www.go1.com.au/',
    'version' => VERSION,
    'js' => array(
      "$base/misc/gogridster/src/common/directives/angular-gridster/angular-gridster.js" => array(),
      "$base/misc/gogridster/build/gogridster.js" => array(),
      "$base/misc/gogridster.js" => array(),
    ),
    'css' => array(
      "$base/misc/gogridster/angular-gridster/angular-gridster.css" => array(),
    ),
    'dependencies' => array(
      array('system', 'ui.resizable'),
      array('system', 'ui.draggable'),
      array('angularjs', 'angularjs')
    ),
  );

  return $libraries;
}

/**
 * Implements hook_forms()
 *
 * @param string $form_id
 * @param array $args
 * @return array
 */
function gridster_forms($form_id, $args) {
  $forms = array();

  if (0 === strpos($form_id, 'gridster_panel_region_config_form_')) {
    $forms[$form_id]['callback'] = 'gridster_panel_region_config_form';
  }

  return $forms;
}

/**
 * Implements hook_ctools_plugin_directory()
 */
function gridster_ctools_plugin_directory($module, $plugin) {
  if ('panels' === $module) {
    switch ($plugin) {
      case 'styles':
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
  if ($owner == 'panels' && $api == 'pipelines') {
    return array(
      'version' => 1,
      'path' => drupal_get_path('module', 'gridster') . '/includes',
    );
  }
}