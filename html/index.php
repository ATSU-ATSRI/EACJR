<?php
$rule_1 = "Disallow:harming humans";
$rule_2 = "Disallow:ignoring human orders";
$rule_3 = "Disallow:harm to self";
if (($rule_1 != TRUE) || ($rule_2 != TRUE) || ($rule_3 != TRUE)) {echo "Protect! Obey! Survive!\n"; die;}

require('datacon.php');

session_start();
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\" />
<html>
<head>
	<title>$mail_sig - EAC</title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
	<meta http-equiv=\"PRAGMA\" content=\"NO-CACHE\">
	<meta http-equiv=\"Expires\" content=\"Tue, 01 Jan 2000 00:00:00 GMT\">
	<meta http-equiv=\"Last-Modified\" content=\" " . gmdate("D, d M Y H:i:s") . " GMT\">
	<meta http-equiv=\"CACHE-CONTROL\" content=\"NO-CACHE\">
	<meta http-equiv=\"CACHE-CONTROL\" content=\"NO-STORE\">
	<meta http-equiv=\"CACHE-CONTROL\" content=\"MUST-REVALIDATE\">
	<meta http-equiv=\"CACHE-CONTROL\" content=\"MAX-AGE=0\">
	<meta http-equiv=\"CACHE-CONTROL\" content=\"POST-CHECK=0\">
	<meta http-equiv=\"CACHE-CONTROL\" content=\"PRE-CHECK=0\">
	<link rel=\"shortcut icon\ href=\"favicon.ico\">
	<link rel=\"stylesheet\" href=\"styles.css\">
	<script>
		document.getElementById(\"submitMe\").disabled = true;
		
		function enableBtn(){
			document.getElementById(\"submitMe\").disabled = false;
			};
		
		function disableBtn(){
			document.getElementById(\"submitMe\").disabled = true;
			};
	</script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<div class=\"base\">
<center>
<div class=\"main\">";


$failed = isset($_SESSION['failed']) ? $_SESSION['failed'] : '';
if (($failed !== "ALL_IS_PERFECT") && (strlen($failed) > 1))
	{
		echo "<div class =\"alert\">$failed</div>";
		unset($_SESSION['failed']);
	}
	
echo "
		<span class=\"left-box\">
			<form name=\"userlogin\" action=\"\" method=\"POST\">
				<div class=\"ft\">
					<div>User email address</div>
					<div><INPUT type=\"text\" name=\"user_id\" id=\"user_id\" size=\"30\" autofocus></div>
					<div>Password</div>
					<div><INPUT type=\"password\" name=\"password\" id=\"password\" size=\"30\"></div>
					<div>Please complete the reCAPTCHA</div>
					<div><span class=\"g-recaptcha\" data-sitekey=\"". $sitekey ."\" data-callback=\"enableBtn\" data-expired-callback=\"disableBtn\"></span></div>
				</div>
				<div class=\"ft-head\"><INPUT type=\"submit\" name=\"submitMe\" id=\"submitMe\" value=\"Login\" disabled=\"true\"></div>
			</form>
			<br />
			<br />
			<a href=\"selfpassreset.php\">Can't remember your password?</a><br />
		</span>
		
		<span class=\"left-box\">
				<img src=\"images/logo.jpg\" alt=\"Logo for $mail_sig\" width=\"307px\" height=\"141px\">
		</span>
";

if (isset($_POST['submitMe']))
	{
		$_SESSION['user_id'] = $_POST['user_id'];
		$_SESSION['password'] = $_POST['password'];
		$_SESSION['g-recaptcha-response'] = $_POST['g-recaptcha-response'];
		
		if ((strlen($_SESSION['user_id']) > 5) && (strlen($_SESSION['password']) > 5))
			{
				header('Location: login.php');
			}
			else
			{
				$_SESSION["failed"] = "User ID or Password Failure.";
				header('Location: index.php');
			}
	}

include('footer.php');
?>
