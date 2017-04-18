<?php

//This file automates the following steps from Gates' simming instructions:
//#8.) From the IBL HTML, open "Schedule.htm" IN INTERNET EXPLORER. Select the entire content of this page and copy it. Then paste into A1 of the "Schedule" tab.
//#9.) In the Schedule tab, copy Column Q and paste into the database and run it.

$username = "iblhoops_chibul";
$password = "oliver23";
$database = "iblhoops_iblleague";

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$scheduleFilePath = 'ibl/IBL/Schedule.htm';

$schedule = new DOMDocument();
$schedule->loadHTMLFile($scheduleFilePath);
$schedule->preserveWhiteSpace = false;

$rows = $schedule->getElementsByTagName('tr');

function stripLeadingZeros($var) {
	$var = ltrim($var,'0');
	return $var;
}

function stripTrailingSpaces($var) {
	$var = rtrim($var,' ');
	return $var;
}

function dateExtract($rawDate) {
	if ($rawDate != FALSE) {
		global $rows;
	
		$month = stripLeadingZeros(date('m', strtotime($rawDate)));
		$day = stripLeadingZeros(date('d', strtotime($rawDate)));
		$year = date('Y', strtotime($rawDate));
		$date = $year."-".$month."-".$day;
		
		$dateArray = array(
			"date" => $date,
			"year" => $year,
			"month" => $month,
			"day" => $day);
		return $dateArray;
	}
}

function boxIDextract($boxHREF) {
	$boxID = ltrim(rtrim($boxHREF,'.htm'),'box');
	return $boxID;
}

echo 'Updating IBL_Schedule database table...'
mysql_query('TRUNCATE TABLE IBL_Schedule');

foreach ($rows as $row) {
	$checkSecondCell = $row->childNodes->item(1)->nodeValue;
	$checkFirstCell = $row->childNodes->item(0)->nodeValue;

	// Check if $row is a date to be parsed.
	if ($checkSecondCell === NULL AND substr($checkFirstCell,0,4) !== "Post") {
		$fullDate = dateExtract($row->textContent);
		$date = $fullDate['date'];
		$year = $fullDate['year'];
	}

	// Check if $row is a game to be parsed.
	if ($row->childNodes->item(2)->nodeValue !== NULL AND $row->childNodes->item(0)->nodeValue !== "visitor" AND $row->childNodes->item(2)->nodeValue !== "") {

		// Check if $row has a box score link to be parsed, and only parse it if it does.
		if ($row->childNodes->item(1)->getElementsByTagName('a')->length !== 0) {
			$boxLink = $row->childNodes->item(1)->getElementsByTagName('a')->item(0)->getAttribute('href');
			$boxID = boxIDextract($boxLink);
		}

		// Parse game info.
		$visitorName = stripTrailingSpaces($row->childNodes->item(0)->textContent);
		$vScore = $row->childNodes->item(1)->textContent;
		$homeName = stripTrailingSpaces($row->childNodes->item(2)->textContent);
		$hScore = $row->childNodes->item(3)->textContent;

		// Prevent NULL values from being sent to the DB.
		// Also gives unplayed games fake and unique BoxIDs so their games still appear.
		if ($row->childNodes->item(1)->nodeValue === NULL OR $row->childNodes->item(1)->nodeValue === "") {
			$vScore = 0;
			$hScore = 0;
			if ($boxID > 99999 OR $boxID === NULL) {
				$boxID = $boxID + 1;
			} else $boxID = 100000;
		}

		// Looks up a team's ID#.
		$visitorTID = mysql_result(mysql_query("SELECT teamid FROM ibl_team_history WHERE team_name = '".$visitorName."';"),0);
		$homeTID = mysql_result(mysql_query("SELECT teamid FROM ibl_team_history WHERE team_name = '".$homeName."';"),0);
	}

	$sqlQueryString = "INSERT INTO IBL_Schedule (Year,BoxID,Date,Visitor,Vscore,Home,Hscore)
		VALUES (".$year.",".$boxID.",'".$date."','".$visitorTID."',".$vScore.",'".$homeTID."',".$hScore.")
		
		ON DUPLICATE KEY UPDATE
		Year = ".$year.",
		Date = '".$date."',
		Visitor = '".$visitorTID."',
		Vscore = ".$vScore.",
		Home = '".$homeTID."',
		Hscore = ".$hScore."
	";

	$rowUpdate = mysql_query($sqlQueryString);
	if (!$sqlQueryString) {
		die('Invalid query: ' . mysql_error());
	}

	unset($boxLink);
	unset($visitorName);
	unset($vScore);
	unset($homeName);
	unset($hScore);
	unset($visitorTID);
	unset($homeTID);
	unset($boxLink);
}

// TODO:
// Standings variables to derive from Schedule: last 10, streak
// New variables: Magic #, rival conf w/l, >.500 w/l, <.500 w/l

echo 'OK';

?>ok