-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 05 Kas 2023, 16:34:59
-- Sunucu sürümü: 10.4.27-MariaDB
-- PHP Sürümü: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `anopia`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expert_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `appointment_type` bigint(20) UNSIGNED NOT NULL,
  `appointment_status` bigint(20) UNSIGNED NOT NULL,
  `room_id` varchar(500) DEFAULT NULL,
  `meet_key` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `appointments`
--

INSERT INTO `appointments` (`id`, `created_at`, `updated_at`, `expert_id`, `user_id`, `appointment_date`, `appointment_time`, `appointment_type`, `appointment_status`, `room_id`, `meet_key`) VALUES
(25, '2023-09-01 08:18:25', '2023-09-01 08:18:45', 1, 29, '2023-09-01', '10:00:00', 1, 3, NULL, NULL),
(26, '2023-09-01 08:18:55', '2023-09-01 08:19:02', 1, 29, '2023-09-01', '14:22:00', 1, 2, NULL, 'f5vg-xck5-53fp'),
(27, '2023-09-01 08:56:09', '2023-09-01 08:56:47', 1, 34, '2023-09-02', '12:00:00', 1, 3, NULL, NULL),
(31, '2023-09-01 12:37:53', '2023-09-01 12:38:05', 38, 34, '2023-09-01', '20:00:00', 2, 2, NULL, '5o6s-8woi-v03q'),
(32, '2023-09-01 14:57:52', '2023-09-01 14:58:05', 38, 34, '2023-09-01', '10:00:00', 2, 2, NULL, 'h4ip-a0by-a0p4'),
(33, '2023-09-01 14:57:52', '2023-09-01 14:58:07', 38, 34, '2023-09-01', '23:00:00', 2, 2, NULL, '1qip-krxv-ic5f'),
(34, '2023-09-04 07:03:52', '2023-09-04 07:03:52', 1, 34, '2023-09-04', '16:00:00', 1, 1, NULL, NULL),
(35, '2023-09-04 07:05:18', '2023-09-04 07:58:52', 38, 34, '2023-09-04', '14:00:00', 1, 2, NULL, 'otg2-7ltu-pdv6'),
(36, '2023-09-05 11:34:42', '2023-09-05 11:34:42', 1, 34, '2023-09-06', '18:00:00', 1, 1, NULL, NULL),
(37, '2023-09-05 11:34:48', '2023-09-05 11:34:48', 1, 34, '2023-09-06', '18:00:00', 1, 1, NULL, NULL),
(38, '2023-09-05 11:34:48', '2023-09-05 11:34:48', 1, 34, '2023-09-06', '17:00:00', 1, 1, NULL, NULL),
(40, '2023-09-05 11:38:47', '2023-09-05 11:38:53', 38, 34, '2023-09-06', '14:00:00', 1, 2, NULL, 'g2j2-t6fp-keex'),
(41, '2023-09-05 11:44:46', '2023-09-05 11:44:55', 38, 34, '2023-09-06', '10:00:00', 1, 2, NULL, 'm5vw-6039-9wx2'),
(42, '2023-09-23 11:55:12', '2023-09-23 11:55:12', 1, 34, '2023-09-24', '16:00:00', 1, 1, NULL, NULL),
(43, '2023-10-25 10:29:47', '2023-10-25 10:29:47', 38, 34, '2023-10-25', '16:00:00', 1, 1, NULL, NULL),
(45, '2023-10-25 10:29:52', '2023-10-25 10:45:38', 38, 34, '2023-10-25', '17:00:00', 1, 2, NULL, '27ns-wt2w-vxzr'),
(46, '2023-10-28 11:07:16', '2023-10-28 11:07:24', 38, 34, '2023-10-28', '18:00:00', 1, 2, NULL, NULL),
(47, '2023-10-28 11:08:53', '2023-10-28 11:09:04', 38, 34, '2023-10-28', '19:00:00', 1, 2, NULL, 'guwe-ghpk-kkdm'),
(48, '2023-10-30 09:21:56', '2023-10-30 09:21:56', 38, 34, '2023-10-30', '16:00:00', 1, 1, NULL, NULL),
(49, '2023-10-30 09:22:05', '2023-10-30 09:22:49', 38, 34, '2023-10-30', '16:00:00', 1, 2, NULL, 'jo6i-ye7i-htvu'),
(50, '2023-10-30 09:22:05', '2023-10-30 09:22:05', 38, 34, '2023-10-30', '17:00:00', 1, 1, NULL, NULL),
(51, '2023-10-30 09:22:05', '2023-10-30 09:22:05', 38, 34, '2023-10-30', '21:00:00', 1, 1, NULL, NULL),
(52, '2023-11-02 07:24:24', '2023-11-02 07:24:52', 38, 34, '2023-11-02', '13:00:00', 1, 2, NULL, '5l5s-b9s3-p0qw');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `certificates`
--

CREATE TABLE `certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year` varchar(255) NOT NULL,
  `certificate` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `certificates`
--

INSERT INTO `certificates` (`id`, `year`, `certificate`, `user_id`, `created_at`, `updated_at`) VALUES
(25, '1923', 'asd', 38, '2023-09-23 10:56:41', '2023-09-23 10:56:41');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `expert_education`
--

CREATE TABLE `expert_education` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `expert_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `expert_education`
--

INSERT INTO `expert_education` (`id`, `title`, `expert_id`, `created_at`, `updated_at`) VALUES
(7, 'Doktora Haccettepe Üniversitesi Psikoloojik Danışmanlık ve Rehberlik', 1, '2023-09-01 10:18:21', '2023-09-01 10:18:21'),
(8, 'Yüksek Lisans Haccettepe Üniversitesi Psikoloojik Danışmanlık ve Rehberlik', 1, '2023-09-01 10:18:21', '2023-09-01 10:18:21'),
(9, 'Lisans Haccettepe Üniversitesi Psikoloojik Danışmanlık ve Rehberlik', 1, '2023-09-01 10:18:21', '2023-09-01 10:18:21'),
(19, 'asdasd', 38, '2023-10-25 10:38:21', '2023-10-25 10:38:21'),
(20, 'qweqwe', 38, '2023-10-25 10:38:21', '2023-10-25 10:38:21'),
(21, 'adad', 38, '2023-10-25 10:38:21', '2023-10-25 10:38:21'),
(22, 'asdasd', 38, '2023-10-25 10:38:21', '2023-10-25 10:38:21');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `expert_infos`
--

CREATE TABLE `expert_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `is_phone` tinyint(1) DEFAULT NULL,
  `is_camera` tinyint(1) DEFAULT NULL,
  `start_hour` time DEFAULT NULL,
  `end_hour` time DEFAULT NULL,
  `appointment_time` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone_price` varchar(255) DEFAULT NULL,
  `chat_price` varchar(255) DEFAULT NULL,
  `camera_price` varchar(255) DEFAULT NULL,
  `is_chat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `expert_infos`
--

INSERT INTO `expert_infos` (`id`, `type_id`, `title`, `about`, `is_phone`, `is_camera`, `start_hour`, `end_hour`, `appointment_time`, `user_id`, `created_at`, `updated_at`, `phone_price`, `chat_price`, `camera_price`, `is_chat`) VALUES
(1, 1, 'Öğretim Üyesi Klinik Psikolog', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis vestibulum nulla condimentum gravida. Nulla leo nisi, aliquet sed commodo sodales, imperdiet ullamcorper ante. Donec nec fringilla lectus. Mauris mi dui, gravida at mauris id, gravida posuere justo. Vestibulum eget consectetur ipsum. Suspendisse molestie vehicula tortor. Aenean eu magna in elit finibus posuere vitae ac erat. Praesent euismod sed tortor id varius. Nunc mattis leo non elit semper varius. Mauris nisl dui, tempor et justo sit amet, gravida egestas arcu. Duis eget elit at erat maximus efficitur id ut purus.', 1, 1, '15:00:00', '19:30:00', '60', 1, NULL, '2023-09-01 11:23:53', '179', '179', '179', '1'),
(2, 1, 'Öğretim Üyesi Klinik Psikolog', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis vestibulum nulla condimentum gravida. Nulla leo nisi, aliquet sed commodo sodales, imperdiet ullamcorper ante. Donec nec fringilla lectus. Mauris mi dui, gravida at mauris id, gravida posuere justo. Vestibulum eget consectetur ipsum. Suspendisse molestie vehicula tortor. Aenean eu magna in elit finibus posuere vitae ac erat. Praesent euismod sed tortor id varius. Nunc mattis leo non elit semper varius. Mauris nisl dui, tempor et justo sit amet, gravida egestas arcu. Duis eget elit at erat maximus efficitur id ut purus.', 0, 0, '00:00:00', NULL, NULL, 2, NULL, NULL, '', '', '', ''),
(3, NULL, NULL, NULL, NULL, NULL, '00:00:00', NULL, NULL, 33, '2023-08-30 13:15:48', '2023-08-30 13:15:48', '', '', '', ''),
(4, 2, 'ben bir uzmanım', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sagittis vestibulum nulla condimentum gravida. Nulla leo nisi, aliquet sed commodo sodales, imperdiet ullamcorper ante. Donec nec fringilla lectus. Mauris mi dui, gravida at mauris id, gravida posuere justo. Vestibulum eget consectetur ipsum. Suspendisse molestie vehicula tortor. Aenean eu magna in elit finibus posuere vitae ac erat. Praesent euismod sed tortor id varius. Nunc mattis leo non elit semper varius. Mauris nisl dui, tempor et justo sit amet, gravida egestas arcu. Duis eget elit at erat maximus efficitur id ut purus.', 1, 1, '09:00:00', '23:00:00', '60', 38, '2023-09-01 11:25:38', '2023-09-01 12:04:41', '179', '179', '179', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `expert_languages`
--

CREATE TABLE `expert_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `expert_languages`
--

INSERT INTO `expert_languages` (`id`, `user_id`, `language_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 25, NULL, NULL),
(3, 2, 25, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `expert_prices`
--

CREATE TABLE `expert_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `expert_sertificates`
--

CREATE TABLE `expert_sertificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `expert_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `expert_types`
--

CREATE TABLE `expert_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `expert_types`
--

INSERT INTO `expert_types` (`id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Psikolog', 1, '2023-08-30 07:12:03', '2023-08-30 07:12:03'),
(2, 'Avukat', 1, '2023-08-30 07:19:04', '2023-08-30 07:19:04');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `failed_jobs`
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
-- Tablo için tablo yapısı `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `status`) VALUES
(1, 'Soru', 'Cevap', 1),
(2, 'Soru', 'Cevap', 1),
(3, 'Soru', 'Cevap', 1),
(4, 'Nasıl randevu alabilirim', 'Dumanla', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` char(49) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `iso_639-1` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Tablo döküm verisi `languages`
--

INSERT INTO `languages` (`id`, `name`, `iso_639-1`) VALUES
(1, 'English', 'US'),
(2, 'Afar', 'aa'),
(3, 'Abkhazian', 'ab'),
(4, 'Afrikaans', 'af'),
(5, 'Amharic', 'am'),
(6, 'Arabic', 'ar'),
(7, 'Assamese', 'as'),
(8, 'Aymara', 'ay'),
(9, 'Azerbaijani', 'az'),
(10, 'Bashkir', 'ba'),
(11, 'Belarusian', 'be'),
(12, 'Bulgarian', 'bg'),
(13, 'Bihari', 'bh'),
(14, 'Bislama', 'bi'),
(15, 'Bengali/Bangla', 'bn'),
(16, 'Tibetan', 'bo'),
(17, 'Breton', 'br'),
(18, 'Catalan', 'ca'),
(19, 'Corsican', 'co'),
(20, 'Czech', 'cs'),
(21, 'Welsh', 'cy'),
(22, 'Danish', 'da'),
(23, 'German', 'de'),
(24, 'Bhutani', 'dz'),
(25, 'Greek', 'el'),
(26, 'Esperanto', 'eo'),
(27, 'Spanish', 'es'),
(28, 'Estonian', 'et'),
(29, 'Basque', 'eu'),
(30, 'Persian', 'fa'),
(31, 'Finnish', 'fi'),
(32, 'Fiji', 'fj'),
(33, 'Faeroese', 'fo'),
(34, 'French', 'fr'),
(35, 'Frisian', 'fy'),
(36, 'Irish', 'ga'),
(37, 'Scots/Gaelic', 'gd'),
(38, 'Galician', 'gl'),
(39, 'Guarani', 'gn'),
(40, 'Gujarati', 'gu'),
(41, 'Hausa', 'ha'),
(42, 'Hindi', 'hi'),
(43, 'Croatian', 'hr'),
(44, 'Hungarian', 'hu'),
(45, 'Armenian', 'hy'),
(46, 'Interlingua', 'ia'),
(47, 'Interlingue', 'ie'),
(48, 'Inupiak', 'ik'),
(49, 'Indonesian', 'in'),
(50, 'Icelandic', 'is'),
(51, 'Italian', 'it'),
(52, 'Hebrew', 'iw'),
(53, 'Japanese', 'ja'),
(54, 'Yiddish', 'ji'),
(55, 'Javanese', 'jw'),
(56, 'Georgian', 'ka'),
(57, 'Kazakh', 'kk'),
(58, 'Greenlandic', 'kl'),
(59, 'Cambodian', 'km'),
(60, 'Kannada', 'kn'),
(61, 'Korean', 'ko'),
(62, 'Kashmiri', 'ks'),
(63, 'Kurdish', 'ku'),
(64, 'Kirghiz', 'ky'),
(65, 'Latin', 'la'),
(66, 'Lingala', 'ln'),
(67, 'Laothian', 'lo'),
(68, 'Lithuanian', 'lt'),
(69, 'Latvian/Lettish', 'lv'),
(70, 'Malagasy', 'mg'),
(71, 'Maori', 'mi'),
(72, 'Macedonian', 'mk'),
(73, 'Malayalam', 'ml'),
(74, 'Mongolian', 'mn'),
(75, 'Moldavian', 'mo'),
(76, 'Marathi', 'mr'),
(77, 'Malay', 'ms'),
(78, 'Maltese', 'mt'),
(79, 'Burmese', 'my'),
(80, 'Nauru', 'na'),
(81, 'Nepali', 'ne'),
(82, 'Dutch', 'nl'),
(83, 'Norwegian', 'no'),
(84, 'Occitan', 'oc'),
(85, '(Afan)/Oromoor/Oriya', 'om'),
(86, 'Punjabi', 'pa'),
(87, 'Polish', 'pl'),
(88, 'Pashto/Pushto', 'ps'),
(89, 'Portuguese', 'pt'),
(90, 'Quechua', 'qu'),
(91, 'Rhaeto-Romance', 'rm'),
(92, 'Kirundi', 'rn'),
(93, 'Romanian', 'ro'),
(94, 'Russian', 'ru'),
(95, 'Kinyarwanda', 'rw'),
(96, 'Sanskrit', 'sa'),
(97, 'Sindhi', 'sd'),
(98, 'Sangro', 'sg'),
(99, 'Serbo-Croatian', 'sh'),
(100, 'Singhalese', 'si'),
(101, 'Slovak', 'sk'),
(102, 'Slovenian', 'sl'),
(103, 'Samoan', 'sm'),
(104, 'Shona', 'sn'),
(105, 'Somali', 'so'),
(106, 'Albanian', 'sq'),
(107, 'Serbian', 'sr'),
(108, 'Siswati', 'ss'),
(109, 'Sesotho', 'st'),
(110, 'Sundanese', 'su'),
(111, 'Swedish', 'sv'),
(112, 'Swahili', 'sw'),
(113, 'Tamil', 'ta'),
(114, 'Telugu', 'te'),
(115, 'Tajik', 'tg'),
(116, 'Thai', 'th'),
(117, 'Tigrinya', 'ti'),
(118, 'Turkmen', 'tk'),
(119, 'Tagalog', 'tl'),
(120, 'Setswana', 'tn'),
(121, 'Tonga', 'to'),
(122, 'Turkish', 'tr'),
(123, 'Tsonga', 'ts'),
(124, 'Tatar', 'tt'),
(125, 'Twi', 'tw'),
(126, 'Ukrainian', 'uk'),
(127, 'Urdu', 'ur'),
(128, 'Uzbek', 'uz'),
(129, 'Vietnamese', 'vi'),
(130, 'Volapuk', 'vo'),
(131, 'Wolof', 'wo'),
(132, 'Xhosa', 'xh'),
(133, 'Yoruba', 'yo'),
(134, 'Chinese', 'zh'),
(135, 'Zulu', 'zu');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `meet_id` varchar(255) NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `messages`
--

INSERT INTO `messages` (`id`, `meet_id`, `sender_id`, `message`, `created_at`, `updated_at`, `seen`, `is_active`) VALUES
(130, 'jo6i-ye7i-htvu', 38, 'asdasd', '2023-10-30 13:10:17', '2023-11-02 06:28:23', 1, 0),
(131, 'jo6i-ye7i-htvu', 34, 'asd', '2023-10-30 13:12:51', '2023-11-02 06:27:32', 1, 0),
(132, 'jo6i-ye7i-htvu', 38, 'qweqwe', '2023-10-30 13:12:57', '2023-11-02 06:28:23', 1, 0),
(133, 'jo6i-ye7i-htvu', 38, 'asdasd', '2023-10-30 13:13:29', '2023-11-02 06:28:23', 1, 0),
(134, 'jo6i-ye7i-htvu', 34, 'asdasd', '2023-10-30 13:13:55', '2023-11-02 06:27:32', 1, 0),
(135, 'jo6i-ye7i-htvu', 38, 'aaa', '2023-10-31 06:24:20', '2023-11-02 06:28:23', 1, 0),
(136, 'jo6i-ye7i-htvu', 34, 'qweqwe', '2023-10-31 06:24:27', '2023-11-02 06:27:32', 1, 0),
(137, 'jo6i-ye7i-htvu', 38, 'aaaa', '2023-10-31 06:24:33', '2023-11-02 06:28:23', 1, 0),
(138, 'jo6i-ye7i-htvu', 38, 'qqq', '2023-10-31 06:24:35', '2023-11-02 06:28:23', 1, 0),
(139, 'jo6i-ye7i-htvu', 38, 'sss', '2023-10-31 06:24:36', '2023-11-02 06:28:23', 1, 0),
(140, 'jo6i-ye7i-htvu', 34, 'bilirim beeen', '2023-10-31 06:27:49', '2023-11-02 06:27:32', 1, 0),
(141, 'jo6i-ye7i-htvu', 34, 'deneme', '2023-10-31 06:28:18', '2023-11-02 06:27:32', 1, 0),
(142, 'jo6i-ye7i-htvu', 34, 'ahahahaa', '2023-10-31 06:28:32', '2023-11-02 06:27:32', 1, 0),
(143, 'jo6i-ye7i-htvu', 34, 'ashlkdasd', '2023-10-31 06:28:40', '2023-11-02 06:27:32', 1, 0),
(144, 'jo6i-ye7i-htvu', 34, 'sdfsdfsdfsdf', '2023-10-31 06:29:17', '2023-11-02 06:27:32', 1, 0),
(145, 'jo6i-ye7i-htvu', 38, 'kes lan', '2023-10-31 06:29:22', '2023-11-02 06:28:23', 1, 0),
(146, 'jo6i-ye7i-htvu', 38, 'asdasd', '2023-10-31 06:31:01', '2023-11-02 06:28:23', 1, 0),
(147, 'jo6i-ye7i-htvu', 38, 'asdasd', '2023-10-31 06:32:05', '2023-11-02 06:28:23', 1, 0),
(148, 'jo6i-ye7i-htvu', 38, 'asdasd', '2023-11-01 12:28:51', '2023-11-02 06:28:23', 1, 0),
(149, 'jo6i-ye7i-htvu', 38, 'asdasd', '2023-11-01 12:31:26', '2023-11-02 06:28:23', 1, 0),
(150, 'jo6i-ye7i-htvu', 38, 'asd', '2023-11-01 12:34:05', '2023-11-02 06:28:23', 1, 0),
(151, 'jo6i-ye7i-htvu', 38, 'qwe', '2023-11-01 12:34:08', '2023-11-02 06:28:23', 1, 0),
(152, 'jo6i-ye7i-htvu', 38, 'fdsf', '2023-11-01 12:34:11', '2023-11-02 06:28:23', 1, 0),
(153, 'jo6i-ye7i-htvu', 38, 'wferfer', '2023-11-01 12:34:13', '2023-11-02 06:28:23', 1, 0),
(154, 'jo6i-ye7i-htvu', 38, 'rthrth', '2023-11-01 12:34:15', '2023-11-02 06:28:23', 1, 0),
(155, 'jo6i-ye7i-htvu', 38, 'adsjaklkjdlasd', '2023-11-01 12:35:22', '2023-11-02 06:28:23', 1, 0),
(156, 'jo6i-ye7i-htvu', 38, 'laskjdkjlasdskjald', '2023-11-01 12:35:34', '2023-11-02 06:28:23', 1, 0),
(157, 'jo6i-ye7i-htvu', 34, 'Deneme', '2023-11-01 12:36:08', '2023-11-02 06:27:32', 1, 0),
(158, 'jo6i-ye7i-htvu', 38, 'asdasd', '2023-11-02 06:26:37', '2023-11-02 06:28:23', 1, 0),
(159, 'jo6i-ye7i-htvu', 34, 'asdasd', '2023-11-02 06:27:10', '2023-11-02 06:27:32', 1, 0),
(160, 'jo6i-ye7i-htvu', 34, 'sfdsf', '2023-11-02 06:27:14', '2023-11-02 06:27:32', 1, 0),
(161, 'jo6i-ye7i-htvu', 34, 'dfgdfg', '2023-11-02 06:27:18', '2023-11-02 06:27:32', 1, 0),
(162, 'jo6i-ye7i-htvu', 34, 'dgfg', '2023-11-02 06:27:30', '2023-11-02 06:27:32', 1, 0),
(163, '5l5s-b9s3-p0qw', 38, 'aaa', '2023-11-05 12:24:36', '2023-11-05 12:25:03', 1, 0),
(164, '5l5s-b9s3-p0qw', 34, 'qqqq', '2023-11-05 12:24:50', '2023-11-05 12:25:05', 1, 0),
(165, '5l5s-b9s3-p0qw', 38, 'sus laaa', '2023-11-05 12:24:54', '2023-11-05 12:25:03', 1, 0),
(166, '5l5s-b9s3-p0qw', 38, 'qqq', '2023-11-05 12:25:02', '2023-11-05 12:25:03', 1, 0),
(167, '5l5s-b9s3-p0qw', 34, 'ssss', '2023-11-05 12:25:05', '2023-11-05 12:25:05', 1, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_08_29_171719_create_expert_prices_table', 1),
(6, '2023_08_29_171856_create_expert_infos_table', 1),
(7, '2023_08_29_173551_create_ratings_table', 1),
(8, '2023_08_29_175414_create_expert_types_table', 1),
(9, '2023_08_30_125510_create_expert_languages_table', 2),
(10, '2023_08_30_144503_create_appointments_table', 3),
(16, '2023_08_30_145318_user_add_columns', 4),
(17, '2023_08_30_161333_nullable_columns_on_expert_infos', 5),
(18, '2023_08_31_090002_appointment_columns_add', 6),
(19, '2016_06_01_000001_create_oauth_auth_codes_table', 7),
(20, '2016_06_01_000002_create_oauth_access_tokens_table', 7),
(21, '2016_06_01_000003_create_oauth_refresh_tokens_table', 7),
(22, '2016_06_01_000004_create_oauth_clients_table', 7),
(23, '2016_06_01_000005_create_oauth_personal_access_clients_table', 7),
(24, '2023_09_01_125816_create_expert_education_table', 8),
(25, '2023_09_01_125849_create_expert_sertificates_table', 8),
(26, '2023_09_04_101539_create_faqs_table', 9),
(28, '2023_09_04_112452_create_certificates_table', 10),
(31, '2023_09_04_130519_create_site_settings_table', 11),
(32, '2023_09_23_154445_create_pages_table', 12),
(33, '2023_10_28_182734_create_messages_table', 12),
(34, '2023_10_30_122914_add_seen_user_is_active_columns_to_messages', 13),
(36, '2023_11_02_073611_create_notes_table', 14);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `note` text NOT NULL,
  `expert_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `notes`
--

INSERT INTO `notes` (`id`, `note`, `expert_id`, `user_id`, `created_at`, `updated_at`) VALUES
(72, 'asdasdasd', 38, 34, '2023-11-02 07:05:31', '2023-11-02 07:05:31'),
(76, 'Ahahaha', 38, 34, '2023-11-05 12:03:48', '2023-11-05 12:03:48'),
(77, 'asdasd', 38, 34, '2023-11-05 12:04:05', '2023-11-05 12:04:05'),
(78, 'asdasd', 38, 34, '2023-11-05 12:04:35', '2023-11-05 12:04:35');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0247b32462763d7d7b850101cf7da3d717e8f438df8793715140c9d0764d78b30cc22c330676ba8e', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-10-29 09:48:12', '2023-10-29 09:48:12', '2024-10-29 12:48:12'),
('06c956293cea26411d977a82b3b416c9e894987af6ed8617806c7a92b98590011f484fd03f552d40', 34, 1, 'Laravel Password Grant Client', '[]', 0, '2023-10-25 10:29:24', '2023-10-25 10:29:24', '2024-10-25 13:29:24'),
('10d53c7be9ea6b7fde816daf68ae074c96e27caf1f0aeb68546b724cbbafde632d8c5ce23f22509b', 29, 1, 'Laravel Password Grant Client', '[]', 0, '2023-08-31 11:52:32', '2023-08-31 11:52:32', '2024-08-31 14:52:32'),
('119f2577c053a89c2f16a451b3210d0d52228df90a670ed513f605a1da12bbb8b1f05e0865563652', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-01 11:26:46', '2023-09-01 11:26:46', '2024-09-01 14:26:46'),
('18a15b3f6a43320666163dc4f375f086c37f3385dc874e0bf3100d4239028dd2c48151ef5f5549ff', 29, 1, 'Laravel Password Grant Client', '[]', 0, '2023-08-31 10:10:30', '2023-08-31 10:10:30', '2024-08-31 13:10:30'),
('2631e5c933893ae18e39b2a5edaa3ad7c3d7c4587ba24a65e3bf6ce9e80d6a22c7b2026f2025998b', 34, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-01 08:56:00', '2023-09-01 08:56:00', '2024-09-01 11:56:00'),
('2d9497840a53026f5265369826f6f9ca013c3364784d50e6ea3283f091e536c8c193e978d40edf54', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-04 07:04:48', '2023-09-04 07:04:48', '2024-09-04 10:04:48'),
('2f2a2fa2e934c56e8e93ed9666c8693d6de9b93e95eb249fe167e20dc0dbee4ab9a24ed8f4d4b417', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-10-28 11:06:39', '2023-10-28 11:06:39', '2024-10-28 14:06:39'),
('3dd9e2bc8960b128aa271db273bd22eea74306963f574ad25b31e4e1fbbec99de5581f3829599c82', 29, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-01 08:09:24', '2023-09-01 08:09:24', '2024-09-01 11:09:24'),
('46aadcdadfec105d2851751d62ba3b2d195589ae54e22e43403330774d370346505f644597270574', 34, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-05 11:43:44', '2023-09-05 11:43:44', '2024-09-05 14:43:44'),
('497f9777eda65c3ba02b39b81bed93402497ee91676d00d52e36e8890c694192cc6beec866d9c0dd', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-10-25 10:31:09', '2023-10-25 10:31:09', '2024-10-25 13:31:09'),
('6664bc18cde532dbb80b6e28b8e519c4d9ed4ceb103702c0874bc88cad3cdb9426bc471cc3bf407a', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-01 12:03:55', '2023-09-01 12:03:55', '2024-09-01 15:03:55'),
('67b893b770f84fc86cdb70108dc5ddff27d1bf08446f3af12b70e090dea739dc27f5e541a5ae3c0e', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-05 11:44:02', '2023-09-05 11:44:02', '2024-09-05 14:44:02'),
('79270ced54548e24e6cc6f51e4e4a7634af485674800b7da724ffd94d83a5bb1020c27d1ab26f7ae', 1, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-01 11:05:22', '2023-09-01 11:05:23', '2024-09-01 14:05:22'),
('79d09b2cec7a904851f4bde6b5c41b3d3e610c1b3df7a8c34288fdce9721e0850acda0fe72047a45', 29, 1, 'Laravel Password Grant Client', '[]', 0, '2023-08-31 16:00:48', '2023-08-31 16:00:48', '2024-08-31 19:00:48'),
('7a670a0f22f9d40e03abf42e7de5f09f4547fef06cf79086bd0baeaeba5ac766c2761f64173480fb', 29, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-01 07:48:09', '2023-09-01 07:48:09', '2024-09-01 10:48:09'),
('7e6607053a9863d97e12b063af1b9acd85dba0151658b9448bef938903f548073d6d97f192666e95', 34, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-01 11:41:40', '2023-09-01 11:41:40', '2024-09-01 14:41:40'),
('7f834fef3c594c87e4b928bd066222f13add1398fd742004e86d4dd5f732dd4d4cf0467144b1179f', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-01 11:40:59', '2023-09-01 11:40:59', '2024-09-01 14:40:59'),
('82adf7946d821a0b5f618d7af8b58a14bdd59eecb9d76f49f77f5fdf8340a8c4c1c629cc4f961153', 29, 1, 'Laravel Password Grant Client', '[]', 0, '2023-08-31 10:10:45', '2023-08-31 10:10:45', '2024-08-31 13:10:45'),
('87a13e7a69408f6cb08405bcfc544c23405bf1d42f569c9735f921b4df752809b17f8bedd7596ebc', 34, 1, 'Laravel Password Grant Client', '[]', 0, '2023-11-01 12:28:42', '2023-11-01 12:28:42', '2024-11-01 15:28:42'),
('9e4aececde67ffe16eabf6aa492edec89a7371b501159ab56d8f922b0ef58e293cea9be500b294d7', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-23 12:24:53', '2023-09-23 12:24:53', '2024-09-23 15:24:53'),
('aa19755e41976e492c64fc099df52a95b33c14439ca21b8dcef1e8d7d7dc6499ae76df80205db6d7', 1, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-01 08:56:36', '2023-09-01 08:56:36', '2024-09-01 11:56:36'),
('b266552978d53276533b8a2467ddfcc0ab99412b6fe6f7016de4e5f911869fb6b6962febcf387138', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-10-25 10:36:23', '2023-10-25 10:36:23', '2024-10-25 13:36:23'),
('b8420c521e859911eb99b0214ae4fd1f5d905fb74d3b012a567958dfe890618b5ceb66d244fdce40', 34, 1, 'Laravel Password Grant Client', '[]', 0, '2023-11-05 12:17:56', '2023-11-05 12:17:56', '2024-11-05 15:17:56'),
('b92229d8dce2bdd9fa95339873476aa21054edf678b076758268d527acfd5757de41fb92b38781b2', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-11-01 12:26:55', '2023-11-01 12:26:55', '2024-11-01 15:26:55'),
('b9ac06ff4274f25fe668fc948b5e1ba6b8d15bf2eace7c74e24704754e643fc2f4d852061a597429', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-23 10:56:17', '2023-09-23 10:56:17', '2024-09-23 13:56:17'),
('caea5c6da6f16ed83817bf38336ca760ed8858f84be83e358c4d9c37a2bb7ea8ebe8b7860f052170', 1, 1, 'Laravel Password Grant Client', '[]', 0, '2023-08-31 10:44:24', '2023-08-31 10:44:24', '2024-08-31 13:44:24'),
('cd4bd49deb2f48d6d55b93e82d43969e035bf2235011513e588aeafc5842317ea7430cda683fcec0', 1, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-01 09:47:36', '2023-09-01 09:47:36', '2024-09-01 12:47:36'),
('d27be62b5d2ab7afb3134218285af05c36c81c96d2c2ef3ee8ce136e52b5da31f3161c8c08aaa683', 34, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-23 11:55:00', '2023-09-23 11:55:00', '2024-09-23 14:55:00'),
('d3447126c28062cc82d5eced48f9b1901a4af1dd004d0b4b61776deba76496962917abc832fe37cf', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-04 08:31:39', '2023-09-04 08:31:39', '2024-09-04 11:31:39'),
('e17cfaccc9f9fea2b388e7a8925f6babcf13d4fcd7bc55612771d87dc4b88498ce1148cff8ee08c7', 34, 1, 'Laravel Password Grant Client', '[]', 0, '2023-09-04 11:35:48', '2023-09-04 11:35:48', '2024-09-04 14:35:48'),
('f685e268bc62328cdb2aaacdd997ba4fce1f500258dfcee559ec96398b8c1d2f34ca3bb1d1fedfe4', 38, 1, 'Laravel Password Grant Client', '[]', 0, '2023-10-25 10:30:26', '2023-10-25 10:30:26', '2024-10-25 13:30:26');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', '2IH2Vh74PXMHyEQ1nXbHu5PHfFTTSHKATjUleAtw', NULL, 'http://localhost', 1, 0, 0, '2023-08-31 10:05:11', '2023-08-31 10:05:11'),
(2, NULL, 'Laravel Password Grant Client', '3csIjQuAVMmJJCdurlHG0IrBrvVLLKOI3zsrTzhm', 'users', 'http://localhost', 0, 1, 0, '2023-08-31 10:05:11', '2023-08-31 10:05:11');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-08-31 10:05:11', '2023-08-31 10:05:11');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personal_access_tokens`
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

--
-- Tablo döküm verisi `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'api-token', '5333f9ff69fbf066d961f56df57243028bf89e1f09c0718ebe7cb0ddf95397fb', '[\"*\"]', NULL, NULL, '2023-08-30 11:15:51', '2023-08-30 11:15:51'),
(2, 'App\\Models\\User', 2, 'api-token', '86e6c71cb95bf633ddc2d8cf60a00d6685094ca360ee4fb4d3b7db01e2986875', '[\"*\"]', NULL, NULL, '2023-08-30 11:25:43', '2023-08-30 11:25:43'),
(3, 'App\\Models\\User', 2, 'api-token', '2c53ab0d44e984839593ab0039379afb40b7b1a20aceca507fa3fa6822726990', '[\"*\"]', NULL, NULL, '2023-08-30 11:40:08', '2023-08-30 11:40:08'),
(4, 'App\\Models\\User', 26, 'api-token', '266ea8eebdb6d912a21cbcf2552b261d0893480afc8e9e2819a443ad588557a0', '[\"*\"]', NULL, NULL, '2023-08-30 13:05:28', '2023-08-30 13:05:28'),
(5, 'App\\Models\\User', 1, 'api-token', 'efde06eaeaf84faabfd50055e56fb636c2f19cc2593d38d0783884e7987010c8', '[\"*\"]', NULL, NULL, '2023-08-30 13:05:57', '2023-08-30 13:05:57'),
(6, 'App\\Models\\User', 26, 'api-token', '91e4ce7a648dfa4332a0cdf461fa6cc3ba1a1c1788cfc430813740c94d69384f', '[\"*\"]', NULL, NULL, '2023-08-30 13:06:13', '2023-08-30 13:06:13'),
(7, 'App\\Models\\User', 28, 'api-token', '01f4638e7bb055375ded4b61babd9a286c99023b6cb4e5517e17051269bb46e6', '[\"*\"]', NULL, NULL, '2023-08-30 13:11:48', '2023-08-30 13:11:48'),
(8, 'App\\Models\\User', 1, 'api-token', 'aea8b8dd99d9230a2186530f35d1209f0b8026b4a7e19e0fe6ab6f73273d2465', '[\"*\"]', NULL, NULL, '2023-08-31 05:48:23', '2023-08-31 05:48:23'),
(9, 'App\\Models\\User', 29, 'api-token', '9254eb4789d72c9ed8be853a38847316b9f083405f0a0d19aa7fd3e844bb6481', '[\"*\"]', NULL, NULL, '2023-08-31 06:13:19', '2023-08-31 06:13:19'),
(10, 'App\\Models\\User', 29, 'api-token', '2aa7894da6991d1efc5004ff1a7df67467fb8f3c23c32fd6a32fc96923df6bbb', '[\"*\"]', NULL, NULL, '2023-08-31 06:13:44', '2023-08-31 06:13:44'),
(11, 'App\\Models\\User', 29, 'api-token', '15d0fc6a70a83b14a1cf88c54f2c8d9a3a66a313c9a68bdbd5b871cc350fa9b6', '[\"*\"]', NULL, NULL, '2023-08-31 09:57:36', '2023-08-31 09:57:36'),
(12, 'App\\Models\\User', 29, 'api-token', 'e4d2980ad5018ce719c4c78a14ad6a85605d6c4d3b0fc5af22c4a535162ede76', '[\"*\"]', NULL, NULL, '2023-08-31 09:58:18', '2023-08-31 09:58:18'),
(13, 'App\\Models\\User', 29, 'api-token', 'cb0e2b7dea2e07fdca54737d695a45e9d2104e7854031928f6df6fcf94687dcb', '[\"*\"]', NULL, NULL, '2023-08-31 09:59:54', '2023-08-31 09:59:54'),
(14, 'App\\Models\\User', 29, 'api-token', '840ba5581ef460b6c2065d4767906e85d7b873f6c7c925c397b81874231c6d0a', '[\"*\"]', NULL, NULL, '2023-08-31 10:00:17', '2023-08-31 10:00:17'),
(15, 'App\\Models\\User', 29, 'Laravel Password Grant Client', 'ca38213abc97604f38ba4f9601df4cfb22fcf0c6a989034417be86bc94ad4459', '[\"*\"]', NULL, NULL, '2023-08-31 10:06:38', '2023-08-31 10:06:38');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reviewer_id` bigint(20) UNSIGNED NOT NULL,
  `expert_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `text` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `ratings`
--

INSERT INTO `ratings` (`id`, `reviewer_id`, `expert_id`, `rating`, `text`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 'asd', 1, NULL, NULL),
(2, 1, 1, 1, 'asd', 0, NULL, NULL),
(3, 38, 38, 3, 'asd', 0, '2023-09-23 11:18:48', '2023-09-23 11:18:48'),
(4, 38, 38, 3, 'asd', 0, '2023-09-23 11:19:20', '2023-09-23 11:19:20'),
(5, 38, 38, 2, 'asdasd', 0, '2023-09-23 11:19:42', '2023-09-23 11:19:42'),
(6, 38, 38, 3, 'asdasdasd', 0, '2023-09-23 11:20:14', '2023-09-23 11:20:14'),
(7, 38, 38, 3, 'deneme', 0, '2023-09-23 11:20:28', '2023-09-23 11:20:28'),
(8, 38, 38, 3, 'asdasd', 0, '2023-09-23 11:24:35', '2023-09-23 11:24:35'),
(9, 38, 38, 2, 'asdasdasd', 0, '2023-09-23 11:24:57', '2023-09-23 11:24:57'),
(10, 38, 38, 2, 'asdasdasdasd', 0, '2023-09-23 11:25:35', '2023-09-23 11:25:35'),
(11, 38, 38, 3, 'asdasdasdasdasd', 0, '2023-09-23 11:26:10', '2023-09-23 11:26:10'),
(12, 38, 38, 4, 'asdasdasdasdasd123', 0, '2023-09-23 11:26:27', '2023-09-23 11:26:27'),
(13, 38, 38, 3, 'asdasd', 0, '2023-09-23 11:36:42', '2023-09-23 11:36:42'),
(14, 38, 38, 3, 'asdasd', 0, '2023-09-23 11:38:23', '2023-09-23 11:38:23'),
(15, 38, 38, 2, 'asdasd', 0, '2023-09-23 11:39:04', '2023-09-23 11:39:04'),
(16, 38, 38, 3, 'asdasd', 0, '2023-09-23 11:39:17', '2023-09-23 11:39:17'),
(17, 38, 38, 3, 'asddasdasd', 0, '2023-09-23 11:40:02', '2023-09-23 11:40:02'),
(18, 34, 1, 3, 'asdasd', 0, '2023-09-23 11:55:49', '2023-09-23 11:55:49');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `site_logo` varchar(255) NOT NULL,
  `site_footer_logo` varchar(255) NOT NULL,
  `site_footer_description` text NOT NULL,
  `anasayfa_1_baslik` varchar(255) NOT NULL,
  `anasayfa_1_alt_yazi` varchar(255) NOT NULL,
  `anasayfa_1_buton_yazi` varchar(255) NOT NULL,
  `anasayfa_1_1_resim` varchar(255) NOT NULL,
  `anasayfa_1_2_resim` varchar(255) NOT NULL,
  `anasayfa_1_3_resim` varchar(255) NOT NULL,
  `anasayfa_2_sol_resim` varchar(255) NOT NULL,
  `anasayfa_2_sag_1_yazi` varchar(255) NOT NULL,
  `anasayfa_2_sag_2_yazi` varchar(255) NOT NULL,
  `anasayfa_2_sag_3_yazi` varchar(255) NOT NULL,
  `anasayfa_2_sag_4_yazi` varchar(255) NOT NULL,
  `anasayfa_3_baslik` varchar(255) NOT NULL,
  `anasayfa_3_alt_baslik` varchar(255) NOT NULL,
  `anasayfa_4_sol_baslik` varchar(255) NOT NULL,
  `anasayfa_4_sol_buton` varchar(255) NOT NULL,
  `anasayfa_4_sag_resim` varchar(255) NOT NULL,
  `anasayfa_5_baslik` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_title`, `site_logo`, `site_footer_logo`, `site_footer_description`, `anasayfa_1_baslik`, `anasayfa_1_alt_yazi`, `anasayfa_1_buton_yazi`, `anasayfa_1_1_resim`, `anasayfa_1_2_resim`, `anasayfa_1_3_resim`, `anasayfa_2_sol_resim`, `anasayfa_2_sag_1_yazi`, `anasayfa_2_sag_2_yazi`, `anasayfa_2_sag_3_yazi`, `anasayfa_2_sag_4_yazi`, `anasayfa_3_baslik`, `anasayfa_3_alt_baslik`, `anasayfa_4_sol_baslik`, `anasayfa_4_sol_buton`, `anasayfa_4_sag_resim`, `anasayfa_5_baslik`, `created_at`, `updated_at`) VALUES
(1, 'aasd12', 'uploads/64f5e8b0e981a.png', 'uploads/64f5e8d743e83.png', 'asd', 'İhtiyaç duyduğunuz kişilerle online görüşme Artık her şey bir tık uzağında', 'Terapinin en kolay haliyle tanışma vakti! Hemen psikolog                   seçerek istediğiniz yerden, istediğiniz şekilde bağlanın.                     Online terapi                   ile sorunlardan kurtularak mutlu bir hayata adım atın!', 'asd', 'uploads/64f70c05c79d5.png', 'uploads/64f5e1304f888.png', 'uploads/64f5e1304fa69.png', 'uploads/64f5e1304fc75.png', 'Alanında Uzman Kişiler', '7/24 Ulaşılabilir', 'İade Garantili', '100% Güvenilir', 'İhtiyacına Uygun Uzmanı Seç', 'Tüm Psikologları Gör', 'Metaverse Psikolojik  Danışmanlık Hizmetimiz  ÇOK YAKINDA  Sizlerle', 'Şimdi Keşfet', 'uploads/64f70be2b1731.png', 'Sık Sorulan Sorular', NULL, '2023-09-05 08:07:49');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `birth_date` date NOT NULL DEFAULT '2023-12-12',
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `email_token` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `expert_documentation` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `birth_date`, `email`, `email_verified_at`, `email_token`, `password`, `type`, `expert_documentation`, `remember_token`, `created_at`, `updated_at`, `status`, `phone`) VALUES
(1, 'Abdurrahman İslamoğlu', 'b2fona', '2023-12-12', 'islamoglu.abd@gmail.com', NULL, NULL, '$2y$10$hTfn9kIubSAFLjTilC3Eau9pEAtUiKoISID0CNLxWAqo87/k06syO', 2, NULL, NULL, '2023-08-30 06:52:49', '2023-09-05 09:05:04', 1, '05511083652'),
(2, 'aykut', '', '2023-12-12', 'aykut.altnsk@gmail.com', NULL, NULL, '$2y$10$hTfn9kIubSAFLjTilC3Eau9pEAtUiKoISID0CNLxWAqo87/k06syO', 2, NULL, NULL, '2023-08-30 11:25:36', '2023-09-05 09:05:32', 1, NULL),
(22, 'Abdurrahman İslamoğlu', '', '2023-12-12', 'islamoglu.abd@gmail.com1', NULL, NULL, '$2y$10$TJ/QWq55F/DkQAtmiuQLP.41xTDX9SbDi39sU33UmItSbXfnzZGy6', 1, NULL, NULL, '2023-08-30 12:39:22', '2023-08-30 12:39:22', 0, NULL),
(23, 'Abdurrahman İslamoğlu', '', '2023-12-12', 'islamoglu.abd@gmail.com3', NULL, NULL, '$2y$10$t/UTPCPToxcZjdBX7gkcx.ka1BXlTGvCJQgoKDML8ztDvRpIJtBmK', 1, NULL, NULL, '2023-08-30 12:40:43', '2023-08-30 12:40:43', 0, NULL),
(24, 'Abdurrahman İslamoğlu', '', '2023-12-12', 'islamoglu.abd@gmail.com123', NULL, NULL, '$2y$10$TOE9tpfd.yeG4jZ.mCj4aOH0gqlI87Sl1oUkhqdHqpFHFOjwsRRQy', 1, NULL, NULL, '2023-08-30 12:42:30', '2023-08-30 12:42:30', 0, NULL),
(25, 'Abdurrahman İslamoğlu', '', '2023-12-12', 'islamoglu.abd@gmail.com1234', NULL, NULL, '$2y$10$91rKvr6dKR5w61dn9rxGKu6W0w30l7FTkr65Ebms9FWKtzTTJ0W8a', 1, NULL, NULL, '2023-08-30 12:58:08', '2023-09-05 09:04:00', 0, NULL),
(26, 'Abdurrahman İslamoğlu', 'b1fona', '1233-03-12', 'islamoglu.abd@gmail.com12345', NULL, 'YjFmb25h', '$2y$10$hTfn9kIubSAFLjTilC3Eau9pEAtUiKoISID0CNLxWAqo87/k06syO', 1, NULL, NULL, '2023-08-30 13:02:54', '2023-09-05 09:01:40', 1, NULL),
(27, 'asd asd', 'b1fona', '1233-03-12', 'islamoglu.abd@gmail.com1231231234', NULL, 'YjFmb25h', '$2y$10$0FywLCaPv.Sf8uX8KyWyVOUjdjKFwHVcXOPTs9x1vQl4XW3uXGTC2', 1, NULL, NULL, '2023-08-30 13:09:13', '2023-09-05 09:02:38', 1, NULL),
(28, 'Aykut Altunışık 1', 'malaykut', '1997-12-12', 'malaykut@gmail.com', NULL, 'bWFsYXlrdXQ=', '$2y$10$TR/rA5HUowE1j72MucyxUOCwUzpJi.xC2CGglTN3nUXKExDwVnYsa', 1, NULL, NULL, '2023-08-30 13:11:25', '2023-09-05 09:00:57', 1, NULL),
(29, 'Aykut Altunışık 1', 'aykut', '1234-03-12', 'topaykut@gmail.com', NULL, 'YXlrdXQ=', '$2y$10$hTfn9kIubSAFLjTilC3Eau9pEAtUiKoISID0CNLxWAqo87/k06syO', 1, NULL, NULL, '2023-08-30 13:12:36', '2023-08-30 13:17:29', 1, NULL),
(31, 'Aykut Altunışık 1', 'aykut', '1234-03-12', 'topaykut@gmail.com1', NULL, 'YXlrdXQ=', '$2y$10$5HsVZ8px47ep42Vs/7fnYOvU8ti5km6nJb0RcEbgDopPqyAIGtmTG', 2, NULL, NULL, '2023-08-30 13:12:51', '2023-08-30 13:17:29', 1, NULL),
(32, 'Aykut Altunışık 1', 'aykut', '1234-03-12', 'topaykut@gmail.com12', NULL, 'YXlrdXQ=', '$2y$10$S4kYCQ.zhBTi04bBe7A6JejT88D8LBQWN6G7Wp7pKEi0VyWayMpk.', 2, NULL, NULL, '2023-08-30 13:13:10', '2023-08-30 13:17:29', 1, NULL),
(33, 'Aykut Altunışık 1', 'aykut', '1234-03-12', 'topaykut@gmail.com123', NULL, 'YXlrdXQ=', '$2y$10$vV7nGL5FZXoOA8m0k/HYWeHDmDVfc20.Bp7VZgAW.l24djS7gNDL6', 2, NULL, NULL, '2023-08-30 13:15:48', '2023-08-30 13:17:29', 1, NULL),
(34, 'Zehra Sena Akgül', 'zehra', '2001-02-20', 'zehrasena@gmail.com', NULL, 'emVocmE=', '$2y$10$Lpu2BYtXXZrSir34/KR98e28Sm8gWed0yvp9NzFjGWeq6L1wYP5Om', 1, NULL, NULL, '2023-09-01 08:55:23', '2023-09-01 08:55:53', 1, NULL),
(38, 'Uzman Uzman', 'uzman', '2001-02-20', 'uzman@uzman.com', NULL, 'dXptYW4=', '$2y$10$hTfn9kIubSAFLjTilC3Eau9pEAtUiKoISID0CNLxWAqo87/k06syO', 2, NULL, NULL, '2023-09-01 11:25:38', '2023-09-05 11:29:38', 1, '05511083652');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `expert_education`
--
ALTER TABLE `expert_education`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `expert_infos`
--
ALTER TABLE `expert_infos`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `expert_languages`
--
ALTER TABLE `expert_languages`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `expert_prices`
--
ALTER TABLE `expert_prices`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `expert_sertificates`
--
ALTER TABLE `expert_sertificates`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `expert_types`
--
ALTER TABLE `expert_types`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Tablo için indeksler `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Tablo için indeksler `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Tablo için indeksler `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Tablo için indeksler `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Tablo için indeksler `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Tablo için indeksler `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Tablo için indeksler `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Tablo için AUTO_INCREMENT değeri `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Tablo için AUTO_INCREMENT değeri `expert_education`
--
ALTER TABLE `expert_education`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Tablo için AUTO_INCREMENT değeri `expert_infos`
--
ALTER TABLE `expert_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `expert_languages`
--
ALTER TABLE `expert_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `expert_prices`
--
ALTER TABLE `expert_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `expert_sertificates`
--
ALTER TABLE `expert_sertificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `expert_types`
--
ALTER TABLE `expert_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- Tablo için AUTO_INCREMENT değeri `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- Tablo için AUTO_INCREMENT değeri `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Tablo için AUTO_INCREMENT değeri `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Tablo için AUTO_INCREMENT değeri `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Tablo için AUTO_INCREMENT değeri `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
