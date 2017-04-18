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
		'content' => array(
			'membercount',
			'memberlist' => array(
				'*' => array(
					'member' => array(
						'userid', 'username', 'avatarurl'
					)
				)
			), 'pagenav',
			'userinfo' => array('userid', 'username')
		)
	)
);

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 14:49, Thu Oct 8th 2009
|| # CVS: $RCSfile$ - $Revision: 35584 $
|| ####################################################################
\*======================================================================*/