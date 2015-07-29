-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 29, 2015 at 04:59 AM
-- Server version: 5.0.45
-- PHP Version: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `imonggo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `customers`
-- 

CREATE TABLE `customers` (
  `imonggo_id` varchar(20) character set latin7 NOT NULL,
  `shopify_id` varchar(20) character set latin2 NOT NULL,
  `email` varchar(50) character set latin7 NOT NULL,
  PRIMARY KEY  (`shopify_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `imonggo_id` (`imonggo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `customers`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `invoices`
-- 

CREATE TABLE `invoices` (
  `id` smallint(5) unsigned zerofill NOT NULL auto_increment,
  `post_date` varchar(30) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `post_date` (`post_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=73 ;

-- 
-- Dumping data for table `invoices`
-- 

INSERT INTO `invoices` (`id`, `post_date`) VALUES 
(00072, 'Jul 29, 2015 09:34:21 am');

-- --------------------------------------------------------

-- 
-- Table structure for table `last_invoice_posting`
-- 

CREATE TABLE `last_invoice_posting` (
  `order_id` varchar(20) character set latin2 NOT NULL,
  `id` smallint(5) unsigned zerofill NOT NULL auto_increment,
  `date` varchar(30) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `date` (`date`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=35 ;

-- 
-- Dumping data for table `last_invoice_posting`
-- 

INSERT INTO `last_invoice_posting` (`order_id`, `id`, `date`) VALUES 
('1095714180', 00034, 'Jul 29, 2015 09:34:21 am');

-- --------------------------------------------------------

-- 
-- Table structure for table `products`
-- 

CREATE TABLE `products` (
  `imonggo_id` varchar(20) collate latin1_general_ci NOT NULL,
  `shopify_id` varchar(20) character set latin7 NOT NULL,
  `name` varchar(50) collate latin1_general_ci NOT NULL,
  UNIQUE KEY `shopify_id` (`shopify_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `products`
-- 

INSERT INTO `products` (`imonggo_id`, `shopify_id`, `name`) VALUES 
('957118', '1002474052', 'Black Party Crop'),
('957114', '1002468484', 'Long Sleeves Black'),
('957117', '1002468356', 'Classic Pink Top'),
('957115', '1002468228', 'Spring Fashion Blouse');
