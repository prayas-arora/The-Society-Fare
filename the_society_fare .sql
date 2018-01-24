-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2018 at 12:02 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `the society fare`
--

-- --------------------------------------------------------

--
-- Table structure for table `ccs_events`
--

CREATE TABLE `ccs_events` (
  `event_id` int(11) NOT NULL,
  `curr_no_of_sub_events` int(11) NOT NULL DEFAULT '0',
  `event_name` varchar(100) NOT NULL,
  `event_date` varchar(20) NOT NULL,
  `event_time` varchar(20) NOT NULL,
  `event_year` varchar(10) NOT NULL,
  `event_venue` varchar(30) NOT NULL,
  `no_of_students` varchar(30) NOT NULL,
  `event_speaker` varchar(50) NOT NULL,
  `event_poster` varchar(100) NOT NULL,
  `brief_bio` text NOT NULL,
  `event_report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ccs_event_gallery`
--

CREATE TABLE `ccs_event_gallery` (
  `main_event_id` int(11) NOT NULL,
  `main_event_image` varchar(100) DEFAULT NULL,
  `main_event_attendance_image` varchar(100) DEFAULT NULL,
  `sub_event_id` int(11) DEFAULT NULL,
  `sub_event_image` varchar(100) DEFAULT NULL,
  `sub_event_attendance_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ccs_sub_events`
--

CREATE TABLE `ccs_sub_events` (
  `main_event_id` int(11) NOT NULL,
  `sub_event_id` int(11) NOT NULL,
  `sub_event_name` varchar(100) NOT NULL,
  `sub_event_date` varchar(20) NOT NULL,
  `sub_event_time` varchar(20) NOT NULL,
  `sub_event_year` varchar(10) NOT NULL,
  `sub_event_venue` varchar(30) NOT NULL,
  `sub_event_no_of_students` varchar(30) NOT NULL,
  `sub_event_speaker` varchar(50) NOT NULL,
  `sub_event_poster` varchar(100) NOT NULL,
  `sub_event_brief_bio` text NOT NULL,
  `sub_event_report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ieee_events`
--

CREATE TABLE `ieee_events` (
  `event_id` int(11) NOT NULL,
  `curr_no_of_sub_events` int(11) NOT NULL DEFAULT '0',
  `event_name` varchar(100) NOT NULL,
  `event_date` varchar(20) NOT NULL,
  `event_time` varchar(20) NOT NULL,
  `event_year` varchar(10) NOT NULL,
  `event_venue` varchar(30) NOT NULL,
  `no_of_students` varchar(30) NOT NULL,
  `event_speaker` varchar(50) NOT NULL,
  `event_poster` varchar(100) NOT NULL,
  `brief_bio` text NOT NULL,
  `event_report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ieee_event_gallery`
--

CREATE TABLE `ieee_event_gallery` (
  `main_event_id` int(11) NOT NULL,
  `main_event_image` varchar(100) DEFAULT NULL,
  `main_event_attendance_image` varchar(100) DEFAULT NULL,
  `sub_event_id` int(11) DEFAULT NULL,
  `sub_event_image` varchar(100) DEFAULT NULL,
  `sub_event_attendance_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ieee_sub_events`
--

CREATE TABLE `ieee_sub_events` (
  `main_event_id` int(11) NOT NULL,
  `sub_event_id` int(11) NOT NULL,
  `sub_event_name` varchar(100) NOT NULL,
  `sub_event_date` varchar(20) NOT NULL,
  `sub_event_time` varchar(20) NOT NULL,
  `sub_event_year` varchar(10) NOT NULL,
  `sub_event_venue` varchar(30) NOT NULL,
  `sub_event_no_of_students` varchar(30) NOT NULL,
  `sub_event_speaker` varchar(50) NOT NULL,
  `sub_event_poster` varchar(100) NOT NULL,
  `sub_event_brief_bio` text NOT NULL,
  `sub_event_report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `msc_events`
--

CREATE TABLE `msc_events` (
  `event_id` int(11) NOT NULL,
  `curr_no_of_sub_events` int(11) NOT NULL DEFAULT '0',
  `event_name` varchar(100) NOT NULL,
  `event_date` varchar(20) NOT NULL,
  `event_time` varchar(20) NOT NULL,
  `event_year` varchar(10) NOT NULL,
  `event_venue` varchar(30) NOT NULL,
  `no_of_students` varchar(30) NOT NULL,
  `event_speaker` varchar(50) NOT NULL,
  `event_poster` varchar(100) NOT NULL,
  `brief_bio` text NOT NULL,
  `event_report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `msc_event_gallery`
--

CREATE TABLE `msc_event_gallery` (
  `main_event_id` int(11) NOT NULL,
  `main_event_image` varchar(100) DEFAULT NULL,
  `main_event_attendance_image` varchar(100) DEFAULT NULL,
  `sub_event_id` int(11) DEFAULT NULL,
  `sub_event_image` varchar(100) DEFAULT NULL,
  `sub_event_attendance_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `msc_sub_events`
--

CREATE TABLE `msc_sub_events` (
  `main_event_id` int(11) NOT NULL,
  `sub_event_id` int(11) NOT NULL,
  `sub_event_name` varchar(100) NOT NULL,
  `sub_event_date` varchar(20) NOT NULL,
  `sub_event_time` varchar(20) NOT NULL,
  `sub_event_year` varchar(10) NOT NULL,
  `sub_event_venue` varchar(30) NOT NULL,
  `sub_event_no_of_students` varchar(30) NOT NULL,
  `sub_event_speaker` varchar(50) NOT NULL,
  `sub_event_poster` varchar(100) NOT NULL,
  `sub_event_brief_bio` text NOT NULL,
  `sub_event_report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `owasp_events`
--

CREATE TABLE `owasp_events` (
  `event_id` int(11) NOT NULL,
  `curr_no_of_sub_events` int(11) NOT NULL DEFAULT '0',
  `event_name` varchar(100) NOT NULL,
  `event_date` varchar(20) NOT NULL,
  `event_time` varchar(20) NOT NULL,
  `event_year` varchar(10) NOT NULL,
  `event_venue` varchar(30) NOT NULL,
  `no_of_students` varchar(30) NOT NULL,
  `event_speaker` varchar(50) NOT NULL,
  `event_poster` varchar(100) NOT NULL,
  `brief_bio` text NOT NULL,
  `event_report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `owasp_event_gallery`
--

CREATE TABLE `owasp_event_gallery` (
  `main_event_id` int(11) NOT NULL,
  `main_event_image` varchar(100) DEFAULT NULL,
  `main_event_attendance_image` varchar(100) DEFAULT NULL,
  `sub_event_id` int(11) DEFAULT NULL,
  `sub_event_image` varchar(100) DEFAULT NULL,
  `sub_event_attendance_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `owasp_sub_events`
--

CREATE TABLE `owasp_sub_events` (
  `main_event_id` int(11) NOT NULL,
  `sub_event_id` int(11) NOT NULL,
  `sub_event_name` varchar(100) NOT NULL,
  `sub_event_date` varchar(20) NOT NULL,
  `sub_event_time` varchar(20) NOT NULL,
  `sub_event_year` varchar(10) NOT NULL,
  `sub_event_venue` varchar(30) NOT NULL,
  `sub_event_no_of_students` varchar(30) NOT NULL,
  `sub_event_speaker` varchar(50) NOT NULL,
  `sub_event_poster` varchar(100) NOT NULL,
  `sub_event_brief_bio` text NOT NULL,
  `sub_event_report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ssa_events`
--

CREATE TABLE `ssa_events` (
  `event_id` int(11) NOT NULL,
  `curr_no_of_sub_events` int(11) NOT NULL DEFAULT '0',
  `event_name` varchar(100) NOT NULL,
  `event_date` varchar(20) NOT NULL,
  `event_time` varchar(20) NOT NULL,
  `event_year` varchar(10) NOT NULL,
  `event_venue` varchar(30) NOT NULL,
  `no_of_students` varchar(30) NOT NULL,
  `event_speaker` varchar(50) NOT NULL,
  `event_poster` varchar(100) NOT NULL,
  `brief_bio` text NOT NULL,
  `event_report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ssa_event_gallery`
--

CREATE TABLE `ssa_event_gallery` (
  `main_event_id` int(11) NOT NULL,
  `main_event_image` varchar(100) DEFAULT NULL,
  `main_event_attendance_image` varchar(100) DEFAULT NULL,
  `sub_event_id` int(11) DEFAULT NULL,
  `sub_event_image` varchar(100) DEFAULT NULL,
  `sub_event_attendance_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ssa_sub_events`
--

CREATE TABLE `ssa_sub_events` (
  `main_event_id` int(11) NOT NULL,
  `sub_event_id` int(11) NOT NULL,
  `sub_event_name` varchar(100) NOT NULL,
  `sub_event_date` varchar(20) NOT NULL,
  `sub_event_time` varchar(20) NOT NULL,
  `sub_event_year` varchar(10) NOT NULL,
  `sub_event_venue` varchar(30) NOT NULL,
  `sub_event_no_of_students` varchar(30) NOT NULL,
  `sub_event_speaker` varchar(50) NOT NULL,
  `sub_event_poster` varchar(100) NOT NULL,
  `sub_event_brief_bio` text NOT NULL,
  `sub_event_report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tedx_events`
--

CREATE TABLE `tedx_events` (
  `event_id` int(11) NOT NULL,
  `curr_no_of_sub_events` int(11) NOT NULL DEFAULT '0',
  `event_name` varchar(100) NOT NULL,
  `event_date` varchar(20) NOT NULL,
  `event_time` varchar(20) NOT NULL,
  `event_year` varchar(10) NOT NULL,
  `event_venue` varchar(30) NOT NULL,
  `no_of_students` varchar(30) NOT NULL,
  `event_speaker` varchar(50) NOT NULL,
  `event_poster` varchar(100) NOT NULL,
  `brief_bio` text NOT NULL,
  `event_report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tedx_event_gallery`
--

CREATE TABLE `tedx_event_gallery` (
  `main_event_id` int(11) NOT NULL,
  `main_event_image` varchar(100) DEFAULT NULL,
  `main_event_attendance_image` varchar(100) DEFAULT NULL,
  `sub_event_id` int(11) DEFAULT NULL,
  `sub_event_image` varchar(100) DEFAULT NULL,
  `sub_event_attendance_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tedx_sub_events`
--

CREATE TABLE `tedx_sub_events` (
  `main_event_id` int(11) NOT NULL,
  `sub_event_id` int(11) NOT NULL,
  `sub_event_name` varchar(100) NOT NULL,
  `sub_event_date` varchar(20) NOT NULL,
  `sub_event_time` varchar(20) NOT NULL,
  `sub_event_year` varchar(10) NOT NULL,
  `sub_event_venue` varchar(30) NOT NULL,
  `sub_event_no_of_students` varchar(30) NOT NULL,
  `sub_event_speaker` varchar(50) NOT NULL,
  `sub_event_poster` varchar(100) NOT NULL,
  `sub_event_brief_bio` text NOT NULL,
  `sub_event_report` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `society` varchar(100) NOT NULL,
  `fb_link` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `email_address`, `society`, `fb_link`) VALUES
(1, 'CCS1_TU', '02f76364e7fa988f902f54dfb40ff604', 'Dr. Inderveer', 'Kaur Channa', 'inderveer@thapar.edu', 'Creative Computing Society', 'https://www.facebook.com/CCSTU/'),
(2, 'CCS2_TU', '02f76364e7fa988f902f54dfb40ff604', 'Dr. Vinod', 'Bhalla', 'vkbhalla@thapar.edu', 'Creative Computing Society', 'https://www.facebook.com/CCSTU/'),
(3, 'SSA1_TU', '57d5022c05e80e6146437bf05ca6bd5a', 'Dr. Maninder', 'Singh', 'msingh@thapar.edu', 'Spiritual Scientist Alliance', 'https://www.facebook.com/ssathaparuniversity/'),
(4, 'SSA2_TU', '57d5022c05e80e6146437bf05ca6bd5a', 'Aieman', 'Preet Singh', 'aeiman@thapar.edu', 'Spiritual Scientist Alliance', 'https://www.facebook.com/ssathaparuniversity/'),
(5, 'MSC1_TU', '8fdd52b5993d5e813741805d777ee8cf', 'Dr. Prashant', 'Singh Rana', 'prashant.singh@thapar.edu', 'Microsoft Student Chapter', 'https://www.facebook.com/msc2k17/'),
(6, 'OWASP1_TU', 'd805603cdd2886461df557bacc49649c', 'Dr. Maninder', ' Singh', 'msingh@thapar.edu', 'OWASP', 'https://www.facebook.com/owasptsc/'),
(7, 'OWASP2_TU', 'd805603cdd2886461df557bacc49649c', 'Aieman', 'Preet Singh', 'aeiman@thapar.edu', 'OWASP', 'https://www.facebook.com/owasptsc/'),
(8, 'TEDX1_TU', '974280c8b5b05208c2b967cb649cd474', 'Dr. Maninder', 'Singh', 'msingh@thapar.edu', 'TEDx', 'https://www.facebook.com/tedxthaparuniversity/'),
(9, 'TEDX2_TU', '974280c8b5b05208c2b967cb649cd474', 'Aieman', 'Preet Singh', 'aeiman@thapar.edu', 'TEDx', 'https://www.facebook.com/tedxthaparuniversity/'),
(10, 'IEEE1_TU', '8be5ccba8f81c73033a1390032815587', 'Dr. Ashima', 'Singh', 'ashima@thapar.edu', 'IEEE', 'https://www.facebook.com/ieee.thapar/');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ccs_events`
--
ALTER TABLE `ccs_events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `ieee_events`
--
ALTER TABLE `ieee_events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `msc_events`
--
ALTER TABLE `msc_events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `owasp_events`
--
ALTER TABLE `owasp_events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `ssa_events`
--
ALTER TABLE `ssa_events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `tedx_events`
--
ALTER TABLE `tedx_events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ccs_events`
--
ALTER TABLE `ccs_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ieee_events`
--
ALTER TABLE `ieee_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `msc_events`
--
ALTER TABLE `msc_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `owasp_events`
--
ALTER TABLE `owasp_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ssa_events`
--
ALTER TABLE `ssa_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tedx_events`
--
ALTER TABLE `tedx_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
