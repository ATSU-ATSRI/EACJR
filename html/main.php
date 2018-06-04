<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include('menu_item.php');


if (!($study_QUERY = $dblink->prepare("SELECT `study_id`, `name` FROM `studys` WHERE (CURDATE() BETWEEN `date_start` AND `date_end`) AND (study_id = ?);"))) { logger(__LINE__, "SQLi Prepare: $study_QUERY->error"); }
if (!($study_QUERY->bind_param($_SESSION["study"]))) { logger(__LINE__, "SQLi pBind: $study_QUERY->error"; }
if (!($study_QUERY->execute())) { logger(__LINE__, "SQLi execute: $study_QUERY->error"); }
if (!($study_QUERY->bind_result($study_id, $study_name))) { logger(__LINE__, "SQLi rBind: $study_QUERY->error"); }
$study_QUERY->store_result();
if ($study_QUERY->num_rows > 0)
	{
	if (!($events_QUERY = $dblink->prepare("
										SELECT 
											patient.patient_id,
											patient.code,
											patient.phase,
											COUNT(CASE
												WHEN symptom.symptom IS NOT NULL THEN 1
											END) AS symptom_count,
											COUNT(CASE
												WHEN ((symptom.phase = patient.phase) AND
													  (review.event_id = symptom.event_id)) THEN 1
											END) AS review_count
										FROM
											patient
												LEFT OUTER JOIN
											symptom ON patient.code = symptom.code
												LEFT OUTER JOIN
											review ON symptom.event_id = review.event_id
										WHERE
											((patient.study_id IN (?))
												AND (patient.patient_id NOT IN (SELECT 
													patient.patient_id
												FROM
													patient
														INNER JOIN
													symptom ON patient.code = symptom.code
														INNER JOIN
													review ON symptom.event_id = review.event_id
												WHERE
													(review.user_id = ?)))
												AND (((symptom.followup_clinic = 'Yes')
												OR (symptom.followup_er = 'Yes')
												OR (symptom.followup_hosp = 'Yes')
												OR (symptom.followup_uc = 'Yes'))
												OR ((symptom.pt_24hr_severity = 'Very Severe')
												OR (symptom.pt_72hr_severity = 'Very Severe')
												OR (symptom.pt_baseline_severity = 'Very Severe'))
												OR (patient.code IN (SELECT 
													patient.code
												FROM
													patient
														LEFT OUTER JOIN
													symptom ON patient.code = symptom.code
												WHERE
													((symptom.pt_baseline_severity = 'Not present')
														AND (symptom.pt_24hr_severity = 'Mild')
														OR (symptom.pt_24hr_severity = 'Moderate')
														OR (symptom.pt_24hr_severity = 'Severe')
														OR (symptom.pt_24hr_severity = 'Very Severe'))
														OR ((symptom.pt_baseline_severity = 'Mild')
														AND (symptom.pt_24hr_severity = 'Moderate')
														OR (symptom.pt_24hr_severity = 'Severe')
														OR (symptom.pt_24hr_severity = 'Very Severe'))
														OR ((symptom.pt_baseline_severity = 'Moderate')
														AND (symptom.pt_24hr_severity = 'Severe')
														OR (symptom.pt_24hr_severity = 'Very Severe'))
														OR ((symptom.pt_baseline_severity = 'Severe')
														AND (symptom.pt_24hr_severity = 'Very Severe'))
														OR ((symptom.pt_baseline_severity = 'Not present')
														AND (symptom.pt_72hr_severity = 'Mild')
														OR (symptom.pt_72hr_severity = 'Moderate')
														OR (symptom.pt_72hr_severity = 'Severe')
														OR (symptom.pt_72hr_severity = 'Very Severe'))
														OR ((symptom.pt_baseline_severity = 'Mild')
														AND (symptom.pt_72hr_severity = 'Moderate')
														OR (symptom.pt_72hr_severity = 'Severe')
														OR (symptom.pt_72hr_severity = 'Very Severe'))
														OR ((symptom.pt_baseline_severity = 'Moderate')
														AND (symptom.pt_72hr_severity = 'Severe')
														OR (symptom.pt_72hr_severity = 'Very Severe'))
														OR ((symptom.pt_baseline_severity = 'Severe')
														AND (symptom.pt_72hr_severity = 'Very Severe'))
														OR ((symptom.pt_24hr_severity = 'Not present')
														AND (symptom.pt_72hr_severity = 'Mild')
														OR (symptom.pt_72hr_severity = 'Moderate')
														OR (symptom.pt_72hr_severity = 'Severe')
														OR (symptom.pt_72hr_severity = 'Very Severe'))
														OR ((symptom.pt_24hr_severity = 'Mild')
														AND (symptom.pt_72hr_severity = 'Moderate')
														OR (symptom.pt_72hr_severity = 'Severe')
														OR (symptom.pt_72hr_severity = 'Very Severe'))
														OR ((symptom.pt_24hr_severity = 'Moderate')
														AND (symptom.pt_72hr_severity = 'Severe')
														OR (symptom.pt_72hr_severity = 'Very Severe'))
														OR ((symptom.pt_24hr_severity = 'Severe')
														AND (symptom.pt_72hr_severity = 'Very Severe')))
												OR (patient.phase > '-1'))))
										GROUP BY patient.code
										ORDER BY patient.phase DESC, patient.patient_id ASC;"))) { logger(__LINE__, "SQLi Prepare: $events_QUERY->error"); }
	if (!($events_QUERY->bind_param('ss', $_SESSION["study"], $_SESSION["id"]))) { logger(__LINE__, "SQLi pBind: $events_QUERY->error"); }
	if (!($events_QUERY->execute())) { logger(__LINE__, "SQLi execute: $events_QUERY->error"); }
	if (!($events_QUERY->bind_result($patient_id, $code, $phase, $symptom_count, $review_count))) { logger(__LINE__, "SQLi rBind: $events_QUERY->error"); }
	$events_QUERY->store_result();
	
	
	echo "
		<div class=\"main\">";
		
		if (isset($_SESSION['pass_fail']))
			{
				echo "<div class=\"alert\">". $_SESSION['pass_fail'] ." </div>";
				unset($_SESSION['pass_fail']);
			}
			
	echo "
		<table name=\"events\">
		<thead>";
	
	if ($events_QUERY->num_rows > 0)
		{
			echo "
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
									<td colspan=\"4\" width=\"100%\" style=\"background-color:cornsilk; text-align:center; vertical-align:middle;\"><br /> ---> Phase $phase <--- <br /></td>
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
		}
		else
		{
			echo "
				<tr>
					<td colspan=\"4\" width=\"100%\"><center>No records availiable to review.</center></td>
				</tr>";
		}
	}
	else
		{
			echo "
				<tr>
					<td colspan=\"4\" width=\"100%\"><center>No records availiable to review.</center></td>
				</tr>";
		}
	echo "	</tbody>
			</table>
			</div>";
	$events_QUERY->close();
	$dblink->close();
	include("footer.php");
	
}

?>