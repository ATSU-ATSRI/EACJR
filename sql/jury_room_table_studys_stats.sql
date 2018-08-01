
-- --------------------------------------------------------

--
-- Table structure for table `studys_stats`
--

CREATE TABLE `studys_stats` (
  `user_id` int(45) NOT NULL,
  `study_id` int(45) NOT NULL,
  `pttotal` int(45) NOT NULL,
  `rvtotal` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
