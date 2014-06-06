<?php

$plugin = array(
  'title' => t('Gridster'),
  'description' => '…',
  'render region' => 'panels_gridster_style_render_region',
  'settings form' => 'panels_gridster_style_settings_form',
  'settings validate' => 'panels_gridster_style_settings_validate',
);

/**
 * Theming callback for gridster region.
 *
 * @param array $vars
 * @return string
 */
function theme_panels_gridster_style_render_region($vars) {
  $display = $vars['display'];
  $region_id = $vars['region_id'];
  $panes = $vars['panes'];
  $settings = $vars['settings'];
  if (!empty($settings['widget_settings'])) {
    $settings['widget_settings'] = json_decode($settings['widget_settings'], true);
  }

  drupal_add_js(drupal_get_path('module', 'gridster') . '/misc/jquery.gridster.min.js');
  drupal_add_css(drupal_get_path('module', 'gridster') . '/misc/jquery.gridster.min.css');
  drupal_add_js(drupal_get_path('module', 'gridster') . '/misc/gridster.js');

  $output = '<ul class="gridster">';

  # dsm(array_keys($panes));
  #dsm($settings);

  foreach ($panes as $pane_id => $item) {
    if ($settings['widget_settings'][$pane_id]) {
      list($row, $col, $x, $y) = array_values($settings['widget_settings'][$pane_id]) + array(1, 1, 1, 1);
    }
    else {
      list($row, $col, $x, $y) = array(1, 1, 1, 1);
    }

    $output .= sprintf(
      '<li data-row="%d" data-col="%d" data-sizex="%d" data-sizey="%d">%s</li>',
      $row, $col, $x, $y, $item
    );
  }

  $output .= '</ul>';

  return $output;
}

/**
 * Settings for region.
 *
 * @param type $settings
 * @return type
 */
function panels_gridster_style_settings_form($settings) {
  $form['widget_margin_left'] = array(
    '#type' => 'textfield',
    '#title' => t('Widget margin left'),
    '#default_value' => isset($settings['widget_margin_left']) ? $settings['widget_margin_left'] : 10,
  );

  $form['widget_margin_right'] = array(
    '#type' => 'textfield',
    '#title' => t('Widget margin right'),
    '#default_value' => isset($settings['widget_margin_right']) ? $settings['widget_margin_right'] : 10,
  );

  $form['widget_base_dimension_width'] = array(
    '#type' => 'textfield',
    '#title' => t('Gridmaster width'),
    '#default_value' => isset($settings['widget_base_dimension_width']) ? $settings['widget_base_dimension_width'] : 140,
  );

  $form['widget_base_dimension_height'] = array(
    '#type' => 'textfield',
    '#title' => t('Gridmaster height'),
    '#default_value' => isset($settings['widget_base_dimension_height']) ? $settings['widget_base_dimension_height'] : 140,
  );

  $form['widget_settings'] = array(
    '#type' => 'textarea', // 'hidden',
    '#default_value' => isset($settings['widget_settings']) ? $settings['widget_settings'] : '',
  );

  return $form;
}

function panels_gridster_style_settings_validate() {
}
