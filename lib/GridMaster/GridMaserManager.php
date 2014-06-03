<?php

namespace Drupal\gridster\Gridster;

class GridMasterManager implements GridMasterManagerInterface {
  public function delete($uuid) {

  }

  public function deleteMultiple($uuids) {

  }

  /**
   * Load grid-master by ID.
   *
   * @param uuid $uuid
   * @return GridMasterInterface
   */
  public function load($uuid) {
  }

  public function loadMultiple($uuids) {

  }

  public function save(GridMasterInterface $grid_master) {

  }

  public function saveMultiple(array $grid_masters) {

  }

  /**
   * @inheritedoc
   *
   * @return Helper\JSONImporterInterface
   */
  public function getJSONImporter() {
  }
}
