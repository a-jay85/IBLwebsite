<?php

include_once 'config.php';
mysql_connect($dbhost,$dbuname,$dbpass);
@mysql_select_db($dbname) or die( "Unable to select database");

$stringCurrentSimYear = "SELECT value FROM nuke_ibl_settings WHERE name = 'Current IBL Season';";
$queryCurrentSimYear = mysql_query($stringCurrentSimYear);

$trnFile = fopen("IBLv4.trn", "rb");
$seasonDaysElapsed = fgets($trnFile,18);

while (!feof($trnFile)) {
    $CurrentSimYear = mysql_result($queryCurrentSimYear, 0);
    $line = fgets($trnFile,129);

    $gameMonth = sprintf("%02u",substr($line,0,2));
    if ($gameMonth == 0) break;
    $gameDay = sprintf("%02u",substr($line,2,2));
    $gameYear = substr($line,4,4);
    $transactionType = substr($line,8,2);

    switch ($transactionType) {

    	case 1: //injury
    		$pid = substr($line,10,6);
    		$tid = substr($line,16,2);
    		$daysInjured = substr($line,18,4);
    		$injuryDetails = substr($line,22,32);
    		break;

    	case 2: //trade
    		$tradeType = substr($line,10,1);
    		switch ($tradeType) {

    			case 0: //player
    				$tidGiver = substr($line,11,6);
    				$tidReceiver = substr($line,17,6);
    				$pid = substr($line,23,6);
    				break;

    			case 1: //draft pick
    				$pickYear = substr($line,11,6);
    				$pickRound = substr($line,17,6);
    				$pickTeam = substr($line,23,6);
    				break;
    		}
    		break;

    	case 3: //sign
    		$tid = substr($line,10,2);
    		$pid = substr($line,12,6);
    		break;

    	case 4: //waive
    		$tid = substr($line,10,2);
    		$pid = substr($line,12,6);
    		break;
    }
}

echo '<br>end tnrParser script.';