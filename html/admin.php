<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include("datacon.php");
	include("menu_item.php");
	
	if (!($look_QUERY = $dblink->prepare("SELECT user_id, email, pass_date, `name`, initials, rank.`desc` FROM jury_room.logins INNER JOIN jury_room.rank ON jury_room.logins.rank = jury_room.rank.rank_id WHERE rank > 0 ORDER BY name DESC;"))) {logger("SQLi Prepare: $look_QUERY->error");}
	if (!($look_QUERY->execute())) { logger("SQLi execute: $look_QUERY->error"); }
	if (!($look_QUERY->bind_result($look_id, $look_email, $look_pass_date, $look_name, $look_initials, $look_rank))) {logger("SQLi rBind: $look_QUERY->error");}
	$look_QUERY->store_result();
	
	echo "
		<div class=\"main\">
		
		<span class=\"left-col\">
			
			<a href=\"admin-new.php\"><button type=\"button\">Add new user</button></a><br />
			<br />
			<a href=\"admin-history.php\"><button type=\"button\">View user history</button></a><br />		
			<br />
			<a href=\"admin-message.php\"><button type=\"button\">View Admin Messages</button></a><br />
			<br />
			
		</span>
		
		<span class=\"right-col\">";
		
		if (isset($_SESSION['pass_fail']))
			{
				echo "<span class=\"alert\">". $_SESSION['pass_fail'] ." </span>";
				unset($_SESSION['pass_fail']);
			}
			
		echo "
		<center>
		<table border=\"1\" width=\"100%\">
			<tr>
				<th colspan=\"7\">Active members</th>
			</tr><tr>
				<th>Name</th>
				<th>Initials</th>
				<th>Email</th>
				<th>Password last set</th>
				<th>Access Level</th>
				<th>&nbsp;</th>
			</tr>";

	if (($look_QUERY->num_rows) > 0)
		{
			while ($look_QUERY->fetch())
				{
					echo "<tr>
						<td>$look_name</td>
						<td>$look_initials</td>
						<td>$look_email</td>
						<td>$look_pass_date</td>
						<td>$look_rank</td>
						<td><a href=\"admin-modify.php?ici=$look_id\"><button type=\"button\">Modify</button></td>
					</tr>";
				}
		}
		else
		{
			echo "<tr><td colspan=\"7\"><center> --- No Users to display --- </center></td></tr>";
		}
		$look_QUERY->close();
		
		if (!($nolook_QUERY = $dblink->prepare("SELECT user_id, email, pass_date, `name`, initials, rank.`desc` FROM jury_room.logins INNER JOIN jury_room.rank ON jury_room.logins.rank = jury_room.rank.rank_id WHERE rank = 0 ORDER BY name DESC;"))) {logger("SQLi Prepare: $nolook_QUERY->error");}
		if (!($nolook_QUERY->execute())) { logger("SQLi execute: $nolook_QUERY->error"); }
		if (!($nolook_QUERY->bind_result($look_id, $look_email, $look_pass_date, $look_name, $look_initials, $look_rank))) {logger("SQLi rBind: $nolook_QUERY->error");}
		$nolook_QUERY->store_result();
		if (($nolook_QUERY->num_rows) > 0)	
		{
			echo "
				<tr>
					<th colspan=\"7\">Inactive members</th>
				</tr>";
						
			while ($nolook_QUERY->fetch())
				{
					echo "<tr>
						<td>$look_name</td>
						<td>$look_initials</td>
						<td>$look_email</td>
						<td>$look_pass_date</td>
						<td>$look_rank</td>
						<td><a href=\"admin-modify.php?ici=$look_id\"><button type=\"button\">Modify</button></td>
					</tr>";
				}
		}
		$nolook_QUERY->close();
		
	echo "
		</table>
		</center>
		</span>
	";
	
	$dblink->close();
	include("footer.php");
}
?>