
-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `user_id` int(10) NOT NULL,
  `email` varchar(45) NOT NULL,
  `pass` varchar(80) NOT NULL,
  `pass_date` varchar(10) DEFAULT NULL,
  `rank` varchar(9) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `initials` varchar(5) DEFAULT NULL,
  `study` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
