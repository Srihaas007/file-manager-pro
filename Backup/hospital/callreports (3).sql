-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 25, 2024 at 12:55 PM
-- Server version: 10.11.7-MariaDB
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absolut1_access18`
--

-- --------------------------------------------------------

--
-- Table structure for table `callreports`
--

CREATE TABLE `callreports` (
  `SrNo` int(11) NOT NULL,
  `CallingCode` varchar(20) DEFAULT NULL,
  `Interpreter` varchar(50) DEFAULT NULL,
  `InterpreterID` varchar(12) DEFAULT '',
  `AgencyName` varchar(40) DEFAULT NULL,
  `AgencyID` varchar(50) DEFAULT NULL,
  `ClientAgency` varchar(15) DEFAULT NULL,
  `AgencyClientID` varchar(40) DEFAULT NULL,
  `DateOfJOb` varchar(25) NOT NULL,
  `TimeOfJOb` varchar(30) DEFAULT NULL,
  `DownloadedTimeZone` varchar(30) DEFAULT NULL,
  `Language1ID` varchar(30) DEFAULT NULL,
  `TargetLanguage` varchar(5) DEFAULT NULL,
  `TargetLanguageName` varchar(25) NOT NULL DEFAULT '',
  `ServiceID` varchar(4) DEFAULT NULL,
  `CallType` varchar(5) DEFAULT NULL,
  `ZoomSessionID` varchar(100) NOT NULL DEFAULT '',
  `NoOfHoursBooked` varchar(8) DEFAULT '',
  `ClientMinimumFeeAudio` varchar(7) DEFAULT NULL,
  `ClientMinimumFeeVideo` varchar(25) NOT NULL DEFAULT '',
  `ClientMinimumDurationAudio` varchar(10) DEFAULT NULL,
  `ClientMinimumDurationVideo` varchar(25) NOT NULL DEFAULT '',
  `NoOfHrsCharged` varchar(10) DEFAULT NULL,
  `ClientTelephoneRatePerMin` varchar(8) DEFAULT NULL,
  `ClientVideoRatePerMin` varchar(5) DEFAULT NULL,
  `CallDisconnectedBy` varchar(20) DEFAULT NULL COMMENT 'Who disconnected the call',
  `ClientAgencyRating` int(5) DEFAULT NULL COMMENT 'Requestor Rating',
  `ClientAgencyCallQualityRating` int(5) DEFAULT NULL COMMENT 'Requestor Call Quality Rating',
  `RatingByInterpreter` int(5) DEFAULT NULL COMMENT 'Interpreter Peer Rating',
  `InterpreterCallQualityRating` int(5) DEFAULT NULL,
  `InterpreterMinimumDurationPayable` varchar(5) DEFAULT '',
  `InterpreterMinimumFee` varchar(5) DEFAULT NULL,
  `InterpreterTelephoneRatePerMinute` varchar(5) DEFAULT NULL,
  `InterpreterVideoRatePerMinute` varchar(5) DEFAULT '',
  `ClientSpecialRateAmountTelephonePerMin` varchar(12) DEFAULT NULL COMMENT 'ClientSpecialRateAmountTelephonePerMin',
  `ClientSpecialRateAmountVideo` varchar(12) DEFAULT NULL COMMENT 'If special rate, then all calculations will be based on this rate',
  `InterpreterSpecialRateAmountVideoPerMin` int(12) DEFAULT NULL COMMENT 'If special rate, then all calculations will be based on this rate',
  `InterpreterSpecialRateAmountTelephonePerMin` int(12) DEFAULT NULL COMMENT 'If special rate, then all calculations will be based on this rate',
  `Client3rdPartyConferenceFeePerMinute` varchar(12) DEFAULT '' COMMENT 'This if for each additional party added to conference',
  `OtherParticipants` varchar(400) DEFAULT NULL,
  `NofOfOtherParticipants` int(10) DEFAULT 0,
  `ConferenceDurationMinutes` int(5) DEFAULT NULL COMMENT 'then you add this duration to NoOfHrsWorked x OtherParticipants column AH',
  `SageInvNumber` int(10) DEFAULT NULL COMMENT 'Account Invoice ID',
  `ClientInvoiceStatus` varchar(5) DEFAULT NULL COMMENT 'Account Invoice Status',
  `InterpreterInvoiceID` varchar(15) DEFAULT NULL,
  `InterpreterInvoiceStatus` varchar(15) DEFAULT NULL COMMENT 'InterpreterInvoiceStatus',
  `WaitingTimeBeforeCallConnectionToInterpreter` varchar(15) DEFAULT NULL COMMENT 'Queue Time (s)',
  `GenderOfInterpreter` varchar(9) DEFAULT NULL,
  `ClientDeviceType` varchar(25) DEFAULT NULL,
  `FromNumber` varchar(20) NOT NULL DEFAULT '' COMMENT 'app or landline ',
  `ClientAgencyDeviceInfo` varchar(30) NOT NULL DEFAULT '',
  `InterpreterDeviceInfo` varchar(25) DEFAULT NULL,
  `ClientIPAddress` varchar(20) DEFAULT NULL,
  `LInguistIPAddress` varchar(16) DEFAULT NULL,
  `ManualBackupName` varchar(20) DEFAULT NULL COMMENT 'Operator Name',
  `ManualBackupDurationBeforeCallConnectionToLinguist` varchar(10) NOT NULL DEFAULT '' COMMENT 'Operator Duration(S)',
  `TwillioContactNumber` varchar(25) DEFAULT NULL COMMENT 'Toll-Free Dialed',
  `TotalInterpreterPay` varchar(25) DEFAULT NULL,
  `IsBackupUsed` varchar(5) NOT NULL DEFAULT '',
  `BackupAccountID` varchar(9) DEFAULT NULL,
  `CallStatus` varchar(13) DEFAULT NULL,
  `CallStatusBackup` varchar(15) DEFAULT NULL COMMENT 'Call Status (Operator), Connected, NoResponse',
  `ClientAgencyPin` varchar(15) DEFAULT NULL COMMENT 'when dialing from landline direct to twillion audio call'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `callreports`
--

INSERT INTO `callreports` (`SrNo`, `CallingCode`, `Interpreter`, `InterpreterID`, `AgencyName`, `AgencyID`, `ClientAgency`, `AgencyClientID`, `DateOfJOb`, `TimeOfJOb`, `DownloadedTimeZone`, `Language1ID`, `TargetLanguage`, `TargetLanguageName`, `ServiceID`, `CallType`, `ZoomSessionID`, `NoOfHoursBooked`, `ClientMinimumFeeAudio`, `ClientMinimumFeeVideo`, `ClientMinimumDurationAudio`, `ClientMinimumDurationVideo`, `NoOfHrsCharged`, `ClientTelephoneRatePerMin`, `ClientVideoRatePerMin`, `CallDisconnectedBy`, `ClientAgencyRating`, `ClientAgencyCallQualityRating`, `RatingByInterpreter`, `InterpreterCallQualityRating`, `InterpreterMinimumDurationPayable`, `InterpreterMinimumFee`, `InterpreterTelephoneRatePerMinute`, `InterpreterVideoRatePerMinute`, `ClientSpecialRateAmountTelephonePerMin`, `ClientSpecialRateAmountVideo`, `InterpreterSpecialRateAmountVideoPerMin`, `InterpreterSpecialRateAmountTelephonePerMin`, `Client3rdPartyConferenceFeePerMinute`, `OtherParticipants`, `NofOfOtherParticipants`, `ConferenceDurationMinutes`, `SageInvNumber`, `ClientInvoiceStatus`, `InterpreterInvoiceID`, `InterpreterInvoiceStatus`, `WaitingTimeBeforeCallConnectionToInterpreter`, `GenderOfInterpreter`, `ClientDeviceType`, `FromNumber`, `ClientAgencyDeviceInfo`, `InterpreterDeviceInfo`, `ClientIPAddress`, `LInguistIPAddress`, `ManualBackupName`, `ManualBackupDurationBeforeCallConnectionToLinguist`, `TwillioContactNumber`, `TotalInterpreterPay`, `IsBackupUsed`, `BackupAccountID`, `CallStatus`, `CallStatusBackup`, `ClientAgencyPin`) VALUES
(528, 'Y5QU4MINZ', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-18', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '30', 'Either', 'Aivi Client App', '', 'android Droidlogic', '', '192.168.1.112', '', '', '', '+442038703548', '0', '1', '', '', '', ''),
(529, 'KECU4N9M7', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-18', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '5', 'Either', 'Aivi Client App', '', 'android Droidlogic', '', '192.168.1.112', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(530, 'TQNFHC3CQ', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-18', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android motorola', '', '192.168.1.117', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(531, 'FIBYQS2PP', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-18', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '9', 'Either', 'Aivi Client App', '', 'android motorola', '', '192.168.1.117', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(532, 'CW1JZ7G6F', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-18', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '3', 'Either', 'Aivi Client App', '', 'android Droidlogic', '', '192.168.1.112', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(533, '72428S0JZ', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-18', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '3', 'Either', 'Aivi Client App', '', 'android Droidlogic', '', '192.168.1.112', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(534, 'ADYU62S07', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-18', '', '', '', '63', 'Afghani', '', 'video', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android Droidlogic', '', '192.168.1.112', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(535, 'APB7JDT4Z', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-18', '', '', '', '63', 'Afghani', '', 'video', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android Droidlogic', '', '192.168.1.112', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(536, 'PSZDF6ERQ', 'Mohsin Ali', '', '', '', 'Warrington BC', '89', '2024-06-18', '', '', '', '6', 'German', '', 'audio', '', '60', '10', '15', '12', '20', '0', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 0, 0, '', '', '', '25', 'Either', 'Aivi Client App', '', 'android google', '', '10.91.120.83', '', '', '', '+442038703548', '0', '1', '', '', '', ''),
(537, 'ULVNFSKH6', 'Emal Haidari', '35031', '', '', '', '32033', '2024-06-19', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android Droidlogic', 'ios Apple', '192.168.1.114', '192.168.1.107', '', '', '+442038703548', '0', '', '', 'Connected', '', ''),
(538, 'T82EOE3HX', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-19', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '9', 'Either', 'Aivi Client App', '', 'android Droidlogic', '', '192.168.1.114', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(539, '3BCVX1TDO', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-19', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '9', 'Either', 'Aivi Client App', '', 'android Droidlogic', '', '192.168.1.114', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(540, 'XE1L8BQMC', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-19', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '14', 'Either', 'Aivi Client App', '', 'android Droidlogic', '', '192.168.1.114', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(541, '4AXNGF0CZ', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-19', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '15', 'Either', 'Aivi Client App', '', 'android Droidlogic', '', '192.168.1.114', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(542, 'LLZFKEMJQ', 'Emal Haidari', '35031', '', '', '', '32033', '2024-06-19', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '4', 'Either', 'Aivi Client App', '', 'android Droidlogic', 'ios Apple', '192.168.1.114', '192.168.1.107', '', '', '+442038703548', '0', '', '', 'Connected', '', ''),
(543, 'KMBHE8PW0', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-19', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android Droidlogic', '', '192.168.1.114', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(544, 'MCWJQ98OI', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-19', '', '', '', '63', 'Afghani', '', 'video', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android Droidlogic', '', '192.168.1.114', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(545, 'I5SGQGIJQ', 'Mohsin Ali', '', '', '', 'Warrington BC', '89', '2024-06-20', '', '', '', '6', 'German', '', 'audio', '', '60', '10', '15', '12', '20', '58', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 58, 0, '', '', '', '42', 'Either', 'Aivi Client App', '', 'android motorola', '', '192.168.1.117', '', '', '', '+442038703548', '0', '1', '', '', '', ''),
(546, 'W15CUHAVW', 'Abdul Nasir Ayoubi', '33221', '', '', 'Warrington BC', '89', '2024-06-21', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '10', '15', '12', '20', '3.02', '0.90', '1.25', 'Interpreter', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 0, 0, '', '', '', '180', 'Either', 'Aivi Client App', '', 'android samsung', '', '192.168.1.115', '', '', '', '+442038703548', '0', '', '', 'Connected', '', ''),
(547, 'Z2I3QKPNK', 'Abdul Nasir Ayoubi', '33221', '', '', '', '32033', '2024-06-21', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0.02', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android motorola', '', '192.168.1.117', '', '', '', '+442038703548', '0', '', '', 'Connected', '', ''),
(548, '6QWASSE99', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-21', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android motorola', '', '192.168.1.117', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(549, 'Q0FOBF6ZV', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-21', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android motorola', '', '94.30.1.52', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(550, 'XT5SG654Y', 'Mohsin Ali', '', '', '', '', '32033', '2024-06-21', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '', '', '', '', '0', '', '', 'Client', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, '', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android motorola', '', '94.30.1.52', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(551, 'W1MDLYZGU', 'Mohsin Ali', '', '', '', 'Warrington BC', '89', '2024-06-21', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '10', '15', '12', '20', '0', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android motorola', '', '94.30.1.52', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(552, 'POE1MVIZA', 'Abdul Nasir Ayoubi', '33221', '', '', 'Warrington BC', '89', '2024-06-21', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '10', '15', '12', '20', '0.05', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android HONOR', '', '82.132.245.94', '', '', '', '+442038703548', '0', '', '', 'Connected', '', ''),
(553, 'GF8JLH658', 'Mohsin Ali', '', '', '', 'Warrington BC', '89', '2024-06-21', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '10', '15', '12', '20', '0', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android google', '', '82.132.236.185', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(554, '0CGS8PGLM', 'Mohsin Ali', '', '', '', 'Warrington BC', '89', '2024-06-21', '', '', '', '6', 'German', '', 'audio', '', '60', '10', '15', '12', '20', '0', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 0, 0, '', '', '', '31', 'Either', 'Aivi Client App', '', 'android google', '', '82.132.236.185', '', '', '', '+442038703548', '0', '1', '', '', '', ''),
(555, 'C2QR1T78K', 'Mohsin Ali', '', '', '', 'Warrington BC', '89', '2024-06-21', '', '', '', '6', 'German', '', 'audio', '', '60', '10', '15', '12', '20', '0', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 0, 0, '', '', '', '20', 'Either', 'Aivi Client App', '', 'android google', '', '82.132.236.185', '', '', '', '+442038703548', '0', '1', '', '', '', ''),
(556, 'JZMS8JSOO', 'Mohsin Ali', '', '', '', 'Warrington BC', '89', '2024-06-21', '', '', '', '6', 'German', '', 'audio', '', '60', '10', '15', '12', '20', '92', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 92, 0, '', '', '', '30', 'Either', 'Aivi Client App', '', 'android google', '', '82.132.236.185', '', '', '', '+442038703548', '0', '1', '', '', '', ''),
(557, 'RQKT46TWP', 'Mohsin Ali', '', '', '', 'Warrington BC', '89', '2024-06-21', '', '', '', '6', 'German', '', 'audio', '', '60', '10', '15', '12', '20', '84.5', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 85, 0, '', '', '', '30', 'Either', 'Aivi Client App', '', 'android google', '', '82.132.236.185', '', '', '', '+442038703548', '0', '1', '', '', '', ''),
(558, '6TUWNHKZ9', 'Maryam Parveen', '', '', '', 'Warrington BC', '89', '2024-06-22', '', '', '', '6', 'German', '', 'audio', '', '60', '10', '15', '12', '20', '74', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 74, 0, '', '', '', '103', 'Either', 'Aivi Client App', '', 'android google', '', 'IP', '', '', '', '+442038703548', '0', '1', '', '', '', ''),
(559, '19Q5YXBC9', 'Maryam Parveen', '', '', '', 'Warrington BC', '89', '2024-06-22', '', '', '', '6', 'German', '', 'audio', '', '60', '10', '15', '12', '20', '71.5', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 72, 0, '', '', '', '116', 'Either', 'Aivi Client App', '', 'android google', '', 'IP', '', '', '', '+442038703548', '0', '1', '', '', '', ''),
(560, 'BHEO7MWJI', 'Maryam Parveen', '', '', '', 'Warrington BC', '89', '2024-06-23', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '10', '15', '12', '20', '0', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android google', '', 'IP', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(561, '09DWFO33V', 'Maryam Parveen', '', '', '', 'Warrington BC', '89', '2024-06-24', '', '', '', '63', 'Afghani', '', 'video', '', '60', '10', '15', '12', '20', '0', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '1.25', '', 0, 0, 0, '', '', '', '23', 'Either', 'Aivi Client App', '', 'android google', '', 'IP', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(562, '284R2PBK7', 'Maryam Parveen', '', '', '', 'Warrington BC', '89', '2024-06-24', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '10', '15', '12', '20', '0', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 0, 0, '', '', '', '7', 'Either', 'Aivi Client App', '', 'android samsung', '', '192.168.1.114', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(563, 'PICVQDPIG', 'Maryam Parveen', '', '', '', 'Warrington BC', '89', '2024-06-24', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '10', '15', '12', '20', '0', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 0, 0, '', '', '', '7', 'Either', 'Aivi Client App', '', 'android samsung', '', '192.168.1.114', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(564, 'A10KH7ZJT', 'Maryam Parveen', '', '', '', 'Warrington BC', '89', '2024-06-24', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '10', '15', '12', '20', '0', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android samsung', '', '192.168.1.114', '', '', '', '+442038703548', '0', '', '', '', '', ''),
(565, 'GRA1C3UV6', 'Maryam Parveen', '', '', '', 'Warrington BC', '89', '2024-06-24', '', '', '', '63', 'Afghani', '', 'audio', '', '60', '10', '15', '12', '20', '0', '0.90', '1.25', 'Client', 0, 0, 0, 0, '', '', '', '', '0.90', '1.10', 0, 0, '0.90', '', 0, 0, 0, '', '', '', '', 'Either', 'Aivi Client App', '', 'android samsung', '', '192.168.1.114', '', '', '', '+442038703548', '0', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `callreports`
--
ALTER TABLE `callreports`
  ADD PRIMARY KEY (`SrNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `callreports`
--
ALTER TABLE `callreports`
  MODIFY `SrNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=566;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
