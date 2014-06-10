<?php

$plugin = array(
  'title' => '[GO]' . t('Gridster'),
  'description' => '…',
  'render region' => 'panels_gogridster_style_render_region',
  // 'settings form' => 'panels_gridster_style_settings_form',
);

/**
 *
 * @param type $vars
 */
function theme_panels_gogridster_style_render_region($vars) {
  $name = sprintf('gridsterApp__%s__%s', $vars['display']->did, $vars['region_id']);

  drupal_add_library('angularjs', 'angularjs');
  drupal_add_js(drupal_get_path('module', 'gridster') . '/misc/gogridster/gogridster/gogridster.js');
  drupal_add_js(drupal_get_path('module', 'gridster') . '/misc/gogridster.js');

  drupal_add_js(
    array('gridster' => array($name => gridster_build_gridmaster_structure($vars['display'], $vars['panes']))),
    array('type' => 'setting')
  );

  $output  = '<div id="'. $name .'" ng-app="'. $name .'" ng-controller="gridsterCtrl">';
  $output .= '</div>';

  return $output;
}

function gridster_build_gridmaster_structure($display, $panes) {
  $return = array('id' => $display->did);

  foreach ($panes as $id => $content) {
    $return['widgets'][] = array(
      'id' => $id,
      'label' => '%label',
      'title' => '%title',
      'css' => array(),
      'js' => array(),
      'options' => array(
        'position' => array(),
      ),
      'content' => $content,
    );
  }

  return $return;
}
