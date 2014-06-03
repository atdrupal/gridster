<?php

namespace Drupal\gridster\Widget;

interface WidgetTypeInterface {

  /**
   * Get name of widget type.
   */
  public function getName();

  /**
   * Get option for a specific widget.
   */
  public function getAvailableOptions();

  /**
   * Get settings form for widget
   */
  public function getSettingsForm();

  /**
   * Get all widgets.
   */
  public function getWidgets();

  /**
   * Store widget option.
   *
   * @param \Drupal\gridster\WidgetInterface $widget
   * @param array $options
   */
  public function saveOptions(WidgetInterface $widget, array $options);
}
