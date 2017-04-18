<?php

include_once 'config.php';
mysql_connect($dbhost,$dbuname,$dbpass);
@mysql_select_db($dbname) or die( "Unable to select database");

$stringCurrentSimYear = "SELECT value FROM nuke_ibl_settings WHERE name = 'Current IBL Season';";
$queryCurrentSimYear = mysql_query($stringCurrentSimYear);

$scoFile = fopen("IBLv4.sco", "rb");
fseek($scoFile,1030000);

if (mysql_query('TRUNCATE TABLE IBL_Box_Scores')) echo 'TRUNCATE TABLE IBL_Box_Scores<p>';

while (!feof($scoFile)) {
    $CurrentSimYear = mysql_result($queryCurrentSimYear, 0);
    $line = fgets($scoFile,2001);

    $gameMonth = sprintf("%02u",substr($line,0,2)+10); // sprintf() prepends 0 if the result isn't in double-digits
    if ($gameMonth > 12 AND $gameMonth != 22) $gameMonth = sprintf("%02u",$gameMonth-12); // if $gameMonth === 22, it's the Playoffs
    if ($gameMonth == 22) $gameMonth = sprintf("%02u",$gameMonth-17); // TODO: not have to hack the Playoffs to be in May
    if ($gameMonth > 10) $CurrentSimYear = --$CurrentSimYear;
    $gameDay = sprintf("%02u",substr($line,2,2)+1);
    $gameOfThatDay = substr($line,4,2)+1;
    $visitorTID = substr($line,6,2)+1;
    $homeTID = substr($line,8,2)+1;
    $visitorQ1pts = substr($line,28,3);
    $visitorQ2pts = substr($line,31,3);
    $visitorQ3pts = substr($line,34,3);
    $visitorQ4pts = substr($line,37,3);
    $visitorOTpts = substr($line,40,3);
    $homeQ1pts = substr($line,43,3);
    $homeQ2pts = substr($line,46,3);
    $homeQ3pts = substr($line,49,3);
    $homeQ4pts = substr($line,52,3);
    $homeOTpts = substr($line,55,3);

    $date = $CurrentSimYear.'-'.$gameMonth.'-'.$gameDay;

    for ($i = 0; $i < 30; $i++) {
        $x = $i*53; // 53 = amount of characters to skip to get to the next player's/team's data line

        $name = trim(substr($line,58+$x,16));
        $pos = trim(substr($line,74+$x,2));
        $pid = trim(substr($line,76+$x,6));
        $gameMIN = substr($line,82+$x,2);
        $game2GM = substr($line,84+$x,2);
        $game2GA = substr($line,86+$x,3);
        $gameFTM = substr($line,89+$x,2);
        $gameFTA = substr($line,91+$x,2);
        $game3GM = substr($line,93+$x,2);
        $game3GA = substr($line,95+$x,2);
        $gameORB = substr($line,97+$x,2);
        $gameDRB = substr($line,99+$x,2);
        $gameAST = substr($line,101+$x,2);
        $gameSTL = substr($line,103+$x,2);
        $gameTOV = substr($line,105+$x,2);
        $gameBLK = substr($line,107+$x,2);
        $gamePF = substr($line,109+$x,2);

        $entryUpdateQuery = "INSERT INTO IBL_Box_Scores (Date,name,pos,pid,visitorTID,homeTID,gameMIN,game2GM,game2GA,gameFTM,gameFTA,game3GM,game3GA,gameORB,gameDRB,gameAST,gameSTL,gameTOV,gameBLK,gamePF)
            VALUES ('$date','$name','$pos',$pid,$visitorTID,$homeTID,$gameMIN,$game2GM,$game2GA,$gameFTM,$gameFTA,$game3GM,$game3GA,$gameORB,$gameDRB,$gameAST,$gameSTL,$gameTOV,$gameBLK,$gamePF)";
        if ($name != NULL || $name != '') {
            if (mysql_query($entryUpdateQuery)) {
                echo $entryUpdateQuery.'<br>';
            }
        }
    }
}

$newChunkEndDate = mysql_result(mysql_query('SELECT Date FROM IBL_Box_Scores ORDER BY Date DESC LIMIT 1'),0);
$lastChunkStartDate = mysql_result(mysql_query("SELECT value FROM nuke_ibl_settings WHERE name='Chunk Start Date' LIMIT 1;"),0);
$lastChunkEndDate = mysql_result(mysql_query("SELECT value FROM nuke_ibl_settings WHERE name='Chunk End Date' LIMIT 1;"),0);

if ($lastChunkEndDate != $newChunkEndDate) {
    $dtObjNewChunkEndDate = date_create($lastChunkEndDate);
    date_modify($dtObjNewChunkEndDate,'+1 day');
    $newChunkStartDate = date_format($dtObjNewChunkEndDate,'Y-m-d');

    $setNewChunkStartDate = mysql_query("UPDATE nuke_ibl_settings SET value='$newChunkStartDate' WHERE name='Chunk Start Date';");
    $setNewChunkEndDate = mysql_query("UPDATE nuke_ibl_settings SET value='$newChunkEndDate' WHERE name='Chunk End Date';");

    if ($setNewChunkEndDate AND $setNewChunkStartDate) {
        echo "<p>Added box scores from $newChunkStartDate through $newChunkEndDate.";
    } else die('Invalid query: '.mysql_error());
} else echo "<p>Looks like new box scores haven't been added.<br>Chunk Start/End Dates will stay set to $lastChunkStartDate and $lastChunkEndDate.";

?>