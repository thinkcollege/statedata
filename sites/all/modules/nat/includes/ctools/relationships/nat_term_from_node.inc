<?php

/**
 * @file
 * Provides a CTools (Panels) relationship that gets a term context from the
 * node context based on terms used by Taxonomy Node.
 */

/**
 * Implementation of specially named hook_ctools_relationships().
 */
function nat_nat_term_from_node_ctools_relationships() {
  $args['nat_term_from_node'] = array(
    'title' => t("Term from node (NAT)"),
    'keyword' => 'nat_term',
    'description' => t('Adds a NAT term from node context'),
    'required context' => new ctools_context_required(t('Node'), 'node'),
    'context' => 'nat_nat_term_from_node_ctools_context',
    'edit form' => 'nat_nat_term_from_node_settings_form',
    'defaults' => array('vid' => array(), 'concatenator' => ','),
  );
  
  return $args;
}

/**
 * Return a new context based on an existing context.
 */
function nat_nat_term_from_node_ctools_context($context, $conf) {
  // If unset it wants a generic, unfilled context, which is just NULL.
  if (empty($context->data)) {
    return ctools_context_create_empty('terms', NULL);
  }

  // Collect all terms for the chosen vocabulary and concatenate them.
  if (isset($context->data->nat)) {
    $terms = array();
    foreach ($context->data->nat as $term) {
      if (in_array($term->vid, $conf['vid'])) {
        $terms[] = $term->tid;
      }
    }

    if (!empty($terms)) {
      $all_terms = ctools_break_phrase(implode($conf['concatenator'], $terms));
      return ctools_context_create('terms', $all_terms);
    }
  }
}

/**
 * Settings form for the relationship.
 */
function nat_nat_term_from_node_settings_form($form, &$form_state) {
  $conf = $form_state['conf'];

  $options = array();
  foreach (taxonomy_get_vocabularies() as $vid => $vocabulary) {
    $options[$vid] = $vocabulary->name;
  }
  $form['vid'] = array(
    '#title' => t('Vocabulary'),
    '#type' => 'checkboxes',
    '#options' => $options,
    '#default_value' => $conf['vid'],
    '#prefix' => '<div class="clearfix">',
    '#suffix' => '</div>',
  );
  $form['concatenator'] = array(
    '#title' => t('Concatenator'),
    '#type' => 'select',
    '#options' => array(',' => ', (AND)', '+' => '+ (OR)'),
    '#default_value' => $conf['concatenator'],
    '#prefix' => '<div class="clearfix">',
    '#suffix' => '</div>',
    '#description' => t("When the value from this context is passed on to a view as argument, the terms can be concatenated in the form of 1+2+3 (for OR) or 1,2,3 (for AND)."),
  );

  return $form;
}