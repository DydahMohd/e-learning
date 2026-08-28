-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2026 at 03:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eac_academy`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `badgeType` varchar(100) NOT NULL,
  `badgeName` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `unlockedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `userId`, `badgeType`, `badgeName`, `description`, `unlockedAt`) VALUES
(1, 1, 'QuizMaster', 'Quiz Master', 'Scored 80% or higher on a quiz', '2026-08-13 13:18:41');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `entityType` varchar(80) DEFAULT NULL,
  `entityId` int(10) UNSIGNED DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `courseId` int(10) UNSIGNED NOT NULL,
  `certificateNumber` varchar(255) DEFAULT NULL,
  `issuedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `userId`, `courseId`, `certificateNumber`, `issuedAt`) VALUES
(1, 1, 2, 'EAC-1-2-1786627387', '2026-08-13 13:23:07'),
(2, 1, 3, 'EAC-1-3-1786627603', '2026-08-13 13:26:43');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `courseId` int(10) UNSIGNED NOT NULL,
  `commentText` text NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `parentId` int(10) UNSIGNED DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `userId`, `courseId`, `commentText`, `likes`, `parentId`, `createdAt`) VALUES
(1, 1, 2, 'This course is very useful for understanding Financial Sector Indicators.', 1, NULL, '2026-08-13 13:53:46');

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `commentId` int(10) UNSIGNED NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment_likes`
--

INSERT INTO `comment_likes` (`id`, `userId`, `commentId`, `createdAt`) VALUES
(1, 1, 1, '2026-08-13 13:54:56');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `difficulty` varchar(50) DEFAULT 'Beginner',
  `duration` varchar(100) DEFAULT NULL,
  `contentPath` varchar(500) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT 4.50,
  `studentCount` int(11) DEFAULT 0,
  `publicationStatus` enum('draft','published','archived') NOT NULL DEFAULT 'published',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `slug`, `title`, `description`, `category`, `difficulty`, `duration`, `contentPath`, `icon`, `rating`, `studentCount`, `createdAt`) VALUES
(1, 'fns', 'Food and Nutrition Security', 'Statistical methods for agriculture and food security analysis across EAC partner states.', 'Agriculture', 'Intermediate', '4 weeks', 'courses/agriculture.php', 'book', 4.50, 3, '2026-08-13 12:24:46'),
(2, 'fsi', 'Financial Sector Indicators', 'Core indicators for monitoring financial sector stability and development in the EAC region.', 'Finance', 'Advanced', '4 weeks', 'courses/fsi.php', 'fa-chart-line', 4.50, 3, '2026-08-13 12:24:46'),
(3, 'gfs', 'Government Finance Statistics', 'Compilation and analysis of government revenue, expenditure, and fiscal balances.', 'Public Finance', 'Intermediate', '5 weeks', 'courses/gfs.php', 'fa-landmark', 4.50, 2, '2026-08-13 12:24:46'),
(4, 'psds', 'Public Sector Debt Statistics', 'Standards and practices for measuring and reporting public sector debt.', 'Public Finance', 'Advanced', '4 weeks', 'courses/psds.php', 'fa-file-invoice-dollar', 4.50, 3, '2026-08-13 12:24:46'),
(5, 'mfs', 'Monetary and Financial Statistics', 'Framework for monetary aggregates, credit, and financial market statistics.', 'Finance', 'Intermediate', '5 weeks', 'courses/mfs.php', 'fa-coins', 4.50, 4, '2026-08-13 12:24:46'),
(6, 'poverty', 'Poverty Statistics', 'Methodologies for poverty measurement, inequality analysis, and social indicators.', 'Social Statistics', 'Beginner', '4 weeks', 'courses/poverty.php', 'fa-users', 4.50, 2, '2026-08-13 12:24:46'),
(7, 'ess', 'External Sector Statistics', 'Balance of payments, international investment position, and trade statistics.', 'International Trade', 'Advanced', '5 weeks', 'courses/ess.php', 'fa-globe-africa', 4.50, 1, '2026-08-13 12:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `course_feedback`
--

CREATE TABLE `course_feedback` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `courseId` int(10) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `course_progress`
--

CREATE TABLE `course_progress` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `courseId` int(10) UNSIGNED NOT NULL,
  `completedModules` longtext NOT NULL,
  `currentPosition` longtext DEFAULT NULL,
  `assessmentPassed` tinyint(1) NOT NULL DEFAULT 0,
  `assessmentScore` decimal(5,2) DEFAULT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `courseId` int(10) UNSIGNED NOT NULL,
  `enrolledAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `completedAt` datetime DEFAULT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','completed','dropped') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `userId`, `courseId`, `enrolledAt`, `completedAt`, `progress`, `status`) VALUES
(1, 1, 1, '2026-08-13 13:03:10', NULL, 0, 'active'),
(2, 1, 3, '2026-08-13 13:03:10', '2026-08-13 15:26:26', 100, 'completed'),
(5, 1, 2, '2026-08-13 13:10:41', NULL, 0, 'active'),
(6, 1, 7, '2026-08-17 08:05:40', NULL, 0, 'active'),
(7, 1, 6, '2026-08-17 08:10:51', NULL, 0, 'active'),
(8, 1, 4, '2026-08-17 08:49:23', NULL, 0, 'active'),
(9, 1, 5, '2026-08-17 09:02:13', NULL, 0, 'active'),
(11, 2, 1, '2026-08-18 07:27:04', NULL, 0, 'active'),
(12, 2, 2, '2026-08-18 07:27:23', NULL, 0, 'active'),
(13, 2, 3, '2026-08-18 07:32:08', NULL, 0, 'active'),
(14, 4, 1, '2026-08-18 07:57:30', NULL, 11, 'active'),
(16, 4, 2, '2026-08-18 13:21:18', NULL, 0, 'active'),
(17, 4, 3, '2026-08-19 07:36:40', NULL, 0, 'active'),
(18, 2, 4, '2026-08-19 08:04:51', NULL, 0, 'active'),
(19, 4, 4, '2026-08-19 08:30:33', NULL, 0, 'active'),
(20, 4, 5, '2026-08-19 08:32:25', NULL, 0, 'active'),
(21, 2, 5, '2026-08-21 13:33:43', NULL, 0, 'active'),
(22, 2, 6, '2026-08-21 13:34:32', NULL, 0, 'active'),
(23, 6, 5, '2026-08-24 09:34:37', NULL, 0, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `learning_streaks`
--

CREATE TABLE `learning_streaks` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `currentStreak` int(11) NOT NULL DEFAULT 0,
  `maxStreak` int(11) NOT NULL DEFAULT 0,
  `lastActivityDate` date DEFAULT NULL,
  `totalPoints` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `learning_streaks`
--

INSERT INTO `learning_streaks` (`id`, `userId`, `currentStreak`, `maxStreak`, `lastActivityDate`, `totalPoints`) VALUES
(1, 1, 1, 3, '2026-08-17', 475),
(2, 2, 1, 3, '2026-08-24', 0),
(6, 4, 2, 2, '2026-08-19', 0),
(7, 5, 0, 0, NULL, 0),
(8, 6, 1, 1, '2026-08-24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(40) NOT NULL DEFAULT 'info',
  `readAt` datetime DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `tokenHash` char(64) NOT NULL,
  `expiresAt` datetime NOT NULL,
  `usedAt` datetime DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `courseId` int(10) UNSIGNED NOT NULL,
  `quizId` int(10) UNSIGNED DEFAULT NULL,
  `score` decimal(5,2) DEFAULT NULL,
  `totalQuestions` int(11) DEFAULT NULL,
  `correctAnswers` int(11) DEFAULT NULL,
  `attemptedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `userId`, `courseId`, `quizId`, `score`, `totalQuestions`, `correctAnswers`, `attemptedAt`) VALUES
(1, 1, 2, 1, 80.00, 10, 8, '2026-08-13 13:14:20'),
(2, 1, 2, 2, 80.00, 10, 8, '2026-08-13 13:18:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `firstName` varchar(120) DEFAULT NULL,
  `middleName` varchar(120) DEFAULT NULL,
  `surname` varchar(120) DEFAULT NULL,
  `sex` varchar(30) DEFAULT NULL,
  `role` enum('student','instructor','admin') NOT NULL DEFAULT 'student',
  `organization` varchar(255) DEFAULT NULL,
  `sector` varchar(150) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `jobTitle` varchar(180) DEFAULT NULL,
  `profilePicture` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `lastLoginAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `fullName`, `firstName`, `middleName`, `surname`, `sex`, `role`, `organization`, `sector`, `country`, `jobTitle`, `profilePicture`, `bio`, `createdAt`, `updatedAt`, `lastLoginAt`) VALUES
(1, 'demo@eac.org', '$2y$10$2eEJyu3KKlCmz.Eh0Ojiuu2CKhy1w0LqTq0.6DRm28LZi8JxiENda', 'Demo Student', NULL, NULL, NULL, NULL, 'student', 'EAC Secretariat', NULL, NULL, NULL, NULL, NULL, '2026-08-13 13:03:10', NULL, NULL),
(2, 'admin@eac.org', '$2y$10$NHJ.8ZqDuH0B0aoRWfblBu0UHpgoglQTDbMcsht1Y8sXEzMDQ7caW', 'Admin User', NULL, NULL, NULL, NULL, 'admin', 'IT Department', NULL, NULL, NULL, NULL, NULL, '2026-08-13 13:03:10', NULL, NULL),
(4, 'mohamed@gmail.com', '$2y$10$sUf4iNdzG9mCU3esMKoL0utE5BsbPawbL0.wWJQwKHeEoKtyT5LHS', 'MOHAMEDI IBRAHIM BEDUI', 'MOHAMEDI', 'IBRAHIM', 'BEDUI', 'Male', 'student', 'saeshbusinesscompanylimited.', 'Private sector', 'Tanzania', NULL, NULL, NULL, '2026-08-18 07:57:30', NULL, NULL),
(5, 'hawasaleh@gmail.com', '$2y$10$ku.vUid548VkaKv5oSp9e.brwEaELINhWYf2H7thlLElfFyrlh5qu', 'Hawa saleh bohero', 'Hawa', 'saleh', 'bohero', 'Female', 'student', 'daystar', 'Academia/research', 'Tanzania', 'Director', NULL, NULL, '2026-08-24 09:28:39', NULL, NULL),
(6, 'hawa@gmail.com', '$2y$10$M4aR5WjhNfsvumTvx0aLs.lIpnazk9d1UPu4ZG22CqQYRgOA6BaGW', 'hawa saleh bohero', 'hawa', 'saleh', 'bohero', 'Female', 'student', 'Daystar', 'Private sector', 'Tanzania', NULL, NULL, NULL, '2026-08-24 09:34:37', '2026-08-24 12:13:17', '2026-08-24 12:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `tokenHash` char(64) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastActivityAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `revokedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `userId`, `tokenHash`, `createdAt`, `lastActivityAt`, `revokedAt`) VALUES
(1, 6, '967ed40b5ee719ef002d24ab5334a7d8f0c5d808da9e3a66651f9d60d1b11cba', '2026-08-24 09:34:37', '2026-08-24 09:34:37', NULL),
(2, 6, '1603f3a277511306555f23dfe3a9f4db1acd3f569dea6fdfc309153fcdd0845a', '2026-08-24 09:35:00', '2026-08-24 12:13:17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_achievement_user` (`userId`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_created` (`createdAt`),
  ADD KEY `idx_audit_user` (`userId`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_certificate_user_course` (`userId`,`courseId`),
  ADD UNIQUE KEY `uq_certificate_number` (`certificateNumber`),
  ADD KEY `fk_certificate_course` (`courseId`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comment_user` (`userId`),
  ADD KEY `fk_comment_course` (`courseId`),
  ADD KEY `fk_comment_parent` (`parentId`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_comment_like` (`userId`,`commentId`),
  ADD KEY `fk_comment_like_comment` (`commentId`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `course_feedback`
--
ALTER TABLE `course_feedback`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_feedback_user_course` (`userId`,`courseId`),
  ADD KEY `fk_feedback_course` (`courseId`);

--
-- Indexes for table `course_progress`
--
ALTER TABLE `course_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_course_progress_user_course` (`userId`,`courseId`),
  ADD KEY `fk_course_progress_course` (`courseId`),
  ADD KEY `idx_course_progress_updated` (`updatedAt`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_enrollment_user_course` (`userId`,`courseId`),
  ADD KEY `fk_enrollment_course` (`courseId`);

--
-- Indexes for table `learning_streaks`
--
ALTER TABLE `learning_streaks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_learning_streak_user` (`userId`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notification_user` (`userId`,`readAt`,`createdAt`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_password_reset_token` (`tokenHash`),
  ADD KEY `idx_password_reset_user` (`userId`,`expiresAt`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_quiz_user` (`userId`),
  ADD KEY `fk_quiz_course` (`courseId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_email` (`email`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_session_token` (`tokenHash`),
  ADD KEY `idx_user_sessions_user` (`userId`),
  ADD KEY `idx_user_sessions_active` (`revokedAt`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comment_likes`
--
ALTER TABLE `comment_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `course_feedback`
--
ALTER TABLE `course_feedback`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_progress`
--
ALTER TABLE `course_progress`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `learning_streaks`
--
ALTER TABLE `learning_streaks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievements`
--
ALTER TABLE `achievements`
  ADD CONSTRAINT `fk_achievement_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `fk_audit_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `fk_certificate_course` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_certificate_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comment_course` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comment_parent` FOREIGN KEY (`parentId`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comment_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD CONSTRAINT `fk_comment_like_comment` FOREIGN KEY (`commentId`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comment_like_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_feedback`
--
ALTER TABLE `course_feedback`
  ADD CONSTRAINT `fk_feedback_course` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_feedback_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_progress`
--
ALTER TABLE `course_progress`
  ADD CONSTRAINT `fk_course_progress_course` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_course_progress_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `fk_enrollment_course` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_enrollment_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `learning_streaks`
--
ALTER TABLE `learning_streaks`
  ADD CONSTRAINT `fk_streak_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notification_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `fk_password_reset_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD CONSTRAINT `fk_quiz_course` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_quiz_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `fk_user_sessions_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
