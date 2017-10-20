<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include("datacon.php");
	include("menu_item.php");
	
	if (!($history_QUERY = $dblink->prepare("SELECT `name`, email, login, logout FROM jury_room.login_history INNER JOIN jury_room.logins ON jury_room.login_history.id = jury_room.logins.user_id ORDER BY jury_room.login_history.seq DESC"))) {logger("SQLi Prepare: $history_QUERY->error");}
	if (!($history_QUERY->execute())) { logger("SQLi execute: $history_QUERY->error"); }
	if (!($history_QUERY->bind_result($history_name, $history_email, $history_login, $history_logout))) {logger("SQLi rBind: $history_QUERY->error");}
	$history_QUERY->store_result();
	
	echo "
		<div class=\"main\">
		
		<span class=\"left-col\">
			
			<a href=\"admin-new.php\"><button type=\"button\">Add new user</button></a><br />
			<br />
			<a href=\"admin.php\"><button type=\"button\">View user list</button></a><br />
			<br />
			<a href=\"admin-message.php\"><button type=\"button\">View Admin Messages</button></a><br />
			<br />
			
		</span>
		
		<span class=\"right-col\">
		<center>
		<table border=\"1\">
			<tr>
				<th>User name</th>
				<th>User email</th>
				<th>Login time</th>
				<th>Logout time</th>
			</tr>";

	if (($history_QUERY->num_rows) > 0)
		{
			while ($history_QUERY->fetch())
				{
								
					echo "<tr>
						<td>$history_name</td> 
						<td>$history_email</td> 
						<td>$history_login</td> 
						<td>$history_logout</td> 
					</tr>";
				}
		}
		else
		{
			echo "<tr><td colspan=\"4\"><center> --- No history to display --- </center></td></tr>";
		}
	
	echo "
		</table>
		</center>
		</span>
	";

	$history_QUERY->close();
	$dblink->close();
	include("footer.php");
}
?>