-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2020-10-17 14:59:27
-- サーバのバージョン： 10.4.14-MariaDB
-- PHP のバージョン: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `athletenote`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `contents`
--

CREATE TABLE `contents` (
  `contentID` varchar(255) NOT NULL,
  `content1` varchar(255) DEFAULT NULL,
  `content2` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `contents`
--

INSERT INTO `contents` (`contentID`, `content1`, `content2`, `created_at`, `updated_at`) VALUES
('kou4809292020-10-03', '..\\..\\ContentsFolder\\user_kou480929\\2020-10-03\\content1.jpg', '..\\..\\ContentsFolder\\user_kou480929\\2020-10-03\\content2.jpg', '2020-10-03 14:07:07', '2020-10-03 23:07:07'),
('kou4809292020-10-04', NULL, NULL, '2020-10-04 13:32:26', '2020-10-04 22:32:26');

-- --------------------------------------------------------

--
-- テーブルの構造 `guestuser`
--

CREATE TABLE `guestuser` (
  `guestID` int(11) NOT NULL,
  `guestuser` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `guestuser`
--

INSERT INTO `guestuser` (`guestID`, `guestuser`) VALUES
(1, 'guestuser1'),
(2, 'GuestUser2'),
(3, 'GuestUser3'),
(4, 'GuestUser4');

-- --------------------------------------------------------

--
-- テーブルの構造 `menu`
--

CREATE TABLE `menu` (
  `userID` varchar(255) NOT NULL,
  `menuID` int(11) NOT NULL,
  `menuname` text NOT NULL,
  `quality` tinytext NOT NULL,
  `quantity` tinytext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `physicalconditionlog`
--

CREATE TABLE `physicalconditionlog` (
  `physicalconditionlogID` int(255) NOT NULL,
  `userID` varchar(255) NOT NULL,
  `fatigue` int(3) DEFAULT NULL,
  `date` date NOT NULL,
  `bodyweight` float DEFAULT NULL,
  `bodytemperature` float DEFAULT NULL,
  `sleeptime` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `physicalconditionlog`
--

INSERT INTO `physicalconditionlog` (`physicalconditionlogID`, `userID`, `fatigue`, `date`, `bodyweight`, `bodytemperature`, `sleeptime`, `created_at`, `updated_at`) VALUES
(6, 'dsa', 1, '2020-07-26', 50, 35, 6, '2020-09-18 13:34:16', '2020-09-18 22:34:16'),
(3, 'dsa', 1, '2020-08-30', 50, 35, 6, '2020-09-18 13:29:20', '2020-09-18 22:29:20'),
(4, 'dsa', 1, '2020-09-01', 50, 35, 6, '2020-09-18 13:30:38', '2020-09-18 22:30:38'),
(2, 'dsa', 2, '2020-09-14', 50, 35, 6, '2020-09-15 11:12:16', '2020-09-15 20:12:16'),
(1, 'dsa', 4, '2020-09-15', 50, 35, 6, '2020-09-15 11:11:45', '2020-09-15 20:11:45'),
(8, 'GuestUser2', 2, '2020-09-16', 77, 36.7, 6, '2020-09-16 14:21:24', '2020-09-16 23:21:24'),
(9, 'GuestUser3', 3, '2020-09-18', 77.3, 36.7, 7, '2020-09-18 12:41:18', '2020-09-18 21:41:18'),
(10, 'koshi', 2, '2020-09-25', 77.7, 36.4, 8.5, '2020-09-25 14:15:17', '2020-09-25 23:15:17'),
(15, 'kou480929', 2, '2020-10-03', 72.3, 32.5, 4, '2020-10-03 12:53:54', '2020-10-03 21:53:54'),
(27, 'kou480929', 3, '2020-10-12', 77.6, 36.8, 8, '2020-10-17 03:37:49', '2020-10-17 12:37:49'),
(29, 'kou480929', 0, '2020-10-13', 0, 37, 0, '2020-10-17 03:52:46', '2020-10-17 12:52:46'),
(26, 'kou480929', 2, '2020-10-16', 77.2, 36.7, 7.5, '2020-10-17 03:03:24', '2020-10-17 12:03:24'),
(25, 'kou480929', 2, '2020-10-17', 76.7, 36.3, 7, '2020-10-17 03:02:57', '2020-10-17 12:02:57'),
(14, 'ku480929', 2, '2020-10-03', 72.3, 32.5, 4, '2020-10-03 12:53:36', '2020-10-03 21:53:36');

-- --------------------------------------------------------

--
-- テーブルの構造 `userdata`
--

CREATE TABLE `userdata` (
  `userID` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `userdata`
--

INSERT INTO `userdata` (`userID`, `password`, `created_at`, `updated_at`) VALUES
('koshi', '$2y$10$U616EzIpcBjik0a3gSn.J.EPRim2dtGflixtt4EkkDN/GwyacLwhK', '2020-09-25 14:09:09', '2020-09-25 23:09:09'),
('kou480929', '$2y$10$ZdAnUWBxTsfNnvrN1uJRcuU1Ei0FOGdQ46uLVPFGG8gVIoW5zxJXe', '2020-09-26 09:19:21', '2020-09-26 18:19:21');

-- --------------------------------------------------------

--
-- テーブルの構造 `workoutlog`
--

CREATE TABLE `workoutlog` (
  `userID` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `intensity` int(3) NOT NULL,
  `thought` text NOT NULL,
  `menu` text NOT NULL,
  `contentID` varchar(255) NOT NULL,
  `openorclose` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `workoutlog`
--

INSERT INTO `workoutlog` (`userID`, `date`, `intensity`, `thought`, `menu`, `contentID`, `openorclose`, `created_at`, `updated_at`) VALUES
('kou480929', '2020-10-03', 1, 'ここに感想を記入してください。', 'ここに練習メニューを記入してください。', 'kou4809292020-10-03', 0, '2020-10-04 13:15:03', '2020-10-16 19:08:15'),
('kou480929', '2020-10-04', 3, '疲れた。', 'クリーン', 'kou4809292020-10-04', 1, '2020-10-04 13:24:51', '2020-10-04 22:24:51');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`contentID`);

--
-- テーブルのインデックス `guestuser`
--
ALTER TABLE `guestuser`
  ADD PRIMARY KEY (`guestID`) USING BTREE,
  ADD UNIQUE KEY `guestID` (`guestID`);

--
-- テーブルのインデックス `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`userID`,`menuID`,`created_at`,`updated_at`),
  ADD KEY `menuID` (`menuID`);

--
-- テーブルのインデックス `physicalconditionlog`
--
ALTER TABLE `physicalconditionlog`
  ADD PRIMARY KEY (`userID`,`date`),
  ADD UNIQUE KEY `physicalconditionlogID` (`physicalconditionlogID`);

--
-- テーブルのインデックス `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`userID`);

--
-- テーブルのインデックス `workoutlog`
--
ALTER TABLE `workoutlog`
  ADD PRIMARY KEY (`userID`,`date`,`contentID`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `guestuser`
--
ALTER TABLE `guestuser`
  MODIFY `guestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルのAUTO_INCREMENT `menu`
--
ALTER TABLE `menu`
  MODIFY `menuID` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルのAUTO_INCREMENT `physicalconditionlog`
--
ALTER TABLE `physicalconditionlog`
  MODIFY `physicalconditionlogID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
