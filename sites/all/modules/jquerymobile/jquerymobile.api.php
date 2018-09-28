<?php

/**
 * @file
 * Lists new API functions, hooks and Form API options for jQuery Mobile
 *
 * @author Mathew Winstone <mwinstone@coldfrontlabs.ca>
 * @copyright 2011 Coldfront Labs Inc.
 * @license Copyright (c) 2011 All rights reserved
 */

// FAPI Extensions

/**
 * Form element options for jQuery Mobile
 *
 * You can enable any of these options manually by adding the appropriate
 * data to the '#attributes' array on your form elements. These are simply
 * convenience options. They trigger the exact same effect.
 */
function jquerymobile_api_form_examples() {
  $form =  array();
  
  /** 
   * Button and Submit Attributes
   *
   * For more details
   * @see http://jquerymobile.com/demos/1.0/docs/buttons/buttons-types.html
   */
  $form['button'] = array(
    '#type' => 'button',
    '#value' => t('Button'),
    // Add rounded corners to your button
    '#corners' => TRUE,
    // Apply an icon
    // You can see the available list of icons by calling
    // jquerymobile_icon_options()
    '#icon' => 'gear',
    // Icon position
    // You can see the available positisions by calling
    // jquerymobile_icon_position_options()
    '#icon_position' => 'top',
    // Icon shadow
    '#icon_shadow' => TRUE,
    // Make this button inline with other buttons
    // Works best when buttons are rendered one after the other or within
    // a control group of fieldset
    '#inline' => FALSE,
    // Add a shadow to the button
    '#shadow' => FALSE,
    // Set the swatch for this element
    // Can be any letter from a-z (lowercase).
    '#swatch' => 'a',
  );
  
}

// Template Extensions

function jquerymobile_template_examples() {
  $output = '';
  
  /**
   * Link theme
   *
   * New attribute options can be passed into any call to theme_link, l() or
   * url() to enable jQuery Mobile related features
   *
   * With links you have two options for enabling support for jQuery Mobile
   *
   * 1. Add your desired attributes to the "$options" array in the l() or
   *    url() functions
   *    @see http://api.drupal.org/api/drupal/core--includes--common.inc/function/l/8
   * 2. Add a set of jQuery Mobile specific array options and the module
   *    will process and add the options automatically.
   *    See below for an example
   */

  $options = array();

  $options['jquerymobile'] = array(
    // Render the link as a button. Probably the most important option listed
    // here since the rest are dependent on it.
    'button' => TRUE,
    // For details on button options, see the Form API Extensions example
    'corners' => TRUE,
    'icon' => 'gear',
    'icon_position' => 'top',
    'icon_shadow' => TRUE,
    'inline' => FALSE,
    'shadow' => FALSE,
    'swatch' => 'a',
  );

  $output .= l(t('Button Link'), '<front>', $options);
  
  return $output;
}