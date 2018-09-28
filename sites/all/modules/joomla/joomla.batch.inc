<?php

/**
 *
 */
function joomla_batch_save($jos, $joomla_update_duplicate, &$context)
{
  joomla_database_init();
  if (empty($context['sandbox'])) {
    // groups
    $context['results']['groups_total'] = 0;
    $context['results']['groups_updated'] = 0;
    $context['results']['groups_new'] = 0;
    $context['results']['groups_failed'] = 0;
    $context['results']['groups_duplicate'] = 0;
    // accounts
    $context['results']['accounts_total'] = 0;
    $context['results']['accounts_updated'] = 0;
    $context['results']['accounts_new'] = 0;
    $context['results']['accounts_failed'] = 0;
    $context['results']['accounts_duplicate'] = 0;
    // user groups map
    $context['results']['maps_total'] = 0;
    $context['results']['maps_updated'] = 0;
    $context['results']['maps_failed'] = 0;
    // categories
    $context['results']['categories_total'] = 0;
    $context['results']['categories_updated'] = 0;
    $context['results']['categories_new'] = 0;
    $context['results']['categories_failed'] = 0;
    // content
    $context['results']['content_total'] = 0;
    $context['results']['content_updated'] = 0;
    $context['results']['content_new'] = 0;
    $context['results']['content_failed'] = 0;
    // comments
    $context['results']['comments_total'] = 0;
    $context['results']['comments_updated'] = 0;
    $context['results']['comments_new'] = 0;
    $context['results']['comments_failed'] = 0;
    // other
    $context['sandbox']['images'] = array();
    $context['sandbox']['progress'] = 0;
    $context['sandbox']['joomla_update_duplicate'] = isset($joomla_update_duplicate) ? $joomla_update_duplicate : variable_get('joomla_update_duplicate', JOOMLA_UPDATE_DUPLICATE);
    db_set_active('joomla');
    $max = 0;
    if ($jos['groups']) {
      $max += db_query('SELECT COUNT( id ) FROM {usergroups}')->fetchField();
    }
    if ($jos['users']) {
      $max += db_query('SELECT COUNT( id ) FROM {users}')->fetchField();
    }
    if ($jos['groups'] && $jos['users']) {
      $max += db_query('SELECT COUNT( user_id ) FROM {user_usergroup_map}')->fetchField();
    }
    if ($jos['comments']) {
      $max += db_query('SELECT COUNT( id ) FROM {jcomments}')->fetchField();
    }
    if ($jos['categories']) {
      $max += db_query('SELECT COUNT( id ) FROM {categories} WHERE extension = \'com_content\'')->fetchField();
    }
    if ($jos['content']) {
      $max += db_query('SELECT COUNT( id ) FROM {content}')->fetchField();
    }
    $context['sandbox']['max'] = $max;
    db_set_active();
    $context['sandbox']['groups_offset'] = 0;
    $context['sandbox']['users_offset'] = 0;
    $context['sandbox']['map_offset'] = 0;
    $context['sandbox']['comments_offset'] = 0;
    $context['sandbox']['categories_offset'] = 0;
    $context['sandbox']['content_offset'] = 0;
  }
  if ($jos['groups']) {
    joomla_group_save($context);
  }
  if ($jos['users']) {
    joomla_user_save($context);
  }
  if ($jos['groups'] && $jos['users']) {
    joomla_map_save($context);
  }
  if ($jos['categories']) {
    joomla_category_save($context);
  }
  if ($jos['content']) {
    joomla_content_save($context);
  }
  if ($jos['comments']) {
    joomla_comment_save($context);
  }
  if ($context['sandbox']['progress'] != $context['sandbox']['max']) {
    $context['finished'] = $context['sandbox']['progress'] / $context['sandbox']['max'];
  }
}

/**
 * @param $context
 */
function joomla_group_save(&$context)
{
  $joomla_update_duplicate = $context['sandbox']['joomla_update_duplicate'];
  $offset = & $context['sandbox']['groups_offset'];
  db_set_active('joomla');
  $groups = db_select('usergroups', 'g')
    ->fields('g', array('id', 'title'))
    ->range($offset, 10)
    ->execute()
    ->fetchAll();
  foreach ($groups as $num => $data) {
    $context['sandbox']['progress']++;
    $context['results']['groups_total']++;
    db_set_active();
    $rid = db_query("SELECT rid FROM {joomla_roles} WHERE jgroupid = :jgroupid", array(':jgroupid' => $data->id))->fetchField();
    if ($rid && !$joomla_update_duplicate) {
      continue;
    }

    if ($data->id == 1 || $data->id == 2) {
      // we force-map group 1 to role 1
      // and          group 2 to role 2
      $joomla_group = new stdClass();
      $joomla_group->rid = $data->id;
      $joomla_group->jgroupid = $data->id;
      if ($rid) {
        drupal_write_record('joomla_roles', $joomla_group, 'rid');
      } else {
        drupal_write_record('joomla_roles', $joomla_group);
      }
      $context['results']['groups_updated']++;
      continue;
    }

      $role = new stdClass();
    // Set uid if we are updating an existing record
    if ($rid) {
      $role->rid = $rid;
    } else {
      //check name to be unique
      $duplicate = db_query_range("SELECT name FROM {role} WHERE name = :name", 0, 1, array(':name' => $data->title))->fetchField();
      if (!empty($duplicate)) {
        //the role already exists
        $context['results']['groups_duplicate']++;
        continue;
      }
    }
    $role->name = $data->title;
    $res = user_role_save($role);
    if ($res) {
      // Write into the joomla -> drupal role mapping table
      $joomla_group = new stdClass();
      $joomla_group->rid = $role->rid;
      $joomla_group->jgroupid = $data->id;
      if ($rid) {
        drupal_write_record('joomla_roles', $joomla_group, 'rid');
      } else {
        drupal_write_record('joomla_roles', $joomla_group);
      }
    }
    if ($rid && $res) {
      $context['results']['groups_updated']++;
    } elseif (!$rid && $res) {
      $context['results']['groups_new']++;
    } else {
      $context['results']['groups_failed']++;
    }
    // Hook to allow other modules to modify the term
    module_invoke_all('joomla', 'role', $role, $data);
    $context['message'] = t('Now processing %role', array('%role' => $data->title));
  }
  $offset += 10;
}

/**
 * @param $context
 */
function joomla_user_save(&$context)
{
  $joomla_update_duplicate = $context['sandbox']['joomla_update_duplicate'];
  $offset = & $context['sandbox']['users_offset'];
  db_set_active('joomla');
  $users = db_select('users', 'u')
    ->fields('u')
    ->orderBy('u.id', 'DESC')
    ->range($offset, 10)
    ->execute()
    ->fetchAll();
  foreach ($users as $num => $data) {
    $context['sandbox']['progress']++;
    $context['results']['accounts_total']++;
    db_set_active();
    $uid = db_query("SELECT uid FROM {joomla_users} WHERE juid = :juid", array(':juid' => $data->id))->fetchField();
    $converted = db_query("SELECT converted FROM {joomla_users} WHERE juid = :juid", array(':juid' => $data->id))->fetchField();
    // Check if the user has selected to update previously imported users
    if ($uid && !$joomla_update_duplicate) {
      continue;
    }
    //if this user has his password converted to drupals hash then we must not update him
    if ($converted && $joomla_update_duplicate) {
      continue;
    }
    $account = new stdClass();
    // Set uid if we are updating an existing record
    if ($uid) {
      $account->uid = $uid;
    } else {
      //check username to be unique
      $duplicate = db_query_range("SELECT name FROM {users} WHERE name = :name", 0, 1, array(':name' => $data->username))->fetchField();
      if (!empty($duplicate)) {
        //the username already exists
        $context['results']['accounts_duplicate']++;
        continue;
      }
      $account->is_new = TRUE;
    }
    $account->name = $data->username;
    $account->mail = $data->email;
    $account->status = !$data->block;
    $account->created = strtotime($data->registerDate);
    $account->access = strtotime($data->lastvisitDate);
    //no negative values
    $account->access = ($account->access < 0) ? NULL : $account->access;
    $account->created = ($account->created < 0) ? NULL : $account->created;
    if ($real_name_field = variable_get('joomla_real_name_field', JOOMLA_REAL_NAME_FIELD)) {
      $lang = field_language('user', $account, $real_name_field);
      $account->{$real_name_field}[$lang][0]['value'] = $data->name;
    }
    /**
     * Older versions of Joomla used an unsalted MD5 password hash.  If this
     * is the case we can use this hash as the Drupal password.
     */
    if (drupal_strlen($data->password) == 32) {
      $account->pass = $data->password;
    }
    $res = user_save($account);
    if ($res) {
      // Write into the joomla -> drupal user mapping table
      $joomla_user = new stdClass();
      $joomla_user->uid = $account->uid;
      $joomla_user->juid = $data->id;
      $joomla_user->password = $data->password;
      if ($uid) {
        drupal_write_record('joomla_users', $joomla_user, 'uid');
      } else {
        drupal_write_record('joomla_users', $joomla_user);
      }
    }
    if ($uid && $res) {
      $context['results']['accounts_updated']++;
    } elseif (!$uid && $res) {
      $context['results']['accounts_new']++;
    } else {
      $context['results']['accounts_failed']++;
    }
    // Hook to allow other modules to modify the term
    module_invoke_all('joomla', 'user', $account, $data);
    $context['message'] = t('Now processing %user', array('%user' => $data->name));
  }
  $offset += 10;
}

/**
 * @param $context
 */
function joomla_map_save(&$context)
{
  $offset = & $context['sandbox']['maps_offset'];
  db_set_active('joomla');
  $groups = db_select('user_usergroup_map', 'm')
    ->fields('m')
    ->range($offset, 10)
    ->execute()
    ->fetchAll();
  foreach ($groups as $num => $data) {
    $context['sandbox']['progress']++;
    $context['results']['maps_total']++;
    db_set_active();
    $rid = db_query("SELECT rid FROM {joomla_roles} WHERE jgroupid = :jgroupid", array(':jgroupid' => $data->group_id))->fetchField();
    if (!$rid) {
      drupal_set_message(t('Could not find a role for joomla group @jgid', array('@jgid' => $data->group_id)), 'error');
      $context['results']['maps_failed']++;
      continue;
    }
    $uid = db_query("SELECT uid FROM {joomla_users} WHERE juid = :juid", array(':juid' => $data->user_id))->fetchField();
    if (!$uid) {
      drupal_set_message(t('Could not find an account for joomla user @juid', array('@juid' => $data->user_id)), 'error');
      $context['results']['maps_failed']++;
      continue;
    }

    $account = user_load($uid);
    $account->roles[$rid] = true;

    $res = user_save($account);
    if ($res) {
      $context['results']['maps_updated']++;
    } else {
      $context['results']['maps_failed']++;
    }
    // Hook to allow other modules to modify the term
    module_invoke_all('joomla', 'map', $account, $data);
    $context['message'] = t('Now processing user-role map');
  }
  $offset += 10;
}

/**
 *
 */
function joomla_category_save(&$context)
{
  $joomla_update_duplicate = $context['sandbox']['joomla_update_duplicate'];
  $cat_offset = & $context['sandbox']['categories_offset'];
  db_set_active('joomla');
  $categories = db_select('categories', 'c')
    ->fields('c', array('id', 'title', 'description', 'parent_id'))
    ->where('(extension = :extension)', array('extension' => 'com_content'))
    ->orderBy('level', 'ASC')
    ->range($cat_offset, 10)
    ->execute()
    ->fetchAll();
  db_set_active();
  //Process Joomla categories -> Drupal terms
  foreach ($categories as $num => $category) {
    $context['results']['categories_total']++;
    $context['sandbox']['progress']++;
    $term_map = db_query("SELECT tid FROM {joomla_categories} WHERE jcategoryid = :jcategoryid", array(':jcategoryid' => $category->id))->fetchField();
    if ($term_map && !$joomla_update_duplicate) {
      continue;
    }
    $term = NULL;
    if ($term_map) {
      $term = db_query('SELECT * FROM {taxonomy_term_data} WHERE tid = :tid', array(':tid' => $term_map))->fetch();
      if (!$term) {
        drupal_set_message(t('Unable to load term id @id', array('@id' => $term_map)), 'error');
        $context['results']['categories_failed']++;
        continue;
      }
    } else {
      $term = new stdClass();
    }
    $term->name = $category->title;
    $term->description = $category->description;
    $parent = db_query("SELECT tid FROM {joomla_categories} WHERE jcategoryid = :jcategoryid", array(':jcategoryid' => $category->parent_id))->fetchField();
    if ($parent) {
      $term->parent = $parent;
    }
    $vid = variable_get('joomla_default_category_vocabulary');
    if (!$vid) {
      drupal_set_message(t('The vocabulary for categories was not configured'), 'error');
      $context['results']['categories_failed']++;
      continue;
    }
    $term->vid = $vid;
    $res = FALSE;
    $res = taxonomy_term_save($term);
    if ($res && !$term_map) {
      // Create an entry in the category <-> vocabulary map table
      $joomla_category = new stdClass();
      $joomla_category->tid = $term->tid;
      $joomla_category->jcategoryid = $category->id;
      drupal_write_record('joomla_categories', $joomla_category);
    }
    switch ($res) {
      case SAVED_NEW:
        $context['results']['categories_new']++;
        break;
      case SAVED_UPDATED:
        $context['results']['categories_updated']++;
        break;
      default:
        $context['results']['categories_failed']++;
        break;
    }
    // Hook to allow other modules to modify the term
    module_invoke_all('joomla', 'term', $term, $category);
    $context['message'] = t('Now processing %term', array('%term' => $term->name));
  }
  $cat_offset += 10;
}

/**
 *
 */
function joomla_content_save(&$context)
{
  $joomla_update_duplicate = $context['sandbox']['joomla_update_duplicate'];
  $images = & $context['sandbox']['images'];
  $offset = & $context['sandbox']['content_offset'];
  db_set_active('joomla');
  $q = db_select('content', 'cs');
  $q->leftJoin('content_frontpage', 'cf', 'cf.content_id = cs.id');
  $q->fields('cs')
    ->fields('cf', array('content_id'))
    ->range($offset, 10);
  $content = $q->execute()->fetchAll();
  db_set_active();
  foreach ($content as $num => $data_joomla) {
    $context['results']['content_total']++;
    $context['sandbox']['progress']++;
    $content_map = db_query('SELECT n.nid, jcontentid, changed FROM {joomla_content} jc JOIN {node} n ON n.nid = jc.nid WHERE jc.jcontentid = :contentid', array(':contentid' => $data_joomla->id))->fetch();
    if ($content_map && !$joomla_update_duplicate) {
      // Content item has already been imported and update is off
      continue;
    }
    /**
     * If the content item already exists, but has not been updated
     * since the last import, skip it
     */
    $joomla_changed = strtotime($data_joomla->modified);
    //if changed is negative drupal will throw an error so:
    if ($joomla_changed < 0) {
      $joomla_changed = 0;
    }
    if ($content_map && $joomla_changed == $content_map->changed) {
      continue;
    }
    $node = new stdClass();
    if ($content_map) {
      $node->nid = $content_map->nid;
      $node = node_load($node->nid);
      $node->revision = 1;
      $node->log = 'This node was programmatically updated at ' . format_date(REQUEST_TIME, 'short', NULL, variable_get('joomla_default_language', LANGUAGE_NONE));
    } else {
      $node->is_new = TRUE;
      $node->log = 'Initial creation from Joomla module';
    }
    $author_uid = db_query('SELECT uid FROM {joomla_users} WHERE juid = :juid', array(':juid' => $data_joomla->created_by))->fetch();
    if ($author_uid) {
      $node->uid = intval($author_uid->uid);
    }
    $node->title = $data_joomla->title;
    $node->status = (bool)$data_joomla->state;
    $node->created = strtotime($data_joomla->created);
    //if created is negative drupal will throw an error so:
    if ($node->created < 0) {
      $node->created = 0;
    }
    $node->language = variable_get('joomla_default_language', LANGUAGE_NONE);
    $node->changed = $joomla_changed;
    // Set content type
    if ($data_joomla->sectionid == 0) {
      $joomla_type = variable_get('joomla_default_static_nodetype', JOOMLA_DEFAULT_STATIC_NODETYPE);
    } else {
      $joomla_type = variable_get('joomla_default_blog_nodetype', JOOMLA_DEFAULT_BLOG_NODETYPE);
    }
    $node->type = $joomla_type;
    if (module_exists('comment')) {
      $node->comment = variable_get('comment_' . $node->type, COMMENT_NODE_OPEN);
    }
    if (!empty($data_joomla->introtext)) {
      $joomla_body = $data_joomla->introtext . "<!--break-->" . $data_joomla->fulltext;
      $joomla_teaser = $data_joomla->introtext;
    } else {
      $joomla_body = $data_joomla->fulltext;
      $joomla_teaser = text_summary($joomla_body);
    }
    $joomla_body = str_replace("{mospagebreak}", "", $joomla_body);
    //images
    if ($data_joomla->images) {
      $joomla_teaser = joomla_replace_mos_image($data_joomla->images, $joomla_teaser);
      $joomla_body = joomla_replace_mos_image($data_joomla->images, $joomla_body);
    }
    $joomla_teaser = joomla_replace_image_link($joomla_teaser);
    $joomla_body = joomla_replace_image_link($joomla_body);
    $lang = field_language('node', $node, NULL, $node->language);
    $node->body[$lang['body']][0]['summary'] = $joomla_teaser;
    $node->body[$lang['body']][0]['value'] = $joomla_body;
    $node->body[$lang['body']][0]['format'] = variable_get('joomla_input_format', JOOMLA_INPUT_FORMAT);
    $tid = db_query('SELECT tid FROM {joomla_categories} WHERE jcategoryid = :jcategoryid', array(':jcategoryid' => $data_joomla->catid))->fetchField();
    if ($tid) {
      $vid = db_query('SELECT vid FROM {taxonomy_term_data} WHERE tid = :tid', array(':tid' => $tid))->fetchField();
      $vocabulary = taxonomy_vocabulary_load($vid);
      $field_name = variable_get('joomla_field_' . $vocabulary->machine_name, FALSE);
      if ($field_name) {
        $node->{$field_name}[$lang[$field_name]][]['tid'] = $tid;
      }
    }
    // Promote to front page?
    if ($data_joomla->content_id) {
      $joomla_promote = 1;
    } else {
      $joomla_promote = 0;
    }
    $node->promote = $joomla_promote;
    node_save($node);
    if (!$content_map) {
      // Created new node, update joomla table
      $joomla_content = new stdClass();
      $joomla_content->nid = $node->nid;
      $joomla_content->jcontentid = $data_joomla->id;
      drupal_write_record('joomla_content', $joomla_content);
    }
    if (!$content_map && $node->nid) {
      $context['results']['content_new']++;
    } elseif ($content_map && $node->nid) {
      $context['results']['content_updated']++;
    } else {
      $context['results']['content_failed']++;
    }
    // Hook to allow other modules to modify the node
    module_invoke_all('joomla', 'node', $node, $data_joomla);
    $context['message'] = t('Now processing %node', array('%node' => $data_joomla->title));
  }
  $offset += 10;
}

/**
 *
 */
function joomla_comment_save(&$context)
{
  $joomla_update_duplicate = $context['sandbox']['joomla_update_duplicate'];
  $offset = & $context['sandbox']['comments_offset'];
  db_set_active('joomla');
  $jcomments = db_select('jcomments', 'jc')
    ->fields('jc')
    ->orderBy('jc.id', 'ASC')
    ->range($offset, 10)
    ->execute()
    ->fetchAll();
  db_set_active();
  foreach ($jcomments as $num => $jcomment) {
    $context['sandbox']['progress']++;
    $context['results']['comments_total']++;
    db_set_active();
    $cid = db_query("SELECT cid FROM {joomla_comments} WHERE jcommentid = :jcid", array(':jcid' => $jcomment->id))->fetchField();
    // Check if the comment has selected to update previously imported comments
    if ($cid && !$joomla_update_duplicate) {
      continue;
    }
    $comment = new stdClass();
    // Set cid if we are updating an existing record
    if ($cid) {
      $comment->cid = $cid;
    }
    $nid = db_query('SELECT nid FROM {joomla_content} WHERE jcontentid = :jcontentid', array(':jcontentid' => $jcomment->object_id))->fetchField();
    $uid = db_query('SELECT uid FROM {joomla_users} WHERE juid = :juid', array(':juid' => $jcomment->userid))->fetchField();
    if (!$nid) {
      $context['results']['comments_failed']++;
      continue;
    }
    $pid = 0;
    if ($jcomment->parent) {
      $pid = db_query('SELECT cid FROM {joomla_comments} WHERE jcommentid = :jparent', array(':jparent' => $jcomment->parent))->fetchField();
    }
    $comment->pid = $pid;
    $comment->nid = $nid;
    $comment->uid = $uid ? $uid : 0;
    $comment->subject = (isset($jcomment->title) && $jcomment->title)
      ? $jcomment->title
      : truncate_utf8(trim(decode_entities(strip_tags($jcomment->comment))), 29, TRUE);
    $comment->hostname = $jcomment->ip;
    $comment->created = strtotime($jcomment->date);
    $comment->changed = $comment->created;
    $comment->status = $jcomment->published;
    $comment->name = $jcomment->name;
    $comment->mail = valid_email_address($jcomment->email) ? $jcomment->email : NULL;
    $comment->homepage = $jcomment->homepage;
    $comment->language = LANGUAGE_NONE;
    // no negative values
    $comment->created = ($comment->created < 0) ? NULL : $comment->created;
    $comment->comment_body[LANGUAGE_NONE][0]['value'] = $jcomment->comment;
    $comment->comment_body[LANGUAGE_NONE][0]['format'] = variable_get('joomla_input_format', JOOMLA_INPUT_FORMAT);
    comment_save($comment);
    if ($comment->cid) {
      // Write into the joomla -> drupal comment mapping table
      $joomla_comment = new stdClass();
      $joomla_comment->cid = $comment->cid;
      $joomla_comment->jcommentid = $jcomment->id;
      if ($cid) {
        drupal_write_record('joomla_comments', $joomla_comment, 'cid');
      } else {
        drupal_write_record('joomla_comments', $joomla_comment);
      }
    }
    if ($cid && $comment->cid) {
      $context['results']['comments_updated']++;
    } elseif (!$cid && $comment->cid) {
      $context['results']['comments_new']++;
    } else {
      $context['results']['comments_failed']++;
    }
    // Hook to allow other modules to modify the term
    module_invoke_all('joomla', 'jcomment', $comment, $jcomment);
    $context['message'] = t('Now processing JComment: %comment', array('%comment' => $comment->subject));
  }
  $offset += 10;
}

/**
 *
 */
function joomla_batch_finished($success, $results, $operations)
{
  if ($success) {
    drupal_set_message(t('Processed @total roles (@new new, @duplicate duplicates, @updated updated, @failed errors)', array(
      '@total' => $results['groups_total'],
      '@duplicate' => $results['groups_duplicate'],
      '@new' => $results['groups_new'],
      '@updated' => $results['groups_updated'],
      '@failed' => $results['groups_failed'],
    )));
    drupal_set_message(t('Processed @users_total users (@users_new new, @users_duplicate duplicates, @users_updated updated, @users_failed errors)', array(
      '@users_total' => $results['accounts_total'],
      '@users_duplicate' => $results['accounts_duplicate'],
      '@users_new' => $results['accounts_new'],
      '@users_updated' => $results['accounts_updated'],
      '@users_failed' => $results['accounts_failed'],
    )));
    drupal_set_message(t('Processed @total user-group maps (@updated updated, @failed errors)', array(
      '@total' => $results['maps_total'],
      '@updated' => $results['maps_updated'],
      '@failed' => $results['maps_failed'],
    )));
    drupal_set_message(t('Processed @total categories (@new new, @updated updated, @failed errors)', array(
      '@total' => $results['categories_total'],
      '@new' => $results['categories_new'],
      '@updated' => $results['categories_updated'],
      '@failed' => $results['categories_failed'],
    )));
    drupal_set_message(t('Processed @total content items (@new new, @updated updated, @failed errors)', array(
      '@total' => $results['content_total'],
      '@new' => $results['content_new'],
      '@updated' => $results['content_updated'],
      '@failed' => $results['content_failed'],
    )));
    drupal_set_message(t('Processed @total comments (@new new, @updated updated, @failed errors)', array(
      '@total' => $results['comments_total'],
      '@new' => $results['comments_new'],
      '@updated' => $results['comments_updated'],
      '@failed' => $results['comments_failed'],
    )));
  } else {
    $error_operation = reset($operations);
    $message = t('An error occurred while processing %error_operation with arguments: @arguments', array('%error_operation' => $error_operation[0], '@arguments' => print_r($error_operation[1], TRUE)));
    drupal_set_message($message, 'error');
  }
}
