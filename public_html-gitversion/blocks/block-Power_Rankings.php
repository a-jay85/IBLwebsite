<?php
/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2005 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}

global $prefix, $multilingual, $currentlang, $db;

$username = "iblhoops_chibul";
$password = "oliver23";
$database = "iblhoops_iblleague";

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="SELECT * FROM nuke_ibl_power WHERE TeamID BETWEEN 1 AND 32 ORDER BY ranking DESC";
$result=mysql_query($query);
$num=mysql_numrows($result);
$i=0;
$content=$content."<table width=150>";
while ($i < $num)
{
	$tid=mysql_result($result,$i,"TeamID");
	$Team=mysql_result($result,$i,"Team");
	$ranking=mysql_result($result,$i,"ranking");
	$wins=mysql_result($result,$i,"win");
	$losses=mysql_result($result,$i,"loss");
	$i++;

	if(($i % 2)==0) {
		$bgcolor="FFFFFF";
	}else{
		$bgcolor="EEEEEE";
	}
	$content = $content."<tr bgcolor=$bgcolor><td align=right valign=top>$i.</td><td align=center>$Team</td><td align=right valign=top>$ranking</td></tr>";
}

$content=$content."<tr><td colspan=3><a href=\"http://www.iblhoops.net/modules.php?name=Power_Rankings\"><font color=#aaaaaa><i>Click here for complete power rankings</i></font></a></table>";

?>