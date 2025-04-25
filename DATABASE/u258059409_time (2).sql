-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 25, 2025 at 06:48 AM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u258059409_time`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `created_at`) VALUES
(6, 'ICCC', 'Ashfield', '2025-01-25 09:52:53'),
(7, 'White Spot Group', 'Factory A/6 Voyager Cct,, Glendenning, 2761', '2025-01-25 09:53:08'),
(9, 'Rotana', 'Ashfield', '2025-01-25 09:53:34'),
(10, 'Clean Space Labour', 'Ashfield', '2025-01-25 09:54:46'),
(11, 'Stride', 'Parramatta', '2025-01-25 10:01:43'),
(13, 'Killara Services', 'Po Box 62, Abbotsford, 3067', '2025-01-25 23:30:51'),
(14, 'NJK Assets', 'PO BOX 442, ASHFIELD NSW 2045, 2045', '2025-01-25 23:31:06'),
(15, 'Renac Pty Limited', '11 Mcguire Cres, BARDIA, NSW, 2565', '2025-01-25 23:31:25'),
(16, 'Squeeky Group', 'CG01/27 – 29 George St, North Strathfield, 2137', '2025-01-25 23:31:48'),
(17, 'TERRA GRANDIS PTY LTD', '29 Easton Ave, Sylvania, 2224', '2025-01-25 23:32:07'),
(18, 'Jonathan (Domestic)', '9 Sherridion Cr, Quakers hill\r\njonathan_dsouza@hotmail.com', '2025-01-26 22:44:14'),
(19, 'Internal Transact', 'Auburn', '2025-01-27 06:27:25'),
(21, 'V&V Trades & Facility Management Pty Ltd', '6 Davenport Crescent, Cranbourne West VIC 3977', '2025-02-24 10:40:35'),
(22, 'Kalyan Dai', 'Kalyan dai ', '2025-02-24 11:39:50');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `pay_rate` decimal(10,2) DEFAULT NULL,
  `bank_details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `phone`, `email`, `address`, `pay_rate`, `bank_details`, `created_at`) VALUES
(5, 'Mandip ', '+61 424 687 205', 'mandeepniraula@gmail.com', NULL, 20.00, 'PAYID +61 424 687 205', '2025-01-25 09:56:51'),
(6, 'Divya', '+61 424 935 554', 'divyaemail@gmail.com', NULL, 22.00, 'PayId- +61 424 935 554	', '2025-01-25 09:58:56'),
(7, 'Subhadra', '0452 509 981', 'subhadraemail@gmail.com', NULL, 22.00, 'PayId- 0452 509 981', '2025-01-25 10:01:13'),
(8, 'Mahendra', '0452464449', 'mahendraemail@gmail.com', NULL, 20.00, 'BSB: 065 006   AC: 10219393', '2025-01-25 12:25:58'),
(9, 'Himal', '0416651583', 'himalemail@gmail.com', NULL, 20.00, 'BSB: 062319  ACC: 10911442', '2025-01-25 12:27:01'),
(10, 'Laxmi', '0416299383', 'laxmiemail@gmail.com', NULL, 22.00, 'BSB: 062018  ACC: 10477397', '2025-01-25 12:27:28'),
(11, 'Prajwal', '0426794969', 'Prajwalemail@gmail.com', NULL, 22.00, 'Pay ID: 0426794969', '2025-01-25 12:28:01'),
(12, 'Bijay', '0406 687 126', 'Bijayemail@gmail.com', NULL, 20.00, 'BSB: 062-948  ACC: 29995536', '2025-01-25 12:29:51'),
(14, 'Anush', '0450 628 595', 'Anushemail@gmail.com', NULL, 25.00, 'Sarmila Rai (PAYID- 0451069815)', '2025-01-25 12:31:50'),
(15, 'Puru', '0416498220', 'puruemail@gmail.com', NULL, 22.00, '000 000 000 0000', '2025-01-25 12:32:45'),
(16, 'Ashif', '0406737269', 'ashifemail@gmail.com', NULL, 20.00, 'PAYID-0406 737 269', '2025-01-25 12:34:34'),
(20, 'Aakash Dangi', '0404 326 891', 'aakashemail@gmail.com', NULL, 22.00, 'BSB : 062107  ACC: 11435700', '2025-01-26 07:35:44'),
(21, 'Keju Maharjan', '0490088924', 'Kejuemail@gmail.com', NULL, 23.00, 'BSB: 112879 ACC: 079799521', '2025-01-26 07:49:52'),
(22, 'Babin', '0410787377', 'babinemail@gmail.com', NULL, 22.00, 'Pay ID: 0410787377', '2025-01-26 22:45:24'),
(23, 'Sujit', '0449933740', 'sujitemail@gmail.com', NULL, 22.00, 'Pay Id: 0449933740', '2025-01-26 22:58:51'),
(24, 'Bias', '0411318101', 'biasemail@gmail.com', NULL, 22.00, 'Pay Id: 0411318101', '2025-01-26 23:00:57'),
(25, 'Sumesh Basnet', '0410 157 123', 'sumesh@smartserve.au', NULL, 28.00, 'BSB :     ACC :', '2025-01-26 23:04:33'),
(26, 'Nirajan Ghimirey', '0405828550', 'nirajanghimirey@gmail.com', NULL, 28.00, 'BSB     ACC', '2025-01-26 23:06:49'),
(27, 'Binod Raut', '0426 243 250', 'binod@smartserve.au', NULL, 28.00, 'BSB: 012406   ACC: 472763305', '2025-01-26 23:07:41'),
(28, 'Kritika Shakya', '0450768931', 'shakyakritika1234@gmail.com', NULL, 23.00, 'PAYID- 0450768931', '2025-01-26 23:38:38'),
(29, 'Niraj Thing', '0432156008', 'nirajthing@gmail.com', NULL, 22.00, 'Pay Id: 0432156008', '2025-01-27 07:01:26'),
(30, 'Sange', '0410 280 416', 'sangeemail@gmail.com', NULL, 25.00, 'Pay Id: 0410 280 416 ', '2025-01-27 07:21:15'),
(31, 'Anand Thakur', '0450189452', 'Thakur@vaigmail.com', NULL, 22.00, '0450189452', '2025-01-27 11:01:16'),
(32, 'Ronak Tamang', '0433810194', 'Ronak.3@gmal.com', NULL, 23.00, 'Pay Id: 0433810194', '2025-01-27 11:18:16'),
(33, 'Bishal Sherestha ', '+61 424 750 450', 'bishals@gmail.com', NULL, 30.00, 'Pay ID: +61 424 750 450', '2025-01-30 04:49:57'),
(34, 'Sudip Rai', '000 00', 'sudip@raigmail.com', NULL, 20.00, 'BSB:      Acc: ', '2025-01-30 05:01:52'),
(35, 'Ishowr Rajbanshi', '0423446129', 'ishworr@gmail.com', NULL, 22.00, 'Pay Id: 0423446129', '2025-01-30 05:06:54'),
(36, 'Sneha Manandar', '0404380233', 'manandarsneha1@gmail.com', NULL, 20.00, '0404380233', '2025-01-31 01:36:11'),
(37, 'Aasa Dhakal', '0415779845', 'Ashadhakal224@gmail.com', NULL, 20.00, '0415779845', '2025-01-31 01:37:21'),
(38, 'Pratik Khanal', '0452598483', 'khanalpratik5@gmail.com', NULL, 23.00, 'BSB :  ACC :', '2025-02-12 09:29:45'),
(39, 'Raju Dhungel', '401277664', 'raju@gmail.com', NULL, 20.00, 'PAYID  401277664', '2025-02-12 12:12:45'),
(40, 'Basanta Kandel', '0468678221', 'kandel2063s@gmail.com', NULL, 22.00, 'kandel2063s@gmail.com', '2025-02-19 07:08:28'),
(41, 'Sameer Kc', '+61415110705', 'Sameer@gmail.com', NULL, 25.00, 'PayId: 0415110705', '2025-02-24 10:27:54'),
(42, 'Sulav Rijal', '0452143949', 'sulav@gmail.com', NULL, 22.00, 'Pay Id: 0452143949', '2025-02-24 11:37:12'),
(43, 'Jahid', '0412874423', 'Jahid@gmail.com', NULL, 22.00, 'Pay Id: 0412874423', '2025-02-24 11:45:00'),
(44, 'Md Nader Nehal Samin', '0426981083', 'nadernehalsamin@gmail.com', NULL, 25.00, 'Pay Id: 0426981083', '2025-02-25 10:02:37'),
(45, 'Mohit Bhandari', '0426675357', 'mohitbhandari551@gmail.com', NULL, 22.00, 'Bsb acc', '2025-02-27 11:10:11');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_runs`
--

CREATE TABLE `payroll_runs` (
  `id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `generated_at` timestamp NULL DEFAULT current_timestamp(),
  `total_amount` decimal(15,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `finalized` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payroll_runs`
--

INSERT INTO `payroll_runs` (`id`, `start_date`, `end_date`, `generated_at`, `total_amount`, `notes`, `finalized`) VALUES
(43, '0000-00-00', '0000-00-00', '2025-02-12 05:53:52', 8695.00, '\nExcluded Amount: $0.00', 1),
(44, '0000-00-00', '0000-00-00', '2025-02-12 12:49:58', 9360.40, 'draft Payrun\nExcluded Amount: $0.00', 1),
(45, '2025-01-27', '2025-02-09', '2025-02-13 09:06:04', 8899.00, '13 FEB 2025\nExcluded - Nirajan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_run_items`
--

CREATE TABLE `payroll_run_items` (
  `id` int(11) NOT NULL,
  `payroll_run_id` int(11) DEFAULT NULL,
  `timesheet_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payroll_run_items`
--

INSERT INTO `payroll_run_items` (`id`, `payroll_run_id`, `timesheet_id`) VALUES
(609, 43, 135),
(610, 43, 142),
(611, 43, 175),
(612, 43, 176),
(613, 43, 177),
(614, 43, 178),
(615, 43, 179),
(616, 43, 162),
(617, 43, 143),
(618, 43, 144),
(619, 43, 122),
(620, 43, 126),
(621, 43, 127),
(622, 43, 145),
(623, 43, 146),
(624, 43, 147),
(625, 43, 164),
(626, 43, 118),
(627, 43, 119),
(628, 43, 120),
(629, 43, 121),
(630, 43, 134),
(631, 43, 151),
(632, 43, 152),
(633, 43, 153),
(634, 43, 154),
(635, 43, 155),
(636, 43, 156),
(637, 43, 157),
(638, 43, 158),
(639, 43, 159),
(640, 43, 160),
(641, 43, 161),
(642, 43, 163),
(643, 43, 148),
(644, 43, 136),
(645, 43, 149),
(646, 43, 131),
(647, 43, 129),
(648, 43, 117),
(649, 43, 141),
(650, 43, 150),
(651, 43, 180),
(652, 43, 137),
(653, 43, 138),
(654, 43, 139),
(655, 43, 140),
(656, 43, 166),
(658, 43, 168),
(659, 43, 169),
(660, 43, 170),
(661, 43, 171),
(662, 43, 172),
(663, 43, 173),
(664, 43, 174),
(665, 43, 123),
(666, 43, 125),
(667, 43, 130),
(669, 43, 132),
(670, 43, 133),
(671, 44, 182),
(672, 44, 135),
(673, 44, 142),
(674, 44, 175),
(675, 44, 176),
(676, 44, 177),
(677, 44, 178),
(678, 44, 179),
(679, 44, 162),
(680, 44, 143),
(681, 44, 144),
(682, 44, 122),
(683, 44, 126),
(684, 44, 127),
(685, 44, 145),
(686, 44, 146),
(687, 44, 183),
(688, 44, 147),
(689, 44, 164),
(690, 44, 118),
(691, 44, 119),
(692, 44, 120),
(693, 44, 121),
(694, 44, 134),
(695, 44, 151),
(696, 44, 152),
(697, 44, 153),
(698, 44, 154),
(699, 44, 155),
(700, 44, 156),
(701, 44, 157),
(702, 44, 158),
(703, 44, 159),
(704, 44, 160),
(705, 44, 161),
(706, 44, 163),
(707, 44, 148),
(708, 44, 136),
(709, 44, 149),
(710, 44, 131),
(711, 44, 129),
(712, 44, 117),
(713, 44, 141),
(714, 44, 150),
(715, 44, 180),
(716, 44, 137),
(717, 44, 138),
(718, 44, 139),
(719, 44, 140),
(720, 44, 166),
(722, 44, 168),
(723, 44, 169),
(724, 44, 170),
(725, 44, 171),
(726, 44, 172),
(727, 44, 173),
(728, 44, 174),
(729, 44, 123),
(730, 44, 125),
(731, 44, 130),
(732, 44, 132),
(733, 44, 133),
(734, 44, 181),
(735, 45, 182),
(736, 45, 135),
(737, 45, 142),
(738, 45, 175),
(739, 45, 176),
(740, 45, 177),
(741, 45, 178),
(742, 45, 179),
(743, 45, 162),
(744, 45, 143),
(745, 45, 144),
(746, 45, 122),
(747, 45, 126),
(748, 45, 127),
(749, 45, 145),
(750, 45, 146),
(751, 45, 183),
(752, 45, 147),
(753, 45, 164),
(754, 45, 118),
(755, 45, 119),
(756, 45, 120),
(757, 45, 121),
(758, 45, 134),
(759, 45, 151),
(760, 45, 152),
(761, 45, 153),
(762, 45, 154),
(763, 45, 155),
(764, 45, 156),
(765, 45, 157),
(766, 45, 158),
(767, 45, 159),
(768, 45, 160),
(769, 45, 161),
(770, 45, 163),
(771, 45, 148),
(772, 45, 136),
(773, 45, 149),
(774, 45, 131),
(775, 45, 129),
(776, 45, 117),
(777, 45, 137),
(778, 45, 138),
(779, 45, 139),
(780, 45, 140),
(781, 45, 166),
(782, 45, 168),
(783, 45, 169),
(784, 45, 170),
(785, 45, 171),
(786, 45, 172),
(787, 45, 173),
(788, 45, 174),
(789, 45, 123),
(790, 45, 125),
(791, 45, 130),
(792, 45, 132),
(793, 45, 133),
(794, 45, 181);

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

CREATE TABLE `timesheets` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `worksite_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `hours` decimal(10,2) DEFAULT NULL,
  `paid` tinyint(1) NOT NULL,
  `remarks` varchar(245) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timesheets`
--

INSERT INTO `timesheets` (`id`, `employee_id`, `worksite_id`, `date`, `hours`, `paid`, `remarks`) VALUES
(11, 20, 10, '2025-01-21', 3.00, 1, ''),
(12, 20, 10, '2025-01-24', 3.00, 1, ''),
(13, 20, 10, '2025-01-17', 3.00, 1, ''),
(14, 20, 10, '2025-01-14', 3.00, 1, ''),
(15, 14, 28, '2025-01-13', 2.00, 1, ''),
(16, 14, 28, '2025-01-20', 2.00, 1, ''),
(17, 6, 5, '2025-01-14', 4.00, 1, ''),
(19, 6, 5, '2025-01-19', 4.00, 1, ''),
(20, 6, 5, '2025-01-21', 4.00, 1, ''),
(22, 6, 5, '2025-01-26', 4.00, 1, ''),
(23, 21, 29, '2025-01-14', 2.50, 1, ''),
(24, 21, 29, '2025-01-17', 2.50, 1, ''),
(25, 21, 29, '2025-01-21', 2.50, 1, ''),
(26, 21, 29, '2025-01-24', 2.50, 1, ''),
(27, 16, 30, '2025-01-15', 2.50, 1, ''),
(28, 16, 30, '2025-01-16', 2.50, 1, ''),
(29, 16, 30, '2025-01-24', 2.50, 1, ''),
(30, 14, 19, '2025-01-15', 2.00, 1, ''),
(31, 14, 19, '2025-01-23', 2.00, 1, ''),
(32, 11, 17, '2025-01-14', 3.00, 1, ''),
(33, 11, 17, '2025-01-15', 1.50, 1, ''),
(34, 11, 17, '2025-01-21', 3.00, 1, ''),
(35, 11, 17, '2025-01-22', 1.50, 1, ''),
(36, 10, 15, '2025-01-26', 30.00, 1, ''),
(37, 10, 16, '2025-01-26', 1.00, 1, ''),
(38, 9, 14, '2025-01-26', 31.00, 1, ''),
(39, 12, 14, '2025-01-26', 45.00, 1, ''),
(40, 11, 12, '2025-01-19', 2.00, 1, ''),
(41, 11, 12, '2025-01-26', 2.00, 1, ''),
(42, 11, 6, '2025-01-19', 4.00, 1, ''),
(43, 11, 6, '2025-01-26', 2.00, 1, ''),
(45, 14, 32, '2025-01-13', 10.00, 1, ''),
(46, 14, 33, '2025-01-15', 3.00, 1, ''),
(47, 14, 34, '2025-01-15', 5.00, 1, ''),
(48, 14, 35, '2025-01-16', 8.00, 1, ''),
(49, 14, 40, '2025-01-17', 3.00, 1, ''),
(50, 14, 38, '2025-01-18', 5.00, 1, ''),
(51, 14, 36, '2025-01-20', 3.00, 1, ''),
(52, 14, 39, '2025-01-22', 8.00, 1, ''),
(53, 14, 37, '2025-01-23', 3.00, 1, ''),
(54, 14, 31, '2025-01-24', 3.00, 1, ''),
(55, 14, 41, '2025-01-25', 4.00, 1, ''),
(56, 22, 39, '2025-01-22', 8.00, 1, ''),
(57, 22, 42, '2025-01-25', 3.00, 1, ''),
(58, 22, 44, '2025-01-25', 3.45, 1, ''),
(59, 12, 33, '2025-01-15', 3.00, 1, ''),
(60, 23, 33, '2025-01-15', 3.00, 1, ''),
(61, 23, 43, '2025-01-15', 6.28, 1, ''),
(62, 24, 43, '2025-01-17', 4.00, 1, ''),
(63, 6, 45, '2025-01-23', 2.00, 1, ''),
(64, 6, 45, '2025-01-20', 2.00, 1, ''),
(65, 6, 46, '2025-01-20', 1.00, 1, ''),
(66, 25, 46, '2025-01-20', 2.00, 1, ''),
(67, 25, 47, '2025-01-17', 10.50, 1, ''),
(68, 26, 47, '2025-01-15', 2.00, 1, ''),
(69, 27, 14, '2024-12-28', 4.00, 1, ''),
(70, 27, 48, '2024-12-30', 11.00, 1, ''),
(71, 27, 6, '2025-01-05', 2.50, 1, ''),
(72, 27, 45, '2025-01-13', 4.00, 1, ''),
(73, 27, 46, '2025-01-13', 2.00, 1, ''),
(74, 27, 46, '2025-01-15', 2.00, 1, ''),
(75, 27, 46, '2025-01-17', 2.00, 1, ''),
(76, 27, 47, '2025-01-15', 2.00, 1, ''),
(77, 27, 46, '2025-01-20', 1.00, 1, ''),
(78, 27, 45, '2025-01-20', 2.00, 1, ''),
(79, 27, 45, '2025-01-23', 2.00, 1, ''),
(80, 9, 44, '2025-01-25', 4.89, 1, ''),
(81, 12, 49, '2025-01-14', 4.50, 1, ''),
(82, 15, 49, '2025-01-14', 4.50, 1, ''),
(84, 12, 50, '2025-01-17', 4.00, 1, ''),
(85, 24, 50, '2025-01-17', 4.00, 1, ''),
(86, 27, 50, '2025-01-17', 5.00, 1, ''),
(87, 23, 20, '2025-01-22', 2.00, 1, ''),
(88, 24, 20, '2025-01-22', 4.00, 1, ''),
(89, 27, 20, '2025-01-22', 2.00, 1, ''),
(90, 27, 51, '2025-01-25', 3.00, 1, ''),
(91, 24, 51, '2025-01-25', 2.00, 1, ''),
(92, 28, 9, '2025-01-24', 3.00, 1, ''),
(93, 23, 52, '2025-01-13', 5.00, 1, ''),
(94, 6, 53, '2025-01-26', 27.50, 1, ''),
(95, 8, 13, '2025-01-26', 42.00, 1, ''),
(96, 11, 53, '2025-01-26', 19.00, 1, ''),
(97, 5, 7, '2025-01-26', 43.52, 1, ''),
(99, 7, 55, '2025-01-26', 31.50, 1, ''),
(100, 16, 30, '2025-01-22', 2.50, 1, ''),
(101, 16, 30, '2025-01-23', 2.50, 1, ''),
(102, 16, 30, '2025-01-24', 2.50, 1, ''),
(103, 29, 47, '2025-01-15', 5.11, 1, ''),
(104, 29, 9, '2025-01-15', 3.00, 1, ''),
(105, 29, 9, '2025-01-20', 3.00, 1, ''),
(106, 20, 53, '2025-01-26', 6.00, 1, ''),
(107, 30, 56, '2025-01-24', 4.00, 1, ''),
(108, 7, 9, '2025-01-13', 3.00, 1, ''),
(109, 12, 7, '2025-01-26', 16.50, 1, ''),
(110, 12, 57, '2025-01-22', 4.00, 1, ''),
(111, 31, 11, '2025-01-26', 18.00, 1, ''),
(112, 31, 58, '2025-01-26', 12.00, 1, ''),
(113, 31, 48, '2025-01-16', 5.50, 1, ''),
(114, 31, 59, '2025-01-18', 6.00, 1, ''),
(115, 15, 7, '2025-01-26', 48.00, 1, ''),
(116, 32, 47, '2025-01-26', 27.00, 1, ''),
(117, 26, 59, '2025-01-28', 1.00, 1, 'Testing remarks'),
(118, 14, 60, '2025-01-29', 5.00, 1, ''),
(119, 14, 19, '2025-01-29', 2.00, 1, ''),
(120, 14, 61, '2025-01-30', 3.00, 1, ''),
(121, 14, 54, '2025-01-30', 1.00, 1, 'North richmond '),
(122, 11, 54, '2025-01-29', 2.00, 1, 'Helped get equipment from the site and worked for 1 hour '),
(123, 33, 60, '2025-01-29', 3.00, 1, 'Start halfway'),
(125, 34, 60, '2025-01-29', 7.00, 1, ''),
(126, 11, 17, '2025-01-28', 3.50, 1, ''),
(127, 11, 17, '2025-01-29', 1.00, 1, ''),
(129, 25, 62, '2025-01-31', 4.00, 1, 'Raneta'),
(130, 34, 63, '2025-01-31', 6.00, 1, ''),
(131, 23, 63, '2025-01-31', 6.00, 1, ''),
(132, 36, 64, '2025-01-31', 5.50, 1, ''),
(133, 37, 64, '2025-01-31', 5.50, 1, ''),
(134, 14, 64, '2025-01-31', 4.50, 1, ''),
(135, 6, 64, '2025-01-31', 4.00, 1, ''),
(136, 20, 10, '2025-01-29', 3.00, 1, ''),
(137, 28, 9, '2025-01-27', 3.00, 1, ''),
(138, 28, 9, '2025-01-30', 3.00, 1, ''),
(139, 28, 9, '2025-02-03', 3.00, 1, ''),
(140, 28, 55, '2025-02-03', 2.50, 1, ''),
(141, 26, 10, '2025-02-01', 3.00, 0, ''),
(142, 6, 5, '2025-02-09', 16.00, 1, ''),
(143, 9, 14, '2025-02-09', 27.00, 1, ''),
(144, 9, 13, '2025-02-09', 1.00, 1, ''),
(145, 11, 6, '2025-02-09', 4.00, 1, ''),
(146, 11, 17, '2025-02-09', 9.00, 1, ''),
(147, 12, 14, '2025-02-09', 40.50, 1, ''),
(148, 16, 30, '2025-02-09', 15.00, 1, ''),
(149, 21, 29, '2025-02-09', 10.00, 1, ''),
(150, 26, 10, '2025-02-05', 3.00, 0, 'Testing remarks'),
(151, 14, 66, '2025-01-28', 5.00, 1, ''),
(152, 14, 28, '2025-01-28', 2.00, 1, ''),
(153, 14, 67, '2025-02-03', 5.00, 1, ''),
(154, 14, 28, '2025-02-03', 2.00, 1, ''),
(155, 14, 19, '2025-02-05', 2.00, 1, ''),
(156, 14, 68, '2025-02-05', 3.00, 1, ''),
(157, 14, 58, '2025-02-05', 3.48, 1, '12$ fuel '),
(158, 14, 68, '2025-02-07', 3.00, 1, 'Bronte Rd, Waverly'),
(159, 14, 68, '2025-02-07', 3.00, 1, 'Debria Av, Zetland '),
(160, 14, 58, '2025-02-08', 3.00, 1, ''),
(161, 14, 69, '2025-02-08', 5.00, 1, 'Raneta'),
(162, 8, 13, '2025-02-08', 39.00, 1, '27/01-08/02'),
(163, 15, 7, '2025-02-08', 41.00, 1, '27/01-08/02'),
(164, 12, 7, '2025-02-08', 11.00, 1, ''),
(166, 28, 9, '2025-01-30', 3.00, 1, ''),
(168, 28, 9, '2025-02-06', 3.00, 1, ''),
(169, 28, 11, '2025-02-04', 2.50, 1, ''),
(170, 28, 11, '2025-02-07', 2.50, 1, ''),
(171, 28, 55, '2025-02-04', 2.50, 1, ''),
(172, 28, 55, '2025-02-05', 5.50, 1, 'vermeer , interior and dynamic'),
(173, 28, 55, '2025-02-06', 2.50, 1, ''),
(174, 28, 55, '2025-02-07', 5.50, 1, 'vermeer , interior and dynamic'),
(175, 7, 55, '2025-01-27', 2.50, 1, ''),
(176, 7, 55, '2025-01-28', 2.50, 1, ''),
(177, 7, 55, '2025-01-29', 5.50, 1, 'vermeer , interior and dynamic'),
(178, 7, 55, '2025-01-30', 2.50, 1, ''),
(179, 7, 55, '2025-01-31', 5.50, 1, 'vermeer , interior and dynamic'),
(180, 26, 10, '2025-02-07', 3.00, 0, ''),
(181, 39, 60, '2025-01-29', 4.00, 1, ''),
(182, 5, 7, '2025-02-09', 34.02, 1, 'From 27 Jan to 9 Feb, deducting tax amt 249.80'),
(183, 11, 60, '2025-01-29', 3.00, 1, 'Petersham and Equipment pickup on Fire station Ryde'),
(184, 26, 58, '2025-02-15', 3.00, 0, ''),
(186, 40, 58, '2025-02-19', 3.00, 0, ''),
(187, 40, 58, '2025-02-22', 3.00, 0, ''),
(188, 6, 5, '2025-02-23', 16.00, 0, 'all 4 shifts'),
(189, 21, 29, '2025-02-23', 10.00, 0, 'all 4 shifts'),
(192, 11, 6, '2025-02-23', 4.00, 0, 'both shifts'),
(193, 16, 30, '2025-02-23', 15.00, 0, 'all 6 shifts'),
(195, 32, 67, '2025-02-23', 4.00, 0, 'Spring Cleaning'),
(196, 5, 7, '2025-02-11', 35.52, 0, 'Deducted Tax'),
(197, 15, 7, '2025-02-23', 45.00, 0, 'as submitted'),
(198, 8, 13, '2025-02-23', 42.85, 0, 'all shifts from 10-23 feb added 45 min'),
(199, 10, 16, '2025-02-23', 62.00, 0, 'missed hours plus 10-23 feb FE'),
(200, 33, 53, '2025-02-23', 1.00, 0, 'missed amt 30$'),
(201, 34, 53, '2025-02-23', 3.00, 0, 'miss payment 3 hrs adjusted'),
(202, 12, 7, '2025-02-23', 5.50, 0, ''),
(203, 12, 13, '2025-02-23', 45.00, 0, 'all shifts accounted'),
(204, 39, 53, '2025-02-23', 4.00, 0, 'Petersham Spring Cleaning missed from previous'),
(205, 11, 17, '2025-02-23', 9.00, 0, 'both shifts'),
(206, 41, 59, '2025-02-20', 32.00, 0, 'Three days in a row 19/02-21/02'),
(207, 41, 67, '2025-02-22', 14.00, 0, '4 jobs completed '),
(208, 11, 70, '2025-02-17', 4.00, 0, 'EOL auburn'),
(209, 11, 71, '2025-02-21', 4.00, 0, 'Two different site down '),
(210, 25, 71, '2025-02-20', 4.00, 0, 'Two diff site'),
(211, 11, 68, '2025-02-17', 2.00, 0, 'On our cost '),
(212, 7, 9, '2025-02-09', 5.50, 0, 'Last payment mistake'),
(214, 27, 28, '2025-02-09', 1.00, 0, 'Last miss payment'),
(215, 27, 19, '2025-02-12', 2.00, 0, ''),
(216, 27, 70, '2025-02-12', 2.00, 0, 'Last payment miss EOL City'),
(217, 27, 67, '2025-02-12', 3.00, 0, 'Last payment miss Firestation '),
(218, 27, 68, '2025-02-18', 3.00, 0, ''),
(219, 27, 30, '2025-02-11', 2.50, 0, ''),
(220, 32, 47, '2025-02-10', 3.27, 0, 'Last payment miss '),
(221, 27, 66, '2025-02-10', 2.00, 0, 'Squeeky Prospect with Himal'),
(222, 42, 72, '2025-02-15', 7.00, 0, 'Kalyan dai labour'),
(223, 43, 59, '2025-02-18', 3.00, 0, ''),
(224, 38, 10, '2025-02-23', 6.00, 0, 'all shifts together'),
(225, 38, 56, '2025-02-23', 2.00, 0, ''),
(226, 38, 28, '2025-02-23', 2.00, 0, 'tow servie'),
(227, 11, 70, '2025-02-25', 8.00, 0, 'EOL Ashfield'),
(228, 44, 70, '2025-02-25', 20.00, 0, 'EOL Randwick'),
(229, 11, 12, '2025-02-23', 8.00, 0, 'punchbowl office all'),
(230, 44, 19, '2025-02-26', 2.00, 0, ''),
(231, 44, 73, '2025-02-26', 2.50, 0, ''),
(232, 44, 68, '2025-02-26', 3.00, 0, 'Portland Cr, Maroubra'),
(233, 45, 29, '2025-02-27', 2.50, 0, 'Trained started 7:40 end 10:00 two people worked'),
(234, 41, 68, '2025-02-27', 3.00, 0, 'Cornulla window clean'),
(235, 41, 70, '2025-02-27', 13.50, 0, 'EOL benfield '),
(236, 41, 67, '2025-02-28', 14.00, 0, 'Cabramata'),
(237, 42, 70, '2025-02-27', 3.00, 0, 'EOL benfield '),
(238, 26, 10, '2025-03-01', 4.00, 0, ''),
(239, 41, 68, '2025-03-01', 5.00, 0, '7/32 New South Head rd. Vaucluse 4.5 if approved 5'),
(240, 41, 66, '2025-03-03', 4.00, 0, 'Caringba unit '),
(241, 41, 66, '2025-03-03', 4.00, 0, 'Caringba single storage house'),
(242, 11, 67, '2025-03-03', 8.50, 0, 'Grasmere general clean 2 boys'),
(243, 41, 67, '2025-03-03', 8.50, 0, 'Sangeet vai done the job ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`) VALUES
(6, 'Binod', '$2y$10$PL.yH779BPZsre6yPlwMB.dOsNZ9YW/8hztcqqnb6ayInWADLzXDq'),
(7, 'sumesh', '$2y$10$bllxcX44q1UUafIU01hBK.JHJhGbMbK.FuJYuPh0QVm1fTvl2neRe');

-- --------------------------------------------------------

--
-- Table structure for table `worksites`
--

CREATE TABLE `worksites` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `worksites`
--

INSERT INTO `worksites` (`id`, `company_id`, `name`, `address`, `created_at`) VALUES
(5, 9, 'General Cleaning Concord (NDIS)', '24 Links AveConcord NSW 2137', '2025-01-25 09:54:06'),
(6, 6, 'Wooloomooloo Office Cleaning', '169 Bourke St, Woolloomooloo, NSW 2011', '2025-01-25 09:54:26'),
(7, 10, 'Advanx Strata', '16 Nield Avenue, Darlinghurst', '2025-01-25 09:55:06'),
(8, 11, 'Head to Health Parramatta', NULL, '2025-01-25 10:02:10'),
(9, 7, 'Marsden Park Office', NULL, '2025-01-25 10:06:02'),
(10, 7, 'Caddens Childcare', NULL, '2025-01-25 10:06:21'),
(11, 7, 'Chesterhill Child care', NULL, '2025-01-25 10:06:39'),
(12, 6, 'Punchbowl Office', NULL, '2025-01-25 10:07:09'),
(13, 6, '50 Clerance St Tenancy', '50 Clarence St, Sydney NSW 2000', '2025-01-25 12:37:08'),
(14, 6, '50 Clerance Common Area', '50 Clarence St, Sydney NSW 2000', '2025-01-25 12:37:25'),
(15, 6, '225 Clerance St Office', NULL, '2025-01-25 12:37:38'),
(16, 6, '225 Clerance St Tenancy', NULL, '2025-01-25 12:37:56'),
(17, 10, 'Eastwood Strata Cleaning', NULL, '2025-01-26 00:01:39'),
(19, 6, 'Kings Cross Domestic Cleaning', NULL, '2025-01-26 00:04:22'),
(20, 10, 'EOL Clean Mascot 22  JAN', '102/563 Gardeners Rd, Mascot, NSW 2020', '2025-01-26 00:33:41'),
(21, 16, 'Spring Cleaning Service', ' 43 Belmore Street Wollongong', '2025-01-26 01:15:14'),
(22, 16, 'Window Cleaning Service - 1 Storey House - Internal & External (Security bars present)', '71 Mount Lewis Avenue Punchbowl', '2025-01-26 01:17:43'),
(23, 16, 'General Cleaning Service - 1 Storey House', ' 32 Scarborough Street Monterey', '2025-01-26 01:17:59'),
(24, 16, 'Window Cleaning Service - 2 Storey House - Internal & External (Security bars present) Elevated rear', '65 Burwood Road Enfield', '2025-01-26 01:18:30'),
(25, 16, 'Spring Cleaning Service - 2 Storey house Split Level', '65 Burwood Road Enfield', '2025-01-26 01:18:44'),
(26, 16, 'Oven & Rangehood Cleaning Service', '65 Burwood Road Enfield', '2025-01-26 01:19:04'),
(27, 16, 'Spring Cleaning Service - 1 Storey House', ' 10 Cochran Place Abbotsbury', '2025-01-26 01:21:23'),
(28, 7, 'Wetherill Park Office', 'Wetherill Park Suburb in New South Wales', '2025-01-26 07:38:06'),
(29, 7, 'Edmunson Park Childcare', '16 Gellibrand Rd, Edmonson Park , NSW 2174', '2025-01-26 07:51:13'),
(30, 7, 'Appen Chatswood', '9 Help St, Chatswood NSW 2067', '2025-01-26 07:55:43'),
(31, 6, 'Samson St, Bondi (ICCC)', 'Samson St, Bondi', '2025-01-26 22:23:47'),
(32, 16, 'Gwandalan Road, Edensor Park', 'Gwandalan Road, Edensor Park', '2025-01-26 22:33:15'),
(33, 6, 'Grafton St,Bondi ', '503/79 Grafton St,Bondi ', '2025-01-26 22:33:28'),
(34, 6, 'Military Rd, Dover hights', '1/155 Military Rd, Dover hights', '2025-01-26 22:33:39'),
(35, 16, 'Cochram place, Abostburry', 'Cochram place, Abostburry', '2025-01-26 22:33:48'),
(36, 16, '71 Lewis Ave, Punchbowl ', '71 Lewis Ave, Punchbowl ', '2025-01-26 22:34:14'),
(37, 16, 'Monterey', '32 Scarborough Street Monterey', '2025-01-26 22:36:41'),
(38, 15, 'Ingleburn Factory (', 'Ingleburn', '2025-01-26 22:37:07'),
(39, 16, '65 Burwood road, Enfield', '65 Burwood road, Enfield', '2025-01-26 22:37:20'),
(40, 6, 'Cronulla Window Clean', 'Cronulla', '2025-01-26 22:40:29'),
(41, 18, '9 Sherridion Cr, Quakers hill', '9 Sherridion Cr, Quakers hill', '2025-01-26 22:44:24'),
(42, 6, '273/3 Phillip St Waterloo', '273/3 Phillip St Waterloo', '2025-01-26 22:48:19'),
(43, 16, 'Wollongong Spring Clean', '43 Belmore Street Wollongong', '2025-01-26 22:50:54'),
(44, 6, 'AXR office 50 Clarenece', 'AXR office 50 Clarenece St', '2025-01-26 22:54:12'),
(45, 15, 'Marsdenpark Reneta', 'Marsden Park', '2025-01-26 23:02:33'),
(46, 13, 'Richmond RAAF (Killara)', 'Richmond', '2025-01-26 23:03:28'),
(47, 16, 'Childcares Squeeky', 'various sites', '2025-01-26 23:05:51'),
(48, 16, 'Rydelmare (Squeeky)', 'Rydelmare', '2025-01-26 23:08:36'),
(49, 6, 'EOL - 12 Church St Mascot 14 JAN', '12 Church St Mascot', '2025-01-26 23:19:42'),
(50, 10, 'EOL 17 JAN MASCOT', 'Unit 297 629 Gardner\'s Rd Mascot', '2025-01-26 23:25:13'),
(51, 6, 'Danks St, Waterloo (ICCC)', 'Danks St, Waterloo', '2025-01-26 23:34:49'),
(52, 6, 'EOL MASCOT 9 JAN', 'Mascot', '2025-01-27 06:13:52'),
(53, 19, 'Missed Payments', 'Auburn', '2025-01-27 06:27:38'),
(54, 19, 'Allowances Fuel and Travel', 'Auburn', '2025-01-27 06:28:08'),
(55, 7, 'Eastern Creek Office', 'Eastern Creek', '2025-01-27 06:47:23'),
(56, 9, 'Castle Hill reneta', 'Castle Hill', '2025-01-27 07:52:29'),
(57, 10, 'EOL Mascot ', 'Mascot', '2025-01-27 10:58:27'),
(58, 7, 'Berry Cottage', '9 Talus St, Naremburn', '2025-01-27 11:06:32'),
(59, 16, 'Dulwich hill ', 'Dulwich hill', '2025-01-27 11:09:12'),
(60, 16, 'Petersham Spring and window clean ', '7 Croydon Street, Petersham ', '2025-01-30 04:46:39'),
(61, 16, 'Window cleaning Service- 1 Storage house ', '1 Flinders Place North Richmond', '2025-01-30 04:47:51'),
(62, 15, 'Castle hill ', 'Renata Castlehill ', '2025-02-03 01:44:29'),
(63, 10, 'EOL 4 Forest St, Forest Lodge', ' 4 Forest St, Forest Lodge', '2025-02-03 01:49:13'),
(64, 16, 'Ryde (Fire Station Deep clean)', '216 Blaxland road, Ryde', '2025-02-03 01:53:33'),
(65, 6, 'General Clean (1 Elger St, Glebe)', '1 Elger St, Glebe', '2025-02-03 01:59:10'),
(66, 16, 'Squeeky Window Clean', '69A County Dr, Cherry Brook', '2025-02-10 11:48:18'),
(67, 16, 'Squeeky Spring Clean', '88, 140 Hollinsworth Road Ingenia retirement village Marsden Park', '2025-02-10 11:58:34'),
(68, 6, 'ICCC Window Clean', '48/5 Broughton Rd, Artarmon', '2025-02-10 12:05:02'),
(69, 15, 'Office Clean', 'Minchenbury', '2025-02-10 12:21:15'),
(70, 6, 'Iccc Adhock ', 'Dulwich hill', '2025-02-24 10:30:13'),
(71, 21, 'Car park cleaning ', 'Martin Place carpark ', '2025-02-24 10:41:18'),
(72, 22, 'Kalyan dai', 'kalyan dai', '2025-02-24 11:40:32'),
(73, 6, 'Domestic clean Daceyville', '58 Isaac Smith Street, daceyville', '2025-02-26 12:50:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_runs`
--
ALTER TABLE `payroll_runs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_run_items`
--
ALTER TABLE `payroll_run_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payroll_run_id` (`payroll_run_id`),
  ADD KEY `timesheet_id` (`timesheet_id`);

--
-- Indexes for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `worksite_id` (`worksite_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `worksites`
--
ALTER TABLE `worksites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `payroll_runs`
--
ALTER TABLE `payroll_runs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `payroll_run_items`
--
ALTER TABLE `payroll_run_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=795;

--
-- AUTO_INCREMENT for table `timesheets`
--
ALTER TABLE `timesheets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `worksites`
--
ALTER TABLE `worksites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payroll_run_items`
--
ALTER TABLE `payroll_run_items`
  ADD CONSTRAINT `payroll_run_items_ibfk_1` FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs` (`id`),
  ADD CONSTRAINT `payroll_run_items_ibfk_2` FOREIGN KEY (`timesheet_id`) REFERENCES `timesheets` (`id`);

--
-- Constraints for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD CONSTRAINT `timesheets_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `timesheets_ibfk_2` FOREIGN KEY (`worksite_id`) REFERENCES `worksites` (`id`);

--
-- Constraints for table `worksites`
--
ALTER TABLE `worksites`
  ADD CONSTRAINT `worksites_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
