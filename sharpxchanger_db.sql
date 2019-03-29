-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2019 at 01:47 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sharpxchanger_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_additional_info`
--

CREATE TABLE `tbl_additional_info` (
  `id` int(11) NOT NULL,
  `notice1` text CHARACTER SET utf8,
  `notice2` text CHARACTER SET utf8,
  `activeStatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_additional_info`
--

INSERT INTO `tbl_additional_info` (`id`, `notice1`, `notice2`, `activeStatus`) VALUES
(1, 'যে কোন প্রয়োজনে আমাদের সাথে যোগাযোগ করুন এবং লেনদেন শেষে আমাদের TESTIMONIALS দিতে ভুলবেন না।', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_info`
--

CREATE TABLE `tbl_admin_info` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_uname` varchar(50) NOT NULL,
  `admin_passwd` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin_info`
--

INSERT INTO `tbl_admin_info` (`admin_id`, `admin_name`, `admin_email`, `admin_uname`, `admin_passwd`) VALUES
(1, 'Md Imran Hadid', 'imranhadid03@gmail.com', 'admin@imran', '$2y$10$TH7Yqwch/vY4ID7ZTpFhY.YbwYYWtopXxKEJFpZk7qSfvUpiBXp3m'),
(2, 'Nur nobi', 'earnnurnobi@gmail.com', 'admin@nur', '$2y$10$TH7Yqwch/vY4ID7ZTpFhY.YbwYYWtopXxKEJFpZk7qSfvUpiBXp3m'),
(3, 'Mostakim Hossain', 'dr.mostakim2@gmail.com', 'admin@robin', '$2y$10$TH7Yqwch/vY4ID7ZTpFhY.YbwYYWtopXxKEJFpZk7qSfvUpiBXp3m');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_notification`
--

CREATE TABLE `tbl_admin_notification` (
  `notify_id` int(11) NOT NULL,
  `notify_text` text NOT NULL,
  `notify_url` varchar(20) NOT NULL,
  `notify_imran` int(11) NOT NULL,
  `notify_nur` int(11) NOT NULL,
  `notify_robin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_info`
--

CREATE TABLE `tbl_contact_info` (
  `contact_id` int(11) NOT NULL,
  `contact_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `contact_mail` varchar(50) NOT NULL,
  `contact_sub` text CHARACTER SET utf8 NOT NULL,
  `contact_text` mediumtext CHARACTER SET utf8 NOT NULL,
  `contact_date` varchar(40) NOT NULL,
  `contact_ip` varchar(16) NOT NULL,
  `contact_platform` varchar(20) NOT NULL,
  `contact_browser` varchar(10) NOT NULL,
  `contact_version` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exchange_info`
--

CREATE TABLE `tbl_exchange_info` (
  `exchange_id` int(11) NOT NULL,
  `gateway_sell` varchar(50) NOT NULL,
  `gateway_recieve` varchar(50) NOT NULL,
  `amount_sell` int(11) NOT NULL,
  `amount_recieve` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `gateway_info_address` varchar(100) NOT NULL,
  `transaction_id` varchar(200) NOT NULL,
  `additional_info` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `date` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gateway_info`
--

CREATE TABLE `tbl_gateway_info` (
  `gateway_id` int(11) NOT NULL,
  `gateway_name` varchar(50) NOT NULL,
  `gateway_address` varchar(200) NOT NULL,
  `username` varchar(40) NOT NULL,
  `we_buy` int(11) NOT NULL,
  `we_sell` int(11) NOT NULL,
  `date` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_gateway_info`
--

INSERT INTO `tbl_gateway_info` (`gateway_id`, `gateway_name`, `gateway_address`, `username`, `we_buy`, `we_sell`, `date`) VALUES
(1, 'Bkash Personal', '0111111111111', 'admin', 1, 1, 'March 21, 2019, Thursday 11:19 pm'),
(2, 'DBBL Rocket', '0111111111111', 'admin', 1, 1, 'March 21, 2019, Thursday 11:19 pm'),
(3, 'Coinbase', 'sxc@coinbase.com', 'demo', 82, 92, 'February 26, 2019'),
(4, 'Ethereum', 'sxc@ethereum.com', 'demo', 82, 90, 'February 26, 2019'),
(5, 'Neteller', 'sxc@neteller.com', 'demo', 85, 95, 'February 26, 2019'),
(6, 'Payza', 'sxc@payza.com', 'demo', 84, 90, 'February 26, 2019'),
(7, 'Skrill', 'sxc@skrill.com', 'demo', 85, 95, 'February 26, 2019');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page_settings`
--

CREATE TABLE `tbl_page_settings` (
  `page_id` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `title` varchar(20) NOT NULL,
  `url` varchar(20) NOT NULL,
  `text` mediumtext,
  `update_on` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_page_settings`
--

INSERT INTO `tbl_page_settings` (`page_id`, `username`, `title`, `url`, `text`, `update_on`) VALUES
(1, 'admin', 'About Us', 'aboutUs.html', '<p>Welcome to SharpXchange!! Here you can exchange your money in a moment. We are the first people in Bangladesh who are working with all types of cryptocurrencies. For Freelancers, here is an innovative arrangement of money. From here you can exchange money from Bangladeshi taka in dollars or USD to BDT. Can be used to change the widely used international wallet in a few moments. Customers can avail of this facility from anywhere in Bangladesh. We receive all countries currency to exchange dollars to specific currency what you want from all over the world. Our Exchange Services Skrill, Neteller, all cryptocurrency.</p>\r\n\r\n<p>In the era of modern e-commerce, the SharpXchange has begun to focus on the ease and simplicity of money transactions on the Internet. Especially in recent times, foreign currency transactions are increasing. Use SharpXchange to eliminate the unauthorized fraud and suffering of different currency transactions. However, the SharpXchange online payment gateway has been playing a significant role in money transactions on the internet so far.</p>\r\n\r\n<p>There is no limit to receiving or transferring money to the personal account. However, if the user accepts the money or receives a dollar, the charge will be 4% from the principal. However, one of the advantages is that the registration of the user through their own referral link or the currency exchange can be 0.5% bonus. If the website or blog is linked to your referral link, then the commission will receive a service exchange.</p>\r\n\r\n<p>Benefits of using SharpXchange</p>\r\n\r\n<ul>\r\n	<li>SharpXchange for Bangladesh is a good exchange of currency. We provide specialized services for Bangladesh through SharpXchange</li>\r\n	<li>You can exchange money at any time through bKash, Rocket, Dutch Bangla Bank.</li>\r\n	<li>From your SharpXchange account, you can load the dollar into the international wallet.</li>\r\n	<li>Many online shops in Bangladesh support the page, so you can buy the product from a lot of shop with the penny account.</li>\r\n</ul>\r\n', 'March 27, 2019, Wednesday 4:46 pm'),
(2, 'admin', 'Privacy Policy', 'policy.html', '<p>At SharpXchange we are committed to ensuring and protecting your privacy and any personal information will be processed fairly and in accordance with all applicable laws. Before you register with us you should read this Privacy Policy because when you register with us or ask us to provide you with any of our products or services, you agree that we may handle your information, including but not limited to your name, address, contact details, payment / beneficiary information, social security number (if collected), passport / NID information, in accordance with this Privacy Policy. Updates to our Privacy Policy happen periodically by posting the latest version here. Our Privacy Policy covers how we use and store your personal information.</p>\r\n\r\n<h2><strong>We use your information for the following purposes:</strong></h2>\r\n\r\n<h3><strong>Registration and administration:</strong></h3>\r\n\r\n<p>We use your information to enable you to open an account with us. Once you have an account with us we will use your details to contact you and to reply to any queries or requests made by you. We may use your information in the administration of your account, which includes us periodically contacting you in order to update your account details (this assists us with keeping our records as up to date as possible) or in order to notify you of changes or improvements to our products or services that may affect our service to you. We will also use your information should we need to enforce our rights.</p>\r\n\r\n<h3><strong>Our products and services:</strong></h3>\r\n\r\n<p>We use your information in order to supply our products and services and to meet our contractual obligations to you. We may supply you with information on our products and services - this would mean that you would be receiving marketing and promotional emails from us. If you do not wish to receive such communications please either contact us or use the checkbox provided during the registration process.</p>\r\n', 'March 27, 2019, Wednesday 5:14 pm');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reserve_list`
--

CREATE TABLE `tbl_reserve_list` (
  `reserve_id` int(11) NOT NULL,
  `gateway_name` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `update_date` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_reserve_list`
--

INSERT INTO `tbl_reserve_list` (`reserve_id`, `gateway_name`, `amount`, `username`, `update_date`) VALUES
(1, 'Bkash Personal', 40000, 'admin@imran', 'March 28, 2019, Thursday 7:54 pm'),
(2, 'DBBL Rocket', 40000, 'admin', 'March 21, 2019, Thursday 9:42 pm'),
(3, 'Coinbase', 400, 'admin', 'March 21, 2019, Thursday 9:43 pm'),
(4, 'Ethereum', 200, 'admin', 'March 21, 2019, Thursday 9:44 pm'),
(5, 'Neteller', 150, 'admin', 'March 21, 2019, Thursday 9:45 pm'),
(6, 'Payza', 100, 'admin', 'March 21, 2019, Thursday 9:44 pm'),
(7, 'Skrill', 50, 'demo', 'February 26, 2019');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_info`
--

CREATE TABLE `tbl_user_info` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `phone` int(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `passwd` varchar(200) NOT NULL,
  `signup_time` varchar(40) NOT NULL,
  `signup_ip` varchar(15) NOT NULL,
  `acc_update` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_info`
--

INSERT INTO `tbl_user_info` (`user_id`, `first_name`, `last_name`, `username`, `phone`, `gender`, `email`, `passwd`, `signup_time`, `signup_ip`, `acc_update`) VALUES
(1, 'Imran', 'Hadid', 'demo', 24567890, 'Male', 'imranhadid03@gmail.com', '$2y$10$p8um0QiSgRLb9rAjBh89/.rWBYXHMDg2uswLkfOcfqsrtHlhxZHqe', 'March 9, 2019, Saturday 1:26 am', '127.0.0.1', 'March 15, 2019, Friday 11:47 pm');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_testimonials`
--

CREATE TABLE `tbl_user_testimonials` (
  `testimonial_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `testimonial_text` mediumtext CHARACTER SET utf8 NOT NULL,
  `view` int(5) NOT NULL,
  `status` varchar(10) NOT NULL,
  `date` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_additional_info`
--
ALTER TABLE `tbl_additional_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_info`
--
ALTER TABLE `tbl_admin_info`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_admin_notification`
--
ALTER TABLE `tbl_admin_notification`
  ADD PRIMARY KEY (`notify_id`);

--
-- Indexes for table `tbl_contact_info`
--
ALTER TABLE `tbl_contact_info`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `tbl_exchange_info`
--
ALTER TABLE `tbl_exchange_info`
  ADD PRIMARY KEY (`exchange_id`);

--
-- Indexes for table `tbl_gateway_info`
--
ALTER TABLE `tbl_gateway_info`
  ADD PRIMARY KEY (`gateway_id`);

--
-- Indexes for table `tbl_page_settings`
--
ALTER TABLE `tbl_page_settings`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `tbl_reserve_list`
--
ALTER TABLE `tbl_reserve_list`
  ADD PRIMARY KEY (`reserve_id`);

--
-- Indexes for table `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_user_testimonials`
--
ALTER TABLE `tbl_user_testimonials`
  ADD PRIMARY KEY (`testimonial_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_additional_info`
--
ALTER TABLE `tbl_additional_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_admin_info`
--
ALTER TABLE `tbl_admin_info`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_admin_notification`
--
ALTER TABLE `tbl_admin_notification`
  MODIFY `notify_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_contact_info`
--
ALTER TABLE `tbl_contact_info`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_exchange_info`
--
ALTER TABLE `tbl_exchange_info`
  MODIFY `exchange_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_gateway_info`
--
ALTER TABLE `tbl_gateway_info`
  MODIFY `gateway_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_page_settings`
--
ALTER TABLE `tbl_page_settings`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_reserve_list`
--
ALTER TABLE `tbl_reserve_list`
  MODIFY `reserve_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user_testimonials`
--
ALTER TABLE `tbl_user_testimonials`
  MODIFY `testimonial_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
