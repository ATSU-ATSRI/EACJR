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
	
	if (!($look_QUERY = $dblink->prepare("SELECT user_id, email, pass_date, `name`, initials, rank.`desc` FROM jury_room.logins INNER JOIN jury_room.rank ON jury_room.logins.rank = jury_room.rank.rank_id WHERE rank > 0 ORDER BY name ASC;"))) {logger(__LINE__, "SQLi Prepare: $look_QUERY->error");}
	if (!($look_QUERY->execute())) { logger(__LINE__, "SQLi execute: $look_QUERY->error"); }
	if (!($look_QUERY->bind_result($look_id, $look_email, $look_pass_date, $look_name, $look_initials, $look_rank))) {logger(__LINE__, "SQLi rBind: $look_QUERY->error");}
	$look_QUERY->store_result();
	
	echo "
		<div class=\"main\">
		
		<span class=\"left-col\">
			
			<a href=\"admin-new.php\"><button type=\"button\">Add a new user</button></a><br />
			<br />
			<a href=\"admin-history.php\"><button type=\"button\">View user history</button></a><br />		
			<br />
			<a href=\"admin-message.php\"><button type=\"button\">View Admin messages</button></a><br />
			<br />
			<a href=\"admin-study.php\"><button type=\"button\">View study information</button></a><br /?
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
			<thead>
			<tr>
				<th width=\"19%\">Name</th>
				<th width=\"10%\">Initials</th>
				<th width=\"23%\">Email</th>
				<th width=\"16%\">Password last set</th>
				<th width=\"16%\">Access Level</th>
				<th width=\"16%\">&nbsp;</th>
			</tr>
			</thead>
			<tbody>";

	if (($look_QUERY->num_rows) > 0)
		{
			echo "	<tr>
					<td colspan=\"7\" width=\"100%\" style=\"background-color:cornsilk; text-align:center; vertical-align:middle;\">Active members</td>
					</tr>";
				
			while ($look_QUERY->fetch())
				{
					echo "<tr>
						<td width=\"19%\">$look_name</td>
						<td width=\"10%\">$look_initials</td>
						<td width=\"23%\">$look_email</td>
						<td width=\"16%\">$look_pass_date</td>
						<td width=\"16%\">$look_rank</td>
						<td width=\"16%\"><a href=\"admin-modify.php?ici=$look_id\"><button type=\"button\">Modify</button></td>
					</tr>";
				}
		}
		else
		{
			echo "<tr><td colspan=\"7\" width=\"100%\" style=\"background-color:cornsilk; text-align:center; vertical-align:middle;\"><center> --- No Users to display --- </center></td></tr>";
		}
		$look_QUERY->close();
		
		if (!($nolook_QUERY = $dblink->prepare("SELECT user_id, email, pass_date, `name`, initials, rank.`desc` FROM jury_room.logins INNER JOIN jury_room.rank ON jury_room.logins.rank = jury_room.rank.rank_id WHERE rank = 0 ORDER BY name ASC;"))) {logger(__LINE__, "SQLi Prepare: $nolook_QUERY->error");}
		if (!($nolook_QUERY->execute())) { logger(__LINE__, "SQLi execute: $nolook_QUERY->error"); }
		if (!($nolook_QUERY->bind_result($look_id, $look_email, $look_pass_date, $look_name, $look_initials, $look_rank))) {logger(__LINE__, "SQLi rBind: $nolook_QUERY->error");}
		$nolook_QUERY->store_result();
		if (($nolook_QUERY->num_rows) > 0)	
		{
			echo "
				<tr>
					<td colspan=\"7\" width=\"100%\" style=\"background-color:cornsilk; text-align:center; vertical-align:middle;\">Inactive members</td>
				</tr>";
						
			while ($nolook_QUERY->fetch())
				{
					echo "<tr>
						<td width=\"19%\">$look_name</td>
						<td width=\"10%\">$look_initials</td>
						<td width=\"23%\">$look_email</td>
						<td width=\"16%\">$look_pass_date</td>
						<td width=\"16%\">$look_rank</td>
						<td width=\"16%\"><a href=\"admin-modify.php?ici=$look_id\"><button type=\"button\">Modify</button></td>
					</tr>";
				}
		}
		$nolook_QUERY->close();
		
	echo "
		</tbody>
		</table>
		</center>
		</span>
	";
	
	$dblink->close();
	include("footer.php");
}
?>