<?php
/**
 * @file
 * This example shows how to use AJAX when altering a node form.
 *
 * It maintains a table parallel to the node table containing attributes
 * 'example_1' and 'example_2' which are displayed on the node form.
 * 'example_2' is displayed dynamically when example_1 is checked.
 */

/**
 * Implements hook_form_FORM_ID_alter() for the node form.
 *
 * Adds two fields to the node form, second only appears after first is enabled.
 */
function d3_statedata_form_node_form_alter(&$form, &$form_state, $form_id) {
  $node = $form['#node'];
  $form['d3_statedata_1'] = array(
    '#type' => 'checkbox',
    '#title' => t('AJAX Example 1'),
    '#description' => t('Enable to show second field.'),
    '#default_value' => $node->d3_statedata['example_1'],
    '#ajax' => array(
      'callback' => 'd3_statedata_form_node_callback',
      'wrapper' => 'ajax-example-form-node',
      'effect' => 'fade',
    )
  );
  $form['container'] = array(
    '#prefix' => '<div id="ajax-example-form-node">',
    '#suffix' => '</div>',
  );

  // If the state values exist and 'd3_statedata_1' state value is 1 or
  // if the state values don't exist and 'example1' variable is 1 then
  // display the d3_statedata_2 field.
  if (!empty($form_state['values']['d3_statedata_1']) && $form_state['values']['d3_statedata_1'] == 1
      || empty($form_state['values']) && $node->d3_statedata['example_1']) {

    $form['container']['d3_statedata_2'] = array(
      '#type' => 'textfield',
      '#title' => t('AJAX Example 2'),
      '#description' => t('AJAX Example 2'),
      '#default_value' => empty($form_state['values']['d3_statedata_2']) ?
                          $node->d3_statedata['example_2'] :
                          $form_state['values']['d3_statedata_2'],
    );
  }
}

/**
 * Returns changed part of the form.
 *
 * @return renderable array
 *
 * @see d3_statedata_form_node_form_alter()
 */
function d3_statedata_form_node_callback($form, $form_state) {
  return $form['container'];
}

/**
 * Implements hook_node_submit().
 * @see d3_statedata_form_node_form_alter()
 */
function d3_statedata_node_submit($node, $form, &$form_state) {
  $values = $form_state['values'];
  // Move the new data into the node object.
  $node->d3_statedata['example_1'] = $values['d3_statedata_1'];
  // Depending on the state of d3_statedata_1; it may not exist.
  $node->d3_statedata['example_2'] = isset($values['d3_statedata_2']) ? $values['d3_statedata_2'] : '';
}

/**
 * Implements hook_node_prepare().
 *
 * @see d3_statedata_form_node_form_alter()
 */
function d3_statedata_node_prepare($node) {
  if (empty($node->d3_statedata)) {
    // Set default values, since this only runs when adding a new node.
    $node->d3_statedata['example_1'] = 0;
    $node->d3_statedata['example_2'] = '';
  }
}

/**
 * Implements hook_node_load().
 *
 * @see d3_statedata_form_node_form_alter()
 */
function d3_statedata_node_load($nodes, $types) {
  $result = db_query('SELECT * FROM {d3_statedata_node_form_alter} WHERE nid IN(:nids)', array(':nids' => array_keys($nodes)))->fetchAllAssoc('nid');

  foreach ($nodes as &$node) {
    $node->d3_statedata['example_1'] =
      isset($result[$node->nid]->example_1) ?
      $result[$node->nid]->example_1 : 0;
    $node->d3_statedata['example_2'] =
      isset($result[$node->nid]->example_2) ?
      $result[$node->nid]->example_2 : '';
  }
}

/**
 * Implements hook_node_insert().
 *
 * @see d3_statedata_form_node_form_alter()
 */
function d3_statedata_node_insert($node) {
  if (isset($node->d3_statedata)) {
    db_insert('d3_statedata_node_form_alter')
      ->fields(array(
        'nid' => $node->nid,
        'example_1' => $node->d3_statedata['example_1'],
        'example_2' => $node->d3_statedata['example_2'],
      ))
      ->execute();
  }
}

/**
 * Implements hook_node_update().
 * @see d3_statedata_form_node_form_alter()
 */
function d3_statedata_node_update($node) {
  if (db_select('d3_statedata_node_form_alter', 'a')->fields('a')->condition('nid', $node->nid, '=')->execute()->fetchAssoc()) {
    db_update('d3_statedata_node_form_alter')
      ->fields(array(
        'example_1' => $node->d3_statedata['example_1'],
        'example_2' => $node->d3_statedata['example_2'],
      ))
      ->condition('nid', $node->nid)
      ->execute();
  }
  else {
    // Cleaner than doing it again.
    d3_statedata_node_insert($node);
  }
}

/**
 * Implements hook_node_delete().
 * @see d3_statedata_form_node_form_alter()
 */
function d3_statedata_node_delete($node) {
  db_delete('d3_statedata_node_form_alter')
    ->condition('nid', $node->nid)
    ->execute();
}
