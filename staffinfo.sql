-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2022 at 03:12 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leave_tracker4`
--

--
-- Dumping data for table `staffinfo`
--

INSERT INTO `staffinfo` (`staffID`, `memberID`, `departmentID`, `clearanceLevel`, `firstName`, `middleName`, `lastName`, `email`, `phoneNumber`, `city`, `state`, `country`, `avatar`, `planned`, `joinDate`, `leaveDate`, `location`, `functionalManager`, `locationManager`, `removed_By`, `removed_On`, `photo_id`, `birthDate`) VALUES
(1, 1, NULL, 5, 'David', 'NULL', ' Moreno', 'davidmoreno@72dragons.com', '5', NULL, NULL, NULL, 'images/2022_04_11_06_11_21_david.jpg', NULL, '2020-06-09', NULL, 'USA', '66', '66', NULL, NULL, NULL, NULL),
(5, 5, NULL, 1, 'Micheal', NULL, '', 'Micheal@gmail.com', NULL, NULL, NULL, NULL, 'images/2022_04_08_03_39_18_Sunflower_from_Silesia2.jpg', NULL, '2020-06-09', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(22, 22, NULL, 1, 'Anya', NULL, 'Wang', 'Anya@gmail.com', NULL, NULL, NULL, NULL, 'images/2022_04_08_03_39_18_Sunflower_from_Silesia2.jpg', NULL, '2020-06-09', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(32, 32, NULL, 1, 'Sashi', NULL, '', 'Sashi@gmail.com', NULL, NULL, NULL, NULL, 'images/2022_04_08_03_39_18_Sunflower_from_Silesia2.jpg', NULL, '2020-06-09', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(35, 35, NULL, 1, 'Lu', NULL, 'Cheng', 'Lu@gmail.com', NULL, NULL, NULL, NULL, 'images/2022_04_08_03_39_18_Sunflower_from_Silesia2.jpg', NULL, '2020-06-09', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(36, 36, NULL, 1, 'Alajandro', NULL, '', 'Alajandro@gmail.com', NULL, NULL, NULL, NULL, 'images/2022_04_08_03_39_18_Sunflower_from_Silesia2.jpg', NULL, '2020-06-09', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(38, 38, NULL, 1, 'Asteria', NULL, 'zhang', 'asteria@gmail.com', NULL, NULL, NULL, NULL, 'images/2022_04_08_03_39_18_Sunflower_from_Silesia2.jpg', NULL, '2020-06-09', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(41, 41, NULL, 1, 'Martin', NULL, 'm', 'martin@gmail.com', NULL, NULL, NULL, NULL, 'images/2022_04_08_03_39_18_Sunflower_from_Silesia2.jpg', NULL, '2020-06-09', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(62, 66, NULL, 5, 'Bradley', NULL, 'M', 'Brad@gmail.com', NULL, NULL, NULL, NULL, 'images/2022_04_08_03_39_18_Sunflower_from_Silesia2.jpg', NULL, '2020-06-09', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(63, 67, NULL, 1, 'pooja', 'NULL', 'NULL', 'pooja@gmail.com', '5', NULL, NULL, NULL, 'images/2022_04_11_12_27_45_Sunflower_from_Silesia2.jpg', NULL, '2020-06-09', NULL, 'India', '1', '1', NULL, NULL, NULL, NULL),
(64, 68, NULL, 1, 'Amit', NULL, 'Mishra', 'amit@72dragons.com', NULL, NULL, NULL, NULL, 'images/2022_04_08_03_39_18_Sunflower_from_Silesia2.jpg', NULL, '2020-06-09', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(71, 69, NULL, 1, 'Amit', 'K', 'Karambaikar', 'amitk@72dragons.com', '+919702644880', NULL, NULL, NULL, NULL, NULL, '2020-04-27', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(72, 70, NULL, 1, 'Ding', '', 'Zhanyu', 'ding@72dragons.com', '', NULL, NULL, NULL, NULL, NULL, '2019-05-01', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(73, 71, NULL, 1, 'Gail', '', 'Lin', 'gail@thedragonyeargallery.com', '+861581468608', NULL, NULL, NULL, NULL, NULL, '2022-07-23', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(74, 72, NULL, 1, 'Gina', '', 'Guan', 'gina@72dragons.com', '+85251303467', NULL, NULL, NULL, NULL, NULL, '2020-12-21', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(75, 73, NULL, 1, 'Guyu', '', 'Zhang', 'guyu@72dragons.com', '+8616710115296', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(76, 74, NULL, 1, 'Ifa', '', 'zamzami', 'ifa@72dragons.com', '+919841223781', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(77, 75, NULL, 1, 'Jazeela', '', 'Basheer', 'jazeela@72dragons.com', '', NULL, NULL, NULL, NULL, NULL, '2019-04-01', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(78, 76, NULL, 1, 'Jenny', 'Jingyu', 'Wang', 'jenny@thedragonyeargallery.com', '+8614715024651', NULL, NULL, NULL, NULL, NULL, '2020-04-23', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(79, 77, NULL, 1, 'Jimmy', '', 'Zhong', 'jimmyzhong@72dragons.com', '', NULL, NULL, NULL, NULL, NULL, '2017-09-09', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(80, 78, NULL, 1, 'Jinyang', '', 'Li', 'jinyang@72dragons.com', '', NULL, NULL, NULL, NULL, NULL, '2020-03-25', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(81, 79, NULL, 1, 'Leo', '', 'Zhu', 'leo@72dragons.com', '+9613672246970', NULL, NULL, NULL, NULL, NULL, '2020-12-04', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(82, 80, NULL, 1, 'Mritunjoy', '', 'Mushahary', 'mritunjoy@72dragons.com', '+918011501382', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(83, 81, NULL, 1, 'Nicole', '', 'Varghese', 'nicole@72dragons.com', '+919930341071', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(84, 82, NULL, 1, 'Nikhil', '', 'Jadhav', 'nikhil@72dragons.com', '+919867924910', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(85, 83, NULL, 1, 'Pei', '', 'Xu', 'xu@72dragons.com', '', NULL, NULL, NULL, NULL, NULL, '2019-08-01', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(86, 84, NULL, 1, 'Pietro', '', 'Aparicio', 'drpietroaparicio@72dragons.com', '', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'USA', NULL, NULL, NULL, NULL, NULL, NULL),
(87, 85, NULL, 1, 'Righya', '', 'Madan', 'righya@72dragons.com', '+919004160572', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(88, 86, NULL, 1, 'Roxy', '', 'Chen', 'roxy@72dragons.com', '+8615919282526', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(89, 87, NULL, 1, 'Sai', '', 'Shinde', 'sai@72dragons.com', '+919967974557', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(90, 88, NULL, 1, 'Seven', '', 'Xie', 'sevenxie@72dragons.com', '', NULL, NULL, NULL, NULL, NULL, '2019-01-02', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(91, 89, NULL, 1, 'Shang', '', 'Pakey', 'shang@thedragonyeargallery.com', '+8613235043008', NULL, NULL, NULL, NULL, NULL, '2022-09-13', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(92, 90, NULL, 1, 'Shashi', '', 'Shewalkar', 'shashi@72dragons.com', '+919284365984', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(93, 91, NULL, 1, 'shubhangi', '', 'Kaushik', 'shubhangi@72dragons.com', '+916388431410', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(94, 92, NULL, 1, 'Theresa', '', 'Hu', 'theresa@72dragons.com', '+8617623570381', NULL, NULL, NULL, NULL, NULL, '2022-07-18', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(95, 93, NULL, 1, 'Umang', '', 'Acharya', 'umang@72dragons.com', '+919167258603', NULL, NULL, NULL, NULL, NULL, '2020-09-21', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(96, 95, NULL, 5, 'Will', 'Cai', 'Jiawei', 'will@72dragons.com', '', NULL, NULL, NULL, NULL, NULL, '2017-05-01', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(97, 96, NULL, 1, 'Xinyu', '', 'Wu', 'xinyu@thedragonyeargallery.com', '+8615205518153', NULL, NULL, NULL, NULL, NULL, '2022-09-16', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(98, 97, NULL, 1, 'Yash', '', 'Arote', 'yash@72dragons.com', '+918007238994', NULL, NULL, NULL, NULL, NULL, '2019-07-08', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(99, 98, NULL, 1, 'Zepeng', '', 'Ma', 'ma@72dragons.com', '', NULL, NULL, NULL, NULL, NULL, '2019-10-30', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(100, 2, NULL, 1, 'Sameer', '', 'Sameer  Jadhav', 'sameer@72dragons.com', '+919321847722', NULL, NULL, NULL, NULL, NULL, '2021-06-07', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(101, 3, NULL, 1, 'Siddhant', '', 'sawant', 'siddhant@72dragons.com', '+918097129791', NULL, NULL, NULL, NULL, NULL, '2020-01-28', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(102, 4, NULL, 1, 'Shweta', '', 'Gupta', 'shweta@72dragons.com', '+919689376054', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(103, 6, NULL, 1, 'Rahul', '', 'Mishra', 'rahulmishra@72dragons.com', '+919920486522', NULL, NULL, NULL, NULL, NULL, '2021-04-26', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(104, 7, NULL, 1, 'Namrata', '', 'Sharma', 'namrata@72dragons.com', '+919221848064', NULL, NULL, NULL, NULL, NULL, '0021-04-26', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(105, 8, NULL, 1, 'Divya', '', 'Venkatesh', 'divya@72dragons.com', '+918861300907', NULL, NULL, NULL, NULL, NULL, '2021-06-07', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(106, 9, NULL, 1, 'Shabnam', '', 'Shaikh', 'shabnam@72dragons.com', '+917678062318', NULL, NULL, NULL, NULL, NULL, '2021-07-12', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(107, 10, NULL, 1, 'Nalin', '', 'Bera', 'nalin@72dragons.com', '+917045309659', NULL, NULL, NULL, NULL, NULL, '2021-03-01', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(108, 11, NULL, 1, 'Rahul', '', 'Dhakan', 'rahul@72dragons.com', '+919930596001', NULL, NULL, NULL, NULL, NULL, '2021-04-01', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(109, 12, NULL, 1, 'Ashish', '', 'Kumar', 'ashish@72dragons.com', '+918953704470', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(110, 13, NULL, 4, 'Space', '', 'Wu', 'Spacewu@thedragonyeargallery.com', '', NULL, NULL, NULL, NULL, NULL, '2022-06-09', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(111, 14, NULL, 1, 'Ria', '', 'Arora', 'ria@72dragons.com', '+919971294674', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(112, 15, NULL, 1, 'Zeno', '', 'Pereria', 'zeno@72dragons.com', '+917875287069', NULL, NULL, NULL, NULL, NULL, '2021-04-01', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(113, 16, NULL, 1, 'Kirti', '', 'Maurya', 'kirti@72dragons.com', '+917045225236', NULL, NULL, NULL, NULL, NULL, '2021-05-03', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(114, 17, NULL, 1, 'Asawari', '', 'Parsekar', 'asawari@72dragons.com', '+918879538817', NULL, NULL, NULL, NULL, NULL, '2021-07-01', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(115, 18, NULL, 1, 'Ratan', '', 'Paul', 'ratan@72dragons.com', '+968179654089', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(116, 19, NULL, 1, 'Rohit', '', 'Sharma', 'rohit@72dragons.com', '+917977084935', NULL, NULL, NULL, NULL, NULL, '2021-07-01', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(117, 20, NULL, 1, 'Amol', '', 'Sureshe', 'amol@72dragons.com', '+919404469950', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(118, 21, NULL, 1, 'Priyanshu', '', 'Tripathi', 'priyanshu@72dragons.com', '+917898447274', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(119, 23, NULL, 1, 'Ayushya', '', 'Sidhnath', 'ayushya@72dragons.com', '+917903027971', NULL, NULL, NULL, NULL, NULL, '2021-04-19', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(120, 24, NULL, 1, 'Altamash', '', 'Shaikh', 'Altamash@gmail.com', '+919833024119', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(121, 25, NULL, 1, 'Devidutta', '', 'Moharana', 'Devidutta@gmail.com', '+8658316983', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(122, 26, NULL, 1, 'Raviraj', '', 'Patil', 'raviraj@72dragons.com', '+918446543997', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(123, 27, NULL, 1, 'Neha', '', 'Singh', 'neha@72dragons.com', '+9619144356', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(124, 28, NULL, 1, 'Manjusha', '', 'Malla', 'manjusha@72dragons.com', '+919985093498', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(125, 29, NULL, 1, 'Sudipta', '', 'Chakraborty', 'Sudipta@gmail.com', '', NULL, NULL, NULL, NULL, NULL, '2021-07-01', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(126, 30, NULL, 1, 'Aparna', '', 'Gharlute', 'aparna@72dragons.com', '981900160', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(127, 31, NULL, 1, 'Dhwanika', '', 'Bhansali', 'dhwanika@72dragons.com', '+96989217657', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(128, 33, NULL, 1, 'Xixie', '', 'Zhou', 'xixie@72dragons.com', '+16508046069', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(129, 34, NULL, 1, 'Yao', '', 'Ching', 'yao@72dragons.com', '+15307609938', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'China', NULL, NULL, NULL, NULL, NULL, NULL),
(130, 37, NULL, 1, 'Fatima', '', 'Hawit', 'fatima@72dragons.com', '+50433775816', NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL, 'USA', NULL, NULL, NULL, NULL, NULL, NULL),
(131, 39, NULL, 1, 'Karthikeyan', '', 'C', 'karthikeyan@72dragons.com', '+919003101433', NULL, NULL, NULL, NULL, NULL, '2020-04-14', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(132, 40, NULL, 1, 'Girisuta', '', 'Nag', 'girisuta@72dragons.com', '+918910418730', NULL, NULL, NULL, NULL, NULL, '2020-08-10', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL),
(133, 42, NULL, 4, 'Harshitha', '', 'Polamarasetti', 'harshitha@72dragons.com', '+918501814945', NULL, NULL, NULL, NULL, NULL, '2020-04-20', NULL, 'India', NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
