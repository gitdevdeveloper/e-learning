-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2022 at 08:57 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_elearning`
--

-- --------------------------------------------------------

--
-- Table structure for table `db_all_message`
--

CREATE TABLE `db_all_message` (
  `id` int(11) NOT NULL COMMENT 'ไอดี',
  `allms_id` int(11) NOT NULL COMMENT 'ไอดี',
  `m_id` int(11) NOT NULL COMMENT 'ไอดี',
  `user_id` int(11) NOT NULL COMMENT 'ไอดีนักเรียน',
  `reply` text NOT NULL COMMENT 'ข้อความตอบกลับ',
  `date_reply` varchar(255) NOT NULL COMMENT 'วันที่ตอบ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_main_lesson`
--

CREATE TABLE `db_main_lesson` (
  `id` int(11) NOT NULL COMMENT 'ไอดี',
  `main_id` int(11) NOT NULL COMMENT 'ไอดี',
  `images` varchar(255) NOT NULL COMMENT 'รูปภาพ',
  `name` varchar(255) NOT NULL COMMENT 'ชื่อบทเรียน',
  `detail` text NOT NULL COMMENT 'รายละเอียดบทเรียน',
  `audio` varchar(255) NOT NULL COMMENT 'ไฟล์เสียง',
  `status` varchar(255) NOT NULL COMMENT 'สถานะ',
  `date` varchar(255) NOT NULL COMMENT 'วันที่'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_message`
--

CREATE TABLE `db_message` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `m_id` int(11) NOT NULL COMMENT 'ID',
  `user_id` int(11) NOT NULL COMMENT 'userID',
  `sub_name` varchar(255) NOT NULL COMMENT 'name_sub_lesson\r\n',
  `message` text NOT NULL COMMENT 'message',
  `reply` text NOT NULL,
  `m_ryply` varchar(255) NOT NULL,
  `m_date` varchar(255) NOT NULL COMMENT 'date',
  `m_ryply_date` varchar(255) NOT NULL,
  `m_status` varchar(255) NOT NULL COMMENT 'status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_mindmap`
--

CREATE TABLE `db_mindmap` (
  `id` int(11) NOT NULL,
  `main_id` int(11) NOT NULL,
  `mindmap` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_posttest`
--

CREATE TABLE `db_posttest` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `post_id` int(11) NOT NULL COMMENT 'ID',
  `main_id` int(255) NOT NULL COMMENT 'IDบทเรียนหลัก',
  `question` varchar(255) NOT NULL COMMENT 'คำถาม',
  `answer` varchar(255) NOT NULL COMMENT 'คำตอบ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_posttest_choice`
--

CREATE TABLE `db_posttest_choice` (
  `id` int(11) NOT NULL COMMENT 'id',
  `choice_id` int(11) NOT NULL COMMENT 'id',
  `post_id` int(11) NOT NULL COMMENT 'id',
  `choice1` varchar(255) NOT NULL COMMENT 'ตัวเลือก 1',
  `choice2` varchar(255) NOT NULL COMMENT 'ตัวเลือก 2',
  `choice3` varchar(255) NOT NULL COMMENT 'ตัวเลือก 3',
  `choice4` varchar(255) NOT NULL COMMENT 'ตัวเลือก 4'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_pretest`
--

CREATE TABLE `db_pretest` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `pre_id` int(11) NOT NULL COMMENT 'ID',
  `main_id` int(11) NOT NULL COMMENT 'IDบทเรียนหลัก',
  `question` varchar(255) NOT NULL COMMENT 'คำถาม',
  `answer` varchar(255) NOT NULL COMMENT 'คำตอบ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_pretest_choice`
--

CREATE TABLE `db_pretest_choice` (
  `id` int(11) NOT NULL COMMENT 'id',
  `choice_id` int(11) NOT NULL COMMENT 'id',
  `pre_id` int(11) NOT NULL COMMENT 'id',
  `choice1` varchar(255) NOT NULL COMMENT 'ตัวเลือก 1',
  `choice2` varchar(255) NOT NULL COMMENT 'ตัวเลือก 2',
  `choice3` varchar(255) NOT NULL COMMENT 'ตัวเลือก 3',
  `choice4` varchar(255) NOT NULL COMMENT 'ตัวเลือก 4'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_score`
--

CREATE TABLE `db_score` (
  `id` int(11) NOT NULL COMMENT 'id',
  `score_id` int(11) NOT NULL COMMENT 'id',
  `user_id` int(11) NOT NULL COMMENT 'id ผู้ใช้',
  `s_pretest` varchar(255) NOT NULL COMMENT 'คะแนนก่อนเรียน',
  `s_posttest` varchar(255) NOT NULL COMMENT 'คะแนนหลังเรียน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_sub_lesson`
--

CREATE TABLE `db_sub_lesson` (
  `id` int(11) NOT NULL COMMENT 'id',
  `sub_id` int(11) NOT NULL COMMENT 'id บทเรียนย่อย',
  `main_id` int(11) NOT NULL COMMENT 'id บทเรียนหลัก',
  `sub_name` varchar(255) NOT NULL COMMENT 'ชื่อบทเรียนย่อย',
  `video` varchar(255) NOT NULL COMMENT 'ไฟล์วิดีโอ',
  `sub_detail` text NOT NULL COMMENT 'รายละเอียด',
  `date` varchar(255) NOT NULL COMMENT 'วันที่'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_user`
--

CREATE TABLE `db_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'ID',
  `username` varchar(255) NOT NULL COMMENT 'username',
  `password` varchar(255) NOT NULL COMMENT 'password',
  `f_name` varchar(255) NOT NULL COMMENT 'ชื่อ',
  `l_name` varchar(255) NOT NULL COMMENT 'สกุล',
  `prefix` varchar(255) NOT NULL COMMENT 'คำนำหน้า',
  `gender` varchar(255) NOT NULL COMMENT 'เพศ',
  `birthday` varchar(255) NOT NULL COMMENT 'วันเกิด',
  `status` enum('student','teacher','admin') NOT NULL COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `db_user`
--

INSERT INTO `db_user` (`id`, `user_id`, `username`, `password`, `f_name`, `l_name`, `prefix`, `gender`, `birthday`, `status`) VALUES
(1, 225863, 'admin', '1234', 'เฉลิมเดช ', 'ประพิณไพโรจน', 'นาย', 'ชาย', '2001-10-16', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `db_user_answer`
--

CREATE TABLE `db_user_answer` (
  `id` int(11) NOT NULL COMMENT 'id',
  `answer_id` int(11) NOT NULL COMMENT 'id',
  `a_pre_id` int(11) NOT NULL COMMENT 'idคำตอบก่อนเรียน',
  `user_id` int(11) NOT NULL COMMENT 'idนักเรียน',
  `a_main_id` int(11) NOT NULL COMMENT 'idบทเรียน',
  `a_snswer` varchar(255) NOT NULL COMMENT 'คำตอบ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `db_user_answer_posttest`
--

CREATE TABLE `db_user_answer_posttest` (
  `id` int(11) NOT NULL COMMENT 'id',
  `answer_id` int(11) NOT NULL COMMENT 'id',
  `a_post_id` int(11) NOT NULL COMMENT 'idคำตอบหลังเรียน',
  `user_id` int(11) NOT NULL COMMENT 'idนักเรียน',
  `a_main_id` int(11) NOT NULL COMMENT 'idบทเรียนหลัก',
  `a_snswer` varchar(255) NOT NULL COMMENT 'คำตอบ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `score_posttest`
--

CREATE TABLE `score_posttest` (
  `id` int(11) NOT NULL COMMENT 'id',
  `s_id` int(11) NOT NULL COMMENT 'id',
  `user_id` int(11) NOT NULL COMMENT 'idนักเรียน',
  `s_main_id` int(11) NOT NULL COMMENT 'idบทเรียนหลัก',
  `score` varchar(255) NOT NULL COMMENT 'คะแนน',
  `date_time` varchar(255) NOT NULL COMMENT 'เวลา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `score_pretest`
--

CREATE TABLE `score_pretest` (
  `id` int(11) NOT NULL COMMENT 'id',
  `s_id` int(11) NOT NULL COMMENT 'id',
  `user_id` int(11) NOT NULL COMMENT 'idนักเรียน',
  `s_main_id` int(11) NOT NULL COMMENT 'idบทเรียนหลัก',
  `score` varchar(255) NOT NULL COMMENT 'คะแนะ',
  `date_time` varchar(255) NOT NULL COMMENT 'เวลา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `db_all_message`
--
ALTER TABLE `db_all_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_main_lesson`
--
ALTER TABLE `db_main_lesson`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_message`
--
ALTER TABLE `db_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_mindmap`
--
ALTER TABLE `db_mindmap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_posttest`
--
ALTER TABLE `db_posttest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_posttest_choice`
--
ALTER TABLE `db_posttest_choice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_pretest`
--
ALTER TABLE `db_pretest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_pretest_choice`
--
ALTER TABLE `db_pretest_choice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_score`
--
ALTER TABLE `db_score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_sub_lesson`
--
ALTER TABLE `db_sub_lesson`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_user`
--
ALTER TABLE `db_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_user_answer`
--
ALTER TABLE `db_user_answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_user_answer_posttest`
--
ALTER TABLE `db_user_answer_posttest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `score_posttest`
--
ALTER TABLE `score_posttest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `score_pretest`
--
ALTER TABLE `score_pretest`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `db_all_message`
--
ALTER TABLE `db_all_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดี', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `db_main_lesson`
--
ALTER TABLE `db_main_lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ไอดี';

--
-- AUTO_INCREMENT for table `db_message`
--
ALTER TABLE `db_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `db_mindmap`
--
ALTER TABLE `db_mindmap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `db_posttest`
--
ALTER TABLE `db_posttest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `db_posttest_choice`
--
ALTER TABLE `db_posttest_choice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- AUTO_INCREMENT for table `db_pretest`
--
ALTER TABLE `db_pretest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `db_pretest_choice`
--
ALTER TABLE `db_pretest_choice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- AUTO_INCREMENT for table `db_score`
--
ALTER TABLE `db_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- AUTO_INCREMENT for table `db_sub_lesson`
--
ALTER TABLE `db_sub_lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- AUTO_INCREMENT for table `db_user`
--
ALTER TABLE `db_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `db_user_answer`
--
ALTER TABLE `db_user_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- AUTO_INCREMENT for table `db_user_answer_posttest`
--
ALTER TABLE `db_user_answer_posttest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- AUTO_INCREMENT for table `score_posttest`
--
ALTER TABLE `score_posttest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- AUTO_INCREMENT for table `score_pretest`
--
ALTER TABLE `score_pretest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
