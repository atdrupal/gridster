<?php

namespace Drupal\gridster\Gridster\Helper;

interface JSONImporterInterface {

  /**
   * Set json input.
   *
   * @param string $json
   */
  public function setInput(string $json);

  /**
   * Start importing.
   *
   * @return \Drupal\gridster\Gridster\GridMasterInterface
   */
  public function import();
}
