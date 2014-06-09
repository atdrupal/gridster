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
  drupal_add_css(drupal_get_path('module', 'gridster') . '/misc/gridster.css');
  drupal_add_js(drupal_get_path('module', 'gridster') . '/misc/gridster.js');

  $output = sprintf('<ul class="gridster" id="gridster-%s-%s">', $vars['display']->did, $vars['region_id']);

  foreach ($panes as $pane_id => $item) {
    if ($settings['widget_settings'][$pane_id]) {
      list($row, $col, $x, $y) = array_values($settings['widget_settings'][$pane_id]) + array(1, 1, 1, 1);
    }
    else {
      list($row, $col, $x, $y) = array(1, 1, 1, 1);
    }

    $output .= sprintf(
      '<li data-id="%d" data-row="%d" data-col="%d" data-sizex="%d" data-sizey="%d">%s</li>',
      $pane_id, $row, $col, $x, $y, $item
    );
  }

  $output .= '</ul>';

  if (user_access('use page manager')) {
    $form = drupal_get_form(
      "gridster_panel_region_config_form_{$vars['display']->did}_{$vars['region_id']}",
      $vars['display']->did,
      $vars['region_id'],
      $settings['widget_settings']
    );

    $form['#attached']['js'][] = drupal_get_path('module', 'gridster') . '/misc/gridster.admin.js';
    $form['#attached']['css'][] = drupal_get_path('module', 'gridster') . '/misc/gridster.admin.css';
    $output .= render($form);
  }

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

/**
 *
 */
function panels_gridster_style_settings_validate() {
}

function gridster_panel_region_config_form($form, $form_state, $display_id, $region_id, $settings) {
  $form['display_id'] = array('#type' => 'hidden', '#value' => $display_id);
  $form['region_id'] = array('#type' => 'hidden', '#value' => $region_id);

  $form['widget_settings'] = array(
    '#type' => 'hidden',
    '#default_value' => json_encode($settings),
  );

  $form["submit_{$display_id}_{$region_id}"] = array(
    '#type' => 'submit',
    '#value' => t('Save')
  );

  return $form;
}

function gridster_panel_region_config_form_submit($form, $form_state) {
  $display_id = $form_state['values']['display_id'];
  $region_id = $form_state['values']['region_id'];
  $settings = $form_state['values']['widget_settings'];

  $display = panels_load_display($display_id);
  $display->panel_settings['style_settings'][$region_id]['widget_settings'] = $settings;
  panels_save_display($display);
}
