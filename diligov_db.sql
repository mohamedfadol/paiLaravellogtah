-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 23, 2024 at 06:00 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diligov_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `action_trackers`
--

DROP TABLE IF EXISTS `action_trackers`;
CREATE TABLE IF NOT EXISTS `action_trackers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tasks` longtext COLLATE utf8mb4_unicode_ci,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  `date_assigned` datetime DEFAULT NULL,
  `date_due` datetime DEFAULT NULL,
  `action_status` enum('DELAYED','CANCELED','ONGOING','NOTSTARTED','COMPLETE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ONGOING',
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `meeting_id` bigint UNSIGNED DEFAULT NULL,
  `agenda_detail_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `action_trackers_member_id_foreign` (`member_id`),
  KEY `action_trackers_meeting_id_foreign` (`meeting_id`),
  KEY `action_trackers_agenda_detail_id_foreign` (`agenda_detail_id`),
  KEY `action_trackers_business_id_foreign` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `action_trackers`
--

INSERT INTO `action_trackers` (`id`, `tasks`, `note`, `date_assigned`, `date_due`, `action_status`, `member_id`, `meeting_id`, `agenda_detail_id`, `deleted_at`, `created_at`, `updated_at`, `business_id`) VALUES
(1, 'sxsx', 'text action', '2024-03-13 20:35:44', '2024-03-23 12:00:00', 'ONGOING', 1, 18, 1, NULL, '2024-03-13 17:35:44', '2024-03-16 15:34:51', 1),
(2, 'ssss', 'fd', '2024-03-16 18:26:22', '2024-03-16 12:00:00', 'ONGOING', 1, 18, 2, NULL, '2024-03-16 15:26:22', '2024-03-16 16:29:21', 1),
(3, 'ssss', 'hhhhh', '2024-03-16 18:27:38', '2024-03-17 12:00:00', 'DELAYED', 1, 19, 2, NULL, '2024-03-16 15:27:38', '2024-03-16 18:37:39', 1),
(4, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'tetsd', '2024-03-17 18:43:22', '2024-03-18 12:00:00', 'ONGOING', 1, 34, 3, NULL, '2024-03-17 15:43:22', '2024-03-17 23:11:26', 1),
(5, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', NULL, '2024-03-17 18:43:27', NULL, 'ONGOING', NULL, 34, 3, NULL, '2024-03-17 15:43:27', '2024-03-17 15:43:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `log_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `causer_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `business_id` int DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `agendas`
--

DROP TABLE IF EXISTS `agendas`;
CREATE TABLE IF NOT EXISTS `agendas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `agenda_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agenda_description` longtext COLLATE utf8mb4_unicode_ci,
  `agenda_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agenda_presenter` int DEFAULT NULL,
  `agenda_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `meeting_id` bigint UNSIGNED DEFAULT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_full_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agendas_meeting_id_foreign` (`meeting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `agendas`
--

INSERT INTO `agendas` (`id`, `agenda_title`, `agenda_description`, `agenda_time`, `agenda_presenter`, `agenda_file`, `created_by`, `deleted_at`, `created_at`, `updated_at`, `meeting_id`, `file_name`, `file_full_path`) VALUES
(18, 'agenda meeting one', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 18, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(19, 'agenda meeting 2', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 19, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(20, 'agenda meeting one', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 18, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(21, 'agenda meeting 2', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 19, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(22, 'agenda meeting one', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 23, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(23, 'agenda meeting 2', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 23, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(24, 'agenda meeting one', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 20, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(25, 'agenda meeting 2', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 20, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(26, 'agenda meeting one', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 18, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(27, 'agenda meeting 2', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 19, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(28, 'agenda meeting one', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 18, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(29, 'agenda meeting 2', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 19, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(30, 'agenda meeting one', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 20, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(31, 'agenda meeting 2', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 21, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(32, 'agenda meeting one', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 21, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(33, 'agenda meeting 2', 'test', 'test', 0, '1710509842.tapo.pdf', 1, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 21, 'tapo.pdf', 'meetings/boards/1710509842.tapo.pdf'),
(34, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley ', 'Lorem Ipsum is simply dummy text of the printing and typesetting ind', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 0, '1710700916.tapo.pdf', 1, NULL, '2024-03-17 15:41:56', '2024-03-17 15:41:56', 34, 'tapo.pdf', 'meetings/boards/1710700916.tapo.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `agenda_details`
--

DROP TABLE IF EXISTS `agenda_details`;
CREATE TABLE IF NOT EXISTS `agenda_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `missions` longtext COLLATE utf8mb4_unicode_ci,
  `tasks` longtext COLLATE utf8mb4_unicode_ci,
  `reservations` longtext COLLATE utf8mb4_unicode_ci,
  `agenda_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agenda_details_agenda_id_foreign` (`agenda_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `agenda_details`
--

INSERT INTO `agenda_details` (`id`, `missions`, `tasks`, `reservations`, `agenda_id`, `created_at`, `updated_at`) VALUES
(1, 'sxsx', 'sxsx', 'sxsxsx', 1, '2024-03-13 17:35:44', '2024-03-13 17:35:44'),
(2, 'ssss', 'ssss', 'ssss', 18, '2024-03-16 15:26:22', '2024-03-16 15:26:22'),
(3, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 34, '2024-03-17 15:43:22', '2024-03-17 15:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `agenda_meeting`
--

DROP TABLE IF EXISTS `agenda_meeting`;
CREATE TABLE IF NOT EXISTS `agenda_meeting` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `agenda_id` bigint UNSIGNED DEFAULT NULL,
  `meeting_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agenda_meeting_agenda_id_foreign` (`agenda_id`),
  KEY `agenda_meeting_meeting_id_foreign` (`meeting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `annual_audit_reports`
--

DROP TABLE IF EXISTS `annual_audit_reports`;
CREATE TABLE IF NOT EXISTS `annual_audit_reports` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `annual_audit_report_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annual_audit_report_text` longtext COLLATE utf8mb4_unicode_ci,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `audit_status` enum('UNPUBLISHED','PUBLISHED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNPUBLISHED',
  PRIMARY KEY (`id`),
  KEY `annual_audit_reports_business_id_foreign` (`business_id`),
  KEY `annual_audit_reports_created_by_foreign` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `annual_reports`
--

DROP TABLE IF EXISTS `annual_reports`;
CREATE TABLE IF NOT EXISTS `annual_reports` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `annual_report_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annual_report_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annual_report_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annual_report_status` enum('UNPUBLISHED','PUBLISHED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNPUBLISHED',
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `meeting_id` bigint UNSIGNED DEFAULT NULL,
  `add_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `annual_reports_business_id_foreign` (`business_id`),
  KEY `annual_reports_meeting_id_foreign` (`meeting_id`),
  KEY `annual_reports_add_by_foreign` (`add_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_board`
--

DROP TABLE IF EXISTS `attendance_board`;
CREATE TABLE IF NOT EXISTS `attendance_board` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_attended` tinyint(1) NOT NULL DEFAULT '0',
  `attended_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minute_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attendance_board_minute_id_foreign` (`minute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `attendance_board`
--

INSERT INTO `attendance_board` (`id`, `is_attended`, `attended_name`, `position`, `minute_id`, `created_at`, `updated_at`) VALUES
(1, 0, NULL, NULL, 1, '2024-03-13 17:35:44', '2024-03-13 17:35:44'),
(2, 0, NULL, NULL, 2, '2024-03-17 15:43:22', '2024-03-17 15:43:22'),
(3, 0, NULL, NULL, 3, '2024-03-17 15:43:27', '2024-03-17 15:43:27');

-- --------------------------------------------------------

--
-- Table structure for table `boards`
--

DROP TABLE IF EXISTS `boards`;
CREATE TABLE IF NOT EXISTS `boards` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `board_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `term` date DEFAULT NULL,
  `quorum` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fiscal_year` date DEFAULT NULL,
  `charter_board` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charter_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `boards_business_id_foreign` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `boards`
--

INSERT INTO `boards` (`id`, `board_name`, `term`, `quorum`, `fiscal_year`, `charter_board`, `charter_name`, `serial_number`, `business_id`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'A Board', '2027-03-13', '66', '2024-03-13', '1710361804.tapo.pdf', 'tapo.pdf', '1', 1, 0, NULL, '2024-03-13 17:30:04', '2024-03-13 17:30:04');

-- --------------------------------------------------------

--
-- Table structure for table `board_meeting`
--

DROP TABLE IF EXISTS `board_meeting`;
CREATE TABLE IF NOT EXISTS `board_meeting` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `board_id` bigint UNSIGNED DEFAULT NULL,
  `meeting_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `board_meeting_board_id_foreign` (`board_id`),
  KEY `board_meeting_meeting_id_foreign` (`meeting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `board_member`
--

DROP TABLE IF EXISTS `board_member`;
CREATE TABLE IF NOT EXISTS `board_member` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `board_id` bigint UNSIGNED DEFAULT NULL,
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `board_member_board_id_foreign` (`board_id`),
  KEY `board_member_member_id_foreign` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

DROP TABLE IF EXISTS `businesses`;
CREATE TABLE IF NOT EXISTS `businesses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `owner_id` bigint UNSIGNED NOT NULL,
  `time_zone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Asia/Kolkata',
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_format` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y-m-d',
  `time_format` enum('12','24') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '24',
  `created_by` int DEFAULT NULL,
  `landmark` text COLLATE utf8mb4_unicode_ci,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_code` char(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternate_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capital` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `email_settings` text COLLATE utf8mb4_unicode_ci,
  `sms_settings` text COLLATE utf8mb4_unicode_ci,
  `common_settings` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `businesses_owner_id_foreign` (`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `businesses`
--

INSERT INTO `businesses` (`id`, `name`, `start_date`, `owner_id`, `time_zone`, `logo`, `date_format`, `time_format`, `created_by`, `landmark`, `country`, `state`, `city`, `zip_code`, `post_code`, `mobile`, `fax`, `alternate_number`, `email`, `registration_number`, `capital`, `website`, `is_active`, `email_settings`, `sms_settings`, `common_settings`, `created_at`, `updated_at`) VALUES
(1, 'Obtima', '2024-03-13', 1, 'UTC', NULL, 'Y-m-d', '24', NULL, NULL, 'Saudi Arabia', 'amman', 'riyadh', '12211', NULL, '0535447543', NULL, NULL, NULL, '12345677', '1500', NULL, 1, NULL, NULL, NULL, '2024-03-13 17:28:23', '2024-03-13 17:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `business_locations`
--

DROP TABLE IF EXISTS `business_locations`;
CREATE TABLE IF NOT EXISTS `business_locations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_id` bigint UNSIGNED NOT NULL,
  `location_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `landmark` text COLLATE utf8mb4_unicode_ci,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternate_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_field1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_field2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_field3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_field4` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `business_locations_business_id_index` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `business_locations`
--

INSERT INTO `business_locations` (`id`, `business_id`, `location_id`, `name`, `landmark`, `country`, `state`, `city`, `zip_code`, `mobile`, `fax`, `alternate_number`, `email`, `website`, `custom_field1`, `custom_field2`, `custom_field3`, `custom_field4`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '0001', 'Obtima', '', 'Saudi Arabia', 'amman', 'riyadh', '12211', '0535447543', NULL, '', '', '', NULL, NULL, NULL, NULL, 1, NULL, '2024-03-13 17:28:23', '2024-03-13 17:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `committees`
--

DROP TABLE IF EXISTS `committees`;
CREATE TABLE IF NOT EXISTS `committees` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `committee_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charter_committee` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charter_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `board_id` bigint UNSIGNED DEFAULT NULL,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `committees_board_id_foreign` (`board_id`),
  KEY `committees_business_id_foreign` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `committees`
--

INSERT INTO `committees` (`id`, `committee_name`, `charter_committee`, `charter_name`, `serial_number`, `board_id`, `business_id`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'A Commitee', '1710361832.tapo.pdf', 'tapo.pdf', NULL, 1, 1, 0, NULL, '2024-03-13 17:30:32', '2024-03-13 17:30:32');

-- --------------------------------------------------------

--
-- Table structure for table `committee_meeting`
--

DROP TABLE IF EXISTS `committee_meeting`;
CREATE TABLE IF NOT EXISTS `committee_meeting` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `committee_id` bigint UNSIGNED DEFAULT NULL,
  `meeting_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `committee_meeting_committee_id_foreign` (`committee_id`),
  KEY `committee_meeting_meeting_id_foreign` (`meeting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `committee_member`
--

DROP TABLE IF EXISTS `committee_member`;
CREATE TABLE IF NOT EXISTS `committee_member` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `committee_id` bigint UNSIGNED DEFAULT NULL,
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `committee_member_committee_id_foreign` (`committee_id`),
  KEY `committee_member_member_id_foreign` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `criterias`
--

DROP TABLE IF EXISTS `criterias`;
CREATE TABLE IF NOT EXISTS `criterias` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `criteria_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `criteria_text` longtext COLLATE utf8mb4_unicode_ci,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `criterias_business_id_foreign` (`business_id`),
  KEY `criterias_created_by_foreign` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `disclosures`
--

DROP TABLE IF EXISTS `disclosures`;
CREATE TABLE IF NOT EXISTS `disclosures` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `disclosure_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disclosure_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disclosure_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disclosure_type` enum('Competition','Related_Party') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Competition',
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `add_by` bigint UNSIGNED DEFAULT NULL,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `disclosures_member_id_foreign` (`member_id`),
  KEY `disclosures_add_by_foreign` (`add_by`),
  KEY `disclosures_business_id_foreign` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_profile_image` longtext COLLATE utf8mb4_unicode_ci,
  `member_biography` longtext COLLATE utf8mb4_unicode_ci,
  `member_first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `has_vote` tinyint(1) NOT NULL DEFAULT '0',
  `has_signed` tinyint(1) NOT NULL DEFAULT '0',
  `member_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `created_by` int DEFAULT NULL,
  `resoultion_numbers` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `morphable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `morphable_id` bigint UNSIGNED NOT NULL,
  `agree` tinyint(1) NOT NULL DEFAULT '0',
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_member_email_unique` (`member_email`),
  KEY `employees_morphable_type_morphable_id_index` (`morphable_type`,`morphable_id`),
  KEY `employees_business_id_foreign` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `financials`
--

DROP TABLE IF EXISTS `financials`;
CREATE TABLE IF NOT EXISTS `financials` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `financial_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `financial_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `financial_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `meeting_id` bigint UNSIGNED DEFAULT NULL,
  `add_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `financials_business_id_foreign` (`business_id`),
  KEY `financials_meeting_id_foreign` (`meeting_id`),
  KEY `financials_add_by_foreign` (`add_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

DROP TABLE IF EXISTS `meetings`;
CREATE TABLE IF NOT EXISTS `meetings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `meeting_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meeting_description` longtext COLLATE utf8mb4_unicode_ci,
  `meeting_start` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meeting_serial_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meeting_end` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meeting_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meeting_media_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meeting_status` enum('SIGNED','QOURMREACHED','NOTSIGNED','PARTIAL') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NOTSIGNED',
  `meeting_puplished` enum('UNPUBLISHED','PUBLISHED','ARCHIVED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNPUBLISHED',
  `meeting_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_all_days` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `hasNextMeeting` tinyint(1) NOT NULL DEFAULT '0',
  `previous_meeting_id` int DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `committee_id` bigint UNSIGNED DEFAULT NULL,
  `board_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meetings_created_by_foreign` (`created_by`),
  KEY `meetings_business_id_foreign` (`business_id`),
  KEY `meetings_committee_id_foreign` (`committee_id`),
  KEY `meetings_board_id_foreign` (`board_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `meeting_title`, `meeting_description`, `meeting_start`, `meeting_serial_number`, `meeting_end`, `background_color`, `meeting_by`, `meeting_media_name`, `meeting_status`, `meeting_puplished`, `meeting_file`, `is_active`, `is_all_days`, `created_by`, `business_id`, `hasNextMeeting`, `previous_meeting_id`, `deleted_at`, `created_at`, `updated_at`, `committee_id`, `board_id`) VALUES
(18, 'meeting. one', 'test', '2024-03-15 16:36:13', '2024/01', '2024-03-18 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', NULL, 1),
(19, 'meeting. 2', 'test', '2024-03-15 16:36:13', '2024/02', '2024-03-15 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 1, NULL),
(20, 'meeting. 3', 'test', '2024-03-15 16:36:13', '2024/01', '2024-03-18 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', NULL, 1),
(21, 'meeting. 4', 'test', '2024-03-15 16:36:13', '2024/02', '2024-03-15 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', NULL, 1),
(22, 'meeting. 5', 'test', '2024-03-15 16:36:13', '2024/01', '2024-03-18 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 1, NULL),
(23, 'meeting. 6', 'test', '2024-03-15 16:36:13', '2024/02', '2024-03-15 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 1, NULL),
(24, 'meeting. 7', 'test', '2024-03-15 16:36:13', '2024/01', '2024-03-18 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', NULL, 1),
(25, 'meeting. 8', 'test', '2024-03-15 16:36:13', '2024/02', '2024-03-15 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', NULL, 1),
(26, 'meeting. 10', 'test', '2024-03-15 16:36:13', '2024/01', '2024-03-18 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', NULL, 1),
(27, 'meeting. 11', 'test', '2024-03-15 16:36:13', '2024/02', '2024-03-15 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 1, NULL),
(28, 'meeting. 12', 'test', '2024-03-15 16:36:13', '2024/01', '2024-03-18 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', NULL, 1),
(29, 'meeting. 13', 'test', '2024-03-15 16:36:13', '2024/02', '2024-03-15 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 1, NULL),
(30, 'meeting. 14', 'test', '2024-03-15 16:36:13', '2024/01', '2024-03-18 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', NULL, 1),
(31, 'meeting. 15', 'test', '2024-03-15 16:36:13', '2024/02', '2024-03-15 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', 1, NULL),
(32, 'meeting. 16', 'test', '2024-03-15 16:36:13', '2024/01', '2024-03-18 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', NULL, 1),
(33, 'meeting. 17', 'test', '2024-03-15 16:36:13', '2024/02', '2024-03-15 18:36:13', NULL, 'test', 'tesr', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-15 10:37:22', '2024-03-15 10:37:22', NULL, 1),
(34, 'meeting test', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', '2024-03-26 08:38:00', '2024/03', '2024-03-28 13:38:00', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley ', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley ', 'NOTSIGNED', 'UNPUBLISHED', NULL, 0, 0, 1, 1, 0, NULL, NULL, '2024-03-17 15:41:56', '2024-03-17 15:41:56', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `meeting_attendance`
--

DROP TABLE IF EXISTS `meeting_attendance`;
CREATE TABLE IF NOT EXISTS `meeting_attendance` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_attended` tinyint(1) NOT NULL DEFAULT '0',
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `meeting_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meeting_attendance_member_id_foreign` (`member_id`),
  KEY `meeting_attendance_meeting_id_foreign` (`meeting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_profile_image` longtext COLLATE utf8mb4_unicode_ci,
  `signature` text COLLATE utf8mb4_unicode_ci,
  `member_biography` longtext COLLATE utf8mb4_unicode_ci,
  `member_first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_middel_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_signature` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `has_vote` tinyint(1) NOT NULL DEFAULT '0',
  `member_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `created_by` int DEFAULT NULL,
  `position_id` bigint UNSIGNED DEFAULT NULL,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fcm` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `members_member_email_unique` (`member_email`),
  KEY `members_position_id_foreign` (`position_id`),
  KEY `members_business_id_foreign` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `member_profile_image`, `signature`, `member_biography`, `member_first_name`, `member_middel_name`, `member_last_name`, `member_mobile`, `member_email`, `member_password`, `name_password`, `member_signature`, `is_active`, `has_vote`, `member_type`, `created_by`, `position_id`, `business_id`, `deleted_at`, `created_at`, `updated_at`, `fcm`) VALUES
(1, NULL, NULL, NULL, 'mohamed', 'fadol', NULL, NULL, 'test@test.com', '$2y$10$5zYmYDpVFFeARm5lzXpkFOMuDwJ0W7z8NAHUhq9dmP6dTUYGF7BiC', 'test@test.com', NULL, 0, 0, 'owner', 1, 1, 1, NULL, '2024-03-13 17:28:23', '2024-03-13 17:28:23', '');

-- --------------------------------------------------------

--
-- Table structure for table `member_annual_audit_report`
--

DROP TABLE IF EXISTS `member_annual_audit_report`;
CREATE TABLE IF NOT EXISTS `member_annual_audit_report` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_signed` tinyint(1) NOT NULL DEFAULT '0',
  `annual_audit_report_status` enum('SIGNED','QOURMREACHED','NOTSIGNED','PARTIAL') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NOTSIGNED',
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `annual_audit_report_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_annual_audit_report_member_id_foreign` (`member_id`),
  KEY `member_annual_audit_report_annual_audit_report_id_foreign` (`annual_audit_report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `member_annual_report`
--

DROP TABLE IF EXISTS `member_annual_report`;
CREATE TABLE IF NOT EXISTS `member_annual_report` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_signed` tinyint(1) NOT NULL DEFAULT '0',
  `annual_report_status` enum('SIGNED','QOURMREACHED','NOTSIGNED','PARTIAL') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NOTSIGNED',
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `annual_report_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_annual_report_member_id_foreign` (`member_id`),
  KEY `member_annual_report_annual_report_id_foreign` (`annual_report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `member_criteria`
--

DROP TABLE IF EXISTS `member_criteria`;
CREATE TABLE IF NOT EXISTS `member_criteria` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `criteria_degree` int DEFAULT NULL,
  `total_degree` int DEFAULT NULL,
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `has_vote` tinyint(1) NOT NULL DEFAULT '0',
  `elected_by` bigint UNSIGNED DEFAULT NULL,
  `criteria_id` bigint UNSIGNED DEFAULT NULL,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_criteria_member_id_foreign` (`member_id`),
  KEY `member_criteria_elected_by_foreign` (`elected_by`),
  KEY `member_criteria_criteria_id_foreign` (`criteria_id`),
  KEY `member_criteria_business_id_foreign` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `member_disclosure`
--

DROP TABLE IF EXISTS `member_disclosure`;
CREATE TABLE IF NOT EXISTS `member_disclosure` (
  `is_signed` tinyint(1) NOT NULL DEFAULT '0',
  `disclosure_status` enum('SIGNED','QOURMREACHED','NOTSIGNED','PARTIAL') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NOTSIGNED',
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `disclosure_id` bigint UNSIGNED DEFAULT NULL,
  KEY `member_disclosure_member_id_foreign` (`member_id`),
  KEY `member_disclosure_disclosure_id_foreign` (`disclosure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `member_financial`
--

DROP TABLE IF EXISTS `member_financial`;
CREATE TABLE IF NOT EXISTS `member_financial` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_signed` tinyint(1) NOT NULL DEFAULT '0',
  `financial_status` enum('SIGNED','QOURMREACHED','NOTSIGNED','PARTIAL') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NOTSIGNED',
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `financial_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_financial_member_id_foreign` (`member_id`),
  KEY `member_financial_financial_id_foreign` (`financial_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `member_minute`
--

DROP TABLE IF EXISTS `member_minute`;
CREATE TABLE IF NOT EXISTS `member_minute` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `has_signed` tinyint(1) NOT NULL DEFAULT '0',
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `minute_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_minute_member_id_foreign` (`member_id`),
  KEY `member_minute_minute_id_foreign` (`minute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `member_minute`
--

INSERT INTO `member_minute` (`id`, `has_signed`, `member_id`, `minute_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2024-03-13 20:16:43', '2024-03-13 20:16:43');

-- --------------------------------------------------------

--
-- Table structure for table `member_resolution`
--

DROP TABLE IF EXISTS `member_resolution`;
CREATE TABLE IF NOT EXISTS `member_resolution` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `has_signed` tinyint(1) NOT NULL DEFAULT '0',
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `resoultion_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_resolution_member_id_foreign` (`member_id`),
  KEY `member_resolution_resoultion_id_foreign` (`resoultion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `member_sign_minutes`
--

DROP TABLE IF EXISTS `member_sign_minutes`;
CREATE TABLE IF NOT EXISTS `member_sign_minutes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `has_signed` tinyint(1) NOT NULL DEFAULT '0',
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `minute_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_sign_minutes_member_id_foreign` (`member_id`),
  KEY `member_sign_minutes_minute_id_foreign` (`minute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_12_01_200019_create_businesses_table', 1),
(6, '2022_12_02_170804_create_packages_table', 1),
(7, '2022_12_02_171307_create_subscriptions_table', 1),
(8, '2022_12_02_190319_create_permission_tables', 1),
(9, '2022_12_02_201237_create_activity_log_table', 1),
(10, '2022_12_02_201238_add_event_column_to_activity_log_table', 1),
(11, '2022_12_02_201239_add_batch_uuid_column_to_activity_log_table', 1),
(12, '2022_12_03_222305_create_systems_table', 1),
(13, '2022_12_04_071040_create_business_locations_table', 1),
(14, '2022_12_04_135621_create_reference_counts_table', 1),
(15, '2022_12_06_085800_create_taxes_table', 1),
(16, '2022_12_30_215843_create_boards_table', 1),
(17, '2022_12_30_221048_create_committees_table', 1),
(18, '2023_01_03_154016_create_positions_table', 1),
(19, '2023_01_04_081534_create_members_table', 1),
(20, '2023_01_04_083358_create_committee_member_table', 1),
(21, '2023_01_04_083933_create_board_member_table', 1),
(22, '2023_01_06_222453_create_share_holders_table', 1),
(23, '2023_01_13_040359_create_employees_table', 1),
(24, '2023_01_20_045816_create_meetings_table', 1),
(25, '2023_01_21_040527_create_agendas_table', 1),
(26, '2023_01_30_050555_create_agenda_meeting_table', 1),
(27, '2023_02_03_053453_create_searchables_table', 1),
(28, '2023_02_07_214642_create_resoultions_table', 1),
(29, '2023_02_14_095748_create_criterias_table', 1),
(30, '2023_02_14_101411_create_member_criteria_table', 1),
(31, '2023_02_22_144616_create_member_resolution_table', 1),
(32, '2023_02_28_195742_create_annual_audit_reports_table', 1),
(33, '2023_02_28_200742_create_minutes_table', 1),
(34, '2023_03_01_130813_create_member_minute_table', 1),
(35, '2023_03_01_194806_create_meeting_attendance_table', 1),
(36, '2023_03_14_133441_create_agenda_details_table', 1),
(37, '2023_04_20_180728_create_attendance_board_table', 1),
(38, '2023_05_06_112518_create_member_sign_minutes_table', 1),
(39, '2023_06_23_112311_create_action_trackers_table', 1),
(40, '2023_07_21_181425_add_fcm_to_users_table', 1),
(41, '2023_07_21_181500_add_fcm_to_members_table', 1),
(42, '2023_07_29_051211_add_business_id_to_action_trackers_table', 1),
(43, '2023_08_03_201556_create_financials_table', 1),
(44, '2023_08_03_210857_create_member_financial_table', 1),
(45, '2023_08_05_020715_create_annual_reports_table', 1),
(46, '2023_08_05_020843_create_member_annual_report_table', 1),
(47, '2023_08_05_065436_add_audit_status_to_annual_audit_reports_table', 1),
(48, '2023_08_05_073129_create_member_annual_audit_report_table', 1),
(49, '2023_08_18_164042_create_disclosures_table', 1),
(50, '2023_08_18_165009_create_member_disclosure_table', 1),
(51, '2024_01_05_093307_create_board_meeting_table', 1),
(52, '2024_01_05_093413_create_committee_meeting_table', 1),
(53, '2024_01_19_153304_create_notes_table', 1),
(54, '2024_03_13_190459_add_board_andcommittee_relations_to_meetings_table', 1),
(55, '2024_03_13_195845_add_meeting_id_relations_to_agendas_table', 1),
(56, '2024_03_15_132800_add_filename_filepath_to_agendas_table', 2),
(57, '2024_03_15_180154_create_notifications_table', 3),
(58, '2024_03_18_045848_add_user_and_agenda_id_integer_to_notes_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `minutes`
--

DROP TABLE IF EXISTS `minutes`;
CREATE TABLE IF NOT EXISTS `minutes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `minute_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minute_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minute_numbers` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minute_decision` longtext COLLATE utf8mb4_unicode_ci,
  `minute_status` enum('SIGNED','QOURMREACHED','NOTSIGNED','PARTIAL') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NOTSIGNED',
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `meeting_id` bigint UNSIGNED DEFAULT NULL,
  `board_id` bigint UNSIGNED DEFAULT NULL,
  `committee_id` bigint UNSIGNED DEFAULT NULL,
  `add_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `minutes_business_id_foreign` (`business_id`),
  KEY `minutes_meeting_id_foreign` (`meeting_id`),
  KEY `minutes_board_id_foreign` (`board_id`),
  KEY `minutes_committee_id_foreign` (`committee_id`),
  KEY `minutes_add_by_foreign` (`add_by`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `minutes`
--

INSERT INTO `minutes` (`id`, `minute_name`, `minute_date`, `minute_numbers`, `minute_decision`, `minute_status`, `business_id`, `meeting_id`, `board_id`, `committee_id`, `add_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'orem Ipsum is simply dummy text of the printing 	\nLorem Ipsum is simply dummy text of the printing', '2024-03-13 23:32:36', '1-2024', 'ddddd', 'NOTSIGNED', 1, 18, 1, NULL, 1, NULL, '2024-03-13 17:35:44', '2024-03-13 17:35:44'),
(2, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:22', '2024-03-17 15:43:22'),
(3, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:27', '2024-03-17 15:43:27'),
(4, 'rerff', '2024-03-13 23:32:36', '1-2024', 'ddddd', 'NOTSIGNED', 1, 18, 1, NULL, 1, NULL, '2024-03-13 17:35:44', '2024-03-13 17:35:44'),
(5, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:22', '2024-03-17 15:43:22'),
(6, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:27', '2024-03-17 15:43:27'),
(7, 'rerff', '2024-03-13 23:32:36', '1-2024', 'ddddd', 'NOTSIGNED', 1, 18, 1, NULL, 1, NULL, '2024-03-13 17:35:44', '2024-03-13 17:35:44'),
(8, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:22', '2024-03-17 15:43:22'),
(9, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:27', '2024-03-17 15:43:27'),
(10, 'rerff', '2024-03-13 23:32:36', '1-2024', 'ddddd', 'NOTSIGNED', 1, 18, 1, NULL, 1, NULL, '2024-03-13 17:35:44', '2024-03-13 17:35:44'),
(11, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:22', '2024-03-17 15:43:22'),
(12, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:27', '2024-03-17 15:43:27'),
(13, 'rerff', '2024-03-13 23:32:36', '1-2024', 'ddddd', 'NOTSIGNED', 1, 18, 1, NULL, 1, NULL, '2024-03-13 17:35:44', '2024-03-13 17:35:44'),
(14, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:22', '2024-03-17 15:43:22'),
(15, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:27', '2024-03-17 15:43:27'),
(16, 'rerff', '2024-03-13 23:32:36', '1-2024', 'ddddd', 'NOTSIGNED', 1, 18, 1, NULL, 1, NULL, '2024-03-13 17:35:44', '2024-03-13 17:35:44'),
(17, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:22', '2024-03-17 15:43:22'),
(18, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:27', '2024-03-17 15:43:27'),
(19, 'rerff', '2024-03-13 23:32:36', '1-2024', 'ddddd', 'NOTSIGNED', 1, 18, 1, NULL, 1, NULL, '2024-03-13 17:35:44', '2024-03-13 17:35:44'),
(20, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:22', '2024-03-17 15:43:22'),
(21, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:27', '2024-03-17 15:43:27'),
(22, 'rerff', '2024-03-13 23:32:36', '1-2024', 'ddddd', 'NOTSIGNED', 1, 18, 1, NULL, 1, NULL, '2024-03-13 17:35:44', '2024-03-13 17:35:44'),
(23, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:22', '2024-03-17 15:43:22'),
(24, 'meeting test', '2024-03-26 08:38:00', '34-2024', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'NOTSIGNED', 1, 34, 1, NULL, 1, NULL, '2024-03-17 15:43:27', '2024-03-17 15:43:27');

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  `annotation_id` int DEFAULT NULL,
  `positionDx` double DEFAULT NULL,
  `positionDy` double DEFAULT NULL,
  `page_index` int DEFAULT NULL,
  `isPrivate` tinyint(1) NOT NULL DEFAULT '0',
  `file_edited` longtext COLLATE utf8mb4_unicode_ci,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `addby` int DEFAULT NULL,
  `agenda_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `note`, `annotation_id`, `positionDx`, `positionDy`, `page_index`, `isPrivate`, `file_edited`, `business_id`, `created_at`, `updated_at`, `addby`, `agenda_id`) VALUES
(1, 'text action', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2024-03-16 15:34:51', '2024-03-16 15:34:51', NULL, NULL),
(2, 'text action', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2024-03-16 15:36:08', '2024-03-16 15:36:08', NULL, NULL),
(3, 'hi prot', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2024-03-16 15:50:06', '2024-03-16 15:50:06', NULL, NULL),
(4, 'hi pr mohamed', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2024-03-16 15:53:20', '2024-03-16 15:53:20', NULL, NULL),
(5, 'fd', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2024-03-16 16:29:21', '2024-03-16 16:29:21', NULL, NULL),
(6, 'hhhhh', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2024-03-16 18:37:39', '2024-03-16 18:37:39', NULL, NULL),
(23, 'hi bro', 1, 300.9765625, 108.984375, 1, 0, 'https://diligov.com/public/charters/1/full_stack_developer_mohamed_fadol.pdf', 1, '2024-03-18 03:24:13', '2024-03-18 03:24:13', 1, 34),
(24, 'hello there', 2, 349.9755859375, 183.984375, 1, 0, 'https://diligov.com/public/charters/1/full_stack_developer_mohamed_fadol.pdf', 1, '2024-03-18 03:24:13', '2024-03-18 03:24:13', 1, 34);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `notification_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_body` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `business_id` int DEFAULT NULL,
  `action_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notification_title`, `notification_body`, `notification_token`, `member_id`, `user_id`, `business_id`, `action_id`, `created_at`, `updated_at`) VALUES
(1, 'notification message', 'test body', 'string', 1, 1, 1, 1, '2024-03-15 20:41:38', '2024-03-15 20:41:38'),
(2, 'notification message', 'test body 2', 'string', 1, 1, 1, 1, '2024-03-15 20:41:38', '2024-03-15 20:41:38'),
(3, 'notification message', 'test body 3', 'string', 1, 1, 1, 1, '2024-03-15 20:41:38', '2024-03-15 20:41:38'),
(4, 'notification message', 'test body', 'string', 1, 1, 1, 1, '2024-03-15 20:41:38', '2024-03-15 20:41:38'),
(5, 'test title 2', 'test body 2', 'string', 1, 1, 1, 1, '2024-03-15 20:41:38', '2024-03-15 20:41:38'),
(6, 'test title 3', 'test body 3', 'string', 1, 1, 1, 1, '2024-03-15 20:41:38', '2024-03-15 20:41:38'),
(7, 'test title', 'test body', 'string', 1, 1, 1, 1, '2024-03-15 20:41:38', '2024-03-15 20:41:38'),
(8, 'test title 2', 'test body 2', 'string', 1, 1, 1, 1, '2024-03-15 20:41:38', '2024-03-15 20:41:38'),
(9, 'test title 3', 'test body 3', 'string', 1, 1, 1, 1, '2024-03-15 20:41:38', '2024-03-15 20:41:38'),
(10, 'notification message', 'test body', 'string', 1, 1, 1, 1, '2024-03-15 20:41:38', '2024-03-15 20:41:38'),
(11, 'notification message', 'test body 2', 'string', 1, 1, 1, 1, '2024-03-15 20:41:38', '2024-03-15 20:41:38'),
(12, 'notification message', 'test body 3', 'string', 1, 1, 1, 1, '2024-03-15 20:41:38', '2024-03-15 20:41:38'),
(13, 'sxsx', '2024-03-23 12:00:00', 'cyfxDNwnT_GE9eVWJF9eA2:APA91bGLgoNa9PNs8xeRj_HsF58Qo4rtl-fJmlFa6FHCqyL02KOGAc40Ha52QmHwgO4JaFMd4EGT4fBPmqHGdroNIn3FNe_VwdlcxGIDs5VPxKTTaO5L693SKD2QXICTG70SrWCRtUOF', 1, 1, 1, 1, '2024-03-16 15:36:09', '2024-03-16 15:36:09'),
(14, 'ssss', '2024-03-16 12:00:00', 'cyfxDNwnT_GE9eVWJF9eA2:APA91bGLgoNa9PNs8xeRj_HsF58Qo4rtl-fJmlFa6FHCqyL02KOGAc40Ha52QmHwgO4JaFMd4EGT4fBPmqHGdroNIn3FNe_VwdlcxGIDs5VPxKTTaO5L693SKD2QXICTG70SrWCRtUOF', 1, 1, 1, 2, '2024-03-16 15:50:06', '2024-03-16 15:50:06'),
(15, 'ssss', '2024-03-16 12:00:00', 'd_knToKITVqH5CBPtuH0N4:APA91bEPDU1ouSjDlcqgF2JhZ56G1UhcsB6HQ-aBeAMccNQvyQ9NoYgh7wYiSBtiSqwJyOnbDWxXwTSdBVk48ftiW2H5FbDc6_fUjKlewtesRM9_EWfa-c_A7rZzEZOQwfMpjqmegEpc', 1, 1, 1, 3, '2024-03-16 15:53:20', '2024-03-16 15:53:20'),
(16, 'ssss', '2024-03-16 12:00:00', 'd_knToKITVqH5CBPtuH0N4:APA91bEPDU1ouSjDlcqgF2JhZ56G1UhcsB6HQ-aBeAMccNQvyQ9NoYgh7wYiSBtiSqwJyOnbDWxXwTSdBVk48ftiW2H5FbDc6_fUjKlewtesRM9_EWfa-c_A7rZzEZOQwfMpjqmegEpc', 1, 1, 1, 2, '2024-03-16 16:29:22', '2024-03-16 16:29:22'),
(17, 'ssss', '2024-03-17 12:00:00', 'd_knToKITVqH5CBPtuH0N4:APA91bEPDU1ouSjDlcqgF2JhZ56G1UhcsB6HQ-aBeAMccNQvyQ9NoYgh7wYiSBtiSqwJyOnbDWxXwTSdBVk48ftiW2H5FbDc6_fUjKlewtesRM9_EWfa-c_A7rZzEZOQwfMpjqmegEpc', 1, 1, 1, 3, '2024-03-16 18:37:40', '2024-03-16 18:37:40'),
(18, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', '18-03-2024 12:00:00 PM', 'eMj3RP7WQhuX6earr9vSiB:APA91bEMLhwPlwOADPmwX8HZcJSDomPV0Wc5QSFw3Ivx2-ralhZvKVSOvMiZ7nK4_I_V2YQ98-gtTSElJ4K2ukeyYpl_6qiA_z3SbXRLlhefPeYQ-hDJ-WO5cRHG69sApa-EpKHZhEqV', 1, 1, 1, 4, '2024-03-17 23:11:27', '2024-03-17 23:11:27');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
CREATE TABLE IF NOT EXISTS `packages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_count` int NOT NULL COMMENT 'No. of Business Locations, 0 = infinite option.',
  `user_count` int NOT NULL,
  `interval` enum('days','months','years') COLLATE utf8mb4_unicode_ci NOT NULL,
  `interval_count` int NOT NULL,
  `trial_days` int NOT NULL,
  `price` decimal(22,4) NOT NULL,
  `custom_permissions` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT '0',
  `is_one_time` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'location.1', 'web', '2024-03-13 17:28:23', '2024-03-13 17:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'APIDiligovToken', 'ef1d27dec11db1696785e822cbbc12514fbabe8478fe41beb3b320b4558296e5', '[\"*\"]', '2024-03-13 19:34:07', NULL, '2024-03-13 17:29:25', '2024-03-13 19:34:07'),
(2, 'App\\Models\\User', 1, 'APIDiligovToken', 'd4eb23a98227bc33f66643cb371bf06f0ffbbf1fb1b5c9bd11f731c08bad6c49', '[\"*\"]', '2024-03-13 22:00:58', NULL, '2024-03-13 19:44:00', '2024-03-13 22:00:58'),
(3, 'App\\Models\\User', 1, 'APIDiligovToken', '7f4f95304382d35b0cf67ef98cf945c2296cb5f9288779b6403b52640dcefb06', '[\"*\"]', '2024-03-22 04:44:13', NULL, '2024-03-13 21:07:02', '2024-03-22 04:44:13'),
(4, 'App\\Models\\User', 1, 'APIDiligovToken', 'aa9ef8502da660a0bd69d02309a34e46ae279acda8b3fa9f69a0be94e0ce1581', '[\"*\"]', '2024-03-14 02:20:43', NULL, '2024-03-13 22:10:45', '2024-03-14 02:20:43'),
(5, 'App\\Models\\User', 1, 'APIDiligovToken', 'ab7ee3409906dbd4b71b2a230ccb5925e500c99d610be0aa1d43cc0c039142de', '[\"*\"]', '2024-03-15 11:38:00', NULL, '2024-03-14 09:09:37', '2024-03-15 11:38:00'),
(6, 'App\\Models\\User', 1, 'APIDiligovToken', 'b078c8d81b933370c1e11f1ce1364fbd03c26d466da9563ed29f7e889f862321', '[\"*\"]', '2024-03-16 15:38:22', NULL, '2024-03-15 11:43:48', '2024-03-16 15:38:22'),
(7, 'App\\Models\\User', 1, 'APIDiligovToken', '77452d03108d4ad8e203c57225ad9993b82716fa3ba04527ecc23c9cb4d96f41', '[\"*\"]', '2024-03-16 23:56:11', NULL, '2024-03-16 15:47:19', '2024-03-16 23:56:11'),
(8, 'App\\Models\\User', 1, 'APIDiligovToken', '97929736da934f791dcdb257a018f6cdbe89abdc970ff0fc362aeee44fdcc1d7', '[\"*\"]', '2024-03-17 16:42:53', NULL, '2024-03-16 23:56:27', '2024-03-17 16:42:53'),
(9, 'App\\Models\\User', 1, 'APIDiligovToken', '35d584ac0ee64c4751ca80d5d5b82322ccd744fd7c03825fd8f301bb876c165d', '[\"*\"]', '2024-03-21 01:28:00', NULL, '2024-03-17 23:06:24', '2024-03-21 01:28:00'),
(10, 'App\\Models\\User', 1, 'APIDiligovToken', '2527a6d43aa1e8137a50bc1f152f6c95731b28c35f97824dfafb0a58b1e28829', '[\"*\"]', '2024-03-23 00:51:41', NULL, '2024-03-21 02:08:27', '2024-03-23 00:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
CREATE TABLE IF NOT EXISTS `positions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `position_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `has_vote` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int DEFAULT NULL,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `positions_business_id_foreign` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `position_name`, `is_active`, `has_vote`, `created_by`, `business_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'CEO', 0, 0, NULL, NULL, NULL, '2024-03-13 17:28:23', '2024-03-13 17:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `reference_counts`
--

DROP TABLE IF EXISTS `reference_counts`;
CREATE TABLE IF NOT EXISTS `reference_counts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ref_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_count` int NOT NULL,
  `business_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `reference_counts`
--

INSERT INTO `reference_counts` (`id`, `ref_type`, `ref_count`, `business_id`, `created_at`, `updated_at`) VALUES
(1, 'business_location', 1, 1, '2024-03-13 17:28:23', '2024-03-13 17:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `resoultions`
--

DROP TABLE IF EXISTS `resoultions`;
CREATE TABLE IF NOT EXISTS `resoultions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `resoultion_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resoultion_numbers` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resoultion_charter` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resolution_decision` longtext COLLATE utf8mb4_unicode_ci,
  `resoultion_status` enum('SIGNED','QOURMREACHED','NOTSIGNED','PARTIAL') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NOTSIGNED',
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `meeting_id` bigint UNSIGNED DEFAULT NULL,
  `board_id` bigint UNSIGNED DEFAULT NULL,
  `committee_id` bigint UNSIGNED DEFAULT NULL,
  `add_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resoultions_business_id_foreign` (`business_id`),
  KEY `resoultions_meeting_id_foreign` (`meeting_id`),
  KEY `resoultions_board_id_foreign` (`board_id`),
  KEY `resoultions_committee_id_foreign` (`committee_id`),
  KEY `resoultions_add_by_foreign` (`add_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `business_id` bigint UNSIGNED NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  KEY `roles_business_id_foreign` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `business_id`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Admin#1', 'web', 1, 1, '2024-03-13 17:28:23', '2024-03-13 17:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `searchables`
--

DROP TABLE IF EXISTS `searchables`;
CREATE TABLE IF NOT EXISTS `searchables` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `charter_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_dir` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `searchables_business_id_foreign` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `searchables`
--

INSERT INTO `searchables` (`id`, `charter_name`, `file_name`, `file_dir`, `business_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'A Board', '1710361804.tapo.pdf', 'charters', 1, NULL, '2024-03-13 17:30:04', '2024-03-13 17:30:04'),
(2, 'A Commitee', '1710361832.tapo.pdf', 'charters', 1, NULL, '2024-03-13 17:30:32', '2024-03-13 17:30:32');

-- --------------------------------------------------------

--
-- Table structure for table `share_holders`
--

DROP TABLE IF EXISTS `share_holders`;
CREATE TABLE IF NOT EXISTS `share_holders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `share_holder_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `share_holders_business_id_foreign` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_id` bigint UNSIGNED DEFAULT NULL,
  `package_id` bigint UNSIGNED NOT NULL,
  `start_date` date DEFAULT NULL,
  `trial_end_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `package_price` decimal(22,4) NOT NULL,
  `package_details` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_id` int UNSIGNED NOT NULL,
  `paid_via` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('approved','waiting','declined') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_business_id_foreign` (`business_id`),
  KEY `subscriptions_package_id_index` (`package_id`),
  KEY `subscriptions_created_id_index` (`created_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `systems`
--

DROP TABLE IF EXISTS `systems`;
CREATE TABLE IF NOT EXISTS `systems` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `systems`
--

INSERT INTO `systems` (`id`, `key`, `value`) VALUES
(1, 'db_version', '1.0.0');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

DROP TABLE IF EXISTS `taxes`;
CREATE TABLE IF NOT EXISTS `taxes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(22,4) NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `taxes_business_id_foreign` (`business_id`),
  KEY `taxes_created_by_foreign` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `profile_image` longtext COLLATE utf8mb4_unicode_ci,
  `signature` text COLLATE utf8mb4_unicode_ci,
  `biography` longtext COLLATE utf8mb4_unicode_ci,
  `name_password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `business_id` int UNSIGNED DEFAULT NULL,
  `allow_login` tinyint(1) NOT NULL DEFAULT '1',
  `contact_no` char(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','terminated') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` enum('married','unmarried','divorced') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` char(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fcm` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_user_type_index` (`user_type`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `name`, `profile_image`, `signature`, `biography`, `name_password`, `email_verified_at`, `surname`, `first_name`, `last_name`, `username`, `email`, `password`, `language`, `business_id`, `allow_login`, `contact_no`, `address`, `status`, `gender`, `marital_status`, `contact_number`, `deleted_at`, `remember_token`, `created_at`, `updated_at`, `fcm`) VALUES
(1, 'user', 'user', NULL, NULL, NULL, 'test@test.com', NULL, 'fadol', 'mohamed', 'fadol', 'mohamed', 'test@test.com', '$2y$10$9moJx20qV06Dvu564lnd8.hyF.C5PujIzgRh9BHeqDXNRJFUuktCu', 'ar', 1, 1, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, '2024-03-13 17:28:23', '2024-03-21 02:08:27', 'eNVbe_znTRm-CL5uFuscQO:APA91bEgXz88wqzbN-VzGoFpKVcHd3luK-XC4TfCj9ovQ-ODhYvU18X4Pza_grtK8qVMwCgZ_G-_xY79z1C8APMGP8XqRd1qmv_VfW-fgHA6SPL3_ptKsGkbMu770fBaR_hNXZ_fETtw');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `action_trackers`
--
ALTER TABLE `action_trackers`
  ADD CONSTRAINT `action_trackers_agenda_detail_id_foreign` FOREIGN KEY (`agenda_detail_id`) REFERENCES `agenda_details` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `action_trackers_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `action_trackers_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `action_trackers_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agendas`
--
ALTER TABLE `agendas`
  ADD CONSTRAINT `agendas_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agenda_details`
--
ALTER TABLE `agenda_details`
  ADD CONSTRAINT `agenda_details_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `agendas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agenda_meeting`
--
ALTER TABLE `agenda_meeting`
  ADD CONSTRAINT `agenda_meeting_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `agendas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agenda_meeting_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `annual_audit_reports`
--
ALTER TABLE `annual_audit_reports`
  ADD CONSTRAINT `annual_audit_reports_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `annual_audit_reports_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `annual_reports`
--
ALTER TABLE `annual_reports`
  ADD CONSTRAINT `annual_reports_add_by_foreign` FOREIGN KEY (`add_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `annual_reports_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `annual_reports_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance_board`
--
ALTER TABLE `attendance_board`
  ADD CONSTRAINT `attendance_board_minute_id_foreign` FOREIGN KEY (`minute_id`) REFERENCES `minutes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `boards`
--
ALTER TABLE `boards`
  ADD CONSTRAINT `boards_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `board_meeting`
--
ALTER TABLE `board_meeting`
  ADD CONSTRAINT `board_meeting_board_id_foreign` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `board_meeting_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `board_member`
--
ALTER TABLE `board_member`
  ADD CONSTRAINT `board_member_board_id_foreign` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `board_member_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `businesses`
--
ALTER TABLE `businesses`
  ADD CONSTRAINT `businesses_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_locations`
--
ALTER TABLE `business_locations`
  ADD CONSTRAINT `business_locations_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `committees`
--
ALTER TABLE `committees`
  ADD CONSTRAINT `committees_board_id_foreign` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `committees_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `committee_meeting`
--
ALTER TABLE `committee_meeting`
  ADD CONSTRAINT `committee_meeting_committee_id_foreign` FOREIGN KEY (`committee_id`) REFERENCES `committees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `committee_meeting_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `committee_member`
--
ALTER TABLE `committee_member`
  ADD CONSTRAINT `committee_member_committee_id_foreign` FOREIGN KEY (`committee_id`) REFERENCES `committees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `committee_member_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `criterias`
--
ALTER TABLE `criterias`
  ADD CONSTRAINT `criterias_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `criterias_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `disclosures`
--
ALTER TABLE `disclosures`
  ADD CONSTRAINT `disclosures_add_by_foreign` FOREIGN KEY (`add_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disclosures_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disclosures_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `financials`
--
ALTER TABLE `financials`
  ADD CONSTRAINT `financials_add_by_foreign` FOREIGN KEY (`add_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `financials_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `financials_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_board_id_foreign` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meetings_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meetings_committee_id_foreign` FOREIGN KEY (`committee_id`) REFERENCES `committees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meetings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meeting_attendance`
--
ALTER TABLE `meeting_attendance`
  ADD CONSTRAINT `meeting_attendance_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meeting_attendance_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `members_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_annual_audit_report`
--
ALTER TABLE `member_annual_audit_report`
  ADD CONSTRAINT `member_annual_audit_report_annual_audit_report_id_foreign` FOREIGN KEY (`annual_audit_report_id`) REFERENCES `annual_audit_reports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_annual_audit_report_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_annual_report`
--
ALTER TABLE `member_annual_report`
  ADD CONSTRAINT `member_annual_report_annual_report_id_foreign` FOREIGN KEY (`annual_report_id`) REFERENCES `annual_reports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_annual_report_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_criteria`
--
ALTER TABLE `member_criteria`
  ADD CONSTRAINT `member_criteria_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_criteria_criteria_id_foreign` FOREIGN KEY (`criteria_id`) REFERENCES `criterias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_criteria_elected_by_foreign` FOREIGN KEY (`elected_by`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_criteria_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_disclosure`
--
ALTER TABLE `member_disclosure`
  ADD CONSTRAINT `member_disclosure_disclosure_id_foreign` FOREIGN KEY (`disclosure_id`) REFERENCES `disclosures` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_disclosure_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_financial`
--
ALTER TABLE `member_financial`
  ADD CONSTRAINT `member_financial_financial_id_foreign` FOREIGN KEY (`financial_id`) REFERENCES `financials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_financial_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_minute`
--
ALTER TABLE `member_minute`
  ADD CONSTRAINT `member_minute_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_minute_minute_id_foreign` FOREIGN KEY (`minute_id`) REFERENCES `minutes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_resolution`
--
ALTER TABLE `member_resolution`
  ADD CONSTRAINT `member_resolution_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_resolution_resoultion_id_foreign` FOREIGN KEY (`resoultion_id`) REFERENCES `resoultions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_sign_minutes`
--
ALTER TABLE `member_sign_minutes`
  ADD CONSTRAINT `member_sign_minutes_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_sign_minutes_minute_id_foreign` FOREIGN KEY (`minute_id`) REFERENCES `minutes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `minutes`
--
ALTER TABLE `minutes`
  ADD CONSTRAINT `minutes_add_by_foreign` FOREIGN KEY (`add_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `minutes_board_id_foreign` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `minutes_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `minutes_committee_id_foreign` FOREIGN KEY (`committee_id`) REFERENCES `committees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `minutes_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `positions_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resoultions`
--
ALTER TABLE `resoultions`
  ADD CONSTRAINT `resoultions_add_by_foreign` FOREIGN KEY (`add_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resoultions_board_id_foreign` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resoultions_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resoultions_committee_id_foreign` FOREIGN KEY (`committee_id`) REFERENCES `committees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resoultions_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `searchables`
--
ALTER TABLE `searchables`
  ADD CONSTRAINT `searchables_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `share_holders`
--
ALTER TABLE `share_holders`
  ADD CONSTRAINT `share_holders_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `taxes`
--
ALTER TABLE `taxes`
  ADD CONSTRAINT `taxes_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `taxes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
