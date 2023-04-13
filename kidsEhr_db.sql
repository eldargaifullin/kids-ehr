-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 02, 2022 at 11:18 PM
-- Server version: 5.7.21-20-beget-5.7.21-20-1-log
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `j977592l_ehr`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--
-- Creation: Jan 08, 2022 at 10:22 AM
-- Last update: Feb 02, 2022 at 08:11 PM
--

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'test@test.com', '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq', '0000-00-00 00:00:00'),
(2, 'emp2', '$2y$10$pUMWMo9UybYWmgZxYnZ/9urbm4B9Ez5W4pgM1/bIUubctNxBOToUS', '2022-01-08 21:21:50'),
(3, 'emp3', '$2y$10$GoqCrqQMqLMpB8qLCmLbyurwnC3Hb35TJ1LkZoXxrYse7xm0aWx3i', '2022-01-08 21:23:01'),
(4, 'emp4', '$2y$10$e/wa2IqW0D5sTAp2xsQdgOiCQt7utqSJDWtW5ryyFQs3LcFbQlsHm', '2022-01-08 21:24:41'),
(5, 'emp5', '$2y$10$QUxkwPyKdb44ZGDs8f6HL.W.JnrQEhftDdopxEr9wdyqtpk0MUTVG', '2022-01-08 21:25:14'),
(6, '123@mail.com', '$2y$10$teu4w5l4Ypq4AoRNF2vxT.b.VUE8f4orDQIiLEvcdC8i9ECcvtY7S', '2022-01-08 21:37:52'),
(18, 'doctorEldar', '$2y$10$76Id4O6K0/PV9t4I7rOlUe4wQ3VyEkmi5jbv.1deqNxkDteFf4G1q', '2022-02-02 23:05:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Feb 02, 2022 at 07:59 PM
-- Last update: Feb 02, 2022 at 08:10 PM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `userId` int(10) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `state` varchar(50) NOT NULL,
  `weight` int(10) NOT NULL,
  `height` int(10) NOT NULL,
  `doctor_id` int(10) NOT NULL,
  `covid_vaccine_received` varchar(30) NOT NULL,
  `first_dose` date NOT NULL,
  `second_dose` date NOT NULL,
  `hepatit_b_date` int(1) NOT NULL,
  `abnormalities` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `email`, `lastName`, `firstName`, `gender`, `date_of_birth`, `address`, `state`, `weight`, `height`, `doctor_id`, `covid_vaccine_received`, `first_dose`, `second_dose`, `hepatit_b_date`, `abnormalities`) VALUES
(33, 'labsjwl2@gmail.com', 'Gaifullin', 'Eldar11', 'male', '2022-02-26', 'hirthausweg 50', 'Bayern', 55, 164, 6, 'Moderna', '2022-02-02', '2022-02-17', 1, '1222Patient diagnosed with Long Covid, have normal CT scans \r\nPatient have been in hospital with Covid-19 and discharged more than three months. Initial results show that there is “significantly impaired gas transfer” from the lungs to the bloodstream in these Long Covid patients when other tests are normal.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
