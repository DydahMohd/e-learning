CREATE TABLE IF NOT EXISTS `course_progress` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userId` int(10) UNSIGNED NOT NULL,
  `courseId` int(10) UNSIGNED NOT NULL,
  `completedModules` longtext NOT NULL,
  `currentPosition` longtext DEFAULT NULL,
  `assessmentPassed` tinyint(1) NOT NULL DEFAULT 0,
  `assessmentScore` decimal(5,2) DEFAULT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_course_progress_user_course` (`userId`,`courseId`),
  KEY `fk_course_progress_course` (`courseId`),
  CONSTRAINT `fk_course_progress_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_course_progress_course` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
