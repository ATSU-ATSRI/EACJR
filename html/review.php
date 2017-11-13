<?php
ob_start();
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include_once("datacon.php");
	include('menu_item.php');
	
	$patient_id = $_REQUEST['req'];
	
	if (!($events_QUERY = $dblink->prepare("
			SELECT 
				symptom.`phase`,
				patient.`code`,
				patient.age,
				patient.sex,
				patient.ethnicity,
				patient.race,
				patient.race_other,
				symptom.event_id,
				symptom.symptom,
				symptom.pt_baseline,
				symptom.pt_baseline_severity,
				symptom.pt_24hr,
				symptom.pt_24hr_severity,
				symptom.pt_24hr_related,
				symptom.pt_24hr_details,
				symptom.pt_72hr,
				symptom.pt_72hr_severity,
				symptom.pt_72hr_related,
				symptom.pt_72hr_details,
				symptom.pt_1wk,
				symptom.pt_1wk_details,
				symptom.followup_clinic,
				symptom.followup_clinic_related,
				symptom.followup_clinic_details,
				symptom.followup_uc,
				symptom.followup_uc_related,
				symptom.followup_uc_details,
				symptom.followup_er,
				symptom.followup_er_related,
				symptom.followup_er_details,
				symptom.followup_hosp,
				symptom.followup_hosp_related,
				symptom.followup_hosp_details,
				symptom.further,
				symptom.further_why,
				symptom.future,
				symptom.future_why,
				review.review_id,
				review.user_id,
				review.pt_24hr_change,
				review.pt_72hr_change,
				review.adverse_event_change,
				review.ae_change,
				review.omt_related,
				review.`comment`
			FROM jury_room.symptom LEFT OUTER JOIN
				patient ON symptom.code = patient.code LEFT OUTER JOIN
				review ON symptom.event_id = review.event_id
			WHERE (patient_id = ?)
			ORDER BY phase, symptom.event_id
			"))) { logger("SQLi Prepare: $events_QUERY->error"); }
	if (!($events_QUERY->bind_param('s', $patient_id)))  { logger("SQLi Prepare: $events_QUERY->error"); }
	if (!($events_QUERY->execute())) { logger("SQLi execute: $events_QUERY->error"); }
	if (!($events_QUERY->bind_result($phase, $code, $age, $sex, $ethnicity, $race, $race_other, $event_id, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk, $pt_1wk_details, $followup_clinic, $followup_clinic_related, $followup_clinic_details, $followup_uc, $followup_uc_related, $followup_uc_details, $followup_er, $followup_er_related, $followup_er_details, $followup_hosp, $followup_hosp_related, $followup_hosp_details, $further, $further_why, $future, $future_why, $review_id, $user_id, $pt_24hr_change, $pt_72_hr_change, $adverse_event_change, $severity_change, $omt_related, $comment))) { logger("SQLi rBind: $events_QUERY->error"); }
	$events_QUERY->store_result();
	

	$severity_array = array("Not present", "Mild", "Moderate", "Severe", "Very Severe");
	$severity_time_array = array("Not present", "baseline", "24hr", "72hr", "1_wk");
	
	$event_id_array = array();
	
		echo "
		<div class=\"main\">
		<center>
		<span class=\"centre-box\">
			<form name=\"review_pt\" action=\"\" method=\"POST\">
				<TABLE>";
					
				$pg_len = 0;
				$pt_comment_text = "";
				while ($events_QUERY->fetch())
				{
					if (($pg_len > 60) || ($pg_len == 0))
						{
							echo "	<TR>
								<TH>Participant: <b> $code </b></TH>
								<TH> Age: <b> $age </b></TH>
								<TH> Sex: <b> $sex </b></TH>
								<TH> Ethnicity: <b> $ethnicity </b></TH>
								<TH> Race: <b>";
								if (strlen($race_other) > 0) {$race_other;} else {$race;}
								echo " </b></TH>
							<TR>
								<TH COLSPAN=\"9\"> &nbsp; </TH>
							</TR><TR>
								<TH width=\"17%\"> Symptom </TH>
								<TH width=\"5%\"> Survey </TH>
								<TH width=\"12%\"> Baseline Severity </TH>
								<TH width=\"12%\"> 24 hr Severity </TH>
								<TH width=\"12%\"> 72 hr Severity </TH>
								<TH width=\"12%\"> 1 Week Severity </TH>
								<TH width=\"10%\"> Adverse Event? </TH>
								<TH width=\"10%\"> If Adverse Event: Severity? </TH>
								<TH width=\"10%\"> If Adverse Event: OMT Related? </TH>
							</TR><TR>";
							$pg_len = 1;
						}
					
					if (strlen($symptom) > 0)
						{
							$event_id_array[] = $event_id;
							
							echo "
									<!--- NEW SYMPTOM STARTS HERE --->
									<TD> $symptom </TD>
									<input type=\"hidden\" name=\"$event_id-event_id\" value=\"$event_id\">
									<input type=\"hidden\" name=\"$event_id-code\" value=\"$code\">";

							if (strlen($pt_24hr) > 0)
								{
									echo "<TD> 24 hr </TD>
									";
								}
								elseif (strlen($pt_72hr) > 0)
								{
									echo "<TD> 72 hr </TD>
									";
								}
								
							echo "	<TD> $pt_baseline_severity </TD>
									<TD> $pt_24hr_severity <br /><br />";
											if (strlen($pt_24hr_related) > 0)
											{echo "
											<b>Pt. Report OMT Related? </b> &nbsp; &nbsp; &nbsp; $pt_24hr_related <br /><br />
											<INPUT type=\"hidden\" name=\"$event_id-pt_24hr_related\" id=\"$event_id-pt_24hr_related\" value=\"$pt_24hr_related\">";}
											echo "</TD>
									<TD> $pt_72hr_severity <br /><br />";
											if (strlen($pt_72hr_related) > 0)
											{echo "
											<b>Pt. Report OMT Related? </b> &nbsp; &nbsp; &nbsp; $pt_72hr_related <br /><br />
											<INPUT type=\"hidden\" name=\"$event_id-pt_72hr_related\" id=\"$event_id-pt_72hr_related\" value=\"$pt_72hr_related\">";}
											echo "
											</TD>
									<TD> $pt_1wk </TD>";
							
							echo "
								<TD>";
									
									$change_array = array(
													"baseline" => array_search("$pt_baseline_severity", $severity_array, TRUE),
													"24hr" => array_search("$pt_24hr_severity", $severity_array, TRUE),
													"72hr" => array_search("$pt_72hr_severity", $severity_array, TRUE),
													"1_wk" => array_search("$pt_1wk", $severity_array, TRUE));
													
																										
										if (isset($adverse_event_change)) {unset($adverse_event_change);}
										if (($change_array['baseline'] < $change_array['24hr']) || ($change_array['baseline'] < $change_array['72hr']) || ($change_array['baseline'] < $change_array['1_wk']) ||
											($change_array['24hr'] < $change_array['72hr']) || ($change_array['24hr'] < $change_array['1_wk']) ||
											($change_array['72hr'] < $change_array['1_wk']))
											{
												echo "Yes<br />";
												$adverse_event_related = "Yes";
											}
											else
											{
												echo "No<br />";
												$adverse_event_related = "No";
											}
										echo "	<INPUT type=\"hidden\" name=\"$event_id-adverse_event\" id=\"$event_id-adverse_event\" value=\"$adverse_event_related\">
												<INPUT type=\"checkbox\" name=\"$event_id-adverse_event_change\" id=\"$event_id-adverse_event_change\" value=\"NOCHANGE\"> Change?
												</TD>";
									
							echo "<TD>";
								//here for reference.
								//$severity_array = array("Not present", "Mild", "Moderate", "Severe", "Very Severe");
								//$severity_time_array = array("Not present", "baseline", "24hr", "72hr", "1_wk");

									$change_array = array(
											"baseline" => array_search("$pt_baseline_severity", $severity_array, TRUE),
											"24hr" => array_search("$pt_24hr_severity", $severity_array, TRUE),
											"72hr" => array_search("$pt_72hr_severity", $severity_array, TRUE),
											"1_wk" => array_search("$pt_1wk", $severity_array, TRUE));
										
										arsort($change_array);
										$lowest = end($change_array);
										$lowest_time = array_search(key($change_array), $severity_time_array, TRUE);
										asort($change_array);
										$highest = end($change_array);
										$highest_time = array_search(key($change_array), $severity_time_array, TRUE);
										if (isset($ae_related)) {unset($ae_related);}
										
										//echo "$lowest - $lowest_time <br /> $highest - $highest_time<br />";
										//NOTE: I don't like how this tracks. We need a better method.
											
											if ($highest - $lowest > 3)
												{
													echo "Large";
													$ae_related = "Large";
												} 
												elseif ($highest - $lowest > 1)
												{
													echo "Moderate";
													$ae_related = "Moderate";
												}
												elseif ($highest - $lowest > 0)
												{
													echo "Mild";
													$ae_related = "Mild";
												}
												else
												{
													echo "No";
													$ae_related = "No";
												}
											
										if ($highest_time > $lowest_time)
											{
												echo " Increase<br />";
												$ae_related .= " Increase";
											}
											elseif ($highest_time < $lowest_time)
											{
												echo " Decrease<br />";
												$ae_related .= " Decrease";
											}
											else
											{
												echo " Change<br />";
												$ae_related .= " Change";
											}
											
								
								echo "	<INPUT type=\"hidden\" name=\"$event_id-ae_related\" id=\"$event_id-ae_related\" value=\"$ae_related\">
										<INPUT type=\"checkbox\" name=\"$event_id-ae_change\" id=\"$event_id-ae_change\" value=\"NOCHANGE\"> Change?
										</TD>";
								
								echo "<TD>
										If Adverse Event: OMT Related?<br />
										<INPUT type=\"radio\" name=\"$event_id-omt_change\" id=\"$event_id-omt_change\" value=\"Definitely\"> Definitely<br />
										<INPUT type=\"radio\" name=\"$event_id-omt_change\" id=\"$event_id-omt_change\" value=\"Probably\"> Probably<br />
										<INPUT type=\"radio\" name=\"$event_id-omt_change\" id=\"$event_id-omt_change\" value=\"Not Sure\"> Not Sure<br />
										<INPUT type=\"radio\" name=\"$event_id-omt_change\" id=\"$event_id-omt_change\" value=\"Unlikely\"> Unlikely<br />
										<INPUT type=\"radio\" name=\"$event_id-omt_change\" id=\"$event_id-omt_change\" value=\"No\"> No<br />
										</TD>
									</TR>";
						}
						else
						{
							if (($followup_clinic == "Yes") || (strlen($followup_clinic_related) > 0) || (strlen($followup_clinic_details) > 0))
								{
									echo "<TR>
											<TD colspan=\"5\"> Contacted Clinician (Office)? <b>$followup_clinic</b><br /> $followup_clinic_details </TD>
											<TD> $followup_clinic_related </TD>";
								}
							
							if (($followup_uc == "Yes") || (strlen($followup_uc_related) > 0) || (strlen($followup_uc_details) > 0))
								{
									echo "<TR>
											<TD colspan=\"5\"> Contacted Urgent Care? <b>$followup_uc</b><br />$followup_uc_details </TD>
											<TD> $followup_uc_related </TD>";
								}
							
							if (($followup_er == "Yes") || (strlen($followup_er_related) > 0) || (strlen($followup_er_details) > 0))
								{
									echo "<TR>
											<TD colspan=\"5\"> Contacted Emergency Room? <b>$followup_er</b><br />$followup_er_details </TD>
											<TD>$followup_er_related</TD>";
								}
							if (($followup_hosp == "Yes") || (strlen($followup_hosp_related) > 0) || (strlen($followup_hosp_details) > 0))
								{
									echo "<TR>
											<TD colspan=\5\"> Contacted Hospital? <b>$followup_hosp</b><br />$followup_hosp_details </TD>
											<TD>$followup_hosp_related</TD>";
								}
								
							if ((strlen($pt_24hr_details) > 0) || (strlen($pt_72hr_details) > 0) || (strlen($pt_1wk_details) > 0))
								{
									echo "<TR>
											<TD> <b> Pt. Comments </b> </TD>";
										
									if (strlen($pt_24hr_details) > 0)
										{
											echo " 	<TD> 24 hr </TD>
													<TD colspan=\"7\"> $pt_24hr_details </TD>";
											$pt_comment_text .= "<b> 24 hr:</b> $pt_24hr_details <br /><br />";
										}
										
									if (strlen($pt_72hr_details) > 0)
										{
											echo "	<TD> 72 hr </TD>
													<TD colspan=\"7\"> $pt_72hr_details </TD>";
											$pt_comment_text .= "<b> 72 hr:</b> $pt_72hr_details <br /><br />";
										}
										
									if (strlen($pt_1wk_details) > 0)
										{
											echo "	<TD> 1 wk </TD>
													<TD colspan=\"7\"> $pt_1wk_details </TD>";
											$pt_comment_text .= "<b> 1 wk: </b> $pt_1wk_details <br /><br />";
										}
								}

							if ((substr($followup_clinic, 0, 3) == "Yes") || (substr($followup_uc, 0, 3) == "Yes") || (substr($followup_er, 0, 3) == "Yes") || (substr($followup_hosp, 0, 3) == "Yes"))	
								{
									echo "<TD>";
									
									$change_array = array(
													"baseline" => array_search("$pt_baseline_severity", $severity_array, TRUE),
													"24hr" => array_search("$pt_24hr_severity", $severity_array, TRUE),
													"72hr" => array_search("$pt_72hr_severity", $severity_array, TRUE),
													"1_wk" => array_search("$pt_1wk", $severity_array, TRUE));
									if (isset($ae_related)) { unset($ae_related);}				
																										
										if (isset($ae_change)) { unset($ae_change); }
										if (($change_array['baseline'] < $change_array['24hr']) || ($change_array['baseline'] < $change_array['72hr']) || ($change_array['baseline'] < $change_array['1_wk']) ||
											($change_array['24hr'] < $change_array['72hr']) || ($change_array['24hr'] < $change_array['1_wk']) ||
											($change_array['72hr'] < $change_array['1_wk']))
											{
												echo "Yes<br />";
												$ae_related = "Yes";
											}
											else
											{
												echo "No<br />";
												$ae_related = "No";
											}
										echo "	<INPUT type=\"hidden\" name=\"$event_id-ae_related\" id=\"$event_id-ae_related\" value=\"$ae_related\">
												<INPUT type=\"checkbox\" name=\"$event_id-ae_change\" id=\"$event_id-ae_change\" value=\"\"> Change?
												</TD>";
									
									echo "<TD></TD>"; // we don't have severity change for followup visits so we don't need this block. If we change our minds, it used to be here.
										
										echo "<TD>
												If Adverse Event: OMT Related?<br />
												<INPUT type=\"radio\" name=\"$event_id-omt_change\" id=\"$event_id-omt_change\" value=\"Definitely\"> Definitely<br />
												<INPUT type=\"radio\" name=\"$event_id-omt_change\" id=\"$event_id-omt_change\" value=\"Probably\"> Probably<br />
												<INPUT type=\"radio\" name=\"$event_id-omt_change\" id=\"$event_id-omt_change\" value=\"Not Sure\"> Not Sure<br />
												<INPUT type=\"radio\" name=\"$event_id-omt_change\" id=\"$event_id-omt_change\" value=\"Unlikely\"> Unlikely<br />
												<INPUT type=\"radio\" name=\"$event_id-omt_change\" id=\"$event_id-omt_change\" value=\"No\"> No<br />
												</TD>
											</TR>";
								}
						}
						
						
						
					if ($phase > "1")
						{
							echo "<TR>
									<TD> EAC Comment<br /> $initals</TD>
									<TD colspan=\"8\"> $comment </TD>
									</TR>";
						}
						
					$pg_len++;
				}
				
					echo "
					<TR>
						<TD> Your Comments: </TD>
						<TD colspan=\"8\"> <textarea name=\"comments\" cols=\"70\" rows=\"4\" wrap=\"physical\"></textarea></TD>
					</TR><TR>
						<TD colspan=\"9\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <INPUT type=\"reset\" name=\"reset\" value=\"Reset Form\">
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
						<INPUT type=\"submit\" name=\"submit\" value=\"Submit Vote\"></TD>
					</TR>
				</TABLE>
			</form>
		</span>
	</center>";
	
	if (isset($_POST['submit']))
		{
			if (count($event_id_array) > 0)
				{
					foreach($event_id_array as $e_id)
						{	
							if (isset($pt_24hr_change)) { unset($pt_24hr_change); }
							if (isset($pt_72hr_change)) { unset($pt_72hr_change); }
							if (isset($adverse_event)) { unset($adverse_event); }
							if (isset($ae_change)) { unset($ae_change); }
							if (isset($omt_related)) { unset($omt_related); }
						
							if (isset($_POST["$e_id-pt_24hr_change"]))
								{
									$pt_24hr_change = "Change";
								}
								else
								{
									if (isset($_POST["$e_id-pt_24hr_related"])) { $pt_24hr_change = $_POST["$e_id-pt_24hr_related"]; }
								}
							 
							if (isset($_POST["$e_id-pt_72hr_change"]))
								{
									$pt_72hr_change = "Change";
								}
								else
								{
									if (isset($_POST["$e_id-pt_72hr_related"])) { $pt_72hr_change = $_POST["$e_id-pt_72hr_related"]; }
								}
							
							if (isset($_POST["$e_id-adverse_event_change"]))
								{
									$adverse_event = "Change";
								}
								else
								{
									if (isset($_POST["$e_id-adverse_event"])) { $adverse_event = $_POST["$e_id-adverse_event"]; }
								}

							if (isset($_POST["$e_id-ae_change"]))
								{
									$ae_change = "Change";
								}
								else
								{
									if (isset($_POST["$e_id-ae_related"])) { $ae_change = $_POST["$e_id-ae_related"]; }
								}
								
							if (isset($_POST["$e_id-omt_change"]))
								{
									if (isset($_POST["$e_id-omt_change"])) { $omt_change = $_POST["$e_id-omt_change"]; }
								}
													
							if (!($vote_QUERY = $dblink->prepare("INSERT INTO jury_room.review (user_id, event_id, pt_24hr_change, pt_72hr_change, adverse_event_change, ae_change, omt_related) VALUES(?, ?, ?, ?, ?, ?, ?);"))) {logger("SQLi Prepare: $vote_QUERY->error");}
							if (!($vote_QUERY->bind_param('sssssss', $_SESSION['id'], $e_id, $pt_24hr_change, $pt_72hr_change, $adverse_event, $ae_change, $omt_chamge))) { logger("SQLi Bind Error: $vote_QUERY->error"); }
							if (!($vote_QUERY->execute())) { logger("SQLi execute: $vote_QUERY->error"); }
							$vote_QUERY->close();
							if (isset($pt_24hr_change)) { unset($pt_24hr_change); }
							if (isset($pt_72hr_change)) { unset($pt_72hr_change); }
							if (isset($adverse_event_change)) { unset($adverse_event_change); }
							if (isset($ae_change)) { unset($ae_change); }
							if (isset($omt_related)) { unset($omt_related); }
						}
					$_SESSION['pass_fail'] = "Vote Recorded.";
					$dblink->close();
					$_SESSION['redirect'] = "main.php";
					header('Location: pause.php');
				}
		}
		
	if (strlen($pt_comment_text) > 0)
		{
			echo "	<span id=\"pt-comments\" class=\"comment-text\"><center><b> .: Patient Comments :.</b></center> <br /><br />$pt_comment_text<br /><br /><a href=\"javascript:void(0)\" onclick=\"document.getElementById('pt-comments').style.display='none';document.getElementById('pt-comments-overlay').style.display='none'\">[ close ] </a></span>
					<span id=\"pt-comments-overlay\" class=\"comment-overlay\"></span>
				
					<script type=\"text/javascript\">
						window.onload=\"document.getElementById('pt-comments').style.display='block';document.getElementById('pt-comments-overlay').style.display='block'\";
					</script>";
		}
		
	include("footer.php");
}
ob_end_flush();
?>