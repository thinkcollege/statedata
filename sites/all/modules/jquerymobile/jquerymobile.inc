<?php

/**
 * @file
 * Includes for jquerymobile
 */

/**
 * Menu callback; Generate a listing of promoted nodes.
 *
 */
function jquerymobile_page_default() {
  global $theme_key;

  $select = db_select('node', 'n')
    ->fields('n', array('nid', 'sticky', 'created'))
    ->condition('promote', 1)
    ->condition('status', 1)
    ->orderBy('sticky', 'DESC')
    ->orderBy('created', 'DESC')
    ->extend('PagerDefault')
    ->limit(variable_get('default_nodes_main', 10))
    ->addTag('node_access');

  $nids = $select->execute()->fetchCol();

  if (!empty($nids)) {
    $nodes = node_load_multiple($nids);
    if (_jquerymobile_is_mobile_theme($theme_key) && _jquerymobile_get_setting($theme_key, 'front')) {
      $build = _jquerymobile_view_multiple($nodes);
    }
    else {
      $build = node_view_multiple($nodes);
    }

    // 'rss.xml' is a path, not a file, registered in node_menu().
    drupal_add_feed('rss.xml', variable_get('site_name', 'Drupal') . ' ' . t('RSS'));
    $build['pager'] = array(
      '#theme' => 'pager',
      '#weight' => 5,
    );
    drupal_set_title(t(''));
  }
  else {
    drupal_set_title(t('Welcome to @site-name', array('@site-name' => variable_get('site_name', 'Drupal'))), PASS_THROUGH);

    $default_message = '<p>' . t('No front page content has been created yet.') . '</p>';

    $default_links = array();
    if (_node_add_access()) {
      $default_links[] = l(t('Add new content'), 'node/add');
    }
    if (!empty($default_links)) {
      $default_message .= theme('item_list', array('items' => $default_links));
    }

    $build['default_message'] = array(
      '#markup' => $default_message,
      '#prefix' => '<div id="first-time">',
      '#suffix' => '</div>',
    );
  }

  return $build;

}


function jquerymobile_load_files() {
  global $theme_key;

  drupal_add_library('jquerymobile', 'jquerymobile.jquery');
  drupal_add_js(_jquerymobile_build_js(), array('type' => 'inline', 'group' => JS_THEME, 'weight' => 102));
  if (_jquerymobile_get_setting($theme_key, 'custom_themes') != NULL) {
    drupal_add_css(variable_get('jquerymobile_custom_path', drupal_get_path('theme', $theme_key) . '/styles/jquery.mobile.overrides.css'), array(
      'type' => 'file', 
      'group' => CSS_THEME, 
      'every_page' => TRUE, 
      'media' => 'all', 
      'preprocess' => FALSE, 
      'weight' => 99,
    ));
    drupal_add_library('jquerymobile', 'jquerymobile.custom');
  }
  else {
    drupal_add_library('jquerymobile', 'jquerymobile');
  }
}

function _jquerymobile_build_js() {
global $theme_key;

  $settings = _jquerymobile_get_settings($theme_key);
  if (isSet($settings)){
    $output = '';
    $output .= 'var jqm = jQuery.noConflict();' . "\n";
    $output .= 'jqm(document).bind("mobileinit", function() {' . "\n";
    if (isSet($settings['ns']))
      $output .= "\n\t" . 'jqm.mobile.ns = "' . $settings['ns'] . '";';
    if (isSet($settings['autoInitializePage']))
      $output .= "\n\t" . 'jqm.mobile.autoInitializePage = ' . $settings['autoInitializePage'] . ';';   
    if (isSet($settings['subPageUrlKey']))
      $output .= "\n\t" . 'jqm.mobile.subPageUrlKey = "' . $settings['subPageUrlKey'] . '";';    
    if (isSet($settings['activePageClass']))  
      $output .= "\n\t" . 'jqm.mobile.activePageClass = "' . $settings['activePageClass'] . '";';
    if (isSet($settings['activeBtnClass']))
      $output .= "\n\t" . 'jqm.mobile.activeBtnClass = "' . $settings['activeBtnClass'] . '";';
    if (isSet($settings['ajaxEnabled']))
      $output .= "\n\t" . 'jqm.mobile.ajaxEnabled = ' . $settings['ajaxEnabled'] . ';';
    if (isSet($settings['hashListeningEnabled']))
      $output .= "\n\t" . 'jqm.mobile.hashListeningEnabled = ' . $settings['hashListeningEnabled'] . ';';
    if (isSet($settings['defaultPageTransition']))
      $output .= "\n\t" . 'jqm.mobile.defaultPageTransition = "' . $settings['defaultPageTransition'] . '";';
    if (isSet($settings['defaultDialogTransition']))
      $output .= "\n\t" . 'jqm.mobile.defaultDialogTransition = "' . $settings['defaultDialogTransition'] . '";';
    if (isSet($settings['minScrollBack']))
      $output .= "\n\t" . 'jqm.mobile.minScrollBack = "' . $settings['minScrollBack'] . '";';
    if (isSet($settings['loadingMessage']))
      $output .= "\n\t" . 'jqm.mobile.loadingMessage = "' . $settings['loadingMessage'] . '";';
    if (isSet($settings['pageLoadErrorMessage']))
      $output .= "\n\t" . 'jqm.mobile.pageLoadErrorMessage = "' . $settings['pageLoadErrorMessage'] . '";';
    if (isSet($settings['linkBindingEnabled']))
      $output .= "\n\t" . 'jqm.mobile.linkBindingEnabled = ' . $settings['linkBindingEnabled'] . ';';
    if (isSet($settings['pushStateEnabled']))
      $output .= "\n\t" . 'jqm.mobile.pushStateEnabled = ' . $settings['pushStateEnabled'] . ';';
    if (isSet($settings['touchOverflowEnabled']))
    $output .= "\n\t" . 'jqm.mobile.touchOverflowEnabled = ' . $settings['touchOverflowEnabled'] . ';';
    
    $output .= "\n});";
  }                     

  return $output;
}

/*
 * Add custom swatches as options.
 *
 * Allows renaming existing swatches or adding new ones.
 */
function _jquerymobile_get_custom_themes() {
  global $theme_key;
  $custom_themes = _jquerymobile_get_setting($theme_key, 'custom_themes');
  $options = array();

  if ($custom_themes) {
    $themes = explode("\n", $custom_themes);

    foreach ($themes as $theme) {
      $set = explode("|", $theme);
      $options[$set[0]] = $set[1];
    }
  }
  return $options;
}

function _jquerymobile_get_theme_list() {
  $option = array();
  $themes = list_themes();
  foreach ($themes as $theme => $name) {
    if ($name->status) {
      $options[$theme] = $theme;
    }
  }
  return $options;
}

function _jquerymobile_is_mobile_theme($theme = NULL) {
  if ($theme != NULL) {
    $result = db_select('jquerymobile', 'j')
      ->fields('j')
      ->condition('theme', $theme)
      ->execute()
      ->fetchAssoc();

    return $result['status'];
  }
  return FALSE;
}

function _jquerymobile_access_theme($theme = NULL) {
  return _jquerymobile_is_mobile_theme($theme->name) && user_access('manage jquerymobile theme settings');
}

function _jquerymobile_get_settings($theme = NULL) {

  if ($theme != NULL) {
    $result = db_select('jquerymobile', 'j')
      ->fields('j')
      ->condition('theme', $theme, '=')
      ->execute()
      ->fetchAssoc();

    return $result;
  }
  return array();
}

function _jquerymobile_get_setting($theme = NULL, $setting = NULL) {

  if ($theme != NULL) {
    $result = db_select('jquerymobile', 'j')
      ->fields('j',
        array($setting)
      )
      ->condition('theme', $theme)
      ->execute()
      ->fetchAssoc();

    return $result[strtolower($setting)];
  }
  return array();
}

function _jquerymobile_set_settings($settings = array()) {
  if ($settings) {
    $result = db_select('jquerymobile', 'j')
      ->fields('j', array('jqmid'))
      ->condition('theme', $settings['theme'])
      ->execute()
      ->fetchAssoc();

    if ($result) {
      $updated = db_update('jquerymobile')
      ->fields($settings)
      ->condition('jqmid', $result)
      ->execute();
    }
    else {
      $inserted = db_insert('jquerymobile')
      ->fields($settings)
      ->execute();
    }
  }
}
