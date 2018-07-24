<?php
/* This programme is property of and copyright to the A. T. Still Research Institute.
   Project:           Event Adjudication Committee (EAC) Portal
   Instrumentation:   Jane Johnson, MA
   Code by:           Geoffroey-Allen S. Franklin, MBA, BS, AAS, AdeC, MCP
   Created:           2016-Oct-20
   Change Log:        2017-Oct-09 - Version 1.0 release.
*/

//General Rules
$rule_1 = "Disallow:harming humans";
$rule_2 = "Disallow:ignoring human orders";
$rule_3 = "Disallow:harm to self";
if (($rule_1 != TRUE) || ($rule_2 != TRUE) || ($rule_3 != TRUE)) {echo "Protect! Obey! Survive!\n"; die;}
date_default_timezone_set('America/Chicago'); //hard set for Kirksville.


// load required items
	// Logger
	require('logger.php');
		set_error_handler("recordError");
		$start_memory = memory_get_usage();
		logger(__LINE__, "===== Start of Log. =====");
		logger(__LINE__, "My timezone is: " . date_default_timezone_get());
		// end logger start
	
	// Database 
	require('datacon.php');
	
	// Standard vars
	$severity_array = array("Not present", "Mild", "Moderate", "Severe", "Very Severe");
	$severity_time_array = array("Not present", "baseline", "24hr", "72hr", "1_wk");
	
	// pull list of studies
	if (!($studys_QUERY = $dblink->prepare("SELECT 
												studys.study_id, 
												studys.quorum,
												studys.consensus,
												(
													SELECT 
														count(*)
													FROM
														jury_room.logins
													WHERE
														logins.study = study_id) AS members
											FROM
												studys
											WHERE
												(CURDATE() BETWEEN `date_start` AND `date_end`);"))) { logger(__LINE__, "SQLi Prepare: $studys_QUERY->error"); }
	if (!($studys_QUERY->execute())) { logger(__LINE__, "SQLi execute: $studys_QUERY->error"); }
	if (!($studys_QUERY->bind_result($study_id, $quorum, $consensus, $members))) { logger(__LINE__, "SQLi rBind: $studys_QUERY->error"); }
	$studys_QUERY->store_result();
	while ($studys_QUERY->fetch())
		{			
		// Start of main loop
			// Scan for patients without no phase (new pt. or new study)
			logger(__LINE__, "Phase Zero scan started.");
			logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
			
			if (!($scan_QUERY = $dblink->prepare("SELECT 
													patient_id,
													patient.code,
													symptom.event_id,
													symptom.pt_baseline,
													symptom.pt_baseline_severity,
													symptom.pt_24hr,
													symptom.pt_24hr_severity,
													symptom.pt_72hr,
													symptom.pt_72hr_severity,
													symptom.pt_1wk,
													symptom.followup_clinic,
													symptom.followup_uc,
													symptom.followup_er,
													symptom.followup_hosp
												FROM
													patient
														RIGHT JOIN
													symptom ON patient.code = symptom.code
												WHERE
													(patient.study_id = ?)
														AND (symptom.phase IS NULL);"))) { logger(__LINE__, "SQLi Prepare: $scan_QUERY->error"); }
			if (!($scan_QUERY->bind_param('s', $study_id))) { logger(__LINE__, "SQLi pBind: $scan_QUERY->error"); }
			if (!($scan_QUERY->execute())) { logger(__LINE__, "SQLi execute: $scan_QUERY->error"); }
			if (!($scan_QUERY->bind_result($patient_id, $code, $event_id, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_72hr, $pt_72hr_severity, $pt_1wk, $followup_clinic, $followup_uc, $followup_er, $followup_hosp))) { logger(__LINE__, "SQL rBind: $scan_QUERY->error"); }
			$scan_QUERY->store_result();
				while ($scan_QUERY->fetch())
					{
						// Am I an AE?
							$change_array = array();
							
							$change_array = array(
								"baseline" => array_search("$pt_baseline_severity", $severity_array, TRUE),
								"24hr" => array_search("$pt_24hr_severity", $severity_array, TRUE),
								"72hr" => array_search("$pt_72hr_severity", $severity_array, TRUE),
								"1_wk" => array_search("$pt_1wk", $severity_array, TRUE));
								
							if (!(isset($followup_clinic))) { $followup_clinic = "No"; }
							if (!(isset($followup_uc))) { $followup_uc = "No"; }
							if (!(isset($followup_er))) { $followup_er = "No"; }
							if (!(isset($followup_hosp))) { $followup_hosp = "No"; }
							
							if (($change_array['baseline'] < $change_array['24hr']) || 
								($change_array['baseline'] < $change_array['72hr']) || 
								($change_array['baseline'] == 4) ||
								($change_array['24hr'] == 4) ||
								($change_array['72hr'] == 4) ||
								($followup_clinic == 'Yes') ||
								($followup_uc == 'Yes') ||
								($followup_er == 'Yes') ||
								($followup_hosp == 'Yes'))
								{
									$new_phase = 1;
								}
								else
								{
									$new_phase = 0;
								}
							
						// move symptom to new phase
							logger(__LINE__, "  >> Moving $event_id to Phase $new_phase.");
						
							if (!($move_QUERY = $dblink->prepare("UPDATE symptom 
																	SET 
																		phase = ?
																	WHERE
																		(event_id = ?)"))) { logger(__LINE__, "SQLi Prepare: $move_QUERY->error"); }
							if (!($move_QUERY->bind_param('ss', $new_phase, $event_id))) { logger(__LINE__, "SQLi pBind: $move_QUERY->error"); }
							if (!($move_QUERY->execute())) { logger(__LINE__, "SQLi execute: $move_QUERY->error"); }
							
						// clean up this event_id.
							$move_QUERY->free_result();
							unset($change_array);
							unset($followup_clinic);
							unset($followup_uc);
							unset($followup_er);
							unset($followup_hosp);
							unset($new_phase);
					}
			// done with phase 0's.
			logger(__LINE__, "Phase Zero scan completed, cleaning up.");
			$scan_QUERY->free_result();
					
		// Scan for symptoms with quorum and phase > 0
			logger(__LINE__, "Phase quorum scan started.");
			logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
			
			if (!($scan_QUERY = $dblink->prepare("SELECT 
													`patient`.`patient_id`,
													`patient`.`study_id`,
													`symptom`.`event_id` AS evi,
													`symptom`.`phase` AS pze,
													`review`.`user_id`,
													`review`.`24hr_adverse_event`,
													`review`.`72hr_adverse_event`,
													`review`.`1wk_adverse_event`,
													`review`.`ae_severity`,
													`review`.`omt_related`,
													(
														CASE
															WHEN
																(
																	(
																		SELECT 
																			COUNT(*) 
																		FROM 
																			`review`
																			RIGHT JOIN `symptom` ON `review`.`event_id`=`symptom`.`event_id` 
																		WHERE 
																			(symptom.phase > 0) 
																			AND (`symptom`.`study_id` = ?)
																			AND (`review`.`event_id` = evi)
																			AND (`review`.`phase` = pze)
																	)
																/ 
																	(
																		SELECT 
																			COUNT(*)
																		FROM
																			`jury_room`.`logins`
																		WHERE
																			FIND_IN_SET(?,study)
																	)
																> 
																	(
																		SELECT 
																			`quorum`
																		FROM
																			`studys`
																		WHERE
																			`studys`.`study_id` = ?
																	) 
																/ 
																	100
																)
															THEN
																'1'
																ELSE '0'
															END
													) AS has_quroum
												FROM
													`patient`
														RIGHT JOIN `symptom` ON `patient`.`code` = `symptom`.`code`
														RIGHT JOIN `review` ON `symptom`.`event_id` = `review`.`event_id`
												WHERE
													(`patient`.`study_id` = ?)
													AND (`symptom`.`phase` > '0')
												ORDER BY 
													`review`.`event_id`;"))) { logger(__LINE__, "SQLi Prepare: $scan_QUERY->error"); }
			if (!($scan_QUERY->bind_param('ssss', $study_id, $study_id, $study_id, $study_id))) { logger(__LINE__, "SQLi pBind: $scan_QUERY->error"); }
			if (!($scan_QUERY->execute())) { logger(__LINE__, "SQLi execute: $scan_QUERY->error"); }
			if (!($scan_QUERY->bind_result($patient_id, $study_id, $event_id, $phase, $user_id, $p24hr_adverse_event, $p72hr_adverse_event, $p1wk_adverse_event, $ae_severity, $omt_related, $has_quroum))) { logger(__LINE__, "SQL rBind: $scan_QUERY->error"); }
			$scan_QUERY->store_result();
			$phase_array = array();
				while ($scan_QUERY->fetch())
					{
						if ($scan_QUERY->num_rows > 0)
							{
								if ($has_quroum == 1)
									{
										// load each user_id into an array by event_id
											$phase_array[$event_id][$user_id] = array($p24hr_adverse_event, $p72hr_adverse_event, $p1wk_adverse_event, $ae_severity, $omt_related);
									}
							}
					}
					
			if (count($phase_array) > 0)
					{
						// compare each user_id against others in the array
						
						foreach ($phase_array as $e_id => $votes)
							{
								// $e_id => event_id
								// count($phase_array[$e_id]) => number of votes recorded
								// count(array_unique($votes)) => number of votes that DON'T match the others.
								// if >$consensus % votes equal set patient.phase = 0 else set patient.phase++
								if 	((count(array_unique($votes)) / count($phase_array[$e_id])) < ($consensus * .01))
									{
										$new_phase = 0;
									}
									else
									{
										if (!($new_phase_QUERY = $dblink->prepare("SELECT 
																				phase
																			FROM
																				symptom
																			WHERE
																				(symptom.event_id = ?);"))) { logger(__LINE__, "SQLi Prepare: $new_phase_QUERY->error"); }
										if (!($new_phase_QUERY->bind_param('s', $e_id))) { logger(__LINE__, "SQLi pBind: $new_phase_QUERY->error"); }
										if (!($new_phase_QUERY->execute())) { logger(__LINE__, "SQLi execute: $new_phase_QUERY->error"); }
										if (!($new_phase_QUERY->bind_result($new_phase))) { logger(__LINE__, "SQL rBind: $new_phase_QUERY->error"); }
										$new_phase_QUERY->store_result();
										$new_phase_QUERY->fetch();
										$new_phase++;
										$new_phase_QUERY->free_result();
									}
								logger(__LINE__, "  >> Moving $event_id to Phase $new_phase.");						
								if (!($move_QUERY = $dblink->prepare("UPDATE symptom 
																	SET 
																		phase = ?
																	WHERE
																		(event_id = ?)"))) { logger(__LINE__, "SQLi Prepare: $move_QUERY->error"); }
								if (!($move_QUERY->bind_param('ss', $new_phase, $e_id))) { logger(__LINE__, "SQLi pBind: $move_QUERY->error"); }
								if (!($move_QUERY->execute())) { logger(__LINE__, "SQLi execute: $move_QUERY->error"); }
							}
					}
				logger(__LINE__, "Phase quorum scan completed, cleaning up.");
				$scan_QUERY->free_result();	
				
				
		// move pt. to max(symptom.phase)
			logger(__LINE__, "Updating pt. phase to match max(symptom.phase)");
			logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
			if (!($getphase_QUERY = $dblink->prepare("SELECT
														`patient`.`patient_id`,
															(
																SELECT
																	MAX(`symptom`.`phase`)
																FROM
																	`symptom`
																WHERE
																	`symptom`.`code` = `patient`.`code`
															) AS re_phase
													FROM
														`patient`
													WHERE
														(`patient`.`phase` > 0) AND 
														(`patient`.`phase` < (
																SELECT
																	MAX(`symptom`.`phase`)
																FROM
																	`symptom`
																WHERE
																	`symptom`.`code` = `patient`.`code`
															) );")))  { logger(__LINE__, "SQLi Prepare: $getphase_QUERY->error"); }
			if (!($getphase_QUERY->execute())) { logger(__LINE__, "SQLi execute: $getphase_QUERY->error"); }
			if (!($getphase_QUERY->bind_result($patient_id, $re_phase))) {logger(__LINE__, "SQLi rBind: $getphase_QUERY->error"); }
			$getphase_QUERY->store_result();
			if ($getphase_QUERY->num_rows() > 0)
				{
					while ($getphase_QUERY->fetch())
						{
							logger(__LINE__, "  >> Moving $patient_id to Phase $re_phase.");
							if (!($move_QUERY = $dblink->prepare("UPDATE patient 
																SET 
																	phase = ?
																WHERE
																	(patient_id = ?)"))) { logger(__LINE__, "SQLi Prepare: $move_QUERY->error"); }
							if (!($move_QUERY->bind_param('ss', $re_phase, $patient_id))) { logger(__LINE__, "SQLi pBind: $move_QUERY->error"); }
							if (!($move_QUERY->execute())) { logger(__LINE__, "SQLi execute: $move_QUERY->error"); }
						}
					logger(__LINE__, "Rephase move completed, cleaning up.");
					$move_QUERY->free_result();
					if (isset($re_phase)) { unset($re_phase); }
					if (isset($patient_id)) { unset($patient_id); }
				}
			logger(__LINE__, "Get Rephase completed, cleaning up.");
			$getphase_QUERY->free_result();
			
		// set patient.phase = 0 when all symptom.phases = 0
		 	logger(__LINE__, "Phase completed scan started.");
			logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
			
			if (!($completed_QUERY = $dblink->prepare("SELECT DISTINCT
														patient.patient_id
													FROM
														patient
															RIGHT JOIN
														symptom ON patient.code = symptom.code
													WHERE
														((SELECT 
																COUNT(*)
															FROM
																symptom
															WHERE
																(phase = '0')
																	AND (symptom.code = patient.code)
																	AND (symptom.symptom IS NOT NULL)) = (SELECT 
																			COUNT(*)
																		FROM
																			symptom
																		WHERE
																			(symptom.code = patient.code)
																				AND (symptom.symptom IS NOT NULL)))
														AND (patient.phase <> 0);"))) { logger(__LINE__, "SQLi Prepare: $completed_QUERY->error"); }
			if (!($completed_QUERY->execute())) { logger(__LINE__, "SQLi execute: $completed_QUERY->error"); }
			if (!($completed_QUERY->bind_result($patient_id))) { logger(__LINE__, "SQL rBind: $completed_QUERY->error"); }
			$completed_QUERY->store_result();
			if ($completed_QUERY->num_rows() > 0)
				{
					while ($completed_QUERY->fetch())
						{
							logger(__LINE__, "  >> Moving $patient_id to Phase 0.");
							if (!($move_QUERY = $dblink->prepare("UPDATE patient 
																SET 
																	phase = 0
																WHERE
																	(patient_id = ?)"))) { logger(__LINE__, "SQLi Prepare: $move_QUERY->error"); }
							if (!($move_QUERY->bind_param('s', $patient_id))) { logger(__LINE__, "SQLi pBind: $move_QUERY->error"); }
							if (!($move_QUERY->execute())) { logger(__LINE__, "SQLi execute: $move_QUERY->error"); }
						}
				}
			logger(__LINE__, "Phase completed scan completed, cleaning up.");
			$completed_QUERY->free_result();
		
		// Update and find lost patients match to max(symptom.phase)
			logger(__LINE__, "Phase lost patient scan started.");
			logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
			
			if (!($completed_QUERY = $dblink->prepare("SELECT
														patient.patient_id,
															(SELECT
																MAX(symptom.phase)
															FROM
																symptom
															WHERE
																symptom.code = patient.code) AS re_phase
													FROM
														patient
													WHERE
														(patient.phase IS NULL);"))) { logger(__LINE__, "SQLi Prepare: $completed_QUERY->error"); }
			if (!($completed_QUERY->execute())) { logger(__LINE__, "SQLi execute: $completed_QUERY->error"); }
			if (!($completed_QUERY->bind_result($patient_id, $new_phase))) { logger(__LINE__, "SQL rBind: $completed_QUERY->error"); }
			$completed_QUERY->store_result();
			if ($completed_QUERY->num_rows() > 0)
				{
					while ($completed_QUERY->fetch())
						{
							logger(__LINE__, "  >> Moving $patient_id to Phase $new_phase.");
							if (!($move_QUERY = $dblink->prepare("UPDATE patient 
																SET 
																	phase = ?
																WHERE
																	(patient_id = ?)"))) { logger(__LINE__, "SQLi Prepare: $move_QUERY->error"); }
							if (!($move_QUERY->bind_param('ss', $new_phase, $patient_id))) { logger(__LINE__, "SQLi pBind: $move_QUERY->error"); }
							if (!($move_QUERY->execute())) { logger(__LINE__, "SQLi execute: $move_QUERY->error"); }
						}
				}
			logger(__LINE__, "Phase lost patient scan completed, cleaning up.");
			$completed_QUERY->free_result();

		
		// End of loop
			logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
		}
	
logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
logger(__LINE__, " ====> End of File <====");
?>