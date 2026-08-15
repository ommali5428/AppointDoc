-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 01:18 PM
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
-- Database: `doctor`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `feedback` varchar(250) CHARACTER SET big5 COLLATE big5_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `feedback`) VALUES
(3, 'Pratik Sorathiya', 'pratik@gmail.com', 'The interface intuitive and user-friendly for both patients and healthcare providers'),
(7, 'Jay Sathiya', 'jaysathiya@gmail.com', 'this website is easy to use also easy to use for who dont know the use of website and its very useful for book doctor appointment.'),
(8, 'sonali', 'sonali@gmail.com', 'The system allow seamless selection of doctors, time slots, and appointment types');

-- --------------------------------------------------------

--
-- Table structure for table `tblappointment`
--

CREATE TABLE `tblappointment` (
  `ID` int(10) NOT NULL,
  `AppointmentNumber` int(10) DEFAULT NULL,
  `Name` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `AppointmentDate` date DEFAULT NULL,
  `AppointmentTime` time DEFAULT NULL,
  `Specialization` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Doctor` int(10) DEFAULT NULL,
  `Message` mediumtext CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ApplyDate` timestamp NULL DEFAULT current_timestamp(),
  `Remark` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Status` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `UpdatonDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblappointment`
--

INSERT INTO `tblappointment` (`ID`, `AppointmentNumber`, `Name`, `MobileNumber`, `Email`, `AppointmentDate`, `AppointmentTime`, `Specialization`, `Doctor`, `Message`, `ApplyDate`, `Remark`, `Status`, `UpdatonDate`) VALUES
(22, 295983882, 'omsathiya', 8320291772, 'omsathiya@gmail.com', '2025-04-08', '15:36:00', '1', 1, 'very pain', '2025-04-07 08:06:46', 'Your Appointment book on time', 'Approved', '2025-04-07 08:12:57'),
(23, 426185585, 'mayur', 123456890, 'mayur@gmail.com', '2025-04-16', '12:30:00', '1', 1, 'very pain', '2025-04-07 08:08:21', NULL, NULL, NULL),
(24, 361345681, 'Bhudev', 7016574109, 'bhudev@gmail.com', '2025-04-18', '12:43:00', '1', 3, 'very pain', '2025-04-07 08:09:00', NULL, NULL, NULL),
(25, 378915147, 'gandhi ', 9723088357, 'gandhi@gmail.com', '2025-04-20', '10:00:00', '1', 1, 'very pain', '2025-04-07 08:09:50', 'Sorry!', 'Cancelled', '2025-04-07 08:13:19'),
(26, 790964631, 'karan', 3106490440, 'karan@gmail.com', '2025-04-15', '13:41:00', '1', 3, 'very pain', '2025-04-07 08:11:16', NULL, NULL, NULL),
(27, 719619956, 'jay', 9426210657, 'jay@gmail.com', '2025-04-12', '09:22:00', '1', 2, 'very pain', '2025-04-07 08:12:13', NULL, NULL, NULL),
(28, 341704011, 'jaydip', 8200254505, 'jaydip@gmail.com', '2025-04-10', '10:00:00', '1', 1, 'very pain', '2025-04-07 08:14:52', NULL, NULL, NULL),
(29, 411596236, 'pratik', 9725573482, 'pratik@gmail.com', '2025-04-09', '10:45:00', '1', 1, 'very pain', '2025-04-07 08:15:50', NULL, NULL, NULL),
(30, 329370026, 'aditya', 1234568860, 'aditya@gmail.com', '2025-04-11', '10:45:00', '5', 11, 'very pain', '2025-04-07 08:17:20', NULL, NULL, NULL),
(31, 321691144, 'akash', 8200396504, 'akash@gmail.com', '2025-04-25', '15:50:00', '5', 12, 'very pain', '2025-04-07 08:18:04', NULL, NULL, NULL),
(35, 401939738, 'vatsu', 1324567980, 'vats@gmail.com', '2025-04-13', '20:53:00', '1', 1, 'jhjghjkl', '2025-04-11 15:23:44', NULL, NULL, NULL),
(36, 146691388, 'vaibhav', 7383142393, 'vaibhav@gmail.com', '2025-04-14', '15:00:00', '3', 23, 'very pain', '2025-04-12 16:35:58', NULL, NULL, NULL),
(37, 709596473, 'yash', 8320291773, 'yash@gmail.com', '2025-04-17', '12:00:00', '1', 1, 'very pain', '2025-04-15 06:02:18', 'done', 'Approved', '2025-04-15 06:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbldoctor`
--

CREATE TABLE `tbldoctor` (
  `ID` int(5) NOT NULL,
  `FullName` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Specialization` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Password` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `qualification` varchar(100) NOT NULL,
  `experience` varchar(50) NOT NULL,
  `hospital_detail` varchar(110) NOT NULL,
  `timing` varchar(110) NOT NULL,
  `images` varchar(100) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbldoctor`
--

INSERT INTO `tbldoctor` (`ID`, `FullName`, `MobileNumber`, `Email`, `Specialization`, `Password`, `qualification`, `experience`, `hospital_detail`, `timing`, `images`, `CreationDate`) VALUES
(1, 'Dr. Mehul Gosai', 1234567890, 'mehulgosai@gmail.com', '1', 'e10adc3949ba59abbe56e057f20f883e', 'Md Pediatrics,\r\nMBBS: G-31266,\r\nMD: G-12894', '19 years', 'Nr. ST Bus Stand, Jail Road, Bhavnagar 364001', '11: am to 01:00 pm.\r\nSunday: Closed', '592d04d8fd83b313a51fc565bc2a896d1739895609jpeg', '2025-02-18 16:20:09'),
(2, 'Dr Jayesh Pandya', 1234567890, 'jayeshpandya@gmail.com', '1', 'e10adc3949ba59abbe56e057f20f883e', 'mbbs', '15 years', 'Nandanvan Paediatric Hospital,Kalanal,Bhavnagar-364001', '10:30 am to 12:30 pm,\r\n05:30 pm to 07:30 pm.\r\nSunday: Close.\r\n', 'b05f2cab4d1cce58b802bf66f0605cc31739895774jpeg', '2025-02-18 16:22:54'),
(3, 'Dr Mehul Pateliya', 1234567890, 'mehulpateliya@gmail.com', '1', 'e10adc3949ba59abbe56e057f20f883e', 'MBBS, MD,\r\nPICU fellowship at Wadia Children Hospital Mumbai.', '10 years', 'Leela Circle, Sadvichar Hospital, 2nd floor, Shree Aalekh Complex, Kaliyabid, Bhavnagar 364001.', '09:00 am to 12:00 pm,\r\n06:00 pm  to 09:00 pm,\r\nSunday: 10:00 am to 12:00 pm ', '34f230694fcf07db5d7a819be4a60d681739895821.jpg', '2025-02-18 16:23:41'),
(11, 'Dr Siddharth Mukharjee', 1234567890, 'siddharthmukharjee@gmail.com', '5', 'e10adc3949ba59abbe56e057f20f883e', 'MBBS(MAMC), MD(Medicine),DM(Cardiology,FSCAI and FESC.', '12', 'Mukharjee Heart and Mind Clinic,209-212, Samved Complex, Jail Road, Bhavnagar,GJ 364001.', '08:30 Am - 05:00 Pm,Sunday: Closed', '7b6ae69bdde94c7647f9fef444830ca71741171047.jpg', '2025-03-05 10:37:27'),
(12, 'Dr Brajmohan Singh', 1234567890, 'brajmohansingh@gmail.com', '5', 'e10adc3949ba59abbe56e057f20f883e', 'MBBS MS(General Surgery),\r\nM.Ch(Cardiologist and  Vascular Surgery)', '13+', 'HCG Hospital, Meghani Circle,Bhavnagar,Gujarat.\r\n(Also in HCG Ahmedabad).', 'Everyday:09:30 Am - 01:00 Pm, 05:00  Pm - 06:00 Pm,\r\nSaturday: 09:00 Am - 01:00 Pm ,\r\nSunday: Closed', '508f1d0d05538cdec195189b238690321741172300.jpg', '2025-03-05 10:58:20'),
(23, 'Dr Umesh Parmar', 738324021, 'umeshparmar@gmail.com', '3', 'e10adc3949ba59abbe56e057f20f883e', 'DNB-National Board of Examination-2020,\r\nMD,\r\nDM', '6 Years', 'Durva Gastro Care, 5th Floor, Subham Complex, Kalubha Road, opp. Rasoi Hotel, Kalanala, Bhavnagar-364001', 'Saturday & Wednesday : 10 am - 6 pm,\r\nSunday : Closed,  \r\nOther days: 10 am - 7 pm. ', 'b84b7c456ac4a0f992875d942113ff161744472320.jpg', '2025-04-12 15:38:40'),
(24, 'Dr Bhavesh Bhut', 1234567890, 'bhaveshbhut@gmail.com', '3', 'e10adc3949ba59abbe56e057f20f883e', 'DM - 2020, \r\nMD - 2017,\r\nMBBS - 2013', '7 Years In healthCare', 'Sattva Gastroliv Hospital,\r\nParadhya one, 1st floor,Jail Rd, opp. Sir T Hospital, Panwadi, Bhavnagar', 'Tuesday - Saturday : 10 am - 2 pm,\r\n6 pm - 8 pm.\r\n Monday : 10 am - 8 pm,\r\n Sunday : Closed.', 'd52fe1e6b5c957059b7edddcc31e28511744475392.jpg', '2025-04-12 16:29:52'),
(25, 'Dr Prakash Bhatt', 7411796435, 'prakashbhatt@gmail.com', '2', 'e10adc3949ba59abbe56e057f20f883e', 'MBBS,\r\nDNB- General Medicine,\r\nDNB - Neurologist', '11 Years ( 5 Years as Specialist)', 'Satyam Neurology Hospital, No. 201-205, Praradhya One Complex, Jail Rd, Opp. Sir T Hospital,Bhavnagar', 'Monday - Friday: 10:30 am - 02:00 pm,\r\n05:00 pm - 07:00 pm,\r\nSaturday : 10:30 am - 02:00 pm,\r\nSunday: Closed', '69034fa095358d6606f0faac886bad881744539284.jpg', '2025-04-13 10:14:44');

-- --------------------------------------------------------

--
-- Table structure for table `tblspecialization`
--

CREATE TABLE `tblspecialization` (
  `ID` int(5) NOT NULL,
  `Specialization` varchar(30) DEFAULT NULL,
  `images` varchar(100) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblspecialization`
--

INSERT INTO `tblspecialization` (`ID`, `Specialization`, `images`, `CreationDate`) VALUES
(1, 'Childspecialist', 'c1e5edb49015d55f268649a984eb6bf61739894805.png', '2025-01-11 16:16:12'),
(2, 'Neurologist', '3f317bdd92a32be3483f50ed01523a0b1740146070.png', '2025-01-11 18:10:24'),
(3, 'Gastroenterologist', '907ef3d811bb627857975fd02f96c5021740146362.jpeg', '2025-01-11 18:11:54'),
(4, 'Dermatologist', '14078de4d8831703d4cb136130ee5f411740146478.png', '2025-01-11 18:12:11'),
(5, 'Cardiologist', 'aceb0571c93d43a865455968bdfda3271740146582.png', '2025-01-11 18:12:41'),
(6, 'Ophthalmologist', 'ed373df4813728d4882f8b213a2d1c3c1740146659.png', '2025-01-11 18:13:11');

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_form`
--

INSERT INTO `user_form` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(10, 'admin', 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'admin'),
(12, 'om sathiya', 'omsathiya@gmail.com', '3b779a9a19a2b5f60cb4975e8d9bb40f', 'user'),
(13, 'mayur makwana', 'mayur@gmail.com', 'ceb6c970658f31504a901b89dcd3e461', 'user'),
(14, 'Ayush', 'ayush@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'user'),
(15, 'yash', 'yash@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblappointment`
--
ALTER TABLE `tblappointment`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbldoctor`
--
ALTER TABLE `tbldoctor`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblspecialization`
--
ALTER TABLE `tblspecialization`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_form`
--
ALTER TABLE `user_form`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblappointment`
--
ALTER TABLE `tblappointment`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbldoctor`
--
ALTER TABLE `tbldoctor`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tblspecialization`
--
ALTER TABLE `tblspecialization`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_form`
--
ALTER TABLE `user_form`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
