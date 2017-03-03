-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2017 at 12:35 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `media`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(10) UNSIGNED NOT NULL,
  `home_top_ad_code` text COLLATE utf8_unicode_ci NOT NULL,
  `home_top_ad_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `home_side_ad_code` text COLLATE utf8_unicode_ci NOT NULL,
  `home_side_ad_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `media_top_ad_code` text COLLATE utf8_unicode_ci NOT NULL,
  `media_top_ad_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `media_bottom_ad_code` text COLLATE utf8_unicode_ci NOT NULL,
  `media_bottom_ad_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `home_top_ad_code`, `home_top_ad_img`, `home_side_ad_code`, `home_side_ad_img`, `media_top_ad_code`, `media_top_ad_img`, `media_bottom_ad_code`, `media_bottom_ad_img`) VALUES
(1, 'adsense code here', '', '', 'https://placeholdit.imgix.net/~text?txtsize=33&txt=350%C3%97250&w=350&h=250', 'adsense code here', '', 'adsense code here', '');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'demo', '2017-02-28 07:15:40', '2017-02-28 07:15:40');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments_flags`
--

CREATE TABLE `comments_flags` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(10) UNSIGNED NOT NULL,
  `short_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '1',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `is_video` int(11) NOT NULL DEFAULT '0',
  `is_picture` int(11) NOT NULL DEFAULT '1',
  `pic_url` text COLLATE utf8_unicode_ci,
  `vid_url` text COLLATE utf8_unicode_ci,
  `vid_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vid_img` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `short_url`, `user_id`, `category_id`, `title`, `description`, `active`, `is_video`, `is_picture`, `pic_url`, `vid_url`, `vid_type`, `vid_img`, `created_at`, `updated_at`) VALUES
(2, '9tU39nJiGRVwLgq', 1, 1, 'skyrim demo', 'sdfsdfsdf', 1, 1, 0, NULL, 'youtube.com/watch?v=w1AenlOEXao', 'youtube', 'http://img.youtube.com/vi/w1AenlOEXao/0.jpg', '2017-02-28 08:01:33', '2017-02-28 08:01:33');

-- --------------------------------------------------------

--
-- Table structure for table `media_flags`
--

CREATE TABLE `media_flags` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_likes`
--

CREATE TABLE `media_likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_views`
--

CREATE TABLE `media_views` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `media_id` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `media_views`
--

INSERT INTO `media_views` (`id`, `ip_address`, `media_id`, `views`, `created_at`, `updated_at`) VALUES
(1, '::1', 1, 1, '2017-02-28 07:40:57', '2017-02-28 07:40:57'),
(2, '::1', 2, 1, '2017-02-28 08:03:06', '2017-02-28 08:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2016_10_12_000000_create_users_table', 1),
('2016_10_12_100000_create_password_resets_table', 1),
('2016_02_13_210541_create_categories_table', 1),
('2016_02_16_114551_create_settings_table', 1),
('2016_02_20_132008_create_media_table', 1),
('2016_02_21_154224_create_pages_table', 1),
('2016_02_22_125448_create_ads_table', 1),
('2016_02_24_210723_create_stats_table', 1),
('2016_02_25_155349_create_comments_table', 1),
('2016_02_25_185424_create_media_likes_table', 1),
('2016_02_25_200733_create_media_flags_table', 1),
('2016_02_25_202306_create_comments_flags_table', 1),
('2016_02_26_122950_create_media_views_table', 1),
('2016_02_28_133130_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `page_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `content`, `page_url`, `created_at`, `updated_at`) VALUES
(1, 'demo', '<p>demo</p>\r\n', 'demo', '2017-02-28 07:19:16', '2017-02-28 07:19:16'),
(2, 'Privacy Policy', '<p>Privacy Policy</p>\r\n', 'Policy', '2017-02-28 20:28:06', '2017-02-28 20:28:06'),
(3, 'About', '<p>about</p>\r\n', 'about', '2017-02-28 20:28:25', '2017-02-28 20:28:25');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `website_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adblock_detecting` int(11) NOT NULL,
  `auto_approve_comments` int(11) NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'nologo.png',
  `favicon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'nofavicon.png',
  `facebook_page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `google_page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auto_approve_posts` int(11) NOT NULL,
  `paginate` int(11) NOT NULL DEFAULT '9',
  `recaptcha` int(11) NOT NULL DEFAULT '0',
  `allow_vid_up` int(11) NOT NULL DEFAULT '0',
  `max_vid_mb` int(11) NOT NULL DEFAULT '100',
  `max_img_mb` int(11) NOT NULL DEFAULT '3',
  `theme` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'dark',
  `anonymous` int(11) NOT NULL DEFAULT '0',
  `adfly` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `website_name`, `website_description`, `title_description`, `website_keywords`, `website_email`, `adblock_detecting`, `auto_approve_comments`, `logo`, `favicon`, `facebook_page_id`, `google_page_id`, `twitter_page_id`, `auto_approve_posts`, `paginate`, `recaptcha`, `allow_vid_up`, `max_vid_mb`, `max_img_mb`, `theme`, `anonymous`, `adfly`, `created_at`, `updated_at`) VALUES
(1, 'title here', 'add seo', 'description here', '', 'admin@admin.com', 0, 0, 'nologo.png', 'nofavicon.png', 'https://www.facebook.com/', 'https://www.twitter.com/', 'https://plus.google.com/', 0, 9, 1, 0, 100, 10, 'brown', 0, 0, '2016-03-26 00:00:00', '2017-02-28 20:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `browser` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `platform` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `device` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`id`, `ip_address`, `country_code`, `country_name`, `browser`, `platform`, `device`, `created_at`, `updated_at`) VALUES
(1, '::1', 'unknown', 'unknown', 'Chrome', 'Unknown OS Platform', 'Computer', '2017-03-02 16:08:16', '2017-03-02 16:08:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'noavatar.jpg',
  `cover` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'nocover.jpg',
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `facebook_profile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_profile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `avatar`, `cover`, `facebook_id`, `twitter_id`, `google_id`, `status`, `level`, `facebook_profile`, `twitter_profile`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$9F0HLMvn0BkO3a.CN09s/efH2dnLPIXsE5jNCy45.Nu.sq1ARgWUm', 'noavatar.jpg', 'nocover.jpg', NULL, NULL, NULL, 0, 1, '', '', 'dqoDm3f9jV1BAedyaijO6FZbketzU3lGEYbJa53ssDG5f0AiyGZOZJfo8nJT', '2016-03-29 18:04:49', '2017-03-01 16:35:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments_flags`
--
ALTER TABLE `comments_flags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_flags`
--
ALTER TABLE `media_flags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_likes`
--
ALTER TABLE `media_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_views`
--
ALTER TABLE `media_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_facebook_id_unique` (`facebook_id`),
  ADD UNIQUE KEY `users_twitter_id_unique` (`twitter_id`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments_flags`
--
ALTER TABLE `comments_flags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `media_flags`
--
ALTER TABLE `media_flags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `media_likes`
--
ALTER TABLE `media_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `media_views`
--
ALTER TABLE `media_views`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stats`
--
ALTER TABLE `stats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
