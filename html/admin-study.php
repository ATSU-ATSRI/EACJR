<?php
$rule_1 = "Disallow:harming humans";
$rule_2 = "Disallow:ignoring human orders";
$rule_3 = "Disallow:harm to self";
if (($rule_1 != TRUE) || ($rule_2 != TRUE) || ($rule_3 != TRUE)) {echo "Protect! Obey! Survive!\n"; die;}

include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include("menu_item.php");
	include_once("datacon.php");

		if (!($study_QUERY = $dblink->prepare("SELECT study_id, name, location, date_start, date_end, pi_name, pi_email, quorum, consensus FROM jury_room.studys;"))) {logger(__LINE__, "SQLi Prepare: $dblink->error");}
		if (!($study_QUERY->execute())) { logger(__LINE__, "SQLi execute: $study_QUERY->error"); }
		if (!($study_QUERY->bind_result($study_id, $study_name, $study_location, $date_start, $date_end, $pi_name, $pi_email, $quorum, $consensus))) {logger(__LINE__, "SQLi rBind: $study_QUERY->error");}
		$study_QUERY->store_result();
		
	
	echo "
		<div class=\"main\">";
		
		if (isset($_SESSION['pass_fail']))
			{
				echo "<span class=\"alert\">". $_SESSION['pass_fail'] ." </span>";
				unset($_SESSION['pass_fail']);
			}
		
	echo "
			<span class=\"left-col\">
			
			<a href=\"admin.php\"><button type=\"button\">View user list</button></a><br />
			<br />
			<a href=\"admin-new.php\"><button type=\"button\">Add a new user</button></a><br />
			<br />
			<a href=\"admin-history.php\"><button type=\"button\">View user history</button></a><br />		
			<br />
			<a href=\"admin-message.php\"><button type=\"button\">View admin messages</button></a><br />
			<br />
						
		</span>
		
		<span class=\"right-col\">
		
		<table padding=\"0.1em\" border=\"1px\">
			<thead>
				<th width=\"16%\">Study Name</th>
				<th width=\"8%\">Study location</th>
				<th width=\"9%\">Voting starts</th>
				<th width=\"9%\">Voting ends</th>
				<th width=\"7%\">Study's quorum</th>
				<th width=\"7%\">Study's consensus</th>
				<th width=\"14%\">PI Name</th>
				<th width=\"14%\">PI Email</th>
				<th width=\"8%\">&nbsp;</th>
				<th width=\"8%\">&nbsp;</th>
			</thead>
			<tbody>
		<form name=\"display_study\" method=\"POST\">			
		";
		
		if (($study_QUERY->num_rows) > 0)	
			{
				while($study_QUERY->fetch())
					{
						echo "		<tr>
										<td width=\"16%\">$study_name</td>
										<td width=\"8%\">$study_location</td>
										<td width=\"9%\">$date_start</td>
										<td width=\"9%\">$date_end</td>
										<td width=\"7%\">$quorum %</td>
										<td width=\"7%\">$consensus %</td>
										<td width=\"14%\">$pi_name</td>
										<td width=\"14%\">$pi_email</td>
										<td width=\"8%\"> <a href=\"admin-study-edit.php?act=$study_id\"><button type=\"button\"> Edit Study </button></a></td>
										<td width=\"8%\"> <a href=\"admin-study-status.php?act=$study_id\"><button type=\"button\"> View Status </button></a></td>
									</tr>
									";
					}
			}
			else
			{
				echo "<tr><td colspan=\"9\"><center> - - - - > No Study to display < - - - -</center></td></tr>";
			}
	
echo "	</form>
				</tbody>
			</table>
		<br />
		
		<a href=\"admin-study-insert.php\"><button type=\"button\"> New Study </button></a><br />
	</span>";
	$study_QUERY->close();
	
	include("footer.php");
}
?>