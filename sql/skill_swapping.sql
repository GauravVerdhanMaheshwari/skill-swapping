-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2025 at 12:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skill_swapping`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AID` tinyint(1) UNSIGNED NOT NULL COMMENT 'It specifies admin’s Id ',
  `Name` char(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'It specifiesadmin’s username',
  `Email` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'It specifies admin’s email ',
  `Password` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'It specifies admin’s Password ',
  `Logs` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'It tells when the admin’s activity'
) ;

--
-- Dumping data for table `admin`
--


-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `Log` varchar(100) NOT NULL,
  `Time` varchar(100) NOT NULL,
  `What` varchar(100) NOT NULL,
  `AID` int(1) UNSIGNED NOT NULL,
  `LID` int(10) NOT NULL
) ;

--
-- Dumping data for table `admin_logs`
--

-- --------------------------------------------------------

--
-- Table structure for table `bio`
--

CREATE TABLE `bio` (
  `BID` int(10) UNSIGNED NOT NULL,
  `Bio` varchar(2000) NOT NULL,
  `UID` int(10) UNSIGNED NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `completed_courses`
--

CREATE TABLE `completed_courses` (
  `CCid` int(10) UNSIGNED NOT NULL,
  `Cid` int(10) UNSIGNED NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` varchar(2000) NOT NULL,
  `SkillNeeded` varchar(30) NOT NULL,
  `SkillTeaching` varchar(30) NOT NULL,
  `Price` int(5) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `UID` int(10) UNSIGNED NOT NULL COMMENT 'maker'
) ;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `Cid` int(10) UNSIGNED NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` varchar(2000) NOT NULL,
  `SkillNeeded` varchar(30) NOT NULL,
  `SkillTeaching` varchar(30) NOT NULL,
  `Price` int(5) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `UID` int(10) UNSIGNED NOT NULL COMMENT 'maker'
) ;

--
-- Dumping data for table `courses`
--



-- --------------------------------------------------------

--
-- Table structure for table `deleted_courses`
--

CREATE TABLE `deleted_courses` (
  `DCid` int(10) UNSIGNED NOT NULL,
  `Cid` int(10) UNSIGNED NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` varchar(2000) NOT NULL,
  `SkillNeeded` varchar(30) NOT NULL,
  `SkillTeaching` varchar(30) NOT NULL,
  `Price` int(5) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `UID` int(10) UNSIGNED NOT NULL COMMENT 'maker'
) ;

--
-- Dumping data for table `deleted_courses`
--


-- --------------------------------------------------------

--
-- Table structure for table `deleted_user`
--

CREATE TABLE `deleted_user` (
  `DID` int(10) UNSIGNED NOT NULL,
  `Time` date NOT NULL,
  `UserName` char(10) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `UID` int(10) NOT NULL
) ;

--
-- Dumping data for table `deleted_user`
--


-- --------------------------------------------------------

--
-- Table structure for table `enroll`
--

CREATE TABLE `enroll` (
  `EID` int(100) UNSIGNED NOT NULL,
  `CID` int(10) UNSIGNED NOT NULL,
  `Maker` int(10) UNSIGNED NOT NULL,
  `Enroller` int(10) UNSIGNED NOT NULL,
  `progress` int(11) DEFAULT 0
) ;

--
-- Dumping data for table `enroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `Log` varchar(100) NOT NULL,
  `Time` date NOT NULL,
  `What` varchar(100) NOT NULL,
  `UID` int(10) UNSIGNED NOT NULL,
  `LID` int(10) UNSIGNED NOT NULL
) ;

--
-- Dumping data for table `logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UID` int(10) UNSIGNED NOT NULL,
  `Name` char(10) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Logs` varchar(100) NOT NULL
) ;

--
-- Dumping data for table `user`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_skill`
--

CREATE TABLE `user_skill` (
  `SID` int(100) NOT NULL,
  `Skill_1` varchar(100) DEFAULT NULL,
  `Skill_2` varchar(100) DEFAULT NULL,
  `Skill_3` varchar(100) DEFAULT NULL,
  `UID` int(10) UNSIGNED NOT NULL
) ;

--
-- Dumping data for table `user_skill`
--



--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AID`);

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`LID`);

--
-- Indexes for table `bio`
--
ALTER TABLE `bio`
  ADD PRIMARY KEY (`BID`),
  ADD KEY `user` (`UID`);

--
-- Indexes for table `completed_courses`
--
ALTER TABLE `completed_courses`
  ADD KEY `Course_id` (`Cid`),
  ADD KEY `UID` (`UID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`Cid`),
  ADD KEY `userId` (`UID`);

--
-- Indexes for table `deleted_user`
--
ALTER TABLE `deleted_user`
  ADD PRIMARY KEY (`DID`);

--
-- Indexes for table `enroll`
--
ALTER TABLE `enroll`
  ADD PRIMARY KEY (`EID`),
  ADD KEY `Course` (`CID`),
  ADD KEY `Maker` (`Maker`),
  ADD KEY `Enroller` (`Enroller`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`LID`),
  ADD KEY `User_id` (`UID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `user_skill`
--
ALTER TABLE `user_skill`
  ADD PRIMARY KEY (`SID`),
  ADD KEY `UID` (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AID` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'It specifies admin’s Id ', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `LID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `bio`
--
ALTER TABLE `bio`
  MODIFY `BID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `Cid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `deleted_user`
--
ALTER TABLE `deleted_user`
  MODIFY `DID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `enroll`
--
ALTER TABLE `enroll`
  MODIFY `EID` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `LID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_skill`
--
ALTER TABLE `user_skill`
  MODIFY `SID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bio`
--
ALTER TABLE `bio`
  ADD CONSTRAINT `user` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`);

--
-- Constraints for table `completed_courses`
--
ALTER TABLE `completed_courses`
  ADD CONSTRAINT `Course_id` FOREIGN KEY (`Cid`) REFERENCES `courses` (`Cid`),
  ADD CONSTRAINT `MUID` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `userId` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`);

--
-- Constraints for table `enroll`
--
ALTER TABLE `enroll`
  ADD CONSTRAINT `Course` FOREIGN KEY (`CID`) REFERENCES `courses` (`Cid`),
  ADD CONSTRAINT `Enroller` FOREIGN KEY (`Enroller`) REFERENCES `user` (`UID`),
  ADD CONSTRAINT `Maker` FOREIGN KEY (`Maker`) REFERENCES `user` (`UID`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `User_id` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`) ON DELETE CASCADE;

--
-- Constraints for table `user_skill`
--
ALTER TABLE `user_skill`
  ADD CONSTRAINT `UID` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
