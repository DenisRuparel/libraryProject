-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 14, 2023 at 04:24 PM
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
('denis', 'denis', 'ruparel', 'denisruparel28@gmail.com', 8866637550, '123', ''),
('denis12', 'denis', 'ruparel', 'deniskalpeshbhai436@gmail.com', 5698741230, '123', ''),
('vivek_vara', 'vivek', 'vara', 'vivekvara2004@gmail.com', 9512618990, '6916', '');

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
('CE001', 'C Programming', 'Coding', 'Denis', 100, 'Atul Publication', '2020-10-16', '11', 'Available', '2023-03-14 16:06:11'),
('CE002', 'C++', 'Programming', 'denis Ruparel', 150, 'Atul Publication', '2021-02-01', '14', 'Available', '2023-03-14 15:52:14'),
('CE003', '.Net Programming', 'Coding', 'Denis Ruparel', 200, 'Atul Publication', '2021-05-10', '19', 'Available', '2023-03-14 16:04:46'),
('CE004', 'PHP', 'Web Development', 'Denis Ruparel', 500, 'Atul Publication', '2008-04-12', '5', 'Available', '2023-03-14 15:48:44'),
('CE005', 'Java Programming', 'Programming', 'Denis Ruparel', 300, 'Atul Publication', '2022-08-25', '9', 'Available', '2023-03-14 04:45:32'),
('CE006', 'Android', 'Android programming', 'vivek', 250, 'vivek Publication', '2023-03-06', '10', 'Available', '2023-03-13 14:30:27');

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
('CVN', 'Chirag', 'Nathvani', 'chiragnathvani@gmail.com', 3245617890, '123', 'avatar/1677944049.png'),
('IHP', 'Imran', 'Pathan', 'imranpathan@gmail.com', 9512618990, '6916', 'avatar/1677944094.png'),
('SDG', 'Sagar', 'Gajera', 'sagargajera@gmail.com', 7854123690, '123', 'avatar/1677944261.png'),
('VND', 'Vanraj', 'Dangar', 'vanrajdangar@gmail.com', 3265417890, '123', 'avatar/1677943966.png'),
('VUV', 'denis', 'ruparel', 'denisruparel28@gmail.com', 8866637550, '1234', 'avatar/1678078851.png');

-- --------------------------------------------------------

--
-- Table structure for table `f_issue_book`
--

DROP TABLE IF EXISTS `f_issue_book`;
CREATE TABLE IF NOT EXISTS `f_issue_book` (
  `issue_book_id` int NOT NULL AUTO_INCREMENT,
  `book_id` varchar(20) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `issue_date_time` varchar(30) NOT NULL,
  `expected_return_date` varchar(30) NOT NULL,
  `return_date_time` varchar(30) NOT NULL,
  `book_fines` varchar(30) NOT NULL,
  `book_issue_status` enum('Issue','Return','Not Return') NOT NULL,
  PRIMARY KEY (`issue_book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `f_issue_book`
--

INSERT INTO `f_issue_book` (`issue_book_id`, `book_id`, `user_id`, `issue_date_time`, `expected_return_date`, `return_date_time`, `book_fines`, `book_issue_status`) VALUES
(7, 'CE003', 'IHP', '2023-03-14 16:04:46', '2023-03-19 16:04:46', '2023-03-14 16:04:58', '0 Rs.', 'Return'),
(6, 'CE001', 'VND', '2023-03-14 16:02:43', '2023-03-19 16:02:43', '2023-03-14 16:02:50', '0 Rs.', 'Return');

-- --------------------------------------------------------

--
-- Table structure for table `issue_book`
--

DROP TABLE IF EXISTS `issue_book`;
CREATE TABLE IF NOT EXISTS `issue_book` (
  `issue_book_id` int NOT NULL AUTO_INCREMENT,
  `book_id` varchar(20) NOT NULL,
  `user_id` bigint NOT NULL,
  `issue_date_time` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `expected_return_date` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `return_date_time` varchar(30) NOT NULL,
  `book_fines` varchar(30) NOT NULL,
  `book_issue_status` enum('Issue','Return','Not Return') NOT NULL,
  PRIMARY KEY (`issue_book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `issue_book`
--

INSERT INTO `issue_book` (`issue_book_id`, `book_id`, `user_id`, `issue_date_time`, `expected_return_date`, `return_date_time`, `book_fines`, `book_issue_status`) VALUES
(83, 'CE001', 206270307020, '2023-03-14 16:06:11', '2023-03-19 16:06:11', '2023-03-14 16:06:20', '0 Rs.', 'Return'),
(81, 'CE003', 206270307066, '2023-03-13 14:48:56', '2023-03-18 14:48:56', '2023-03-13 14:49:13', '0 Rs.', 'Return'),
(82, 'CE005', 206270307024, '2023-03-14 04:45:32', '2023-03-19 04:45:32', '2023-03-14 04:46:34', '0 Rs.', 'Return'),
(80, 'CE004', 206270307024, '2023-03-13 14:46:12', '2023-03-18 14:46:12', '2023-03-13 14:48:14', '0 Rs.', 'Return');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

DROP TABLE IF EXISTS `register`;
CREATE TABLE IF NOT EXISTS `register` (
  `enrollment_number` bigint NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contact` bigint NOT NULL,
  `password` varchar(15) NOT NULL,
  `activation` varchar(100) NOT NULL,
  `user_avatar` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`enrollment_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`enrollment_number`, `first_name`, `last_name`, `email`, `contact`, `password`, `activation`, `user_avatar`, `date`) VALUES
(206270307020, 'uday', 'odedara', 'uday2004@gmail.com', 2147483647, 'u', '', 'avatar/1678769443.png', '2023-03-14 10:20:43'),
(206270307024, 'vivek', 'vara', 'vivekvara2004@gmail.com', 2147483647, '6916', '', 'avatar/1675691422.png', '2023-02-06 19:20:22'),
(206270307066, 'denis', 'ruparel', 'denisruparel28@gmail.com', 8866637550, '321', '', 'avatar/1675691384.png', '2023-02-06 19:19:44'),
(206270307083, 'shanti', 'agath', 'shantiagath@gmail.com', 1234567890, '123', '', 'avatar/1675691456.png', '2023-02-06 19:20:56'),
(206270307093, 'nidhi', 'solanki', 'nidhisolanki@gmail.com', 2147483647, '123', '', 'avatar/1677916332.png', '2023-03-04 13:22:12');

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
