<?php

namespace Drupal\gridster;

use panels_renderer_ipe;

class Render extends panels_renderer_ipe {
  protected $pane_info = array();

  protected function getGridmasterId($region_id) {
    return sprintf('gridsterApp__%s__%s', $this->display->did, $region_id);
  }

  function ___render_pane(&$pane) {
    module_invoke_all('panels_pane_prerender', $pane);
    $content = $this->render_pane_content($pane);

    if ($this->display->hide_title == PANELS_TITLE_PANE && !empty($this->display->title_pane) && $this->display->title_pane == $pane->pid) {
      if (empty($content->title) && !empty($content->original_title)) {
        $this->display->stored_pane_title = $content->original_title;
      }
      else {
        $this->display->stored_pane_title = !empty($content->title) ? $content->title : '';
      }
    }

    if (!empty($content->content)) {
      $this->pane_info[$pane->pid] = $content;
      return $content->content;
    }
  }
}
