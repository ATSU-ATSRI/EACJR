
-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `study_id` varchar(45) DEFAULT NULL,
  `survey_rec_id` varchar(20) DEFAULT NULL,
  `consent` int(11) DEFAULT NULL,
  `visit_days` int(11) DEFAULT NULL,
  `doctor` varchar(45) DEFAULT NULL,
  `age` varchar(11) DEFAULT NULL,
  `sex` varchar(11) DEFAULT NULL,
  `ethnicity` varchar(45) DEFAULT NULL,
  `race` varchar(45) DEFAULT NULL,
  `race_other` varchar(45) DEFAULT NULL,
  `further_yn` varchar(11) DEFAULT NULL,
  `further_why` longtext,
  `future_yn` varchar(11) DEFAULT NULL,
  `future_why` longtext,
  `paper` varchar(11) DEFAULT NULL,
  `complete` varchar(11) DEFAULT NULL,
  `phase` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
