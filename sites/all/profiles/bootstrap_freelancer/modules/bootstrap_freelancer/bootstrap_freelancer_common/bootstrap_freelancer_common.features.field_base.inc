<?php
/**
 * @file
 * bootstrap_freelancer_common.features.field_base.inc
 */

/**
 * Implements hook_field_default_field_bases().
 */
function bootstrap_freelancer_common_field_default_field_bases() {
  $field_bases = array();

  // Exported field_base: 'body'
  $field_bases['body'] = array(
    'active' => 1,
    'cardinality' => 1,
    'deleted' => 0,
    'entity_types' => array(
      0 => 'node',
    ),
    'field_name' => 'body',
    'foreign keys' => array(
      'format' => array(
        'columns' => array(
          'format' => 'format',
        ),
        'table' => 'filter_format',
      ),
    ),
    'indexes' => array(
      'format' => array(
        0 => 'format',
      ),
    ),
    'locked' => 0,
    'module' => 'text',
    'settings' => array(),
    'translatable' => 0,
    'type' => 'text_with_summary',
  );

  // Exported field_base: 'field_field_template'
  $field_bases['field_field_template'] = array(
    'active' => 1,
    'cardinality' => 1,
    'deleted' => 0,
    'entity_types' => array(),
    'field_name' => 'field_field_template',
    'foreign keys' => array(),
    'indexes' => array(),
    'locked' => 0,
    'module' => 'template_field',
    'settings' => array(),
    'translatable' => 0,
    'type' => 'template_field',
  );

  return $field_bases;
}
