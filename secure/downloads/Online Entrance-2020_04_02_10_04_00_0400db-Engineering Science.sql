-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2020 at 01:47 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `team_corana`
--

-- --------------------------------------------------------

--
-- Table structure for table `question_collections`
--

CREATE TABLE `question_collections` (
  `id` int(11) NOT NULL,
  `set_no` int(11) NOT NULL,
  `question_no` int(40) NOT NULL,
  `question` text NOT NULL,
  `optn_a` text NOT NULL,
  `optn_b` text NOT NULL,
  `optn_c` text NOT NULL,
  `optn_d` text NOT NULL,
  `correct_optn` varchar(10) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `cntng_marks` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_collections`
--

INSERT INTO `question_collections` (`id`, `set_no`, `question_no`, `question`, `optn_a`, `optn_b`, `optn_c`, `optn_d`, `correct_optn`, `answer`, `cntng_marks`) VALUES
(1, 1, 1, 'question', 'optn a', 'optn b', 'optn c', 'optn d', 'a', 'this is answer', 1),
(2, 1, 2, 'question 2', 'optn a', 'optn b', 'optn c', 'optn d', 'd', 'd is the correct answer', 2),
(3, 1, 3, 'qsn 3', 'a', 'bc', 'c', 'd', 'c', 'c will be correcta answer', 2);

-- --------------------------------------------------------

--
-- Table structure for table `question_sets`
--

CREATE TABLE `question_sets` (
  `id` int(11) NOT NULL,
  `set_name` varchar(11) NOT NULL,
  `set_details` text NOT NULL,
  `trn_date` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_sets`
--

INSERT INTO `question_sets` (`id`, `set_name`, `set_details`, `trn_date`) VALUES
(1, 'SET A', 'This is the first date', '2019-11-26 09:11:59'),
(2, 'SET B', 'This is the second set details', '2019-10-23 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_exam_details`
--

CREATE TABLE `user_exam_details` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `set_no` int(10) NOT NULL,
  `submitted_answers` varchar(255) NOT NULL,
  `total_marks` int(4) NOT NULL,
  `attempt_qsn` int(4) NOT NULL,
  `right_answer` int(4) NOT NULL,
  `wrong_answer` int(4) NOT NULL,
  `no_attempt` int(4) NOT NULL,
  `obtain_marks` int(4) NOT NULL,
  `result` varchar(40) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `trn_date` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_exam_details`
--

INSERT INTO `user_exam_details` (`id`, `user_name`, `set_no`, `submitted_answers`, `total_marks`, `attempt_qsn`, `right_answer`, `wrong_answer`, `no_attempt`, `obtain_marks`, `result`, `remarks`, `trn_date`) VALUES
(1, 'bhubany', 0, 'Array', 0, 0, 0, 0, 0, 0, '', 'FAIL', '2020-02-08 16:13:37'),
(2, 'bhubany', 0, '', 0, 0, 0, 0, 0, 0, '', 'FAIL', '2020-02-08 16:17:26'),
(3, 'bhubany', 1, 'a', 1, 1, 1, 0, 0, 1, '100', 'OUTSTANDING', '2020-02-08 16:17:39'),
(4, 'bhubany', 1, 'a', 1, 1, 1, 0, 0, 1, '100', 'OUTSTANDING', '2020-02-08 16:46:48'),
(5, 'bhubany', 1, 'a', 1, 1, 1, 0, 0, 1, '100', 'OUTSTANDING', '2020-02-08 16:47:07'),
(6, 'bhubany', 0, '', 0, 0, 0, 0, 0, 0, '', 'FAIL', '2020-02-08 17:11:39'),
(7, 'bhubany', 0, '', 0, 0, 0, 0, 0, 0, '', 'FAIL', '2020-02-08 17:12:14'),
(8, 'bhubany', 0, '', 0, 0, 0, 0, 0, 0, '', 'FAIL', '2020-02-08 17:12:59'),
(9, 'bhubany', 0, '', 0, 0, 0, 0, 0, 0, '', 'FAIL', '2020-02-08 17:13:19'),
(10, 'bhubany', 0, '', 0, 0, 0, 0, 0, 0, '', 'FAIL', '2020-02-08 17:13:23'),
(11, 'bhubany', 0, '', 0, 0, 0, 0, 0, 0, '', 'FAIL', '2020-02-08 17:14:33'),
(12, 'bhubany', 1, 'nnn', 5, 0, 0, 0, 3, 0, '0', 'FAIL', '2020-02-08 17:18:17'),
(13, 'bhubany', 1, 'a', 5, 3, 1, 2, 0, 1, '20', 'FAIL', '2020-02-08 17:25:35'),
(14, 'bhubany', 1, '', 5, 3, 0, 3, 0, 0, '0', 'FAIL', '2020-02-08 17:32:01'),
(15, 'bhubany', 1, 'nnn', 5, 0, 0, 0, 3, 0, '0', 'FAIL', '2020-02-08 17:35:52'),
(16, 'bhubany', 1, 'a', 5, 3, 1, 2, 0, 1, '20', 'FAIL', '2020-02-08 17:46:11'),
(17, 'bhubany', 1, 'ann', 5, 1, 1, 0, 2, 1, '20', 'FAIL', '2020-02-08 20:01:47');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `firstName` varchar(40) NOT NULL,
  `middleName` varchar(40) NOT NULL,
  `surName` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` varchar(40) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `is_verified` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `firstName`, `middleName`, `surName`, `email`, `username`, `password`, `image`, `created_at`, `is_active`, `is_verified`) VALUES
(1, 'bhuban', 'prasad', 'yadav', 'yadav.bhuban.by@gmail.com', 'bhubany', 'fb53a87175fe0775a16929a4fe6e2f47', 'team_corona_logo.jpg', '2020-02-08 12:57:45', 1, 1),
(2, 'khage', 'prasad', 'yadav', 'someone@gmail.com', 'khage', 'd9ec5f5b72c91fca79391bb8479457b9', 'team_corona_logo.jpg', '2020-02-08 15:24:06', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `question_collections`
--
ALTER TABLE `question_collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_sets`
--
ALTER TABLE `question_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_exam_details`
--
ALTER TABLE `user_exam_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `question_collections`
--
ALTER TABLE `question_collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `question_sets`
--
ALTER TABLE `question_sets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_exam_details`
--
ALTER TABLE `user_exam_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
