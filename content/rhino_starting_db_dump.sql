-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2020 at 03:30 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rhino_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `guest_id` bigint(20) UNSIGNED NOT NULL,
  `slot_id` mediumint(9) NOT NULL,
  `bring_guest` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_changing_car` tinyint(4) NOT NULL DEFAULT 0,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `part_ex_vrm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `part_ex_vehicle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `part_ex_distance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `part_ex_settlement` tinyint(1) DEFAULT NULL,
  `is_canceled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_vehicles`
--

CREATE TABLE `appointment_vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vehicle_condition` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colour` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands_translation`
--

CREATE TABLE `brands_translation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brand_dealership`
--

CREATE TABLE `brand_dealership` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `dealership_id` bigint(20) UNSIGNED NOT NULL,
  `region_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brand_event`
--

CREATE TABLE `brand_event` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brand_user`
--

CREATE TABLE `brand_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `new` tinyint(1) NOT NULL,
  `used` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies_translation`
--

CREATE TABLE `companies_translation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso_3166_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso_3166_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_seating_position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `country_code`, `iso_3166_2`, `iso_3166_3`, `driver_seating_position`, `status`, `created_at`, `updated_at`) VALUES
(1, 'United Kingdom', 'GB', 'GB', 'GBR', 'right', 1, '2020-01-13 12:46:04', '2020-01-13 12:46:04'),
(2, 'USA', 'US', 'US', 'USA', 'left', 1, '2020-01-13 12:46:04', '2020-01-13 12:46:04'),
(3, 'France', 'FR', 'FR', 'FRA', 'left', 1, '2020-01-13 12:46:04', '2020-01-13 12:46:04');

-- --------------------------------------------------------

--
-- Table structure for table `dealerships`
--

CREATE TABLE `dealerships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `latitude` double(9,6) DEFAULT NULL,
  `longitude` double(9,6) DEFAULT NULL,
  `monday_start` time DEFAULT NULL,
  `monday_end` time DEFAULT NULL,
  `tuesday_start` time DEFAULT NULL,
  `tuesday_end` time DEFAULT NULL,
  `wednesday_start` time DEFAULT NULL,
  `wednesday_end` time DEFAULT NULL,
  `thursday_start` time DEFAULT NULL,
  `thursday_end` time DEFAULT NULL,
  `friday_start` time DEFAULT NULL,
  `friday_end` time DEFAULT NULL,
  `saturday_start` time DEFAULT NULL,
  `saturday_end` time DEFAULT NULL,
  `sunday_start` time DEFAULT NULL,
  `sunday_end` time DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dealerships_translation`
--

CREATE TABLE `dealerships_translation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dealership_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_6` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dealership_user`
--

CREATE TABLE `dealership_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dealership_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dealership_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `appointment_duration` smallint(6) DEFAULT NULL,
  `break_time` smallint(6) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events_translation`
--

CREATE TABLE `events_translation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `greeting` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_user`
--

CREATE TABLE `event_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_vehicle`
--

CREATE TABLE `event_vehicle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `new` tinyint(1) NOT NULL,
  `used` tinyint(1) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups_translation`
--

CREATE TABLE `groups_translation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) NOT NULL,
  `unique` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_6` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `landline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_logged_in` datetime DEFAULT NULL,
  `stage` smallint(6) NOT NULL DEFAULT 1,
  `confirmation_letter_sent` tinyint(1) NOT NULL DEFAULT 0,
  `postal_contact` tinyint(1) NOT NULL DEFAULT 0,
  `email_contact` tinyint(1) NOT NULL DEFAULT 0,
  `sms_contact` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_vehicle`
--

CREATE TABLE `guest_vehicle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guest_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code2` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code3` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `flag` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code2`, `code3`, `name`, `status`, `flag`, `created_at`, `updated_at`) VALUES
(1, 'GB', 'GBR', 'English (UK)', 1, NULL, '2020-01-13 12:46:04', '2020-01-13 12:46:04'),
(2, 'US', 'USA', 'English (US)', 1, NULL, '2020-01-13 12:46:04', '2020-01-13 12:46:04'),
(3, 'FR', 'FRA', 'French', 1, NULL, '2020-01-13 12:46:04', '2020-01-13 12:46:04');

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
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_11_10_023605_create_companies_table', 1),
(4, '2019_11_10_023745_create_brands_table', 1),
(5, '2019_11_10_024423_create_countries_table', 1),
(6, '2019_11_10_025728_create_regions_table', 1),
(7, '2019_11_10_030520_create_groups_table', 1),
(8, '2019_11_10_045548_create_dealerships_table', 1),
(9, '2019_11_10_045616_create_types_table', 1),
(10, '2019_11_10_045816_create_events_table', 1),
(11, '2019_11_10_050000_create_users_table', 1),
(12, '2019_11_10_050100_create_appointments_table', 1),
(13, '2019_11_10_050136_create_guests_table', 1),
(14, '2019_11_10_052129_create_vehicles_table', 1),
(15, '2019_11_11_030753_create_brand_dealership_table', 1),
(16, '2019_11_11_031148_create_brand_event_table', 1),
(17, '2019_11_11_032000_create_brand_user_table', 1),
(18, '2019_11_11_032609_create_dealership_user_table', 1),
(19, '2019_11_11_035403_create_event_vehicle_table', 1),
(20, '2019_11_11_062459_create_guest_vehicle_table', 1),
(21, '2019_11_15_164054_create_events_users_relationship_table', 1),
(22, '2019_11_18_104500_create_event_translation', 1),
(23, '2019_11_18_105501_create_languages_table', 1),
(24, '2019_11_18_111809_create_dealerships_translation', 1),
(25, '2019_11_18_113234_create_settings_table', 1),
(26, '2019_11_18_113356_create_settings_translations_table', 1),
(27, '2019_11_18_121627_create_brands_translation_table', 1),
(28, '2019_11_18_123232_add_foreign_key_for_brands_translations', 1),
(29, '2019_11_18_124144_create_companies_translation_table', 1),
(30, '2019_11_18_130359_add_foreign_key_for_companies_translations', 1),
(31, '2019_11_18_131138_create_groups_translation_table', 1),
(32, '2019_11_18_140147_add_foreign_key_between_dealership_and_brands', 1),
(33, '2019_11_18_142353_add_foreign_key_between_dealership_and_user', 1),
(34, '2019_11_18_144932_add_foreign_key_between_dealership_and_dealership_translation', 1),
(35, '2019_11_18_145440_add_foreign_key_to_regions_table', 1),
(36, '2019_11_18_150827_add_foreign_key_to_guests_table', 1),
(37, '2019_11_18_150942_add_foreign_key_to_vehicles_table', 1),
(38, '2019_11_18_151100_add_foreign_key_to_guest_vehicle_table', 1),
(39, '2019_11_18_151306_add_foreign_key_to_event_user_table', 1),
(40, '2019_11_18_152114_add_foreign_key_for_settings_translation_table', 1),
(41, '2019_11_18_153400_add_foreign_key_to_brand_user_table', 1),
(42, '2019_11_18_155023_add_foreign_key_to_event_vehicle_table', 1),
(43, '2019_11_18_155258_add_foreign_key_to_brand_event_table', 1),
(44, '2019_11_18_160811_add_foreign_key_to_event_translation_table', 1),
(45, '2019_11_18_161504_create_type_translation_table', 1),
(46, '2019_11_18_161921_add_foreign_key_to_event_table', 1),
(47, '2019_11_18_162053_add_foreign_key_to_types_translation_table', 1),
(48, '2019_11_19_113530_create_time_zones_table', 1),
(49, '2019_12_02_161955_create_vehicles_translation_table', 1),
(50, '2019_12_02_162322_add_foreign_key_to_vehicle_translation_table', 1),
(51, '2019_12_06_143027_add_foreign_key_to_appointments_table', 1),
(52, '2019_12_06_170625_add_foreign_key_to_users_table', 1),
(53, '2020_01_02_164826_create_sessions_table', 1),
(54, '2020_01_10_145148_create_appointment_vehicles_table', 1),
(55, '2020_01_10_145558_add_foreign_ky_to_appointment_vehicles_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `identifier`, `created_at`, `updated_at`) VALUES
(1, 'greetingFrontend', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(2, 'confirmYourDetails', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(3, 'bookingConfirmation', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(4, 'uniqueId', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(5, 'EnterYourUniqueCode', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(6, 'e.gnchfge23sxs', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(7, 'home', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(8, 'name', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(9, 'of', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(10, 'edit', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(11, 'update', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(12, 'action', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(13, 'active', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(14, 'inactive', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(15, 'successfully_created', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(16, 'create', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(17, 'add', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(18, 'rows_per_page', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(19, 'delete', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(20, 'delete_confirmation', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(21, 'cancel', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(22, 'successfully_updated', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(23, 'successfully_deleted', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(24, 'dealerships', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(25, 'dealership', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(26, 'brands', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(27, 'brand', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(28, 'vehicles', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(29, 'vehicle', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(30, 'events', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(31, 'event', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(32, 'country', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(33, 'countries', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(34, 'region', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(35, 'regions', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(36, 'address', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(37, 'opening_times', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(38, 'status', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(39, 'select', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(40, 'select_a', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(41, 'select_country', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(42, 'select_region', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(43, 'postcode', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(44, 'capital', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(45, 'group', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(46, 'groups', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(47, 'guests', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(48, 'users', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(49, 'user', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(50, 'guest', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(51, 'languages', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(52, 'language', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(53, 'types', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(54, 'type', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(55, 'logo', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(56, 'color', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(57, 'actions', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(58, 'firstName', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(59, 'surName', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(60, 'passwords', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(61, 'password', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(62, 'enterYourPassword', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(63, 'minimum8Character', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(64, 'notMatching', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(65, 'rule', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(66, 'profile', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(67, 'flag', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(68, 'back', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(69, 'dashboard', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(70, 'list_of', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(71, 'list', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(72, 'is_required', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(73, 'ok', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(74, 'startDate', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(75, 'endDate', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(76, 'searchBy', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(77, 'email', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(78, 'role', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(79, 'confirm', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(80, 'admin', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(81, 'mobile', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(82, 'landline', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(83, 'method', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(84, 'appointment_duration', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(85, 'minutes', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(86, 'Hours', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(87, 'new', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(88, 'used', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(89, 'model', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(90, 'order', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(91, 'upload', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(92, 'image', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(93, 'left_hand_drive_image', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(94, 'right_hand_drive_image', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(95, 'sales_executive', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(96, 'sales_executives', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(97, 'has_been_added', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(98, 'settings', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(99, 'to', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(100, 'or', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(101, 'no', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(102, 'found', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(103, 'break', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(104, 'code', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(105, 'company', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(106, 'companies', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(107, 'seating_position', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(108, 'left', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(109, 'right', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(110, 'banner', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(111, 'latitude', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(112, 'longitude', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(113, 'monday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(114, 'tuesday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(115, 'wednesday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(116, 'thursday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(117, 'friday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(118, 'saturday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(119, 'sunday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(120, 'start', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(121, 'end', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(122, 'address_line', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(123, 'appointment', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(124, 'appointments', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(125, 'time', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(126, 'greeting', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(127, 'notes', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(128, 'text', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(129, 'date', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(130, 'your_details', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(131, 'partExchange', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(132, 'selectModel', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(133, 'bookYourSlot', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(134, 'logOut', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(135, 'login', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(136, 'SkipThisStep', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(137, 'unsure', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(138, 'nowBookYourAppointment', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(139, 'choose', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(140, 'a', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(141, 'sales', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(142, 'person', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(143, 'wouldYouLikeToBringGuest', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(144, 'mightYourGuestAlsoBeInterested', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(145, 'yes', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(146, 'available', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(147, 'dates', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(148, 'times', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(149, 'continue', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(150, 'signin', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(151, 'welcome', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(152, 'multi', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(153, 'access_level', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(154, 'staff', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(155, 'member', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(156, 'DoYouHaveACarToPartExchange', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(157, 'enterYour', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(158, 'details', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(159, 'registrationNumber', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(160, 'makeAndModel', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(161, 'currentMileage', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(162, 'byCheckingThisBox', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(163, 'clickHereDoNotExchangeVehicle', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(164, 'pleaseConfirmAmendYourContactDetails', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(165, 'areTheseDetailsStillCorrect', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(166, 'phoneNumber', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(167, 'save', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(168, 'followingDetailsAreCorrect', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(169, 'modelsOfInterest', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(170, 'amend', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(171, 'yourReservationConfirmed', '2020-01-13 12:55:09', '2020-01-13 12:55:09');

-- --------------------------------------------------------

--
-- Table structure for table `settings_translation`
--

CREATE TABLE `settings_translation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `setting_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings_translation`
--

INSERT INTO `settings_translation` (`id`, `setting_id`, `language_id`, `label`, `translation`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Greeting Frontend', 'Hello Mr Dinsdale and welcome to our Platinum Event.', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(2, 2, 1, 'Confirm your details', 'Confirm your details', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(3, 3, 1, 'Booking confirmation', 'Booking confirmation', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(4, 4, 1, 'UniqueId', 'Unique Id', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(5, 5, 1, 'Enter your unique code', 'Enter your unique code', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(6, 6, 1, 'e.g nchfge23sxs', 'e.g nchfge23sxs', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(7, 7, 1, 'Home', 'Home', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(8, 8, 1, 'Name', 'Name', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(9, 9, 1, 'of', 'of', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(10, 10, 1, 'Edit', 'Edit', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(11, 11, 1, 'Update', 'Update', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(12, 12, 1, 'Action', 'Action', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(13, 13, 1, 'Active', 'Active', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(14, 14, 1, 'Inactive', 'Inactive', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(15, 15, 1, 'Successfully created', 'Successfully created', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(16, 16, 1, 'Create', 'Create', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(17, 17, 1, 'Add', 'Add', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(18, 18, 1, 'Rows Per Page test', 'Rows Per Page', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(19, 19, 1, 'Delete', 'Delete', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(20, 20, 1, 'Are you sure you want to delete ?', 'Are you sure you want to delete ?', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(21, 21, 1, 'Cancel', 'Cancel', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(22, 22, 1, 'Successfully updated', 'Successfully updated', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(23, 23, 1, 'Successfully deleted', 'Successfully deleted', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(24, 24, 1, 'Dealerships', 'Dealerships', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(25, 25, 1, 'Dealership', 'Dealership', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(26, 26, 1, 'Brands', 'Brands', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(27, 27, 1, 'Brand', 'Brand', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(28, 28, 1, 'Vehicles', 'Vehicles', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(29, 29, 1, 'Vehicle', 'Vehicle', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(30, 30, 1, 'Events', 'Events', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(31, 31, 1, 'Event', 'Event', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(32, 32, 1, 'Country', 'Country', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(33, 33, 1, 'Countries', 'Countries', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(34, 34, 1, 'Region', 'Region', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(35, 35, 1, 'Regions', 'Regions', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(36, 36, 1, 'Address', 'Address', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(37, 37, 1, 'Opening Times', 'Opening Times', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(38, 38, 1, 'Status', 'Status', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(39, 39, 1, 'Select', 'Select', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(40, 40, 1, 'Select A', 'Select A', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(41, 41, 1, 'Select Country', 'Select Country', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(42, 42, 1, 'Select Region', 'Select region', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(43, 43, 1, 'Postcode', 'Postcode', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(44, 44, 1, 'Capital', 'Capital', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(45, 45, 1, 'Group', 'group', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(46, 46, 1, 'Groups', 'Groups', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(47, 47, 1, 'Guests', 'Guests', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(48, 48, 1, 'Users', 'Users', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(49, 49, 1, 'User', 'User', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(50, 50, 1, 'Guest', 'Guest', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(51, 51, 1, 'Languages', 'Languages', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(52, 52, 1, 'Language', 'Language', '2020-01-13 12:55:07', '2020-01-13 12:55:07'),
(53, 53, 1, 'Types', 'Types', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(54, 54, 1, 'Type', 'Type', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(55, 55, 1, 'Logo', 'Logo', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(56, 56, 1, 'Color', 'Color', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(57, 57, 1, 'Actions', 'Actions', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(58, 58, 1, 'First name', 'First name', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(59, 59, 1, 'Surname', 'Surname', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(60, 60, 1, 'Passwords', 'Passwords', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(61, 61, 1, 'Password', 'Password', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(62, 62, 1, 'Enter your password', 'Enter your password', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(63, 63, 1, 'minimum 8 character', 'minimum 8 character', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(64, 64, 1, 'not matching', 'not matching', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(65, 65, 1, 'Rule', 'Rule', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(66, 66, 1, 'Profile', 'Profile', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(67, 67, 1, 'Flag', 'Flag', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(68, 68, 1, 'Back', 'Back', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(69, 69, 1, 'Dashboard', 'Dashboard', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(70, 70, 1, 'List Of', 'List Of', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(71, 71, 1, 'List', 'List', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(72, 72, 1, 'is required', 'is required', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(73, 73, 1, 'Ok', 'Ok', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(74, 74, 1, 'Start Date', 'Start Date', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(75, 75, 1, 'End Date', 'End Date', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(76, 76, 1, 'Search by', 'Search by', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(77, 77, 1, 'Email', 'Email', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(78, 78, 1, 'Role', 'Role', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(79, 79, 1, 'Confirm', 'Confirm', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(80, 80, 1, 'Admin', 'Admin', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(81, 81, 1, 'Mobile', 'Mobile', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(82, 82, 1, 'Landline', 'Landline', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(83, 83, 1, 'Method', 'Method', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(84, 84, 1, 'Appointment Duration', 'Appointment Duration', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(85, 85, 1, 'Minutes', 'Minutes', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(86, 86, 1, 'Hours', 'Hours', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(87, 87, 1, 'New', 'New', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(88, 88, 1, 'Used', 'Used', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(89, 89, 1, 'Model', 'Model', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(90, 90, 1, 'Order', 'Order', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(91, 91, 1, 'Upload', 'Upload', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(92, 92, 1, 'image', 'image', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(93, 93, 1, 'Left hand drive image', 'Left hand drive image', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(94, 94, 1, 'Right hand drive image', 'Right hand drive image', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(95, 95, 1, 'Sales executive', 'Sales executive', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(96, 96, 1, 'Sales executives', 'Sales executives', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(97, 97, 1, 'Has been added', 'Has been added', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(98, 98, 1, 'Settings', 'Settings', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(99, 99, 1, 'To', 'To', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(100, 100, 1, 'Or', 'Or', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(101, 101, 1, 'No', 'No', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(102, 102, 1, 'Found', 'Found', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(103, 103, 1, 'Break', 'Break', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(104, 104, 1, 'Code', 'Code', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(105, 105, 1, 'Company', 'Company', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(106, 106, 1, 'Companies', 'Companies', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(107, 107, 1, 'Seating Position', 'Seating Position', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(108, 108, 1, 'Left', 'Left', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(109, 109, 1, 'Right', 'Right', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(110, 110, 1, 'Banner', 'Banner', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(111, 111, 1, 'Latitude', 'Latitude', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(112, 112, 1, 'Longitude', 'Longitude', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(113, 113, 1, 'Monday', 'Monday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(114, 114, 1, 'Tuesday', 'Tuesday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(115, 115, 1, 'Wednesday', 'Wednesday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(116, 116, 1, 'Thursday', 'Thursday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(117, 117, 1, 'Friday', 'Friday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(118, 118, 1, 'Saturday', 'Saturday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(119, 119, 1, 'Sunday', 'Sunday', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(120, 120, 1, 'Start', 'Start', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(121, 121, 1, 'End', 'End', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(122, 122, 1, 'Address Line', 'Address Line', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(123, 123, 1, 'Appointment', 'Appointment', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(124, 124, 1, 'Appointments', 'Appointments', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(125, 125, 1, 'Time', 'Time', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(126, 126, 1, 'Greeting', 'Greeting', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(127, 127, 1, 'Notes', 'Notes', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(128, 128, 1, 'Text', 'text', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(129, 129, 1, 'Date', 'Date', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(130, 130, 1, 'Your Details', 'Your Details', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(131, 131, 1, 'Part exchange', 'Part exchange', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(132, 132, 1, 'Select model', 'Select model', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(133, 133, 1, 'Book your slot', 'Book your slot', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(134, 134, 1, 'Logout', 'Logout', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(135, 135, 1, 'Login', 'Login', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(136, 136, 1, 'Skip this step', 'Skip this step', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(137, 137, 1, 'Unsure', 'Unsure', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(138, 138, 1, 'Now book your appointment', 'Now book your appointment', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(139, 139, 1, 'Choose', 'Choose', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(140, 140, 1, 'a', 'a', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(141, 141, 1, 'Sales', 'Sales', '2020-01-13 12:55:08', '2020-01-13 12:55:08'),
(142, 142, 1, 'Person', 'Person', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(143, 143, 1, 'Would you like to bring guest?', 'Would you like to bring guest?', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(144, 144, 1, 'Might your guest also be interested in changing their car?', 'Might your guest also be interested in changing their car?', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(145, 145, 1, 'Yes', 'Yes', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(146, 146, 1, 'Available', 'Available', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(147, 147, 1, 'Dates', 'dates', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(148, 148, 1, 'Times', 'times', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(149, 149, 1, 'Continue', 'Continue', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(150, 150, 1, 'Sign in', 'Sign in', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(151, 151, 1, 'Welcome', 'Welcome', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(152, 152, 1, 'Multi', 'Multi', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(153, 153, 1, 'Access Level', 'Access Level', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(154, 154, 1, 'Staff', 'Staff', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(155, 155, 1, 'Member', 'Member', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(156, 156, 1, 'Do you have a car to part exchange?', 'Do you have a car to part exchange?', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(157, 157, 1, 'Enter your', 'Enter your', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(158, 158, 1, 'Details', 'Details', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(159, 159, 1, 'Registration Number', 'Registration Number', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(160, 160, 1, 'Make and Model', 'Make and Model', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(161, 161, 1, 'Current Mileage', 'Current Mileage', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(162, 162, 1, 'By checking this box, you agree to us obtaining a settlement figure for your part exchange vehicle', 'By checking this box, you agree to us obtaining a settlement figure for your part exchange vehicle', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(163, 163, 1, 'Click here if you don\'t have a part exchange vehicle', 'Click here if you don\'t have a part exchange vehicle', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(164, 164, 1, 'Please confirm or amend your contact details', 'Please confirm or amend your contact details', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(165, 165, 1, 'Are these details still correct?', 'Are these details still correct?', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(166, 166, 1, 'Phone Number', 'Phone Number', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(167, 167, 1, 'Save', 'Save', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(168, 168, 1, 'Please check the following details are correct', 'Please check the following details are correct', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(169, 169, 1, 'Your model(s) of interest:', 'Your model(s) of interest:', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(170, 170, 1, 'Amend', 'Amend', '2020-01-13 12:55:09', '2020-01-13 12:55:09'),
(171, 171, 1, 'your reservation has been confirmed', 'your reservation has been confirmed', '2020-01-13 12:55:09', '2020-01-13 12:55:09');

-- --------------------------------------------------------

--
-- Table structure for table `time_zones`
--

CREATE TABLE `time_zones` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abbr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `offset` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isdst` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `types_translation`
--

CREATE TABLE `types_translation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealership_id` bigint(20) UNSIGNED DEFAULT NULL,
  `group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `region_id` bigint(20) UNSIGNED DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `manufacturer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_mail` tinyint(1) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `language_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `surname`, `email`, `email_verified_at`, `password`, `remember_token`, `level`, `dealership_id`, `group_id`, `region_id`, `country_id`, `manufacturer_id`, `company_id`, `notes`, `profile_image`, `send_mail`, `status`, `language_id`, `created_at`, `updated_at`) VALUES
(1, 'Rhino', 'Admin', 'admin@rhino.com', '2020-01-13 12:46:04', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'O95ibodSCcVAw3Id4Q8Fkwd2otkqfWJPGTU7lp5DrYx154DDu3OMf6x5FJnL', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, 'Saepe laudantium molestias vel sunt numquam cum. Dignissimos optio sint sit deleniti officiis. Velit tenetur aperiam quaerat tempora ratione dolores quia.', 'https://lorempixel.com/40/40/people/?63412', 1, 0, NULL, '2020-01-13 12:46:04', '2020-01-13 13:01:11');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `driver_seating_position_left_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_seating_position_right_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles_translation`
--

CREATE TABLE `vehicles_translation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `model` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_event_id_index` (`event_id`),
  ADD KEY `appointments_user_id_index` (`user_id`),
  ADD KEY `appointments_guest_id_index` (`guest_id`),
  ADD KEY `appointments_slot_id_index` (`slot_id`);

--
-- Indexes for table `appointment_vehicles`
--
ALTER TABLE `appointment_vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_vehicles_appointment_id_index` (`appointment_id`),
  ADD KEY `appointment_vehicles_vehicle_id_index` (`vehicle_id`),
  ADD KEY `appointment_vehicles_vehicle_condition_index` (`vehicle_condition`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_status_index` (`status`),
  ADD KEY `brands_company_id_foreign` (`company_id`);

--
-- Indexes for table `brands_translation`
--
ALTER TABLE `brands_translation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_translation_brand_id_index` (`brand_id`),
  ADD KEY `brands_translation_language_id_index` (`language_id`),
  ADD KEY `brands_translation_name_index` (`name`);

--
-- Indexes for table `brand_dealership`
--
ALTER TABLE `brand_dealership`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_dealership_brand_id_foreign` (`brand_id`),
  ADD KEY `brand_dealership_dealership_id_foreign` (`dealership_id`);

--
-- Indexes for table `brand_event`
--
ALTER TABLE `brand_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_event_brand_id_foreign` (`brand_id`),
  ADD KEY `brand_event_event_id_foreign` (`event_id`);

--
-- Indexes for table `brand_user`
--
ALTER TABLE `brand_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_user_brand_id_index` (`brand_id`),
  ADD KEY `brand_user_user_id_index` (`user_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_status_index` (`status`);

--
-- Indexes for table `companies_translation`
--
ALTER TABLE `companies_translation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_translation_language_id_index` (`language_id`),
  ADD KEY `companies_translation_company_id_foreign` (`company_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countries_status_index` (`status`);

--
-- Indexes for table `dealerships`
--
ALTER TABLE `dealerships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dealerships_country_id_index` (`country_id`),
  ADD KEY `dealerships_group_id_index` (`group_id`),
  ADD KEY `dealerships_latitude_index` (`latitude`),
  ADD KEY `dealerships_longitude_index` (`longitude`),
  ADD KEY `dealerships_status_index` (`status`);

--
-- Indexes for table `dealerships_translation`
--
ALTER TABLE `dealerships_translation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dealerships_translation_dealership_id_index` (`dealership_id`),
  ADD KEY `dealerships_translation_language_id_index` (`language_id`),
  ADD KEY `dealerships_translation_name_index` (`name`),
  ADD KEY `dealerships_translation_address_line_1_index` (`address_line_1`);

--
-- Indexes for table `dealership_user`
--
ALTER TABLE `dealership_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dealership_user_dealership_id_foreign` (`dealership_id`),
  ADD KEY `dealership_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_dealership_id_index` (`dealership_id`),
  ADD KEY `events_type_id_index` (`type_id`),
  ADD KEY `events_status_index` (`status`);

--
-- Indexes for table `events_translation`
--
ALTER TABLE `events_translation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_translation_event_id_index` (`event_id`),
  ADD KEY `events_translation_language_id_index` (`language_id`),
  ADD KEY `events_translation_name_index` (`name`);

--
-- Indexes for table `event_user`
--
ALTER TABLE `event_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_user_event_id_index` (`event_id`),
  ADD KEY `event_user_user_id_index` (`user_id`);

--
-- Indexes for table `event_vehicle`
--
ALTER TABLE `event_vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_vehicle_event_id_foreign` (`event_id`),
  ADD KEY `event_vehicle_vehicle_id_foreign` (`vehicle_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_status_index` (`status`);

--
-- Indexes for table `groups_translation`
--
ALTER TABLE `groups_translation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_translation_id_index` (`id`),
  ADD KEY `groups_translation_group_id_index` (`group_id`),
  ADD KEY `groups_translation_language_id_index` (`language_id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guests_unique_unique` (`unique`),
  ADD KEY `guests_event_id_index` (`event_id`),
  ADD KEY `guests_language_id_index` (`language_id`),
  ADD KEY `guests_email_index` (`email`),
  ADD KEY `guests_status_index` (`status`);

--
-- Indexes for table `guest_vehicle`
--
ALTER TABLE `guest_vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_vehicle_guest_id_index` (`guest_id`),
  ADD KEY `guest_vehicle_vehicle_id_index` (`vehicle_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `languages_code2_index` (`code2`),
  ADD KEY `languages_code3_index` (`code3`),
  ADD KEY `languages_status_index` (`status`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regions_brand_id_index` (`brand_id`),
  ADD KEY `regions_status_index` (`status`),
  ADD KEY `regions_country_id_foreign` (`country_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings_translation`
--
ALTER TABLE `settings_translation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_translation_setting_id_index` (`setting_id`),
  ADD KEY `settings_translation_language_id_index` (`language_id`);

--
-- Indexes for table `time_zones`
--
ALTER TABLE `time_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `types_status_index` (`status`);

--
-- Indexes for table `types_translation`
--
ALTER TABLE `types_translation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `types_translation_type_id_index` (`type_id`),
  ADD KEY `types_translation_language_id_index` (`language_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_dealership_id_index` (`dealership_id`),
  ADD KEY `users_group_id_index` (`group_id`),
  ADD KEY `users_region_id_index` (`region_id`),
  ADD KEY `users_country_id_index` (`country_id`),
  ADD KEY `users_manufacturer_id_index` (`manufacturer_id`),
  ADD KEY `users_company_id_index` (`company_id`),
  ADD KEY `users_status_index` (`status`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicles_brand_id_index` (`brand_id`);

--
-- Indexes for table `vehicles_translation`
--
ALTER TABLE `vehicles_translation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicles_translation_vehicle_id_index` (`vehicle_id`),
  ADD KEY `vehicles_translation_language_id_index` (`language_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment_vehicles`
--
ALTER TABLE `appointment_vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands_translation`
--
ALTER TABLE `brands_translation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brand_dealership`
--
ALTER TABLE `brand_dealership`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brand_event`
--
ALTER TABLE `brand_event`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brand_user`
--
ALTER TABLE `brand_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies_translation`
--
ALTER TABLE `companies_translation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dealerships`
--
ALTER TABLE `dealerships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dealerships_translation`
--
ALTER TABLE `dealerships_translation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dealership_user`
--
ALTER TABLE `dealership_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_translation`
--
ALTER TABLE `events_translation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_user`
--
ALTER TABLE `event_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_vehicle`
--
ALTER TABLE `event_vehicle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups_translation`
--
ALTER TABLE `groups_translation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guest_vehicle`
--
ALTER TABLE `guest_vehicle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `settings_translation`
--
ALTER TABLE `settings_translation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `time_zones`
--
ALTER TABLE `time_zones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types_translation`
--
ALTER TABLE `types_translation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles_translation`
--
ALTER TABLE `vehicles_translation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `appointment_vehicles`
--
ALTER TABLE `appointment_vehicles`
  ADD CONSTRAINT `appointment_vehicles_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_vehicles_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `brands_translation`
--
ALTER TABLE `brands_translation`
  ADD CONSTRAINT `brands_translation_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `brands_translation_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `brand_dealership`
--
ALTER TABLE `brand_dealership`
  ADD CONSTRAINT `brand_dealership_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `brand_dealership_dealership_id_foreign` FOREIGN KEY (`dealership_id`) REFERENCES `dealerships` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `brand_event`
--
ALTER TABLE `brand_event`
  ADD CONSTRAINT `brand_event_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `brand_event_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `brand_user`
--
ALTER TABLE `brand_user`
  ADD CONSTRAINT `brand_user_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `brand_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `companies_translation`
--
ALTER TABLE `companies_translation`
  ADD CONSTRAINT `companies_translation_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `companies_translation_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `dealerships`
--
ALTER TABLE `dealerships`
  ADD CONSTRAINT `dealerships_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `dealerships_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `dealerships_translation`
--
ALTER TABLE `dealerships_translation`
  ADD CONSTRAINT `dealerships_translation_dealership_id_foreign` FOREIGN KEY (`dealership_id`) REFERENCES `dealerships` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dealerships_translation_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `dealership_user`
--
ALTER TABLE `dealership_user`
  ADD CONSTRAINT `dealership_user_dealership_id_foreign` FOREIGN KEY (`dealership_id`) REFERENCES `dealerships` (`id`),
  ADD CONSTRAINT `dealership_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_dealership_id_foreign` FOREIGN KEY (`dealership_id`) REFERENCES `dealerships` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `events_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`);

--
-- Constraints for table `events_translation`
--
ALTER TABLE `events_translation`
  ADD CONSTRAINT `events_translation_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_translation_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `event_user`
--
ALTER TABLE `event_user`
  ADD CONSTRAINT `event_user_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `event_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `event_vehicle`
--
ALTER TABLE `event_vehicle`
  ADD CONSTRAINT `event_vehicle_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_vehicle_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups_translation`
--
ALTER TABLE `groups_translation`
  ADD CONSTRAINT `groups_translation_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `groups_translation_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `guests`
--
ALTER TABLE `guests`
  ADD CONSTRAINT `guests_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guest_vehicle`
--
ALTER TABLE `guest_vehicle`
  ADD CONSTRAINT `guest_vehicle_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guest_vehicle_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `regions`
--
ALTER TABLE `regions`
  ADD CONSTRAINT `regions_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `regions_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `settings_translation`
--
ALTER TABLE `settings_translation`
  ADD CONSTRAINT `settings_translation_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `settings_translation_setting_id_foreign` FOREIGN KEY (`setting_id`) REFERENCES `settings` (`id`);

--
-- Constraints for table `types_translation`
--
ALTER TABLE `types_translation`
  ADD CONSTRAINT `types_translation_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `types_translation_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_dealership_id_foreign` FOREIGN KEY (`dealership_id`) REFERENCES `dealerships` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicles_translation`
--
ALTER TABLE `vehicles_translation`
  ADD CONSTRAINT `vehicles_translation_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `vehicles_translation_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
