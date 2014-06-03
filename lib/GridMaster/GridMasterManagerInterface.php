<?php

namespace Drupal\gridster\Gridster;

interface GridMasterManagerInterface {

  /**
   * Load grid-master by ID.
   *
   * @param uuid $uuid
   * @return GridMasterInterface
   */
  public function load($uuid);

  /**
   * Load multiple grid-master by IDs.
   *
   * @param <uuid> $uuids
   */
  public function loadMultiple($uuids);

  /**
   * Delete a grid-master by ID.
   *
   * @param uuid $uuid
   */
  public function delete($uuid);

  /**
   * Delete multiple grid-master.
   *
   * @param <uuid> $uuids
   */
  public function deleteMultiple($uuids);

  /**
   * Save grid-master to DB.
   *
   * @return uuid
   */
  public function save(GridMasterInterface $grid_master);

  /**
   * Save multiple grid-masters.
   *
   * @param <GridMasterInterface> $grid_masters
   */
  public function saveMultiple(array $grid_masters);

  /**
   * @return JSONImporterInterface
   */
  public function getJSONImporter();
}
