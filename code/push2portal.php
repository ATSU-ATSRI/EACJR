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


	//This is the input list of files from the data generated and import list.
	$filelist = file('../input_data/filelist.txt',FILE_SKIP_EMPTY_LINES);
	
	if ($filelist !== FALSE)
		{
			foreach ($filelist as $filename)
				{
					logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
					logger(__LINE__, "Converting Filename: " . $filename);
					$filename = trim(substr($filename, strrpos($filename, "\\") + 1));
					$filename = "../input_data/" . $filename;
					logger(__LINE__, "Processing Filename: " . $filename);
					$input_filename = fopen($filename,"rb");
					$load_header = "1";
					if (isset($header_array)) {unset($header_array);}
					while (($input_data = fgetcsv($input_filename)) !== FALSE)
						{
							// Header translator (Because REDCap is stupid.)

							if (isset($load_header))
								{
									$header_array = array("study_id","record_id","consent_yn","visit_days","coup_how_d1","study_part_yn_d1","cal_yr_comp_d1","code","doctor","age_d1","sex_d1","ethnicity_d1","race_d1___1","race_d1___2","race_d1___3","race_d1___4","race_d1___5","race_d1___6","race_d1___7","other_race_d1","pain_hf_sympt_d1","pain_neck_sympt_d1","pain_up_back_sympt_d1","pain_chest_sympt_d1","pain_low_back_sympt_d1","pain_tail_sympt_d1","pain_hip_sympt_d1","pain_abd_sympt_d1","pain_arm_sympt_d1","pain_leg_sympt_d1","rad_pain_sympt_d1","stiff_sympt_d1","swell_sympt_d1","weak_sympt_d1","numb_sympt_d1","tired_sympt_d1","head_sympt_d1","lt_head_sympt_d1","vis_sympt_d1","sleep_sympt_d1","irrit_sympt_d1","talk_sympt_d1","nausea_sympt_d1","walk_sympt_d1","tinn_sympt_d1","rad_pain_reg_d1","stiff_reg_d1","swell_reg_d1","weak_reg_d1","numb_reg_d1","no_symp_com_d1","worst1_hf_d1","related_hf_d1","recent_hf_d1","worst_hf_d1","worst1_neck_d1","related_neck_d1","recent_neck_d1","worst_neck_d1","worst1_up_back_d1","related_up_back_d1","recent_up_back_d1","worst_up_back_d1","worst1_chest_d1","related_chest_d1","recent_chest_d1","worst_chest_d1","worst1_low_back_d1","related_low_back_d1","recent_low_back_d1","worst_low_back_d1","worst1_tail_d1","related_tail_d1","recent_tail_d1","worst_tail_d1","worst1_hip_d1","related_hip_d1","recent_hip_d1","worst_hip_d1","worst1_abd_d1","related_abd_d1","recent_abd_d1","worst_abd_d1","worst1_arm_d1","related_arm_d1","recent_arm_d1","worst_arm_d1","worst1_leg_d1","related_leg_d1","recent_leg_d1","worst_leg_d1","worst1_rad_pain_d1","related_red_pain_d1","recent_rad_pain_d1","worst_rad_pain_d1","worst1_stiff_d1","related_stiff_d1","recent_stiff_d1","worst_stiff_d1","worst1_swell_d1","related_swell_d1","recent_swell_d1","worst_swell_d1","worst1_weak_d1","related_weak_d1","recent_weak_d1","worst_weak_d1","worst1_numb_d1","related_numb_d1","recent_numb_d1","worst_numb_d1","worst1_tired_d1","related_tired_d1","recent_tired_d1","worst_tired_d1","worst1_head_d1","related_head_d1","recent_head_d1","worst_head_d1","worst1_lt_head_d1","related_lt_head_d1","recent_lt_head_d1","worst_lt_head_d1","worst1_vision_d1","related_vis_d1","recent_vis_d1","worst_sev_d1","worst1_sleep_d1","related_sleep_d1","recent_sleep_d1","worst_sleep_d1","worst1_irrit_d1","related_irrit_d1","recent_irrit_d1","worst_irrit_d1","worst1_talk_d1","related_talk_d1","recent_talk_d1","worst_talk_d1","worst1_nausea_d1","related_naus_d1","recent_naus_d1","worst_naus_d1","worst1_walk_d1","related_walk_d1","recent_walk_d1","worst_walk_d1","worst1_tinn_d1","related_tinn_d1","recent_tinn_d1","worst_tinn_d1","other1_sympt_d1","other1_sympt_name_d1","worst1_other1_d1","related_other1_d1","recent_other1_d1","worst_other1_d1","other2_sympt_d1","other2_sympt_name_d1","worst1_other2_d1","related_other2_d1","recent_other2_d1","worst_other2_d1","details_d1","email_address_d1","omt_adverse_events_study_24hour_survey_complete","pain_head_face_d3","pain_neck_d3","pain_up_back_d3","pain_chest_d3","pain_low_back_d3","pain_tail_d3","pain_hip_d3","pain_abd_d3","pain_arm_d3","pain_leg_d3","rad_pain_d3","stiff_d3","swell_d3","weak_d3","numb_d3","tire_d3","headache_d3","lt_head_d3","vision_d3","sleep_d3","irrit_d3","talk_d3","nausea_d3","walk_d3","tinn_d3","rad_pain_reg_d3","stiff_reg_d3","swell_reg_d3","weak_reg_d3","numb_reg_d3","no_symp_comp_d3","day_severity_head_face_d3","related_head_face_d3","head_face_6week_d3","head_face_worst_d3","day_severity_neck_d3","related_neck_d3","neck_6week_d3","neck_worst_d3","day_severity_up_back_d3","related_up_back_d3","up_back_6week_d3","up_back_worst_d3","day_severity_chest_d3","related_chest_d3","chest_6week_d3","chest_worst_d3","day_low_back_d3","related_low_back_d3","low_back_6week_d3","low_back_worst_d3","day_severity_tail_d3","related_tail_d3","tail_6week_d3","tail_worst_d3","day_severity_hip_d3","related_hip_d3","hip_6week_d3","hip_worst_d3","day_severity_abd_d3","related_abd_d3","abd_6week_d3","abd_worst_d3","day_severity_arm_d3","related_arm_d3","arm_6week_d3","arm_worst_d3","day_severity_leg_d3","related_leg_d3","leg_6week_d3","leg_worst_d3","day_severity_rad_pain_d3","related_rad_pain_d3","rad_pain_6week_d3","rad_pain_worst_d3","day_severity_stiff_d3","related_stiff_d3","stiff_6week_d3","stiff_worst_d3","day_severity_swell_d3","related_swell_d3","swell_6week_d3","swell_worst_d3","day_severity_weak_d3","related_weak_d3","weak_6week_d3","weak_worst_d3","day_severity_numb_d3","related_numb_d3","numb_6week_d3","numb_worst_d3","day_severity_tire_d3","related_tire_d3","tire_6week_d3","tire_worst_d3","day_severity_head_d3","related_head_d3","head_6week_d3","head_worst_d3","day_severity_lt_head_d3","related_lt_head_d3","lt_head_6week_d3","lt_head_worst_d3","day_severity_vision_d3","related_vision_d3","vision_6week_d3","vision_worst_d3","day_severity_sleep_d3","related_sleep_d3","sleep_6week_d3","sleep_worst_d3","day_severity_irrit_d3","related_irrit_d3","irrit_6week_d3","irrit_worst_d3","day_severity_talk_d3","related_talk_d3","talk_6week_d3","talk_worst_d3","day_severity_nausea_d3","related_nausea_d3","nausea_6week_d3","nausea_worst_d3","day_severity_walk_d3","related_walk_d3","walk_6week_d3","walk_worst_d3","day_severity_tinn_d3","related_tinn_d3","tinn_6week_d3","tinn_worst_d3","other_yn_d3","other1_sympt_name_d3","day_severity_other1_d3","related_other1_d3","other1_6week_d3","other1_worst_d3","other2_yn_d3","other2_sympt_name_d3","day_severity_other2_d3","related_other2_d3","other2_6week_d3","other2_worst_d3","details_d3","omt_adverse_events_study_midweek_survey_complete","pain_hf_sympt_d7","pain_neck_sympt_d7","pain_ub_sympt_d7","pain_chest_sympt_d7","pain_low_back_sympt_d7","pain_tail_sympt_d7","pain_hip_sympt_d7","pain_abd_sympt_d7","pain_arm_sympt_d7","pain_leg_sympt_d7","rad_pain_sympt_d7","stiff_sympt_d7","swell_sympt_d7","weak_sympt_d7","numb_sympt_d7","tired_sympt_d7","head_sympt_d7","lt_head_sympt_d7","vis_sympt_d7","sleep_sympt_d7","irrit_sympt_d7","talk_sympt_d7","nausea_sympt_d7","walk_symbp_d7","tinn_sympt_d7","other1_sympt_d7","other2_sympt_d7","follow_clinic_yn_d7","fu_visit_d7","why_clinic_d7","uc_yn_d7","uc_hc_visit_d7","why_uc_d7","er_yn_d7","er_hc_visit_d7","why_er_d7","hosp_yn_d7","hosp_hc_visit_d7","why_hosp_d7","details_d7","further_yn_d7","further_omt_why_d7","future_yn_d7","future_why_d7","omt_adverse_events_study_1week_survey_complete","survey_format","survey_format_complete");
									unset($load_header); // header array loaded, clear and get pt. info
									
								}
								else
								{
									
									// clear vars
									if (isset($code)) {unset($code);}
									if (isset($study_id)) {unset($study_id);}
									if (isset($survey_rec_id)) {unset($survey_rec_id);}
									if (isset($consent)) {unset($consent);}
									if (isset($visit_days)) {unset($visit_days);}
									if (isset($doctor)) {unset($doctor);}
									if (isset($age)) {unset($age);}
									if (isset($sex)) {unset($sex);}
									if (isset($ethnicity)) {unset($ethnicity);}
									if (isset($race)) {unset($race);}
									if (isset($race_other)) {unset($race_other);}
									if (isset($further_yn)) {unset($further_yn);}
									if (isset($further_why)) {unset($further_why);}
									if (isset($future_yn)) {unset($future_yn);}
									if (isset($future_why)) {unset($future_why);}
									if (isset($paper)) {unset($paper);}
									if (isset($complete)) {unset($complete);}
									
									// data collection
									// pt. data
									$code = $input_data[array_search("code", $header_array, TRUE)];			// the study code that is located on the survey packet
									$study_id = $input_data[array_search("study_id", $header_array, TRUE)];		// what study is this in? (This # is inseted in the csv!!!)
									$survey_rec_id = $input_data[array_search("record_id", $header_array, TRUE)];	// what is this pt.'s study id?
									$consent = $input_data[array_search("consent_yn", $header_array, TRUE)];
									$visit_days = $input_data[array_search("visit_days", $header_array, TRUE)];
									$doctor = $input_data[array_search("doctor", $header_array, TRUE)];
									$age = $input_data[array_search("age_d1", $header_array, TRUE)];
									$sex = $input_data[array_search("sex_d1", $header_array, TRUE)];
									$ethnicity = $input_data[array_search("ethnicity_d1", $header_array, TRUE)];
									// race
										if ($input_data[array_search("race_d1___1", $header_array, TRUE)] == "1") { $race = "White";}
										if ($input_data[array_search("race_d1___2", $header_array, TRUE)] == "1") { $race = "Black or African American";}
										if ($input_data[array_search("race_d1___3", $header_array, TRUE)] == "1") { $race = "Asian";}
										if ($input_data[array_search("race_d1___4", $header_array, TRUE)] == "1") { $race = "American Indian or Alaska Native";}
										if ($input_data[array_search("race_d1___5", $header_array, TRUE)] == "1") { $race = "Native Hawaiian or Other Pacific Islander";}
										if ($input_data[array_search("race_d1___6", $header_array, TRUE)] == "1") { $race = "Other";}
										if ($input_data[array_search("race_d1___7", $header_array, TRUE)] == "1") { $race = "Prefer not to answer";}
									$race_other = $input_data[array_search("other_race_d1", $header_array, TRUE)];
									$further_yn = $input_data[array_search("further_yn_d7", $header_array, TRUE)];
									$further_why = $input_data[array_search("further_omt_why_d7", $header_array, TRUE)];
									$future_yn = $input_data[array_search("future_yn_d7", $header_array, TRUE)];
									$future_why = $input_data[array_search("future_why_d7", $header_array, TRUE)];
									$paper = $input_data[array_search("survey_format", $header_array, TRUE)];
									$complete = $input_data[array_search("survey_format_complete", $header_array, TRUE)];
									
									if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.patient (`code`, `study_id`, `survey_rec_id`, `consent`, `visit_days`, `doctor`, `age`, `sex`, `ethnicity`, `race`, `race_other`, `further_yn`, `further_why`, `future_yn`, `future_why`, `paper`, `complete`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
									if (!($insert_SQL->bind_param('sssssssssssssssss', $code, $study_id, $survey_rec_id, $consent, $visit_days, $doctor, $age, $sex, $ethnicity, $race, $race_other, $further_yn, $further_why, $future_yn, $future_why, $paper, $complete))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
									logger(__LINE__, "Inserting patient record: " . $code);
									logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
									if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
									unset($insert_SQL);
									
									
									// symptom
									
											if (isset($symptom)) {unset($symptom);}
											if (isset($pt_baseline)) {unset($pt_baseline);}
											if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
											if (isset($pt_24hr)) {unset($pt_24hr);}
											if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
											if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
											if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
											if (isset($pt_72hr))	{unset($pt_72hr);}
											if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
											if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
											if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
											if (isset($pt_1wk)) {unset($pt_1wk);}
											if (isset($insert_SQL)) {unset($insert_SQL);}
									
										// Pain/Discomfort in Head/Face (including Jaw, not including Headache)						
											if (strlen($input_data[array_search("pain_hf_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_head_face_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_hf_sympt_d7", $header_array, TRUE)]) > 0)
												{
													$symptom = "Pain/Discomfort in Head/Face (including Jaw, not including Headache)";
													if (strlen($input_data[array_search("pain_hf_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_hf_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_hf_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_hf_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_hf_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_hf_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_hf_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_hf_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_hf_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_hf_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_hf_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_hf_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_hf_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_hf_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_hf_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_hf_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_hf_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_head_face_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_head_face_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_head_face_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_head_face_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_head_face_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_head_face_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_head_face_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_head_face_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_head_face_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_head_face_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_head_face_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("head_face_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("head_face_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("head_face_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("head_face_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("head_face_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("head_face_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}													
														}
														
													if (strlen($input_data[array_search("pain_hf_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("pain_hf_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("pain_hf_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("pain_hf_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("pain_hf_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("pain_hf_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
										
										// Pain/Discomfort in Neck
											if (strlen($input_data[array_search("pain_neck_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_neck_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_neck_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Pain/Discomfort in Neck";
													if (strlen($input_data[array_search("pain_neck_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															if ($input_data[array_search("worst1_neck_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_neck_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_neck_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_neck_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_neck_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_neck_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_neck_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_neck_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_neck_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_neck_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_neck_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_neck_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_neck_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_neck_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_neck_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_neck_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
													if (strlen($input_data[array_search("pain_neck_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_neck_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_neck_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_neck_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_neck_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_neck_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_neck_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_neck_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_neck_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_neck_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_neck_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("neck_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("neck_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("neck_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("neck_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("neck_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("neck_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_neck_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("pain_neck_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("pain_neck_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("pain_neck_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("pain_neck_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("pain_neck_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
										
										// Pain/Discomfort in Upper Back
											if (strlen($input_data[array_search("pain_up_back_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_up_back_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_ub_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Pain/Discomfort in Upper Back";
													if (strlen($input_data[array_search("pain_up_back_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_up_back_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_up_back_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_up_back_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_up_back_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_up_back_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_up_back_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_up_back_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_up_back_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_up_back_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_up_back_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_up_back_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_up_back_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_up_back_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_up_back_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_up_back_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_up_back_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
													if (strlen($input_data[array_search("pain_up_back_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_up_back_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_up_back_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_up_back_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_up_back_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_up_back_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_up_back_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_up_back_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_up_back_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_up_back_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_up_back_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("up_back_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("up_back_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("up_back_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("up_back_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("up_back_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("up_back_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_ub_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("pain_ub_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("pain_ub_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("pain_ub_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("pain_ub_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("pain_ub_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
										
										// Pain/Discomfort in Chest/Ribs
											if (strlen($input_data[array_search("pain_chest_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_chest_d3", $header_array, TRUE)]) > 0  || strlen($input_data[array_search("pain_chest_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Pain/Discomfort in Chest/Ribs";
													if (strlen($input_data[array_search("pain_chest_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_chest_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_chest_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_chest_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_chest_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_chest_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_chest_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_chest_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_chest_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_chest_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_chest_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_chest_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_chest_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_chest_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_chest_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_chest_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_chest_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_chest_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_chest_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_chest_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_chest_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_chest_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_chest_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_chest_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_chest_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_chest_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_chest_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_chest_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("chest_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("chest_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("chest_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("chest_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("chest_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("chest_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_chest_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("pain_chest_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("pain_chest_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("pain_chest_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("pain_chest_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("pain_chest_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Pain/Discomfort in Lower Back
											if (strlen($input_data[array_search("pain_low_back_sympt_d1", $header_array, TRUE)]) > 0  || strlen($input_data[array_search("pain_low_back_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_low_back_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Pain/Discomfort in Lower Back";
													if (strlen($input_data[array_search("pain_low_back_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_low_back_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_low_back_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_low_back_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_low_back_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_low_back_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_low_back_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_low_back_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_low_back_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_low_back_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_low_back_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_low_back_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_low_back_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_low_back_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_low_back_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_low_back_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_low_back_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_low_back_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_low_back_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_low_back_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_low_back_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_low_back_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_low_back_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_low_back_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_low_back_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_low_back_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_low_back_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_low_back_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("low_back_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("low_back_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("low_back_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("low_back_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("low_back_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("low_back_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_low_back_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("pain_low_back_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("pain_low_back_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("pain_low_back_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("pain_low_back_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("pain_low_back_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
									
									// Pain/Discomfort in Tailbone/Sacrum
											if (strlen($input_data[array_search("pain_tail_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_tail_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_tail_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Pain/Discomfort in Tailbone/Sacrum";
													if (strlen($input_data[array_search("pain_tail_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_tail_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_tail_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_tail_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_tail_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_tail_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_tail_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_tail_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_tail_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_tail_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_tail_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_tail_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_tail_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_tail_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_tail_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_tail_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_tail_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_tail_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_tail_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_tail_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_tail_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_tail_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_tail_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_tail_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_tail_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_tail_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_tail_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_tail_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("tail_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("tail_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("tail_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("tail_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("tail_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("tail_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_tail_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("pain_tail_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("pain_tail_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("pain_tail_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("pain_tail_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("pain_tail_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Pain/Discomfort in Hip/Pelvis
											if (strlen($input_data[array_search("pain_hip_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_hip_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_hip_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Pain/Discomfort in Hip/Pelvis";
													if (strlen($input_data[array_search("pain_hip_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_hip_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_hip_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_hip_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_hip_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_hip_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_hip_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_hip_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_hip_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_hip_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_hip_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_hip_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_hip_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_hip_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_hip_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_hip_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_hip_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_hip_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_hip_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_hip_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_hip_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_hip_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_hip_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_hip_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_hip_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_hip_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_hip_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_hip_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("hip_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("hip_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("hip_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("hip_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("hip_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("hip_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_hip_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("pain_hip_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("pain_hip_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("pain_hip_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("pain_hip_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("pain_hip_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Pain/Discomfort in Abdomen
											if (strlen($input_data[array_search("pain_abd_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_abd_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_abd_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Pain/Discomfort in Abdomen";
													if (strlen($input_data[array_search("pain_abd_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_abd_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_abd_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_abd_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_abd_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_abd_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_abd_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_abd_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_abd_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_abd_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_abd_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_abd_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_abd_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_abd_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_abd_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_abd_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_abd_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_abd_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_abd_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_abd_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_abd_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_abd_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_abd_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_abd_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_abd_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_abd_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_abd_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_abd_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("abd_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("abd_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("abd_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("abd_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("abd_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("abd_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_abd_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("pain_abd_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("pain_abd_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("pain_abd_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("pain_abd_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("pain_abd_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}

									// Pain/Discomfort in Arm (Shoulder, Upper Arm, Elbow, Forearm, Wrist, or Hand)
											if (strlen($input_data[array_search("pain_arm_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_arm_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_arm_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Pain/Discomfort in Arm (Shoulder, Upper Arm, Elbow, Forearm, Wrist, or Hand)";
													if (strlen($input_data[array_search("pain_arm_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_arm_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_arm_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_arm_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_arm_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_arm_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_arm_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_arm_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_arm_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_arm_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_arm_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_arm_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_arm_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_arm_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_arm_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_arm_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_arm_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_arm_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_arm_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_arm_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_arm_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_arm_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_arm_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_arm_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_arm_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_arm_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_arm_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_arm_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("arm_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("arm_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("arm_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("arm_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("arm_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("arm_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_arm_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("pain_arm_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("pain_arm_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("pain_arm_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("pain_arm_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("pain_arm_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Pain/Discomfort in Leg (Thigh, Knee, Calf, Shin, Ankle, or Foot)
											if (strlen($input_data[array_search("pain_leg_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_leg_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("pain_leg_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Pain/Discomfort in Leg (Thigh, Knee, Calf, Shin, Ankle, or Foot)";
													if (strlen($input_data[array_search("pain_leg_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_leg_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_leg_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_leg_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_leg_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_leg_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_leg_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_leg_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_leg_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_leg_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_leg_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_leg_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_leg_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_leg_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_leg_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_leg_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_leg_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_leg_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_leg_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_leg_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_leg_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_leg_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_leg_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_leg_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_leg_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_leg_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_leg_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_leg_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("leg_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("leg_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("leg_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("leg_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("leg_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("leg_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("pain_leg_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("pain_leg_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("pain_leg_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("pain_leg_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("pain_leg_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("pain_leg_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
									
									// Radiating Pain ([rad_pain_reg_d3])
											if (strlen($input_data[array_search("rad_pain_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("rad_pain_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("rad_pain_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Radiating Pain";
												if (strlen($input_data[array_search("rad_pain_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															$symptom .= " $input_data[43]";
															
															if ($input_data[array_search("worst1_rad_pain_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_rad_pain_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_rad_pain_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_rad_pain_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_rad_pain_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_red_pain_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_red_pain_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_red_pain_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_red_pain_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_red_pain_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_rad_pain_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_rad_pain_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_rad_pain_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_rad_pain_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_rad_pain_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_rad_pain_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("rad_pain_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															if (strlen($input_data[array_search("rad_pain_reg_d1", $header_array, TRUE)]) < 1) { $symptom .= " ".$input_data[array_search("rad_pain_reg_d3", $header_array, TRUE)].""; }
															
															if ($input_data[array_search("day_severity_rad_pain_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_rad_pain_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_rad_pain_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_rad_pain_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_rad_pain_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_rad_pain_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_rad_pain_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_rad_pain_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_rad_pain_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_rad_pain_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("rad_pain_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("rad_pain_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("rad_pain_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("rad_pain_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("rad_pain_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("rad_pain_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("rad_pain_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("rad_pain_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("rad_pain_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("rad_pain_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("rad_pain_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("rad_pain_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Stiffness
											if (strlen($input_data[array_search("stiff_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("stiff_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("stiff_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Stiffness";
													if (strlen($input_data[array_search("stiff_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															$symptom .= " $input_data[44]";
															
															if ($input_data[array_search("worst1_stiff_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_stiff_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_stiff_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_stiff_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_stiff_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_stiff_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_stiff_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_stiff_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_stiff_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_stiff_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_stiff_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_stiff_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_stiff_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_stiff_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_stiff_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_stiff_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("stiff_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															if (strlen($input_data[array_search("stiff_reg_d1", $header_array, TRUE)]) < 1) { $symptom .= " ".$input_data[array_search("stiff_reg_d3", $header_array, TRUE)].""; }
															
															if ($input_data[array_search("day_severity_stiff_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_stiff_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_stiff_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_stiff_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_stiff_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_stiff_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_stiff_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_stiff_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_stiff_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_stiff_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("stiff_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("stiff_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("stiff_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("stiff_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("stiff_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("stiff_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("stiff_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("stiff_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("stiff_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("stiff_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("stiff_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("stiff_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Swelling
											if (strlen($input_data[array_search("swell_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("swell_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("swell_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Swelling";
													if (strlen($input_data[array_search("swell_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															$symptom .= " $input_data[45]";
															
															if ($input_data[array_search("worst1_swell_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_swell_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_swell_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_swell_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_swell_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_swell_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_swell_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_swell_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_swell_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_swell_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_swell_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_swell_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_swell_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_swell_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_swell_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_swell_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("swell_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															if (strlen($input_data[array_search("swell_reg_d1", $header_array, TRUE)]) < 1) { $symptom .= " ".$input_data[array_search("swell_reg_d3", $header_array, TRUE)].""; }
															
															if ($input_data[array_search("day_severity_swell_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_swell_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_swell_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_swell_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_swell_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_swell_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_swell_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_swell_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_swell_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_swell_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("swell_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("swell_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("swell_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("swell_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("swell_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("swell_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("swell_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("swell_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("swell_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("swell_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("swell_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("swell_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}		
												
										// Weakness
											if (strlen($input_data[array_search("weak_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("weak_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("weak_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Weakness";
													if (strlen($input_data[array_search("weak_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															$symptom .= " $input_data[46]";
															
															if ($input_data[array_search("worst1_weak_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_weak_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_weak_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_weak_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_weak_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_weak_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_weak_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_weak_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_weak_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_weak_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_weak_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_weak_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_weak_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_weak_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_weak_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_weak_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("weak_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															if (strlen($input_data[array_search("weak_reg_d1", $header_array, TRUE)]) < 1) { $symptom .= " ".$input_data[array_search("weak_reg_d3", $header_array, TRUE)].""; }
															
															if ($input_data[array_search("day_severity_weak_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_weak_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_weak_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_weak_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_weak_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_weak_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_weak_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_weak_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_weak_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_weak_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("weak_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("weak_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("weak_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("weak_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("weak_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("weak_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("weak_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("weak_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("weak_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("weak_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("weak_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("weak_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Numbness/Tingling
											if (strlen($input_data[array_search("numb_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("numb_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("numb_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Numbness/Tingling";
													if (strlen($input_data[array_search("numb_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															$symptom .= " $input_data[47]";
															
															if ($input_data[array_search("worst1_numb_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_numb_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_numb_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_numb_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_numb_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_numb_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_numb_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_numb_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_numb_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_numb_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_numb_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_numb_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_numb_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_numb_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_numb_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_numb_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("numb_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															if (strlen($input_data[array_search("numb_reg_d1", $header_array, TRUE)]) < 1) { $symptom .= " ".$input_data[array_search("numb_reg_d3", $header_array, TRUE)].""; }
															
															if ($input_data[array_search("day_severity_numb_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_numb_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_numb_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_numb_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_numb_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_numb_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_numb_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_numb_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_numb_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_numb_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("numb_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("numb_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("numb_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("numb_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("numb_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("numb_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("numb_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("numb_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("numb_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("numb_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("numb_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("numb_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}

										// Tiredness/Fatigue
											if (strlen($input_data[array_search("tired_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("tire_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("tired_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Tiredness/Fatigue";
													if (strlen($input_data[array_search("tired_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_tired_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_tired_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_tired_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_tired_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_tired_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_tired_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_tired_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_tired_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_tired_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_tired_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_tired_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_tired_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_tired_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_tired_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_tired_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_tired_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("tire_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_tire_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_tire_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_tire_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_tire_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_tire_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_tire_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_tire_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_tire_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_tire_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_tire_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("tire_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("tire_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("tire_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("tire_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("tire_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("tire_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("tired_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("tired_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("tired_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("tired_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("tired_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("tired_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Headache
											if (strlen($input_data[array_search("head_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("headache_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("head_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Headache";
													if (strlen($input_data[array_search("head_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_head_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_head_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_head_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_head_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_head_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_head_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_head_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_head_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_head_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_head_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_head_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_head_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_head_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_head_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_head_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_head_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("headache_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_head_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_head_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_head_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_head_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_head_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_head_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_head_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_head_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_head_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_head_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("head_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("head_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("head_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("head_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("head_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("head_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("head_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("head_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("head_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("head_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("head_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("head_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Light Headed (Fainting/Dizziness/Vertigo)
											if (strlen($input_data[array_search("lt_head_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("lt_head_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("lt_head_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Light Headed (Fainting/Dizziness/Vertigo)";
													if (strlen($input_data[array_search("lt_head_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_lt_head_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_lt_head_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_lt_head_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_lt_head_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_lt_head_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_lt_head_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_lt_head_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_lt_head_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_lt_head_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_lt_head_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_lt_head_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_lt_head_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_lt_head_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_lt_head_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_lt_head_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_lt_head_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("lt_head_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_lt_head_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_lt_head_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_lt_head_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_lt_head_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_lt_head_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_lt_head_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_lt_head_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_lt_head_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_lt_head_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_lt_head_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("lt_head_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("lt_head_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("lt_head_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("lt_head_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("lt_head_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("lt_head_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("lt_head_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("lt_head_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("lt_head_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("lt_head_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("lt_head_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("lt_head_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Vision Problems
											if (strlen($input_data[array_search("vis_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("vision_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("vis_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Vision Problems";
													if (strlen($input_data[array_search("vis_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_vision_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_vision_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_vision_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_vision_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_vision_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_vis_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_vis_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_vis_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_vis_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_vis_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_vis_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_sev_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_sev_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_sev_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_sev_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_sev_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("vision_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_vision_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_vision_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_vision_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_vision_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_vision_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_vision_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_vision_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_vision_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_vision_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_vision_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("vision_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("vision_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("vision_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("vision_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("vision_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("vision_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("vis_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("vis_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("vis_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("vis_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("vis_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("vis_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Problems Sleeping
											if (strlen($input_data[array_search("sleep_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("sleep_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("sleep_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Problems Sleeping";
													if (strlen($input_data[array_search("sleep_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_sleep_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_sleep_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_sleep_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_sleep_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_sleep_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_sleep_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_sleep_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_sleep_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_sleep_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_sleep_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_sleep_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_sleep_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_sleep_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_sleep_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_sleep_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_sleep_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("sleep_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_sleep_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_sleep_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_sleep_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_sleep_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_sleep_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_sleep_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_sleep_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_sleep_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_sleep_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_sleep_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("sleep_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("sleep_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("sleep_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("sleep_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("sleep_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("sleep_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("sleep_sympt_d7", $header_array, TRUE)]) > 0 )
														{
															if ($input_data[array_search("sleep_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("sleep_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("sleep_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("sleep_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("sleep_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Irritability/Crying
											if (strlen($input_data[array_search("irrit_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("irrit_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("irrit_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}													

													$symptom = "Irritability/Crying";
													if (strlen($input_data[array_search("irrit_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_irrit_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_irrit_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_irrit_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_irrit_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_irrit_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_irrit_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_irrit_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_irrit_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_irrit_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_irrit_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_irrit_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_irrit_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_irrit_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_irrit_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_irrit_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_irrit_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("irrit_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_irrit_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_irrit_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_irrit_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_irrit_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_irrit_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_irrit_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_irrit_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_irrit_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_irrit_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_irrit_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("irrit_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("irrit_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("irrit_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("irrit_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("irrit_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("irrit_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("irrit_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("irrit_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("irrit_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("irrit_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("irrit_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("irrit_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Difficulty Talking
											if (strlen($input_data[array_search("talk_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("talk_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("talk_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Difficulty Talking";
													if (strlen($input_data[array_search("talk_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_talk_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_talk_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_talk_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_talk_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_talk_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_talk_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_talk_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_talk_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_talk_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_talk_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_talk_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_talk_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_talk_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_talk_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_talk_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_talk_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("talk_d3", $header_array, TRUE)]) > 0 )
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_talk_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_talk_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_talk_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_talk_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_talk_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_talk_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_talk_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_talk_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_talk_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_talk_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("talk_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("talk_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("talk_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("talk_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("talk_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("talk_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("talk_sympt_d7", $header_array, TRUE)]) > 0 )
														{
															if ($input_data[array_search("talk_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("talk_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("talk_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("talk_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("talk_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
												
										// Nausea/Vomiting
											if (strlen($input_data[array_search("nausea_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("nausea_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("nausea_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Nausea/Vomiting";
													if (strlen($input_data[array_search("nausea_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_nausea_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_nausea_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_nausea_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_nausea_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_nausea_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_naus_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_naus_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_naus_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_naus_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_naus_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_naus_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_naus_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_naus_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_naus_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_naus_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_naus_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("nausea_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_nausea_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_nausea_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_nausea_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_nausea_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_nausea_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_nausea_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_nausea_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_nausea_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_nausea_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_nausea_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("nausea_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("nausea_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("nausea_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("nausea_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("nausea_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("nausea_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("nausea_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("nausea_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("nausea_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("nausea_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("nausea_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("nausea_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Difficulty Walking
											if (strlen($input_data[array_search("walk_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("walk_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("walk_symbp_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Difficulty Walking";
													if (strlen($input_data[array_search("walk_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_walk_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_walk_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_walk_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_walk_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_walk_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_walk_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_walk_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_walk_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_walk_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_walk_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_walk_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_walk_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_walk_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_walk_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_walk_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_walk_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("walk_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_walk_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_walk_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_walk_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_walk_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_walk_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_walk_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_walk_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_walk_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_walk_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_walk_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("walk_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("walk_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("walk_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("walk_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("walk_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("walk_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("walk_symbp_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("walk_symbp_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("walk_symbp_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("walk_symbp_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("walk_symbp_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("walk_symbp_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// Ringing in Ears (Tinnitus)
											if (strlen($input_data[array_search("tinn_sympt_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("tinn_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("tinn_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Ringing in Ears (Tinnitus)";
													if (strlen($input_data[array_search("tinn_sympt_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															
															if ($input_data[array_search("worst1_tinn_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_tinn_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_tinn_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_tinn_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_tinn_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_tinn_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_tinn_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_tinn_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_tinn_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_tinn_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_tinn_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_tinn_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_tinn_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_tinn_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_tinn_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_tinn_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("tinn_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															
															if ($input_data[array_search("day_severity_tinn_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_tinn_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_tinn_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_tinn_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_tinn_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_tinn_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_tinn_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_tinn_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_tinn_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_tinn_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("tinn_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("tinn_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("tinn_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("tinn_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("tinn_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("tinn_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("tinn_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("tinn_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("tinn_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("tinn_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("tinn_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("tinn_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}	

									// Other 1
											if (strlen($input_data[array_search("other1_sympt_name_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("other1_sympt_name_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("other1_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Other";
													if (strlen($input_data[array_search("other1_sympt_name_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															$symptom .= " ".$input_data[array_search("other1_sympt_name_d1", $header_array, TRUE)]."";
															
															if ($input_data[array_search("worst1_other1_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_other1_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_other1_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_other1_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_other1_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_other1_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_other1_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_other1_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_other1_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_other1_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_other1_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_other1_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_other1_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_other1_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_other1_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_other1_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("other1_sympt_name_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															if (strlen($input_data[array_search("other1_sympt_name_d1", $header_array, TRUE)]) < 1) { $symptom .= " ".$input_data[array_search("other1_sympt_name_d3", $header_array, TRUE)].""; }
															
															if ($input_data[array_search("day_severity_other1_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_other1_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_other1_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_other1_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_other1_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_other1_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_other1_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_other1_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_other1_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_other1_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("other1_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("other1_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("other1_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("other1_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("other1_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("other1_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("other1_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("other1_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("other1_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("other1_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("other1_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("other1_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}

										// Other 2
											if (strlen($input_data[array_search("other2_sympt_name_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("other2_sympt_name_d3", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("other2_sympt_d7", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "Other";
													if (strlen($input_data[array_search("other2_sympt_name_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
															$symptom .= " ".$input_data[array_search("other2_sympt_name_d1", $header_array, TRUE)]."";
															
															if ($input_data[array_search("worst1_other2_d1", $header_array, TRUE)] == "0") { $pt_24hr_severity = "Not present"; }
															if ($input_data[array_search("worst1_other2_d1", $header_array, TRUE)] == "1") { $pt_24hr_severity = "Mild"; }
															if ($input_data[array_search("worst1_other2_d1", $header_array, TRUE)] == "2") { $pt_24hr_severity = "Moderate";}
															if ($input_data[array_search("worst1_other2_d1", $header_array, TRUE)] == "3") { $pt_24hr_severity = "Severe";}
															if ($input_data[array_search("worst1_other2_d1", $header_array, TRUE)] == "4") { $pt_24hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_other2_d1", $header_array, TRUE)] == "0") { $pt_24hr_related = "No"; }
															if ($input_data[array_search("related_other2_d1", $header_array, TRUE)] == "1") { $pt_24hr_related = "Unlikely"; }
															if ($input_data[array_search("related_other2_d1", $header_array, TRUE)] == "2") { $pt_24hr_related = "Not Sure";}
															if ($input_data[array_search("related_other2_d1", $header_array, TRUE)] == "3") { $pt_24hr_related = "Probably";}
															if ($input_data[array_search("related_other2_d1", $header_array, TRUE)] == "4") { $pt_24hr_related = "Definitely";}
															
															if ($input_data[array_search("recent_other2_d1", $header_array, TRUE)] == "1")
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("worst_other2_d1", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("worst_other2_d1", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("worst_other2_d1", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("worst_other2_d1", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("worst_other2_d1", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("other2_sympt_name_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
															if (strlen($input_data[array_search("other2_sympt_name_d1", $header_array, TRUE)]) < 1) { $symptom .= " ".$input_data[array_search("other2_sympt_name_d3", $header_array, TRUE)].""; }
															
															if ($input_data[array_search("day_severity_other2_d3", $header_array, TRUE)] == "0") { $pt_72hr_severity = "Not present"; }
															if ($input_data[array_search("day_severity_other2_d3", $header_array, TRUE)] == "1") { $pt_72hr_severity = "Mild"; }
															if ($input_data[array_search("day_severity_other2_d3", $header_array, TRUE)] == "2") { $pt_72hr_severity = "Moderate";}
															if ($input_data[array_search("day_severity_other2_d3", $header_array, TRUE)] == "3") { $pt_72hr_severity = "Severe";}
															if ($input_data[array_search("day_severity_other2_d3", $header_array, TRUE)] == "4") { $pt_72hr_severity = "Very Severe";}
															
															if ($input_data[array_search("related_other2_d3", $header_array, TRUE)] == "0") { $pt_72hr_related = "No"; }
															if ($input_data[array_search("related_other2_d3", $header_array, TRUE)] == "1") { $pt_72hr_related = "Unlikely"; }
															if ($input_data[array_search("related_other2_d3", $header_array, TRUE)] == "2") { $pt_72hr_related = "Not Sure";}
															if ($input_data[array_search("related_other2_d3", $header_array, TRUE)] == "3") { $pt_72hr_related = "Probably";}
															if ($input_data[array_search("related_other2_d3", $header_array, TRUE)] == "4") { $pt_72hr_related = "Definitely";}
															
															if ((strlen($pt_baseline) < 1) && ($input_data[array_search("other2_6week_d3", $header_array, TRUE)] == "1"))
																{
																	$pt_baseline = "Yes";
																	
																	if ($input_data[array_search("other2_worst_d3", $header_array, TRUE)] == "0") { $pt_baseline_severity = "Not present"; }
																	if ($input_data[array_search("other2_worst_d3", $header_array, TRUE)] == "1") { $pt_baseline_severity = "Mild"; }
																	if ($input_data[array_search("other2_worst_d3", $header_array, TRUE)] == "2") { $pt_baseline_severity = "Moderate";}
																	if ($input_data[array_search("other2_worst_d3", $header_array, TRUE)] == "3") { $pt_baseline_severity = "Severe";}
																	if ($input_data[array_search("other2_worst_d3", $header_array, TRUE)] == "4") { $pt_baseline_severity = "Very Severe";}
																}
														}
														
													if (strlen($input_data[array_search("other2_sympt_d7", $header_array, TRUE)]) > 0)
														{
															if ($input_data[array_search("other2_sympt_d7", $header_array, TRUE)] == "0") { $pt_1wk = "Not present"; }
															if ($input_data[array_search("other2_sympt_d7", $header_array, TRUE)] == "1") { $pt_1wk = "Mild"; }
															if ($input_data[array_search("other2_sympt_d7", $header_array, TRUE)] == "2") { $pt_1wk = "Moderate";}
															if ($input_data[array_search("other2_sympt_d7", $header_array, TRUE)] == "3") { $pt_1wk = "Severe";}
															if ($input_data[array_search("other2_sympt_d7", $header_array, TRUE)] == "4") { $pt_1wk = "Very Severe";}
														}
														
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_baseline`, `pt_baseline_severity`, `pt_24hr`, `pt_24hr_severity`, `pt_24hr_related`, `pt_24hr_details`, `pt_72hr`, `pt_72hr_severity`, `pt_72hr_related`, `pt_72hr_details`, `pt_1wk`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
												
										// I have not had any of the symptoms/complaints listed above since my OMT.
											if (strlen($input_data[array_search("no_symp_com_d1", $header_array, TRUE)]) > 0 || strlen($input_data[array_search("no_symp_comp_d3", $header_array, TRUE)]) > 0)
												{
													if (isset($symptom)) {unset($symptom);}
													if (isset($pt_baseline)) {unset($pt_baseline);}
													if (isset($pt_baseline_severity)) {unset($pt_baseline_severity);}
													if (isset($pt_24hr)) {unset($pt_24hr);}
													if (isset($pt_24hr_severity)) {unset($pt_24hr_severity);}
													if (isset($pt_24hr_related)) {unset($pt_24hr_related);}
													if (isset($pt_24hr_details)) {unset($pt_24hr_details);}
													if (isset($pt_72hr))	{unset($pt_72hr);}
													if (isset($pt_72hr_severity)) {unset($pt_72hr_severity);}
													if (isset($pt_72hr_related)) {unset($pt_72hr_related);}
													if (isset($pt_72hr_details)) {unset($pt_72hr_details);}
													if (isset($pt_1wk)) {unset($pt_1wk);}
													if (isset($insert_SQL)) {unset($insert_SQL);}
													
													$symptom = "I have not had any of the symptoms/complaints listed above since my OMT.";
													if (strlen($input_data[array_search("no_symp_com_d1", $header_array, TRUE)]) > 0)
														{
															$pt_24hr = "Yes";
														}
													if (strlen($input_data[array_search("no_symp_comp_d3", $header_array, TRUE)]) > 0)
														{
															$pt_72hr = "Yes";
														}
																									
													if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `symptom`, `pt_24hr`, `pt_72hr`) VALUES(?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
													if (!($insert_SQL->bind_param('sssss', $study_id, $code, $symptom, $pt_24hr, $pt_72hr))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}	
												
									// Pt. comments.
										if (strlen($input_data[array_search("details_d1", $header_array, TRUE)]) > 0)
											{ 
												if (isset($pt_24hr_details)) { unset($pt_24hr_details);}
												if (isset($insert_SQL)) { unset($insert_SQL);}
												
												$pt_24hr_details = $input_data[array_search("details_d1", $header_array, TRUE)];
												if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `pt_24hr_details`) VALUES(?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
												if (!($insert_SQL->bind_param('sss', $study_id, $code, $pt_24hr_details))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
												logger(__LINE__, "Inserting 24hr details");
												logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
												if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
												unset($insert_SQL);
											}
										
										if (strlen($input_data[array_search("details_d3", $header_array, TRUE)]) > 0)
											{ 
												if (isset($pt_72hr_details)) { unset($pt_72hr_details);}
												if (isset($insert_SQL)) { unset($insert_SQL);}
												
												$pt_72hr_details = $input_data[array_search("details_d3", $header_array, TRUE)];
												if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `pt_72hr_details`) VALUES(?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
												if (!($insert_SQL->bind_param('sss', $study_id, $code, $pt_72hr_details))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
												logger(__LINE__, "Inserting 72hr details");
												logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
												if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
												unset($insert_SQL);
											}

										if (strlen($input_data[array_search("details_d7", $header_array, TRUE)]) > 0)
											{ 
												if (isset($pt_1wk_details)) { unset($pt_1wk_details);}
												if (isset($insert_SQL)) { unset($insert_SQL);}
												
												$pt_1wk_details = $input_data[array_search("details_d7", $header_array, TRUE)];
												
												if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `pt_1wk_details`) VALUES(?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
												if (!($insert_SQL->bind_param('sss', $study_id, $code, $pt_1wk_details))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
												logger(__LINE__, "Inserting 1wk details");
												logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
												if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
												unset($insert_SQL);
											}

										if (strlen($input_data[array_search("follow_clinic_yn_d7", $header_array, TRUE)]) > 0)
											{
												if (isset($followup_clinic)) { unset($followup_clinic);}
												if (isset($followup_clinic_related)) { unset($followup_clinic_related);}
												if (isset($followup_clinic_details)) { unset($followup_clinic_details);}
												if (isset($insert_SQL)) { unset($insert_SQL);}
												
												if ($input_data[array_search("follow_clinic_yn_d7", $header_array, TRUE)] == "0") {$followup_clinic = "No";}
												if ($input_data[array_search("follow_clinic_yn_d7", $header_array, TRUE)] == "1") {$followup_clinic = "Yes, by phone";}
												if ($input_data[array_search("follow_clinic_yn_d7", $header_array, TRUE)] == "2") {$followup_clinic = "Yes, in the office";}
												
												if ($input_data[array_search("fu_visit_d7", $header_array, TRUE)] == "0") {$followup_clinic_related = "No";}
												if ($input_data[array_search("fu_visit_d7", $header_array, TRUE)] == "1") {$followup_clinic_related = "Unlikely";}
												if ($input_data[array_search("fu_visit_d7", $header_array, TRUE)] == "2") {$followup_clinic_related = "Not Sure";}
												if ($input_data[array_search("fu_visit_d7", $header_array, TRUE)] == "3") {$followup_clinic_related = "Probably";}
												if ($input_data[array_search("fu_visit_d7", $header_array, TRUE)] == "4") {$followup_clinic_related = "Definitely";}
												
												if (strlen($input_data[array_search("why_clinic_d7", $header_array, TRUE)]) > 0)
													{
														$followup_clinic_details = $input_data[array_search("why_clinic_d7", $header_array, TRUE)];
													}
												
												if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `followup_clinic`, `followup_clinic_related`, `followup_clinic_details`) VALUES(?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
												if (!($insert_SQL->bind_param('sssss', $study_id, $code, $followup_clinic, $followup_clinic_related, $followup_clinic_details))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
												logger(__LINE__, "Inserting clinic followup");
												logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
												if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
												unset($insert_SQL);
											}
											
										if (strlen($input_data[array_search("uc_yn_d7", $header_array, TRUE)]) > 0)
											{
												if (isset($followup_uc)) { unset($followup_uc);}
												if (isset($followup_uc_related)) { unset($followup_uc_related);}
												if (isset($followup_uc_details)) { unset($followup_uc_details);}
												if (isset($insert_SQL)) { unset($insert_SQL);}
												
												if ($input_data[array_search("uc_yn_d7", $header_array, TRUE)] == "0") {$followup_uc = "No";}
												if ($input_data[array_search("uc_yn_d7", $header_array, TRUE)] == "1") {$followup_uc = "Yes";}
																						
												if ($input_data[array_search("uc_hc_visit_d7", $header_array, TRUE)] == "0") {$followup_uc_related = "No";}
												if ($input_data[array_search("uc_hc_visit_d7", $header_array, TRUE)] == "1") {$followup_uc_related = "Unlikely";}
												if ($input_data[array_search("uc_hc_visit_d7", $header_array, TRUE)] == "2") {$followup_uc_related = "Not Sure";}
												if ($input_data[array_search("uc_hc_visit_d7", $header_array, TRUE)] == "3") {$followup_uc_related = "Probably";}
												if ($input_data[array_search("uc_hc_visit_d7", $header_array, TRUE)] == "4") {$followup_uc_related = "Definitely";}
												
												if (strlen($input_data[array_search("why_uc_d7", $header_array, TRUE)]) > 0)
													{
														$followup_uc_details = $input_data[array_search("why_uc_d7", $header_array, TRUE)];
													}
												
												if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `followup_uc`, `followup_uc_related`, `followup_uc_details`) VALUES(?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
												if (!($insert_SQL->bind_param('sssss', $study_id, $code, $followup_uc, $followup_uc_related, $followup_uc_details))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
												logger(__LINE__, "Inserting urgent care details");
												logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
												if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
												unset($insert_SQL);
											}
									
										if (strlen($input_data[array_search("er_yn_d7", $header_array, TRUE)]) > 0)
											{
												if (isset($followup_er)) { unset($followup_er);}
												if (isset($followup_er_related)) { unset($followup_er_related);}
												if (isset($followup_er_details)) { unset($followup_er_details);}
												if (isset($insert_SQL)) { unset($insert_SQL);}
												
												if ($input_data[array_search("er_yn_d7", $header_array, TRUE)] == "2") {$followup_er = "No";}
												if ($input_data[array_search("er_yn_d7", $header_array, TRUE)] == "1") {$followup_er = "Yes";}
																						
												if ($input_data[array_search("er_hc_visit_d7", $header_array, TRUE)] == "0") {$followup_er_related = "No";}
												if ($input_data[array_search("er_hc_visit_d7", $header_array, TRUE)] == "1") {$followup_er_related = "Unlikely";}
												if ($input_data[array_search("er_hc_visit_d7", $header_array, TRUE)] == "2") {$followup_er_related = "Not Sure";}
												if ($input_data[array_search("er_hc_visit_d7", $header_array, TRUE)] == "3") {$followup_er_related = "Probably";}
												if ($input_data[array_search("er_hc_visit_d7", $header_array, TRUE)] == "4") {$followup_er_related = "Definitely";}
												
												if (strlen($input_data[array_search("why_er_d7", $header_array, TRUE)]) > 0)
													{
														$followup_er_details = $input_data[array_search("why_er_d7", $header_array, TRUE)];
													}
												
												if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `followup_er`, `followup_er_related`, `followup_er_details`) VALUES(?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
												if (!($insert_SQL->bind_param('sssss', $study_id, $code, $followup_er, $followup_er_related, $followup_er_details))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
												logger(__LINE__, "Inserting ER visit details");
												logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
												if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
												unset($insert_SQL);
											}
											
										if (strlen($input_data[array_search("hosp_yn_d7", $header_array, TRUE)]) > 0)
											{
												if (isset($followup_hosp)) { unset($followup_hosp);}
												if (isset($followup_hosp_related)) { unset($followup_hosp_related);}
												if (isset($followup_hosp_details)) { unset($followup_hosp_details);}
												if (isset($insert_SQL)) { unset($insert_SQL);}
												
												if ($input_data[array_search("hosp_yn_d7", $header_array, TRUE)] == "2") {$followup_hosp = "No";}
												if ($input_data[array_search("hosp_yn_d7", $header_array, TRUE)] == "1") {$followup_hosp = "Yes";}
																						
												if ($input_data[array_search("hosp_hc_visit_d7", $header_array, TRUE)] == "0") {$followup_hosp_related = "No";}
												if ($input_data[array_search("hosp_hc_visit_d7", $header_array, TRUE)] == "1") {$followup_hosp_related = "Unlikely";}
												if ($input_data[array_search("hosp_hc_visit_d7", $header_array, TRUE)] == "2") {$followup_hosp_related = "Not Sure";}
												if ($input_data[array_search("hosp_hc_visit_d7", $header_array, TRUE)] == "3") {$followup_hosp_related = "Probably";}
												if ($input_data[array_search("hosp_hc_visit_d7", $header_array, TRUE)] == "4") {$followup_hosp_related = "Definitely";}
												
												if (strlen($input_data[array_search("why_hosp_d7", $header_array, TRUE)]) > 0)
													{
														$followup_hosp_details = $input_data[array_search("why_hosp_d7", $header_array, TRUE)];
													}
												
												if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `followup_hosp`, `followup_hosp_related`, `followup_hosp_details`) VALUES(?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
												if (!($insert_SQL->bind_param('sssss', $study_id, $code, $followup_hosp, $followup_hosp_related, $followup_hosp_details))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
												logger(__LINE__, "Inserting hospital visit details");
												logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
												if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
												unset($insert_SQL);
											}
											
									// future/further
									if (strlen($input_data[array_search("further_yn_d7", $header_array, TRUE)]) > 0)
											{
												if (isset($further)) { unset($further);}
												if (isset($further_why)) { unset($futher_why);}
												if (isset($insert_SQL)) { unset($insert_SQL);}
												
												if ($input_data[array_search("urther_yn_d7", $header_array, TRUE)] == "0") {$further = "No";}
												if ($input_data[array_search("urther_yn_d7", $header_array, TRUE)] == "1") {$further = "Yes";}
												if ($input_data[array_search("urther_yn_d7", $header_array, TRUE)] == "2") {$further = "Undecided";}
																						
												if (strlen($input_data[array_search("further_omt_why_d7", $header_array, TRUE)]) > 0)
													{
														$further_why = $input_data[array_search("further_omt_why_d7", $header_array, TRUE)];
													}
												
												if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `further`, `further_why`) VALUES(?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
												if (!($insert_SQL->bind_param('ssss', $study_id, $code, $further, $further_why))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
												logger(__LINE__, "Inserting further OMT details");
												logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
												if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
												unset($insert_SQL);
											}
											
										if (strlen($input_data[array_search("future_yn_d7", $header_array, TRUE)]) > 0)
											{
												if (isset($future)) { unset($future);}
												if (isset($future_why)) { unset($future_why);}
												if (isset($insert_SQL)) { unset($insert_SQL);}
												
												if ($input_data[array_search("future_yn_d7", $header_array, TRUE)] == "0") {$future = "No";}
												if ($input_data[array_search("future_yn_d7", $header_array, TRUE)] == "1") {$future = "Yes";}
												if ($input_data[array_search("future_yn_d7", $header_array, TRUE)] == "2") {$future = "Undecided";}
																						
												if (strlen($input_data[array_search("future_why_d7", $header_array, TRUE)]) > 0)
													{
														$further_why = $input_data[array_search("future_why_d7", $header_array, TRUE)];
													}
												
												if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.symptom (`study_id`, `code`, `future`, `future_why`) VALUES(?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
												if (!($insert_SQL->bind_param('ssss', $study_id, $code, $future, $future_why))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
												logger(__LINE__, "Inserting further OMT details");
												logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
												if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
												unset($insert_SQL);
											}
								}
						}
				
					fclose($input_filename);
					logger(__LINE__, "Completed Filename: " . $filename);
				}

			logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
			logger(__LINE__, " ====> End of Main Loop <====");
		}

logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
logger(__LINE__, " ====> End of File <====");
?>