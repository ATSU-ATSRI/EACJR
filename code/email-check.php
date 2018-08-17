<?php
include("datacon.php");
include("logger.php");
require("/usr/share/php/PHPMailer-master/PHPMailerAutoload.php");

$start_memory = memory_get_usage();
logger(__LINE__, "=====> Start of email check. <=====");
logger(__LINE__, "My timezone is: " . date_default_timezone_get());
	
if (!($study_QUERY = $dblink->prepare("SELECT `study_id`, `name`, `pi_name`, `pi_email` FROM `studys` WHERE (CURDATE() BETWEEN `date_start` AND `date_end`);"))) { logger(__LINE__, "SQLi Prepare: $study_QUERY->error"); }
if (!($study_QUERY->execute())) { logger(__LINE__, "SQLi execute: $study_QUERY->error"); }
if (!($study_QUERY->bind_result($study_id, $study_name, $pi_name, $pi_email))) { logger(__LINE__, "SQLi rBind: $study_QUERY->error"); }
$study_QUERY->store_result();
if ($study_QUERY->num_rows > 0)
	{
		while ($study_QUERY->fetch())
		{
			//Check for active users in this study_id
			if (!($user_QUERY = $dblink->prepare("SELECT `user_id`, `email`, `name` FROM `logins` WHERE (FIND_IN_SET(?, `study`)) AND (`rank` > 0);"))) { logger(__LINE__, "SQLi prepare: $user_QUERY->error"); }
			if (!($user_QUERY->bind_param('s', $study_id))) { logger(__LINE__, "SQLi pBind: $user_QUERY->error"); }
			if (!($user_QUERY->execute())) { logger(__LINE__, "SQLi execute: $user_QUERY->error"); }
			if (!($user_QUERY->bind_result($user_id, $user_email, $user_name))) { logger(__LINE__, "SQLi rBind: $user_QUERY->error"); }
			$user_QUERY->store_result();
			if ($user_QUERY->num_rows > 0)
			{
				while ($user_QUERY->fetch())
					{
						//grab phase counts
						if (!($phase_QUERY = $dblink->prepare("SELECT 
																   COUNT(DISTINCT `patient`.`code`), `patient`.`phase` 
																FROM 
																   `patient` 
																WHERE 
																	 (`study_id` = ?) 
																GROUP BY 
																	 `patient`.`phase`;")))  { logger(__LINE__, "SQLi Prepare: $dblink->error"); }
						if (!($phase_QUERY->bind_param('s', $study_id))) { logger(__LINE__, "SQLi pBind: $phase_QUERY->error"); }
						if (!($phase_QUERY->execute())) { logger(__LINE__, "SQLi execute: $phase_QUERY->error"); }
						if (!($phase_QUERY->bind_result($phase_count, $phase_number))) { logger(__LINE__, "SQLi rBind: $phase_QUERY->error"); }
						$phase_QUERY->store_result();
						
						if (!($userdone_QUERY = $dblink->prepare("SELECT
																	COUNT(DISTINCT `patient`.`patient_id`),
																	`patient`.`phase`
																FROM
																	`patient`
																	RIGHT JOIN `symptom` ON `patient`.`code`=`symptom`.`code`
																	
																WHERE
																	(`patient`.`study_id` = ?)
																	AND (`symptom`.`phase` > '0')
																	AND (concat(`review`.`event_id`,'-',`review`.`phase`) NOT IN(
																			SELECT
																				concat(`symptom`.`event_id`,'-',`symptom`.`phase`)
																			FROM 
																				`review`
																				INNER JOIN `symptom` ON `review`.`event_id`=`symptom`.`event_id`
																			WHERE
																				(`symptom`.`phase` > '0')
																				AND (`review`.`user_id` = ?)
																			)
																		 )
																GROUP BY
																	`patient`.`phase`;"))) { logger(__LINE__, "SQLi Prepare: $dblink->error"); }
						if (!($userdone_QUERY->bind_param('ss',$study_id, $user_id))) { logger(__LINE__, "SQLi pBind: $userdone_QUERY->error"); }
						if (!($userdone_QUERY->execute())) { logger(__LINE__, "SQLi execute: $userdone_QUERY->error"); }
						if (!($userdone_QUERY->bind_result($userdone_count, $userdone_phase))) { logger(__LINE__, "SQLi rBind: $userdone_QUERY->error"); }
						$userdone_QUERY->store_result();
						
						if (isset($phase_response)) { unset($phase_response); }
						if (isset($phase_array)) { unset($phase_array); }
						$phase_array = array();
						$phase_response = "The $study_name study has the following status.<br />";
						while ($phase_QUERY->fetch())
							{
								$phase_response .= "Phase $phase_number has $phase_count records.<br />";
								$phase_array[$phase_number] = $phase_count;
							}
						
						if (isset($user_array)) { unset($user_array); }
						$user_array = array();
						while ($userdone_QUERY->fetch())
							{
								$user_array[$userdone_phase] = $userdone_count;
							}
						if (isset($userdone_phase)) { unset($userdone_phase); }
						if (isset($userdone_count)) { unset($userdone_count); }
							
						// build the counts to go by phase
						if (!($check_QUERY = $dblink->prepare("SELECT COUNT(DISTINCT `patient`.`patient_id`) FROM `patient` RIGHT JOIN `symptom` ON `patient`.`code`=`symptom`.`code` RIGHT JOIN `review` ON `symptom`.`event_id`=`review`.`event_id` WHERE (`patient`.`study_id` = ?) AND (`review`.`user_id` = ?)"))) { logger(__LINE__, "SQLi Prepare: $dblink->error"); }
						if (!($check_QUERY->bind_param('ss',$study_id, $user_id))) { logger(__LINE__, "SQLi pBind error: $check_QUERY->error"); }
						if (!($check_QUERY->execute())) { logger(__LINE__, "SQLi execute error: $check_QUERY->error"); }
						if (!($check_QUERY->bind_result($check_count))) { logger(__LINE__, "SQLi rBind error: $check_QUERY->error"); }
						$check_QUERY->store_result();
						$check_QUERY->fetch();
												
						if (isset($review_togo)) { unset($review_togo); }
						$review_togo = "Currently; ";
						if ($check_count > 0)
							{
								foreach($phase_array AS $p => $c)
									{
										if ($p > 0)
											{
												$review_togo .= "You have $user_array[$p] records in phase $p to review. ";
											}
											else
											{
												$review_togo .= "There are ";
												if ($phase_array[0] > 0)
													{
														$review_togo .= "$c";
													} 
													else 
													{ 
														$review_togo .= "no";
													} 
												$review_togo .= " records resolved. ";
											}
										if (isset($x)) { unset($x); }
									}
							}
							else
							{
								$review_togo = "You have not reviewed any records.";
							}
							
						$review_togo .= "<br /><br />Don't forget the portal's URL is $host_url.<br />";
						if (isset($phase_array)) { unset($phase_array); }
						if (isset($user_array)) { unset($user_array); }
						if (isset($c)) { unset($c); }
						if (isset($p)) { unset($p); }
						if (isset($x)) { unset($x); }
						
						
						//Check times items reviewed
						if (!($events_QUERY = $dblink->prepare("
															SELECT
																`review`.`user_id` AS 'kid',
																`logins`.`name`,
																MAX(`login_history`.`login`) AS 'last_seen',
																(
																	SELECT
																		COUNT(DISTINCT `patient`.`code`)
																	FROM
																		`review`
																	INNER JOIN `symptom` ON `review`.`event_id` = `symptom`.`event_id`
																	INNER JOIN `patient` ON `symptom`.`code` = `patient`.`code`
																	WHERE
																		(`patient`.`study_id` = ?) 
																		AND (`review`.`user_id` = kid)
																) AS 'pt_reviewed',
																  (
																	SELECT
																		COUNT(DISTINCT `review`.`event_id`)
																	FROM
																		`review`
																	INNER JOIN `symptom` ON `review`.`event_id` = `symptom`.`event_id`
																	INNER JOIN `patient` ON `symptom`.`code` = `patient`.`code`
																	WHERE
																		(`patient`.`study_id` = ?) 
																		AND (`review`.`user_id` = kid)
																) AS 'events_reviewed',
																(SELECT
																	COUNT(`login_history`.`id`)
																 FROM
																	`login_history`
																 WHERE
																	(`login_history`.`id` = kid)
																 ) AS 'number of logins',
																AVG(q.review_time) AS avg_review_time
															FROM
																`review`
																INNER JOIN `symptom` ON `review`.`event_id` = `symptom`.`event_id`
																INNER JOIN `logins` ON `review`.`user_id` = `logins`.`user_id`
																INNER JOIN `login_history` ON `logins`.`user_id` = `login_history`.`id`
																LEFT JOIN (
																	SELECT
																		`review`.`user_id`,
																		(
																			TIMESTAMPDIFF(
																				SECOND,
																				MIN(TIME(`review`.`action_date`)),
																				MAX(TIME(`review`.`action_date`))
																			) / (
																			COUNT(DISTINCT(`review`.`action_date`)) -1
																			)
																		) AS review_time
																	FROM
																		`review`
																	GROUP BY
																		`review`.`user_id`,
																		DATE(`review`.`action_date`)
																) AS `q` ON `review`.`user_id` = `q`.`user_id`
															WHERE
																(`symptom`.`study_id` = ?)
																AND (`review`.`user_id` = ?)
															GROUP BY
																kid
															ORDER BY
																`logins`.`name`;"))) { logger(__LINE__, "SQLi Prepare: $events_QUERY->error"); }
								if (!($events_QUERY->bind_param('ssss', $study_id, $study_id, $study_id, $user_id))) { logger(__LINE__, "SQLi pBind: $events_QUERY->error"); }
								if (!($events_QUERY->execute())) { logger(__LINE__, "SQLi execute: $events_QUERY->error"); }
								if (!($events_QUERY->bind_result($kid, $name, $last_seen, $review_count, $symptom_count, $login_count, $avg_time))) { logger(__LINE__, "SQLi rBind: $events_QUERY->error"); }
								$events_QUERY->store_result();
								$events_num = $events_QUERY->num_rows;
								
								if ($events_num > 0)
									{
										$phase_QUERY->fetch();
										$events_QUERY->fetch();
									}
									else
									{
										if (isset($kid)) { unset($kid); }
										if (isset($name)) { unset($name); }
										if (isset($review_count)) { unset($review_count); }
										if (isset($symptom_count)) { unset($symptom_count); }
										if (isset($avg_time)) { unset($avg_time); }
										if (isset($last_seen)) { unset($last_seen); }
										if (isset($login_count)) { unset($login_count); }
									}
								
								if ($login_count > 0)
									{
										$logins_msg = "Our records show that you have logged in $login_count times, and were last online, $last_seen (UTC).<br />";
										if ($events_num > 0)
											{
												$avg_time = sprintf("%02d", floor($avg_time / 3600)) . ":" . sprintf("%02d", floor(($avg_time / 60) % 60)) . "." . sprintf("%02d", $avg_time % 60) ." (H:m.s)";
												$events_msg = "You have reviewed $symptom_count events across $review_count records with an average review time per record of $avg_time.";
											}
									}
									else
									{
										$logins_msg = "Our records do not show that you have logged in. If you are experiencing a problem with the portal, please contact $pi_name via $pi_email.<br />";
									}
								if (isset($kid)) { unset($kid); }
								if (isset($name)) { unset($name); }
								if (isset($review_count)) { unset($review_count); }
								if (isset($symptom_count)) { unset($symptom_count); }
								if (isset($avg_time)) { unset($avg_time); }
								if (isset($last_seen)) { unset($last_seen); }
								if (isset($login_count)) { unset($login_count); }
								if (isset($events_num)) { unset($events_num); }
								$events_QUERY->free_result();
								
										//send email
										$mail = new PHPMailer();
										$mail->WordWrap = 50;
										$mail->IsHTML(true);
										$mail->Mailer = "smtp";
										$mail->Host = $mail_host;
										$mail->Username = $mail_username;
										$mail->Password = $mail_password;
										$mail->SMTPAuth = true;
										$mail->Prority = 1;
										$mail->Subject = "DO-Touch.NET EAC Portal Activity.";
										$mail->From = $mail_username;
										$mail->FromName = "DO-Touch.NET EAC";
										$mail->AddReplyTo($mail_username,$mail_username);
										$mail->AddAddress($user_email,$user_email);
										$mail->AddBCC($pi_name,$pi_email);
										$mail->AddBCC($mail_username,$mail_username);
							
										$email_body = "
											Greetings, $user_name.<br />
											<br />";
										
										if (isset($logins_msg)) { $email_body .= "$logins_msg<br />"; }
										if (isset($phase_response)) { $email_body .= "$phase_response<br />"; }
										if (isset($events_msg)) { $email_body .= "$events_msg<br />"; }
										if (isset($review_togo)) { $email_body .= "$review_togo<br />"; }
										
										$email_body .= "<br />
											Thank you for your participation, we hope you have a nice day,<br />
											~DO-Touch.NET<br />
											";
										$mail->Body = $email_body;
										$mail->AltBody = str_ireplace("<br />","\n",$email_body);
							
										if (!$mail->Send())
											{
												$mailerror = $mail->ErrorInfo;
												logger(__LINE__, "PHPMailer Error: $mailerror");
											}
											
										$mail->ClearAllRecipients();
										$mail->ClearReplyTos();
										logger(__LINE__, "Email sent to: $user_name ($user_email).");
										if (isset($patient_id)) { unset($patient_id); }
										if (isset($code)) { unset($code); }
										if (isset($phase)) { unset($phase); }
										if (isset($symptom_count)) { unset($symptom_count); }
										if (isset($review_count)) { unset($review_count); }
										if (isset($login_count)) { unset($login_count); }
										if (isset($last_seen)) { unset($last_seen); }
										if (isset($logins_msg)) { unset($logins_msg); }
										if (isset($phase_response)) { unset($phase_response); }
										if (isset($events_msg)) { unset($events_msg); }
										if (isset($review_togo)) { unset($review_togo); }
										if (isset($check_count)) { unset($check_count); }
										$check_QUERY->free_result();
										$userdone_QUERY->free_result();
										$phase_QUERY->free_result();
										
					}
			}
		}
		$user_QUERY->free_result();
		$study_QUERY->free_result();
		if (isset($study_QUERY)) { unset($study_QUERY); }
		if (isset($study_name)) { unset($study_name); }
		if (isset($pi_name)) { unset($pi_name); }
		if (isset($pi_email)) { unset($pi_email); }
	}
	logger(__LINE__, "=====> End of email check. <=====");
?>