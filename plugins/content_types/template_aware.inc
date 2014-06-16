<?php

$plugin = array(
  'title' => '[Gridster Demo] Template Aware',
  'single' => true,
  'description' => 'Template aware widget',
  'content type' => 'gridster_template_aware_widget_content_type',
  'category' => t('Widgets'),
  // 'top level' => true,
  'render callback' => 'gridster_template_aware_content_type_render',
);

/**
 * …
 *
 * @param type $subtype
 * @param type $conf
 * @param type $panel_args
 * @return string
 */
function gridster_template_aware_content_type_render($subtype, $conf, $panel_args) {
  global $base_path;

  $return = new stdClass();
  $return->title = 'title is here';
  $return->template = $base_path . drupal_get_path('module', 'gridster') . '/plugins/content_types/template.html';
  $return->content = array('name' => 'Drupal');
  
  return $return;
}
