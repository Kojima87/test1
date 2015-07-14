-- phpMyAdmin SQL Dump
-- version 4.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: 2015 年 7 月 14 日 19:53
-- サーバのバージョン： 5.5.42-log
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `guestbook`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `parentId` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `mail` varchar(50) CHARACTER SET utf8 NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `message`
--

INSERT INTO `message` (`id`, `parentId`, `name`, `mail`, `message`, `created_at`) VALUES
(1, 0, 'test1', 'test1@zzz.com', 'テスト1', '2015-06-28 17:02:51'),
(8, 0, 'test8', 'test8@zzz.com', 'テスト８', '2015-07-11 15:37:43'),
(35, 8, 'com8', '', 'こんにちは', '2015-07-12 12:03:04'),
(39, 8, 'com8', '', '８さん、こんにちは', '2015-07-13 23:03:32'),
(41, 0, 'test41', 'test41@zzz.com', 'テスト４１', '2015-07-13 23:17:17'),
(65, 41, 'com41', '', 'hello 41', '2015-07-14 10:58:20'),
(67, 0, 'test67', 'test67@zzz.com', 'テスト６７', '2015-07-14 11:05:00'),
(68, 8, 'com8', '', 'hello 8', '2015-07-14 11:05:27'),
(72, 0, 'test72', '', 'テスト７２', '2015-07-14 19:49:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;