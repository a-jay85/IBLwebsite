

<?php

$username = "iblhoops_chibul";
$password = "oliver23";
$database = "iblhoops_iblleague";

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$freeagentyear = $_REQUEST['freeagentyear'];

$tid = $_REQUEST['tid'];

$yr = $_REQUEST['yr'];

if ($tid == NULL)
{

if ($freeagentyear != NULL)
{
// === CODE FOR FREE AGENTS

echo "<html><head><title>Upcoming Free Agents List ($freeagentyear)</title></head><body>
<style>th{ font-size: 9pt; font-family:Arial; color: white; background-color: navy}td      { text-align: Left; font-size: 9pt; font-family:Arial; color:black; }.tdp { font-weight: bold; text-align: Left; font-size: 9pt; color:black; } </style>
<center><h2>Players Currently to be Free Agents at the end of the $freeagentyear Season</h2>
      <table border=1 cellspacing=1><tr><th colspan=27><center>Player Ratings</center></th></tr>
      <tr><th>Pos</th><th>Player</th><th>Team</th><th>Age</th><th>Sta</th><th>2ga</th><th>2g%</th><th>fta</th><th>ft%</th><th>3ga</th><th>3g%</th><th>orb</th><th>drb</th><th>ast</th><th>stl</th><th>to</th><th>blk</th><th>foul</th><th>o-o</th><th>d-o</th><th>p-o</th><th>t-o</th><th>o-d</th><th>d-d</th><th>p-d</th><th>t-d</th><th>Inj</th></tr>";

$query="SELECT * FROM nuke_iblplyr WHERE retired = 0 ORDER BY ordinal ASC";
$result=mysql_query($query);
$num=mysql_numrows($result);

$j=0;

while ($i < $num)
{
$draftyear=mysql_result($result,$i,"draftyear");
$exp=mysql_result($result,$i,"exp");
$cy=mysql_result($result,$i,"cy");
$cyt=mysql_result($result,$i,"cyt");

$yearoffreeagency=$draftyear+$exp+$cyt-$cy;

if ($yearoffreeagency == $freeagentyear)
{

$name=mysql_result($result,$i,"name");
$team=mysql_result($result,$i,"teamname");
$tid=mysql_result($result,$i,"tid");
$pid=mysql_result($result,$i,"pid");
$pos=mysql_result($result,$i,"pos");
$age=mysql_result($result,$i,"age");
$inj=mysql_result($result,$i,"injured");

$r_2ga=mysql_result($result,$i,"r_fga");
$r_2gp=mysql_result($result,$i,"r_fgp");
$r_fta=mysql_result($result,$i,"r_fta");
$r_ftp=mysql_result($result,$i,"r_ftp");
$r_3ga=mysql_result($result,$i,"r_tga");
$r_3gp=mysql_result($result,$i,"r_tgp");
$r_orb=mysql_result($result,$i,"r_orb");
$r_drb=mysql_result($result,$i,"r_drb");
$r_ast=mysql_result($result,$i,"r_ast");
$r_stl=mysql_result($result,$i,"r_stl");
$r_blk=mysql_result($result,$i,"r_blk");
$r_tvr=mysql_result($result,$i,"r_to");
$r_sta=mysql_result($result,$i,"sta");
$r_foul=mysql_result($result,$i,"r_foul");
$r_totoff=mysql_result($result,$i,"oo")+mysql_result($result,$i,"do")+mysql_result($result,$i,"po")+mysql_result($result,$i,"to");
$r_totdef=mysql_result($result,$i,"od")+mysql_result($result,$i,"dd")+mysql_result($result,$i,"pd")+mysql_result($result,$i,"td");
$r_oo=mysql_result($result,$i,"oo");
$r_do=mysql_result($result,$i,"do");
$r_po=mysql_result($result,$i,"po");
$r_to=mysql_result($result,$i,"to");
$r_od=mysql_result($result,$i,"od");
$r_dd=mysql_result($result,$i,"dd");
$r_pd=mysql_result($result,$i,"pd");
$r_td=mysql_result($result,$i,"td");
$r_foul=mysql_result($result,$i,"r_foul");

if ($j == 0)
{
echo "      <tr bgcolor=#ffffff align=center>";
$j=1;
} else {
echo "      <tr bgcolor=#e6e7e2 align=center>";
$j=0;
}
echo "      <td>$pos</td><td><a href=\"http://www.iblhoops.net/modules.php?name=Player&pa=showpage&pid=$pid\">$name</a></td><td><a href=\"team.php?tid=$tid\">$team</a></td><td>$age</td><td>$r_sta</td><td>$r_2ga</td><td>$r_2gp</td><td>$r_fta</td><td>$r_ftp</td><td>$r_3ga</td><td>$r_3gp</td><td>$r_orb</td><td>$r_drb</td><td>$r_ast</td><td>$r_stl</td><td>$r_tvr</td><td>$r_blk</td><td>$r_foul</td><td>$r_oo</td><td>$r_do</td><td>$r_po</td><td>$r_to</td><td>$r_od</td><td>$r_dd</td><td>$r_pd</td><td>$r_td</td><td>$inj</td></tr>
";
} else {
}

$i++;

}

echo "
    </table>";

// === END FREE AGENCY LISTINGS

} else {

echo "<html><head><title>IBL Master Team List</title></head><body>
<table border=1 cellspacing=1 cellpadding=1><tr><td><center><h2>IBL Master Team List</h2></center></td></tr>
<tr><td valign=top><center><h3>Teams</h3></center><ul>";

$queryteam="SELECT * FROM nuke_ibl_team_info ORDER BY teamid";
$resultteam=mysql_query($queryteam);
$num=mysql_numrows($resultteam);

$i=0;

while ($i < $num)
{
$teamid=mysql_result($resultteam,$i,"teamid");
$team_city=mysql_result($resultteam,$i,"team_city");
$team_name=mysql_result($resultteam,$i,"team_name");

echo "
<li><a href=\"team.php?tid=$teamid\">$team_city $team_name</a></li>";

$i++;
}

echo "</td></tr></table></body></html>";
}

} else {

$queryteam="SELECT * FROM nuke_ibl_team_info WHERE teamid = '$tid' ";
$resultteam=mysql_query($queryteam);

$teamid=mysql_result($resultteam,0,"teamid");
$team_city=mysql_result($resultteam,0,"team_city");
$team_name=mysql_result($resultteam,0,"team_name");
$color1=mysql_result($resultteam,0,"color1");
$color2=mysql_result($resultteam,0,"color2");
$owner_name=mysql_result($resultteam,0,"owner_name");
$owner_email=mysql_result($resultteam,0,"owner_email");
$aim=mysql_result($resultteam,0,"aim");
$msn=mysql_result($resultteam,0,"msn");
$SlideUp=mysql_result($resultteam,0,"SlideUp");
$Extension=mysql_result($resultteam,0,"Used_Extension_This_Season");

$querywl="SELECT * FROM nuke_iblteam_win_loss WHERE currentname = '$team_name' ORDER BY year ASC";
$resultwl=mysql_query($querywl);
$numwl=mysql_numrows($resultwl);

/* ===== CODE FOR CURRENT YEAR ===== */

if ($yr == NULL)
{
$queryfaon="SELECT * FROM nuke_modules WHERE mid = '28' ORDER BY title ASC";
$resultfaon=mysql_query($queryfaon);
$numfaon=mysql_numrows($resultfaon);
$faon=mysql_result($resultfaon,0,"active");

if ($faon==0)
{>
$query="SELECT * FROM nuke_iblplyr WHERE tid = '$tid' AND retired = 0 ORDER BY ordinal ASC";
} else {
$query="SELECT * FROM nuke_iblplyr WHERE tid = '$tid' AND retired = 0 AND cyt != cy ORDER BY ordinal ASC";
}
$result=mysql_query($query);
$num=mysql_numrows($result);

echo "<html><head><title>IBL $team_city $team_name Team Page</title></head><body>
<style>th{ font-size: 9pt; font-family:Arial; color:$color1; background-color: $color2}td      { text-align: Left; font-size: 9pt; font-family:Arial; color:black; }.tdp { font-weight: bold; text-align: Left; font-size: 9pt; color:black; } </style>
<img src=\"http://www.iblhoops.net/images/logo/$tid.jpg\">
><table><tr><td valign=top>
      <table>
      <tr><th colspan=25><center>Player Ratings</center></th></tr>
      <tr><th>Pos</th><th>Player</th><th>Age</th><th>Sta</th><th>2ga</th><th>2g%</th><th>fta</th><th>ft%</th><th>3ga</th><th>3g%</th><th>orb</th><th>drb</th><th>ast</th><th>stl</th><th>to</th><th>blk</th><th>o-o</th><th>d-o</th><th>p-o</th><th>t-o</th><th>o-d</th><th>d-d</th><th>p-d</th><th>t-d</th><th>Inj</th></tr>";

$i=0;

/* =======================RATINGS */

while ($i < $num)
{
$name=mysql_result($result,$i,"name");
$team=mysql_result($result,$i,"teamname");
$pid=mysql_result($result,$i,"pid");
$pos=mysql_result($result,$i,"pos");
$age=mysql_result($result,$i,"age");
$inj=mysql_result($result,$i,"injured");

$r_2ga=mysql_result($result,$i,"r_fga");
$r_2gp=mysql_result($result,$i,"r_fgp");
$r_fta=mysql_result($result,$i,"r_fta");
$r_ftp=mysql_result($result,$i,"r_ftp");
$r_3ga=mysql_result($result,$i,"r_tga");
$r_3gp=mysql_result($result,$i,"r_tgp");
$r_orb=mysql_result($result,$i,"r_orb");
$r_drb=mysql_result($result,$i,"r_drb");
$r_ast=mysql_result($result,$i,"r_ast");
$r_stl=mysql_result($result,$i,"r_stl");
$r_blk=mysql_result($result,$i,"r_blk");
$r_tvr=mysql_result($result,$i,"r_to");
$r_sta=mysql_result($result,$i,"sta");
$r_foul=mysql_result($result,$i,"r_foul");
$r_totoff=mysql_result($result,$i,"oo")+mysql_result($result,$i,"do")+mysql_result($result,$i,"po")+mysql_result($result,$i,"to");
$r_totdef=mysql_result($result,$i,"od")+mysql_result($result,$i,"dd")+mysql_result($result,$i,"pd")+mysql_result($result,$i,"td");
$r_oo=mysql_result($result,$i,"oo");
$r_do=mysql_result($result,$i,"do");
$r_po=mysql_result($result,$i,"po");
$r_to=mysql_result($result,$i,"to");
$r_od=mysql_result($result,$i,"od");
$r_dd=mysql_result($result,$i,"dd");
$r_pd=mysql_result($result,$i,"pd");
$r_td=mysql_result($result,$i,"td");

if ($i % 2)
{
echo "      <tr bgcolor=#ffffff align=center>";
} else {
echo "      <tr bgcolor=#e6e7e2 align=center>";
}
echo "      <td>$pos</td><td><a href=\"http://www.iblhoops.net/modules.php?name=Player&pa=showpage&pid=$pid\">$name</a></td><td>$age</td><td>$r_sta</td><td>$r_2ga</td><td>$r_2gp</td><td>$r_fta</td><td>$r_ftp</td><td>$r_3ga</td><td>$r_3gp</td><td>$r_orb</td><td>$r_drb</td><td>$r_ast</td><td>$r_stl</td><td>$r_tvr</td><td>$r_blk</td><td>$r_oo</td><td>$r_do</td><td>$r_po</td><td>$r_to</td><td>$r_od</td><td>$r_dd</td><td>$r_pd</td><td>$r_td</td><td>$inj</td></tr>";

$i++;

}

echo "
    </table>
    <hr color=$color1>
    <table>
         <tr><th colspan=19><center>Season Totals</center></th></tr>
<tr><th>Pos</th><th colspan=3>Player</th><th>g</th><th>gs</th><th>min</th><th>fgm - fga</th><th>ftm - fta</th><th>3gm - 3ga</th><th>orb</th><th>reb</th><th>ast</th><th>stl</th><th>to</th><th>blk</th><th>pf</th><th>pts</th></tr>";

$i=0;

/* =======================STATS */

while ($i < $num)
{
$name=mysql_result($result,$i,"name");
$pos=mysql_result($result,$i,"pos");

$stats_gm=mysql_result($result,$i,"stats_gm");
$stats_gs=mysql_result($result,$i,"stats_gs");
$stats_min=mysql_result($result,$i,"stats_min");
$stats_fgm=mysql_result($result,$i,"stats_fgm");
$stats_fga=mysql_result($result,$i,"stats_fga");
$stats_ftm=mysql_result($result,$i,"stats_ftm");
$stats_fta=mysql_result($result,$i,"stats_fta");
$stats_tgm=mysql_result($result,$i,"stats_3gm");
$stats_tga=mysql_result($result,$i,"stats_3ga");
$stats_orb=mysql_result($result,$i,"stats_orb");
$stats_drb=mysql_result($result,$i,"stats_drb");
$stats_ast=mysql_result($result,$i,"stats_ast");
$stats_stl=mysql_result($result,$i,"stats_stl");
$stats_to=mysql_result($result,$i,"stats_to");
$stats_blk=mysql_result($result,$i,"stats_blk");
$stats_pf=mysql_result($result,$i,"stats_pf");
$stats_reb=$stats_orb+$stats_drb;
$stats_pts=2*$stats_fgm+$stats_ftm+$stats_tgm;

if ($i % 2)
{
echo "      <tr bgcolor=#ffffff align=center>";
} else {
echo "      <tr bgcolor=#e6e7e2 align=center>";
}
echo "      <td><center>$pos</center></td><td colspan=3>$name</td><td><center>$stats_gm</center></td><td><center>$stats_gs</center></td><td><center>$stats_min</center></td><td><center>$stats_fgm - $stats_fga</center></td><td><center>$stats_ftm - $stats_fta</center></td><td><center>$stats_tgm - $stats_tga</center></td><td><center>$stats_orb</center></td><td><center>$stats_reb</center></td><td><center>$stats_ast</center></td><td><center>$stats_stl</center></td><td><center>$stats_to</center></td><td><center>$stats_blk</center></td><td><center>$stats_pf</center></td><td><center>$stats_pts</center></td></tr>";

$i++;

}

// ==== INSERT TEAM OFFENSE AND DEFENSE TOTALS ====

$queryTeamOffenseTotals="SELECT * FROM ibl_team_offense_stats WHERE team = '$team_name' AND year = '0'";
$resultTeamOffenseTotals=mysql_query($queryTeamOffenseTotals);
$numTeamOffenseTotals=mysql_numrows($resultTeamOffenseTotals);

$t=0;

while ($t < $numTeamOffenseTotals)
{

$team_off_games=mysql_result($resultTeamOffenseTotals,$t,"games");
$team_off_minutes=mysql_result($resultTeamOffenseTotals,$t,"minutes");
$team_off_fgm=mysql_result($resultTeamOffenseTotals,$t,"fgm");
$team_off_fga=mysql_result($resultTeamOffenseTotals,$t,"fga");
$team_off_ftm=mysql_result($resultTeamOffenseTotals,$t,"ftm");
$team_off_fta=mysql_result($resultTeamOffenseTotals,$t,"fta");
$team_off_tgm=mysql_result($resultTeamOffenseTotals,$t,"tgm");
$team_off_tga=mysql_result($resultTeamOffenseTotals,$t,"tga");
$team_off_orb=mysql_result($resultTeamOffenseTotals,$t,"orb");
$team_off_reb=mysql_result($resultTeamOffenseTotals,$t,"reb");
$team_off_ast=mysql_result($resultTeamOffenseTotals,$t,"ast");
$team_off_stl=mysql_result($resultTeamOffenseTotals,$t,"stl");
$team_off_tvr=mysql_result($resultTeamOffenseTotals,$t,"tvr");
$team_off_blk=mysql_result($resultTeamOffenseTotals,$t,"blk");
$team_off_pf=mysql_result($resultTeamOffenseTotals,$t,"pf");
$team_off_pts=$team_off_fgm+$team_off_fgm+$team_off_ftm+$team_off_tgm;

echo "      <th colspan=4><center>$team_name Offense</center></th><th><center>$team_off_games</center></th><th><center>$team_off_games</center></th><th><center>$team_off_minutes</center></th><th><center>$team_off_fgm - $team_off_fga</center></th><th><center>$team_off_ftm - $team_off_fta</center></th><th><center>$team_off_tgm - $team_off_tga</center></th><th><center>$team_off_orb</center></th><th><center>$team_off_reb</center></th><th><center>$team_off_ast</center></th><th><center>$team_off_stl</center></th><th><center>$team_off_tvr</center></th><th><center>$team_off_blk</center></th><th><center>$team_off_pf</center></th><th><center>$team_off_pts</center></th></tr>";

$t++;

}


$queryTeamDefenseTotals="SELECT * FROM ibl_team_defense_stats WHERE team = '$team_name' AND year = '0'";
$resultTeamDefenseTotals=mysql_query($queryTeamDefenseTotals);
$numTeamDefenseTotals=mysql_numrows($resultTeamDefenseTotals);

$t=0;

while ($t < $numTeamDefenseTotals)
{

$team_def_games=mysql_result($resultTeamDefenseTotals,$t,"games");
$team_def_minutes=mysql_result($resultTeamDefenseTotals,$t,"minutes");
$team_def_fgm=mysql_result($resultTeamDefenseTotals,$t,"fgm");
$team_def_fga=mysql_result($resultTeamDefenseTotals,$t,"fga");
$team_def_ftm=mysql_result($resultTeamDefenseTotals,$t,"ftm");
$team_def_fta=mysql_result($resultTeamDefenseTotals,$t,"fta");
$team_def_tgm=mysql_result($resultTeamDefenseTotals,$t,"tgm");
$team_def_tga=mysql_result($resultTeamDefenseTotals,$t,"tga");
$team_def_orb=mysql_result($resultTeamDefenseTotals,$t,"orb");
$team_def_reb=mysql_result($resultTeamDefenseTotals,$t,"reb");
$team_def_ast=mysql_result($resultTeamDefenseTotals,$t,"ast");
$team_def_stl=mysql_result($resultTeamDefenseTotals,$t,"stl");
$team_def_tvr=mysql_result($resultTeamDefenseTotals,$t,"tvr");
$team_def_blk=mysql_result($resultTeamDefenseTotals,$t,"blk");
$team_def_pf=mysql_result($resultTeamDefenseTotals,$t,"pf");
$team_def_pts=$team_def_fgm+$team_def_fgm+$team_def_ftm+$team_def_tgm;

echo "      <th colspan=4><center>$team_name Defense</center></th><th><center>$team_def_games</center></th><th><center>$team_def_games</center></th><th><center>$team_def_minutes</center></th><th><center>$team_def_fgm - $team_def_fga</center></th><th><center>$team_def_ftm - $team_def_fta</center></th><th><center>$team_def_tgm - $team_def_tga</center></th><th><center>$team_def_orb</center></th><th><center>$team_def_reb</center></th><th><center>$team_def_ast</center></th><th><center>$team_def_stl</center></th><th><center>$team_def_tvr</center></th><th><center>$team_def_blk</center></th><th><center>$team_def_pf</center></th><th><center>$team_def_pts</center></th></tr>

<tr><td colspan=18><hr color=$color1</td></tr>";

$t++;

}

echo "
   <tr><th colspan=19><center>Season Averages</center></th></tr>
<tr><th>Pos</th><th colspan=3>Player</th><th>g</th><th>gs</th><th>min</th><th>fgp</th><th>ftp</th><th>3gp</th><th>orb</th><th>reb</th><th>ast</th><th>stl</th><th>to</th><th>blk</th><th>pf</th><th>pts</th></tr>";

/* =======================AVERAGES */

$i=0;

while ($i < $num)
{
$name=mysql_result($result,$i,"name");
$pos=mysql_result($result,$i,"pos");

$stats_gm=mysql_result($result,$i,"stats_gm");
$stats_gs=mysql_result($result,$i,"stats_gs");
$stats_min=mysql_result($result,$i,"stats_min");
$stats_fgm=mysql_result($result,$i,"stats_fgm");
$stats_fga=mysql_result($result,$i,"stats_fga");
@$stats_fgp=($stats_fgm/$stats_fga);
$stats_ftm=mysql_result($result,$i,"stats_ftm");
$stats_fta=mysql_result($result,$i,"stats_fta");
@$stats_ftp=($stats_ftm/$stats_fta);
$stats_tgm=mysql_result($result,$i,"stats_3gm");
$stats_tga=mysql_result($result,$i,"stats_3ga");
@$stats_tgp=($stats_tgm/$stats_tga);
$stats_orb=mysql_result($result,$i,"stats_orb");
$stats_drb=mysql_result($result,$i,"stats_drb");
$stats_ast=mysql_result($result,$i,"stats_ast");
$stats_stl=mysql_result($result,$i,"stats_stl");
$stats_to=mysql_result($result,$i,"stats_to");
$stats_blk=mysql_result($result,$i,"stats_blk");
$stats_pf=mysql_result($result,$i,"stats_pf");
$stats_reb=$stats_orb+$stats_drb;
$stats_pts=2*$stats_fgm+$stats_ftm+$stats_tgm;

@$stats_mpg=($stats_min/$stats_gm);
@$stats_opg=($stats_orb/$stats_gm);
@$stats_rpg=($stats_reb/$stats_gm);
@$stats_apg=($stats_ast/$stats_gm);
@$stats_spg=($stats_stl/$stats_gm);
@$stats_tpg=($stats_to/$stats_gm);
@$stats_bpg=($stats_blk/$stats_gm);
@$stats_fpg=($stats_pf/$stats_gm);
@$stats_ppg=($stats_pts/$stats_gm);

if ($i % 2)
{
echo "      <tr bgcolor=#ffffff align=center>";
} else {
echo "      <tr bgcolor=#e6e7e2 align=center>";
}
echo "
<td>$pos</td><td colspan=3>$name</td>
<td><center>$stats_gm</center></td><td>$stats_gs</td><td><center>";
printf('%01.2f', $stats_mpg);
echo "</center></td><td><center>";
printf('%01.3f', $stats_fgp);
echo "</center></td><td><center>";
printf('%01.3f', $stats_ftp);
echo "</center></td><td><center>";
printf('%01.3f', $stats_tgp);
echo "</center></td><td><center>";
printf('%01.2f', $stats_opg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_rpg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_apg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_spg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_tpg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_bpg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_fpg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_ppg);
echo "</center></td></tr>";

$i++;

}

// ========= TEAM AVERAGES DISPLAY


$queryTeamOffenseTotals="SELECT * FROM ibl_team_offense_stats WHERE team = '$team_name' AND year = '0'";
$resultTeamOffenseTotals=mysql_query($queryTeamOffenseTotals);
$numTeamOffenseTotals=mysql_numrows($resultTeamOffenseTotals);

$t=0;

while ($t < $numTeamOffenseTotals)
{

$team_off_games=mysql_result($resultTeamOffenseTotals,$t,"games");
$team_off_minutes=mysql_result($resultTeamOffenseTotals,$t,"minutes");
$team_off_fgm=mysql_result($resultTeamOffenseTotals,$t,"fgm");
$team_off_fga=mysql_result($resultTeamOffenseTotals,$t,"fga");
@$team_off_fgp=($team_off_fgm/$team_off_fga);
$team_off_ftm=mysql_result($resultTeamOffenseTotals,$t,"ftm");
$team_off_fta=mysql_result($resultTeamOffenseTotals,$t,"fta");
@$team_off_ftp=($team_off_ftm/$team_off_fta);
$team_off_tgm=mysql_result($resultTeamOffenseTotals,$t,"tgm");
$team_off_tga=mysql_result($resultTeamOffenseTotals,$t,"tga");
@$team_off_tgp=($team_off_tgm/$team_off_tga);
$team_off_orb=mysql_result($resultTeamOffenseTotals,$t,"orb");
$team_off_reb=mysql_result($resultTeamOffenseTotals,$t,"reb");
$team_off_ast=mysql_result($resultTeamOffenseTotals,$t,"ast");
$team_off_stl=mysql_result($resultTeamOffenseTotals,$t,"stl");
$team_off_tvr=mysql_result($resultTeamOffenseTotals,$t,"tvr");
$team_off_blk=mysql_result($resultTeamOffenseTotals,$t,"blk");
$team_off_pf=mysql_result($resultTeamOffenseTotals,$t,"pf");
$team_off_pts=$team_off_fgm+$team_off_fgm+$team_off_ftm+$team_off_tgm;

@$team_off_avgmin=($team_off_minutes/$team_off_games);
@$team_off_avgorb=($team_off_orb/$team_off_games);
@$team_off_avgreb=($team_off_reb/$team_off_games);
@$team_off_avgast=($team_off_ast/$team_off_games);
@$team_off_avgstl=($team_off_stl/$team_off_games);
@$team_off_avgtvr=($team_off_tvr/$team_off_games);
@$team_off_avgblk=($team_off_blk/$team_off_games);
@$team_off_avgpf=($team_off_pf/$team_off_games);
@$team_off_avgpts=($team_off_pts/$team_off_games);


echo "<tr><th colspan=4>$team_name Offense</th>
<th><center>$team_off_games</center></th><th>$team_off_games</th><th><center>";
printf('%01.2f', $team_off_avgmin);
echo "</center></th><th><center>";
printf('%01.3f', $team_off_fgp);
echo "</center></th><th><center>";
printf('%01.3f', $team_off_ftp);
echo "</center></th><th><center>";
printf('%01.3f', $team_off_tgp);
echo "</center></th><th><center>";
printf('%01.2f', $team_off_avgorb);
echo "</center></th><th><center>";
printf('%01.2f', $team_off_avgreb);
echo "</center></th><th><center>";
printf('%01.2f', $team_off_avgast);
echo "</center></th><th><center>";
printf('%01.2f', $team_off_avgstl);
echo "</center></th><th><center>";
printf('%01.2f', $team_off_avgtvr);
echo "</center></th><th><center>";
printf('%01.2f', $team_off_avgblk);
echo "</center></th><th><center>";
printf('%01.2f', $team_off_avgpf);
echo "</center></th><th><center>";
printf('%01.2f', $team_off_avgpts);
echo "</center></th></tr>";

$t++;

}


$queryTeamDefenseTotals="SELECT * FROM ibl_team_defense_stats WHERE team = '$team_name' AND year = '0'";
$resultTeamDefenseTotals=mysql_query($queryTeamDefenseTotals);
$numTeamDefenseTotals=mysql_numrows($resultTeamDefenseTotals);

$t=0;

while ($t < $numTeamDefenseTotals)
{

$team_def_games=mysql_result($resultTeamDefenseTotals,$t,"games");
$team_def_minutes=mysql_result($resultTeamDefenseTotals,$t,"minutes");
$team_def_fgm=mysql_result($resultTeamDefenseTotals,$t,"fgm");
$team_def_fga=mysql_result($resultTeamDefenseTotals,$t,"fga");
@$team_def_fgp=($team_def_fgm/$team_def_fga);
$team_def_ftm=mysql_result($resultTeamDefenseTotals,$t,"ftm");
$team_def_fta=mysql_result($resultTeamDefenseTotals,$t,"fta");
@$team_def_ftp=($team_def_ftm/$team_def_fta);
$team_def_tgm=mysql_result($resultTeamDefenseTotals,$t,"tgm");
$team_def_tga=mysql_result($resultTeamDefenseTotals,$t,"tga");
@$team_def_tgp=($team_def_tgm/$team_def_tga);
$team_def_orb=mysql_result($resultTeamDefenseTotals,$t,"orb");
$team_def_reb=mysql_result($resultTeamDefenseTotals,$t,"reb");
$team_def_ast=mysql_result($resultTeamDefenseTotals,$t,"ast");
$team_def_stl=mysql_result($resultTeamDefenseTotals,$t,"stl");
$team_def_tvr=mysql_result($resultTeamDefenseTotals,$t,"tvr");
$team_def_blk=mysql_result($resultTeamDefenseTotals,$t,"blk");
$team_def_pf=mysql_result($resultTeamDefenseTotals,$t,"pf");
$team_def_pts=$team_def_fgm+$team_def_fgm+$team_def_ftm+$team_def_tgm;

@$team_def_avgmin=($team_def_minutes/$team_def_games);
@$team_def_avgorb=($team_def_orb/$team_def_games);
@$team_def_avgreb=($team_def_reb/$team_def_games);
@$team_def_avgast=($team_def_ast/$team_def_games);
@$team_def_avgstl=($team_def_stl/$team_def_games);
@$team_def_avgtvr=($team_def_tvr/$team_def_games);
@$team_def_avgblk=($team_def_blk/$team_def_games);
@$team_def_avgpf=($team_def_pf/$team_def_games);
@$team_def_avgpts=($team_def_pts/$team_def_games);


echo "<tr><th colspan=4>$team_name Defense</th>
<th><center>$team_def_games</center></th><th>$team_def_games</th><th><center>";
printf('%01.2f', $team_def_avgmin);
echo "</center></th><th><center>";
printf('%01.3f', $team_def_fgp);
echo "</center></th><th><center>";
printf('%01.3f', $team_def_ftp);
echo "</center></th><th><center>";
printf('%01.3f', $team_def_tgp);
echo "</center></th><th><center>";
printf('%01.2f', $team_def_avgorb);
echo "</center></th><th><center>";
printf('%01.2f', $team_def_avgreb);
echo "</center></th><th><center>";
printf('%01.2f', $team_def_avgast);
echo "</center></th><th><center>";
printf('%01.2f', $team_def_avgstl);
echo "</center></th><th><center>";
printf('%01.2f', $team_def_avgtvr);
echo "</center></th><th><center>";
printf('%01.2f', $team_def_avgblk);
echo "</center></th><th><center>";
printf('%01.2f', $team_def_avgpf);
echo "</center></th><th><center>";
printf('%01.2f', $team_def_avgpts);
echo "</center></th></tr>";

$t++;

}



echo "
    </table>
    <hr color=$color1>
    <table>
   <tr><th colspan=18><center>Contracts</center></th></tr>
<tr><th>Pos</th><th colspan=3>Player</th><th>Bird</th><th>Year1</th><th>Year2</th><th>Year3</th><th>Year4</th><th>Year5</th><th>Year6</th><td bgcolor=#000000 width=3></td><th>Talent</th><th>Skill</th><th>Intang</th><th>Clutch</th><th>Consistency</th></tr>";

/* =======================CONTRACTS ET AL */

$i=0;
$cap1=0;
$cap2=0;
$cap3=0;
$cap4=0;
$cap5=0;
$cap6=0;

while ($i < $num)
{

$name=mysql_result($result,$i,"name");
$pos=mysql_result($result,$i,"pos");

$cy=mysql_result($result,$i,"cy");
$cyt=mysql_result($result,$i,"cyt");

if ($faon == 0) {
$year1=$cy;
$year2=$cy+1;
$year3=$cy+2;
$year4=$cy+3;
$year5=$cy+4;
$year6=$cy+5;
} else {
$year1=$cy+1;
$year2=$cy+2;
$year3=$cy+3;
$year4=$cy+4;
$year5=$cy+5;
$year6=$cy+6;
}

if ($cy==0)
{

if ($year1 < 7)
{
$con1=mysql_result($result,$i,"cy1");
} else {
$con1=0;
}

if ($year2 < 7)
{
$con2=mysql_result($result,$i,"cy2");
} else {
$con2=0;
}

if ($year3 < 7)
{
$con3=mysql_result($result,$i,"cy3");
} else {
$con3=0;
}

if ($year4 < 7)
{
$con4=mysql_result($result,$i,"cy4");
} else {
$con4=0;
}

if ($year5 < 7)
{
$con5=mysql_result($result,$i,"cy5");
} else {
$con5=0;
}

if ($year6 < 7)
{
$con6=mysql_result($result,$i,"cy6");
} else {
$con6=0;
}

} else {
if ($year1 < 7)
{
$con1=mysql_result($result,$i,"cy$year1");
} else {
$con1=0;
}

if ($year2 < 7)
{
$con2=mysql_result($result,$i,"cy$year2");
} else {
$con2=0;
}

if ($year3 < 7)
{
$con3=mysql_result($result,$i,"cy$year3");
} else {
$con3=0;
}

if ($year4 < 7)
{
$con4=mysql_result($result,$i,"cy$year4");
} else {
$con4=0;
}

if ($year5 < 7)
{
$con5=mysql_result($result,$i,"cy$year5");
} else {
$con5=0;
}

if ($year6 < 7)
{
$con6=mysql_result($result,$i,"cy$year6");
} else {
$con6=0;
}
}

$bird=mysql_result($result,$i,"bird");
$talent=mysql_result($result,$i,"talent");
$skill=mysql_result($result,$i,"skill");
$intangibles=mysql_result($result,$i,"intangibles");
$Clutch=mysql_result($result,$i,"Clutch");
$Consistency=mysql_result($result,$i,"Consistency");

if ($i % 2)
{
echo "      <tr bgcolor=#ffffff align=center>";
} else {
echo "      <tr bgcolor=#e6e7e2 align=center>";
}
echo "      <td>$pos</td><td colspan=3>$name</td><td>$bird</td><td>$con1</td><td>$con2</td><td>$con3</td><td>$con4</td><td>$con5</td><td>$con6</td><td bgcolor=#000000></td><td>$talent</td><td>$skill</td><td>$intangibles</td><td>$Clutch</td><td>$Consistency</td></tr>";

$cap1=$cap1+$con1;
$cap2=$cap2+$con2;
$cap3=$cap3+$con3;
$cap4=$cap4+$con4;
$cap5=$cap5+$con5;
$cap6=$cap6+$con6;

$i++;

}

$cap1=$cap1/100;
$cap2=$cap2/100;
$cap3=$cap3/100;
$cap4=$cap4/100;
$cap5=$cap5/100;
$cap6=$cap6/100;

echo "      <tr bgcolor=#bbbbff><td></td><td colspan=3>Cap Totals</td><td></td><td>";
printf('%01.2f', $cap1);
echo "</td><td>";
printf('%01.2f', $cap2);
echo "</td><td>";
printf('%01.2f', $cap3);
echo "</td><td>";
printf('%01.2f', $cap4);
echo "</td><td>";
printf('%01.2f', $cap5);
echo "</td><td>";
printf('%01.2f', $cap6);
echo "</td><td bgcolor=#000000></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td colspan=15>";

/* =================== INSERT STARTERS =========== */

$startingPG=NULL;
$startingSG=NULL;
$startingSF=NULL;
$startingPF=NULL;
$startingC=NULL;

$startingPGpid=NULL;
$startingSGpid=NULL;
$startingSFpid=NULL;
$startingPFpid=NULL;
$startingCpid=NULL;

$s=0;

while ($s < $num)
{

if (mysql_result($result,$s,"PGDepth")==1)
{
$startingPG=mysql_result($result,$s,"name");
$startingPGpid=mysql_result($result,$s,"pid");
} else {
}

if (mysql_result($result,$s,"SGDepth") == 1)
{
$startingSG=mysql_result($result,$s,"name");
$startingSGpid=mysql_result($result,$s,"pid");
} else {
}

if (mysql_result($result,$s,"SFDepth") == 1)
{
$startingSF=mysql_result($result,$s,"name");
$startingSFpid=mysql_result($result,$s,"pid");
} else {
}

if (mysql_result($result,$s,"PFDepth") == 1)
{
$startingPF=mysql_result($result,$s,"name");
$startingPFpid=mysql_result($result,$s,"pid");
} else {
}

if (mysql_result($result,$s,"CDepth") == 1)
{
$startingC=mysql_result($result,$s,"name");
$startingCpid=mysql_result($result,$s,"pid");
} else {
}

$s++;

}

echo "<center><table border=1 cellpadding=1 cellspacing=1><tr><th colspan=5><center><b>Last Chunk's Starters</b></center></th></tr>
<tr><td><center><b>Starting PG</b><br><img src=\"http://www.iblhoops.net/images/player/$startingPGpid.jpg\"><br><a href=\"http://www.iblhoops.net/modules.php?name=Player&pa=showpage&pid=$startingPGpid\">$startingPG</a></td>
<td><center><b>Starting SG</b><br><img src=\"http://www.iblhoops.net/images/player/$startingSGpid.jpg\"><br><a href=\"http://www.iblhoops.net/modules.php?name=Player&pa=showpage&pid=$startingSGpid\">$startingSG</a></td>
<td><center><b>Starting SF</b><br><img src=\"http://www.iblhoops.net/images/player/$startingSFpid.jpg\"><br><a href=\"http://www.iblhoops.net/modules.php?name=Player&pa=showpage&pid=$startingSFpid\">$startingSF</a></td>
<td><center><b>Starting PF</b><br><img src=\"http://www.iblhoops.net/images/player/$startingPFpid.jpg\"><br><a href=\"http://www.iblhoops.net/modules.php?name=Player&pa=showpage&pid=$startingPFpid\">$startingPF</a></td>
<td><center><b>Starting C</b><br><img src=\"http://www.iblhoops.net/images/player/$startingCpid.jpg\"><br><a href=\"http://www.iblhoops.net/modules.php?name=Player&pa=showpage&pid=$startingCpid\">$startingC</a></td></tr></table></td></tr></table>
";

/* ===== FORK FOR PREVIOUS YEARS ===== */

} else {

$query="SELECT * FROM nuke_iblhist WHERE teamid = '$tid' AND year = $yr ORDER BY name ASC";
$result=mysql_query($query);
$num=mysql_numrows($result);

echo "<html><head><title>IBL $team_city $team_name Team Page ($yr)</title></head><body>
<style>th{ font-size: 9pt; font-family:Arial; color:$color1; background-color: $color2}td      { text-align: Left; font-size: 9pt; font-family:Arial; color:black; }.tdp { font-weight: bold; text-align: Left; font-size: 9pt; color:black; } </style>
<img src=\"http://www.iblhoops.net/images/logo/$tid.jpg\">
<table><tr><td valign=top>
      <table>
      <tr><th colspan=21><center>Player Ratings ($yr)</center></th></tr>
      <tr><th>Player</th><th>2ga</th><th>2g%</th><th>fta</th><th>ft%</th><th>3ga</th><th>3g%</th><th>orb</th><th>drb</th><th>ast</th><th>stl</th><th>to</th><th>blk</th><th>o-o</th><th>d-o</th><th>p-o</th><th>t-o</th><th>o-d</th><th>d-d</th><th>p-d</th><th>t-d</th></tr>";

$i=0;

/* =======================RATINGS */

while ($i < $num)
{
$name=mysql_result($result,$i,"name");
$team=mysql_result($result,$i,"team");
$pid=mysql_result($result,$i,"pid");

$r_2ga=mysql_result($result,$i,"r_2ga");
$r_2gp=mysql_result($result,$i,"r_2gp");
$r_fta=mysql_result($result,$i,"r_fta");
$r_ftp=mysql_result($result,$i,"r_ftp");
$r_3ga=mysql_result($result,$i,"r_3ga");
$r_3gp=mysql_result($result,$i,"r_3gp");
$r_orb=mysql_result($result,$i,"r_orb");
$r_drb=mysql_result($result,$i,"r_drb");
$r_ast=mysql_result($result,$i,"r_ast");
$r_stl=mysql_result($result,$i,"r_stl");
$r_blk=mysql_result($result,$i,"r_blk");
$r_tvr=mysql_result($result,$i,"r_tvr");
$r_totoff=mysql_result($result,$i,"r_oo")+mysql_result($result,$i,"r_do")+mysql_result($result,$i,"r_po")+mysql_result($result,$i,"r_to");
$r_totdef=mysql_result($result,$i,"r_od")+mysql_result($result,$i,"r_dd")+mysql_result($result,$i,"r_pd")+mysql_result($result,$i,"r_td");
$r_oo=mysql_result($result,$i,"r_oo");
$r_do=mysql_result($result,$i,"r_do");
$r_po=mysql_result($result,$i,"r_po");
$r_to=mysql_result($result,$i,"r_to");
$r_od=mysql_result($result,$i,"r_od");
$r_dd=mysql_result($result,$i,"r_dd");
$r_pd=mysql_result($result,$i,"r_pd");
$r_td=mysql_result($result,$i,"r_td");

if ($i % 2)
{
echo "      <tr bgcolor=#ffffff align=center>";
} else {
echo "      <tr bgcolor=#e6e7e2 align=center>";
}
echo "      <script src="sorttable.js"></script><td><a href=\"http://www.iblhoops.net/modules.php?name=Player&pa=showpage&pid=$pid\">$name</a></td><td>$r_2ga</td><td>$r_2gp</td><td>$r_fta</td><td>$r_ftp</td><td>$r_3ga</td><td>$r_3gp</td><td>$r_orb</td><td>$r_drb</td><td>$r_ast</td><td>$r_stl</td><td>$r_tvr</td><td>$r_blk</td><td>$r_oo</td><td>$r_do</td><td>$r_po</td><td>$r_to</td><td>$r_od</td><td>$r_dd</td><td>$r_pd</td><td>$r_td</td></tr>";

$i++;

}

echo "
    </table>
    <table>
         <tr><th colspan=17><center>Season Totals ($yr)</center></th></tr>
<tr><th colspan=3>Player</th><th>g</th><th>min</th><th>fgm - fga</th><th>ftm - fta</th><th>3gm - 3ga</th><th>orb</th><th>reb</th><th>ast</th><th>stl</th><th>to</th><th>blk</th><th>pf</th><th>pts</th></tr>";

$i=0;

/* =======================STATS */

while ($i < $num)
{
$name=mysql_result($result,$i,"name");

$stats_gm=mysql_result($result,$i,"gm");
$stats_min=mysql_result($result,$i,"min");
$stats_fgm=mysql_result($result,$i,"fgm");
$stats_fga=mysql_result($result,$i,"fga");
$stats_ftm=mysql_result($result,$i,"ftm");
$stats_fta=mysql_result($result,$i,"fta");
$stats_tgm=mysql_result($result,$i,"3gm");
$stats_tga=mysql_result($result,$i,"3ga");
$stats_orb=mysql_result($result,$i,"orb");
$stats_ast=mysql_result($result,$i,"ast");
$stats_stl=mysql_result($result,$i,"stl");
$stats_to=mysql_result($result,$i,"tvr");
$stats_blk=mysql_result($result,$i,"blk");
$stats_pf=mysql_result($result,$i,"pf");
$stats_reb=mysql_result($result,$i,"reb");
$stats_pts=2*$stats_fgm+$stats_ftm+$stats_tgm;

if ($i % 2)
{
echo "      <tr bgcolor=#ffffff align=center>";
} else {
echo "      <tr bgcolor=#e6e7e2 align=center>";
}
echo "      <td colspan=3>$name</td><td><center>$stats_gm</center></td><td><center>$stats_min</center></td><td><center>$stats_fgm - $stats_fga</center></td><td><center>$stats_ftm - $stats_fta</center></td><td><center>$stats_tgm - $stats_tga</center></td><td><center>$stats_orb</center></td><td><center>$stats_reb</center></td><td><center>$stats_ast</center></td><td><center>$stats_stl</center></td><td><center>$stats_to</center></td><td><center>$stats_blk</center></td><td><center>$stats_pf</center></td><td><center>$stats_pts</center></td></tr>";

$i++;

}

echo "
   <tr><th colspan=17><center>Season Averages ($yr)</center></th></tr>
<tr><th colspan=3>Player</th><th>g</th><th>min</th><th>fgp</th><th>ftp</th><th>3gp</th><th>orb</th><th>reb</th><th>ast</th><th>stl</th><th>to</th><th>blk</th><th>pf</th><th>pts</th></tr>";

/* =======================AVERAGES */

$i=0;

while ($i < $num)
{
$name=mysql_result($result,$i,"name");

$stats_gm=mysql_result($result,$i,"gm");
$stats_min=mysql_result($result,$i,"min");
$stats_fgm=mysql_result($result,$i,"fgm");
$stats_fga=mysql_result($result,$i,"fga");
@$stats_fgp=($stats_fgm/$stats_fga);
$stats_ftm=mysql_result($result,$i,"ftm");
$stats_fta=mysql_result($result,$i,"fta");
@$stats_ftp=($stats_ftm/$stats_fta);
$stats_tgm=mysql_result($result,$i,"3gm");
$stats_tga=mysql_result($result,$i,"3ga");
@$stats_tgp=($stats_tgm/$stats_tga);
$stats_orb=mysql_result($result,$i,"orb");
$stats_ast=mysql_result($result,$i,"ast");
$stats_stl=mysql_result($result,$i,"stl");
$stats_to=mysql_result($result,$i,"tvr");
$stats_blk=mysql_result($result,$i,"blk");
$stats_pf=mysql_result($result,$i,"pf");
$stats_reb=mysql_result($result,$i,"reb");
$stats_pts=2*$stats_fgm+$stats_ftm+$stats_tgm;

@$stats_mpg=($stats_min/$stats_gm);
@$stats_opg=($stats_orb/$stats_gm);
@$stats_rpg=($stats_reb/$stats_gm);
@$stats_apg=($stats_ast/$stats_gm);
@$stats_spg=($stats_stl/$stats_gm);
@$stats_tpg=($stats_to/$stats_gm);
@$stats_bpg=($stats_blk/$stats_gm);
@$stats_fpg=($stats_pf/$stats_gm);
@$stats_ppg=($stats_pts/$stats_gm);

if ($i % 2)
{
echo "      <tr bgcolor=#ffffff align=center>";
} else {
echo "      <tr bgcolor=#e6e7e2 align=center>";
}
echo "
<td colspan=3>$name</td>
<td><center>$stats_gm</center></td><td><center>";
printf('%01.2f', $stats_mpg);
echo "</center></td><td><center>";
printf('%01.3f', $stats_fgp);
echo "</center></td><td><center>";
printf('%01.3f', $stats_ftp);
echo "</center></td><td><center>";
printf('%01.3f', $stats_tgp);
echo "</center></td><td><center>";
printf('%01.2f', $stats_opg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_rpg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_apg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_spg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_tpg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_bpg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_fpg);
echo "</center></td><td><center>";
printf('%01.2f', $stats_ppg);
echo "</center></td></tr>";

$i++;

}

echo "
    </table>
";

/* ===== END FORK FOR PREVIOUS YEARS ===== */
}


// ==== GET OWNER PRIVATE MESSAGE INFO

$queryo="SELECT * FROM nuke_users WHERE user_ibl_team = '$team_name' ORDER BY user_id ASC";
$resulto=mysql_query($queryo);
$numo=mysql_numrows($resulto);

// ==== IF MORE THAN ONE OWNER (BECAUSE WIGNOSY KEEPS A TEAM ON HAND), RE-QUERY AND DROP WIGNOSY FROM QUERY

if ($numo > 1)
{
$queryo="SELECT * FROM nuke_users WHERE user_ibl_team = '$team_name' AND user_id > 2 ORDER BY user_id ASC";
$resulto=mysql_query($queryo);
$numo=mysql_numrows($resulto);
}


$user_id=mysql_result($resulto,0,"user_id");
$username=mysql_result($resulto,0,"username");
$user_lastvisit=mysql_result($resulto,0,"user_lastvisit");
$visitdate=date(r,$user_lastvisit);

echo "
</td><td valign=top>
<table width=200><tr bgcolor=#dddddd><td><center>
<a href=\"team.php?tid=$tid\">$team_city $team_name</a><hr>
<b>Owner Nickname:</b> <a href=\"http://www.iblhoops.net/modules.php?name=Your_Account&op=userinfo&username=$username\">$username</a><br>
<a href=\"http://www.iblhoops.net/modules.php?name=Private_Messages&mode=post&u=$user_id\"><font color=#ff0000>Send Private Message</font></a><hr>
<b>Owner Name/Email:</b> <a href=\"mailto:$owner_email\">$owner_name</a><hr>
<b>Last Visited the Site:</b> $visitdate
<hr>";

if ($SlideUp == 1) {
echo "<b>TEAM PHILOSOPHY:</b> \"Slide Up\"<hr>";
} else {
echo "<b>TEAM PHILOSOPHY:</b> \"Slide Down\"<hr>";
}

if ($Extension == 1) {
echo "Has Used Contract Extension for this Season<br>";
} else {
echo "Contract Extension for this Season still available.<br>";
}

echo "</center></td></tr>
";

echo "<tr><td>
<center><u>TEAM HISTORY</u><br>";

/* =======================YEAR BY YEAR TEAM RECORDS */

$h=0;
$wintot=0;
$lostot=0;

while ($h < $numwl)
{
$yearwl=mysql_result($resultwl,$h,"year");
$namewl=mysql_result($resultwl,$h,"namethatyear");
$wins=mysql_result($resultwl,$h,"wins");
$losses=mysql_result($resultwl,$h,"losses");

$wintot=$wintot+$wins;
$lostot=$lostot+$losses;

echo "
<a href=\"team.php?tid=$tid&yr=$yearwl\">$yearwl $namewl</a>: $wins-$losses <br>";

$h++;

}

@$wlpct=$wintot/($wintot+$lostot);

echo "TOTAL: $wintot-$lostot (";
printf('%01.3f', $wlpct);

echo " Pct)
</td></tr><tr><td><hr></td></tr><tr><td bgcolor=#cccccc><center><b><u>FIRST-ROUND PLAYOFF RESULTS</u></b><br>";

/* =========== PLAYOFF RESULTS ========== */
$queryplayoffs="SELECT * FROM ibl_playoff_results ORDER BY year, round ASC";
$resultplayoffs=mysql_query($queryplayoffs);
$numplayoffs=mysql_numrows($resultplayoffs);

$pp=0;
$totalplayoffwins=0;
$totalplayofflosses=0;
$serieswins=0;

while ($pp < $numplayoffs)
{

$playoffround=mysql_result($resultplayoffs,$pp,"round");
$playoffyear=mysql_result($resultplayoffs,$pp,"year");
$playoffwinner=mysql_result($resultplayoffs,$pp,"winner");
$playoffloser=mysql_result($resultplayoffs,$pp,"loser");
$playoffloser_games=mysql_result($resultplayoffs,$pp,"loser_games");

if ($playoffround == 1)
{
  if ($playoffwinner == $team_name)
  {
  echo "$playoffyear - $team_name 4, $playoffloser $playoffloser_games<br>";
  $totalplayoffwins=$totalplayoffwins+4;
  $totalplayofflosses=$totalplayofflosses+$playoffloser_games;
  $serieswins++;
  } else if ($playoffloser == $team_name) {
  echo "$playoffyear - $playoffwinner 4, $team_name $playoffloser_games<br>";
  $totalplayofflosses=$totalplayofflosses+4;
  $totalplayoffwins=$totalplayoffwins+$playoffloser_games;
  }
} else {
}

$pp++;
}
@$playoffwlpct=$totalplayoffwins/($totalplayoffwins+$totalplayofflosses);
echo "<br><i>Total First-Round Record: $totalplayoffwins-$totalplayofflosses (";
printf('%01.3f', $playoffwlpct);
echo " Pct., winning $serieswins series)</i></td></tr>
<tr><td><center><b><u>CONF. SEMIFINAL RESULTS</u></b><br>";

$pp=0;
$totalplayoffwins=0;
$totalplayofflosses=0;
$serieswins=0;
while ($pp < $numplayoffs)
{

$playoffround=mysql_result($resultplayoffs,$pp,"round");
$playoffyear=mysql_result($resultplayoffs,$pp,"year");
$playoffwinner=mysql_result($resultplayoffs,$pp,"winner");
$playoffloser=mysql_result($resultplayoffs,$pp,"loser");
$playoffloser_games=mysql_result($resultplayoffs,$pp,"loser_games");

if ($playoffround == 2)
{
  if ($playoffwinner == $team_name)
  {
  echo "$playoffyear - $team_name 4, $playoffloser $playoffloser_games<br>";
  $totalplayoffwins=$totalplayoffwins+4;
  $totalplayofflosses=$totalplayofflosses+$playoffloser_games;
  $serieswins++;
  } else if ($playoffloser == $team_name) {
  echo "$playoffyear - $playoffwinner 4, $team_name $playoffloser_games<br>";
  $totalplayofflosses=$totalplayofflosses+4;
  $totalplayoffwins=$totalplayoffwins+$playoffloser_games;
  }
} else {
}

$pp++;
}

@$playoffwlpct=$totalplayoffwins/($totalplayoffwins+$totalplayofflosses);
echo "<br><i>Conference Semifinal Record: $totalplayoffwins-$totalplayofflosses (";
printf('%01.3f', $playoffwlpct);
echo " Pct., winning $serieswins series)</i></td></tr>
<tr><td bgcolor=#cccccc><center><b><u>CONF. FINAL RESULTS</u></b><br>";

$pp=0;
$totalplayoffwins=0;
$totalplayofflosses=0;
$serieswins=0;
while ($pp < $numplayoffs)
{

$playoffround=mysql_result($resultplayoffs,$pp,"round");
$playoffyear=mysql_result($resultplayoffs,$pp,"year");
$playoffwinner=mysql_result($resultplayoffs,$pp,"winner");
$playoffloser=mysql_result($resultplayoffs,$pp,"loser");
$playoffloser_games=mysql_result($resultplayoffs,$pp,"loser_games");

if ($playoffround == 3)
{
  if ($playoffwinner == $team_name)
  {
  echo "$playoffyear - $team_name 4, $playoffloser $playoffloser_games<br>";
  $totalplayoffwins=$totalplayoffwins+4;
  $totalplayofflosses=$totalplayofflosses+$playoffloser_games;
  $serieswins++;
  } else if ($playoffloser == $team_name) {
  echo "$playoffyear - $playoffwinner 4, $team_name $playoffloser_games<br>";
  $totalplayofflosses=$totalplayofflosses+4;
  $totalplayoffwins=$totalplayoffwins+$playoffloser_games;
  }
} else {
}

$pp++;
}
@$playoffwlpct=$totalplayoffwins/($totalplayoffwins+$totalplayofflosses);
echo "<br><i>Conference Finals Record: $totalplayoffwins-$totalplayofflosses (";
printf('%01.3f', $playoffwlpct);
echo " Pct., winning $serieswins series)</i></td></tr>
<tr><td><center><b><u>IBL FINALS RESULTS</u></b><br>";

$pp=0;
$totalplayoffwins=0;
$totalplayofflosses=0;
$serieswins=0;

while ($pp < $numplayoffs)
{

$playoffround=mysql_result($resultplayoffs,$pp,"round");
$playoffyear=mysql_result($resultplayoffs,$pp,"year");
$playoffwinner=mysql_result($resultplayoffs,$pp,"winner");
$playoffloser=mysql_result($resultplayoffs,$pp,"loser");
$playoffloser_games=mysql_result($resultplayoffs,$pp,"loser_games");

if ($playoffround == 4)
{
  if ($playoffwinner == $team_name)
  {
  echo "$playoffyear - $team_name 4, $playoffloser $playoffloser_games<br>";
  $totalplayoffwins=$totalplayoffwins+4;
  $totalplayofflosses=$totalplayofflosses+$playoffloser_games;
  $serieswins++;
  } else if ($playoffloser == $team_name) {
  echo "$playoffyear - $playoffwinner 4, $team_name $playoffloser_games<br>";
  $totalplayofflosses=$totalplayofflosses+4;
  $totalplayoffwins=$totalplayoffwins+$playoffloser_games;
  }
} else {
}

$pp++;
}

@$playoffwlpct=$totalplayoffwins/($totalplayoffwins+$totalplayofflosses);
echo "<br><i>IBL Finals Record: $totalplayoffwins-$totalplayofflosses (";
printf('%01.3f', $playoffwlpct);
echo " Pct., winning $serieswins series)</i></td></tr>
<tr><td bgcolor=cccccc>
<center><u><b>DRAFT PICKS</b></u><br>";

/*=================== DISPLAY DRAFT PICKS   */

$querypicks="SELECT * FROM ibl_draft_picks WHERE ownerofpick = '$team_name' ORDER BY year, round ASC";
$resultpicks=mysql_query($querypicks);
$numpicks=mysql_numrows($resultpicks);

$hh=0;

while ($hh < $numpicks)
{

$ownerofpick=mysql_result($resultpicks,$hh,"ownerofpick");
$teampick=mysql_result($resultpicks,$hh,"teampick");
$year=mysql_result($resultpicks,$hh,"year");
$round=mysql_result($resultpicks,$hh,"round");

echo "$year $teampick ";
if ($round==1)
{
echo "1st-round pick <hr>
";
} else if ($round==2) {
echo "2nd-round pick <hr>
";
} else {
}

$hh++;
}


echo "</center></td></tr></td>
</tr></table>
</body></html>";

}

mysql_close();

?>