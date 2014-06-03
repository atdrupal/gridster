<?php

namespace Drupal\gridster\Gridster\Helper;

interface RenderInterface {
  /**
   * Setter for grid_master property.
   *
   * @param \Drupal\gridster\Gridster\GridMasterInterface $grid_master
   */
  public function setGridMaster(\Drupal\gridster\Gridster\GridMasterInterface $grid_master);

  /**
   * Main method to process and output grid-master.
   *
   * @return string
   */
  public function render();
}
