
-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `phase` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(10) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `comment` varchar(8000) DEFAULT NULL,
  `24hr_adverse_event` varchar(45) DEFAULT NULL,
  `72hr_adverse_event` varchar(45) DEFAULT NULL,
  `1wk_adverse_event` varchar(45) DEFAULT NULL,
  `followup_adverse_event` varchar(45) DEFAULT NULL,
  `ae_severity` varchar(45) DEFAULT NULL,
  `omt_related` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
