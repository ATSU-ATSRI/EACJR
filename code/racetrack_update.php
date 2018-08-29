<?php
$rule_1 = "Disallow:harming humans";
$rule_2 = "Disallow:ignoring human orders";
$rule_3 = "Disallow:harm to self";
if (($rule_1 != TRUE) || ($rule_2 != TRUE) || ($rule_3 != TRUE)) {echo "Protect! Obey! Survive!\n"; die;}
date_default_timezone_set('America/Chicago'); 

	require('logger.php');
		set_error_handler("recordError");
		$start_memory = memory_get_usage();
		logger(__LINE__, "===== Start of Log. =====");
			
	require('datacon.php');
	
	if (!($studys_QUERY = $dblink->prepare("SELECT 
												studys.study_id
											FROM
												studys
											WHERE
												(CURDATE() BETWEEN `date_start` AND `date_end`);"))) { logger(__LINE__, "SQLi Prepare: $dblink->error"); }
	if (!($studys_QUERY->execute())) { logger(__LINE__, "SQLi execute: $studys_QUERY->error"); }
	if (!($studys_QUERY->bind_result($study_id))) { logger(__LINE__, "SQLi rBind: $studys_QUERY->error"); }
	$studys_QUERY->store_result();
	if ($studys_QUERY->num_rows() > 0)
		{
			while ($studys_QUERY->fetch())
				{
					if (!($race_QUERY = $dblink->prepare("SELECT 
															`logins`.`user_id` AS `kid`, 
															(
																(
																	(
																		SELECT
																			COUNT(`patient`.`code`)
																		FROM
																			`patient`
																		WHERE
																			`patient`.`study_id` = ?
																	)
																	+
																	(
																		SELECT 
																			COUNT(`patient`.`code`)
																		FROM
																			`patient`
																		WHERE
																			(`patient`.`study_id` = ?)
																			AND (`patient`.`phase` > '1')
																	)
																)
																-
																(
																	SELECT 
																		COUNT(`patient`.`code`)
																	FROM
																		`patient`
																	WHERE
																		(`patient`.`study_id` = ?)
																		AND (`patient`.`phase` = '0')
																		AND (`patient`.`code` NOT IN 
																				(
																					SELECT 
																						`patient`.`code`
																					FROM
																						`review`
																						INNER JOIN `symptom` ON `review`.`event_id`=`symptom`.`event_id`
																						INNER JOIN `patient` ON `symptom`.`code`=`patient`.`code`
																					WHERE
																						`patient`.`study_id` = ?
																				)
																			) 
																)
															) AS `pttotal`, 
															(
																SELECT 
																	COUNT(DISTINCT `patient`.`code`)
																FROM 
																	`patient` 
																	INNER JOIN `symptom` ON `patient`.`code`=`symptom`.`code` 
																	INNER JOIN `review` ON `symptom`.`event_id`=`review`.`event_id` 
																WHERE 
																	(`patient`.`study_id` = ?) 
																	AND (`patient`.`phase` > '-1') 
																	AND (`review`.`user_id` = kid)
															) AS `rvtotal` 
														FROM 
															`logins` 
														WHERE 
															FIND_IN_SET(?,`logins`.`study`) 
														GROUP BY 
															`logins`.`user_id`;")))  { logger(__LINE__, "SQLi Prepare error: $dblink->error"); }
					if (!($race_QUERY->bind_param('ssssss', $study_id, $study_id, $study_id, $study_id, $study_id, $study_id))) { logger(__LINE__, "SQLi pBind error: $race_QUERY->error"); }
					if (!($race_QUERY->execute())) { logger(__LINE__, "SQLi execute error: $race_QUERY->error"); }
					if (!($race_QUERY->bind_result($race_user_id, $race_pttotal, $race_rvtotal))) { logger(__LINE__, "SQLi rBind error: $race_QUERY->error"); }
					$race_QUERY->store_result();
					if ($race_QUERY->num_rows() > 0)
						{
							while ($race_QUERY->fetch())
								{
									if (!($update_QUERY = $dblink->prepare("INSERT INTO studys_stats 
																				(
																					user_id,
																					study_id,
																					pttotal,
																					rvtotal
																				)
																			VALUES
																				(
																					?, 
																					?, 
																					?, 
																					? 
																				)
																		ON DUPLICATE KEY 
																		UPDATE 
																			user_id = ?, 
																			study_id = ?, 
																			pttotal = ?, 
																			rvtotal = ?;"))) { logger(__LINE__, "SQLi prepare error: $dblink->error"); }
									if (!($update_QUERY->bind_param('ssssssss', $race_user_id, $study_id, $race_pttotal, $race_rvtotal, $race_user_id, $study_id, $race_pttotal, $race_rvtotal))) { logger(__LINE__, "SQLi pBind error: $update_QUERY->error"); }
									if (!($update_QUERY->execute())) { logger(__LINE__, "SQLi execute error: $update_QUERY->error"); }
									$update_QUERY->free_result();
								}
						}
					$race_QUERY->free_result();
				}
		}
		$studys_QUERY->free_result();
		logger(__LINE__, "===== End of Log. =====");
?>