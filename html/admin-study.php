<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include("menu_item.php");
	include_once("datacon.php");

		if (!($study_QUERY = $dblink->prepare("SELECT study_id, name, location, date_start, date_end, pi_name, pi_email, quorum FROM jury_room.studys;"))) {logger(__LINE__, "SQLi Prepare: $study_QUERY->error");}
		if (!($study_QUERY->execute())) { logger(__LINE__, "SQLi execute: $study_QUERY->error"); }
		if (!($study_QUERY->bind_result($study_id, $study_name, $study_location, $date_start, $date_end, $pi_name, $pi_email, $quorum))) {logger(__LINE__, "SQLi rBind: $study_QUERY->error");}
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
			<a href=\"admin-message.php\"><button type=\"button\">View Admin messages</button></a><br />
			<br />
						
		</span>
		
		<span class=\"right-col\">
		
		<table border=\"1\" width=\"100%\">
			<thead>
			<TR>
				<TH width=\"20%\"> Study Name </TH>
				<TH width=\"10%\"> Study location </TH>
				<TH width=\"10%\"> Voting starts on: </TH>
				<TH width=\"10%\"> Voting ends on: </TH>
				<TH width=\"8%\"> Study's quorum % </TH>
				<TH width=\"17%\"> PI Name </TH>
				<TH width=\"15%\"> PI Email </TH>
				<TH width=\"10%\"> </TH>
			</TR>	
			</thead>
			<tbody>
		<form name=\"display_study\" method=\"POST\">			
		";
		
		if (($study_QUERY->num_rows) > 0)	
			{
				while($study_QUERY->fetch())
					{
						echo "	<TR>
									<TD width=\"20%\">$study_name</TD>
									<TD width=\"10%\">$study_location</TD>
									<TD width=\"10%\">$date_start</TD>
									<TD width=\"10%\">$date_end</TD>
									<TD width=\"8%\">$quorum</TD>
									<TD width=\"17%\">$pi_name</TD>
									<TD width=\"15%\">$pi_email</TD>
									<TD width=\"10%\"> <a href=\"admin-study-edit.php?act=$study_id\"><button type=\"button\"> Edit Study </button></a></TD>
								</TR>";
					}
			}
			else
			{
				echo "<TR><TD colspan=\"3\" width=\100%\"><center> - - - - > No Study to display < - - - -</center></TD></TR>";
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