<?php

/**
 * @file
 * Administrative page callbacks for Service Links module.
 */

/**
 * Menu callback administration settings for general options.
 */
function printfriendly_admin_settings() {
  if (substr($_SERVER['REMOTE_ADDR'], 0, 4) == '127.'
      || $_SERVER['REMOTE_ADDR'] == '::1') {
    drupal_set_message(t('It appears that your site is running on a local
    server. PrintFriendly service requires a remotely-accessible web site
    to function.'), 'warning', FALSE);
  }

  $form['#attached']['css'] = array(
    drupal_get_path('module', 'printfriendly') . '/printfriendly.css',
  );

  $form['printfriendly_types'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Content Types'),
    '#description' => t('Configure where the printfriendly button should appear.'),
    '#options' => node_type_get_names(),
    '#default_value' => variable_get('printfriendly_types', array()),
  );
  $form['printfriendly_display'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Button display'),
    '#description' => t('Select content displays that the button should appear.'),
    '#options' => array(
      'teaser' => t('Teaser'),
      'full' => t('Full content page'),
    ),
    '#default_value' => array_filter(variable_get('printfriendly_display', array())),
  );
  
  // Add more features here
  $form['printfriendly_features'] = array(
      '#type' => 'fieldset',
      '#title' => t('Features'),
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
    );
  
  $img_path = drupal_get_path('module', 'printfriendly') . '/images';
  $results = file_scan_directory($img_path, '/^.*\.(gif|png|jpg|GIF|PNG|JPG)$/');
  $options = array();
  foreach ($results as $image) {
    $options[$image->filename] = theme('image', array('path' => $image->uri));
  }
  ksort($options);

  // set custom button image options.
  $options['custom-button-img-url'] = '';

  $form['printfriendly_features']['printfriendly_image'] = array(
    '#type' => 'radios',
    '#title' => t('Choose button'),
    '#options' => $options,
    '#default_value' => variable_get('printfriendly_image', 'button-print-grnw20.png'),
  );

  $form['printfriendly_features']['custom_button_img_url'] = array(
      '#type' => 'textfield',
      '#title' => t('Custom button image URL'),
      '#description' => t('Put full path of an image http://devt.drupalchamp.org/sites/default/files/drupal-logo.png'),
      '#default_value' => variable_get('custom_button_img_url', ''),
   );
  
  $icon = '';
  if(!empty(variable_get('printfriendly_page_custom_header'))) $icon = 'custom_logo';  else $icon = 'default_logo';
  $form['printfriendly_features']['printfriendly_page_header'] = array(
    '#type' => 'select',
    '#title' => t('Page header'),
    '#options' => array(
      'default_logo' => 'My Website Icon',
      'custom_logo' => 'Upload an Image',
    ),
    '#default_value' => $icon,
  );

  $form['printfriendly_features']['printfriendly_page_custom_header'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter URL'),
      '#description' => t('Put full path of the file like http://devt.drupalchamp.org/sites/default/files/drupal-logo.png'),
      '#states' => array(
        'invisible' => array(
          ':input[name="printfriendly_page_header"]' => array(
            array('value' => t('default_logo')),
          ),
        ),
      ),
     '#default_value' => variable_get('printfriendly_page_custom_header', ''),
   );

   $form['printfriendly_features']['printfriendly_tagline'] = array(
     '#type' => 'textfield',
     '#title' => t('Header tagline'),
     '#default_value' => variable_get('printfriendly_tagline', ''),
     '#description' => t('Add a specific tagline to the header.'),
     '#states' => array(
        'invisible' => array(
          ':input[name="printfriendly_page_header"]' => array(
            array('value' => t('default_logo')),
          ),
        ),
      ),
   );

  $form['printfriendly_features']['printfriendly_click_delete'] = array(
    '#type' => 'select',
    '#title' => t('Click-to-delete'),
    '#options' => array(
      '0' => 'Allow',
      '1' => 'Not Allow',
     ),
    '#default_value' => variable_get('printfriendly_click_delete', '0'),
  );

  $form['printfriendly_features']['printfriendly_images'] = array(
    '#type' => 'select',
    '#title' => t('Images'),
    '#options' => array(
      '0' => 'Include',
      '1' => 'Exclude',
     ),
    '#default_value' => variable_get('printfriendly_images', '0'),
  );

  $form['printfriendly_features']['printfriendly_image_style'] = array(
    '#type' => 'select',
    '#title' => t('Image style'),
    '#options' => array(
      'right' => 'Align Right',
      'left' => 'Align Left',
      'none' => 'Align None',
      'block' => 'Center/Block',
     ),
    '#default_value' => variable_get('printfriendly_image_style', 'right'),
  );

  $form['printfriendly_features']['printfriendly_email'] = array(
    '#type' => 'select',
    '#title' => t('Email'),
    '#options' => array(
      '0' => 'Allow',
      '1' => 'Not Allow',
     ),
    '#default_value' => variable_get('printfriendly_email', '0'),
  );

  $form['printfriendly_features']['printfriendly_pdf'] = array(
    '#type' => 'select',
    '#title' => t('PDF'),
    '#options' => array(
      '0' => 'Allow',
      '1' => 'Not Allow',
     ),
    '#default_value' => variable_get('printfriendly_pdf', '0'),
  );

  $form['printfriendly_features']['printfriendly_print'] = array(
    '#type' => 'select',
    '#title' => t('Print'),
    '#options' => array(
      '0' => 'Allow',
      '1' => 'Not Allow',
     ),
    '#default_value' => variable_get('printfriendly_print', '0'),
  );

  $form['printfriendly_features']['printfriendly_custom_css'] = array(
      '#type' => 'textfield',
      '#description' => t('Put full path of the file like http://devt.drupalchamp.org/sites/default/files/printfriendly.css'),
      '#title' => t('Custom css url'),
      '#default_value' => variable_get('printfriendly_custom_css', ''),

  );

  /*-----------------------------------------------------------*/

  $form['support-link'] = array(
    '#markup' => t('Need help or have suggestions? !support-email.', array(
      '!support-email' => l(t('Support@PrintFriendly.com'), 'mailto:support@printfriendly.com', array(
        'absolute' => TRUE,
        'query' => array('subject' => 'Support for PrintFriendly Drupal module'),
      )),
    )),
    '#weight' => 1000,
  );

  $form['#submit'][] = 'printfriendly_admin_settings_submit';
  return system_settings_form($form);
}

function printfriendly_admin_settings_submit(&$form, &$form_state) {
   if($form_state['values']['printfriendly_page_header'] == 'custom_logo'){
     variable_set('printfriendly_page_custom_header', $form_state['values']['printfriendly_page_custom_header']);
     variable_set('printfriendly_tagline', $form_state['values']['printfriendly_tagline']);
   }else{
     $form_state['values']['printfriendly_page_custom_header'] = '';
     $form_state['values']['printfriendly_tagline'] = '';
     variable_set('printfriendly_page_custom_header', '');
     variable_set('printfriendly_tagline', '');
   }
   
   if(!empty($form_state['values']['printfriendly_custom_css'])){
     variable_set('printfriendly_custom_css', $form_state['values']['printfriendly_custom_css']);
   }else{
     variable_set('printfriendly_custom_css', '');
   }
   
   if($form_state['values']['printfriendly_image'] == 'custom-button-img-url'){
     variable_set('custom_button_img_url', $form_state['values']['custom_button_img_url']);
   }else{
     $form_state['values']['custom_button_img_url'] = '';
     variable_set('custom_button_img_url', '');
   }
   
}


