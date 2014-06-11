<?php

namespace Drupal\gridster;

class RenderIPE extends Render {
  protected function getGridmasterId($region_id) {
    return sprintf('gridsterApp__%s__%s', $this->display->did, $region_id);
  }

  protected function buildStructure($region_id, $panes, $widget_settings) {
    $return = array(
      'id' => $this->getGridmasterId($region_id),
      'title' => "[$region_id]",
      'options' => array(
        'draggable' => array('enabled' => false),
        'resizable' => array('enabled' => false),
      ),
    );

    foreach ($panes as $id => $content) {
      $return['widgets'][$id] = array(
        'id' => $id,
        'label' => '%label',
        'title' => isset($this->pane_info[$id]->title) ? $this->pane_info[$id]->title : '',
        'content' => $content,
        'options' => array(
          'position' => array('col' => 0, 'row' => 0, 'sizeX' => 1, 'sizeY' => 1)
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

    return "<div id='{$id}' ng-app='{$id}' ng-controller='gridsterCtrl'></div>";
  }
}
