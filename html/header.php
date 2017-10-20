<?php
include("commonfunctions.php");
session_start();

$failed = isset($_SESSION['failed']) ? $_SESSION['failed'] : '';

if ($failed == "ALL_IS_PERFECT")
	{
		$id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
		$rank = isset($_SESSION['rank']) ? $_SESSION['rank'] : '';

		echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\" />
		<html>
		<head>
			<title>DO-Touch.NET - EAC</title>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
			<meta http-equiv=\"PRAGMA\" content=\"NO-CACHE\">
			<meta http-equiv=\"Expires\" content=\"-1\">
			<meta http-equiv=\"CACHE-CONTROL\" content=\"NO-CACHE\">
			<meta http-equiv=\"CACHE-CONTROL\" content=\"NO-STORE\">
			<link rel=\"shortcut icon\ href=\"favicon.ico\">
			<link rel=\"stylesheet\" href=\"styles.css\">
		</head>
		<body>
		<div class=\"base\">
		<center>
		<div class=\"main\">
		";
	}
	else
	{
		echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\" />
		<html>
		<head>
			<title>DO-Touch.NET - EAC</title>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
			<meta http-equiv=\"PRAGMA\" content=\"NO-CACHE\">
			<meta http-equiv=\"Expires\" content=\"-1\">
			<meta http-equiv=\"CACHE-CONTROL\" content=\"NO-CACHE\">
			<meta http-equiv=\"CACHE-CONTROL\" content=\"NO-STORE\">
			<link rel=\"shortcut icon\ href=\"favicon.ico\">
			<link rel=\"stylesheet\" href=\"styles.css\">
			<meta http-equiv=\"Refresh\" content=\"5; url=index.php\">
		</head>
		<body>
		<div class=\"base\">
		<center>
		<div class=\"main\">
			<span class=\"left-box\">
				<img src=\"images/updating.gif\"> 
			</span>
			<span class=\"left-box\">
				<font size=\"+2\">Processing Request, please wait.</font>
			</span>
		";
		logger("ALERT: Crawler alert");
		include("footer.php"); 
	}

?>