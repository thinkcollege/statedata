<?php
/**
 * @file
 * bootstrap_freelancer_common.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function bootstrap_freelancer_common_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "context" && $api == "context") {
    return array("version" => "3");
  }
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
  if ($module == "template_api" && $api == "template_api") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_node_info().
 */
function bootstrap_freelancer_common_node_info() {
  $items = array(
    'block' => array(
      'name' => t('block'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
