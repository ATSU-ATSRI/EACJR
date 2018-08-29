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

	echo "
		<div class=\"main\">";
		
		if (isset($_SESSION['pass_fail']))
			{
				echo "<span class=\"alert\">". $_SESSION['pass_fail'] ." </span>";
				unset($_SESSION['pass_fail']);
			}
		
	echo "	<span class=\"left-col\">
			
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
		
		<form name=\"editstudy\" method=\"post\">
		<table border=\"0\" width=\"100%\">
			<thead>
			<TR><TH width=\"100%\"> New Study Information </TH></TR>
			</thead>
			<tbody>
				<TR>
					<TH width=\"30%\">Study Name?</TH>
					<TD width=\"70%\"><input type=\"text\" size=\"45\" name=\"study_name\" value=\"\"></TD>
				</TR>
				<TR>
					<TH width=\"30%\">Study Location?</TH>
					<TD width=\"70%\"><input type=\"text\" size=\"75\" name=\"study_location\" value=\"\"></TD>
				</TR>
				<TR>
					<TH width=\"30%\">Date to start voting?<br />Format: YYYY-MM-DD</TH>
					<TD width=\"70%\"><input type=\"text\" size=\"10\" name=\"date_start\" value=\"\"></TD>
				</TR>
				<TR>
					<TH width=\"30%\">Date to end voting?<br>Format: YYYY-MM-DD</TH>
					<TD width=\"70%\"><input type=\"text\" size=\"10\" name=\"date_end\" value=\"\"></TD>
				</TR>
				<TR>
					<TH width=\"30%\">Percentage of users voting to reach a quorum?</TH>
					<TD width=\"70%\"><input type=\"text\" size=\"45\" name=\"quorum\" value=\"\"> %</TD>
				</TR>
				<TR>
					<TH width=\"30%\">Percentage of users voting to reach consensus?</TH>
					<TD width=\"70%\"><input type=\"text\" size=\"45\" name=\"consensus\" value=\"\"> %</TD>
				</TR>
				<TR>
					<TH width=\"30%\">PI's name?</TH>
					<TD width=\"70%\"><input type=\"text\" size=\"45\" name=\"pi_name\" value=\"\"></TD>
				</TR>
				<TR>
					<TH width=\"30%\">PI's email address?</TH>
					<TD width=\"70%\"><input type=\"text\" size=\"45\" name=\"pi_email\" value=\"\"></TD>
				</TR>
			</tbody>
		</table>
	<input type=\"submit\" name=\"submit\" value=\"Save Study\">
	</form>
	</span>";
	
	if (isset($_POST['submit']))
		{
			if (isset($_POST['study_name']) && isset($_POST['study_location']) && isset($_POST['date_start']) && isset($_POST['date_end']) && isset($_POST['quorum']) && isset($_POST['consensus']) && isset($_POST['pi_name']) && isset($_POST['pi_email']))
				{
					$study_name = $_POST['study_name'];
					$study_location = $_POST['study_location'];
					$date_start = $_POST['date_start'];
					$date_end = $_POST['date_end'];
					$quorum = $_POST['quorum'];
					$consensus = $_POST['consensus'];
					$pi_name = $_POST['pi_name'];
					$pi_email = $_POST['pi_email'];
					
					if (!($insert_QUERY = $dblink->prepare("INSERT INTO jury_room.studys (name, location, date_start, date_end, quorum, consensus, pi_name, pi_email) VALUES(?, ?, ?, ?, ?, ?, ?, ?);"))) {logger(__LINE__, "SQLi Prepare: $dblink->error");}
					if (!($insert_QUERY->bind_param('ssssssss', $study_name, $study_location, $date_start, $date_end, $quorum, $consensus, $pi_name, $pi_email))) { logger(__LINE__, "SQLi Bind Error: $insert_QUERY->error"); }
					if (!($insert_QUERY->execute())) { logger(__LINE__, "SQLi execute: $insert_QUERY->error"); }
					$insert_QUERY->close();
					$dblink->close();
					$_SESSION['pass_fail'] = "Study Added.";
					$_SESSION['redirect'] = "admin-study.php";
					header('Location: pause.php');
				}
				else
				{
					$_SESSION['pass_fail'] = "Please complete the entire form";
					header('Location: admin-study-insert.php');
				}
		}
	
	include("footer.php");
}
?>