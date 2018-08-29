<?php
$rule_1 = "Disallow:harming humans";
$rule_2 = "Disallow:ignoring human orders";
$rule_3 = "Disallow:harm to self";
if (($rule_1 != TRUE) || ($rule_2 != TRUE) || ($rule_3 != TRUE)) {echo "Protect! Obey! Survive!\n"; die;}

include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include("datacon.php");
	include("menu_item.php");
	
	if (!($history_QUERY = $dblink->prepare("SELECT `name`, email, login, logout FROM jury_room.login_history INNER JOIN jury_room.logins ON jury_room.login_history.id = jury_room.logins.user_id ORDER BY jury_room.login_history.seq DESC"))) {logger(__LINE__, "SQLi Prepare: $history_QUERY->error");}
	if (!($history_QUERY->execute())) { logger(__LINE__, "SQLi execute: $history_QUERY->error"); }
	if (!($history_QUERY->bind_result($history_name, $history_email, $history_login, $history_logout))) {logger(__LINE__, "SQLi rBind: $history_QUERY->error");}
	$history_QUERY->store_result();
	
	echo "
		<div class=\"main\">
		
		<span class=\"left-col\">
			
					<a href=\"admin.php\"><button type=\"button\">View user list</button></a><br />
			<br />
			<a href=\"admin-new.php\"><button type=\"button\">Add a new user</button></a><br />
			<br />
			<a href=\"admin-history.php\"><button type=\"button\">View user history</button></a><br />		
			<br />
			<a href=\"admin-study.php\"><button type=\"button\">View study information</button></a><br /?
			<br />
			
		</span>
		
		<span class=\"right-col\">
		<center>
		<table border=\"1\">
			<thead>
			<tr>
				<th width=\"25%\">User name</th>
				<th width=\"25%\">User email</th>
				<th width=\"25%\">Login time</th>
				<th width=\"25%\">Logout time</th>
			</tr>
			</thead>
			<tbody>";

	if (($history_QUERY->num_rows) > 0)
		{
			while ($history_QUERY->fetch())
				{
								
					echo "<tr>
						<td width=\"25%\">$history_name</td> 
						<td width=\"25%\">$history_email</td> 
						<td width=\"25%\">$history_login</td> 
						<td width=\"25%\">$history_logout</td> 
					</tr>";
				}
		}
		else
		{
			echo "<tr><td colspan=\"4\" wudth=\"100%\"><center> --- No history to display --- </center></td></tr>";
		}
	
	echo "
		</tbody>
		</table>
		</center>
		</span>
	";

	$history_QUERY->close();
	$dblink->close();
	include("footer.php");
}
?>