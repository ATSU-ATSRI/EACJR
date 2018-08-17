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
			"))) { logger(__LINE__, "SQLi Prepare: $events_QUERY->error"); }
	if (!($events_QUERY->bind_param('s', $patient_id)))  { logger(__LINE__, "SQLi Prepare: $events_QUERY->error"); }
	if (!($events_QUERY->execute())) { logger(__LINE__, "SQLi execute: $events_QUERY->error"); }
	if (!($events_QUERY->bind_result($phase, $code, $age, $sex, $ethnicity, $race, $race_other, $event_id, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk, $pt_1wk_details, $followup_clinic, $followup_clinic_related, $followup_clinic_details, $followup_uc, $followup_uc_related, $followup_uc_details, $followup_er, $followup_er_related, $followup_er_details, $followup_hosp, $followup_hosp_related, $followup_hosp_details, $further, $further_why, $future, $future_why))) { logger(__LINE__, "SQLi rBind: $events_QUERY->error"); }
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
								<TH width=\"100%\"><center> Participant Survey </center></TH>
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
										<li>Not applicable (N/A)</li>
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
											
											if (strlen($pt_24hr_severity) > 0 ) 
												{
													echo "
													<b>Pt. Report OMT Related? </b> &nbsp; &nbsp; &nbsp; ";
													
													if (strlen($pt_24hr_related) > 0)
														{
															echo " $pt_24hr_related <br /><br />
																<INPUT type=\"hidden\" name=\"$event_id-pt_24hr_related\" id=\"$event_id-pt_24hr_related\" value=\"$pt_24hr_related\">";
														}
														else
														{	
															echo " No Response.";
														}
												}
											echo "</TD>
									<TD width=\"11%\"> $pt_72hr_severity <br /><br />";
																							
											if (strlen($pt_72hr_severity) > 0)
												{
													echo "
													<b>Pt. Report OMT Related? </b> &nbsp; &nbsp; &nbsp;";
											
													if (strlen($pt_72hr_related) > 0)
														{ 
															echo " $pt_72hr_related <br /><br />
															<INPUT type=\"hidden\" name=\"$event_id-pt_72hr_related\" id=\"$event_id-pt_72hr_related\" value=\"$pt_72hr_related\">";
														}
														else
														{
															echo " No Response.";
														}
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
							echo "
									<!--- NEW FOLLOWUP OR COMMENT STARTS HERE --->";
									
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
									$allow_comment = 1;
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
									$allow_comment = 1;
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
									$allow_comment = 1;
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
									$allow_comment = 1;
								}
								
							if (((substr($followup_clinic, 0, 3) == "Yes") || (substr($followup_uc, 0, 3) == "Yes") || (substr($followup_er, 0, 3) == "Yes") || (substr($followup_hosp, 0, 3) == "Yes")) && ($followup_vote == 1))
								{
									$event_id_array[] = $event_id;
									
										echo "	<input type=\"hidden\" name=\"$event_id-event_id\" value=\"$event_id\">
												<input type=\"hidden\" name=\"$event_id-code\" value=\"$code\">
												
												<TD width=\"12%\">
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
																	action_date DESC;"))) { logger(__LINE__, "SQLi Prepare: $cmt_QUERY->error"); }
							if (!($cmt_QUERY->bind_param('s', $event_id)))  { logger(__LINE__, "SQLi Prepare: $cmt_QUERY->error"); }
							if (!($cmt_QUERY->execute())) { logger(__LINE__, "SQLi execute: $cmt_QUERY->error"); }
							if (!($cmt_QUERY->bind_result($cmt_user_id, $cmt_date, $cmt_comment))) { logger(__LINE__, "SQLi rBind: $cmt_QUERY->error"); }
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
											$eac_comments .= "<b>$cmt_user_id ($cmt_date):</b> $cmt_comment <br />----<br />";
										}
								
									// display list of comments
									echo "<TR>
											<TD width=\"20%\"> EAC Comment(s)</TD>
											<TD colspan=\"7\"> ";
											if (isset($eac_comments))
												{ echo "$eac_comments"; }
									echo "</TD>
										</TR>";
								}
						}
					
					if ($allow_comment == 1)
						{
							echo "<TR>
								<TD width=\"20%\"> Your Comments: </TD>
								<TD colspan=\"7\"> <textarea name=\"$event_id-comment\" id=\"$event_id-comment\" cols=\"80\" rows=\"2\" maxlength=\"7900\" wrap=\"physical\"></textarea></TD>
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
			</form>";
			
			// insert PET form.
			if (!($pet_QUERY = $dblink->prepare("SELECT `study_id`, `code`, `HF_ART`, `HF_BLT`, `HF_CR`, `HF_CS`, `HF_HVLA`, `HF_IND`, `HF_Lymph`, `HF_ME`, `HF_MFR`, `HF_PH`, `HF_ST`, `HF_VIS`, `HF_Other`, `HF_Specify`, `HF_Response`, `Neck_ART`, `Neck_BLT`, `Neck_CR`, `Neck_CS`, `Neck_HVLA`, `Neck_IND`, `Neck_Lymph`, `Neck_ME`, `Neck_MFR`, `Neck_PH`, `Neck_ST`, `Neck_VIS`, `Neck_Other`, `Neck_Specify`, `Neck_Response`, `Thor_ART`, `Thor_BLT`, `Thor_CR`, `Thor_CS`, `Thor_HVLA`, `Thor_IND`, `Thor_Lymph`, `Thor_ME`, `Thor_MFR`, `Thor_PH`, `Thor_ST`, `Thor_VIS`, `Thor_Other`, `Thor_Specify`, `Thor_Response`, `Ribs_ART`, `Ribs_BLT`, `Ribs_CR`, `Ribs_CS`, `Ribs_HVLA`, `Ribs_IND`, `Ribs_Lymph`, `Ribs_ME`, `Ribs_MFR`, `Ribs_PH`, `Ribs_ST`, `Ribs_VIS`, `Ribs_Other`, `Ribs_Specify`, `Rib_Response`, `Lumb_ART`, `Lumb_BLT`, `Lumb_CR`, `Lumb_CS`, `Lumb_HVLA`, `Lumb_IND`, `Lumb_Lymph`, `Lumb_ME`, `Lumb_MFR`, `Lumb_PH`, `Lumb_ST`, `Lumb_VIS`, `Lumb_Other`, `Lumb_Specify`, `Lumb_Response`, `Sac_ART`, `Sac_BLT`, `Sac_CR`, `Sac_CS`, `Sac_HVLA`, `Sac_Ind`, `Sac_Lymph`, `Sac_ME`, `Sac_MFR`, `Sac_PH`, `Sac_ST`, `Sac_VIS`, `Sac_Other`, `Sac_Specify`, `Sac_Response`, `Pelvis_ART`, `Pelvis_BLT`, `Pelvis_CR`, `Pelvis_CS`, `Pelvis_HVLA`, `Pelvis_IND`, `Pelvis_Lymph`, `Pelvis_ME`, `Pelvis_MFR`, `Pelvis_PH`, `Pelvis_ST`, `Pelvis_VIS`, `Pelvis_Other`, `Pelvis_Specify`, `Pelvis_Response`, `Abd_ART`, `Abd_BLT`, `Abd_CR`, `Abd_CS`, `Abd_HVLA`, `Abd_IND`, `Abd_Lymph`, `Abd_ME`, `Abd_MFR`, `Abd_PH`, `Abd_ST`, `Abd_VIS`, `Abd_Other`, `Abd_Specify`, `Abd_Response`, `Up_Ex_ART`, `Up_Ex_BLT`, `Up_Ex_CR`, `Up_Ex_CS`, `Up_Ex_HVLA`, `Up_Ex_IND`, `Up_Ex_Lymph`, `Up_Ex_ME`, `Up_Ex_MFR`, `Up_Ex_PH`, `Up_Ex_ST`, `Up_Ex_VIS`, `Up_Ex_Other`, `Up_Ex_Specify`, `Up_Ex_Response`, `Should_ART`, `Should_BLT`, `Should_CR`, `Should_CS`, `Should_HVLA`, `Should_IND`, `Should_Lymph`, `Should_ME`, `Should_MFR`, `Should_PH`, `Should_ST`, `Should_VIS`, `Should_Other`, `Should_Specify`, `Should_Response`, `Elbow_ART`, `Elbow_BLT`, `Elbow_CR`, `Elbow_CS`, `Elbow_HVLA`, `Elbow_IND`, `Elbow_Lymph`, `Elbow_ME`, `Elbow_MFR`, `Elbow_PH`, `Elbow_ST`, `Elbow_VIS`, `Elbow_Other`, `Elbow_Specify`, `Elbow_Response`, `Wrist_ART`, `Wrist_BLT`, `Wrist_CR`, `Wrist_CS`, `Wrist_HVLA`, `Wrist_IND`, `Wrist_Lymph`, `Wrist_ME`, `Wrist_MFR`, `Wrist_PH`, `Wrist_ST`, `Wrist_VIS`, `Wrist_Other`, `Wrist_Specify`, `Wrist_Response`, `Low_Ex_ART`, `Low_Ex_BLT`, `Low_Ex_CR`, `Low_Ex_CS`, `Low_Ex_HVLA`, `Low_Ex_IND`, `Low_Ex_Lymph`, `Low_Ex_ME`, `Low_Ex_MFR`, `Low_Ex_PH`, `Low_Ex_ST`, `Low_Ex_VIS`, `Low_Ex_Other`, `Low_Ex_Specify`, `Low_Ex_Response`, `Thigh_ART`, `Thigh_BLT`, `Thigh_CR`, `Thigh_CS`, `Thigh_HVLA`, `Thigh_Ind`, `Thigh_Lymph`, `Thigh_ME`, `Thigh_MFR`, `Thigh_PH`, `Thigh_ST`, `Thigh_VIS`, `Thigh_Other`, `Thigh_Specify`, `Thigh_Response`, `Knee_ART`, `Knee_BLT`, `Knee_CR`, `Knee_CS`, `Knee_HVLA`, `Knee_IND`, `Knee_Lymph`, `Knee_ME`, `Knee_MFR`, `Knee_PH`, `Knee_ST`, `Knee_VIS`, `Knee_Other`, `Knee_Specify`, `Knee_Response`, `Ankle_ART`, `Ankle_BLT`, `Ankle_CR`, `Ankle_CS`, `Ankle_HVLA`, `Ankle_IND`, `Ankle_Lymph`, `Ankle_ME`, `Ankle_MFR`, `Ankle_PH`, `Ankle_ST`, `Ankle_VIS`, `Ankle_Other`, `Ankle_Specify`, `Ankle_Response`, `C739`, `C739_1`, `C739_2`, `C739_8`, `C739_3`, `C739_4`, `C739_5`, `C739_9`, `C739_7`, `C739_6`, `Written_Diagnosis_1`, `Diagnosis_Code_1`, `Chief_Related_1`, `SD_Related_1`, `Written_Diagnosis_2`, `Diagnosis_Code_2`, `Chief_Related_2`, `SD_Related_2`, `Written_Diagnosis_3`, `Diagnosis_Code_3`, `Chief_Related_3`, `SD_Related_3`, `Written_Diagnosis_4`, `Diagnosis_Code_4`, `Chief_Related_4`, `SD_Related_4`, `Written_Diagnosis_5`, `Diagnosis_Code_5`, `Chief_Related_5`, `SD_Related_5`, `Written_Diagnosis_6`, `Diagnosis_Code_6`, `Chief_Related_6`, `SD_Related_6`, `Written_Diagnosis_7`, `Diagnosis_Code_7`, `Chief_Related_7`, `SD_Related_7`, `Procuedures_1`, `Procedures_2`, `Procedures_3`, `Procedures_4`, `Procedures_5` FROM `pet` WHERE (`code` = ?);"))) { logger(__LINE__, "SQLi Prepare: $pet_QUERY->error"); }
			if (!($pet_QUERY->bind_param('s', $code)))  { logger(__LINE__, "SQLi Prepare: $pet_QUERY->error"); }
			if (!($pet_QUERY->execute())) { logger(__LINE__, "SQLi execute: $pet_QUERY->error"); }
			$pet_QUERY->store_result();
			if (!($pet_QUERY->bind_result($study_id, $code, $HF_ART, $HF_BLT, $HF_CR, $HF_CS, $HF_HVLA, $HF_IND, $HF_Lymph, $HF_ME, $HF_MFR, $HF_PH, $HF_ST, $HF_VIS, $HF_Other, $HF_Specify, $HF_Response, $Neck_ART, $Neck_BLT, $Neck_CR, $Neck_CS, $Neck_HVLA, $Neck_IND, $Neck_Lymph, $Neck_ME, $Neck_MFR, $Neck_PH, $Neck_ST, $Neck_VIS, $Neck_Other, $Neck_Specify, $Neck_Response, $Thor_ART, $Thor_BLT, $Thor_CR, $Thor_CS, $Thor_HVLA, $Thor_IND, $Thor_Lymph, $Thor_ME, $Thor_MFR, $Thor_PH, $Thor_ST, $Thor_VIS, $Thor_Other, $Thor_Specify, $Thor_Response, $Ribs_ART, $Ribs_BLT, $Ribs_CR, $Ribs_CS, $Ribs_HVLA, $Ribs_IND, $Ribs_Lymph, $Ribs_ME, $Ribs_MFR, $Ribs_PH, $Ribs_ST, $Ribs_VIS, $Ribs_Other, $Ribs_Specify, $Ribs_Response, $Lumb_ART, $Lumb_BLT, $Lumb_CR, $Lumb_CS, $Lumb_HVLA, $Lumb_IND, $Lumb_Lymph, $Lumb_ME, $Lumb_MFR, $Lumb_PH, $Lumb_ST, $Lumb_VIS, $Lumb_Other, $Lumb_Specify, $Lumb_Response, $Sac_ART, $Sac_BLT, $Sac_CR, $Sac_CS, $Sac_HVLA, $Sac_Ind, $Sac_Lymph, $Sac_ME, $Sac_MFR, $Sac_PH, $Sac_ST, $Sac_VIS, $Sac_Other, $Sac_Specify, $Sac_Response, $Pelvis_ART, $Pelvis_BLT, $Pelvis_CR, $Pelvis_CS, $Pelvis_HVLA, $Pelvis_IND, $Pelvis_Lymph, $Pelvis_ME, $Pelvis_MFR, $Pelvis_PH, $Pelvis_ST, $Pelvis_VIS, $Pelvis_Other, $Pelvis_Specify, $Pelvis_Response, $Abd_ART, $Abd_BLT, $Abd_CR, $Abd_CS, $Abd_HVLA, $Abd_IND, $Abd_Lymph, $Abd_ME, $Abd_MFR, $Abd_PH, $Abd_ST, $Abd_VIS, $Abd_Other, $Abd_Specify, $Abd_Response, $Up_Ex_ART, $Up_Ex_BLT, $Up_Ex_CR, $Up_Ex_CS, $Up_Ex_HVLA, $Up_Ex_IND, $Up_Ex_IND, $Up_Ex_ME, $Up_Ex_MFR, $Up_Ex_PH, $Up_Ex_ST, $Up_Ex_VIS, $Up_Ex_Other, $Up_Ex_Specify, $Up_Ex_Response, $Should_ART, $Should_BLT, $Should_CR, $Should_CS, $Should_HVLA, $Should_IND, $Should_Lymph, $Should_ME, $Should_MFR, $Should_PH, $Should_ST, $Should_VIS, $Should_Other, $Should_Specify, $Should_Response, $Elbow_ART, $Elbow_BLT, $Elbow_CR, $Elbow_CS, $Elbow_HVLA, $Elbow_IND, $Elbow_Lymph, $Elbow_ME, $Elbow_MFR, $Elbow_PH, $Elbow_ST, $Elbow_VIS, $Elbow_Other, $Elbow_Specify, $Elbow_Response, $Wrist_ART, $Wrist_BLT, $Wrist_CR, $Wrist_CS, $Wrist_HVLA, $Wrist_IND, $Wrist_Lymph, $Wrist_ME, $Wrist_MFR, $Wrist_PH, $Wrist_ST, $Wrist_VIS, $Wrist_Other, $Wrist_Specify, $Wrist_Response, $Low_Ex_ART, $Low_Ex_BLT, $Low_Ex_CR, $Low_Ex_CS, $Low_Ex_HVLA, $Low_Ex_IND, $Low_Ex_Lymph, $Low_Ex_ME, $Low_Ex_MFR, $Low_Ex_PH, $Low_Ex_ST, $Low_Ex_VIS, $Low_Ex_Other, $Low_Ex_Specify, $Low_Ex_Response, $Thigh_ART, $Thigh_BLT, $Thigh_CR, $Thigh_CS, $Thigh_HVLA, $Thigh_Ind, $Thigh_Lymph, $Thigh_ME, $Thigh_MFR, $Thigh_PH, $Thigh_ST, $Thigh_VIS, $Thigh_Other, $Thigh_Specify, $Thigh_Response, $Knee_ART, $Knee_BLT, $Knee_CR, $Knee_CS, $Knee_HVLA, $Knee_IND, $Knee_Lymph, $Knee_ME, $Knee_MFR, $Knee_PH, $Knee_PH, $Knee_VIS, $Knee_Other, $Knee_Specify, $Knee_Response, $Ankle_ART, $Ankle_BLT, $Ankle_CR, $Ankle_CS, $Ankle_HVLA, $Ankle_IND, $Ankle_Lymph, $Ankle_ME, $Ankle_MFR, $Ankle_PH, $Ankle_ST, $Ankle_VIS, $Ankle_Other, $Ankle_Specify, $Ankle_Response, $C739, $C739_1, $C739_2, $C739_8, $C739_3, $C739_4, $C739_5, $C739_9, $C739_7, $C739_6, $Written_Diagnosis_1, $Diagnosis_Code_1, $Chief_Related_1, $SD_Related_1, $Written_Diagnosis_2, $Diagnosis_Code_2, $Chief_Related_2, $SD_Related_2, $Written_Diagnosis_3, $Diagnosis_Code_3, $Chief_Related_3, $SD_Related_3, $Written_Diagnosis_4, $Diagnosis_Code_4, $Chief_Related_4, $SD_Related_4, $Written_Diagnosis_5, $Diagnosis_Code_5, $Chief_Related_5, $SD_Related_5, $Written_Diagnosis_6, $Diagnosis_Code_6, $Chief_Related_6, $SD_Related_6, $Written_Diagnosis_7, $Diagnosis_Code_7, $Chief_Related_7, $SD_Related_7, $Procuedures_1, $Procedures_2, $Procedures_3, $Procedures_4, $Procedures_5))) { logger(__LINE__, "SQLi rBind: $pet_QUERY->error"); }
			if ($pet_QUERY->num_rows > 0)
				{
					$pet_QUERY->fetch();
					echo "
					<TABLE border=\"1\">
						<thead2>
						<TR>
							<TH width=\"100%\"><center> OMT Treatment Method </center></TH></TR>
						<TR>
							<TH width=\"25%\">Region </TH>
							<TH width=\"5%\"> ART/Still </TH>
							<TH width=\"5%\"> BLT/LAS </TH>
							<TH width=\"5%\"> CR/BD </TH>
							<TH width=\"5%\"> CS/FPR </TH>
							<TH width=\"5%\"> HVLA </TH>
							<TH width=\"5%\"> IND/Func </TH>
							<TH width=\"5%\"> Lymph </TH>
							<TH width=\"4%\"> ME </TH>
							<TH width=\"4%\"> MFR </TH>
							<TH width=\"4%\"> PH </TH>
							<TH width=\"4%\"> ST </TH>
							<TH width=\"4%\"> VIS </TH>
							<TH width=\"4%\"> Other </TH>
							<TH width=\"11%\"> Specify </TH>
							<TH width=\"10%\"> Response </TH>
						</TR></thead2><tbody2>
						";
						
					if (isset($HF_ART) || isset($HF_BLT) || isset($HF_CR) || isset($HF_CS) || isset($HF_HVLA) || isset($HF_IND) || isset($HF_Lymph) || isset($HF_ME) || isset($HF_MFR) || isset($HF_PH) || isset($HF_ST) || isset($HF_VIS) || isset($HF_Other) || (strlen($HF_Specify) > 0) || ($HF_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Head/Face </TD>
								<TD width=\"5%\">$HF_ART</TD>
								<TD width=\"5%\">$HF_BLT</TD>
								<TD width=\"5%\">$HF_CR</TD>
								<TD width=\"5%\">$HF_CS</TD>
								<TD width=\"5%\">$HF_HVLA</TD>
								<TD width=\"5%\">$HF_IND</TD>
								<TD width=\"5%\">$HF_Lymph</TD>
								<TD width=\"4%\">$HF_ME</TD>
								<TD width=\"4%\">$HF_MFR</TD>
								<TD width=\"4%\">$HF_PH</TD>
								<TD width=\"4%\">$HF_ST</TD>
								<TD width=\"4%\">$HF_VIS</TD>
								<TD width=\"4%\">$HF_Other</TD>
								<TD width=\"11%\">$HF_Specify</TD>
								<TD width=\"10%\">";
									if ($HF_Response == "Off") {echo "No Response";} else {echo "$HF_Response";}
							echo "</TD>
							</TR>";
						}
					
					if(isset($Neck_ART) || isset($Neck_BLT) || isset($Neck_CR) || isset($Neck_CS) || isset($Neck_HVLA) || isset($Neck_IND) || isset($Neck_Lymph) || isset($Neck_ME) || isset($Neck_MFR) || isset($Neck_PH) || isset($Neck_ST) || isset($Neck_VIS) || isset($Neck_Other) || (strlen($Neck_Specify) > 0) || ($Neck_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Neck </TD>
								<TD width=\"5%\">$Neck_ART</TD>
								<TD width=\"5%\">$Neck_BLT</TD>
								<TD width=\"5%\">$Neck_CR</TD>
								<TD width=\"5%\">$Neck_CS</TD>
								<TD width=\"5%\">$Neck_HVLA</TD>
								<TD width=\"5%\">$Neck_IND</TD>
								<TD width=\"5%\">$Neck_Lymph</TD>
								<TD width=\"4%\">$Neck_ME</TD>
								<TD width=\"4%\">$Neck_MFR</TD>
								<TD width=\"4%\">$Neck_PH</TD>
								<TD width=\"4%\">$Neck_ST</TD>
								<TD width=\"4%\">$Neck_VIS</TD>
								<TD width=\"4%\">$Neck_Other</TD>
								<TD width=\"11%\">$Neck_Specify</TD>
								<TD width=\"10%\">";
									if ($Neck_Response == "Off") {echo "No Response";} else {echo "$Neck_Response";}
							echo "</TD>
							</TR>";
						}

					if (isset($Thor_ART) || isset($Thor_BLT) || isset($Thor_CR) || isset($Thor_CS) || isset($Thor_HVLA) || isset($Thor_IND) || isset($Thor_Lymph) || isset($Thor_ME) || isset($Thor_MFR) || isset($Thor_PH) || isset($Thor_ST) || isset($Thor_VIS) || isset($Thor_Other) || (strlen($Thor_Specify) > 0) || ($Thor_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Thoracic </TD>
								<TD width=\"5%\">$Thor_ART</TD>
								<TD width=\"5%\">$Thor_BLT</TD>
								<TD width=\"5%\">$Thor_CR</TD>
								<TD width=\"5%\">$Thor_CS</TD>
								<TD width=\"5%\">$Thor_HVLA</TD>
								<TD width=\"5%\">$Thor_IND</TD>
								<TD width=\"5%\">$Thor_Lymph</TD>
								<TD width=\"4%\">$Thor_ME</TD>
								<TD width=\"4%\">$Thor_MFR</TD>
								<TD width=\"4%\">$Thor_PH</TD>
								<TD width=\"4%\">$Thor_ST</TD>
								<TD width=\"4%\">$Thor_VIS</TD>
								<TD width=\"4%\">$Thor_Other</TD>
								<TD width=\"11%\">$Thor_Specify</TD>
								<TD width=\"10%\">";
									if ($Thor_Response == "Off") {echo "No Response";} else {echo "$Thor_Response";}
							echo "</TD>
							</TR>";
						}
						
					if (isset($Ribs_ART) || isset($Ribs_BLT) || isset($Ribs_CR) || isset($Ribs_CS) || isset($Ribs_HVLA) || isset($Ribs_IND) || isset($Ribs_Lymph) || isset($Ribs_ME) || isset($Ribs_MFR) || isset($Ribs_PH) || isset($Ribs_ST) || isset($Ribs_VIS) || isset($Ribs_Other) || (strlen($Ribs_Specify) > 0) || ($Ribs_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Ribs </TD>
								<TD width=\"5%\">$Ribs_ART</TD>
								<TD width=\"5%\">$Ribs_BLT</TD>
								<TD width=\"5%\">$Ribs_CR</TD>
								<TD width=\"5%\">$Ribs_CS</TD>
								<TD width=\"5%\">$Ribs_HVLA</TD>
								<TD width=\"5%\">$Ribs_IND</TD>
								<TD width=\"5%\">$Ribs_Lymph</TD>
								<TD width=\"4%\">$Ribs_ME</TD>
								<TD width=\"4%\">$Ribs_MFR</TD>
								<TD width=\"4%\">$Ribs_PH</TD>
								<TD width=\"4%\">$Ribs_ST</TD>
								<TD width=\"4%\">$Ribs_VIS</TD>
								<TD width=\"4%\">$Ribs_Other</TD>
								<TD width=\"11%\">$Ribs_Specify</TD>
								<TD width=\"10%\">";
									if ($Ribs_Response == "Off") {echo "No Response";} else {echo "$Ribs_Response";}
							echo "</TD>
							</TR>";
						}

					if (isset($Lumb_ART) || isset($Lumb_BLT) || isset($Lumb_CR) || isset($Lumb_CS) || isset($Lumb_HVLA) || isset($Lumb_IND) || isset($Lumb_Lymph) || isset($Lumb_ME) || isset($Lumb_MFR) || isset($Lumb_PH) || isset($Lumb_ST) || isset($Lumb_VIS) || isset($Lumb_Other) || (strlen($Lumb_Specify) > 0) || ($Lumb_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Lumbar </TD>
								<TD width=\"5%\">$Lumb_ART</TD>
								<TD width=\"5%\">$Lumb_BLT</TD>
								<TD width=\"5%\">$Lumb_CR</TD>
								<TD width=\"5%\">$Lumb_CS</TD>
								<TD width=\"5%\">$Lumb_HVLA</TD>
								<TD width=\"5%\">$Lumb_IND</TD>
								<TD width=\"5%\">$Lumb_Lymph</TD>
								<TD width=\"4%\">$Lumb_ME</TD>
								<TD width=\"4%\">$Lumb_MFR</TD>
								<TD width=\"4%\">$Lumb_PH</TD>
								<TD width=\"4%\">$Lumb_ST</TD>
								<TD width=\"4%\">$Lumb_VIS</TD>
								<TD width=\"4%\">$Lumb_Other</TD>
								<TD width=\"11%\">$Lumb_Specify</TD>
								<TD width=\"10%\">";
									if ($Lumb_Response == "Off") {echo "No Response";} else {echo "$Lumb_Response";}
							echo "</TD>
							</TR>";
						}
					
					if (isset($Sac_ART) || isset($Sac_BLT) || isset($Sac_CR) || isset($Sac_CS) || isset($Sac_HVLA) || isset($Sac_Ind) || isset($Sac_Lymph) || isset($Sac_ME) || isset($Sac_MFR) || isset($Sac_PH) || isset($Sac_ST) || isset($Sac_VIS) || isset($Sac_Other) || (strlen($Sac_Specify) > 0) || ($Sac_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Sacrum </TD>
								<TD width=\"5%\">$Sac_ART</TD>
								<TD width=\"5%\">$Sac_BLT</TD>
								<TD width=\"5%\">$Sac_CR</TD>
								<TD width=\"5%\">$Sac_CS</TD>
								<TD width=\"5%\">$Sac_HVLA</TD>
								<TD width=\"5%\">$Sac_Ind</TD>
								<TD width=\"5%\">$Sac_Lymph</TD>
								<TD width=\"4%\">$Sac_ME</TD>
								<TD width=\"4%\">$Sac_MFR</TD>
								<TD width=\"4%\">$Sac_PH</TD>
								<TD width=\"4%\">$Sac_ST</TD>
								<TD width=\"4%\">$Sac_VIS</TD>
								<TD width=\"4%\">$Sac_Other</TD>
								<TD width=\"11%\">$Sac_Specify</TD>
								<TD width=\"10%\">";
									if ($Sac_Response == "Off") {echo "No Response";} else {echo "$Sac_Response";}
							echo "</TD>
							</TR>";
						}
					
					if (isset($Pelvis_ART) || isset($Pelvis_BLT) || isset($Pelvis_CR) || isset($Pelvis_CS) || isset($Pelvis_HVLA) || isset($Pelvis_IND) || isset($Pelvis_Lymph) || isset($Pelvis_ME) || isset($Pelvis_MFR) || isset($Pelvis_PH) || isset($Pelvis_ST) || isset($Pelvis_VIS) || isset($Pelvis_Other) || (strlen($Pelvis_Specify) > 0) || ($Pelvis_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Pelvis/Innominate/Hip </TD>
								<TD width=\"5%\">$Pelvis_ART</TD>
								<TD width=\"5%\">$Pelvis_BLT</TD>
								<TD width=\"5%\">$Pelvis_CR</TD>
								<TD width=\"5%\">$Pelvis_CS</TD>
								<TD width=\"5%\">$Pelvis_HVLA</TD>
								<TD width=\"5%\">$Pelvis_IND</TD>
								<TD width=\"5%\">$Pelvis_Lymph</TD>
								<TD width=\"4%\">$Pelvis_ME</TD>
								<TD width=\"4%\">$Pelvis_MFR</TD>
								<TD width=\"4%\">$Pelvis_PH</TD>
								<TD width=\"4%\">$Pelvis_ST</TD>
								<TD width=\"4%\">$Pelvis_VIS</TD>
								<TD width=\"4%\">$Pelvis_Other</TD>
								<TD width=\"11%\">$Pelvis_Specify</TD>
								<TD width=\"10%\">";
									if ($Pelvis_Response == "Off") {echo "No Response";} else {echo "$Pelvis_Response";}
							echo "</TD>
							</TR>";
						}
					
					if (isset($Abd_ART) || isset($Abd_BLT) || isset($Abd_CR) || isset($Abd_CS) || isset($Abd_HVLA) || isset($Abd_IND) || isset($Abd_Lymph) || isset($Abd_ME) || isset($Abd_MFR) || isset($Abd_PH) || isset($Abd_ST) || isset($Abd_VIS) || isset($Abd_Other) || (strlen($Abd_Specify) > 0) || ($Abd_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Abdomen </TD>
								<TD width=\"5%\">$Abd_ART</TD>
								<TD width=\"5%\">$Abd_BLT</TD>
								<TD width=\"5%\">$Abd_CR</TD>
								<TD width=\"5%\">$Abd_CS</TD>
								<TD width=\"5%\">$Abd_HVLA</TD>
								<TD width=\"5%\">$Abd_IND</TD>
								<TD width=\"5%\">$Abd_Lymph</TD>
								<TD width=\"4%\">$Abd_ME</TD>
								<TD width=\"4%\">$Abd_MFR</TD>
								<TD width=\"4%\">$Abd_PH</TD>
								<TD width=\"4%\">$Abd_ST</TD>
								<TD width=\"4%\">$Abd_VIS</TD>
								<TD width=\"4%\">$Abd_Other</TD>
								<TD width=\"11%\">$Abd_Specify</TD>
								<TD width=\"10%\">";
									if ($Abd_Response == "Off") {echo "No Response";} else {echo "$Abd_Response";}
							echo "</TD>
							</TR>";
						}
					
					if (isset($Up_Ex_ART) || isset($Up_Ex_BLT) || isset($Up_Ex_CR) || isset($Up_Ex_CS) || isset($Up_Ex_HVLA) || isset($Up_Ex_IND) || isset($Up_Ex_IND) || isset($Up_Ex_ME) || isset($Up_Ex_MFR) || isset($Up_Ex_PH) || isset($Up_Ex_ST) || isset($Up_Ex_VIS) || isset($Up_Ex_Other) || (strlen($Up_Ex_Specify) > 0) || ($Up_Ex_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Upper Extremities </TD>
								<TD width=\"5%\">$Up_Ex_ART</TD>
								<TD width=\"5%\">$Up_Ex_BLT</TD>
								<TD width=\"5%\">$Up_Ex_CR</TD>
								<TD width=\"5%\">$Up_Ex_CS</TD>
								<TD width=\"5%\">$Up_Ex_HVLA</TD>
								<TD width=\"5%\">$Up_Ex_IND</TD>
								<TD width=\"5%\">$Up_Ex_IND</TD>
								<TD width=\"4%\">$Up_Ex_ME</TD>
								<TD width=\"4%\">$Up_Ex_MFR</TD>
								<TD width=\"4%\">$Up_Ex_PH</TD>
								<TD width=\"4%\">$Up_Ex_ST</TD>
								<TD width=\"4%\">$Up_Ex_VIS</TD>
								<TD width=\"4%\">$Up_Ex_Other</TD>
								<TD width=\"11%\">$Up_Ex_Specify</TD>
								<TD width=\"10%\">";
									if ($Up_Ex_Response == "Off") {echo "No Response";} else {echo "$Up_Ex_Response";}
							echo "</TD>
							</TR>";
						}
					
					if (isset($Should_ART) || isset($Should_BLT) || isset($Should_CR) || isset($Should_CS) || isset($Should_HVLA) || isset($Should_IND) || isset($Should_Lymph) || isset($Should_ME) || isset($Should_MFR) || isset($Should_PH) || isset($Should_ST) || isset($Should_VIS) || isset($Should_Other) || (strlen($Should_Specify) > 0) || ($Should_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Shoulder/Upper Arm </TD>
								<TD width=\"5%\">$Should_ART</TD>
								<TD width=\"5%\">$Should_BLT</TD>
								<TD width=\"5%\">$Should_CR</TD>
								<TD width=\"5%\">$Should_CS</TD>
								<TD width=\"5%\">$Should_HVLA</TD>
								<TD width=\"5%\">$Should_IND</TD>
								<TD width=\"5%\">$Should_Lymph</TD>
								<TD width=\"4%\">$Should_ME</TD>
								<TD width=\"4%\">$Should_MFR</TD>
								<TD width=\"4%\">$Should_PH</TD>
								<TD width=\"4%\">$Should_ST</TD>
								<TD width=\"4%\">$Should_VIS</TD>
								<TD width=\"4%\">$Should_Other</TD>
								<TD width=\"11%\">$Should_Specify</TD>
								<TD width=\"10%\">";
									if ($Should_Response == "Off") {echo "No Response";} else {echo "$Should_Response";}
							echo "</TD>
							</TR>";
						}
					
					if (isset($Elbow_ART) || isset($Elbow_BLT) || isset($Elbow_CR) || isset($Elbow_CS) || isset($Elbow_HVLA) || isset($Elbow_IND) || isset($Elbow_Lymph) || isset($Elbow_ME) || isset($Elbow_MFR) || isset($Elbow_PH) || isset($Elbow_ST) || isset($Elbow_VIS) || isset($Elbow_Other) || (strlen($Elbow_Specify) > 0) || ($Elbow_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Elbow/Forearm </TD>
								<TD width=\"5%\">$Elbow_ART</TD>
								<TD width=\"5%\">$Elbow_BLT</TD>
								<TD width=\"5%\">$Elbow_CR</TD>
								<TD width=\"5%\">$Elbow_CS</TD>
								<TD width=\"5%\">$Elbow_HVLA</TD>
								<TD width=\"5%\">$Elbow_IND</TD>
								<TD width=\"5%\">$Elbow_Lymph</TD>
								<TD width=\"4%\">$Elbow_ME</TD>
								<TD width=\"4%\">$Elbow_MFR</TD>
								<TD width=\"4%\">$Elbow_PH</TD>
								<TD width=\"4%\">$Elbow_ST</TD>
								<TD width=\"4%\">$Elbow_VIS</TD>
								<TD width=\"4%\">$Elbow_Other</TD>
								<TD width=\"11%\">$Elbow_Specify</TD>
								<TD width=\"10%\">";
									if ($Elbow_Response == "Off") {echo "No Response";} else {echo "$Elbow_Response";}
							echo "</TD>
							</TR>";
						}
					
					if (isset($Wrist_ART) || isset($Wrist_BLT) || isset($Wrist_CR) || isset($Wrist_CS) || isset($Wrist_HVLA) || isset($Wrist_IND) || isset($Wrist_Lymph) || isset($Wrist_ME) || isset($Wrist_MFR) || isset($Wrist_PH) || isset($Wrist_ST) || isset($Wrist_VIS) || isset($Wrist_Other) || (strlen($Wrist_Specify) > 0) || ($Wrist_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Wrist/Hand </TD>
								<TD width=\"5%\">$Wrist_ART</TD>
								<TD width=\"5%\">$Wrist_BLT</TD>
								<TD width=\"5%\">$Wrist_CR</TD>
								<TD width=\"5%\">$Wrist_CS</TD>
								<TD width=\"5%\">$Wrist_HVLA</TD>
								<TD width=\"5%\">$Wrist_IND</TD>
								<TD width=\"5%\">$Wrist_Lymph</TD>
								<TD width=\"4%\">$Wrist_ME</TD>
								<TD width=\"4%\">$Wrist_MFR</TD>
								<TD width=\"4%\">$Wrist_PH</TD>
								<TD width=\"4%\">$Wrist_ST</TD>
								<TD width=\"4%\">$Wrist_VIS</TD>
								<TD width=\"4%\">$Wrist_Other</TD>
								<TD width=\"11%\">$Wrist_Specify</TD>
								<TD width=\"10%\">";
									if ($Wrist_Response == "Off") {echo "No Response";} else {echo "$Wrist_Response";}
							echo "</TD>
							</TR>";
						}
					
					if (isset($Low_Ex_ART) || isset($Low_Ex_BLT) || isset($Low_Ex_CR) || isset($Low_Ex_CS) || isset($Low_Ex_HVLA) || isset($Low_Ex_IND) || isset($Low_Ex_Lymph) || isset($Low_Ex_ME) || isset($Low_Ex_MFR) || isset($Low_Ex_PH) || isset($Low_Ex_ST) || isset($Low_Ex_VIS) || isset($Low_Ex_Other) || (strlen($Low_Ex_Specify) > 0) || ($Low_Ex_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Lower Extremities </TD>
								<TD width=\"5%\">$Low_Ex_ART</TD>
								<TD width=\"5%\">$Low_Ex_BLT</TD>
								<TD width=\"5%\">$Low_Ex_CR</TD>
								<TD width=\"5%\">$Low_Ex_CS</TD>
								<TD width=\"5%\">$Low_Ex_HVLA</TD>
								<TD width=\"5%\">$Low_Ex_IND</TD>
								<TD width=\"5%\">$Low_Ex_Lymph</TD>
								<TD width=\"4%\">$Low_Ex_ME</TD>
								<TD width=\"4%\">$Low_Ex_MFR</TD>
								<TD width=\"4%\">$Low_Ex_PH</TD>
								<TD width=\"4%\">$Low_Ex_ST</TD>
								<TD width=\"4%\">$Low_Ex_VIS</TD>
								<TD width=\"4%\">$Low_Ex_Other</TD>
								<TD width=\"11%\">$Low_Ex_Specify</TD>
								<TD width=\"10%\">";
									if ($Low_Ex_Response == "Off") {echo "No Response";} else {echo "$Low_Ex_Response";}
							echo "</TD>
							</TR>";
						}
					
					if (isset($Thigh_ART) || isset($Thigh_BLT) || isset($Thigh_CR) || isset($Thigh_CS) || isset($Thigh_HVLA) || isset($Thigh_Ind) || isset($Thigh_Lymph) || isset($Thigh_ME) || isset($Thigh_MFR) || isset($Thigh_PH) || isset($Thigh_ST) || isset($Thigh_VIS) || isset($Thigh_Other) || (strlen($Thigh_Specify) > 0) || ($Thigh_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Thigh </TD>
								<TD width=\"5%\">$Thigh_ART</TD>
								<TD width=\"5%\">$Thigh_BLT</TD>
								<TD width=\"5%\">$Thigh_CR</TD>
								<TD width=\"5%\">$Thigh_CS</TD>
								<TD width=\"5%\">$Thigh_HVLA</TD>
								<TD width=\"5%\">$Thigh_Ind</TD>
								<TD width=\"5%\">$Thigh_Lymph</TD>
								<TD width=\"4%\">$Thigh_ME</TD>
								<TD width=\"4%\">$Thigh_MFR</TD>
								<TD width=\"4%\">$Thigh_PH</TD>
								<TD width=\"4%\">$Thigh_ST</TD>
								<TD width=\"4%\">$Thigh_VIS</TD>
								<TD width=\"4%\">$Thigh_Other</TD>
								<TD width=\"11%\">$Thigh_Specify</TD>
								<TD width=\"10%\">";
									if ($Thigh_Response == "Off") {echo "No Response";} else {echo "$Thigh_Response";}
							echo "</TD>
							</TR>";
						}
					
					if (isset($Knee_ART) || isset($Knee_BLT) || isset($Knee_CR) || isset($Knee_CS) || isset($Knee_HVLA) || isset($Knee_IND) || isset($Knee_Lymph) || isset($Knee_ME) || isset($Knee_MFR) || isset($Knee_PH) || isset($Knee_PH) || isset($Knee_VIS) || isset($Knee_Other) || (strlen($Knee_Specify) > 0) || ($Knee_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Knee/Calf/Shin </TD>
								<TD width=\"5%\">$Knee_ART</TD>
								<TD width=\"5%\">$Knee_BLT</TD>
								<TD width=\"5%\">$Knee_CR</TD>
								<TD width=\"5%\">$Knee_CS</TD>
								<TD width=\"5%\">$Knee_HVLA</TD>
								<TD width=\"5%\">$Knee_IND</TD>
								<TD width=\"5%\">$Knee_Lymph</TD>
								<TD width=\"4%\">$Knee_ME</TD>
								<TD width=\"4%\">$Knee_MFR</TD>
								<TD width=\"4%\">$Knee_PH</TD>
								<TD width=\"4%\">$Knee_PH</TD>
								<TD width=\"4%\">$Knee_VIS</TD>
								<TD width=\"4%\">$Knee_Other</TD>
								<TD width=\"11%\">$Knee_Specify</TD>
								<TD width=\"10%\">";
									if ($Knee_Response == "Off") {echo "No Response";} else {echo "$Knee_Response";}
							echo "</TD>
							</TR>";
						}
					
					if (isset($Ankle_ART) || isset($Ankle_BLT) || isset($Ankle_CR) || isset($Ankle_CS) || isset($Ankle_HVLA) || isset($Ankle_IND) || isset($Ankle_Lymph) || isset($Ankle_ME) || isset($Ankle_MFR) || isset($Ankle_PH) || isset($Ankle_ST) || isset($Ankle_VIS) || isset($Ankle_Other) || (strlen($Ankle_Specify) > 0) || ($Ankle_Response !== "Off"))
						{
							echo "
							<TR>
								<TD width=\"25%\"> Ankle/Foot </TD>
								<TD width=\"5%\">$Ankle_ART</TD>
								<TD width=\"5%\">$Ankle_BLT</TD>
								<TD width=\"5%\">$Ankle_CR</TD>
								<TD width=\"5%\">$Ankle_CS</TD>
								<TD width=\"5%\">$Ankle_HVLA</TD>
								<TD width=\"5%\">$Ankle_IND</TD>
								<TD width=\"5%\">$Ankle_Lymph</TD>
								<TD width=\"4%\">$Ankle_ME</TD>
								<TD width=\"4%\">$Ankle_MFR</TD>
								<TD width=\"4%\">$Ankle_PH</TD>
								<TD width=\"4%\">$Ankle_ST</TD>
								<TD width=\"4%\">$Ankle_VIS</TD>
								<TD width=\"4%\">$Ankle_Other</TD>
								<TD width=\"11%\">$Ankle_Specify</TD>
								<TD width=\"10%\">";
									if ($Ankle_Response == "Off") {echo "No Response";} else {echo "$Ankle_Response";}
							echo "</TD>
							</TR>";
						}
						
					echo "<TR>
							<TH width=\"100%\"><center> Diagnoses Documentation </center></TH></TR>";
							
					if (isset($C739)) 
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"16\"> Somatic Dysfunction of Head/Face (739.0)</TD>
							</TR>";
						}
					
					if (isset($C739_1))
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"16\"> Somatic Dysfunction of Neck (739.1)</TD>
							</TR>";
						}
					
					if (isset($C739_2))
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"16\"> Somatic Dysfunction of Thoracic (739.2)</TD>
							</TR>";
						}
					
					if (isset($C739_8))
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"16\"> Somatic Dysfunction of Ribs (739.8)</TD>
							</TR>";
						}
					
					if (isset($C739_3))
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"16\"> Somatic Dysfunction of Lumbar (739.3)</TD>
							</TR>";
						}
					
					if (isset($C739_4))
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"16\"> Somatic Dysfunction of Sacrum (739.4)</TD>
							</TR>";
						}
					
					if (isset($C739_5))
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"16\"> Somatic Dysfunction of Pelvis (739.5)</TD>
							</TR>";
						}
					
					if (isset($C739_9))
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"16\"> Somatic Dysfunction of Abdomen/Other (739.9)</TD>
							</TR>";
						}
					
					if (isset($C739_7))
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"16\"> Somatic Dysfunction of Upper Extremity (739.7)</TD>
							</TR>";
						}
					
					if (isset($C739_6))
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"16\"> Somatic Dysfunction of Lower Extremity (739.6)</TD>
							</TR>";
						}
					
					if ((strlen($Written_Diagnosis_1) > 0) || (strlen($Diagnosis_Code_1) > 0) || (isset($Chief_Related_1) && ($Chief_Related_1 !== "Off")) || (isset($SD_Related_1) && ($SD_Related_1 !== "Off")))
						{
							echo "
							<TR> 
								<TD width=\"40%\" colspan=\"6\">$Written_Diagnosis_1</TD>
								<TD width=\"20%\"colspan=\"3\">$Diagnosis_Code_1</TD>
								<TD width=\"20%\"colspan=\"3\">Related to Chief Complaint?  ";
									if (isset($Chief_Related_1) && ($Chief_Related_1 !== "Off")) {echo "$Chief_Related_1";} else {echo "No Response";}
							echo "</TD>
								<TD width=\"20%\"colspan=\"3\">Related to Somatic Dysfunction?  ";
									if (isset($SD_Related_1) && ($SD_Related_1 !== "Off")) {echo "$SD_Related_1";} else {echo "No Response";}
							echo "</TD>
							</TR>";
						}
					
					if ((strlen($Written_Diagnosis_2) > 0) || (strlen($Diagnosis_Code_2) > 0) || (isset($Chief_Related_2) && ($Chief_Related_2 !== "Off")) || (isset($SD_Related_2) && ($SD_Related_2 !== "Off")))
						{
							echo "
							<TR> 
								<TD width=\"40%\" colspan=\"6\">$Written_Diagnosis_2</TD>
								<TD width=\"20%\" colspan=\"3\">$Diagnosis_Code_2</TD>
								<TD width=\"20%\" colspan=\"3\">Related to Chief Complaint?  ";
									if (isset($Chief_Related_2) && ($Chief_Related_2 !== "Off")) {echo "$Chief_Related_2";} else {echo "No Response";}
							echo "</TD>
								<TD width=\"20%\"colspan=\"3\">Related to Somatic Dysfunction?  ";
									if (isset($SD_Related_2) && ($SD_Related_2 !== "Off")) {echo "$SD_Related_2";} else {echo "No Response";}
							echo "</TD>
							</TR>";
						}
					
					if ((strlen($Written_Diagnosis_3) > 0) || (strlen($Diagnosis_Code_3) > 0) || (isset($Chief_Related_3) && ($Chief_Related_3 !== "Off")) || (isset($SD_Related_3) && ($SD_Related_3 !== "Off")))
						{
							echo "
							<TR> 
								<TD width=\"40%\" colspan=\"6\">$Written_Diagnosis_3</TD>
								<TD width=\"20%\" colspan=\"3\">$Diagnosis_Code_3</TD>
								<TD width=\"20%\" colspan=\"3\">Related to Chief Complaint?  ";
									if (isset($Chief_Related_3) && ($Chief_Related_3 !== "Off")) {echo "$Chief_Related_3";} else {echo "No Response";}
							echo "</TD>
								<TD width=\"20%\"colspan=\"3\">Related to Somatic Dysfunction?  ";
									if (isset($SD_Related_3) && ($SD_Related_3 !== "Off")) {echo "$SD_Related_3";} else {echo "No Response";}
							echo "</TD>
							</TR>";
						}
					
					if ((strlen($Written_Diagnosis_4) > 0) || (strlen($Diagnosis_Code_4) > 0) || (isset($Chief_Related_4) && ($Chief_Related_4 !== "Off")) || (isset($SD_Related_4) && ($SD_Related_4 !== "Off")))
						{
							echo "
							<TR> 
								<TD width=\"40%\" colspan=\"6\">$Written_Diagnosis_4</TD>
								<TD width=\"20%\" colspan=\"3\">$Diagnosis_Code_4</TD>
								<TD width=\"20%\" colspan=\"3\">Related to Chief Complaint?  ";
									if (isset($Chief_Related_4) && ($Chief_Related_4 !== "Off")) {echo "$Chief_Related_4";} else {echo "No Response";}
							echo "</TD>
								<TD width=\"20%\"colspan=\"3\">Related to Somatic Dysfunction?  ";
									if (isset($SD_Related_4) && ($SD_Related_4 !== "Off")) {echo "$SD_Related_4";} else {echo "No Response";}
							echo "</TD>
							</TR>";
						}
					
					if ((strlen($Written_Diagnosis_5) > 0) || (strlen($Diagnosis_Code_5) > 0) || (isset($Chief_Related_5) && ($Chief_Related_5 !== "Off")) || (isset($SD_Related_5) && ($SD_Related_5 !== "Off"))) 
						{
							echo "
							<TR> 
								<TD width=\"40%\" colspan=\"6\">$Written_Diagnosis_5</TD>
								<TD width=\"20%\" colspan=\"3\">$Diagnosis_Code_5</TD>
								<TD width=\"20%\" colspan=\"3\">Related to Chief Complaint?  ";
									if (isset($Chief_Related_5) && ($Chief_Related_5 !== "Off")) {echo "$Chief_Related_5";} else {echo "No Response";}
							echo "</TD>
								<TD width=\"20%\"colspan=\"3\">Related to Somatic Dysfunction?  ";
									if (isset($SD_Related_5) && ($SD_Related_6 !== "Off")) {echo "$SD_Related_5";} else {echo "No Response";}
							echo "</TD>
							</TR>";
						}
					
					if ((strlen($Written_Diagnosis_6) > 0) || (strlen($Diagnosis_Code_6) > 0) || (isset($Chief_Related_6) && ($Chief_Related_6 !== "Off")) || (isset($SD_Related_6) && ($SD_Related_6 !== "Off"))) 
						{
							echo "
							<TR> 
								<TD width=\"40%\" colspan=\"6\">$Written_Diagnosis_6</TD>
								<TD width=\"20%\" colspan=\"3\">$Diagnosis_Code_6</TD>
								<TD width=\"20%\" colspan=\"3\">Related to Chief Complaint?  ";
									if (isset($Chief_Related_6) && ($Chief_Related_6 !== "Off")) {echo "$Chief_Related_6";} else {echo "No Response";}
							echo "</TD>
								<TD width=\"20%\"colspan=\"3\">Related to Somatic Dysfunction?  ";
									if (isset($SD_Related_6) && ($SD_Related_6 !== "Off")) {echo "$SD_Related_6";} else {echo "No Response";}
							echo "</TD>
							</TR>";
						}
					
					if ((strlen($Written_Diagnosis_7) > 0) || (strlen($Diagnosis_Code_7) > 0) || (isset($Chief_Related_7) && ($Chief_Related_7 !== "Off")) || (isset($SD_Related_7) && ($SD_Related_7 !== "Off")))
						{
							echo "
							<TR> 
								<TD width=\"40%\" colspan=\"6\">$Written_Diagnosis_7</TD>
								<TD width=\"20%\" colspan=\"3\">$Diagnosis_Code_7</TD>
								<TD width=\"20%\" colspan=\"3\">Related to Chief Complaint?  ";
									if (isset($Chief_Related_7) && ($Chief_Related_7 !== "Off")) {echo "$Chief_Related_7";} else {echo "No Response";}
							echo "</TD>
								<TD width=\"20%\"colspan=\"3\">Related to Somatic Dysfunction? ";
									if (isset($SD_Related_7) && ($SD_Related_7 !== "Off")) {echo "$SD_Related_7";} else {echo "No Response";}
							echo "</TD>
							</TR>";
						}
						
					if ((strlen($Procuedures_1) > 0) || (strlen($Procedures_2) > 0) || (strlen($Procedures_3) > 0) || (strlen($Procedures_4) > 0) || (strlen($Procedures_5) > 0))
						{
							echo "<TR>
							<TH width=\"100%\"><center> Additional Procedures/Interventions </center></TH></TR>";
						}
							
					if (strlen($Procuedures_1) > 0)
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"15\">$Procuedures_1</TD>
							</TR>";
						}

					if (strlen($Procedures_2) > 0)
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"15\">$Procedures_2</TD>
							</TR>";
						}

					if (strlen($Procedures_3) > 0)
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"15\">$Procedures_3</TD>
							</TR>";
						}

					if (strlen($Procedures_4) > 0)
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"15\">$Procedures_4</TD>
							</TR>";
						}

					if (strlen($Procedures_5) > 0)
						{
							echo "
							<TR>
								<TD width=\"100%\" colspan=\"15\">$Procedures_5</TD>
							</TR>";
						}
				echo "
					</tbody2>	
					</TABLE>";
				}
			
			
		echo "
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
							if (isset($_POST["$e_id-followup_isae"])) { $followup_adverse_event = $_POST["$e_id-followup_isae"]; } else { $followup_adverse_event = NULL; }
							if (isset($_POST["$e_id-ae_severity"])) { $ae_severity = $_POST["$e_id-ae_severity"]; } else { $ae_severity = NULL; }
							if (isset($_POST["$e_id-omt_related"])) { $omt_related = $_POST["$e_id-omt_related"]; } else { $omt_related = NULL; }
						
							if (!($vote_QUERY = $dblink->prepare("
								INSERT INTO 
									jury_room.review 
										(	user_id,
											phase,
											event_id, 
											comment,
											24hr_adverse_event,
											72hr_adverse_event,
											1wk_adverse_event,
											followup_adverse_event,
											ae_severity,
											omt_related) 
										VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);"))) {logger(__LINE__, "SQLi Prepare: $vote_QUERY->error");}
							if (!($vote_QUERY->bind_param('ssssssssss', $_SESSION['id'], $phase, $e_id, $comment, $p24hr_adverse_event, $p72hr_adverse_event, $p1wk_adverse_event, $followup_adverse_event, $ae_severity, $omt_related))) { logger(__LINE__, "SQLi Bind Error: $vote_QUERY->error"); }
							if (!($vote_QUERY->execute())) { logger(__LINE__, "SQLi execute: $vote_QUERY->error"); }
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