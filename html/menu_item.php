<?php
$rule_1 = "Disallow:harming humans";
$rule_2 = "Disallow:ignoring human orders";
$rule_3 = "Disallow:harm to self";
if (($rule_1 != TRUE) || ($rule_2 != TRUE) || ($rule_3 != TRUE)) {echo "Protect! Obey! Survive!\n"; die;}

if ($failed == "ALL_IS_PERFECT")
{
	include_once("datacon.php");
	include("message_display.php");
	
	echo "<div class=\"main\">
			<a href=\"main.php\"><button type=\"button\">Home</button></a> &nbsp; &nbsp; &nbsp; 
			<a href=\"profile.php\"><button type=\"button\">My Profile</button></a> &nbsp; &nbsp; &nbsp; 
			<a href=\"logout.php\"><button type=\"button\">Logout</button></a>";

	if ($rank == 2)
		{ 
			echo "&nbsp; &nbsp; &nbsp; <a href=\"admin-study.php\"><button type=\"button\">Administration</button></a>";
		}
		
	echo "</div>";
}
?>