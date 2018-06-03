-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 03, 2018 at 12:43 AM
-- Server version: 5.7.20
-- PHP Version: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jury_room`
--

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `id` int(11) NOT NULL,
  `study_id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `HF_ART` int(11) DEFAULT NULL,
  `HF_BLT` int(11) DEFAULT NULL,
  `HF_CR` int(11) DEFAULT NULL,
  `HF_CS` int(11) DEFAULT NULL,
  `HF_HVLA` int(11) DEFAULT NULL,
  `HF_IND` int(11) DEFAULT NULL,
  `HF_Lymph` int(11) DEFAULT NULL,
  `HF_ME` int(11) DEFAULT NULL,
  `HF_MFR` int(11) DEFAULT NULL,
  `HF_PH` int(11) DEFAULT NULL,
  `HF_ST` int(11) DEFAULT NULL,
  `HF_VIS` int(11) DEFAULT NULL,
  `HF_Other` int(11) DEFAULT NULL,
  `HF_Specify` text,
  `HF_Response` varchar(4) DEFAULT NULL,
  `Neck_ART` int(11) DEFAULT NULL,
  `Neck_BLT` int(11) DEFAULT NULL,
  `Neck_CR` int(11) DEFAULT NULL,
  `Neck_CS` int(11) DEFAULT NULL,
  `Neck_HVLA` int(11) DEFAULT NULL,
  `Neck_IND` int(11) DEFAULT NULL,
  `Neck_Lymph` int(11) DEFAULT NULL,
  `Neck_ME` int(11) DEFAULT NULL,
  `Neck_MFR` int(11) DEFAULT NULL,
  `Neck_PH` int(11) DEFAULT NULL,
  `Neck_ST` int(11) DEFAULT NULL,
  `Neck_VIS` int(11) DEFAULT NULL,
  `Neck_Other` int(11) DEFAULT NULL,
  `Neck_Specify` text,
  `Neck_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Thor_ART` int(11) DEFAULT NULL,
  `Thor_BLT` int(11) DEFAULT NULL,
  `Thor_CR` int(11) DEFAULT NULL,
  `Thor_CS` int(11) DEFAULT NULL,
  `Thor_HVLA` int(11) DEFAULT NULL,
  `Thor_IND` int(11) DEFAULT NULL,
  `Thor_Lymph` int(11) DEFAULT NULL,
  `Thor_ME` int(11) DEFAULT NULL,
  `Thor_MFR` int(11) DEFAULT NULL,
  `Thor_PH` int(11) DEFAULT NULL,
  `Thor_ST` int(11) DEFAULT NULL,
  `Thor_VIS` int(11) DEFAULT NULL,
  `Thor_Other` int(11) DEFAULT NULL,
  `Thor_Specify` text CHARACTER SET latin1,
  `Thor_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Ribs_ART` int(11) DEFAULT NULL,
  `Ribs_BLT` int(11) DEFAULT NULL,
  `Ribs_CR` int(11) DEFAULT NULL,
  `Ribs_CS` int(11) DEFAULT NULL,
  `Ribs_HVLA` int(11) DEFAULT NULL,
  `Ribs_IND` int(11) DEFAULT NULL,
  `Ribs_Lymph` int(11) DEFAULT NULL,
  `Ribs_ME` int(11) DEFAULT NULL,
  `Ribs_MFR` int(11) DEFAULT NULL,
  `Ribs_PH` int(11) DEFAULT NULL,
  `Ribs_ST` int(11) DEFAULT NULL,
  `Ribs_VIS` int(11) DEFAULT NULL,
  `Ribs_Other` int(11) DEFAULT NULL,
  `Ribs_Specify` text,
  `Rib_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Lumb_ART` int(11) DEFAULT NULL,
  `Lumb_BLT` int(11) DEFAULT NULL,
  `Lumb_CR` int(11) DEFAULT NULL,
  `Lumb_CS` int(11) DEFAULT NULL,
  `Lumb_HVLA` int(11) DEFAULT NULL,
  `Lumb_IND` int(11) DEFAULT NULL,
  `Lumb_Lymph` int(11) DEFAULT NULL,
  `Lumb_ME` int(11) DEFAULT NULL,
  `Lumb_MFR` int(11) DEFAULT NULL,
  `Lumb_PH` int(11) DEFAULT NULL,
  `Lumb_ST` int(11) DEFAULT NULL,
  `Lumb_VIS` int(11) DEFAULT NULL,
  `Lumb_Other` int(11) DEFAULT NULL,
  `Lumb_Specify` text CHARACTER SET latin1,
  `Lumb_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Sac_ART` int(11) DEFAULT NULL,
  `Sac_BLT` int(11) DEFAULT NULL,
  `Sac_CR` int(11) DEFAULT NULL,
  `Sac_CS` int(11) DEFAULT NULL,
  `Sac_HVLA` int(11) DEFAULT NULL,
  `Sac_Ind` int(11) DEFAULT NULL,
  `Sac_Lymph` int(11) DEFAULT NULL,
  `Sac_ME` int(11) DEFAULT NULL,
  `Sac_MFR` int(11) DEFAULT NULL,
  `Sac_PH` int(11) DEFAULT NULL,
  `Sac_ST` int(11) DEFAULT NULL,
  `Sac_VIS` int(11) DEFAULT NULL,
  `Sac_Other` int(11) DEFAULT NULL,
  `Sac_Specify` text CHARACTER SET latin1,
  `Sac_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Pelvis_ART` int(11) DEFAULT NULL,
  `Pelvis_BLT` int(11) DEFAULT NULL,
  `Pelvis_CR` int(11) DEFAULT NULL,
  `Pelvis_CS` int(11) DEFAULT NULL,
  `Pelvis_HVLA` int(11) DEFAULT NULL,
  `Pelvis_IND` int(11) DEFAULT NULL,
  `Pelvis_Lymph` int(11) DEFAULT NULL,
  `Pelvis_ME` int(11) DEFAULT NULL,
  `Pelvis_MFR` int(11) DEFAULT NULL,
  `Pelvis_PH` int(11) DEFAULT NULL,
  `Pelvis_ST` int(11) DEFAULT NULL,
  `Pelvis_VIS` int(11) DEFAULT NULL,
  `Pelvis_Other` int(11) DEFAULT NULL,
  `Pelvis_Specify` text CHARACTER SET latin1,
  `Pelvis_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Abd_ART` int(11) DEFAULT NULL,
  `Abd_BLT` int(11) DEFAULT NULL,
  `Abd_CR` int(11) DEFAULT NULL,
  `Abd_CS` int(11) DEFAULT NULL,
  `Abd_HVLA` int(11) DEFAULT NULL,
  `Abd_IND` int(11) DEFAULT NULL,
  `Abd_Lymph` int(11) DEFAULT NULL,
  `Abd_ME` int(11) DEFAULT NULL,
  `Abd_MFR` int(11) DEFAULT NULL,
  `Abd_PH` int(11) DEFAULT NULL,
  `Abd_ST` int(11) DEFAULT NULL,
  `Abd_VIS` int(11) DEFAULT NULL,
  `Abd_Other` int(11) DEFAULT NULL,
  `Abd_Specify` text CHARACTER SET latin1,
  `Abd_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Up_Ex_ART` int(11) DEFAULT NULL,
  `Up_Ex_BLT` int(11) DEFAULT NULL,
  `Up_Ex_CR` int(11) DEFAULT NULL,
  `Up_Ex_CS` int(11) DEFAULT NULL,
  `Up_Ex_HVLA` int(11) DEFAULT NULL,
  `Up_Ex_IND` int(11) DEFAULT NULL,
  `Up_Ex_Lymph` int(11) DEFAULT NULL,
  `Up_Ex_ME` int(11) DEFAULT NULL,
  `Up_Ex_MFR` int(11) DEFAULT NULL,
  `Up_Ex_PH` int(11) DEFAULT NULL,
  `Up_Ex_ST` int(11) DEFAULT NULL,
  `Up_Ex_VIS` int(11) DEFAULT NULL,
  `Up_Ex_Other` int(11) DEFAULT NULL,
  `Up_Ex_Specify` text CHARACTER SET latin1,
  `Up_Ex_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Should_ART` int(11) DEFAULT NULL,
  `Should_BLT` int(11) DEFAULT NULL,
  `Should_CR` int(11) DEFAULT NULL,
  `Should_CS` int(11) DEFAULT NULL,
  `Should_HVLA` int(11) DEFAULT NULL,
  `Should_IND` int(11) DEFAULT NULL,
  `Should_Lymph` int(11) DEFAULT NULL,
  `Should_ME` int(11) DEFAULT NULL,
  `Should_MFR` int(11) DEFAULT NULL,
  `Should_PH` int(11) DEFAULT NULL,
  `Should_ST` int(11) DEFAULT NULL,
  `Should_VIS` int(11) DEFAULT NULL,
  `Should_Other` int(11) DEFAULT NULL,
  `Should_Specify` text CHARACTER SET latin1,
  `Should_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Elbow_ART` int(11) DEFAULT NULL,
  `Elbow_BLT` int(11) DEFAULT NULL,
  `Elbow_CR` int(11) DEFAULT NULL,
  `Elbow_CS` int(11) DEFAULT NULL,
  `Elbow_HVLA` int(11) DEFAULT NULL,
  `Elbow_IND` int(11) DEFAULT NULL,
  `Elbow_Lymph` int(11) DEFAULT NULL,
  `Elbow_ME` int(11) DEFAULT NULL,
  `Elbow_MFR` int(11) DEFAULT NULL,
  `Elbow_PH` int(11) DEFAULT NULL,
  `Elbow_ST` int(11) DEFAULT NULL,
  `Elbow_VIS` int(11) DEFAULT NULL,
  `Elbow_Other` int(11) DEFAULT NULL,
  `Elbow_Specify` text CHARACTER SET latin1,
  `Elbow_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Wrist_ART` int(11) DEFAULT NULL,
  `Wrist_BLT` int(11) DEFAULT NULL,
  `Wrist_CR` int(11) DEFAULT NULL,
  `Wrist_CS` int(11) DEFAULT NULL,
  `Wrist_HVLA` int(11) DEFAULT NULL,
  `Wrist_IND` int(11) DEFAULT NULL,
  `Wrist_Lymph` int(11) DEFAULT NULL,
  `Wrist_ME` int(11) DEFAULT NULL,
  `Wrist_MFR` int(11) DEFAULT NULL,
  `Wrist_PH` int(11) DEFAULT NULL,
  `Wrist_ST` int(11) DEFAULT NULL,
  `Wrist_VIS` int(11) DEFAULT NULL,
  `Wrist_Other` int(11) DEFAULT NULL,
  `Wrist_Specify` text CHARACTER SET latin1,
  `Wrist_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Low_Ex_ART` int(11) DEFAULT NULL,
  `Low_Ex_BLT` int(11) DEFAULT NULL,
  `Low_Ex_CR` int(11) DEFAULT NULL,
  `Low_Ex_CS` int(11) DEFAULT NULL,
  `Low_Ex_HVLA` int(11) DEFAULT NULL,
  `Low_Ex_IND` int(11) DEFAULT NULL,
  `Low_Ex_Lymph` int(11) DEFAULT NULL,
  `Low_Ex_ME` int(11) DEFAULT NULL,
  `Low_Ex_MFR` int(11) DEFAULT NULL,
  `Low_Ex_PH` int(11) DEFAULT NULL,
  `Low_Ex_ST` int(11) DEFAULT NULL,
  `Low_Ex_VIS` int(11) DEFAULT NULL,
  `Low_Ex_Other` int(11) DEFAULT NULL,
  `Low_Ex_Specify` text CHARACTER SET latin1,
  `Low_Ex_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Thigh_ART` int(11) DEFAULT NULL,
  `Thigh_BLT` int(11) DEFAULT NULL,
  `Thigh_CR` int(11) DEFAULT NULL,
  `Thigh_CS` int(11) DEFAULT NULL,
  `Thigh_HVLA` int(11) DEFAULT NULL,
  `Thigh_Ind` int(11) DEFAULT NULL,
  `Thigh_Lymph` int(11) DEFAULT NULL,
  `Thigh_ME` int(11) DEFAULT NULL,
  `Thigh_MFR` int(11) DEFAULT NULL,
  `Thigh_PH` int(11) DEFAULT NULL,
  `Thigh_ST` int(11) DEFAULT NULL,
  `Thigh_VIS` int(11) DEFAULT NULL,
  `Thigh_Other` int(11) DEFAULT NULL,
  `Thigh_Specify` text CHARACTER SET latin1,
  `Thigh_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Knee_ART` int(11) DEFAULT NULL,
  `Knee_BLT` int(11) DEFAULT NULL,
  `Knee_CR` int(11) DEFAULT NULL,
  `Knee_CS` int(11) DEFAULT NULL,
  `Knee_HVLA` int(11) DEFAULT NULL,
  `Knee_IND` int(11) DEFAULT NULL,
  `Knee_Lymph` int(11) DEFAULT NULL,
  `Knee_ME` int(11) DEFAULT NULL,
  `Knee_MFR` int(11) DEFAULT NULL,
  `Knee_PH` int(11) DEFAULT NULL,
  `Knee_ST` int(11) DEFAULT NULL,
  `Knee_VIS` int(11) DEFAULT NULL,
  `Knee_Other` int(11) DEFAULT NULL,
  `Knee_Specify` text CHARACTER SET latin1,
  `Knee_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `Ankle_ART` int(11) DEFAULT NULL,
  `Ankle_BLT` int(11) DEFAULT NULL,
  `Ankle_CR` int(11) DEFAULT NULL,
  `Ankle_CS` int(11) DEFAULT NULL,
  `Ankle_HVLA` int(11) DEFAULT NULL,
  `Ankle_IND` int(11) DEFAULT NULL,
  `Ankle_Lymph` int(11) DEFAULT NULL,
  `Ankle_ME` int(11) DEFAULT NULL,
  `Ankle_MFR` int(11) DEFAULT NULL,
  `Ankle_PH` int(11) DEFAULT NULL,
  `Ankle_ST` int(11) DEFAULT NULL,
  `Ankle_VIS` int(11) DEFAULT NULL,
  `Ankle_Other` int(11) DEFAULT NULL,
  `Ankle_Specify` text CHARACTER SET latin1,
  `Ankle_Response` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `C739` int(11) DEFAULT NULL,
  `C739_1` int(11) DEFAULT NULL,
  `C739_2` int(11) DEFAULT NULL,
  `C739_8` int(11) DEFAULT NULL,
  `C739_3` int(11) DEFAULT NULL,
  `C739_4` int(11) DEFAULT NULL,
  `C739_5` int(11) DEFAULT NULL,
  `C739_9` int(11) DEFAULT NULL,
  `C739_7` int(11) DEFAULT NULL,
  `C739_6` int(11) DEFAULT NULL,
  `Written_Diagnosis_1` text CHARACTER SET latin1,
  `Diagnosis_Code_1` varchar(8) CHARACTER SET latin1 DEFAULT NULL,
  `Chief_Related_1` text,
  `SD_Related_1` text,
  `Written_Diagnosis_2` text CHARACTER SET latin1,
  `Diagnosis_Code_2` varchar(8) CHARACTER SET latin1 DEFAULT NULL,
  `Chief_Related_2` text,
  `SD_Related_2` text,
  `Written_Diagnosis_3` text CHARACTER SET latin1,
  `Diagnosis_Code_3` varchar(8) CHARACTER SET latin1 DEFAULT NULL,
  `Chief_Related_3` text,
  `SD_Related_3` text,
  `Written_Diagnosis_4` text CHARACTER SET latin1,
  `Diagnosis_Code_4` varchar(8) CHARACTER SET latin1 DEFAULT NULL,
  `Chief_Related_4` text,
  `SD_Related_4` text,
  `Written_Diagnosis_5` text CHARACTER SET latin1,
  `Diagnosis_Code_5` varchar(8) CHARACTER SET latin1 DEFAULT NULL,
  `Chief_Related_5` text,
  `SD_Related_5` text,
  `Written_Diagnosis_6` text CHARACTER SET latin1,
  `Diagnosis_Code_6` varchar(8) CHARACTER SET latin1 DEFAULT NULL,
  `Chief_Related_6` text,
  `SD_Related_6` text,
  `Written_Diagnosis_7` text CHARACTER SET latin1,
  `Diagnosis_Code_7` varchar(8) CHARACTER SET latin1 DEFAULT NULL,
  `Chief_Related_7` text,
  `SD_Related_7` text,
  `Procuedures_1` text CHARACTER SET latin1,
  `Procedures_2` text CHARACTER SET latin1,
  `Procedures_3` text CHARACTER SET latin1,
  `Procedures_4` text CHARACTER SET latin1,
  `Procedures_5` text CHARACTER SET latin1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
