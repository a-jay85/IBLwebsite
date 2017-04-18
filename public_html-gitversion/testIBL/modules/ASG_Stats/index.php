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

if (!defined('MODULE_FILE')) {
	die ("You can't access this file directly...");
}

require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);

$pagetitle = "All-Star Game Stats";

{
	include("header.php");
	OpenTable();
	$team = $_POST['team'];
	$position = $_POST['position'];
	$sortby = $_POST['sortby'];
	$conference = $_POST['conference'];

	if ($position == '')
	{
		$argument =$argument."";
	}else{
		$argument=$argument."AND pos = '$position'";
	}
	if ($team == 0)
	{
		$argument =$argument."";
	}else{
		$argument=$argument." AND tid = $team";
	}
	if ($sortby == "1")
	{
		$sort="((2*`stats_fgm`+`stats_ftm`+`stats_3gm`)/`stats_gm`)";
	}else if ($sortby == "2"){
		$sort="((stats_orb+stats_drb)/`stats_gm`)";
	}else if ($sortby == "3"){
		$sort="((stats_ast)/`stats_gm`)";
	}else if ($sortby == "4"){
		$sort="((stats_stl)/`stats_gm`)";
	}else if ($sortby == "5"){
		$sort="((stats_blk)/`stats_gm`)";
	}else if ($sortby == "6"){
		$sort="((stats_to)/`stats_gm`)";
	}else if ($sortby == "7"){
		$sort="((stats_pf)/`stats_gm`)";
	}else{
		$sort="((2*`stats_fgm`+`stats_ftm`+`stats_3gm`)/`stats_gm`)";
	}

	$query="SELECT * FROM nuke_iblplyr WHERE stats_gs/stats_gm >= 0.5 and stats_gm >= 15 and retired = 0 $argument ORDER BY $sort DESC";
	$result=mysql_query($query);
	$num=mysql_numrows($result);

	echo "<form name=\"Leaderboards\" method=\"post\" action=\"modules.php?name=ASG_Stats\">";
	echo "<table border=1>";
	echo "<tr><td><b>Team</td><td><select name=\"team\">";
	team_option($team);
	echo "</select></td>";
	echo "<td><b>Pos</td><td><select name=\"position\">";
	position_option($position);
	echo "<td><b>Sort By</td><td><select name=\"sortby\">";
	sort_option($sortby);
	echo "</select></td>";
	echo "</select></td><td><input type=\"submit\" value=\"Search Season Data\"></td>";
	echo "</tr></table>";

	echo "<table cellpadding=3 CELLSPACING=0 border=0><tr bgcolor=C2D69A><td><b>Rank</td><td><b>Name</td><td><b>Pos</td><td><b>Team</td><td><b>GP</td><td><b>GS</td><td><b>Min</td><td allign=right><b>fgm</td><td><b>fga</td><td allign=right><b>fg%</td><td><b>ftm</td><td allign=right><b>fta</td><td><b>ft%</td><td allign=right><b>tgm</td><td><b>tga</td><td allign=right><b>tg%</td><td><b>orb</td><td allign=right><b>reb</td><td><b>ast</td><td allign=right><b>stl</td><td><b>to</td><td allign=right><b>blk</td><td><b>pf</td><td allign=right><b>ppg</td></tr>";

	while ($i < $num)
	{
		$pid=mysql_result($result,$i,"pid");
		$pos=mysql_result($result,$i,"pos");
		$name=mysql_result($result,$i,"name");
		$teamname=mysql_result($result,$i,"teamname");
		$teamid=mysql_result($result,$i,"tid");
		//$chunknumber=mysql_result($result,$i,"chunk");
		//$qa=mysql_result($result,$i,"qa");
		$stats_gm=mysql_result($result,$i,"stats_gm");
		$stats_gs=mysql_result($result,$i,"stats_gs");
		$stats_min=mysql_result($result,$i,"stats_min");
		$stats_fgm=mysql_result($result,$i,"stats_fgm");
		$stats_fga=mysql_result($result,$i,"stats_fga");
		@$stats_fgp=number_format(($stats_fgm/$stats_fga*100),1);
		$stats_ftm=mysql_result($result,$i,"stats_ftm");
		$stats_fta=mysql_result($result,$i,"stats_fta");
		@$stats_ftp=number_format(($stats_ftm/$stats_fta*100),1);
		$stats_tgm=mysql_result($result,$i,"stats_3gm");
		$stats_tga=mysql_result($result,$i,"stats_3ga");
		@$stats_tgp=number_format(($stats_tgm/$stats_tga*100),1);
		$stats_orb=mysql_result($result,$i,"stats_orb");
		$stats_drb=mysql_result($result,$i,"stats_drb");
		$stats_reb=$stats_orb+$stats_drb;
		$stats_ast=mysql_result($result,$i,"stats_ast");
		$stats_stl=mysql_result($result,$i,"stats_stl");
		$stats_to=mysql_result($result,$i,"stats_to");
		$stats_blk=mysql_result($result,$i,"stats_blk");
		$stats_pf=mysql_result($result,$i,"stats_pf");
		$stats_pts=2*$stats_fgm+$stats_ftm+$stats_tgm;



		@$stats_mpg=number_format(($stats_min/$stats_gm),1);
		@$stats_fgmpg=number_format(($stats_fgm/$stats_gm),1);
		@$stats_fgapg=number_format(($stats_fga/$stats_gm),1);
		@$stats_ftmpg=number_format(($stats_ftm/$stats_gm),1);
		@$stats_ftapg=number_format(($stats_fta/$stats_gm),1);
		@$stats_tgmpg=number_format(($stats_tgm/$stats_gm),1);
		@$stats_tgapg=number_format(($stats_tga/$stats_gm),1);
		@$stats_orbpg=number_format(($stats_orb/$stats_gm),1);
		@$stats_rpg=number_format(($stats_reb/$stats_gm),1);
		@$stats_apg=number_format(($stats_ast/$stats_gm),1);
		@$stats_spg=number_format(($stats_stl/$stats_gm),1);
		@$stats_tpg=number_format(($stats_to/$stats_gm),1);
		@$stats_bpg=number_format(($stats_blk/$stats_gm),1);
		@$stats_fpg=number_format(($stats_pf/$stats_gm),1);
		@$stats_ppg=number_format(($stats_pts/$stats_gm),1);

		if ($stats_gm > 0 )
		{
			$qa=number_format((($stats_pts+$stats_orb+$stats_drb+(2*$stats_ast)+(2*$stats_stl)+(2*$stats_blk))-(($stats_fga-$stats_fgm)+($stats_fta-$stats_ftm)+$stats_to+$stats_pf))/$stats_gm,1);
		}else{
			$qa=number_format(0,1);
		}

		if(($i % 2)==0) {
			$bgcolor="DDDDDD";
		}else{
			$bgcolor="FFFFFF";
		}

		$i++;
		echo "<tr bgcolor=$bgcolor><td>$i.</td><td><a href=modules.php?name=Player&pa=showpage&pid=$pid>$name</a></td><td>$pos</td><td><a href=modules.php?name=Team&op=team&tid=$teamid>$teamname</a></td><td>$stats_gm</td><td>$stats_gs</td><td align=right>$stats_mpg</td><td align=right>$stats_fgmpg</td><td align=right>$stats_fgapg</td><td align=right>$stats_fgp</td><td align=right>$stats_ftmpg</td><td align=right>$stats_ftapg</td><td align=right>$stats_ftp</td><td align=right>$stats_tgmpg</td><td align=right>$stats_tgapg</td><td align=right>$stats_tgp</td><td align=right>$stats_orbpg</td><td align=right>$stats_rpg</td><td align=right>$stats_apg</td><td align=right>$stats_spg</td><td align=right>$stats_tpg</td><td align=right>$stats_bpg</td><td align=right>$stats_fpg</td><td align=right>$stats_ppg</td></tr>";

	}

	echo "</table></form>";
	CloseTable();
	include("footer.php");
}


function chunk_option ($num, $chunk_selected)
{
	$i=0;
	echo "<option value='0'>All</option>";
	while ($i < $num)
	{
		$i++;
		if ($chunk_selected == $i)
		{
			echo "<option value=$i SELECTED>$i</option>";
		}else{
			echo "<option value=$i>$i</option>";
		}
	}
}

function team_option ($team_selected)
{
	$query="SELECT * FROM nuke_ibl_power WHERE TeamID BETWEEN 1 AND 32 ORDER BY TeamID ASC";
	$result=mysql_query($query);
	$num=mysql_numrows($result);
	echo "<option value=0>All</option>";
	$i=0;
	while ($i < $num)
	{
		$tid=mysql_result($result,$i,"TeamID");
		$Team=mysql_result($result,$i,"Team");

		$i++;
		if ($team_selected == $tid)
		{
			echo "<option value=$tid SELECTED>$Team</option>";
		}else{
			echo "<option value=$tid>$Team</option>";
		}
	}
}

function position_option ($position_selected)
{
	$arr = array("C", "PF", "SF", "SG", "PG");
	$num=sizeof($arr);
	echo "<option value=''>All</option>";
	$i=0;
	while ($i < $num)
	{
		$position=$arr[$i];

		$i++;
		if ($position_selected == $position)
		{
			echo "<option value='$position' SELECTED>$position</option>";
		}else{
			echo "<option value='$position'>$position</option>";
		}
	}
}

function sort_option($sort_selected)
{
	$arr = array("PPG", "REB", "AST", "STL", "BLK", "TO", "FOUL");
	$num=sizeof($arr);
	$i=0;
	while ($i < $num)
	{
		$sortby=$arr[$i];

		$i++;
		if ($i == $sort_selected)
		{
			echo "<option value='$i' SELECTED>$sortby</option>";
		}else{
			echo "<option value='$i'>$sortby</option>";
		}
	}
}

function test ()
{
	echo "TEST";
}


?>