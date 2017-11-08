<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include('menu_item.php');

	if (!($events_QUERY = $dblink->prepare("
			SELECT
				patient.patient_id,
				patient.code,
				symptom.phase,
				count(CASE WHEN symptom.symptom IS NOT NULL THEN 1 END) AS symptom_count,
				count(DISTINCT review.event_id) AS review_count
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
								)
						)
					)
				)
			GROUP BY patient.code
			ORDER BY symptom.phase, patient.code"))) { logger("SQLi Prepare: $events_QUERY->error"); }
	if (!($events_QUERY->bind_param('ss', $_SESSION["study"], $_SESSION["id"]))) { logger("SQLi pBind: $events_QUERY->error"); }
	if (!($events_QUERY->execute())) { logger("SQLi execute: $events_QUERY->error"); }
	if (!($events_QUERY->bind_result($patient_id, $code, $phase, $symptom_count, $review_count))) { logger("SQLi rBind: $events_QUERY->error"); }
	$events_QUERY->store_result();
	
	
	echo "
		<div class=\"main\">";
		
		if (isset($_SESSION['pass_fail']))
			{
				echo "<span class=\"alert\">". $_SESSION['pass_fail'] ." </span>";
				unset($_SESSION['pass_fail']);
			}
			
	echo "
		<table name=\"events\" width=\"90%\" border=\"1\">
		<tr>
			<th colspan=\"4\">Active records</th>
		</tr>
		";
	
	if ($events_QUERY->num_rows > 0)
		{
			echo "
				<tr>
					<th>Participant</th>
					<th>Symptom Count</th>
					<th>Review Count<th>
				</tr>";
				
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
									<th colspan=\"4\"><br /> ---> Phase $phase <--- <br /></th>
								</tr>";
							$phase_last = $phase;
						}
							
					echo "
						<tr>
							<td>$patient_id</td>
							<td>$symptom_count</td>
							<td>$review_count</td>
							<td><a href=\"review.php?req=$patient_id\"><button type=\"button\">Review</button></a></td>
						</tr>";
						
				}
		}
		else
		{
			echo "
				<tr>
					<td colspan=\"4\"><center>No records availiable to review.</center></td>
				</tr>";
		}
	echo "</table>
			</div>";
	$events_QUERY->close();
	$dblink->close();
	include("footer.php");
	
}

?>