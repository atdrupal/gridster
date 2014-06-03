<?php

namespace Drupal\gridster\Gridster;

interface GridMasterInterface {

  /**
   * @return uuid
   */
  public function getId();

  /**
   * @return <WidgetInterface> keyed array of existing widgets.
   */
  public function getWidgets();

  /**
   * Add a widget to grid-master.
   *
   * @param \Drupal\gridster\Widget\WidgetInterface $widget
   */
  public function addWidget(GridMasterWidgetInterface $gm_widget);

  /**
   * Remove widget from grid-master.
   */
  public function removeWidget(GridMasterWidgetInterface $gm_widget);

  /**
   * Remove widget from grid-master by ID.
   *
   * @param uuid $gm_widget_id
   */
  public function removeWidgetById(string $gm_widget_id);
}
