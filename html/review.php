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
				symptom.future_why
			FROM jury_room.symptom LEFT OUTER JOIN
				patient ON symptom.code = patient.code
			WHERE (patient_id = ?) AND
            (
				(symptom NOT LIKE 'I have not had any%') OR
                (symptom IS NULL)
			)
			ORDER BY phase, symptom.event_id
			"))) { logger("SQLi Prepare: $events_QUERY->error"); }
	if (!($events_QUERY->bind_param('s', $patient_id)))  { logger("SQLi Prepare: $events_QUERY->error"); }
	if (!($events_QUERY->execute())) { logger("SQLi execute: $events_QUERY->error"); }
	if (!($events_QUERY->bind_result($phase, $code, $age, $sex, $ethnicity, $race, $race_other, $event_id, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk, $pt_1wk_details, $followup_clinic, $followup_clinic_related, $followup_clinic_details, $followup_uc, $followup_uc_related, $followup_uc_details, $followup_er, $followup_er_related, $followup_er_details, $followup_hosp, $followup_hosp_related, $followup_hosp_details, $further, $further_why, $future, $future_why))) { logger("SQLi rBind: $events_QUERY->error"); }
	$events_QUERY->store_result();
	
	$followup_vote = 0;
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
				$allow_comment = 0;
				while ($events_QUERY->fetch())
				{
					if ($pg_len == 0)
						{
							echo "<thead>";
							echo "	<TR>
								<TH width=\"20%\">Participant: <b> $code </b></TH>
								<TH width=\"11%\"> Age: <b> $age </b></TH>
								<TH width=\"11%\"> Sex: <b> $sex </b></TH>
								<TH width=\"11%\"> Ethnicity: <b> $ethnicity </b></TH>
								<TH width=\"11%\"> Race: <b>";
								if (strlen($race_other) > 0) {echo "$race_other";} else {echo "$race";}
								echo " </b></TH>
								<TH width=\"12%\"></TH>
								<TH width=\"12%\"></TH>
								<TH width=\"12%\"></TH>
							</TR>";
							echo "<TR>
								<TH width=\"20%\"> Symptom </TH>
								<TH width=\"11%\"> <a class=\"tooltip\" href=\"#\">Baseline Severity <span class=\"tooltip-data\">
									Worst severity in week prior to OMT from 24-hour or Mid-week survey
									<ul>
										<li>Very Severe</li>
										<li>Severe</li>
										<li>Moderate</li>
										<li>Mild</li>
										<li>Not Present (i.e., did not have)</li>
										<li>No Response or blank (i.e., did not respond)</li>
									</ul>
									</span></a> </TH>
								<TH width=\"11%\"> <a class=\"tooltip\" href=\"#\">24 hr Severity <span class=\"tooltip-data\">
									Worst severity since OMT
									<ul>
										<li>Very Severe</li>
										<li>Severe</li>
										<li>Moderate</li>
										<li>Mild</li>
										<li>Not Present (i.e., did not have)</li>
										<li>No Response or blank (i.e., did not respond)</li>
									</ul>
									</span></a></TH>
								<TH width=\"11%\"> <a class=\"tooltip\" href=\"#\">72 hr Severity <span class=\"tooltip-data\">
									Worst severity in past 2 days
									<ul>
										<li>Very Severe</li>
										<li>Severe</li>
										<li>Moderate</li>
										<li>Mild</li>
										<li>Not Present (i.e., did not have)</li>
										<li>No Response or blank (i.e., did not respond)</li>
									</ul>
									</span></a></TH>
								<TH width=\"11%\"> <a class=\"tooltip\" href=\"#\">1 Week Severity <span class=\"tooltip-data\">
									Worst severity on day 7
									<ul>
										<li>Very Severe</li>
										<li>Severe</li>
										<li>Moderate</li>
										<li>Mild</li>
										<li>Not Present (i.e., did not have)</li>
										<li>No Response or blank (i.e., did not respond)</li>
									</ul>
									</span></a></TH>
								<TH width=\"12%\"> <a class=\"tooltip\" href=\"#\">Adverse Event? <span class=\"tooltip-data\">Only symptoms with an increase in severity from baseline or no change from Very Severe baseline severity are included in report.<br />
									<ul>
										<li>No = Symptom was not an adverse event (i.e., symptom was not \"unfavorable and unintended\" or was not \"temporally associated with the use of a medical treatment or procedure that may or may not be considered related to the medical treatment or procedure.\" (NCI, 2006))</li>
										<li>Inconclusive = Could not determine whether symptom was an adverse event.</li>
									</ul>
									</span></a></TH>
								<TH width=\"12%\"> <a class=\"tooltip-left\" href=\"#\"> If Adverse Event: Intensity? <span class=\"tooltip-data\">
									Maximum change in severity from Baseline(calculated):
									<ul>
										<li>Major Increase (increase 3+ steps)</li>
										<li>Medium Increase (increase 2 steps)</li>
										<li>Minor Increase (increase 1 step)</li>
										<li>None (no change, Baseline severity = Very Severe)</li>
									</ul>
									</span></a> </TH>
								<TH width=\"12%\"> <a class=\"tooltip-left\" href=\"#\">If Adverse Event: OMT Related? <span class=\"tooltip-data\">
									<ul>
										<li>Definitely = The adverse event almost certainly resulted from OMT</li>
										<li>Probably = Adverse event is more likely than not to have resulted from OMT</li>
										<li>Not Sure = Adverse event is equally likely and unlikely to have resulted from OMT</li>
										<li>Unlikely = Adverse event is less likely than not to have resulted from OMT</li>
										<li>No = The adverse event almost certainly did not result from OMT</li>
									</ul>
									</span></a> </TH>
							</TR>
							</thead>
							<tbody>";
							$pg_len = 1;
						}
										
					if (strlen($symptom) > 0)
						{
							echo "
									<!--- NEW SYMPTOM STARTS HERE --->";
									
							$event_id_array[] = $event_id;
													
							// assign key value to severity
							$change_array = array(
								"baseline" => array_search("$pt_baseline_severity", $severity_array, TRUE),
								"24hr" => array_search("$pt_24hr_severity", $severity_array, TRUE),
								"72hr" => array_search("$pt_72hr_severity", $severity_array, TRUE),
								"1_wk" => array_search("$pt_1wk", $severity_array, TRUE));	
								
							// Set a background colour if NOT an AE
							if (($change_array['baseline'] < $change_array['24hr']) || ($change_array['24hr'] == 4) ||
								($change_array['baseline'] < $change_array['72hr']) || ($change_array['72hr'] == 4))
									{
										echo "
										<TR>";
									}
									else
									{
										echo "
										<TR style=\"background-color: WhiteSmoke\">";
									}
							
							echo "
									<TD width=\"20%\"> $symptom </TD>
									<input type=\"hidden\" name=\"$event_id-event_id\" value=\"$event_id\">
									<input type=\"hidden\" name=\"$event_id-code\" value=\"$code\">
									<TD width=\"11%\">";
								
									
							if (strlen($pt_baseline_severity) > 0)
								{
									 echo "$pt_baseline_severity";
								}
								else
								{
									echo "N/A";
								}

							echo "</TD>
									<TD width=\"11%\"> $pt_24hr_severity <br /><br />";
											if (strlen($pt_24hr_related) > 0)
											{
												echo "
													<b>Pt. Report OMT Related? </b> &nbsp; &nbsp; &nbsp; $pt_24hr_related <br /><br />
													<INPUT type=\"hidden\" name=\"$event_id-pt_24hr_related\" id=\"$event_id-pt_24hr_related\" value=\"$pt_24hr_related\">";
											}
											echo "</TD>
									<TD width=\"11%\"> $pt_72hr_severity <br /><br />";
											if (strlen($pt_72hr_related) > 0)
											{
												echo "
													<b>Pt. Report OMT Related? </b> &nbsp; &nbsp; &nbsp; $pt_72hr_related <br /><br />
													<INPUT type=\"hidden\" name=\"$event_id-pt_72hr_related\" id=\"$event_id-pt_72hr_related\" value=\"$pt_72hr_related\">";
											}
											echo "
											</TD>
									<TD width=\"11%\"> $pt_1wk </TD>";
							
							echo "
								<TD width=\"12%\">";
									$isae = 0;
									echo "<b>24 hr?</b> ";
									if (($change_array['baseline'] < $change_array['24hr']) || ($change_array['24hr'] == 4))
										{
											echo "<br /><INPUT type=\"radio\" name=\"$event_id-pt_24hr_isae\" id=\"$event_id-pt_24hr_isae\" value=\"Yes\" checked=\"checked\" />Yes.</INPUT><br />
													<b>Change to:</b><br />
													<INPUT type=\"radio\" name=\"$event_id-pt_24hr_isae\" id=\"$event_id-pt_24hr_isae\" value=\"No\">No</INPUT><br />
													<INPUT type=\"radio\" name=\"$event_id-pt_24hr_isae\" id=\"$event_id-pt_24hr_isae\" value=\"Inconclusive\">Inconclusive</INPUT><br />";
											$isae = 1;
										}
										else
										{
											echo "No.<br />
													<INPUT type=\"hidden\" name=\"$event_id-pt_24hr_isae\" id=\"$event_id-pt_24hr_isae\" value=\"No\" />";
										}
										
									echo "<b>72 hr?</b> ";
									if (($change_array['baseline'] < $change_array['72hr']) || ($change_array['72hr'] == 4))
										{
											echo "<br /><INPUT type=\"radio\" name=\"$event_id-pt_72hr_isae\" id=\"$event_id-pt_72hr_isae\" value=\"Yes\" checked=\"checked\" />Yes</INPUT><br />
													<b>Change to:</b><br />
													<INPUT type=\"radio\" name=\"$event_id-pt_72hr_isae\" id=\"$event_id-pt_72hr_isae\" value=\"No\">No</INPUT><br />
													<INPUT type=\"radio\" name=\"$event_id-pt_72hr_isae\" id=\"$event_id-pt_72hr_isae\" value=\"Inconclusive\">Inconclusive</INPUT><br />";
											$isae = 1;
											
										}
										else
										{
											echo "No.<br /> 
													<INPUT type=\"hidden\" name=\"$event_id-pt_72hr_isae\" id=\"$event_id-pt_72hr_isae\" value=\"No\" />";
										}

									echo "<b>1 week?</b>";
									if ((($change_array['baseline'] < $change_array['1_wk']) || ($change_array['1_wk'] == 4)) && ( $isae == 1 ))
										{
											echo "<br /><INPUT type=\"radio\" name=\"$event_id-pt_1_wk_isae\" id=\"$event_id-pt_1_wk_isae\" value=\"Yes\" checked=\"checked\" />Yes.</INPUT><br />
													<b>Change to:</b><br />
													<INPUT type=\"radio\" name=\"$event_id-pt_1_wk_isae\" id=\"$event_id-pt_1_wk_isae\" value=\"No\">No</INPUT><br />
													<INPUT type=\"radio\" name=\"$event_id-pt_1_wk_isae\" id=\"$event_id-pt_1_wk_isae\" value=\"Inconclusive\">Inconclusive</INPUT><br />";
											$isae = 1;
										}
										else
										{
											echo "No.<br /> 
													<INPUT type=\"hidden\" name=\"$event_id-pt_1_wk_isae\" id=\"$event_id-pt_1_wk_isae\" value=\"No\">";
										} 

										echo "</TD>";

									
							echo "<TD width=\"12%\">";
								//here for reference.
								//$severity_array = array("Not present", "Mild", "Moderate", "Severe", "Very Severe");
								//$severity_time_array = array("Not present", "baseline", "24hr", "72hr", "1_wk");

							if ($isae == 1)
								{
									if (array_search("$pt_baseline_severity", $severity_array, TRUE)) { $ca_base = array_search("$pt_baseline_severity", $severity_array, TRUE); } else { $ca_base = 0; }
									if (array_search("$pt_24hr_severity", $severity_array, TRUE)) { $ca_24hr = array_search("$pt_24hr_severity", $severity_array, TRUE); } else { $ca_24hr = 0; }
									if (array_search("$pt_72hr_severity", $severity_array, TRUE)) { $ca_72hr = array_search("$pt_72hr_severity", $severity_array, TRUE); } else { $ca_72hr = 0; }
									if (array_search("$pt_1wk", $severity_array, TRUE)) { $ca_1wk = array_search("$pt_1wk", $severity_array, TRUE); } else { $ca_1wk = 0; }
									
									$change_array = array(
											"baseline" => $ca_base,
											"24hr" => $ca_24hr,
											"72hr" => $ca_72hr,
											"1_wk" => $ca_1wk);
										
										// lowest is -always- the baseline value.
										$lowest = $change_array["baseline"];
										$lowest_time = 1;
										
										asort($change_array);
										$highest = end($change_array);
										$highest_time = array_search(key($change_array), $severity_time_array, TRUE);
										if (isset($ae_severity)) {unset($ae_severity);}

										// added an abs() to these because of using the baseline value as lowest (when it might not be actually LESS).
											if (abs($highest - $lowest > 2))
												{
													//echo "Major";
													$ae_severity = "Major";
												} 
												elseif (abs($highest - $lowest > 1))
												{
													//echo "Medium";
													$ae_severity = "Medium";
												}
												elseif (abs($highest - $lowest > 0))
												{
													//echo "Minor";
													$ae_severity = "Minor";
												}
												else
												{
													//echo "No";
													$ae_severity = "No";
												}
											
										if ($highest_time > $lowest_time)
											{
												//echo " Increase<br />";
												$ae_severity .= " Increase";
											}
											elseif ($highest_time < $lowest_time)
											{
												//echo " Decrease<br />";
												$ae_severity .= " Decrease";
											}
											else
											{
												//echo " Change<br />";
												$ae_severity .= " Change";
											}
											
								
										echo "	<INPUT type=\"radio\" name=\"$event_id-ae_severity\" id=\"$event_id-ae_severity\" value=\"$ae_severity\" checked=\"checked\" />$ae_severity.</INPUT><br />
												<b>Change to:</b> <br />
												<INPUT type=\"radio\" name=\"$event_id-ae_severity\" id=\"$event_id-ae_severity\" value=\"Minor\"> Minor<br />
												<INPUT type=\"radio\" name=\"$event_id-ae_severity\" id=\"$event_id-ae_severity\" value=\"Medium\"> Medium<br />
												<INPUT type=\"radio\" name=\"$event_id-ae_severity\" id=\"$event_id-ae_severity\" value=\"Major\"> Major<br />
												</TD>";
										
										echo "<TD width=\"12%\">
												<INPUT type=\"hidden\" name=\"$event_id-omt_related\" id=\"$event_id-omt_related\" value=\"NA\">
												<INPUT type=\"radio\" name=\"$event_id-omt_related\" id=\"$event_id-omt_related\" value=\"Definitely\"> Definitely<br />
												<INPUT type=\"radio\" name=\"$event_id-omt_related\" id=\"$event_id-omt_related\" value=\"Probably\"> Probably<br />
												<INPUT type=\"radio\" name=\"$event_id-omt_related\" id=\"$event_id-omt_related\" value=\"Not Sure\"> Not Sure<br />
												<INPUT type=\"radio\" name=\"$event_id-omt_related\" id=\"$event_id-omt_related\" value=\"Unlikely\"> Unlikely<br />
												<INPUT type=\"radio\" name=\"$event_id-omt_related\" id=\"$event_id-omt_related\" value=\"No\"> No<br />
												</TD>
											</TR>";
										$allow_comment = 1;
								}
								else
								{
									echo "</TD><TD width=\"12%\"></TD></TR>";
								}
						}
						else
						{
							if (($followup_clinic == "Yes") || (strlen($followup_clinic_related) > 0) || (strlen($followup_clinic_details) > 0))
								{
									echo "<TR>
											<TD colspan=\"4\" width=\"52%\"> Contacted Clinician (Office)? <b>$followup_clinic</b><br />";
											if (strlen($followup_clinic_details) > 1)
												{
													echo "$followup_clinic_details";
												}
												else
												{
													echo "No Response.";
												}
										echo "</TD>
											<TD width=\"12%\"><b>Pt. Report OMT Related? </b> &nbsp; &nbsp; &nbsp; $followup_clinic_related </TD>";
									$followup_vote = 1;
								}
							
							if (($followup_uc == "Yes") || (strlen($followup_uc_related) > 0) || (strlen($followup_uc_details) > 0))
								{
									echo "<TR>
											<TD colspan=\"4\" width=\"52%\"> Contacted Urgent Care? <b>$followup_uc</b><br />";
											if (strlen($followup_uc_details) > 1)
												{
													echo "$followup_uc_details";
												}
												else
												{
													echo "No Response.";
												}
										echo "</TD>
											<TD width=\"12%\"><b>Pt. Report OMT Related? </b> &nbsp; &nbsp; &nbsp; $followup_uc_related </TD>";
									$followup_vote = 1;
								}
							
							if (($followup_er == "Yes") || (strlen($followup_er_related) > 0) || (strlen($followup_er_details) > 0))
								{
									echo "<TR>
											<TD colspan=\"4\" width=\"52%\"> Contacted Emergency Room? <b>$followup_er</b><br />";
											if (strlen($followup_er_details) > 1)
												{
													echo "$followup_er_details";
												}
												else
												{
													echo "No Response.";
												}
										echo "</TD>
											<TD width=\"12%\"><b>Pt. Report OMT Related? </b> &nbsp; &nbsp; &nbsp; $followup_er_related</TD>";
									$followup_vote = 1;
								}
								
							if (($followup_hosp == "Yes") || (strlen($followup_hosp_related) > 0) || (strlen($followup_hosp_details) > 0))
								{
									echo "<TR>
											<TD colspan=\"4\" width=\"52%\"> Contacted Hospital? <b>$followup_hosp</b><br />";
											if (strlen($followup_hosp_details) > 1)
												{
													echo "$followup_hosp_details";
												}
												else
												{
													echo "No Response.";
												}
										echo "</TD>
											<TD width=\"12%\"><b>Pt. Report OMT Related? </b> &nbsp; &nbsp; &nbsp; $followup_hosp_related</TD>";
									$followup_vote = 1;
								}
								
							if (((substr($followup_clinic, 0, 3) == "Yes") || (substr($followup_uc, 0, 3) == "Yes") || (substr($followup_er, 0, 3) == "Yes") || (substr($followup_hosp, 0, 3) == "Yes")) && ($followup_vote == 1))
								{
									//echo "
									//<TD width=\"12%\"></TD>";	// included a blank
									
										echo "<TD width=\"12%\">
												<INPUT type=\"hidden\" name=\"$event_id-followup_isae\" id=\"$event_id-followup_isae\" value=\"Yes\">
												<INPUT type=\"radio\" name=\"$event_id-followup_isae\" id=\"$event_id-followup_isae\" value=\"Yes\"> Yes<br />
												<INPUT type=\"radio\" name=\"$event_id-followup_isae\" id=\"$event_id-followup_isae\" value=\"No\"> No<br />
												<INPUT type=\"radio\" name=\"$event_id-followup_isae\" id=\"$event_id-followup_isae\" value=\"Inconclusive\"> Inconclusive<br />
												
												</TD>";
									
										echo "<TD width=\"12%\">
												<INPUT type=\"hidden\" name=\"$event_id-ae_severity\" id=\"$event_id-ae_severity\" value=\"NA\">
												<INPUT type=\"radio\" name=\"$event_id-ae_severity\" id=\"$event_id-ae_severity\" value=\"Mild\"> Mild<br/>
												<INPUT type=\"radio\" name=\"$event_id-ae_severity\" id=\"$event_id-ae_severity\" value=\"Moderate\"> Moderate<br/>
												<INPUT type=\"radio\" name=\"$event_id-ae_severity\" id=\"$event_id-ae_severity\" value=\"Severe\"> Severe<br/>
												</TD>";
										
										echo "<TD width=\"12%\">
												<INPUT type=\"hidden\" name=\"$event_id-omt_related\" id=\"$event_id-omt_related\" value=\"NA\">
												<INPUT type=\"radio\" name=\"$event_id-omt_related\" id=\"$event_id-omt_related\" value=\"Definitely\"> Definitely<br />
												<INPUT type=\"radio\" name=\"$event_id-omt_related\" id=\"$event_id-omt_related\" value=\"Probably\"> Probably<br />
												<INPUT type=\"radio\" name=\"$event_id-omt_related\" id=\"$event_id-omt_related\" value=\"Not Sure\"> Not Sure<br />
												<INPUT type=\"radio\" name=\"$event_id-omt_related\" id=\"$event_id-omt_related\" value=\"Unlikely\"> Unlikely<br />
												<INPUT type=\"radio\" name=\"$event_id-omt_related\" id=\"$event_id-omt_related\" value=\"No\"> No<br />
												</TD>
											</TR>";
											
									$followup_vote = 0;
								}
								
							if ((strlen($pt_24hr_details) > 0) || (strlen($pt_72hr_details) > 0) || (strlen($pt_1wk_details) > 0))
								{
									echo "<TR style=\"background-color: orange\">
											<TD width=\"20%\"> <b> Pt. Comments </b> </TD>";
										
									if (strlen($pt_24hr_details) > 0)
										{
											echo " 	<TD width=\"11%\"> 24 hr </TD>
													<TD colspan=\"6\" width=\"69%\"> $pt_24hr_details </TD>";
											$pt_comment_text .= "<b> 24 hr:</b> $pt_24hr_details <br /><br />";
										}
										
									if (strlen($pt_72hr_details) > 0)
										{
											echo "	<TD width=\"11%\"> 72 hr </TD>
													<TD colspan=\"6\" width=\"69%\"> $pt_72hr_details </TD>";
											$pt_comment_text .= "<b> 72 hr:</b> $pt_72hr_details <br /><br />";
										}
										
									if (strlen($pt_1wk_details) > 0)
										{
											echo "	<TD width=\"11%\"> 1 wk </TD>
													<TD colspan=\"6\" width=\"69%\"> $pt_1wk_details </TD>";
											$pt_comment_text .= "<b> 1 wk: </b> $pt_1wk_details <br /><br />";
										}
									echo "</TR>";
									$allow_comment = 0;
								}

						}
						
					if ($phase > "1")
						{
							if (!($cmt_QUERY = $dblink->prepare("SELECT 
																	user_id,
																	action_date,
																	comment
																FROM
																	review
																WHERE
																	(comment IS NOT NULL) AND
																	(event_id = ?)
																ORDER BY
																	action_date DESC;"))) { logger("SQLi Prepare: $cmt_QUERY->error"); }
							if (!($cmt_QUERY->bind_param('s', $event_id)))  { logger("SQLi Prepare: $cmt_QUERY->error"); }
							if (!($cmt_QUERY->execute())) { logger("SQLi execute: $cmt_QUERY->error"); }
							if (!($cmt_QUERY->bind_result($cmt_user_id, $cmt_date, $cmt_comment))) { logger("SQLi rBind: $cmt_QUERY->error"); }
							$cmt_QUERY->store_result();
							if ($cmt_QUERY->num_rows > 0)
								$eac_comments = "";
								{
									// build list of comments
									while ($cmt_QUERY->fetch())
										{
											if (strlen($eac_comments > 1))
												{
													$eac_comments .= "<br />----<br />";
												}
											$eac_comments .= "<b>$cmt_user_id ($cmt_date):</b> $cmt_comment";
										}
								
									// display list of comments
									echo "<TR>
											<TD width=\"20%\"> EAC Comment(s)</TD>
											<TD colspan=\"7\"> $eac_comments </TD>
										</TR>";
								}
						}
					
					if ($allow_comment == 1)
						{
							echo "<TR>
								<TD width=\"20%\"> Your Comments: </TD>
								<TD colspan=\"7\"> <textarea name=\"$event_id-comment\" id=\"$event_id-comment\" cols=\"80\" rows=\"2\" maxlength=\"3900\" wrap=\"physical\"></textarea></TD>
							</TR>";
							
							$allow_comment = 0;
						}
						
					$pg_len++;
				}
				
					echo "
					<TR>
						<TD colspan=\"8\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <INPUT type=\"reset\" name=\"reset\" value=\"Reset Form\">
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
						<INPUT type=\"submit\" name=\"submit\" value=\"Submit Vote\"></TD>
					</TR></tbody>
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
							// clean up any old data.
							if (isset($comment)) { unset($comment); }
							if (isset($p24hr_adverse_event)) { unset($p24hr_adverse_event); }
							if (isset($p72hr_adverse_event)) { unset($p72hr_adverse_event); }
							if (isset($p1wk_adverse_event)) { unset($p1wk_adverse_event); }
							if (isset($followup_adverse_event)) { unset($followup_adverse_event); }
							if (isset($ae_severity)) { unset($ae_severity); }
							if (isset($omt_related)) { unset($omt_related); }
							
							// mock in current event_id values from POST
							if (isset($_POST["$e_id-comment"])) { $comment = $_POST["$e_id-comment"]; } else { $comment = NULL; }
							if (isset($_POST["$e_id-pt_24hr_isae"])) { $p24hr_adverse_event = $_POST["$e_id-pt_24hr_isae"]; } else { $p24hr_adverse_event = NULL; }
							if (isset($_POST["$e_id-pt_72hr_isae"])) { $p72hr_adverse_event = $_POST["$e_id-pt_72hr_isae"]; } else { $p72hr_adverse_event = NULL; }
							if (isset($_POST["$e_id-pt_1_wk_isae"])) { $p1wk_adverse_event = $_POST["$e_id-pt_1_wk_isae"]; } else { $p1wk_adverse_event = NULL; }
							if (isset($_POST["$e_id-pt_followup_isae"])) { $followup_adverse_event = $_POST["$e_id-followup_isae"]; } else { $followup_adverse_event = NULL; }
							if (isset($_POST["$e_id-ae_severity"])) { $ae_severity = $_POST["$e_id-ae_severity"]; } else { $ae_severity = NULL; }
							if (isset($_POST["$e_id-omt_related"])) { $omt_related = $_POST["$e_id-omt_related"]; } else { $omt_related = NULL; }
						
							if (!($vote_QUERY = $dblink->prepare("
								INSERT INTO 
									jury_room.review 
										(	user_id, 
											event_id, 
											comment,
											24hr_adverse_event,
											72hr_adverse_event,
											1wk_adverse_event,
											followup_adverse_event,
											ae_severity,
											omt_related) 
										VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);"))) {logger("SQLi Prepare: $vote_QUERY->error");}
							if (!($vote_QUERY->bind_param('sssssssss', $_SESSION['id'], $e_id, $comment, $p24hr_adverse_event, $p72hr_adverse_event, $p1wk_adverse_event, $followup_adverse_event, $ae_severity, $omt_related))) { logger("SQLi Bind Error: $vote_QUERY->error"); }
							if (!($vote_QUERY->execute())) { logger("SQLi execute: $vote_QUERY->error"); }
							$vote_QUERY->close();
							
							// clean up any old data.
							if (isset($comment)) { unset($comment); }
							if (isset($p24hr_adverse_event)) { unset($p24hr_adverse_event); }
							if (isset($p72hr_adverse_event)) { unset($p72hr_adverse_event); }
							if (isset($p1wk_adverse_event)) { unset($p1wk_adverse_event); }
							if (isset($followup_adverse_event)) { unset($followup_adverse_event); }
							if (isset($ae_severity)) { unset($ae_severity); }
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