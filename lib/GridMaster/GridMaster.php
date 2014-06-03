<?php

namespace Drupal\gridster\Gridster;

class GridMaster implements GridMasterInterface {

  public function addWidget(\Drupal\gridster\Widget\WidgetInterface $widget) {

  }

  public function getId() {

  }

  public function getWidgets() {

  }

  /**
   * @param string $uuid
   * @return GridMasterWidgetInterface
   */
  public function getWidget(string $uuid) {
  }

  /**
   * @return Helper\RenderInterface
   */
  public function getRender() {

  }

  public function removeWidget(GridMasterWidgetInterface $gm_widget) {

  }

  public function removeWidgetById(string $gm_widget_id) {

  }

  public function render() {

  }

  public function setRender(Helper\RenderInterface $render) {

  }

}
