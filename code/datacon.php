<?php
$rule_1 = "Disallow:harming humans";
$rule_2 = "Disallow:ignoring human orders";
$rule_3 = "Disallow:harm to self";
if (($rule_1 != TRUE) || ($rule_2 != TRUE) || ($rule_3 != TRUE)) {echo "Protect! Obey! Survive!\n"; die;}

$MySqlHostName = "SQL HOST HERE";
$MySqlUserName = "SQL USER HERE";
$MySqlPassWord = "SQL PASSWORD HERE";
$MySqlDataBase = "jury_room";

mysqli_report(MYSQLI_REPORT_ERROR);

$dblink = new mysqli($MySqlHostName, $MySqlUserName, $MySqlPassWord, $MySqlDataBase);
if ($dblink->connect_errno)
	{
		logger(__LINE__, "---MySQLi Error" . mysqli_connect_error($dblink) ." ---");
	}

$mail_sig = "PORTAL NAME HERE FOR USE IN MAIL SIG AND SUBJECT LINES";
$mail_password = "EMAIL PASSWORD HERE";
$mail_username = "EMAIL@EMAIL";
$mail_host = "MAIL HOST GOES HERE";
$host_url = "URL FOR PORTAL GOES HERE";
$options = [ 'cost' => NUMBER GOES HERE ]; // used for hashing on PHP < 7.0
$secret = "reCAPTCHA SECRET CODE GOES HERE";
$sitekey = "reCAPTCHA SITE KEY GOES HERE";
?>
