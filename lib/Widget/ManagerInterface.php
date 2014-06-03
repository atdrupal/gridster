<?php

namespace Drupal\gridster\Widget;

interface ManagerInterface {

  /**
   * Load widget by type & id.
   *
   * @param string $type
   * @param string $id
   */
  public function loadWidget($type, $id);
}
