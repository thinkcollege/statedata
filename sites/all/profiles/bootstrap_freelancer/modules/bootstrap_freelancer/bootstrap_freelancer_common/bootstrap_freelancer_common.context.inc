<?php
/**
 * @file
 * bootstrap_freelancer_common.context.inc
 */

/**
 * Implements hook_context_default_contexts().
 */
function bootstrap_freelancer_common_context_default_contexts() {
  $export = array();

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'home';
  $context->description = 'Home page blocks';
  $context->tag = 'Page';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        '<front>' => '<front>',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'nodeblock-home_navigation' => array(
          'module' => 'nodeblock',
          'delta' => 'home_navigation',
          'region' => 'navigation',
          'weight' => '-10',
        ),
        'nodeblock-header_block' => array(
          'module' => 'nodeblock',
          'delta' => 'header_block',
          'region' => 'header',
          'weight' => '-10',
        ),
        'nodeblock-portfolio' => array(
          'module' => 'nodeblock',
          'delta' => 'portfolio',
          'region' => 'content',
          'weight' => '-10',
        ),
        'nodeblock-about' => array(
          'module' => 'nodeblock',
          'delta' => 'about',
          'region' => 'content',
          'weight' => '-9',
        ),
      ),
    ),
  );
  $context->condition_mode = 1;

  // Translatables
  // Included for use with string extractors like potx.
  t('Home page blocks');
  t('Page');
  $export['home'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'sitewide_context';
  $context->description = '';
  $context->tag = 'All';
  $context->conditions = array(
    'sitewide' => array(
      'values' => array(
        1 => 1,
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'nodeblock-footer' => array(
          'module' => 'nodeblock',
          'delta' => 'footer',
          'region' => 'footer',
          'weight' => '-10',
        ),
      ),
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('All');
  $export['sitewide_context'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'sitewide_no_home';
  $context->description = '';
  $context->tag = 'All';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        '~<front>' => '~<front>',
      ),
    ),
    'sitewide' => array(
      'values' => array(
        1 => 1,
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'nodeblock-navigation' => array(
          'module' => 'nodeblock',
          'delta' => 'navigation',
          'region' => 'navigation',
          'weight' => '-10',
        ),
      ),
    ),
  );
  $context->condition_mode = 1;

  // Translatables
  // Included for use with string extractors like potx.
  t('All');
  $export['sitewide_no_home'] = $context;

  return $export;
}
