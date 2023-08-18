<?php

/**
 * @file
 * Provide views data for quick_node_clone.module.
 */

/**
 * Implements hook_views_data_alter().
 */
function viewfieldplugin_views_data_alter(&$data) {
  $data['node']['node_link'] = [
    'title' => t('Node Link'),
    'help' => t('Generate a link to the node.'),
    'field' => [
      'id' => 'new_node_link',
    ],
  ];
}
