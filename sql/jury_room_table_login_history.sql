
-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `seq` int(10) NOT NULL,
  `id` varchar(45) DEFAULT NULL,
  `login` datetime(6) DEFAULT NULL,
  `logout` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
