-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2021 at 06:16 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diagnostic`
--

-- --------------------------------------------------------

--
-- Table structure for table `log_status`
--

CREATE TABLE `log_status` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `logInOut` int(11) NOT NULL,
  `ipAddress` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_recovery`
--

CREATE TABLE `password_recovery` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `ipaddress` varchar(250) COLLATE utf8_bin NOT NULL,
  `request_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00:00',
  `method` varchar(10) COLLATE utf8_bin NOT NULL COMMENT 'phone or email',
  `status` int(11) NOT NULL COMMENT '0 = failed, 1 = mail sent, 2 = sucess'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='password will recover using sms only through verified phone number.' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts`
--

CREATE TABLE `tbl_accounts` (
  `id` int(11) NOT NULL,
  `accounts_date` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00',
  `accounts_type_id` tinyint(1) NOT NULL DEFAULT 0 COMMENT ' 0 = expense, 1 = income ',
  `invoice_number` varchar(250) COLLATE utf8_bin NOT NULL,
  `is_official_accounts` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = yes, 0 = not',
  `amount` double NOT NULL DEFAULT 0,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(22) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_accounts`
--

INSERT INTO `tbl_accounts` (`id`, `accounts_date`, `accounts_type_id`, `invoice_number`, `is_official_accounts`, `amount`, `insert_by`, `insert_time`) VALUES
(2, '2021-04-27', 1, '20210427135730', 0, 15000, 1, '2021-04-27 13:57'),
(3, '2021-04-28', 0, '20210427135802', 1, 1500, 1, '2021-04-27 13:58'),
(4, '2021-04-27', 0, '20210427141809', 1, 56000, 1, '2021-04-27 14:18'),
(5, '2021-04-27', 1, '20210427150605', 1, 169500, 1, '2021-04-27 15:06'),
(7, '2021-04-28', 1, '20210428091444', 1, 1000, 1, '2021-04-28 09:14'),
(8, '2021-05-01', 1, '20210501100447', 1, 1500, 1, '2021-05-01 10:04'),
(9, '2021-05-01', 0, '20210501100513', 1, 10000, 1, '2021-05-01 10:05'),
(10, '2021-05-01', 0, '20210501100529', 1, 5000, 1, '2021-05-01 10:05'),
(11, '2021-05-01', 0, '20210501100548', 1, 2000, 1, '2021-05-01 10:05'),
(12, '2021-05-01', 0, '20210501100604', 1, 500, 1, '2021-05-01 10:06'),
(13, '2021-05-01', 0, '20210501100618', 1, 600, 1, '2021-05-01 10:06'),
(14, '2021-05-01', 1, '20210501100631', 1, 20000, 1, '2021-05-01 10:06'),
(18, '2021-05-01', 1, '20210501152845', 0, 500, 1, '2021-05-01 15:28'),
(19, '2021-05-01', 1, '20210501155507', 0, 250, 1, '2021-05-01 15:55'),
(20, '2021-05-02', 1, '20210502095129', 0, 500, 1, '2021-05-02 09:51'),
(21, '2021-05-08', 1, '20210508123252', 0, 1500, 1, '2021-05-08 12:32'),
(22, '2021-05-08', 1, '20210508124508', 0, 500, 1, '2021-05-08 12:45'),
(23, '2021-05-09', 1, '20210509100802', 0, 1500, 5, '2021-05-09 10:08'),
(24, '2021-05-09', 1, '20210509132843', 0, 500, 14, '2021-05-09 13:28'),
(25, '2021-05-26', 1, '20210526123631', 0, 1400, 1, '2021-05-26 12:36'),
(26, '2021-05-26', 1, '20210526123757', 0, 800, 1, '2021-05-26 12:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts_category`
--

CREATE TABLE `tbl_accounts_category` (
  `id` int(11) NOT NULL,
  `accounts_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = expense, 1 = income',
  `account_head` text COLLATE utf8_bin NOT NULL,
  `readonly` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = yes, 0 = not',
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00',
  `insert_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_accounts_category`
--

INSERT INTO `tbl_accounts_category` (`id`, `accounts_type`, `account_head`, `readonly`, `insert_time`, `insert_by`) VALUES
(1, 1, 'test bill', 1, '2021-04-27 10:38', 1),
(2, 1, 'unknown2', 1, '2021-04-27 10:39', 1),
(4, 0, 'das', 1, '2021-04-27 10:51', 1),
(5, 1, 'known for all', 1, '2021-04-27 10:52', 1),
(6, 1, 'javascript', 1, '2021-04-27 10:55', 1),
(7, 0, 'java', 1, '2021-04-27 10:55', 1),
(8, 1, 'python', 1, '2021-04-27 10:55', 1),
(9, 0, 'ruby', 1, '2021-04-27 10:56', 1),
(10, 0, 'c#', 1, '2021-04-27 10:56', 1),
(11, 0, 'PHP', 1, '2021-04-27 10:57', 1),
(12, 1, 'django', 1, '2021-04-27 10:57', 1),
(13, 1, 'known', 1, '2021-04-28 09:14', 1),
(14, 0, 'musk buy', 1, '2021-05-01 10:03', 1),
(15, 0, 'sanitizer', 1, '2021-05-01 10:03', 1),
(16, 0, 'report print', 1, '2021-05-01 10:03', 1),
(17, 1, 'medicine', 1, '2021-05-01 10:03', 1),
(18, 1, 'report', 1, '2021-05-01 10:03', 1),
(19, 1, 'doctor', 1, '2021-05-01 10:04', 1),
(20, 1, 'health', 1, '2021-05-01 10:04', 1),
(22, 1, 'unknown', 0, '2021-05-01 15:43', 1),
(24, 1, 'known', 0, '2021-05-08 15:14', 14);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts_details`
--

CREATE TABLE `tbl_accounts_details` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `accounts_category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text COLLATE utf8_bin DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `insert_time` varchar(22) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_accounts_details`
--

INSERT INTO `tbl_accounts_details` (`id`, `invoice_number`, `accounts_category_id`, `quantity`, `description`, `amount`, `insert_time`) VALUES
(1, '20210427130419', 1, 1, 'sdfsdfds', 500, '2021-04-27 13:04'),
(2, '20210427130419', 1, 2, 'asdsad', 1000, '2021-04-27 13:04'),
(3, '20210427135730', 1, 1, 'income from office', 10000, '2021-04-27 13:57'),
(4, '20210427135730', 5, 1, 'known income', 5000, '2021-04-27 13:57'),
(5, '20210427135802', 7, 1, 'java', 1000, '2021-04-27 13:58'),
(6, '20210427135802', 9, 1, 'ruby', 500, '2021-04-27 13:58'),
(7, '20210427141809', 11, 1, 'php', 5000, '2021-04-27 14:18'),
(8, '20210427141809', 10, 1, 'ccc', 1000, '2021-04-27 14:18'),
(9, '20210427141809', 9, 500, 'sdfsdf', 50000, '2021-04-27 14:18'),
(10, '20210427150605', 5, 1, 'dsadas', 500, '2021-04-27 15:06'),
(11, '20210427150605', 6, 1, 'asdasdasd', 1000, '2021-04-27 15:06'),
(12, '20210427150605', 2, 1, 'sadsad', 10000, '2021-04-27 15:06'),
(13, '20210427150605', 6, 500, 'fasdfasf', 8000, '2021-04-27 15:06'),
(14, '20210427150605', 8, 1, 'asdasdsad', 80000, '2021-04-27 15:06'),
(15, '20210427150605', 12, 500, 'asdsads', 70000, '2021-04-27 15:06'),
(16, '20210428091444', 2, 1, 'sdds', 1000, '2021-04-28 09:14'),
(17, '20210501100447', 17, 1, 'ok', 500, '2021-05-01 10:04'),
(18, '20210501100447', 6, 1, 'ok', 1000, '2021-05-01 10:04'),
(19, '20210501100513', 14, 50000, 'musk', 10000, '2021-05-01 10:05'),
(20, '20210501100529', 15, 100, 'sani', 5000, '2021-05-01 10:05'),
(21, '20210501100548', 16, 1000, 'report', 2000, '2021-05-01 10:05'),
(22, '20210501100604', 14, 1000, 'as', 500, '2021-05-01 10:06'),
(23, '20210501100618', 11, 100, 'dfsa', 600, '2021-05-01 10:06'),
(27, '20210501152845', 1, 1, 'Bill of Mr. hossian', 500, '2021-05-01 15:28'),
(28, '20210501155507', 1, 1, 'Bill of Mr. sharif', 250, '2021-05-01 15:55'),
(29, '20210502095129', 1, 1, 'Bill of Mr. hossian', 500, '2021-05-02 09:51'),
(30, '20210508123252', 1, 1, 'Bill of Mr. sharif', 1500, '2021-05-08 12:32'),
(31, '20210508124508', 1, 1, 'Bill of Mr. sharif', 500, '2021-05-08 12:45'),
(32, '20210509100802', 1, 1, 'Bill of Mr. sharif', 1500, '2021-05-09 10:08'),
(33, '20210509132843', 1, 1, 'Bill of Mr. sharif', 500, '2021-05-09 13:28'),
(34, '20210526123631', 1, 1, 'Bill of Mr. sharif', 1400, '2021-05-26 12:36'),
(35, '20210526123757', 1, 1, 'Bill of Mr. mamun', 800, '2021-05-26 12:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activities`
--

CREATE TABLE `tbl_activities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_field` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `activity_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `icon` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fa fa-asterisk',
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_activities`
--

INSERT INTO `tbl_activities` (`id`, `user_id`, `module`, `module_field`, `description`, `activity_date_time`, `icon`, `deleted`) VALUES
(1, 3, 'Drug Generic', 'User Drug Generic', 'User Added Drug Generic', '2019-09-10 20:10:16', 'fa fa-check-circle', 0),
(3, 3, 'Drug Company', 'User Drug Company', 'User Added Drug Company', '2019-09-10 20:26:41', 'fa fa-cube', 0),
(4, 3, 'Drug Company', 'User Drug Company', 'User Delete Drug Company', '2019-09-10 20:34:02', 'fa fa-cube', 0),
(5, 3, 'User Profile', 'User Profile Information', 'User Profile Updated Successfully', '2019-09-11 15:23:27', 'fa fa-user', 0),
(6, 3, 'User Profile', 'User Profile Information', 'User Profile Updated Successfully', '2019-09-11 15:24:39', 'fa fa-user', 0),
(7, 3, 'User Profile', 'User Profile Information', 'User Profile Updated Successfully', '2019-09-11 16:14:29', 'fa fa-user', 0),
(8, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 19:40:50', 'fa fa-file', 0),
(9, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 19:46:58', 'fa fa-file', 0),
(10, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 19:56:47', 'fa fa-file', 0),
(11, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 19:56:52', 'fa fa-file', 0),
(12, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 19:58:02', 'fa fa-file', 0),
(13, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 20:01:19', 'fa fa-file', 0),
(14, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 20:08:18', 'fa fa-file', 0),
(15, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 20:08:22', 'fa fa-file', 0),
(16, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 20:09:30', 'fa fa-file', 0),
(17, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 20:13:52', 'fa fa-file', 0),
(18, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 20:13:57', 'fa fa-file', 0),
(19, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 20:42:36', 'fa fa-file', 0),
(20, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 20:42:40', 'fa fa-file', 0),
(21, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 20:42:43', 'fa fa-file', 0),
(22, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 22:29:56', 'fa fa-file', 0),
(23, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 22:30:01', 'fa fa-file', 1),
(24, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 22:30:04', 'fa fa-file', 1),
(25, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 22:30:08', 'fa fa-file', 1),
(26, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-12 22:30:13', 'fa fa-file', 1),
(27, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-14 16:10:57', 'fa fa-file', 1),
(28, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-14 16:11:01', 'fa fa-file', 1),
(29, 3, 'Chief Complaints', 'User Chief Complaints', 'User Delete Chief Complaints', '2019-09-14 16:12:30', 'fa fa-file', 1),
(30, 1, 'login', 'login successful', '::1', '2020-02-02 01:09:42', 'fa fa-unlock-alt', 0),
(31, 2, 'login', 'login successful', '::1', '2020-02-02 01:10:10', 'fa fa-unlock-alt', 0),
(32, 3, 'login', 'login successful', '103.222.23.37', '2020-02-05 14:42:53', 'fa fa-unlock-alt', 0),
(33, 3, 'login', 'login successful', '103.218.26.73', '2020-02-05 16:01:16', 'fa fa-unlock-alt', 0),
(34, 3, 'login', 'login successful', '27.131.12.205', '2020-02-06 05:52:42', 'fa fa-unlock-alt', 0),
(35, 3, 'login', 'login successful', '27.131.12.205', '2020-02-06 06:09:42', 'fa fa-unlock-alt', 0),
(36, 3, 'login', 'login successful', '27.131.12.205', '2020-02-10 05:49:26', 'fa fa-unlock-alt', 0),
(37, 3, 'login', 'login successful', '27.131.12.205', '2020-02-11 06:55:59', 'fa fa-unlock-alt', 0),
(38, 3, 'login', 'login successful', '103.222.23.37', '2020-02-11 08:43:07', 'fa fa-unlock-alt', 0),
(39, 2, 'login', 'login successful', '103.222.23.37', '2020-02-11 08:46:50', 'fa fa-unlock-alt', 0),
(40, 2, 'login', 'login successful', '::1', '2020-02-11 07:34:56', 'fa fa-unlock-alt', 0),
(41, 2, 'profile', 'profile Update', 'User Update Profile Info', '2020-02-11 12:35:15', 'fa fa-user', 0),
(42, 2, 'profile', 'profile Update', 'User Update Profile Info', '2020-02-11 12:35:25', 'fa fa-user', 0),
(43, 1, 'login', 'login successful', '::1', '2020-02-11 23:18:29', 'fa fa-unlock-alt', 0),
(44, 2, 'login', 'login successful', '::1', '2020-02-12 01:45:21', 'fa fa-unlock-alt', 0),
(45, 2, 'image', 'User image', 'User Add New Image', '2020-02-12 06:53:24', 'fa fa-picture-o', 0),
(46, 2, 'image', 'User image', 'User Update Image', '2020-02-12 06:55:00', 'fa fa-picture-o', 0),
(47, 2, 'image', 'User image', 'User Update Image', '2020-02-12 09:10:31', 'fa fa-picture-o', 0),
(48, 2, 'image', 'User image', 'User Add New Image', '2020-02-12 09:25:29', 'fa fa-picture-o', 0),
(49, 1, 'login', 'login successful', '::1', '2020-02-12 23:11:49', 'fa fa-unlock-alt', 0),
(50, 2, 'login', 'login successful', '::1', '2020-02-12 23:21:30', 'fa fa-unlock-alt', 0),
(51, 2, 'image', 'User image', 'User Add New Image', '2020-02-13 04:22:51', 'fa fa-picture-o', 0),
(52, 2, 'image', 'User image', 'User Update Image', '2020-02-13 04:31:13', 'fa fa-picture-o', 0),
(53, 2, 'favourite', 'User favourite', 'User favourite Picture Updated', '2020-02-13 04:31:53', 'fa fa-heart', 0),
(54, 2, 'wishlist', 'User wishlist', 'User Wishlist Added', '2020-02-13 04:32:06', 'fa fa-heart', 0),
(55, 2, 'wishlist', 'User wishlist', 'User Wishlist Updated', '2020-02-13 04:32:11', 'fa fa-heart', 0),
(56, 1, 'login', 'login successful', '103.222.23.37', '2020-02-15 19:22:49', 'fa fa-unlock-alt', 0),
(57, 3, 'login', 'login successful', '103.120.202.98', '2020-02-15 19:28:23', 'fa fa-unlock-alt', 0),
(58, 3, 'login', 'login successful', '27.131.12.205', '2020-02-16 06:12:52', 'fa fa-unlock-alt', 0),
(59, 1, 'login', 'login successful', '103.222.23.37', '2020-02-16 11:04:47', 'fa fa-unlock-alt', 0),
(60, 2, 'login', 'login successful', '103.222.23.37', '2020-02-16 11:28:09', 'fa fa-unlock-alt', 0),
(61, 3, 'login', 'login successful', '103.218.26.73', '2020-02-22 17:18:17', 'fa fa-unlock-alt', 0),
(62, 3, 'login', 'login successful', '27.131.12.205', '2020-03-01 05:54:16', 'fa fa-unlock-alt', 0),
(63, 1, 'login', 'login successful', '103.76.46.99', '2020-03-10 10:19:12', 'fa fa-unlock-alt', 0),
(64, 1, 'login', 'login successful', '103.76.46.104', '2020-03-10 12:28:27', 'fa fa-unlock-alt', 0),
(65, 1, 'login', 'login successful', '103.76.46.99', '2020-03-10 12:48:27', 'fa fa-unlock-alt', 0),
(66, 1, 'login', 'login successful', '103.76.46.99', '2020-03-11 05:21:28', 'fa fa-unlock-alt', 0),
(67, 1, 'login', 'login successful', '103.76.46.99', '2020-03-11 05:26:34', 'fa fa-unlock-alt', 0),
(68, 3, 'login', 'login successful', '103.218.26.73', '2020-03-20 15:52:05', 'fa fa-unlock-alt', 0),
(69, 3, 'login', 'login successful', '103.218.26.73', '2020-03-20 21:21:56', 'fa fa-unlock-alt', 0),
(70, 3, 'login', 'login successful', '103.76.46.99', '2020-03-22 15:58:28', 'fa fa-unlock-alt', 0),
(71, 1, 'login', 'login successful', '103.76.46.99', '2020-03-23 07:38:22', 'fa fa-unlock-alt', 0),
(72, 1, 'login', 'login successful', '103.222.23.37', '2020-03-29 20:08:53', 'fa fa-unlock-alt', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_common_pages`
--

CREATE TABLE `tbl_common_pages` (
  `id` int(11) NOT NULL,
  `is_menu` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = no, 1 = yes',
  `priority` int(11) NOT NULL COMMENT 'max will top.',
  `parent_page_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(20) NOT NULL,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `attatched` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_common_pages`
--

INSERT INTO `tbl_common_pages` (`id`, `is_menu`, `priority`, `parent_page_id`, `name`, `title`, `body`, `attatched`) VALUES
(2, 0, 10, 0, 'privacypolicy', 'Privacy & Policy', '<div class=\"desc\">\r\n<p>asfasfasfasfsa</p>\r\n</div>\r\n', 'assets/pageSettings/KBlackWallpaperUHD_20190831143710.jpg'),
(3, 1, 1, 0, 'mission', 'Our Mission', '<p>Estabilishing great professionalism through the satisfaction</p>\r\n', 'assets/pageSettings/about_20190527162626.jpg'),
(4, 1, 1, 1, 'vision', 'Our Vision', '<p>To be a participant of the development of the country we are promised to build a resourceful professional environment.</p>\r\n', 'assets/pageSettings/about_20190527162647.jpg'),
(5, 0, 1, 0, 'payment-policy', 'Payment Policy', '<p>sdgsfsaf</p>\r\n', 'assets/pageSettings/creditclient_20190528104347.png'),
(10, 0, 1, 0, 'rules-and-regulation', 'Rules And Regulation', '', ''),
(11, 0, 0, 0, 'partners', 'Our Product Catalogue', '', 'assets/pageSettings/Catalog_20190624105452.pdf'),
(12, 1, 1, 1, 'productcatalog', 'Product Catalog', '', 'assets/pageSettings/Catalog_20190627114921.pdf'),
(13, 1, 1, 1, 'our-objective', 'our-objective', 'our-objective', ''),
(14, 1, 10, 0, 'Test ', 'Test ', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', 'assets/pageSettings/_20190707182209.jpg'),
(16, 1, 23, 13, 'a', 'oooooooooooooo', '', 'assets/pageSettings/images_20210420115325.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_discount_option`
--

CREATE TABLE `tbl_discount_option` (
  `id` int(11) NOT NULL,
  `option_name` text COLLATE utf8_bin NOT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_discount_option`
--

INSERT INTO `tbl_discount_option` (`id`, `option_name`, `insert_by`, `insert_time`) VALUES
(1, 'Govt. employee', 1, '0000-00-00 00:00'),
(2, 'Doctor\'s Relative', 1, '0000-00-00 00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_divission`
--

CREATE TABLE `tbl_divission` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_divission`
--

INSERT INTO `tbl_divission` (`id`, `name`) VALUES
(1, 'ঢাকা'),
(2, 'রাজশাহী'),
(3, 'চট্টগ্রাম'),
(4, 'সিলেট'),
(5, 'খুলনা'),
(6, 'বরিশাল'),
(7, 'রংপুর'),
(8, 'ময়মনসিংহ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mail_send_setting`
--

CREATE TABLE `tbl_mail_send_setting` (
  `id` int(11) NOT NULL,
  `setting_name` text COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_mail_send_setting`
--

INSERT INTO `tbl_mail_send_setting` (`id`, `setting_name`, `value`) VALUES
(1, 'protocol', 'smtp'),
(2, 'smtp_host', ''),
(3, 'smtp_port', '465'),
(4, 'smtp_user', 'info@northernfertilizer.com'),
(5, 'smtp_pass', '13456'),
(6, 'mailtype', 'text'),
(7, 'charset', 'iso-8859-1'),
(8, 'wordwrap', 'TRUE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient`
--

CREATE TABLE `tbl_patient` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(250) COLLATE utf8_bin NOT NULL,
  `patient_phone` varchar(20) COLLATE utf8_bin NOT NULL,
  `father_name` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `mother_name` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `patient_nid` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `birth_date` varchar(10) COLLATE utf8_bin DEFAULT '0000-00-00',
  `gender` text COLLATE utf8_bin DEFAULT NULL,
  `address` text COLLATE utf8_bin DEFAULT NULL,
  `photo` text COLLATE utf8_bin DEFAULT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_patient`
--

INSERT INTO `tbl_patient` (`id`, `patient_name`, `patient_phone`, `father_name`, `mother_name`, `patient_nid`, `birth_date`, `gender`, `address`, `photo`, `insert_by`, `insert_time`) VALUES
(1, 'sharif', '01789653265', 'acb', 'amena', '65983265', '1970-01-01', 'male', 'mohammadpur', NULL, 1, '2021-04-29 14:43'),
(2, 'mamun', '01784562395', 'shofiq', 'mina', '56894511', '2020-05-01', 'male', 'mohammadpur', NULL, 1, '2021-04-29 14:55'),
(3, 'didar ahmed', '01784562369', 'alam', 'ohida', '2000365987', '2021-04-29', NULL, 'mohammadpur', NULL, 1, '2021-04-29 15:07'),
(4, 'hossian', '01721326598', 'IMAN ALI FAKIR ', 'Sabiha Sheikh', '659845156', '2021-04-24', NULL, 'মিরপুর-১১,পল্লবী, ঢাকা-১২১৬, বাংলাদেশ।', 'assets/userPhoto/images_20210501094812.png', 1, '2021-05-01 09:48'),
(5, 'mehedi', '01898656589', 'Habib Sheikh', 'Ohida Akhter', '545852569', '2021-04-24', NULL, 'mohammadpur, dhaka 1207', 'assets/userPhoto/images_20210501094903.jpg', 1, '2021-05-01 09:49'),
(6, 'habib', '01569636563', 'LATE MIR WAHED ALI', 'Ohida Akhtera', '6598451587', '1970-01-01', 'male', 'dhaka', NULL, 1, '2021-05-01 09:50'),
(7, 'jabeddsa', '01701010101', 'Shafiqul Islam khan', 'Ohida Akhter begum', '6598451545', '1970-01-01', 'male', 'savar', NULL, 1, '2021-05-01 09:55'),
(8, 'hamid', '01789858636', 'sadas', 'asdsa', '565645', '1970-01-01', 'male', 'sadsad', NULL, 1, '2021-05-26 15:44'),
(9, 'lamia', '01789863626', 'sasad', 'asdsadas', '6564545', '1970-01-01', 'female', 'sadsad', NULL, 1, '2021-05-26 15:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tests`
--

CREATE TABLE `tbl_tests` (
  `id` int(11) NOT NULL,
  `issue_date` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00',
  `invoice_number` varchar(250) COLLATE utf8_bin NOT NULL,
  `patient_id` int(11) NOT NULL,
  `referred_by` int(11) NOT NULL DEFAULT 0,
  `total_amount` double NOT NULL DEFAULT 0,
  `discount_amount` double DEFAULT 0,
  `discount_permit_by` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `discount_option_id` int(11) NOT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(22) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_tests`
--

INSERT INTO `tbl_tests` (`id`, `issue_date`, `invoice_number`, `patient_id`, `referred_by`, `total_amount`, `discount_amount`, `discount_permit_by`, `discount_option_id`, `insert_by`, `insert_time`) VALUES
(1, '2021-04-29', '20210429144330', 1, 1, 600, 100, 'shan', 1, 1, '2021-04-29 14:43'),
(2, '2021-04-29', '20210429145501', 2, 1, 1800, 200, 'me', 2, 1, '2021-04-29 14:55'),
(3, '2021-04-29', '20210429145625', 1, 3, 250, 0, '', 0, 1, '2021-04-29 14:56'),
(4, '2021-04-29', '20210429150712', 3, 3, 4700, 700, 'me', 2, 1, '2021-04-29 15:07'),
(5, '2021-05-01', '20210501095242', 6, 1, 500, 0, '', 0, 1, '2021-05-01 09:52'),
(6, '2021-05-01', '20210501095305', 5, 1, 250, 0, '', 0, 1, '2021-05-01 09:53'),
(7, '2021-05-01', '20210501095341', 3, 1, 2000, 500, 'shan', 1, 1, '2021-05-01 09:53'),
(8, '2021-05-01', '20210501095414', 4, 3, 350, 0, '', 0, 1, '2021-05-01 09:54'),
(9, '2021-05-01', '20210501095555', 7, 3, 350, 0, '', 0, 1, '2021-05-01 09:55'),
(10, '2021-05-01', '20210501095626', 7, 3, 2600, 100, 'me', 2, 1, '2021-05-01 09:56'),
(11, '2021-05-01', '20210501095649', 4, 3, 350, 0, '', 0, 1, '2021-05-01 09:56'),
(12, '2021-05-01', '20210501095718', 4, 1, 1800, 100, 'me', 1, 1, '2021-05-01 09:57'),
(13, '2021-05-01', '20210501115806', 4, 1, 350, 0, '', 0, 1, '2021-05-01 11:58'),
(14, '2021-05-02', '20210501122730', 7, 1, 350, 0, '', 0, 1, '2021-05-01 12:27'),
(19, '2021-05-01', '20210501152845', 4, 1, 500, 0, '', 0, 1, '2021-05-01 15:28'),
(20, '2021-05-01', '20210501155507', 1, 1, 250, 0, '', 0, 1, '2021-05-01 15:55'),
(21, '2021-05-02', '20210502095129', 4, 4, 500, 0, '', 0, 1, '2021-05-02 09:51'),
(22, '2021-05-08', '20210508123252', 1, 3, 1500, 0, '', 0, 1, '2021-05-08 12:32'),
(23, '2021-05-08', '20210508124508', 1, 3, 500, 0, '', 0, 1, '2021-05-08 12:45'),
(24, '2021-05-09', '20210509100802', 1, 3, 1500, 0, '', 0, 5, '2021-05-09 10:08'),
(25, '2021-05-09', '20210509132843', 1, 3, 500, 0, '', 0, 14, '2021-05-09 13:28'),
(26, '2021-05-26', '20210526123631', 1, 11, 1500, 100, 'me', 1, 1, '2021-05-26 12:36'),
(27, '2021-05-26', '20210526123757', 2, 3, 800, 0, '', 0, 1, '2021-05-26 12:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tests_details`
--

CREATE TABLE `tbl_tests_details` (
  `id` int(11) NOT NULL,
  `tests_id` int(11) NOT NULL,
  `tests_name_id` int(11) NOT NULL,
  `referrer_fee` double NOT NULL DEFAULT 0,
  `test_bill` double NOT NULL DEFAULT 0,
  `report_publish_date` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00',
  `test_report_details` text COLLATE utf8_bin DEFAULT NULL,
  `report_upload_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00:00',
  `insert_time` varchar(22) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_tests_details`
--

INSERT INTO `tbl_tests_details` (`id`, `tests_id`, `tests_name_id`, `referrer_fee`, `test_bill`, `report_publish_date`, `test_report_details`, `report_upload_time`, `insert_time`) VALUES
(1, 1, 1, 20, 350, '2021-04-29', '<p>ok</p>\r\n', '0000-00-00 00:00:00', '2021-04-29 14:43'),
(2, 1, 2, 25, 250, '2021-04-29', '<p>ok</p>\r\n', '0000-00-00 00:00:00', '2021-04-29 14:43'),
(3, 2, 4, 50, 500, '2021-04-29', '<p>ok</p>\r\n', '0000-00-00 00:00:00', '2021-04-29 14:55'),
(4, 2, 6, 150, 1300, '2021-04-30', '<p>ok</p>', '0000-00-00 00:00:00', '2021-04-29 14:55'),
(5, 3, 2, 25, 250, '2021-04-29', '<p>ok test updated</p>\r\n', '2021-04-29 15:14', '2021-04-29 14:56'),
(6, 4, 1, 20, 350, '2021-04-29', '<p>ok</p>\r\n', '0000-00-00 00:00:00', '2021-04-29 15:07'),
(7, 4, 2, 25, 250, '2021-04-29', '<p>ok</p>\r\n', '0000-00-00 00:00:00', '2021-04-29 15:07'),
(8, 4, 3, 50, 500, '2021-04-29', '<p>ok</p>\r\n', '0000-00-00 00:00:00', '2021-04-29 15:07'),
(9, 4, 5, 200, 1800, '2021-04-29', '<p>ok</p>', '0000-00-00 00:00:00', '2021-04-29 15:07'),
(10, 4, 6, 150, 1300, '2021-04-29', '<p>ok</p>', '0000-00-00 00:00:00', '2021-04-29 15:07'),
(11, 4, 4, 50, 500, '2021-04-29', '<p>ok</p>\r\n', '0000-00-00 00:00:00', '2021-04-29 15:07'),
(12, 5, 4, 50, 500, '2021-05-01', '<p>ok</p>\r\n', '0000-00-00 00:00:00', '2021-05-01 09:52'),
(13, 6, 2, 25, 250, '2021-05-01', '<p>ok</p>\r\n', '0000-00-00 00:00:00', '2021-05-01 09:53'),
(14, 7, 9, 150, 1500, '2021-05-01', '<p>ok</p>\r\n', '2021-05-09 12:47', '2021-05-01 09:53'),
(15, 7, 8, 50, 500, '2021-05-01', '<p>ok testing</p>\r\n', '0000-00-00 00:00:00', '2021-05-01 09:53'),
(16, 8, 1, 20, 350, '2021-05-01', '<p>ok</p>\r\n', '0000-00-00 00:00:00', '2021-05-01 09:54'),
(17, 9, 1, 20, 350, '2021-05-01', '<p>ok</p>\r\n', '0000-00-00 00:00:00', '2021-05-01 09:55'),
(18, 10, 5, 200, 1800, '2021-05-01', '<p>ok ok</p>\r\n', '2021-05-08 16:26', '2021-05-01 09:56'),
(19, 10, 10, 100, 800, '2021-05-01', '<p>ok</p>\r\n', '2021-05-09 12:24', '2021-05-01 09:56'),
(20, 11, 1, 20, 350, '2021-05-01', '<p>ok</p>\r\n', '2021-05-26 12:46', '2021-05-01 09:56'),
(21, 12, 5, 200, 1800, '2021-05-01', '<p>okok</p>\r\n', '2021-05-08 15:48', '2021-05-01 09:57'),
(22, 13, 1, 20, 350, '1970-01-01', '<p>okokok</p>\r\n', '2021-05-09 12:01', '2021-05-01 11:58'),
(23, 14, 1, 20, 350, '2021-05-01', '<p>okgdsfhjh dsfsd</p>\r\n', '2021-05-09 09:26', '2021-05-01 12:27'),
(28, 19, 3, 50, 500, '2021-05-01', '<p>okokasd</p>\r\n', '2021-05-09 12:35', '2021-05-01 15:28'),
(29, 20, 2, 25, 250, '2021-05-01', '<p>ok</p>\r\n', '2021-05-02 09:56', '2021-05-01 15:55'),
(30, 21, 4, 50, 500, '2021-05-02', '<table>ok</table>\r\n', '2021-05-08 12:00', '2021-05-02 09:51'),
(31, 22, 11, 100, 1500, '2021-05-08', '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\">\r\n <thead>\r\n  <tr>\r\n   <th scope=\"col\">name</th>\r\n   <th scope=\"col\">value</th>\r\n  </tr>\r\n </thead>\r\n <tbody>\r\n  <tr>\r\n   <td>urine</td>\r\n   <td>0.25</td>\r\n  </tr>\r\n  <tr>\r\n   <td>medicine</td>\r\n   <td>000</td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<p> </p>\r\n', '2021-05-09 12:33', '2021-05-08 12:32'),
(32, 23, 3, 50, 500, '2021-05-08', '<table class=\"table\">\r\n <thead>\r\n  <tr>\r\n   <th scope=\"col\">#</th>\r\n   <th scope=\"col\">First</th>\r\n   <th scope=\"col\">Last</th>\r\n   <th scope=\"col\">Handle</th>\r\n  </tr>\r\n </thead>\r\n <tbody>\r\n  <tr>\r\n   <th scope=\"row\">1</th>\r\n   <td>Mark</td>\r\n   <td>Ottoman</td>\r\n   <td>@mdo</td>\r\n  </tr>\r\n  <tr>\r\n   <th scope=\"row\">2</th>\r\n   <td>Jacob</td>\r\n   <td>Thornton</td>\r\n   <td>@fatman</td>\r\n  </tr>\r\n  <tr>\r\n   <th scope=\"row\">3</th>\r\n   <td>Larry page</td>\r\n   <td>the Bird</td>\r\n   <td>@twitter</td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '2021-05-09 10:23', '2021-05-08 12:45'),
(33, 24, 11, 100, 1500, '2021-05-09', '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\">\r\n <thead>\r\n  <tr>\r\n   <th scope=\"col\">name</th>\r\n   <th scope=\"col\">value</th>\r\n  </tr>\r\n </thead>\r\n <tbody>\r\n  <tr>\r\n   <td>urine</td>\r\n   <td>1.80</td>\r\n  </tr>\r\n  <tr>\r\n   <td>medicine</td>\r\n   <td>3.75</td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<p> </p>\r\n', '2021-05-09 13:50', '2021-05-09 10:08'),
(34, 25, 8, 50, 500, '2021-05-09', '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\">\r\n <thead>\r\n  <tr>\r\n   <th scope=\"col\">name</th>\r\n   <th scope=\"col\">value</th>\r\n   <th scope=\"col\">name</th>\r\n   <th scope=\"col\">value</th>\r\n   <th scope=\"col\">name</th>\r\n   <th scope=\"col\">value</th>\r\n  </tr>\r\n </thead>\r\n <tbody>\r\n  <tr>\r\n   <td>ok</td>\r\n   <td>1</td>\r\n   <td>ok</td>\r\n   <td>0.00</td>\r\n   <td>ok</td>\r\n   <td>0.00</td>\r\n  </tr>\r\n  <tr>\r\n   <td>ok</td>\r\n   <td>0.00</td>\r\n   <td>ok</td>\r\n   <td>0.00</td>\r\n   <td>ok</td>\r\n   <td>0.00</td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', '2021-05-09 13:23', '2021-05-09 13:28'),
(35, 26, 9, 150, 1500, '2021-05-26', '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\">\r\n <thead>\r\n  <tr>\r\n   <th scope=\"col\">Test</th>\r\n   <th scope=\"col\">Result</th>\r\n   <th scope=\"col\">Normal Value</th>\r\n  </tr>\r\n </thead>\r\n <tbody>\r\n  <tr>\r\n   <td>Sodium</td>\r\n   <td>136 mmol/l</td>\r\n   <td>135-155 mmol/l</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Potassium</td>\r\n   <td>6.8 mmol/l</td>\r\n   <td>3.5-5.55 mmol/l</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Chloride</td>\r\n   <td>112 mmol/l</td>\r\n   <td>98- 106 mmol/l</td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<p> </p>\r\n', '2021-05-26 12:04', '2021-05-26 12:36'),
(36, 27, 10, 100, 800, '2021-05-26', '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\">\r\n <thead>\r\n  <tr>\r\n   <th scope=\"col\">Test</th>\r\n   <th scope=\"col\">Result</th>\r\n   <th scope=\"col\">Normal Value</th>\r\n  </tr>\r\n </thead>\r\n <tbody>\r\n  <tr>\r\n   <td>Blood Glucse (FBS)</td>\r\n   <td>4.5 m.mol/L</td>\r\n   <td>5.5 m.mol/L</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Crosspending Urine Sugar</td>\r\n   <td>Nil</td>\r\n   <td>Nil</td>\r\n  </tr>\r\n  <tr>\r\n   <td>1hrs after 75gm glucose</td>\r\n   <td>9.8 m.mol/L</td>\r\n   <td>7.8 m.mol/L</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Crosspending Urine Sugar</td>\r\n   <td>Nil</td>\r\n   <td>Nil</td>\r\n  </tr>\r\n  <tr>\r\n   <td>2hrs after 75gm glucose</td>\r\n   <td>9.2 m.mol/L</td>\r\n   <td>7.8 m.mol/L</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Crosspending Urine Sugar</td>\r\n   <td>Nil</td>\r\n   <td>Nil</td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<p> </p>\r\n', '2021-05-26 14:21', '2021-05-26 12:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_test_category`
--

CREATE TABLE `tbl_test_category` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_bin DEFAULT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_test_category`
--

INSERT INTO `tbl_test_category` (`id`, `name`, `insert_by`, `insert_time`) VALUES
(1, 'Regular', 1, '2021-04-29 14:37'),
(2, 'সাবস্ক্রিপশন', 1, '2021-04-29 16:03'),
(3, 'bone marrow aspiration', 1, '2021-05-01 09:36'),
(4, 'blood count', 1, '2021-05-01 09:36'),
(5, 'epinephrine tolerance test', 1, '2021-05-01 09:36'),
(6, 'glucose tolerance test', 1, '2021-05-01 09:36'),
(7, 'immunologic blood test', 1, '2021-05-01 09:37'),
(8, 'serological test', 1, '2021-05-01 09:37'),
(9, 'angiocardiography', 1, '2021-05-01 09:37'),
(10, 'Lipid Profile', 1, '2021-05-01 09:37'),
(11, 'OGTT-Report', 1, '2021-05-01 09:38'),
(12, 'Biochemistry-Report', 1, '2021-05-01 09:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_test_name`
--

CREATE TABLE `tbl_test_name` (
  `id` int(11) NOT NULL,
  `test_category_id` int(11) NOT NULL,
  `test_name` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `price` double NOT NULL DEFAULT 0,
  `referral_commission` double NOT NULL DEFAULT 0,
  `report_format` text COLLATE utf8_bin DEFAULT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_test_name`
--

INSERT INTO `tbl_test_name` (`id`, `test_category_id`, `test_name`, `price`, `referral_commission`, `report_format`, `insert_by`, `insert_time`) VALUES
(7, 11, 'test 2', 1800, 180, '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\">\r\n <thead>\r\n  <tr>\r\n   <th scope=\"col\">Test</th>\r\n   <th scope=\"col\">Result</th>\r\n   <th scope=\"col\">Normal Value</th>\r\n  </tr>\r\n </thead>\r\n <tbody>\r\n  <tr>\r\n   <td>Random Blood Sugar(RBS)</td>\r\n   <td>4.5 m.mol/L</td>\r\n   <td>7.8 m.mol/L</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Crosspending Urine Sugar</td>\r\n   <td>Nil</td>\r\n   <td>Nil</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Fasting Blood glucose(FBS)</td>\r\n   <td>9.8 m.mol/L</td>\r\n   <td>4.2 - 6.4 m.mol/L</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Crosspending Urine Sugar</td>\r\n   <td>Nil</td>\r\n   <td>Nil</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Blood Glucose(2hrs ABF)</td>\r\n   <td>5.8 m.mol/L</td>\r\n   <td>7.8 m.mol/L </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Crosspending Urine Sugar</td>\r\n   <td>Nil</td>\r\n   <td>Nil</td>\r\n  </tr>\r\n  <tr>\r\n   <td>S. Creatinine</td>\r\n   <td>1.2 mg/dl</td>\r\n   <td>\r\n   <p>Male 0.6-1.2 mg/dl</p>\r\n\r\n   <p>Female 0.5-0.9mg/dl </p>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>Serum Cholesterol</td>\r\n   <td>200 mg/dl</td>\r\n   <td>Up to 200 mg/dl</td>\r\n  </tr>\r\n  <tr>\r\n   <td>S. Bilirubin</td>\r\n   <td>0.68 mg/dl</td>\r\n   <td>Up to 1.0mg/dl</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Blood Urea</td>\r\n   <td>26 mg/d</td>\r\n   <td>15-40mg/dl</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Uric Acid</td>\r\n   <td>4.0 mg/d</td>\r\n   <td>\r\n   <p>F: 2.5-6.0 mg/dl</p>\r\n\r\n   <p>M: 3.5-7.2 mg/dl</p>\r\n   </td>\r\n  </tr>\r\n  <tr>\r\n   <td>S.G.P.T</td>\r\n   <td>15 U / l</td>\r\n   <td>Up to 41 U /  l</td>\r\n  </tr>\r\n  <tr>\r\n   <td>S.G.O.P</td>\r\n   <td>31 U / l</td>\r\n   <td>Up to 42 U/ l</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Serum Albumin</td>\r\n   <td>4.0g</td>\r\n   <td>3.2-5.0 g</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Blood Glucose (1hrs ABF)</td>\r\n   <td>5.8 m.mol/l</td>\r\n   <td>7.8 m.mol/l</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Crosspending Urine Sugar</td>\r\n   <td>Nil</td>\r\n   <td>Nil</td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', 1, '2021-04-29 14:53'),
(8, 10, 'Lipid profile', 500, 50, '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" xss=removed>\r\n <thead>\r\n  <tr>\r\n   <th scope=\"col\">Test</th>\r\n   <th scope=\"col\">Result</th>\r\n   <th scope=\"col\">Normal Value</th>\r\n  </tr>\r\n </thead>\r\n <tbody>\r\n  <tr>\r\n   <td>Serum Cholesterol</td>\r\n   <td>264 mg/dl</td>\r\n   <td>Up to 200mg/dl</td>\r\n  </tr>\r\n  <tr>\r\n   <td>H D L Cholesterol</td>\r\n   <td>37 mg/dl</td>\r\n   <td>Up to 50mg/dl</td>\r\n  </tr>\r\n  <tr>\r\n   <td>L D L Cholesterol</td>\r\n   <td>155 mg/dl</td>\r\n   <td>Up to 150mg/dl</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Trilycerides</td>\r\n   <td>360 mg/dl</td>\r\n   <td>150mg/dl</td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n', 1, '2021-05-01 09:40'),
(9, 12, 'Biochemistry test1', 1500, 150, '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" xss=removed>\r\n <thead>\r\n  <tr>\r\n   <th scope=\"col\">Test</th>\r\n   <th scope=\"col\">Result</th>\r\n   <th scope=\"col\">Normal Value</th>\r\n  </tr>\r\n </thead>\r\n <tbody>\r\n  <tr>\r\n   <td>Sodium</td>\r\n   <td>149 mmol/l</td>\r\n   <td>135-155 mmol/l</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Potassium</td>\r\n   <td>6.8 mmol/l</td>\r\n   <td>3.5-5.55 mmol/l</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Chloride</td>\r\n   <td>112 mmol/l</td>\r\n   <td>98- 106 mmol/l</td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<p> </p>\r\n', 1, '2021-05-01 09:40'),
(10, 11, 'OGTT', 800, 100, '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\">\r\n <thead>\r\n  <tr>\r\n   <th scope=\"col\">Test</th>\r\n   <th scope=\"col\">Result</th>\r\n   <th scope=\"col\">Normal Value</th>\r\n  </tr>\r\n </thead>\r\n <tbody>\r\n  <tr>\r\n   <td>Blood Glucse (FBS)</td>\r\n   <td>4.5 m.mol/L</td>\r\n   <td>5.5 m.mol/L</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Crosspending Urine Sugar</td>\r\n   <td>Nil</td>\r\n   <td>Nil</td>\r\n  </tr>\r\n  <tr>\r\n   <td>1hrs after 75gm glucose</td>\r\n   <td>9.8 m.mol/L</td>\r\n   <td>7.8 m.mol/L</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Crosspending Urine Sugar</td>\r\n   <td>Nil</td>\r\n   <td>Nil</td>\r\n  </tr>\r\n  <tr>\r\n   <td>2hrs after 75gm glucose</td>\r\n   <td>9.2 m.mol/L</td>\r\n   <td>7.8 m.mol/L</td>\r\n  </tr>\r\n  <tr>\r\n   <td>Crosspending Urine Sugar</td>\r\n   <td>Nil</td>\r\n   <td>Nil</td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<p> </p>\r\n', 1, '2021-05-01 09:41'),
(11, 12, 'Biochemistry ', 1500, 100, '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" xss=removed>\r\n <thead>\r\n  <tr>\r\n   <th scope=\"col\">Test</th>\r\n   <th scope=\"col\">Result</th>\r\n   <th scope=\"col\">Normal Value</th>\r\n  </tr>\r\n </thead>\r\n <tbody>\r\n  <tr>\r\n   <td>Random Blood Sugar (RBS)</td>\r\n   <td>3.8m.mol/L</td>\r\n   <td>7.8 mmol/1</td>\r\n  </tr>\r\n </tbody>\r\n</table>\r\n\r\n<p> </p>\r\n\r\n<p> </p>\r\n\r\n<p> </p>\r\n', 1, '2021-05-08 12:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_test_payment`
--

CREATE TABLE `tbl_test_payment` (
  `id` int(11) NOT NULL,
  `tests_id` int(11) NOT NULL DEFAULT 0,
  `patient_id` int(11) NOT NULL DEFAULT 0,
  `paid_amount` double NOT NULL DEFAULT 0,
  `paid_date` varchar(22) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payment_approved` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = not, 1 = yes',
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_test_payment`
--

INSERT INTO `tbl_test_payment` (`id`, `tests_id`, `patient_id`, `paid_amount`, `paid_date`, `payment_approved`, `insert_by`, `insert_time`) VALUES
(1, 4, 3, 4000, '2021-04-29', 1, 1, '2021-04-29 15:08'),
(2, 10, 7, 500, '2021-05-01', 1, 1, '2021-05-01 09:57'),
(3, 10, 7, 1000, '2021-05-01', 1, 1, '2021-05-01 09:58'),
(4, 10, 7, 1000, '2021-05-01', 1, 1, '2021-05-01 09:58'),
(5, 5, 6, 500, '2021-05-01', 1, 1, '2021-05-01 09:59'),
(6, 6, 5, 250, '2021-05-01', 1, 1, '2021-05-01 09:59'),
(7, 12, 4, 1700, '2021-05-01', 1, 1, '2021-05-01 10:00'),
(8, 7, 3, 500, '2021-05-01', 1, 1, '2021-05-01 10:01'),
(9, 7, 3, 1000, '2021-05-01', 1, 1, '2021-05-01 10:01'),
(10, 2, 2, 1600, '2021-05-01', 1, 1, '2021-05-01 10:01'),
(11, 3, 1, 250, '2021-05-01', 1, 1, '2021-05-01 10:02'),
(12, 1, 1, 400, '2021-05-01', 1, 1, '2021-05-01 10:02'),
(13, 9, 7, 350, '2021-05-01', 1, 1, '2021-05-01 10:59'),
(14, 14, 7, 350, '2021-05-01', 1, 1, '2021-05-01 12:54'),
(15, 21, 4, 500, '2021-05-08', 1, 14, '2021-05-08 14:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_upozilla`
--

CREATE TABLE `tbl_upozilla` (
  `id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `zilla_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_upozilla`
--

INSERT INTO `tbl_upozilla` (`id`, `division_id`, `zilla_id`, `name`) VALUES
(1, 1, 1, 'সাভার'),
(2, 1, 1, 'ধামরাই'),
(3, 1, 1, 'কেরাণীগঞ্জ'),
(4, 1, 1, 'নবাবগঞ্জ'),
(5, 1, 1, 'দোহার'),
(6, 1, 1, 'তেজগাঁও উন্নয়ন সার্কেল'),
(7, 1, 2, 'কালীগঞ্জ'),
(8, 1, 2, 'কালিয়াকৈর'),
(9, 1, 2, 'কাপাসিয়া'),
(10, 1, 2, 'গাজীপুর সদর'),
(11, 1, 2, 'শ্রীপুর'),
(12, 1, 3, 'বাসাইল'),
(13, 1, 3, 'ভুয়াপুর'),
(14, 1, 3, 'ঘাটাইল'),
(15, 1, 3, 'দেলদুয়ার'),
(16, 1, 3, 'গোপালপুর'),
(17, 1, 3, 'মধুপুর'),
(18, 1, 3, 'মির্জাপুর'),
(19, 1, 3, 'নাগরপুর'),
(20, 1, 3, 'সখিপুর'),
(21, 1, 3, 'টাঙ্গাইল সদর'),
(22, 1, 3, 'কালিহাতী'),
(23, 1, 3, 'ধনবাড়ি'),
(24, 1, 4, 'আড়াইহাজার'),
(25, 1, 4, 'বন্দর'),
(26, 1, 4, 'নারায়ণগঞ্জ সদর'),
(27, 1, 4, 'রূপগঞ্জ'),
(28, 1, 4, 'সোনারগাঁ'),
(29, 1, 5, 'ইটনা'),
(30, 1, 5, 'কটিয়াদি'),
(31, 1, 5, 'ভৈরব'),
(32, 1, 5, 'হোসেনপুর'),
(33, 1, 5, 'তাড়াইল'),
(34, 1, 5, 'পাকুন্দিয়া'),
(35, 1, 5, 'কুলিয়ারচর'),
(36, 1, 5, 'কিশোরগঞ্জ সদর'),
(37, 1, 5, 'করিমগঞ্জ'),
(38, 1, 5, 'বাজিতপুর'),
(39, 1, 5, 'অষ্টগ্রাম'),
(40, 1, 5, 'মিঠামইন'),
(41, 1, 5, 'নিকলী'),
(42, 1, 6, 'বেলাবো'),
(43, 1, 6, 'মনোহরদী'),
(44, 1, 6, 'নরসিংদী সদর'),
(45, 1, 6, 'পলাশ'),
(46, 1, 6, 'রায়পুরা'),
(47, 1, 6, 'শিবপুর'),
(48, 1, 7, 'রাজবাড়ী সদর'),
(49, 1, 7, 'গোয়ালন্দ'),
(50, 1, 7, 'পাংশা'),
(51, 1, 7, 'বালিয়াকান্দি'),
(52, 1, 7, 'কালুখালী'),
(53, 1, 8, 'ফরিদপুর সদর'),
(54, 1, 8, 'আলফাডাঙ্গা'),
(55, 1, 8, 'বোয়ালমারী'),
(56, 1, 8, 'সদরপুর'),
(57, 1, 8, 'নগরকান্দা'),
(58, 1, 8, 'ভাঙ্গা'),
(59, 1, 8, 'চরভদ্রাসন'),
(60, 1, 8, 'মধুখালী'),
(61, 1, 8, 'সালথা'),
(62, 1, 9, 'মাদারীপুর সদর'),
(63, 1, 9, 'শিবচর'),
(64, 1, 9, 'কালকিনি'),
(65, 1, 9, 'রাজৈর'),
(66, 1, 10, 'গোপালগঞ্জ সদর'),
(67, 1, 10, 'কাশিয়ানী'),
(68, 1, 10, 'টুংগীপাড়া'),
(69, 1, 10, 'কোটালীপাড়া'),
(70, 1, 10, 'মুকসুদপুর'),
(71, 1, 11, 'মুন্সিগঞ্জ সদর'),
(72, 1, 11, 'শ্রীনগর'),
(73, 1, 11, 'সিরাজদিখান'),
(74, 1, 11, 'লৌহজং '),
(75, 1, 11, 'গজারিয়া'),
(76, 1, 11, 'টংগিবাড়ী'),
(77, 1, 12, 'হরিরামপুর'),
(78, 1, 12, 'সাটুরিয়া'),
(79, 1, 12, 'মানিকগঞ্জ সদর'),
(80, 1, 12, 'ঘিওর'),
(81, 1, 12, 'শিবালয়'),
(82, 1, 12, 'দৌলতপুর'),
(83, 1, 12, 'সিংগাইর'),
(84, 1, 13, 'শরিয়তপুর সদর'),
(85, 1, 13, 'নড়িয়া'),
(86, 1, 13, 'জাজিরা'),
(87, 1, 13, 'গোসাইরহাট'),
(88, 1, 13, 'ভেদরগঞ্জ'),
(89, 1, 13, 'ডামুড্যা'),
(90, 2, 14, 'পবা'),
(91, 2, 14, 'দুর্গাপুর'),
(92, 2, 14, 'মোহনপুর'),
(93, 2, 14, 'চারঘাট'),
(94, 2, 14, 'পুঠিয়া'),
(95, 2, 14, 'বাঘা'),
(96, 2, 14, 'গোদাগাড়ী'),
(97, 2, 14, 'তানোর'),
(98, 2, 14, 'বাঘমারা'),
(99, 2, 15, 'বেলকুচি'),
(100, 2, 15, 'চৌহালি'),
(101, 2, 15, 'কামারখন্দ'),
(102, 2, 15, 'কাজীপুর'),
(103, 2, 15, 'রায়গঞ্জ'),
(104, 2, 15, 'শাহজাদপুর'),
(105, 2, 15, 'সিরাজগঞ্জ সদর'),
(106, 2, 15, 'তাড়াশ'),
(107, 2, 15, 'উল্লাপাড়া'),
(108, 2, 16, 'সুজানগর'),
(109, 2, 16, 'ঈশ্বরদী'),
(110, 2, 16, 'ভাঙ্গুরা'),
(111, 2, 16, 'পাবনা সদর'),
(112, 2, 16, 'বেড়া'),
(113, 2, 16, 'আটঘরিয়া'),
(114, 2, 16, 'চাটমোহর'),
(115, 2, 16, 'সাঁথিয়া'),
(116, 2, 16, 'ফরিদপুর'),
(117, 2, 17, 'কাহালু'),
(118, 2, 17, 'বগুড়া সদর'),
(119, 2, 17, 'সারিয়াকান্দি'),
(120, 2, 17, 'শাজাহানপুর'),
(121, 2, 17, 'দুপচাঁচিয়া'),
(122, 2, 17, 'আদমদিঘি'),
(123, 2, 17, 'নন্দিগ্রাম'),
(124, 2, 17, 'সোনাতলা'),
(125, 2, 17, 'ধুনট'),
(126, 2, 17, 'গাবতলী'),
(127, 2, 17, 'শেরপুর'),
(128, 2, 17, 'শিবগঞ্জ'),
(129, 2, 18, 'চাঁপাইনবাবগঞ্জ সদর'),
(130, 2, 18, 'গোমস্তাপুর'),
(131, 2, 18, 'নাচোল'),
(132, 2, 18, 'ভোলাহাট'),
(133, 2, 18, 'শিবগঞ্জ'),
(134, 2, 19, 'আক্কেলপুর'),
(135, 2, 19, 'কালাই'),
(136, 2, 19, 'ক্ষেতলাল'),
(137, 2, 19, 'পাঁচবিবি'),
(138, 2, 19, 'জয়পুরহাট সদর'),
(139, 2, 20, 'মহাদেবপুর'),
(140, 2, 20, 'বদলগাছী'),
(141, 2, 20, 'পত্নিতলা'),
(142, 2, 20, 'ধামইরহাট'),
(143, 2, 20, 'নিয়ামতপুর'),
(144, 2, 20, 'মান্দা'),
(145, 2, 20, 'আত্রাই'),
(146, 2, 20, 'রাণীনগর'),
(147, 2, 20, 'নওগাঁ সদর'),
(148, 2, 20, 'সাপাহার'),
(149, 2, 20, 'পোরশা'),
(150, 2, 21, 'নাটোর সদর'),
(151, 2, 21, 'সিংড়া'),
(152, 2, 21, 'বড়াইগ্রাম'),
(153, 2, 21, 'বাগাতিপাড়া'),
(154, 2, 21, 'গুরুদাসপুর'),
(155, 2, 21, 'লালপুর'),
(156, 2, 21, 'নলডাঙ্গা'),
(157, 3, 22, 'রাঙ্গুনিয়া'),
(158, 3, 22, 'সীতাকুণ্ড'),
(159, 3, 22, 'মীরসরাই'),
(160, 3, 22, 'পটিয়া'),
(161, 3, 22, 'সন্দ্বীপ'),
(162, 3, 22, 'বাঁশখালী'),
(163, 3, 22, 'বোয়ালখালী'),
(164, 3, 22, 'আনোয়ারা'),
(165, 3, 22, 'সাতকানিয়া'),
(166, 3, 22, 'লোহাগাড়া'),
(167, 3, 22, 'হাটহাজারী'),
(168, 3, 22, 'ফটিকছড়ি'),
(169, 3, 22, 'রাঊজান'),
(170, 3, 22, 'চন্দনাইশ'),
(171, 3, 23, 'দেবিদ্বার'),
(172, 3, 23, 'বরুড়া'),
(173, 3, 23, 'ব্রাহ্মণপাড়া'),
(174, 3, 23, 'চান্দিনা'),
(175, 3, 23, 'চৌদ্দগ্রাম'),
(176, 3, 23, 'দাউদকান্দি'),
(177, 3, 23, 'হোমনা'),
(178, 3, 23, 'লাকসাম'),
(179, 3, 23, 'মুরাদনগর'),
(180, 3, 23, 'নাঙ্গলকোট'),
(181, 3, 23, 'কুমিল্লা সদর'),
(182, 3, 23, 'মেঘনা'),
(183, 3, 23, 'মনোহরগঞ্জ'),
(184, 3, 23, 'সদর দক্ষিণ'),
(185, 3, 23, 'তিতাস'),
(186, 3, 23, 'বুড়িচং'),
(187, 3, 24, 'ছাগলনাইয়া'),
(188, 3, 24, 'ফেনী সদর'),
(189, 3, 24, 'সোনাগাজী'),
(190, 3, 24, 'ফুলগাজী'),
(191, 3, 24, 'পরশুরাম'),
(192, 3, 24, 'দাগনভুঞা'),
(193, 3, 25, 'ব্রাহ্মণবাড়িয়া সদর'),
(194, 3, 25, 'কসবা'),
(195, 3, 25, 'নাসিরনগর'),
(196, 3, 25, 'সরাইল'),
(197, 3, 25, 'আশুগঞ্জ'),
(198, 3, 25, 'আখাউরা'),
(199, 3, 25, 'নবীনগর'),
(200, 3, 25, 'বাঞ্ছারামপুর'),
(201, 3, 25, 'বিজয়নগর'),
(202, 3, 26, 'রাঙ্গামাটি সদর'),
(203, 3, 26, 'কাপ্তাই'),
(204, 3, 26, 'কাউখালী'),
(205, 3, 26, 'বাঘাইছড়ি'),
(206, 3, 26, 'বরকল'),
(207, 3, 26, 'লংগদু'),
(208, 3, 26, 'রাজস্থলী'),
(209, 3, 26, 'বিলাইছড়ি'),
(210, 3, 26, 'জুরাছড়ি'),
(211, 3, 26, 'নানিয়ারচর'),
(212, 3, 27, 'হাইমচর'),
(213, 3, 27, 'কচুয়া'),
(214, 3, 27, 'শহরাস্তি'),
(215, 3, 27, 'চাঁদপুর সদর'),
(216, 3, 27, 'মতলব উত্তর'),
(217, 3, 27, 'ফরিদ্গঞ্জ'),
(218, 3, 27, 'মতলব দক্ষিণ'),
(219, 3, 27, 'হাজীগঞ্জ'),
(220, 3, 28, 'নোয়াখালী সদর'),
(221, 3, 28, 'কোম্পানীগঞ্জ'),
(222, 3, 28, 'বেগমগঞ্জ'),
(223, 3, 28, 'হাতিয়া'),
(224, 3, 28, 'সুবর্ণচর'),
(225, 3, 28, 'কবিরহাট'),
(226, 3, 28, 'সেনবাগ'),
(227, 3, 28, 'চাটখিল'),
(228, 3, 28, 'সোনাইমুড়ী'),
(229, 3, 29, 'লক্ষ্মীপুর সদর'),
(230, 3, 29, 'কমলনগর'),
(231, 3, 29, 'রায়পুর'),
(232, 3, 29, 'রামগতি'),
(233, 3, 29, 'রামগঞ্জ'),
(234, 3, 30, 'কক্সবাজার সদর'),
(235, 3, 30, 'চকরিয়া'),
(236, 3, 30, 'কুতুবদিয়া'),
(237, 3, 30, 'উখিয়া'),
(238, 3, 30, 'মহেশখালী'),
(239, 3, 30, 'পেকুয়া'),
(240, 3, 30, 'রামু'),
(241, 3, 30, 'টেকনাফ'),
(242, 3, 31, 'খাগড়াছড়ি সদর'),
(243, 3, 31, 'দিঘীনালা'),
(244, 3, 31, 'পানছড়ি'),
(245, 3, 31, 'লক্ষীছড়ি'),
(246, 3, 31, 'মহালছড়ি'),
(247, 3, 31, 'মানিকছড়ি'),
(248, 3, 31, 'রামগড়'),
(249, 3, 31, 'মাটিরাঙ্গা'),
(250, 3, 31, 'গুইমারা'),
(251, 3, 32, 'বান্দরবান সদর'),
(252, 3, 32, 'আলীকদম'),
(253, 3, 32, 'নাইক্ষ্যংছড়ি'),
(254, 3, 32, 'রোয়াংছড়ি'),
(255, 3, 32, 'লামা'),
(256, 3, 32, 'রুমা'),
(257, 3, 32, 'থানচি'),
(258, 4, 33, 'বালাগঞ্জ'),
(259, 4, 33, 'বিয়ানীবাজার'),
(260, 4, 33, 'বিশ্বনাথ'),
(261, 4, 33, 'কোম্পানীগঞ্জ'),
(262, 4, 33, 'ফেঞ্চুগঞ্জ'),
(263, 4, 33, 'গোলাপগঞ্জ'),
(264, 4, 33, 'গোয়াইনঘাট'),
(265, 4, 33, 'জৈন্তাপুর'),
(266, 4, 33, 'কানাইঘাট'),
(267, 4, 33, 'সিলেট সদর'),
(268, 4, 33, 'জকিগঞ্জ'),
(269, 4, 33, 'দক্ষিণ সুরমা'),
(270, 4, 33, 'ওসমানী নগর'),
(271, 4, 34, 'বড়লেখা'),
(272, 4, 34, 'কমলগঞ্জ'),
(273, 4, 34, 'কুলাউরা'),
(274, 4, 34, 'মৌলভীবাজার সদর '),
(275, 4, 34, 'রাজনগর'),
(276, 4, 34, 'শ্রীমঙ্গল'),
(277, 4, 34, 'জুড়ী'),
(278, 4, 35, 'নবীগঞ্জ'),
(279, 4, 35, 'বাহুবল'),
(280, 4, 35, 'আজমিরীগঞ্জ'),
(281, 4, 35, 'বানিয়াচং'),
(282, 4, 35, 'লাখাই'),
(283, 4, 35, 'চুনারুঘাট'),
(284, 4, 35, 'হবিগঞ্জ সদর'),
(285, 4, 35, 'মাধবপুর'),
(286, 4, 36, 'সুনামগঞ্জ সদর'),
(287, 4, 36, 'দক্ষিণ সুনামগঞ্জ'),
(288, 4, 36, 'বিশ্বম্ভরপুর'),
(289, 4, 36, 'ছাতক'),
(290, 4, 36, 'জগন্নাথপুর'),
(291, 4, 36, 'তাহিরপুর'),
(292, 4, 36, 'ধর্মপাশা'),
(293, 4, 36, 'জামালগঞ্জ'),
(294, 4, 36, 'শাল্লা'),
(295, 4, 36, 'দিরাই'),
(296, 4, 36, 'দোয়ারাবাজার'),
(297, 5, 37, 'পাইকগাছা'),
(298, 5, 37, 'ফুলতলা'),
(299, 5, 37, 'দিঘলিয়া'),
(300, 5, 37, 'রূপসা'),
(301, 5, 37, 'তেরখাদা'),
(302, 5, 37, 'ডুমুরিয়া'),
(303, 5, 37, 'বটিয়াঘাটা'),
(304, 5, 37, 'দাকোপ'),
(305, 5, 37, 'কয়রা'),
(306, 5, 38, 'মণিরামপুর'),
(307, 5, 38, 'অভয়নগর'),
(308, 5, 38, 'বাঘারপাড়া'),
(309, 5, 38, 'চৌগাছা'),
(310, 5, 38, 'ঝিকরগাছা'),
(311, 5, 38, 'কেশবপুর'),
(312, 5, 38, 'যশোর সদর'),
(313, 5, 38, 'শার্শা'),
(314, 5, 39, 'আশাশুনি'),
(315, 5, 39, 'দেবহাটা'),
(316, 5, 39, 'কলারোয়া'),
(317, 5, 39, 'সাতক্ষীরা সদর'),
(318, 5, 39, 'শ্যামনগর'),
(319, 5, 39, 'তালা'),
(320, 5, 39, 'কালিগঞ্জ'),
(321, 5, 40, 'মুজিবনগর'),
(322, 5, 40, 'মেহেরপুর সদর'),
(323, 5, 40, 'গাংনী'),
(324, 5, 41, 'নড়াইল সদর'),
(325, 5, 41, 'লোহাগড়া'),
(326, 5, 41, 'কালিয়া'),
(327, 5, 42, 'চুয়াডাঙ্গা সদর'),
(328, 5, 42, 'আলমডাঙ্গা'),
(329, 5, 42, 'দামুড়হুদা'),
(330, 5, 42, 'জীবননগর'),
(331, 5, 43, 'শালিখা'),
(332, 5, 43, 'শ্রীপুর'),
(333, 5, 43, 'মাগুরা সদর'),
(334, 5, 43, 'মহম্মদপুর'),
(335, 5, 44, 'ফকিরহাট'),
(336, 5, 44, 'বাগেরহাট সদর'),
(337, 5, 44, 'মোল্লাহাট'),
(338, 5, 44, 'শরণখোলা'),
(339, 5, 44, 'রামপাল'),
(340, 5, 44, 'মোড়েলগঞ্জ'),
(341, 5, 44, 'কচুয়া'),
(342, 5, 44, 'মোংলা'),
(343, 5, 44, 'চিতলমারী'),
(344, 5, 45, 'ঝিনাইদহ সদর'),
(345, 5, 45, 'শৈলকুপা'),
(346, 5, 45, 'হরিণাকুণ্ডু '),
(347, 5, 45, 'কালীগঞ্জ'),
(348, 5, 45, 'কোটচাঁদপুর'),
(349, 5, 45, 'মহেশপুর'),
(350, 5, 46, 'কুষ্টিয়া সদর'),
(351, 5, 46, 'কুমারখালী'),
(352, 5, 46, 'খোকসা'),
(353, 5, 46, 'মিরপুর'),
(354, 5, 46, 'দৌলতপুর'),
(355, 5, 46, 'ভেড়ামারা'),
(356, 6, 47, 'বরিশাল সদর'),
(357, 6, 47, 'বাকেরগঞ্জ'),
(358, 6, 47, 'বাবুগঞ্জ'),
(359, 6, 47, 'উজিরপুর'),
(360, 6, 47, 'বানারীপাড়া'),
(361, 6, 47, 'গৌরনদী'),
(362, 6, 47, 'আগৈলঝাড়া'),
(363, 6, 47, 'মেহেন্দিগঞ্জ'),
(364, 6, 47, 'মুলাদী'),
(365, 6, 47, 'হিজলা'),
(366, 6, 48, 'ঝালকাঠি সদর'),
(367, 6, 48, 'কাঠালিয়া'),
(368, 6, 48, 'নলছিটি'),
(369, 6, 48, 'রাজাপুর'),
(370, 6, 49, 'বাউফল'),
(371, 6, 49, 'পটুয়াখালী সদর'),
(372, 6, 49, 'দুমকি'),
(373, 6, 49, 'দশমিনা'),
(374, 6, 49, 'কলাপাড়া'),
(375, 6, 49, 'মির্জাগঞ্জ'),
(376, 6, 49, 'গলাচিপা'),
(377, 6, 49, 'রাঙ্গাবালী'),
(378, 6, 50, 'পিরোজপুর সদর'),
(379, 6, 50, 'নাজিরপুর'),
(380, 6, 50, 'কাউখালী'),
(381, 6, 50, 'জিয়ানগর'),
(382, 6, 50, 'ভান্ডারিয়া'),
(383, 6, 50, 'মঠবাড়ীয়া'),
(384, 6, 50, 'নেছারাবাদ'),
(385, 6, 51, 'ভোলা সদর'),
(386, 6, 51, 'বোরহানউদ্দিন'),
(387, 6, 51, 'চরফ্যাশন'),
(388, 6, 51, 'দৌলতখান'),
(389, 6, 51, 'মনপুরা'),
(390, 6, 51, 'তজুমদ্দিন'),
(391, 6, 51, 'লালমোহন'),
(392, 6, 52, 'আমতলী'),
(393, 6, 52, 'বরগুনা সদর'),
(394, 6, 52, 'বেতাগী'),
(395, 6, 52, 'বামনা'),
(396, 6, 52, 'পাথরঘাটা'),
(397, 6, 52, 'তালতলি'),
(398, 7, 53, 'রংপুর সদর'),
(399, 7, 53, 'গঙ্গাচড়া'),
(400, 7, 53, 'তারাগঞ্জ'),
(401, 7, 53, 'বদরগঞ্জ'),
(402, 7, 53, 'মিঠাপুকুর'),
(403, 7, 53, 'কাউনিয়া'),
(404, 7, 53, 'পীরগঞ্জ'),
(405, 7, 53, 'পীরগাছা'),
(406, 7, 54, 'লালমনিরহাট সদর'),
(407, 7, 54, 'আদিতমারী'),
(408, 7, 54, 'কালীগঞ্জ'),
(409, 7, 54, 'হাতীবান্ধা'),
(410, 7, 54, 'পাটগ্রাম'),
(411, 7, 55, 'পঞ্চগড় সদর'),
(412, 7, 55, 'দেবীগঞ্জ'),
(413, 7, 55, 'বোদা'),
(414, 7, 55, 'আটোয়ারী'),
(415, 7, 55, 'তেতুলিয়া'),
(416, 7, 56, 'কুড়িগ্রাম সদর'),
(417, 7, 56, 'নাগেশ্বরী'),
(418, 7, 56, 'ভুরুঙ্গামারী'),
(419, 7, 56, 'ফুলবাড়ী'),
(420, 7, 56, 'রাজারহাট'),
(421, 7, 56, 'উলিপুর'),
(422, 7, 56, 'চিলমারী'),
(423, 7, 56, 'রৌমারী'),
(424, 7, 56, 'চর রাজিবপুর'),
(425, 7, 57, 'নবাবগঞ্জ'),
(426, 7, 57, 'বীরগঞ্জ'),
(427, 7, 57, 'ঘোড়াঘাট'),
(428, 7, 57, 'বিরামপুর'),
(429, 7, 57, 'পার্বতীপুর'),
(430, 7, 57, 'বোচাগঞ্জ'),
(431, 7, 57, 'কাহারোল'),
(432, 7, 57, 'ফুলবাড়ী'),
(433, 7, 57, 'দিনাজপুর সদর'),
(434, 7, 57, 'হাকিমপুর'),
(435, 7, 57, 'খানসামা'),
(436, 7, 57, 'বিরল'),
(437, 7, 57, 'চিরিরবন্দর'),
(438, 7, 58, 'ঠাকুরগাঁও সদর'),
(439, 7, 58, 'পীরগঞ্জ'),
(440, 7, 58, 'রাণীশংকৈল'),
(441, 7, 58, 'হরিপুর'),
(442, 7, 58, 'বালিয়াডাঙ্গী'),
(443, 7, 59, 'সাদুল্লাপুর'),
(444, 7, 59, 'গাইবান্ধা সদর'),
(445, 7, 59, 'পলাশবাড়ী'),
(446, 7, 59, 'সাঘাটা'),
(447, 7, 59, 'গোবিন্দগঞ্জ'),
(448, 7, 59, 'সুন্দরগঞ্জ'),
(449, 7, 59, 'ফুলছড়ি'),
(450, 7, 60, 'সৈয়দপুর'),
(451, 7, 60, 'ডোমার'),
(452, 7, 60, 'ডিমলা'),
(453, 7, 60, 'জলঢাকা'),
(454, 7, 60, 'কিশোরগঞ্জ'),
(455, 7, 60, 'নীলফামারী সদর'),
(456, 8, 61, 'ফুলবাড়ীয়া '),
(457, 8, 61, 'ত্রিশাল'),
(458, 8, 61, 'ভালুকা'),
(459, 8, 61, 'মুক্তাগাছা'),
(460, 8, 61, 'ময়মনসিংহ সদর'),
(461, 8, 61, 'ধোবাউরা'),
(462, 8, 61, 'ফুলপুর'),
(463, 8, 61, 'হালুয়াঘাট'),
(464, 8, 61, 'গৌরীপুর'),
(465, 8, 61, 'গফরগাঁও'),
(466, 8, 61, 'ঈশ্বরগঞ্জ'),
(467, 8, 61, 'নান্দাইল'),
(468, 8, 61, 'তারাকান্দা'),
(469, 8, 62, 'জামালপুর সদর'),
(470, 8, 62, 'মেলান্দহ'),
(471, 8, 62, 'ইসলামপুর'),
(472, 8, 62, 'দেওয়ানগঞ্জ'),
(473, 8, 62, 'সরিষাবাড়ী'),
(474, 8, 62, 'মাদারগঞ্জ'),
(475, 8, 62, 'বকশীগঞ্জ'),
(476, 8, 63, 'বারহাট্টা'),
(477, 8, 63, 'দুর্গাপুর'),
(478, 8, 63, 'কেন্দুয়া'),
(479, 8, 63, 'আটপাড়া'),
(480, 8, 63, 'মদন'),
(481, 8, 63, 'খালিয়াজুরী'),
(482, 8, 63, 'কলমাকান্দা'),
(483, 8, 63, 'মোহনগঞ্জ'),
(484, 8, 63, 'পূর্বধলা'),
(485, 8, 63, 'নেত্রকোনা সদর'),
(486, 8, 64, 'শেরপুর সদর'),
(487, 8, 64, 'নালিতাবাড়ী'),
(488, 8, 64, 'শ্রীবরদী'),
(489, 8, 64, 'নকলা'),
(490, 8, 64, 'ঝিনাইগাতী'),
(491, 1, 1, 'ঢাকা মহানগর');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_zilla`
--

CREATE TABLE `tbl_zilla` (
  `id` int(11) NOT NULL,
  `divission_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_zilla`
--

INSERT INTO `tbl_zilla` (`id`, `divission_id`, `name`) VALUES
(1, 1, 'ঢাকা'),
(2, 1, 'গাজীপুর'),
(3, 1, 'টাঙ্গাইল'),
(4, 1, 'নারায়ণগঞ্জ'),
(5, 1, 'কিশোরগঞ্জ'),
(6, 1, 'নরসিংদী'),
(7, 1, 'রাজবাড়ী'),
(8, 1, 'ফরিদপুর'),
(9, 1, 'মাদারীপুর'),
(10, 1, 'গোপালগঞ্জ'),
(11, 1, 'মুন্সিগঞ্জ'),
(12, 1, 'মানিকগঞ্জ'),
(13, 1, 'শরীয়তপুর'),
(14, 2, 'রাজশাহী'),
(15, 2, 'সিরাজগঞ্জ'),
(16, 2, 'পাবনা'),
(17, 2, 'বগুড়া'),
(18, 2, 'চাঁপাইনবাবগঞ্জ'),
(19, 2, 'জয়পুরহাট'),
(20, 2, 'নওগাঁ'),
(21, 2, 'নাটোর'),
(22, 3, 'চট্টগ্রাম'),
(23, 3, 'কুমিল্লা'),
(24, 3, 'ফেনী'),
(25, 3, 'ব্রাহ্মণবাড়িয়া'),
(26, 3, 'রাঙ্গামাটি'),
(27, 3, 'চাঁদপুর'),
(28, 3, 'নোয়াখালী'),
(29, 3, 'লক্ষ্মীপুর'),
(30, 3, 'কক্সবাজার'),
(31, 3, 'খাগড়াছড়ি'),
(32, 3, 'বান্দরবান'),
(33, 4, 'সিলেট'),
(34, 4, 'মৌলভীবাজার'),
(35, 4, 'হবিগঞ্জ'),
(36, 4, 'সুনামগঞ্জ'),
(37, 5, 'খুলনা'),
(38, 5, 'যশোর'),
(39, 5, 'সাতক্ষীরা'),
(40, 5, 'মেহেরপুর'),
(41, 5, 'নড়াইল'),
(42, 5, 'চুয়াডাঙ্গা'),
(43, 5, 'মাগুড়া'),
(44, 5, 'বাগেরহাট'),
(45, 5, 'ঝিনাইদহ'),
(46, 5, 'কুষ্টিয়া'),
(47, 6, 'বরিশাল'),
(48, 6, 'ঝালকাঠি'),
(49, 6, 'পটুয়াখালী'),
(50, 6, 'পিরোজপুর'),
(51, 6, 'ভোলা'),
(52, 6, 'বরগুনা'),
(53, 7, 'রংপুর'),
(54, 7, 'লালমনিরহাট'),
(55, 7, 'পঞ্চগড়'),
(56, 7, 'কুড়িগ্রাম'),
(57, 7, 'দিনাজপুর'),
(58, 7, 'ঠাকুরগাঁও'),
(59, 7, 'গাইবান্ধা'),
(60, 7, 'নীলফামারী'),
(61, 8, 'ময়মনসিংহ'),
(62, 8, 'জামালপুর'),
(63, 8, 'নেত্রকোনা'),
(64, 8, 'শেরপুর');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `username` varchar(10) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `address` int(11) NOT NULL COMMENT 'thana id',
  `district` varchar(30) NOT NULL,
  `division` varchar(30) NOT NULL,
  `roadHouse` text NOT NULL,
  `postcode` varchar(100) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `phone` text NOT NULL,
  `userType` text NOT NULL,
  `photo` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `birthdate` varchar(10) NOT NULL DEFAULT '0000-00-00',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 for active user, 0 for not active user',
  `emailVerified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 for verify, 0 for not verify',
  `mobileVerified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 for verify, 0 for not verify'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `address`, `district`, `division`, `roadHouse`, `postcode`, `blood_group`, `phone`, `userType`, `photo`, `birthdate`, `status`, `emailVerified`, `mobileVerified`) VALUES
(1, 'rayhan', 'roky', 'roky', 'taslimul4001@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, '', '', '12/6 solimullah road', '', '', '01709372481', 'admin', 'assets/userPhoto/pngtreebusinessmanuseravatarfreevectorpngimage_20210424092551.jpg', '0000-00-00', 1, 0, 0),
(3, 'shoriful', 'islam', 'shoriful', 'shoriful@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 109, '', '', '45/dxbx', '407', 'O-', '01766889900', 'doctor', 'assets/userPhoto/defaultUser.jpg', '08-02-2010', 1, 0, 0),
(4, 'Anil', 'Kumar', 'anil', 'anil@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 261, '', '', '45/dxbx', '407', 'B-', '01766889900', 'accounts', 'assets/userPhoto/pngtreebusinessmanuseravatarfreevectorpngimage_20210509123553.jpg', '09-02-2009', 1, 0, 0),
(5, 'shoriful', 'islam', 'lab', 'shodddriful@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 261, '', '', 'rsaytuasrut', '407', 'B-', '01734578963', 'lab', 'assets/userPhoto/images_20210508153138.png', '28 Aug, 20', 1, 0, 0),
(11, 'oyon', 'islam', 'oyon', 'roky4001@gmail.com', '5c9ab9459306513b971646d9512640660de633b0', 8, '', '', 'qw', '', '', '01700000000', 'doctor', 'assets/userPhoto/images_20210420115305.png', '0000-00-00', 1, 0, 0),
(12, 'taslimul', 'islam', 'xyz', 'xyz@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, '', '', 'assax', '', '', '01846951141', 'doctor', 'assets/userPhoto/defaultUser.jpg', '0000-00-00', 1, 0, 0),
(13, 'oyon', 'islam', 'ASLA2080re', 'dhsajh@shdsajh.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 8, '', '', 'er', '', '', '01700004000', 'doctor', 'assets/userPhoto/defaultUser.jpg', '0000-00-00', 1, 0, 0),
(14, 'shahriar', 'shaan', 'shaan', 'shahriar@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 45454, '1', '1', 'asdsa', '5454', 'b', '01756511351', 'user', 'assets/userPhoto/pngtreebusinessmanuseravatarfreevectorpngimage_20210509123854.jpg', '0000-00-00', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='types of user, each type has single controller';

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `value`, `name`) VALUES
(1, 'user', 'User'),
(3, 'accounts', 'Accounts'),
(4, 'doctor', 'Doctor'),
(5, 'lab', 'Lab');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_status`
--
ALTER TABLE `log_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_recovery`
--
ALTER TABLE `password_recovery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`);

--
-- Indexes for table `tbl_accounts_category`
--
ALTER TABLE `tbl_accounts_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_accounts_details`
--
ALTER TABLE `tbl_accounts_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_activities`
--
ALTER TABLE `tbl_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_common_pages`
--
ALTER TABLE `tbl_common_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tbl_discount_option`
--
ALTER TABLE `tbl_discount_option`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_divission`
--
ALTER TABLE `tbl_divission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_mail_send_setting`
--
ALTER TABLE `tbl_mail_send_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tests`
--
ALTER TABLE `tbl_tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`);

--
-- Indexes for table `tbl_tests_details`
--
ALTER TABLE `tbl_tests_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_test_category`
--
ALTER TABLE `tbl_test_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_test_name`
--
ALTER TABLE `tbl_test_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_test_payment`
--
ALTER TABLE `tbl_test_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_upozilla`
--
ALTER TABLE `tbl_upozilla`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_zilla`
--
ALTER TABLE `tbl_zilla`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_status`
--
ALTER TABLE `log_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_recovery`
--
ALTER TABLE `password_recovery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_accounts_category`
--
ALTER TABLE `tbl_accounts_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_accounts_details`
--
ALTER TABLE `tbl_accounts_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_activities`
--
ALTER TABLE `tbl_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tbl_common_pages`
--
ALTER TABLE `tbl_common_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_discount_option`
--
ALTER TABLE `tbl_discount_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_divission`
--
ALTER TABLE `tbl_divission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_mail_send_setting`
--
ALTER TABLE `tbl_mail_send_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_tests`
--
ALTER TABLE `tbl_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_tests_details`
--
ALTER TABLE `tbl_tests_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_test_category`
--
ALTER TABLE `tbl_test_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_test_name`
--
ALTER TABLE `tbl_test_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_test_payment`
--
ALTER TABLE `tbl_test_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_upozilla`
--
ALTER TABLE `tbl_upozilla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=492;

--
-- AUTO_INCREMENT for table `tbl_zilla`
--
ALTER TABLE `tbl_zilla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
