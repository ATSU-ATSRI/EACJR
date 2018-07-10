<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include("datacon.php");
	include("menu_item.php");
	$study_id = $_REQUEST['act'];
	
		if (!($study_QUERY = $dblink->prepare("SELECT name, location, date_start, date_end, pi_name, pi_email, quorum FROM `jury_room`.`studys` WHERE (study_id = ?);"))) {logger(__LINE__, "SQLi Prepare: $dblink->error");}
		if (!($study_QUERY->bind_param('s', $study_id))) {logger("SQLi pBind: $study_QUERY->error");}
		if (!($study_QUERY->execute())) { logger(__LINE__, "SQLi execute: $study_QUERY->error"); }
		if (!($study_QUERY->bind_result($study_name, $study_location, $date_start, $date_end, $pi_name, $pi_email, $quorum))) {logger(__LINE__, "SQLi rBind: $study_QUERY->error");}
		$study_QUERY->store_result();
		$study_QUERY->fetch();
	
	echo "
		<div class=\"main\">";
		
		if (isset($_SESSION['pass_fail']))
			{
				echo "<div class=\"alert\">". $_SESSION['pass_fail'] ." </div>";
				unset($_SESSION['pass_fail']);
			}
		
	echo "	<span class=\"left-col\">
			
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
		
				<span class=\"right-col\">
		
			<div class=\"ft-head\">	Study Information </div>
				<div class=\"ft\">
					<div>Study Name?</div>
					<div>$study_name</div>
					<div>Study Location?</div>
					<div>$study_location</div>
					<div>Date to start voting? &nbsp; &nbsp; &nbsp; &nbsp; Format: YYYY-MM-DD</div>
					<div>$date_start</div>
					<div>Date to end voting? &nbsp; &nbsp; &nbsp; &nbsp; Format: YYYY-MM-DD</div>
					<div>$date_end</div>
					<div>Percentage of users voting to reach Quorum?</div>
					<div>$quorum %</div>
					<div>PI's name?</div>
					<div>$pi_name</div>
					<div>PI's email address?</div>
					<div>$pi_email</div>
				</div>
			<div class=\"ft\"></div>
		";
	mysqli_stmt_close($study_QUERY);
	
	echo "<span class=\"left-box\">
				<div class=\"ft-head\">Count of patient records by phase</div>
					<div class=\"mt\">
						<div class=\"mt-header\">
							<div class=\"mt-head\">Phase Number </div>
							<div class=\"mt-head\"> Number of records </div>
						</div>
						<div class=\"mt-body\">
						";
			
	if (!($phase_QUERY = $dblink->prepare("SELECT COUNT(*), `phase` FROM `patient` WHERE (`study_id` = ?) GROUP BY `phase`;"))) { logger(__LINE__, "SQLi Prepare: ". $phase_QUERY->error ." "); }
	if (!($phase_QUERY->bind_param('s', $study_id))) { logger(__LINE__, "SQLi rBind error: $phase_QUERY->error"); }
	if (!($phase_QUERY->execute())) { logger(__LINE__, "SQLi execute error: $phase_QUERY->error"); }	
	if (!($phase_QUERY->bind_result($phase_count, $phase_phaseno))) { logger(__LINE__, "SQLi rBind error: $phase_QUERY->error"); }
	$phase_QUERY->store_result();
	
	if (($phase_QUERY->num_rows) > 0)
		{
			while ($phase_QUERY->fetch())
				{
					echo "	<div class=\"mt-row\">
								<div class=\"mt-cell\">$phase_phaseno</div>
								<div class=\"mt-cell\">$phase_count </div>
							</div>
						";
				}
		}
		else
		{
			echo "   <div class=\"mt-row\"> No records to display </div>";
		}
		
	echo "		</div>
			</div>
			</span>";
	mysqli_stmt_close($phase_QUERY);

	echo "	<span class=\"right-box\">
			<div class=\"ft-head\"> Active Users </div>
			<div class=\"mt\">
				<div class=\"mt-header\">
					<div class=\"mt-head\">Name</div>
					<div class=\"mt-head\">Last login</div>
					<div class=\"mt-head\">Records reviewed</div>
					<div class=\"mt-head\">Avg time/record (h:m.s)</div>
				</div>
				<div class=\"mt-body\">
				";
	
	if (!($active_QUERY = $dblink->prepare("SELECT `review`.`user_id` AS 'kid', `logins`.`name`, MAX(`login_history`.`login`) AS 'last_seen', (SELECT COUNT(*) FROM `review` INNER JOIN `symptom` ON `review`.`event_id` = `symptom`.`event_id` INNER JOIN `patient` ON `symptom`.`code` = `patient`.`code` WHERE (`patient`.`study_id` = ?) AND (`review`.`user_id` = kid)) AS 'pt.reviewed', AVG(q.review_time) AS avg_review_time FROM `review` INNER JOIN `symptom` ON `review`.`event_id` = `symptom`.`event_id` INNER JOIN `logins` ON `review`.`user_id` = `logins`.`user_id` INNER JOIN `login_history` ON `logins`.`user_id` = `login_history`.`id` LEFT JOIN   (SELECT `review`.`user_id`, (TIMESTAMPDIFF(SECOND, MIN(TIME(`review`.`action_date`)), MAX(TIME(`review`.`action_date`))) / (COUNT(DISTINCT(`review`.`action_date`)) -1)) AS review_time FROM `review` GROUP BY `review`.`user_id`, DATE(`review`.`action_date`)) AS `q` ON `review`.`user_id`=`q`.`user_id` WHERE (`symptom`.`study_id` = ?) GROUP BY kid ORDER BY `logins`.`name`;"))) { logger(__LINE__, "SQLi Prepare: $active_QUERY->error"); }
	if (!($active_QUERY->bind_param('ss', $study_id, $study_id))) { logger(__LINE__, "SQLi rBind error: $active_QUERY->error"); }
	if (!($active_QUERY->execute())) { logger(__LINE__, "SQLi execute error: $active_QUERY->error"); }	
	if (!($active_QUERY->bind_result($active_user_id, $active_name, $active_last, $active_reviewed, $active_reivew_time))) { logger(__LINE__, "SQLi rBind error: $logouts_QUERY->error"); }
	$active_QUERY->store_result();
	
	
	if (($active_QUERY->num_rows) > 0)
		{
			while ($active_QUERY->fetch())
				{
					$active_reivew_time = sprintf("%02d", floor($active_reivew_time / 3600)) . ":" . sprintf("%02d", floor(($active_reivew_time / 60) % 60)) . "." . sprintf("%02d", $active_reivew_time % 60) ." ";
					
					echo "	<div class=\"mt-row\">
								<div class=\"mt-cell\">$active_name</div>
								<div class=\"mt-cell\">$active_last</div>
								<div class=\"mt-cell\">$active_reviewed</div>
								<div class=\"mt-cell\">$active_reivew_time</div>
							</div>";
				}
		}
		else
		{
			echo "	<div class=\"mt-row\"> No Records to display </div>";
		}
		
	echo " 			</div>
				</div>
			</span>
		</span>";
	mysqli_stmt_close($active_QUERY);

	include("footer.php");
}
?>