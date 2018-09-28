<?php
/**
 * @file
 * export_state_data.features.user_role.inc
 */

/**
 * Implements hook_user_default_roles().
 */
function export_state_data_user_default_roles() {
  $roles = array();

  // Exported role: administrator.
  $roles['administrator'] = array(
    'name' => 'administrator',
    'weight' => 2,
  );

  return $roles;
}
