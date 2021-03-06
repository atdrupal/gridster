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
  switch ($plugin) {
    case 'display_renderers':
      return 'plugins/' . $plugin;
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

/**
 * Alter to IPE config form.
 */
function gridster_form_panels_ipe_edit_control_form_alter(&$form, $form_state) {
  if (FALSE !== strpos($form['#action'], '/panels/ajax/gridster_ipe/save_form/')) {
    $default = isset($form['#display']->panel_settings['display_settings']) ? $form['#display']->panel_settings['display_settings'] : array();
    $form['display_settings'] = array(
      '#type' => 'hidden',
      '#attributes' => array('class' => 'gridster-display-settings-field'),
      '#default_value' => json_encode($default),
      '#attached' => array(
        'js' => array(drupal_get_path('module', 'gridster') . '/misc/gogridster.admin.js'),
        'css' => array(drupal_get_path('module', 'gridster') . '/misc/gogridster.admin.css')
      ),
    );

    array_unshift($form['buttons']['submit']['#submit'], function($form, &$form_state) {
      $form_state['display']->panel_settings['display_settings'] = json_decode($form_state['values']['display_settings'], true);
    });
  }
}

/**
 * Implements hook_form_FORM_ID_alter()
 *
 * On cloning, custom settings for displays lost, this custom code (and
 * gridster_panels_display_save function) to copy settings from old to new page.
 */
function gridster_form_page_manager_page_form_clone_alter(&$form, $form_state) {
  $form['#submit'][] = function($form, $form_state) {
    $task_name = substr($form_state['redirect'], strlen('/edit/') + strpos($form_state['redirect'], '/edit/'));
    $page = page_manager_get_page_cache($task_name);

    $_oids = array_keys($form_state['page']->handlers);

    foreach (array_keys($page->handlers) as $i => $handler_id) {
      $display = &$page->handlers[$handler_id]->conf['display'];
      $_odisplay_id = $form_state['page']->handlers[$_oids[$i]]->conf['did'];
      $_display = panels_load_display($_odisplay_id);
      $display_settings = &$display->panel_settings['display_settings'];

      foreach ($display_settings as $region_id => &$region_settings) {
        foreach ($region_settings['widgets'] as $ii => $widget_setting) {
          unset($region_settings['widgets'][$ii]);
          $uuid = $_display->content[$ii]->uuid;
          $region_settings['widgets'][$uuid] = array('id' => $uuid) + $widget_setting;
        }
      }
    }

    page_manager_set_page_cache($page);
  };
}

/**
 * Implements hook_panels_display_save()
 */
function gridster_panels_display_save($display) {
  static $ran = array();

  if (!empty($ran[$display->did])) {
    return;
  }
  else {
    $ran[$display->did] = true;
  }

  $save = true;
  $display_settings = &$display->panel_settings['display_settings'];

  foreach (array_keys($display_settings) as $region_id) {
    $expected_id = preg_replace('/__\d+__/', "__{$display->did}__", $display_settings[$region_id]['id']);
    if ($region_id !== $expected_id) {
      $display_settings[$expected_id] = $display_settings[$region_id];
      unset($display_settings[$region_id]);
    }

    $region_settings = $display_settings[$expected_id];

    foreach ($region_settings['widgets'] as $uuid => $widget_settings) {
      if (!isset($display->content[$uuid])) {
        foreach ($display->content as $id => $content) {
          if ($uuid === $content->uuid) {
            $save = true;
            unset($region_settings['widgets'][$uuid]);
            $region_settings['widgets'][$id] = array('id' => $id) + $widget_settings;
          }
        }
      }
    }
  }

  if ($save) {
    panels_save_display($display);
  }
}
