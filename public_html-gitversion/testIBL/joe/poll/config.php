<?
$user = "iblhoops_chibul";
$password = "oliver23";
$database = "iblhoops_ibl4";
$host = "localhost";
mysql_connect($host, $user, $password) or die ("I cannot connect to the database server because: ".mysql_error());
mysql_select_db($database) or die ("I cannot connect to the database because: ".mysql_error());
?>