<?php
include("datacon.php");
include("logger.php");
require("/usr/share/php/PHPMailer-master/PHPMailerAutoload.php");

logger(__LINE__, "=====> Start of email check. <=====");
if (!($study_QUERY = $dblink->prepare("SELECT `study_id`, `name` FROM `studys` WHERE (CURDATE() BETWEEN `date_start` AND `date_end`);"))) { logger(__LINE__, "SQLi Prepare: $study_QUERY->error"); }
if (!($study_QUERY->execute())) { logger(__LINE__, "SQLi execute: $study_QUERY->error"); }
if (!($study_QUERY->bind_result($study_id, $study_name))) { logger(__LINE__, "SQLi rBind: $study_QUERY->error"); }
$study_QUERY->store_result();
if ($study_QUERY->num_rows > 0)
	{
		while ($study_QUERY->fetch())
		{
			//Check for active users in this study_id
			if (!($user_QUERY = $dblink->prepare("SELECT `user_id`, `email`, `name` FROM `logins` WHERE (`study` = ?) AND (`rank` > 0);"))) { logger(__LINE__, "SQLi prepare: $user_QUERY->error"); }
			if (!($user_QUERY->bind_param('s', $study_id))) { logger(__LINE__, "SQLi pBind: $user_QUERY->error"); }
			if (!($user_QUERY->execute())) { logger(__LINE__, "SQLi execute: $user_QUERY->error"); }
			if (!($user_QUERY->bind_result($user_id, $user_email, $user_name))) { logger(__LINE__, "SQLi rBind: $user_QUERY->error"); }
			$user_QUERY->store_result();
			if ($user_QUERY->num_rows > 0)
			{
				while ($user_QUERY->fetch())
					{
						//Check if this user_is has items to review
						if (!($events_QUERY = $dblink->prepare("
									SELECT
										patient.patient_id,
										patient.code,
										patient.phase,
										COUNT(
											CASE WHEN symptom.symptom IS NOT NULL THEN 1
										END
									) AS symptom_count,
									COUNT(
										CASE WHEN(
											(symptom.phase = patient.phase) AND(
												review.event_id = symptom.event_id
											)
										) THEN 1
									END
									) AS review_count
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
											(patient.study_id IN(?)) AND(
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
												)
											) AND(patient.phase > '0')
										)
									GROUP BY
										patient.code
									ORDER BY
										patient.phase
									DESC
										,
										patient.patient_id ASC;"))) { logger(__LINE__, "SQLi Prepare: $events_QUERY->error"); }
								if (!($events_QUERY->bind_param('ss', $study_id, $user_id))) { logger(__LINE__, "SQLi pBind: $events_QUERY->error"); }
								if (!($events_QUERY->execute())) { logger(__LINE__, "SQLi execute: $events_QUERY->error"); }
								if (!($events_QUERY->bind_result($patient_id, $code, $phase, $symptom_count, $review_count))) { logger(__LINE__, "SQLi rBind: $events_QUERY->error"); }
								$events_QUERY->store_result();
								$events_num = $events_QUERY->num_rows;
								
								if ($events_num > 0)
									{
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
										//$mail->AddBCC($admin_name,$admin_email);
							
										$email_body = "
											Greetings, $user_name.<br />
											<br />
											You have $events_num records to review in the EAC Portal. <br />
											URL: http://rebrand.ly/eac2018/<br />
											<br />
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
										logger(__LINE__, "Email sent to: $user_name ($user_email) - with $events_num events!");
										if (isset($patient_id)) { unset($patient_id); }
										if (isset($code)) { unset($code); }
										if (isset($phase)) { unset($phase); }
										if (isset($symptom_count)) { unset($symptom_count); }
										if (isset($review_count)) { unset($review_count); }
									}
					}
			}
			if (isset($user_QUERY)) { unset($user_QUERY); }
		}
	}
	if (isset($study_QUERY)) { unset($study_QUERY); }
	logger(__LINE__, "=====> End of email check. <=====");
?>