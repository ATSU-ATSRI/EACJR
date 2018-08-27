<?php
session_start();
$redirect = isset($_SESSION['redirect']) ? $_SESSION['redirect'] : 'index.php';

if ($redirect != "index.php")
	{
		require('datacon.php');

			$report_study_id = $_SESSION['report_study'];
			$report_study_name = $_SESSION['report_study_name'];
			$report_type = $_SESSION['report_type'];
			
			if ($report_type === "resolved")
				{ 
					$report_QUERY = "SELECT `patient`.`study_id`, `patient`.`patient_id`, `patient`.`code` as pt_code, `patient`.`phase` as pt_phase, `symptom`.`event_id` as symptom_event_id, `symptom`.`symptom`, `symptom`.`insert_date`, `symptom`.`pt_baseline`, `symptom`.`pt_baseline_severity`, `symptom`.`pt_24hr`, `symptom`.`pt_24hr_severity`, `symptom`.`pt_24hr_related`, `symptom`.`pt_24hr_details`, `symptom`.`pt_72hr`, `symptom`.`pt_72hr_severity`, `symptom`.`pt_72hr_related`, `symptom`.`pt_72hr_details`, `symptom`.`pt_1wk`, `symptom`.`pt_1wk_details`, `symptom`.`followup_clinic`, `symptom`.`followup_clinic_related`, `symptom`.`followup_clinic_details`, `symptom`.`followup_uc`, `symptom`.`followup_uc_related`, `symptom`.`followup_uc_details`, `symptom`.`followup_er`, `symptom`.`followup_er_related`, `symptom`.`followup_er_details`, `symptom`.`followup_hosp`, `symptom`.`followup_hosp_related`, `symptom`.`followup_hosp_details`, `symptom`.`further`, `symptom`.`further_why`, `symptom`.`future`, `symptom`.`future_why`, `review`.`review_id`, `review`.`phase` AS review_phase, `review`.`action_date`, `review`.`user_id`, `review`.`event_id` AS review_event_id, `review`.`comment`, `review`.`24hr_adverse_event`, `review`.`72hr_adverse_event`, `review`.`1wk_adverse_event`, `review`.`followup_adverse_event`, `review`.`ae_severity`, `review`.`omt_related` FROM `patient` LEFT JOIN `symptom` ON `patient`.`code`=`symptom`.`code` LEFT JOIN `review` ON `symptom`.`event_id`=`review`.`event_id` WHERE (`patient`.`study_id` = '$report_study_id') AND (`patient`.`phase` = '0') ORDER BY `patient`.`patient_id`ASC, `review`.`phase` ASC;";
					$_SESSION['pass_fail'] = "Resolved report generating.";
					$go_flag = 1;
				}
				elseif ($report_type === "pending")
				{
					$report_QUERY = "SELECT `patient`.`study_id`, `patient`.`patient_id`, `patient`.`code` as pt_code, `patient`.`phase` as pt_phase, `symptom`.`event_id` as symptom_event_id, `symptom`.`symptom`, `symptom`.`insert_date`, `symptom`.`pt_baseline`, `symptom`.`pt_baseline_severity`, `symptom`.`pt_24hr`, `symptom`.`pt_24hr_severity`, `symptom`.`pt_24hr_related`, `symptom`.`pt_24hr_details`, `symptom`.`pt_72hr`, `symptom`.`pt_72hr_severity`, `symptom`.`pt_72hr_related`, `symptom`.`pt_72hr_details`, `symptom`.`pt_1wk`, `symptom`.`pt_1wk_details`, `symptom`.`followup_clinic`, `symptom`.`followup_clinic_related`, `symptom`.`followup_clinic_details`, `symptom`.`followup_uc`, `symptom`.`followup_uc_related`, `symptom`.`followup_uc_details`, `symptom`.`followup_er`, `symptom`.`followup_er_related`, `symptom`.`followup_er_details`, `symptom`.`followup_hosp`, `symptom`.`followup_hosp_related`, `symptom`.`followup_hosp_details`, `symptom`.`further`, `symptom`.`further_why`, `symptom`.`future`, `symptom`.`future_why`, `review`.`review_id`, `review`.`phase` AS review_phase, `review`.`action_date`, `review`.`user_id`, `review`.`event_id` AS review_event_id, `review`.`comment`, `review`.`24hr_adverse_event`, `review`.`72hr_adverse_event`, `review`.`1wk_adverse_event`, `review`.`followup_adverse_event`, `review`.`ae_severity`, `review`.`omt_related` FROM `patient` LEFT JOIN `symptom` ON `patient`.`code`=`symptom`.`code` LEFT JOIN `review` ON `symptom`.`event_id`=`review`.`event_id` WHERE (`patient`.`study_id` = '$report_study_id') AND (`patient`.`phase` > '0') ORDER BY `patient`.`patient_id`ASC, `review`.`phase` ASC;";
					$_SESSION['pass_fail'] = "Pending report generating.";
					$go_flag = 1;
				}
				elseif ($report_type === "unconsensus")
				{
					$report_QUERY = "SELECT `patient`.`study_id`, `patient`.`patient_id`, `patient`.`code` as pt_code, `patient`.`phase` as pt_phase, `symptom`.`event_id` as symptom_event_id, `symptom`.`symptom`, `symptom`.`insert_date`, `symptom`.`pt_baseline`, `symptom`.`pt_baseline_severity`, `symptom`.`pt_24hr`, `symptom`.`pt_24hr_severity`, `symptom`.`pt_24hr_related`, `symptom`.`pt_24hr_details`, `symptom`.`pt_72hr`, `symptom`.`pt_72hr_severity`, `symptom`.`pt_72hr_related`, `symptom`.`pt_72hr_details`, `symptom`.`pt_1wk`, `symptom`.`pt_1wk_details`, `symptom`.`followup_clinic`, `symptom`.`followup_clinic_related`, `symptom`.`followup_clinic_details`, `symptom`.`followup_uc`, `symptom`.`followup_uc_related`, `symptom`.`followup_uc_details`, `symptom`.`followup_er`, `symptom`.`followup_er_related`, `symptom`.`followup_er_details`, `symptom`.`followup_hosp`, `symptom`.`followup_hosp_related`, `symptom`.`followup_hosp_details`, `symptom`.`further`, `symptom`.`further_why`, `symptom`.`future`, `symptom`.`future_why`, `review`.`review_id`, `review`.`phase` AS review_phase, `review`.`action_date`, `review`.`user_id`, `review`.`event_id` AS review_event_id, `review`.`comment`, `review`.`24hr_adverse_event`, `review`.`72hr_adverse_event`, `review`.`1wk_adverse_event`, `review`.`followup_adverse_event`, `review`.`ae_severity`, `review`.`omt_related` FROM `patient` LEFT JOIN `symptom` ON `patient`.`code`=`symptom`.`code` LEFT JOIN `review` ON `symptom`.`event_id`=`review`.`event_id` WHERE (`patient`.`study_id` = '$report_study_id') AND (`patient`.`phase` > '1') ORDER BY `patient`.`patient_id`ASC, `review`.`phase` ASC;";
					$_SESSION['pass_fail'] = "Unconsensus report generating.";
					$go_flag = 1;
				}
				elseif ($report_type === "worktime")
				{
					$report_QUERY = "SELECT `logins`.`name` AS name, MIN(`login_history`.`login`) AS first_login, MIN(`review`.`action_date`) AS first_vote, MAX(`review`.`action_date`) AS last_vote, MAX(`login_history`.`login`) AS last_login FROM `review` LEFT OUTER JOIN `login_history` ON `review`.`user_id`=`login_history`.`id` INNER JOIN `logins` ON `login_history`.`id`=`logins`.`user_id` WHERE FIND_IN_SET('$report_study_id',`logins`.`study`) GROUP BY `logins`.`user_id`";
					$_SESSION['pass_fail'] = "Worktime report generating.";
					$go_flag = 1;
				}
				else
				{
					$_SESSION['pass_fail'] = "Report Error.";
					$go_flag = 0;
				}
				
			if ($go_flag > 0)
				{
					set_time_limit(60);
								
					if ($result = $dblink->query($report_QUERY))
						{
							$filename = $report_study_name . "_". $report_type ."_report." . date("Y.m.d.H.i.s") . ".csv";
							$filename = str_ireplace(" ","_",$filename);
									
							header("Content-Type: application/octet-stream");
							header("Content-Disposition: attachment; filename=$filename");
							$download = fopen("php://output", "w");
							
							$head = $result->fetch_fields();
							$headname = "";
							foreach ($head as $h)
								{
									$headname .= $h->name . ",";
								}
								$headname = substr($headname, 0, -1) . "\r\n";
								fputs($download, $headname);	
							
							while($row = $result->fetch_assoc())
								{
									fputcsv($download, $row);
								}
							fclose($download);
						}
						else
						{ 
							logger(__LINE__, "SQLi error: $dblink->error"); 
						}
					mysqli_stmt_close($result);
					if (isset($report)) { unset($report); }
					if (isset($row)) { unset($row); }
					if (isset($download)) { unset($download); }
				}
	
			if (isset($go_flag)) { unset($go_flag); }
			if (isset($report_study_id)) { unset($report_study_id); }
			if (isset($report_study_name)) { unset($report_study_name); }
			if (isset($report_type)) { unset($report_type); }
			if (isset($result)) { unset($result); }
			if (isset($_SESSION['report_study'])) { unset($_SESSION['report_study']); }
			if (isset($_SESSION['report_study_name'])) { unset($_SESSION['report_study_name']); }
			if (isset($_SESSION['report_type'])) { unset($_SESSION['report_type']); } 
			unset($_SESSION['redirect']);
	}
	else
	{
		if (isset($go_flag)) { unset($go_flag); }
		if (isset($report_study_id)) { unset($report_study_id); }
		if (isset($report_study_name)) { unset($report_study_name); }
		if (isset($report_type)) { unset($report_type); }
		if (isset($result)) { unset($result); }
		if (isset($_SESSION['report_study'])) { unset($_SESSION['report_study']); }
		if (isset($_SESSION['report_study_name'])) { unset($_SESSION['report_study_name']); }
		if (isset($_SESSION['report_type'])) { unset($_SESSION['report_type']); } 
		unset($_SESSION['redirect']);

		include("header.php");		
		echo "
		<div class=\"main\">
			<span class=\"left-box\">
				<center>
				<img src=\"images/updating.gif\"> 
				</center>
			</span>
			<span class=\"left-box\">
				<font size=\"+2\">Processing your request, please wait.</font>
			</span>
		";
		include("footer.php");
	}
?>