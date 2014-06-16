<?php

namespace Drupal\gridster;

class RenderIPE extends Render {
  function ajax_save_form($break = NULL) {
    parent::ajax_save_form($break);

    $display = panels_load_display($this->display->did);
    $settings = &$display->panel_settings['display_settings'];
    $app_name = reset(array_keys($settings));
    $save = FALSE;

    foreach ($settings[$app_name]['widgets'] as $_id => $widget_settings) {
      if (FALSE === strpos($_id, 'new-')) {
        continue;
      }

      // Remove the temp
      unset($settings[$app_name]['widgets'][$_id]);

      // Save correct value
      $uuid = str_replace('new-', '', $_id);

      foreach ($display->content as $content_id => $content) {
        if ($uuid === $content->uuid) {
          $save = TRUE;

          $settings[$app_name]['widgets'][$content_id] = $widget_settings + array(
            'id' => $content_id,
          );
        }
      }
    }

    if ($save) {
      panels_save_display($display);
    }
  }

  function command_add_pane($pid) {
    parent::command_add_pane($pid);

    foreach ($this->commands as &$command) {
      if ('insertNewPane' === $command['command']) {
        $command += array(
          'displayId' => $this->display->did,
          'paneId' => is_object($pid) ? $pid->pid : $pid,
          'paneTitle' => '%title…',
        );
      }
    }
  }

}
