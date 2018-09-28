<?php
/**
 * @file
 * calendar_content_type.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function calendar_content_type_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_node_info().
 */
function calendar_content_type_node_info() {
  $items = array(
    'calendar_item' => array(
      'name' => t('Calendar item'),
      'base' => 'node_content',
      'description' => t('An item to be displayed on the MMA Events Calendar'),
      'has_title' => '1',
      'title_label' => t('Event Name'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
