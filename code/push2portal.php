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
		logger(__LINE__, "My timezone is: " . date_default_timezone_get());
	
	require('datacon.php');

	$filelist = file('../input_data/filelist.txt',FILE_SKIP_EMPTY_LINES);
	
	if ($filelist !== FALSE)
		{
			foreach ($filelist as $filename)
				{
					logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
					logger(__LINE__, "Converting Filename: " . $filename);
					$filename = trim(substr($filename, strrpos($filename, "/") + 1));
					$filename = "../input_data/" . $filename;
					logger(__LINE__, "Processing Filename: " . $filename);
					$input_filename = fopen($filename,"rb");
					$load_header = "1";
					if (isset($header_array)) {unset($header_array);}
					while (($input_data = fgetcsv($input_filename)) !== FALSE)
						{
							if (isset($load_header))
								{
									$header_array = array("study_id","record_id","consent_yn","visit_days","coup_how_d1","study_part_yn_d1","cal_yr_comp_d1","code","doctor","age_d1","sex_d1","ethnicity_d1","race_d1___1","race_d1___2","race_d1___3","race_d1___4","race_d1___5","race_d1___6","race_d1___7","other_race_d1","pain_hf_sympt_d1","pain_neck_sympt_d1","pain_up_back_sympt_d1","pain_chest_sympt_d1","pain_low_back_sympt_d1","pain_tail_sympt_d1","pain_hip_sympt_d1","pain_abd_sympt_d1","pain_arm_sympt_d1","pain_leg_sympt_d1","rad_pain_sympt_d1","stiff_sympt_d1","swell_sympt_d1","weak_sympt_d1","numb_sympt_d1","tired_sympt_d1","head_sympt_d1","lt_head_sympt_d1","vis_sympt_d1","sleep_sympt_d1","irrit_sympt_d1","talk_sympt_d1","nausea_sympt_d1","walk_sympt_d1","tinn_sympt_d1","rad_pain_reg_d1","stiff_reg_d1","swell_reg_d1","weak_reg_d1","numb_reg_d1","no_symp_com_d1","worst1_hf_d1","related_hf_d1","recent_hf_d1","worst_hf_d1","worst1_neck_d1","related_neck_d1","recent_neck_d1","worst_neck_d1","worst1_up_back_d1","related_up_back_d1","recent_up_back_d1","worst_up_back_d1","worst1_chest_d1","related_chest_d1","recent_chest_d1","worst_chest_d1","worst1_low_back_d1","related_low_back_d1","recent_low_back_d1","worst_low_back_d1","worst1_tail_d1","related_tail_d1","recent_tail_d1","worst_tail_d1","worst1_hip_d1","related_hip_d1","recent_hip_d1","worst_hip_d1","worst1_abd_d1","related_abd_d1","recent_abd_d1","worst_abd_d1","worst1_arm_d1","related_arm_d1","recent_arm_d1","worst_arm_d1","worst1_leg_d1","related_leg_d1","recent_leg_d1","worst_leg_d1","worst1_rad_pain_d1","related_red_pain_d1","recent_rad_pain_d1","worst_rad_pain_d1","worst1_stiff_d1","related_stiff_d1","recent_stiff_d1","worst_stiff_d1","worst1_swell_d1","related_swell_d1","recent_swell_d1","worst_swell_d1","worst1_weak_d1","related_weak_d1","recent_weak_d1","worst_weak_d1","worst1_numb_d1","related_numb_d1","recent_numb_d1","worst_numb_d1","worst1_tired_d1","related_tired_d1","recent_tired_d1","worst_tired_d1","worst1_head_d1","related_head_d1","recent_head_d1","worst_head_d1","worst1_lt_head_d1","related_lt_head_d1","recent_lt_head_d1","worst_lt_head_d1","worst1_vision_d1","related_vis_d1","recent_vis_d1","worst_sev_d1","worst1_sleep_d1","related_sleep_d1","recent_sleep_d1","worst_sleep_d1","worst1_irrit_d1","related_irrit_d1","recent_irrit_d1","worst_irrit_d1","worst1_talk_d1","related_talk_d1","recent_talk_d1","worst_talk_d1","worst1_nausea_d1","related_naus_d1","recent_naus_d1","worst_naus_d1","worst1_walk_d1","related_walk_d1","recent_walk_d1","worst_walk_d1","worst1_tinn_d1","related_tinn_d1","recent_tinn_d1","worst_tinn_d1","other1_sympt_d1","other1_sympt_name_d1","worst1_other1_d1","related_other1_d1","recent_other1_d1","worst_other1_d1","other2_sympt_d1","other2_sympt_name_d1","worst1_other2_d1","related_other2_d1","recent_other2_d1","worst_other2_d1","details_d1","email_address_d1","omt_adverse_events_study_24hour_survey_complete","pain_head_face_d3","pain_neck_d3","pain_up_back_d3","pain_chest_d3","pain_low_back_d3","pain_tail_d3","pain_hip_d3","pain_abd_d3","pain_arm_d3","pain_leg_d3","rad_pain_d3","stiff_d3","swell_d3","weak_d3","numb_d3","tire_d3","headache_d3","lt_head_d3","vision_d3","sleep_d3","irrit_d3","talk_d3","nausea_d3","walk_d3","tinn_d3","rad_pain_reg_d3","stiff_reg_d3","swell_reg_d3","weak_reg_d3","numb_reg_d3","no_symp_comp_d3","day_severity_head_face_d3","related_head_face_d3","head_face_6week_d3","head_face_worst_d3","day_severity_neck_d3","related_neck_d3","neck_6week_d3","neck_worst_d3","day_severity_up_back_d3","related_up_back_d3","up_back_6week_d3","up_back_worst_d3","day_severity_chest_d3","related_chest_d3","chest_6week_d3","chest_worst_d3","day_low_back_d3","related_low_back_d3","low_back_6week_d3","low_back_worst_d3","day_severity_tail_d3","related_tail_d3","tail_6week_d3","tail_worst_d3","day_severity_hip_d3","related_hip_d3","hip_6week_d3","hip_worst_d3","day_severity_abd_d3","related_abd_d3","abd_6week_d3","abd_worst_d3","day_severity_arm_d3","related_arm_d3","arm_6week_d3","arm_worst_d3","day_severity_leg_d3","related_leg_d3","leg_6week_d3","leg_worst_d3","day_severity_rad_pain_d3","related_rad_pain_d3","rad_pain_6week_d3","rad_pain_worst_d3","day_severity_stiff_d3","related_stiff_d3","stiff_6week_d3","stiff_worst_d3","day_severity_swell_d3","related_swell_d3","swell_6week_d3","swell_worst_d3","day_severity_weak_d3","related_weak_d3","weak_6week_d3","weak_worst_d3","day_severity_numb_d3","related_numb_d3","numb_6week_d3","numb_worst_d3","day_severity_tire_d3","related_tire_d3","tire_6week_d3","tire_worst_d3","day_severity_head_d3","related_head_d3","head_6week_d3","head_worst_d3","day_severity_lt_head_d3","related_lt_head_d3","lt_head_6week_d3","lt_head_worst_d3","day_severity_vision_d3","related_vision_d3","vision_6week_d3","vision_worst_d3","day_severity_sleep_d3","related_sleep_d3","sleep_6week_d3","sleep_worst_d3","day_severity_irrit_d3","related_irrit_d3","irrit_6week_d3","irrit_worst_d3","day_severity_talk_d3","related_talk_d3","talk_6week_d3","talk_worst_d3","day_severity_nausea_d3","related_nausea_d3","nausea_6week_d3","nausea_worst_d3","day_severity_walk_d3","related_walk_d3","walk_6week_d3","walk_worst_d3","day_severity_tinn_d3","related_tinn_d3","tinn_6week_d3","tinn_worst_d3","other_yn_d3","other1_sympt_name_d3","day_severity_other1_d3","related_other1_d3","other1_6week_d3","other1_worst_d3","other2_yn_d3","other2_sympt_name_d3","day_severity_other2_d3","related_other2_d3","other2_6week_d3","other2_worst_d3","details_d3","omt_adverse_events_study_midweek_survey_complete","pain_hf_sympt_d7","pain_neck_sympt_d7","pain_ub_sympt_d7","pain_chest_sympt_d7","pain_low_back_sympt_d7","pain_tail_sympt_d7","pain_hip_sympt_d7","pain_abd_sympt_d7","pain_arm_sympt_d7","pain_leg_sympt_d7","rad_pain_sympt_d7","stiff_sympt_d7","swell_sympt_d7","weak_sympt_d7","numb_sympt_d7","tired_sympt_d7","head_sympt_d7","lt_head_sympt_d7","vis_sympt_d7","sleep_sympt_d7","irrit_sympt_d7","talk_sympt_d7","nausea_sympt_d7","walk_symbp_d7","tinn_sympt_d7","other1_sympt_d7","other2_sympt_d7","follow_clinic_yn_d7","fu_visit_d7","why_clinic_d7","uc_yn_d7","uc_hc_visit_d7","why_uc_d7","er_yn_d7","er_hc_visit_d7","why_er_d7","hosp_yn_d7","hosp_hc_visit_d7","why_hosp_d7","details_d7","further_yn_d7","further_omt_why_d7","future_yn_d7","future_why_d7","omt_adverse_events_study_1week_survey_complete","survey_format","survey_format_complete");
									unset($load_header); 
									
								}
								else
								{
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
									
									$code = $input_data[array_search("code", $header_array, TRUE)];
									$study_id = $input_data[array_search("study_id", $header_array, TRUE)];
									$survey_rec_id = $input_data[array_search("record_id", $header_array, TRUE)];
									$consent = $input_data[array_search("consent_yn", $header_array, TRUE)];
									$visit_days = $input_data[array_search("visit_days", $header_array, TRUE)];
									$doctor = $input_data[array_search("doctor", $header_array, TRUE)];
									$age = $input_data[array_search("age_d1", $header_array, TRUE)];
									$sex = $input_data[array_search("sex_d1", $header_array, TRUE)];
									$ethnicity = $input_data[array_search("ethnicity_d1", $header_array, TRUE)];
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
													if (!($insert_SQL->bind_param('ssssssssssssss', $study_id, $code, $symptom, $pt_baseline, $pt_baseline_severity, $pt_24hr, $pt_24hr_severity, $pt_24hr_related, $pt_24hr_details, $pt_72hr, $pt_72hr_severity, $pt_72hr_related, $pt_72hr_details, $pt_1wk))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
													logger(__LINE__, "Inserting symptom: $symptom.");
													logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
													if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
													unset($insert_SQL);
												}
										
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
															if (strlen($input_data[array_search("rad_pain_reg_d1", $header_array, TRUE)]) > 0) { $symptom .= " " . $input_data[array_search("rad_pain_reg_d1", $header_array, TRUE)] .""; }
															
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
															if (strlen($input_data[array_search("rad_pain_reg_d1", $header_array, TRUE)]) < 1) { $symptom .= " " . $input_data[array_search("rad_pain_reg_d3", $header_array, TRUE)] . ""; }
															
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
															if (strlen($input_data[array_search("stiff_reg_d1", $header_array, TRUE)]) > 0) { $symptom .= " " . $input_data[array_search("stiff_reg_d1", $header_array, TRUE)] . ""; }
															
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
															if (strlen($input_data[array_search("swell_reg_d1", $header_array, TRUE)]) > 0) { $symptom .= " " . $input_data[array_search("swell_reg_d1", $header_array, TRUE)] . ""; }
															
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
															if (strlen($input_data[array_search("swell_reg_d1", $header_array, TRUE)]) < 1) { $symptom .= " " . $input_data[array_search("swell_reg_d3", $header_array, TRUE)] . ""; }
															
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
															if (strlen($input_data[array_search("weak_reg_d1", $header_array, TRUE)]) > 0) { $symptom .= " " . $input_data[array_search("weak_reg_d1", $header_array, TRUE) ] . ""; }
															
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
															if (strlen($input_data[array_search("weak_reg_d1", $header_array, TRUE)]) < 1) { $symptom .= " " . $input_data[array_search("weak_reg_d3", $header_array, TRUE)] . ""; }
															
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
															if (strlen($input_data[array_search("numb_reg_d1", $header_array, TRUE)]) > 0) { $symptom .= " " . $input_data[array_search("numb_reg_d1", $header_array, TRUE)] . ""; }
															
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
															if (strlen($input_data[array_search("numb_reg_d1", $header_array, TRUE)]) < 1) { $symptom .= " " . $input_data[array_search("numb_reg_d3", $header_array, TRUE)] . ""; }
															
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
					if (isset($insert_SQL)) { unset($insert_SQL);}
					fclose($input_filename);
					logger(__LINE__, "Completed Filename: " . $filename);
				}

			logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
			logger(__LINE__, " ====> End of Pt. Survey Loop <====");
			$dblink->close();
			
		}
		
	logger(__LINE__, " ====> Start of PET Loop <====");
	$dblink = new mysqli($MySqlHostName, $MySqlUserName, $MySqlPassWord, $MySqlDataBase);
		if ($dblink->connect_errno)
			{
				logger(__LINE__, "---MySQLi Error" . mysqli_connect_error($dblink) ." ---");
			}
	$petlist = file('../input_data/petlist.txt',FILE_SKIP_EMPTY_LINES);
	
	if ($petlist !== FALSE)
		{
			foreach ($petlist as $filename)
				{
					logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
					logger(__LINE__, "Converting Filename: " . $filename);
					$filename = trim(substr($filename, strrpos($filename, "/") + 1));
					$filename = "../input_data/" . $filename;
					logger(__LINE__, "Processing Filename: " . $filename);
					$input_filename = fopen($filename,"rb");
					$load_header = "1";
					if (isset($header_array)) {unset($header_array);}
					while (($input_data = fgetcsv($input_filename)) !== FALSE)
						{
							if (isset($load_header))
								{
									$header_array = array("study_id", "null", "From", "Received Date", "Date of Office Visit", "code", "Physician Name", "HF_ART", "HF_BLT", "HF_CR", "HF_CS", "HF_HVLA", "HF_IND", "HF_Lymph", "HF_ME", "HF_MFR", "HF_PH", "HF_ST", "HF_VIS", "HF_Other", "HF_Specify", "HF_Response", "Neck_ART", "Neck_BLT", "Neck_CR", "Neck_CS", "Neck_HVLA", "Neck_IND", "Neck_Lymph", "Neck_ME", "Neck_MFR", "Neck_PH", "Neck_ST", "Neck_VIS", "Neck_Other", "Neck_Specify", "Neck_Response", "Thor_ART", "Thor_BLT", "Thor_CR", "Thor_CS", "Thor_HVLA", "Thor_IND", "Thor_Lymph", "Thor_ME", "Thor_MFR", "Thor_PH", "Thor_ST", "Thor_VIS", "Thor_Other", "Thor_Specify", "Thor_Response", "Ribs_ART", "Ribs_BLT", "Ribs_CR", "Ribs_CS", "Ribs_HVLA", "Ribs_IND", "Ribs_Lymph", "Ribs_ME", "Ribs_MFR", "Ribs_PH", "Ribs_ST", "Ribs_VIS", "Ribs_Other", "Ribs_Specify", "Rib_Response", "Lumb_ART", "Lumb_BLT", "Lumb_CR", "Lumb_CS", "Lumb_HVLA", "Lumb_IND", "Lumb_Lymph", "Lumb_ME", "Lumb_MFR", "Lumb_PH", "Lumb_ST", "Lumb_VIS", "Lumb_Other", "Lumb_Specify", "Lumb_Response", "Sac_ART", "Sac_BLT", "Sac_CR", "Sac_CS", "Sac_HVLA", "Sac_Ind", "Sac_Lymph", "Sac_ME", "Sac_MFR", "Sac_PH", "Sac_ST", "Sac_VIS", "Sac_Other", "Sac_Specify", "Sac_Response", "Pelvis_ART", "Pelvis_BLT", "Pelvis_CR", "Pelvis_CS", "Pelvis_HVLA", "Pelvis_IND", "Pelvis_Lymph", "Pelvis_ME", "Pelvis_MFR", "Pelvis_PH", "Pelvis_ST", "Pelvis_VIS", "Pelvis_Other", "Pelvis_Specify", "Pelvis_Response", "Abd_ART", "Abd_BLT", "Abd_CR", "Abd_CS", "Abd_HVLA", "Abd_IND", "Abd_Lymph", "Abd_ME", "Abd_MFR", "Abd_PH", "Abd_ST", "Abd_VIS", "Abd_Other", "Abd_Specify", "Abd_Response", "Up_Ex_ART", "Up_Ex_BLT", "Up_Ex_CR", "Up_Ex_CS", "Up_Ex_HVLA", "Up_Ex_IND", "Up_Ex_Lymph", "Up_Ex_ME", "Up_Ex_MFR", "Up_Ex_PH", "Up_Ex_ST", "Up_Ex_VIS", "Up_Ex_Other", "Up_Ex_Specify", "Up_Ex_Response", "Should_ART", "Should_BLT", "Should_CR", "Should_CS", "Should_HVLA", "Should_IND", "Should_Lymph", "Should_ME", "Should_MFR", "Should_PH", "Should_ST", "Should_VIS", "Should_Other", "Should_Specify", "Should_Response", "Elbow_ART", "Elbow_BLT", "Elbow_CR", "Elbow_CS", "Elbow_HVLA", "Elbow_IND", "Elbow_Lymph", "Elbow_ME", "Elbow_MFR", "Elbow_PH", "Elbow_ST", "Elbow_VIS", "Elbow_Other", "Elbow_Specify", "Elbow_Response", "Wrist_ART", "Wrist_BLT", "Wrist_CR", "Wrist_CS", "Wrist_HVLA", "Wrist_IND", "Wrist_Lymph", "Wrist_ME", "Wrist_MFR", "Wrist_PH", "Wrist_ST", "Wrist_VIS", "Wrist_Other", "Wrist_Specify", "Wrist_Response", "Low_Ex_ART", "Low_Ex_BLT", "Low_Ex_CR", "Low_Ex_CS", "Low_Ex_HVLA", "Low_Ex_IND", "Low_Ex_Lymph", "Low_Ex_ME", "Low_Ex_MFR", "Low_Ex_PH", "Low_Ex_ST", "Low_Ex_VIS", "Low_Ex_Other", "Low_Ex_Specify", "Low_Ex_Response", "Thigh_ART", "Thigh_BLT", "Thigh_CR", "Thigh_CS", "Thigh_HVLA", "Thigh_Ind", "Thigh_Lymph", "Thigh_ME", "Thigh_MFR", "Thigh_PH", "Thigh_ST", "Thigh_VIS", "Thigh_Other", "Thigh_Specify", "Thigh_Response", "Knee_ART", "Knee_BLT", "Knee_CR", "Knee_CS", "Knee_HVLA", "Knee_IND", "Knee_Lymph", "Knee_ME", "Knee_MFR", "Knee_PH", "Knee_ST", "Knee_VIS", "Knee_Other", "Knee_Specify", "Knee_Response", "Ankle_ART", "Ankle_BLT", "Ankle_CR", "Ankle_CS", "Ankle_HVLA", "Ankle_IND", "Ankle_Lymph", "Ankle_ME", "Ankle_MFR", "Ankle_PH", "Ankle_ST", "Ankle_VIS", "Ankle_Other", "Ankle_Specify", "Ankle_Response", "739", "739.1", "739.2","739.8", "739.3", "739.4", "739.5", "739.9", "739.7", "739.6", "Written_Diagnosis_1", "Diagnosis_Code_1", "Chief_Related_1", "SD_Related_1", "Written_Diagnosis_2", "Diagnosis_Code_2", "Chief_Related_2", "SD_Related_2", "Written_Diagnosis_3", "Diagnosis_Code_3", "Chief_Related_3", "SD_Related_3", "Written_Diagnosis_4", "Diagnosis_Code_4", "Chief_Related_4", "SD_Related_4", "Written_Diagnosis_5", "Diagnosis_Code_5", "Chief_Related_5", "SD_Related_5", "Written_Diagnosis_6", "Diagnosis_Code_6", "Chief_Related_6", "SD_Related_6", "Written_Diagnosis_7", "Diagnosis_Code_7", "Chief_Related_7", "SD_Related_7", "Procuedures_1", "Procedures_2", "Procedures_3", "Procedures_4", "Procedures_5");
									unset($load_header); 									
								}
								else
								{
									if (isset($code)) {unset($code);}
									if (isset($study_id)) {unset($study_id);}
									if (isset($HF_ART)) {unset($HF_ART);}
									if (isset($HF_BLT)) {unset($HF_BLT);}
									if (isset($HF_CR)) {unset($HF_CR);}
									if (isset($HF_CS)) {unset($HF_CS);}
									if (isset($HF_HVLA)) {unset($HF_HVLA);}
									if (isset($HF_IND)) {unset($HF_IND);}
									if (isset($HF_Lymph)) {unset($HF_Lymph);}
									if (isset($HF_ME)) {unset($HF_ME);}
									if (isset($HF_MFR)) {unset($HF_MFR);}
									if (isset($HF_PH)) {unset($HF_PH);}
									if (isset($HF_ST)) {unset($HF_ST);}
									if (isset($HF_VIS)) {unset($HF_VIS);}
									if (isset($HF_Other)) {unset($HF_Other);}
									if (isset($HF_Specify)) {unset($HF_Specify);}
									if (isset($HF_Response)) {unset($HF_Response);}
									if (isset($Neck_ART)) {unset($Neck_ART);}
									if (isset($Neck_BLT)) {unset($Neck_BLT);}
									if (isset($Neck_CR)) {unset($Neck_CR);}
									if (isset($Neck_CS)) {unset($Neck_CS);}
									if (isset($Neck_HVLA)) {unset($Neck_HVLA);}
									if (isset($Neck_IND)) {unset($Neck_IND);}
									if (isset($Neck_Lymph)) {unset($Neck_Lymph);}
									if (isset($Neck_ME)) {unset($Neck_ME);}
									if (isset($Neck_MFR)) {unset($Neck_MFR);}
									if (isset($Neck_PH)) {unset($Neck_PH);}
									if (isset($Neck_ST)) {unset($Neck_ST);}
									if (isset($Neck_VIS)) {unset($Neck_VIS);}
									if (isset($Neck_Other)) {unset($Neck_Other);}
									if (isset($Neck_Specify)) {unset($Neck_Specify);}
									if (isset($Neck_Response)) {unset($Neck_Response);}
									if (isset($Thor_ART)) {unset($Thor_ART);}
									if (isset($Thor_BLT)) {unset($Thor_BLT);}
									if (isset($Thor_CR)) {unset($Thor_CR);}
									if (isset($Thor_CS)) {unset($Thor_CS);}
									if (isset($Thor_HVLA)) {unset($Thor_HVLA);}
									if (isset($Thor_IND)) {unset($Thor_IND);}
									if (isset($Thor_Lymph)) {unset($Thor_Lymph);}
									if (isset($Thor_ME)) {unset($Thor_ME);}
									if (isset($Thor_MFR)) {unset($Thor_MFR);}
									if (isset($Thor_PH)) {unset($Thor_PH);}
									if (isset($Thor_ST)) {unset($Thor_ST);}
									if (isset($Thor_VIS)) {unset($Thor_VIS);}
									if (isset($Thor_Other)) {unset($Thor_Other);}
									if (isset($Thor_Specify)) {unset($Thor_Specify);}
									if (isset($Thor_Response)) {unset($Thor_Response);}
									if (isset($Ribs_ART)) {unset($Ribs_ART);}
									if (isset($Ribs_BLT)) {unset($Ribs_BLT);}
									if (isset($Ribs_CR)) {unset($Ribs_CR);}
									if (isset($Ribs_CS)) {unset($Ribs_CS);}
									if (isset($Ribs_HVLA)) {unset($Ribs_HVLA);}
									if (isset($Ribs_IND)) {unset($Ribs_IND);}
									if (isset($Ribs_Lymph)) {unset($Ribs_Lymph);}
									if (isset($Ribs_ME)) {unset($Ribs_ME);}
									if (isset($Ribs_MFR)) {unset($Ribs_MFR);}
									if (isset($Ribs_PH)) {unset($Ribs_PH);}
									if (isset($Ribs_ST)) {unset($Ribs_ST);}
									if (isset($Ribs_VIS)) {unset($Ribs_VIS);}
									if (isset($Ribs_Other)) {unset($Ribs_Other);}
									if (isset($Ribs_Specify)) {unset($Ribs_Specify);}
									if (isset($Rib_Response)) {unset($Rib_Response);}
									if (isset($Lumb_ART)) {unset($Lumb_ART);}
									if (isset($Lumb_BLT)) {unset($Lumb_BLT);}
									if (isset($Lumb_CR)) {unset($Lumb_CR);}
									if (isset($Lumb_CS)) {unset($Lumb_CS);}
									if (isset($Lumb_HVLA)) {unset($Lumb_HVLA);}
									if (isset($Lumb_IND)) {unset($Lumb_IND);}
									if (isset($Lumb_Lymph)) {unset($Lumb_Lymph);}
									if (isset($Lumb_ME)) {unset($Lumb_ME);}
									if (isset($Lumb_MFR)) {unset($Lumb_MFR);}
									if (isset($Lumb_PH)) {unset($Lumb_PH);}
									if (isset($Lumb_ST)) {unset($Lumb_ST);}
									if (isset($Lumb_VIS)) {unset($Lumb_VIS);}
									if (isset($Lumb_Other)) {unset($Lumb_Other);}
									if (isset($Lumb_Specify)) {unset($Lumb_Specify);}
									if (isset($Lumb_Response)) {unset($Lumb_Response);}
									if (isset($Sac_ART)) {unset($Sac_ART);}
									if (isset($Sac_BLT)) {unset($Sac_BLT);}
									if (isset($Sac_CR)) {unset($Sac_CR);}
									if (isset($Sac_CS)) {unset($Sac_CS);}
									if (isset($Sac_HVLA)) {unset($Sac_HVLA);}
									if (isset($Sac_Ind)) {unset($Sac_Ind);}
									if (isset($Sac_Lymph)) {unset($Sac_Lymph);}
									if (isset($Sac_ME)) {unset($Sac_ME);}
									if (isset($Sac_MFR)) {unset($Sac_MFR);}
									if (isset($Sac_PH)) {unset($Sac_PH);}
									if (isset($Sac_ST)) {unset($Sac_ST);}
									if (isset($Sac_VIS)) {unset($Sac_VIS);}
									if (isset($Sac_Other)) {unset($Sac_Other);}
									if (isset($Sac_Specify)) {unset($Sac_Specify);}
									if (isset($Sac_Response)) {unset($Sac_Response);}
									if (isset($Pelvis_ART)) {unset($Pelvis_ART);}
									if (isset($Pelvis_BLT)) {unset($Pelvis_BLT);}
									if (isset($Pelvis_CR)) {unset($Pelvis_CR);}
									if (isset($Pelvis_CS)) {unset($Pelvis_CS);}
									if (isset($Pelvis_HVLA)) {unset($Pelvis_HVLA);}
									if (isset($Pelvis_IND)) {unset($Pelvis_IND);}
									if (isset($Pelvis_Lymph)) {unset($Pelvis_Lymph);}
									if (isset($Pelvis_ME)) {unset($Pelvis_ME);}
									if (isset($Pelvis_MFR)) {unset($Pelvis_MFR);}
									if (isset($Pelvis_PH)) {unset($Pelvis_PH);}
									if (isset($Pelvis_ST)) {unset($Pelvis_ST);}
									if (isset($Pelvis_VIS)) {unset($Pelvis_VIS);}
									if (isset($Pelvis_Other)) {unset($Pelvis_Other);}
									if (isset($Pelvis_Specify)) {unset($Pelvis_Specify);}
									if (isset($Pelvis_Response)) {unset($Pelvis_Response);}
									if (isset($Abd_ART)) {unset($Abd_ART);}
									if (isset($Abd_BLT)) {unset($Abd_BLT);}
									if (isset($Abd_CR)) {unset($Abd_CR);}
									if (isset($Abd_CS)) {unset($Abd_CS);}
									if (isset($Abd_HVLA)) {unset($Abd_HVLA);}
									if (isset($Abd_IND)) {unset($Abd_IND);}
									if (isset($Abd_Lymph)) {unset($Abd_Lymph);}
									if (isset($Abd_ME)) {unset($Abd_ME);}
									if (isset($Abd_MFR)) {unset($Abd_MFR);}
									if (isset($Abd_PH)) {unset($Abd_PH);}
									if (isset($Abd_ST)) {unset($Abd_ST);}
									if (isset($Abd_VIS)) {unset($Abd_VIS);}
									if (isset($Abd_Other)) {unset($Abd_Other);}
									if (isset($Abd_Specify)) {unset($Abd_Specify);}
									if (isset($Abd_Response)) {unset($Abd_Response);}
									if (isset($Up_Ex_ART)) {unset($Up_Ex_ART);}
									if (isset($Up_Ex_BLT)) {unset($Up_Ex_BLT);}
									if (isset($Up_Ex_CR)) {unset($Up_Ex_CR);}
									if (isset($Up_Ex_CS)) {unset($Up_Ex_CS);}
									if (isset($Up_Ex_HVLA)) {unset($Up_Ex_HVLA);}
									if (isset($Up_Ex_IND)) {unset($Up_Ex_IND);}
									if (isset($Up_Ex_Lymph)) {unset($Up_Ex_IND);}
									if (isset($Up_Ex_ME)) {unset($Up_Ex_ME);}
									if (isset($Up_Ex_MFR)) {unset($Up_Ex_MFR);}
									if (isset($Up_Ex_PH)) {unset($Up_Ex_PH);}
									if (isset($Up_Ex_ST)) {unset($Up_Ex_ST);}
									if (isset($Up_Ex_VIS)) {unset($Up_Ex_VIS);}
									if (isset($Up_Ex_Other)) {unset($Up_Ex_Other);}
									if (isset($Up_Ex_Specify)) {unset($Up_Ex_Specify);}
									if (isset($Up_Ex_Response)) {unset($Up_Ex_Response);}
									if (isset($Should_ART)) {unset($Should_ART);}
									if (isset($Should_BLT)) {unset($Should_BLT);}
									if (isset($Should_CR)) {unset($Should_CR);}
									if (isset($Should_CS)) {unset($Should_CS);}
									if (isset($Should_HVLA)) {unset($Should_HVLA);}
									if (isset($Should_IND)) {unset($Should_IND);}
									if (isset($Should_Lymph)) {unset($Should_Lymph);}
									if (isset($Should_ME)) {unset($Should_ME);}
									if (isset($Should_MFR)) {unset($Should_MFR);}
									if (isset($Should_PH)) {unset($Should_PH);}
									if (isset($Should_ST)) {unset($Should_ST);}
									if (isset($Should_VIS)) {unset($Should_VIS);}
									if (isset($Should_Other)) {unset($Should_Other);}
									if (isset($Should_Specify)) {unset($Should_Specify);}
									if (isset($Should_Response)) {unset($Should_Response);}
									if (isset($Elbow_ART)) {unset($Elbow_ART);}
									if (isset($Elbow_BLT)) {unset($Elbow_BLT);}
									if (isset($Elbow_CR)) {unset($Elbow_CR);}
									if (isset($Elbow_CS)) {unset($Elbow_CS);}
									if (isset($Elbow_HVLA)) {unset($Elbow_HVLA);}
									if (isset($Elbow_IND)) {unset($Elbow_IND);}
									if (isset($Elbow_Lymph)) {unset($Elbow_Lymph);}
									if (isset($Elbow_ME)) {unset($Elbow_ME);}
									if (isset($Elbow_MFR)) {unset($Elbow_MFR);}
									if (isset($Elbow_PH)) {unset($Elbow_PH);}
									if (isset($Elbow_ST)) {unset($Elbow_ST);}
									if (isset($Elbow_VIS)) {unset($Elbow_VIS);}
									if (isset($Elbow_Other)) {unset($Elbow_Other);}
									if (isset($Elbow_Specify)) {unset($Elbow_Specify);}
									if (isset($Elbow_Response)) {unset($Elbow_Response);}
									if (isset($Wrist_ART)) {unset($Wrist_ART);}
									if (isset($Wrist_BLT)) {unset($Wrist_BLT);}
									if (isset($Wrist_CR)) {unset($Wrist_CR);}
									if (isset($Wrist_CS)) {unset($Wrist_CS);}
									if (isset($Wrist_HVLA)) {unset($Wrist_HVLA);}
									if (isset($Wrist_IND)) {unset($Wrist_IND);}
									if (isset($Wrist_Lymph)) {unset($Wrist_Lymph);}
									if (isset($Wrist_ME)) {unset($Wrist_ME);}
									if (isset($Wrist_MFR)) {unset($Wrist_MFR);}
									if (isset($Wrist_PH)) {unset($Wrist_PH);}
									if (isset($Wrist_ST)) {unset($Wrist_ST);}
									if (isset($Wrist_VIS)) {unset($Wrist_VIS);}
									if (isset($Wrist_Other)) {unset($Wrist_Other);}
									if (isset($Wrist_Specify)) {unset($Wrist_Specify);}
									if (isset($Wrist_Response)) {unset($Wrist_Response);}
									if (isset($Low_Ex_ART)) {unset($Low_Ex_ART);}
									if (isset($Low_Ex_BLT)) {unset($Low_Ex_BLT);}
									if (isset($Low_Ex_CR)) {unset($Low_Ex_CR);}
									if (isset($Low_Ex_CS)) {unset($Low_Ex_CS);}
									if (isset($Low_Ex_HVLA)) {unset($Low_Ex_HVLA);}
									if (isset($Low_Ex_IND)) {unset($Low_Ex_IND);}
									if (isset($Low_Ex_Lymph)) {unset($Low_Ex_Lymph);}
									if (isset($Low_Ex_ME)) {unset($Low_Ex_ME);}
									if (isset($Low_Ex_MFR)) {unset($Low_Ex_MFR);}
									if (isset($Low_Ex_PH)) {unset($Low_Ex_PH);}
									if (isset($Low_Ex_ST)) {unset($Low_Ex_ST);}
									if (isset($Low_Ex_VIS)) {unset($Low_Ex_VIS);}
									if (isset($Low_Ex_Other)) {unset($Low_Ex_Other);}
									if (isset($Low_Ex_Specify)) {unset($Low_Ex_Specify);}
									if (isset($Low_Ex_Response)) {unset($Low_Ex_Response);}
									if (isset($Thigh_ART)) {unset($Thigh_ART);}
									if (isset($Thigh_BLT)) {unset($Thigh_BLT);}
									if (isset($Thigh_CR)) {unset($Thigh_CR);}
									if (isset($Thigh_CS)) {unset($Thigh_CS);}
									if (isset($Thigh_HVLA)) {unset($Thigh_HVLA);}
									if (isset($Thigh_Ind)) {unset($Thigh_Ind);}
									if (isset($Thigh_Lymph)) {unset($Thigh_Lymph);}
									if (isset($Thigh_ME)) {unset($Thigh_ME);}
									if (isset($Thigh_MFR)) {unset($Thigh_MFR);}
									if (isset($Thigh_PH)) {unset($Thigh_PH);}
									if (isset($Thigh_ST)) {unset($Thigh_ST);}
									if (isset($Thigh_VIS)) {unset($Thigh_VIS);}
									if (isset($Thigh_Other)) {unset($Thigh_Other);}
									if (isset($Thigh_Specify)) {unset($Thigh_Specify);}
									if (isset($Thigh_Response)) {unset($Thigh_Response);}
									if (isset($Knee_ART)) {unset($Knee_ART);}
									if (isset($Knee_BLT)) {unset($Knee_BLT);}
									if (isset($Knee_CR)) {unset($Knee_CR);}
									if (isset($Knee_CS)) {unset($Knee_CS);}
									if (isset($Knee_HVLA)) {unset($Knee_HVLA);}
									if (isset($Knee_IND)) {unset($Knee_IND);}
									if (isset($Knee_Lymph)) {unset($Knee_Lymph);}
									if (isset($Knee_ME)) {unset($Knee_ME);}
									if (isset($Knee_MFR)) {unset($Knee_MFR);}
									if (isset($Knee_PH)) {unset($Knee_PH);}
									if (isset($Knee_ST)) {unset($Knee_PH);}
									if (isset($Knee_VIS)) {unset($Knee_VIS);}
									if (isset($Knee_Other)) {unset($Knee_Other);}
									if (isset($Knee_Specify)) {unset($Knee_Specify);}
									if (isset($Knee_Response)) {unset($Knee_Response);}
									if (isset($Ankle_ART)) {unset($Ankle_ART);}
									if (isset($Ankle_BLT)) {unset($Ankle_BLT);}
									if (isset($Ankle_CR)) {unset($Ankle_CR);}
									if (isset($Ankle_CS)) {unset($Ankle_CS);}
									if (isset($Ankle_HVLA)) {unset($Ankle_HVLA);}
									if (isset($Ankle_IND)) {unset($Ankle_IND);}
									if (isset($Ankle_Lymph)) {unset($Ankle_Lymph);}
									if (isset($Ankle_ME)) {unset($Ankle_ME);}
									if (isset($Ankle_MFR)) {unset($Ankle_MFR);}
									if (isset($Ankle_PH)) {unset($Ankle_PH);}
									if (isset($Ankle_ST)) {unset($Ankle_ST);}
									if (isset($Ankle_VIS)) {unset($Ankle_VIS);}
									if (isset($Ankle_Other)) {unset($Ankle_Other);}
									if (isset($Ankle_Specify)) {unset($Ankle_Specify);}
									if (isset($Ankle_Response)) {unset($Ankle_Response);}
									if (isset($C739)) {unset($C739);}
									if (isset($C739_1)) {unset($C739_1);}
									if (isset($C739_2)) {unset($C739_2);}
									if (isset($C739_8)) {unset($C739_8);}
									if (isset($C739_3)) {unset($C739_3);}
									if (isset($C739_4)) {unset($C739_4);}
									if (isset($C739_5)) {unset($C739_5);}
									if (isset($C739_9)) {unset($C739_9);}
									if (isset($C739_7)) {unset($C739_7);}
									if (isset($C739_6)) {unset($C739_6);}
									if (isset($Written_Diagnosis_1)) {unset($Written_Diagnosis_1);}
									if (isset($Diagnosis_Code_1)) {unset($Diagnosis_Code_1);}
									if (isset($Chief_Related_1)) {unset($Chief_Related_1);}
									if (isset($SD_Related_1)) {unset($SD_Related_1);}
									if (isset($Written_Diagnosis_2)) {unset($Written_Diagnosis_2);}
									if (isset($Diagnosis_Code_2)) {unset($Diagnosis_Code_2);}
									if (isset($Chief_Related_2)) {unset($Chief_Related_2);}
									if (isset($SD_Related_2)) {unset($SD_Related_2);}
									if (isset($Written_Diagnosis_3)) {unset($Written_Diagnosis_3);}
									if (isset($Diagnosis_Code_3)) {unset($Diagnosis_Code_3);}
									if (isset($Chief_Related_3)) {unset($Chief_Related_3);}
									if (isset($SD_Related_3)) {unset($SD_Related_3);}
									if (isset($Written_Diagnosis_4)) {unset($Written_Diagnosis_4);}
									if (isset($Diagnosis_Code_4)) {unset($Diagnosis_Code_4);}
									if (isset($Chief_Related_4)) {unset($Chief_Related_4);}
									if (isset($SD_Related_4)) {unset($SD_Related_4);}
									if (isset($Written_Diagnosis_5)) {unset($Written_Diagnosis_5);}
									if (isset($Diagnosis_Code_5)) {unset($Diagnosis_Code_5);}
									if (isset($Chief_Related_5)) {unset($Chief_Related_5);}
									if (isset($SD_Related_5)) {unset($SD_Related_5);}
									if (isset($Written_Diagnosis_6)) {unset($Written_Diagnosis_6);}
									if (isset($Diagnosis_Code_6)) {unset($Diagnosis_Code_6);}
									if (isset($Chief_Related_6)) {unset($Chief_Related_6);}
									if (isset($SD_Related_6)) {unset($SD_Related_6);}
									if (isset($Written_Diagnosis_7)) {unset($Written_Diagnosis_7);}
									if (isset($Diagnosis_Code_7)) {unset($Diagnosis_Code_7);}
									if (isset($Chief_Related_7)) {unset($Chief_Related_7);}
									if (isset($SD_Related_7)) {unset($SD_Related_7);}
									if (isset($Procuedures_1)) {unset($Procuedures_1);}
									if (isset($Procedures_2)) {unset($Procedures_2);}
									if (isset($Procedures_3)) {unset($Procedures_3);}
									if (isset($Procedures_4)) {unset($Procedures_4);}
									if (isset($Procedures_5)) {unset($Procedures_5);}
									
									$code = $input_data[array_search("code", $header_array, TRUE)];
									$study_id = $input_data[array_search("study_id", $header_array, TRUE)];
									if ($input_data[array_search("HF_ART", $header_array, TRUE)] == 'Yes') { $HF_ART = '1'; } else { $HF_ART = null; }
									if ($input_data[array_search("HF_BLT", $header_array, TRUE)] == 'Yes') { $HF_BLT = '1'; } else { $HF_BLT = null; }
									if ($input_data[array_search("HF_CR", $header_array, TRUE)] == 'Yes') { $HF_CR = '1'; } else { $HF_CR = null; }
									if ($input_data[array_search("HF_CS", $header_array, TRUE)] == 'Yes') { $HF_CS = '1'; } else { $HF_CS = null; }
									if ($input_data[array_search("HF_HVLA", $header_array, TRUE)] == 'Yes') { $HF_HVLA = '1'; } else { $HF_HVLA = null; }
									if ($input_data[array_search("HF_IND", $header_array, TRUE)] == 'Yes') { $HF_IND = '1'; } else { $HF_IND = null; }
									if ($input_data[array_search("HF_Lymph", $header_array, TRUE)] == 'Yes') { $HF_Lymph = '1'; } else { $HF_Lymph = null; }
									if ($input_data[array_search("HF_ME", $header_array, TRUE)] == 'Yes') { $HF_ME = '1'; } else { $HF_ME = null; }
									if ($input_data[array_search("HF_MFR", $header_array, TRUE)] == 'Yes') { $HF_MFR = '1'; } else { $HF_MFR = null; }
									if ($input_data[array_search("HF_PH", $header_array, TRUE)] == 'Yes') { $HF_PH = '1'; } else { $HF_PH = null; }
									if ($input_data[array_search("HF_ST", $header_array, TRUE)] == 'Yes') { $HF_ST = '1'; } else { $HF_ST = null; }
									if ($input_data[array_search("HF_VIS", $header_array, TRUE)] == 'Yes') { $HF_VIS = '1'; } else { $HF_VIS = null; }
									if ($input_data[array_search("HF_Other", $header_array, TRUE)] == 'Yes') { $HF_Other = '1'; } else { $HF_Other = null; }
									if (!(is_null($input_data[array_search("HF_Specify", $header_array, TRUE)]))) { $HF_Specify = $input_data[array_search("HF_Specify", $header_array, TRUE)]; } else { $HF_Specify = null; }
									if (!(is_null($input_data[array_search("HF_Response", $header_array, TRUE)]))) { $HF_Response = $input_data[array_search("HF_Response", $header_array, TRUE)]; } else { $HF_Response = null; }
									if ($input_data[array_search("Neck_ART", $header_array, TRUE)] == 'Yes') { $Neck_ART = '1'; } else { $Neck_ART = null; }
									if ($input_data[array_search("Neck_BLT", $header_array, TRUE)] == 'Yes') { $Neck_BLT = '1'; } else { $Neck_BLT = null; }
									if ($input_data[array_search("Neck_CR", $header_array, TRUE)] == 'Yes') { $Neck_CR = '1'; } else { $Neck_CR = null; }
									if ($input_data[array_search("Neck_CS", $header_array, TRUE)] == 'Yes') { $Neck_CS = '1'; } else { $Neck_CS = null; }
									if ($input_data[array_search("Neck_HVLA", $header_array, TRUE)] == 'Yes') { $Neck_HVLA = '1'; } else { $Neck_HVLA = null; }
									if ($input_data[array_search("Neck_IND", $header_array, TRUE)] == 'Yes') { $Neck_IND = '1'; } else { $Neck_IND = null; }
									if ($input_data[array_search("Neck_Lymph", $header_array, TRUE)] == 'Yes') { $Neck_Lymph = '1'; } else { $Neck_Lymph = null; }
									if ($input_data[array_search("Neck_ME", $header_array, TRUE)] == 'Yes') { $Neck_ME = '1'; } else { $Neck_ME = null; }
									if ($input_data[array_search("Neck_MFR", $header_array, TRUE)] == 'Yes') { $Neck_MFR = '1'; } else { $Neck_MFR = null; }
									if ($input_data[array_search("Neck_PH", $header_array, TRUE)] == 'Yes') { $Neck_PH = '1'; } else { $Neck_PH = null; }
									if ($input_data[array_search("Neck_ST", $header_array, TRUE)] == 'Yes') { $Neck_ST = '1'; } else { $Neck_ST = null; }
									if ($input_data[array_search("Neck_VIS", $header_array, TRUE)] == 'Yes') { $Neck_VIS = '1'; } else { $Neck_VIS = null; }
									if ($input_data[array_search("Neck_Other", $header_array, TRUE)] == 'Yes') { $Neck_Other = '1'; } else { $Neck_Other = null; }
									if (!(is_null($input_data[array_search("Neck_Specify", $header_array, TRUE)]))) { $Neck_Specify = $input_data[array_search("Neck_Specify", $header_array, TRUE)]; } else { $Neck_Specify = null; }
									if (!(is_null($input_data[array_search("Neck_Response", $header_array, TRUE)]))) { $Neck_Response = $input_data[array_search("Neck_Response", $header_array, TRUE)]; } else { $Neck_Response = null; }
									if ($input_data[array_search("Thor_ART", $header_array, TRUE)] == 'Yes') { $Thor_ART = '1'; } else { $Thor_ART = null; }
									if ($input_data[array_search("Thor_BLT", $header_array, TRUE)] == 'Yes') { $Thor_BLT = '1'; } else { $Thor_BLT = null; }
									if ($input_data[array_search("Thor_CR", $header_array, TRUE)] == 'Yes') { $Thor_CR = '1'; } else { $Thor_CR = null; }
									if ($input_data[array_search("Thor_CS", $header_array, TRUE)] == 'Yes') { $Thor_CS = '1'; } else { $Thor_CS = null; }
									if ($input_data[array_search("Thor_HVLA", $header_array, TRUE)] == 'Yes') { $Thor_HVLA = '1'; } else { $Thor_HVLA = null; }
									if ($input_data[array_search("Thor_IND", $header_array, TRUE)] == 'Yes') { $Thor_IND = '1'; } else { $Thor_IND = null; }
									if ($input_data[array_search("Thor_Lymph", $header_array, TRUE)] == 'Yes') { $Thor_Lymph = '1'; } else { $Thor_Lymph = null; }
									if ($input_data[array_search("Thor_ME", $header_array, TRUE)] == 'Yes') { $Thor_ME = '1'; } else { $Thor_ME = null; }
									if ($input_data[array_search("Thor_MFR", $header_array, TRUE)] == 'Yes') { $Thor_MFR = '1'; } else { $Thor_MFR = null; }
									if ($input_data[array_search("Thor_PH", $header_array, TRUE)] == 'Yes') { $Thor_PH = '1'; } else { $Thor_PH = null; }
									if ($input_data[array_search("Thor_ST", $header_array, TRUE)] == 'Yes') { $Thor_ST = '1'; } else { $Thor_ST = null; }
									if ($input_data[array_search("Thor_VIS", $header_array, TRUE)] == 'Yes') { $Thor_VIS = '1'; } else { $Thor_VIS = null; }
									if ($input_data[array_search("Thor_Other", $header_array, TRUE)] == 'Yes') { $Thor_Other = '1'; } else { $Thor_Other = null; }
									if (!(is_null($input_data[array_search("Thor_Specify", $header_array, TRUE)]))) { $Thor_Specify = $input_data[array_search("Thor_Specify", $header_array, TRUE)]; } else { $Thor_Specify = null; }
									if (!(is_null($input_data[array_search("Thor_Response", $header_array, TRUE)]))) { $Thor_Response = $input_data[array_search("Thor_Response", $header_array, TRUE)]; } else { $Thor_Response = null; }
									if ($input_data[array_search("Ribs_ART", $header_array, TRUE)] == 'Yes') { $Ribs_ART = '1'; } else { $Ribs_ART = null; }
									if ($input_data[array_search("Ribs_BLT", $header_array, TRUE)] == 'Yes') { $Ribs_BLT = '1'; } else { $Ribs_BLT = null; }
									if ($input_data[array_search("Ribs_CR", $header_array, TRUE)] == 'Yes') { $Ribs_CR = '1'; } else { $Ribs_CR = null; }
									if ($input_data[array_search("Ribs_CS", $header_array, TRUE)] == 'Yes') { $Ribs_CS = '1'; } else { $Ribs_CS = null; }
									if ($input_data[array_search("Ribs_HVLA", $header_array, TRUE)] == 'Yes') { $Ribs_HVLA = '1'; } else { $Ribs_HVLA = null; }
									if ($input_data[array_search("Ribs_IND", $header_array, TRUE)] == 'Yes') { $Ribs_IND = '1'; } else { $Ribs_IND = null; }
									if ($input_data[array_search("Ribs_Lymph", $header_array, TRUE)] == 'Yes') { $Ribs_Lymph = '1'; } else { $Ribs_Lymph = null; }
									if ($input_data[array_search("Ribs_ME", $header_array, TRUE)] == 'Yes') { $Ribs_ME = '1'; } else { $Ribs_ME = null; }
									if ($input_data[array_search("Ribs_MFR", $header_array, TRUE)] == 'Yes') { $Ribs_MFR = '1'; } else { $Ribs_MFR = null; }
									if ($input_data[array_search("Ribs_PH", $header_array, TRUE)] == 'Yes') { $Ribs_PH = '1'; } else { $Ribs_PH = null; }
									if ($input_data[array_search("Ribs_ST", $header_array, TRUE)] == 'Yes') { $Ribs_ST = '1'; } else { $Ribs_ST = null; }
									if ($input_data[array_search("Ribs_VIS", $header_array, TRUE)] == 'Yes') { $Ribs_VIS = '1'; } else { $Ribs_VIS = null; }
									if ($input_data[array_search("Ribs_Other", $header_array, TRUE)] == 'Yes') { $Ribs_Other = '1'; } else { $Ribs_Other = null; }
									if (!(is_null($input_data[array_search("Ribs_Specify", $header_array, TRUE)]))) { $Ribs_Specify = $input_data[array_search("Ribs_Specify", $header_array, TRUE)]; } else { $Ribs_Specify = null; }
									if (!(is_null($input_data[array_search("Rib_Response", $header_array, TRUE)]))) { $Rib_Response = $input_data[array_search("Rib_Response", $header_array, TRUE)]; } else { $Rib_Response = null; }
									if ($input_data[array_search("Lumb_ART", $header_array, TRUE)] == 'Yes') { $Lumb_ART = '1'; } else { $Lumb_ART = null; }
									if ($input_data[array_search("Lumb_BLT", $header_array, TRUE)] == 'Yes') { $Lumb_BLT = '1'; } else { $Lumb_BLT = null; }
									if ($input_data[array_search("Lumb_CR", $header_array, TRUE)] == 'Yes') { $Lumb_CR = '1'; } else { $Lumb_CR = null; }
									if ($input_data[array_search("Lumb_CS", $header_array, TRUE)] == 'Yes') { $Lumb_CS = '1'; } else { $Lumb_CS = null; }
									if ($input_data[array_search("Lumb_HVLA", $header_array, TRUE)] == 'Yes') { $Lumb_HVLA = '1'; } else { $Lumb_HVLA = null; }
									if ($input_data[array_search("Lumb_IND", $header_array, TRUE)] == 'Yes') { $Lumb_IND = '1'; } else { $Lumb_IND = null; }
									if ($input_data[array_search("Lumb_Lymph", $header_array, TRUE)] == 'Yes') { $Lumb_Lymph = '1'; } else { $Lumb_Lymph = null; }
									if ($input_data[array_search("Lumb_ME", $header_array, TRUE)] == 'Yes') { $Lumb_ME = '1'; } else { $Lumb_ME = null; }
									if ($input_data[array_search("Lumb_MFR", $header_array, TRUE)] == 'Yes') { $Lumb_MFR = '1'; } else { $Lumb_MFR = null; }
									if ($input_data[array_search("Lumb_PH", $header_array, TRUE)] == 'Yes') { $Lumb_PH = '1'; } else { $Lumb_PH = null; }
									if ($input_data[array_search("Lumb_ST", $header_array, TRUE)] == 'Yes') { $Lumb_ST = '1'; } else { $Lumb_ST = null; }
									if ($input_data[array_search("Lumb_VIS", $header_array, TRUE)] == 'Yes') { $Lumb_VIS = '1'; } else { $Lumb_VIS = null; }
									if ($input_data[array_search("Lumb_Other", $header_array, TRUE)] == 'Yes') { $Lumb_Other = '1'; } else { $Lumb_Other = null; }
									if (!(is_null($input_data[array_search("Lumb_Specify", $header_array, TRUE)]))) { $Lumb_Specify = $input_data[array_search("Lumb_Specify", $header_array, TRUE)]; } else { $Lumb_Specify = null; }
									if (!(is_null($input_data[array_search("Lumb_Response", $header_array, TRUE)]))) { $Lumb_Response = $input_data[array_search("Lumb_Response", $header_array, TRUE)]; } else { $Lumb_Response = null; }
									if ($input_data[array_search("Sac_ART", $header_array, TRUE)] == 'Yes') { $Sac_ART = '1'; } else { $Sac_ART = null; }
									if ($input_data[array_search("Sac_BLT", $header_array, TRUE)] == 'Yes') { $Sac_BLT = '1'; } else { $Sac_BLT = null; }
									if ($input_data[array_search("Sac_CR", $header_array, TRUE)] == 'Yes') { $Sac_CR = '1'; } else { $Sac_CR = null; }
									if ($input_data[array_search("Sac_CS", $header_array, TRUE)] == 'Yes') { $Sac_CS = '1'; } else { $Sac_CS = null; }
									if ($input_data[array_search("Sac_HVLA", $header_array, TRUE)] == 'Yes') { $Sac_HVLA = '1'; } else { $Sac_HVLA = null; }
									if ($input_data[array_search("Sac_Ind", $header_array, TRUE)] == 'Yes') { $Sac_Ind = '1'; } else { $Sac_Ind = null; }
									if ($input_data[array_search("Sac_Lymph", $header_array, TRUE)] == 'Yes') { $Sac_Lymph = '1'; } else { $Sac_Lymph = null; }
									if ($input_data[array_search("Sac_ME", $header_array, TRUE)] == 'Yes') { $Sac_ME = '1'; } else { $Sac_ME = null; }
									if ($input_data[array_search("Sac_MFR", $header_array, TRUE)] == 'Yes') { $Sac_MFR = '1'; } else { $Sac_MFR = null; }
									if ($input_data[array_search("Sac_PH", $header_array, TRUE)] == 'Yes') { $Sac_PH = '1'; } else { $Sac_PH = null; }
									if ($input_data[array_search("Sac_ST", $header_array, TRUE)] == 'Yes') { $Sac_ST = '1'; } else { $Sac_ST = null; }
									if ($input_data[array_search("Sac_VIS", $header_array, TRUE)] == 'Yes') { $Sac_VIS = '1'; } else { $Sac_VIS = null; }
									if ($input_data[array_search("Sac_Other", $header_array, TRUE)] == 'Yes') { $Sac_Other = '1'; } else { $Sac_Other = null; }
									if (!(is_null($input_data[array_search("Sac_Specify", $header_array, TRUE)]))) { $Sac_Specify = $input_data[array_search("Sac_Specify", $header_array, TRUE)]; } else { $Sac_Specify = null; }
									if (!(is_null($input_data[array_search("Sac_Response", $header_array, TRUE)]))) { $Sac_Response = $input_data[array_search("Sac_Response", $header_array, TRUE)]; } else { $Sac_Response = null; }
									if ($input_data[array_search("Pelvis_ART", $header_array, TRUE)] == 'Yes') { $Pelvis_ART = '1'; } else { $Pelvis_ART = null; }
									if ($input_data[array_search("Pelvis_BLT", $header_array, TRUE)] == 'Yes') { $Pelvis_ART = '1'; } else { $Pelvis_ART = null; }
									if ($input_data[array_search("Pelvis_CR", $header_array, TRUE)] == 'Yes') { $Pelvis_CR = '1'; } else { $Pelvis_CR = null; }
									if ($input_data[array_search("Pelvis_CS", $header_array, TRUE)] == 'Yes') { $Pelvis_CS = '1'; } else { $Pelvis_CS = null; }
									if ($input_data[array_search("Pelvis_HVLA", $header_array, TRUE)] == 'Yes') { $Pelvis_HVLA = '1'; } else { $Pelvis_HVLA = null; }
									if ($input_data[array_search("Pelvis_IND", $header_array, TRUE)] == 'Yes') { $Pelvis_IND = '1'; } else { $Pelvis_IND = null; }
									if ($input_data[array_search("Pelvis_Lymph", $header_array, TRUE)] == 'Yes') { $Pelvis_Lymph = '1'; } else { $Pelvis_Lymph = null; }
									if ($input_data[array_search("Pelvis_ME", $header_array, TRUE)] == 'Yes') { $Pelvis_ME = '1'; } else { $Pelvis_ME = null; }
									if ($input_data[array_search("Pelvis_MFR", $header_array, TRUE)] == 'Yes') { $Pelvis_MFR = '1'; } else { $Pelvis_MFR = null; }
									if ($input_data[array_search("Pelvis_PH", $header_array, TRUE)] == 'Yes') { $Pelvis_PH = '1'; } else { $Pelvis_PH = null; }
									if ($input_data[array_search("Pelvis_ST", $header_array, TRUE)] == 'Yes') { $Pelvis_ST = '1'; } else { $Pelvis_ST = null; }
									if ($input_data[array_search("Pelvis_VIS", $header_array, TRUE)] == 'Yes') { $Pelvis_VIS = '1'; } else { $Pelvis_VIS = null; }
									if ($input_data[array_search("Pelvis_Other", $header_array, TRUE)] == 'Yes') { $Pelvis_Other = '1'; } else { $Pelvis_Other = null; }
									if (!(is_null($input_data[array_search("Pelvis_Specify", $header_array, TRUE)]))) { $Pelvis_Specify = $input_data[array_search("Pelvis_Specify", $header_array, TRUE)]; } else { $Pelvis_Specify = null; }
									if (!(is_null($input_data[array_search("Pelvis_Response", $header_array, TRUE)]))) { $Pelvis_Response = $input_data[array_search("Pelvis_Response", $header_array, TRUE)]; } else { $Pelvis_Response = null; }
									if ($input_data[array_search("Abd_ART", $header_array, TRUE)] == 'Yes') { $Abd_ART = '1'; } else { $Abd_ART = null; }
									if ($input_data[array_search("Abd_BLT", $header_array, TRUE)] == 'Yes') { $Abd_BLT = '1'; } else { $Abd_BLT = null; }
									if ($input_data[array_search("Abd_CR", $header_array, TRUE)] == 'Yes') { $Abd_CR = '1'; } else { $Abd_CR = null; }
									if ($input_data[array_search("Abd_CS", $header_array, TRUE)] == 'Yes') { $Abd_CS = '1'; } else { $Abd_CS = null; }
									if ($input_data[array_search("Abd_HVLA", $header_array, TRUE)] == 'Yes') { $Abd_HVLA = '1'; } else { $Abd_HVLA = null; }
									if ($input_data[array_search("Abd_IND", $header_array, TRUE)] == 'Yes') { $Abd_IND = '1'; } else { $Abd_IND = null; }
									if ($input_data[array_search("Abd_Lymph", $header_array, TRUE)] == 'Yes') { $Abd_Lymph = '1'; } else { $Abd_Lymph = null; }
									if ($input_data[array_search("Abd_ME", $header_array, TRUE)] == 'Yes') { $Abd_ME = '1'; } else { $Abd_ME = null; }
									if ($input_data[array_search("Abd_MFR", $header_array, TRUE)] == 'Yes') { $Abd_MFR = '1'; } else { $Abd_MFR = null; }
									if ($input_data[array_search("Abd_PH", $header_array, TRUE)] == 'Yes') { $Abd_PH = '1'; } else { $Abd_PH = null; }
									if ($input_data[array_search("Abd_ST", $header_array, TRUE)] == 'Yes') { $Abd_ST = '1'; } else { $Abd_ST = null; }
									if ($input_data[array_search("Abd_VIS", $header_array, TRUE)] == 'Yes') { $Abd_VIS = '1'; } else { $Abd_VIS = null; }
									if ($input_data[array_search("Abd_Other", $header_array, TRUE)] == 'Yes') { $Abd_Other = '1'; } else { $Abd_Other = null; }
									if (!(is_null($input_data[array_search("Abd_Specify", $header_array, TRUE)]))) { $Abd_Specify = $input_data[array_search("Abd_Specify", $header_array, TRUE)]; } else { $Abd_Specify = null; }
									if (!(is_null($input_data[array_search("Abd_Response", $header_array, TRUE)]))) { $Abd_Response = $input_data[array_search("Abd_Response", $header_array, TRUE)]; } else { $Abd_Response = null; }
									if ($input_data[array_search("Up_Ex_ART", $header_array, TRUE)] == 'Yes') { $Up_Ex_ART = '1'; } else { $Up_Ex_ART = null; }
									if ($input_data[array_search("Up_Ex_BLT", $header_array, TRUE)] == 'Yes') { $Up_Ex_BLT = '1'; } else { $Up_Ex_BLT = null; }
									if ($input_data[array_search("Up_Ex_CR", $header_array, TRUE)] == 'Yes') { $Up_Ex_CR = '1'; } else { $Up_Ex_CR = null; }
									if ($input_data[array_search("Up_Ex_CS", $header_array, TRUE)] == 'Yes') { $Up_Ex_CS = '1'; } else { $Up_Ex_CS = null; }
									if ($input_data[array_search("Up_Ex_HVLA", $header_array, TRUE)] == 'Yes') { $Up_Ex_HVLA = '1'; } else { $Up_Ex_HVLA = null; }
									if ($input_data[array_search("Up_Ex_IND", $header_array, TRUE)] == 'Yes') { $Up_Ex_IND = '1'; } else { $Up_Ex_IND = null; }
									if ($input_data[array_search("Up_Ex_IND", $header_array, TRUE)] == 'Yes') { $Up_Ex_Lymph = '1'; } else { $Up_Ex_Lymph = null; }
									if ($input_data[array_search("Up_Ex_ME", $header_array, TRUE)] == 'Yes') { $Up_Ex_ME = '1'; } else { $Up_Ex_ME = null; }
									if ($input_data[array_search("Up_Ex_MFR", $header_array, TRUE)] == 'Yes') { $Up_Ex_MFR = '1'; } else { $Up_Ex_MFR = null; }
									if ($input_data[array_search("Up_Ex_PH", $header_array, TRUE)] == 'Yes') { $Up_Ex_PH = '1'; } else { $Up_Ex_PH = null; }
									if ($input_data[array_search("Up_Ex_ST", $header_array, TRUE)] == 'Yes') { $Up_Ex_ST = '1'; } else { $Up_Ex_ST = null; }
									if ($input_data[array_search("Up_Ex_VIS", $header_array, TRUE)] == 'Yes') { $Up_Ex_VIS = '1'; } else { $Up_Ex_VIS = null; }
									if ($input_data[array_search("Up_Ex_Other", $header_array, TRUE)] == 'Yes') { $Up_Ex_Other = '1'; } else { $Up_Ex_Other = null; }
									if (!(is_null($input_data[array_search("Up_Ex_Specify", $header_array, TRUE)]))) { $Up_Ex_Specify = $input_data[array_search("Up_Ex_Specify", $header_array, TRUE)]; } else { $Up_Ex_Specify = null; }
									if (!(is_null($input_data[array_search("Up_Ex_Response", $header_array, TRUE)]))) { $Up_Ex_Response = $input_data[array_search("Up_Ex_Response", $header_array, TRUE)]; } else { $Up_Ex_Response = null; }
									if ($input_data[array_search("Should_ART", $header_array, TRUE)] == 'Yes') { $Should_ART = '1'; } else { $Should_ART = null; }
									if ($input_data[array_search("Should_BLT", $header_array, TRUE)] == 'Yes') { $Should_BLT = '1'; } else { $Should_BLT = null; }
									if ($input_data[array_search("Should_CR", $header_array, TRUE)] == 'Yes') { $Should_CR = '1'; } else { $Should_CR = null; }
									if ($input_data[array_search("Should_CS", $header_array, TRUE)] == 'Yes') { $Should_CS = '1'; } else { $Should_CS = null; }
									if ($input_data[array_search("Should_HVLA", $header_array, TRUE)] == 'Yes') { $Should_HVLA = '1'; } else { $Should_HVLA = null; }
									if ($input_data[array_search("Should_IND", $header_array, TRUE)] == 'Yes') { $Should_IND = '1'; } else { $Should_IND = null; }
									if ($input_data[array_search("Should_Lymph", $header_array, TRUE)] == 'Yes') { $Should_Lymph = '1'; } else { $Should_Lymph = null; }
									if ($input_data[array_search("Should_ME", $header_array, TRUE)] == 'Yes') { $Should_ME = '1'; } else { $Should_ME = null; }
									if ($input_data[array_search("Should_MFR", $header_array, TRUE)] == 'Yes') { $Should_MFR = '1'; } else { $Should_MFR = null; }
									if ($input_data[array_search("Should_PH", $header_array, TRUE)] == 'Yes') { $Should_PH = '1'; } else { $Should_PH = null; }
									if ($input_data[array_search("Should_ST", $header_array, TRUE)] == 'Yes') { $Should_ST = '1'; } else { $Should_ST = null; }
									if ($input_data[array_search("Should_VIS", $header_array, TRUE)] == 'Yes') { $Should_VIS = '1'; } else { $Should_VIS = null; }
									if ($input_data[array_search("Should_Other", $header_array, TRUE)] == 'Yes') { $Should_Other = '1'; } else { $Should_Other = null; }
									if (!(is_null($input_data[array_search("Should_Specify", $header_array, TRUE)]))) { $Should_Specify = $input_data[array_search("Should_Specify", $header_array, TRUE)]; } else { $Should_Specify = null; }
									if (!(is_null($input_data[array_search("Should_Response", $header_array, TRUE)]))) { $Should_Response = $input_data[array_search("Should_Response", $header_array, TRUE)]; } else { $Should_Response = null; }
									if ($input_data[array_search("Elbow_ART", $header_array, TRUE)] == 'Yes') { $Elbow_ART = '1'; } else { $Elbow_ART = null; }
									if ($input_data[array_search("Elbow_BLT", $header_array, TRUE)] == 'Yes') { $Elbow_BLT = '1'; } else { $Elbow_BLT = null; }
									if ($input_data[array_search("Elbow_CR", $header_array, TRUE)] == 'Yes') { $Elbow_CR = '1'; } else { $Elbow_CR = null; }
									if ($input_data[array_search("Elbow_CS", $header_array, TRUE)] == 'Yes') { $Elbow_CS = '1'; } else { $Elbow_CS = null; }
									if ($input_data[array_search("Elbow_HVLA", $header_array, TRUE)] == 'Yes') { $Elbow_HVLA = '1'; } else { $Elbow_HVLA = null; }
									if ($input_data[array_search("Elbow_IND", $header_array, TRUE)] == 'Yes') { $Elbow_IND = '1'; } else { $Elbow_IND = null; }
									if ($input_data[array_search("Elbow_Lymph", $header_array, TRUE)] == 'Yes') { $Elbow_Lymph = '1'; } else { $Elbow_Lymph = null; }
									if ($input_data[array_search("Elbow_ME", $header_array, TRUE)] == 'Yes') { $Elbow_ME = '1'; } else { $Elbow_ME = null; }
									if ($input_data[array_search("Elbow_MFR", $header_array, TRUE)] == 'Yes') { $Elbow_MFR = '1'; } else { $Elbow_MFR = null; }
									if ($input_data[array_search("Elbow_PH", $header_array, TRUE)] == 'Yes') { $Elbow_PH = '1'; } else { $Elbow_PH = null; }
									if ($input_data[array_search("Elbow_ST", $header_array, TRUE)] == 'Yes') { $Elbow_ST = '1'; } else { $Elbow_ST = null; }
									if ($input_data[array_search("Elbow_VIS", $header_array, TRUE)] == 'Yes') { $Elbow_VIS = '1'; } else { $Elbow_VIS = null; }
									if ($input_data[array_search("Elbow_Other", $header_array, TRUE)] == 'Yes') { $Elbow_Other = '1'; } else { $Elbow_Other = null; }
									if (!(is_null($input_data[array_search("Elbow_Specify", $header_array, TRUE)]))) { $Elbow_Specify = $input_data[array_search("Elbow_Specify", $header_array, TRUE)]; } else { $Elbow_Specify = null; }
									if (!(is_null($input_data[array_search("Elbow_Response", $header_array, TRUE)]))) { $Elbow_Response = $input_data[array_search("Elbow_Response", $header_array, TRUE)]; } else { $Elbow_Response = null; }
									if ($input_data[array_search("Wrist_ART", $header_array, TRUE)] == 'Yes') { $Wrist_ART = '1'; } else { $Wrist_ART = null; }
									if ($input_data[array_search("Wrist_BLT", $header_array, TRUE)] == 'Yes') { $Wrist_BLT = '1'; } else { $Wrist_BLT = null; }
									if ($input_data[array_search("Wrist_CR", $header_array, TRUE)] == 'Yes') { $Wrist_CR = '1'; } else { $Wrist_CR = null; }
									if ($input_data[array_search("Wrist_CS", $header_array, TRUE)] == 'Yes') { $Wrist_CS = '1'; } else { $Wrist_CS = null; }
									if ($input_data[array_search("Wrist_HVLA", $header_array, TRUE)] == 'Yes') { $Wrist_HVLA = '1'; } else { $Wrist_HVLA = null; }
									if ($input_data[array_search("Wrist_IND", $header_array, TRUE)] == 'Yes') { $Wrist_IND = '1'; } else { $Wrist_IND = null; }
									if ($input_data[array_search("Wrist_Lymph", $header_array, TRUE)] == 'Yes') { $Wrist_Lymph = '1'; } else { $Wrist_Lymph = null; }
									if ($input_data[array_search("Wrist_ME", $header_array, TRUE)] == 'Yes') { $Wrist_ME = '1'; } else { $Wrist_ME = null; }
									if ($input_data[array_search("Wrist_MFR", $header_array, TRUE)] == 'Yes') { $Wrist_MFR = '1'; } else { $Wrist_MFR = null; }
									if ($input_data[array_search("Wrist_PH", $header_array, TRUE)] == 'Yes') { $Wrist_PH = '1'; } else { $Wrist_PH = null; }
									if ($input_data[array_search("Wrist_ST", $header_array, TRUE)] == 'Yes') { $Wrist_ST = '1'; } else { $Wrist_ST = null; }
									if ($input_data[array_search("Wrist_VIS", $header_array, TRUE)] == 'Yes') { $Wrist_VIS = '1'; } else { $Wrist_VIS = null; }
									if ($input_data[array_search("Wrist_Other", $header_array, TRUE)] == 'Yes') { $Wrist_Other = '1'; } else { $Wrist_Other = null; }
									if (!(is_null($input_data[array_search("Wrist_Specify", $header_array, TRUE)]))) { $Wrist_Specify = $input_data[array_search("Wrist_Specify", $header_array, TRUE)]; } else { $Wrist_Specify = null; }
									if (!(is_null($input_data[array_search("Wrist_Response", $header_array, TRUE)]))) { $Wrist_Response = $input_data[array_search("Wrist_Response", $header_array, TRUE)]; } else { $Wrist_Response = null; }
									if ($input_data[array_search("Low_Ex_ART", $header_array, TRUE)] == 'Yes') { $Low_Ex_ART = '1'; } else { $Low_Ex_ART = null; }
									if ($input_data[array_search("Low_Ex_BLT", $header_array, TRUE)] == 'Yes') { $Low_Ex_BLT = '1'; } else { $Low_Ex_BLT = null; }
									if ($input_data[array_search("Low_Ex_CR", $header_array, TRUE)] == 'Yes') { $Low_Ex_CR = '1'; } else { $Low_Ex_CR = null; }
									if ($input_data[array_search("Low_Ex_CS", $header_array, TRUE)] == 'Yes') { $Low_Ex_CS = '1'; } else { $Low_Ex_CS = null; }
									if ($input_data[array_search("Low_Ex_HVLA", $header_array, TRUE)] == 'Yes') { $Low_Ex_HVLA = '1'; } else { $Low_Ex_HVLA = null; }
									if ($input_data[array_search("Low_Ex_IND", $header_array, TRUE)] == 'Yes') { $Low_Ex_IND = '1'; } else { $Low_Ex_IND = null; }
									if ($input_data[array_search("Low_Ex_Lymph", $header_array, TRUE)] == 'Yes') { $Low_Ex_Lymph = '1'; } else { $Low_Ex_Lymph = null; }
									if ($input_data[array_search("Low_Ex_ME", $header_array, TRUE)] == 'Yes') { $Low_Ex_ME = '1'; } else { $Low_Ex_ME = null; }
									if ($input_data[array_search("Low_Ex_MFR", $header_array, TRUE)] == 'Yes') { $Low_Ex_MFR = '1'; } else { $Low_Ex_MFR = null; }
									if ($input_data[array_search("Low_Ex_PH", $header_array, TRUE)] == 'Yes') { $Low_Ex_PH = '1'; } else { $Low_Ex_PH = null; }
									if ($input_data[array_search("Low_Ex_ST", $header_array, TRUE)] == 'Yes') { $Low_Ex_ST = '1'; } else { $Low_Ex_ST = null; }
									if ($input_data[array_search("Low_Ex_VIS", $header_array, TRUE)] == 'Yes') { $Low_Ex_VIS = '1'; } else { $Low_Ex_VIS = null; }
									if ($input_data[array_search("Low_Ex_Other", $header_array, TRUE)] == 'Yes') { $Low_Ex_Other = '1'; } else { $Low_Ex_Other = null; }
									if (!(is_null($input_data[array_search("Low_Ex_Specify", $header_array, TRUE)]))) { $Low_Ex_Specify = $input_data[array_search("Low_Ex_Specify", $header_array, TRUE)]; } else { $Low_Ex_Specify = null; }
									if (!(is_null($input_data[array_search("Low_Ex_Response", $header_array, TRUE)]))) { $Low_Ex_Response = $input_data[array_search("Low_Ex_Response", $header_array, TRUE)]; } else { $Low_Ex_Response = null; }
									if ($input_data[array_search("Thigh_ART", $header_array, TRUE)] == 'Yes') { $Thigh_ART = '1'; } else { $Thigh_ART = null; }
									if ($input_data[array_search("Thigh_BLT", $header_array, TRUE)] == 'Yes') { $Thigh_BLT = '1'; } else { $Thigh_BLT = null; }
									if ($input_data[array_search("Thigh_CR", $header_array, TRUE)] == 'Yes') { $Thigh_CR = '1'; } else { $Thigh_CR = null; }
									if ($input_data[array_search("Thigh_CS", $header_array, TRUE)] == 'Yes') { $Thigh_CS = '1'; } else { $Thigh_CS = null; }
									if ($input_data[array_search("Thigh_HVLA", $header_array, TRUE)] == 'Yes') { $Thigh_HVLA = '1'; } else { $Thigh_HVLA = null; }
									if ($input_data[array_search("Thigh_Ind", $header_array, TRUE)] == 'Yes') { $Thigh_Ind = '1'; } else { $Thigh_Ind = null; }
									if ($input_data[array_search("Thigh_Lymph", $header_array, TRUE)] == 'Yes') { $Thigh_Lymph = '1'; } else { $Thigh_Lymph = null; }
									if ($input_data[array_search("Thigh_ME", $header_array, TRUE)] == 'Yes') { $Thigh_ME = '1'; } else { $Thigh_ME = null; }
									if ($input_data[array_search("Thigh_MFR", $header_array, TRUE)] == 'Yes') { $Thigh_MFR = '1'; } else { $Thigh_MFR = null; }
									if ($input_data[array_search("Thigh_PH", $header_array, TRUE)] == 'Yes') { $Thigh_PH = '1'; } else { $Thigh_PH = null; }
									if ($input_data[array_search("Thigh_ST", $header_array, TRUE)] == 'Yes') { $Thigh_ST = '1'; } else { $Thigh_ST = null; }
									if ($input_data[array_search("Thigh_VIS", $header_array, TRUE)] == 'Yes') { $Thigh_VIS = '1'; } else { $Thigh_VIS = null; }
									if ($input_data[array_search("Thigh_Other", $header_array, TRUE)] == 'Yes') { $Thigh_Other = '1'; } else { $Thigh_Other = null; }
									if (!(is_null($input_data[array_search("Thigh_Specify", $header_array, TRUE)]))) { $Thigh_Specify = $input_data[array_search("Thigh_Specify", $header_array, TRUE)]; } else { $Thigh_Specify = null; }
									if (!(is_null($input_data[array_search("Thigh_Response", $header_array, TRUE)]))) { $Thigh_Response = $input_data[array_search("Thigh_Response", $header_array, TRUE)]; } else { $Thigh_Response = null; }
									if ($input_data[array_search("Knee_ART", $header_array, TRUE)] == 'Yes') { $Knee_ART = '1'; } else { $Knee_ART = null; }
									if ($input_data[array_search("Knee_BLT", $header_array, TRUE)] == 'Yes') { $Knee_BLT = '1'; } else { $Knee_BLT = null; }
									if ($input_data[array_search("Knee_CR", $header_array, TRUE)] == 'Yes') { $Knee_CR = '1'; } else { $Knee_CR = null; }
									if ($input_data[array_search("Knee_CS", $header_array, TRUE)] == 'Yes') { $Knee_CS = '1'; } else { $Knee_CS = null; }
									if ($input_data[array_search("Knee_HVLA", $header_array, TRUE)] == 'Yes') { $Knee_HVLA = '1'; } else { $Knee_HVLA = null; }
									if ($input_data[array_search("Knee_IND", $header_array, TRUE)] == 'Yes') { $Knee_IND = '1'; } else { $Knee_IND = null; }
									if ($input_data[array_search("Knee_Lymph", $header_array, TRUE)] == 'Yes') { $Knee_Lymph = '1'; } else { $Knee_Lymph = null; }
									if ($input_data[array_search("Knee_ME", $header_array, TRUE)] == 'Yes') { $Knee_ME = '1'; } else { $Knee_ME = null; }
									if ($input_data[array_search("Knee_MFR", $header_array, TRUE)] == 'Yes') { $Knee_MFR = '1'; } else { $Knee_MFR = null; }
									if ($input_data[array_search("Knee_PH", $header_array, TRUE)] == 'Yes') { $Knee_PH = '1'; } else { $Knee_PH = null; }
									if ($input_data[array_search("Knee_ST", $header_array, TRUE)] == 'Yes') { $Knee_ST = '1'; } else { $Knee_ST = null; }
									if ($input_data[array_search("Knee_VIS", $header_array, TRUE)] == 'Yes') { $Knee_VIS = '1'; } else { $Knee_VIS = null; }
									if ($input_data[array_search("Knee_Other", $header_array, TRUE)] == 'Yes') { $Knee_Other = '1'; } else { $Knee_Other = null; }
									if (!(is_null($input_data[array_search("Knee_Specify", $header_array, TRUE)]))) { $Knee_Specify = $input_data[array_search("Knee_Specify", $header_array, TRUE)]; } else { $Knee_Specify = null; }
									if (!(is_null($input_data[array_search("Knee_Response", $header_array, TRUE)]))) { $Knee_Response = $input_data[array_search("Knee_Response", $header_array, TRUE)]; } else { $Knee_Response = null; }
									if ($input_data[array_search("Ankle_ART", $header_array, TRUE)] == 'Yes') { $Ankle_ART = '1'; } else { $Ankle_ART = null; }
									if ($input_data[array_search("Ankle_BLT", $header_array, TRUE)] == 'Yes') { $Ankle_BLT = '1'; } else { $Ankle_BLT = null; }
									if ($input_data[array_search("Ankle_CR", $header_array, TRUE)] == 'Yes') { $Ankle_CR = '1'; } else { $Ankle_CR = null; }
									if ($input_data[array_search("Ankle_CS", $header_array, TRUE)] == 'Yes') { $Ankle_CS = '1'; } else { $Ankle_CS = null; }
									if ($input_data[array_search("Ankle_HVLA", $header_array, TRUE)] == 'Yes') { $Ankle_HVLA = '1'; } else { $Ankle_HVLA = null; }
									if ($input_data[array_search("Ankle_IND", $header_array, TRUE)] == 'Yes') { $Ankle_IND = '1'; } else { $Ankle_IND = null; }
									if ($input_data[array_search("Ankle_Lymph", $header_array, TRUE)] == 'Yes') { $Ankle_Lymph = '1'; } else { $Ankle_Lymph = null; }
									if ($input_data[array_search("Ankle_ME", $header_array, TRUE)] == 'Yes') { $Ankle_ME = '1'; } else { $Ankle_ME = null; }
									if ($input_data[array_search("Ankle_MFR", $header_array, TRUE)] == 'Yes') { $Ankle_MFR = '1'; } else { $Ankle_MFR = null; }
									if ($input_data[array_search("Ankle_PH", $header_array, TRUE)] == 'Yes') { $Ankle_PH = '1'; } else { $Ankle_PH = null; }
									if ($input_data[array_search("Ankle_ST", $header_array, TRUE)] == 'Yes') { $Ankle_ST = '1'; } else { $Ankle_ST = null; }
									if ($input_data[array_search("Ankle_VIS", $header_array, TRUE)] == 'Yes') { $Ankle_VIS = '1'; } else { $Ankle_VIS = null; }
									if ($input_data[array_search("Ankle_Other", $header_array, TRUE)] == 'Yes') { $Ankle_Other = '1'; } else { $Ankle_Other = null; }
									if (!(is_null($input_data[array_search("Ankle_Specify", $header_array, TRUE)]))) { $Ankle_Specify = $input_data[array_search("Ankle_Specify", $header_array, TRUE)]; } else { $Ankle_Specify = null; }
									if (!(is_null($input_data[array_search("Ankle_Response", $header_array, TRUE)]))) { $Ankle_Response = $input_data[array_search("Ankle_Response", $header_array, TRUE)]; } else { $Ankle_Response = null; }
									if ($input_data[array_search("739", $header_array, TRUE)] == 'Yes') { $C739 = '1'; } else { $C739 = null; }
									if ($input_data[array_search("739.1", $header_array, TRUE)] == 'Yes') { $C739_1 = '1'; } else { $C739_1 = null; }
									if ($input_data[array_search("739.2", $header_array, TRUE)] == 'Yes') { $C739_2 = '1'; } else { $C739_2 = null; }
									if ($input_data[array_search("739.8", $header_array, TRUE)] == 'Yes') { $C739_8 = '1'; } else { $C739_8 = null; }
									if ($input_data[array_search("739.3", $header_array, TRUE)] == 'Yes') { $C739_3 = '1'; } else { $C739_3 = null; }
									if ($input_data[array_search("739.4", $header_array, TRUE)] == 'Yes') { $C739_4 = '1'; } else { $C739_4 = null; }
									if ($input_data[array_search("739.5", $header_array, TRUE)] == 'Yes') { $C739_5 = '1'; } else { $C739_5 = null; }
									if ($input_data[array_search("739.9", $header_array, TRUE)] == 'Yes') { $C739_9 = '1'; } else { $C739_9 = null; }
									if ($input_data[array_search("739.7", $header_array, TRUE)] == 'Yes') { $C739_7 = '1'; } else { $C739_7 = null; }
									if ($input_data[array_search("739.6", $header_array, TRUE)] == 'Yes') { $C739_6 = '1'; } else { $C739_6 = null; }
									if (!(is_null($input_data[array_search("Written_Diagnosis_1", $header_array, TRUE)]))) { $Written_Diagnosis_1 = $input_data[array_search("Written_Diagnosis_1", $header_array, TRUE)]; } else { $Written_Diagnosis_1 = null; }
									if (!(is_null($input_data[array_search("Diagnosis_Code_1", $header_array, TRUE)]))) { $Diagnosis_Code_1 = $input_data[array_search("Diagnosis_Code_1", $header_array, TRUE)]; } else { $Diagnosis_Code_1 = null; }
									if (!(is_null($input_data[array_search("Chief_Related_1", $header_array, TRUE)]))) { $Chief_Related_1 = $input_data[array_search("Chief_Related_1", $header_array, TRUE)]; } else { $Chief_Related_1 = null; }
									if (!(is_null($input_data[array_search("SD_Related_1", $header_array, TRUE)]))) { $SD_Related_1 = $input_data[array_search("SD_Related_1", $header_array, TRUE)]; } else { $SD_Related_1 = null; }
									if (!(is_null($input_data[array_search("Written_Diagnosis_2", $header_array, TRUE)]))) { $Written_Diagnosis_2 = $input_data[array_search("Written_Diagnosis_2", $header_array, TRUE)]; } else { $Written_Diagnosis_2 = null; }
									if (!(is_null($input_data[array_search("Diagnosis_Code_2", $header_array, TRUE)]))) { $Diagnosis_Code_2 = $input_data[array_search("Diagnosis_Code_2", $header_array, TRUE)]; } else { $Diagnosis_Code_2 = null; }
									if (!(is_null($input_data[array_search("Chief_Related_2", $header_array, TRUE)]))) { $Chief_Related_2 = $input_data[array_search("Chief_Related_2", $header_array, TRUE)]; } else { $Chief_Related_2 = null; }
									if (!(is_null($input_data[array_search("SD_Related_2", $header_array, TRUE)]))) { $SD_Related_2 = $input_data[array_search("SD_Related_2", $header_array, TRUE)]; } else { $SD_Related_2 = null; }
									if (!(is_null($input_data[array_search("Written_Diagnosis_3", $header_array, TRUE)]))) { $Written_Diagnosis_3 = $input_data[array_search("Written_Diagnosis_3", $header_array, TRUE)]; } else { $Written_Diagnosis_3 = null; }
									if (!(is_null($input_data[array_search("Diagnosis_Code_3", $header_array, TRUE)]))) { $Diagnosis_Code_3 = $input_data[array_search("Diagnosis_Code_3", $header_array, TRUE)]; } else { $Diagnosis_Code_3 = null; }
									if (!(is_null($input_data[array_search("Chief_Related_3", $header_array, TRUE)]))) { $Chief_Related_3 = $input_data[array_search("Chief_Related_3", $header_array, TRUE)]; } else { $Chief_Related_3 = null; }
									if (!(is_null($input_data[array_search("SD_Related_3", $header_array, TRUE)]))) { $SD_Related_3 = $input_data[array_search("SD_Related_3", $header_array, TRUE)]; } else { $SD_Related_3 = null; }
									if (!(is_null($input_data[array_search("Written_Diagnosis_4", $header_array, TRUE)]))) { $Written_Diagnosis_4 = $input_data[array_search("Written_Diagnosis_4", $header_array, TRUE)]; } else { $Written_Diagnosis_4 = null; }
									if (!(is_null($input_data[array_search("Diagnosis_Code_4", $header_array, TRUE)]))) { $Diagnosis_Code_4 = $input_data[array_search("Diagnosis_Code_4", $header_array, TRUE)]; } else { $Diagnosis_Code_4 = null; }
									if (!(is_null($input_data[array_search("Chief_Related_4", $header_array, TRUE)]))) { $Chief_Related_4 = $input_data[array_search("Chief_Related_4", $header_array, TRUE)]; } else { $Chief_Related_4 = null; }
									if (!(is_null($input_data[array_search("SD_Related_4", $header_array, TRUE)]))) { $SD_Related_4 = $input_data[array_search("SD_Related_4", $header_array, TRUE)]; } else { $SD_Related_4 = null; }
									if (!(is_null($input_data[array_search("Written_Diagnosis_5", $header_array, TRUE)]))) { $Written_Diagnosis_5 = $input_data[array_search("Written_Diagnosis_5", $header_array, TRUE)]; } else { $Written_Diagnosis_5 = null; }
									if (!(is_null($input_data[array_search("Diagnosis_Code_5", $header_array, TRUE)]))) { $Diagnosis_Code_5 = $input_data[array_search("Diagnosis_Code_5", $header_array, TRUE)]; } else { $Diagnosis_Code_5 = null; }
									if (!(is_null($input_data[array_search("Chief_Related_5", $header_array, TRUE)]))) { $Chief_Related_5 = $input_data[array_search("Chief_Related_5", $header_array, TRUE)]; } else { $Chief_Related_5 = null; }
									if (!(is_null($input_data[array_search("SD_Related_5", $header_array, TRUE)]))) { $SD_Related_5 = $input_data[array_search("SD_Related_5", $header_array, TRUE)]; } else { $SD_Related_5 = null; }
									if (!(is_null($input_data[array_search("Written_Diagnosis_6", $header_array, TRUE)]))) { $Written_Diagnosis_6 = $input_data[array_search("Written_Diagnosis_6", $header_array, TRUE)]; } else { $Written_Diagnosis_6 = null; }
									if (!(is_null($input_data[array_search("Diagnosis_Code_6", $header_array, TRUE)]))) { $Diagnosis_Code_6 = $input_data[array_search("Diagnosis_Code_6", $header_array, TRUE)]; } else { $Diagnosis_Code_6 = null; }
									if (!(is_null($input_data[array_search("Chief_Related_6", $header_array, TRUE)]))) { $Chief_Related_6 = $input_data[array_search("Chief_Related_6", $header_array, TRUE)]; } else { $Chief_Related_6 = null; }
									if (!(is_null($input_data[array_search("SD_Related_6", $header_array, TRUE)]))) { $SD_Related_6 = $input_data[array_search("SD_Related_6", $header_array, TRUE)]; } else { $SD_Related_6 = null; }
									if (!(is_null($input_data[array_search("Written_Diagnosis_7", $header_array, TRUE)]))) { $Written_Diagnosis_7 = $input_data[array_search("Written_Diagnosis_7", $header_array, TRUE)]; } else { $Written_Diagnosis_7 = null; }
									if (!(is_null($input_data[array_search("Diagnosis_Code_7", $header_array, TRUE)]))) { $Diagnosis_Code_7 = $input_data[array_search("Diagnosis_Code_7", $header_array, TRUE)]; } else { $Diagnosis_Code_7 = null; }
									if (!(is_null($input_data[array_search("Chief_Related_7", $header_array, TRUE)]))) { $Chief_Related_7 = $input_data[array_search("Chief_Related_7", $header_array, TRUE)]; } else { $Chief_Related_7 = null; }
									if (!(is_null($input_data[array_search("SD_Related_7", $header_array, TRUE)]))) { $SD_Related_7 = $input_data[array_search("SD_Related_7", $header_array, TRUE)]; } else { $SD_Related_7 = null; }
									if (!(is_null($input_data[array_search("Procuedures_1", $header_array, TRUE)]))) { $Procuedures_1 = $input_data[array_search("Procuedures_1", $header_array, TRUE)]; } else { $Procuedures_1 = null; }
									if (!(is_null($input_data[array_search("Procedures_2", $header_array, TRUE)]))) { $Procedures_2 = $input_data[array_search("Procedures_2", $header_array, TRUE)]; } else { $Procedures_2 = null; }
									if (!(is_null($input_data[array_search("Procedures_3", $header_array, TRUE)]))) { $Procedures_3 = $input_data[array_search("Procedures_3", $header_array, TRUE)]; } else { $Procedures_3 = null; }
									if (!(is_null($input_data[array_search("Procedures_4", $header_array, TRUE)]))) { $Procedures_4 = $input_data[array_search("Procedures_4", $header_array, TRUE)]; } else { $Procedures_4 = null; }
									if (!(is_null($input_data[array_search("Procedures_5", $header_array, TRUE)]))) { $Procedures_5 = $input_data[array_search("Procedures_5", $header_array, TRUE)]; } else { $Procedures_5 = null; }
									
									if (isset($insert_SQL)) { unset($insert_SQL);}
									if (!($insert_SQL = $dblink->prepare("INSERT INTO jury_room.pet (`code`, `study_id`, `HF_ART`, `HF_BLT`, `HF_CR`, `HF_CS`, `HF_HVLA`, `HF_IND`, `HF_Lymph`, `HF_ME`, `HF_MFR`, `HF_PH`, `HF_ST`, `HF_VIS`, `HF_Other`, `HF_Specify`, `HF_Response`, `Neck_ART`, `Neck_BLT`, `Neck_CR`, `Neck_CS`, `Neck_HVLA`, `Neck_IND`, `Neck_Lymph`, `Neck_ME`, `Neck_MFR`, `Neck_PH`, `Neck_ST`, `Neck_VIS`, `Neck_Other`, `Neck_Specify`, `Neck_Response`, `Thor_ART`, `Thor_BLT`, `Thor_CR`, `Thor_CS`, `Thor_HVLA`, `Thor_IND`, `Thor_Lymph`, `Thor_ME`, `Thor_MFR`, `Thor_PH`, `Thor_ST`, `Thor_VIS`, `Thor_Other`, `Thor_Specify`, `Thor_Response`, `Ribs_ART`, `Ribs_BLT`, `Ribs_CR`, `Ribs_CS`, `Ribs_HVLA`, `Ribs_IND`, `Ribs_Lymph`, `Ribs_ME`, `Ribs_MFR`, `Ribs_PH`, `Ribs_ST`, `Ribs_VIS`, `Ribs_Other`, `Ribs_Specify`, `Rib_Response`, `Lumb_ART`, `Lumb_BLT`, `Lumb_CR`, `Lumb_CS`, `Lumb_HVLA`, `Lumb_IND`, `Lumb_Lymph`, `Lumb_ME`, `Lumb_MFR`, `Lumb_PH`, `Lumb_ST`, `Lumb_VIS`, `Lumb_Other`, `Lumb_Specify`, `Lumb_Response`, `Sac_ART`, `Sac_BLT`, `Sac_CR`, `Sac_CS`, `Sac_HVLA`, `Sac_Ind`, `Sac_Lymph`, `Sac_ME`, `Sac_MFR`, `Sac_PH`, `Sac_ST`, `Sac_VIS`, `Sac_Other`, `Sac_Specify`, `Sac_Response`, `Pelvis_ART`, `Pelvis_BLT`, `Pelvis_CR`, `Pelvis_CS`, `Pelvis_HVLA`, `Pelvis_IND`, `Pelvis_Lymph`, `Pelvis_ME`, `Pelvis_MFR`, `Pelvis_PH`, `Pelvis_ST`, `Pelvis_VIS`, `Pelvis_Other`, `Pelvis_Specify`, `Pelvis_Response`, `Abd_ART`, `Abd_BLT`, `Abd_CR`, `Abd_CS`, `Abd_HVLA`, `Abd_IND`, `Abd_Lymph`, `Abd_ME`, `Abd_MFR`, `Abd_PH`, `Abd_ST`, `Abd_VIS`, `Abd_Other`, `Abd_Specify`, `Abd_Response`, `Up_Ex_ART`, `Up_Ex_BLT`, `Up_Ex_CR`, `Up_Ex_CS`, `Up_Ex_HVLA`, `Up_Ex_IND`, `Up_Ex_Lymph`, `Up_Ex_ME`, `Up_Ex_MFR`, `Up_Ex_PH`, `Up_Ex_ST`, `Up_Ex_VIS`, `Up_Ex_Other`, `Up_Ex_Specify`, `Up_Ex_Response`, `Should_ART`, `Should_BLT`, `Should_CR`, `Should_CS`, `Should_HVLA`, `Should_IND`, `Should_Lymph`, `Should_ME`, `Should_MFR`, `Should_PH`, `Should_ST`, `Should_VIS`, `Should_Other`, `Should_Specify`, `Should_Response`, `Elbow_ART`, `Elbow_BLT`, `Elbow_CR`, `Elbow_CS`, `Elbow_HVLA`, `Elbow_IND`, `Elbow_Lymph`, `Elbow_ME`, `Elbow_MFR`, `Elbow_PH`, `Elbow_ST`, `Elbow_VIS`, `Elbow_Other`, `Elbow_Specify`, `Elbow_Response`, `Wrist_ART`, `Wrist_BLT`, `Wrist_CR`, `Wrist_CS`, `Wrist_HVLA`, `Wrist_IND`, `Wrist_Lymph`, `Wrist_ME`, `Wrist_MFR`, `Wrist_PH`, `Wrist_ST`, `Wrist_VIS`, `Wrist_Other`, `Wrist_Specify`, `Wrist_Response`, `Low_Ex_ART`, `Low_Ex_BLT`, `Low_Ex_CR`, `Low_Ex_CS`, `Low_Ex_HVLA`, `Low_Ex_IND`, `Low_Ex_Lymph`, `Low_Ex_ME`, `Low_Ex_MFR`, `Low_Ex_PH`, `Low_Ex_ST`, `Low_Ex_VIS`, `Low_Ex_Other`, `Low_Ex_Specify`, `Low_Ex_Response`, `Thigh_ART`, `Thigh_BLT`, `Thigh_CR`, `Thigh_CS`, `Thigh_HVLA`, `Thigh_Ind`, `Thigh_Lymph`, `Thigh_ME`, `Thigh_MFR`, `Thigh_PH`, `Thigh_ST`, `Thigh_VIS`, `Thigh_Other`, `Thigh_Specify`, `Thigh_Response`, `Knee_ART`, `Knee_BLT`, `Knee_CR`, `Knee_CS`, `Knee_HVLA`, `Knee_IND`, `Knee_Lymph`, `Knee_ME`, `Knee_MFR`, `Knee_PH`, `Knee_ST`, `Knee_VIS`, `Knee_Other`, `Knee_Specify`, `Knee_Response`, `Ankle_ART`, `Ankle_BLT`, `Ankle_CR`, `Ankle_CS`, `Ankle_HVLA`, `Ankle_IND`, `Ankle_Lymph`, `Ankle_ME`, `Ankle_MFR`, `Ankle_PH`, `Ankle_ST`, `Ankle_VIS`, `Ankle_Other`, `Ankle_Specify`, `Ankle_Response`, `C739`, `C739_1`, `C739_2`, `C739_8`, `C739_3`, `C739_4`, `C739_5`, `C739_9`, `C739_7`, `C739_6`, `Written_Diagnosis_1`, `Diagnosis_Code_1`, `Chief_Related_1`, `SD_Related_1`, `Written_Diagnosis_2`, `Diagnosis_Code_2`, `Chief_Related_2`, `SD_Related_2`, `Written_Diagnosis_3`, `Diagnosis_Code_3`, `Chief_Related_3`, `SD_Related_3`, `Written_Diagnosis_4`, `Diagnosis_Code_4`, `Chief_Related_4`, `SD_Related_4`, `Written_Diagnosis_5`, `Diagnosis_Code_5`, `Chief_Related_5`, `SD_Related_5`, `Written_Diagnosis_6`, `Diagnosis_Code_6`, `Chief_Related_6`, `SD_Related_6`, `Written_Diagnosis_7`, `Diagnosis_Code_7`, `Chief_Related_7`, `SD_Related_7`, `Procuedures_1`, `Procedures_2`, `Procedures_3`, `Procedures_4`, `Procedures_5`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) { logger(__LINE__, "MySQLi Prepare: $insert_SQL->error"); }
									if (!($insert_SQL->bind_param('sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', $code, $study_id, $HF_ART, $HF_BLT, $HF_CR, $HF_CS, $HF_HVLA, $HF_IND, $HF_Lymph, $HF_ME, $HF_MFR, $HF_PH, $HF_ST, $HF_VIS, $HF_Other, $HF_Specify, $HF_Response, $Neck_ART, $Neck_BLT, $Neck_CR, $Neck_CS, $Neck_HVLA, $Neck_IND, $Neck_Lymph, $Neck_ME, $Neck_MFR, $Neck_PH, $Neck_ST, $Neck_VIS, $Neck_Other, $Neck_Specify, $Neck_Response, $Thor_ART, $Thor_BLT, $Thor_CR, $Thor_CS, $Thor_HVLA, $Thor_IND, $Thor_Lymph, $Thor_ME, $Thor_MFR, $Thor_PH, $Thor_ST, $Thor_VIS, $Thor_Other, $Thor_Specify, $Thor_Response, $Ribs_ART, $Ribs_BLT, $Ribs_CR, $Ribs_CS, $Ribs_HVLA, $Ribs_IND, $Ribs_Lymph, $Ribs_ME, $Ribs_MFR, $Ribs_PH, $Ribs_ST, $Ribs_VIS, $Ribs_Other, $Ribs_Specify, $Rib_Response, $Lumb_ART, $Lumb_BLT, $Lumb_CR, $Lumb_CS, $Lumb_HVLA, $Lumb_IND, $Lumb_Lymph, $Lumb_ME, $Lumb_MFR, $Lumb_PH, $Lumb_ST, $Lumb_VIS, $Lumb_Other, $Lumb_Specify, $Lumb_Response, $Sac_ART, $Sac_BLT, $Sac_CR, $Sac_CS, $Sac_HVLA, $Sac_Ind, $Sac_Lymph, $Sac_ME, $Sac_MFR, $Sac_PH, $Sac_ST, $Sac_VIS, $Sac_Other, $Sac_Specify, $Sac_Response, $Pelvis_ART, $Pelvis_BLT, $Pelvis_CR, $Pelvis_CS, $Pelvis_HVLA, $Pelvis_IND, $Pelvis_Lymph, $Pelvis_ME, $Pelvis_MFR, $Pelvis_PH, $Pelvis_ST, $Pelvis_VIS, $Pelvis_Other, $Pelvis_Specify, $Pelvis_Response, $Abd_ART, $Abd_BLT, $Abd_CR, $Abd_CS, $Abd_HVLA, $Abd_IND, $Abd_Lymph, $Abd_ME, $Abd_MFR, $Abd_PH, $Abd_ST, $Abd_VIS, $Abd_Other, $Abd_Specify, $Abd_Response, $Up_Ex_ART, $Up_Ex_BLT, $Up_Ex_CR, $Up_Ex_CS, $Up_Ex_HVLA, $Up_Ex_IND, $Up_Ex_Lymph, $Up_Ex_ME, $Up_Ex_MFR, $Up_Ex_PH, $Up_Ex_ST, $Up_Ex_VIS, $Up_Ex_Other, $Up_Ex_Specify, $Up_Ex_Response, $Should_ART, $Should_BLT, $Should_CR, $Should_CS, $Should_HVLA, $Should_IND, $Should_Lymph, $Should_ME, $Should_MFR, $Should_PH, $Should_ST, $Should_VIS, $Should_Other, $Should_Specify, $Should_Response, $Elbow_ART, $Elbow_BLT, $Elbow_CR, $Elbow_CS, $Elbow_HVLA, $Elbow_IND, $Elbow_Lymph, $Elbow_ME, $Elbow_MFR, $Elbow_PH, $Elbow_ST, $Elbow_VIS, $Elbow_Other, $Elbow_Specify, $Elbow_Response, $Wrist_ART, $Wrist_BLT, $Wrist_CR, $Wrist_CS, $Wrist_HVLA, $Wrist_IND, $Wrist_Lymph, $Wrist_ME, $Wrist_MFR, $Wrist_PH, $Wrist_ST, $Wrist_VIS, $Wrist_Other, $Wrist_Specify, $Wrist_Response, $Low_Ex_ART, $Low_Ex_BLT, $Low_Ex_CR, $Low_Ex_CS, $Low_Ex_HVLA, $Low_Ex_IND, $Low_Ex_Lymph, $Low_Ex_ME, $Low_Ex_MFR, $Low_Ex_PH, $Low_Ex_ST, $Low_Ex_VIS, $Low_Ex_Other, $Low_Ex_Specify, $Low_Ex_Response, $Thigh_ART, $Thigh_BLT, $Thigh_CR, $Thigh_CS, $Thigh_HVLA, $Thigh_Ind, $Thigh_Lymph, $Thigh_ME, $Thigh_MFR, $Thigh_PH, $Thigh_ST, $Thigh_VIS, $Thigh_Other, $Thigh_Specify, $Thigh_Response, $Knee_ART, $Knee_BLT, $Knee_CR, $Knee_CS, $Knee_HVLA, $Knee_IND, $Knee_Lymph, $Knee_ME, $Knee_MFR, $Knee_PH, $Knee_ST, $Knee_VIS, $Knee_Other, $Knee_Specify, $Knee_Response, $Ankle_ART, $Ankle_BLT, $Ankle_CR, $Ankle_CS, $Ankle_HVLA, $Ankle_IND, $Ankle_Lymph, $Ankle_ME, $Ankle_MFR, $Ankle_PH, $Ankle_ST, $Ankle_VIS, $Ankle_Other, $Ankle_Specify, $Ankle_Response, $C739, $C739_1, $C739_2, $C739_8, $C739_3, $C739_4, $C739_5, $C739_9, $C739_7, $C739_6, $Written_Diagnosis_1, $Diagnosis_Code_1, $Chief_Related_1, $SD_Related_1, $Written_Diagnosis_2, $Diagnosis_Code_2, $Chief_Related_2, $SD_Related_2, $Written_Diagnosis_3, $Diagnosis_Code_3, $Chief_Related_3, $SD_Related_3, $Written_Diagnosis_4, $Diagnosis_Code_4, $Chief_Related_4, $SD_Related_4, $Written_Diagnosis_5, $Diagnosis_Code_5, $Chief_Related_5, $SD_Related_5, $Written_Diagnosis_6, $Diagnosis_Code_6, $Chief_Related_6, $SD_Related_6, $Written_Diagnosis_7, $Diagnosis_Code_7, $Chief_Related_7, $SD_Related_7, $Procuedures_1, $Procedures_2, $Procedures_3, $Procedures_4, $Procedures_5))) { logger(__LINE__, "MySQLi bindp: $insert_SQL->error"); }
									logger(__LINE__, "Inserting PET record for: " . $code);
									logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
									if (!($insert_SQL->execute())) { logger(__LINE__, "MySQLi execute: $insert_SQL->error"); }
									unset($insert_SQL);
								}
						}
					if (isset($insert_SQL)) { unset($insert_SQL);}
					fclose($input_filename);
					logger(__LINE__, "Completed Filename: " . $filename);
				}
			logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
			logger(__LINE__, " ====> End of PET Loop <====");
		}

logger(__LINE__, number_format((memory_get_usage() - $start_memory)) . " Bytes in use.");
logger(__LINE__, " ====> End of File <====");
?>