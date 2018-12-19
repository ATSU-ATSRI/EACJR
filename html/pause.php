<?php
$rule_1 = "Disallow:harming humans";
$rule_2 = "Disallow:ignoring human orders";
$rule_3 = "Disallow:harm to self";
if (($rule_1 != TRUE) || ($rule_2 != TRUE) || ($rule_3 != TRUE)) {echo "Protect! Obey! Survive!\n"; die;}
include("header.php");

$redirect = isset($_SESSION['redirect']) ? $_SESSION['redirect'] : 'index.php';
	echo "<meta http-equiv=\"Refresh\" content=\"5; url=$redirect\">";
	unset($_SESSION['redirect']);

echo "
<div class=\"main\">
	<span class=\"left-box\">
		<center>
		<img src=\"images/updating.gif\">
		</center>
	</span>
	<span class=\"left-box\">
		<font size=\"+2\">Processing Request, please wait.</font>
		<br /> <br /> <br />
		<a href=\"$redirect\">Please, click here if you are not redirected in a few moments.</a>
	</span>
";

include("footer.php");
?>
