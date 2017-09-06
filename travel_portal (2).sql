-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2017 at 09:23 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `financial_year` varchar(30) NOT NULL,
  `cost_center_id` int(11) NOT NULL,
  `budget` int(11) NOT NULL,
  `remain_budget` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`id`, `department_id`, `financial_year`, `cost_center_id`, `budget`, `remain_budget`, `status`) VALUES
(6, 4, '2017', 1, 100000, 84000, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `budget_history`
--

CREATE TABLE `budget_history` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `credit` int(11) DEFAULT NULL,
  `debit` int(11) DEFAULT NULL,
  `current_budget` int(11) NOT NULL,
  `remain_budget` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `budget_history`
--

INSERT INTO `budget_history` (`id`, `budget_id`, `request_id`, `credit`, `debit`, `current_budget`, `remain_budget`) VALUES
(5, 6, 0, NULL, 7000, 100000, 93000);

-- --------------------------------------------------------

--
-- Table structure for table `bus_category`
--

CREATE TABLE `bus_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bus_category`
--

INSERT INTO `bus_category` (`id`, `name`, `status`) VALUES
(1, 'AC Bus', 'active'),
(2, 'Non AC', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `bus_ticket_booking`
--

CREATE TABLE `bus_ticket_booking` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `bus_provider_id` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `comment` text NOT NULL,
  `bus_attachment` varchar(50) NOT NULL,
  `arrange_by` enum('Pending','Company','Own') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `car_booking`
--

CREATE TABLE `car_booking` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `car_category_id` int(11) NOT NULL,
  `pick_up_date` datetime NOT NULL,
  `drop_off_date` datetime NOT NULL,
  `pick_up_location` varchar(50) NOT NULL,
  `drop_off_location` varchar(50) NOT NULL,
  `cost` int(11) NOT NULL,
  `car_attchment` varchar(50) NOT NULL,
  `arrange_by` enum('Pending','Company','Own') NOT NULL,
  `cancel_status` enum('0','1','2','') NOT NULL,
  `refund_amount` int(11) NOT NULL,
  `cancellation_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `car_category`
--

CREATE TABLE `car_category` (
  `id` int(11) NOT NULL,
  `car_type` varchar(100) NOT NULL,
  `rate_km` varchar(30) NOT NULL,
  `city_id` int(11) NOT NULL,
  `car_owner` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car_category`
--

INSERT INTO `car_category` (`id`, `car_type`, `rate_km`, `city_id`, `car_owner`, `status`) VALUES
(1, 'Swift Desire', '6', 18, 0, 'active'),
(2, 'Indigo', '6', 18, 0, 'active'),
(3, 'Hyundai', '7', 18, 0, 'inactive'),
(4, 'Hyundai Ford Ikon', '6', 18, 0, 'active'),
(5, 'Auto', '4', 18, 0, 'active'),
(6, 'Public Transport', '3', 18, 0, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `car_ticket_booking`
--

CREATE TABLE `car_ticket_booking` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `car_provider_id` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `comment` text NOT NULL,
  `car_attachment` varchar(50) NOT NULL,
  `arrange_by` enum('Pending','Company','Own') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE `configuration` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `setting` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`id`, `type`, `setting`) VALUES
(1, 'two_wheeler', '3'),
(2, 'four_wheeler', '7'),
(3, 'per_diem', '600');

-- --------------------------------------------------------

--
-- Table structure for table `cost_center`
--

CREATE TABLE `cost_center` (
  `id` int(11) NOT NULL,
  `guest_house` enum('1','2') NOT NULL COMMENT '1 Yes,2 No ',
  `city_id` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cost_center`
--

INSERT INTO `cost_center` (`id`, `guest_house`, `city_id`, `status`) VALUES
(1, '1', 18, 'active'),
(2, '1', 33, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `dept_name` varchar(100) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `dept_name`, `status`) VALUES
(1, 'HR & Admin', 'active'),
(2, 'Editorial', 'active'),
(3, 'Ad Sales', 'active'),
(4, 'Travel', 'active'),
(5, 'F & A', 'active'),
(6, 'Production', 'active'),
(7, 'SMD', 'active'),
(8, 'Finance & Accounts', 'active'),
(9, 'Management', 'active'),
(10, 'Programming', 'active'),
(11, 'Projects', 'active'),
(12, 'Information Technology', 'active'),
(13, 'Corporate', 'active'),
(14, 'Marketing', 'active'),
(15, 'Corporate Contract', 'active'),
(16, 'Brand Marketing', 'active'),
(17, 'Corporate Strategy', 'active'),
(18, 'P&L Head', 'active'),
(19, 'Activation Sales', 'active'),
(20, 'Ad Sales & Marketing', 'active'),
(21, 'Ad Scheduling', 'active'),
(22, 'Administration', 'active'),
(23, 'Brand Communications', 'active'),
(24, 'Chairman\'s Office', 'active'),
(25, 'Corporate Project Team', 'active'),
(26, 'Director\'s Office', 'active'),
(27, 'ED Office', 'active'),
(28, 'GABR', 'active'),
(29, 'GRC', 'active'),
(30, 'Human Resources', 'active'),
(31, 'Marcomm', 'active'),
(32, 'MD\'S Office', 'active'),
(33, 'Mining', 'active'),
(34, 'MIS', 'active'),
(35, 'Marketing & Sales', 'active'),
(36, 'New Product', 'active'),
(37, 'NOC / SYSTEM', 'active'),
(38, 'Production & Information Tech', 'active'),
(39, 'Response', 'active'),
(40, 'Sales', 'active'),
(41, 'Special Project', 'active'),
(42, 'Technology', 'active'),
(43, 'Technical', 'active'),
(44, 'ePAPER', 'active'),
(45, 'Crisis', 'active'),
(46, 'DB City Real Estate Division', 'active'),
(47, 'Board of Directors', 'active'),
(48, 'Private Treaties', 'active'),
(49, 'Response Vertical', 'active'),
(50, 'Commercials', 'active'),
(51, 'Corporate HR', 'active'),
(52, 'Media School', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int(11) NOT NULL,
  `desg_name` varchar(100) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `desg_name`, `status`) VALUES
(3, 'Project Managers', 'active'),
(8, 'Senior Manager', 'active'),
(9, 'Sr. Consultant', 'active'),
(11, 'Solution Architect', 'active'),
(13, 'Team Lead', 'active'),
(15, 'Technical Lead ', 'active'),
(18, 'Trainee', 'active'),
(19, 'IT Head Operations', 'active'),
(20, 'Deputy Manager', 'active'),
(22, 'Assistant Manager', 'active'),
(26, 'Software Developer', 'active'),
(29, 'Cheif Technology Officer', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `empID` varchar(10) NOT NULL,
  `gi_email` varchar(150) NOT NULL,
  `employee_id` varchar(30) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `dept_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `cost_center_id` varchar(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `reporting_manager_id` int(11) DEFAULT NULL,
  `ea_manager_id` int(12) NOT NULL,
  `reporting_person_id` int(11) DEFAULT NULL,
  `location` varchar(30) NOT NULL,
  `father_name` varchar(150) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `blood_group` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `phone` varchar(15) NOT NULL,
  `emergency_phone` varchar(15) NOT NULL,
  `emergency_phone2` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `l_address1` varchar(200) NOT NULL,
  `l_address2` varchar(200) NOT NULL,
  `l_city` varchar(50) NOT NULL,
  `l_state` varchar(50) NOT NULL,
  `l_post_code` varchar(10) NOT NULL,
  `l_country` varchar(50) NOT NULL,
  `p_address1` varchar(200) NOT NULL,
  `p_address2` varchar(200) NOT NULL,
  `p_city` varchar(50) NOT NULL,
  `p_state` varchar(50) NOT NULL,
  `p_post_code` varchar(10) NOT NULL,
  `p_country` varchar(50) NOT NULL,
  `pan` varchar(40) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `bank_account_number` varchar(20) NOT NULL,
  `bank_account_name` varchar(150) NOT NULL,
  `bank_ifsc` varchar(20) NOT NULL,
  `bank_address` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `image` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `empID`, `gi_email`, `employee_id`, `designation_id`, `dept_id`, `grade_id`, `cost_center_id`, `city_id`, `reporting_manager_id`, `ea_manager_id`, `reporting_person_id`, `location`, `father_name`, `gender`, `blood_group`, `dob`, `phone`, `emergency_phone`, `emergency_phone2`, `email`, `l_address1`, `l_address2`, `l_city`, `l_state`, `l_post_code`, `l_country`, `p_address1`, `p_address2`, `p_city`, `p_state`, `p_post_code`, `p_country`, `pan`, `bank_name`, `bank_account_number`, `bank_account_name`, `bank_ifsc`, `bank_address`, `status`, `image`, `created`, `modified`, `status_modified`) VALUES
(4, 'CRG-0001', 'maknojiya440@gmail.com', '101111', 22, 4, 5, '18', 3, 5, 0, NULL, '', '', 'Male', '', '1987-02-13', '9771473855', '', '', '', '', '', 'Bhopal', 'Gujarat', '380015', 'India', '', '', '', '', '', '', '', '', '', '', '', '', 'active', '', '2017-07-08 20:01:35', '2017-07-26 22:02:37', '0000-00-00 00:00:00'),
(5, 'CRG-0002', 'abhishek.kumar@dbcorp.in', '17050', 22, 42, 15, '18', 18, 6, 0, NULL, '', '', 'Male', '', '1987-02-13', '9771473855', '', '', '', '', '', 'Bhopal', 'Madhya-Pradesh', '380015', 'India', '', '', '', '', '', '', '', '', '', '', '', '', 'active', 'assets/emp_photos/-eg7l5X.png', '2017-07-10 20:15:38', '2017-07-27 15:15:26', '0000-00-00 00:00:00'),
(6, 'CRG-0003', 's_shivendra@dbcorp.in', '13308', 19, 42, 10, '18', 18, 7, 0, NULL, '', '', 'Male', '', '1979-08-20', '9993554567', '', '', '', '', '', '', 'Madhya-Pradesh', '380015', 'India', '', '', '', '', '', '', '', '', '', '', '', '', 'active', '', '2017-07-14 21:34:19', '2017-07-27 15:21:30', '0000-00-00 00:00:00'),
(7, 'CRG-0004', 'rd_bhatnagar@dbcorp.in', '13758', 29, 0, 4, '18', 18, 0, 0, NULL, '', '', 'Male', '', '1963-01-05', '9619056789', '', '', '', '', '', '', 'Madhya-Pradesh', '380015', 'India', '', '', '', '', '', '', '', '', '', '', '', '', 'active', '', '2017-07-15 10:30:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'CRG-0005', 'puneetdiwedi19@gmail.com', 'puneetdiwedi19', 18, 0, 4, '18', 18, 5, 0, NULL, '', '', 'Male', '', '1963-01-05', '9658741236', '', '', '', '', '', '', 'Madhya-Pradesh', '380015', 'India', '', '', '', '', '', '', '', '', '', '', '', '', 'active', '', '2017-07-15 10:30:42', '2017-07-20 19:09:16', '0000-00-00 00:00:00'),
(9, 'CRG-0006', 'abhay.singh1@dbcorp.in', '36560', 20, 1, 10, '18', 18, 0, 0, NULL, '', '', 'Male', '', '1999-07-01', '0911100556', '', '', '', '', '', '', 'Madhya-Pradesh', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'active', '', '2017-07-24 12:38:05', '2017-07-27 15:20:27', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `employees_role`
--

CREATE TABLE `employees_role` (
  `id` int(11) NOT NULL,
  `employees_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees_role`
--

INSERT INTO `employees_role` (`id`, `employees_id`, `roles_id`) VALUES
(1, 1, 2),
(2, 2, 5),
(3, 3, 2),
(4, 3, 3),
(5, 3, 4),
(6, 3, 5),
(155, 7, 1),
(156, 7, 5),
(196, 8, 1),
(197, 8, 2),
(198, 8, 3),
(199, 8, 4),
(200, 8, 5),
(201, 8, 7),
(220, 4, 1),
(221, 4, 2),
(222, 4, 3),
(223, 4, 4),
(224, 4, 5),
(225, 4, 7),
(226, 4, 8),
(227, 5, 1),
(228, 9, 1),
(229, 9, 2),
(230, 9, 8),
(231, 6, 1),
(232, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `employment_request_form`
--

CREATE TABLE `employment_request_form` (
  `id` int(11) NOT NULL,
  `ref_code` varchar(15) NOT NULL,
  `reffered_by` varchar(15) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `emergency_phone` varchar(11) NOT NULL,
  `full_data` text NOT NULL,
  `status` enum('Rejected','Selected','Discarded','Pending','Offered') NOT NULL,
  `status_modified` datetime DEFAULT NULL,
  `emp_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `employees_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `credit_card_number` int(11) NOT NULL,
  `bank_name` varchar(30) NOT NULL,
  `reimbursement_arrangment` varchar(30) NOT NULL,
  `total_claim` int(11) NOT NULL,
  `less_advance` int(11) NOT NULL,
  `recevied_amount` int(11) NOT NULL,
  `expense_status` enum('Pending','Approved','Rejected') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `flight_category`
--

CREATE TABLE `flight_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flight_category`
--

INSERT INTO `flight_category` (`id`, `name`, `status`) VALUES
(1, 'Economy Class', 'active'),
(2, 'Premium Economy', 'active'),
(3, 'Business Class', 'active'),
(4, 'First Class', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `flight_ticket_booking`
--

CREATE TABLE `flight_ticket_booking` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `flight_provider_id` int(11) NOT NULL,
  `pnr_number` varchar(30) NOT NULL,
  `cost` int(11) NOT NULL,
  `flight_number` varchar(30) NOT NULL,
  `comment` text NOT NULL,
  `flight_attachment` varchar(50) NOT NULL,
  `arrange_by` enum('Pending','Company','Own') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `grade_name` varchar(100) NOT NULL,
  `travel_mode` varchar(50) NOT NULL,
  `travel_class` varchar(50) NOT NULL,
  `hotel_class` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `grade_name`, `travel_mode`, `travel_class`, `hotel_class`, `car_id`, `status`) VALUES
(4, 'M0', '1', '1', 5, 4, 'active'),
(5, 'M0/1', '1', '1', 5, 4, 'active'),
(6, 'M0/2', '1', '1', 5, 4, 'active'),
(7, 'M1/1', '1', '1', 3, 1, 'active'),
(8, 'M1/2', '1', '1', 3, 1, 'active'),
(9, 'M2/1', '', '', 0, 0, 'inactive'),
(10, 'M2/2', '2', '7', 3, 2, 'active'),
(11, 'M3/1', '2', '8', 3, 2, 'active'),
(12, 'M3/2', '2', '8', 3, 2, 'active'),
(13, 'M4/1', '2', '9', 3, 2, 'active'),
(14, 'M4/2', '2', '9', 3, 2, 'active'),
(15, 'M5', '2', '9', 3, 2, 'active'),
(16, 'M6', '2', '5', 2, 5, 'active'),
(17, 'M7', '2', '5', 2, 5, 'active'),
(18, 'M2/1', '2', '7', 3, 2, 'active'),
(19, 'S', '2', '5', 2, 6, 'active'),
(20, 'O', '2', '5', 2, 6, 'active'),
(22, 'M8', '2', '5', 1, 6, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_booking`
--

CREATE TABLE `hotel_booking` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `hotel_provider_id` int(11) NOT NULL,
  `accommodation_type` int(11) NOT NULL,
  `check_in_date` datetime NOT NULL,
  `check_out_date` datetime NOT NULL,
  `cost` int(11) NOT NULL,
  `bill_no` varchar(30) NOT NULL,
  `comment` text NOT NULL,
  `hotel_attchment` varchar(50) NOT NULL,
  `arrange_by` enum('Pending','Company','Own') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_category`
--

CREATE TABLE `hotel_category` (
  `id` int(11) NOT NULL,
  `hotel_name` varchar(100) NOT NULL,
  `city_id` int(11) NOT NULL,
  `room_amount` varchar(30) NOT NULL,
  `category` varchar(30) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotel_category`
--

INSERT INTO `hotel_category` (`id`, `hotel_name`, `city_id`, `room_amount`, `category`, `status`) VALUES
(1, 'Shubh Inn', 18, '800', '3', 'active'),
(2, 'Sun Place', 18, '1000', '2', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `indian_cities`
--

CREATE TABLE `indian_cities` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `class` varchar(30) NOT NULL,
  `state_id` int(11) NOT NULL,
  `cost_center_id` int(11) NOT NULL,
  `guest_house` enum('1','2') NOT NULL,
  `officenumber` varchar(30) NOT NULL,
  `officeaddress` text NOT NULL,
  `gsaddress` text NOT NULL,
  `caretakername` varchar(100) NOT NULL,
  `mobile_number` varchar(10) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `indian_cities`
--

INSERT INTO `indian_cities` (`id`, `name`, `class`, `state_id`, `cost_center_id`, `guest_house`, `officenumber`, `officeaddress`, `gsaddress`, `caretakername`, `mobile_number`, `status`) VALUES
(1, 'Hyderabad', 'A', 2, 1, '2', '', '', '', '', '', 'active'),
(2, 'Delhi', 'A', 10, 2, '1', '', 'Dainik Bhaskar , Noida 63, D-143, Ground Floor, Sector-63, Noida, Uttar Pradesh, 201301', 'B-4/40, Safdarjung Enclave New Delhi-110029\r\nPhone No. - 011 65355533', 'Bogendra Mukhiya', '9654035108', 'active'),
(3, 'Ahmedabad', 'A', 12, 3, '1', '', 'Divya Bhaskar, 280, Bhaskar House, Nr. YMCA Club, Nr. Infinium Toyota Showroom, Makarba Gam, S.G. Highway, Ahmedabad-380015', 'A-101 Asavari Towers, Bh. Wide Angle, Ramdevnagar, Satellite, Ahmedabad 380051', 'Pankaj Patel', '9909979927', 'active'),
(4, 'Gandhinagar', 'A', 12, 3, '2', '', '', '', '', '', 'active'),
(5, 'Gurgaon', 'A', 13, 2, '2', '', '', '', '', '', 'active'),
(6, 'Bangalore', 'A', 17, 0, '1', '', '', '', '', '', 'active'),
(7, 'Mumbai', 'A', 22, 7, '1', '', 'Mumbai Office BKC\r\nDainik Bhaskar\r\n501,5thFloor,Naman Corporate Link,Opp Dena Bank,C-31,G-Block,Bandra Kurla Cpmplex,Bandra ( East ),Mumbai - 400051\r\n---------------------------------------\r\nMumbai Office Mahim\r\nDainik Bhaskar,\r\nG-3/A, Kamanwala Chambers, New Udyog Mandir -2 ,\r\nMogul Lane,  Mahim (W) Mumbai - 400 016.\r\nTel: +91 22 39501500.', 'Guest House-1\r\nMr. Mahiyar Keravala\r\nVivekanand co-operative housing society, Building no-5, 3rd floor, room no 15, L.J.Road, Near Shobha hotel, Mahim West -16\r\nTel-022-24464358\r\nMob: 9892386510\r\n-----------------------------------------------------------------------------------\r\nGuest House-2\r\nMr. Sagar Bapat, Loyyeds Garden, 10th floor,102, Opp Stanroz showroom,\r\nNear Marathe Udyog Bhavan, prabhadevi west, Mumbai-25\r\nTel:- 022-65804162\r\nMob: 9324791941', 'Narayan', '9892386510', 'active'),
(8, 'Chennai', 'A', 35, 0, '1', '', '', '', '', '', 'active'),
(9, 'Noida', 'A', 38, 0, '1', '', '', '', '', '', 'active'),
(10, 'Kolkata', 'A', 41, 0, '1', '', '', '', '', '', 'active'),
(11, 'Visakhapatnam', 'B', 2, 11, '2', '', '', '', '', '', 'active'),
(12, 'Vizag', 'B', 2, 0, '1', '', '', '', '', '', 'active'),
(13, 'Goa', 'B', 11, 0, '1', '', '', '', '', '', 'active'),
(14, 'Faridabad', 'B', 13, 0, '1', '', '', '', '', '', 'active'),
(15, 'Cochin', 'B', 43, 0, '1', '', '', '', '', '', 'active'),
(16, 'Mysore', 'B', 17, 0, '1', '', '', '', '', '', 'active'),
(17, 'Kochi', 'B', 19, 0, '1', '', '', '', '', '', 'active'),
(18, 'Bhopal', 'B', 21, 18, '1', '', 'Dainik Bhaskar, 6, Ram Gopal Maheshwari Marg, Indira Press Complex, Zone-I, Maharana Pratap Nagar, Bhopal, Madhya 462011', 'GH-1\r\nLotus Villa - 5, Green Meadows, Arera Hills, Bhopal\r\nMeghnath Sharma - M: 7415271346 L: 0755-6544415\r\n----------------------------------------\r\nGH-2\r\nLotus Villa - 19, Green Meadows,  Arera Hills, Bhopal\r\nMr. Mahesh M: 7692080751 L : 0755-6544410\r\n----------------------------------------\r\nGH-3\r\nHouse No 27, Rose villa, Green Meadows, Arera Hills, Nr. Indian Oil office Bhopal.\r\nMr. Prakash Sahu, M: 8602574717, L: 0755-6544419\r\n----------------------------------------', 'Mr. Sanjay Vyas', '9977255566', 'active'),
(19, 'Patna', 'B', 5, 0, '1', '', '', '', '', '', 'active'),
(20, 'Bokaro', 'B', 16, 0, '1', '', '', '', '', '', 'active'),
(21, 'Bhagalpur', 'B', 5, 0, '1', '', '', '', '', '', 'active'),
(22, 'Muzzaffarpur', 'B', 5, 0, '1', '', '', '', '', '', 'active'),
(23, 'Gaya', 'B', 5, 0, '1', '', '', '', '', '', 'active'),
(24, 'Raipur', 'B', 7, 24, '2', '', '', '', '', '', 'active'),
(25, 'Bhilai', 'B', 7, 24, '2', '', '', '', '', '', 'active'),
(26, 'Surat', 'B', 12, 26, '2', '', '', '', '', '', 'active'),
(27, 'Rajkot', 'B', 12, 27, '2', '', '', '', '', '', 'active'),
(28, 'Baroda', 'B', 12, 89, '2', '', '', '', '', '', 'active'),
(29, 'Shimla', 'B', 13, 0, '1', '', '', '', '', '', 'active'),
(30, 'Ranchi', 'B', 16, 0, '1', '', '', '', '', '', 'active'),
(31, 'Jamshedpur', 'B', 16, 0, '1', '', '', '', '', '', 'active'),
(32, 'Dhanbad', 'B', 16, 0, '1', '', '', '', '', '', 'active'),
(33, 'Indore', 'B', 21, 33, '1', '', 'Dainik Bhaskar, 4/54, Press Complex, A B Road, Indore, MP-452010', '401, Pushpa Ratan Building, Vasant Vihar Colony, Near Jain Nursery. A.B. Road,Indore.\r\nJeevan Mukhiya, Mobile:9977001565', 'Mr. Rajkumar Sahu', '9977002456', 'active'),
(34, 'Jabalpur', 'B', 21, 34, '2', '', '', '', '', '', 'active'),
(35, 'Gwalior', 'B', 21, 35, '2', '', '', '', '', '', 'active'),
(36, 'Nagpur', 'B', 22, 0, '1', '', '', '', '', '', 'active'),
(37, 'Aurangabad', 'B', 22, 0, '1', '', '', '', '', '', 'active'),
(38, 'Vijayawada', 'C', 2, 0, '1', '', '', '', '', '', 'active'),
(39, 'Tirupati', 'C', 2, 0, '1', '', '', '', '', '', 'active'),
(40, 'Bilaspur', 'C', 7, 40, '2', '', '', '', '', '', 'active'),
(41, 'Raigarh', 'C', 7, 41, '2', '', '', '', '', '', 'active'),
(42, 'Bhavnagar', 'C', 12, 42, '2', '', '', '', '', '', 'active'),
(43, 'Bhuj', 'C', 12, 43, '2', '', '', '', '', '', 'active'),
(44, 'Jamnagar', 'C', 12, 27, '2', '', '', '', '', '', 'active'),
(45, 'Mehsana', 'C', 12, 45, '2', '', '', '', '', '', 'active'),
(46, 'Vapi', 'C', 12, 46, '2', '', '', '', '', '', 'active'),
(47, 'Junagadh', 'C', 12, 47, '2', '', '', '', '', '', 'active'),
(48, 'Anand', 'C', 12, 3, '2', '', '', '', '', '', 'active'),
(49, 'Navsari', 'C', 12, 26, '2', '', '', '', '', '', 'active'),
(50, 'Valsad', 'C', 12, 46, '2', '', '', '', '', '', 'active'),
(51, 'Patan', 'C', 12, 45, '2', '', '', '', '', '', 'active'),
(52, 'Himmatnagar', 'C', 12, 45, '2', '', '', '', '', '', 'active'),
(53, 'Gandhidham', 'C', 12, 3, '2', '', '', '', '', '', 'active'),
(54, 'Panipat', 'C', 13, 0, '1', '', '', '', '', '', 'active'),
(55, 'Hissar', 'C', 13, 0, '1', '', '', '', '', '', 'active'),
(56, 'Mangalore', 'C', 17, 0, '1', '', '', '', '', '', 'active'),
(57, 'Hoshangabad', 'C', 21, 0, '1', '', '', '', '', '', 'active'),
(58, 'Ratlam', 'C', 21, 0, '1', '', '', '', '', '', 'active'),
(59, 'Ujjain', 'C', 21, 0, '1', '', '', '', '', '', 'active'),
(60, 'Sagar', 'C', 21, 0, '1', '', '', '', '', '', 'active'),
(61, 'Satna', 'C', 21, 0, '1', '', '', '', '', '', 'active'),
(62, 'Khandwa', 'C', 21, 0, '1', '', '', '', '', '', 'active'),
(63, 'Akola', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(64, 'Amravati', 'C', 21, 0, '1', '', '', '', '', '', 'active'),
(65, 'Jalna', 'C', 22, 37, '2', '', '', '', '', '', 'active'),
(66, 'Ahmednagar', 'C', 21, 0, '1', '', '', '', '', '', 'active'),
(67, 'Hamira', 'C', 44, 0, '1', '', '', '', '', '', 'active'),
(68, 'Sarhind', 'C', 44, 0, '1', '', '', '', '', '', 'active'),
(69, 'Bathinda', 'C', 44, 0, '1', '', '', '', '', '', 'active'),
(70, 'Ajmer', 'C', 33, 70, '2', '', '', '', '', '', 'active'),
(71, 'Sriganganagar', 'C', 33, 71, '2', '', '', '', '', '', 'active'),
(72, 'Alwar', 'C', 33, 72, '2', '', '', '', '', '', 'active'),
(73, 'Sikar', 'C', 33, 73, '2', '', '', '', '', '', 'active'),
(74, 'Pali', 'C', 33, 74, '2', '', '', '', '', '', 'active'),
(75, 'Sirohi', 'C', 33, 74, '2', '', '', '', '', '', 'active'),
(76, 'Barmer', 'C', 33, 76, '2', '', '', '', '', '', 'active'),
(77, 'Hanumangarh', 'C', 33, 71, '2', '', '', '', '', '', 'active'),
(78, 'Bhilwara', 'C', 33, 78, '2', '', '', '', '', '', 'active'),
(79, 'Banswara', 'C', 33, 79, '2', '', '', '', '', '', 'active'),
(80, 'Nashik', 'B', 22, 0, '1', '', '', '', '', '', 'active'),
(81, 'Jalgaon', 'B', 22, 0, '1', '', '', '', '', '', 'active'),
(82, 'Solapur', 'B', 22, 0, '1', '', '', '', '', '', 'active'),
(83, 'Pune', 'B', 22, 0, '1', '', '', '', '', '', 'active'),
(84, 'Chandigarh', 'B', 44, 84, '1', '', '', '', '', '', 'active'),
(85, 'Jalandhar', 'B', 44, 0, '1', '', '', '', '', '', 'active'),
(86, 'Ludhiana', 'B', 44, 0, '1', '', '', '', '', '', 'active'),
(87, 'Amritsar', 'B', 44, 0, '1', '', '', '', '', '', 'active'),
(88, 'Jaipur', 'B', 33, 88, '1', '', 'Dainik Bhaskar\r\n10, Jawaharlal Nehru Marg, Malviya nagar Near Vidya Aashram school Jaipur.\r\n', 'Flat No.403, Pearl Park View Apartment, Mathur Colony, Mangal Marg, Bapu Nagar\r\nJaipur-302001\r\nMr. Gaurav M:07220094387\r\n', 'Mr. Rajeev Kapoor', '9828050506', 'active'),
(89, 'Jodhpur', 'B', 33, 89, '2', '', '', '', '', '', 'active'),
(90, 'Udaipur', 'B', 33, 90, '2', '', '', '', '', '', 'active'),
(91, 'Bikaner', 'B', 33, 91, '2', '', '', '', '', '', 'active'),
(92, 'Kota', 'B', 33, 92, '2', '', '', '', '', '', 'active'),
(93, 'Coimbatore', 'B', 35, 0, '1', '', '', '', '', '', 'active'),
(94, 'Kanpur', 'B', 38, 0, '1', '', '', '', '', '', 'active'),
(95, 'Lucknow', 'B', 38, 0, '1', '', '', '', '', '', 'active'),
(96, 'Agra', 'B', 38, 0, '1', '', '', '', '', '', 'active'),
(97, 'Allahabad', 'B', 38, 0, '1', '', '', '', '', '', 'active'),
(98, 'Dehradun', 'B', 39, 0, '1', '', '', '', '', '', 'active'),
(99, 'Haridwar', 'B', 39, 0, '1', '', '', '', '', '', 'active'),
(100, 'Aligarh', 'B', 38, 0, '1', '', '', '', '', '', 'active'),
(101, 'Meerut', 'B', 38, 0, '1', '', '', '', '', '', 'active'),
(102, 'Moradabad', 'B', 38, 0, '1', '', '', '', '', '', 'active'),
(103, 'Bareilly', 'B', 38, 0, '1', '', '', '', '', '', 'active'),
(104, 'Varanasi', 'B', 38, 0, '1', '', '', '', '', '', 'active'),
(105, 'Gorakhpur', 'B', 38, 0, '1', '', '', '', '', '', 'active'),
(106, 'Jhansi', 'B', 38, 0, '1', '', '', '', '', '', 'active'),
(107, 'Guna', 'C', 21, 18, '2', '', '', '', '', '', 'active'),
(108, 'Rajgarh', 'C', 21, 18, '2', '', '', '', '', '', 'active'),
(109, 'Biaora', 'C', 21, 18, '2', '', '', '', '', '', 'active'),
(110, 'Sehore', 'C', 21, 18, '2', '', '', '', '', '', 'active'),
(111, 'Asta', 'C', 21, 18, '2', '', '', '', '', '', 'active'),
(112, 'Vidisha', 'C', 21, 18, '2', '', '', '', '', '', 'active'),
(113, 'Bairagarh', 'C', 21, 18, '2', '', '', '', '', '', 'active'),
(114, 'Raisen', 'C', 21, 18, '2', '', '', '', '', '', 'active'),
(115, 'Mandideep', 'C', 21, 18, '2', '', '', '', '', '', 'active'),
(116, 'Ganjbasoda', 'C', 21, 18, '2', '', '', '', '', '', 'active'),
(117, 'Bhel', 'C', 21, 18, '2', '', '', '', '', '', 'active'),
(118, 'Kolar', 'C', 21, 18, '2', '', '', '', '', '', 'active'),
(119, 'AshokNagar', 'C', 21, 18, '2', '', '', '', '', '', 'active'),
(120, 'Bhind', 'C', 21, 35, '2', '', '', '', '', '', 'active'),
(121, 'Morena', 'C', 21, 35, '2', '', '', '', '', '', 'active'),
(122, 'Dabra', 'C', 21, 35, '2', '', '', '', '', '', 'active'),
(123, 'Datiya', 'C', 21, 35, '2', '', '', '', '', '', 'active'),
(124, 'Shivpuri', 'C', 21, 35, '2', '', '', '', '', '', 'active'),
(125, 'Shoepur', 'C', 21, 35, '2', '', '', '', '', '', 'active'),
(126, 'Bina', 'C', 21, 60, '2', '', '', '', '', '', 'active'),
(127, 'Damoh', 'C', 21, 60, '2', '', '', '', '', '', 'active'),
(128, 'Tikamgarh', 'C', 21, 60, '2', '', '', '', '', '', 'active'),
(129, 'Chattarpur', 'C', 21, 60, '2', '', '', '', '', '', 'active'),
(130, 'Mhow', 'C', 21, 33, '2', '', '', '', '', '', 'active'),
(131, 'Dhar', 'C', 21, 33, '2', '', '', '', '', '', 'active'),
(132, 'Jhabua', 'C', 21, 33, '2', '', '', '', '', '', 'active'),
(133, 'Alirajpur', 'C', 21, 33, '2', '', '', '', '', '', 'active'),
(134, 'Dewas', 'C', 21, 33, '2', '', '', '', '', '', 'active'),
(135, 'Shajapur', 'C', 21, 59, '2', '', '', '', '', '', 'active'),
(136, 'Nagda', 'C', 21, 59, '2', '', '', '', '', '', 'active'),
(137, 'Jaora', 'C', 21, 58, '2', '', '', '', '', '', 'active'),
(138, 'Neemuch', 'C', 21, 58, '2', '', '', '', '', '', 'active'),
(139, 'Mandsaur', 'C', 21, 58, '2', '', '', '', '', '', 'active'),
(140, 'Manasa', 'C', 21, 58, '2', '', '', '', '', '', 'active'),
(141, 'Garoth', 'C', 21, 58, '2', '', '', '', '', '', 'active'),
(142, 'Bhuranpur', 'C', 21, 62, '2', '', '', '', '', '', 'active'),
(143, 'Khargaon', 'C', 21, 62, '2', '', '', '', '', '', 'active'),
(144, 'Badwani', 'C', 21, 62, '2', '', '', '', '', '', 'active'),
(145, 'Itarsi', 'C', 22, 57, '2', '', '', '', '', '', 'active'),
(146, 'Harda', 'C', 21, 57, '2', '', '', '', '', '', 'active'),
(147, 'Betul', 'C', 21, 57, '2', '', '', '', '', '', 'active'),
(148, 'Sarni', 'C', 21, 57, '2', '', '', '', '', '', 'active'),
(149, 'Mutlia', 'C', 21, 57, '2', '', '', '', '', '', 'active'),
(150, 'Pipariya', 'C', 21, 57, '2', '', '', '', '', '', 'active'),
(151, 'Coimbotore', 'B', 35, 0, '1', '', '', '', '', '', 'active'),
(152, 'Banglore', 'B', 17, 0, '1', '', '', '', '', '', 'active'),
(153, 'Vishakapattnam', 'B', 2, 0, '1', '', '', '', '', '', 'active'),
(154, 'Ambikapur', 'C', 7, 40, '2', '', '', '', '', '', 'active'),
(155, 'Koria', 'C', 7, 40, '2', '', '', '', '', '', 'active'),
(156, 'Balod', 'C', 7, 24, '2', '', '', '', '', '', 'active'),
(157, 'Bhilai', 'C', 7, 0, '1', '', '', '', '', '', 'inactive'),
(158, 'kawardha', 'C', 7, 24, '2', '', '', '', '', '', 'active'),
(159, 'Mahasamund', 'C', 7, 24, '2', '', '', '', '', '', 'active'),
(160, 'Kankare', 'C', 7, 24, '2', '', '', '', '', '', 'active'),
(161, 'Baloda Bazar', 'C', 7, 24, '2', '', '', '', '', '', 'active'),
(162, 'Durg', 'C', 7, 24, '2', '', '', '', '', '', 'active'),
(163, 'Rajnandgaon', 'C', 7, 24, '2', '', '', '', '', '', 'active'),
(164, 'Dhamtari', 'C', 7, 24, '2', '', '', '', '', '', 'active'),
(165, 'Jagdalpur', 'C', 7, 24, '2', '', '', '', '', '', 'active'),
(166, 'Korba', 'C', 7, 41, '2', '', '', '', '', '', 'active'),
(167, 'Janjgir', 'C', 7, 41, '2', '', '', '', '', '', 'active'),
(168, 'Jashpur', 'C', 7, 41, '2', '', '', '', '', '', 'active'),
(169, 'CG Road Office', 'C', 12, 3, '2', '', '', '', '', '', 'active'),
(170, 'Khanpur', 'C', 12, 3, '2', '', '', '', '', '', 'active'),
(171, 'Surendranagar', 'C', 12, 3, '2', '', '', '', '', '', 'active'),
(172, 'Gandhinagar', 'C', 12, 3, '2', '', '', '', '', '', 'active'),
(173, 'Nadiad', 'C', 12, 3, '2', '', '', '', '', '', 'active'),
(174, 'Ghandhidham', 'C', 12, 43, '2', '', '', '', '', '', 'active'),
(175, 'Porbander', 'C', 12, 47, '2', '', '', '', '', '', 'active'),
(176, 'Ambreli', 'C', 12, 47, '2', '', '', '', '', '', 'active'),
(177, 'Modasa', 'C', 12, 45, '2', '', '', '', '', '', 'active'),
(178, 'Palanpur', 'C', 12, 45, '2', '', '', '', '', '', 'active'),
(179, 'Bardoli', 'C', 12, 26, '2', '', '', '', '', '', 'active'),
(180, 'Bharuch', 'C', 12, 319, '2', '', '', '', '', '', 'active'),
(181, 'Godhra', 'C', 12, 319, '2', '', '', '', '', '', 'active'),
(182, 'Dahod', 'C', 12, 319, '2', '', '', '', '', '', 'active'),
(183, 'Sehore', 'C', 12, 0, '1', '', '', '', '', '', 'inactive'),
(184, 'Vallibhipur', 'C', 12, 42, '2', '', '', '', '', '', 'active'),
(185, 'Talaja', 'C', 12, 42, '2', '', '', '', '', '', 'active'),
(186, 'Mahuva', 'C', 12, 42, '2', '', '', '', '', '', 'active'),
(187, 'Tonk', 'C', 33, 88, '2', '', '', '', '', '', 'active'),
(188, 'Saviamadhopur', 'C', 33, 88, '2', '', '', '', '', '', 'active'),
(189, 'Gangapur City', 'C', 33, 88, '2', '', '', '', '', '', 'active'),
(190, 'Hindaun City', 'C', 33, 88, '2', '', '', '', '', '', 'active'),
(191, 'Karauli', 'C', 33, 88, '2', '', '', '', '', '', 'active'),
(192, 'Shahpura', 'C', 33, 88, '2', '', '', '', '', '', 'active'),
(193, 'Choumu', 'C', 33, 88, '2', '', '', '', '', '', 'active'),
(194, 'Bandikui', 'C', 33, 88, '2', '', '', '', '', '', 'active'),
(195, 'Dosa', 'C', 33, 88, '2', '', '', '', '', '', 'active'),
(196, 'Bwaver', 'C', 33, 70, '2', '', '', '', '', '', 'active'),
(197, 'Kishangarh', 'C', 33, 70, '2', '', '', '', '', '', 'active'),
(198, 'Behror', 'C', 33, 72, '2', '', '', '', '', '', 'active'),
(199, 'Bhiwadi', 'C', 33, 72, '2', '', '', '', '', '', 'active'),
(200, 'Chittorgarh', 'C', 33, 78, '2', '', '', '', '', '', 'active'),
(201, 'Nokha', 'C', 33, 91, '2', '', '', '', '', '', 'active'),
(202, 'Phalodi', 'C', 33, 89, '2', '', '', '', '', '', 'active'),
(203, 'Bhilara', 'C', 33, 89, '2', '', '', '', '', '', 'active'),
(204, 'Baran', 'C', 33, 92, '2', '', '', '', '', '', 'active'),
(205, 'Bundi', 'C', 33, 92, '2', '', '', '', '', '', 'active'),
(206, 'Jhalawar', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(207, 'Rawatbhata', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(208, 'Ramganjmandi', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(209, 'Kuchaman', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(210, 'Abu road', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(211, 'Jalor', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(212, 'Sumerpur', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(213, 'Bhilmer', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(214, 'Churu', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(215, 'Jhunjhunu', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(216, 'Chidawa', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(217, 'Neemkathana', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(218, 'Suratgarh', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(219, 'Rajsamand', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(220, 'Pratapgarh', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(221, 'Dungarpur', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(222, 'Sagwara', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(223, 'Jaisalmer', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(224, 'Balotra', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(225, 'Pokaran', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(226, 'Dholpur', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(227, 'Hajipur', 'C', 5, 19, '1', '', '', '', '', '', 'active'),
(228, 'Ara', 'C', 5, 19, '2', '', '', '', '', '', 'active'),
(229, 'Chhapra', 'C', 5, 0, '1', '', '', '', '', '', 'active'),
(230, 'Biharsharif', 'C', 5, 0, '1', '', '', '', '', '', 'active'),
(231, 'Samastipur', 'C', 5, 0, '1', '', '', '', '', '', 'active'),
(232, 'Darbhanga', 'C', 5, 0, '1', '', '', '', '', '', 'active'),
(233, 'Purniya', 'C', 5, 0, '1', '', '', '', '', '', 'active'),
(234, 'Ramghar', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(235, 'Hazaribagh', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(236, 'Koderma', 'C', 33, 0, '1', '', '', '', '', '', 'active'),
(237, 'Chatra', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(238, 'Gumla', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(239, 'Simdega', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(240, 'Khuti', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(241, 'Lohardaga', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(242, 'Latehar', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(243, 'Garhwa', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(244, 'Daltonganj', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(245, 'Bokaro', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(246, 'Bermo', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(247, 'Giridih', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(248, 'Jamtara', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(249, 'Jharia', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(250, 'Katras', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(251, 'Ghatsila', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(252, 'Chaibasa', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(253, 'Chakradharpur', 'C', 16, 0, '1', '', '', '', '', '', 'active'),
(254, 'Waluj', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(255, 'Ahmednagar', 'C', 22, 0, '1', '', '', '', '', '', 'inactive'),
(256, 'Beed', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(257, 'Hingoli', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(258, 'Nanded', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(259, 'Parbhani', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(260, 'Pune', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(261, 'Amravati', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(262, 'Buldhana', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(263, 'Yavatmal', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(264, 'Nagpur', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(265, 'Bhusawal', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(266, 'Chalisgaon', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(267, 'Dhule', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(268, 'Malegaon', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(269, 'Sinner', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(270, 'Osmanabad', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(271, 'Latur', 'C', 22, 0, '1', '', '', '', '', '', 'active'),
(272, 'Panchkula', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(273, 'Mohali', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(274, 'Mandi', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(275, 'Solan', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(276, 'Hamirpur', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(277, 'Dharmshala', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(278, 'Nahan', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(279, 'Kullu', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(280, 'Una', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(281, 'Tarn-Taran', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(282, 'Batala', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(283, 'Gurdaspur', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(284, 'Pathankot', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(285, 'Moga', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(286, 'Firozpur', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(287, 'Barnala', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(288, 'Sangrur', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(289, 'Abhor', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(290, 'Hoshiarpur', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(291, 'Phadwara', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(292, 'Nawanshahr', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(293, 'Kapurthala', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(294, 'Jammu', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(295, 'Ropar', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(296, 'Patiala', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(297, 'Khann', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(298, 'Kaithal', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(299, 'Yamnunager', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(300, 'Kurukshetra', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(301, 'Sirsa', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(302, 'Dabawali', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(303, 'Fatehabad', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(304, 'Hansi', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(305, 'Bhiwani', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(306, 'Charkhi Dadri', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(307, 'Sonipat', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(308, 'Karnal', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(309, 'Jind', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(310, 'Gohana', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(311, 'Gurgaon', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(312, 'Faridabad', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(313, 'Mahendergarh', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(314, 'Narnaul', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(315, 'Bahadurgarh', 'C', 45, 0, '1', '', '', '', '', '', 'active'),
(316, 'New Delhi', 'A', 10, 0, '1', '', '', '', '', '', 'inactive'),
(317, 'Mumbai BKC', 'A', 22, 0, '1', '', '', '', '', '', 'inactive'),
(318, 'Mumbai Mahim', 'A', 22, 0, '1', '', '', '', '', '', 'inactive'),
(319, 'Vadodara', 'C', 12, 319, '2', '', '', '', '', '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `logo` text,
  `is_active` tinyint(4) DEFAULT NULL,
  `is_visible` int(11) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `menu_id`, `name`, `label`, `module`, `action`, `url`, `logo`, `is_active`, `is_visible`, `sort_order`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Dashboard', 'Dashboard', 'dashboard', 'index', 'dashboard/index', '<i class=\"fa fa-dashboard\"></i>', 1, 1, 1, NULL, NULL, NULL, NULL),
(2, NULL, 'Travel', 'Travel', 'travel_request', 'index', 'travel_request/index', '<i class=\"fa fa-plane\"></i>', 1, 1, 2, NULL, NULL, NULL, NULL),
(3, NULL, 'Personal Task', 'Personal Task', NULL, NULL, NULL, '<i class=\"fa fa-list-alt\"></i>', 1, 1, 3, NULL, NULL, NULL, NULL),
(4, NULL, 'Travel Desk ', 'Travel Desk ', NULL, NULL, NULL, '<i class=\"fa fa-calendar\"></i>', 1, 1, 4, NULL, NULL, NULL, NULL),
(5, NULL, 'Finance Desk', 'Finance Desk', 'finance_desk', 'index', 'finance_desk/index', '<i class=\"fa fa-rupee\"></i>', 1, 1, 5, NULL, NULL, NULL, NULL),
(6, NULL, 'Auditor Desk', 'Auditor Desk', NULL, NULL, NULL, '<i class=\"fa fa-users\"></i>', 1, 1, 6, NULL, NULL, NULL, NULL),
(7, NULL, 'Report', 'Report', NULL, NULL, NULL, '<i class=\"fa fa-file-text\"></i>', 1, 1, 8, NULL, NULL, NULL, NULL),
(8, NULL, 'Masters Data', 'Masters Data', NULL, NULL, NULL, '<i class=\"fa fa-list-alt\"></i>', 1, 1, 9, NULL, NULL, NULL, NULL),
(9, 2, 'Flight', 'Flight', 'flight_travel', 'index', 'flight_travel/index', '<i class=\"fa fa-paper-plane-o\"></i>', 0, 1, NULL, NULL, NULL, NULL, NULL),
(10, 2, 'Train', 'Train', 'train_travel', 'index', 'train_travel/index', '<i class=\"fa fa-train\"></i>', 0, 1, NULL, NULL, NULL, NULL, NULL),
(11, 2, 'Car', 'car', 'car_travel', 'index', 'car_travel/index', '<i class=\"fa fa-car\"></i>', 0, 1, NULL, NULL, NULL, NULL, NULL),
(12, 2, 'Bus', 'Bus', 'bus_travel', 'index', 'bus_travel/index', '<i class=\"fa fa-bus\"></i>', 0, 1, NULL, NULL, NULL, NULL, NULL),
(13, 3, 'Inbox', 'Inbox', 'employee_request', 'inbox', 'employee_request/inbox', '<i class=\"fa fa-inbox\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(14, 3, 'My Draft', 'My Draft', 'employee_request', 'draft', 'employee_request/draft', '<i class=\"fa fa-pencil-square\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(15, 3, 'My Request', 'My Request', 'employee_request', 'index', 'employee_request/index', '<i class=\"fa fa-tasks\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(16, 8, 'Roles', 'Roles', 'roles', 'index', 'roles/index', '<i class=\"fa fa-user\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(17, 22, 'Designations', 'Designations', 'designation', 'index', 'designation/index', '<i class=\"fa fa-users\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(18, 8, 'States', 'States', 'states', 'index', 'states/index', '<i class=\"fa fa-map-marker\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(19, 8, 'City', 'City', 'city', 'index', 'city/index', '<i class=\"fa fa-map-marker\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(20, 8, 'Cost Center', 'Cost Center', 'cost_center', 'index', 'cost_center/index', '<i class=\"fa fa-location-arrow \"></i>', 0, 0, NULL, NULL, NULL, NULL, NULL),
(21, 8, 'Travel Policy', 'Travel Policy', NULL, NULL, NULL, '<i class=\"fa fa-plane\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(22, 8, 'Employees Master', 'Employees Master', NULL, NULL, NULL, '<i class=\"fa fa-users\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(23, 8, 'Travel Categories', 'Travel Categories', NULL, NULL, NULL, '<i class=\"fa fa-tags\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(24, 8, 'Service Proviers', 'Service Proviers', 'service_proviers', 'index', 'service_proviers/index', '<i class=\"fa fa-th-list\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(25, 22, 'Employee Grade', 'Employee Grade', 'grades', 'index', 'grades/index', '<i class=\"fa fa-star-o\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(26, 22, 'Employee List', 'Employee List', 'employees', 'index', 'employees/index', '<i class=\"fa fa-users\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(27, 21, 'Travel Reasons', 'Travel Reasons', 'travel_reasons', 'index', 'travel_reasons/index', '<i class=\"fa fa-comment\"></i>', 1, 1, 1, NULL, NULL, NULL, NULL),
(28, 21, 'Travel Policy', 'Travel Policy', 'travel_policy', 'index', 'travel_policy/index', '<i class=\"fa fa-exchange\"></i>', 1, 1, 3, NULL, NULL, NULL, NULL),
(29, 21, 'Travel Entitlement', 'Travel Entitlement', NULL, NULL, NULL, '<i class=\"fa fa-info-circle\"></i>', 1, 1, 4, NULL, NULL, NULL, NULL),
(30, 21, 'Expense Polices', 'Expense Polices', NULL, NULL, NULL, '<i class=\"fa fa-money\"></i>', 1, 1, 5, NULL, NULL, NULL, NULL),
(31, 23, 'Car Categories', 'Car Categories', 'car_category', 'index', 'car_category/index', '<i class=\"fa fa-car\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(32, 23, 'Hotel Master', 'Hotel Master', 'hotel_category', 'index', 'hotel_category/index', '<i class=\"fa fa-hotel\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(33, 23, 'Flight Class', 'Flight Class', 'flight_category', 'index', 'flight_category/index', '<i class=\"fa fa-paper-plane-o\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(34, 23, 'Train Class', 'Train Class', 'train_category', 'index', 'train_category/index', '<i class=\"fa fa-train\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(35, 23, 'Bus Class', 'Bus Class', 'bus_category', 'index', 'bus_category/index', '<i class=\"fa fa-bus\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(41, 21, 'Travel Rejected Reasons', 'Travel Rejected Reasons', 'travel_rejected_reasons', 'index', 'travel_rejected_reasons/index', '<i class=\"fa fa-comment\"></i>', 1, 1, 2, NULL, NULL, NULL, NULL),
(42, 4, 'Inbox', 'Inbox', 'travel_desk', 'inbox', 'travel_desk/inbox', '<i class=\"fa fa-inbox\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(43, 4, 'Travel Dashboard', 'Travel Request', 'travel_desk', 'index', 'travel_desk/index', '<i class=\"fa fa-tasks\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(44, 21, 'Travel Budget', 'Travel Budget', 'budget', 'index', 'budget/index', '<i class=\"fa fa-rupee\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(46, 22, 'Department', 'Department', 'department', 'index', 'department/index', '<i class=\"fa fa-list\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL),
(47, 8, 'Projects', 'Projects', 'projects', 'index', 'projects/index', '<i class=\"fa fa-list\"></i>', 1, 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `notify_emp_id` int(11) NOT NULL,
  `sender_emp_id` int(11) NOT NULL,
  `target_id` varchar(15) NOT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `status` enum('Pending','Approved','Declined','Assigned','In_Process','Completed','In_Question','On_hold','Disbursed') NOT NULL,
  `read` tinyint(1) NOT NULL,
  `notify_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `dept_id`, `status`) VALUES
(1, 'Tranning', 4, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `roles_name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `roles_name`, `description`, `status`) VALUES
(1, 'Employee', '*****Employee*****\r\nThe role will be assigned to all DB Corp users as the default.', 'active'),
(2, 'Travel Desk', 'For Travel Desk Users', 'active'),
(3, 'Finance Desk', 'For Finance Desk Users', 'active'),
(4, 'Auditor', '*****Audit of Business Trip*****\r\nRole for Internal Audit.', 'active'),
(5, 'Repoting', 'it is for reporting propose, they users able to view all reports, if role assign to users', 'active'),
(6, 'Manager', 'Manager', 'inactive'),
(7, 'Administrator', '*****Administrator of Travel Application*****\r\nThe administrator can add and edit all the master\'s data.\r\nRoles, Designations, States, DB Offices Citys, Travel Policy, Employee Data, Travel Categories, Service Providers', 'active'),
(8, 'Travel Admin', 'Travel Admin can manage travel all category and  service providers.', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `roles_menu`
--

CREATE TABLE `roles_menu` (
  `id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles_menu`
--

INSERT INTO `roles_menu` (`id`, `roles_id`, `menu_id`) VALUES
(43, 6, 1),
(44, 6, 5),
(45, 6, 6),
(46, 6, 25),
(47, 6, 26),
(143, 3, 5),
(144, 5, 7),
(162, 4, 6),
(258, 2, 42),
(259, 2, 43),
(285, 1, 1),
(286, 1, 9),
(287, 1, 10),
(288, 1, 11),
(289, 1, 12),
(290, 1, 13),
(291, 1, 14),
(292, 1, 15),
(293, 1, 45),
(294, 8, 32),
(295, 8, 24),
(323, 7, 1),
(324, 7, 13),
(325, 7, 14),
(326, 7, 15),
(327, 7, 42),
(328, 7, 43),
(329, 7, 5),
(330, 7, 6),
(331, 7, 7),
(332, 7, 18),
(333, 7, 19),
(334, 7, 44),
(335, 7, 27),
(336, 7, 41),
(337, 7, 28),
(338, 7, 29),
(339, 7, 30),
(340, 7, 17),
(341, 7, 25),
(342, 7, 26),
(343, 7, 46),
(344, 7, 31),
(345, 7, 32),
(346, 7, 33),
(347, 7, 34),
(348, 7, 35),
(349, 7, 24),
(350, 7, 47);

-- --------------------------------------------------------

--
-- Table structure for table `room_booking_request`
--

CREATE TABLE `room_booking_request` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `request_date` date NOT NULL,
  `client` int(11) NOT NULL,
  `engagement_type` varchar(50) NOT NULL,
  `account_manager` varchar(100) NOT NULL,
  `exp_reimbursable` varchar(10) NOT NULL,
  `booking_reason` text NOT NULL,
  `location` varchar(50) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `rooms` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `approver` int(11) NOT NULL,
  `decline_reason` varchar(255) NOT NULL,
  `action_date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `code` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `send_mail`
--

CREATE TABLE `send_mail` (
  `id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `to_email` varchar(255) NOT NULL,
  `cc_email` varchar(255) NOT NULL,
  `bcc_email` varchar(255) NOT NULL,
  `from_email` varchar(55) NOT NULL,
  `message` text NOT NULL,
  `is_multi_attachment` tinyint(1) NOT NULL,
  `attachment` text NOT NULL,
  `no_of_try` tinyint(4) NOT NULL,
  `status` enum('Not Send','Send') NOT NULL,
  `created_datetime` datetime NOT NULL,
  `modified_datetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `send_mail`
--

INSERT INTO `send_mail` (`id`, `subject`, `to_email`, `cc_email`, `bcc_email`, `from_email`, `message`, `is_multi_attachment`, `attachment`, `no_of_try`, `status`, `created_datetime`, `modified_datetime`) VALUES
(39286, 'Welcome Abhay Singh to CRG Family', 'abhay.singh1@dbcorp.in', '', '', 'info@crgroup.co.in', 'Dear Abhay Singh,<br><br>\r\n                                A warm welcome to CRG Family.<br>\r\n                                Please find a screen shot of your profile in the attachment.<br><br>\r\n                                Best Regards,<br><br>\r\n                                Team HR.<br>', 0, 'assets/employee_pdf/employee_profile-CRG-0006.pdf', 0, 'Not Send', '2017-07-24 12:38:05', '0000-00-00 00:00:00'),
(39287, 'A new member Abhay Singh has joined CRG Family', 'vchitale@crgroup.com,vbhokse@crgroup.com,kreengasia@crgroup.co.in', 'hsethi@crgroup.co.in,avaidya@crgroup.com,rsethi@crgroup.co.in', '', 'info@crgroup.co.in', 'Hi Team,<br><br>\r\n                                A new team member, <b>Abhay Singh</b>, has joined the CRG Family today.<br>\r\n                                Please find detailed profile below -<br><br><table border = \'1\'><tr><td colspan=\'4\'><b style=\'color:#5975DC;\'>BASIC INFORMATION</b></td></tr><tr><td><b>Employee ID</b></td><td>CRG-0006</td><td><b>Email(Official)</b></td><td>abhay.singh1@dbcorp.in</td></tr><tr><td><b>Designation</b></td><td>Deputy Manager</td><td><b>Grade</b></td><td>M2/2</td></tr><tr><td colspan=\'4\'><b style=\'color:#5975DC;\'>PERSONAL INFORMATION</b></td></tr><tr><td><b>First Name</b></td><td>Abhay</td><td><b>Middle Name</b></td><td></td></tr><tr><td><b>Last Name</b></td><td>Singh</td><td><b>Father Name</b></td><tr><td><b>Gender</b></td><td>Male</td></tr><tr><td><b>Mobile Number</b></td><td>0000000000</td><td><b>Date of Birth</b></td><td>1st Jul, 1999</td></tr><tr><td colspan=\'4\'><b style=\'color:#5975DC;\'>LOCAL ADDRESS</b></td></tr><tr><td><b>Address 1</b></td><td></td><td><b>Address 2</b></td><td></td></tr><tr><td><b>City</b></td><td></td><td><b>State</b></td><td>Madhya-Pradesh</td></tr><tr><td><b>Country</b></td><td></td><td><b>Post Code</b></td><td></td></tr></table><br><br>Best Regards,<br><br>\r\n                                Team HR.<br>', 0, 'assets/employee_pdf/employee_profile-CRG-0006.pdf', 0, 'Not Send', '2017-07-24 12:38:05', '0000-00-00 00:00:00'),
(39288, 'Welcome Abhay Singh to CRG Family', 'all@crgroup.co.in', '', '', 'info@crgroup.co.in', '<p>Dear Team,<br><br>\r\n                                Team HR take this opportunity to join you all in extending a warm welcome to\r\n                                <b>Abhay Singh</b>,\r\n                                who has joined \r\n                                <b style=\'color:#337ab7;\'>Corporate</b> <b style=\'color:#f26e22;\'>Renaissance</b> <b style=\'color:#337ab7;\'>Group</b> \r\n                                <b></b> as <b>Deputy Manager</b>.\r\n                                <br><br></p>We look forward to your support and cooperation to Mr <b>Abhay Singh</b>,\r\n                                in his current assignment and wish him a happy association with the CRG Family.<br><br>\r\n                                You can all reach him at abhay.singh1@dbcorp.in<br><br>\r\n                                Best Regards,<br><br>\r\n                                Team HR.<br>', 0, '', 0, 'Not Send', '2017-07-24 12:38:05', '0000-00-00 00:00:00'),
(39289, 'Company Policies', 'abhay.singh1@dbcorp.in', '', '', 'info@crgroup.co.in', 'Dear Abhay Singh<br><br>\r\n                                We at Team HRD would like to share the set of policies that we have to adhere to in CRG. \r\n                                Please find enclosed the company policies for your quick reference.<br>\r\n                                You may also find the same in your Employee folder under section <b>Policies</b>.<br>\r\n                                Look forward to have long term association with you.<br><br>\r\n                                Thank You<br><br>\r\n                                Team HRD.<br><br>\r\n                                CRG Solutions Pvt Ltd.<br>', 1, 'assets/CRG-Travel-Policy.pdf,assets/CRG-Working-hours-Guidelines.pdf,assets/Reimbursement_Policy.pdf,assets/short_leave_policy.pdf,assets/leave_policy.pdf,assets/ERP_policy.pdf,assets/Discipline_policy.pdf,assets/Employee_Receipt_for_Company_Property.pdf', 0, 'Not Send', '2017-07-24 12:38:05', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `service_proviers`
--

CREATE TABLE `service_proviers` (
  `id` int(11) NOT NULL,
  `service_type` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `amount` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_proviers`
--

INSERT INTO `service_proviers` (`id`, `service_type`, `name`, `amount`, `location`, `city_id`, `status`) VALUES
(1, 1, 'First Class', 1000, 'Bhopal', 0, 'inactive'),
(2, 1, 'Patidar Travels', 0, 'Indore', 33, 'active'),
(3, 1, 'Pearl Travels', 75, 'Bhopal', 18, 'active'),
(4, 1, 'UniglobeMod Travels', 75, 'Bhopal', 18, 'active'),
(5, 1, 'Misbha Travels', 0, 'Mumbai', 7, 'active'),
(6, 1, 'Omkar International', 0, 'Mumbai', 7, 'active'),
(7, 1, 'Travel Care', 0, 'Jaipur', 88, 'active'),
(8, 1, 'FCM', 0, 'Ahemdabad', 3, 'active'),
(9, 1, 'Chahat Travels', 0, 'Chandigarh', 84, 'active'),
(10, 1, 'Travel Samurai', 0, 'Chandigarh', 84, 'active'),
(11, 1, 'Friends Travels', 0, 'Patna', 19, 'active'),
(12, 1, 'Om Travels', 0, 'Patna', 19, 'active'),
(13, 1, 'Ridhi sidhi', 0, 'Jamsherpur', 31, 'active'),
(14, 1, 'Jai Travels', 0, 'Ranchi', 30, 'active'),
(15, 1, 'Umang Travels', 0, 'Ahemdabad', 3, 'active'),
(16, 1, 'New Shukla', 0, 'Bhopal', 18, 'active'),
(17, 1, 'R International', 0, 'Ahemdabad', 3, 'active'),
(18, 1, 'Priyam Travels', 0, 'Chandigarh', 84, 'active'),
(19, 1, 'Shivam Travels', 0, 'Ranchi', 30, 'active'),
(20, 1, 'Fun Fly Travels', 0, 'Ranchi', 30, 'active'),
(21, 1, 'Amolak Travels', 0, 'Delhi', 2, 'inactive'),
(22, 4, 'Chartered Bus', 0, 'Bhopal', 18, 'active'),
(23, 4, 'Travel Desk', 0, 'Bhopal', 18, 'active'),
(24, 3, 'New Sarthi', 0, 'Bhopal', 18, 'active'),
(25, 3, 'Vijay Laxmi', 0, 'Bhopal', 18, 'active'),
(26, 3, 'Kidhar', 0, 'Bhopal', 18, 'active'),
(27, 3, 'OLA Booked By Self', 0, 'Bhopal', 18, 'active'),
(28, 3, 'Uber Booked By Self', 0, 'Bhopal', 18, 'active'),
(29, 2, 'New Shukla', 0, 'Bhopal', 18, 'active'),
(30, 2, 'Umang Travels', 0, 'Ahemdabad', 3, 'active'),
(31, 2, 'Travel Care', 0, 'Jaipur', 88, 'active'),
(32, 2, 'R International', 0, 'Ahemdabad', 3, 'active'),
(33, 2, 'Chahat Travels', 0, 'Chandigarh', 84, 'active'),
(34, 2, 'Travel Samurai', 0, 'Chandigarh', 84, 'active'),
(35, 2, 'Priyam Travels', 0, 'Chandigarh', 84, 'active'),
(36, 2, 'Friends Travels', 0, 'Patna', 30, 'active'),
(37, 2, 'Om Travels', 0, 'Patna', 19, 'active'),
(38, 2, 'Ridhi sidhi', 0, 'Jamsherpur', 31, 'active'),
(39, 2, 'Shivam Travels', 0, 'Ranchi', 30, 'active'),
(40, 2, 'Amolak Travels', 0, 'Delhi', 316, 'active'),
(41, 2, 'Beam DB Corp', 0, 'Bhopal', 18, 'active'),
(42, 5, 'Alpha One Hotel', 2000, '', 1, 'inactive'),
(43, 3, 'Ashok Travels', 0, '', 2, 'active'),
(44, 3, 'Kaushik Cab Services', 0, '', 9, 'active'),
(45, 3, 'Aswani Cab Travels', 0, '', 2, 'active'),
(46, 5, 'Sun Palace', 1500, '', 18, 'active'),
(47, 5, 'Shubh Inn', 2500, '', 18, 'active'),
(48, 5, 'Lake Princess', 1500, '', 18, 'active'),
(49, 3, 'Rishabh Tour & Travels ', 0, '', 18, 'active'),
(50, 2, 'Jai Maa Travels', 0, '', 18, 'active'),
(51, 3, 'Anshi Tours & Travels', 0, '', 95, 'active'),
(52, 3, 'Viber Mobility & Hospitality P', 0, '', 9, 'active'),
(53, 1, 'shaan World travels', 0, '', 2, 'active'),
(54, 2, 'Super fast Express', 0, '', 2, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `state_list`
--

CREATE TABLE `state_list` (
  `id` int(11) NOT NULL,
  `state_name` varchar(30) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1',
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state_list`
--

INSERT INTO `state_list` (`id`, `state_name`, `country_id`, `status`) VALUES
(1, 'Andaman-Nicobar ', 101, 'active'),
(2, 'Andhra-Pradesh', 101, 'active'),
(3, 'Arunachal-Pradesh', 101, 'active'),
(4, 'Assam', 101, 'active'),
(5, 'Bihar', 101, 'active'),
(6, 'Chandigarh', 101, 'inactive'),
(7, 'Chhattisgarh', 101, 'active'),
(8, 'Dadra-and-Nagar-Haveli', 101, 'active'),
(9, 'Daman-and-Diu', 101, 'active'),
(10, 'Delhi', 101, 'active'),
(11, 'Goa', 101, 'active'),
(12, 'Gujarat', 101, 'active'),
(13, 'Haryana', 101, 'active'),
(14, 'Himachal-Pradesh', 101, 'active'),
(15, 'Jammu&Kashmir', 101, 'active'),
(16, 'Jharkhand', 101, 'active'),
(17, 'Karnataka', 101, 'active'),
(18, 'Kenmore', 101, 'active'),
(19, 'Kerala', 101, 'active'),
(20, 'Lakshadweep', 101, 'active'),
(21, 'Madhya-Pradesh', 101, 'active'),
(22, 'Maharashtra', 101, 'active'),
(23, 'Manipur', 101, 'active'),
(24, 'Meghalaya', 101, 'active'),
(25, 'Mizoram', 101, 'active'),
(26, 'Nagaland', 101, 'active'),
(27, 'Narora', 101, 'active'),
(28, 'Natwar', 101, 'active'),
(29, 'Odisha', 101, 'active'),
(30, 'Paschim-Medinipur', 101, 'active'),
(31, 'Pondicherry', 101, 'active'),
(32, 'Punjab', 101, 'active'),
(33, 'Rajasthan', 101, 'active'),
(34, 'Sikkim', 101, 'active'),
(35, 'Tamilnadu', 101, 'active'),
(36, 'Telangana', 101, 'active'),
(37, 'Tripura', 101, 'active'),
(38, 'Uttar-Pradesh', 101, 'active'),
(39, 'Uttarakhand', 101, 'active'),
(40, 'Vaishali', 101, 'active'),
(41, 'West-Bengal', 101, 'active'),
(43, 'Karla', 1, 'active'),
(44, 'Panjab', 1, 'active'),
(45, 'CPH', 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `train_category`
--

CREATE TABLE `train_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `train_category`
--

INSERT INTO `train_category` (`id`, `name`, `status`) VALUES
(1, 'SL', 'active'),
(2, 'CC', 'active'),
(3, '1AC', 'active'),
(4, '2AC', 'active'),
(5, '3AC', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `train_ticket_booking`
--

CREATE TABLE `train_ticket_booking` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `train_provider_id` int(11) NOT NULL,
  `pnr_number` varchar(30) NOT NULL,
  `cost` int(11) NOT NULL,
  `train_number` varchar(30) NOT NULL,
  `comment` text NOT NULL,
  `train_attachment` varchar(50) NOT NULL,
  `arrange_by` enum('Pending','Company','Own') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travel_booking`
--

CREATE TABLE `travel_booking` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `travel_ticket` int(11) DEFAULT NULL,
  `accommodation` int(11) DEFAULT NULL,
  `car_hire` int(11) DEFAULT NULL,
  `bookbyself` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travel_category`
--

CREATE TABLE `travel_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `travel_type` int(11) NOT NULL,
  `amount` int(30) NOT NULL,
  `city_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_category`
--

INSERT INTO `travel_category` (`id`, `name`, `travel_type`, `amount`, `city_id`, `category`, `type`, `status`) VALUES
(1, 'Economy Class', 1, 0, 0, 0, 0, 'active'),
(2, 'Premium Economy', 1, 0, 0, 0, 0, 'active'),
(3, 'Business Class', 1, 0, 0, 0, 0, 'active'),
(4, 'First Class', 1, 0, 0, 0, 0, 'active'),
(5, 'SL', 2, 0, 0, 0, 0, 'active'),
(6, 'CC', 2, 0, 0, 0, 0, 'active'),
(7, '1AC', 2, 0, 0, 0, 0, 'active'),
(8, '2AC', 2, 0, 0, 0, 0, 'active'),
(9, '3AC', 2, 0, 0, 0, 0, 'active'),
(10, 'AC Bus', 4, 0, 0, 0, 0, 'active'),
(11, 'Non AC', 4, 0, 0, 0, 0, 'active'),
(12, 'Swift Desire', 3, 6, 18, 0, 0, 'active'),
(13, 'Indigo', 3, 6, 18, 0, 0, 'active'),
(14, 'Hyundai', 3, 7, 18, 0, 0, 'inactive'),
(15, 'Hyundai Ford Ikon', 3, 6, 18, 0, 0, 'active'),
(16, 'Auto', 3, 4, 18, 0, 0, 'active'),
(17, 'Public Transport', 3, 3, 18, 0, 0, 'active'),
(18, 'Shubh Inn', 5, 800, 18, 3, 1, 'active'),
(19, 'Sun Place', 5, 1000, 18, 2, 1, 'active'),
(20, 'Lake Princess', 5, 1000, 33, 1, 0, 'active'),
(21, 'Hotel Nisraga', 5, 1500, 18, 2, 1, 'active'),
(22, 'Surendra Vlish', 5, 2500, 18, 3, 1, 'active'),
(23, 'Court Marriott', 5, 1500, 88, 3, 0, 'active'),
(24, 'IVY Swits', 5, 2500, 3, 3, 0, 'active'),
(25, 'Lake View Ashoka', 5, 1500, 26, 3, 0, 'active'),
(26, 'Hotel Mosaic', 5, 2000, 9, 3, 0, 'active'),
(27, 'The Ashok NewDelhi', 5, 1500, 2, 3, 0, 'active'),
(28, 'Red Fox', 5, 1200, 88, 2, 0, 'active'),
(29, 'Hotal Maharaja', 5, 1640, 88, 2, 0, 'active'),
(30, 'Hotel Balaji', 5, 900, 31, 1, 0, 'active'),
(31, 'Hotel South Park', 5, 2800, 31, 3, 0, 'active'),
(32, 'J K Residency', 5, 1500, 31, 2, 0, 'active'),
(33, 'Omkar Palace', 5, 2200, 59, 3, 0, 'active'),
(34, 'Hotel Ashray', 5, 1466, 59, 2, 0, 'active'),
(35, 'Hotel Shri Maya', 5, 1466, 59, 2, 0, 'active'),
(36, 'Hotel Hilton Tower', 5, 1700, 59, 1, 0, 'active'),
(37, 'Midtown Hotel', 5, 1800, 92, 2, 0, 'active'),
(38, 'Silver Palace', 5, 2500, 81, 3, 0, 'active'),
(39, 'Vivanta Hari Mahal', 5, 2500, 89, 3, 0, 'active'),
(40, 'Hotel Monarch and Restaurant', 5, 1500, 89, 2, 0, 'active'),
(41, 'Courtyard Marriot', 5, 2500, 3, 3, 0, 'active'),
(42, 'Crown Plaza', 5, 1500, 3, 3, 0, 'active'),
(43, 'Radisson Blu', 5, 2600, 3, 3, 0, 'active'),
(44, 'Hotel Surya Executive', 5, 2500, 82, 3, 0, 'active'),
(45, 'Swastika Home ( guest house )', 5, 1416, 9, 1, 0, 'active'),
(46, 'COUNTRY INN', 5, 4956, 9, 4, 0, 'active'),
(47, 'PARK ASCENT', 5, 4920, 9, 4, 0, 'active'),
(48, 'RADISSION BLU KAUSHAMBI  GHAZIABAD', 5, 8732, 9, 5, 0, 'active'),
(49, 'WEST INN MUMBAI', 5, 13800, 7, 5, 0, 'active'),
(50, 'ORCHID HOTEL  MUMBAI', 5, 8000, 7, 4, 0, 'active'),
(51, 'HOLIDAY INN  DELHI AEROCITY', 5, 7800, 2, 4, 0, 'active'),
(52, 'Hotel Lineage', 5, 3500, 95, 4, 0, 'active'),
(53, 'Coral\'s Inn', 5, 1200, 95, 1, 0, 'active'),
(54, 'The Grand JBR', 5, 3500, 95, 4, 0, 'active'),
(55, 'Dayal Paradise', 5, 3500, 95, 4, 0, 'active'),
(56, 'Ramada', 5, 3200, 3, 3, 1, 'active'),
(57, 'Crown Plaza', 5, 5500, 3, 5, 1, 'active'),
(58, 'Novotel', 5, 5500, 3, 5, 1, 'active'),
(59, 'Radission Blue', 5, 5500, 3, 5, 1, 'active'),
(60, 'Pride Plaza', 5, 3500, 3, 4, 1, 'active'),
(61, 'Fern Residency', 5, 3000, 3, 3, 1, 'active'),
(62, 'Planet Landmark', 5, 2000, 3, 2, 1, 'active'),
(63, 'Grand Elegance', 5, 1800, 3, 2, 1, 'active'),
(64, 'Spectrum Atithya (Service Apartment)', 5, 1750, 3, 2, 1, 'active'),
(65, 'Avion', 5, 800, 3, 1, 1, 'active'),
(66, 'Lemon Tree Aerocity', 5, 5500, 2, 4, 1, 'active'),
(67, 'PRIDE HOTEL', 5, 5000, 2, 4, 1, 'active'),
(68, 'Novotel', 5, 5000, 2, 4, 1, 'active'),
(69, 'Redfox By Lemon Tree Aerocity', 5, 5000, 2, 4, 1, 'active'),
(70, 'Hotel Classic Diplomat', 5, 2800, 2, 2, 1, 'active'),
(71, 'Lemon Tree Premier', 5, 6500, 5, 6, 1, 'active'),
(72, 'Red Carpet Hotel', 5, 2400, 9, 2, 1, 'active'),
(73, 'Savoy Suite', 5, 3500, 9, 4, 1, 'active'),
(74, 'Mahagun Sarovar Portico', 5, 3000, 9, 4, 1, 'active'),
(75, 'The Park Inn By Radisson', 5, 4000, 2, 4, 1, 'active'),
(76, 'Sita International', 5, 1500, 2, 2, 1, 'active'),
(77, 'Shreyans Inn', 5, 4250, 2, 4, 1, 'active'),
(78, 'Goodwill Hotel', 5, 2500, 2, 3, 1, 'active'),
(79, 'Oodless Residency', 5, 2800, 2, 3, 1, 'active'),
(80, 'Lotus Hospitality', 5, 1853, 9, 2, 1, 'active'),
(81, 'Eros Hotel', 5, 7700, 2, 5, 1, 'active'),
(82, 'Golden Tulip', 5, 3500, 9, 5, 1, 'active'),
(83, 'golden Tulip', 5, 3500, 9, 4, 1, 'active'),
(84, 'hotel Hyphen', 5, 1900, 9, 2, 1, 'active'),
(85, 'lotus hospitality', 5, 0, 9, 2, 2, 'active'),
(86, 'Mahagun Sarovar Partico', 5, 3200, 9, 4, 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `travel_expenses`
--

CREATE TABLE `travel_expenses` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `bill_number` varchar(25) NOT NULL,
  `project_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `travel_mode` enum('Two Wheeler','Four Wheeler','Taxi','Train','Bus','Air','Auto','Others','Per Diem') NOT NULL DEFAULT 'Train',
  `travel_type` enum('out_of_station','local','per_diem') NOT NULL,
  `misc` varchar(200) NOT NULL,
  `kms` int(11) NOT NULL,
  `parking` int(10) DEFAULT NULL,
  `toll` int(10) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `description` text NOT NULL,
  `has_bill` tinyint(1) NOT NULL,
  `status` enum('Pending','Approved','Declined','Disbursed','In_Question') NOT NULL DEFAULT 'Pending',
  `archived` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `bill_file_name` varchar(50) NOT NULL,
  `decline_reason` text NOT NULL,
  `in_question_reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travel_policy`
--

CREATE TABLE `travel_policy` (
  `id` int(11) NOT NULL,
  `service_type` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `approval_level` int(11) NOT NULL,
  `city_class` varchar(11) NOT NULL,
  `actual` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `popup` text NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_policy`
--

INSERT INTO `travel_policy` (`id`, `service_type`, `grade_id`, `approval_level`, `city_class`, `actual`, `amount`, `popup`, `status`) VALUES
(1, 1, 18, 1, 'A', 1, 0, '-', 'active'),
(2, 2, 18, 1, 'A', 1, 0, '-', 'active'),
(3, 4, 18, 1, 'A', 1, 0, '-', 'active'),
(4, 7, 18, 1, 'A', 1, 0, '-', 'active'),
(5, 7, 18, 1, 'B', 1, 0, '-', 'active'),
(6, 7, 18, 1, 'C', 1, 0, '-', 'active'),
(7, 5, 18, 1, 'A', 0, 4250, 'You are entitled Hotels Up to Rs. 4250.00', 'active'),
(8, 5, 18, 1, 'B', 0, 2500, 'You are entitled Hotels Up to Rs. 2500.00', 'active'),
(9, 5, 18, 1, 'C', 0, 1500, 'You are entitled Hotels Up to Rs. 1500.00', 'active'),
(10, 6, 18, 1, 'A', 0, 1250, '-', 'active'),
(11, 6, 18, 1, 'B', 0, 600, '-', 'active'),
(12, 6, 18, 1, 'C', 0, 500, '-', 'active'),
(13, 1, 16, 1, 'A', 1, 0, '--', 'active'),
(14, 2, 16, 1, 'A', 1, 0, '-', 'active'),
(15, 4, 16, 1, 'A', 1, 0, '-', 'active'),
(16, 6, 16, 1, 'A', 0, 350, '-', 'active'),
(17, 6, 16, 1, 'B', 0, 275, '-', 'active'),
(18, 6, 16, 1, 'C', 0, 175, '-', 'active'),
(19, 7, 16, 1, 'A', 0, 200, '-', 'active'),
(20, 7, 16, 1, 'B', 0, 100, '-', 'active'),
(21, 7, 16, 1, 'C', 0, 75, '-', 'active'),
(22, 5, 16, 1, 'A', 0, 1500, '-', 'active'),
(23, 5, 16, 1, 'B', 0, 750, '-', 'active'),
(24, 5, 16, 1, 'C', 0, 400, '-', 'active'),
(25, 1, 17, 1, 'A', 1, 0, '-', 'active'),
(26, 2, 17, 1, 'A', 1, 0, '-', 'active'),
(27, 4, 17, 1, 'A', 1, 0, '-', 'active'),
(28, 5, 17, 1, 'A', 0, 1250, '-', 'active'),
(29, 5, 17, 1, 'B', 0, 500, '-', 'active'),
(30, 5, 17, 1, 'C', 0, 300, '-', 'active'),
(31, 6, 17, 1, 'A', 0, 350, '-', 'active'),
(32, 6, 17, 1, 'B', 0, 275, '-', 'active'),
(33, 6, 17, 1, 'C', 0, 125, '-', 'active'),
(34, 7, 17, 1, 'A', 0, 150, '-', 'active'),
(35, 7, 17, 1, 'B', 0, 100, '-', 'active'),
(36, 7, 17, 1, 'C', 0, 75, '-', 'active'),
(37, 1, 19, 1, 'A', 1, 0, '-', 'active'),
(38, 2, 19, 1, 'A', 1, 0, '-', 'active'),
(39, 4, 19, 1, 'A', 1, 0, '-', 'active'),
(40, 5, 19, 1, 'A', 0, 750, '-', 'active'),
(41, 5, 19, 1, 'B', 0, 250, '-', 'active'),
(42, 5, 19, 1, 'C', 0, 200, '-', 'active'),
(43, 6, 19, 1, 'A', 0, 200, '-', 'active'),
(44, 6, 19, 1, 'B', 0, 150, '-', 'active'),
(45, 6, 19, 1, 'C', 0, 75, '-', 'active'),
(46, 7, 19, 1, 'A', 0, 125, '-', 'active'),
(47, 7, 19, 1, 'B', 0, 75, '-', 'active'),
(48, 7, 19, 1, 'C', 0, 50, '-', 'active'),
(49, 1, 20, 1, 'A', 1, 0, '-', 'active'),
(50, 2, 20, 1, 'A', 1, 0, '-', 'active'),
(51, 4, 20, 1, 'A', 1, 0, '-', 'active'),
(52, 5, 20, 1, 'A', 0, 350, '-', 'active'),
(53, 5, 20, 1, 'B', 0, 150, '-', 'active'),
(54, 5, 20, 1, 'C', 0, 100, '-', 'active'),
(55, 6, 20, 1, 'A', 0, 150, '-', 'active'),
(56, 6, 20, 1, 'B', 0, 75, '-', 'active'),
(57, 6, 20, 1, 'C', 0, 50, '-', 'active'),
(58, 7, 20, 1, 'A', 0, 75, '-', 'active'),
(59, 1, 20, 1, 'B', 1, 0, '-', 'active'),
(60, 7, 20, 1, 'C', 0, 25, '-', 'active'),
(61, 7, 20, 1, 'B', 0, 50, '-', 'active'),
(62, 1, 15, 1, 'A', 1, 0, '-', 'active'),
(63, 2, 15, 1, 'A', 1, 0, '-', 'active'),
(64, 4, 15, 1, 'A', 1, 0, '-', 'active'),
(65, 5, 15, 1, 'A', 0, 2000, '-', 'active'),
(66, 5, 15, 1, 'B', 0, 1000, '-', 'active'),
(67, 5, 15, 1, 'C', 0, 600, '-', 'active'),
(68, 6, 15, 1, 'A', 0, 400, '-', 'active'),
(69, 6, 15, 1, 'B', 0, 300, '-', 'active'),
(70, 6, 15, 1, 'C', 0, 200, '-', 'active'),
(71, 7, 15, 1, 'A', 0, 200, '-', 'active'),
(72, 7, 15, 1, 'B', 0, 125, '-', 'active'),
(73, 7, 15, 1, 'C', 0, 100, '-', 'active'),
(74, 1, 22, 1, 'A', 1, 0, '-', 'active'),
(75, 2, 22, 1, 'A', 1, 0, '-', 'active'),
(76, 4, 22, 1, 'A', 1, 0, '-', 'active'),
(77, 5, 22, 1, 'A', 0, 1000, '-', 'active'),
(78, 5, 22, 1, 'B', 0, 350, '-', 'active'),
(79, 5, 22, 1, 'C', 0, 250, '-', 'active'),
(80, 6, 22, 1, 'A', 0, 250, '-', 'active'),
(81, 6, 22, 1, 'B', 0, 200, '-', 'active'),
(82, 6, 22, 1, 'C', 0, 100, '-', 'active'),
(83, 7, 22, 1, 'A', 0, 150, '-', 'active'),
(84, 7, 22, 1, 'B', 0, 100, '-', 'active'),
(85, 7, 22, 1, 'C', 0, 75, '-', 'active'),
(86, 1, 4, 0, 'A', 1, 0, '-', 'active'),
(87, 2, 4, 0, 'A', 1, 0, '-', 'active'),
(88, 4, 4, 0, 'A', 1, 0, '-', 'active'),
(89, 5, 4, 0, 'A', 1, 0, '-', 'active'),
(90, 5, 4, 0, 'B', 1, 0, '-', 'active'),
(91, 5, 4, 0, 'C', 1, 0, '-', 'active'),
(92, 6, 4, 0, 'A', 1, 0, '-', 'active'),
(93, 6, 4, 0, 'B', 1, 0, '-', 'active'),
(94, 6, 4, 0, 'C', 1, 0, '-', 'active'),
(95, 7, 4, 0, 'A', 1, 0, '-', 'active'),
(96, 7, 4, 0, 'B', 1, 0, '-', 'active'),
(97, 7, 4, 0, 'C', 1, 0, '-', 'active'),
(98, 1, 5, 1, 'A', 1, 0, '-', 'active'),
(99, 2, 5, 0, 'A', 1, 0, '-', 'active'),
(100, 4, 5, 0, 'A', 1, 0, '-', 'active'),
(101, 5, 5, 0, 'A', 1, 0, '-', 'active'),
(102, 5, 5, 0, 'B', 1, 0, '-', 'active'),
(103, 5, 5, 0, 'C', 1, 0, '-', 'active'),
(104, 6, 5, 0, 'A', 1, 0, '-', 'active'),
(105, 6, 5, 0, 'B', 1, 0, '-', 'active'),
(106, 6, 5, 0, 'C', 1, 0, '-', 'active'),
(107, 7, 5, 0, 'C', 1, 0, '-', 'active'),
(108, 7, 5, 0, 'B', 1, 0, '-', 'active'),
(109, 7, 5, 0, 'A', 1, 0, '-', 'active'),
(110, 1, 6, 0, 'A', 1, 0, '-', 'active'),
(111, 2, 6, 0, 'A', 1, 0, '-', 'active'),
(112, 4, 6, 0, 'A', 1, 0, '-', 'active'),
(113, 6, 6, 0, 'A', 1, 0, '-', 'active'),
(114, 6, 6, 0, 'B', 1, 0, '-', 'active'),
(115, 6, 6, 0, 'C', 1, 0, '-', 'active'),
(116, 7, 6, 0, 'A', 1, 0, '-', 'active'),
(117, 7, 6, 0, 'B', 1, 0, '-', 'active'),
(118, 7, 6, 0, 'C', 1, 0, '-', 'active'),
(119, 5, 6, 0, 'A', 1, 0, '-', 'active'),
(120, 5, 6, 0, 'B', 1, 0, '-', 'active'),
(121, 5, 6, 0, 'C', 1, 0, '-', 'active'),
(122, 1, 7, 0, 'A', 1, 0, '-', 'active'),
(123, 2, 7, 0, 'A', 1, 0, '-', 'active'),
(124, 4, 7, 0, 'A', 1, 0, '-', 'active'),
(125, 5, 7, 0, 'A', 1, 0, '-', 'active'),
(126, 5, 7, 0, 'B', 1, 0, '-', 'active'),
(127, 5, 7, 0, 'C', 1, 0, '-', 'active'),
(128, 6, 7, 0, 'A', 1, 0, '-', 'active'),
(129, 6, 7, 0, 'B', 1, 0, '-', 'active'),
(130, 6, 7, 0, 'C', 1, 0, '-', 'active'),
(131, 7, 7, 0, 'A', 1, 0, '-', 'active'),
(132, 7, 7, 0, 'C', 1, 0, '-', 'active'),
(133, 7, 7, 0, 'B', 1, 0, '-', 'active'),
(134, 2, 8, 1, 'A', 1, 0, '-', 'active'),
(135, 1, 8, 1, 'A', 1, 0, '-', 'active'),
(136, 4, 8, 1, 'A', 1, 0, '-', 'active'),
(137, 5, 8, 1, 'A', 0, 5000, '-', 'active'),
(138, 5, 8, 1, 'B', 0, 3000, '-', 'active'),
(139, 5, 8, 1, 'C', 0, 2000, '-', 'active'),
(140, 6, 8, 1, 'A', 0, 1250, '-', 'active'),
(141, 6, 8, 1, 'B', 0, 750, '-', 'active'),
(142, 1, 10, 1, 'A', 1, 0, '-', 'active'),
(143, 6, 8, 1, 'C', 0, 750, '-', 'active'),
(144, 7, 8, 1, 'A', 1, 0, '-', 'active'),
(145, 7, 8, 1, 'B', 1, 0, '-', 'active'),
(146, 7, 8, 1, 'C', 1, 0, '-', 'active'),
(147, 2, 10, 1, 'A', 1, 0, '-', 'active'),
(148, 4, 10, 1, 'A', 1, 0, '-', 'active'),
(149, 5, 10, 1, 'A', 0, 3500, '-', 'active'),
(150, 5, 10, 1, 'B', 0, 2000, '-', 'active'),
(151, 5, 10, 1, 'C', 0, 1350, '-', 'active'),
(152, 6, 10, 1, 'A', 0, 1000, '-', 'active'),
(153, 6, 10, 1, 'B', 0, 600, '-', 'active'),
(154, 6, 10, 1, 'C', 0, 500, '-', 'active'),
(155, 7, 10, 1, 'A', 1, 0, '-', 'active'),
(156, 7, 10, 1, 'B', 1, 0, '-', 'active'),
(157, 7, 10, 1, 'C', 1, 0, '-', 'active'),
(158, 1, 11, 1, 'A', 1, 0, '-', 'active'),
(159, 2, 11, 1, 'A', 1, 0, '-', 'active'),
(160, 4, 11, 1, 'A', 1, 0, '-', 'active'),
(161, 5, 11, 1, 'A', 0, 3000, '-', 'active'),
(162, 5, 11, 1, 'B', 0, 1750, '-', 'active'),
(163, 5, 11, 1, 'C', 0, 1200, '-', 'active'),
(164, 6, 11, 1, 'A', 0, 600, '-', 'active'),
(165, 6, 11, 1, 'B', 0, 500, '-', 'active'),
(166, 6, 11, 1, 'C', 0, 400, '-', 'active'),
(167, 7, 11, 1, 'A', 1, 0, '-', 'active'),
(168, 7, 11, 1, 'B', 1, 0, '-', 'active'),
(169, 7, 11, 1, 'C', 1, 0, '-', 'active'),
(170, 1, 12, 1, 'A', 1, 0, '-', 'active'),
(171, 2, 12, 1, 'A', 1, 0, '-', 'active'),
(172, 4, 12, 1, 'A', 1, 0, '-', 'active'),
(173, 5, 12, 1, 'A', 0, 2750, '-', 'active'),
(174, 5, 12, 1, 'B', 0, 1500, '-', 'active'),
(175, 5, 12, 1, 'C', 0, 1000, '-', 'active'),
(176, 6, 12, 1, 'A', 0, 500, '-', 'active'),
(177, 6, 12, 1, 'B', 0, 500, '-', 'active'),
(178, 6, 12, 1, 'C', 0, 400, '-', 'active'),
(179, 7, 12, 1, 'A', 1, 0, '-', 'active'),
(180, 7, 12, 1, 'B', 1, 0, '-', 'active'),
(181, 7, 12, 1, 'C', 1, 0, '-', 'active'),
(182, 1, 13, 1, 'A', 1, 0, '-', 'active'),
(183, 2, 13, 1, 'A', 1, 0, '-', 'active'),
(184, 4, 13, 1, 'A', 1, 0, '-', 'active'),
(185, 5, 13, 1, 'A', 0, 2500, '-', 'active'),
(186, 5, 13, 1, 'B', 0, 1350, '-', 'active'),
(187, 5, 13, 1, 'C', 0, 850, '-', 'active'),
(188, 6, 13, 1, 'A', 0, 500, '-', 'active'),
(189, 6, 13, 1, 'B', 0, 400, '-', 'active'),
(190, 6, 13, 1, 'C', 0, 300, '-', 'active'),
(191, 7, 13, 1, 'A', 1, 0, '-', 'active'),
(192, 7, 13, 1, 'B', 1, 0, '-', 'active'),
(193, 7, 13, 1, 'C', 1, 0, '-', 'active'),
(194, 1, 14, 1, 'A', 1, 0, '-', 'active'),
(195, 2, 14, 1, 'A', 1, 0, '-', 'active'),
(196, 4, 14, 1, 'A', 1, 0, '-', 'active'),
(197, 5, 14, 1, 'A', 0, 2250, '-', 'active'),
(198, 5, 14, 1, 'B', 0, 1250, '-', 'active'),
(199, 5, 14, 1, 'C', 0, 700, '-', 'active'),
(200, 6, 14, 1, 'A', 0, 500, '-', 'active'),
(201, 6, 14, 1, 'B', 0, 400, '-', 'active'),
(202, 6, 14, 1, 'C', 0, 300, '-', 'active'),
(203, 7, 14, 1, 'A', 1, 0, '-', 'active'),
(204, 7, 14, 1, 'B', 1, 0, '-', 'active'),
(205, 7, 14, 1, 'C', 1, 0, '-', 'active'),
(206, 2, 15, 1, 'B', 1, 0, '-', 'active'),
(207, 2, 15, 1, 'C', 1, 0, '-', 'active'),
(208, 1, 15, 1, 'B', 1, 0, '-', 'active'),
(209, 1, 15, 1, 'C', 1, 0, '-', 'active'),
(210, 4, 15, 1, 'B', 1, 0, '-', 'active'),
(211, 4, 15, 1, 'C', 1, 0, '-', 'active'),
(212, 2, 16, 1, 'B', 1, 0, '-', 'active'),
(213, 2, 16, 1, 'C', 1, 0, '-', 'active'),
(214, 1, 16, 1, 'B', 1, 0, '-', 'active'),
(215, 1, 16, 1, 'C', 1, 0, '-', 'active'),
(216, 4, 16, 1, 'B', 1, 0, '-', 'active'),
(217, 4, 16, 1, 'C', 1, 0, '-', 'active'),
(218, 1, 17, 1, 'B', 1, 0, '-', 'active'),
(219, 1, 17, 1, 'C', 1, 0, '-', 'active'),
(220, 2, 17, 1, 'B', 1, 0, '-', 'active'),
(221, 2, 17, 1, 'C', 1, 0, '-', 'active'),
(222, 4, 17, 1, 'B', 1, 0, '-', 'active'),
(223, 4, 17, 1, 'C', 1, 0, '-', 'active'),
(224, 1, 22, 1, 'B', 1, 0, '-', 'active'),
(225, 1, 22, 1, 'C', 1, 0, '-', 'active'),
(226, 2, 22, 1, 'B', 1, 0, '-', 'active'),
(227, 2, 22, 1, 'C', 1, 0, '-', 'active'),
(228, 4, 22, 1, 'B', 1, 0, '-', 'active'),
(229, 4, 22, 1, 'C', 1, 0, '-', 'active'),
(230, 1, 19, 1, 'B', 1, 0, '-', 'active'),
(231, 1, 19, 1, 'C', 1, 0, '-', 'active'),
(232, 2, 19, 1, 'B', 1, 0, '-', 'active'),
(233, 2, 19, 1, 'C', 1, 0, '-', 'active'),
(234, 4, 19, 1, 'B', 1, 0, '-', 'active'),
(235, 4, 19, 1, 'C', 1, 0, '-', 'active'),
(236, 1, 20, 1, 'C', 1, 0, '-', 'active'),
(237, 2, 20, 1, 'B', 1, 0, '-', 'active'),
(238, 2, 20, 1, 'C', 1, 0, '-', 'active'),
(239, 4, 20, 1, 'C', 1, 0, '-', 'active'),
(240, 4, 20, 1, 'B', 1, 0, '-', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `travel_reasons`
--

CREATE TABLE `travel_reasons` (
  `id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `hangout_suggestion` text NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_reasons`
--

INSERT INTO `travel_reasons` (`id`, `reason`, `hangout_suggestion`, `status`) VALUES
(1, 'Department Meet', 'No', 'active'),
(2, 'SLT Meeting', 'No', 'active'),
(3, 'ULT Meeting', 'No', 'active'),
(4, 'Training', 'No', 'active'),
(5, 'Bureau Visit', 'No', 'active'),
(6, 'Production Meet', 'Yes', 'active'),
(7, 'State Visit', 'No', 'active'),
(8, 'Center Visit', 'No', 'active'),
(9, 'Internal Meet', 'No', 'active'),
(10, 'Client Meet', 'No', 'active'),
(11, 'Project', 'No', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `travel_rejected_reasons`
--

CREATE TABLE `travel_rejected_reasons` (
  `id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `hangout_suggestion` text NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_rejected_reasons`
--

INSERT INTO `travel_rejected_reasons` (`id`, `reason`, `hangout_suggestion`, `status`) VALUES
(1, 'Byond Travel Date', 'No', 'active'),
(2, 'Budget Not Approved', 'Yes', 'active'),
(3, 'Travel Plan Changed', 'No', 'active'),
(4, 'Ticket is not Available', 'No', 'active'),
(5, 'Do the work thru Hangouts', 'Yes', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `travel_request`
--

CREATE TABLE `travel_request` (
  `id` int(11) NOT NULL,
  `reference_id` varchar(30) NOT NULL,
  `request_number` varchar(15) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `group_travel` int(11) NOT NULL,
  `travel_type` enum('1','2','3','4','5') NOT NULL COMMENT '1 Flight,2 Train,3 Car,4 Bus,5 Hotel',
  `departure_date` datetime NOT NULL,
  `return_date` datetime DEFAULT NULL,
  `request_date` date NOT NULL,
  `approval_level` int(11) DEFAULT NULL,
  `reporting_manager_id` int(11) NOT NULL,
  `travel_reason_id` int(11) NOT NULL,
  `travel_class_id` int(11) NOT NULL,
  `from_city_id` int(11) NOT NULL,
  `to_city_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `hotel_allowance` int(11) NOT NULL,
  `hotel_allowance_actual` int(11) NOT NULL,
  `DA_allowance` int(11) NOT NULL,
  `DA_allowance_actual` int(11) NOT NULL,
  `convince_allowance` int(11) NOT NULL,
  `convince_allowance_actual` int(11) NOT NULL,
  `trip_ticket` int(11) DEFAULT NULL,
  `hotel_booking` int(11) DEFAULT NULL,
  `car_booking` int(11) DEFAULT NULL,
  `approval_status` enum('Pending','Approved','Rejected') NOT NULL,
  `approve_comment` text,
  `reject_reason` int(11) DEFAULT NULL,
  `approval_datetime` datetime DEFAULT NULL,
  `cancel_status` enum('0','1','2') NOT NULL,
  `refund_amount` int(11) NOT NULL,
  `cancellation_comment` text NOT NULL,
  `request_status` enum('1','2','3','4','5','6','7') NOT NULL,
  `status` enum('active','inactive','draft','cancel') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travel_request_member`
--

CREATE TABLE `travel_request_member` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `email` varchar(30) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(11) NOT NULL,
  `employee_id` varchar(11) DEFAULT NULL,
  `reset_token` varchar(50) NOT NULL,
  `reset_request_time` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `check_status` varchar(255) NOT NULL DEFAULT 'out'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `email`, `last_name`, `username`, `password`, `is_active`, `type`, `employee_id`, `reset_token`, `reset_request_time`, `last_login`, `check_status`) VALUES
(49, 'Padmin', 'puneetdiwedi19@gmail.com', 'admin', 'padmin', '$2y$10$2GOR0fdnXquZptx3hkEzZOK1GuaFE7QqJ/aCYj3FgI6vtYC4JkXT.', 1, 'admin', '8', '', '0000-00-00 00:00:00', '2017-07-27 16:09:11', 'out'),
(100, 'Jafarali', 'maknojiya440@gmail.com', 'Maknojiya', 'maknojiya440', '$2y$10$tNJ56VRlCIRMRgCcsptsGuywuPBKfHyhC9BrZHgWclGd0FOwciLfK', 1, 'employee', '4', '', '0000-00-00 00:00:00', '2017-07-27 21:32:37', 'out'),
(101, 'Abhishek', 'abhishek.kumar@dbcorp.in', 'Sharma', 'abhkum3', '$2y$10$DHIQ8tYdmlskaUu7hGEwGeFeYrSqfBsCES.9NYcDE3unBPu1l8qWW', 1, 'employee', '5', '', '0000-00-00 00:00:00', '2017-07-27 21:35:57', 'out'),
(102, 'Shivendra', 's_shivendra@dbcorp.in', 'Sharma', 'shisha8', '$2y$10$lPGJXSPtexQH3rCEySFYJ.tAT.UBHvzbnybA.Lk60WUwnHcKsRV2O', 1, 'employee', '6', '', '0000-00-00 00:00:00', '2017-07-27 16:47:39', 'out'),
(103, 'RD', 'rd_bhatnagar@dbcorp.in', 'Bhatnagar', 'RDBHAT', '$2y$10$HbSCfEOUTjGD8XsyPDR8a.yTMi3dGpe0lQLz/IxHO6IgCxIi6JlS6', 1, 'employee', '7', '', '0000-00-00 00:00:00', '2017-07-20 12:54:29', 'out'),
(104, 'Abhay', 'abhay.singh1@dbcorp.in', 'Singh', 'abhsin18', '$2y$10$lj5OgGc5.//b807t6paz/e9q6BFA32cAWvUqLJNXyDOR17Nex7y.O', 1, 'employee', '9', '', '0000-00-00 00:00:00', '2017-07-27 16:08:35', 'out');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget_history`
--
ALTER TABLE `budget_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_category`
--
ALTER TABLE `bus_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_ticket_booking`
--
ALTER TABLE `bus_ticket_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_booking`
--
ALTER TABLE `car_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_category`
--
ALTER TABLE `car_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_ticket_booking`
--
ALTER TABLE `car_ticket_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cost_center`
--
ALTER TABLE `cost_center`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `employees_role`
--
ALTER TABLE `employees_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employment_request_form`
--
ALTER TABLE `employment_request_form`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flight_category`
--
ALTER TABLE `flight_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flight_ticket_booking`
--
ALTER TABLE `flight_ticket_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel_booking`
--
ALTER TABLE `hotel_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel_category`
--
ALTER TABLE `hotel_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `indian_cities`
--
ALTER TABLE `indian_cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_FI_1` (`menu_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_menu`
--
ALTER TABLE `roles_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_booking_request`
--
ALTER TABLE `room_booking_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `send_mail`
--
ALTER TABLE `send_mail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_proviers`
--
ALTER TABLE `service_proviers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `train_category`
--
ALTER TABLE `train_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `train_ticket_booking`
--
ALTER TABLE `train_ticket_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travel_booking`
--
ALTER TABLE `travel_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travel_category`
--
ALTER TABLE `travel_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travel_expenses`
--
ALTER TABLE `travel_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travel_policy`
--
ALTER TABLE `travel_policy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travel_reasons`
--
ALTER TABLE `travel_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travel_rejected_reasons`
--
ALTER TABLE `travel_rejected_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travel_request`
--
ALTER TABLE `travel_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travel_request_member`
--
ALTER TABLE `travel_request_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `budget_history`
--
ALTER TABLE `budget_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `bus_category`
--
ALTER TABLE `bus_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bus_ticket_booking`
--
ALTER TABLE `bus_ticket_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `car_booking`
--
ALTER TABLE `car_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `car_category`
--
ALTER TABLE `car_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `car_ticket_booking`
--
ALTER TABLE `car_ticket_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cost_center`
--
ALTER TABLE `cost_center`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `employees_role`
--
ALTER TABLE `employees_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;
--
-- AUTO_INCREMENT for table `employment_request_form`
--
ALTER TABLE `employment_request_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `flight_category`
--
ALTER TABLE `flight_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `flight_ticket_booking`
--
ALTER TABLE `flight_ticket_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `hotel_booking`
--
ALTER TABLE `hotel_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `hotel_category`
--
ALTER TABLE `hotel_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `indian_cities`
--
ALTER TABLE `indian_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=320;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `roles_menu`
--
ALTER TABLE `roles_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;
--
-- AUTO_INCREMENT for table `room_booking_request`
--
ALTER TABLE `room_booking_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `send_mail`
--
ALTER TABLE `send_mail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39290;
--
-- AUTO_INCREMENT for table `service_proviers`
--
ALTER TABLE `service_proviers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `train_category`
--
ALTER TABLE `train_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `train_ticket_booking`
--
ALTER TABLE `train_ticket_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `travel_booking`
--
ALTER TABLE `travel_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `travel_category`
--
ALTER TABLE `travel_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `travel_expenses`
--
ALTER TABLE `travel_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `travel_policy`
--
ALTER TABLE `travel_policy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;
--
-- AUTO_INCREMENT for table `travel_reasons`
--
ALTER TABLE `travel_reasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `travel_rejected_reasons`
--
ALTER TABLE `travel_rejected_reasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `travel_request`
--
ALTER TABLE `travel_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `travel_request_member`
--
ALTER TABLE `travel_request_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
