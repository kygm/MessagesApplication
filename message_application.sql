-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2020 at 06:38 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `message_application`
--

-- --------------------------------------------------------

--
-- Table structure for table `conversation`
--

CREATE TABLE `conversation` (
  `convoID` int(11) NOT NULL,
  `SenderID` int(11) NOT NULL,
  `RecieveID` int(11) NOT NULL,
  `msgID` int(11) NOT NULL,
  `convo_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msgID` int(11) NOT NULL,
  `msg_text` mediumtext NOT NULL,
  `msg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `security`
--

CREATE TABLE `security` (
  `UserID` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  `admin` int(1) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `blocked` int(1) NOT NULL,
  `logged_in` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `security`
--

INSERT INTO `security` (`UserID`, `username`, `password`, `admin`, `first_name`, `last_name`, `email`, `blocked`, `logged_in`) VALUES
(2, 'kevdog20', '$2y$10$fcDHsVjJlntj2IHIRpokkuD405k2EJtP/lN33wv7NHu3FKpOFuiEa', 1, 'Kevin', 'Gutierrez', 'rickev20@gmail.com', 0, 14),
(3, 'test', '$2y$10$ur4nBBFAFcrRCR7IqvuSeO2SmZaxtWVvQmHYply7.gG9Zd0pkX.Um', 0, 'test', 'test', 'test', 0, NULL),
(4, 'admin', '$2y$10$IlTTT/MXfT7QNH/kttjeH.nzQEuLM0vpJx1F6yVYq50oFpTYZEAhO', 1, 'admin', 'admin', 'admin', 0, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`convoID`),
  ADD KEY `FK1_SenderID` (`SenderID`),
  ADD KEY `FK2_RecieveID` (`RecieveID`),
  ADD KEY `FK3_MsgID` (`msgID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msgID`);

--
-- Indexes for table `security`
--
ALTER TABLE `security`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `convoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msgID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security`
--
ALTER TABLE `security`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conversation`
--
ALTER TABLE `conversation`
  ADD CONSTRAINT `FK1_SenderID` FOREIGN KEY (`SenderID`) REFERENCES `security` (`UserID`),
  ADD CONSTRAINT `FK2_RecieveID` FOREIGN KEY (`RecieveID`) REFERENCES `security` (`UserID`),
  ADD CONSTRAINT `FK3_MsgID` FOREIGN KEY (`msgID`) REFERENCES `messages` (`msgID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
