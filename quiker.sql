-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2015 at 09:19 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET FOREIGN_KEY_CHECKS=0;
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
-- Table structure for table `pramoters`
--

DROP TABLE IF EXISTS `pramoters`;
CREATE TABLE IF NOT EXISTS `pramoters` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `status` enum('enabled','disabled') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pramoters`
--

INSERT INTO `pramoters` (`id`, `name`, `username`, `password`, `status`) VALUES
(1, 'Premchand', 'premchand.dokku', 'ed72a124ed565ab0deed670135c4ff73', 'enabled'),
(2, 'Sumit', 'sumit.sharma', '7225ff71e8821b24fd72b4c8fda95b9a', 'enabled'),
(3, 'Prashant', 'prashant.nayak', 'prashant', 'enabled'),
(4, 'Ashiah', 'ashish.prabhoo', 'ashish', 'enabled');

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
  `response` text NOT NULL,
  `folder` text NOT NULL,
  `pramoter_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `shopname`, `address`, `phone_number`, `response`, `folder`, `pramoter_id`) VALUES
(1, 'test', '', 0, '', 'test1438538118', 1),
(2, 'test', '', 0, '', 'test1438538214', 1),
(3, 'test', '', 0, '', 'test1438538381', 1),
(4, 'Tanvi', 'Andheri', 9967959896, 'Great', 'Tanvi1438715470', 1);

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
(1, 'adil.khan', '5c3bea5d394835b2af9d2cfd632147f8');
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
