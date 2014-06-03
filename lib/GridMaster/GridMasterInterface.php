<?php

namespace Drupal\gridster\Gridster;

interface GridMasterInterface {

  /**
   * @return uuid
   */
  public function getId();

  /**
   * @return <GridMasterWidgetInterface> keyed array of existing widgets.
   */
  public function getWidgets();

  /**
   * Get widget by UUID.
   *
   * @param uuid $uuid
   * @return GridMasterWidgetInterface
   */
  public function getWidget(string $uuid);

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

  /**
   * Setter for render property.
   *
   * @param \Drupal\gridster\Gridster\Helper\RenderInterface $render
   */
  public function setRender(Helper\RenderInterface $render);

  /**
   * Getter for render property.
   *
   * @return Helper\RenderInterface
   */
  public function getRender();

  /**
   * Render gridster, should use render property to process.
   *
   * @return string
   */
  public function render();
}
