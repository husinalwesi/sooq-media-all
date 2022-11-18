-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2020 at 11:25 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sooq`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup_log`
--

CREATE TABLE `backup_log` (
  `id` int(11) NOT NULL,
  `created_date` varchar(10) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `backup_log`
--

INSERT INTO `backup_log` (`id`, `created_date`, `admin_id`) VALUES
(1, '1555323997', 1),
(15, '1592519293', 1),
(16, '1592527633', 1),
(17, '1592537448', 1),
(18, '1593115274', 1),
(19, '1593260729', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `start_date` varchar(10) NOT NULL,
  `end_date` varchar(10) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_amount` int(11) NOT NULL,
  `created_date` varchar(10) NOT NULL,
  `modified_date` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `is_ignored` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`id`, `client_id`, `start_date`, `end_date`, `employee_id`, `amount`, `payment_amount`, `created_date`, `modified_date`, `user_id`, `is_deleted`, `is_ignored`) VALUES
(11, 9, '', '', 4, 200, 100, '1593329948', '0', 1, 0, 0),
(12, 3, '', '', 4, 250, 120, '1593330066', '0', 1, 0, 0),
(13, 7, '', '', 4, 300, 150, '1593330106', '0', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contract_timeline`
--

CREATE TABLE `contract_timeline` (
  `id` int(11) NOT NULL,
  `start_month` int(11) NOT NULL,
  `start_year` int(11) NOT NULL,
  `end_month` int(11) NOT NULL,
  `end_year` int(11) NOT NULL,
  `created_date` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `modified_date` varchar(10) NOT NULL,
  `contract_id` int(11) NOT NULL,
  `start_date` varchar(10) NOT NULL,
  `end_date` varchar(10) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contract_timeline`
--

INSERT INTO `contract_timeline` (`id`, `start_month`, `start_year`, `end_month`, `end_year`, `created_date`, `user_id`, `is_deleted`, `modified_date`, `contract_id`, `start_date`, `end_date`, `amount`, `payment_amount`) VALUES
(13, 0, 0, 0, 0, '1593329948', 1, 0, '0', 11, '1592254800', '1594846800', 200, 100),
(14, 0, 0, 0, 0, '1593330066', 1, 0, '0', 12, '1590958800', '1593464400', 250, 120),
(15, 0, 0, 0, 0, '1593330106', 1, 0, '0', 13, '1592946000', '1595538000', 300, 150);

-- --------------------------------------------------------

--
-- Table structure for table `online_finance_managment`
--

CREATE TABLE `online_finance_managment` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `title_finance` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `created_date` varchar(10) NOT NULL,
  `modified_date` varchar(10) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `finance_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `online_finance_managment`
--

INSERT INTO `online_finance_managment` (`id`, `client_id`, `title_finance`, `amount`, `user_id`, `status`, `created_date`, `modified_date`, `is_deleted`, `finance_date`) VALUES
(14, 3, 'عرض الإثنين', 25, 4, 1, '1593330334', '1593330470', 0, '06/24/2020 12:00 AM - 06/29/2020 11:59 PM'),
(15, 7, 'تمويل 1', 30, 4, 1, '1593330389', '1593330515', 0, '06/23/2020 12:00 AM - 06/25/2020 11:59 PM'),
(16, 9, 'عرض عيد الأم', 35, 4, 1, '1593330407', '1593330520', 0, '06/23/2020 12:00 AM - 06/25/2020 11:59 PM'),
(17, 7, 'تمويل نهاية الشهر', 50, 4, 1, '1593330553', '1593416357', 0, '06/28/2020 12:00 AM - 06/30/2020 11:59 PM');

-- --------------------------------------------------------

--
-- Table structure for table `payment_managment`
--

CREATE TABLE `payment_managment` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `title_finance` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` varchar(10) NOT NULL,
  `modified_date` varchar(10) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_managment`
--

INSERT INTO `payment_managment` (`id`, `client_id`, `title_finance`, `amount`, `user_id`, `created_date`, `modified_date`, `is_deleted`, `month`, `year`, `date`) VALUES
(9, 9, 'دفعة', 100, 1, '1593330048', '0', 0, 0, 0, '1593464400'),
(10, 3, 'دفعة من الحساب', 150, 1, '1593330085', '0', 0, 0, 0, '1593291600'),
(11, 7, 'حساب الشهر', 300, 1, '1593330140', '0', 0, 0, 0, '1593291600');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `mobile_num` varchar(15) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `created_date` varchar(10) NOT NULL,
  `last_login` varchar(10) NOT NULL,
  `last_login_ip` varchar(10) NOT NULL,
  `status` varchar(1) NOT NULL,
  `mobile_num_country_code` varchar(5) NOT NULL,
  `mobile_num_iso_code` varchar(5) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `modified_date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `mobile_num`, `username`, `password`, `img`, `created_date`, `last_login`, `last_login_ip`, `status`, `mobile_num_country_code`, `mobile_num_iso_code`, `fullname`, `email`, `is_deleted`, `user_type`, `first_name`, `last_name`, `modified_date`) VALUES
(1, '798982102', 'ادمن', 'e10adc3949ba59abbe56e057f20f883e', '', '1514576726', '1533909506', '86.108.75.', '1', 'jo', '962', 'حسين الويسي', 'alwesihusin@gmail.com', 0, 'admin', 'حسين', 'الويسي', '1592537363'),
(3, '798652453', 'بوبايز', 'e10adc3949ba59abbe56e057f20f883e', '0', '1592535490', '0', '0', '0', 'jo', '962', 'محمد العسلي', 'info@popayes.com', 0, 'client', 'محمد', 'العسلي', '1592535585'),
(4, '798653685', 'رامي', 'e10adc3949ba59abbe56e057f20f883e', '0', '1592535671', '0', '0', '0', 'jo', '962', 'رامي دعيس', 'arleen@gmail.com', 0, 'employee', 'رامي', 'دعيس', '1592537713'),
(5, '798210222', 'السبعاوي', 'fbe82b93c071bedda31afded400cca52', '0', '1592537638', '0', '0', '0', 'jo', '962', 'fg bf', 'xxx@xcxc', 1, 'client', 'fg', 'bf', '0'),
(6, '799999999', 'master_admin', 'e10adc3949ba59abbe56e057f20f883e', '', '1592537638', '', '', '', 'jo', '962', 'Master Admin', 'x@x.com', 0, 'admin', 'Master', 'Admin', ''),
(7, '798982456', 'سيلزي', 'e10adc3949ba59abbe56e057f20f883e', '0', '1592914018', '0', '0', '0', 'jo', '962', 'محمد منصور', 'mohammad@mansour.com', 0, 'client', 'محمد', 'منصور', '0'),
(8, '798546215', 'اسماء منصور', 'e10adc3949ba59abbe56e057f20f883e', '0', '1592914075', '0', '0', '0', 'jo', '962', 'اسماء منصور', 'asmaa@mansour.com', 0, 'employee', 'اسماء', 'منصور', '0'),
(9, '798652456', 'اكشن موبايل', 'e10adc3949ba59abbe56e057f20f883e', '0', '1593083369', '0', '0', '0', 'jo', '962', 'خالد عبد الرحيم', 'khaled@abdraheem.com', 0, 'client', 'خالد', 'عبد الرحيم', '0'),
(10, '454555', 'بيت الكباب', 'e10adc3949ba59abbe56e057f20f883e', '0', '1593114617', '0', '0', '0', 'jo', '962', 'اكرم خالد', 'dsads@fds.com', 0, 'client', 'اكرم', 'خالد', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backup_log`
--
ALTER TABLE `backup_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contract_timeline`
--
ALTER TABLE `contract_timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_finance_managment`
--
ALTER TABLE `online_finance_managment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_managment`
--
ALTER TABLE `payment_managment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backup_log`
--
ALTER TABLE `backup_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `contract`
--
ALTER TABLE `contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contract_timeline`
--
ALTER TABLE `contract_timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `online_finance_managment`
--
ALTER TABLE `online_finance_managment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payment_managment`
--
ALTER TABLE `payment_managment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
