<?php

/**
 * @file
 * On behalf implementation of Feeds mapping API for date.module.
 */

/**
 * Implements hook_feeds_processor_targets().
 */
function date_feeds_processor_targets($entity_type, $bundle_name) {
  $targets = array();

  $field_types = array(
    'date' => TRUE,
    'datestamp' => TRUE,
    'datetime' => TRUE,
  );

  foreach (field_info_instances($entity_type, $bundle_name) as $name => $instance) {
    $info = field_info_field($name);

    if (!isset($field_types[$info['type']])) {
      continue;
    }

    $targets[$name . ':start'] = array(
      'name' => check_plain($instance['label']),
      'callback' => 'date_feeds_set_target',
      'description' => t('The start date for the @name field. Also use if mapping both start and end.', array('@name' => $instance['label'])),
      'real_target' => $name,
      'summary_callbacks' => array('date_feeds_summary_callback'),
      'form_callbacks' => array('date_feeds_form_callback'),
    );

    if (!empty($info['settings']['todate'])) {
      // Change the label for the start date.
      $targets[$name . ':start']['name'] = t('@name: Start', array('@name' => $instance['label']));

      $targets[$name . ':end'] = array(
        'name' => t('@name: End', array('@name' => $instance['label'])),
        'callback' => 'date_feeds_set_target',
        'description' => t('The end date for the @name field.', array('@name' => $instance['label'])),
        'real_target' => $name,
      );
    }
  }

  return $targets;
}

/**
 * Callback for setting date values.
 */
function date_feeds_set_target(FeedsSource $source, $entity, $target, array $values) {
  list($field_name, $sub_field) = explode(':', $target, 2);

  $delta = 0;
  foreach ($values as $value) {

    if (!($value instanceof FeedsDateTimeElement)) {

      if (empty($value) || !is_numeric($value) && is_string($value) && !date_create($value)) {
        $value = new FeedsDateTimeElement(NULL, NULL);
      }
      elseif ($sub_field == 'end') {
        $value = new FeedsDateTimeElement(NULL, $value);
      }
      else {
        $value = new FeedsDateTimeElement($value, NULL);
      }
    }

    $value->buildDateField($entity, $field_name, $delta);
    $delta++;
  }
}
