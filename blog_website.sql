-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2020 at 11:33 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `cat_desc` text DEFAULT NULL,
  `sub_category` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `cat_desc`, `sub_category`, `status`) VALUES
(1, 'Education', 'This is Education Category and all types of Education related Post will be under this category', 0, 1),
(2, 'Technology', 'This is Technology Category and all types of Technology related Post will be under this category', 0, 1),
(3, 'Politics', '', 0, 1),
(4, 'Sports', '', 0, 1),
(5, 'Fashion', '', 0, 1),
(6, 'Health & Fitness', 'Health & Fitness Description', 0, 1),
(7, 'International', '', 0, 1),
(9, 'Cricket', 'This is cricket category under Sports', 4, 1),
(10, 'FootBall', 'This is football category under Sports', 4, 1),
(11, 'Hockey', 'This is hockey category under Sports', 4, 1),
(12, 'Network', 'This is Networking Category', 2, 1),
(13, 'Robotics', 'This is Robotics Category', 2, 1),
(14, 'Mens Fashion', 'Mens Fashion Posts', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `cmt_id` int(11) NOT NULL,
  `comments` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `visitor_id` int(11) NOT NULL,
  `is_parent` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL,
  `new_status` int(1) DEFAULT 1,
  `cmt_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`cmt_id`, `comments`, `post_id`, `visitor_id`, `is_parent`, `status`, `new_status`, `cmt_date`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Neque vitae tempus quam pellentesque nec nam. Sapien eget mi proin sed libero enim sed faucibus turpis. Convallis tellus id interdum velit laoreet id. Egestas tellus rutrum tellus pellentesque. Sodales ut eu sem integer. ', 5, 1, 0, 1, 0, '2020-10-24 10:51:35'),
(2, 'Praesent elementum facilisis leo vel fringilla est ullamcorper eget.', 5, 1, 1, 0, 0, '2020-10-24 10:52:21'),
(3, 'Well Played', 5, 3, 0, 0, 0, '2020-10-24 12:56:06'),
(4, 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 4, 1, 1, 0, '2020-10-24 13:32:59'),
(5, 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, 12, 3, 1, 0, '2020-10-24 14:02:14'),
(6, 'Be sure to use an appropriate type attribute on all inputs (e.g., email for email address or number for numerical information) to take advantage of newer input controls like email verification, number selection, and more.', 4, 13, 0, 1, 0, '2020-10-24 16:24:46'),
(7, 'Praesent elementum facilisis leo vel fringilla est ullamcorper eget.', 5, 14, 1, 0, 0, '2020-10-24 21:04:38'),
(8, 'Well Played BY FCB', 5, 3, 1, 1, 0, '2020-10-28 07:19:50'),
(9, 'Google Pixel is a great phone', 4, 14, 0, 1, 0, '2020-10-28 16:27:23'),
(10, 'Well THen.', 4, 4, 9, 1, 1, '2020-10-28 16:29:02');

-- --------------------------------------------------------

--
-- Table structure for table `meta_tags`
--

CREATE TABLE `meta_tags` (
  `meta_id` int(11) NOT NULL,
  `meta_info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meta_tags`
--

INSERT INTO `meta_tags` (`meta_id`, `meta_info`) VALUES
(1, 'PHP'),
(2, 'Laravel'),
(3, 'Fashion'),
(4, 'Tech'),
(5, 'Computer');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `meta` varchar(255) NOT NULL,
  `post_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `title`, `description`, `image`, `category_id`, `author_id`, `status`, `meta`, `post_date`) VALUES
(1, 'PHP, Laravel is a powerful framework', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '9878_Mask Group 92.png', 2, 1, 1, 'php', '2020-09-27 11:33:00'),
(3, 'The Latest Research for Web Designers, September 2020', 'In today’s look at the latest research for web designers, we’re going to look at studies and reports from Payoneer, Robert Half, Hootsuite, and Contentsquare to see what they have to say about things like:\r\n\r\nCurrent freelancer demand\r\nWeb designer earning potential\r\nA change in ecommerce shopping trends\r\nUnseen content rates\r\n\r\nLess than 17% of freelancers experienced an increase in demand for their services and less than 23% saw demand remain the same.\r\n\r\nAn overwhelming majority of freelancers experienced a shrink in demand, with nearly 29% saying it slightly decreased while almost 32% said it greatly decreased.\r\n\r\nHowever, the data collected wasn’t just assessed on a global scale. Payoneer also looked at freelancing demand trends in various parts of the world:\r\n\r\nNotice the differences between Asia and Australia (who were hit with COVID-19 earlier) and North America and Europe (where the pandemic arrived a little later).\r\n\r\nIt appears as though Asian and Australian freelancers are, economically speaking, already starting to feel the effects of recovery from the pandemic with demand working in their favor.\r\n\r\nSo, if you’re feeling like there’s no end to the hardships you’ve faced during COVID-19, and were considering dropping your prices, hold on for just a little bit longer. Freelancers are starting to feel optimistic about demand for their services increasing. If you go devaluing yourself now, it’ll be hard to return to where you were before COVID-19 when things get back to normal.', '749079_728299_Mask Group 102.png', 1, 8, 1, 'research', '2020-10-05 04:24:00'),
(4, 'Google Pixel 5 Hands-On Video Surfaces, Shows Under-Display Top Speaker', 'Google Pixel 5 hands-on video has been posted by a UK-based YouTuber. The tech giants 2020 flagship phone was launched earlier this month alongside the Google Pixel 4a 5G. The video shows off the phones design along with its cameras and a few benchmarking tests. The hands-on video also shows the absence of a top speaker at the front, indicating the presence of an under-display speaker on the phone. Limited to 5G countries, the Google Pixel 5 will be available across nine countries including Australia, Japan, the UK, and the US from October 15.\r\n\r\nYouTuber totallydubbedHD posted two videos on his channel. The first is a first look feature of the phone, and the second is a hands-on video where the YouTuber answers some of the questions addressed to him by his followers on the social media. The YouTuber also clarifies that the showcased Google Pixel 5 was provided by Vodafone UK without any form of embargo in place.\r\n\r\nThe first look video shows that the phone comes with a USB Type-C to Type-C cable, a Type-C to Type-A adapter, and a Type-C adapter in the box. It must be noted that the box seen in the video is specific to UK markets. The dual camera setup is seen inside a square-shaped module on the back. Although the module protrudes a little, the YouTuber said it doesnt make the phone wobbly when placed on a surface. The selfie camera is seen inside a hole-punch cutout at the top left corner of the screen.\r\n\r\nNo front speakers were spotted on the phone. A hardware diagram of the Google Pixel 5 was earlier spotted on Reddit hinted at an under-display speaker on the phone. Now, the launch renders of the phone and the latest hands-on video shows that the phone indeed carries a speaker placed below the phones 6-inch OLED display.\r\n\r\nIn the second video, totallydubbedHD shows off the various features of the phone, based on followers  questions. The video shows off elements such as the phones wireless charging, display brightness, battery life, camera app, video stabilisation, and more.', '451426_Google-Pixel-4-.jpg', 7, 8, 1, 'phone', '2020-10-05 04:00:00'),
(5, 'Barcelona and Sevilla remain unbeaten after Camp Nou draw', '(Reuters) - Philippe Coutinho scored his first league goal since returning to Barcelona to help his side draw 1-1 at home to an excellent Sevilla side in La Liga on Sunday as the Catalans dropped points for the first time under Ronald Koeman. Europa League holders Sevilla took an early lead when Dutch forward Luuk de Jong pounced on a poor headed clearance in the area and smashed into the net, flummoxing Barca keeper Neto. But the Catalans hit back less than two minutes later when club record signing Coutinho, back at the club after spending last year on loan with Bayern Munich, reacted fastest to fire home after a Lionel Messi pass was deflected into his path.\r\n\r\nAntoine Griezmann missed a good chance to give Barca the lead before halftime but hit the side netting while midfielder Frenkie de Jong should have scored late in the second half but missed the target from inside the area. Sevilla could also have snatched a winner, with Youssef En-Nesyri seeing a deflected shot hit the crossbar before failing to test Neto with a free header.\r\n\r\nBarca and Sevilla each have seven points after three games and are fifth and sixth in the standings, with champions Real Madrid top on 10. The Catalans had made a superb start to the campaign under new coach Koeman, hammering Villarreal 4-0 in their opening game before pulling off an impressive 3-0 win at Celta Vigo despite having 10 men for the entire second half.\r\n\r\nBut they met a very different challenge in Sevilla, who finished fourth in the league last season. We knew this would be a really difficult game and so it proved, Sevilla are an excellent team and they played very well, they flooded the midfield and we struggled to cope with that but at least we earned a point, Coutinho said. Its been difficult for us to play three games in one week but this is just the start, we will soon get used to this. Sevilla coach Julen Lopetegui felt his side deserved more. It is very difficult to leave this ground with a point but I am not satisfied because we had our chances, he said. It was tough because they are a great team but its a real shame we couldnt have got more from the game. We are playing with a lot of confidence at the moment but we should demand a little more from ourselves.\r\n\r\nBarcas new signing Sergino Dest made his debut three days after completing his switch from Ajax, coming off the bench to replace the injured Jordi Alba.', '473912_1601831689_795472_1601845160_noticia_normal.jpg', 10, 8, 1, 'football', '2020-10-05 01:00:00'),
(6, 'A new approach to artificial intelligence that builds in uncertainty', 'A decontamination robot funded by the Office of Naval Research (ONR) and designed by several local universities was recently tested in Richmond Va. The robot—initially designed for shipboard firefighting and maintenance tasks—has now been enlisted in the fight against COVID-19.\r\nThe robot has four wheels and a mechanical arm that uses short-wave ultraviolet (UVC) light to decontaminate surfaces. Its current version requires humans to oversee and drive the robot, but the hope is the robot will become fully autonomous.\r\n\r\nThe value of robots to deploy UVC lamps for decontamination is that you can reduce exposure of humans to the UVC light, and the robot can reposition the lamps over surfaces you wish to decontaminate, using its arms, said Dr. Thomas McKenna, a program officer in ONRs Warfighter Performance Department. When the robot was designed, there was no COVID, but the combination of mobility and manipulation are a good match to this task.', '79819_latest-developments-in-robotics.jpg', 2, 8, 1, 'robotics,technology,programming', '2020-10-24 02:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` int(1) NOT NULL COMMENT '1=Admin, 2=Editor',
  `status` int(1) NOT NULL COMMENT '0=Inactive, 1=Active',
  `image` text DEFAULT NULL,
  `join_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `address`, `phone`, `role`, `status`, `image`, `join_date`) VALUES
(1, 'Md. Faisal Hamid Hemel', 'faisal@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'Mirpur, Dhaka', '01715234605', 2, 1, 'faisal.jpg', '2020-09-08'),
(2, 'Toufiqul bari', 'tonoy@shikhbeshobai.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Kallyanpur, Dhaka', '01759999999', 2, 1, '288603_729603_Capture.PNG', '2020-09-13'),
(8, 'Fahim Tayebee', 'fahim72@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Rajshahi', '01765649100', 1, 1, '_MG_9707.jpg', '2020-10-01'),
(9, 'Dev', 'dev@gmail.com', '6bb0e3b82a69a2bdf7139d17eeb5f79818b92a4d', 'Dhaka', '01765649100', 2, 0, NULL, '2020-10-01');

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `visitor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `image` text DEFAULT NULL,
  `id_status` int(1) NOT NULL DEFAULT 1,
  `join_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`visitor_id`, `name`, `email`, `password`, `status`, `image`, `id_status`, `join_date`) VALUES
(1, 'Mohaiminul', 'mohaiminul14@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, '12432_image.jpg', 1, '2020-10-24'),
(3, 'Anu', 'ahmed45@gmail.com', 'f350d780ea8aaa48030b4db64f790c14dbcd757f', 1, '', 1, '2020-10-24'),
(4, 'Sam', 'sam33@gmail.com', '123456', 1, '', 1, '2020-10-24'),
(12, 'Jamy', 'jamy78@gmail.com', '98df2d0f39e0c53f65b02b5ab9c031f697191def', 1, '', 1, '2020-10-24'),
(13, 'Jack', 'jack23@gmail.com', '3837847', 1, '', 1, '2020-10-24'),
(14, 'Jack', 'jack90@gmail.com', '6970371', 1, '', 1, '2020-10-24');

-- --------------------------------------------------------

--
-- Table structure for table `web_info`
--

CREATE TABLE `web_info` (
  `web_id` int(11) NOT NULL,
  `web_name` varchar(255) NOT NULL,
  `web_fav` text NOT NULL,
  `web_logo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `web_info`
--

INSERT INTO `web_info` (`web_id`, `web_name`, `web_fav`, `web_logo`) VALUES
(1, 'UBBLOGER', 'web_fav.png', 'web_logo.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cmt_id`);

--
-- Indexes for table `meta_tags`
--
ALTER TABLE `meta_tags`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`visitor_id`);

--
-- Indexes for table `web_info`
--
ALTER TABLE `web_info`
  ADD PRIMARY KEY (`web_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `cmt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `meta_tags`
--
ALTER TABLE `meta_tags`
  MODIFY `meta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `visitor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `web_info`
--
ALTER TABLE `web_info`
  MODIFY `web_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
