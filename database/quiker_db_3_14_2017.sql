-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2017 at 07:48 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quiker`
--
CREATE DATABASE IF NOT EXISTS `quiker` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `quiker`;

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
CREATE TABLE IF NOT EXISTS `agents` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `status` enum('enabled','disabled') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `name`, `username`, `password`, `status`) VALUES
(1, 'Premchand', 'premchand_dokku', 'ed72a124ed565ab0deed670135c4ff73', 'enabled'),
(2, 'Sumit', 'sumit_sharma', '7225ff71e8821b24fd72b4c8fda95b9a', 'enabled'),
(3, 'Prashant', 'prashant_nayak', 'af948f0b6334c5d6e822c9bc8cf24034', 'enabled'),
(4, 'Ashiah', 'ashish_prabhoo', '7b69ad8a8999d4ca7c42b8a729fb0ffd', 'enabled'),
(5, 'Bhavin', 'bhavin_shah', 'de6b0c87d96dffad0b8b4deb59060d07', 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `category` int(1) NOT NULL,
  `folder` text NOT NULL,
  `agent_id` int(11) NOT NULL,
  `date` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `shopname`, `address`, `phone_number`, `email`, `category`, `folder`, `agent_id`, `date`) VALUES
(1, 'Tanvi', 'Andheri', 9967959896, 'Great', 0, 'Tanvi1438715470', 1, '0000-00-00 00:00:00'),
(2, 'Medical', 'Panvel', 8898554422, 'Great', 0, 'Medical1438798696', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'adil_khan', '5c3bea5d394835b2af9d2cfd632147f8');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
