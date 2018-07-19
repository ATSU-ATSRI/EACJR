<?php
include("datacon.php");
include("header.php");

if (!($login_QUERY = $dblink->prepare("UPDATE login_history as t1, (SELECT max(seq) FROM login_history WHERE id=?) as t2 SET t1.logout=NOW() WHERE (t1.id=?) AND (t1.seq=t2.`max(seq)`)"))) {logger(__LINE__, "SQLi Prepare: $login_QUERY->error");}
if (!($login_QUERY->bind_param('ss', $id, $id))) {logger(__LINE__, "SQLi Bind Error: $login_QUERY->error");}
if (!($login_QUERY->execute())) {logger(__LINE__, "SQLi execute: $login_QUERY->error");}
$login_QUERY->close();
$dblink->close();

session_unset(); 
session_destroy(); 
echo "<meta http-equiv=\"Refresh\" content=\"5; url='index.php'\">";
	
echo "
<div class=\"main\">
	<span class=\"left-box\">
		<center>
		<img src=\"images/updating.gif\"> 
		</center>
	</span>
	<span class=\"left-box\">
		<font size=\"+2\">Goodbye.</font>
	</span>
";


include("footer.php");
?>