<?php
/**
 * @file
 * ymstuff.features.inc
 */

/**
 * Implements hook_node_info().
 */
function ymstuff_node_info() {
  $items = array(
    'page' => array(
      'name' => t('Page'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}
