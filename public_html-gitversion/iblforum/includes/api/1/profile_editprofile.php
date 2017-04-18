<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 4.1.3 - Licence Number VBSWUQO7JP
|| # ---------------------------------------------------------------- # ||
|| # Copyright ©2000-2011 vBulletin Solutions Inc. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| # http://www.vbulletin.com | http://www.vbulletin.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/
if (!VB_API) die;

loadCommonWhiteList();

$VB_API_WHITELIST = array(
	'response' => array(
		'HTML' => array(
			'birthdaybit',
			'customfields' => array(
				'required' => array(
					'*' => $VB_API_WHITELIST_COMMON['customfield']
				),
				'regular' => array(
					'*' => $VB_API_WHITELIST_COMMON['customfield']
				),
			),
		)
	),
	'bbuserinfo' => array(
		'username', 'parentemail', 'usertitle', 'homepage', 'icq', 'aim',
		'msn', 'yahoo', 'skype', 'coppauser'
	),
	'show' => array(
		'customtitleoption', 'birthday_readonly', 'birthday_required'
	)
);

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 14:49, Thu Oct 8th 2009
|| # CVS: $RCSfile$ - $Revision: 35584 $
|| ####################################################################
\*======================================================================*/