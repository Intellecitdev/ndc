-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 18, 2026 at 07:30 AM
-- Server version: 11.4.13-MariaDB
-- PHP Version: 8.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `intellec_ndcv2DB`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(250) NOT NULL,
  `url` varchar(500) NOT NULL,
  `method` varchar(10) NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `agent` varchar(500) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `old_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_data`)),
  `new_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `subject`, `url`, `method`, `ip`, `agent`, `user_id`, `old_data`, `new_data`, `created_at`, `updated_at`) VALUES
(1, 'Parent Category Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"name\":\"Sanitary\",\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":1}', '2026-10-17 17:42:22', '2026-10-17 17:42:22'),
(2, 'Category Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"parent_category_id\":1,\"name\":\"Sanitary\",\"description\":\"Sanitary item list\",\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":1}', '2026-10-17 17:42:22', '2026-10-17 17:42:22'),
(3, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0001\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Concealed Bib Cock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":1}', '2026-10-17 17:42:22', '2026-10-17 17:42:22'),
(4, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0002\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Plastic Bib Cock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":2}', '2026-10-17 17:42:22', '2026-10-17 17:42:22'),
(5, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0003\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Angel Stock Cock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":3}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(6, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0004\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Council Stock Cock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":4}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(7, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0005\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Twin Bib Cock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":5}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(8, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0006\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Pilar Cock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":6}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(9, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0007\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Basin Mixer Fixed\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":7}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(10, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0008\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Bath Mixer\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":8}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(11, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0009\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Sink Mixer\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":9}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(12, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0010\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Basin Mixer\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":10}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(13, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0011\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Push Shower\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":11}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(14, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0012\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Hand Shower\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":12}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(15, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0013\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Moving Shower\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":13}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(16, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0014\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"High Commode Seat Cover (Orient)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":14}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(17, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0015\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"High Commode Seat Cover (Carla)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":15}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(18, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0016\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"R A K Ball Cock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":16}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(19, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0017\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Soap Ketch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":17}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(20, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0018\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Basin Magic Pipe\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":18}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(21, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0019\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Sink Magic Pipe\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":19}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(22, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0020\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Sink Waste\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":20}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(23, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0021\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Tissue Holder\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":21}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(24, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0022\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Heat Proof Connection Pipe (Basin)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":22}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(25, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0023\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Heat Proof Connection Pipe (For Geyser)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":23}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(26, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0024\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Lead Pipe Connection Pipe White\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":24}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(27, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0025\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Gate Bulb \\u00be Inch, 1 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":25}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(28, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0026\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Gas Stove\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":26}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(29, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0027\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Double Injector\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":27}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(30, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0028\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Single Injector\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":28}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(31, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0029\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Thread Tap\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":29}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(32, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0030\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Glass Self\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":30}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(33, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0031\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"4 Inch Net Mesh for Bathroom\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":31}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(34, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0032\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"GI Bush\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":32}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(35, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0033\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Adjustable Range Sewing Range\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":33}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(36, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0034\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Pipe Range 14 Inches\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":34}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(37, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0035\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Gas Stove Pipe\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":35}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(38, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0036\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Sink Pillar Cock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":36}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(39, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0037\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Glass Clip Packet\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":37}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(40, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0038\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Gas Stove Pipe Clip\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":38}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(41, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0039\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"GI Plug\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":39}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(42, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0040\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Bath Shower Pipe\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":40}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(43, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0041\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Push Shower Head\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":41}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(44, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0042\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Push Button\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":42}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(45, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0043\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Basin Mixer Moving\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":43}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(46, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0044\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"RAK Ball Cock Fitting\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":44}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(47, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0045\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Bath Shower Head\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":45}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(48, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0046\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"High Commode Seat Cover Nut\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":46}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(49, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0047\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Kurian Putting\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":47}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(50, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0048\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"White Cement\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":48}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(51, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0049\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"0.5 Inch Gate Bulb\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":49}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(52, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0050\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"0.5\\/1.5 Inch Ball Bulb\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":50}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(53, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0051\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"0.5 Inch GI Short Pitch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":51}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(54, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0052\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Gas Stove Nozzle\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":52}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(55, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0053\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Water Filter PP 20 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":53}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(56, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0054\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Water Filter PP 10 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":54}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(57, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0055\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Towel Stand (24 Inch SS)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":55}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(58, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0056\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Ball Cock (Float Bulb) 2 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":56}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(59, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0057\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Ball Cock (Float Bulb) 1.5 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":57}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(60, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0058\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Ball Cock (Float Bulb) 1 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":58}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(61, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0059\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Ball Cock (Float Sand) 0.5 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":59}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(62, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0060\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Ball Cock (Float Bulb) 3\\/4 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":60}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(63, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0061\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Net Filter (20 Inch)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":61}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(64, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0062\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Net Filter (10 Inch)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":62}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(65, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0063\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Box Filter (20 Inch)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":63}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(66, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0064\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Box Filter (10 Inch)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":64}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(67, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0065\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Gas Riser\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":65}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(68, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0066\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Plastic Low Down\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":66}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(69, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0067\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Thai Silicone Gum\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":67}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(70, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0068\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Gas Stove Half-Quarter Key\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":68}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(71, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0069\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Rack Towel Rail\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":69}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(72, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0070\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Water Filter Bib Cock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":70}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(73, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0071\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Kitchen Tissue Holder (SS)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":71}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(74, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0072\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Plus Minus Gum\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":72}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(75, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0073\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Ring Tape\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":73}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(76, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0074\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"100 Gas Burners\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":74}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(77, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0075\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"0.5 Inch Gas Cock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":75}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(78, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0076\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"0.5 Inch Non-Nikon Bulb\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":76}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(79, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0077\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"0.5 Inch Union GI\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":77}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(80, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0078\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"0.5 Inch Elbow GI\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":78}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(81, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0079\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"0.5 Inch Nipple GI\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":79}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(82, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0080\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Bath Mixer Off Side\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":80}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(83, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0081\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Geyser Pressure Bulb\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":81}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(84, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0082\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Star Ainge Set\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":82}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(85, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0083\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Water Filter Pressure Bulb\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":83}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(86, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0084\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Water Filter Inlet Bulb\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":84}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(87, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0085\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"CPVC Pipe\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":85}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(88, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0086\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"CPVC Pipe (Female Type Socket)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":86}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(89, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0087\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"CPVC Pipe (Male Type Socket)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":87}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(90, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0088\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"CPVC Pipe (Plain Elbow)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":88}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(91, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0089\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"CPVC Pipe Gum\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":89}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(92, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0090\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"CPVC Pipe (Female Tee)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":90}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(93, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0091\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"CPVC Pipe (Plain Tee)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":91}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(94, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0092\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"CPVC Pipe (Female Elbow)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":92}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(95, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0093\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"CPVC Union\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":93}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(96, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0094\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"RD Water Connector\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":94}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(97, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0095\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"50 mm Lock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":95}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(98, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0096\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Water Filter Pipe (5 mm)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":96}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(99, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0097\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Water Filter Pipe (10 mm)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":97}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(100, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0098\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Plumber Tools Bag\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":98}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(101, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0099\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Electric Carrying Bag\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":99}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(102, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0100\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Sink Cock Div\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":100}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(103, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0101\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"18 Inch Manhole Cover\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":101}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(104, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0102\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"2 Inch UPVC Pipe\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":102}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(105, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0103\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"2 Inch Elbow\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":103}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(106, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0104\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"2 Inch Pipe Tee\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":104}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(107, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0105\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"2 Inch Clam (GI)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":105}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(108, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0106\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Ring Caster\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":106}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(109, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0107\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"CPVC Plain Socket\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":107}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(110, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0108\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"Login Cock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":108}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(111, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"SAN-0109\",\"parent_category_id\":1,\"category_id\":1,\"item_unit_id\":1,\"name\":\"0.5 Inch GI Clam\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":109}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(112, 'Parent Category Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"name\":\"Carpenter\",\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":2}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(113, 'Category Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"parent_category_id\":2,\"name\":\"Carpenter\",\"description\":\"Carpenter item list\",\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":2}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(114, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0001\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Steel Cornice\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":110}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(115, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0002\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Steel Tape\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":111}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(116, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0003\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Geyser 45 Ltr\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":112}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(117, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0004\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"HazBolt\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":113}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(118, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0005\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Rim Lock\\/Door Lock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":114}', '2026-10-17 17:42:23', '2026-10-17 17:42:23');
INSERT INTO `activity_logs` (`id`, `subject`, `url`, `method`, `ip`, `agent`, `user_id`, `old_data`, `new_data`, `created_at`, `updated_at`) VALUES
(119, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0006\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Handle Lock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":115}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(120, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0007\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Lever Lock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":116}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(121, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0008\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Splash\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":117}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(122, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0009\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Screen Clam\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":118}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(123, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0010\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Counsel Kopje\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":119}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(124, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0011\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Chain Link\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":120}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(125, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0012\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Drawer Lock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":121}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(126, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0013\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Door Magnet\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":122}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(127, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0014\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Wardrobe Channel (15 Inch)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":123}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(128, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0015\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Door Handle\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":124}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(129, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0016\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Drawer Handle Golden\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":125}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(130, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0017\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Thai Window Wheel\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":126}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(131, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0018\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Thai Lock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":127}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(132, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0019\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Thai Window Mosquito Net (Fiber) 7 Feet\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":128}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(133, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0020\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Thai Rubber 2 Part Half Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":129}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(134, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0021\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Thai Rubber Round 2 Yarn\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":130}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(135, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0022\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Plastic Door Casing (3 Inch)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":131}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(136, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0023\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Melamine Board (Bois Color)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":132}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(137, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0024\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Melamine Board (Grey Color)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":133}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(138, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0025\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Roar Fly Board (15 ml)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":134}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(139, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0026\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Roar Fly Board (18 ml)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":135}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(140, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0027\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Aging 3x4 Base Color\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":136}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(141, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0028\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Aging 3x8 Grey Color\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":137}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(142, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0029\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Aging 3x4 Wall Night Color\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":138}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(143, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0030\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Solution Gum\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":139}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(144, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0031\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"L Culm 1 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":140}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(145, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0032\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Drawer Lock Clam 1 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":141}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(146, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0033\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Auto Polish\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":142}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(147, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0034\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Wood Series Paper\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":143}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(148, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0035\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"MS Washer (2 Yarns) Thin\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":144}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(149, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0036\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"MS Washer (3 Yarns) Thin\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":145}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(150, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0037\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Wardrobe Concealed Closet (State\\/Half\\/Full)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":146}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(151, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0038\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Glass Push Magnet (Black)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":147}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(152, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0039\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Glass Magnet\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":148}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(153, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0040\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Push Lock\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":149}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(154, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0041\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Super Glue Gum\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":150}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(155, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0042\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Tip Pudding\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":151}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(156, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0043\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Wood Screw 0.5 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":152}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(157, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0044\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Wood Screw 1.4\\/1 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":153}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(158, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0045\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Guna Wire (Thin)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":154}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(159, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0046\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"GI Wire\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":155}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(160, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0047\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Net Thai Window Wheel\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":156}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(161, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0048\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Glass Cutting Pen\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":157}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(162, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0049\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Wood Screw 3\\/4 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":158}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(163, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0050\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Drawer Handle Screw 1.4\\/1 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":159}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(164, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0051\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Drawer Handle Screw 1 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":160}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(165, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0052\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Pipe Handle\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":161}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(166, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0053\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Star Burning Screw (1 Inch)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":162}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(167, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0054\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Star Burning Screw (1.5 Inch)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":163}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(168, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0055\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Doba Handle\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":164}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(169, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0056\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Drawer Knobs\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":165}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(170, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0057\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Mosquito Netting Hook\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":166}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(171, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0058\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Steel Wire Cut (0.5 Inch)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":167}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(172, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0059\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Steel Wire Cut (1 Inch)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":168}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(173, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0060\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Steel Wire Cut (2 Inch)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":169}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(174, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0061\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Pin Super (3\\/4) White\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":170}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(175, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0062\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Wool Screw 3 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":171}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(176, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0063\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Plastic Door Handle\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":172}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(177, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0064\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"4 Wooden Door Hinge\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":173}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(178, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0065\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Hand Saw\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":174}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(179, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0066\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Conceal Height 2 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":175}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(180, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0067\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Batal\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":176}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(181, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0068\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Kechi\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":177}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(182, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0069\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Screw 0.5 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":178}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(183, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0070\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Screw 1 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":179}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(184, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0071\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Screw 1.5 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":180}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(185, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0072\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Screw 2 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":181}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(186, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0073\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Screw 2.5 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":182}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(187, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"CAR-0074\",\"parent_category_id\":2,\"category_id\":2,\"item_unit_id\":1,\"name\":\"Screw 3 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":183}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(188, 'Parent Category Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"name\":\"Electric\",\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":3}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(189, 'Category Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"parent_category_id\":3,\"name\":\"Electric\",\"description\":\"Electric item list\",\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":3}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(190, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0001\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Light 15 Watt\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":184}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(191, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0002\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Tube Light 4 Fit 20 Watt\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":185}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(192, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0003\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Tube Light 2 Fit 10 Watt\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":186}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(193, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0004\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Slim Botton LED Tube Light 4 Fit 40 Watt\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":187}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(194, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0005\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Slim Botton LED Tube Light 2 Fit 20 Watt\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":188}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(195, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0006\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"T-5 Tube Light 4 Feet 20 Watt (White)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":189}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(196, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0007\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"T-5 Tube Light 4 Feet 20 Watt (Oram)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":190}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(197, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0008\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Jhar Batir Light Small \\/60 Watt\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":191}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(198, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0009\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Light 07 Watt\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":192}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(199, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0010\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Panel Light 6 Watt\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":193}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(200, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0011\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Panel Light 8 Watt\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":194}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(201, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0012\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Panel Light 40 Watt (Slim Type Square)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":195}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(202, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0013\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Light 40 Watt (Box Type Square)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":196}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(203, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0014\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Panel Light 40 Watt (Box Type Square)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":197}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(204, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0015\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Panel Light 40 Watt (Slim Type Square)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":198}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(205, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0016\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Panel Light 1\\u00d71 Fit 24 Watt\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":199}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(206, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0017\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Panel Light 8\\u00d78 Fit 18 Watt (Box Type Square)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":200}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(207, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0018\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Panel Light 8\\u00d78 Fit 18 Watt (Slim Type Square)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":201}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(208, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0019\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Panel Light 8\\u00d78 Fit 12 Watt (Slim Type Square)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":202}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(209, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0020\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Panel Light 8\\u00d78 Fit 12 Watt (Box Type Square)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":203}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(210, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0021\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Search Light 100 Watt\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":204}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(211, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0022\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Search Light 200 Watt\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":205}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(212, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0023\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Ceiling Fan 56 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":206}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(213, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0024\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Exhaust Fan 06 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":207}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(214, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0025\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Exhaust Fan 08 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":208}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(215, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0026\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Exhaust Fan 10 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":209}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(216, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0027\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Exhaust Fan 12 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":210}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(217, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0028\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Holder\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":211}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(218, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0029\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"MK Regulator\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":212}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(219, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0030\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Normal Regulator\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":213}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(220, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0031\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Capacitor\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":214}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(221, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0032\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"2 Pin Socket\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":215}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(222, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0033\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"3 Pin Socket\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":216}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(223, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0034\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"6 Pin Socket\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":217}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(224, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0035\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"3 Pin Plug\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":218}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(225, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0036\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"MK Box\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":219}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(226, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0037\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Piano Switch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":220}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(227, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0038\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"1 Gang Switch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":221}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(228, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0039\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"2 Gang Switch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":222}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(229, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0040\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"3 Gang Switch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":223}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(230, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0041\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"4 Gang Switch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":224}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(231, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0042\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"DB Switch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":225}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(232, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0043\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"1.5 RM Cable\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":226}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(233, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0044\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Electric Channel\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":227}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(234, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0045\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"10 AMP Circuit Breaker\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":228}', '2026-10-17 17:42:23', '2026-10-17 17:42:23');
INSERT INTO `activity_logs` (`id`, `subject`, `url`, `method`, `ip`, `agent`, `user_id`, `old_data`, `new_data`, `created_at`, `updated_at`) VALUES
(235, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0046\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"16 AMP Circuit Breaker\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":229}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(236, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0047\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"20 AMP Circuit Breaker\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":230}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(237, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0048\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"32 AMP Circuit Breaker\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":231}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(238, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0049\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"40 AMP Circuit Breaker\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":232}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(239, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0050\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"63 AMP Circuit Breaker\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":233}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(240, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0051\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Screw Driver\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":234}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(241, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0052\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Royal Plug\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":235}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(242, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0053\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Plus\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":236}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(243, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0054\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Taster\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":237}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(244, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0055\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Drill Machine\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":238}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(245, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0056\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Calling Bell Battery\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":239}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(246, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0057\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Calling Bell Electric\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":240}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(247, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0058\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Piano 2 Pin Socket\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":241}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(248, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0059\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"2 Pin Plug\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":242}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(249, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0060\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Wall Holder\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":243}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(250, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0061\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Multi Plug\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":244}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(251, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0062\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Spot Light White\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":245}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(252, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0063\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Pasha Spot Light\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":246}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(253, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0064\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Calling Bell Switch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":247}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(254, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0065\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Cable Clip\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":248}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(255, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0066\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Focus LED Light\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":249}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(256, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0067\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Hammer\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":250}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(257, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0068\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Nos Plus\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":251}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(258, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0069\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Cutting Plus\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":252}', '2026-10-17 17:42:23', '2026-10-17 17:42:23'),
(259, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0070\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Piano Calling Bell Switch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":253}', '2026-10-17 17:42:24', '2026-10-17 17:42:24'),
(260, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0071\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Ceiling Fan 36 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":254}', '2026-10-17 17:42:24', '2026-10-17 17:42:24'),
(261, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0072\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Remote Battery\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":255}', '2026-10-17 17:42:24', '2026-10-17 17:42:24'),
(262, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0073\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Chamatir Small \\/ Slim Patch Holder\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":256}', '2026-10-17 17:42:24', '2026-10-17 17:42:24'),
(263, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0074\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Jharbati Holder (Golden Colour)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":257}', '2026-10-17 17:42:24', '2026-10-17 17:42:24'),
(264, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0075\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Spot Light Oram\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":258}', '2026-10-17 17:42:24', '2026-10-17 17:42:24'),
(265, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0076\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Panel Light 1 Fit \\/ 4 Fit (Box Type)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":259}', '2026-10-17 17:42:24', '2026-10-17 17:42:24'),
(266, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0077\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"T-5 Light 2 Fit 10 Watt Oram\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":260}', '2026-10-17 17:42:24', '2026-10-17 17:42:24'),
(267, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0078\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"One Phase Circuit Breaker Box\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":261}', '2026-10-17 17:42:24', '2026-10-17 17:42:24'),
(268, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0079\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Panel Light 4 Fit \\/ 6 Inch\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":262}', '2026-10-17 17:42:24', '2026-10-17 17:42:24'),
(269, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0080\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"Panel Light 6 Inch Round\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":263}', '2026-10-17 17:42:24', '2026-10-17 17:42:24'),
(270, 'Item Created', 'http://localhost/ndcitinv', 'GET', '127.0.0.1', 'Symfony', NULL, NULL, '{\"code\":\"ELE-0081\",\"parent_category_id\":3,\"category_id\":3,\"item_unit_id\":1,\"name\":\"LED Light 15 Watt (Oram Colour)\",\"has_warranty\":false,\"is_consumable\":true,\"is_license\":false,\"status\":true,\"approval_status\":\"Approved\",\"created_by\":null,\"updated_by\":null,\"id\":264}', '2026-10-17 17:42:24', '2026-10-17 17:42:24'),
(271, 'Logged In administrator@gmail.com', 'http://localhost/ndcitinv/login', 'POST', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, NULL, NULL, '2026-10-17 20:03:14', '2026-10-17 20:03:14'),
(272, 'Logged In administrator@gmail.com', 'https://ndcv2.intellecsoftbd.com/login', 'POST', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, NULL, NULL, '2026-10-18 02:28:24', '2026-10-18 02:28:24'),
(273, 'Supplier Deleted', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/suppliers/20', 'DELETE', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"id\":20,\"code\":\"SUP-020\",\"name\":\"Faruk Construction Materials\",\"contact_person\":\"Mizanur Faruk\",\"contact_no\":\"01711000020\",\"email\":\"mizanur@farukconstruction.com\",\"address\":\"Comilla Sadar, Comilla\",\"status\":true,\"created_by\":null,\"updated_by\":null}', NULL, '2026-10-18 02:28:54', '2026-10-18 02:28:54'),
(274, 'Supplier Deleted', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/suppliers/19', 'DELETE', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"id\":19,\"code\":\"SUP-019\",\"name\":\"Haque Garments Accessories\",\"contact_person\":\"Emran Haque\",\"contact_no\":\"01711000019\",\"email\":\"emran@haquegarments.com\",\"address\":\"Gazipura, Gazipur\",\"status\":true,\"created_by\":null,\"updated_by\":null}', NULL, '2026-10-18 02:28:57', '2026-10-18 02:28:57'),
(275, 'Supplier Deleted', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/suppliers/18', 'DELETE', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"id\":18,\"code\":\"SUP-018\",\"name\":\"Majumder Security Systems\",\"contact_person\":\"Tapos Majumder\",\"contact_no\":\"01711000018\",\"email\":\"tapos@majumdersecurity.com\",\"address\":\"Banani, Dhaka\",\"status\":true,\"created_by\":null,\"updated_by\":null}', NULL, '2026-10-18 02:29:00', '2026-10-18 02:29:00'),
(276, 'Supplier Deleted', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/suppliers/17', 'DELETE', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"id\":17,\"code\":\"SUP-017\",\"name\":\"Pramanik Glass & Ceramics\",\"contact_person\":\"Ratan Pramanik\",\"contact_no\":\"01711000017\",\"email\":\"\",\"address\":\"Ashulia, Savar, Dhaka\",\"status\":true,\"created_by\":null,\"updated_by\":null}', NULL, '2026-10-18 02:29:03', '2026-10-18 02:29:03'),
(277, 'Supplier Deleted', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/suppliers/16', 'DELETE', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"id\":16,\"code\":\"SUP-016\",\"name\":\"Mondol Packaging Ltd.\",\"contact_person\":\"Suman Mondol\",\"contact_no\":\"01711000016\",\"email\":\"suman@mondolpackaging.com\",\"address\":\"Khulna Sadar, Khulna\",\"status\":false,\"created_by\":null,\"updated_by\":null}', NULL, '2026-10-18 02:29:06', '2026-10-18 02:29:06'),
(278, 'Supplier Deleted', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/suppliers/15', 'DELETE', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"id\":15,\"code\":\"SUP-015\",\"name\":\"Bhuiyan Electrical Suppliers\",\"contact_person\":\"Farid Bhuiyan\",\"contact_no\":\"01711000015\",\"email\":\"farid@bhuiyanelectrical.com\",\"address\":\"Bogra Sadar, Bogura\",\"status\":true,\"created_by\":null,\"updated_by\":null}', NULL, '2026-10-18 02:29:08', '2026-10-18 02:29:08'),
(279, 'Unit Deleted', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/units/281', 'DELETE', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"id\":281,\"code\":\"WHI0008\",\"name\":\"NDC\",\"address\":\"NDC\",\"type\":\"Wing\",\"order\":8,\"status\":true}', NULL, '2026-10-18 02:29:46', '2026-10-18 02:29:46'),
(280, 'Unit Deleted', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/units/6', 'DELETE', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"id\":6,\"code\":\"WHI0007\",\"name\":\"AITSO\",\"address\":\"Dhaka\",\"type\":\"Wing\",\"order\":7,\"status\":true}', NULL, '2026-10-18 02:29:48', '2026-10-18 02:29:48'),
(281, 'Unit Deleted', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/units/5', 'DELETE', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"id\":5,\"code\":\"WHI0006\",\"name\":\"9 division\",\"address\":\"Kadirabad\",\"type\":\"Wing\",\"order\":6,\"status\":true}', NULL, '2026-10-18 02:29:51', '2026-10-18 02:29:51'),
(282, 'Unit Deleted', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/units/4', 'DELETE', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"id\":4,\"code\":\"WHI0005\",\"name\":\"7 division\",\"address\":\"jahangirabad\",\"type\":\"Wing\",\"order\":5,\"status\":true}', NULL, '2026-10-18 02:29:53', '2026-10-18 02:29:53'),
(283, 'Unit Deleted', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/units/3', 'DELETE', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"id\":3,\"code\":\"WHI0004\",\"name\":\"8 division\",\"address\":\"Bogura\",\"type\":\"Wing\",\"order\":4,\"status\":true}', NULL, '2026-10-18 02:29:56', '2026-10-18 02:29:56'),
(284, 'Unit Deleted', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/units/2', 'DELETE', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"id\":2,\"code\":\"WHI0003\",\"name\":\"10 division\",\"address\":\"Borisal\",\"type\":\"Wing\",\"order\":3,\"status\":true}', NULL, '2026-10-18 02:29:58', '2026-10-18 02:29:58'),
(285, 'Unit Deleted', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/units/1', 'DELETE', '103.145.209.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"id\":1,\"code\":\"WHI0001\",\"name\":\"ITDTE\",\"address\":\"AHQ, Dhaka Cantonment\",\"type\":\"Wing\",\"order\":1,\"status\":true}', NULL, '2026-10-18 02:30:00', '2026-10-18 02:30:00'),
(286, 'Logged In administrator@gmail.com', 'https://ndcv2.intellecsoftbd.com/login', 'POST', '103.112.236.251', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, NULL, NULL, '2026-10-18 09:36:10', '2026-10-18 09:36:10'),
(287, 'Logged In shamim424884@gmail.com', 'https://ndcv2.intellecsoftbd.com/login', 'POST', '37.111.225.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 1, NULL, NULL, '2026-10-18 10:29:20', '2026-10-18 10:29:20'),
(288, 'Logged Out shamim424884@gmail.com', 'https://ndcv2.intellecsoftbd.com/logout', 'POST', '37.111.225.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 1, NULL, NULL, '2026-10-18 10:35:46', '2026-10-18 10:35:46'),
(289, 'Logged In storman@gmail.com', 'https://ndcv2.intellecsoftbd.com/login', 'POST', '37.111.225.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 4, NULL, NULL, '2026-10-18 10:36:04', '2026-10-18 10:36:04'),
(290, 'Logged In storman@gmail.com', 'https://ndcv2.intellecsoftbd.com/login', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 4, NULL, NULL, '2026-10-18 10:46:15', '2026-10-18 10:46:15'),
(291, 'Logged In administrator@gmail.com', 'https://ndcv2.intellecsoftbd.com/login', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, NULL, NULL, '2026-10-18 10:49:33', '2026-10-18 10:49:33'),
(292, 'Unit Created', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/units', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, NULL, '{\"code\":\"0001\",\"name\":\"NDC\",\"address\":\"Dhaka\",\"type\":\"Wing\",\"order\":\"1\",\"status\":true,\"id\":282}', '2026-10-18 10:50:30', '2026-10-18 10:50:30'),
(293, 'Unit Created', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/units', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, NULL, '{\"code\":\"0002\",\"name\":\"TRG\",\"address\":\"Dhaka\",\"type\":\"Wing\",\"order\":\"2\",\"status\":true,\"id\":283}', '2026-10-18 10:51:07', '2026-10-18 10:51:07'),
(294, 'Unit Created', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/units', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, NULL, '{\"code\":\"0003\",\"name\":\"AWFC\",\"address\":\"Dhaka\",\"type\":\"Wing\",\"order\":\"3\",\"status\":true,\"id\":284}', '2026-10-18 10:52:15', '2026-10-18 10:52:15'),
(295, 'Unit Created', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/units', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, NULL, '{\"code\":\"0004\",\"name\":\"ITDE\",\"address\":\"Dhaka\",\"type\":\"Wing\",\"order\":\"4\",\"status\":true,\"id\":285}', '2026-10-18 10:52:35', '2026-10-18 10:52:35'),
(296, 'Unit Created', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/units', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, NULL, '{\"code\":\"0005\",\"name\":\"MT\",\"address\":\"Dhaka\",\"type\":\"Wing\",\"order\":\"5\",\"status\":true,\"id\":286}', '2026-10-18 10:52:56', '2026-10-18 10:52:56'),
(297, 'Supplier Created', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/suppliers', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, NULL, '{\"code\":\"SP-001\",\"name\":\"Khan Electronics\",\"contact_person\":\"Adbullah Al Mamun\",\"contact_no\":\"01912345678\",\"email\":\"mamun@gmail.com\",\"address\":\"Mirpur 2, Dhaka\",\"status\":true,\"created_by\":2,\"updated_by\":2,\"id\":21}', '2026-10-18 10:54:51', '2026-10-18 10:54:51'),
(298, 'Supplier Created', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/suppliers', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, NULL, '{\"code\":\"SP-002\",\"name\":\"Shamim Traders\",\"contact_person\":\"Shamim Osman\",\"contact_no\":\"01712345678\",\"email\":\"shamim@gmail.com\",\"address\":\"Mirpur 6, Dhaka\",\"status\":true,\"created_by\":2,\"updated_by\":2,\"id\":22}', '2026-10-18 10:55:43', '2026-10-18 10:55:43'),
(299, 'Category Updated', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/categories/3', 'PATCH', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"name\":\"Electric\",\"description\":\"Electric item list\",\"updated_by\":null}', '{\"name\":\"LED Light\",\"description\":null,\"updated_by\":2}', '2026-10-18 10:56:45', '2026-10-18 10:56:45'),
(300, 'Category Updated', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/categories/3', 'PATCH', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"name\":\"LED Light\",\"description\":null}', '{\"name\":\"Light\",\"description\":\"Electric LED Light\"}', '2026-10-18 10:57:06', '2026-10-18 10:57:06'),
(301, 'Category Created', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/categories', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, NULL, '{\"parent_category_id\":\"3\",\"name\":\"Fan\",\"description\":\"Electric Fan\",\"status\":true,\"created_by\":2,\"updated_by\":2,\"approval_status\":\"Pending\",\"id\":4}', '2026-10-18 10:57:32', '2026-10-18 10:57:32'),
(302, 'Logged In qm@gmail.com', 'https://ndcv2.intellecsoftbd.com/login', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 3, NULL, NULL, '2026-10-18 10:58:13', '2026-10-18 10:58:13'),
(303, 'Category Updated', 'https://ndcv2.intellecsoftbd.com/inventory/approvals/1/approve', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 3, '{\"updated_by\":2,\"approval_status\":\"Pending\"}', '{\"updated_by\":3,\"approval_status\":\"Approved\"}', '2026-10-18 10:58:19', '2026-10-18 10:58:19'),
(304, 'Category Updated', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/categories/3', 'PATCH', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"name\":\"Light\"}', '{\"name\":\"Electric Item\"}', '2026-10-18 11:00:29', '2026-10-18 11:00:29'),
(305, 'Brand Created', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/brands', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 4, NULL, '{\"category_id\":\"3\",\"name\":\"Vision\",\"description\":null,\"status\":true,\"created_by\":4,\"updated_by\":4,\"approval_status\":\"Pending\",\"id\":1}', '2026-10-18 11:04:11', '2026-10-18 11:04:11'),
(306, 'Brand Updated', 'https://ndcv2.intellecsoftbd.com/inventory/approvals/2/approve', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 3, '{\"updated_by\":4,\"approval_status\":\"Pending\"}', '{\"updated_by\":3,\"approval_status\":\"Approved\"}', '2026-10-18 11:04:15', '2026-10-18 11:04:15'),
(307, 'Logged In administrator@gmail.com', 'https://ndcv2.intellecsoftbd.com/login', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, NULL, NULL, '2026-10-18 11:04:19', '2026-10-18 11:04:19'),
(308, 'Item Updated', 'https://ndcv2.intellecsoftbd.com/inventory/configuration/items/264', 'PUT', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 2, '{\"brand_id\":null,\"has_warranty\":false,\"is_consumable\":true,\"updated_by\":null}', '{\"brand_id\":\"1\",\"has_warranty\":true,\"is_consumable\":false,\"updated_by\":2}', '2026-10-18 11:07:03', '2026-10-18 11:07:03'),
(309, 'Purchase Order Created', 'https://ndcv2.intellecsoftbd.com/inventory/purchase/purchaseorders', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 4, NULL, '{\"date\":\"2026-10-18 00:00:00\",\"supplier_id\":\"21\",\"financial_year_id\":\"1\",\"reference_no\":\"123456\",\"priority\":\"3\",\"comments\":null,\"po_no\":\"tmp6ad4569d35acc\",\"unit_id\":null,\"created_by\":4,\"updated_by\":4,\"approval_status\":\"Pending\",\"id\":1}', '2026-10-18 11:18:21', '2026-10-18 11:18:21'),
(310, 'Purchase Order Updated', 'https://ndcv2.intellecsoftbd.com/inventory/purchase/purchaseorders', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 4, '{\"po_no\":\"tmp6ad4569d35acc\"}', '{\"po_no\":\"PO000001\\/2026-2027\"}', '2026-10-18 11:18:21', '2026-10-18 11:18:21'),
(311, 'Purchase Order Updated', 'https://ndcv2.intellecsoftbd.com/inventory/approvals/3/approve', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 3, '{\"updated_by\":4,\"approval_status\":\"Pending\"}', '{\"updated_by\":3,\"approval_status\":\"Approved\"}', '2026-10-18 11:18:37', '2026-10-18 11:18:37'),
(316, 'Purchase Receive Created', 'https://ndcv2.intellecsoftbd.com/inventory/purchase/purchaseorderreceive', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 4, NULL, '{\"invoice_no\":\"INV-0011\",\"date\":\"2026-10-18 00:00:00\",\"unit_id\":null,\"supplier_id\":21,\"purchase_order_id\":1,\"financial_year_id\":1,\"received_qty\":\"2\",\"created_by\":4,\"updated_by\":4,\"approval_status\":\"Pending\",\"id\":5}', '2026-10-18 11:23:05', '2026-10-18 11:23:05'),
(317, 'Stock Created', 'https://ndcv2.intellecsoftbd.com/inventory/purchase/purchaseorderreceive', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 4, NULL, '{\"unit_id\":null,\"item_id\":264,\"purchase_receive_id\":5,\"purchase_receive_item_id\":5,\"supplier_id\":21,\"status\":\"Pending\",\"coverage_type\":\"Warranty\",\"coverage_start\":\"2026-10-18 00:00:00\",\"duration\":\"2\",\"duration_type\":\"Years\",\"coverage_end\":\"2028-10-18 00:00:00\",\"coverage_terms\":null,\"serial_no\":\"1122\",\"quantity\":1,\"created_by\":4,\"updated_by\":4,\"id\":1}', '2026-10-18 11:23:05', '2026-10-18 11:23:05'),
(318, 'Stock Created', 'https://ndcv2.intellecsoftbd.com/inventory/purchase/purchaseorderreceive', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 4, NULL, '{\"unit_id\":null,\"item_id\":264,\"purchase_receive_id\":5,\"purchase_receive_item_id\":5,\"supplier_id\":21,\"status\":\"Pending\",\"coverage_type\":\"Warranty\",\"coverage_start\":\"2026-10-18 00:00:00\",\"duration\":\"2\",\"duration_type\":\"Years\",\"coverage_end\":\"2028-10-18 00:00:00\",\"coverage_terms\":null,\"serial_no\":\"1123\",\"quantity\":1,\"created_by\":4,\"updated_by\":4,\"id\":2}', '2026-10-18 11:23:05', '2026-10-18 11:23:05'),
(319, 'Purchase Receive Updated', 'https://ndcv2.intellecsoftbd.com/inventory/approvals/4/approve', 'POST', '103.152.107.160', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 3, '{\"updated_by\":4,\"approval_status\":\"Pending\"}', '{\"updated_by\":3,\"approval_status\":\"Approved\"}', '2026-10-18 11:23:11', '2026-10-18 11:23:11'),
(320, 'Logged In storman@gmail.com', 'https://ndcv2.intellecsoftbd.com/login', 'POST', '103.231.176.182', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 OPR/136.0.0.0', 4, NULL, NULL, '2026-10-18 12:48:59', '2026-10-18 12:48:59');

-- --------------------------------------------------------

--
-- Table structure for table `approval_requests`
--

CREATE TABLE `approval_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `approvable_type` varchar(255) NOT NULL,
  `approvable_id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(20) NOT NULL COMMENT 'material, purchase, stock, issue',
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `message` varchar(500) NOT NULL,
  `chips` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`chips`)),
  `status` varchar(10) NOT NULL DEFAULT 'Pending',
  `reason` text DEFAULT NULL,
  `requested_by` bigint(20) UNSIGNED DEFAULT NULL,
  `actioned_by` bigint(20) UNSIGNED DEFAULT NULL,
  `actioned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approval_requests`
--

INSERT INTO `approval_requests` (`id`, `approvable_type`, `approvable_id`, `category`, `unit_id`, `title`, `reference`, `message`, `chips`, `status`, `reason`, `requested_by`, `actioned_by`, `actioned_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Category', 4, 'material', NULL, 'New Category', 'Fan', 'Category Fan is pending QM approval.', '[\"Fan\",\"Electric\"]', 'Approved', NULL, 2, 3, '2026-10-18 10:58:19', '2026-10-18 10:57:32', '2026-10-18 10:58:19'),
(2, 'App\\Models\\Brand', 1, 'material', NULL, 'New Brand', 'Vision', 'Brand Vision is pending QM approval.', '[\"Vision\",\"Electric Item\"]', 'Approved', NULL, 4, 3, '2026-10-18 11:04:15', '2026-10-18 11:04:11', '2026-10-18 11:04:15'),
(3, 'App\\Models\\PurchaseOrder', 1, 'purchase', NULL, 'New Purchase Order', 'PO000001/2026-2027', 'Purchase order PO000001/2026-2027 is pending QM approval.', '[\"PO000001\\/2026-2027\",\"Khan Electronics\",\"6 pcs\"]', 'Approved', NULL, 4, 3, '2026-10-18 11:18:37', '2026-10-18 11:18:21', '2026-10-18 11:18:37'),
(4, 'App\\Models\\PurchaseReceive', 5, 'stock', NULL, 'New Stock Entry', 'INV-0011', 'Stock entry INV-0011 against PO000001/2026-2027 is pending QM approval.', '[\"INV-0011\",\"2 pcs\",\"Khan Electronics\"]', 'Approved', NULL, 4, 3, '2026-10-18 11:23:11', '2026-10-18 11:23:05', '2026-10-18 11:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approval_status` varchar(10) NOT NULL DEFAULT 'Approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `category_id`, `name`, `description`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `approval_status`) VALUES
(1, 3, 'Vision', NULL, 1, 4, 3, '2026-10-18 11:04:11', '2026-10-18 11:04:15', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `capacities`
--

CREATE TABLE `capacities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `product_model_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approval_status` varchar(10) NOT NULL DEFAULT 'Approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_category_id`, `name`, `description`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `approval_status`) VALUES
(1, 1, 'Sanitary', 'Sanitary item list', 1, NULL, NULL, '2026-10-17 17:42:22', '2026-10-17 17:42:22', 'Approved'),
(2, 2, 'Carpenter', 'Carpenter item list', 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(3, 3, 'Electric Item', 'Electric LED Light', 1, NULL, 2, '2026-10-17 17:42:23', '2026-10-18 11:00:29', 'Approved'),
(4, 3, 'Fan', 'Electric Fan', 1, 2, 3, '2026-10-18 10:57:32', '2026-10-18 10:58:19', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `priority` enum('N','M','H') NOT NULL DEFAULT 'N' COMMENT 'Normal / Medium / High',
  `message` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damages`
--

CREATE TABLE `damages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `reason` text NOT NULL,
  `actions` text NOT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('Pending','Approved','Declined') NOT NULL DEFAULT 'Pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deployments`
--

CREATE TABLE `deployments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `deploy_date` date NOT NULL,
  `personnel` varchar(150) NOT NULL,
  `comments` varchar(250) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_years`
--

CREATE TABLE `financial_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `financial_years`
--

INSERT INTO `financial_years` (`id`, `name`, `is_current`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '2026-2027', 1, 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(2, '2027-2028', 0, 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(3, '2028-2029', 0, 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `ip_audits`
--

CREATE TABLE `ip_audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(45) NOT NULL,
  `url` varchar(500) NOT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT 1,
  `reason` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ip_filters`
--

CREATE TABLE `ip_filters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `type` enum('blacklist','whitelist') NOT NULL DEFAULT 'blacklist',
  `reason` varchar(250) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issue_vouchers`
--

CREATE TABLE `issue_vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `iv_no` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `from_unit_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approval_status` varchar(10) NOT NULL DEFAULT 'Approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issue_voucher_items`
--

CREATE TABLE `issue_voucher_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `issue_voucher_id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` bigint(20) UNSIGNED NOT NULL,
  `to_unit_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `status` enum('Pending','Received','Returned') NOT NULL DEFAULT 'Pending',
  `actioned_by` bigint(20) UNSIGNED DEFAULT NULL,
  `actioned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_category_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `port_id` bigint(20) UNSIGNED DEFAULT NULL,
  `layer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `capacity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_unit_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `has_warranty` tinyint(1) NOT NULL DEFAULT 0,
  `is_consumable` tinyint(1) NOT NULL DEFAULT 0,
  `is_license` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approval_status` varchar(10) NOT NULL DEFAULT 'Approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `parent_category_id`, `category_id`, `brand_id`, `product_model_id`, `port_id`, `layer_id`, `capacity_id`, `item_unit_id`, `code`, `name`, `description`, `has_warranty`, `is_consumable`, `is_license`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `approval_status`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0001', 'Concealed Bib Cock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:22', '2026-10-17 17:42:22', 'Approved'),
(2, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0002', 'Plastic Bib Cock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:22', '2026-10-17 17:42:22', 'Approved'),
(3, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0003', 'Angel Stock Cock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(4, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0004', 'Council Stock Cock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(5, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0005', 'Twin Bib Cock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(6, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0006', 'Pilar Cock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(7, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0007', 'Basin Mixer Fixed', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(8, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0008', 'Bath Mixer', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(9, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0009', 'Sink Mixer', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(10, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0010', 'Basin Mixer', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(11, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0011', 'Push Shower', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(12, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0012', 'Hand Shower', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(13, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0013', 'Moving Shower', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(14, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0014', 'High Commode Seat Cover (Orient)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(15, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0015', 'High Commode Seat Cover (Carla)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(16, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0016', 'R A K Ball Cock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(17, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0017', 'Soap Ketch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(18, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0018', 'Basin Magic Pipe', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(19, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0019', 'Sink Magic Pipe', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(20, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0020', 'Sink Waste', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(21, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0021', 'Tissue Holder', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(22, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0022', 'Heat Proof Connection Pipe (Basin)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(23, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0023', 'Heat Proof Connection Pipe (For Geyser)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(24, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0024', 'Lead Pipe Connection Pipe White', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(25, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0025', 'Gate Bulb ¾ Inch, 1 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(26, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0026', 'Gas Stove', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(27, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0027', 'Double Injector', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(28, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0028', 'Single Injector', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(29, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0029', 'Thread Tap', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(30, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0030', 'Glass Self', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(31, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0031', '4 Inch Net Mesh for Bathroom', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(32, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0032', 'GI Bush', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(33, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0033', 'Adjustable Range Sewing Range', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(34, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0034', 'Pipe Range 14 Inches', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(35, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0035', 'Gas Stove Pipe', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(36, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0036', 'Sink Pillar Cock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(37, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0037', 'Glass Clip Packet', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(38, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0038', 'Gas Stove Pipe Clip', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(39, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0039', 'GI Plug', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(40, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0040', 'Bath Shower Pipe', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(41, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0041', 'Push Shower Head', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(42, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0042', 'Push Button', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(43, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0043', 'Basin Mixer Moving', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(44, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0044', 'RAK Ball Cock Fitting', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(45, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0045', 'Bath Shower Head', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(46, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0046', 'High Commode Seat Cover Nut', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(47, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0047', 'Kurian Putting', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(48, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0048', 'White Cement', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(49, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0049', '0.5 Inch Gate Bulb', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(50, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0050', '0.5/1.5 Inch Ball Bulb', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(51, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0051', '0.5 Inch GI Short Pitch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(52, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0052', 'Gas Stove Nozzle', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(53, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0053', 'Water Filter PP 20 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(54, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0054', 'Water Filter PP 10 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(55, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0055', 'Towel Stand (24 Inch SS)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(56, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0056', 'Ball Cock (Float Bulb) 2 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(57, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0057', 'Ball Cock (Float Bulb) 1.5 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(58, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0058', 'Ball Cock (Float Bulb) 1 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(59, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0059', 'Ball Cock (Float Sand) 0.5 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(60, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0060', 'Ball Cock (Float Bulb) 3/4 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(61, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0061', 'Net Filter (20 Inch)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(62, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0062', 'Net Filter (10 Inch)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(63, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0063', 'Box Filter (20 Inch)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(64, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0064', 'Box Filter (10 Inch)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(65, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0065', 'Gas Riser', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(66, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0066', 'Plastic Low Down', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(67, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0067', 'Thai Silicone Gum', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(68, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0068', 'Gas Stove Half-Quarter Key', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(69, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0069', 'Rack Towel Rail', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(70, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0070', 'Water Filter Bib Cock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(71, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0071', 'Kitchen Tissue Holder (SS)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(72, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0072', 'Plus Minus Gum', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(73, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0073', 'Ring Tape', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(74, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0074', '100 Gas Burners', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(75, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0075', '0.5 Inch Gas Cock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(76, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0076', '0.5 Inch Non-Nikon Bulb', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(77, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0077', '0.5 Inch Union GI', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(78, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0078', '0.5 Inch Elbow GI', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(79, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0079', '0.5 Inch Nipple GI', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(80, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0080', 'Bath Mixer Off Side', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(81, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0081', 'Geyser Pressure Bulb', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(82, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0082', 'Star Ainge Set', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(83, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0083', 'Water Filter Pressure Bulb', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(84, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0084', 'Water Filter Inlet Bulb', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(85, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0085', 'CPVC Pipe', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(86, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0086', 'CPVC Pipe (Female Type Socket)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(87, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0087', 'CPVC Pipe (Male Type Socket)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(88, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0088', 'CPVC Pipe (Plain Elbow)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(89, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0089', 'CPVC Pipe Gum', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(90, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0090', 'CPVC Pipe (Female Tee)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(91, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0091', 'CPVC Pipe (Plain Tee)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(92, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0092', 'CPVC Pipe (Female Elbow)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(93, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0093', 'CPVC Union', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(94, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0094', 'RD Water Connector', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(95, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0095', '50 mm Lock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(96, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0096', 'Water Filter Pipe (5 mm)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(97, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0097', 'Water Filter Pipe (10 mm)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(98, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0098', 'Plumber Tools Bag', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(99, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0099', 'Electric Carrying Bag', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(100, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0100', 'Sink Cock Div', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(101, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0101', '18 Inch Manhole Cover', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(102, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0102', '2 Inch UPVC Pipe', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(103, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0103', '2 Inch Elbow', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(104, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0104', '2 Inch Pipe Tee', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(105, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0105', '2 Inch Clam (GI)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(106, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0106', 'Ring Caster', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(107, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0107', 'CPVC Plain Socket', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(108, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0108', 'Login Cock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(109, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 'SAN-0109', '0.5 Inch GI Clam', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(110, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0001', 'Steel Cornice', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(111, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0002', 'Steel Tape', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(112, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0003', 'Geyser 45 Ltr', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(113, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0004', 'HazBolt', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(114, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0005', 'Rim Lock/Door Lock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(115, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0006', 'Handle Lock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(116, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0007', 'Lever Lock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(117, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0008', 'Splash', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(118, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0009', 'Screen Clam', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(119, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0010', 'Counsel Kopje', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(120, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0011', 'Chain Link', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(121, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0012', 'Drawer Lock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(122, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0013', 'Door Magnet', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(123, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0014', 'Wardrobe Channel (15 Inch)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(124, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0015', 'Door Handle', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(125, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0016', 'Drawer Handle Golden', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(126, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0017', 'Thai Window Wheel', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(127, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0018', 'Thai Lock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(128, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0019', 'Thai Window Mosquito Net (Fiber) 7 Feet', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(129, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0020', 'Thai Rubber 2 Part Half Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(130, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0021', 'Thai Rubber Round 2 Yarn', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(131, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0022', 'Plastic Door Casing (3 Inch)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(132, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0023', 'Melamine Board (Bois Color)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(133, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0024', 'Melamine Board (Grey Color)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(134, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0025', 'Roar Fly Board (15 ml)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(135, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0026', 'Roar Fly Board (18 ml)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(136, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0027', 'Aging 3x4 Base Color', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(137, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0028', 'Aging 3x8 Grey Color', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(138, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0029', 'Aging 3x4 Wall Night Color', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(139, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0030', 'Solution Gum', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(140, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0031', 'L Culm 1 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(141, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0032', 'Drawer Lock Clam 1 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(142, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0033', 'Auto Polish', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(143, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0034', 'Wood Series Paper', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(144, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0035', 'MS Washer (2 Yarns) Thin', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(145, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0036', 'MS Washer (3 Yarns) Thin', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(146, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0037', 'Wardrobe Concealed Closet (State/Half/Full)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(147, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0038', 'Glass Push Magnet (Black)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(148, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0039', 'Glass Magnet', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(149, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0040', 'Push Lock', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(150, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0041', 'Super Glue Gum', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(151, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0042', 'Tip Pudding', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(152, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0043', 'Wood Screw 0.5 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(153, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0044', 'Wood Screw 1.4/1 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(154, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0045', 'Guna Wire (Thin)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(155, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0046', 'GI Wire', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(156, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0047', 'Net Thai Window Wheel', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(157, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0048', 'Glass Cutting Pen', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(158, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0049', 'Wood Screw 3/4 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(159, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0050', 'Drawer Handle Screw 1.4/1 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(160, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0051', 'Drawer Handle Screw 1 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(161, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0052', 'Pipe Handle', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(162, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0053', 'Star Burning Screw (1 Inch)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(163, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0054', 'Star Burning Screw (1.5 Inch)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(164, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0055', 'Doba Handle', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(165, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0056', 'Drawer Knobs', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(166, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0057', 'Mosquito Netting Hook', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(167, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0058', 'Steel Wire Cut (0.5 Inch)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(168, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0059', 'Steel Wire Cut (1 Inch)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(169, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0060', 'Steel Wire Cut (2 Inch)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(170, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0061', 'Pin Super (3/4) White', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(171, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0062', 'Wool Screw 3 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(172, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0063', 'Plastic Door Handle', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(173, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0064', '4 Wooden Door Hinge', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(174, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0065', 'Hand Saw', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(175, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0066', 'Conceal Height 2 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(176, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0067', 'Batal', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(177, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0068', 'Kechi', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(178, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0069', 'Screw 0.5 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(179, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0070', 'Screw 1 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(180, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0071', 'Screw 1.5 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(181, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0072', 'Screw 2 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(182, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0073', 'Screw 2.5 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(183, 2, 2, NULL, NULL, NULL, NULL, NULL, 1, 'CAR-0074', 'Screw 3 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(184, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0001', 'LED Light 15 Watt', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(185, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0002', 'LED Tube Light 4 Fit 20 Watt', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(186, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0003', 'LED Tube Light 2 Fit 10 Watt', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(187, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0004', 'Slim Botton LED Tube Light 4 Fit 40 Watt', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(188, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0005', 'Slim Botton LED Tube Light 2 Fit 20 Watt', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(189, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0006', 'T-5 Tube Light 4 Feet 20 Watt (White)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(190, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0007', 'T-5 Tube Light 4 Feet 20 Watt (Oram)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(191, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0008', 'Jhar Batir Light Small /60 Watt', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(192, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0009', 'LED Light 07 Watt', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(193, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0010', 'LED Panel Light 6 Watt', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(194, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0011', 'LED Panel Light 8 Watt', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(195, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0012', 'LED Panel Light 40 Watt (Slim Type Square)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(196, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0013', 'LED Light 40 Watt (Box Type Square)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(197, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0014', 'LED Panel Light 40 Watt (Box Type Square)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(198, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0015', 'LED Panel Light 40 Watt (Slim Type Square)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(199, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0016', 'LED Panel Light 1×1 Fit 24 Watt', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(200, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0017', 'LED Panel Light 8×8 Fit 18 Watt (Box Type Square)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(201, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0018', 'LED Panel Light 8×8 Fit 18 Watt (Slim Type Square)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(202, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0019', 'LED Panel Light 8×8 Fit 12 Watt (Slim Type Square)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(203, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0020', 'LED Panel Light 8×8 Fit 12 Watt (Box Type Square)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(204, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0021', 'Search Light 100 Watt', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(205, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0022', 'Search Light 200 Watt', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(206, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0023', 'Ceiling Fan 56 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(207, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0024', 'Exhaust Fan 06 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(208, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0025', 'Exhaust Fan 08 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(209, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0026', 'Exhaust Fan 10 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(210, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0027', 'Exhaust Fan 12 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(211, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0028', 'Holder', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(212, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0029', 'MK Regulator', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(213, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0030', 'Normal Regulator', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(214, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0031', 'Capacitor', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(215, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0032', '2 Pin Socket', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(216, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0033', '3 Pin Socket', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(217, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0034', '6 Pin Socket', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(218, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0035', '3 Pin Plug', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(219, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0036', 'MK Box', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(220, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0037', 'Piano Switch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(221, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0038', '1 Gang Switch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(222, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0039', '2 Gang Switch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(223, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0040', '3 Gang Switch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(224, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0041', '4 Gang Switch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(225, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0042', 'DB Switch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(226, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0043', '1.5 RM Cable', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(227, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0044', 'Electric Channel', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(228, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0045', '10 AMP Circuit Breaker', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(229, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0046', '16 AMP Circuit Breaker', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(230, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0047', '20 AMP Circuit Breaker', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(231, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0048', '32 AMP Circuit Breaker', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(232, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0049', '40 AMP Circuit Breaker', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(233, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0050', '63 AMP Circuit Breaker', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(234, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0051', 'Screw Driver', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(235, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0052', 'Royal Plug', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(236, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0053', 'Plus', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(237, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0054', 'Taster', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(238, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0055', 'Drill Machine', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(239, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0056', 'Calling Bell Battery', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(240, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0057', 'Calling Bell Electric', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(241, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0058', 'Piano 2 Pin Socket', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(242, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0059', '2 Pin Plug', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(243, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0060', 'Wall Holder', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(244, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0061', 'Multi Plug', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(245, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0062', 'Spot Light White', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(246, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0063', 'Pasha Spot Light', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(247, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0064', 'Calling Bell Switch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(248, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0065', 'Cable Clip', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(249, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0066', 'Focus LED Light', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(250, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0067', 'Hammer', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(251, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0068', 'Nos Plus', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(252, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0069', 'Cutting Plus', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(253, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0070', 'Piano Calling Bell Switch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:24', '2026-10-17 17:42:24', 'Approved'),
(254, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0071', 'Ceiling Fan 36 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:24', '2026-10-17 17:42:24', 'Approved'),
(255, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0072', 'Remote Battery', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:24', '2026-10-17 17:42:24', 'Approved'),
(256, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0073', 'Chamatir Small / Slim Patch Holder', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:24', '2026-10-17 17:42:24', 'Approved'),
(257, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0074', 'Jharbati Holder (Golden Colour)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:24', '2026-10-17 17:42:24', 'Approved'),
(258, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0075', 'Spot Light Oram', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:24', '2026-10-17 17:42:24', 'Approved'),
(259, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0076', 'LED Panel Light 1 Fit / 4 Fit (Box Type)', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:24', '2026-10-17 17:42:24', 'Approved'),
(260, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0077', 'T-5 Light 2 Fit 10 Watt Oram', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:24', '2026-10-17 17:42:24', 'Approved'),
(261, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0078', 'One Phase Circuit Breaker Box', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:24', '2026-10-17 17:42:24', 'Approved'),
(262, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0079', 'LED Panel Light 4 Fit / 6 Inch', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:24', '2026-10-17 17:42:24', 'Approved'),
(263, 3, 3, NULL, NULL, NULL, NULL, NULL, 1, 'ELE-0080', 'Panel Light 6 Inch Round', NULL, 0, 1, 0, 1, NULL, NULL, '2026-10-17 17:42:24', '2026-10-17 17:42:24', 'Approved'),
(264, 3, 3, 1, NULL, NULL, NULL, NULL, 1, 'ELE-0081', 'LED Light 15 Watt (Oram Colour)', NULL, 1, 0, 0, 1, NULL, 2, '2026-10-17 17:42:24', '2026-10-18 11:07:03', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `item_units`
--

CREATE TABLE `item_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_units`
--

INSERT INTO `item_units` (`id`, `code`, `name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'PCS', 'Pieces', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(2, 'SET', 'Set', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(3, 'BOX', 'Box', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(4, 'PKT', 'Packet', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(5, 'DOZ', 'Dozen', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(6, 'KG', 'Kilogram', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(7, 'GM', 'Gram', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(8, 'LTR', 'Liter', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(9, 'MTR', 'Meter', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(10, 'FT', 'Feet', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(11, 'UNT', 'Unit', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(12, 'PAIR', 'Pair', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(13, 'REAM', 'Ream', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(14, 'ROLL', 'Roll', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(15, 'CTN', 'Carton', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(16, 'BDL', 'Bundle', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(17, 'BTL', 'Bottle', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(18, 'CAN', 'Can', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(19, 'CASE', 'Case', 0, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(20, 'SQFT', 'Square Feet', 1, NULL, NULL, '2026-10-14 17:59:47', '2026-10-14 17:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `layers`
--

CREATE TABLE `layers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `product_model_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE `licenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deployment_id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` bigint(20) UNSIGNED NOT NULL,
  `product_key` varchar(100) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `licensed_to_name` varchar(100) NOT NULL,
  `licensed_to_email` varchar(100) NOT NULL,
  `re_assignable` tinyint(1) NOT NULL DEFAULT 0,
  `purchase_date` date NOT NULL,
  `expiration_date` date NOT NULL,
  `note` varchar(250) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_00_000001_create_roles_table', 1),
(2, '0001_01_00_000002_create_units_table', 1),
(3, '0001_01_00_000003_create_ranks_table', 1),
(4, '0001_01_01_000000_create_users_table', 1),
(5, '0001_01_01_000001_create_cache_table', 1),
(6, '0001_01_01_000002_create_jobs_table', 1),
(7, '0001_01_01_000003_create_quick_links_table', 1),
(8, '0001_01_01_000004_create_role_permissions_table', 1),
(9, '2026_10_13_000001_create_admin_tables', 1),
(10, '2026_10_13_000002_create_configuration_tables', 1),
(11, '2026_10_13_000003_create_purchase_and_stock_tables', 1),
(12, '2026_10_13_095534_create_notifications_table', 1),
(13, '2026_10_14_000001_create_approval_requests_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('08ae3ef3-8cb5-4ad7-8969-51c9c5cf58a4', 'App\\Notifications\\ApprovalNotification', 'App\\Models\\User', 4, '{\"subject\":\"Stock Entry Approved\",\"message\":\"INV-0011 was approved by Quarter Master.\",\"type\":\"Approval Decision\",\"sender_id\":3,\"sender\":\"Quarter Master\",\"approval_id\":4,\"category\":\"stock\",\"url\":\"https:\\/\\/ndcv2.intellecsoftbd.com\\/inventory\\/purchase\\/purchaseorderreceive\\/5\"}', NULL, '2026-10-18 11:23:11', '2026-10-18 11:23:11'),
('0c200453-9e29-416f-a581-48f57163d32b', 'App\\Notifications\\ApprovalNotification', 'App\\Models\\User', 3, '{\"subject\":\"New Purchase Order\",\"message\":\"Purchase order PO000001\\/2026-2027 is pending QM approval.\",\"type\":\"Approval\",\"sender_id\":4,\"sender\":\"Storeman\",\"approval_id\":3,\"category\":\"purchase\",\"url\":\"https:\\/\\/ndcv2.intellecsoftbd.com\\/inventory\\/approvals\\/3\"}', '2026-10-18 11:18:37', '2026-10-18 11:18:21', '2026-10-18 11:18:21'),
('40b398f9-ca83-4382-bc2c-ccdc7bbc7539', 'App\\Notifications\\ApprovalNotification', 'App\\Models\\User', 3, '{\"subject\":\"New Brand\",\"message\":\"Brand Vision is pending QM approval.\",\"type\":\"Approval\",\"sender_id\":4,\"sender\":\"Storeman\",\"approval_id\":2,\"category\":\"material\",\"url\":\"https:\\/\\/ndcv2.intellecsoftbd.com\\/inventory\\/approvals\\/2\"}', '2026-10-18 11:04:16', '2026-10-18 11:04:11', '2026-10-18 11:04:11'),
('4b099b82-e0ad-4441-95b3-d3a86813673a', 'App\\Notifications\\ApprovalNotification', 'App\\Models\\User', 2, '{\"subject\":\"Category Approved\",\"message\":\"Fan was approved by Quarter Master.\",\"type\":\"Approval Decision\",\"sender_id\":3,\"sender\":\"Quarter Master\",\"approval_id\":1,\"category\":\"material\",\"url\":\"https:\\/\\/ndcv2.intellecsoftbd.com\\/inventory\\/configuration\\/categories\\/4\"}', NULL, '2026-10-18 10:58:19', '2026-10-18 10:58:19'),
('4b89115f-008b-4334-951a-a4872f3062c9', 'App\\Notifications\\ApprovalNotification', 'App\\Models\\User', 4, '{\"subject\":\"Brand Approved\",\"message\":\"Vision was approved by Quarter Master.\",\"type\":\"Approval Decision\",\"sender_id\":3,\"sender\":\"Quarter Master\",\"approval_id\":2,\"category\":\"material\",\"url\":\"https:\\/\\/ndcv2.intellecsoftbd.com\\/inventory\\/configuration\\/brands\\/1\"}', NULL, '2026-10-18 11:04:16', '2026-10-18 11:04:16'),
('531a6549-24af-47ed-9c50-d592fd5c955f', 'App\\Notifications\\ApprovalNotification', 'App\\Models\\User', 3, '{\"subject\":\"New Category\",\"message\":\"Category Fan is pending QM approval.\",\"type\":\"Approval\",\"sender_id\":2,\"sender\":\"administrator\",\"approval_id\":1,\"category\":\"material\",\"url\":\"https:\\/\\/ndcv2.intellecsoftbd.com\\/inventory\\/approvals\\/1\"}', '2026-10-18 10:58:19', '2026-10-18 10:57:32', '2026-10-18 10:57:32'),
('5fd587c1-3d2b-47b1-a48c-d86cde6f7cba', 'App\\Notifications\\ApprovalNotification', 'App\\Models\\User', 3, '{\"subject\":\"New Stock Entry\",\"message\":\"Stock entry INV-0011 against PO000001\\/2026-2027 is pending QM approval.\",\"type\":\"Approval\",\"sender_id\":4,\"sender\":\"Storeman\",\"approval_id\":4,\"category\":\"stock\",\"url\":\"https:\\/\\/ndcv2.intellecsoftbd.com\\/inventory\\/approvals\\/4\"}', '2026-10-18 11:23:11', '2026-10-18 11:23:05', '2026-10-18 11:23:05'),
('60122e25-1483-4f24-97c4-932b920c2f48', 'App\\Notifications\\ApprovalNotification', 'App\\Models\\User', 4, '{\"subject\":\"Purchase Order Approved\",\"message\":\"PO000001\\/2026-2027 was approved by Quarter Master.\",\"type\":\"Approval Decision\",\"sender_id\":3,\"sender\":\"Quarter Master\",\"approval_id\":3,\"category\":\"purchase\",\"url\":\"https:\\/\\/ndcv2.intellecsoftbd.com\\/inventory\\/purchase\\/purchaseorders\\/1\"}', NULL, '2026-10-18 11:18:37', '2026-10-18 11:18:37');

-- --------------------------------------------------------

--
-- Table structure for table `parent_categories`
--

CREATE TABLE `parent_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approval_status` varchar(10) NOT NULL DEFAULT 'Approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parent_categories`
--

INSERT INTO `parent_categories` (`id`, `name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `approval_status`) VALUES
(1, 'Sanitary', 1, NULL, NULL, '2026-10-17 17:42:22', '2026-10-17 17:42:22', 'Approved'),
(2, 'Carpenter', 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved'),
(3, 'Electric', 1, NULL, NULL, '2026-10-17 17:42:23', '2026-10-17 17:42:23', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ports`
--

CREATE TABLE `ports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `product_model_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_models`
--

CREATE TABLE `product_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approval_status` varchar(10) NOT NULL DEFAULT 'Approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `po_no` varchar(40) NOT NULL,
  `date` date NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `financial_year_id` bigint(20) UNSIGNED NOT NULL,
  `reference_no` varchar(250) NOT NULL,
  `priority` tinyint(3) UNSIGNED NOT NULL DEFAULT 3 COMMENT '1 Highest, 2 Medium, 3 Normal',
  `attachment` varchar(255) DEFAULT NULL,
  `comments` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approval_status` varchar(10) NOT NULL DEFAULT 'Approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `po_no`, `date`, `unit_id`, `supplier_id`, `financial_year_id`, `reference_no`, `priority`, `attachment`, `comments`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `approval_status`) VALUES
(1, 'PO000001/2026-2027', '2026-10-18', NULL, 21, 1, '123456', 3, NULL, NULL, 1, 4, 3, '2026-10-18 11:18:21', '2026-10-18 11:18:37', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_items`
--

CREATE TABLE `purchase_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `order_qty` int(10) UNSIGNED NOT NULL,
  `received_qty` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_items`
--

INSERT INTO `purchase_order_items` (`id`, `purchase_order_id`, `item_id`, `order_qty`, `received_qty`, `created_at`, `updated_at`) VALUES
(1, 1, 264, 6, 2, '2026-10-18 11:18:21', '2026-10-18 11:23:05');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_receives`
--

CREATE TABLE `purchase_receives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `financial_year_id` bigint(20) UNSIGNED NOT NULL,
  `received_qty` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approval_status` varchar(10) NOT NULL DEFAULT 'Approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_receives`
--

INSERT INTO `purchase_receives` (`id`, `invoice_no`, `date`, `unit_id`, `supplier_id`, `purchase_order_id`, `financial_year_id`, `received_qty`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `approval_status`) VALUES
(5, 'INV-0011', '2026-10-18', NULL, 21, 1, 1, 2, 1, 4, 3, '2026-10-18 11:23:05', '2026-10-18 11:23:11', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_receive_items`
--

CREATE TABLE `purchase_receive_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_receive_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_item_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_receive_items`
--

INSERT INTO `purchase_receive_items` (`id`, `purchase_receive_id`, `purchase_order_item_id`, `item_id`, `quantity`, `created_at`, `updated_at`) VALUES
(5, 5, 1, 264, 2, '2026-10-18 11:23:05', '2026-10-18 11:23:05');

-- --------------------------------------------------------

--
-- Table structure for table `quick_links`
--

CREATE TABLE `quick_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `link` varchar(250) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE `ranks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `short` varchar(30) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` (`id`, `short`, `name`, `order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Lt Col', 'Lieutenant Colonel', 6, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(2, 'Brig. Gen', 'Brigadier Genera', 4, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(3, 'Maj Gen', 'Major General', 3, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(4, 'Col', 'Colonel', 5, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(5, 'Maj', 'Major', 7, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(6, 'Cpl', 'Corporal', 17, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(7, 'Snk', 'Sainik', 19, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(8, 'Lcpl', 'Lance Corporal', 18, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(9, 'Sgt', 'Sergeant', 16, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(10, 'SWO', 'Senior Warrant Officer', 14, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(11, 'CIVIL', 'CIVIL', 10, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(12, 'Captain', 'Captain', 8, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(13, 'Gen', 'General', 1, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(14, 'Lt Gen', 'Lieutenant General', 2, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(15, 'Lt', 'Lieutenant', 9, 1, '2026-10-14 17:59:47', '2026-10-14 17:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin', '2026-10-14 17:59:45', '2026-10-14 17:59:45'),
(2, 'Admin', 'admin', '2026-10-14 17:59:46', '2026-10-14 17:59:46'),
(3, 'Quarter Master', 'qm', '2026-10-14 17:59:47', '2026-10-14 17:59:47'),
(4, 'Storeman', 'storeman', '2026-10-14 17:59:47', '2026-10-14 17:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(150) NOT NULL,
  `ability` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `path`, `ability`) VALUES
(292, 2, 'admin/ipauditing', 'create'),
(294, 2, 'admin/ipauditing', 'delete'),
(293, 2, 'admin/ipauditing', 'edit'),
(291, 2, 'admin/ipauditing', 'view'),
(288, 2, 'admin/ipfiltering', 'create'),
(290, 2, 'admin/ipfiltering', 'delete'),
(289, 2, 'admin/ipfiltering', 'edit'),
(287, 2, 'admin/ipfiltering', 'view'),
(303, 2, 'admin/logs', 'view'),
(305, 2, 'admin/messaging/chats', 'create'),
(307, 2, 'admin/messaging/chats', 'delete'),
(306, 2, 'admin/messaging/chats', 'edit'),
(304, 2, 'admin/messaging/chats', 'view'),
(313, 2, 'admin/messaging/notifications', 'create'),
(315, 2, 'admin/messaging/notifications', 'delete'),
(314, 2, 'admin/messaging/notifications', 'edit'),
(312, 2, 'admin/messaging/notifications', 'view'),
(309, 2, 'admin/messaging/tickets', 'create'),
(311, 2, 'admin/messaging/tickets', 'delete'),
(310, 2, 'admin/messaging/tickets', 'edit'),
(308, 2, 'admin/messaging/tickets', 'view'),
(296, 2, 'admin/roles', 'create'),
(298, 2, 'admin/roles', 'delete'),
(297, 2, 'admin/roles', 'edit'),
(295, 2, 'admin/roles', 'view'),
(300, 2, 'admin/users', 'create'),
(302, 2, 'admin/users', 'delete'),
(301, 2, 'admin/users', 'edit'),
(299, 2, 'admin/users', 'view'),
(223, 2, 'inventory/configuration/brands', 'create'),
(225, 2, 'inventory/configuration/brands', 'delete'),
(224, 2, 'inventory/configuration/brands', 'edit'),
(222, 2, 'inventory/configuration/brands', 'view'),
(219, 2, 'inventory/configuration/categories', 'create'),
(221, 2, 'inventory/configuration/categories', 'delete'),
(220, 2, 'inventory/configuration/categories', 'edit'),
(218, 2, 'inventory/configuration/categories', 'view'),
(235, 2, 'inventory/configuration/financialyears', 'create'),
(237, 2, 'inventory/configuration/financialyears', 'delete'),
(236, 2, 'inventory/configuration/financialyears', 'edit'),
(234, 2, 'inventory/configuration/financialyears', 'view'),
(239, 2, 'inventory/configuration/items', 'create'),
(241, 2, 'inventory/configuration/items', 'delete'),
(240, 2, 'inventory/configuration/items', 'edit'),
(238, 2, 'inventory/configuration/items', 'view'),
(231, 2, 'inventory/configuration/itemunits', 'create'),
(233, 2, 'inventory/configuration/itemunits', 'delete'),
(232, 2, 'inventory/configuration/itemunits', 'edit'),
(230, 2, 'inventory/configuration/itemunits', 'view'),
(227, 2, 'inventory/configuration/models', 'create'),
(229, 2, 'inventory/configuration/models', 'delete'),
(228, 2, 'inventory/configuration/models', 'edit'),
(226, 2, 'inventory/configuration/models', 'view'),
(215, 2, 'inventory/configuration/parentcategories', 'create'),
(217, 2, 'inventory/configuration/parentcategories', 'delete'),
(216, 2, 'inventory/configuration/parentcategories', 'edit'),
(214, 2, 'inventory/configuration/parentcategories', 'view'),
(207, 2, 'inventory/configuration/ranks', 'create'),
(209, 2, 'inventory/configuration/ranks', 'delete'),
(208, 2, 'inventory/configuration/ranks', 'edit'),
(206, 2, 'inventory/configuration/ranks', 'view'),
(211, 2, 'inventory/configuration/suppliers', 'create'),
(213, 2, 'inventory/configuration/suppliers', 'delete'),
(212, 2, 'inventory/configuration/suppliers', 'edit'),
(210, 2, 'inventory/configuration/suppliers', 'view'),
(203, 2, 'inventory/configuration/units', 'create'),
(205, 2, 'inventory/configuration/units', 'delete'),
(204, 2, 'inventory/configuration/units', 'edit'),
(202, 2, 'inventory/configuration/units', 'view'),
(247, 2, 'inventory/purchase/purchaseorderreceive', 'create'),
(249, 2, 'inventory/purchase/purchaseorderreceive', 'delete'),
(248, 2, 'inventory/purchase/purchaseorderreceive', 'edit'),
(246, 2, 'inventory/purchase/purchaseorderreceive', 'view'),
(243, 2, 'inventory/purchase/purchaseorders', 'create'),
(245, 2, 'inventory/purchase/purchaseorders', 'delete'),
(244, 2, 'inventory/purchase/purchaseorders', 'edit'),
(242, 2, 'inventory/purchase/purchaseorders', 'view'),
(281, 2, 'inventory/reports/damagereport', 'view'),
(280, 2, 'inventory/reports/issuereport', 'view'),
(278, 2, 'inventory/reports/itemsearch', 'view'),
(284, 2, 'inventory/reports/licensesinformation', 'view'),
(279, 2, 'inventory/reports/purchasereport', 'view'),
(282, 2, 'inventory/reports/stockbalancereport', 'view'),
(285, 2, 'inventory/reports/stockchecking', 'view'),
(286, 2, 'inventory/reports/stocksummary', 'view'),
(283, 2, 'inventory/reports/warrantyinformation', 'view'),
(275, 2, 'inventory/transaction/barcodes', 'create'),
(277, 2, 'inventory/transaction/barcodes', 'delete'),
(276, 2, 'inventory/transaction/barcodes', 'edit'),
(274, 2, 'inventory/transaction/barcodes', 'view'),
(259, 2, 'inventory/transaction/damages', 'create'),
(261, 2, 'inventory/transaction/damages', 'delete'),
(260, 2, 'inventory/transaction/damages', 'edit'),
(258, 2, 'inventory/transaction/damages', 'view'),
(263, 2, 'inventory/transaction/issuevouchers', 'create'),
(265, 2, 'inventory/transaction/issuevouchers', 'delete'),
(264, 2, 'inventory/transaction/issuevouchers', 'edit'),
(262, 2, 'inventory/transaction/issuevouchers', 'view'),
(271, 2, 'inventory/transaction/licenses', 'create'),
(273, 2, 'inventory/transaction/licenses', 'delete'),
(272, 2, 'inventory/transaction/licenses', 'edit'),
(270, 2, 'inventory/transaction/licenses', 'view'),
(251, 2, 'inventory/transaction/stockposition', 'create'),
(253, 2, 'inventory/transaction/stockposition', 'delete'),
(252, 2, 'inventory/transaction/stockposition', 'edit'),
(250, 2, 'inventory/transaction/stockposition', 'view'),
(255, 2, 'inventory/transaction/stockreceive', 'create'),
(257, 2, 'inventory/transaction/stockreceive', 'delete'),
(256, 2, 'inventory/transaction/stockreceive', 'edit'),
(254, 2, 'inventory/transaction/stockreceive', 'view'),
(267, 2, 'inventory/transaction/warrantyandservice', 'create'),
(269, 2, 'inventory/transaction/warrantyandservice', 'delete'),
(268, 2, 'inventory/transaction/warrantyandservice', 'edit'),
(266, 2, 'inventory/transaction/warrantyandservice', 'view'),
(152, 3, 'inventory/approvals', 'edit'),
(151, 3, 'inventory/approvals', 'view'),
(130, 3, 'inventory/configuration/brands', 'view'),
(129, 3, 'inventory/configuration/categories', 'view'),
(133, 3, 'inventory/configuration/financialyears', 'view'),
(134, 3, 'inventory/configuration/items', 'view'),
(132, 3, 'inventory/configuration/itemunits', 'view'),
(131, 3, 'inventory/configuration/models', 'view'),
(128, 3, 'inventory/configuration/parentcategories', 'view'),
(126, 3, 'inventory/configuration/ranks', 'view'),
(127, 3, 'inventory/configuration/suppliers', 'view'),
(125, 3, 'inventory/configuration/units', 'view'),
(122, 3, 'inventory/purchase/purchaseorderreceive', 'create'),
(124, 3, 'inventory/purchase/purchaseorderreceive', 'delete'),
(123, 3, 'inventory/purchase/purchaseorderreceive', 'edit'),
(121, 3, 'inventory/purchase/purchaseorderreceive', 'view'),
(118, 3, 'inventory/purchase/purchaseorders', 'create'),
(120, 3, 'inventory/purchase/purchaseorders', 'delete'),
(119, 3, 'inventory/purchase/purchaseorders', 'edit'),
(117, 3, 'inventory/purchase/purchaseorders', 'view'),
(145, 3, 'inventory/reports/damagereport', 'view'),
(144, 3, 'inventory/reports/issuereport', 'view'),
(142, 3, 'inventory/reports/itemsearch', 'view'),
(148, 3, 'inventory/reports/licensesinformation', 'view'),
(143, 3, 'inventory/reports/purchasereport', 'view'),
(146, 3, 'inventory/reports/stockbalancereport', 'view'),
(149, 3, 'inventory/reports/stockchecking', 'view'),
(150, 3, 'inventory/reports/stocksummary', 'view'),
(147, 3, 'inventory/reports/warrantyinformation', 'view'),
(141, 3, 'inventory/transaction/barcodes', 'view'),
(137, 3, 'inventory/transaction/damages', 'view'),
(138, 3, 'inventory/transaction/issuevouchers', 'view'),
(140, 3, 'inventory/transaction/licenses', 'view'),
(135, 3, 'inventory/transaction/stockposition', 'view'),
(136, 3, 'inventory/transaction/stockreceive', 'view'),
(139, 3, 'inventory/transaction/warrantyandservice', 'view'),
(165, 4, 'inventory/configuration/brands', 'create'),
(158, 4, 'inventory/configuration/brands', 'view'),
(164, 4, 'inventory/configuration/categories', 'create'),
(157, 4, 'inventory/configuration/categories', 'view'),
(161, 4, 'inventory/configuration/financialyears', 'view'),
(167, 4, 'inventory/configuration/items', 'create'),
(162, 4, 'inventory/configuration/items', 'view'),
(160, 4, 'inventory/configuration/itemunits', 'view'),
(166, 4, 'inventory/configuration/models', 'create'),
(159, 4, 'inventory/configuration/models', 'view'),
(163, 4, 'inventory/configuration/parentcategories', 'create'),
(156, 4, 'inventory/configuration/parentcategories', 'view'),
(154, 4, 'inventory/configuration/ranks', 'view'),
(155, 4, 'inventory/configuration/suppliers', 'view'),
(153, 4, 'inventory/configuration/units', 'view'),
(171, 4, 'inventory/purchase/purchaseorderreceive', 'create'),
(170, 4, 'inventory/purchase/purchaseorderreceive', 'view'),
(169, 4, 'inventory/purchase/purchaseorders', 'create'),
(168, 4, 'inventory/purchase/purchaseorders', 'view'),
(196, 4, 'inventory/reports/damagereport', 'view'),
(195, 4, 'inventory/reports/issuereport', 'view'),
(193, 4, 'inventory/reports/itemsearch', 'view'),
(199, 4, 'inventory/reports/licensesinformation', 'view'),
(194, 4, 'inventory/reports/purchasereport', 'view'),
(197, 4, 'inventory/reports/stockbalancereport', 'view'),
(200, 4, 'inventory/reports/stockchecking', 'view'),
(201, 4, 'inventory/reports/stocksummary', 'view'),
(198, 4, 'inventory/reports/warrantyinformation', 'view'),
(191, 4, 'inventory/transaction/barcodes', 'create'),
(192, 4, 'inventory/transaction/barcodes', 'edit'),
(190, 4, 'inventory/transaction/barcodes', 'view'),
(179, 4, 'inventory/transaction/damages', 'create'),
(180, 4, 'inventory/transaction/damages', 'edit'),
(178, 4, 'inventory/transaction/damages', 'view'),
(182, 4, 'inventory/transaction/issuevouchers', 'create'),
(183, 4, 'inventory/transaction/issuevouchers', 'edit'),
(181, 4, 'inventory/transaction/issuevouchers', 'view'),
(188, 4, 'inventory/transaction/licenses', 'create'),
(189, 4, 'inventory/transaction/licenses', 'edit'),
(187, 4, 'inventory/transaction/licenses', 'view'),
(173, 4, 'inventory/transaction/stockposition', 'create'),
(174, 4, 'inventory/transaction/stockposition', 'edit'),
(172, 4, 'inventory/transaction/stockposition', 'view'),
(176, 4, 'inventory/transaction/stockreceive', 'create'),
(177, 4, 'inventory/transaction/stockreceive', 'edit'),
(175, 4, 'inventory/transaction/stockreceive', 'view'),
(185, 4, 'inventory/transaction/warrantyandservice', 'create'),
(186, 4, 'inventory/transaction/warrantyandservice', 'edit'),
(184, 4, 'inventory/transaction/warrantyandservice', 'view');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('FO80UvoBDtr0tRWrkCpc1eQpdU5ZBwzqu0D2raIW', NULL, '103.231.176.182', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36 OPR/136.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib0FCU1pObzdUNnFHWENTaUp3QUx1N3YydzRqZ2dvVVpyOTlTaWdlNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cHM6Ly9uZGN2Mi5pbnRlbGxlY3NvZnRiZC5jb20vaW52ZW50b3J5Ijt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vbmRjdjIuaW50ZWxsZWNzb2Z0YmQuY29tL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9fQ==', 1792307949),
('nNZmawGuo5wK7ePWSOslw5E8HIijHVobamud67B8', NULL, '103.231.176.182', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNmUwMzIxUWRVNDhQdVFjcHg0TlRxZ3g5M2xabW41TDh2SEVHU2pQQyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cHM6Ly9uZGN2Mi5pbnRlbGxlY3NvZnRiZC5jb20vaW52ZW50b3J5Ijt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vbmRjdjIuaW50ZWxsZWNzb2Z0YmQuY29tL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792306126);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_receive_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_receive_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `serial_no` varchar(100) DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `status` varchar(20) NOT NULL DEFAULT 'In Stock',
  `coverage_type` enum('Warranty','Service') DEFAULT NULL,
  `coverage_start` date DEFAULT NULL,
  `duration` int(10) UNSIGNED DEFAULT NULL,
  `duration_type` enum('Days','Months','Years') DEFAULT NULL,
  `coverage_end` date DEFAULT NULL,
  `coverage_terms` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `unit_id`, `item_id`, `purchase_receive_id`, `purchase_receive_item_id`, `supplier_id`, `parent_id`, `serial_no`, `quantity`, `status`, `coverage_type`, `coverage_start`, `duration`, `duration_type`, `coverage_end`, `coverage_terms`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, NULL, 264, 5, 5, 21, NULL, '1122', 1, 'In Stock', 'Warranty', '2026-10-18', 2, 'Years', '2028-10-18', NULL, 4, 4, '2026-10-18 11:23:05', '2026-10-18 11:23:11'),
(2, NULL, 264, 5, 5, 21, NULL, '1123', 1, 'In Stock', 'Warranty', '2026-10-18', 2, 'Years', '2028-10-18', NULL, 4, 4, '2026-10-18 11:23:05', '2026-10-18 11:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `code`, `name`, `contact_person`, `contact_no`, `email`, `address`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(21, 'SP-001', 'Khan Electronics', 'Adbullah Al Mamun', '01912345678', 'mamun@gmail.com', 'Mirpur 2, Dhaka', 1, 2, 2, '2026-10-18 10:54:51', '2026-10-18 10:54:51'),
(22, 'SP-002', 'Shamim Traders', 'Shamim Osman', '01712345678', 'shamim@gmail.com', 'Mirpur 6, Dhaka', 1, 2, 2, '2026-10-18 10:55:43', '2026-10-18 10:55:43');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(250) NOT NULL,
  `details` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `status` enum('Open','Closed') NOT NULL DEFAULT 'Open',
  `close_note` text DEFAULT NULL,
  `closed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comments`
--

CREATE TABLE `ticket_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comments` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `type` enum('Wing','Unit','Division') NOT NULL DEFAULT 'Wing',
  `order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `code`, `name`, `address`, `type`, `order`, `status`, `created_at`, `updated_at`) VALUES
(282, '0001', 'NDC', 'Dhaka', 'Wing', 1, 1, '2026-10-18 10:50:30', '2026-10-18 10:50:30'),
(283, '0002', 'TRG', 'Dhaka', 'Wing', 2, 1, '2026-10-18 10:51:07', '2026-10-18 10:51:07'),
(284, '0003', 'AWFC', 'Dhaka', 'Wing', 3, 1, '2026-10-18 10:52:15', '2026-10-18 10:52:15'),
(285, '0004', 'ITDE', 'Dhaka', 'Wing', 4, 1, '2026-10-18 10:52:35', '2026-10-18 10:52:35'),
(286, '0005', 'MT', 'Dhaka', 'Wing', 5, 1, '2026-10-18 10:52:56', '2026-10-18 10:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL COMMENT 'Login name',
  `email` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `full_name`, `mobile_no`, `address`, `role_id`, `unit_id`, `rank_id`, `photo`, `join_date`, `last_login_at`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'shamim424884@gmail.com', 'Shamimul Haque', '01977424884', NULL, 1, NULL, 11, NULL, '2025-04-10', '2026-10-18 10:29:20', 1, NULL, '$2y$12$G.gymRL1J3Ei.mX9UtmOFecTwBRRT5rT9HOO4wr4Ov2hb3dp11V8C', NULL, '2025-04-09 18:00:00', '2026-10-18 10:29:20'),
(2, 'administrator', 'administrator@gmail.com', 'Administrator', NULL, NULL, 2, NULL, 4, NULL, '2025-01-12', '2026-10-18 11:04:19', 1, NULL, '$2y$12$rEcikerX2C6Mio4FE6jcger2pWYqqxn5P0JwsyRRXsTH.HQ4hwQIq', NULL, '2025-01-11 18:00:00', '2026-10-18 11:04:19'),
(3, 'Quarter Master', 'qm@gmail.com', 'Quarter Master', '01977424885', NULL, 3, NULL, 7, NULL, '2026-10-12', '2026-10-18 10:58:13', 1, NULL, '$2y$12$BIjJSMMOi.F2rmRmB1UdjelEWG9BeEuYe.DABz4RgELc7Y/zNjFmS', NULL, '2026-10-11 18:00:00', '2026-10-18 10:58:13'),
(4, 'Storeman', 'storman@gmail.com', 'Storeman', '01977424886', NULL, 4, NULL, 7, NULL, '2026-10-12', '2026-10-18 12:48:59', 1, NULL, '$2y$12$Vnuru3RDyx/ZaKT3NjXEj.CLjpAJbHbf/ogC/9gwnlQBGAZcuyndS', NULL, '2026-10-11 18:00:00', '2026-10-18 12:48:59');

-- --------------------------------------------------------

--
-- Table structure for table `warranty_claims`
--

CREATE TABLE `warranty_claims` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `damage_id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('Warranty','Service') NOT NULL,
  `status` enum('For Claim','Claimed','Received','Not Covered') NOT NULL DEFAULT 'For Claim',
  `claim_date` date DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `expected_return_date` date DEFAULT NULL,
  `claimed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `received_by` bigint(20) UNSIGNED DEFAULT NULL,
  `received_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `approval_requests`
--
ALTER TABLE `approval_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approval_requests_approvable_type_approvable_id_index` (`approvable_type`,`approvable_id`),
  ADD KEY `approval_requests_unit_id_foreign` (`unit_id`),
  ADD KEY `approval_requests_requested_by_foreign` (`requested_by`),
  ADD KEY `approval_requests_actioned_by_foreign` (`actioned_by`),
  ADD KEY `approval_requests_category_index` (`category`),
  ADD KEY `approval_requests_status_index` (`status`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_category_id_foreign` (`category_id`),
  ADD KEY `brands_created_by_foreign` (`created_by`),
  ADD KEY `brands_updated_by_foreign` (`updated_by`),
  ADD KEY `brands_approval_status_index` (`approval_status`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `capacities`
--
ALTER TABLE `capacities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `capacities_category_id_foreign` (`category_id`),
  ADD KEY `capacities_product_model_id_foreign` (`product_model_id`),
  ADD KEY `capacities_created_by_foreign` (`created_by`),
  ADD KEY `capacities_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_category_id_foreign` (`parent_category_id`),
  ADD KEY `categories_created_by_foreign` (`created_by`),
  ADD KEY `categories_updated_by_foreign` (`updated_by`),
  ADD KEY `categories_approval_status_index` (`approval_status`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_sender_id_foreign` (`sender_id`),
  ADD KEY `chats_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `damages`
--
ALTER TABLE `damages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damages_stock_id_foreign` (`stock_id`),
  ADD KEY `damages_unit_id_foreign` (`unit_id`),
  ADD KEY `damages_approved_by_foreign` (`approved_by`),
  ADD KEY `damages_created_by_foreign` (`created_by`),
  ADD KEY `damages_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `deployments`
--
ALTER TABLE `deployments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deployments_stock_id_foreign` (`stock_id`),
  ADD KEY `deployments_unit_id_foreign` (`unit_id`),
  ADD KEY `deployments_created_by_foreign` (`created_by`),
  ADD KEY `deployments_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `financial_years`
--
ALTER TABLE `financial_years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `financial_years_name_unique` (`name`),
  ADD KEY `financial_years_created_by_foreign` (`created_by`),
  ADD KEY `financial_years_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ip_audits`
--
ALTER TABLE `ip_audits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ip_filters`
--
ALTER TABLE `ip_filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue_vouchers`
--
ALTER TABLE `issue_vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `issue_vouchers_iv_no_unique` (`iv_no`),
  ADD KEY `issue_vouchers_from_unit_id_foreign` (`from_unit_id`),
  ADD KEY `issue_vouchers_created_by_foreign` (`created_by`),
  ADD KEY `issue_vouchers_updated_by_foreign` (`updated_by`),
  ADD KEY `issue_vouchers_approval_status_index` (`approval_status`);

--
-- Indexes for table `issue_voucher_items`
--
ALTER TABLE `issue_voucher_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_voucher_items_issue_voucher_id_foreign` (`issue_voucher_id`),
  ADD KEY `issue_voucher_items_stock_id_foreign` (`stock_id`),
  ADD KEY `issue_voucher_items_to_unit_id_foreign` (`to_unit_id`),
  ADD KEY `issue_voucher_items_actioned_by_foreign` (`actioned_by`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `items_code_unique` (`code`),
  ADD KEY `items_parent_category_id_foreign` (`parent_category_id`),
  ADD KEY `items_category_id_foreign` (`category_id`),
  ADD KEY `items_brand_id_foreign` (`brand_id`),
  ADD KEY `items_product_model_id_foreign` (`product_model_id`),
  ADD KEY `items_port_id_foreign` (`port_id`),
  ADD KEY `items_layer_id_foreign` (`layer_id`),
  ADD KEY `items_capacity_id_foreign` (`capacity_id`),
  ADD KEY `items_item_unit_id_foreign` (`item_unit_id`),
  ADD KEY `items_created_by_foreign` (`created_by`),
  ADD KEY `items_updated_by_foreign` (`updated_by`),
  ADD KEY `items_approval_status_index` (`approval_status`);

--
-- Indexes for table `item_units`
--
ALTER TABLE `item_units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_units_code_unique` (`code`),
  ADD KEY `item_units_created_by_foreign` (`created_by`),
  ADD KEY `item_units_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layers`
--
ALTER TABLE `layers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `layers_category_id_foreign` (`category_id`),
  ADD KEY `layers_product_model_id_foreign` (`product_model_id`),
  ADD KEY `layers_created_by_foreign` (`created_by`),
  ADD KEY `layers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `licenses_deployment_id_foreign` (`deployment_id`),
  ADD KEY `licenses_stock_id_foreign` (`stock_id`),
  ADD KEY `licenses_created_by_foreign` (`created_by`),
  ADD KEY `licenses_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `parent_categories`
--
ALTER TABLE `parent_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `parent_categories_name_unique` (`name`),
  ADD KEY `parent_categories_created_by_foreign` (`created_by`),
  ADD KEY `parent_categories_updated_by_foreign` (`updated_by`),
  ADD KEY `parent_categories_approval_status_index` (`approval_status`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `ports`
--
ALTER TABLE `ports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ports_category_id_foreign` (`category_id`),
  ADD KEY `ports_product_model_id_foreign` (`product_model_id`),
  ADD KEY `ports_created_by_foreign` (`created_by`),
  ADD KEY `ports_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `product_models`
--
ALTER TABLE `product_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_models_category_id_foreign` (`category_id`),
  ADD KEY `product_models_brand_id_foreign` (`brand_id`),
  ADD KEY `product_models_created_by_foreign` (`created_by`),
  ADD KEY `product_models_updated_by_foreign` (`updated_by`),
  ADD KEY `product_models_approval_status_index` (`approval_status`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_orders_po_no_unique` (`po_no`),
  ADD KEY `purchase_orders_unit_id_foreign` (`unit_id`),
  ADD KEY `purchase_orders_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchase_orders_financial_year_id_foreign` (`financial_year_id`),
  ADD KEY `purchase_orders_created_by_foreign` (`created_by`),
  ADD KEY `purchase_orders_updated_by_foreign` (`updated_by`),
  ADD KEY `purchase_orders_approval_status_index` (`approval_status`);

--
-- Indexes for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_items_purchase_order_id_foreign` (`purchase_order_id`),
  ADD KEY `purchase_order_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `purchase_receives`
--
ALTER TABLE `purchase_receives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_receives_unit_id_foreign` (`unit_id`),
  ADD KEY `purchase_receives_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchase_receives_purchase_order_id_foreign` (`purchase_order_id`),
  ADD KEY `purchase_receives_financial_year_id_foreign` (`financial_year_id`),
  ADD KEY `purchase_receives_created_by_foreign` (`created_by`),
  ADD KEY `purchase_receives_updated_by_foreign` (`updated_by`),
  ADD KEY `purchase_receives_approval_status_index` (`approval_status`);

--
-- Indexes for table `purchase_receive_items`
--
ALTER TABLE `purchase_receive_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_receive_items_purchase_receive_id_foreign` (`purchase_receive_id`),
  ADD KEY `purchase_receive_items_purchase_order_item_id_foreign` (`purchase_order_item_id`),
  ADD KEY `purchase_receive_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `quick_links`
--
ALTER TABLE `quick_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quick_links_user_id_foreign` (`user_id`);

--
-- Indexes for table `ranks`
--
ALTER TABLE `ranks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permissions_role_id_path_ability_unique` (`role_id`,`path`,`ability`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stocks_serial_no_unique` (`serial_no`),
  ADD KEY `stocks_unit_id_foreign` (`unit_id`),
  ADD KEY `stocks_item_id_foreign` (`item_id`),
  ADD KEY `stocks_purchase_receive_id_foreign` (`purchase_receive_id`),
  ADD KEY `stocks_purchase_receive_item_id_foreign` (`purchase_receive_item_id`),
  ADD KEY `stocks_supplier_id_foreign` (`supplier_id`),
  ADD KEY `stocks_parent_id_foreign` (`parent_id`),
  ADD KEY `stocks_created_by_foreign` (`created_by`),
  ADD KEY `stocks_updated_by_foreign` (`updated_by`),
  ADD KEY `stocks_status_index` (`status`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_code_unique` (`code`),
  ADD KEY `suppliers_created_by_foreign` (`created_by`),
  ADD KEY `suppliers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`),
  ADD KEY `tickets_closed_by_foreign` (`closed_by`);

--
-- Indexes for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_comments_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_code_unique` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_name_unique` (`name`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_unit_id_foreign` (`unit_id`),
  ADD KEY `users_rank_id_foreign` (`rank_id`);

--
-- Indexes for table `warranty_claims`
--
ALTER TABLE `warranty_claims`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warranty_claims_damage_id_foreign` (`damage_id`),
  ADD KEY `warranty_claims_stock_id_foreign` (`stock_id`),
  ADD KEY `warranty_claims_unit_id_foreign` (`unit_id`),
  ADD KEY `warranty_claims_claimed_by_foreign` (`claimed_by`),
  ADD KEY `warranty_claims_received_by_foreign` (`received_by`),
  ADD KEY `warranty_claims_created_by_foreign` (`created_by`),
  ADD KEY `warranty_claims_updated_by_foreign` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT for table `approval_requests`
--
ALTER TABLE `approval_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `capacities`
--
ALTER TABLE `capacities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `damages`
--
ALTER TABLE `damages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deployments`
--
ALTER TABLE `deployments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_years`
--
ALTER TABLE `financial_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ip_audits`
--
ALTER TABLE `ip_audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_filters`
--
ALTER TABLE `ip_filters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_vouchers`
--
ALTER TABLE `issue_vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_voucher_items`
--
ALTER TABLE `issue_voucher_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT for table `item_units`
--
ALTER TABLE `item_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `layers`
--
ALTER TABLE `layers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `parent_categories`
--
ALTER TABLE `parent_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ports`
--
ALTER TABLE `ports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_models`
--
ALTER TABLE `product_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_receives`
--
ALTER TABLE `purchase_receives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_receive_items`
--
ALTER TABLE `purchase_receive_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quick_links`
--
ALTER TABLE `quick_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ranks`
--
ALTER TABLE `ranks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=316;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `warranty_claims`
--
ALTER TABLE `warranty_claims`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `approval_requests`
--
ALTER TABLE `approval_requests`
  ADD CONSTRAINT `approval_requests_actioned_by_foreign` FOREIGN KEY (`actioned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `approval_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `approval_requests_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `brands_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `brands_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `capacities`
--
ALTER TABLE `capacities`
  ADD CONSTRAINT `capacities_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `capacities_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `capacities_product_model_id_foreign` FOREIGN KEY (`product_model_id`) REFERENCES `product_models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `capacities_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `categories_parent_category_id_foreign` FOREIGN KEY (`parent_category_id`) REFERENCES `parent_categories` (`id`),
  ADD CONSTRAINT `categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chats_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `damages`
--
ALTER TABLE `damages`
  ADD CONSTRAINT `damages_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `damages_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `damages_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`),
  ADD CONSTRAINT `damages_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `damages_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `deployments`
--
ALTER TABLE `deployments`
  ADD CONSTRAINT `deployments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `deployments_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`),
  ADD CONSTRAINT `deployments_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `deployments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `financial_years`
--
ALTER TABLE `financial_years`
  ADD CONSTRAINT `financial_years_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `financial_years_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `issue_vouchers`
--
ALTER TABLE `issue_vouchers`
  ADD CONSTRAINT `issue_vouchers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `issue_vouchers_from_unit_id_foreign` FOREIGN KEY (`from_unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `issue_vouchers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `issue_voucher_items`
--
ALTER TABLE `issue_voucher_items`
  ADD CONSTRAINT `issue_voucher_items_actioned_by_foreign` FOREIGN KEY (`actioned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `issue_voucher_items_issue_voucher_id_foreign` FOREIGN KEY (`issue_voucher_id`) REFERENCES `issue_vouchers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `issue_voucher_items_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`),
  ADD CONSTRAINT `issue_voucher_items_to_unit_id_foreign` FOREIGN KEY (`to_unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `items_capacity_id_foreign` FOREIGN KEY (`capacity_id`) REFERENCES `capacities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `items_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `items_item_unit_id_foreign` FOREIGN KEY (`item_unit_id`) REFERENCES `item_units` (`id`),
  ADD CONSTRAINT `items_layer_id_foreign` FOREIGN KEY (`layer_id`) REFERENCES `layers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `items_parent_category_id_foreign` FOREIGN KEY (`parent_category_id`) REFERENCES `parent_categories` (`id`),
  ADD CONSTRAINT `items_port_id_foreign` FOREIGN KEY (`port_id`) REFERENCES `ports` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `items_product_model_id_foreign` FOREIGN KEY (`product_model_id`) REFERENCES `product_models` (`id`),
  ADD CONSTRAINT `items_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `item_units`
--
ALTER TABLE `item_units`
  ADD CONSTRAINT `item_units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `item_units_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `layers`
--
ALTER TABLE `layers`
  ADD CONSTRAINT `layers_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `layers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `layers_product_model_id_foreign` FOREIGN KEY (`product_model_id`) REFERENCES `product_models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `layers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `licenses`
--
ALTER TABLE `licenses`
  ADD CONSTRAINT `licenses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `licenses_deployment_id_foreign` FOREIGN KEY (`deployment_id`) REFERENCES `deployments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `licenses_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`),
  ADD CONSTRAINT `licenses_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `parent_categories`
--
ALTER TABLE `parent_categories`
  ADD CONSTRAINT `parent_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `parent_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ports`
--
ALTER TABLE `ports`
  ADD CONSTRAINT `ports_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `ports_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ports_product_model_id_foreign` FOREIGN KEY (`product_model_id`) REFERENCES `product_models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ports_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_models`
--
ALTER TABLE `product_models`
  ADD CONSTRAINT `product_models_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `product_models_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `product_models_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_models_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_orders_financial_year_id_foreign` FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`),
  ADD CONSTRAINT `purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `purchase_orders_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `purchase_orders_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD CONSTRAINT `purchase_order_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `purchase_order_items_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_receives`
--
ALTER TABLE `purchase_receives`
  ADD CONSTRAINT `purchase_receives_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchase_receives_financial_year_id_foreign` FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`),
  ADD CONSTRAINT `purchase_receives_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `purchase_receives_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `purchase_receives_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `purchase_receives_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purchase_receive_items`
--
ALTER TABLE `purchase_receive_items`
  ADD CONSTRAINT `purchase_receive_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `purchase_receive_items_purchase_order_item_id_foreign` FOREIGN KEY (`purchase_order_item_id`) REFERENCES `purchase_order_items` (`id`),
  ADD CONSTRAINT `purchase_receive_items_purchase_receive_id_foreign` FOREIGN KEY (`purchase_receive_id`) REFERENCES `purchase_receives` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quick_links`
--
ALTER TABLE `quick_links`
  ADD CONSTRAINT `quick_links_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stocks_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `stocks_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `stocks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stocks_purchase_receive_id_foreign` FOREIGN KEY (`purchase_receive_id`) REFERENCES `purchase_receives` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stocks_purchase_receive_item_id_foreign` FOREIGN KEY (`purchase_receive_item_id`) REFERENCES `purchase_receive_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stocks_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stocks_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `stocks_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `suppliers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_closed_by_foreign` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD CONSTRAINT `ticket_comments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_rank_id_foreign` FOREIGN KEY (`rank_id`) REFERENCES `ranks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `warranty_claims`
--
ALTER TABLE `warranty_claims`
  ADD CONSTRAINT `warranty_claims_claimed_by_foreign` FOREIGN KEY (`claimed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `warranty_claims_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `warranty_claims_damage_id_foreign` FOREIGN KEY (`damage_id`) REFERENCES `damages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `warranty_claims_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `warranty_claims_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`),
  ADD CONSTRAINT `warranty_claims_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `warranty_claims_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
