<?php

include_once 'config.php';
mysql_connect($dbhost,$dbuname,$dbpass);
@mysql_select_db($dbname) or die( "Unable to select database");

$leagueFileName = mysql_result(mysql_query("SELECT value FROM nuke_ibl_settings WHERE name = 'League File Name'"),0);
$engFile = fopen("$leagueFileName.eng", "rb");
$engArray = array();

while (!feof($engFile)) {
    $line = fgets($engFile);
    if (!eregi('   ',$line)) {
	    preg_match("/(.*), (.*)/", $line, $tempArray);
	    $key = (string)$tempArray[1];
	    $value = (int)$tempArray[2];
    	$engArray[$key] = $value;
    }
}

if (eregi('engParser.php',$_SERVER['REQUEST_URI'])) var_dump($engArray);