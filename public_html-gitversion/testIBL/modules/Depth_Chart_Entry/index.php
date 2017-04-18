<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/* ibl College Scout Module added by Spencer Cooley                    */
/* 2/2/2005                                                             */
/*                                                                      */
/************************************************************************/

if (!eregi("modules.php", $_SERVER['PHP_SELF'])) die ("You can't access this file directly...");

require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
$userpage = 1;

//include("modules/$module_name/navbar.php");

function userinfo($username, $bypass=0, $hid=0, $url=0)
	{
	global $user, $cookie, $sitename, $prefix, $user_prefix, $db, $admin, $broadcast_msg, $my_headlines, $module_name, $useset, $subscription_url;
	$sql = "SELECT * FROM ".$prefix."_bbconfig";
	$result = $db->sql_query($sql);
	while ( $row = $db->sql_fetchrow($result) )	{
		$board_config[$row['config_name']] = $row['config_value'];
	}
	$sql2 = "SELECT * FROM ".$user_prefix."_users WHERE username='$username'";
	$result2 = $db->sql_query($sql2);
	$num = $db->sql_numrows($result2);
	$userinfo = $db->sql_fetchrow($result2);
	if(!$bypass) cookiedecode($user);
	include("header.php");

	// === CODE TO INSERT IBL DEPTH CHART ===

	function posHandler($positionVar)
	{
		echo "<option value=\"0\"".($positionVar == 0 ? " SELECTED" : "").">No</option>";
		echo "<option value=\"1\"".($positionVar == 1 ? " SELECTED" : "").">1st</option>";
		echo "<option value=\"2\"".($positionVar == 2 ? " SELECTED" : "").">2nd</option>";
		echo "<option value=\"3\"".($positionVar == 3 ? " SELECTED" : "").">3rd</option>";
		echo "<option value=\"4\"".($positionVar == 4 ? " SELECTED" : "").">4th</option>";
		echo "<option value=\"5\"".($positionVar == 5 ? " SELECTED" : "").">ok</option>";
		echo "</select></td>";
	}

	function offdefHandler($focusVar)
	{
		echo "<option value=\"0\"".($focusVar == 0 ? " SELECTED" : "").">Auto</option>";
		echo "<option value=\"1\"".($focusVar == 1 ? " SELECTED" : "").">Outside</option>";
		echo "<option value=\"2\"".($focusVar == 2 ? " SELECTED" : "").">Drive</option>";
		echo "<option value=\"3\"".($focusVar == 3 ? " SELECTED" : "").">Post</option>";
	}

	function oidibhHandler($settingVar)
	{
		echo "<option value=\"2\"".($settingVar == 2 ? " SELECTED" : "").">2</option>";
		echo "<option value=\"1\"".($settingVar == 1 ? " SELECTED" : "").">1</option>";
		echo "<option value=\"0\"".($settingVar == 0 ? " SELECTED" : "").">-</option>";
		echo "<option value=\"-1\"".($settingVar == -1 ? " SELECTED" : "").">-1</option>";
		echo "<option value=\"-2\"".($settingVar == -2 ? " SELECTED" : "").">-2</option>";
	}

	OpenTable();
	$teamlogo = $userinfo[user_ibl_team];

	$sql7 = "SELECT * FROM ".$prefix."_ibl_offense_sets WHERE TeamName = '$teamlogo' ORDER BY SetNumber ASC";
	$result7 = $db->sql_query($sql7);
	$num7 = $db->sql_numrows($result7);

	$sql8 = "SELECT * FROM ".$prefix."_iblplyr WHERE teamname = '$teamlogo' AND retired = '0' ORDER BY ordinal ASC";
	$result8 = $db->sql_query($sql8);

	if ($useset == NULL) $useset=1;

	$sql9 = "SELECT * FROM ".$prefix."_ibl_offense_sets WHERE TeamName = '$teamlogo' AND SetNumber = '$useset'";
	$result9 = $db->sql_query($sql9);
	$row9 = $db->sql_fetchrow($result9);

	$offense_name = $row9[offense_name];
	$Slot1 = $row9[PG_Depth_Name];
	$Slot2 = $row9[SG_Depth_Name];
	$Slot3 = $row9[SF_Depth_Name];
	$Slot4 = $row9[PF_Depth_Name];
	$Slot5 = $row9[C_Depth_Name];

	$Low1 = $row9[PG_Low_Range];
	$Low2 = $row9[SG_Low_Range];
	$Low3 = $row9[SF_Low_Range];
	$Low4 = $row9[PF_Low_Range];
	$Low5 = $row9[C_Low_Range];

	$High1 = $row9[PG_High_Range];
	$High2 = $row9[SG_High_Range];
	$High3 = $row9[SF_High_Range];
	$High4 = $row9[PF_High_Range];
	$High5 = $row9[C_High_Range];

	$i=0;

	echo "SELECT OFFENSIVE SET TO USE: ";

	while ($i < 3) {
		$name_of_set=mysql_result($result7,$i,"offense_name");
		$i++;

		echo "<a href=\"modules.php?name=Depth_Chart_Entry&useset=$i\">$name_of_set</a> | ";
	}

	echo "<hr>
		<form name=\"Depth_Chart\" method=\"post\" action=\"modules.php?name=Depth_Chart_Entry&op=submit\">
		<input type=\"hidden\" name=\"Team_Name\" value=\"$teamlogo\"><input type=\"hidden\" name=\"Set_Name\" value=\"$offense_name\">
		<center><img src=\"online/teamgrfx/$teamlogo.jpg\"><br><table><tr><th colspan=14><center>DEPTH CHART ENTRY - Offensive Set: $offense_name</center></th></tr>
		<tr><th>Pos</th><th>Player</th><th>$Slot1</th><th>$Slot2</th><th>$Slot3</th><th>$Slot4</th><th>$Slot5</th><th>active</th><th>min</th><th>OF</th><th>DF</th><th>OI</th><th>DI</th><th>BH</th></tr>";
	$depthcount=1;

	while ($row8 = $db->sql_fetchrow($result8)) {
		$player_pos = $row8[altpos];
		$player_name = $row8[name];
		$player_staminacap = $row8[sta]+40;
		if ($player_staminacap > 40) $player_staminacap = 40;
		$player_PG = $row8[dc_PGDepth];
		$player_SG = $row8[dc_SGDepth];
		$player_SF = $row8[dc_SFDepth];
		$player_PF = $row8[dc_PFDepth];
		$player_C = $row8[dc_CDepth];
		$player_active = $row8[dc_active];
		$player_min = $row8[dc_minutes];
		$player_of = $row8[dc_of];
		$player_df = $row8[dc_df];
		$player_oi = $row8[dc_oi];
		$player_di = $row8[dc_di];
		$player_bh = $row8[dc_bh];
		$player_inj = $row8[injured];

		if ($player_pos == 'PG') $pos_value=1;
		if ($player_pos == 'G') $pos_value=2;
		if ($player_pos == 'SG') $pos_value=3;
		if ($player_pos == 'GF') $pos_value=4;
		if ($player_pos == 'SF') $pos_value=5;
		if ($player_pos == 'F') $pos_value=6;
		if ($player_pos == 'PF') $pos_value=7;
		if ($player_pos == 'FC') $pos_value=8;
		if ($player_pos == 'C') $pos_value=9;

		echo "\n<tr><td>$player_pos</td><td nowrap><input type=\"hidden\" name=\"Inury$depthcount\" value=\"$player_inj\"><input type=\"hidden\" name=\"Name$depthcount\" value=\"$player_name\">$player_name</td>\n";

		if ($pos_value >= $Low1 && $player_inj < 15) {
			if ($pos_value <= $High1) {
				echo "<td><select name=\"pg$depthcount\">";
				posHandler($player_PG);
			} else {
				echo "<td><input type=\"hidden\" name=\"pg$depthcount\" value=\"0\">no</td>";
			}
		} else {
			echo "<td><input type=\"hidden\" name=\"pg$depthcount\" value=\"0\">no</td>";
		}

		if ($pos_value >= $Low2 && $player_inj < 15) {
			if ($pos_value <= $High2) {
				echo "<td><select name=\"sg$depthcount\">";
				posHandler($player_SG);
			} else {
				echo "<td><input type=\"hidden\" name=\"sg$depthcount\" value=\"0\">no</td>";
			}
		} else {
			echo "<td><input type=\"hidden\" name=\"sg$depthcount\" value=\"0\">no</td>";
		}

		if ($pos_value >= $Low3 && $player_inj < 15) {
			if ($pos_value <= $High3) {
				echo "<td><select name=\"sf$depthcount\">";
				posHandler($player_SF);
			} else {
				echo "<td><input type=\"hidden\" name=\"sf$depthcount\" value=\"0\">no</td>";
			}
		} else {
			echo "<td><input type=\"hidden\" name=\"sf$depthcount\" value=\"0\">no</td>";
		}

		if ($pos_value >= $Low4 && $player_inj < 15) {
			if ($pos_value <= $High4) {
				echo "<td><select name=\"pf$depthcount\">";
				posHandler($player_PF);
			} else {
				echo "<td><input type=\"hidden\" name=\"pf$depthcount\" value=\"0\">no</td>";
			}
		} else {
			echo "<td><input type=\"hidden\" name=\"pf$depthcount\" value=\"0\">no</td>";
		}

		if ($pos_value >= $Low5 && $player_inj < 15) {
			if ($pos_value <= $High5) {
				echo "<td><select name=\"c$depthcount\">";
				posHandler($player_C);
			} else {
				echo "<td><input type=\"hidden\" name=\"c$depthcount\" value=\"0\">no</td>";
			}
		} else {
			echo "<td><input type=\"hidden\" name=\"c$depthcount\" value=\"0\">no</td>";
		}

		echo "<td><select name=\"active$depthcount\">";
		if ($player_active == 1) {
			echo "<option value=\"1\" SELECTED>Yes</option><option value=\"0\">No</option>";
		} else {
			echo "<option value=\"1\">Yes</option><option value=\"0\" SELECTED>No</option>";
		}
		echo "</select></td>";

		echo "<td><select name=\"min$depthcount\">";
		echo "<option value=\"0\"".($player_min == 0 ? " SELECTED" : "").">Auto</option>";
		$abc=1;
		while ($abc <= $player_staminacap) {
			echo "<option value=\"".$abc."\"".($player_min == $abc ? " SELECTED" : "").">".$abc."</option>";
			$abc++;
		}

		echo "</select></td><td><select name=\"OF$depthcount\">";
		offdefHandler($player_of);
		echo "</select></td><td><select name=\"DF$depthcount\">";
		offdefHandler($player_df);

		echo "</select></td><td><select name=\"OI$depthcount\">";
		oidibhHandler($player_oi);
		echo "</select></td><td><select name=\"DI$depthcount\">";
		oidibhHandler($player_di);
		echo "</select></td><td><select name=\"BH$depthcount\">";
		oidibhHandler($player_bh);

		echo "</select></td></tr>";
		$depthcount++;
	}

	echo "<tr><th colspan=14><input type=\"radio\" name=\"emailtarget\" value=\"Normal\" checked> Submit Depth Chart? <input type=\"submit\" value=\"Submit\"></th></tr></form></table></center>";
	CloseTable();

	// === END INSERT OF IBL DEPTH CHART ===

	include("footer.php");
}

function main($user) {
	global $stop;
	if (!is_user($user)) {
		include("header.php");
		OpenTable();
		echo "<center><font class=\"title\"><b>".($stop ? _LOGININCOR : _USERREGLOGIN)."</b></font></center>";
		CloseTable();
		echo "<br>";
		if (!is_user($user)) {
			OpenTable();
			loginbox();
			CloseTable();
		}
		include("footer.php");
	} elseif (is_user($user)) {
		global $cookie;
		cookiedecode($user);
		userinfo($cookie[1]);
	}
}

function submit() {
    include("header.php");
    OpenTable();

	$Set_Name = $_POST['Set_Name'];
	$Team_Name = $_POST['Team_Name'];
	$emailtarget = $_POST['emailtarget'];
	$text = "$Team_Name Depth Chart Submission<br><table>";
	$text = $text."<tr><td><b>Name</td><td><b>PG</td><td><b>SG</td><td><b>SF</td><td><b>PF</td><td><b>C</td><td><b>Active</td><td><b>Min</td><td><b>OF</td><td><b>DF</td><td><b>OI</td><td><b>DI</td><td><b>BH</td></tr>";
	$filetext = "Name,PG,SG,SF,PF,C,ACTIVE,MIN,OF,DF,OI,DI
";

	$activeplayers=0;
	$pos_1=0;
	$pos_2=0;
	$pos_3=0;
	$pos_4=0;
	$pos_5=0;

	$i=1;
	$injury_Sum = 0;
	while ($i < 16) {
		$a = "<tr><td>".$_POST['Name'.$i]."</td>";
		$b = "<td>".$_POST['pg'.$i]."</td>";
		$c = "<td>".$_POST['sg'.$i]."</td>";
		$d = "<td>".$_POST['sf'.$i]."</td>";
		$e = "<td>".$_POST['pf'.$i]."</td>";
		$f = "<td>".$_POST['c'.$i]."</td>";
		$g = "<td>".$_POST['active'.$i]."</td>";
		$h = "<td>".$_POST['min'.$i]."</td>";
		$z = "<td>".$_POST['OF'.$i]."</td>";
		$j = "<td>".$_POST['DF'.$i]."</td>";
		$k = "<td>".$_POST['OI'.$i]."</td>";
		$l = "<td>".$_POST['DI'.$i]."</td>";
		$m = "<td>".$_POST['BH'.$i]."</td></tr>
";
		$text = $text.$a.$b.$c.$d.$e.$f.$g.$h.$z.$j.$k.$l.$m;

		$injury = $_POST['Inury'.$i];
		$aa = $_POST['Name'.$i].",";
		$bb = $_POST['pg'.$i].",";
		$cc = $_POST['sg'.$i].",";
		$dd = $_POST['sf'.$i].",";
		$ee = $_POST['pf'.$i].",";
		$ff = $_POST['c'.$i].",";
		$gg = $_POST['active'.$i].",";
		$hh = $_POST['min'.$i].",";
		$zz = $_POST['OF'.$i].",";
		$jj = $_POST['DF'.$i].",";
		$kk = $_POST['OI'.$i].",";
		$ll = $_POST['DI'.$i].",";
		$mm = $_POST['BH'.$i]."
";
		$filetext = $filetext.$aa.$bb.$cc.$dd.$ee.$ff.$gg.$hh.$zz.$jj.$kk.$ll.$mm;

		$dc_insert1=$_POST['pg'.$i];
		$dc_insert2=$_POST['sg'.$i];
		$dc_insert3=$_POST['sf'.$i];
		$dc_insert4=$_POST['pf'.$i];
		$dc_insert5=$_POST['c'.$i];
		$dc_insert6=$_POST['active'.$i];
		$dc_insert7=$_POST['min'.$i];
		$dc_insert8=$_POST['OF'.$i];
		$dc_insert9=$_POST['DF'.$i];
		$dc_insertA=$_POST['OI'.$i];
		$dc_insertB=$_POST['DI'.$i];
		$dc_insertC=$_POST['BH'.$i];
		$dc_insertkey=addslashes($_POST['Name'.$i]);

		$updatequery1="UPDATE ".$prefix."_iblplyr SET dc_PGDepth = '$dc_insert1' WHERE name = '$dc_insertkey'";
		$updatequery2="UPDATE ".$prefix."_iblplyr SET dc_SGDepth = '$dc_insert2' WHERE name = '$dc_insertkey'";
		$updatequery3="UPDATE ".$prefix."_iblplyr SET dc_SFDepth = '$dc_insert3' WHERE name = '$dc_insertkey'";
		$updatequery4="UPDATE ".$prefix."_iblplyr SET dc_PFDepth = '$dc_insert4' WHERE name = '$dc_insertkey'";
		$updatequery5="UPDATE ".$prefix."_iblplyr SET dc_CDepth = '$dc_insert5' WHERE name = '$dc_insertkey'";
		$updatequery6="UPDATE ".$prefix."_iblplyr SET dc_active = '$dc_insert6' WHERE name = '$dc_insertkey'";
		$updatequery7="UPDATE ".$prefix."_iblplyr SET dc_minutes = '$dc_insert7' WHERE name = '$dc_insertkey'";
		$updatequery8="UPDATE ".$prefix."_iblplyr SET dc_of = '$dc_insert8' WHERE name = '$dc_insertkey'";
		$updatequery9="UPDATE ".$prefix."_iblplyr SET dc_df = '$dc_insert9' WHERE name = '$dc_insertkey'";
		$updatequeryA="UPDATE ".$prefix."_iblplyr SET dc_oi = '$dc_insertA' WHERE name = '$dc_insertkey'";
		$updatequeryB="UPDATE ".$prefix."_iblplyr SET dc_di = '$dc_insertB' WHERE name = '$dc_insertkey'";
		$updatequeryC="UPDATE ".$prefix."_iblplyr SET dc_bh = '$dc_insertC' WHERE name = '$dc_insertkey'";
		$updatequeryD="UPDATE ibl_team_history SET depth = NOW() + INTERVAL 2 HOUR WHERE team_name = '$Team_Name'";
		$updatequeryF="UPDATE ibl_team_history SET sim_depth = NOW() + INTERVAL 2 HOUR WHERE team_name = '$Team_Name'";
		$executeupdate1=mysql_query($updatequery1);
		$executeupdate2=mysql_query($updatequery2);
		$executeupdate3=mysql_query($updatequery3);
		$executeupdate4=mysql_query($updatequery4);
		$executeupdate5=mysql_query($updatequery5);
		$executeupdate6=mysql_query($updatequery6);
		$executeupdate7=mysql_query($updatequery7);
		$executeupdate8=mysql_query($updatequery8);
		$executeupdate9=mysql_query($updatequery9);
		$executeupdateA=mysql_query($updatequeryA);
		$executeupdateB=mysql_query($updatequeryB);
		$executeupdateC=mysql_query($updatequeryC);
		$executeupdateD=mysql_query($updatequeryD);
		$executeupdateF=mysql_query($updatequeryF);

		$i++;

		if ($dc_insert6 == 1) $activeplayers=$activeplayers+1;
		if ($dc_insert1 > 0 && $injury == 0) $pos_1=$pos_1+1;
		if ($dc_insert2 > 0 && $injury == 0) $pos_2=$pos_2+1;
		if ($dc_insert3 > 0 && $injury == 0) $pos_3=$pos_3+1;
		if ($dc_insert4 > 0 && $injury == 0) $pos_4=$pos_4+1;
		if ($dc_insert5 > 0 && $injury == 0) $pos_5=$pos_5+1;
	}

	$text = $text."</table>";
	if ($activeplayers < 11) {
		echo "<font color=red>Your lineup has not been submitted to the commissioner's office because it is an illegal lineup.  You must have at least 12 active players in your lineup; you have $activeplayers.  Please press the \"Back\" button on your browser and re-enter your lineup.</font>";
		$error=1;
	}
	if ($pos_1 < 3 && $error == 0) {
		echo "<font color=red>Your lineup has not been submitted to the commissioner's office because it is an illegal lineup.  You must have at least 3 players entered in PG slot; you have $pos_1.  Please press the \"Back\" button on your browser and re-enter your lineup.</font>";
		$error=1;
	}
	if ($pos_2 < 3 && $error == 0) {
		echo "<font color=red>Your lineup has not been submitted to the commissioner's office because it is an illegal lineup.  You must have at least 3 players entered in SG slot; you have $pos_2.  Please press the \"Back\" button on your browser and re-enter your lineup.</font>";
		$error=1;
	}
	if ($pos_3 < 3 && $error == 0) {
		echo "<font color=red>Your lineup has not been submitted to the commissioner's office because it is an illegal lineup.  You must have at least 3 players entered in SF slot; you have $pos_3.  Please press the \"Back\" button on your browser and re-enter your lineup.</font>";
		$error=1;
	}
	if ($pos_4 < 3 && $error == 0) {
		echo "<font color=red>Your lineup has not been submitted to the commissioner's office because it is an illegal lineup.  You must have at least 3 players entered in PF slot; you have $pos_4.  Please press the \"Back\" button on your browser and re-enter your lineup.</font>";
		$error=1;
	}
	if ($pos_5 < 3 && $error == 0) {
		echo "<font color=red>Your lineup has not been submitted to the commissioner's office because it is an illegal lineup.  You must have at least 3 players entered in C slot; you have $pos_5.  Please press the \"Back\" button on your browser and re-enter your lineup.</font>";
		$error=1;
	}

	if ($error == 0) {
		$emailsubject = $Team_Name." Depth Chart - $Set_Name Offensive Set";
		if ($emailtarget == Preseason) {
			$recipient = 'ajaynicolas@gmail.com';
		} else {
			$recipient = 'ajaynicolas@gmail.com';
		}

		if (mail($recipient, $emailsubject, $filetext, "From: ibldepthcharts@gmail.com")) {
			echo "<center> <font color=red>Your depth chart has been submitted and e-mailed successfully.  Thank you. </font></center>";
		} else {
			echo " <font color=red>Message failed to e-mail properly; please contact the commissioner.</font></center>";
		}
	}

	echo "<br>$text";
	// DISPLAYS DEPTH CHART

	CloseTable();
	include("footer.php");
}

switch($op) {
	case "submit":
		submit();
		break;
	default:
		main($user);
	break;
}

?>