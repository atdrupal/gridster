<?php

$plugin = array(
  'title' => '[GO]' . t('Gridster'),
  'description' => '…',
  'render region' => 'panels_gogridster_style_render_region',
  // 'settings form' => 'panels_gridster_style_settings_form',
);

/**
 * @param type $vars
 */
function theme_panels_gogridster_style_render_region($vars) {
  $name = sprintf('gridsterApp__%s__%s', $vars['display']->did, $vars['region_id']);

  drupal_add_library('gridster', 'gogridster');

  drupal_add_js(
    array('gridster' => array($name => gridster_build_gridmaster_structure($vars['display'], $vars['panes']))),
    array('type' => 'setting')
  );

  return sprintf(
    '<div id="%s" ng-app="%s" ng-controller="gridsterCtrl"></div>',
    $name,
    $name
  );
}

function gridster_build_gridmaster_structure($display, $panes) {
  $return = array('id' => $display->did, 'title' => '');

  foreach ($panes as $id => $content) {
    $find_title = strpos($content, '<h2 class="pane-title">') ? '<h2 class="pane-title">([^<]+)<\/h2>' : '()';
    $find_content = '<div class="pane-content">(.+)<\/div>\s*<\/div>';
    preg_match("/^.+{$find_title}.+{$find_content}\s*$/ms", $content, $matches);
    list(, $title, $content) = $matches + array('', '', '');

    $return['widgets'][] = array(
      'id' => $id,
      'label' => '%label',
      'title' => $title,
      'css' => array(),
      'js' => array(),
      'options' => array(
        'draggable' => array('enabled' => true),
        'position' => array(),
      ),
      'content' => $content,
    );
  }

  return $return;
}
