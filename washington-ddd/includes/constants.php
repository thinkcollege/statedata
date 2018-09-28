<?php
define('DIR', LIVE ? '/washington-ddd/' : '/waddd/');
define('DOMAIN', LIVE ? 'www.statedata.info' : $_SERVER['HTTP_HOST']);
define('DATA_DIR', LIVE ? '/home/statedata/wa-ddd/' : '/Volumes/Stuff/umb/web/waddd/data/');
define('DEBUG', LIVE ? 0 : 1);
define('TEMPLATE', 'waddd_template');
define('ADMIN_EMAIL', 'paul.foos@umb.edu');

define('DB_USER', 'waddd');
define('DB_PASS', 'yVxvE4WCZEuZKuhL');
define('DATABASE', 'waddd');
define('PRE_TABLE', '');
define('TABLE_BILLING', 	'`' . PRE_TABLE . 'Billing`');
define('TABLE_EMPLOYMENT',	'`' . PRE_TABLE . 'Employment`');
define('TABLE_CODE_LOOKUP',	'`' . PRE_TABLE . 'CodeLookup`');
define('TABLE_PROVIDER',	'`' . PRE_TABLE . 'Providers`');
define('TABLE_USER',		'`' . PRE_TABLE . 'User`');
define('TABLE_USER_REPORT',	'`' . PRE_TABLE . 'UserReport`');

define('OUTCOME_GROSS_PAY',		 1);
define('OUTCOME_HOURS_PAID',	 2);
define('OUTCOME_TOTAL_SUPPORT',	 3);
define('OUTCOME_JOB_PREP',		 4);
define('OUTCOME_JOB_DEV',		 5);
define('OUTCOME_JOB_COACHING',	 6);
define('OUTCOME_RECORD_KEEPING', 7);

define('REGEX_REGION_CODE', '/^RG0[1-6]$/');
define('REGEX_COUNTY_CODE', '/^CY\d{2}$/');
define('REGEX_PROVIDER_NUMBER', '/^\d+(?:,\d+)*$/i');
define('REGEX_DATETIME', '/^(\d{4}-\d{2}-\d{2}(?:\s\d{2}:\d{2}:\d{2})?(?=\.?\d*)|\d{2}\/\d{2}\/\d{4})?/');
define('REGEX_FLAG', '/^(False|True)?$/');

define('ADD', 'add');
define('EDIT', 'edit');
define('SAVE', 'save');
define('LOGOUT', 'logout');

define('MIN_ALLOWED_RECORDS',	5);
define('DATA_RELEASE_DELAY',	4);
