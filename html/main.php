<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include('menu_item.php');
	
	echo "
		<div class=\"main\">
		";
		
		if (isset($_SESSION['pass_fail']))
			{
				echo "<div class=\"alert\">". $_SESSION['pass_fail'] ." </div>";
				unset($_SESSION['pass_fail']);
			}

if (!($study_QUERY = $dblink->prepare("SELECT `logins`.`name` AS \"User_name\", `studys`.`study_id`, `studys`.`name` AS \"Study_name\" FROM `studys` INNER JOIN `logins` ON FIND_IN_SET(`studys`.`study_id`, `logins`.`study`) != 0 WHERE (CURDATE() BETWEEN `date_start` AND `date_end`) AND (`logins`.`user_id` = ?)"))) { logger(__LINE__, "SQLi Prepare: $study_QUERY->error"); }
if (!($study_QUERY->bind_param('s', $_SESSION["id"]))) { logger(__LINE__, "SQLi pBind: $study_QUERY->error"); }
if (!($study_QUERY->execute())) { logger(__LINE__, "SQLi execute: $study_QUERY->error"); }
if (!($study_QUERY->bind_result($user_name_NULL, $study_id_this, $study_name))) { logger(__LINE__, "SQLi rBind: $study_QUERY->error"); }
$study_QUERY->store_result();

if (($study_QUERY->num_rows) > 0)
{
while ($study_QUERY->fetch())
	{
		if (!($events_QUERY = $dblink->prepare("
										SELECT
											patient.study_id,
											patient.patient_id,
											patient.code,
											patient.phase
										FROM
											patient
										LEFT OUTER JOIN
											symptom
										ON
											patient.code = symptom.code
										LEFT OUTER JOIN
											review
										ON
											symptom.event_id = review.event_id
										WHERE
											(
												(patient.study_id = ?) AND(
													patient.patient_id NOT IN(
													SELECT
														patient.patient_id
													FROM
														patient
													INNER JOIN
														symptom
													ON
														patient.code = symptom.code
													INNER JOIN
														review
													ON
														symptom.event_id = review.event_id
													WHERE
														(review.user_id = ?)
												)
												) AND(
													(
														(symptom.followup_clinic = 'Yes') OR(symptom.followup_er = 'Yes') OR(symptom.followup_hosp = 'Yes') OR(symptom.followup_uc = 'Yes')
													) OR(
														(
															symptom.pt_24hr_severity = 'Very Severe'
														) OR(
															symptom.pt_72hr_severity = 'Very Severe'
														) OR(
															symptom.pt_baseline_severity = 'Very Severe'
														)
													) OR(
														patient.code IN(
														SELECT
															patient.code
														FROM
															patient
														LEFT OUTER JOIN
															symptom
														ON
															patient.code = symptom.code
														WHERE
															(
																(
																	symptom.pt_baseline_severity = 'Not present'
																) AND(
																	symptom.pt_24hr_severity = 'Mild'
																) OR(
																	symptom.pt_24hr_severity = 'Moderate'
																) OR(
																	symptom.pt_24hr_severity = 'Severe'
																) OR(
																	symptom.pt_24hr_severity = 'Very Severe'
																)
															) OR(
																(
																	symptom.pt_baseline_severity = 'Mild'
																) AND(
																	symptom.pt_24hr_severity = 'Moderate'
																) OR(
																	symptom.pt_24hr_severity = 'Severe'
																) OR(
																	symptom.pt_24hr_severity = 'Very Severe'
																)
															) OR(
																(
																	symptom.pt_baseline_severity = 'Moderate'
																) AND(
																	symptom.pt_24hr_severity = 'Severe'
																) OR(
																	symptom.pt_24hr_severity = 'Very Severe'
																)
															) OR(
																(
																	symptom.pt_baseline_severity = 'Severe'
																) AND(
																	symptom.pt_24hr_severity = 'Very Severe'
																)
															) OR(
																(
																	symptom.pt_baseline_severity = 'Not present'
																) AND(
																	symptom.pt_72hr_severity = 'Mild'
																) OR(
																	symptom.pt_72hr_severity = 'Moderate'
																) OR(
																	symptom.pt_72hr_severity = 'Severe'
																) OR(
																	symptom.pt_72hr_severity = 'Very Severe'
																)
															) OR(
																(
																	symptom.pt_baseline_severity = 'Mild'
																) AND(
																	symptom.pt_72hr_severity = 'Moderate'
																) OR(
																	symptom.pt_72hr_severity = 'Severe'
																) OR(
																	symptom.pt_72hr_severity = 'Very Severe'
																)
															) OR(
																(
																	symptom.pt_baseline_severity = 'Moderate'
																) AND(
																	symptom.pt_72hr_severity = 'Severe'
																) OR(
																	symptom.pt_72hr_severity = 'Very Severe'
																)
															) OR(
																(
																	symptom.pt_baseline_severity = 'Severe'
																) AND(
																	symptom.pt_72hr_severity = 'Very Severe'
																)
															) OR(
																(
																	symptom.pt_24hr_severity = 'Not present'
																) AND(
																	symptom.pt_72hr_severity = 'Mild'
																) OR(
																	symptom.pt_72hr_severity = 'Moderate'
																) OR(
																	symptom.pt_72hr_severity = 'Severe'
																) OR(
																	symptom.pt_72hr_severity = 'Very Severe'
																)
															) OR(
																(
																	symptom.pt_24hr_severity = 'Mild'
																) AND(
																	symptom.pt_72hr_severity = 'Moderate'
																) OR(
																	symptom.pt_72hr_severity = 'Severe'
																) OR(
																	symptom.pt_72hr_severity = 'Very Severe'
																)
															) OR(
																(
																	symptom.pt_24hr_severity = 'Moderate'
																) AND(
																	symptom.pt_72hr_severity = 'Severe'
																) OR(
																	symptom.pt_72hr_severity = 'Very Severe'
																)
															) OR(
																(
																	symptom.pt_24hr_severity = 'Severe'
																) AND(
																	symptom.pt_72hr_severity = 'Very Severe'
																)
															)
													) OR(patient.phase > '-1')
													)
												) AND (patient.phase > '0')
											)
										GROUP BY
											patient.patient_id,
											patient.code
										ORDER BY
											patient.phase ASC,
											patient.patient_id ASC;"))) { logger(__LINE__, "SQLi Prepare: $events_QUERY->error"); }
	if (!($events_QUERY->bind_param('ss', $study_id_this, $_SESSION["id"]))) { logger(__LINE__, "SQLi pBind: $events_QUERY->error"); }
	if (!($events_QUERY->execute())) { logger(__LINE__, "SQLi execute: $events_QUERY->error"); }
	if (!($events_QUERY->bind_result($study_number, $patient_id, $code, $phase))) { logger(__LINE__, "SQLi rBind: $events_QUERY->error"); }
	$events_QUERY->store_result();
	
	if ($events_QUERY->num_rows > 0)
		{

			echo "<div class=\"study-box\">
			<div class=\"study-left\">$study_name</div>
				";
			
			//$study_id_this
			if (!($race_QUERY = $dblink->prepare("SELECT `logins`.`user_id` AS `kid`, (SELECT COUNT(*) FROM `patient` WHERE (`patient`.`study_id` = ?) AND (`patient`.`phase` > '0')) AS `pttotal`, (SELECT COUNT(DISTINCT `patient`.`code`) FROM `patient` INNER JOIN `symptom` ON `patient`.`code`=`symptom`.`code` INNER JOIN `review` ON `symptom`.`event_id`=`review`.`event_id` WHERE (`patient`.`study_id` = ?) AND (`patient`.`phase` > '0') AND (`review`.`user_id` = kid)) AS `rvtotal` FROM `logins` WHERE FIND_IN_SET(?,`logins`.`study`) GROUP BY `logins`.`user_id`;"))) { logger(__LINE__, "SQLi Prepare: $dblink->error()"); }
			if (!($race_QUERY->bind_param('sss', $study_id_this, $study_id_this, $study_id_this))) { logger(__LINE__, "SQLi pBind: $race_QUERY->error()"); }
			if (!($race_QUERY->execute())) { logger(__LINE__, "SQLi Execute->error()"); }
			if (!($race_QUERY->bind_result($race_id, $race_pttotal, $race_rvtotal))) { logger(__LINE__, "SQLi rBind: $race_QUERY->error()"); }
			$race_QUERY->store_result();
			
			if ((($race_QUERY->num_rows) > 0) && ($_SESSION["id"] == "1"))
				{
					echo "<div class=\"study-right\" style=\"border-style: none dashed none none;\">Race to the finish!<br /><br />";
					$colour_ARRAY = array(	"background-color:red;color:white", 
											"background-color:orange;color:black", 
											"background-color:yellow;color:black", 
											"background-color:green;color:white", 
											"background-color:blue;color:white", 
											"background-color:purple;color:white", 
											"background-color:cyan;color:black", 
											"background-color:pink;color:black", 
											"background-color:black;color:white", 
											"background-color:grey;color:white");
					
					while ($race_QUERY->fetch())
						{
							$ptperc = round((($race_rvtotal / $race_pttotal) * 100), 0);
							if ($ptperc < 1) { $ptperc = 0; }
							$rand_colour = $colour_ARRAY[rand(0, 9)];
							while ($rand_colour == $rand_colour_last)
								{
									$rand_colour = $colour_ARRAY[rand(0, 9)];
								}
							
							echo "
									<div class=\"race-left\">";
							if ($race_id == $_SESSION["id"])
								{
									echo "You >>> ";
								}
								else
								{
									echo " # $race_id ";
								}
							echo "</div>
									<div class=\"race-right\" style=\"$rand_colour;width:$ptperc%;\">";
									if ($ptperc > 0) {echo "$ptperc %"; }  
									echo "</div>";
							$rand_colour_last = $rand_colour;
						}		
							
					echo "	</div>";
				}
			
			echo "
				<div class=\"study-table\">
				<table name=\"events\">
				<thead>
				<tr>
					<th width=\"25%\">Participant record ID</th>
					<th width=\"25%\">Participant record ID</th>
					<th width=\"25%\">Participant record ID</th>
					<th width=\"25%\">Participant record ID</th>					
				</tr>
				</thead>
				<tbody>";
				
			$phase_last = "0";
			$colcount = "0";
			$pad_string = "0";
			
			while ($events_QUERY->fetch())
				{
					if (is_null($phase))
						{
								$phase = "1";
						}
						
					if ($phase_last !== $phase)
						{
							echo "
								<tr>
									<td colspan=\"4\" width=\"100%\" style=\"background-color:cornsilk;text-align:center;vertical-align:middle;\"><br /> ---> Phase $phase <--- <br /></td>
								</tr>";
							$phase_last = $phase;
						}
					
					if ($colcount > 4)
						{
							echo "</tr>
							";
							$colcount = 0;
						}
					
					if ($colcount < 1)
						{
							echo "<tr>";
							$colcount = 1;
						}
						
					if (($colcount > 0) && ($colcount < 5))
						{
							$disp_patient_id = str_pad($patient_id, 4, $pad_string, STR_PAD_LEFT);
							
							
							echo "<td width=\"25%\">$disp_patient_id &nbsp; &nbsp; ";
					
							if ($phase > 0)
								{
									echo "<a href=\"review.php?req=$patient_id\"><button type=\"button\">Review</button></a>";
								}
							
							echo "</td>";
							unset($disp_patient_id);
						}
						
					
					$colcount++;
				}
			echo "</tbody>
			</table>
			</div>
			";
		}
		else
		{
			echo "	<div class=\"study-box\">
						<div class=\"study-left\"> $study_name </div>
						<div class=\"study-right\"> <center>No records availiable to review.</center></div>
					</div>
					";			
		}
	}
	$events_QUERY->close();
}
else
	{
		echo "	<div class=\"study-box\">
					<div class=\"study-left\"></div>
					<div class=\"study-right\"> <center>No study availiable to review.</center> </div>
				</div>
				";
	}
echo "
		</div>
	</div>";
$dblink->close();
include("footer.php");
	
}

?>