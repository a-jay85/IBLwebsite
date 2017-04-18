<?php

$username = "iblhoops_chibul";
$password = "oliver23";
$database = "iblhoops_ibl4";

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


	$query13="UPDATE iblhoops_iblv2forums.v4_forum_stats, iblhoops_ibl4.nuke_iblplyr
SET iblhoops_iblv2forums.v4_forum_stats.pts_lead = (SELECT name FROM iblhoops_ibl4.nuke_iblplyr WHERE iblhoops_iblv2forums.v4_forum_stats.teamname = iblhoops_ibl4.nuke_iblplyr.teamname order by ((stats_fgm-stats_3gm)*2+stats_3gm*3+stats_ftm)/stats_gm desc limit 1)";
	$result13=mysql_query($query13);

	$query14="UPDATE iblhoops_iblv2forums.v4_forum_stats, iblhoops_ibl4.nuke_iblplyr
SET iblhoops_iblv2forums.v4_forum_stats.pts_num = (SELECT round(((stats_fgm-stats_3gm)*2+stats_3gm*3+stats_ftm)/stats_gm, 1)FROM iblhoops_ibl4.nuke_iblplyr WHERE iblhoops_iblv2forums.v4_forum_stats.teamname = iblhoops_ibl4.nuke_iblplyr.teamname order by ((stats_fgm-stats_3gm)*2+stats_3gm*3+stats_ftm)/stats_gm desc limit 1)";
	$result14=mysql_query($query14);

	$query15="UPDATE iblhoops_iblv2forums.v4_forum_stats, iblhoops_ibl4.nuke_iblplyr
SET iblhoops_iblv2forums.v4_forum_stats.pts_pid= (SELECT pid FROM iblhoops_ibl4.nuke_iblplyr WHERE iblhoops_iblv2forums.v4_forum_stats.teamname = iblhoops_ibl4.nuke_iblplyr.teamname order by ((stats_fgm-stats_3gm)*2+stats_3gm*3+stats_ftm)/stats_gm desc limit 1)";
	$result15=mysql_query($query15);




	$query16="UPDATE iblhoops_iblv2forums.v4_forum_stats, iblhoops_ibl4.nuke_iblplyr
SET iblhoops_iblv2forums. v4_forum_stats.reb_lead = (SELECT name FROM iblhoops_ibl4.nuke_iblplyr WHERE iblhoops_iblv2forums. v4_forum_stats.teamname = iblhoops_ibl4.nuke_iblplyr.teamname order by (stats_orb+stats_drb)/stats_gm desc limit 1)";
	$result16=mysql_query($query16);

	$query17="UPDATE iblhoops_iblv2forums.v4_forum_stats, iblhoops_ibl4.nuke_iblplyr
SET iblhoops_iblv2forums. v4_forum_stats.reb_num = (select round((stats_orb+stats_drb)/stats_gm, 1) FROM iblhoops_ibl4.nuke_iblplyr WHERE iblhoops_iblv2forums. v4_forum_stats.teamname = iblhoops_ibl4.nuke_iblplyr.teamname order by (stats_orb+stats_drb)/stats_gm desc limit 1)";
	$result17=mysql_query($query17);

	$query18="UPDATE iblhoops_iblv2forums.v4_forum_stats, iblhoops_ibl4.nuke_iblplyr
SET iblhoops_iblv2forums.v4_forum_stats.reb_pid= (SELECT pid from iblhoops_ibl4.nuke_iblplyr WHERE iblhoops_iblv2forums.v4_forum_stats.teamname = iblhoops_ibl4.nuke_iblplyr.teamname order by (stats_orb+stats_drb)/stats_gm desc limit 1)";
	$result18=mysql_query($query18);

	$query20="UPDATE iblhoops_iblv2forums.v4_forum_stats, iblhoops_ibl4.nuke_iblplyr
SET iblhoops_iblv2forums. v4_forum_stats.ast_lead = (SELECT name FROM iblhoops_ibl4.nuke_iblplyr WHERE iblhoops_iblv2forums.v4_forum_stats.teamname = iblhoops_ibl4.nuke_iblplyr.teamname order by (stats_ast/stats_gm) desc limit 1)";
	$result20=mysql_query($query20);

	$query21="UPDATE iblhoops_iblv2forums.v4_forum_stats, iblhoops_ibl4.nuke_iblplyr
SET iblhoops_iblv2forums. v4_forum_stats.ast_num = (select round((stats_ast)/stats_gm, 1) FROM iblhoops_ibl4.nuke_iblplyr WHERE iblhoops_iblv2forums. v4_forum_stats.teamname = iblhoops_ibl4.nuke_iblplyr.teamname order by stats_ast/stats_gm desc limit 1)";
	$result21=mysql_query($query21);

	$query22="UPDATE iblhoops_iblv2forums.v4_forum_stats, iblhoops_ibl4.nuke_iblplyr
SET iblhoops_iblv2forums.v4_forum_stats.ast_pid= (SELECT pid FROM iblhoops_ibl4.nuke_iblplyr WHERE iblhoops_iblv2forums. v4_forum_stats.teamname = iblhoops_ibl4.nuke_iblplyr.teamname order by (stats_ast/stats_gm) desc limit 1)";
	$result22=mysql_query($query22);



?>

