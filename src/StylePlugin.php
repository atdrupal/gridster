<?php

namespace Drupal\gridseter;

use panels_display;

class StylePlugin {

  /**
   * @var panels_display
   */
  private $display;

  /**
   * @var string
   */
  private $region_id;

  /**
   * @var string
   */
  private $name;

  /**
   * @param panels_display $display
   * @param string $region_id
   */
  public function __construct($display, $region_id) {
    $this->display = $display;
    $this->region_id = $region_id;
    $this->name = sprintf('gridsterApp__%s__%s', $display->did, $region_id);
  }

  public function render() {
    $build = $this->build();
    return render($build);
  }

  private function build() {
    $output = '<div id="%s" ng-app="%s" ng-controller="gridsterCtrl"></div>';

    $attachments['library'][] = array('gridster', 'gogridster');
    $attachments['js'][] = array('type' => 'setting', 'data' => array(
        'gridster' => array(
          $this->name => array(
            'id' => $this->name,
            'widgets' => $this->buildWidgets(),
          )
        ),
    ));

    return array(
      '#markup' => sprintf($output, $this->name, $this->name),
      '#attached' => $attachments
    );
  }

  private function buildWidgets() {
    return array();
  }

}
