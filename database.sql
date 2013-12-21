-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 21, 2013 at 07:11 PM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `calendar_p4_calendarte_biz`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `top_pick` tinyint(1) NOT NULL,
  `category` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `website` varchar(255) NOT NULL,
  `purchase_link` varchar(255) NOT NULL,
  `admission_info` varchar(255) NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `organization_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `address_street` varchar(255) NOT NULL,
  `address_box` varchar(16) NOT NULL,
  `address_city` varchar(255) NOT NULL,
  `address_state` varchar(32) NOT NULL,
  `address_zipcode` varchar(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `website` varchar(255) NOT NULL,
  `director` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`organization_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`organization_id`, `created`, `modified`, `user_id`, `category`, `genre`, `type`, `name`, `description`, `address_street`, `address_box`, `address_city`, `address_state`, `address_zipcode`, `email`, `phone`, `website`, `director`, `image_url`) VALUES
(4, 1387238723, 1387238723, 33, 0, 0, 0, 'Wheatland Chorale', 'The Wheatland Chorale has earned a reputation as one of Pennsylvania&#039;s premier choral ensembles. The singers, all volunteers, are selected through audition, and travel from throughout Central and Southeastern Pennsylvania for weekly rehearsals in Lancaster. The Chorale is named for its birthplace in the Wheatland Hills area of Lancaster. The popularity of the Wheatland Chorale has grown steadily. The regular season includes a concert subscription series, performed in Lancaster, Wyomissing and at Elizabethtown College.', '', '', '', '', '', 'info@wheatlandchorale.org', '717-555-1212', 'http://www.wheatlandchorale.org', 'Eric Riley', 'http://wheatlandchorale.org/wp-content/uploads/2012/11/wheatland-group2.jpg'),
(5, 1387243427, 1387243427, 33, 0, 0, 0, 'Musical Associates', 'Musical Associates is a select group of singers and instrumentalists, dedicated to bringing the finest in choral music to music lovers in the Susquehanna Valley. Under the direction of Artistic Director Emery DeWitt, the singers and instrumentalists include many of the area&#039;s top soloists. Concerts are usually held in the summer.', '', '', '', '', '', 'info@musicalassociates.org', '717-555-1212', 'http://www.musicalassociates.org', 'Emery DeWitt', 'http://musicalassociates.org/wp/wp-content/uploads/2013/03/MA-Header-weaver-ii-940x324-top-title1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE `shows` (
  `show_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`show_id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`),
  KEY `venue_id` (`venue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` int(11) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `created`, `modified`, `token`, `password`, `last_login`, `timezone`, `first_name`, `last_name`, `email`, `avatar`) VALUES
(31, 1387127998, 1387158892, '49325bb0a4f3ef2bf1328174ab57573b43d0d4fb', '09e08f67de901dca540b5c52035a484af07c9aac', 1387158798, '', 'Dan', 'East', 'daneast915@gmail.com', ''),
(33, 1387238196, 1387238196, 'f984bc5294c1e735c6a2651955f1d249b21882df', 'e9bee8ed7da539ed6457914f757756b8b07730f3', 1387648833, '', 'Admin', 'Admin', 'admin@fake.org', '');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `venue_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `address_street` varchar(255) NOT NULL,
  `address_box` varchar(32) NOT NULL,
  `address_city` varchar(255) NOT NULL,
  `address_state` varchar(32) NOT NULL,
  `address_zipcode` varchar(16) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `seating_chart` varchar(255) NOT NULL,
  `parking_info` varchar(255) NOT NULL,
  `accessibility_info` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`venue_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`venue_id`, `created`, `modified`, `user_id`, `name`, `description`, `address_street`, `address_box`, `address_city`, `address_state`, `address_zipcode`, `phone`, `email`, `website`, `seating_chart`, `parking_info`, `accessibility_info`, `image_url`) VALUES
(1, 1387326634, 1387326634, 33, 'Ware Center', 'Lancaster&#039;s new visual and performing arts center located in the heart of the arts and historic district! There is something for everyone in Lancaster, and The Ware Center of Millersville University Lancaster captures a little of everything. From art to cabaret to music, we have an event series or two that you will love! Stunning new, architecturally important facility with a two-story, glass enclosed lobby space, acoustically-perfect performance space with stadium seating and Ville in the Sky -- a music cafe overlooking the city of Lancaster.', '42 N. Prince Street', '', 'Lancaster', 'PA', '17603', '717-871-2308', 'warecenterinfo@millersville.edu', 'http://www.millersville.edu/muarts/venues/ware-center', '', '', '', 'http://www.lancasterarts.com/Uploads/images/LancasterARTS/Sponsors-website/WareCentr408w.jpg'),
(2, 1387419377, 1387419377, 33, 'Lancaster Church of the Brethren', '', '1601 Sunset Ave.', '', 'Lancaster', 'PA', '17603', '717-397-4751', 'info@lancob.org', 'http://www.lancob.org', '', '', '', 'http://lancob.org/site/wp-content/uploads/2011/12/HomePage_Banner1-copy.jpg'),
(3, 1387419807, 1387419807, 33, 'First Presbyterian Church', '', '140 E. Orange St.', '', 'Lancaster', 'PA', '17603', '717-394-6854', 'info@fpclive.org', 'http://www.fpclive.org', '', '', '', ''),
(4, 1387643114, 1387643114, 33, 'Long&#039;s Park', 'Long&rsquo;s Park is a 80-acre park located northwest of Lancaster City at the intersection of Harrisburg Pike and the Route 30 Bypass. Picnic pavilions and tables dot the park along with a petting farm, children&#039;s playgrounds, a two-acre, spring-fed lake, tennis courts and a fitness trail.', '1441 Harrisburg Pike', '', 'Lancaster', 'PA', '17603', '717-735-8883', 'info@longspark.org', 'http://www.longspark.org', '', '', '', 'http://allegrochamberorchestra.org/wp/wp-content/uploads/2013/04/Longs-Park-with-crowd-300x205.jpg'),
(5, 1387643325, 1387643325, 33, 'Barshinger Center', 'The Barshinger Center provides a world-class, 500-seat concert hall to serve as the centerpiece of Franklin and Marshall&#039;s thriving music program.', '615 College Avenue', '', 'Lancaster', 'PA', '17603', '717-735-8883', 'info@fandm.edu', 'http://www.fandm.edu/directory/building/259', '', '', '', 'http://allegrochamberorchestra.org/wp/wp-content/uploads/2013/04/barshinger-outside.jpg');
