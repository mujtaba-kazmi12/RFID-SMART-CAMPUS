-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2023 at 02:06 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_fyp`
--
CREATE DATABASE IF NOT EXISTS `db_fyp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_fyp`;

-- --------------------------------------------------------

--
-- Table structure for table `account_table`
--

CREATE TABLE `account_table` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `card_amount` varchar(20) NOT NULL DEFAULT '0',
  `status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_table`
--

INSERT INTO `account_table` (`id`, `student_id`, `account_no`, `card_amount`, `status`) VALUES
(1, 1, 'BSCS-FA19-033', '400', 'Active'),
(2, 2, 'BSCS-FA19-046', '500', 'Active'),
(3, 3, 'BSCS-FA19-066', '700', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule`
--

CREATE TABLE `class_schedule` (
  `id` int(11) NOT NULL,
  `class_ID` int(11) NOT NULL,
  `day_ID` int(11) NOT NULL,
  `lec_ID` int(11) NOT NULL,
  `slot` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_table`
--

CREATE TABLE `class_table` (
  `id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `dep_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_table`
--

INSERT INTO `class_table` (`id`, `class_name`, `dep_id`) VALUES
(1, 'BSCS-1', 1),
(2, 'BSCS-2', 1),
(3, 'BSCS-3', 1),
(4, 'BSCS-4', 1),
(5, 'BSCS-5', 1),
(6, 'BSCS-6', 1),
(7, 'BSCS-7', 1),
(8, 'BSCS-8', 1);

-- --------------------------------------------------------

--
-- Table structure for table `days-lec_table`
--

CREATE TABLE `days-lec_table` (
  `id` int(11) NOT NULL,
  `days` int(11) NOT NULL,
  `lectures` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `days-lec_table`
--

INSERT INTO `days-lec_table` (`id`, `days`, `lectures`) VALUES
(1, 5, 8);

-- --------------------------------------------------------

--
-- Table structure for table `degree_table`
--

CREATE TABLE `degree_table` (
  `id` int(11) NOT NULL,
  `degree` varchar(50) NOT NULL,
  `dept_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `degree_table`
--

INSERT INTO `degree_table` (`id`, `degree`, `dept_id`) VALUES
(1, 'BSCS', 1),
(2, 'BSSE', 1),
(3, 'BBA', 2),
(4, 'BS Account & Finance', 2);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `dept_name`) VALUES
(1, 'Department of Computer Science'),
(2, 'Department of Managment');

-- --------------------------------------------------------

--
-- Table structure for table `detail_table`
--

CREATE TABLE `detail_table` (
  `id` int(11) NOT NULL,
  `department_ID` int(11) NOT NULL,
  `class_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_table`
--

INSERT INTO `detail_table` (`id`, `department_ID`, `class_ID`) VALUES
(29, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `dt_class`
--

CREATE TABLE `dt_class` (
  `id` int(11) NOT NULL,
  `dept_ID` int(11) NOT NULL,
  `class_ID` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dt_class`
--

INSERT INTO `dt_class` (`id`, `dept_ID`, `class_ID`, `subject`) VALUES
(13, 1, 6, 'Distributed Database'),
(14, 1, 8, 'Wireless Network');

-- --------------------------------------------------------

--
-- Table structure for table `dt_room`
--

CREATE TABLE `dt_room` (
  `id` int(11) NOT NULL,
  `room_no` varchar(50) NOT NULL,
  `n_row` int(11) NOT NULL,
  `columns` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dt_room`
--

INSERT INTO `dt_room` (`id`, `room_no`, `n_row`, `columns`) VALUES
(3, '112', 5, 3),
(4, '113', 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_table`
--

CREATE TABLE `enrollment_table` (
  `id` int(11) NOT NULL,
  `department_ID` int(11) NOT NULL,
  `degree_ID` int(11) NOT NULL,
  `sem_ID` int(11) NOT NULL,
  `subject_ID` int(11) NOT NULL,
  `status` text NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment_table`
--

INSERT INTO `enrollment_table` (`id`, `department_ID`, `degree_ID`, `sem_ID`, `subject_ID`, `status`) VALUES
(1, 1, 1, 1, 1, 'Approved'),
(2, 1, 1, 1, 1, 'pending'),
(3, 1, 1, 1, 1, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_table`
--

CREATE TABLE `invoice_table` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` text NOT NULL,
  `description` text NOT NULL,
  `price` text NOT NULL,
  `quantity` text NOT NULL,
  `total` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_table`
--

INSERT INTO `invoice_table` (`id`, `invoice_id`, `item_id`, `item_name`, `description`, `price`, `quantity`, `total`) VALUES
(2, 1, 1, 'Juice', 'Drinks', '50', '3', '150'),
(3, 1, 2, 'Coke', 'Drinks', '50', '3', '150'),
(4, 2, 1, 'Juice', 'Drinks', '50', '3', '150'),
(5, 3, 1, 'Juice', 'Drinks', '50', '3', '150'),
(6, 4, 1, 'Juice', 'Drinks', '50', '1', '50'),
(7, 5, 1, 'Juice', 'Drinks', '50', '1', '50'),
(8, 6, 1, 'Juice', 'Drinks', '50', '3', '150'),
(9, 6, 2, 'Coke', 'Drinks', '50', '3', '150');

-- --------------------------------------------------------

--
-- Table structure for table `item_table`
--

CREATE TABLE `item_table` (
  `id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_table`
--

INSERT INTO `item_table` (`id`, `item_name`, `description`, `price`) VALUES
(1, 'Juice', 'Drinks', '50'),
(2, 'Coke', 'Drinks', '50'),
(3, 'Lays', 'Eatable', '50'),
(4, 'Sandwich', 'Eatable', '100');

-- --------------------------------------------------------

--
-- Table structure for table `room_table`
--

CREATE TABLE `room_table` (
  `id` int(11) NOT NULL,
  `room_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_table`
--

INSERT INTO `room_table` (`id`, `room_no`) VALUES
(6, '111'),
(7, '112'),
(8, '113'),
(9, '123');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_table`
--

CREATE TABLE `schedule_table` (
  `id` int(11) NOT NULL,
  `lectures_time` varchar(50) NOT NULL,
  `days` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_table`
--

INSERT INTO `schedule_table` (`id`, `lectures_time`, `days`) VALUES
(1, '8:00 AM - 9:00 AM', 'Monday'),
(2, '9:00 AM - 10:00 AM', 'Tuesday'),
(3, '10:00 AM - 11:00 AM', 'Wednesday'),
(4, '11:00 AM - 12:00 PM', 'Thursday'),
(5, '12:00 PM - 1:00 PM', 'Friday'),
(6, '1:00 PM - 2:00 PM', 'Saturday'),
(7, '2:00 PM - 3:00 PM', 'Sunday'),
(8, '3:00 PM - 4:00 PM', NULL),
(9, '4:00 PM - 5:00 PM', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seating_plan`
--

CREATE TABLE `seating_plan` (
  `id` int(11) NOT NULL,
  `room_no` text NOT NULL,
  `seating_plan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semester_table`
--

CREATE TABLE `semester_table` (
  `id` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `deg_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester_table`
--

INSERT INTO `semester_table` (`id`, `semester`, `deg_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 1, 2),
(10, 2, 2),
(11, 3, 2),
(12, 4, 2),
(13, 5, 2),
(14, 6, 2),
(15, 7, 2),
(16, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `class_ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `rollno` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `class_ID`, `name`, `rollno`) VALUES
(1, 8, 'Jahanzaib Alam', 'BSCS-FA19-003'),
(2, 8, 'Muhammed Faizan', 'BSCS-FA19-004'),
(3, 8, 'Talha Osama', 'BSCS-FA19-005'),
(4, 8, 'Murad Zahid', 'BSCS-FA19-006'),
(5, 8, 'Shahid Nabeel', 'BSCS-FA19-007'),
(6, 8, 'Sikandar Zia', 'BSCS-FA19-008'),
(7, 8, 'Mohsin Afzal', 'BSCS-FA19-009'),
(8, 8, 'Muhammed Rehan', 'BSCS-FA19-010'),
(9, 8, 'Muhammed Ahmad', 'BSCS-FA19-011'),
(10, 8, 'Muhammed Ali', 'BSCS-FA19-012'),
(11, 8, 'Hashir Waseem', 'BSCS-FA19-013'),
(12, 8, 'Dilawaiz Waseem', 'BSCS-FA19-014'),
(13, 8, 'Abdul Hanan', 'BSCS-FA19-015'),
(14, 8, 'Hamza Abbas', 'BSCS-FA19-016'),
(15, 8, 'Muhammed Nouman', 'BSCS-FA19-017'),
(16, 8, 'Adnan Sharif', 'BSCS-FA19-018'),
(17, 8, 'Shahzaib Ali', 'BSCS-FA19-020'),
(18, 8, 'Muhammed Naeem', 'BSCS-FA19-023'),
(19, 8, 'Zuhair Habib', 'BSCS-FA19-027'),
(20, 8, 'Bilal Ahmad', 'BSCS-FA19-033'),
(21, 8, 'Muhammed Hassan', 'BSCS-FA19-034'),
(22, 8, 'Ahmad Jillani', 'BSCS-FA19-035'),
(23, 8, 'Naeem Waseem', 'BSCS-FA19-040'),
(24, 6, 'Ali Ahsan', 'BSCS-FA20-001'),
(25, 6, 'Ahsan Ali', 'BSCS-FA20-002'),
(26, 6, 'Ali Ahmad', 'BSCS-FA20-004'),
(27, 6, 'Bilal Hafeez', 'BSCS-FA20-005'),
(28, 6, 'Hafeez Bilal', 'BSCS-FA20-006'),
(29, 6, 'Ahmad Sajjad', 'BSCS-FA20-008'),
(30, 6, 'Ahsan Bilal', 'BSCS-FA20-009'),
(31, 6, 'Bilal Ahsan', 'BSCS-FA20-012'),
(32, 6, 'Abdur Rehman', 'BSCS-FA20-014'),
(33, 6, 'Afnan Saeed', 'BSCS-FA20-015'),
(34, 6, 'Kabeer Khan', 'BSCS-FA20-017'),
(35, 6, 'Saad Ali', 'BSCS-FA20-019'),
(36, 6, 'Shoaib Tahir', 'BSCS-FA20-022'),
(37, 6, 'Muhammed Usman', 'BSCS-FA20-024'),
(38, 6, 'Taufiq Hamza', 'BSCS-FA20-025'),
(39, 6, 'Hammad Ali', 'BSCS-FA20-028'),
(40, 6, 'Moiaz Masud', 'BSCS-FA20-030'),
(41, 6, 'Mohsin Ali', 'BSCS-FA20-031'),
(42, 6, 'Asim Shehzad', 'BSCS-FA20-032');

-- --------------------------------------------------------

--
-- Table structure for table `student_table`
--

CREATE TABLE `student_table` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rollno` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pno` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_table`
--

INSERT INTO `student_table` (`id`, `name`, `rollno`, `email`, `pno`) VALUES
(1, 'Bilal Ahmad', 'BSCS-FA19-033', 'bscs-fa19-033@tuf.edu.pk', '0323-9636097'),
(2, 'Bilal Hafeez', 'BSCS-FA19-046', 'bscs-fa19-046@tuf.edu.pk', '0323-1234567'),
(3, 'Saad Ali Sajid', 'BSCS-FA19-066', 'bscs-fa19-066@tuf.edu.pk', '0323-1234567');

-- --------------------------------------------------------

--
-- Table structure for table `subject_table`
--

CREATE TABLE `subject_table` (
  `id` int(11) NOT NULL,
  `class_ID` int(11) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_type` varchar(50) NOT NULL,
  `no_of_lec` int(11) NOT NULL,
  `teacher_ID` varchar(50) NOT NULL,
  `room_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_table`
--

INSERT INTO `subject_table` (`id`, `class_ID`, `course_code`, `course_name`, `course_type`, `no_of_lec`, `teacher_ID`, `room_ID`) VALUES
(10, 1, 'CS-123', 'Programming', 'Theory', 3, '3', 3),
(12, 2, 'ENG-121', 'English', 'Theory', 3, '4', 3),
(18, 5, 'ENG-121', 'Functional English', 'Theory', 3, '4', 4),
(19, 1, 'ENG-121', 'Functional English', 'Theory', 3, '6', 6),
(20, 1, 'CS-123', 'Programming', 'Theory', 2, '7', 7),
(21, 2, 'ICT-111', 'Introduction to communication and technology', 'Theory', 3, '9', 8),
(22, 1, 'ISL-145', 'Islamiyat', 'Theory', 2, '7', 8),
(23, 2, 'CS-111', 'Object Oriented Programming', 'Theory', 3, '6', 8),
(24, 2, 'Math-121', 'Numerical Computing', 'Theory', 3, '10', 9);

-- --------------------------------------------------------

--
-- Table structure for table `table_subject`
--

CREATE TABLE `table_subject` (
  `id` int(11) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `credit_hours` varchar(50) NOT NULL,
  `sem_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_subject`
--

INSERT INTO `table_subject` (`id`, `course_code`, `course_name`, `credit_hours`, `sem_id`) VALUES
(1, 'CS-123', 'Programming Fundamentals', '3(3-0)', 1),
(2, 'ENG-121', 'Functional English-I', '2(2-0)', 1),
(3, 'CS-124', 'OOP', '4(3-1)', 2),
(4, 'ENG-122', 'Functional English-II', '3(3-0)', 2),
(5, 'ICT-123', 'ICT', '3(2-1)', 9),
(6, 'IS-111', 'Islamic Studies', '2(2-0)', 9);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_schedule`
--

CREATE TABLE `teacher_schedule` (
  `id` int(11) NOT NULL,
  `teacher_ID` varchar(100) NOT NULL,
  `day_ID` int(11) NOT NULL,
  `lec_ID` int(11) NOT NULL,
  `slot` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_schedule`
--

INSERT INTO `teacher_schedule` (`id`, `teacher_ID`, `day_ID`, `lec_ID`, `slot`) VALUES
(21, 'ABC-123', 1, 1, 'available'),
(22, 'ABC-123', 1, 2, 'available'),
(23, 'ABC-123', 3, 2, 'available'),
(24, 'ABC-123', 2, 3, 'available'),
(25, 'ABC-123', 5, 3, 'available'),
(26, 'ABC-123', 4, 4, 'available'),
(27, 'ABC-123', 4, 6, 'available'),
(28, 'ABC-123', 5, 7, 'available'),
(29, '123abc', 1, 1, 'available'),
(30, '123abc', 2, 3, 'available'),
(31, '123abc', 4, 3, 'available'),
(32, '123abc', 5, 3, 'available'),
(33, '123abc', 2, 4, 'available'),
(34, '123abc', 3, 6, 'available'),
(35, '123abc', 5, 6, 'available'),
(36, '123abc', 1, 7, 'available'),
(37, '123abc', 2, 7, 'available'),
(38, '123abc', 4, 7, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_table`
--

CREATE TABLE `teacher_table` (
  `id` int(11) NOT NULL,
  `department_ID` int(11) NOT NULL,
  `teacher_name` varchar(50) NOT NULL,
  `teacher_ID` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_table`
--

INSERT INTO `teacher_table` (`id`, `department_ID`, `teacher_name`, `teacher_ID`) VALUES
(6, 1, 'Bilal Ahmad', 'ABC-123'),
(7, 1, 'Ahmad', '123abc'),
(8, 1, 'Murad', 'Murad-111'),
(9, 1, 'Nabeel', 'Nabeel-123'),
(10, 1, 'Mobeen ', 'Mobeen-178');

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `class_ID` int(11) NOT NULL,
  `day` text NOT NULL,
  `time_slot` text NOT NULL,
  `subject` varchar(50) NOT NULL,
  `lecture` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`id`, `class_ID`, `day`, `time_slot`, `subject`, `lecture`) VALUES
(215, 1, 'Monday', '8:00 AM - 9:00 AM', '', 'ENG-121<br>Bilal Ahmad<br>Room-111'),
(216, 1, 'Tuesday', '8:00 AM - 9:00 AM', '', ''),
(217, 1, 'Wednesday', '8:00 AM - 9:00 AM', '', ''),
(218, 1, 'Thursday', '8:00 AM - 9:00 AM', '', ''),
(219, 1, 'Friday', '8:00 AM - 9:00 AM', '', ''),
(220, 1, 'Monday', '9:00 AM - 10:00 AM', '', ''),
(221, 1, 'Tuesday', '9:00 AM - 10:00 AM', '', 'ENG-121<br>Bilal Ahmad<br>Room-111'),
(222, 1, 'Wednesday', '9:00 AM - 10:00 AM', '', 'ENG-121<br>Bilal Ahmad<br>Room-111'),
(223, 1, 'Thursday', '9:00 AM - 10:00 AM', '', ''),
(224, 1, 'Friday', '9:00 AM - 10:00 AM', '', ''),
(225, 1, 'Monday', '10:00 AM - 11:00 AM', '', ''),
(226, 1, 'Tuesday', '10:00 AM - 11:00 AM', '', 'CS-123<br>Ahmad<br>Room-112'),
(227, 1, 'Wednesday', '10:00 AM - 11:00 AM', '', ''),
(228, 1, 'Thursday', '10:00 AM - 11:00 AM', '', ''),
(229, 1, 'Friday', '10:00 AM - 11:00 AM', '', 'ISL-145<br>Ahmad<br>Room-113'),
(230, 1, 'Monday', '11:00 AM - 12:00 PM', '', ''),
(231, 1, 'Tuesday', '11:00 AM - 12:00 PM', '', ''),
(232, 1, 'Wednesday', '11:00 AM - 12:00 PM', '', 'CS-123<br>Ahmad<br>Room-112'),
(233, 1, 'Thursday', '11:00 AM - 12:00 PM', '', ''),
(234, 1, 'Friday', '11:00 AM - 12:00 PM', '', ''),
(235, 1, 'Monday', '12:00 PM - 1:00 PM', '', ''),
(236, 1, 'Tuesday', '12:00 PM - 1:00 PM', '', ''),
(237, 1, 'Wednesday', '12:00 PM - 1:00 PM', '', ''),
(238, 1, 'Thursday', '12:00 PM - 1:00 PM', '', ''),
(239, 1, 'Friday', '12:00 PM - 1:00 PM', '', ''),
(240, 1, 'Monday', '1:00 PM - 2:00 PM', '', ''),
(241, 1, 'Tuesday', '1:00 PM - 2:00 PM', '', ''),
(242, 1, 'Wednesday', '1:00 PM - 2:00 PM', '', ''),
(243, 1, 'Thursday', '1:00 PM - 2:00 PM', '', ''),
(244, 1, 'Friday', '1:00 PM - 2:00 PM', '', ''),
(245, 1, 'Monday', '2:00 PM - 3:00 PM', '', ''),
(246, 1, 'Tuesday', '2:00 PM - 3:00 PM', '', ''),
(247, 1, 'Wednesday', '2:00 PM - 3:00 PM', '', ''),
(248, 1, 'Thursday', '2:00 PM - 3:00 PM', '', ''),
(249, 1, 'Friday', '2:00 PM - 3:00 PM', '', 'ISL-145<br>Ahmad<br>Room-113'),
(250, 1, 'Monday', '3:00 PM - 4:00 PM', '', ''),
(251, 1, 'Tuesday', '3:00 PM - 4:00 PM', '', ''),
(252, 1, 'Wednesday', '3:00 PM - 4:00 PM', '', ''),
(253, 1, 'Thursday', '3:00 PM - 4:00 PM', '', ''),
(254, 1, 'Friday', '3:00 PM - 4:00 PM', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `total_invoices`
--

CREATE TABLE `total_invoices` (
  `invoice_id` int(11) NOT NULL,
  `customer_account` text NOT NULL,
  `total_amount` text NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `total_invoices`
--

INSERT INTO `total_invoices` (`invoice_id`, `customer_account`, `total_amount`, `time`) VALUES
(1, '12345', '300', '2023-05-23 16:46:16'),
(2, '12345', '150', '2023-05-23 16:56:27'),
(3, '12345', '150', '2023-05-25 18:02:18'),
(4, 'BSCS-FA19-033', '50', '2023-06-12 08:46:08'),
(5, 'BSCS-FA19-033', '50', '2023-06-12 08:50:25'),
(6, 'BSCS-FA19-066', '300', '2023-06-12 10:13:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`id`, `name`, `email`, `reg_no`, `role`, `password`) VALUES
(1, 'Bilal Ahmad', 'bscs-fa19-033@tuf.edu.pk', 'BSCS-FA19-033', 'student', 'bilal123'),
(3, 'Bilal Hafeez', 'bscs-fa19-046@tuf.edu.pk', 'BSCS-FA19-046', 'student', 'hafeez123'),
(4, 'Uzair Saeed', 'uzair.saeed@tuf.edu.pk', 'UZAIR123', 'teacher', 'uzair123'),
(7, 'Cafe', 'cafe@tuf.edu.pk', 'CAFE-123', 'cafe', 'cafe1234'),
(8, 'accounts', 'account@tuf.edu.pk', 'ACCOUNTS-123', 'account', 'account123'),
(16, 'Manage', 'manage@tuf.edu.pk', 'MANAGE-123', 'management', 'manage123'),
(17, 'Saad Ali Sajid', 'bscs-fa19-066@tuf.edu.pk', 'BSCS-FA19-066', 'student', 'saad1234'),
(18, 'Ahmad', 'ahmad@tuf.edu.pk', 'KLLL', 'student', 'bilal123'),
(19, 'admin', 'admin', 'admin', 'admin', 'pass123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_table`
--
ALTER TABLE `account_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_no` (`account_no`),
  ADD KEY `acc_stu` (`student_id`);

--
-- Indexes for table `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_table`
--
ALTER TABLE `class_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cs_class` (`dep_id`);

--
-- Indexes for table `days-lec_table`
--
ALTER TABLE `days-lec_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `days_con` (`days`),
  ADD KEY `lec_con` (`lectures`);

--
-- Indexes for table `degree_table`
--
ALTER TABLE `degree_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dept_deg` (`dept_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `detail_table`
--
ALTER TABLE `detail_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_ID` (`class_ID`);

--
-- Indexes for table `dt_class`
--
ALTER TABLE `dt_class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dept` (`dept_ID`),
  ADD KEY `deg` (`class_ID`);

--
-- Indexes for table `dt_room`
--
ALTER TABLE `dt_room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollment_table`
--
ALTER TABLE `enrollment_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_enroll` (`department_ID`),
  ADD KEY `deg_enroll` (`degree_ID`),
  ADD KEY `sem_enroll` (`sem_ID`),
  ADD KEY `subject_id` (`subject_ID`);

--
-- Indexes for table `invoice_table`
--
ALTER TABLE `invoice_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_table`
--
ALTER TABLE `item_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_table`
--
ALTER TABLE `room_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_table`
--
ALTER TABLE `schedule_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seating_plan`
--
ALTER TABLE `seating_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester_table`
--
ALTER TABLE `semester_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sem_deg` (`deg_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_class` (`class_ID`);

--
-- Indexes for table `student_table`
--
ALTER TABLE `student_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_table`
--
ALTER TABLE `subject_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_subject`
--
ALTER TABLE `table_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_schedule`
--
ALTER TABLE `teacher_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_table`
--
ALTER TABLE `teacher_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_ID` (`teacher_ID`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `total_invoices`
--
ALTER TABLE `total_invoices`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `reg_no` (`reg_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_table`
--
ALTER TABLE `account_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `class_schedule`
--
ALTER TABLE `class_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `class_table`
--
ALTER TABLE `class_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `days-lec_table`
--
ALTER TABLE `days-lec_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `degree_table`
--
ALTER TABLE `degree_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_table`
--
ALTER TABLE `detail_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `dt_class`
--
ALTER TABLE `dt_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `dt_room`
--
ALTER TABLE `dt_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `enrollment_table`
--
ALTER TABLE `enrollment_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_table`
--
ALTER TABLE `invoice_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `item_table`
--
ALTER TABLE `item_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room_table`
--
ALTER TABLE `room_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `schedule_table`
--
ALTER TABLE `schedule_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `seating_plan`
--
ALTER TABLE `seating_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `semester_table`
--
ALTER TABLE `semester_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `student_table`
--
ALTER TABLE `student_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subject_table`
--
ALTER TABLE `subject_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `table_subject`
--
ALTER TABLE `table_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teacher_schedule`
--
ALTER TABLE `teacher_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `teacher_table`
--
ALTER TABLE `teacher_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_table`
--
ALTER TABLE `account_table`
  ADD CONSTRAINT `acc_stu` FOREIGN KEY (`student_id`) REFERENCES `student_table` (`id`);

--
-- Constraints for table `class_table`
--
ALTER TABLE `class_table`
  ADD CONSTRAINT `cs_class` FOREIGN KEY (`dep_id`) REFERENCES `department` (`dept_id`);

--
-- Constraints for table `days-lec_table`
--
ALTER TABLE `days-lec_table`
  ADD CONSTRAINT `days_con` FOREIGN KEY (`days`) REFERENCES `schedule_table` (`id`),
  ADD CONSTRAINT `lec_con` FOREIGN KEY (`lectures`) REFERENCES `schedule_table` (`id`);

--
-- Constraints for table `degree_table`
--
ALTER TABLE `degree_table`
  ADD CONSTRAINT `dept_deg` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`);

--
-- Constraints for table `dt_class`
--
ALTER TABLE `dt_class`
  ADD CONSTRAINT `deg` FOREIGN KEY (`class_ID`) REFERENCES `class_table` (`id`),
  ADD CONSTRAINT `dept` FOREIGN KEY (`dept_ID`) REFERENCES `department` (`dept_id`);

--
-- Constraints for table `enrollment_table`
--
ALTER TABLE `enrollment_table`
  ADD CONSTRAINT `deg_enroll` FOREIGN KEY (`degree_ID`) REFERENCES `degree_table` (`id`),
  ADD CONSTRAINT `department_enroll` FOREIGN KEY (`department_ID`) REFERENCES `department` (`dept_id`),
  ADD CONSTRAINT `sem_enroll` FOREIGN KEY (`sem_ID`) REFERENCES `semester_table` (`id`),
  ADD CONSTRAINT `stu_enroll` FOREIGN KEY (`id`) REFERENCES `student_table` (`id`),
  ADD CONSTRAINT `subject_id` FOREIGN KEY (`subject_ID`) REFERENCES `table_subject` (`id`);

--
-- Constraints for table `semester_table`
--
ALTER TABLE `semester_table`
  ADD CONSTRAINT `sem_deg` FOREIGN KEY (`deg_id`) REFERENCES `degree_table` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `student_class` FOREIGN KEY (`class_ID`) REFERENCES `class_table` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
