-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2020-10-17 15:10:15
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

-- --------------------------------------------------------

--
-- テーブルの構造 `guestuser`
--

CREATE TABLE `guestuser` (
  `guestID` int(11) NOT NULL,
  `guestuser` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
