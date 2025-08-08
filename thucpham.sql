-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 07, 2025 at 06:30 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thucpham`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'ID user đã login, NULL nếu guest',
  `session_id` varchar(255) DEFAULT NULL COMMENT 'Session ID cho guest user',
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Tổng tiền trước thuế',
  `total_item` int(11) NOT NULL DEFAULT 0 COMMENT 'Tổng số lượng sản phẩm',
  `status` enum('active','abandoned','completed') NOT NULL DEFAULT 'active' COMMENT 'Trạng thái giỏ hàng',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `subtotal`, `total_item`, `status`, `created_at`, `updated_at`) VALUES
(20, NULL, '3IPKoWBgzfrLeHQeEDUazUK8WpviGwoki3gRroBi', 0.00, 0, 'active', '2025-08-03 19:24:16', '2025-08-03 19:24:16'),
(21, NULL, 'ldszjkSEAAkkSDdDgyXW9jHLFLGq8hmnDyy5O9g9', 0.00, 0, 'active', '2025-08-03 19:24:57', '2025-08-03 19:24:57'),
(22, NULL, 'ACeSvFHhhLT72sUKufgJEXfzbw5ucrwZ7XCi8jRO', 0.00, 0, 'active', '2025-08-03 19:26:55', '2025-08-03 19:26:55'),
(23, NULL, 'IwXFDgAGR860Pj8aVlhw21iSEGfQsl2ou5Vu67rR', 0.00, 0, 'active', '2025-08-03 19:26:58', '2025-08-03 19:26:58'),
(24, NULL, 'GsvWQ6Fr4pKBSInr54F7bXTgeb8apTGGSGQHzV7w', 0.00, 0, 'active', '2025-08-03 19:44:13', '2025-08-03 19:44:13'),
(25, NULL, 'QkpAmCaKIgHUdmmcOGXFkThZyPIXeAkea7lihwWY', 0.00, 0, 'active', '2025-08-03 19:44:17', '2025-08-03 19:44:17'),
(26, NULL, 'u1GEQW5YuGrS0JNDLHNoKz0cpkYjf90xt2cT26PZ', 0.00, 0, 'active', '2025-08-03 19:51:06', '2025-08-03 19:51:06'),
(27, NULL, 'dPJtEN9idSaJNx8Fh4paRbDA352GejkATrk5LoDz', 0.00, 0, 'active', '2025-08-03 19:51:10', '2025-08-03 19:51:10'),
(28, NULL, 'iKFPKiru1DjCytkTqCPY5yv6XTJIAXdeTS65fBJy', 0.00, 0, 'active', '2025-08-03 19:52:46', '2025-08-03 19:52:46'),
(29, NULL, 'FaNTSN38z5F4FwzUJVw8XbzvkEwsuSMyHRUrauiA', 0.00, 0, 'active', '2025-08-03 19:52:52', '2025-08-03 19:52:52'),
(30, NULL, 'rtURZ2kyzXeTZtNpsmcU23rGWcG79eki1hwHoAnn', 0.00, 0, 'active', '2025-08-03 19:57:35', '2025-08-03 19:57:35'),
(31, NULL, 'DB8rn79M6vy1eOZ7LEcYGbR2C6YIPhuqqgdQrX1r', 0.00, 0, 'active', '2025-08-03 19:57:38', '2025-08-03 19:57:38'),
(32, NULL, 'setsoLaNHX8yssn4PI8zdfBFJgtA3GOccwWZ92Pc', 0.00, 0, 'active', '2025-08-03 20:06:14', '2025-08-03 20:06:14'),
(33, NULL, 'BwKtM3YVyQQIqmtr5Hd594kXC79qCkijHVWP9RwQ', 0.00, 0, 'active', '2025-08-03 20:06:25', '2025-08-03 20:18:10'),
(35, NULL, 'JiUytoAuxgKMxUWqLG460lTOKZvYTbwHD6iBHYs9', 0.00, 0, 'active', '2025-08-06 17:55:28', '2025-08-06 17:55:28'),
(36, NULL, 'vz227oTjQVQc3jKjf9xUZRhIpqYZ9Obvq8H0madY', 0.00, 0, 'active', '2025-08-06 17:55:32', '2025-08-06 17:55:32'),
(37, NULL, 'MmZ3ZObs8SWk8m6rXTWmwLgfvwCNLi0i72oVl18t', 0.00, 0, 'active', '2025-08-06 17:59:36', '2025-08-06 17:59:36'),
(38, NULL, '5tvyId2OMor90Pg8x1hbU0kWuqKZ0vt0e7mv2MSq', 0.00, 0, 'active', '2025-08-06 17:59:40', '2025-08-06 20:27:50'),
(39, NULL, 'E2jtfhYbkXjzChLT4CPv9RKjo6RVg6XeKD6Rn6sO', 1550.00, 2, 'active', '2025-08-07 02:50:15', '2025-08-07 02:54:11'),
(41, NULL, 'Y8p8X2lsJeObRLv3kyWudksOoGdzx2DY64vFG7zZ', 0.00, 0, 'active', '2025-08-07 09:09:42', '2025-08-07 09:09:42'),
(43, NULL, 'rQdJLUnQysWYxuVfzyK6scrIB4WJV5OlwL7eecb2', 0.00, 0, 'active', '2025-08-07 09:24:26', '2025-08-07 09:24:26'),
(44, NULL, '6DnHy832T35InKSzsQBv8J1WYtoEK0K9wUyGfcQ8', 0.00, 0, 'active', '2025-08-07 09:24:31', '2025-08-07 09:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID giỏ hàng',
  `product_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID sản phẩm',
  `quantity` int(11) NOT NULL DEFAULT 1 COMMENT 'Số lượng sản phẩm',
  `unit_price` decimal(10,2) NOT NULL COMMENT 'Giá đơn vị tại thời điểm add',
  `line_total` decimal(10,2) NOT NULL COMMENT 'Tổng tiền dòng = quantity * unit_price',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `unit_price`, `line_total`, `created_at`, `updated_at`) VALUES
(23, 39, 6, 1, 700.00, 700.00, '2025-08-07 02:50:15', '2025-08-07 02:50:15'),
(24, 39, 2, 1, 850.00, 850.00, '2025-08-07 02:50:18', '2025-08-07 02:50:18');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `parent_id`, `image`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 'Thịt thuỷ hải sản', 'thit-thuy-hai-san', NULL, 'categories/dMZDQocaQs4fvnaiKVhjE9NCWm7AcVSsHGArF4Rq.jpg', NULL, 1, 1, '2025-07-30 18:47:57', '2025-07-30 18:47:57'),
(3, 'Rau củ , hoa quả', 'rau-cu-hoa-qua', NULL, 'categories/O7ZX6FbCEcxr1byu6DiXgygJ9q56pwwB3t9d6LSf.jpg', NULL, 1, 2, '2025-07-30 18:48:39', '2025-07-30 18:48:59'),
(4, 'Bún ,mỳ , miến', 'bun-my-mien', NULL, 'categories/FbzY2h4WI06A0Q7PpkX1s260QxoOZPs2QP6Yfe6f.jpg', NULL, 1, 3, '2025-08-06 23:23:36', '2025-08-06 23:23:36'),
(5, 'Nguyên liệu đồ khô', 'nguyen-lieu-do-kho', NULL, 'categories/o3PhA0BAsDKDPThQFSb0VhCeqJiKavRLfMujb5jB.jpg', NULL, 1, 4, '2025-08-06 23:24:16', '2025-08-06 23:24:16'),
(6, 'Giò chả thực phẩm chế biến sẵn', 'gio-cha-thuc-pham-che-bien-san', NULL, 'categories/wM0NKaVnjmKIUbPREwIc40qHwahqYeDJM7dwVcUj.jpg', NULL, 1, 5, '2025-08-06 23:25:07', '2025-08-06 23:25:07'),
(7, 'Bánh kẹo , đồ ăn vặt , đồ uống', 'banh-keo-do-an-vat-do-uong', NULL, 'categories/TAcIc1l6RK6EoeBLhvTYhdeUgEzYkFqNCvZAlx2U.jpg', NULL, 1, 6, '2025-08-06 23:25:58', '2025-08-06 23:25:58'),
(8, 'Các loại gia vị', 'cac-loai-gia-vi', NULL, 'categories/bkQG4LQavkQT9wzo9drTNBv9DsdFbduhKJnIfIQn.jpg', NULL, 1, 7, '2025-08-06 23:26:40', '2025-08-06 23:26:40');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_07_30_082152_create_categories_table', 2),
(6, '2025_07_29_004338_create_units_table', 3),
(8, '2025_07_30_154732_create_products_table', 4),
(9, '2025_08_01_160533_create_carts_table', 5),
(10, '2025_08_01_160614_create_cart_items_table', 5),
(11, '2025_08_02_165350_create_shipping_rates_table', 6),
(12, '2025_08_03_015256_create_payment_methods_table', 7),
(13, '2025_08_03_020205_create_orders_table', 7),
(14, '2025_08_03_020216_create_order_items_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `shipping_rate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `delivery_province` varchar(100) NOT NULL,
  `delivery_city` varchar(100) DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `delivery_time_frame` varchar(50) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_zone_name` varchar(100) DEFAULT NULL,
  `processing_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','processing','shipping','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `is_guest_order` tinyint(1) NOT NULL DEFAULT 0,
  `order_notes` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `order_date` datetime NOT NULL DEFAULT '2025-08-03 02:42:03',
  `confirmed_at` datetime DEFAULT NULL,
  `shipped_at` datetime DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `payment_method_id`, `shipping_rate_id`, `customer_name`, `customer_email`, `customer_phone`, `delivery_province`, `delivery_city`, `delivery_address`, `delivery_time_frame`, `subtotal`, `shipping_fee`, `shipping_zone_name`, `processing_fee`, `discount_amount`, `total_amount`, `status`, `payment_status`, `is_guest_order`, `order_notes`, `admin_notes`, `order_date`, `confirmed_at`, `shipped_at`, `delivered_at`, `created_at`, `updated_at`) VALUES
(1, 'ORD-20250804-3954', 1, 1, 17, 'ijfff', NULL, NULL, 'Gifu', 'hai', '742 nguyễn văn linh hải phòng', '12-15h', 3250.00, 750.00, NULL, 0.00, 0.00, 4000.00, 'shipping', 'pending', 0, 'ddd', NULL, '2025-08-03 02:42:03', NULL, NULL, NULL, '2025-08-03 20:17:30', '2025-08-04 01:35:30'),
(2, 'ORD-20250807-3173', 1, 1, 7, 'ijfffssss', NULL, '0982513461', 'Chiba', 'hai', '742 nguyễn văn linh hải phòng', '12-15h', 4250.00, 600.00, NULL, 0.00, 0.00, 4850.00, 'pending', 'pending', 0, 'ok', NULL, '2025-08-03 02:42:03', NULL, NULL, NULL, '2025-08-06 17:59:47', '2025-08-06 17:59:47'),
(3, 'ORD-20250807-4505', 1, 1, 12, 'ijfffssss', NULL, '0982513461', 'Hyogo', 'hai', '742 nguyễn văn linh hải phòng', '12-15h', 6550.00, 700.00, NULL, 0.00, 0.00, 7250.00, 'pending', 'pending', 0, NULL, NULL, '2025-08-03 02:42:03', NULL, NULL, NULL, '2025-08-07 09:09:58', '2025-08-07 09:09:58'),
(4, 'ORD-20250807-7238', 1, 1, 38, 'rrrrrrr', NULL, '0982513461', 'Ibaraki', 'hai', '742 nguyễn văn linh hải phòng', '15-18h', 4850.00, 580.00, NULL, 0.00, 0.00, 5430.00, 'pending', 'pending', 0, NULL, NULL, '2025-08-03 02:42:03', NULL, NULL, NULL, '2025-08-07 09:24:36', '2025-08-07 09:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_jp_name` varchar(255) DEFAULT NULL,
  `product_slug` varchar(255) DEFAULT NULL,
  `product_image` varchar(500) DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `line_total` decimal(10,2) NOT NULL,
  `product_weight` decimal(8,2) DEFAULT NULL,
  `product_category` varchar(255) DEFAULT NULL,
  `product_unit` varchar(50) DEFAULT NULL,
  `product_unit_display` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_jp_name`, `product_slug`, `product_image`, `unit_price`, `quantity`, `discount_percent`, `discount_amount`, `line_total`, `product_weight`, `product_category`, `product_unit`, `product_unit_display`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Cá rô phi 500 – 700g', '冷凍テイラピア', 'ca-ro-phi-500-700g', 'products/SRWU00uFG6ZUS9eCHgDMdBcF7Gtr6M6jZdocJX23.png', 600.00, 4, 0.00, 0.00, 2400.00, 0.00, 'Thịt thuỷ hải sản', 'kg', 'kg', '2025-08-03 20:17:30', '2025-08-03 20:17:30'),
(2, 1, 2, 'Thịt LỢN mông (không da)', '豚モモ肉（皮無し）', 'thit-lon-mong-khong-da', 'products/Vw7OCqYdFfDjZ0FZjmHCKINEDMX124KNVaPLOvNI.jpg', 850.00, 1, 0.00, 0.00, 850.00, 0.00, 'Thịt thuỷ hải sản', 'kg', 'kg', '2025-08-03 20:17:30', '2025-08-03 20:17:30'),
(3, 2, 2, 'Thịt LỢN mông (không da)', '豚モモ肉（皮無し）', 'thit-lon-mong-khong-da', 'products/Vw7OCqYdFfDjZ0FZjmHCKINEDMX124KNVaPLOvNI.jpg', 850.00, 5, 0.00, 0.00, 4250.00, 0.00, 'Thịt thuỷ hải sản', 'kg', 'kg', '2025-08-06 17:59:47', '2025-08-06 17:59:47'),
(4, 3, 2, 'Thịt LỢN mông (không da)', '豚モモ肉（皮無し）', 'thit-lon-mong-khong-da', 'products/Vw7OCqYdFfDjZ0FZjmHCKINEDMX124KNVaPLOvNI.jpg', 850.00, 3, 0.00, 0.00, 2550.00, 0.00, 'Thịt thuỷ hải sản', 'kg', 'kg', '2025-08-07 09:09:58', '2025-08-07 09:09:58'),
(5, 3, 3, 'Vịt nhỏ không đầu 1,6kg', 'アヒル', 'vit-nho-khong-dau-16kg', 'products/6J4x6hpwgKokrylf2COSlyantLSVXvTvrAgJlxBH.jpg', 1700.00, 1, 0.00, 0.00, 1700.00, 0.00, 'Thịt thuỷ hải sản', 'Con', 'con', '2025-08-07 09:09:58', '2025-08-07 09:09:58'),
(6, 3, 4, 'Tương đen Cholimex – chai_230g', 'Cholimex', 'tuong-den-cholimex-chai-230g', 'products/uHIh5rdQQQn6qJ4jy6gEua85plGGD3ISkIn7E7R6.jpg', 250.00, 1, 0.00, 0.00, 250.00, 0.00, 'Các loại gia vị', 'Chai', 'chai', '2025-08-07 09:09:58', '2025-08-07 09:09:58'),
(7, 3, 1, 'Cá rô phi 500 – 700g', '冷凍テイラピア', 'ca-ro-phi-500-700g', 'products/SRWU00uFG6ZUS9eCHgDMdBcF7Gtr6M6jZdocJX23.png', 600.00, 1, 0.00, 0.00, 600.00, 0.00, 'Thịt thuỷ hải sản', 'kg', 'kg', '2025-08-07 09:09:58', '2025-08-07 09:09:58'),
(8, 3, 5, 'Ớt tươi đông lạnh 500g', '冷凍唐辛子500gr', 'ot-tuoi-dong-lanh-500g', 'products/9mBSIUoUVHP9smzFxX2xHNRQpHbapcyoWNQJtpJJ.jpg', 750.00, 1, 0.00, 0.00, 750.00, 0.00, 'Rau củ , hoa quả', 'Gram', 'g', '2025-08-07 09:09:58', '2025-08-07 09:09:58'),
(9, 3, 6, 'Sấu 500g｜', 'ドラコントメロン', 'sau-500g', 'products/reo2sUTjrJ2pJVLoeQzKsJCnDHDNe3j1vLwSp2uV.jpg', 700.00, 1, 0.00, 0.00, 700.00, 0.00, 'Rau củ , hoa quả', 'Gram', 'g', '2025-08-07 09:09:58', '2025-08-07 09:09:58'),
(10, 4, 1, 'Cá rô phi 500 – 700g', '冷凍テイラピア', 'ca-ro-phi-500-700g', 'products/SRWU00uFG6ZUS9eCHgDMdBcF7Gtr6M6jZdocJX23.png', 600.00, 1, 0.00, 0.00, 600.00, 0.00, 'Thịt thuỷ hải sản', 'kg', 'kg', '2025-08-07 09:24:36', '2025-08-07 09:24:36'),
(11, 4, 5, 'Ớt tươi đông lạnh 500g', '冷凍唐辛子500gr', 'ot-tuoi-dong-lanh-500g', 'products/9mBSIUoUVHP9smzFxX2xHNRQpHbapcyoWNQJtpJJ.jpg', 750.00, 1, 0.00, 0.00, 750.00, 0.00, 'Rau củ , hoa quả', 'Gram', 'g', '2025-08-07 09:24:36', '2025-08-07 09:24:36'),
(12, 4, 6, 'Sấu 500g｜', 'ドラコントメロン', 'sau-500g', 'products/reo2sUTjrJ2pJVLoeQzKsJCnDHDNe3j1vLwSp2uV.jpg', 700.00, 1, 0.00, 0.00, 700.00, 0.00, 'Rau củ , hoa quả', 'Gram', 'g', '2025-08-07 09:24:36', '2025-08-07 09:24:36'),
(13, 4, 2, 'Thịt LỢN mông (không da)', '豚モモ肉（皮無し）', 'thit-lon-mong-khong-da', 'products/Vw7OCqYdFfDjZ0FZjmHCKINEDMX124KNVaPLOvNI.jpg', 850.00, 1, 0.00, 0.00, 850.00, 0.00, 'Thịt thuỷ hải sản', 'kg', 'kg', '2025-08-07 09:24:36', '2025-08-07 09:24:36'),
(14, 4, 4, 'Tương đen Cholimex – chai_230g', 'Cholimex', 'tuong-den-cholimex-chai-230g', 'products/uHIh5rdQQQn6qJ4jy6gEua85plGGD3ISkIn7E7R6.jpg', 250.00, 1, 0.00, 0.00, 250.00, 0.00, 'Các loại gia vị', 'Chai', 'chai', '2025-08-07 09:24:36', '2025-08-07 09:24:36'),
(15, 4, 3, 'Vịt nhỏ không đầu 1,6kg', 'アヒル', 'vit-nho-khong-dau-16kg', 'products/6J4x6hpwgKokrylf2COSlyantLSVXvTvrAgJlxBH.jpg', 1700.00, 1, 0.00, 0.00, 1700.00, 0.00, 'Thịt thuỷ hải sản', 'Con', 'con', '2025-08-07 09:24:36', '2025-08-07 09:24:36');

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
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('cod','bank_transfer','credit_card','momo','zalopay','paypal') NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `card_number_masked` varchar(20) DEFAULT NULL,
  `card_holder_name` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `processing_fee` decimal(5,2) NOT NULL DEFAULT 0.00,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `user_id`, `type`, `name`, `description`, `card_number_masked`, `card_holder_name`, `expiry_date`, `is_default`, `is_active`, `processing_fee`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, NULL, 'cod', 'Cash on Delivery', 'Thanh toán tiền mặt khi nhận hàng (COD)', NULL, NULL, NULL, 0, 1, 0.00, 1, '2025-08-02 20:43:20', '2025-08-02 20:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `jp_name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `specification` text DEFAULT NULL COMMENT 'thông số kỹ thuật',
  `currency` varchar(3) NOT NULL DEFAULT 'JPY',
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive','out_of_stock') NOT NULL DEFAULT 'active',
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT '% giảm giá',
  `image` varchar(255) DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Danh sách ảnh bổ sung' CHECK (json_valid(`images`)),
  `rating_avg` decimal(3,2) NOT NULL DEFAULT 0.00,
  `rating_count` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `unit_id`, `name`, `jp_name`, `slug`, `description`, `specification`, `currency`, `price`, `quantity`, `status`, `discount`, `image`, `images`, `rating_avg`, `rating_count`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Cá rô phi 500 – 700g', '冷凍テイラピア', 'ca-ro-phi-500-700g', NULL, '500-700 gam / 1 con', 'JPY', 600.00, 15, 'active', 0.00, 'products/SRWU00uFG6ZUS9eCHgDMdBcF7Gtr6M6jZdocJX23.png', NULL, 0.00, 0, 0, '2025-07-30 23:30:18', '2025-07-30 23:30:18'),
(2, 2, 1, 'Thịt LỢN mông (không da)', '豚モモ肉（皮無し）', 'thit-lon-mong-khong-da', 'Thịt heo', NULL, 'JPY', 850.00, 15, 'active', 0.00, 'products/Vw7OCqYdFfDjZ0FZjmHCKINEDMX124KNVaPLOvNI.jpg', NULL, 0.00, 0, 1, '2025-08-01 01:58:28', '2025-08-01 01:58:28'),
(3, 2, 27, 'Vịt nhỏ không đầu 1,6kg', 'アヒル', 'vit-nho-khong-dau-16kg', 'tươi ngon', '1 con', 'JPY', 1700.00, 3, 'active', 0.00, 'products/6J4x6hpwgKokrylf2COSlyantLSVXvTvrAgJlxBH.jpg', NULL, 0.00, 0, 1, '2025-08-06 23:52:59', '2025-08-06 23:52:59'),
(4, 8, 8, 'Tương đen Cholimex – chai_230g', 'Cholimex', 'tuong-den-cholimex-chai-230g', NULL, 'chai', 'JPY', 250.00, 199, 'active', 0.00, 'products/uHIh5rdQQQn6qJ4jy6gEua85plGGD3ISkIn7E7R6.jpg', NULL, 0.00, 0, 1, '2025-08-06 23:56:23', '2025-08-06 23:56:23'),
(5, 3, 12, 'Ớt tươi đông lạnh 500g', '冷凍唐辛子500gr', 'ot-tuoi-dong-lanh-500g', '冷凍唐辛子500gr', '500gr', 'JPY', 750.00, 1000, 'active', 0.00, 'products/9mBSIUoUVHP9smzFxX2xHNRQpHbapcyoWNQJtpJJ.jpg', NULL, 0.00, 0, 0, '2025-08-07 01:23:19', '2025-08-07 02:50:02'),
(6, 3, 12, 'Sấu 500g｜', 'ドラコントメロン', 'sau-500g', NULL, NULL, 'JPY', 700.00, 100, 'active', 0.00, 'products/reo2sUTjrJ2pJVLoeQzKsJCnDHDNe3j1vLwSp2uV.jpg', NULL, 0.00, 0, 0, '2025-08-07 02:09:12', '2025-08-07 02:09:12');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rates`
--

CREATE TABLE `shipping_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zone_name` varchar(100) NOT NULL,
  `base_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `delivery_days` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_rates`
--

INSERT INTO `shipping_rates` (`id`, `province`, `city`, `zone_name`, `base_fee`, `delivery_days`, `created_at`, `updated_at`) VALUES
(1, 'Tokyo', NULL, 'Tokyo Metropolitan Area', 500.00, '1', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(2, 'Tokyo', 'Shibuya', 'Central Tokyo', 450.00, '1', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(3, 'Tokyo', 'Shinjuku', 'Central Tokyo', 450.00, '1', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(4, 'Kanagawa', NULL, 'Kanto Region', 550.00, '1', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(5, 'Kanagawa', 'Yokohama', 'Major City', 500.00, '1', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(6, 'Saitama', NULL, 'Kanto Region', 600.00, '2', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(7, 'Chiba', NULL, 'Kanto Region', 600.00, '2', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(8, 'Osaka', NULL, 'Kansai Region', 650.00, '2', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(9, 'Osaka', 'Osaka City', 'Major City', 600.00, '2', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(10, 'Kyoto', NULL, 'Kansai Region', 650.00, '2', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(11, 'Kyoto', 'Kyoto City', 'Historic City', 600.00, '2', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(12, 'Hyogo', NULL, 'Kansai Region', 700.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(13, 'Hyogo', 'Kobe', 'Port City', 650.00, '2', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(14, 'Aichi', NULL, 'Chubu Region', 650.00, '2', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(15, 'Aichi', 'Nagoya', 'Major City', 600.00, '2', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(16, 'Shizuoka', NULL, 'Chubu Region', 700.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(17, 'Gifu', NULL, 'Chubu Region', 750.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(18, 'Miyagi', NULL, 'Tohoku Region', 800.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(19, 'Miyagi', 'Sendai', 'Regional Hub', 750.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(20, 'Fukushima', NULL, 'Tohoku Region', 850.00, '4', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(21, 'Aomori', NULL, 'Northern Japan', 950.00, '4', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(22, 'Hokkaido', NULL, 'Hokkaido Island', 1000.00, '4', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(23, 'Hokkaido', 'Sapporo', 'Major City', 900.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(24, 'Hokkaido', 'Hakodate', 'Southern Hokkaido', 950.00, '4', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(25, 'Fukuoka', NULL, 'Kyushu Region', 850.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(26, 'Fukuoka', 'Fukuoka City', 'Regional Hub', 800.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(27, 'Kumamoto', NULL, 'Kyushu Region', 900.00, '4', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(28, 'Kagoshima', NULL, 'Southern Kyushu', 950.00, '4', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(29, 'Kagawa', NULL, 'Shikoku Region', 750.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(30, 'Ehime', NULL, 'Shikoku Region', 780.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(31, 'Hiroshima', NULL, 'Chugoku Region', 700.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(32, 'Hiroshima', 'Hiroshima City', 'Major City', 650.00, '2', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(33, 'Okayama', NULL, 'Chugoku Region', 720.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(34, 'Okinawa', NULL, 'Remote Islands', 1200.00, '5', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(35, 'Okinawa', 'Naha', 'Main City', 1100.00, '5', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(36, 'Gunma', NULL, 'Mountain Region', 650.00, '2', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(37, 'Tochigi', NULL, 'Kanto Extended', 620.00, '2', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(38, 'Ibaraki', NULL, 'Kanto Extended', 580.00, '2', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(39, 'Nara', NULL, 'Historic Region', 680.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(40, 'Wakayama', NULL, 'Kii Peninsula', 720.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52'),
(41, 'Mie', NULL, 'Central Japan', 700.00, '3', '2025-08-02 10:31:52', '2025-08-02 10:31:52');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `symbol`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'kg', 'kg', NULL, 1, '2025-07-30 18:00:43', '2025-07-30 18:00:43'),
(2, 'cái', 'cái', NULL, 1, '2025-07-30 18:00:59', '2025-07-30 18:00:59'),
(3, 'túi', 'túi', NULL, 1, '2025-07-30 18:01:10', '2025-07-30 18:01:10'),
(4, 'Chiếc', 'chiếc', 'Đơn vị đếm chiếc - dùng cho xe, máy móc, thiết bị', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(5, 'Bộ', 'bộ', 'Đơn vị tính bộ - dùng cho sản phẩm có nhiều chi tiết', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(6, 'Hộp', 'hộp', 'Đơn vị đóng gói hộp - dùng cho sản phẩm đóng hộp', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(7, 'Thùng', 'thùng', 'Đơn vị đóng gói thùng - dùng cho sản phẩm đóng thùng', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(8, 'Chai', 'chai', 'Đơn vị đóng chai - dùng cho chất lỏng đóng chai', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(9, 'Lon', 'lon', 'Đơn vị đóng lon - dùng cho đồ uống, thực phẩm đóng lon', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(10, 'Gói', 'gói', 'Đơn vị đóng gói - dùng cho sản phẩm đóng gói nhỏ', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(11, 'Kilogram', 'kg', 'Đơn vị khối lượng - 1000 gram', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(12, 'Gram', 'g', 'Đơn vị khối lượng cơ bản', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(13, 'Tấn', 'tấn', 'Đơn vị khối lượng lớn - 1000 kg', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(14, 'Lít', 'l', 'Đơn vị thể tích chất lỏng', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(15, 'Millilít', 'ml', 'Đơn vị thể tích nhỏ - 1/1000 lít', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(16, 'Mét', 'm', 'Đơn vị chiều dài cơ bản', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(17, 'Centimét', 'cm', 'Đơn vị chiều dài - 1/100 mét', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(18, 'Mét vuông', 'm²', 'Đơn vị diện tích', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(19, 'Mét khối', 'm³', 'Đơn vị thể tích không gian', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(20, 'Viên', 'viên', 'Đơn vị đếm viên - dùng cho thuốc, kẹo', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(21, 'Hạt', 'hạt', 'Đơn vị đếm hạt - dùng cho hạt giống, ngũ cốc', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(22, 'Cuộn', 'cuộn', 'Đơn vị đếm cuộn - dùng cho giấy, vải, dây', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(23, 'Tờ', 'tờ', 'Đơn vị đếm tờ - dùng cho giấy, tài liệu', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(24, 'Quyển', 'quyển', 'Đơn vị đếm quyển - dùng cho sách, tạp chí', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(25, 'Cặp', 'cặp', 'Đơn vị đếm cặp - dùng cho giày, tất, găng tay', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(26, 'Đơn vị', 'đvt', 'Đơn vị tính chung - dùng khi không có đơn vị cụ thể', 1, '2025-07-30 19:46:25', '2025-07-30 19:46:25'),
(27, 'Con', 'con', 'đơn vị tính theo con', 1, '2025-08-02 10:42:36', '2025-08-02 10:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 0 COMMENT '0=customer, 1=admin',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `phone`, `role`, `is_active`, `last_name`, `first_name`, `display_name`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', '$2y$12$ZDI7a7xtlX/O116.VYEDv.Y97vYV78mg0DTlRY3DyatBF466URfCa', '0594414099', 1, 1, 'Thai Duong', 'Admin', 'Admin Thai Duong', NULL, '2GsaBmheYuc2eHjPdviJtoidFhIBCeeJFNSUq4wp1qxj8qSG9nQK9sBU4jDo', '2025-07-29 10:47:37', '2025-07-29 10:47:37'),
(2, 'customer@example.com', '$2y$12$PrkJqeDhgOI0.aSq1v8QQuuWxRmNkavVUJ2fcZ.C2pwzc445VuAky', '0987654321', 0, 1, 'A', 'Nguyen Van', 'Nguyen Van A', NULL, NULL, '2025-07-29 10:47:37', '2025-07-29 10:47:37'),
(3, 'd4948274@gmail.com', '$2y$12$5bQPCXDuQgCmGSIc/oAmaOfjVTKtP2nm6duTBbUv07mSwxLhr0YaS', '0868291780', 0, 1, 'pham', 'okihjh', 'okihjh pham', NULL, NULL, '2025-07-29 11:42:53', '2025-07-29 11:42:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_session_id` (`session_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cart_product` (`cart_id`,`product_id`),
  ADD KEY `idx_cart_product` (`cart_id`,`product_id`),
  ADD KEY `idx_cart_id` (`cart_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_slug_is_active_index` (`slug`,`is_active`),
  ADD KEY `categories_parent_id_index` (`parent_id`),
  ADD KEY `categories_sort_order_index` (`sort_order`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_shipping_rate_id_foreign` (`shipping_rate_id`),
  ADD KEY `orders_order_number_index` (`order_number`),
  ADD KEY `orders_user_id_index` (`user_id`),
  ADD KEY `orders_payment_method_id_index` (`payment_method_id`),
  ADD KEY `orders_status_index` (`status`),
  ADD KEY `orders_payment_status_index` (`payment_status`),
  ADD KEY `orders_is_guest_order_index` (`is_guest_order`),
  ADD KEY `orders_order_date_index` (`order_date`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_items_order_id_product_id_unique` (`order_id`,`product_id`),
  ADD KEY `order_items_order_id_index` (`order_id`),
  ADD KEY `order_items_product_id_index` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_methods_user_id_index` (`user_id`),
  ADD KEY `payment_methods_type_index` (`type`),
  ADD KEY `payment_methods_is_active_index` (`is_active`),
  ADD KEY `payment_methods_sort_order_index` (`sort_order`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_unit_id_foreign` (`unit_id`),
  ADD KEY `products_slug_status_index` (`slug`,`status`),
  ADD KEY `products_category_id_status_index` (`category_id`,`status`),
  ADD KEY `products_is_featured_status_index` (`is_featured`,`status`),
  ADD KEY `products_rating_avg_index` (`rating_avg`),
  ADD KEY `products_price_index` (`price`);

--
-- Indexes for table `shipping_rates`
--
ALTER TABLE `shipping_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_rates_province_city_index` (`province`,`city`),
  ADD KEY `shipping_rates_province_index` (`province`),
  ADD KEY `shipping_rates_zone_name_index` (`zone_name`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_email_index` (`email`),
  ADD KEY `users_is_active_index` (`is_active`),
  ADD KEY `users_role_index` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shipping_rates`
--
ALTER TABLE `shipping_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `orders_shipping_rate_id_foreign` FOREIGN KEY (`shipping_rate_id`) REFERENCES `shipping_rates` (`id`),
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
