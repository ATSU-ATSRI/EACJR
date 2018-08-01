
-- --------------------------------------------------------

--
-- Table structure for table `symptom`
--

CREATE TABLE `symptom` (
  `event_id` int(11) NOT NULL,
  `study_id` varchar(45) NOT NULL,
  `insert_date` datetime(6) DEFAULT NULL,
  `phase` int(1) DEFAULT NULL,
  `code` varchar(11) NOT NULL,
  `symptom` varchar(200) DEFAULT NULL,
  `pt_baseline` varchar(45) DEFAULT NULL,
  `pt_baseline_severity` varchar(45) DEFAULT NULL,
  `pt_24hr` varchar(45) DEFAULT NULL,
  `pt_24hr_severity` varchar(45) DEFAULT NULL,
  `pt_24hr_related` varchar(45) DEFAULT NULL,
  `pt_24hr_details` longtext,
  `pt_72hr` varchar(45) DEFAULT NULL,
  `pt_72hr_severity` varchar(45) DEFAULT NULL,
  `pt_72hr_related` varchar(45) DEFAULT NULL,
  `pt_72hr_details` longtext,
  `pt_1wk` varchar(45) DEFAULT NULL,
  `pt_1wk_details` longtext,
  `followup_clinic` varchar(45) DEFAULT NULL,
  `followup_clinic_related` varchar(45) DEFAULT NULL,
  `followup_clinic_details` longtext,
  `followup_uc` varchar(45) DEFAULT NULL,
  `followup_uc_related` varchar(45) DEFAULT NULL,
  `followup_uc_details` longtext,
  `followup_er` varchar(45) DEFAULT NULL,
  `followup_er_related` varchar(45) DEFAULT NULL,
  `followup_er_details` longtext,
  `followup_hosp` varchar(45) DEFAULT NULL,
  `followup_hosp_related` varchar(45) DEFAULT NULL,
  `followup_hosp_details` longtext,
  `further` varchar(45) DEFAULT NULL,
  `further_why` longtext,
  `future` varchar(45) DEFAULT NULL,
  `future_why` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
