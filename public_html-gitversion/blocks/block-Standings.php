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

$content=$content."<table>";
$division="Atlantic";
$stanidings=standings($division);
$content=$content.$stanidings;

$division="Central";
$stanidings=standings($division);
$content=$content.$stanidings;

$division="Midwest";
$stanidings=standings($division);
$content=$content.$stanidings;

$division="Pacific";
$stanidings=standings($division);
$content=$content.$stanidings;

$content=$content."<tr><td colspan=2><a href=\"http://www.ijbl.net/modules.php?name=Content&pa=showpage&pid=81\"><font color=#aaaaaa><i>Click here for complete standings</i></font></a></td></tr></table>";

function standings ($division) {
	$query="SELECT * FROM nuke_ibl_power WHERE Division = '$division' ORDER BY gb DESC";
	$result=mysql_query($query);
	$num=mysql_numrows($result);
	$i=0;
	$gbbase=mysql_result($result,$i,"gb");

	$stangings="<tr><td colspan=2><center><font color=#bb0000><b>$division Division</b></font></center></td></tr>
	<tr bgcolor=#0000cc><td><center><font color=#ffffff><b>Team (W-L)</b></font></center></td><td><center><font color=#ffffff><b>GB</b></font></center></td></tr>";
	while ($i < $num)
	{
		$tid=mysql_result($result,$i,"TeamID");
		$Team=mysql_result($result,$i,"Team");
		$win=mysql_result($result,$i,"win");
		$loss=mysql_result($result,$i,"loss");
		$gb=mysql_result($result,$i,"gb");
		$gb=$gbbase-$gb;
		if(($i % 2)==0) {
			$bgcolor="FFFFFF";
		}else{
			$bgcolor="EEEEEE";
		}

		$stangings=$stangings."<tr bgcolor=$bgcolor><td nowrap><a href=\"http://www.ijbl.net/modules.php?name=Team&op=team&tid=$tid\">$Team</a> ($win-$loss)</td><td>$gb</td></tr>";
		$i++;
	}
	$stangings=$stangings."<tr><td colspan=2><hr></td></tr>";
	return $stangings;
}

?>