<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include("datacon.php");
	include("menu_item.php");
	$study_id = $_REQUEST['act'];
	
		if (isset($_POST['remove']))
		{
			$rm_user_id = $_POST['rm_user_id'];
			$rm_user_study = $_POST['rm_user_study'];
			
			$rm_user_array = explode(",", $rm_user_study);
			if (isset($rm_user_study)) { unset($rm_user_study); }
			$rm_user_study = "";
			
			foreach ($rm_user_array as $rm_us)
				{
					if ($rm_us !== $study_id)
						{
							$rm_user_study .= $rm_us .",";
						}
				}
			if (strlen($rm_user_study) > 0)
				{
					$rm_user_study = substr($rm_user_study, 0, -1);
				}
				else
				{
					$rm_user_study = "NULL";
				}
			
			if (!($rm_user_QUERY = $dblink->prepare("UPDATE `logins` SET `study`=? WHERE `user_id`=?;"))) { logger(__LINE__, "SQLi Prepare Error: $dblink->error"); }
			if (!($rm_user_QUERY->bind_param('ss', $rm_user_study, $rm_user_id))) { logger(__LINE__, "SQLi pBind error: $rm_user_QUERY->error"); }
			if (!($rm_user_QUERY->execute())) { logger(__LINE__, "SQLi execute error: $rm_user_QUERY->error"); }
			$rm_user_QUERY->close();
			$dblink->close();
			$_SESSION['pass_fail'] = "Study Updated.";
			$_SESSION['redirect'] = 'admin-study-edit.php?act=' . $study_id;
			if (headers_sent()) 
				{
					echo "<meta http-equiv=\"Location\" content=\"pause.php\">";
				}
				else
				{
					header('Location: pause.php');
				}

		}

	if (isset($_POST['adduser']))
		{
			$add_user_id = $_POST['add_user_id'];
			$add_user_study = $_POST['add_user_study'];
			
			$add_user_array = explode(",", $add_user_study);
			if (isset($add_user_study)) { unset($add_user_study); }
			$add_user_study = "";
			foreach ($add_user_array as $add_us)
				{
					$add_user_study .= $add_us .",";
				}

				$add_user_study .= $study_id;
			
			if (!($add_user_QUERY = $dblink->prepare("UPDATE `logins` SET `study`=? WHERE `user_id`=?;"))) { logger(__LINE__, "SQLi Prepare Error: $dblink->error"); }
			if (!($add_user_QUERY->bind_param('ss', $add_user_study, $add_user_id))) {logger(__LINE__, "SQLi pBind error: $add_user_QUERY->error"); }
			if (!($add_user_QUERY->execute())) { logger(__LINE__, "SQLi execute error: $add_user_QUERY"); }
			$add_user_QUERY->close();
			$dblink->close();
			$_SESSION['pass_fail'] = "Study Updated.";
			$_SESSION['redirect'] = 'admin-study-edit.php?act=' . $study_id;
			header('Location: pause.php');
		}

	if (isset($_POST['update']))
		{
			if (isset($_POST['study_name']) && isset($_POST['study_location']) && isset($_POST['date_start']) && isset($_POST['date_end']) && isset($_POST['quorum']) && isset($_POST['pi_name']) && isset($_POST['pi_email']))
				{
					$study_name = $_POST['study_name'];
					$study_location = $_POST['study_location'];
					$date_start = $_POST['date_start'];
					$date_end = $_POST['date_end'];
					$quorum = $_POST['quorum'];
					$pi_name = $_POST['pi_name'];
					$pi_email = $_POST['pi_email'];
					
					if (!($update_QUERY = $dblink->prepare("UPDATE `studys` SET `name`=?,`date_start`=?,`date_end`=?,`pi_name`=?,`pi_email`=?,`location`=?,`quorum`=? WHERE (`study_id`=?);"))) { logger(__LINE__, "SQLi Prepare: $update_QUERY->error"); }
					if (!($update_QUERY->bind_param('ssssssss', $study_name, $date_start, $date_end, $pi_name, $pi_email, $study_location, $quorum, $study_id))) { logger(__LINE__, "SQLi Bind Error: $update_QUERY->error"); }
					if (!($update_QUERY->execute())) { logger(__LINE__, "SQLi execute: $update_QUERY->error"); }
					$update_QUERY->close();
					$dblink->close();
					$_SESSION['pass_fail'] = "Study Updated.";
					$_SESSION['redirect'] = 'admin-study-edit.php?act=' . $study_id;
					header('Location: pause.php');
				}
				else
				{
					$_SESSION['pass_fail'] = "Please complete the entire form.";
					$_SESSION['redirect'] = 'admin-study-edit.php?act=' . $study_id;
					header('Location: pause.php');
				}
		}

	
		if (!($study_QUERY = $dblink->prepare("SELECT name, location, date_start, date_end, pi_name, pi_email, quorum FROM `jury_room`.`studys` WHERE (study_id = ?);"))) {logger(__LINE__, "SQLi Prepare: $dblink->error");}
		if (!($study_QUERY->bind_param('s', $study_id))) {logger("SQLi pBind: $study_QUERY->error");}
		if (!($study_QUERY->execute())) { logger(__LINE__, "SQLi execute: $study_QUERY->error"); }
		if (!($study_QUERY->bind_result($study_name, $study_location, $date_start, $date_end, $pi_name, $pi_email, $quorum))) {logger(__LINE__, "SQLi rBind: $study_QUERY->error");}
		$study_QUERY->store_result();
		$study_QUERY->fetch();
	
	echo "
		<div class=\"main\">
		
			<span class=\"left-col\">
			
			<a href=\"admin-new.php\"><button type=\"button\">Add new user</button></a><br />
			<br />
			<a href=\"admin-history.php\"><button type=\"button\">View user history</button></a><br />		
			<br />
			<a href=\"admin.php\"><button type=\"button\">View user list</button></a><br />
			<br />
			<a href=\"admin-message.php\"><button type=\"button\">View Admin Messages</button></a><br />
			<br />
			<a href=\"admin-study.php\"><button type=\"button\">View study information</button></a><br /?
			<br />
			
		</span>
		
		<form name=\"editsurvey\" method=\"post\">
		<span class=\"right-col\">
		
			<div class=\"ft-head\">	Study Information </div>
				<div class=\"ft\">
					<div>Study Name?</div>
					<div><input type=\"text\" size=\"45\" name=\"study_name\" value=\"$study_name\"></div>
					<div>Study Location?</div>
					<div><input type=\"text\" size=\"75\" name=\"study_location\" value=\"$study_location\"></div>
					<div>Date to start voting? &nbsp; &nbsp; &nbsp; &nbsp; Format: YYYY-MM-DD</div>
					<div><input type=\"text\" size=\"10\" name=\"date_start\" value=\"$date_start\"></div>
					<div>Date to end voting? &nbsp; &nbsp; &nbsp; &nbsp; Format: YYYY-MM-DD</div>
					<div><input type=\"text\" size=\"10\" name=\"date_end\" value=\"$date_end\"></div>
					<div>Percentage of users voting to reach Quorum?</div>
					<div><input type=\"text\" size=\"45\" name=\"quorum\" value=\"$quorum\"> %</div>
					<div>PI's name?</div>
					<div><input type=\"text\" size=\"45\" name=\"pi_name\" value=\"$pi_name\"></div>
					<div>PI's email address?</div>
					<div><input type=\"text\" size=\"45\" name=\"pi_email\" value=\"$pi_email\"></div>
				</div>
			<div class=\"ft\"><input type=\"submit\" name=\"update\" value=\"Update Study\"></div>
		</form>
		</span>";
	mysqli_stmt_close($study_QUERY);
	
	echo "<span class=\"left-box\">
				<div class=\"ft-head\"> Users in this study </div>
				<div class=\"ft\">";
			
	if (!($logins_QUERY = $dblink->prepare("SELECT user_id, name, study FROM `logins` where FIND_IN_SET(?,study);"))) { logger(__LINE__, "SQLi Prepare: $logins_QUERY->error"); }
	if (!($logins_QUERY->bind_param('s', $study_id))) { logger(__LINE__, "SQLi rBind error: $logins_QUERY->error"); }
	if (!($logins_QUERY->execute())) { logger(__LINE__, "SQLi execute error: $logins_QUERY->error"); }	
	if (!($logins_QUERY->bind_result($logins_user_id, $logins_name, $logins_study))) { logger(__LINE__, "SQLi rBind error: $logins_QUERY->error"); }
	$logins_QUERY->store_result();
	
	
	if (($logins_QUERY->num_rows) > 0)
		{
			while ($logins_QUERY->fetch())
				{
					echo "	<div style=\"float:left;margin-top:5px;\"> 
								<form name=\"removeusers\" method=\"post\">
								$logins_name
								<input type=\"hidden\" name=\"rm_user_id\" value=\"$logins_user_id\">
								<input type=\"hidden\" name=\"rm_user_study\" value=\"$logins_study\">
								<input type=\"submit\" size=\"10\" name=\"remove\" value=\">>>\">
								</form>
							</div>";
				}
		}
		
	echo "	</div>
			<div class=\"ft-head\">&nbsp; </div>
			</span>";
	mysqli_stmt_close($logins_QUERY);

	echo "	<span class=\"right-box\">
			<div class=\"ft-head\"> Users not in this study </div>
			<div class=\"ft\">";
	
	if (!($logouts_QUERY = $dblink->prepare("SELECT user_id, name, study FROM `logins` where NOT FIND_IN_SET(?,study);"))) { logger(__LINE__, "SQLi Prepare: $logouts_QUERY->error"); }
	if (!($logouts_QUERY->bind_param('s', $study_id))) { logger(__LINE__, "SQLi rBind error: $logouts_QUERY->error"); }
	if (!($logouts_QUERY->execute())) { logger(__LINE__, "SQLi execute error: $logouts_QUERY->error"); }	
	if (!($logouts_QUERY->bind_result($logouts_user_id, $logouts_name, $logouts_study))) { logger(__LINE__, "SQLi rBind error: $logouts_QUERY->error"); }
	$logouts_QUERY->store_result();
	
	
	if (($logouts_QUERY->num_rows) > 0)
		{
			while ($logouts_QUERY->fetch())
				{
					echo "	<div style=\"float:left;margin-top:5px;\">
								<form name=\"addusers\" method=\"post\">
								<input type=\"hidden\" name=\"add_user_id\" value=\"$logouts_user_id\">
								<input type=\"hidden\" name=\"add_user_study\" value=\"$logouts_study\">
								<input type=\"submit\" size=\"10\" name=\"adduser\" value=\"<<<\">
							$logouts_name
								</form>
							</div>";
				}
		}
	echo " </div>
			<div class=\"ft-head\">&nbsp; </div>
			</span>";
	mysqli_stmt_close($logouts_QUERY);

	include("footer.php");
}
?>