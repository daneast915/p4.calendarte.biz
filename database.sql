-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 23, 2013 at 05:32 AM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `calendar_p4_calendarte_biz`
--
-- CREATE DATABASE IF NOT EXISTS `calendar_p4_calendarte_biz` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `calendar_p4_calendarte_biz`;

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
)  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `created`, `modified`, `user_id`, `organization_id`, `name`, `description`, `top_pick`, `category`, `genre`, `website`, `purchase_link`, `admission_info`) VALUES
(2, 1387745831, 1387764725, 33, 4, 'Glad Tidings!', 'Holiday concert', 1, 0, 0, 'http://www.wheatlandchorale.org', 'http://wheatlandchorale.org/tickets/', ''),
(3, 1387770366, 1387770366, 33, 10, 'Demuth Invitational Opening', 'Please join us for our annual Demuth Invitational opening reception tonight from 5-8pm. Exhibition on view February 7th - March 2nd. Museum Hours: Tues-Sat 10-4, Sun 1-4', 0, 0, 0, '', '', ''),
(4, 1387770763, 1387770763, 33, 8, 'Amahl &amp; the Night Visitors', 'OperaLancaster presents the touching story Amahl and the Night Visitors, the Gian Carlo Menotti classic about a young boy who meets the Magi on their journey to see the Christ Child. The tale of Amahl&rsquo;s encounter features Lancaster&rsquo;s top singers, chorus and dancers and makes a welcome addition to your family&rsquo;s holiday season.  ', 1, 0, 0, 'http://www.operalancaster.com/201314-season.html', '', ''),
(5, 1387771053, 1387771053, 33, 7, 'Music in the Round: Rhapsody in Blue', 'Come join us on Friday, January 24, 2014 for our first Music in the Round concert of the new year: Rhapsody in Blue, at the Ware Center, 41 N. Prince St, Lancaster!  This event begins at 6:45 with appetizers, wine and beer in the Ware Center&rsquo;s Grand Salon, followed by an hour of music in the beautiful Atrium.  The audience surrounds the musicians in an intimate environment.rnrnThis concert features a very fine local pianist, Dr. William Wright, performing the Rhapsody in Blue of George Gershwin.  This will be the rarely-performed &ldquo;original version&rdquo; of the work! The concert will also include Handel&rsquo;s Water Music Suite #2, and Gustav Holst&rsquo;s lovely St. Paul Suite.', 1, 0, 0, 'http://allegrochamberorchestra.org/wp/ai1ec_event/music-in-the-round-rhapsody-in-blue/?instance_id=78', '', ''),
(6, 1387771148, 1387771148, 33, 7, 'Music in the Round: Love Is All Around', 'Come join us for a special Valentine&rsquo;s Day event: Love Is All Around, at the Ware Center, 41 N. Prince St, Lancaster!  This event begins at 6:45 with appetizers, wine and beer in the Ware Center&rsquo;s Grand Salon, followed by an hour of music in the beautiful Atrium.  The audience surrounds the musicians in an intimate environment.rnrnThis concert features Debussy: Prelude to an Afternoon of a Faun;  Beethoven: Romance No. 1 in G (Todd Sullivan, violin soloist);  Borodin: Nocturne from String Quartet No. 2;  Lehman: Fragments of the Imagination (World Premiere; Jana MacKay, flute soloist).', 0, 0, 0, 'http://allegrochamberorchestra.org/wp/ai1ec_event/music-in-the-round-love-is-all-around/?instance_id=82', '', ''),
(7, 1387771362, 1387771362, 33, 7, 'Music in the Round: If It&rsquo;s Not Baroque&hellip;', 'The music of the Baroque era is perfect for Allegro! Join us for If It&rsquo;s Not Baroque&hellip;, at the Ware Center, 41 N. Prince St, Lancaster!  This event begins at 6:45 with appetizers, wine and beer in the Ware Center&rsquo;s Grand Salon, followed by an hour of music in the beautiful Atrium.  The audience surrounds the musicians in an intimate environment.rnrnThis concert features Handel: Concerto Grosso Op. 3. No. 3;  Bach: Brandenburg Concerto No. 3;  Albinoni: Concerto for Oboe, Op 9 No. 2 (featuring Jeffrey O&rsquo;Donnell, oboe);  Clarke: St. Patrick Suite.', 0, 0, 0, 'http://allegrochamberorchestra.org/wp/ai1ec_event/music-in-the-round-if-its-not-baroque/?instance_id=105', '', ''),
(8, 1387771432, 1387771432, 33, 7, 'Allegro: Going Solo', 'Allegro Chamber Orchestra begins its 2014 Core Series with a concert full of soloists!  Haydn&rsquo;s Sinfonia Concertante for Oboe, Bassoon, Violin and Cello will feature soloists from Allegro&rsquo;s principal players (Jeffrey O&rsquo;Donnell, oboe; Kimberly Buchar, Bassoon, Todd Sullivan, violin and John Caldwell, cello) , as will Vivaldi&rsquo;s Piccolo Concerto in C, 443 (featuring Jana MacKay, piccolo soloist).  Daugherty&rsquo;s  Flamingo has an unusual twist &ndash; 2 tambourine soloists: Mark Yingling and Matthew Grady! The concert will conclude with Mozart&rsquo;s Symphony No. 39.', 1, 0, 0, 'http://allegrochamberorchestra.org/wp/ai1ec_event/allegro-going-solo/?instance_id=106', '', ''),
(9, 1387771707, 1387771862, 33, 7, 'Allegro: FIRE', 'Allegro presents fiery music at our July concert: FIRE! The concert has a subtitle too: &ldquo;Music You Don&rsquo;t Know That You Know!&rdquo; In other words, even if the titles don&rsquo;t sound familiar, you&rsquo;ll be saying, &ldquo;I know that!&rdquo;  The concert will include Handel: Entrance of the Queen of Sheba;  Haydn: Cello Concerto in D (featuring Sarah Male, cello soloist); Falla: Ritual Fire Dance;  Beethoven: Symphony No. 2.', 0, 0, 0, 'http://allegrochamberorchestra.org/wp/ai1ec_event/allegro-fire/?instance_id=95', '', ''),
(10, 1387771967, 1387771967, 33, 7, 'Allegro: Wondrous Journey', 'Allegro&rsquo;s Summer Core Season closes with a very special concert, featuring Ralph Lehman&rsquo;s Wondrous Journey, a piece commissioned by Kim Norcross (Allegro conductor Brian Norcross&rsquo; wife) to celebrate 25 years of wedded bliss.  Also on the program will be JS Bach&rsquo;s Brandenburg Concerto No. 1, and the stunning suite of Symphonic Dances from Leonard Bernstein&rsquo;s West Side Story.', 0, 0, 0, 'http://allegrochamberorchestra.org/wp/ai1ec_event/allegro-wondrous-journey/?instance_id=100', '', ''),
(11, 1387772193, 1387772193, 33, 6, 'Meeting Mozart in His Time', 'A journey back in time with the maestro and orchestra in period costumes', 1, 0, 0, 'http://www.lancastersymphony.org/ConcertsandTickets/2013-2014SeasonataGlance/tabid/222/eventid_715/61/Default.aspx', '', ''),
(12, 1387772388, 1387772388, 33, 6, 'Romeo Meets Carmen', 'Tchaikovsky&mdash;Romeo &amp; Juliet Overture-FantasyrnSarasate&mdash;Carmen Fantasy, Maria Azova, violinrnde Falla&mdash;Ritual Fire DancernConus&mdash;Violin Concerto in E Minor, Maria Azova, violinrnHanson&mdash;Symphony No. 2 in D-Flat Major &ldquo;Romantic&rdquo;', 0, 0, 0, 'http://www.lancastersymphony.org/ConcertsandTickets/2013-2014SeasonataGlance/tabid/222/eventid_715/62/Default.aspx', '', ''),
(13, 1387772574, 1387772574, 33, 4, 'Spring Concert', 'Annual Spring concert', 0, 0, 0, 'http://wheatlandchorale.org/', '', ''),
(14, 1387772849, 1387772878, 33, 5, 'The Marriage of True Minds', 'Musical Associates annual concert at the end of summer', 0, 0, 0, 'http://musicalassociates.org/wp/', '', '');

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
)  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`organization_id`, `created`, `modified`, `user_id`, `category`, `genre`, `type`, `name`, `description`, `address_street`, `address_box`, `address_city`, `address_state`, `address_zipcode`, `email`, `phone`, `website`, `director`, `image_url`) VALUES
(4, 1387238723, 1387743026, 33, 0, 0, 0, 'Wheatland Chorale', 'The Wheatland Chorale has earned a reputation as one of Pennsylvania&#039;s premier choral ensembles. The singers, all volunteers, are selected through audition, and travel from throughout Central and Southeastern Pennsylvania for weekly rehearsals in Lancaster. The Chorale is named for its birthplace in the Wheatland Hills area of Lancaster. The popularity of the Wheatland Chorale has grown steadily. The regular season includes a concert subscription series, performed in Lancaster, Wyomissing and at Elizabethtown College.', '18 E. Walnut St.', '', 'Lancaster', 'PA', '17602', 'info@wheatlandchorale.org', '717-555-1212', 'http://www.wheatlandchorale.org', 'Eric Riley', 'http://wheatlandchorale.org/wp-content/uploads/2012/11/wheatland-group2.jpg'),
(5, 1387243427, 1387743047, 33, 0, 0, 0, 'Musical Associates', 'Musical Associates is a select group of singers and instrumentalists, dedicated to bringing the finest in choral music to music lovers in the Susquehanna Valley. Under the direction of Artistic Director Emery DeWitt, the singers and instrumentalists include many of the area&#039;s top soloists. Concerts are usually held in the summer.', '18 E. Walnut St.', '', 'Lancaster', 'PA', '17602', 'info@musicalassociates.org', '717-555-1212', 'http://www.musicalassociates.org', 'Emery DeWitt', 'http://musicalassociates.org/wp/wp-content/uploads/2013/03/MA-Header-weaver-ii-940x324-top-title1.jpg'),
(6, 1387769475, 1387769475, 33, 0, 0, 0, 'Lancaster Symphony Orchestra', 'Now in its 66th season, the Lancaster Symphony Orchestra has played for over three decades under the direction of rn            Maestro Stephen Gunzenhauser. The Symphony has evolved from a community orchestra playing a few concerts per year rn            into a $1.7 million organization of professional musicians presenting six Classic Series concerts, the Sounds of rn            the Season holiday concert series and two New Year&#039;s Celebration concerts. The concerts feature international rn            guest artists and conductors and frequent U.S. and world premieres, such as 2012&#039;s national premiere of rn            Disney&#039;s Fantasia Live In Concert. Opening Night Friday audiences are also treated to a post-concert reception rn            where they can interact with the Symphony&#039;s musicians and guest artists.', '226 North Arch Street', '', 'Lancaster', 'PA', '17603', '', '', 'http://www.lancastersymphony.org', 'Stephen Gunzenhauser', 'http://www.witf.org/center-stage/LSO_orchestra_Gunzenhauser%2520resized%2520homepg.jpg'),
(7, 1387769601, 1387771909, 33, 0, 0, 0, 'Allegro - the Chamber Orchestra of Lancaster', 'Allegro means joyful &hellip; fast and lively &hellip; a different musical experience &hellip; We invite you to experience the joy  of Allegro! Allegro brings the music to life through concerts that are specially designed to be engaging, enjoyable and fun. Our musicians clearly love what they are doing. The players mingle with the audience before concerts, during intermission and after performances.', 'P.O. Box 1741', '', 'Lancaster', 'PA', '17608', 'info@allegrochamberorchestra.org', '717-560-7317', 'http://www.allegrochamberorchestra.org', 'Brian Norcross', 'http://assets3.razoo.com/assets/media/images/000/017/146/images/size_550x415_razoo%20550x415.png?1297798878'),
(8, 1387769933, 1387770662, 33, 0, 0, 0, 'OperaLancaster', 'OperaLancaster was founded as the Lancaster Opera Workshop in the early 50s in the small in-home studio of rn            Frederick Robinson and Dorothy Darr. Today, OperaLancaster is the only surviving opera company in Pennsylvania rn            between Philaldelphia and Pittsburg producing opera with full sets, costumes, and full orchestra every year.rn            Each season, OperaLancaster offers three main stage productions: A light production in English in the Fall, rn            an annual production of Amahl &amp;amp; the Night Visitors in January, and a traditional staged Grand Opera in the rn            Spring. Additionally, OperaLancaster produces and presents smaller concerts, productions, community outreach, rn            lectures, and educational series throughout the year.', '42 North Prince Street', '', 'Lancaster', 'PA', '17603', '', '717-871-7814', 'http://www.operalancaster.com', 'William Dewan', 'https://si0.twimg.com/profile_images/752170165/operalanc.png'),
(9, 1387770054, 1387770117, 33, 0, 0, 0, 'PRiMA Theatre Company', 'We believe that the arts are at their best when they speak your language, jab at the status quo and enrich your life. rn            That is why PRiMA Theatre Company, Lancaster&#039;s freshest professional theatre, is beckoning in a new era of relevant rn            and modern arts programming to the Lancaster area. Producing Director, Mitchell M. Nugent leads the non-profit rn            organization in exciting main-stage shows in concert style and energetic, top-notch cabarets at The Ware Center.rn      ', '42 North Prince Street', '', 'Lancaster', 'PA', '17603', '', '', 'http://www.primatheatre.com/', 'Mitchell M. Nugent', 'http://www.primatheatre.com/index_files/PRiMA%202014.jpg'),
(10, 1387770290, 1387770290, 33, 0, 0, 0, 'Demuth Museum', 'The Demuth Museum is dedicated to developing awareness, understanding and appreciation of the art work and legacyrn            of American modernist Charles Demuth. We engage and inspire diverse audiences through an innovative program ofrn            exhibitions, education, scholarship and collections activities.', '120 East King Street', '', 'Lancaster', 'PA', '17602', 'information@demuth.org', '', 'http://www.demuth.org', 'Anne M. Lampe', 'http://www.demuth.org/_images/live/Mission_250_1.jpg');

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
)  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`show_id`, `created`, `modified`, `user_id`, `event_id`, `venue_id`, `date_time`) VALUES
(10, 1387757929, 1387757929, 33, 2, 1, '2013-12-25 20:00:00'),
(11, 1387758543, 1387758543, 33, 2, 3, '2014-01-11 20:00:00'),
(12, 1387770546, 1387770546, 33, 3, 9, '2014-02-07 17:00:00'),
(13, 1387770921, 1387770921, 33, 4, 13, '2013-12-04 19:30:00'),
(14, 1387771091, 1387771091, 33, 5, 1, '2014-01-24 18:45:00'),
(15, 1387771201, 1387771201, 33, 6, 1, '2014-02-14 18:45:00'),
(16, 1387771387, 1387771387, 33, 7, 1, '2014-03-14 18:45:00'),
(17, 1387771475, 1387771475, 33, 8, 1, '2014-06-14 14:00:00'),
(18, 1387771516, 1387771516, 33, 8, 1, '2014-06-14 19:30:00'),
(19, 1387771732, 1387771732, 33, 9, 1, '2014-07-12 14:00:00'),
(20, 1387771753, 1387771753, 33, 9, 1, '2014-07-12 19:30:00'),
(21, 1387772001, 1387772001, 33, 10, 1, '2014-08-09 14:00:00'),
(22, 1387772019, 1387772019, 33, 10, 1, '2014-08-09 19:30:00'),
(23, 1387772239, 1387772239, 33, 11, 7, '2014-01-17 20:00:00'),
(24, 1387772262, 1387772262, 33, 11, 7, '2014-01-18 20:00:00'),
(25, 1387772291, 1387772291, 33, 11, 7, '2014-01-19 20:00:00'),
(26, 1387772411, 1387772411, 33, 12, 7, '2014-02-21 20:00:00'),
(27, 1387772438, 1387772438, 33, 12, 7, '2014-02-22 20:00:00'),
(28, 1387772491, 1387772491, 33, 12, 7, '2014-02-23 20:00:00'),
(29, 1387772729, 1387772729, 33, 13, 14, '2014-03-28 20:00:00'),
(30, 1387772753, 1387772753, 33, 13, 3, '2014-03-30 20:00:00'),
(31, 1387772904, 1387772904, 33, 14, 2, '2013-08-24 19:00:00'),
(32, 1387772933, 1387772933, 33, 14, 3, '2013-09-08 16:00:00');

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
)  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `created`, `modified`, `token`, `password`, `last_login`, `timezone`, `first_name`, `last_name`, `email`, `avatar`) VALUES
(31, 1387127998, 1387158892, '49325bb0a4f3ef2bf1328174ab57573b43d0d4fb', '09e08f67de901dca540b5c52035a484af07c9aac', 1387158798, '', 'Dan', 'East', 'daneast915@gmail.com', ''),
(33, 1387238196, 1387238196, '631a40385751139c5f6f8a6556e4d5ee948896a0', 'e9bee8ed7da539ed6457914f757756b8b07730f3', 1387767757, '', 'Admin', 'Admin', 'admin@fake.org', '');

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
  `seating_info` varchar(255) NOT NULL,
  `parking_info` varchar(255) NOT NULL,
  `accessibility_info` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`venue_id`)
)  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`venue_id`, `created`, `modified`, `user_id`, `name`, `description`, `address_street`, `address_box`, `address_city`, `address_state`, `address_zipcode`, `phone`, `email`, `website`, `seating_info`, `parking_info`, `accessibility_info`, `image_url`) VALUES
(1, 1387326634, 1387326634, 33, 'Ware Center', 'Lancaster&#039;s new visual and performing arts center located in the heart of the arts and historic district! There is something for everyone in Lancaster, and The Ware Center of Millersville University Lancaster captures a little of everything. From art to cabaret to music, we have an event series or two that you will love! Stunning new, architecturally important facility with a two-story, glass enclosed lobby space, acoustically-perfect performance space with stadium seating and Ville in the Sky -- a music cafe overlooking the city of Lancaster.', '42 N. Prince Street', '', 'Lancaster', 'PA', '17603', '717-871-2308', 'warecenterinfo@millersville.edu', 'http://www.millersville.edu/muarts/venues/ware-center', '', '', '', 'http://www.lancasterarts.com/Uploads/images/LancasterARTS/Sponsors-website/WareCentr408w.jpg'),
(2, 1387419377, 1387419377, 33, 'Lancaster Church of the Brethren', '', '1601 Sunset Ave.', '', 'Lancaster', 'PA', '17603', '717-397-4751', 'info@lancob.org', 'http://www.lancob.org', '', '', '', 'http://lancob.org/site/wp-content/uploads/2011/12/HomePage_Banner1-copy.jpg'),
(3, 1387419807, 1387419807, 33, 'First Presbyterian Church', '', '140 E. Orange St.', '', 'Lancaster', 'PA', '17603', '717-394-6854', 'info@fpclive.org', 'http://www.fpclive.org', '', '', '', ''),
(4, 1387643114, 1387643114, 33, 'Long&#039;s Park', 'Long&rsquo;s Park is a 80-acre park located northwest of Lancaster City at the intersection of Harrisburg Pike and the Route 30 Bypass. Picnic pavilions and tables dot the park along with a petting farm, children&#039;s playgrounds, a two-acre, spring-fed lake, tennis courts and a fitness trail.', '1441 Harrisburg Pike', '', 'Lancaster', 'PA', '17603', '717-735-8883', 'info@longspark.org', 'http://www.longspark.org', '', '', '', 'http://allegrochamberorchestra.org/wp/wp-content/uploads/2013/04/Longs-Park-with-crowd-300x205.jpg'),
(5, 1387643325, 1387643325, 33, 'Barshinger Center', 'The Barshinger Center provides a world-class, 500-seat concert hall to serve as the centerpiece of Franklin and Marshall&#039;s thriving music program.', '615 College Avenue', '', 'Lancaster', 'PA', '17603', '717-735-8883', 'info@fandm.edu', 'http://www.fandm.edu/directory/building/259', '', '', '', 'http://allegrochamberorchestra.org/wp/wp-content/uploads/2013/04/barshinger-outside.jpg'),
(7, 1387671806, 1387674904, 33, 'Fulton Theatre / Opera House', 'Central Pennsylvania&#039;s premier regional theatre and National Historic Landmark combines Broadway caliber musicals, comedies and dramas with the grandeur of ornate Victorian architecture. The Fulton first opened its doors in 1852. Almost 160 years later, this National Historic Landmark Theatre continues to entertain, educate and delight audiences, bringing live theatre, music, and more than 100,000 patrons into downtown Lancaster annually. Since its inception, some of the brightest stars of theatre, music and film have appeared on its stage. Today, under the leadership of Artistic Director Marc Robin and Managing Director Aaron A. Young, the Fulton Theatre produces a mix of comedies, dramas and musicals, employing the talents of professional directors, designers, playwrights and actors from the local community, New York and across the country.', '12 North Prince Street', '', 'Lancaster', 'PA', '17603', '717-397-7425', 'info@fulton.org', 'http://www.thefulton.org', '', '', '', 'http://www.bam.org/media/261845/2012_Visit%20_Opera%20House%20_305x171.jpg'),
(8, 1387768766, 1387768766, 33, 'Lancaster Public Library', 'As one of the oldest public libraries in the country, we have been providing library service in Lancaster for over 250 years. Our three locations in the county include Lancaster City, Leola, and Mountville.', '125 N. Duke Street', '', 'Lancaster', 'PA', '17602', '717-394-2651', 'info@lancaster.lib.pa.us', 'http://www.lancaster.lib.pa.us', '', '', '', ''),
(9, 1387768905, 1387768905, 33, 'Demuth Museum', 'The Demuth Museum is dedicated to developing awareness, understanding and appreciation of the art work and legacy  of American modernist Charles Demuth. We engage and inspire diverse audiences through an innovative program of exhibitions, education, scholarship and collections activities.', '120 East King Street', '', 'Lancaster', 'PA', '17602', '', 'info@demuth.org', 'http://www.demuth.org', '', '', '', 'http://www.demuth.org/_images/live/Mission_250_1.jpg'),
(10, 1387769064, 1387769353, 33, 'Pennsylvania College of Art and Design', 'Pennsylvania College of Art &amp; Design celebrated its 30th year in 2012. When the senior class graduated on May 5, 2012, the college recognized thirty years of preparing students for a life -- and career -- in art and design.  Pennsylvania College of Art &amp; Design&rsquo;s strong Bachelor of Fine Arts program attracts aspiring professional artists who want to study in an urban environment, and within a community that actively supports the arts. PCA&amp;D is a non-profit, professional art college offering four-year Bachelor of Fine Arts (BFA) programs in Fine Art, Graphic Design, Illustration, and Photography, and beginning in Fall 2014, a major in Digital Media.', '204 N. Prince Street', '', 'Lancaster', 'PA', '17603', '717-396-7833', 'info@pcad.edu', 'http://www.pcad.edu', '', '', '', 'http://collegeprowler.com/images/standard/29350/?v=71F51AF'),
(11, 1387769197, 1387769197, 33, 'North Museum of Natural History and Science', 'In 2013, the North Museum of Natural History &amp;amp; Science marks 60 years of inspiring curiosity and a love of science in children and adults of all ages. Through exhibits, events and educational programming, we hope to plant the seeds of exploration leading to a lifelong journey of discovery. Visit us often to find out about upcoming events and activities. There&#039;s always something new at the North!', '400 College Avenue', '', 'Lancaster', 'PA', '17603', '717-291-3941', 'info@northmuseum.org', 'http://www.northmuseum.org', '', '', '', 'http://www.fandm.edu/uploads/media_items/north-museum-1.300.250.c.jpg'),
(12, 1387769334, 1387769334, 33, 'Holy Trinity Lutheran Church', 'Holy Trinity Lutheran Church, a vibrant city congregation with a long history and an eye to the future,  is committed to excellence in worship, music, and outreach to the diverse community that makes up its  South Duke Street neighborhood. Each year since 1974 the church has hosted a concert series &ldquo;Music at Trinity&rdquo; with performances by national and regional musicians, with special emphasis on organ music. Trinity has the largest and one of the finest organs in Lancaster County containing four manuals and 99 ranks, which is partially housed in an historic 1774 case by David Tannenberg.  On First Fridays the church opens the doors of its sanctuary and Landmark Caf&eacute; for a variety of events including acoustic music, art exhibits, and poetry readings.', '31 South Duke Street', '', 'Lancaster', 'PA', '17602', '', 'info@trinitylancaster.org', 'http://www.trinitylancaster.org/organ.php', '', '', '', 'http://www.trinitylancaster.org/images/organpic2.jpg'),
(13, 1387770876, 1387770876, 33, 'Highland Presbyterian Church', '', '500 East Roseville Road ', '', 'Lancaster', 'PA', '17601', '', 'info@highlandpc.org', 'http://www.highlandpc.org/programs/concerts/', '', '', '', 'http://www.highlandpc.org/wp-content/uploads/2013/07/britten.jpg'),
(14, 1387772688, 1387772688, 33, 'Market Square Presbyterian Church', '', '20 S. Second St.', '', 'Harrisburg', 'PA', '17101', '', 'info@wheatlandchorale.org', 'http://www.marketsquarechurch.org', '', '', '', 'http://www.marketsquarechurch.org/images/church%20front.JPG');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
