-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 13, 2023 at 09:12 AM
-- Server version: 8.0.27
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `user_id` varchar(10) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contact` bigint NOT NULL,
  `password` varchar(15) NOT NULL,
  `activation` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `first_name`, `last_name`, `email`, `contact`, `password`, `activation`) VALUES
('denis', 'denis', 'ruparel', 'denis1234@gmail.com', 8866637930, '123', ''),
('denis12', 'denis', 'ruparel', 'deniskalpeshbhai436@gmail.com', 5698741230, '123', ''),
('vivek_vara', 'vivek', 'vara', 'vivekvara2004@gmail.com', 9512618990, '6916', ''),
('denis123', 'denis', 'ruparel', 'denisruparel@gmail.com', 4521369870, '123', '');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `book_id` varchar(20) NOT NULL,
  `book_title` varchar(100) NOT NULL,
  `catagory` varchar(100) NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `publication` varchar(100) NOT NULL,
  `purchase_date` date NOT NULL,
  `quantity` varchar(20) NOT NULL,
  `availability` enum('Available','Not Available') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `book_updated_on` varchar(30) NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `book_title`, `catagory`, `author_name`, `price`, `publication`, `purchase_date`, `quantity`, `availability`, `book_updated_on`) VALUES
('CE001', 'C Programming', 'Coding', 'Denis', 100, 'Atul Publication', '2020-10-16', '10', 'Available', ''),
('CE002', 'C++', 'Programming', 'denis Ruparel', 150, 'Atul Publication', '2021-02-01', '15', 'Available', ''),
('CE003', '.Net Programming', 'Coding', 'Denis Ruparel', 200, 'Atul Publication', '2021-05-10', '20', 'Available', ''),
('CE004', 'PHP', 'Web Development', 'Denis Ruparel', 500, 'Atul Publication', '2008-04-12', '5', 'Available', ''),
('CE005', 'Java Programming', 'Programming', 'Denis Ruparel', 300, 'Atul Publication', '2022-08-25', '10', 'Available', ''),
('CE006', 'MALP', 'microprocessor programming', 'denis', 270, 'Atul Publication', '2023-02-04', '6', 'Available', '');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat` (
  `userid` int NOT NULL,
  `enrollment_number` bigint NOT NULL,
  `message` text NOT NULL,
  `status` enum('Online','Offline') NOT NULL,
  `sender` enum('Student') NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`userid`, `enrollment_number`, `message`, `status`, `sender`) VALUES
(0, 206270307024, '', 'Online', 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

DROP TABLE IF EXISTS `faculties`;
CREATE TABLE IF NOT EXISTS `faculties` (
  `f_id` varchar(15) NOT NULL,
  `f_name` varchar(30) NOT NULL,
  `l_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` bigint NOT NULL,
  `password` varchar(15) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  PRIMARY KEY (`f_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`f_id`, `f_name`, `l_name`, `email`, `contact`, `password`, `avatar`) VALUES
('DKR', 'Denis', 'Ruparel', 'denisruparel28@gmail.com', 8866637550, '123', 'avatar/1675233798.png'),
('VUV', 'Vivek', 'vara', 'vivekvara2004@gmail.com', 9512618990, '6916', 'avatar/1675234779.png');

-- --------------------------------------------------------

--
-- Table structure for table `issue_book`
--

DROP TABLE IF EXISTS `issue_book`;
CREATE TABLE IF NOT EXISTS `issue_book` (
  `enrollment_number` bigint NOT NULL,
  `book_id` varchar(20) NOT NULL,
  `book_title` varchar(100) NOT NULL,
  `issue_date` varchar(30) NOT NULL,
  `return_date` varchar(30) NOT NULL,
  `book_issue_status` enum('Issue','Return','Not Return') NOT NULL,
  PRIMARY KEY (`enrollment_number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

DROP TABLE IF EXISTS `register`;
CREATE TABLE IF NOT EXISTS `register` (
  `userid` int NOT NULL,
  `enrollment_number` bigint NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contact` bigint NOT NULL,
  `password` varchar(15) NOT NULL,
  `activation` varchar(100) NOT NULL,
  `user_avatar` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  `status` enum('No','Yes') NOT NULL,
  `sender` enum('Student','Admin','Faculty') NOT NULL,
  PRIMARY KEY (`enrollment_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`userid`, `enrollment_number`, `first_name`, `last_name`, `email`, `contact`, `password`, `activation`, `user_avatar`, `date`, `message`, `status`, `sender`) VALUES
(1, 206270307024, 'vivek', 'vara', 'vivekvara2004@gmail.com', 2147483647, '6916', '', 'avatar/1675691422.png', '2023-02-06 19:20:22', '', 'No', 'Student'),
(2, 206270307066, 'denis', 'ruparel', 'deniskalpeshbhai436@gmail.com', 2147483647, '123', '', 'avatar/1675691384.png', '2023-02-06 19:19:44', '', 'No', 'Student'),
(3, 206270307083, 'shanti', 'agath', 'shantiagath@gmail.com', 1234567890, '123', '', 'avatar/1675691456.png', '2023-02-06 19:20:56', '', 'No', 'Student'),
(4, 206270307093, 'nidhi', 'solanki', 'nidhisolanki@gmail.com', 123456789, '123', '', 'avatar/1675691505.png', '2023-02-06 19:21:45', '', 'No', 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
CREATE TABLE IF NOT EXISTS `requests` (
  `enrollment_number` bigint NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contact` int NOT NULL,
  `password` varchar(15) NOT NULL,
  `activation` varchar(100) NOT NULL,
  `user_avatar` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`enrollment_number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` int NOT NULL AUTO_INCREMENT,
  `library_admin` varchar(50) NOT NULL,
  `library_contact` bigint NOT NULL,
  `library_email` varchar(50) NOT NULL,
  `library_total_book_issue_day` int NOT NULL,
  `library_one_day_fine` decimal(4,2) NOT NULL,
  `library_issue_total_book_per_user` int NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `library_admin`, `library_contact`, `library_email`, `library_total_book_issue_day`, `library_one_day_fine`, `library_issue_total_book_per_user`) VALUES
(0, 'denis', 8866637550, 'denis12@gmail.com', 5, '2.00', 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
