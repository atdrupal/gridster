<?php

namespace Drupal\gridster\Gridster;

interface GridMasterWidgetInterface {

  /**
   * @param uuid $uuid
   */
  public function setId($uuid);

  /**
   * @return uuid
   */
  public function getId();

  /**
   * Set status for gm-widget.
   *
   * @param bool $status
   */
  public function setStatus($status);

  /**
   * Get current status of gm-widget.
   *
   * @return boolean
   */
  public function getStatus();

  /**
   * Get widget options.
   *
   * @return array
   */
  public function getOptions();

  /**
   * Set widget options.
   */
  public function setOptions(array $options);

  /**
   * Get widget type.
   *
   * @return string
   */
  public function getWidgetType();

  /**
   * Set widget type.
   *
   * @param string $type
   */
  public function setWidgetType($type);

  /**
   * @return \Drupal\gridster\Widget\WidgetInterface
   */
  public function getWidget();
}
