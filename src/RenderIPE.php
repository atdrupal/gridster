<?php

namespace Drupal\gridster;

class RenderIPE extends Render {
  protected function buildStructure($region_id, $panes, $widget_settings) {
    $return = array(
      'id' => $this->getGridmasterId($region_id),
      'title' => '', // "[$region_id]",
      'options' => array(
        'draggable' => array('enabled' => false),
        'resizable' => array('enabled' => false)
      ),
    );

    foreach ($panes as $id => $content) {
      $return['widgets'][$id] = array(
        'id' => $id,
        'label' => '%label',
        'title' => isset($this->pane_info[$id]->title) ? $this->pane_info[$id]->title : '',
        'content' => $content,
        'options' => array(
          'position' => array('col' => null, 'row' => null, 'sizeX' => null, 'sizeY' => null)
        ),
      );

      if (isset($widget_settings[$id]['options']['position'])) {
        $return['widgets'][$id]['options']['position'] = $widget_settings[$id]['options']['position'];
      }
    }

    return $return;
  }

  function render_region($region_id, $panes) {
    $id = $this->getGridmasterId($region_id);
    $widget_settings = array();

    if (isset($this->display->panel_settings['display_settings'][$id]['widgets'])) {
      $widget_settings = $this->display->panel_settings['display_settings'][$id]['widgets'];
      array_map(function(&$item) { unset($item->{'$$hashKey'}); }, $widget_settings);
    }

    drupal_add_library('gridster', 'gogridster');
    drupal_add_js(
      array('gridster' => array($id => $this->buildStructure($region_id, $panes, $widget_settings))),
      array('type' => 'setting')
    );

    // Generate this region's 'empty' placeholder pane from the IPE plugin.
    $empty_ph = theme('panels_ipe_placeholder_pane', array(
      'region_id' => $region_id,
      'region_title' =>  $this->plugins['layout']['regions'][$region_id]
    ));

    // Wrap the placeholder in some guaranteed markup.
    $control = '<div class="panels-ipe-placeholder panels-ipe-on panels-ipe-portlet-marker panels-ipe-portlet-static">'
      . $empty_ph . theme('panels_ipe_add_pane_button', array(
          'region_id' => $region_id,
          'display' => $this->display,
          'renderer' => $this
      ))
      . "</div>";

    $output = theme('panels_ipe_region_wrapper', array(
      'output' => '',
      'region_id' => $region_id,
      'display' => $this->display,
      'controls' => $control,
      'renderer' => $this
    ));

    return "<div"
        . " id='panels-ipe-regionid-{$region_id}'"
        // . " id='{$id}'"
        . " class='panels-ipe-region'"
        . " data-region='{$region_id}'"
        . " ng-app='{$id}'"
        . " ng-controller='gridsterCtrl'"
        . ">{$output}</div>";
  }

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
