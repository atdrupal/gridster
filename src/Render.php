<?php

namespace Drupal\gridster;

use panels_renderer_ipe;

class Render extends panels_renderer_ipe {
  protected $pane_info = array();

  protected function getGridmasterId($region_id) {
    return sprintf('gridsterApp__%s__%s', $this->display->did, $region_id);
  }

  function render_pane(&$pane) {
    module_invoke_all('panels_pane_prerender', $pane);
    $content = $this->render_pane_content($pane);

    if ($this->display->hide_title == PANELS_TITLE_PANE && !empty($this->display->title_pane) && $this->display->title_pane == $pane->pid) {
      if (empty($content->title) && !empty($content->original_title)) {
        $this->display->stored_pane_title = $content->original_title;
      }
      else {
        $this->display->stored_pane_title = !empty($content->title) ? $content->title : '';
      }
    }

    if (!empty($content->content)) {
      $this->pane_info[$pane->pid] = $content;
      $output = is_string($content->content) ? $content->content : '%gridster_template_aware';
      $output = theme('panels_ipe_pane_wrapper', array('output' => $output, 'pane' => $pane, 'display' => $this->display, 'renderer' => $this));
      return "<div id=\"panels-ipe-paneid-{$pane->pid}\" class=\"panels-ipe-portlet-wrapper panels-ipe-portlet-marker\">" . $output . "</div>";
    }
  }

  protected function buildStructure($region_id, $panes, $widget_settings) {
    $return = array(
      'id' => $this->getGridmasterId($region_id),
      'title' => '', // @todo Provide an option to render region title
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

      if (false !== strpos($return['widgets'][$id]['content'], '%gridster_template_aware')) {
        if (isset($this->pane_info[$id]->template)) {
          $return['widgets'][$id]['template'] = $this->pane_info[$id]->template;
          list($prefix, $suffix) = explode('%gridster_template_aware', $return['widgets'][$id]['content']);
          $return['widgets'][$id]['content'] = $this->pane_info[$id]->content;
          $return['widgets'][$id]['prefix'] = $prefix;
          $return['widgets'][$id]['suffix'] = $suffix;
        }
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
        . " class='panels-ipe-region'"
        . " data-region='{$region_id}'"
        . " ng-app='{$id}'"
        . " ng-controller='gridsterCtrl'"
        . ">{$output}</div>";
  }
}
