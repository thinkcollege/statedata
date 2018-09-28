<?php
$action = has_value($_REQUEST, 'action') ? $_REQUEST['action'] : '';
$cUser = user::getInstance();
if (!$cUser->isSupervisor()) {	// Non  supervisors can only edit there own information.
	$_REQUEST['user'] = $cUser->getID();
	$user = $cUser;
} else {
	$user = user::getUser(has_value($_REQUEST, 'user', 0, COMP_GT) ? $_REQUEST['user'] : 0);
}
$msgs[] = 'Got user - ' . $user->getID() . ': ' . (microtime(true) - $t);
if (has_value($_REQUEST, 'user', 0)) {
	$template->addRegion('heading', 'Add User');
} else if (has_value($_REQUEST, 'user', 0, COMP_GT)) {
	$template->addRegion('heading', 'Edit User');
} else {
	$template->addRegion('heading', 'User Management');
}
if (has_value($_REQUEST, 'user') && has_value($_REQUEST, 'save')) {
	$msgs[] = 'Saving user - ' . $user->getID() . ': ' . (microtime(true) - $t);
	$ret = $user->save($_REQUEST['fname'], $_REQUEST['lname'], $_REQUEST['email'],
		has_value($_REQUEST, 'pass', null) ? $_REQUEST['pass'] : null,
		has_value($_REQUEST, 'region') ? (has_value($_REQUEST, 'region', '0') ? '' : $_REQUEST['region']) : '',
		has_value($_REQUEST, 'county') ? (has_value($_REQUEST, 'county', '0') ? '' : $_REQUEST['county']) : '',
		has_value($_REQUEST, 'provider') ? (has_value($_REQUEST, 'provider', '0') ? '' : $_REQUEST['provider']) : '',
		has_value($_REQUEST, 'super', 1), has_value($_REQUEST, 'disabled', 1	));
	if ($ret == true) {
		$_REQUEST['user'] = $user->getID();
	}
}
if (has_value($_REQUEST, 'user')) {
	$content = new form('./?'. $_SERVER['QUERY_STRING'], form::METHOD_POST);
	$content->setClass('form');
	if (isset($ret) && $ret == true) {
		$content->add(new p('User updated successfully.', 'success'));
	}
	$content->add(new input($page, input::HIDDEN, 'page'), new input(SAVE, input::HIDDEN, 'action'), new input($user->getID(), input::HIDDEN, 'user'),
		new label('First Name:', 'fname'), new input($user->getFirstName(), input::TEXT, 'fname', 'fname'), new br(),
		new label('Last Name:', 'lname'), new input($user->getLastName(), input::TEXT, 'lname', 'lname'), new br(),
		new label('E-mail:', 'email'), new input($user->getEmail(), input::TEXT, 'email', 'email'), new br(),
		new label('Password:', 'pass'), new input('', input::TEXT, 'pass', 'pass'),
		new span($user->getID() > 0 ? 'The password will only be updated when a value is entered into the box.' : 'The Password <strong>MUST</strong> contain at least 1 of the 3 following character types, a lowercase, an UPPERCASE, a digit, or a special character e.g. !, @, #, $, %, etc.'), new br(),
		new label('Region:', 'region'));
	#if ($cUser->isSupervisor() && $cUser->getRegion() == '') {
	$regions = $_SESSION['baseReport']->getRegions();
	$content->add($regions);
	/*} else if ($cUser->getRegion() == '') {
		$content->add('All Regions.');
	} else {
		$content->add(getVar('SELECT Value FROM ' . TABLE_CODE_LOOKUP . ' WHERE Code = \'' . e($cUser->getRegion()) . '\'') . '.');
	}*/
	$content->add(new br(), new label('County:', 'county'));
	$content->add(select::fromArray($_SESSION['baseReport']->getCountiesInRegion($cUser->getRegion() != '' ? $cUser->getRegion : 'all'), 'county', 'county'));
	/*if ($cUser->isSupervisor() && $cUser->getCounty() == '') {
		$content->add($rs->toSelect('county', 'Select County'));
	} else if ($cUser->getCounty() == '') {
		$content->add('All Counties.');
	} else {
		$content->add(getVar('SELECT Value FROM ' . TABLE_CODE_LOOKUP . ' WHERE Code = \'' . e($cUser->getCounty()) . '\'') . '.');
	}*/
	$content->add(new br(), new label('Provider:', 'provider'));
	$content->add(select::fromArray($_SESSION['baseReport']->getProvidersInRegionCounty($cUser->getRegion() != '' ? $cUser->getRegion() : 'all', $cUser->getCounty() != '' ? $cUser->getCounty() : 'all'), 'provider', 'provider'));
	/*if ($cUser->isSupervisor() && $cUser->getProvider() == '') {
		$rs = fQuery('SELECT DISTINCT p.Number AS `Value`, p.Name AS `Option`, IF(p.`NUmber` = \'' . e($user->getProvider()) . '\', 1, 0) AS `Selected`'
				. ($cUser->getRegion() == ''
					? ', CONCAT(r.`Value`, \' - \', c.`Value`) AS `Group`'
					: ($cUser->getCounty() == '' ? ', c.`Value` AS `Group`' : ''))
					. ' FROM ' . TABLE_BILLING . ' b INNER JOIN ' . TABLE_PROVIDER . ' p ON p.Number = b.ProviderNumber'
				. ($cUser->getRegion() == '' ? ' INNER JOIN ' . TABLE_CODE_LOOKUP . ' r ON r.`Code` = b.`RegionCode`' : '')
				. ($cUser->getCounty() == '' ? ' INNER JOIN ' . TABLE_CODE_LOOKUP . ' c ON c.`Code` = b.`CountyCode`' : '')
				. ' ORDER BY ' . ($cUser->getRegion() == '' || $cUser->getCounty() == '' ? '`Group`,' : '') . 'p.Name');
			$content->add($rs->toSelect('provider', 'Select Provider'));
	} else if ($cUser->getProvider() == '') {
		$content->add('All Providers.');
	} else {
		$content->add(getVar('SELECT Name FROM ' . TABLE_PROVIDER . ' WHERE Number = \'' . e($cUser->getProvider()) . '\'') . '.');
	}*/
	
	if ($cUser->isSupervisor()) {
		$super = new input(1, input::CHECKBOX, 'super', 'super');
		$user->isSupervisor() && !has_value($_REQUEST, 'super') ? $super->check() : false;
		$disabled = new input(1, input::CHECKBOX, 'disabled', 'disabled');
		$user->isDisabled() && !has_value($_REQUEST, 'disabled') ? $disabled->check() : false;
		$content->add(new br(), $super, new label('Is supervisor', 'super'),
			new br(), $disabled, new label('Is disabled', 'disabled'));
	}
	$content->add(new br(), new br(), new input('Save', input::SUBMIT, 'save'));
} else if ($cUser->isSupervisor()) {
	$content = new p(new a('Add User', './?page=' . $page . '&user=0'));
	$rs = fQuery('SELECT u.id AS `Value`, CONCAT(u.LastName,\', \', u.FirstName, \' - \', u.username) AS `Option`'
					. ($cUser->getRegion() == ''
						? ', CONCAT(IFNULL(r.`Value`, \' Global\'), \' - \', c.`Value`, \': \', p.Name) AS `Group`' 
						: ($cUser->getCounty() == ''
							? ', CONCAT(c.`Value`, \': \', p.Name) AS `Group`'
							: ($cUser->getProvider() == '' ? ', p.Name AS `Group`' : '')))
				. ' FROM ' . TABLE_USER . ' u'
				. ($cUser->getRegion() == '' ? ' LEFT JOIN ' . TABLE_CODE_LOOKUP . ' r ON r.`Code` = u.`RegionCode`' : '')
				. ($cUser->getCounty() == '' ? ' LEFT JOIN ' . TABLE_CODE_LOOKUP . ' c ON c.`Code` = u.`CountyCode`' : '')
				. ($cUser->getProvider() == '' ? ' LEFT JOIN ' . TABLE_PROVIDER . ' p ON p.`Number` = u.`ProviderNumber`' : '')
				. ' WHERE 1 '. ($cUser->getRegion() != '' ? ' AND u.RegionCode = \'' . e($cUser->getRegion()) . '\'' : '')
						   . ($cUser->getCounty() != '' ? ' AND u.CountyCode = \'' . e($cUser->getCounty()) . '\'' : '')
						   . ($cUser->getProvider() != '' ? ' AND u.ProviderNumber = \'' . e($cUser->getProvider()) . '\'' : '')
			. ' ORDER BY ' . ($cUser->getRegion() == '' ? 'r.`Value`,' : '')
						   . ($cUser->getCounty() == '' ? 'c.`Value`,' : '')
						   . ($cUser->getProvider() == '' ? 'p.`Name`,' : '') . 'u.LastName,u.FirstName');
	$select = $rs->toSelect('user', 'Select User');
	$form = new form('./', form::METHOD_GET);
	$form->add(new input($page, input::HIDDEN, 'page'), $select->__toString(), new input('Edit', input::SUBMIT));
	$content .= $form;
	
	$form = new form('./', form::METHOD_GET);
	$select->setName('delete');
	$form->add(new br(), new br(), $select->__toString(), new input('Delete', input::SUBMIT));
	$content .= $form;
}
$template->addRegion('content', $content);