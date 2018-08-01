
-- --------------------------------------------------------

--
-- Table structure for table `studys`
--

CREATE TABLE `studys` (
  `study_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `pi_name` varchar(45) DEFAULT NULL,
  `pi_email` varchar(45) DEFAULT NULL,
  `location` varchar(75) DEFAULT NULL,
  `quorum` varchar(45) DEFAULT '80',
  `consensus` varchar(45) DEFAULT '75'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
