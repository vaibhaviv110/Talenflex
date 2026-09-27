-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2026 at 07:50 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobportal1`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `id` int(100) NOT NULL,
  `job_id` int(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `education` varchar(50) NOT NULL,
  `experience` varchar(100) NOT NULL,
  `skills` varchar(255) NOT NULL,
  `resume` varchar(255) NOT NULL,
  `apply_date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`id`, `job_id`, `company_name`, `user_id`, `user_name`, `email`, `mobile`, `education`, `experience`, `skills`, `resume`, `apply_date`, `status`, `message`) VALUES
(1, 5, 'Wipro', 23, '', '', '', '', '', '', '', '2026-07-26', 'Rejected', ''),
(2, 4, 'qutonz', 23, '', '', '', '', '', '', '', '2026-07-26', 'Rejected', ''),
(3, 4, 'qutonz', 25, '', '', '', '', '', '', '', '2026-07-26', 'Accepted', ''),
(4, 5, 'Wipro', 25, '', '', '', '', '', '', 'resume_format_blog_asset-2.jpg', '2026-07-26', 'Pending', ''),
(5, 4, 'qutonz', 26, '', '', '', '', '', '', 'resume_format_blog_asset-2.jpg', '2026-07-26', 'Rejected', ''),
(6, 1, 'unicorn', 28, '', '', '', '', '', '', 'resume_format_blog_asset-2.jpg', '2026-07-26', 'Pending', ''),
(7, 6, 'TCS', 13, '', '', '', '', '', '', 'resume_format_blog_asset-2.jpg', '2026-07-26', 'Pending', ''),
(8, 5, 'Wipro', 11, '', '', '', '', '', '', '3.jpg', '2026-07-26', 'Accepted | Date: 2026-10-02 | Time: 17:15 | Note: in campus', ''),
(9, 1, 'unicorn', 13, '', '', '', '', '', '', 'resume_format_blog_asset-2.jpg', '2026-07-27', 'Rejected', ''),
(10, 9, 'qutonz', 13, '', '', '', '', '', '', 'resume_format_blog_asset-2.jpg', '2026-08-02', 'Accepted', ''),
(11, 11, 'TCS', 40, '', '', '', 'B.Tech', '1 - 2 Years', 'Mechanical Engineering', '1786203334_1.jpg', '2026-08-08', 'Accepted', ''),
(12, 8, 'qutonz', 13, '', '', '', 'BCA', 'Fresher', 'kali linux', '1786245439_4.jpg', '2026-08-09', 'Accepted | Date: 2026-09-09 | Time: 10:15 | Note: company ', ''),
(13, 11, 'TCS', 13, '', '', '', 'B.Tech', 'Fresher', 'computer science', '1786372757_images.png', '2026-08-10', 'Rejected', ''),
(14, 3, 'qutonz', 28, '', '', '', 'MCA', '1 - 2 Years', 'php,mysql', '1786377185_resume_format_blog_asset-2.jpg', '2026-08-10', 'Accepted', ''),
(15, 2, 'unicorn', 28, '', '', '', 'MCA', '1 - 2 Years', 'php,mysql', '1786377968_resume_format_blog_asset-2.jpg', '2026-08-10', 'Pending', ''),
(16, 10, 'qutonz', 40, '', '', '', 'MCA', 'Fresher', 'python', '1786788368_user.png', '2026-08-15', 'Accepted | Date: 2026-09-14 | Time: 15:15 | Note: office', ''),
(17, 3, 'qutonz', 13, '', '', '', 'BCA', '1 - 2 Years', 'mysql', '1787480755_Screenshot (362).png', '2026-08-23', 'Accepted | Date: 2026-09-04 | Time: 10:25 | Note: company', ''),
(18, 13, 'Wipro', 0, 'jensi pethani', '', '', 'BCA', '6 Months Internship', 'powerbi,excel', '1789880519_resume_format_blog_asset-2.jpg', '2026-09-20', 'Accepted | Date: 2026-10-05 | Time: 11:35 | Note: company', '');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`c_id`, `c_name`) VALUES
(1, 'Ahmedabad'),
(2, 'Surat'),
(3, 'Vadodara'),
(4, 'Rajkot'),
(5, 'Gandhinagar'),
(6, 'Bhavnagar'),
(7, 'Jamnagar'),
(8, 'Anand'),
(9, 'Bharuch'),
(16, 'Junagadh'),
(17, 'Vapi'),
(19, 'Amreli'),
(21, 'Pune'),
(22, 'Mumbai');

-- --------------------------------------------------------

--
-- Table structure for table `comadd_job`
--

CREATE TABLE `comadd_job` (
  `id` int(20) NOT NULL,
  `c_id` int(20) NOT NULL,
  `com_name` varchar(30) NOT NULL,
  `job_title` varchar(40) NOT NULL,
  `job_type` varchar(40) NOT NULL,
  `location` varchar(50) NOT NULL,
  `salary` int(50) NOT NULL,
  `description` text NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comadd_job`
--

INSERT INTO `comadd_job` (`id`, `c_id`, `com_name`, `job_title`, `job_type`, `location`, `salary`, `description`, `views`) VALUES
(1, 0, 'unicorn', 'PHP Developer', 'Full Time', 'surat', 15000, 'We are looking for a PHP Developer with knowledge of HTML, CSS, Bootstrap, JavaScript, PHP and MySQL. Freshers can also apply.', 0),
(2, 0, 'unicorn', 'PHP Developer', 'Full Time', 'surat', 14000, 'css,javascript,bootsrap', 0),
(3, 0, 'qutonz', 'PHP Developer', 'Full Time', 'surat', 15000, 'css,bootstrap', 0),
(4, 0, 'qutonz', 'cyber security', 'Full Time', 'mumbai', 50000, 'linux,unix', 0),
(5, 0, 'Wipro', 'UI/UX & Graphics Designer', 'Full Time', 'Vadodara', 35000, 'photoshop,adobe,figma', 0),
(6, 0, 'TCS', 'UI/UX & Graphics Designer', 'Remote', 'pune', 42000, 'all design', 0),
(7, 0, 'qutonz', 'PHP Developer', 'Part Time', 'Vadodara', 15000, 'html,css\r\n', 0),
(8, 0, 'qutonz', 'cyber security', 'Internship', 'Vadodara', 45000, 'kalilinux', 0),
(9, 0, 'qutonz', 'Data science', 'Part Time', 'mumbai', 50000, 'excel', 0),
(10, 0, 'qutonz', 'software engineering', 'Part Time', 'Vadodara', 45000, 'python,java,c++', 0),
(11, 0, 'TCS', 'Mechanical Engineering', 'Part Time', 'Pune', 55000, 'Computer Science, Mechanical, Electrical,', 0),
(12, 5, 'Wipro', 'AI/LLM Engineer', 'Full Time', 'Pune', 45000, 'power BI,Excel', 0),
(13, 16, 'Wipro', 'AI/LLM Engineer', 'Internship', 'Vadodara', 30000, 'Excel,python', 0),
(14, 4, 'unicorn', 'Construction', 'Part Time', '', 35000, 'enginerring', 0),
(15, 0, 'Wipro', 'Construction', 'Full Time', 'Vadodara', 42000, 'Enginerring', 0),
(16, 0, 'Wipro', 'Digital Marketing', 'Part Time', 'Rajkot', 20000, 'designing', 0);

-- --------------------------------------------------------

--
-- Table structure for table `companyreg`
--

CREATE TABLE `companyreg` (
  `cid` int(20) NOT NULL,
  `c_id` int(20) NOT NULL,
  `name` varchar(18) NOT NULL,
  `email` varchar(25) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` varchar(25) NOT NULL,
  `industry` varchar(200) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `companyreg`
--

INSERT INTO `companyreg` (`cid`, `c_id`, `name`, `email`, `mobile`, `address`, `industry`, `password`) VALUES
(1, 0, 'qutonz', 'qu12@gmail.com', '', 'Rajkot', '', '987654'),
(2, 0, 'unicorn', 'u56@gmail.com', '', 'Ahemdabad', '', '987654ewsdfghjn'),
(3, 0, 'unicorn', 'u56@gmail.com', '', 'Ahemdabad', '', '987654ewsdfghjn'),
(4, 0, 'unicorn', 'u56@gmail.com', '', 'Ahemdabad', '', '987654ewsdfghjn'),
(5, 0, 'qutonz', 'q@gmail.com', '', 'Rajkot', 'Cyber Security', '123'),
(6, 0, 'unicorn', 'u@gmail.com', '', 'surat', 'Manufacturing', '123'),
(7, 0, 'unicorn', 'u12@gmail.com', '', 'vadodara', 'Software Development', '1234'),
(8, 0, 'unicorn', 'u12@gmail.com', '', 'vadodara', 'Software Development', '1234'),
(9, 0, 'unicorn', 'u12@gmail.com', '', 'vadodara', 'Construction', '1234'),
(10, 0, 'unicorn', 'u12@gmail.com', '', 'vadodara', 'Construction', '123'),
(11, 0, 'unicorn', 'u12@gmail.com', '', 'vadodara', 'Cyber Security', '1234'),
(12, 0, 'unicorn', 'u12@gmail.com', '', 'vadodara', 'Cyber Security', '123'),
(13, 0, 'qutonz', 'q@gmail.com', '', 'rajkot', 'Marketing', '12'),
(14, 0, 'qutonz', 'q@gmail.com', '', 'rajkot', 'Marketing', '123'),
(15, 0, 'unicorn', 'uni12@gmail.com', '', 'mumbai', 'Information Technology', '123'),
(16, 0, 'unicorn', 'uni12@gmail.com', '', 'mumbai', 'Information Technology', '1234'),
(17, 0, 'unicorn', 'u@gmail.com', '', 'rajkot', 'Software Development', '123'),
(18, 0, 'TCS', 'tcs@gmail.com', '', 'Dilhi', 'Cyber Security', '123456'),
(19, 0, 'unicorn', 'u@gmail.com', '', 'rajkot', 'Manufacturing', '123'),
(20, 0, 'unicorn', 'u@gmail.com', '', 'vapi', 'Software Development', '123'),
(21, 0, 'qutonz', 'q@gmail.com', '', 'Rajkot', 'Cyber Security', '123'),
(23, 0, 'unicorn', 'u@gmail.com', '', 'vapi\r\n', 'Manufacturing', '789'),
(24, 0, 'qutonz', 'q@gmail.com', '', 'vapi\r\n', 'Information Technology', '123'),
(25, 0, 'Wipro', 'wipro@gmail.com', '', 'ahemdabad', 'Cyber Security', '1212'),
(26, 0, 'TCS', 'tcs12@gmail.com', '', 'vapi', 'Software Development', '098'),
(27, 0, 'Wipro', 'wipro@gmail.com', '', 'Vadodara', 'Software Development', '1234'),
(28, 0, 'Wipro', 'wipro@gmail.com', '', 'Vadodara', 'Software Development', '123'),
(29, 0, 'Wipro', 'wipro@gmail.com', '', 'Vadodara', 'Software Development', '098'),
(30, 0, 'TCS', 'tcs@gmail.com', '', 'Ahemdabad', 'Cyber Security', '1234'),
(31, 0, 'Wipro', 'wipro@gmail.com', '', 'vapi', 'Cyber Security', '123'),
(32, 0, 'TCS', 'tcs@gmail.com', '', 'surat\r\n', 'Cyber Security', '1234'),
(33, 0, 'TCS', 'tcs@gmail.com', '', 'surat\r\n', 'Cyber Security', '123'),
(34, 0, 'google', 'g@gmail.com', '', 'karnatak', 'Software Development', '123');

-- --------------------------------------------------------

--
-- Table structure for table `com_messages`
--

CREATE TABLE `com_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `user_id`, `company_id`, `name`, `email`, `company_name`, `subject`, `message`, `created_at`) VALUES
(1, 0, 0, 'Urmi Usdad', 'usdadurmi@gmail.com', '', 'python', 'hello', '2026-08-09 03:15:31'),
(2, 0, 0, 'Urmi Usdad', 'usdadurmi@gmail.com', '', 'kali linux', 'hello', '2026-08-09 03:19:50'),
(3, 0, 0, 'Urmi Usdad', 'usdadurmi@gmail.com', '', 'python', 'hello\r\n', '2026-08-10 14:41:27'),
(4, 0, 0, 'Urmi Usdad', 'usdadurmi@gmail.com', '', 'python', 'hello', '2026-08-10 14:42:00'),
(5, 0, 0, 'Urmi Usdad', 'usdadurmi@gmail.com', '', 'python', 'hello', '2026-08-10 15:18:32'),
(6, 0, 0, 'Urmi Usdad', 'usdadurmi@gmail.com', '', 'python', 'hello im urmi usdad', '2026-08-10 15:25:03'),
(7, 0, 0, 'bhumi', 'b@gmail.com', '', 'php', '', '2026-08-10 15:54:56'),
(8, 0, 0, 'bhumi', 'b@gmail.com', '', 'php', '', '2026-08-10 16:07:08'),
(9, 0, 0, 'amisha', 'a@gmail.com', 'Qutoz', 'python', 'Hello about this job', '2026-08-15 10:20:30'),
(10, 0, 0, 'Urmi Usdad', 'usdadurmi@gmail.com', 'Qutoz', '.net', 'hello about this job', '2026-08-15 14:48:25'),
(11, 0, 0, 'Urmi Usdad', 'usdadurmi@gmail.com', 'TCS', 'php', 'hello', '2026-08-15 14:53:20'),
(12, 0, 0, 'amisha', 'a@gmail.com', 'Qutoz', 'job query', 'welcome', '2026-08-15 15:17:09'),
(13, 0, 0, 'amisha', 'a@gmail.com', 'Qutoz', 'job query', 'welcome to ', '2026-08-15 15:19:30'),
(14, 0, 0, 'amisha', 'a@gmail.com', 'Qutoz', 'job query', 'hello', '2026-08-15 15:23:16'),
(15, 0, 0, 'kirti', 'k12@gmail.com', 'Wipro', 'designer', 'hello giving this job', '2026-08-15 15:38:24'),
(16, 0, 0, 'Urmi Usdad', 'usdadurmi@gmail.com', 'Qutoz', 'designer', 'hii', '2026-08-23 10:52:31'),
(17, 0, 0, 'Urmi Usdad', 'usdadurmi@gmail.com', 'Qutoz', 'kali linux', 'hii\r\n\r\n', '2026-08-23 11:02:35'),
(18, 0, 0, 'jensi pethani', 'jp@gmail.com', 'Wipro', 'technical', 'this is company are usa connected', '2026-09-20 05:03:26');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(10) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `gender` varchar(5) NOT NULL,
  `city` varchar(50) NOT NULL,
  `u_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `Name`, `Email`, `Password`, `PhoneNumber`, `gender`, `city`, `u_type`) VALUES
(1, 'bhavy', 'bhavy13@gmail.com', '321456', '1122334455', 'male', 'ahemdabad', 'user'),
(2, 'bhavy', 'bhavy13@gmail.com', '123654', '1122334455', 'male', 'surat', 'user'),
(3, 'bhavy', 'bhavy13@gmail.com', '123654', '1122334455', 'male', 'ahemdabad', 'user'),
(4, 'urmi', 'u12@gmail.com', '1234u', '2147483647', 'femal', 'Rajkot', 'user'),
(5, 'urmi', 'u12@gmail.com', '123u', '2147483647', 'femal', 'Rajkot', 'user'),
(6, 'neer', 'usdad18@gmail.com', 'neer18', '2147483647', 'male', 'surat', 'user'),
(7, 'neer', 'usdad18@gmail.com', 'neer18', '2147483647', 'male', 'surat', 'user'),
(8, 'neer', 'usdad18@gmail.com', '1234', '2147483647', 'male', 'surat', 'user'),
(9, 'vyani', 'v10@gmail.com', 'v123', '2147483647', 'femal', 'vadodara', 'user'),
(10, 'meshiv', 'm12@gmail.com', 'm987', '2147483647', 'male', 'vapi', 'user'),
(11, 'kirti', 'k12@gmail.com', '123', '2147483647', 'femal', 'mumbai', 'user'),
(12, 'ami', 'a@gmail.com', 'a123', '2147483647', 'femal', 'rajkot', 'user'),
(13, 'Urmi Usdad', 'usdadurmi@gmail.com', '1234', '2147483647', 'femal', 'mumbai', 'user'),
(14, 'vaibhavi', 'v@gmail.com', '1234', '2147483647', 'femal', 'vadodara', 'user'),
(15, 'Urmi Usdad', 'usdadurmi@gmail.com', '1234', '2147483647', 'femal', 'vapi', 'user'),
(16, 'Urmi Usdad', 'usdadurmi@gmail.com', '1234', '2147483647', 'femal', 'mumbai', 'user'),
(17, 'naushik', 'n13@gmail.com', '12345', '2147483647', 'male', 'mumbai', 'user'),
(18, 'Urmi Usdad', 'usdadurmi@gmail.com', '1234', '2147483647', 'femal', 'vadodara', 'user'),
(19, 'Urmi Usdad', 'usdadurmi@gmail.com', '1234', '2147483647', 'femal', 'vapi', 'user'),
(20, 'Urmi Usdad', 'usdadurmi@gmail.com', '1234', '2147483647', 'femal', 'mumbai', 'user'),
(21, 'Urmi Usdad', 'usdadurmi@gmail.com', '1234', '2147483647', 'femal', 'Rajkot', 'user'),
(22, 'Urmi Usdad', 'usdadurmi@gmail.com', '1234', '2147483647', 'femal', 'vadodara', 'user'),
(23, 'tarang', 't@gmail.com', 't@123', '2147483647', 'male', 'surat', 'user'),
(24, 'Meshiv', 'm@gmail.com', '1010', '2147483647', 'male', 'Rajkot', 'user'),
(25, 'Meshiv', 'm@gmail.com', '123', '2147483647', 'male', 'Rajkot', 'user'),
(26, 'vyani', 'v12@gmail.com', '123', '2147483647', 'femal', 'vadodara', 'user'),
(27, 'vyani', 'v12@gmail.com', '123', '2147483647', 'femal', 'vadodara', 'user'),
(28, 'bhumi', 'b@gmail.com', '1234', '2147483647', 'femal', 'vapi', 'user'),
(29, 'Urmi Usdad', 'usdadurmi@gmail.com', '1234', '2147483647', 'femal', 'vapi', 'user'),
(30, 'kirti', 'k12@gmail.com', '123', '2147483647', 'femal', 'surat', 'user'),
(31, 'kirti', 'k12@gmail.com', '123', '2147483647', 'femal', 'surat', 'user'),
(32, 'Urmi Usdad', 'usdadurmi@gmail.com', '1234', '2147483647', 'femal', 'vapi', 'user'),
(33, 'kailash', 'kailashkunjadiya@gmail.com', '123', '2147483647', 'femal', 'mumbai', 'user'),
(34, 'kailash Kunjadiya  ', 'kailashkunjadiya@gmail.com', '123', '2147483647', 'femal', 'vapi', 'user'),
(35, 'vyanktas', 'v@gmail.com', '123', '2147483647', 'femal', 'surat', 'user'),
(36, 'abc_candidate', 'abc_candidate@gmail.com', '123', '2147483647', 'male', 'Rajkot', 'user'),
(37, 'Admin urmi', 'urmi@gmail.com', '123', '2147483647', 'femal', 'Surat', 'admin'),
(38, 'Admin vaibhavi', 'vaibhavi@gmail.com', '123', '2147483647', 'femal', 'Ahmedabad', 'admin'),
(39, 'amisha', 'a@gmail.com', '1234', '9876543212', 'femal', 'surat', 'user'),
(40, 'amisha', 'a@gmail.com', '123', '9876543212', 'femal', 'surat', 'user'),
(41, 'jensi pethani', 'jp@gmail.com', '321', '9874563210', 'femal', 'Rajkot', 'user'),
(42, 'dhruvi', 'd@gmail.com', '123', '9632587410', 'femal', 'Vadodara', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `c_id` int(20) NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `passing_year` varchar(40) NOT NULL,
  `skills` text NOT NULL,
  `experience` varchar(100) NOT NULL,
  `resume` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_id`, `c_id`, `qualification`, `passing_year`, `skills`, `experience`, `resume`) VALUES
(1, 1, 0, 'bca', '2026', 'php,css,html', 'fresher', 'resume_format_blog_asset-2.jpg'),
(2, 1, 0, 'bca', '2026', 'php', 'fresher', 'resume_format_blog_asset-2.jpg'),
(3, 13, 0, 'bca', '2026', 'html\r\n', '6 Months', 'resume_format_blog_asset-2.jpg'),
(4, 39, 0, 'mca', '2026', '.net', '6 Months', 'resume_format_blog_asset-2.jpg'),
(5, 40, 0, 'B.TECH', '2027', 'Mechanical Engineering', '6 Months', '1.jpg'),
(6, 28, 0, 'mca', '2026', 'php developer', '1 Year', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `comadd_job`
--
ALTER TABLE `comadd_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companyreg`
--
ALTER TABLE `companyreg`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `com_messages`
--
ALTER TABLE `com_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `comadd_job`
--
ALTER TABLE `comadd_job`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `companyreg`
--
ALTER TABLE `companyreg`
  MODIFY `cid` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `com_messages`
--
ALTER TABLE `com_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
