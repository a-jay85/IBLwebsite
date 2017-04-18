<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2006 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if (!eregi("modules.php", $_SERVER['PHP_SELF'])) {
	die ("You can't access this file directly...");
}

require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
$userpage = 1;
$current_ibl_season=mysql_result(mysql_query("SELECT value FROM nuke_ibl_settings WHERE name = 'Current IBL Season' LIMIT 1"),0,"value");
include("header.php");

$querywl="SELECT * FROM nuke_iblteam_win_loss ORDER BY currentname ASC";
$resultwl=mysql_query($querywl);
$numwl=mysql_num_rows($resultwl);


OpenTable();

$h=0;
$wintot=0;
$lostot=0;

while ($h < $numwl) 
{
//	$teamname[$h]=mysql_result($resultwl,$h,"currentname");
//	$yearwl[$h]=mysql_result($resultwl,$h,"year");
//	$namewl[$h]=mysql_result($resultwl,$h,"namethatyear");
//	$wins[$h]=mysql_result($resultwl,$h,"wins");
//	$losses[$h]=mysql_result($resultwl,$h,"losses");
//	$wintot[$h]=$wintot[$h]+$wins[$h];
//	$lostot[$h]=$lostot[$h]+$losses[$h];
//	@$winpct[$h]=number_format($wintot[$h]/($wintot[$h]+$lostot[$h]),3);


		
//	$table_echo=$table_echo."<tr><td>".$teamname[$h]."</td><td>".$wintot[$h]."</td><td>".$lostot[$h]."</td><td>".$winpct[$h]."</td></tr>";
	
	
	
	
	$teamname[$h]=mysql_result($resultwl,$h,"currentname");
	$yearwl[$h]=mysql_result($resultwl,$h,"year");
	$namewl[$h]=mysql_result($resultwl,$h,"namethatyear");
	$wins[$h]=mysql_result($resultwl,$h,"wins");
	$losses[$h]=mysql_result($resultwl,$h,"losses");
	$wintot[$h]=$wintot[$h]+$wins[$h];
	$lostot[$h]=$lostot[$h]+$losses[$h];
	@$winpct[$h]=number_format($wins[$h]/($wins[$h]+$losses[$h]),3);


		
	$table_echo=$table_echo."<tr><td>".$teamname[$h]."</td><td>".$wins[$h]."</td><td>".$losses[$h]."</td><td>".$winpct[$h]."</td></tr>";	

	$h++;
}

$text=$text."<table class=\"sortable\" border=1>
		  <tr><th>Team</th><th>Wins</th><th>Losses</th><th>Pct.</th></tr>$table_echo</table>";
echo $text;


CloseTable();
include("footer.php");


?>