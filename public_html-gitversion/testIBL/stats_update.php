<?php

//$username = "iblhoops_chibul";
//$password = "oliver23";
//$database = "iblhoops_ibl4";

//mysql_connect(localhost,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");


// Perform Query
//mysql_query("update iblhoops_iblv2forums.iblv2user a, iblhoops_ibl4.nuke_ibl_power b, iblhoops_iblv2forums.v4_forum_stats c set a.usertitle= CONCAT(a.usertitle2, " (",b.win,\-\,b.loss,")","<br><br><b>PPG:</b>","&nbsp; &nbsp;", \<a href ="http://iblhoops.net/testIBL/modules.php?name=Player&pa=showpage&pid=\, c.pts_pid,\">\,c.pts_lead,\</a>\, " (", c.pts_num, ")","<br><b>RPG:</b>","&nbsp; &nbsp;", \<a href ="http://iblhoops.net/testIBL/modules.php?name=Player&pa=showpage&pid=\, c.reb_pid,\">\,c.reb_lead,\</a>\, " (", c.reb_num, ")","<br><b>APG:</b>","&nbsp; &nbsp;",\<a href ="http://iblhoops.net/testIBL/modules.php?name=Player&pa=showpage&pid=\, c.ast_pid,\">\,c.ast_lead,\</a>\, " (", c.ast_num, ")<br>") where a.teamname = b.Team and c.teamname = a.teamname");
           
$test = array(
            'a' => "Lorem Ipsum",
            'b' => "ipsum u (",b.win,'-',b.loss,")
);
print_r($test);


?>