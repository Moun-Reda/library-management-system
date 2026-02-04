-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2026 at 05:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `librarydatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `Email` varchar(10) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `PASSWORD` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Email`, `NAME`, `PASSWORD`) VALUES
('ee@dd', 'Moun Reda', '$2y$10$RpTqHrKQdsEgkjGUFF3TTurRYMUhYlnNr3wLEMKkwbY.Yln2StDcK'),
('m120@120', 'Moun Reda', '$2y$10$NWhKW.Zn/Y0G93TCYCjMReFiFVI2X6AjblJ0NxUdCFRSgIlr31KuK'),
('moun@1', 'Moun Reda', '$2y$10$SYASqDpOrKA8c33KBcal8urI04p.4arMMk5x3r3QDMswpDBPEt302'),
('moun@123', 'moon', '$2y$10$py86htNxIrDE2IRa20jk7uWrWZhWF6xR1GcMFXKOohA2jKKD7Y..2'),
('reda@123', 'Moun Reda', '$2y$10$Xm69zAlTxeDSjMhZQvWAlePgSc6Nc.ZyvuaGgkLhfjuaGgPvZBz4y'),
('redamoon90', 'Moun Reda', '$2y$10$IUlV3wy2gO6DwqAcqxztkuVfQ8GnFqkbORp12FRG6.mhsW1xsGpri'),
('redamoon@g', 'Moun Reda', '$2y$10$imR45lL/4KbCbvBjLEebPOTeXFlxb3g0GFnxc04pYq4N/38C/5yg.'),
('we@df', 'Moun Reda', '$2y$10$yUQryTFgI9J8EWPN0DJIdegHXEz7/40VQ2OTRI5NR.DS0GX1IWki2');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `publish_house` varchar(50) DEFAULT NULL,
  `publishing_date` date DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `book_status` enum('available','unavailable') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `publish_house`, `publishing_date`, `category`, `book_status`) VALUES
(1, 'To Kill a Mockingbird', 'Harper Lee', 'J.B. Lippincott & Co.', '1960-07-11', 'Fiction', 'available'),
(2, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Charles Scribner\'s Sons', '1925-04-10', 'Classic', 'unavailable'),
(3, 'Pride and Prejudice', 'Jane Austen', 'T. Egerton', '1813-01-28', 'Romance', 'available'),
(4, 'The Catcher in the Rye', 'J.D. Salinger', 'Little, Brown and Company', '1951-07-16', 'Fiction', 'available'),
(5, 'The Lord of the Rings', 'J.R.R. Tolkien', 'George Allen & Unwin', '1954-07-29', 'Fantasy', 'available'),
(6, 'The Hobbit', 'J.R.R. Tolkien', 'George Allen & Unwin', '1937-09-21', 'Fantasy', 'available'),
(7, 'The Hunger Games', 'Suzanne Collins', 'Scholastic', '2008-09-14', 'Dystopian', 'available'),
(8, 'The Chronicles of Narnia', 'C.S. Lewis', 'Geoffrey Bles', '1950-10-16', 'Fantasy', 'available'),
(9, 'The Kite Runner', 'Khaled Hosseini', 'Riverhead Books', '2003-05-29', 'Fiction', 'available'),
(10, 'The Little Prince', 'Antoine de Saint-Exupéry', 'Reynal & Hitchcock', '1943-04-06', 'Classic', 'available'),
(11, 'The Book Thief', 'Markus Zusak', 'Picador', '2005-09-01', 'Historical Fiction', 'available'),
(12, 'Life of Pi', 'Yann Martel', 'Knopf Canada', '2001-09-11', 'Adventure', 'available'),
(13, '1984', 'George Orwell', 'Secker & Warburg', '1949-06-08', 'Dystopian', 'available'),
(14, 'Moby-Dick', 'Herman Melville', 'Harper & Brothers', '1851-10-18', 'Adventure', 'available'),
(15, 'War and Peace', 'dan brown', 'The Russian Messenger', '1869-01-01', 'Historical Fiction', 'unavailable'),
(16, 'The Alchemist', 'Paulo Coelho', 'HarperTorch', '1988-04-01', 'Philosophical Fiction', 'available'),
(17, 'The Da Vinci Code', 'dr.strange', 'The Russian Messenger', '1901-01-01', 'Mystery', 'available'),
(18, 'A Game of Thrones', 'George R.R. Martin', 'Bantam Spectra', '1996-08-06', 'Fantasy', 'available'),
(19, 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', 'Bloomsbury', '1997-06-26', 'Fantasy', 'available'),
(20, 'Anne of Green Gables', 'Lucy Maud Montgomery', 'L.C. Page & Co.', '1908-06-01', 'Classic', 'available'),
(21, 'The Fault in Our Stars', 'John Green', 'Dutton Books', '2012-01-10', 'Young Adult', 'available'),
(26, 'Rose', 'Lili', 'Future', '1999-01-02', 'Romance', 'unavailable'),
(27, 'مملكه البلاغة', 'حنان لاشين', 'عصير الكتب', '2024-05-05', 'Mystery', 'available'),
(28, 'hhh', 'hhhh', 'ft', NULL, 'Fantasy', 'unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `borrow_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL DEFAULT curdate(),
  `expected_return_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `fine` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`borrow_id`, `member_id`, `book_id`, `borrow_date`, `expected_return_date`, `return_date`, `fine`) VALUES
(1, 4, 2, '2025-11-29', '2025-12-06', '2025-11-29', 0),
(2, 6, 26, '2025-11-29', '2025-12-06', NULL, 0),
(3, 6, 2, '2025-11-29', '2025-12-06', NULL, 0),
(4, 7, 15, '2025-12-06', '2025-12-12', NULL, 0),
(5, 7, 28, '2025-12-06', '2025-12-13', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `name`, `phone_number`, `address`) VALUES
(2, 'meriam samy', '01198765432', 'sidi beshr'),
(3, 'mariam mohammed', '01234567890', 'sidi gaber'),
(4, 'Moun Reda Ali', '01211926911', 'abu-qire'),
(6, 'Salma Hussien', '123212', 'france'),
(7, 'مون ', '123212', 'us'),
(8, 'Asser', '123123', 'france');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`Email`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`),
  ADD CONSTRAINT `borrowings_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
