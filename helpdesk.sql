-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2023 at 07:15 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helpdesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(50) NOT NULL,
  `query_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_from` int(11) NOT NULL,
  `message` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `query_id`, `timestamp`, `user_from`, `message`) VALUES
(6, 2, '2023-06-01 19:27:32', 3, 'Will you please elaborate for which subject and chapter?\r\n'),
(12, 2, '2023-06-02 00:53:07', 1, 'The drive link for Subject IOT Chapter 2.'),
(13, 2, '2023-06-02 02:52:58', 3, 'Please try to use you college email id.'),
(14, 2, '2023-06-02 02:53:18', 1, 'we have tried several times but failed'),
(15, 2, '2023-06-02 02:53:30', 3, 'Okay let me verify that one.'),
(16, 2, '2023-06-02 02:53:44', 1, 'Any updates?'),
(17, 2, '2023-06-02 02:54:09', 3, 'No updates till now. '),
(18, 2, '2023-06-02 02:54:16', 3, 'I will get back to you later'),
(19, 2, '2023-06-02 02:54:23', 1, 'Okay Sir!'),
(20, 2, '2023-06-02 02:54:53', 3, 'I veriied that link.. and have updated it with the new one.'),
(21, 2, '2023-06-02 02:55:05', 3, 'Try and let me know'),
(22, 2, '2023-06-02 02:55:18', 1, 'Okay Sir  !'),
(23, 2, '2023-06-02 02:55:26', 1, 'I will check'),
(24, 2, '2023-06-02 02:55:39', 1, 'Yes Sir, It is working'),
(25, 2, '2023-06-02 02:55:51', 3, 'Okay!'),
(32, 3, '2023-06-03 07:21:55', 1, 'how are you?'),
(34, 3, '2023-06-03 07:30:12', 3, 'I am fine what about you?'),
(36, 12, '2023-06-04 11:19:46', 1, 'hi sir'),
(37, 12, '2023-06-04 11:20:36', 1, 'Please issue me a new library card as I have lost my older one'),
(38, 12, '2023-06-04 11:21:23', 3, 'Sure, but there are going to be some formalities regarding the same');

-- --------------------------------------------------------

--
-- Table structure for table `login_info`
--

CREATE TABLE `login_info` (
  `id` int(11) NOT NULL,
  `userid` varchar(12) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `usertype` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_info`
--

INSERT INTO `login_info` (`id`, `userid`, `pass`, `usertype`) VALUES
(2, 'b190771', '25d55ad283aa400af464c76d713c07ad', 1),
(3, 'b190552', '25d55ad283aa400af464c76d713c07ad', 1),
(5, 't190772', '25d55ad283aa400af464c76d713c07ad', 2),
(7, 'c190774', '25d55ad283aa400af464c76d713c07ad', 3),
(8, 't190775', '25d55ad283aa400af464c76d713c07ad', 2);

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` longtext NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 2 COMMENT '1: Ongoing 2:NotVerifed 3:Closed 4:Rejected',
  `closure_comments` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  `admin_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`id`, `title`, `description`, `status`, `closure_comments`, `timestamp`, `user_from`, `user_to`, `admin_user`) VALUES
(1, 'Lab assignment practical 2 procedure', 'Please provide an instruction guide for the practical', 3, '', '2023-05-12 06:02:55', 2, 6, NULL),
(2, 'Drive link for notes of chapter 2 is not working.', 'The drive link provided on google classroom for chapter 2 notes (Energy management) is not opening.', 1, '', '2023-05-12 04:27:11', 1, 3, NULL),
(3, 'Library cards not issued yet', 'Please issue library cards for first semester Computer Science students.', 1, '', '2023-05-12 06:26:36', 1, 3, NULL),
(4, 'extend assignment date', 'please extend assignment date for DSA assignment', 4, '', '2023-05-12 04:26:38', 1, 6, NULL),
(7, 'Alot a Slot', 'Please Provide a slot for report checked', 4, '', '2023-06-02 03:11:25', 1, 3, NULL),
(9, 'Approve Holiday Request', 'Please Approve holiday on 3rd feb for A', 2, '', '2023-06-03 06:41:43', 1, 6, NULL),
(12, 'New library card', 'PLease issue a new library card.', 1, '', '2023-06-04 11:18:59', 1, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_registration`
--

CREATE TABLE `user_registration` (
  `id` int(11) NOT NULL,
  `userid` varchar(12) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `course` tinyint(1) NOT NULL COMMENT '1 - CSE, 2 - IT, 3 - EE,4 - ECE,5 - ME,6 - CE ',
  `semester` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0: Unverified 1: Verified',
  `usertype` tinyint(1) NOT NULL COMMENT '1:Student 2:Faculty Head 3: College Admin',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_registration`
--

INSERT INTO `user_registration` (`id`, `userid`, `firstname`, `lastname`, `email`, `course`, `semester`, `status`, `usertype`, `timestamp`) VALUES
(1, 'b190552', 'Abhishek ', 'Garg', 'abhishekgarg@gmail.com', 1, 8, 1, 1, '2023-05-07 18:38:01'),
(2, 'b190771', 'Akshita', 'Jain', 'akshita@gmail.com', 2, 6, 0, 1, '2023-05-12 05:17:39'),
(3, 't190772', 'Akshit', 'Shukla', 'akshit@gmail.com', 1, 0, 1, 2, '2023-06-01 15:04:36'),
(5, 'c190774', 'Aditi', 'Jain', 'aditi@gmail.com', 0, 0, 1, 3, '2023-06-01 15:24:22'),
(6, 't190775', 'Pankaj', 'Dadheech', 'p@gmail.com', 3, 0, 1, 2, '2023-06-01 16:34:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quer_id` (`query_id`),
  ADD KEY `fk_chat_user` (`user_from`);

--
-- Indexes for table `login_info`
--
ALTER TABLE `login_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`userid`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_admin_user` (`admin_user`),
  ADD KEY `fk_user_from` (`user_from`),
  ADD KEY `fk_user_to` (`user_to`);

--
-- Indexes for table `user_registration`
--
ALTER TABLE `user_registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`userid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `login_info`
--
ALTER TABLE `login_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_registration`
--
ALTER TABLE `user_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `fk_chat_user` FOREIGN KEY (`user_from`) REFERENCES `user_registration` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `quer_id` FOREIGN KEY (`query_id`) REFERENCES `queries` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `login_info`
--
ALTER TABLE `login_info`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`userid`) REFERENCES `user_registration` (`userid`) ON UPDATE CASCADE;

--
-- Constraints for table `queries`
--
ALTER TABLE `queries`
  ADD CONSTRAINT `fk_admin_user` FOREIGN KEY (`admin_user`) REFERENCES `user_registration` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_from` FOREIGN KEY (`user_from`) REFERENCES `user_registration` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_to` FOREIGN KEY (`user_to`) REFERENCES `user_registration` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
