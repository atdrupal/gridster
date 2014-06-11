<?php

/**
 * @file
 */

/**
 * Implements hook_default_panels_renderer_pipeline().
 */
function gridster_default_panels_renderer_pipeline() {
  $pipeline = new stdClass();
  $pipeline->disabled = FALSE;
  $pipeline->api_version = 1;
  $pipeline->name = 'gridster_ipe';
  $pipeline->admin_title = '[Gridster] ' . t('In-Place Editor');
  $pipeline->admin_description = t('Allows privileged users to update and rearrange the content while viewing this panel.');
  $pipeline->weight = 0;
  $pipeline->settings = array(
    'renderers' => array(
      0 => array(
        'access' => array(
          'plugins' => array(
            0 => array(
              'name' => 'perm',
              'settings' => array(
                'perm' => 'use panels in place editing',
              ),
              'context' => 'logged-in-user',
            ),
          ),
          'logic' => 'and',
        ),
        'renderer' => 'gridster_ipe',
        'options' => array(),
      ),
    ),
  );

  return array($pipeline->name => $pipeline);
}
