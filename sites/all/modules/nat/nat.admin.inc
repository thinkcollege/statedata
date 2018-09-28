<?php

/**
 * @file
 * NAT module administrative forms.
 */

/**
 * Menu callback: NAT module settings form.
 */
function nat_settings_form() {
  $types = node_type_get_types();
  $vocabularies = _nat_get_vocabularies();

  if (empty($vocabularies)) {
    drupal_set_message(t('The NAT module requires at least one vocabulary to be defined.'), 'error');
    drupal_goto('admin/content/taxonomy');
  }

  $nat_config = _nat_variable_get();

  $form['nat_node_config'] = array('#type' => 'vertical_tabs');

  foreach ($types as $type => $type_object) {
    $collapsed = (!isset($nat_config['types'][$type])) || (empty($nat_config['types'][$type]));
    $form['nat_' . $type] = array(
      '#type' => 'fieldset',
      '#title' => check_plain($type_object->name),
      '#group' => 'nat_node_config',
      '#collapsible' => TRUE,
      '#collapsed' => $collapsed
    );
    $form['nat_' . $type][$type] = array(
      '#type' => 'select',
      '#title' => t('Vocabularies'),
      '#options' => $vocabularies,
      '#default_value' => isset($nat_config['types'][$type]) ? $nat_config['types'][$type] : array(),
      '#multiple' => TRUE,
      '#description' => t('Creating a node of type %type will automatically create a term in any selected vocabularies.', array('%type' => $type)),
      '#parents' => array('types', $type)
    );
    $form['nat_' . $type]['delete_' . $type] = array(
      '#type' => 'checkbox',
      '#title' => t('Delete associated term if a node is deleted.'),
      '#default_value' => isset($nat_config['delete'][$type]) ? $nat_config['delete'][$type] : 0,
      '#parents' => array('delete', $type)
    );
  }
  $form['submit'] = array('#type' => 'submit', '#value' => t('Save configuration'));

  return $form;
}

/**
 * Process NAT settings form submissions.
 */
function nat_settings_form_submit($form, &$form_state) {
  $form_values = $form_state['values'];

  $nat_config = _nat_variable_get();
  $nat_config['types'] = $form_values['types'];
  $nat_config['delete'] = array_filter($form_values['delete']);

  variable_set('nat_config', $nat_config);

  drupal_set_message(t('Configuration settings saved. If new node types have been associated with NAT, ensure that their fields have been linked as necessary via the <a href="!fields-url">Fields</a> tab.', array('!fields-url' => url('admin/structure/nat/fields'))));
}

/**
 * Menu callback: NAT module fields form.
 * @todo This form is something of a mess and could use a little clean-up.
 */
function nat_fields_form() {
  $nat_config = _nat_variable_get();
  $all_types = node_type_get_types();
  $all_vocabularies = _nat_get_vocabularies();

  $form['nat_field_config'] = array('#type' => 'vertical_tabs');
  $header = array(
    'node' => array('data' => t('Node field')),
    'term' => array('data' => t('Term field'))
  );

  foreach ($nat_config['types'] as $type => $vocabularies) {
    $node_fields = array_map('_nat_field_label', field_info_instances('node', $type));
    $node_fields = array_filter($node_fields);
    $node_fields = array('0' => t('--None--'), 'title' => t('Title (inbuilt)')) + $node_fields;
    foreach ($vocabularies as $vid) {
      $vocabulary = taxonomy_vocabulary_load($vid);
      $term_fields = array_map('_nat_field_label', field_info_instances('taxonomy_term', $vocabulary->machine_name));
      $term_fields = array('0' => t('--None--'), 'name' => t('Name (inbuilt)'), 'description' => t('Description (inbuilt)')) + $term_fields;

      $form_field_name = "nat_$type-$vid";
      $form[$form_field_name] = array(
        '#title' => check_plain($all_types[$type]->name . '<->' . $all_vocabularies[$vid]),
        '#type' => 'fieldset',
        '#description' => t('Match fields from the node form to their corresponding fields in the taxonomy term form.'),
        '#group' => 'nat_field_config'
      );

      $rows = array();
      $i = 0;
      foreach ($term_fields as $name => $field) {
        if ($name != '0') {
          $association_exists = isset($nat_config['associations'][$type]) && isset($nat_config['associations'][$type][$vid]);
          $association = $association_exists && isset($nat_config['associations'][$type][$vid][$name]) ? $name : NULL;
          $rows[] = array(
           'node' => array(
              '#type' => 'select',
              '#options' => $node_fields,
              '#parents' => array('nat', $type, $vid, $i, 'node'),
              '#default_value' => isset($association) ? array($nat_config['associations'][$type][$vid][$name]) : array()
            ),
            'term' => array(
              '#type' => 'select',
              '#options' => $term_fields,
              '#parents' => array('nat', $type, $vid, $i++, 'term'),
              '#default_value' => isset($association) ? array($name) : array()
            )
          );
        }
      }

      $form[$form_field_name]['table'] = array(
        '#theme' => 'nat_table',
        'header' => array('#type' => 'value', '#value' => $header),
        'rows' => $rows
      );
    }
  }

  $form['associations'] = array('#type' => 'value', '#value' => array());
  $form['submit'] = array('#type' => 'submit', '#value' => t('Save field configuration'));

  return $form;
}

/**
 * Validate NAT fields form submissions.
 */
function nat_fields_form_validate($form, &$form_state) {
  $form_values = $form_state['values'];

  $all_types = node_type_get_types();
  $all_vocabularies = _nat_get_vocabularies();

  $associations = $term_title_check = array();
  foreach ($form_values['nat'] as $node_type => $vocabulary) {
    foreach ($vocabulary as $vid => $fields) {
      $fieldset = $all_types[$node_type]->name . '<->' . $all_vocabularies[$vid];
      foreach ($fields as $id => $field) {
        // Remove unassociated fields.
        $field = array_filter($field);

        // The title, name and description fields are inbuilt fields.
        if (count($field) > 1) {
          if ($field['node'] == 'title') {
            $field_type_node = 'text';
          }
          else {
            $field_info_node = field_info_field($field['node']);
            $field_type_node = $field_info_node['type'];
          }
          if ($field['term'] == 'name' || $field['term'] == 'description') {
            $field_type_term = 'text';
          }
          else {
            $field_info_term = field_info_field($field['term']);
            $field_type_term = $field_info_term['type'];
          }

          // Check if the fields are compatible.
          if (_nat_field_types_match($field_type_node, $field_type_term)) {
            // The term title field is pretty much the only required field.
            if ($field['term'] == 'name') {
              $term_title_check[$node_type][$vid] = TRUE;
            }
            // We assume that the fields are in the order term => node.
            $associations[$node_type][$vid][$field['term']] = $field['node'];
          }
          else {
            // form_set_error does not like fields which are any more specific.
            form_set_error('nat_' . $node_type . '-' . $vid, t('[%fieldset] The field types of the node field, %field_node, and the term field, %field_term, do not match', array('%fieldset' => $fieldset, '%field_node' => $field['node'], '%field_term' => $field['term'])));
          }
        }
      }

      if (!isset($associations[$node_type]) || !isset($associations[$node_type][$vid]) || count($associations[$node_type][$vid]) == 0) {
        form_set_error('nat_' . $node_type . '-' . $vid, t('Each node-term association should have at least one field association.'));
      }
    }
  }

  // Check for the presence of the title field in each association.
  foreach ($associations as $node_type => $vocabularies) {
    foreach ($vocabularies as $vid => $fields) {
      if (!isset($term_title_check[$node_type][$vid])) {
        form_set_error('nat_' . $node_type . '-' . $vid, t('At least one of the term fields associated with the %type node type has to be the title field.', array('%type' => $node_type)));
      }
    }
  }

  form_set_value($form['associations'], $associations, $form_state);
}

/**
 * Process NAT fields form submissions.
 */
function nat_fields_form_submit($form, &$form_state) {
  $form_values = $form_state['values'];
  $nat_config = _nat_variable_get();
  $nat_config['associations'] = $form_values['associations'];

  variable_set('nat_config', $nat_config);

  drupal_set_message(t('Configuration settings saved.'));
}

/**
 * Check if the node and term field types are compatible.
 *
 * @param $field_type_node
 *   The node field type.
 * @param $field_type_term
 *   The term field type.
 * @return Boolean
 *   Returns TRUE if compatible and FALSE otherwise.
 */
function _nat_field_types_match($field_type_node, $field_type_term) {
  If ($field_type_node == $field_type_term) {
    return TRUE;
  }
  $field_type_node = _nat_field_type_resolve($field_type_node);
  $field_type_term = _nat_field_type_resolve($field_type_term);

  return $field_type_node == $field_type_term;
}

/**
 * Resolve equivalent field types.
 * @todo This need proper fleshing out.
 *
 * @param $type
 *   The field type in question.
 * @return
 *   Returns an equivalent field type.
 */
function _nat_field_type_resolve($type) {
  switch ($type) {
    case 'text_long':
    case 'text_with_summary':
    case 'text':
      return 'text';
    default:
      return $type;
  }
}

/**
 * Sync the NAT table with the node table for associated vocabularies.
 */
function nat_sync_form() {
  $vocabularies = _nat_get_vocabularies();

  if (empty($vocabularies)) {
    drupal_set_message(t('The NAT module requires at least one vocabulary to be defined.'), 'error');
    drupal_goto('admin/content/taxonomy');
  }

  $nat_config = _nat_variable_get();
  $options = array();
  foreach ($nat_config['types'] as $type => $associations) {
    if (!empty($associations)) {
      foreach ($associations as $vid) {
        $options[$type . '|' . $vid] = t('@type &lsaquo;-&rsaquo; !vocabulary', array('@type' => $type, '!vocabulary' => $vocabularies[$vid]));
      }
    }
  }
  if (empty($options)) {
    drupal_set_message(t('There are no vocabularies available to sync.'));
    drupal_goto('admin/settings/nat');
  }

  $form['sync'] = array(
    '#type' => 'fieldset',
    '#title' => t('Sync associations'),
    '#description' => t('The Sync operation will create NAT associations (and terms) for nodes (marked for NAT association) not present in the NAT table.'),
    '#collapsible' => TRUE
  );
  $form['sync']['vocabularies'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Select the vocabularies to sync with associated node tables'),
    '#description' => t('Any nodes not already NAT associated with the selected vocabularies will be associated.'),
    '#required' => TRUE,
    '#options' => $options
  );
  $form['submit'] = array('#type' => 'submit', '#value' => t('Sync tables'));

  return $form;
}

/**
 * Process NAT sync form submissions.
 */
function nat_sync_form_submit($form, &$form_state) {
  _nat_sync_associations(array_filter($form_state['values']['vocabularies']));
}

/**
 * Synchronize NAT node-term relationships. Create associated terms for node
 * where missing.
 *
 * @param $associations
 *   Associative array denoting the node-vocabulary pair that is to be synced.
 */
function _nat_sync_associations($associations) {
  $counter = 0;
  foreach ($associations as $association) {
    $association = explode('|', $association);
    // This query can possibly be improved.
    $result = db_query("SELECT n.nid FROM {node} n LEFT JOIN {nat} n1 ON (n.nid = n1.nid AND n1.vid = :vid) LEFT JOIN {nat} n2 ON (n.nid = n2.nid AND n2.nid <> n1.nid) WHERE n.type = :type AND n1.nid IS NULL", array(':vid' => $association[1], ':type' => $association[0]));
    foreach ($result as $node) {
      // We need to execute a node_load in order to load field information.
      $node = node_load($node->nid);

      // Add node title as terms.
      $terms = _nat_add_terms($node, array($association[1]));

      // Save node-term association in the NAT table.
      _nat_save_association($node->nid, $terms);

      $counter++;
    }
  }

  drupal_set_message(t('NAT sync complete: %count nodes synced.', array('%count' => $counter)));
}

/**
 * Retrieve the field label for the field which can be synchronized.
 *
 * @param Array $field
 *   The field to be analysed.
 */
function _nat_field_label($field) {
  $field_info = field_info_field($field['field_name']);
  return $field['label'] . " (" . $field['field_name'] . ')';
}

/**
 * Theme table elements within the NAT field configuration form.
 *
 * @param $variables
 *   Contains an associative array containing the element to be themed.
 */
function theme_nat_table($variables) {
  $element = $variables['element'];

  $rows = array();
  foreach ($element['rows'] as $id => $value) {
    if (is_numeric($id)) {
      $rows[$id]['node'] = drupal_render($element['rows'][$id]['node']);
      $rows[$id]['term'] = drupal_render($element['rows'][$id]['term']);
    }
  }

  return theme('table', array('header' => $element['header']['#value'], 'rows' => $rows));
}
