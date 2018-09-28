<?php
/**
 * Add body classes if certain regions have content.
 */
function freelancer_bootstrap_preprocess_html(&$variables) {
  if (!empty($variables['page']['featured'])) {
    $variables['classes_array'][] = 'featured';
  }
  
  if (!empty($variables['page']['footer_firstcolumn'])
    || !empty($variables['page']['footer_secondcolumn'])
    || !empty($variables['page']['footer_thirdcolumn'])) {
    $variables['classes_array'][] = 'footer-columns';
  }
}

function freelancer_bootstrap_form_alter(&$form, &$form_state, $form_id)
{
  if ($form_id == 'contact_site_form') {
    $form['name']['#attributes']['placeholder'] = $form['name']['#title'];
    $form['mail']['#attributes']['placeholder'] = $form['mail']['#title'];
    $form['subject']['#attributes']['placeholder'] = $form['subject']['#title'];
    $form['message']['#attributes']['placeholder'] = $form['message']['#title'];
    $form['actions']['submit']['#attributes']['class'][] = 'btn btn-success btn-lg'; 
  }
}

function freelancer_bootstrap_preprocess_page(&$vars) {
  if (drupal_is_front_page()) {
    unset($vars['page']['content']['system_main']['default_message']); //will remove message "no front page content is created"
    drupal_set_title(''); //removes welcome message (page title)
  }
}