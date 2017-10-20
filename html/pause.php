<?php
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
	</span>
";

include("footer.php");
?>