-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 27, 2024 at 09:44 AM
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
-- Table structure for table `clients`
--

CREATE TABLE `client` (
  `ClientID` varchar(15) NOT NULL,
  `ExpectedFinishTimeofAppointment` int(11) DEFAULT 2,
  `AlternativeDates` int(11) NOT NULL DEFAULT 0,
  `EndUserilliterate` int(11) NOT NULL DEFAULT 0,
  `startTimeofAppointment` int(11) DEFAULT 2,
  `endUserMobile` int(11) DEFAULT 0,
  `endUserEmail` int(11) DEFAULT 0,
  `targetLanguage` int(11) DEFAULT 2,
  `yourEmailID` int(11) DEFAULT 2,
  `yourContactNumber` int(11) DEFAULT 2,
  `BudgetHolderName` varchar(65) NOT NULL DEFAULT '0',
  `contactPersonEmail` int(11) DEFAULT 1,
  `BudgetHolderContact` varchar(65) NOT NULL DEFAULT '0',
  `BudgetHolderEmail` varchar(65) NOT NULL DEFAULT '0',
  `ClientJobReferenceNumber` varchar(65) NOT NULL DEFAULT '1',
  `DeptOrTypeofCase` varchar(65) NOT NULL DEFAULT '1',
  `CostCentreCode` varchar(65) NOT NULL DEFAULT '1',
  `IsClientInclusive` varchar(65) NOT NULL DEFAULT '0',
  `DontChargeTravelTime` varchar(65) NOT NULL DEFAULT '0',
  `TrustServices` varchar(65) NOT NULL DEFAULT '0',
  `OtherTrusts` varchar(65) NOT NULL DEFAULT '0',
  `OtherNature` varchar(65) NOT NULL DEFAULT '0',
  `TrustLocationAddress` varchar(65) NOT NULL DEFAULT '0',
  `IsInclusiveForInterpreters` varchar(50) NOT NULL DEFAULT '0',
  `SendSMSToEndUser` varchar(50) NOT NULL DEFAULT '0',
  `SendEmailReminderToEndUser` varchar(100) NOT NULL DEFAULT '0',
  `ShowTimeSheetOnline` varchar(100) NOT NULL DEFAULT '0',
  `PayTravelTimeToInterpreterAfter` varchar(100) NOT NULL DEFAULT '0',
  `AfterHowManyMilesToChargeMileage` int(100) DEFAULT 0,
  `ChargeTravelTimeToClientAfter` int(100) DEFAULT NULL,
  `AfterHowManyMilesToPayMileageToLinguist` int(100) DEFAULT 0,
  `SubOffice` varchar(12) DEFAULT NULL,
  `DoyouhaveaLocationSessionID` int(11) DEFAULT 1,
  `DoYouHaveApproval4ThisBooking` int(11) DEFAULT 0,
  `ReasonF2FInterprterNeeded` int(11) DEFAULT 0,
  `AnyHealthSafetyHazzards` int(11) DEFAULT 2,
  `GenderofInterpreter` int(11) DEFAULT 1,
  `Officer` int(11) DEFAULT 2,
  `ClientCaller` int(11) DEFAULT 2,
  `DNA` int(11) DEFAULT 0,
  `InterpreterPaid` int(11) DEFAULT 0,
  `PayInterpreter` int(11) DEFAULT 0,
  `BookingAddressPostCode` int(11) DEFAULT 0,
  `BookingAddress3` int(11) DEFAULT 1,
  `BookingAddress2` int(11) DEFAULT 2,
  `BookingAdress1` int(11) DEFAULT 2,
  `HouseNo` int(11) DEFAULT 2,
  `BookingAddressID` int(11) DEFAULT 0,
  `telephoneinterpreting` int(11) DEFAULT 1,
  `remotevideointerpreting` int(11) NOT NULL DEFAULT 1,
  `remotebslvideointerpreting` int(11) NOT NULL DEFAULT 1,
  `skypeforbusiness` int(11) DEFAULT 0,
  `whatsapp` int(11) DEFAULT 0,
  `teams` int(11) DEFAULT 0,
  `zoom` int(11) DEFAULT 0,
  `f2finterpreting` int(11) DEFAULT 1,
  `transcription` varchar(25) NOT NULL DEFAULT '',
  `translation` varchar(25) NOT NULL DEFAULT '',
  `ServiceType` int(11) DEFAULT 2,
  `ClientClientName` int(11) DEFAULT 1,
  `show_review_inclient_admin` int(11) DEFAULT 0,
  `show_review_inclient` int(11) DEFAULT 0,
  `ccAdminEmail` varchar(200) DEFAULT '0',
  `clientAdminEmail` varchar(200) DEFAULT '0',
  `adminNeedEmailConfirmation` tinyint(40) DEFAULT 0,
  `client_admin_password` varchar(255) DEFAULT '0',
  `reject_booking` int(11) DEFAULT 0,
  `approved_booking` int(11) DEFAULT 0,
  `haveclientadmin` int(11) DEFAULT 0,
  `isold` varchar(20) NOT NULL DEFAULT 'yes',
  `savings_chart_for_client` int(11) NOT NULL DEFAULT 1,
  `cancellation_chart_for_client` int(11) NOT NULL DEFAULT 1,
  `response_chart_for_client` int(11) NOT NULL DEFAULT 1,
  `savings_chart_for_client_admin` int(11) NOT NULL DEFAULT 1,
  `cancellation_chart_for_client_admin` int(11) NOT NULL DEFAULT 1,
  `response_chart_for_client_admin` int(11) NOT NULL DEFAULT 1,
  `RVIRate` double DEFAULT NULL,
  `BSLVideoRate` double DEFAULT NULL,
  `ChargeClientByMinuteAfter1stHr` int(11) DEFAULT NULL,
  `ChargeClientNormalRate4OutOfhours` int(11) DEFAULT NULL,
  `ChargeClientFixedHrlyRate4OutOfHrs` double DEFAULT NULL,
  `OutOfOfficeHoursStartsAt` varchar(8) DEFAULT NULL,
  `OutOfOfficeHoursEndsAt` varchar(8) NOT NULL DEFAULT '',
  `RatePerMile2Client` double DEFAULT NULL,
  `reject_booking_client_user` int(11) DEFAULT NULL,
  `appointment` tinyint(4) DEFAULT NULL,
  `appointment_type` tinyint(4) DEFAULT NULL,
  `attendees` tinyint(4) DEFAULT NULL,
  `is_aleady_worked` tinyint(4) DEFAULT NULL,
  `papers_being_referred` tinyint(4) DEFAULT NULL,
  `TelPoneRate` varchar(25) NOT NULL DEFAULT '0.25',
  `ClientTelephoneRatePerMin` varchar(25) NOT NULL DEFAULT '',
  `ClientVideoRatePerMin` varchar(25) NOT NULL DEFAULT '',
  `ClientAgencyRating` varchar(25) NOT NULL DEFAULT '',
  `ClientSpecialRateAmountTelephonePerMin` varchar(25) NOT NULL DEFAULT '',
  `ClientSpecialRateAmountVideo` varchar(25) NOT NULL DEFAULT '',
  `Client3rdPartyTelephoneConferenceFeePerMinute` varchar(25) NOT NULL DEFAULT '',
  `Client3rdPartyVideoConferenceFeePerMinute` varchar(11) NOT NULL DEFAULT '',
  `ClientMinimumFeeAudio` varchar(25) NOT NULL DEFAULT '',
  `ClientMinimumFeeVideo` varchar(25) NOT NULL DEFAULT '',
  `ClientMinimumDurationAudio` varchar(25) NOT NULL DEFAULT '',
  `ClientMinimumDurationVideo` varchar(25) NOT NULL DEFAULT '',
  `IsProvidePatientLink` varchar(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `client` (`ClientID`, `ExpectedFinishTimeofAppointment`, `AlternativeDates`, `EndUserilliterate`, `startTimeofAppointment`, `endUserMobile`, `endUserEmail`, `targetLanguage`, `yourEmailID`, `yourContactNumber`, `BudgetHolderName`, `contactPersonEmail`, `BudgetHolderContact`, `BudgetHolderEmail`, `ClientJobReferenceNumber`, `DeptOrTypeofCase`, `CostCentreCode`, `IsClientInclusive`, `DontChargeTravelTime`, `TrustServices`, `OtherTrusts`, `OtherNature`, `TrustLocationAddress`, `IsInclusiveForInterpreters`, `SendSMSToEndUser`, `SendEmailReminderToEndUser`, `ShowTimeSheetOnline`, `PayTravelTimeToInterpreterAfter`, `AfterHowManyMilesToChargeMileage`, `ChargeTravelTimeToClientAfter`, `AfterHowManyMilesToPayMileageToLinguist`, `SubOffice`, `DoyouhaveaLocationSessionID`, `DoYouHaveApproval4ThisBooking`, `ReasonF2FInterprterNeeded`, `AnyHealthSafetyHazzards`, `GenderofInterpreter`, `Officer`, `ClientCaller`, `DNA`, `InterpreterPaid`, `PayInterpreter`, `BookingAddressPostCode`, `BookingAddress3`, `BookingAddress2`, `BookingAdress1`, `HouseNo`, `BookingAddressID`, `telephoneinterpreting`, `remotevideointerpreting`, `remotebslvideointerpreting`, `skypeforbusiness`, `whatsapp`, `teams`, `zoom`, `f2finterpreting`, `transcription`, `translation`, `ServiceType`, `ClientClientName`, `show_review_inclient_admin`, `show_review_inclient`, `ccAdminEmail`, `clientAdminEmail`, `adminNeedEmailConfirmation`, `client_admin_password`, `reject_booking`, `approved_booking`, `haveclientadmin`, `isold`, `savings_chart_for_client`, `cancellation_chart_for_client`, `response_chart_for_client`, `savings_chart_for_client_admin`, `cancellation_chart_for_client_admin`, `response_chart_for_client_admin`, `RVIRate`, `BSLVideoRate`, `ChargeClientByMinuteAfter1stHr`, `ChargeClientNormalRate4OutOfhours`, `ChargeClientFixedHrlyRate4OutOfHrs`, `OutOfOfficeHoursStartsAt`, `OutOfOfficeHoursEndsAt`, `RatePerMile2Client`, `reject_booking_client_user`, `appointment`, `appointment_type`, `attendees`, `is_aleady_worked`, `papers_being_referred`, `TelPoneRate`, `ClientTelephoneRatePerMin`, `ClientVideoRatePerMin`, `ClientAgencyRating`, `ClientSpecialRateAmountTelephonePerMin`, `ClientSpecialRateAmountVideo`, `Client3rdPartyTelephoneConferenceFeePerMinute`, `Client3rdPartyVideoConferenceFeePerMinute`, `ClientMinimumFeeAudio`, `ClientMinimumFeeVideo`, `ClientMinimumDurationAudio`, `ClientMinimumDurationVideo`, `IsProvidePatientLink`) VALUES
('89', 2, 0, 0, 2, 0, 0, 2, 2, 2, '0', 0, '0', '0', '2', '2', '0', '-1', '0', '0', '0', '0', '0', '-1', '0', '0', '0', '', 0, NULL, 0, '', 0, 0, 0, 2, 1, 2, 2, 0, 0, 0, 2, 1, 2, 2, 2, 0, 1, 1, 1, 1, 1, 1, 1, 1, '', '', 2, 2, 1, 1, '', '', 0, '', 0, 0, 0, 'yes', 1, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, '07:59:00', '17:59:00', 0.45, 0, 0, 0, 0, 0, 0, '0.2', '', '', '', '', '', '', '0', '', '', '', '', '0');

--
-- Triggers `clients`
--
DELIMITER $$
CREATE TRIGGER `set_restrictions` AFTER INSERT ON `client` FOR EACH ROW INSERT INTO user_page_restrictions
        ( `User_ID`, `User_Type`, `Page_ID`, `Page_Name`, `Permission`, `Date`, `User_Client`)
   VALUES
	(  NEW.ClientID , 1 , 1, 'upcoming_booking', '1','null','0'),
	(  NEW.ClientID  , 1 , 1, 'upcoming_booking', '1','null','1'),
    
	(  NEW.ClientID , 1 , 2, 'progress_booking', '1','null','0'),
	(  NEW.ClientID  , 1 , 2, 'progress_booking', '1','null','1'),
    
	(  NEW.ClientID    , 1 , 3, 'cancle_booking', '1','null','0'),
	(  NEW.ClientID  , 1 , 3, 'cancle_booking', '1','null','1'),
    
	(  NEW.ClientID  , 1 , 4, 'double_booking', '1','null','0'),
	(  NEW.ClientID  , 1 , 4, 'double_booking', '1','null','1'),
    
	(  NEW.ClientID  , 1 , 5, 'new_booking', '1','null','0'),
	(  NEW.ClientID  , 1 , 5, 'new_booking', '1','null','1'),
    
	(  NEW.ClientID  , 1 , 6, 'completed_jobs', '1','null','0'),
	(  NEW.ClientID  , 1 , 6, 'completed_jobs', '1','null','1')
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ClientID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
