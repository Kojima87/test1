-- phpMyAdmin SQL Dump
-- version 4.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: 2015 年 7 月 18 日 21:55
-- サーバのバージョン： 5.5.42-log
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `guestbook`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `parentId` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `mail` varchar(50) CHARACTER SET utf8 NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `comments`
--

INSERT INTO `comments` (`id`, `parentId`, `name`, `mail`, `comment`, `created_at`) VALUES
(1, 1, 'yamada', 'yamada@zzz.com', 'Hi.  I&#039;m yamada.', '2015-07-18 15:09:21'),
(2, 5, 'suzuki', 'suzuki@zzz.com', '鈴木です。山田さん、こんにちは。', '2015-07-18 16:09:11'),
(3, 6, 'ito', '', 'Hi, Aoki.  I&#039;m Ito.', '2015-07-18 21:10:52');

-- --------------------------------------------------------

--
-- テーブルの構造 `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `parentId` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `mail` varchar(50) CHARACTER SET utf8 NOT NULL,
  `msg` text CHARACTER SET utf8 NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `message`
--

INSERT INTO `message` (`id`, `parentId`, `name`, `mail`, `msg`, `created_at`) VALUES
(1, 0, 'test1', 'test1@zzz.com', 'テスト1', '2015-06-28 17:02:51'),
(5, 0, 'yamada', 'yamada@zzz.com', '山田です。', '2015-07-18 15:54:54'),
(6, 0, 'aoki', 'aoki@zzz.com', '青木です。', '2015-07-18 20:50:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;