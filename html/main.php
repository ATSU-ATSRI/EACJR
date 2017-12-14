<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include('menu_item.php');

	if (!($events_QUERY = $dblink->prepare("
			SELECT
				patient.patient_id,
				patient.code,
				patient.phase,
				count(CASE WHEN symptom.symptom IS NOT NULL THEN 1 END) AS symptom_count,
				(SELECT 
						count(*)
					FROM
						review
							INNER JOIN
						symptom ON review.event_id = symptom.event_id
					WHERE
						symptom.phase = patient.phase) AS review_count
			FROM patient 
				LEFT OUTER JOIN	symptom ON patient.code = symptom.code 
				LEFT OUTER JOIN review ON symptom.event_id = review.event_id
			WHERE
				(
					(patient.study_id IN (?)) AND
					(symptom.event_id NOT IN (SELECT event_id FROM review WHERE (user_id = ?))) AND 
					(
						(
							(symptom.followup_clinic = 'Yes') OR
							(symptom.followup_er = 'Yes') OR 
							(symptom.followup_hosp = 'Yes') OR 
							(symptom.followup_uc = 'Yes')
						)
						OR 
						(
							(symptom.pt_24hr_severity = 'Very Severe') OR 
							(symptom.pt_72hr_severity = 'Very Severe') OR 
							(symptom.pt_baseline_severity = 'Very Severe')
						)
						OR
						( 
							patient.code IN
								(
									SELECT patient.code
									FROM patient 
										LEFT OUTER JOIN	symptom ON patient.code = symptom.code 
									WHERE
										((symptom.pt_baseline_severity = 'Not present') AND 
											(symptom.pt_24hr_severity = 'Mild') OR 
											(symptom.pt_24hr_severity = 'Moderate') OR 
											(symptom.pt_24hr_severity = 'Severe') OR 
											(symptom.pt_24hr_severity = 'Very Severe')) OR
										((symptom.pt_baseline_severity = 'Mild') AND 
											(symptom.pt_24hr_severity = 'Moderate') OR 
											(symptom.pt_24hr_severity = 'Severe') OR 
											(symptom.pt_24hr_severity = 'Very Severe')) OR 
										((symptom.pt_baseline_severity = 'Moderate') AND 
											(symptom.pt_24hr_severity = 'Severe') OR 
											(symptom.pt_24hr_severity = 'Very Severe')) OR 
										((symptom.pt_baseline_severity = 'Severe') AND 
											(symptom.pt_24hr_severity = 'Very Severe')) OR 
										((symptom.pt_baseline_severity = 'Not present') AND 
											(symptom.pt_72hr_severity = 'Mild') OR 
											(symptom.pt_72hr_severity = 'Moderate') OR 
											(symptom.pt_72hr_severity = 'Severe') OR 
											(symptom.pt_72hr_severity = 'Very Severe')) OR
										((symptom.pt_baseline_severity = 'Mild') AND 
											(symptom.pt_72hr_severity = 'Moderate') OR 
											(symptom.pt_72hr_severity = 'Severe') OR 
											(symptom.pt_72hr_severity = 'Very Severe')) OR 
										((symptom.pt_baseline_severity = 'Moderate') AND 
											(symptom.pt_72hr_severity = 'Severe') OR 
											(symptom.pt_72hr_severity = 'Very Severe')) OR 
										((symptom.pt_baseline_severity = 'Severe') AND 
											(symptom.pt_72hr_severity = 'Very Severe')) OR 
										((symptom.pt_24hr_severity = 'Not present') AND 
											(symptom.pt_72hr_severity = 'Mild') OR 
											(symptom.pt_72hr_severity = 'Moderate') OR 
											(symptom.pt_72hr_severity = 'Severe') OR 
											(symptom.pt_72hr_severity = 'Very Severe')) OR
										((symptom.pt_24hr_severity = 'Mild') AND 
											(symptom.pt_72hr_severity = 'Moderate') OR 
											(symptom.pt_72hr_severity = 'Severe') OR 
											(symptom.pt_72hr_severity = 'Very Severe')) OR 
										((symptom.pt_24hr_severity = 'Moderate') AND 
											(symptom.pt_72hr_severity = 'Severe') OR 
											(symptom.pt_72hr_severity = 'Very Severe')) OR 
										((symptom.pt_24hr_severity = 'Severe') AND 
											(symptom.pt_72hr_severity = 'Very Severe'))
								) OR
							(
								patient.phase > '-1'
							)
						)
					)
				)
			GROUP BY patient.code
			ORDER BY patient.phase DESC, patient.patient_id ASC"))) { logger("SQLi Prepare: $events_QUERY->error"); }
	if (!($events_QUERY->bind_param('ss', $_SESSION["study"], $_SESSION["id"]))) { logger("SQLi pBind: $events_QUERY->error"); }
	if (!($events_QUERY->execute())) { logger("SQLi execute: $events_QUERY->error"); }
	if (!($events_QUERY->bind_result($patient_id, $code, $phase, $symptom_count, $review_count))) { logger("SQLi rBind: $events_QUERY->error"); }
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
					<th width=\"25%\">Participant</th>
					<th width=\"25%\">Symptom Count</th>
					<th width=\"25%\">Review Count</th>
					<th width=\"25%\"></th>
				</tr>
				</thead>
				<tbody>";
				
			$phase_last = "0";
			
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
							
					echo "
						<tr>
							<td width=\"25%\">$patient_id</td>
							<td width=\"25%\">$symptom_count</td>
							<td width=\"25%\">$review_count</td>
							<td width=\"25%\">";
					if ($phase > 0)
						{
							echo "<a href=\"review.php?req=$patient_id\"><button type=\"button\">Review</button></a>";
						}
					echo "</tr>";
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