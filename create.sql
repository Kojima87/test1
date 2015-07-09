-- phpMyAdmin SQL Dump
-- version 4.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: 2015 年 7 月 09 日 21:49
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
  `m_id` int(11) NOT NULL,
  `m_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `m_mail` varchar(50) CHARACTER SET utf8 NOT NULL,
  `m_message` text CHARACTER SET utf8 NOT NULL,
  `m_dt` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `message`
--

INSERT INTO `message` (`m_id`, `m_name`, `m_mail`, `m_message`, `m_dt`) VALUES
(1, 'test1', 'test1@zzz.com', 'テスト1', '2015-06-28 17:02:51'),
(4, 'test4', '', 'テスト⒋', '2015-06-29 22:52:17'),
(5, 'test5', '', 'テスト５', '2015-07-02 20:38:00'),
(6, 'test6', 'test6@zzz.com', 'テスト６', '2015-07-03 17:00:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`m_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;