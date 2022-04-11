-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2022 at 06:26 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_chokchaiinternational`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `level_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `users_id` int(11) NOT NULL COMMENT ' ผู้ตรวจสอบและดูแลการประเมิน Verify',
  `employees_id` int(11) NOT NULL COMMENT ' ผู้ประเมินหลัก ',
  `status` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT ' 1=รอการประเมินผล / 2=รอการตรวจสอบ / 3=การประเมินผลสำเร็จ / 4=ส่งกลับแก้ไข',
  `tems_status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_mail` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'N' COMMENT ' Y/N ',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessments`
--

INSERT INTO `assessments` (`id`, `level_id`, `name`, `detail`, `users_id`, `employees_id`, `status`, `tems_status`, `email`, `send_mail`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'การประเมินประจำปีฝ่ายสำนักงาน CI ปี 2565', 'การประเมินประจำปีฝ่ายสำนักงาน CI ปี 2565', 8, 8, '3', 'N', 'sa@gmail.com', 'N', '12345', '2022-03-17 16:59:59', '2022-03-30 20:50:54', '0'),
(14, 2, 'การประเมินผลฝ่ายการตลาด 101', 'การประเมินผลฝ่ายการตลาด / จำนวน 10 คน', 8, 11, '2', 'N', 'admin@gmail.com', 'Y', '12345', '2022-03-30 20:15:57', '2022-03-30 23:30:10', '0');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_emps`
--

CREATE TABLE `assessment_emps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` int(11) DEFAULT NULL,
  `assessment_group_id` int(11) DEFAULT NULL,
  `assessment_from_id` int(11) DEFAULT NULL,
  `level_id` int(11) DEFAULT NULL,
  `employees_id` int(11) NOT NULL COMMENT ' ผู้ถูกประเมิน ',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT ' 1=รอการประเมินผล / 2=การประเมินผลสำเร็จ / 3=ส่งกลับแก้ไข',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_emps`
--

INSERT INTO `assessment_emps` (`id`, `assessment_id`, `assessment_group_id`, `assessment_from_id`, `level_id`, `employees_id`, `note`, `status`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 2, 4, 12, 'การประเมินประจำปี ของพนังงานธุรการ', '2', NULL, '2022-03-16 20:56:52', NULL, '0'),
(12, 14, 4, 4, 4, 8, NULL, '1', NULL, '2022-03-30 23:14:07', '2022-03-30 23:32:44', '0'),
(13, 14, 9, 4, 4, 9, NULL, '1', NULL, '2022-03-30 23:14:07', '2022-03-30 23:32:44', '0'),
(15, 14, 11, 4, 4, 11, 'เฉพาะผู้ประเมินฝ่ายเท่านั้น', '1', NULL, '2022-03-30 23:32:44', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_forms`
--

CREATE TABLE `assessment_forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sum_average` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_forms`
--

INSERT INTO `assessment_forms` (`id`, `title`, `sub_title`, `sum_average`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'แบบประเมินพนักงาน IT', 'It suport / programer', 100.00, '2022-03-15 02:37:09', '2022-03-15 19:28:32', '0'),
(3, 'แบบประเมินสำนักงาน CI', 'ประเมินระดับพนักงาน', 50.00, '2022-03-15 02:42:21', '2022-03-15 19:24:58', '0'),
(4, 'แบบประเมิณการตลาดออนไลน์ 101', 'ประเมินระดับพนักงาน', 100.00, '2022-03-30 23:13:01', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_form_details`
--

CREATE TABLE `assessment_form_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `forms_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `average` double(8,2) NOT NULL,
  `type` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT '1=ใส่คะแนน / 2=ใส่คำอธิบาย',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_form_details`
--

INSERT INTO `assessment_form_details` (`id`, `forms_id`, `name`, `average`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 2, 'การประเมินศักยภาพ (Potential)ระดับ1 (20%) 2.1 ความคิดริเริ่มสร้างสรรค์ในการปรับปรุงงาน มีการสังเกต และให้ข้อเสนอแนะจากการทำงานประจำ เพื่อการปฏิบัติงาน สะดวก และรวดเร็วขึ้นกว่าเดิม หรือมี', 20.00, '1', '2022-03-15 02:37:10', '2022-03-15 19:28:32', '0'),
(7, 2, 'ความคิดริเริ่มสร้างสรรค์ในการปรับปรุงงาน มีการสังเกต และให้ข้อเสนอแนะจากการทำงานประจำ เพื่อการปฏิบัติงาน สะดวก และรวดเร็วขึ้นกว่าเดิม หรือมีประสิทธิภาพมากขึ้น (หลักการ Lean)', 10.00, '1', '2022-03-15 02:37:10', '2022-03-15 19:28:32', '0'),
(8, 2, 'ภาวะผู้นำการทำหน้าที่ของตัวเราให้ดีจนมีคนเลียนแบบ หรือเป็นแบบอย่างที่ดีใครๆก็อยากจะร่วมงานด้วย', 50.00, '1', '2022-03-15 02:37:10', '2022-03-15 19:28:32', '0'),
(9, 2, 'การทำงานภายใต้ความกดดัน การทำงานที่ได้รับความสำเร็จตามเป้าหมาย ในเวลาที่กำหนด (กรณีได้รับมอบหมายงาน สามารถบริหารเวลา และผลลัพธ์ให้ได้ตามที่ตั้งไว้ คือการดิ้นรน (คิด) เพื่อให้ได้ผลนั้นๆ ตามความคาดหวังของงาน ด้วยความอดทน, ภาคเพียร, พยายาม เป็นต้น)', 20.00, '1', '2022-03-15 02:37:10', '2022-03-15 19:28:32', '0'),
(10, 2, 'ขอเสนอแนะ', 0.00, '2', '2022-03-15 02:37:10', '2022-03-15 19:28:32', '0'),
(17, 3, 'การประเมินศักยภาพ (Potential)ระดับ1 (20%) 2.1 ความคิดริเริ่มสร้างสรรค์ในการปรับปรุงงาน มีการสังเกต และให้ข้อเสนอแนะจากการทำงานประจำ เพื่อการปฏิบัติงาน สะดวก และรวดเร็วขึ้นกว่าเดิม หรือมี', 25.00, '1', NULL, '2022-03-15 19:24:58', '0'),
(18, 3, 'ภาวะผู้นำการทำหน้าที่ของตัวเราให้ดีจนมีคนเลียนแบบ หรือเป็นแบบอย่างที่ดีใครๆก็อยากจะร่วมงานด้วย', 25.00, '1', NULL, '2022-03-15 19:24:58', '0'),
(20, 4, 'ประเมินระดับพนักงาน 01', 50.00, '1', '2022-03-30 23:13:01', NULL, '0'),
(21, 4, 'ประเมินระดับพนักงาน 02', 50.00, '1', '2022-03-30 23:13:01', NULL, '0'),
(22, 4, 'อธิบายเพิ่มเติม', 0.00, '2', '2022-03-30 23:13:01', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_groups`
--

CREATE TABLE `assessment_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` int(11) DEFAULT NULL,
  `level_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employees_id` int(11) NOT NULL COMMENT ' ผู้ประเมินกลุ่ม ',
  `status` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT ' 1=รอการประเมินผล / 2=การประเมินผลสำเร็จ / 3=ส่งกลับแก้ไข',
  `tems_status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_mail` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'N' COMMENT ' Y/N ',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_groups`
--

INSERT INTO `assessment_groups` (`id`, `assessment_id`, `level_id`, `name`, `detail`, `employees_id`, `status`, `tems_status`, `email`, `send_mail`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 3, 'กลุ่มธุรการสำนักงาน CI', 'กลุ่มธุรการสำนักงาน CI', 9, '2', 'N', 'Y', 'Y', '12345', '2022-03-16 20:55:27', '2022-03-30 20:50:56', '0'),
(2, 1, 3, 'กลุ่ม IT Suport / Programer', 'กลุ่ม IT Suport / Programer', 10, '2', 'N', 'N', 'N', '12345', '2022-03-16 20:55:27', '2022-03-30 20:50:56', '0'),
(4, 14, 3, 'กลุ่มการตลาดออนไลน์', 'กลุ่มการตลาดออนไลน์ / 1 คน', 11, '1', 'N', 'N', 'Y', '12345', '2022-03-30 20:17:34', '2022-03-30 23:31:54', '0'),
(9, 14, 3, 'กลุ่มการตลาด Retail 101', 'กลุ่มการตลาด Retail 101', 10, '1', 'N', 'N', 'N', '12345', '2022-03-30 20:44:33', '2022-03-30 23:31:54', '0'),
(11, 14, 3, 'ผู้ประเมินกลุ่ม (ชีวินทร์ ทองคำ)', 'เฉพาะผู้ประเมินฝ่ายเท่านั้น', 11, '1', 'N', 'admin@gmail.com', 'Y', '12345', '2022-03-30 23:31:54', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'สาขารังสิต', '2022-03-04 02:18:34', NULL, '0'),
(2, 'สาขาปากช่อง', '2022-03-03 09:20:43', NULL, '0'),
(3, 'Lotus ศรีนครินทร์', '2022-03-03 09:20:43', NULL, '0'),
(4, 'Mega บางนา', '2022-03-03 09:20:43', NULL, '0'),
(5, 'Top รังสิต', '2022-03-03 09:20:43', NULL, '0'),
(6, 'เซ็นทรัล West gate', '2022-03-03 09:20:43', NULL, '0'),
(7, 'เซ็นทรัลเวิลด์', '2022-03-03 09:20:43', NULL, '0'),
(8, 'เซ็นทรัลปิ่นเกล้า', '2022-03-03 09:20:43', NULL, '0'),
(9, 'เซ็นทรัลแจ้งวัฒนะ', '2022-03-03 09:20:43', '2022-03-14 21:21:13', '0'),
(10, 'เซ็นทรัลบางนา', '2022-03-03 09:20:43', NULL, '0'),
(11, 'เซ็นทรัลพระราม 2', '2022-03-03 09:20:43', NULL, '0'),
(12, 'เซ็นทรัลพระราม 3', '2022-03-03 09:20:43', NULL, '0'),
(13, 'เซ็นทรัลพระราม 9', '2022-03-03 09:20:43', NULL, '0'),
(14, 'เดอะมอลล์บางแค', '2022-03-03 09:20:43', NULL, '0'),
(15, 'เซ็นทรัลรัตนาธิเบศร์', '2022-03-03 09:20:43', NULL, '0'),
(16, 'แฟชั่นไอส์แลนด์', '2022-03-03 09:20:43', NULL, '0'),
(17, 'ประสานมิตร', '2022-03-03 09:20:43', NULL, '0'),
(18, 'หัวหน้าเขต 1', '2022-03-03 09:20:43', NULL, '0'),
(19, 'หัวหน้าเขต 2', '2022-03-03 09:20:43', NULL, '0'),
(20, 'พาราไดซ์ พาร์ค', '2022-03-03 09:20:43', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ฝ่ายทรัพยากรบุคคล(HRM)', '2022-03-04 07:17:07', '2022-03-14 21:16:53', '0');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departments_id` int(11) NOT NULL,
  `sub_departments_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `branche_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_code`, `departments_id`, `sub_departments_id`, `position_id`, `branche_id`, `level_id`, `title_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, '563112', 1, 1, 7, 1, 3, 1, 'สรญา บูชา', '2022-03-14 21:21:47', '2022-03-14 21:22:36', '0'),
(9, '458053', 1, 3, 5, 1, 3, 2, 'ภัทรา พรหมชาติ', '2022-03-14 21:23:20', NULL, '0'),
(10, '458062', 1, 5, 6, 1, 3, 3, 'เปมิกา ผาสุกกาญจน์', '2022-03-14 21:23:47', NULL, '0'),
(11, '31600002', 1, 3, 1, 1, 3, 3, 'ชีวินทร์ ทองคำ', '2022-03-14 21:24:24', NULL, '0'),
(12, '31610003', 1, 6, 3, 1, 3, 3, 'เยาวธิดา แสนสีจันทร์', '2022-03-14 21:25:49', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `number`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'ลำดับผู้บริหาร', '2022-03-03 09:16:02', NULL, NULL),
(2, 2, 'ลำดับผู้จัดการ', '2022-03-03 09:16:02', NULL, NULL),
(3, 3, 'ลำดับหัวหน้างาน', '2022-03-03 09:16:02', NULL, NULL),
(4, 4, 'ลำดับพนักงาน', '2022-03-03 09:16:02', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_03_03_024153_create_permissions_table', 2),
(6, '2022_03_03_024521_create_roles_table', 2),
(7, '2022_03_03_083329_create_departments_table', 3),
(8, '2022_03_03_083524_create_sub_departments_table', 3),
(9, '2022_03_03_083738_create_positions_table', 3),
(10, '2022_03_03_083958_create_levels_table', 3),
(11, '2022_03_03_084610_create_branches_table', 3),
(12, '2022_03_03_084947_create_employees_table', 3),
(13, '2022_03_03_085618_create_social_logins_table', 3),
(14, '2022_03_07_030726_create_titles_table', 4),
(15, '2022_03_10_021621_create_roles_systems_table', 5),
(16, '2022_03_14_022753_create_notifications_table', 6),
(17, '2022_03_15_073927_create_assessment_forms_table', 7),
(18, '2022_03_15_074232_create_assessment_form_details_table', 7),
(19, '2022_03_16_035146_create_assessments_table', 8),
(20, '2022_03_16_041034_create_assessment_groups_table', 8),
(21, '2022_03_16_060939_create_assessment_emps_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `users_id` int(11) NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_type` int(11) NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `users_id`, `message`, `message_type`, `route`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 13, 'มีผู้ขอลงทะเบียนขอเข้าใช้งานระบบ name : พงศกร สิงหเสรี', 1, 'request-access', '1', '2022-03-14 20:26:13', '2022-03-14 21:13:34', '0');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('saifah1928@gmail.com', '7PfsMRer4bzSyIDmuHLnGG8lph34Qy3g0Z57GhVi15NhKqIoEb3CBRgZgL00DpnA', '2022-03-03 01:08:38');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `detail`, `level`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Owner', 'เจ้าของระบบ สามารถเข้าถึงและจัดการข้อมูลภายในระบบได้ทั้งหมด', '1', '2022-03-03 02:49:20', NULL, '0'),
(2, 'Administrator', 'Administrator', '3', '2022-03-03 02:49:20', '2022-03-15 19:35:53', '0');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departments_id` int(11) NOT NULL,
  `sub_departments_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `departments_id`, `sub_departments_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ผู้ช่วยผู้จัดการฝ่ายทรัพยากรบุคคล ด้านงาน HRM', 1, 3, '2022-03-04 02:13:28', '2022-03-14 21:20:08', '0'),
(3, 'หัวหน้าแผนกค่าตอบแทน', 1, 6, '2022-03-04 02:13:52', '2022-03-14 21:19:43', '0'),
(5, 'หัวหน้าแผนกบุคคล', 1, 3, '2022-03-14 21:20:52', NULL, '0'),
(6, 'หัวหน้าแผนกเงินเดือน', 1, 5, '2022-03-14 21:21:03', NULL, '0'),
(7, 'หัวหน้าพัฒนาบุคลากร', 1, 1, '2022-03-14 21:22:18', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` int(11) NOT NULL,
  `roles_systems_id` int(255) NOT NULL,
  `view` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Yes/NO',
  `add` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Yes/NO',
  `edit` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Yes/NO',
  `delete` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Yes/NO',
  `export` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Yes/NO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `permission_id`, `roles_systems_id`, `view`, `add`, `edit`, `delete`, `export`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 2, 1, 'Y', 'Y', 'Y', 'Y', 'Y', '2022-03-09 02:02:32', '2022-03-15 19:35:53', NULL),
(4, 2, 2, 'Y', 'Y', 'Y', 'Y', 'N', '2022-03-09 02:02:32', '2022-03-15 19:35:53', NULL),
(5, 2, 3, 'Y', 'Y', 'Y', 'Y', 'N', '2022-03-09 19:04:25', '2022-03-15 19:35:53', NULL),
(6, 2, 4, 'Y', 'Y', 'Y', 'Y', 'N', '2022-03-09 19:06:10', '2022-03-15 19:35:53', NULL),
(7, 2, 5, 'Y', 'Y', 'Y', 'Y', 'N', '2022-03-09 19:06:10', '2022-03-15 19:35:53', NULL),
(8, 2, 6, 'Y', 'N', 'N', 'Y', 'N', '2022-03-09 19:06:10', '2022-03-15 19:35:53', NULL),
(15, 2, 8, 'Y', 'Y', 'Y', 'Y', 'N', '2022-03-09 19:06:10', '2022-03-15 19:35:53', NULL),
(16, 2, 9, 'Y', 'Y', 'Y', 'Y', 'N', '2022-03-09 19:06:10', '2022-03-15 19:35:53', NULL),
(17, 2, 10, 'Y', 'Y', 'Y', 'Y', 'N', '2022-03-09 19:06:10', '2022-03-15 19:35:53', NULL),
(36, 2, 11, 'Y', 'Y', 'Y', 'Y', 'N', '2022-03-09 19:06:10', '2022-03-15 19:35:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles_systems`
--

CREATE TABLE `roles_systems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles_systems`
--

INSERT INTO `roles_systems` (`id`, `name`, `module`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'จัดการข้อมูลพนักงาน', 'employees', '2022-03-10 02:20:35', NULL, '0'),
(2, 'จัดการข้อมูลแผนก', 'departments', '2022-03-10 02:20:35', '2022-03-11 01:36:32', '0'),
(3, 'จัดการข้อมูลแผนกย่อย', 'subdepartments', '2022-03-10 02:20:35', '2022-03-11 01:59:40', '0'),
(4, 'จัดการข้อมูลตำแหน่ง', 'positions', '2022-03-10 02:20:35', '2022-03-11 02:04:28', '0'),
(5, 'จัดการข้อมูลสาขา', 'branches', '2022-03-10 02:20:35', '2022-03-11 02:05:13', '0'),
(6, 'จัดการรายการข้อมูลผู้ขอเข้าใช้งานระบบ', 'request', '2022-03-10 02:20:35', '2022-03-11 02:11:50', '0'),
(8, 'จัดการข้อมูลสิทธิ์ผู้ใช้งาน', 'permissions', '2022-03-11 02:18:09', NULL, '0'),
(9, 'จัดการบทบาทของผู้ใช้งาน', 'roles', '2022-03-11 02:23:59', NULL, '0'),
(10, 'กำหนดบทบาทของระบบ', 'rolessystems', '2022-03-11 02:24:29', NULL, '0'),
(11, 'จัดการข้อมูลแบบฟอร์มประเมิน', 'assessmentform', '2022-03-15 19:32:45', '2022-03-15 19:33:33', '0');

-- --------------------------------------------------------

--
-- Table structure for table `social_logins`
--

CREATE TABLE `social_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employees_id` int(11) NOT NULL,
  `social_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `social` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_departments`
--

CREATE TABLE `sub_departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departments_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_departments`
--

INSERT INTO `sub_departments` (`id`, `name`, `departments_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'พัฒนาบุคลากร', 1, '2022-03-04 02:12:22', '2022-03-14 21:17:47', '0'),
(3, 'สำนักงานใหญ่', 1, '2022-03-04 02:12:43', '2022-03-14 21:17:08', '0'),
(5, 'แผนกเงินเดือน', 1, '2022-03-14 21:18:30', NULL, '0'),
(6, 'แผนกค่าตอบแทน', 1, '2022-03-14 21:19:19', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `titles`
--

INSERT INTO `titles` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'นาย', '2022-03-07 03:08:28', NULL, NULL),
(2, 'นาง', '2022-03-07 03:08:28', NULL, NULL),
(3, 'นางสาว', '2022-03-07 03:08:28', NULL, NULL),
(4, 'อื่นๆ', '2022-03-07 03:08:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `permission_id`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'devloopers.Phaiwan', 'dev.saifah8953@gmail.com', NULL, 1, '$2y$10$/vowhtBwaQI7hbCnDVqO6.nz14xwYk1zAOmNCSiB9fg1rQfZsr9Mq', NULL, '2022-03-03 02:48:08', '2022-03-07 01:28:16', '0'),
(8, 'สายฟ้า ไพรวรรณ์', 'saifah1928@gmail.com', NULL, 2, '$2y$10$bX0qjihOM4HI9i5mhtqD7.oGJSCiDLXlX0Uv/qM/nr3nB4MYjL7MW', NULL, '2022-03-02 23:51:29', '2022-03-09 18:38:35', '0'),
(13, 'พงศกร สิงหเสรี', 'pongsakorn.it@farmchokchai.net', NULL, 2, '$2y$10$YurqWrM2ndbXI0i/dzzug.DRpWkK8X66HaN0kAsCNsE3a//d6Ng2S', NULL, '2022-03-14 20:26:13', NULL, '3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_emps`
--
ALTER TABLE `assessment_emps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_forms`
--
ALTER TABLE `assessment_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_form_details`
--
ALTER TABLE `assessment_form_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_groups`
--
ALTER TABLE `assessment_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_systems`
--
ALTER TABLE `roles_systems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_logins`
--
ALTER TABLE `social_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_departments`
--
ALTER TABLE `sub_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `assessment_emps`
--
ALTER TABLE `assessment_emps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `assessment_forms`
--
ALTER TABLE `assessment_forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assessment_form_details`
--
ALTER TABLE `assessment_form_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `assessment_groups`
--
ALTER TABLE `assessment_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `roles_systems`
--
ALTER TABLE `roles_systems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `social_logins`
--
ALTER TABLE `social_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_departments`
--
ALTER TABLE `sub_departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
