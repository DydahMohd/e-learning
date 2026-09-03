-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2026 at 02:47 PM
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
-- Database: `eac_stats_elearning`
-- Distribution-safe dump: runtime user, session, progress, certificate,
-- comment, assessment-attempt and audit records are intentionally excluded.
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


-- --------------------------------------------------------

--
-- Table structure for table `assessment_attempts`
--

CREATE TABLE `assessment_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `courseId` int(10) UNSIGNED NOT NULL,
  `tokenHash` char(64) NOT NULL,
  `startedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `expiresAt` datetime NOT NULL,
  `submittedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_attempts`
--


-- --------------------------------------------------------

--
-- Table structure for table `assessment_options`
--

CREATE TABLE `assessment_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `questionId` bigint(20) UNSIGNED NOT NULL,
  `optionText` text NOT NULL,
  `isCorrect` tinyint(1) NOT NULL DEFAULT 0,
  `sortOrder` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_options`
--

INSERT INTO `assessment_options` (`id`, `questionId`, `optionText`, `isCorrect`, `sortOrder`) VALUES
(1, 1, 'Availability', 0, 0),
(2, 1, 'Access', 0, 1),
(3, 1, 'Utilization', 0, 2),
(4, 1, 'Stability', 1, 3),
(5, 2, 'Stable and predictable food prices', 0, 0),
(6, 2, 'Large fluctuations that reduce household purchasing power', 1, 1),
(7, 2, 'Declining global commodity prices', 0, 2),
(8, 2, 'Increased agricultural production', 0, 3),
(9, 3, 'Mild public health problem', 0, 0),
(10, 3, 'Moderate public health problem', 0, 1),
(11, 3, 'Severe public health problem', 1, 2),
(12, 3, 'No public health problem', 0, 3),
(13, 4, 'Kenya and Rwanda only', 0, 0),
(14, 4, 'Burundi and Tanzania only', 0, 1),
(15, 4, 'DRC, South Sudan, Tanzania, Uganda', 1, 2),
(16, 4, 'All EAC countries', 0, 3),
(17, 5, 'Malaria', 0, 0),
(18, 5, 'Iron deficiency', 1, 1),
(19, 5, 'Vitamin A deficiency', 0, 2),
(20, 5, 'Hookworm infestation only', 0, 3),
(21, 6, 'Once per year', 0, 0),
(22, 6, 'Every 4–6 months', 1, 1),
(23, 6, 'Daily in low dose', 0, 2),
(24, 6, 'Only when clinically deficient', 0, 3),
(25, 7, 'Acute/short-term undernutrition', 0, 0),
(26, 7, 'Chronic or long-term undernutrition', 1, 1),
(27, 7, 'Overnutrition and obesity', 0, 2),
(28, 7, 'Micronutrient deficiency only', 0, 3),
(29, 8, 'Kenya', 0, 0),
(30, 8, 'Burundi', 1, 1),
(31, 8, 'Rwanda', 0, 2),
(32, 8, 'Uganda', 0, 3),
(33, 9, 'Acceptable situation', 0, 0),
(34, 9, 'Poor situation', 0, 1),
(35, 9, 'Serious situation', 0, 2),
(36, 9, 'Critical emergency', 1, 3),
(37, 10, 'Undernutrition (stunting, wasting)', 0, 0),
(38, 10, 'Micronutrient deficiencies', 0, 1),
(39, 10, 'Overweight/obesity', 0, 2),
(40, 10, 'Excessive physical activity', 1, 3),
(41, 11, '2,000 g', 0, 0),
(42, 11, '2,500 g', 1, 1),
(43, 11, '3,000 g', 0, 2),
(44, 11, '3,500 g', 0, 3),
(45, 12, 'Microsoft Excel only', 0, 0),
(46, 12, 'WHO Anthro and/or ENA for SMART', 1, 1),
(47, 12, 'SPSS only', 0, 2),
(48, 12, 'Manual calculation', 0, 3),
(49, 13, 'Routine programming', 0, 0),
(50, 13, 'District-level interventions', 0, 1),
(51, 13, 'National emergency priority with multi-sectoral action', 1, 2),
(52, 13, 'No action required', 0, 3),
(53, 14, 'Adolescent overweight', 0, 0),
(54, 14, 'Irreversible stunting', 1, 1),
(55, 14, 'Acute malnutrition only', 0, 2),
(56, 14, 'Vitamin A deficiency', 0, 3),
(57, 15, 'Deworming only', 0, 0),
(58, 15, 'High-dose vitamin A supplementation every 6 months', 1, 1),
(59, 15, 'Iron supplementation', 0, 2),
(60, 15, 'Zinc supplementation', 0, 3),
(61, 16, '30%', 0, 0),
(62, 16, '50%', 1, 1),
(63, 16, '75%', 0, 2),
(64, 16, '100%', 0, 3),
(65, 17, '5–10% duplicate measurements', 0, 0),
(66, 17, 'Standardized training and pilot testing', 0, 1),
(67, 17, 'Using WHO growth standards', 0, 2),
(68, 17, 'Skipping plausibility checks to save time', 1, 3),
(69, 18, 'Long-term cumulative deficits', 0, 0),
(70, 18, 'Recent acute malnutrition', 1, 1),
(71, 18, 'Micronutrient status', 0, 2),
(72, 18, 'Birth outcomes only', 0, 3),
(73, 19, 'Excess calories from diverse diets', 0, 0),
(74, 19, 'Deficiencies of vitamins and minerals despite adequate energy intake', 1, 1),
(75, 19, 'Overconsumption of animal-source foods', 0, 2),
(76, 19, 'Seasonal food surpluses', 0, 3),
(77, 20, 'Food fortification of oil and sugar', 0, 0),
(78, 20, 'High-dose supplementation twice yearly', 0, 1),
(79, 20, 'Biofortified crops (e.g., orange-fleshed sweet potato)', 0, 2),
(80, 20, 'All of the above are highly cost-effective', 1, 3),
(81, 21, 'Routine supplementation only', 0, 0),
(82, 21, 'Blanket iron-folic acid supplementation + fortification + malaria control', 1, 1),
(83, 21, 'Dietary education only', 0, 2),
(84, 21, 'Monitoring every 5 years', 0, 3),
(85, 22, 'The double burden only', 0, 0),
(86, 22, 'The triple burden of malnutrition', 1, 1),
(87, 22, 'Acute food insecurity', 0, 2),
(88, 22, 'Seasonal hunger', 0, 3),
(89, 23, 'Immediately after harvest', 0, 0),
(90, 23, 'During or just before the lean/hunger season (often Feb–May)', 1, 1),
(91, 23, 'During the rainy season only', 0, 2),
(92, 23, 'Timing does not matter', 0, 3),
(93, 24, 'Stunting', 0, 0),
(94, 24, 'Underweight', 0, 1),
(95, 24, 'Wasting (Weight-for-Height)', 1, 2),
(96, 24, 'Height-for-Age', 0, 3),
(97, 25, 'Regional frameworks and coordination (e.g., SADC, EAC strategies)', 1, 0),
(98, 25, 'National policies only', 0, 1),
(99, 25, 'Donor funding without coordination', 0, 2),
(100, 25, 'Individual household actions only', 0, 3),
(101, 26, 'Weight-for-height < -2 SD', 0, 0),
(102, 26, 'Height-for-age < -2 SD', 1, 1),
(103, 26, 'Weight-for-age < -2 SD', 0, 2),
(104, 26, 'BMI-for-age < -2 SD', 0, 3),
(105, 27, 'Birth to 6 months', 0, 0),
(106, 27, 'Pregnancy to 24 months (the first 1,000 days)', 1, 1),
(107, 27, '0-5 years', 0, 2),
(108, 27, 'Adolescence', 0, 3),
(109, 28, 'Acceptable situation', 0, 0),
(110, 28, 'Poor situation', 0, 1),
(111, 28, 'Serious situation requiring humanitarian response', 1, 2),
(112, 28, 'Critical emergency', 0, 3),
(113, 29, 'Stunting', 0, 0),
(114, 29, 'Wasting', 1, 1),
(115, 29, 'Anemia', 0, 2),
(116, 29, 'Low birth weight', 0, 3),
(117, 30, '3 times higher', 0, 0),
(118, 30, '5 times higher', 0, 1),
(119, 30, '9 times higher', 1, 2),
(120, 30, '15 times higher', 0, 3),
(121, 31, 'DHS (Demographic and Health Survey)', 0, 0),
(122, 31, 'SMART Survey', 1, 1),
(123, 31, 'MICS', 0, 2),
(124, 31, 'Food Balance Sheet', 0, 3),
(125, 32, 'September-November (post-harvest)', 0, 0),
(126, 32, 'February-April (pre-harvest)', 1, 1),
(127, 32, 'December-January (during harvest)', 0, 2),
(128, 32, 'Any time of year', 0, 3),
(129, 33, 'Weekly', 0, 0),
(130, 33, 'Daily', 1, 1),
(131, 33, 'Before each measurement', 0, 2),
(132, 33, 'Monthly', 0, 3),
(133, 34, 'Routine health facility services only', 0, 0),
(134, 34, 'Targeted supplementary feeding programs', 0, 1),
(135, 34, 'Critical emergency humanitarian response (mass screening, CMAM scale-up, blanket feeding)', 1, 2),
(136, 34, 'No intervention needed', 0, 3),
(137, 35, 'Monthly', 0, 0),
(138, 35, 'Quarterly', 0, 1),
(139, 35, 'Annually', 0, 2),
(140, 35, 'Every 2-5 years (major surveys)', 1, 3),
(141, 36, 'Kenya', 0, 0),
(142, 36, 'Burundi (52-56%)', 1, 1),
(143, 36, 'Tanzania', 0, 2),
(144, 36, 'Rwanda', 0, 3),
(145, 37, 'Low volatility', 0, 0),
(146, 37, 'Moderate volatility', 0, 1),
(147, 37, 'High volatility - significant market dysfunction', 1, 2),
(148, 37, 'No volatility', 0, 3),
(149, 38, 'Kenya, Rwanda, Burundi, Uganda', 0, 0),
(150, 38, 'DRC, South Sudan, Tanzania, Uganda', 1, 1),
(151, 38, 'All seven countries', 0, 2),
(152, 38, 'Only DRC and South Sudan', 0, 3),
(153, 39, '< 10.0 g/dL', 0, 0),
(154, 39, '< 11.0 g/dL', 1, 1),
(155, 39, '< 12.0 g/dL', 0, 2),
(156, 39, '< 13.0 g/dL', 0, 3),
(157, 40, 'Complete elimination by 2025', 0, 0),
(158, 40, '30% reduction by 2025', 1, 1),
(159, 40, '50% reduction by 2030', 0, 2),
(160, 40, 'No specific target exists', 0, 3),
(161, 41, 'Monthly', 0, 0),
(162, 41, 'Every 3 months', 0, 1),
(163, 41, 'Every 6 months', 1, 2),
(164, 41, 'Annually', 0, 3),
(165, 42, 'World Bank', 0, 0),
(166, 42, 'FAO', 1, 1),
(167, 42, 'WHO', 0, 2),
(168, 42, 'UNICEF', 0, 3),
(169, 43, 'Stunting', 0, 0),
(170, 43, 'Severe acute malnutrition without medical complications', 1, 1),
(171, 43, 'Anemia', 0, 2),
(172, 43, 'Vitamin A deficiency', 0, 3),
(173, 44, '6-8 months', 0, 0),
(174, 44, '3-4 months', 0, 1),
(175, 44, '2-3 weeks', 1, 2),
(176, 44, '1 year', 0, 3),
(177, 45, 'Maternal anemia and undernutrition', 1, 0),
(178, 45, 'Excessive weight gain during pregnancy', 0, 1),
(179, 45, 'High maternal education', 0, 2),
(180, 45, 'Urban residence', 0, 3),
(181, 46, 'Stunting and wasting occurring together', 0, 0),
(182, 46, 'Undernutrition and overweight/obesity coexisting in the same population', 1, 1),
(183, 46, 'Anemia and vitamin A deficiency', 0, 2),
(184, 46, 'Food insecurity and poverty', 0, 3),
(185, 47, '1-2%', 0, 0),
(186, 47, '5-10%', 1, 1),
(187, 47, '20-25%', 0, 2),
(188, 47, '50%', 0, 3),
(189, 48, 'Community-level interventions only', 0, 0),
(190, 48, 'District-level programming', 0, 1),
(191, 48, 'National emergency priority with multi-sectoral approach', 1, 2),
(192, 48, 'No intervention needed', 0, 3),
(193, 49, 'Microsoft Excel only', 0, 0),
(194, 49, 'WHO Anthro and/or ENA for SMART', 1, 1),
(195, 49, 'Any statistical software', 0, 2),
(196, 49, 'Manual calculations only', 0, 3),
(197, 50, 'Vitamin A deficiency', 0, 0),
(198, 50, 'Iron deficiency (accounts for ~50% of cases)', 1, 1),
(199, 50, 'Malaria', 0, 2),
(200, 50, 'Genetic disorders', 0, 3),
(201, 51, 'Lack of funding for surveys', 0, 0),
(202, 51, 'Incompatible methodologies and indicators preventing valid regional aggregation', 1, 1),
(203, 51, 'Insufficient technical capacity in Partner States', 0, 2),
(204, 51, 'Political resistance to data sharing', 0, 3),
(205, 52, 'Household & Community Level', 0, 0),
(206, 52, 'District Level', 0, 1),
(207, 52, 'Provincial Coordination Level', 1, 2),
(208, 52, 'National Level', 0, 3),
(209, 53, 'Conduct technical data analysis', 0, 0),
(210, 53, 'Collect household-level data', 0, 1),
(211, 53, 'Develop survey questionnaires', 0, 2),
(212, 53, 'Approve workplans, validate reports, provide policy guidance, and mobilize resources', 1, 3),
(213, 54, '1 coordinator only', 0, 0),
(214, 54, '4 dedicated staff (coordinator, statistics/M&E officer, data analyst/GIS specialist, admin support)', 1, 1),
(215, 54, '10-12 staff covering all technical areas', 0, 2),
(216, 54, 'Staff shared with other EAC departments', 0, 3),
(217, 55, 'WHAT to measure (indicator definitions)', 0, 0),
(218, 55, 'HOW to measure (methodologies and tools)', 0, 1),
(219, 55, 'WHERE to measure (geographic targeting)', 1, 2),
(220, 55, 'WHEN to measure (timing and reporting schedules)', 0, 3),
(221, 56, 'WHO Child Growth Standards 2006', 1, 0),
(222, 56, 'NCHS 1977 reference', 0, 1),
(223, 56, 'National growth references (each country uses own)', 0, 2),
(224, 56, 'Any internationally recognized standard', 0, 3),
(225, 57, 'January-March (lean season)', 0, 0),
(226, 57, 'April-June (pre-harvest)', 0, 1),
(227, 57, 'July-September (post-harvest)', 1, 2),
(228, 57, 'Any time of year (no standardization needed)', 0, 3),
(229, 58, 'December 31 of the survey year', 0, 0),
(230, 58, 'January 31 of the following year', 0, 1),
(231, 58, 'February 28 of the following year', 0, 2),
(232, 58, 'March 31 of the following year', 1, 3),
(233, 59, 'Technical Error of Measurement (TEM) < 5mm', 0, 0),
(234, 59, 'Technical Error of Measurement (TEM) < 7mm', 1, 1),
(235, 59, 'Technical Error of Measurement (TEM) < 10mm', 0, 2),
(236, 59, 'No standardization test required if enumerators are trained', 0, 3),
(237, 60, 'Data is automatically accepted anyway', 0, 0),
(238, 60, 'Country receives a warning but data is included', 0, 1),
(239, 60, 'Investigation triggered and data potentially excluded from regional reporting until issues resolved', 1, 2),
(240, 60, 'Data quality criteria are optional guidelines only', 0, 3),
(241, 61, 'How healthy, stable and strong a country\'s financial system is', 1, 0),
(242, 61, 'The exchange rate for the day', 0, 1),
(243, 61, 'A company\'s marketing reach', 0, 2),
(244, 61, 'The weather outlook', 0, 3),
(245, 62, 'Three', 0, 0),
(246, 62, 'Four', 0, 1),
(247, 62, 'Five', 1, 2),
(248, 62, 'Eight', 0, 3),
(249, 63, 'Institutions, such as banks, that accept deposits and use them to provide loans and other services', 1, 0),
(250, 63, 'Companies that only sell insurance', 0, 1),
(251, 63, 'Government tax offices', 0, 2),
(252, 63, 'Funds that invest only in real estate', 0, 3),
(253, 64, 'The Basel Standards issued by the BCBS', 1, 0),
(254, 64, 'The GATS modes of supply', 0, 1),
(255, 64, 'The IMTS customs rules', 0, 2),
(256, 64, 'The Penetration Ratio', 0, 3),
(257, 65, 'The highest-quality, most permanent form of a DT\'s capital', 1, 0),
(258, 65, 'Subordinated debt', 0, 1),
(259, 65, 'A type of nonperforming loan', 0, 2),
(260, 65, 'Money owed to depositors', 0, 3),
(261, 66, '8.5 percent', 1, 0),
(262, 66, '10 percent', 0, 1),
(263, 66, '12 percent', 0, 2),
(264, 66, '6 percent', 0, 3),
(265, 67, '10 percent and 12 percent', 1, 0),
(266, 67, '8.5 percent and 10 percent', 0, 1),
(267, 67, '12 percent and 15 percent', 0, 2),
(268, 67, '5 percent and 8 percent', 0, 3),
(269, 68, 'A safeguard against rapid asset growth without corresponding capital injection', 1, 0),
(270, 68, 'A measure of insurance penetration', 0, 1),
(271, 68, 'A profitability ratio', 0, 2),
(272, 68, 'A measure of digital lending', 0, 3),
(273, 69, '90 days', 1, 0),
(274, 69, '30 days', 0, 1),
(275, 69, 'one year', 0, 2),
(276, 69, 'two years', 0, 3),
(277, 70, 'The extent to which a DT has set aside funds to cover potential losses from its NPLs', 1, 0),
(278, 70, 'The DT\'s foreign-exchange exposure', 0, 1),
(279, 70, 'The share of loans to households', 0, 2),
(280, 70, 'The DT\'s market share', 0, 3),
(281, 71, 'Lending to only a few sectors', 1, 0),
(282, 71, 'Holding too much cash', 0, 1),
(283, 71, 'Paying staff too much', 0, 2),
(284, 71, 'Issuing too few loans', 0, 3),
(285, 72, 'The profit earned from the assets owned or controlled and investments made by the DT', 1, 0),
(286, 72, 'The number of branches a DT has', 0, 1),
(287, 72, 'The DT\'s deposit base', 0, 2),
(288, 72, 'The DT\'s foreign-currency loans', 0, 3),
(289, 73, 'The profit earned from the DT\'s own funds (capital)', 1, 0),
(290, 73, 'The proportion of nonperforming loans', 0, 1),
(291, 73, 'The liquidity coverage over 30 days', 0, 2),
(292, 73, 'The spread between lending and deposit rates', 0, 3),
(293, 74, '3 months or less', 1, 0),
(294, 74, '6 months or less', 0, 1),
(295, 74, 'one year or less', 0, 2),
(296, 74, 'any length', 0, 3),
(297, 75, 'How much of a bank\'s assets can be quickly used to cover cash needs such as customers\' deposit withdrawals', 1, 0),
(298, 75, 'The DT\'s profitability', 0, 1),
(299, 75, 'The DT\'s staff costs', 0, 2),
(300, 75, 'The number of digital loans', 0, 3),
(301, 76, '30 days', 1, 0),
(302, 76, '90 days', 0, 1),
(303, 76, 'one year', 0, 2),
(304, 76, 'five years', 0, 3),
(305, 77, 'one year', 1, 0),
(306, 77, '30 days', 0, 1),
(307, 77, '90 days', 0, 2),
(308, 77, 'ten years', 0, 3),
(309, 78, 'Changes in the value of foreign currency', 1, 0),
(310, 78, 'Rising salaries', 0, 1),
(311, 78, 'Loan concentration', 0, 2),
(312, 78, 'Falling deposit numbers', 0, 3),
(313, 79, 'Twelve', 1, 0),
(314, 79, 'Five', 0, 1),
(315, 79, 'Thirteen', 0, 2),
(316, 79, 'Twenty', 0, 3),
(317, 80, 'Loans approved quickly online with limited information may not be repaid', 1, 0),
(318, 80, 'Deposits are too high', 0, 1),
(319, 80, 'Branches are too few', 0, 2),
(320, 80, 'Staff costs are rising', 0, 3),
(321, 81, 'Stress or lack of trust in the banking system', 1, 0),
(322, 81, 'Strong profitability', 0, 1),
(323, 81, 'High liquidity', 0, 2),
(324, 81, 'Low foreign-currency exposure', 0, 3),
(325, 82, 'Long-term cover such as life and pensions', 1, 0),
(326, 82, 'Only motor insurance', 0, 1),
(327, 82, 'Short-term health cover settled within a year', 0, 2),
(328, 82, 'Deposit accounts', 0, 3),
(329, 83, 'Within a year', 1, 0),
(330, 83, 'Over 20 years', 0, 1),
(331, 83, 'Only at retirement', 0, 2),
(332, 83, 'Never', 0, 3),
(333, 84, 'Below 100 percent', 1, 0),
(334, 84, 'Above 100 percent', 0, 1),
(335, 84, 'Above 150 percent', 0, 2),
(336, 84, 'At exactly 200 percent', 0, 3),
(337, 85, 'A safeguard against excessive asset growth without corresponding capital injection', 1, 0),
(338, 85, 'A measure of premium growth', 0, 1),
(339, 85, 'A liquidity ratio', 0, 2),
(340, 85, 'A measure of digital lending', 0, 3),
(341, 86, 'The proportion of premiums retained rather than passed to reinsurance', 1, 0),
(342, 86, 'The proportion of assets in real estate', 0, 1),
(343, 86, 'The insurer\'s ROE', 0, 2),
(344, 86, 'The penetration of insurance in the economy', 0, 3),
(345, 87, 'How developed the insurance sector is within the economy', 1, 0),
(346, 87, 'The insurer\'s staff costs', 0, 1),
(347, 87, 'The number of claims paid', 0, 2),
(348, 87, 'The maturity of investments', 0, 3),
(349, 88, 'What an IC pays in claims with what it receives in premiums', 1, 0),
(350, 88, 'Assets with liabilities', 0, 1),
(351, 88, 'Capital with risk-weighted assets', 0, 2),
(352, 88, 'Loans with deposits', 0, 3),
(353, 89, 'The size of insurance corporations relative to the overall economy', 1, 0),
(354, 89, 'The insurer\'s profitability', 0, 1),
(355, 89, 'The number of policyholders', 0, 2),
(356, 89, 'The reinsurance retained', 0, 3),
(357, 90, 'Invest them and pay them out with interest to support workers after retirement', 1, 0),
(358, 90, 'Lend them to governments only', 0, 1),
(359, 90, 'Use them to buy insurance', 0, 2),
(360, 90, 'Keep them as idle cash', 0, 3),
(361, 91, '12 months', 1, 0),
(362, 91, '30 days', 0, 1),
(363, 91, '90 days', 0, 2),
(364, 91, 'ten years', 0, 3),
(365, 92, 'Cover the future benefits it intends to pay', 1, 0),
(366, 92, 'Pay this month\'s salaries', 0, 1),
(367, 92, 'Buy a new office', 0, 2),
(368, 92, 'Reduce dependency', 0, 3),
(369, 93, 'The PF does not have enough active members to pay its retirees', 1, 0),
(370, 93, 'The PF has too much cash', 0, 1),
(371, 93, 'The PF is over-invested in equities', 0, 2),
(372, 93, 'The PF has no retirees', 0, 3),
(373, 94, 'Minimal operational cost', 1, 0),
(374, 94, 'Higher operational cost', 0, 1),
(375, 94, 'A larger dependency ratio', 0, 2),
(376, 94, 'More real-estate exposure', 0, 3),
(377, 95, 'One year or less (short-term)', 1, 0),
(378, 95, 'More than ten years', 0, 1),
(379, 95, 'Exactly five years', 0, 2),
(380, 95, 'With no maturity', 0, 3),
(381, 96, 'Investing predominantly in only a few sectors', 1, 0),
(382, 96, 'Holding too much cash', 0, 1),
(383, 96, 'Paying staff too much', 0, 2),
(384, 96, 'Issuing loans', 0, 3),
(385, 97, 'The PF is more vulnerable to changes in the value of the real estate market', 1, 0),
(386, 97, 'The PF holds no property', 0, 1),
(387, 97, 'The PF has more cash', 0, 2),
(388, 97, 'The PF has fewer members', 0, 3),
(389, 98, 'Apartments and houses purchased by households for own use', 1, 0),
(390, 98, 'Offices and warehouses', 0, 1),
(391, 98, 'Government bonds', 0, 2),
(392, 98, 'Foreign currency', 0, 3),
(393, 99, 'It may shrink collateral value, creating a loan exposure', 1, 0),
(394, 99, 'It raises the CET1 minimum', 0, 1),
(395, 99, 'It increases the dependency ratio', 0, 2),
(396, 99, 'It has no effect', 0, 3),
(397, 100, 'Profit earned from NFCs\' own funds', 1, 0),
(398, 100, 'Debt borrowed abroad', 0, 1),
(399, 100, 'Operational cost to income', 0, 2),
(400, 100, 'Loans spread across sectors', 0, 3),
(401, 101, 'Repay their loans using their income', 1, 0),
(402, 101, 'Attract more customers', 0, 1),
(403, 101, 'Reduce staff numbers', 0, 2),
(404, 101, 'Increase property prices', 0, 3),
(405, 102, 'Repay the interest on funds borrowed using their income', 1, 0),
(406, 102, 'Repay all principal immediately', 0, 1),
(407, 102, 'Pay dividends', 0, 2),
(408, 102, 'Buy real estate', 0, 3),
(409, 103, 'People who live together and share some money and expenses (one person or a family)', 1, 0),
(410, 103, 'Only a married couple', 0, 1),
(411, 103, 'A registered company', 0, 2),
(412, 103, 'A bank branch', 0, 3),
(413, 104, 'Households have borrowed a lot relative to income (household indebtedness)', 1, 0),
(414, 104, 'Households have no debt', 0, 1),
(415, 104, 'The economy has shrunk', 0, 2),
(416, 104, 'Banks hold more capital', 0, 3),
(417, 105, 'NFCs are heavily indebted, raising vulnerability to higher lending rates', 1, 0),
(418, 105, 'NFCs have no debt', 0, 1),
(419, 105, 'NFCs are very liquid', 0, 2),
(420, 105, 'NFCs hold mostly cash', 0, 3),
(421, 106, 'Offices, shops, rental apartments, factories and warehouses', 1, 0),
(422, 106, 'Only houses and apartments', 0, 1),
(423, 106, 'Treasury bills', 0, 2),
(424, 106, 'Pension contributions', 0, 3),
(425, 107, 'A standardized system that tracks how governments earn, spend, borrow and manage resources', 1, 0),
(426, 107, 'A register of commercial bank interest rates', 0, 1),
(427, 107, 'A list of private company profits', 0, 2),
(428, 107, 'A climate-monitoring tool', 0, 3),
(429, 108, 'A fiscal deficit (including grants) of no more than 3% of GDP', 1, 0),
(430, 108, '6% of GDP', 0, 1),
(431, 108, '50% of GDP', 0, 2),
(432, 108, '10% of GDP', 0, 3),
(433, 109, 'The IMF\'s Government Finance Statistics Manual; GFSM 2014', 1, 0),
(434, 109, 'The Balance of Payments Manual; BPM7', 0, 1),
(435, 109, 'The System of National Accounts; SNA 1993', 0, 2),
(436, 109, 'The IMTS compilers guide', 0, 3),
(437, 110, 'The System of National Accounts (SNA)', 1, 0),
(438, 110, 'The COFOG tax code', 0, 1),
(439, 110, 'The Basel Standards', 0, 2),
(440, 110, 'The GATS modes of supply', 0, 3),
(441, 111, 'Actual cash received or paid', 1, 0),
(442, 111, 'Transactions when they occur regardless of cash', 0, 1),
(443, 111, 'Only foreign-currency items', 0, 2),
(444, 111, 'Only year-end balances', 0, 3),
(445, 112, 'Modified cash basis', 1, 0),
(446, 112, 'Pure accrual basis', 0, 1),
(447, 112, 'Commitment basis', 0, 2),
(448, 112, 'Customs basis', 0, 3),
(449, 113, 'The opening balance sheet plus the period\'s flows', 1, 0),
(450, 113, 'Only the period\'s transactions', 0, 1),
(451, 113, 'Total revenue minus total expenditure', 0, 2),
(452, 113, 'The central bank balance sheet', 0, 3),
(453, 114, 'Taxes, social contributions, grants and other revenue', 1, 0),
(454, 114, 'Compensation of employees and subsidies', 0, 1),
(455, 114, 'Loans issued by government', 0, 2),
(456, 114, 'Infrastructure and machinery', 0, 3),
(457, 115, 'Expense', 1, 0),
(458, 115, 'Revenue', 0, 1),
(459, 115, 'Financial assets', 0, 2),
(460, 115, 'Non-financial assets', 0, 3),
(461, 116, 'Net investment in non-financial assets', 1, 0),
(462, 116, 'Revenue', 0, 1),
(463, 116, 'Liabilities', 0, 2),
(464, 116, 'Financial assets', 0, 3),
(465, 117, 'Total revenue minus total expenditure', 1, 0),
(466, 117, 'Total assets minus total liabilities', 0, 1),
(467, 117, 'Revenue as a percentage of GDP', 0, 2),
(468, 117, 'The policy interest rate', 0, 3),
(469, 118, 'Transactions in financial assets and the net incurrence of liabilities', 1, 0),
(470, 118, 'Revenue and expense only', 0, 1),
(471, 118, 'Non-financial assets only', 0, 2),
(472, 118, 'Grants from the central bank', 0, 3),
(473, 119, 'Revenue exceeds expenditure', 1, 0),
(474, 119, 'Expenditure exceeds revenue', 0, 1),
(475, 119, 'Assets equal liabilities', 0, 2),
(476, 119, 'Debt exceeds 50% of GDP', 0, 3),
(477, 120, 'General government and public corporations', 1, 0),
(478, 120, 'Only the central government', 0, 1),
(479, 120, 'Private banks and households', 0, 2),
(480, 120, 'Insurance corporations only', 0, 3),
(481, 121, 'Local governments', 1, 0),
(482, 121, 'The central bank', 0, 1),
(483, 121, 'Public nonfinancial corporations', 0, 2),
(484, 121, 'Public deposit-taking corporations', 0, 3),
(485, 122, 'Public corporations (public financial corporations)', 1, 0),
(486, 122, 'General government', 0, 1),
(487, 122, 'Households', 0, 2),
(488, 122, 'Non-financial corporations of the private sector', 0, 3),
(489, 123, 'Statements from national revenue authorities', 1, 0),
(490, 123, 'Household grocery receipts', 0, 1),
(491, 123, 'Stock-market tickers', 0, 2),
(492, 123, 'Advertising spend data', 0, 3),
(493, 124, 'Its purpose — health, education, defence', 1, 0),
(494, 124, 'The economic nature of the transaction', 0, 1),
(495, 124, 'The currency of payment', 0, 2),
(496, 124, 'The maturity of debt', 0, 3),
(497, 125, 'The economic nature of the transaction (e.g. compensation of employees, goods and services)', 1, 0),
(498, 125, 'The purpose of the spending', 0, 1),
(499, 125, 'The geographic region', 0, 2),
(500, 125, 'The donor of grants', 0, 3),
(501, 126, 'To provide reliable, consistent information on government financial operations for decision-making and monitoring', 1, 0),
(502, 126, 'To set commercial bank lending rates', 0, 1),
(503, 126, 'To audit private companies', 0, 2),
(504, 126, 'To forecast the weather', 0, 3),
(505, 127, 'Revenue as a % of GDP, tax revenue as a % of GDP, public investment as a % of GDP', 1, 0),
(506, 127, 'Commercial bank deposit and lending rates', 0, 1),
(507, 127, 'Household grocery prices and rents', 0, 2),
(508, 127, 'Company share prices and dividends', 0, 3),
(509, 128, '3 percent of GDP', 1, 0),
(510, 128, '6 percent of GDP', 0, 1),
(511, 128, '50 percent of GDP', 0, 2),
(512, 128, '10 percent of GDP', 0, 3),
(513, 129, '6 percent of GDP', 1, 0),
(514, 129, '3 percent of GDP', 0, 1),
(515, 129, '50 percent of GDP', 0, 2),
(516, 129, '12 percent of GDP', 0, 3),
(517, 130, '50 percent of GDP in net present value terms', 1, 0),
(518, 130, '3 percent of GDP', 0, 1),
(519, 130, '6 percent of GDP', 0, 2),
(520, 130, '100 percent of GDP', 0, 3),
(521, 131, 'Total assets (financial and non-financial) minus total liabilities', 1, 0),
(522, 131, 'Total revenue minus total expenditure', 0, 1),
(523, 131, 'Revenue as a percentage of GDP', 0, 2),
(524, 131, 'The sum of all grants received', 0, 3),
(525, 132, 'Non-financial assets', 1, 0),
(526, 132, 'Financial assets', 0, 1),
(527, 132, 'Liabilities', 0, 2),
(528, 132, 'Revenue', 0, 3),
(529, 133, 'A capital grant (revenue)', 1, 0),
(530, 133, 'An expense', 0, 1),
(531, 133, 'A non-financial asset', 0, 2),
(532, 133, 'A reduction in revenue', 0, 3),
(533, 134, 'Changes in liabilities and interest payments', 1, 0),
(534, 134, 'A capital grant', 0, 1),
(535, 134, 'An asset sale', 0, 2),
(536, 134, 'Revenue from taxes', 0, 3),
(537, 135, 'A financial transaction affecting both assets and liabilities', 1, 0),
(538, 135, 'A capital grant', 0, 1),
(539, 135, 'An expense', 0, 2),
(540, 135, 'A non-financial asset', 0, 3),
(541, 136, 'Taxes', 1, 0),
(542, 136, 'Dividends', 0, 1),
(543, 136, 'Asset sales', 0, 2),
(544, 136, 'Liabilities', 0, 3),
(545, 137, 'Asset sales', 1, 0),
(546, 137, 'Taxes', 0, 1),
(547, 137, 'Dividends', 0, 2),
(548, 137, 'Grants', 0, 3),
(549, 138, 'To ensure fiscal sustainability', 1, 0),
(550, 138, 'To raise the policy rate', 0, 1),
(551, 138, 'To avoid publishing data', 0, 2),
(552, 138, 'To increase bank deposits', 0, 3),
(553, 139, 'Fiscal transparency, debt sustainability and regional convergence', 1, 0),
(554, 139, 'Higher household spending', 0, 1),
(555, 139, 'Private company profits', 0, 2),
(556, 139, 'Lower deposit interest', 0, 3),
(557, 140, 'Are public debts sustainable?', 1, 0),
(558, 140, 'What is tomorrow\'s weather?', 0, 1),
(559, 140, 'What price should a shop charge?', 0, 2),
(560, 140, 'Which film should I watch?', 0, 3),
(561, 141, 'Net operating balance', 1, 0),
(562, 141, 'Debt-to-GDP ratio', 0, 1),
(563, 141, 'Gross public debt', 0, 2),
(564, 141, 'Reserve requirement', 0, 3),
(565, 142, 'The net incurrence of liabilities', 1, 0),
(566, 142, 'Revenue', 0, 1),
(567, 142, 'Non-financial assets', 0, 2),
(568, 142, 'Compensation of employees', 0, 3),
(569, 143, 'General government', 1, 0),
(570, 143, 'Public nonfinancial corporations', 0, 1),
(571, 143, 'The private sector', 0, 2),
(572, 143, 'Households', 0, 3),
(573, 144, 'GFS data source', 1, 0),
(574, 144, 'Debt instrument', 0, 1),
(575, 144, 'Classification of revenue', 0, 2),
(576, 144, 'Convergence ceiling', 0, 3),
(577, 145, 'Investment in non-financial assets relative to the size of the economy', 1, 0),
(578, 145, 'The central bank policy rate', 0, 1),
(579, 145, 'Household savings', 0, 2),
(580, 145, 'Commercial lending rates', 0, 3),
(581, 146, 'Both assets and liabilities', 1, 0),
(582, 146, 'Revenue only', 0, 1),
(583, 146, 'Non-financial assets only', 0, 2),
(584, 146, 'Compensation of employees', 0, 3),
(585, 147, 'A framework used for measuring and reporting public debt data', 1, 0),
(586, 147, 'A register of private company profits', 0, 1),
(587, 147, 'A schedule of central bank policy rates', 0, 2),
(588, 147, 'A national population census', 0, 3),
(589, 148, 'A financial claim requiring future payment of interest and/or principal by the debtor to the creditor', 1, 0),
(590, 148, 'A grant that never has to be repaid', 0, 1),
(591, 148, 'Any government building or piece of land', 0, 2),
(592, 148, 'A tax on imported goods', 0, 3),
(593, 149, 'All government liabilities that are debt instruments', 1, 0),
(594, 149, 'Only foreign loans', 0, 1),
(595, 149, 'Only treasury bills', 0, 2),
(596, 149, 'Government land and equipment', 0, 3),
(597, 150, 'Analysing fiscal sustainability and measuring the government\'s risk exposure', 1, 0),
(598, 150, 'Setting commercial bank lending rates', 0, 1),
(599, 150, 'Auditing private firms', 0, 2),
(600, 150, 'Forecasting the weather', 0, 3),
(601, 151, 'The Public Sector Debt Statistics Guide (PSDSG) 2013', 1, 0),
(602, 151, 'The Balance of Payments Manual (BPM6)', 0, 1),
(603, 151, 'Basel III', 0, 2),
(604, 151, 'The COFOG classification', 0, 3),
(605, 152, 'General government and public corporations', 1, 0),
(606, 152, 'Only the central bank', 0, 1),
(607, 152, 'Private households and firms', 0, 2),
(608, 152, 'Foreign governments only', 0, 3),
(609, 153, 'Budgetary central government and extra-budgetary units', 1, 0),
(610, 153, 'Only the central bank', 0, 1),
(611, 153, 'Local councils only', 0, 2),
(612, 153, 'Private contractors', 0, 3),
(613, 154, 'Treasury bonds and Treasury bills', 1, 0),
(614, 154, 'Land and buildings', 0, 1),
(615, 154, 'Tax revenue', 0, 2),
(616, 154, 'Employee salaries', 0, 3),
(617, 155, 'IMF allocations to countries', 1, 0),
(618, 155, 'Local municipal bonds', 0, 1),
(619, 155, 'Private bank deposits', 0, 2),
(620, 155, 'Export earnings', 0, 3),
(621, 156, 'Published as memorandum items', 1, 0),
(622, 156, 'Recorded as revenue', 0, 1),
(623, 156, 'Ignored entirely', 0, 2),
(624, 156, 'Counted as non-financial assets', 0, 3),
(625, 157, 'Partner States\' Ministries of Finance, Central Banks and NSOs websites, and the EAC Statistics Portal', 1, 0),
(626, 157, 'Only in printed newspapers', 0, 1),
(627, 157, 'On private company blogs', 0, 2),
(628, 157, 'Only via commercial banks', 0, 3),
(629, 158, 'Held by resident units', 1, 0),
(630, 158, 'Held by non-resident units', 0, 1),
(631, 158, 'Always in foreign currency', 0, 2),
(632, 158, 'Always short-term', 0, 3),
(633, 159, 'More than one year', 1, 0),
(634, 159, 'One year or less', 0, 1),
(635, 159, 'Exactly six months', 0, 2),
(636, 159, 'Less than one month', 0, 3),
(637, 160, 'Bonds and treasury bills', 1, 0),
(638, 160, 'Loans and arrears', 0, 1),
(639, 160, 'Land and buildings', 0, 2),
(640, 160, 'Tax receipts', 0, 3),
(641, 161, 'Central, state and local governments', 1, 0),
(642, 161, 'Public corporations only', 0, 1),
(643, 161, 'Private banks', 0, 2),
(644, 161, 'Foreign governments', 0, 3),
(645, 162, 'GGD plus the debt of public financial and non-financial corporations', 1, 0),
(646, 162, 'GGD minus grants', 0, 1),
(647, 162, 'Only external debt', 0, 2),
(648, 162, 'Only short-term debt', 0, 3),
(649, 163, 'Guaranteed borrowing raises fiscal risk, so a fuller picture of exposure is needed', 1, 0),
(650, 163, 'To make the debt total look smaller', 0, 1),
(651, 163, 'Because it is required for the census', 0, 2),
(652, 163, 'To set commercial interest rates', 0, 3),
(653, 164, 'Non-residents (foreign governments, international organisations, foreign banks, bondholders)', 1, 0),
(654, 164, 'Residents only', 0, 1),
(655, 164, 'The central bank only', 0, 2),
(656, 164, 'Local households only', 0, 3),
(657, 165, 'All liabilities that are debt instruments', 1, 0),
(658, 165, 'Only foreign-currency loans', 0, 1),
(659, 165, 'Only short-term debt', 0, 2),
(660, 165, 'Government buildings and land', 0, 3),
(661, 166, 'Gross debt minus financial assets in corresponding debt instruments', 1, 0),
(662, 166, 'Gross debt plus interest payments', 0, 1),
(663, 166, 'Total revenue minus total expenditure', 0, 2),
(664, 166, 'Gross debt times the interest rate', 0, 3),
(665, 167, '(Total Public Debt ÷ GDP) × 100', 1, 0),
(666, 167, '(GDP ÷ Total Public Debt) × 100', 0, 1),
(667, 167, 'Total Public Debt − GDP', 0, 2),
(668, 167, 'GDP × the interest rate', 0, 3),
(669, 168, 'More sustainable', 1, 0),
(670, 168, 'Less sustainable', 0, 1),
(671, 168, 'Always a sign of crisis', 0, 2),
(672, 168, 'Irrelevant to sustainability', 0, 3),
(673, 169, '50 percent of GDP in net present value terms', 1, 0),
(674, 169, '3 percent of GDP', 0, 1),
(675, 169, '6 percent of GDP', 0, 2),
(676, 169, '100 percent of GDP', 0, 3),
(677, 170, 'Obligations that arise only if a particular future event occurs', 1, 0),
(678, 170, 'Debts that must always be repaid on a fixed date', 0, 1),
(679, 170, 'Grants that are never repaid', 0, 2),
(680, 170, 'Government-owned land and buildings', 0, 3),
(681, 171, 'They can affect fiscal sustainability even if not recorded as direct liabilities', 1, 0),
(682, 171, 'They reduce the need to publish debt data', 0, 1),
(683, 171, 'They always lower the debt-to-GDP ratio', 0, 2),
(684, 171, 'They replace the need for a budget', 0, 3),
(685, 172, 'A contractual arrangement giving rise to conditional payment requirements', 1, 0),
(686, 172, 'A liability recognised only after the event, with no contract', 0, 1),
(687, 172, 'A grant received from abroad', 0, 2),
(688, 172, 'A short-term treasury bill', 0, 3),
(689, 173, 'The debt service-to-revenue ratio', 1, 0),
(690, 173, 'The debt-to-GDP ratio', 0, 1),
(691, 173, 'The interest-to-GDP ratio', 0, 2),
(692, 173, 'The debt-to-exports ratio', 0, 3),
(693, 174, 'The debt service-to-exports ratio', 1, 0),
(694, 174, 'The interest-to-GDP ratio', 0, 1),
(695, 174, 'The debt-to-GDP ratio', 0, 2),
(696, 174, 'The debt service-to-revenue ratio', 0, 3),
(697, 175, 'A bilateral postponement of debt service with new, extended maturities', 1, 0),
(698, 175, 'A complete cancellation of all debt', 0, 1),
(699, 175, 'A change that never affects payment dates', 0, 2),
(700, 175, 'A measure that applies only to private firms', 0, 3),
(701, 176, 'Alters the original terms — e.g. lower interest, extended maturity, or partial forgiveness', 1, 0),
(702, 176, 'Only postpones payments with no change to terms', 0, 1),
(703, 176, 'Is identical to issuing new treasury bills', 0, 2),
(704, 176, 'Always cancels the debt entirely', 0, 3),
(705, 177, 'Who has money, who owes money, and how money flows through the economy', 1, 0),
(706, 177, 'Only the government\'s budget', 0, 1),
(707, 177, 'Retail shop prices', 0, 2),
(708, 177, 'Company profit forecasts', 0, 3),
(709, 178, 'Five', 1, 0),
(710, 178, 'Three', 0, 1),
(711, 178, 'Seven', 0, 2),
(712, 178, 'Two', 0, 3),
(713, 179, 'Non-profit Institutions Serving Households', 1, 0),
(714, 179, 'National Public Insurance and Social Health', 0, 1),
(715, 179, 'Net Private Investment in Shares and Holdings', 0, 2),
(716, 179, 'None of the above', 0, 3),
(717, 180, 'Has its own balance sheet and can take on liabilities and contracts in its own name', 1, 0),
(718, 180, 'Is always owned by government', 0, 1),
(719, 180, 'Cannot borrow money', 0, 2),
(720, 180, 'Only exists abroad', 0, 3),
(721, 181, 'A commercial bank', 1, 0),
(722, 181, 'An insurance company', 0, 1),
(723, 181, 'A forex bureau', 0, 2),
(724, 181, 'A pension fund', 0, 3),
(725, 182, 'A pension fund', 1, 0),
(726, 182, 'A commercial bank', 0, 1),
(727, 182, 'A deposit-taking SACCO', 0, 2),
(728, 182, 'A Money Market Fund', 0, 3),
(729, 183, 'Main centre of economic interest is outside the domestic economy', 1, 0),
(730, 183, 'Owners are foreign', 0, 1),
(731, 183, 'Staff are foreign nationals', 0, 2),
(732, 183, 'Accounts are in foreign currency', 0, 3),
(733, 184, 'Have their own sources of funding and charge market prices', 1, 0),
(734, 184, 'Depend entirely on budget allocation', 0, 1),
(735, 184, 'Cannot be owned by government', 0, 2),
(736, 184, 'Issue currency', 0, 3),
(737, 185, 'An Other Depository Corporation (ODC)', 1, 0),
(738, 185, 'An Other Financial Corporation', 0, 1),
(739, 185, 'A non-financial corporation', 0, 2),
(740, 185, 'Part of general government', 0, 3),
(741, 186, 'Users of money that do not create it', 1, 0),
(742, 186, 'Makers of money', 0, 1),
(743, 186, 'Only the central bank', 0, 2),
(744, 186, 'Only non-residents', 0, 3),
(745, 187, 'The Central Bank and ODCs', 1, 0),
(746, 187, 'Households and NPISH', 0, 1),
(747, 187, 'Central Government and non-residents', 0, 2),
(748, 187, 'OFCs and NFCs', 0, 3),
(749, 188, 'Central Government and non-residents', 1, 0),
(750, 188, 'Households and OFCs', 0, 1),
(751, 188, 'The Central Bank and ODCs', 0, 2),
(752, 188, 'NFCs and NPISH', 0, 3),
(753, 189, 'The money holding sectors', 1, 0),
(754, 189, 'The central bank only', 0, 1),
(755, 189, 'Non-residents only', 0, 2),
(756, 189, 'General government only', 0, 3),
(757, 190, 'Central bank liabilities — currency in circulation plus reserve deposits at the central bank', 1, 0),
(758, 190, 'All household savings', 0, 1),
(759, 190, 'Government tax revenue', 0, 2),
(760, 190, 'Foreign currency held by exporters', 0, 3),
(761, 191, 'Foreign assets of financial corporations minus their liabilities to the rest of the world', 1, 0),
(762, 191, 'Total household deposits', 0, 1),
(763, 191, 'Government securities only', 0, 2),
(764, 191, 'Bank capital', 0, 3),
(765, 192, 'Domestic assets of the financial sector minus its domestic liabilities to the economy', 1, 0),
(766, 192, 'Foreign reserves only', 0, 1),
(767, 192, 'The monetary base', 0, 2),
(768, 192, 'Currency outside banks', 0, 3),
(769, 193, 'Lending to central government (securities and loans) minus government deposits and obligations', 1, 0),
(770, 193, 'Only treasury bills held by banks', 0, 1),
(771, 193, 'All taxes collected', 0, 2),
(772, 193, 'Credit to households', 0, 3),
(773, 194, 'Private companies, households and NPISH', 1, 0),
(774, 194, 'Central government only', 0, 1),
(775, 194, 'Foreign banks', 0, 2),
(776, 194, 'The central bank', 0, 3),
(777, 195, 'The financial sector\'s own funds — equity, retained profits and reserves', 1, 0),
(778, 195, 'Unclassified balances', 0, 1),
(779, 195, 'Foreign assets', 0, 2),
(780, 195, 'Government deposits', 0, 3),
(781, 196, 'A series of analytical surveys that combine institutional data into standardised outputs', 1, 0),
(782, 196, 'A single annual report', 0, 1),
(783, 196, 'Daily price bulletins', 0, 2),
(784, 196, 'Company filings', 0, 3),
(785, 197, 'The monetary base', 1, 0),
(786, 197, 'Broad money', 0, 1),
(787, 197, 'Non-liquid liabilities', 0, 2),
(788, 197, 'Treasury bond rates', 0, 3),
(789, 198, 'Central Bank Survey + ODC Survey', 1, 0),
(790, 198, 'ODC Survey + OFC Survey', 0, 1),
(791, 198, 'Central Bank Survey + OFC Survey', 0, 2),
(792, 198, 'OFC Survey only', 0, 3),
(793, 199, 'Broad money', 1, 0),
(794, 199, 'The reserve requirement ratio', 0, 1),
(795, 199, 'The repo rate', 0, 2),
(796, 199, 'Capital', 0, 3),
(797, 200, 'No more than 2 years', 1, 0),
(798, 200, 'More than 10 years', 0, 1),
(799, 200, 'Exactly 5 years', 0, 2),
(800, 200, 'Unlimited', 0, 3),
(801, 201, 'Currency outside banks + transferable deposits of MHS', 1, 0),
(802, 201, 'M2 + foreign currency deposits', 0, 1),
(803, 201, 'M3 + debt securities', 0, 2),
(804, 201, 'Currency in circulation only', 0, 3),
(805, 202, 'M3', 1, 0),
(806, 202, 'M1', 0, 1),
(807, 202, 'M2', 0, 2),
(808, 202, 'M5', 0, 3),
(809, 203, 'Money Market Fund shares/units held by MHS', 1, 0),
(810, 203, 'Currency outside banks', 0, 1),
(811, 203, 'Savings deposits', 0, 2),
(812, 203, 'Foreign currency deposits', 0, 3),
(813, 204, 'Restricted deposits and fixed deposits over 2 years', 1, 0),
(814, 204, 'Currency outside banks', 0, 1),
(815, 204, 'Transferable deposits', 0, 2),
(816, 204, 'Savings deposits under 2 years', 0, 3),
(817, 205, 'Financial corporations that do not take deposits', 1, 0),
(818, 205, 'The central bank', 0, 1),
(819, 205, 'Commercial banks', 0, 2),
(820, 205, 'General government', 0, 3),
(821, 206, 'OFCs do not take deposits, so their obligations are not part of broad money', 1, 0),
(822, 206, 'OFCs are unregulated', 0, 1),
(823, 206, 'OFCs hold no assets', 0, 2),
(824, 206, 'OFCs deal only with non-residents', 0, 3),
(825, 207, 'Depository Corporations Survey + OFC Survey', 1, 0),
(826, 207, 'Central Bank Survey + ODC Survey', 0, 1),
(827, 207, 'ODC Survey + OFC Survey', 0, 2),
(828, 207, 'Central Bank Survey only', 0, 3),
(829, 208, 'Reported as two separate line items', 1, 0),
(830, 208, 'Merged into one figure', 0, 1),
(831, 208, 'Excluded', 0, 2),
(832, 208, 'Added to NFA', 0, 3),
(833, 209, 'Unclassified assets minus unclassified liabilities, plus consolidation adjustments', 1, 0),
(834, 209, 'Only treasury bills', 0, 1),
(835, 209, 'Total deposits', 0, 2),
(836, 209, 'Foreign reserves', 0, 3),
(837, 210, 'The most complete view of the financial sector\'s claims and liabilities', 1, 0),
(838, 210, 'Only the central bank\'s balance sheet', 0, 1),
(839, 210, 'Only household data', 0, 2),
(840, 210, 'Only interest rates', 0, 3),
(841, 211, 'Deposit and deposit-substitute liabilities that form part of broad money', 1, 0),
(842, 211, 'Long-term insurance reserves', 0, 1),
(843, 211, 'Capital', 0, 2),
(844, 211, 'Foreign assets', 0, 3),
(845, 212, 'The Depository Corporations Survey', 1, 0),
(846, 212, 'The OFC Survey', 0, 1),
(847, 212, 'The Central Bank Survey', 0, 2),
(848, 212, 'The interest-rate report', 0, 3),
(849, 213, 'The monetary policy direction of the central bank', 1, 0),
(850, 213, 'The exchange rate', 0, 1),
(851, 213, 'Bank profits', 0, 2),
(852, 213, 'The price of treasury bills', 0, 3),
(853, 214, 'ODCs lend to each other for very short periods', 1, 0),
(854, 214, 'The central bank lends to government', 0, 1),
(855, 214, 'Households borrow mortgages', 0, 2),
(856, 214, 'Treasury bonds are issued', 0, 3),
(857, 215, 'The share of banks\' deposit liabilities that must be held at the central bank', 1, 0),
(858, 215, 'The tax rate on banks', 0, 1),
(859, 215, 'The interest on savings', 0, 2),
(860, 215, 'The treasury bill rate', 0, 3),
(861, 216, 'Up to one year (e.g. 91, 182, 364 days)', 1, 0),
(862, 216, 'More than ten years', 0, 1),
(863, 216, 'Exactly five years', 0, 2),
(864, 216, 'No fixed maturity', 0, 3),
(865, 217, 'The industry/economic activity of the borrower', 1, 0),
(866, 217, 'The size of the loan', 0, 1),
(867, 217, 'The loan\'s currency', 0, 2),
(868, 217, 'The borrower\'s age', 0, 3),
(869, 218, 'Agriculture, forestry and fishing', 1, 0),
(870, 218, 'Manufacturing', 0, 1),
(871, 218, 'Mining and quarrying', 0, 2),
(872, 218, 'Construction', 0, 3),
(873, 219, 'Manufacturing', 1, 0),
(874, 219, 'Wholesale and retail trade', 0, 1),
(875, 219, 'Construction', 0, 2),
(876, 219, 'Mining and quarrying', 0, 3),
(877, 220, 'Monetary and multidimensional', 1, 0),
(878, 220, 'Absolute and subjective', 0, 1),
(879, 220, 'Chronic and transient', 0, 2),
(880, 220, 'Income and inequality', 0, 3),
(881, 221, 'Absolute poverty', 1, 0),
(882, 221, 'Relative poverty', 0, 1),
(883, 221, 'Subjective poverty', 0, 2),
(884, 221, 'Vulnerability', 0, 3),
(885, 222, 'Chronic poverty', 1, 0),
(886, 222, 'Transient poverty', 0, 1),
(887, 222, 'Relative poverty', 0, 2),
(888, 222, 'Subjective poverty', 0, 3),
(889, 223, 'Consumption', 1, 0),
(890, 223, 'Income', 0, 1),
(891, 223, 'Self-reported wealth', 0, 2),
(892, 223, 'Tax records', 0, 3),
(893, 224, 'As the annual value of use (service flow), via the user-cost method', 1, 0),
(894, 224, 'As its full purchase price in the year it was bought', 0, 1),
(895, 224, 'As its current resale value', 0, 2),
(896, 224, 'It is always excluded', 0, 3),
(897, 225, '$3,846', 1, 0),
(898, 225, '$2,000', 0, 1),
(899, 225, '$5,000', 0, 2),
(900, 225, '$10,000', 0, 3),
(901, 226, 'So owners are comparable to renters and their housing welfare isn\'t understated', 1, 0),
(902, 226, 'To tax homeowners', 0, 1),
(903, 226, 'Because owners always pay more than renters', 0, 2),
(904, 226, 'To remove housing from the aggregate', 0, 3),
(905, 227, '$3.00 per person per day', 1, 0),
(906, 227, '$1.90 per person per day', 0, 1),
(907, 227, '$2.15 per person per day', 0, 2),
(908, 227, '$8.30 per person per day', 0, 3),
(909, 228, '2,087.3', 1, 0),
(910, 228, '912.7', 0, 1),
(911, 228, '1,500', 0, 2),
(912, 228, '587.3', 0, 3),
(913, 229, 'Median', 1, 0),
(914, 229, 'Maximum', 0, 1),
(915, 229, 'Sum', 0, 2),
(916, 229, 'Mode', 0, 3),
(917, 230, '$4.20 per person per day', 1, 0),
(918, 230, '$3.65 per person per day', 0, 1),
(919, 230, '$3.00 per person per day', 0, 2),
(920, 230, '$8.30 per person per day', 0, 3),
(921, 231, 'α = 0', 1, 0),
(922, 231, 'α = 1', 0, 1),
(923, 231, 'α = 2', 0, 2),
(924, 231, 'α = 10', 0, 3),
(925, 232, 'The poverty gap index (P₁)', 1, 0),
(926, 232, 'The headcount ratio (P₀)', 0, 1),
(927, 232, 'The squared poverty gap (P₂)', 0, 2),
(928, 232, 'The Gini index', 0, 3),
(929, 233, 'Perfect equality', 1, 0),
(930, 233, 'Perfect inequality', 0, 1),
(931, 233, 'That everyone is poor', 0, 2),
(932, 233, 'A poverty line of zero', 0, 3),
(933, 234, '0.20', 1, 0),
(934, 234, '0.40', 0, 1),
(935, 234, '0.50', 0, 2),
(936, 234, '0.90', 0, 3),
(937, 235, 'At least one-third of the weighted indicators', 1, 0),
(938, 235, 'All of the indicators', 0, 1),
(939, 235, 'Any single indicator', 0, 2),
(940, 235, 'Exactly half of the indicators', 0, 3),
(941, 236, 'The EAC regional MPI is comparable across Partner States; most national MPIs are not comparable across countries', 1, 0),
(942, 236, 'All national MPIs are directly comparable across countries', 0, 1),
(943, 236, 'No MPI can ever be compared across countries', 0, 2),
(944, 236, 'The global MPI cannot be compared across countries', 0, 3),
(945, 237, 'To capture seasonal variation in consumption and prices', 1, 0),
(946, 237, 'To reduce the cost of the survey', 0, 1),
(947, 237, 'Because enumerators work slowly', 0, 2),
(948, 237, 'To avoid using a sampling frame', 0, 3),
(949, 238, 'A 7-day recall with a detailed food list', 1, 0),
(950, 238, 'A 12-month diary', 0, 1),
(951, 238, 'A single yes/no question', 0, 2),
(952, 238, 'A telephone interview (CATI)', 0, 3),
(953, 239, 'Enables real-time validity checks and faster, higher-quality data', 1, 0),
(954, 239, 'Removes the need for enumerators', 0, 1),
(955, 239, 'Is always the cheapest option', 0, 2),
(956, 239, 'Avoids the need for a questionnaire', 0, 3),
(957, 240, 'The BOP, the IIP, and the other changes in financial assets and liabilities accounts', 1, 0),
(958, 240, 'Current, capital and financial accounts only', 0, 1),
(959, 240, 'Exports, imports and reserves', 0, 2),
(960, 240, 'Households, corporations and government', 0, 3),
(961, 241, 'BPM6, released in 2009', 0, 0),
(962, 241, 'BPM7, released by the IMF in March 2025', 1, 1),
(963, 241, 'SNA 2025, released in 2025', 0, 2),
(964, 241, 'BPM5, released in 1993', 0, 3),
(965, 242, 'A stock statement of assets and liabilities at a point in time', 0, 0),
(966, 242, 'A record of flows between residents and the rest of the world over a period', 1, 1),
(967, 242, 'A list of a country\'s reserve assets', 0, 2),
(968, 242, 'A government budget statement', 0, 3),
(969, 243, 'Credit and debit', 0, 0),
(970, 243, 'NAFA and NIL', 1, 1),
(971, 243, 'Surplus and deficit', 0, 2),
(972, 243, 'Stock and flow', 0, 3),
(973, 244, 'Cash basis', 0, 0),
(974, 244, 'Accrual basis', 1, 1),
(975, 244, 'Modified cash basis', 0, 2),
(976, 244, 'Commitment basis', 0, 3),
(977, 245, 'Historical cost', 0, 0),
(978, 245, 'Exchange (market) prices', 1, 1),
(979, 245, 'Customs tariff value', 0, 2),
(980, 245, 'Book value', 0, 3),
(981, 246, 'Nationality of owners', 0, 0),
(982, 246, 'Centre of predominant economic interest', 1, 1),
(983, 246, 'Place of incorporation only', 0, 2),
(984, 246, 'Currency used', 0, 3),
(985, 247, 'Relevance', 0, 0),
(986, 247, 'Timeliness', 0, 1),
(987, 247, 'Profitability', 1, 2),
(988, 247, 'Coverage', 0, 3),
(989, 248, 'Goods and services; earned income; transfer income', 1, 0),
(990, 248, 'Direct, portfolio and other investment', 0, 1),
(991, 248, 'Current, capital and financial', 0, 2),
(992, 248, 'Assets, liabilities and net worth', 0, 3),
(993, 249, 'Stock-exchange records', 0, 0),
(994, 249, 'International Merchandise Trade Statistics (IMTS)', 1, 1),
(995, 249, 'Pension-fund reports', 0, 2),
(996, 249, 'Central-bank reserve records', 0, 3),
(997, 250, 'The producing economy', 0, 0),
(998, 250, 'The merchant\'s economy of residence', 1, 1),
(999, 250, 'The final buyer\'s economy', 0, 2),
(1000, 250, 'Each economy equally', 0, 3),
(1001, 251, 'General merchandise', 0, 0),
(1002, 251, 'Manufacturing services', 1, 1),
(1003, 251, 'Reserve assets', 0, 2),
(1004, 251, 'Capital transfers', 0, 3),
(1005, 252, '10', 0, 0),
(1006, 252, '12', 0, 1),
(1007, 252, '17', 1, 2),
(1008, 252, '5', 0, 3),
(1009, 253, 'Mode 1 — cross-border supply', 0, 0),
(1010, 253, 'Mode 2 — consumption abroad', 0, 1),
(1011, 253, 'Mode 3 — commercial presence', 1, 2),
(1012, 253, 'Mode 4 — presence of natural persons', 0, 3),
(1013, 254, 'Secondary income', 0, 0),
(1014, 254, 'Primary income', 1, 1),
(1015, 254, 'Current transfers', 0, 2),
(1016, 254, 'Capital transfers', 0, 3),
(1017, 255, 'Exchange', 0, 0),
(1018, 255, 'Transfer', 1, 1),
(1019, 255, 'Reserve', 0, 2),
(1020, 255, 'Derivative', 0, 3),
(1021, 256, 'No, it is always excluded', 0, 0),
(1022, 256, 'Yes, and data collection at border stations is encouraged', 1, 1),
(1023, 256, 'Only if above a value threshold', 0, 2),
(1024, 256, 'Only for services', 0, 3),
(1025, 257, 'Debits exceed credits', 0, 0),
(1026, 257, 'Credits (exports and income receivable) exceed debits', 1, 1),
(1027, 257, 'The capital account is negative', 0, 2),
(1028, 257, 'Reserves fall', 0, 3),
(1029, 258, 'A recurring payment for services rendered', 0, 0),
(1030, 258, 'A one-time, unrequited transaction relating to the acquisition, disposal or forgiveness of assets or liabilities', 1, 1),
(1031, 258, 'Any transfer made in cash', 0, 2),
(1032, 258, 'A loan between residents and nonresidents', 0, 3),
(1033, 259, 'It is made every month', 0, 0),
(1034, 259, 'A liability is forgiven by the creditor', 1, 1),
(1035, 259, 'It pays for imported goods', 0, 2),
(1036, 259, 'It is a wage payment', 0, 3),
(1037, 260, 'A corporate bond', 0, 0),
(1038, 260, 'Mineral rights', 1, 1),
(1039, 260, 'A bank deposit', 0, 2),
(1040, 260, 'An investment fund share', 0, 3),
(1041, 261, 'A current transfer', 0, 0),
(1042, 261, 'A capital tax (a capital transfer)', 1, 1),
(1043, 261, 'Earned income', 0, 2),
(1044, 261, 'A reserve asset', 0, 3),
(1045, 262, 'Current transfers always', 0, 0),
(1046, 262, 'Capital transfers if exceptionally large and infrequent', 1, 1),
(1047, 262, 'Reserve assets', 0, 2),
(1048, 262, 'Direct investment', 0, 3),
(1049, 263, 'Gross domestic product', 0, 0),
(1050, 263, 'Net lending (surplus) / net borrowing (deficit)', 1, 1),
(1051, 263, 'The statistical discrepancy', 0, 2),
(1052, 263, 'Total reserves', 0, 3),
(1053, 264, 'Functional categories, instruments, institutional sectors, maturity', 1, 0),
(1054, 264, 'Goods, services, income, transfers', 0, 1),
(1055, 264, 'Assets, liabilities, equity, reserves', 0, 2),
(1056, 264, 'Cash, accrual, market, book', 0, 3),
(1057, 265, '1% or more of voting power', 0, 0),
(1058, 265, '10% or more of voting power', 1, 1),
(1059, 265, '50% or more of voting power', 0, 2),
(1060, 265, '100% of voting power', 0, 3),
(1061, 266, 'Negotiability', 1, 0),
(1062, 266, 'Long maturity', 0, 1),
(1063, 266, 'Government backing', 0, 2),
(1064, 266, 'Physical form', 0, 3),
(1065, 267, 'Interest income', 0, 0),
(1066, 267, 'Dividends', 0, 1),
(1067, 267, 'Revaluations in the other changes account', 1, 2),
(1068, 267, 'Capital transfers', 0, 3),
(1069, 268, 'Portfolio investment', 0, 0),
(1070, 268, 'Direct investment', 0, 1),
(1071, 268, 'Reserve assets', 1, 2),
(1072, 268, 'Other investment', 0, 3);
INSERT INTO `assessment_options` (`id`, `questionId`, `optionText`, `isCorrect`, `sortOrder`) VALUES
(1073, 269, 'Direct investment', 0, 0),
(1074, 269, 'Portfolio investment', 1, 1),
(1075, 269, 'A reserve asset', 0, 2),
(1076, 269, 'A capital transfer', 0, 3),
(1077, 270, 'One year or less', 1, 0),
(1078, 270, 'Two years or less', 0, 1),
(1079, 270, 'Three years or less', 0, 2),
(1080, 270, 'Five years or less', 0, 3),
(1081, 271, 'A flow statement over a period', 0, 0),
(1082, 271, 'A position (stock) statement of external assets and liabilities at a point in time', 1, 1),
(1083, 271, 'A record of customs transactions', 0, 2),
(1084, 271, 'A government budget', 0, 3),
(1085, 272, 'Net creditor', 0, 0),
(1086, 272, 'Net debtor', 1, 1),
(1087, 272, 'Reserve issuer', 0, 2),
(1088, 272, 'Surplus economy', 0, 3),
(1089, 273, 'Tax bracket', 0, 0),
(1090, 273, 'Currency of denomination', 1, 1),
(1091, 273, 'Customs tariff line', 0, 2),
(1092, 273, 'Industry of importer', 0, 3),
(1093, 274, 'Financial-account transactions', 0, 0),
(1094, 274, 'Revaluations', 0, 1),
(1095, 274, 'Other volume changes', 1, 2),
(1096, 274, 'Current transfers', 0, 3),
(1097, 275, 'Always indicates a surplus economy', 0, 0),
(1098, 275, 'May raise risks', 1, 1),
(1099, 275, 'Has no meaning', 0, 2),
(1100, 275, 'Equals a balanced position', 0, 3),
(1101, 276, 'It records the same flows', 0, 0),
(1102, 276, 'It shows the stock/position while the BOP records the flows', 1, 1),
(1103, 276, 'It replaces the BOP', 0, 2),
(1104, 276, 'It covers only reserves', 0, 3),
(1105, 277, 'Food availability', 0, 0),
(1106, 277, 'Economic access', 1, 1),
(1107, 277, 'Nutrition utilization', 0, 2),
(1108, 277, 'Food safety', 0, 3),
(1109, 278, 'Chronic food insecurity requiring long-term development programs', 0, 0),
(1110, 278, 'Transitory food insecurity transitioning toward acute crisis', 1, 1),
(1111, 278, 'Acute food insecurity requiring only short-term emergency response', 0, 2),
(1112, 278, 'No food insecurity—this is a normal seasonal pattern', 0, 3),
(1113, 279, 'Import Dependency: 36%; Self-Sufficiency: 67% - Moderate vulnerability', 1, 0),
(1114, 279, 'Import Dependency: 54%; Self-Sufficiency: 67% - High vulnerability', 0, 1),
(1115, 279, 'Import Dependency: 36%; Self-Sufficiency: 108% - Low vulnerability', 0, 2),
(1116, 279, 'Cannot calculate from the information given', 0, 3),
(1117, 280, 'Economic access', 0, 0),
(1118, 280, 'Physical access', 0, 1),
(1119, 280, 'Social access (primarily)', 1, 2),
(1120, 280, 'Legal access', 0, 3),
(1121, 281, 'Cash transfer program to increase food purchases', 0, 0),
(1122, 281, 'Agricultural inputs to boost food production', 0, 1),
(1123, 281, 'Integrated nutrition program: dietary diversification + water/sanitation + micronutrient supplementation', 1, 2),
(1124, 281, 'Emergency food distributions', 0, 3),
(1125, 282, 'Yes - 30% production increase will solve instability', 0, 0),
(1126, 282, 'Unlikely to be sufficient on its own', 1, 1),
(1127, 282, 'Yes - production is the only problem', 0, 2),
(1128, 282, 'No - agricultural interventions never work', 0, 3),
(1129, 283, 'Availability (production inadequate)', 0, 0),
(1130, 283, 'Economic Access (poverty preventing food purchase)', 0, 1),
(1131, 283, 'Utilization (diet quality and WASH problems)', 1, 2),
(1132, 283, 'Stability (recent shocks causing crisis)', 0, 3),
(1133, 284, 'Three', 0, 0),
(1134, 284, 'Four', 0, 1),
(1135, 284, 'Five', 1, 2),
(1136, 284, 'Seven', 0, 3),
(1137, 285, 'The Basel Standards issued by the BCBS', 1, 0),
(1138, 285, 'The GATS modes of supply', 0, 1),
(1139, 285, 'The SNA 2025 sequence of accounts', 0, 2),
(1140, 285, 'The IMTS concepts and definitions', 0, 3),
(1141, 286, '6.0 percent', 0, 0),
(1142, 286, '8.5 percent', 1, 1),
(1143, 286, '10 percent', 0, 2),
(1144, 286, '12 percent', 0, 3),
(1145, 287, 'A measure of loan concentration', 0, 0),
(1146, 287, 'A safeguard against rapid asset growth without corresponding capital injection', 1, 1),
(1147, 287, 'A measure of foreign-exchange exposure', 0, 2),
(1148, 287, 'A profitability indicator', 0, 3),
(1149, 288, '30 days', 0, 0),
(1150, 288, '60 days', 0, 1),
(1151, 288, '90 days', 1, 2),
(1152, 288, 'one year', 0, 3),
(1153, 289, 'The extent to which a DT has set aside funds to cover potential losses from its NPLs', 1, 0),
(1154, 289, 'How loans are spread across sectors', 0, 1),
(1155, 289, 'The DT\'s foreign-currency exposure', 0, 2),
(1156, 289, 'The proportion of digital loans', 0, 3),
(1157, 290, 'The profit earned from the DT\'s own funds (capital)', 1, 0),
(1158, 290, 'The proportion of loans that are nonperforming', 0, 1),
(1159, 290, 'The DT\'s foreign-exchange exposure', 0, 2),
(1160, 290, 'The share of digital loans', 0, 3),
(1161, 291, '3 months or less', 1, 0),
(1162, 291, '6 months or less', 0, 1),
(1163, 291, 'one year or less', 0, 2),
(1164, 291, 'any maturity', 0, 3),
(1165, 292, '30 days; 100 percent', 1, 0),
(1166, 292, '90 days; 100 percent', 0, 1),
(1167, 292, 'one year; 100 percent', 0, 2),
(1168, 292, '30 days; 8.5 percent', 0, 3),
(1169, 293, 'Changes in the value of foreign currency', 1, 0),
(1170, 293, 'Loan concentration', 0, 1),
(1171, 293, 'Rising staff costs', 0, 2),
(1172, 293, 'Digital-loan defaults', 0, 3),
(1173, 294, 'Five', 0, 0),
(1174, 294, 'Ten', 0, 1),
(1175, 294, 'Twelve', 1, 2),
(1176, 294, 'Thirteen', 0, 3),
(1177, 295, 'Core capital to total deposits', 0, 0),
(1178, 295, 'Digital loans to gross loans', 1, 1),
(1179, 295, 'Loans to deposits ratio', 0, 2),
(1180, 295, 'Effective interest on loans', 0, 3),
(1181, 296, 'Non-Life Insurance Companies (NLICs)', 0, 0),
(1182, 296, 'Life Insurance Companies (LICs)', 1, 1),
(1183, 296, 'Money market funds', 0, 2),
(1184, 296, 'Deposit takers', 0, 3),
(1185, 297, 'Above 100 percent', 0, 0),
(1186, 297, 'Below 100 percent', 1, 1),
(1187, 297, 'Exactly at 50 percent', 0, 2),
(1188, 297, 'Above 150 percent', 0, 3),
(1189, 298, 'The proportion of premiums retained rather than passed on to reinsurance', 1, 0),
(1190, 298, 'The proportion of assets held in real estate', 0, 1),
(1191, 298, 'The insurer\'s profitability on its own funds', 0, 2),
(1192, 298, 'The level of insurance coverage in the economy', 0, 3),
(1193, 299, '30 days', 0, 0),
(1194, 299, '90 days', 0, 1),
(1195, 299, '12 months', 1, 2),
(1196, 299, 'five years', 0, 3),
(1197, 300, 'Cover the future benefits it intends to pay', 1, 0),
(1198, 300, 'Pay its staff salaries', 0, 1),
(1199, 300, 'Buy more real estate', 0, 2),
(1200, 300, 'Reduce its dependency ratio', 0, 3),
(1201, 301, 'Higher operational cost', 0, 0),
(1202, 301, 'Minimal operational cost', 1, 1),
(1203, 301, 'A larger dependency ratio', 0, 2),
(1204, 301, 'More real-estate exposure', 0, 3),
(1205, 302, '1 year or less (short-term)', 1, 0),
(1206, 302, 'more than 5 years', 0, 1),
(1207, 302, 'exactly 10 years', 0, 2),
(1208, 302, 'with no maturity', 0, 3),
(1209, 303, 'Apartments and houses purchased by households for their own use', 1, 0),
(1210, 303, 'Offices, shops and warehouses', 0, 1),
(1211, 303, 'Government securities', 0, 2),
(1212, 303, 'Foreign currency', 0, 3),
(1213, 304, 'It may shrink collateral value, creating a loan exposure', 1, 0),
(1214, 304, 'It increases the EAC minimum CET1 ratio', 0, 1),
(1215, 304, 'It raises the dependency ratio', 0, 2),
(1216, 304, 'It has no effect on DTs', 0, 3),
(1217, 305, 'Profit earned from NFCs\' own funds', 1, 0),
(1218, 305, 'Debt borrowed in foreign currency', 0, 1),
(1219, 305, 'The proportion of income spent on operating costs', 0, 2),
(1220, 305, 'Loans spread across sectors', 0, 3),
(1221, 306, 'Repay the interest on funds borrowed using their income', 1, 0),
(1222, 306, 'Repay the full principal immediately', 0, 1),
(1223, 306, 'Attract foreign investors', 0, 2),
(1224, 306, 'Reduce its operational costs', 0, 3),
(1225, 307, 'People who live together and share some of their money and expenses (can be one person or a family)', 1, 0),
(1226, 307, 'Only a married couple with children', 0, 1),
(1227, 307, 'A registered business', 0, 2),
(1228, 307, 'A government department', 0, 3),
(1229, 308, 'Households have borrowed a lot relative to their income (household indebtedness)', 1, 0),
(1230, 308, 'Households have no debt', 0, 1),
(1231, 308, 'The economy has grown', 0, 2),
(1232, 308, 'Banks hold more capital', 0, 3),
(1425, 357, 'Income or consumption compared to a poverty line', 0, 0),
(1426, 357, 'Deprivations across several dimensions such as health, education and living standards', 1, 1),
(1427, 357, 'Only the cost of a food basket', 0, 2),
(1428, 357, 'The market value of a household\'s assets', 0, 3),
(1429, 358, 'Comparable over time', 1, 0),
(1430, 358, 'Collected only once', 0, 1),
(1431, 358, 'Kept confidential', 0, 2),
(1432, 358, 'Measured in US dollars only', 0, 3),
(1433, 359, 'Relative poverty line', 1, 0),
(1434, 359, 'Absolute poverty line', 0, 1),
(1435, 359, 'Subjective poverty line', 0, 2),
(1436, 359, 'Multidimensional index', 0, 3),
(1437, 360, 'A subjective poverty measure', 1, 0),
(1438, 360, 'An absolute poverty line', 0, 1),
(1439, 360, 'A consumption aggregate', 0, 2),
(1440, 360, 'The Gini index', 0, 3),
(1441, 361, 'Transient poverty', 1, 0),
(1442, 361, 'Chronic poverty', 0, 1),
(1443, 361, 'Relative poverty', 0, 2),
(1444, 361, 'Inequality', 0, 3),
(1445, 362, 'The forward-looking risk of falling into poverty after a shock', 1, 0),
(1446, 362, 'The number of people currently poor', 0, 1),
(1447, 362, 'The gap between rich and poor', 0, 2),
(1448, 362, 'The cost of a food basket', 0, 3),
(1449, 363, 'People can be unequal without being poor', 1, 0),
(1450, 363, 'Poverty and inequality are the same thing', 0, 1),
(1451, 363, 'Reducing inequality always eliminates poverty', 0, 2),
(1452, 363, 'Inequality only matters in poor countries', 0, 3),
(1453, 364, 'Defining and computing the welfare indicator', 1, 0),
(1454, 364, 'Setting the poverty line', 0, 1),
(1455, 364, 'Computing the headcount ratio', 0, 2),
(1456, 364, 'Disaggregating results by region', 0, 3),
(1457, 365, 'Consumption', 1, 0),
(1458, 365, 'Income', 0, 1),
(1459, 365, 'Self-reported wealth rank', 0, 2),
(1460, 365, 'Tax records', 0, 3),
(1461, 366, 'As the annual value of use (service flow)', 1, 0),
(1462, 366, 'As its full purchase price in the year bought', 0, 1),
(1463, 366, 'It is always excluded', 0, 2),
(1464, 366, 'As its resale value', 0, 3),
(1465, 367, 'Valued at local market prices and included', 1, 0),
(1466, 367, 'Excluded because no money changed hands', 0, 1),
(1467, 367, 'Counted only if sold', 0, 2),
(1468, 367, 'Valued at the national average price only', 0, 3),
(1469, 368, 'Total expenditure on an item ÷ quantity purchased', 1, 0),
(1470, 368, 'Quantity purchased ÷ total expenditure', 0, 1),
(1471, 368, 'The national poverty line ÷ household size', 0, 2),
(1472, 368, 'Current price ÷ purchase price', 0, 3),
(1473, 369, 'So owners are comparable to renters and their housing welfare isn\'t understated', 1, 0),
(1474, 369, 'To tax homeowners', 0, 1),
(1475, 369, 'Because owners pay more than renters', 0, 2),
(1476, 369, 'To exclude housing from the aggregate', 0, 3),
(1477, 370, 'User cost', 1, 0),
(1478, 370, 'Acquisition', 0, 1),
(1479, 370, 'Rental equivalence', 0, 2),
(1480, 370, 'Resale value', 0, 3),
(1481, 371, 'Income tax payments', 1, 0),
(1482, 371, 'Food received as a gift', 0, 1),
(1483, 371, 'Imputed rent for an owned home', 0, 2),
(1484, 371, 'The service value of a bicycle', 0, 3),
(1485, 372, 'Adjusts for inflation / price differences (constant prices)', 1, 0),
(1486, 372, 'Adds taxes back in', 0, 1),
(1487, 372, 'Uses income instead of spending', 0, 2),
(1488, 372, 'Counts only food', 0, 3),
(1489, 373, '$3,846', 1, 0),
(1490, 373, '$2,000', 0, 1),
(1491, 373, '$10,000', 0, 2),
(1492, 373, '$5,000', 0, 3),
(1493, 374, 'The urban household remains better off, but the difference in welfare is smaller after adjusting for price differences', 1, 0),
(1494, 374, 'Both households have the same level of welfare after price adjustment', 0, 1),
(1495, 374, 'The rural household is better off because its nominal consumption is lower', 0, 2),
(1496, 374, 'Price adjustments do not affect comparisons of household welfare', 0, 3),
(1497, 375, 'The absolute line, because it applies across EAC countries and keeps comparisons consistent', 1, 0),
(1498, 375, 'The relative line, because it moves with the average', 0, 1),
(1499, 375, 'The subjective line, because it reflects feelings', 0, 2),
(1500, 375, 'None — lines are not used in the EAC', 0, 3),
(1501, 376, '$3.00 per person per day', 1, 0),
(1502, 376, '$1.90 per person per day', 0, 1),
(1503, 376, '$2.15 per person per day', 0, 2),
(1504, 376, '$8.30 per person per day', 0, 3),
(1505, 377, 'Costing a minimum food basket, then adding essential non-food spending', 1, 0),
(1506, 377, 'Taking 60% of median income', 0, 1),
(1507, 377, 'Asking people what they feel they need', 0, 2),
(1508, 377, 'Using the global $3.00 line directly', 0, 3),
(1509, 378, '1.15', 1, 0),
(1510, 378, '0.87', 0, 1),
(1511, 378, '2.25', 0, 2),
(1512, 378, '1.96', 0, 3),
(1513, 379, 'Food spending is about equal to the food poverty line', 1, 0),
(1514, 379, 'Total spending is the national median', 0, 1),
(1515, 379, 'Income is zero', 0, 2),
(1516, 379, 'Non-food spending is highest', 0, 3),
(1517, 380, '2,087.3', 1, 0),
(1518, 380, '912.7', 0, 1),
(1519, 380, '1,500', 0, 2),
(1520, 380, '587.3', 0, 3),
(1521, 381, 'Median', 1, 0),
(1522, 381, 'Maximum', 0, 1),
(1523, 381, 'Sum', 0, 2),
(1524, 381, 'Mode', 0, 3),
(1525, 382, 'The two lines use different thresholds and aren\'t directly comparable — both are valid and complementary', 1, 0),
(1526, 382, 'The national line should be replaced by $3.00', 0, 1),
(1527, 382, 'The international line is always more accurate', 0, 2),
(1528, 382, 'One of them must be a calculation error', 0, 3),
(1529, 383, 'α = 0', 1, 0),
(1530, 383, 'α = 1', 0, 1),
(1531, 383, 'α = 2', 0, 2),
(1532, 383, 'α = 100', 0, 3),
(1533, 384, '0.20 (20%)', 1, 0),
(1534, 384, '0.45 (45%)', 0, 1),
(1535, 384, '0.90 (90%)', 0, 2),
(1536, 384, '0.05 (5%)', 0, 3),
(1537, 385, 'The poverty gap (P₁) / sum of gaps', 1, 0),
(1538, 385, 'The headcount (P₀)', 0, 1),
(1539, 385, 'The Gini index', 0, 2),
(1540, 385, 'The squared gap (P₂)', 0, 3),
(1541, 386, 'The poorest in Region A are worse off; poverty is more unequal there', 1, 0),
(1542, 386, 'Region A has fewer poor people', 0, 1),
(1543, 386, 'Region A\'s poor are closer to the line', 0, 2),
(1544, 386, 'The two regions are identical', 0, 3),
(1545, 387, '0.14', 1, 0),
(1546, 387, '0.40', 0, 1),
(1547, 387, '0.07', 0, 2),
(1548, 387, '1.40', 0, 3),
(1549, 388, 'Targeted investment in that region (roads, agriculture, school feeding)', 1, 0),
(1550, 388, 'Cut the national poverty line', 0, 1),
(1551, 388, 'Stop collecting survey data', 0, 2),
(1552, 388, 'Ignore it — the national average is fine', 0, 3),
(1553, 389, 'Fewer are poor, but the poorest are falling further behind — inequality among the poor is worsening', 1, 0),
(1554, 389, 'Poverty has been eliminated', 0, 1),
(1555, 389, 'The data must be wrong', 0, 2),
(1556, 389, 'Nothing has changed', 0, 3),
(1557, 390, 'Perfect equality — everyone has the same income/consumption', 1, 0),
(1558, 390, 'Perfect inequality', 0, 1),
(1559, 390, 'Everyone is poor', 0, 2),
(1560, 390, 'The poverty line is zero', 0, 3),
(1561, 391, 'Considers deprivations across several dimensions, not just income/consumption', 1, 0),
(1562, 391, 'Uses a higher income line', 0, 1),
(1563, 391, 'Only applies to children', 0, 2),
(1564, 391, 'Ignores health and education', 0, 3),
(1565, 392, 'Complementary — many countries report both', 1, 0),
(1566, 392, 'Multidimensional replaces monetary', 0, 1),
(1567, 392, 'They always give the same result', 0, 2),
(1568, 392, 'They cannot be used together', 0, 3),
(1569, 393, 'Amartya Sen', 1, 0),
(1570, 393, 'Adam Smith', 0, 1),
(1571, 393, 'The World Bank', 0, 2),
(1572, 393, 'UNICEF', 0, 3),
(1573, 394, 'At least one-third of the weighted indicators', 1, 0),
(1574, 394, 'All ten indicators', 0, 1),
(1575, 394, 'Any single indicator', 0, 2),
(1576, 394, 'Exactly half the indicators', 0, 3),
(1577, 395, '0.25', 1, 0),
(1578, 395, '0.50', 0, 1),
(1579, 395, '1.00', 0, 2),
(1580, 395, '0.10', 0, 3),
(1581, 396, 'Reveal inequalities and target interventions', 1, 0),
(1582, 396, 'Lower the national MPI', 0, 1),
(1583, 396, 'Remove the need for a cut-off', 0, 2),
(1584, 396, 'Make the MPI comparable across countries', 0, 3),
(1585, 397, 'The EAC regional MPI (standardised indicators across Partner States)', 1, 0),
(1586, 397, 'Each country\'s own national MPI', 0, 1),
(1587, 397, 'Different cut-offs for each', 0, 2),
(1588, 397, 'Their monetary poverty lines only', 0, 3),
(1589, 398, 'Reflects the intensity of poverty, not just the number of poor', 1, 0),
(1590, 398, 'Is always lower', 0, 1),
(1591, 398, 'Ignores how deprived people are', 0, 2),
(1592, 398, 'Requires no data', 0, 3),
(1593, 399, 'They supply the data for both monetary and non-monetary poverty indicators', 1, 0),
(1594, 399, 'They replace the need for poverty lines', 0, 1),
(1595, 399, 'They are cheaper than a census', 0, 2),
(1596, 399, 'They only measure income', 0, 3),
(1597, 400, 'Every 3 to 5 years', 1, 0),
(1598, 400, 'Every month', 0, 1),
(1599, 400, 'Once a decade only', 0, 2),
(1600, 400, 'Every 20 years', 0, 3),
(1601, 401, 'To capture seasonal variation in food consumption and prices', 1, 0),
(1602, 401, 'To save money', 0, 1),
(1603, 401, 'Because enumerators work slowly', 0, 2),
(1604, 401, 'To avoid using a sampling frame', 0, 3),
(1605, 402, 'Multi-stage stratified cluster sampling', 1, 0),
(1606, 402, 'A simple census of everyone', 0, 1),
(1607, 402, 'Convenience sampling at markets', 0, 2),
(1608, 402, 'Quota sampling by phone', 0, 3),
(1609, 403, 'COICOP', 1, 0),
(1610, 403, 'ISO 9001', 0, 1),
(1611, 403, 'The Gini scale', 0, 2),
(1612, 403, 'PPP', 0, 3),
(1613, 404, 'A 7-day recall with a detailed food list', 1, 0),
(1614, 404, 'A 12-month diary', 0, 1),
(1615, 404, 'A single yes/no question', 0, 2),
(1616, 404, 'Telephone interview (CATI)', 0, 3),
(1617, 405, 'A pilot is a fuller dress rehearsal of the whole questionnaire and fieldwork logistics', 1, 0),
(1618, 405, 'A pilot only checks the software', 0, 1),
(1619, 405, 'A pilot has no respondents', 0, 2),
(1620, 405, 'A pilot replaces enumerator training', 0, 3),
(1621, 406, 'It enables real-time validity checks and faster, higher-quality data', 1, 0),
(1622, 406, 'It removes the need for enumerators', 0, 1),
(1623, 406, 'It is always cheaper', 0, 2),
(1624, 406, 'It avoids the need for a questionnaire', 0, 3),
(1625, 407, 'Results are representative of the whole population', 1, 0),
(1626, 407, 'The dataset is smaller', 0, 1),
(1627, 407, 'Duplicates are created', 0, 2),
(1628, 407, 'The poverty line is set', 0, 3),
(1629, 408, 'Balance of Payments, International Investment Position, Other Changes in Financial Assets and Liabilities Account', 1, 0),
(1630, 408, 'Balance of Payments Transactions, International Investment Position Stocks, Revaluations', 0, 1),
(1631, 408, 'Current Account, Capital Account, Financial Account', 0, 2),
(1632, 408, 'International Investment Position Assets, International Investment Position Liabilities, Net International Investment Position', 0, 3),
(1633, 409, 'A position is a level of assets/liabilities at a point in time; a flow is a transaction or other change over a period', 1, 0),
(1634, 409, 'A position is always larger than a flow', 0, 1),
(1635, 409, 'Flows appear only in the International Investment Position (IIP)', 0, 2),
(1636, 409, 'There is no difference', 0, 3),
(1637, 410, 'The digitalization of economic activity and emergence of digital financial assets', 0, 0),
(1638, 410, 'The need to better capture global production and trade in services', 0, 1),
(1639, 410, 'Strengthening alignment with the System of National Accounts (SNA)', 0, 2),
(1640, 410, 'The abolition of the International Investment Position (IIP)', 1, 3),
(1641, 411, 'Timeliness', 0, 0),
(1642, 411, 'Coverage', 1, 1),
(1643, 411, 'Confidentiality', 0, 2),
(1644, 411, 'Accessibility', 0, 3),
(1645, 412, 'Net acquisition of financial assets and net incurrence of liabilities', 1, 0),
(1646, 412, 'National accounts and national income limits', 0, 1),
(1647, 412, 'Nominal assets and notional liabilities', 0, 2),
(1648, 412, 'Net additional flows and net interest liabilities', 0, 3),
(1649, 413, 'Three', 0, 0),
(1650, 413, 'Four', 0, 1),
(1651, 413, 'Five', 1, 2),
(1652, 413, 'Seven', 0, 3),
(1653, 414, 'At CIF value (cost, insurance, and freight) at the border of the importing economy', 0, 0),
(1654, 414, 'At FOB value (free on board), excluding international transport and insurance costs beyond the border of the exporting economy', 1, 1),
(1655, 414, 'At market prices determined by customs authorities', 0, 2),
(1656, 414, 'At CIF value less import duties and taxes', 0, 3),
(1657, 415, 'In the economy where the goods are produced', 0, 0),
(1658, 415, 'In the economy where the merchant is resident', 1, 1),
(1659, 415, 'In the final buyer\'s economy', 0, 2),
(1660, 415, 'In all three economies equally', 0, 3),
(1661, 416, '−100', 0, 0),
(1662, 416, '+100', 0, 1),
(1663, 416, 'Zero', 1, 2),
(1664, 416, 'It cannot be determined', 0, 3),
(1665, 417, 'Mode 1 — cross-border supply', 0, 0),
(1666, 417, 'Mode 2 — consumption abroad', 0, 1),
(1667, 417, 'Mode 3 — commercial presence', 1, 2),
(1668, 417, 'Mode 4 — presence of natural persons', 0, 3),
(1669, 418, 'Two', 0, 0),
(1670, 418, 'Three', 0, 1),
(1671, 418, 'Five', 1, 2),
(1672, 418, 'Seventeen', 0, 3),
(1673, 419, 'An exchange', 0, 0),
(1674, 419, 'A transfer', 1, 1),
(1675, 419, 'A reserve asset', 0, 2),
(1676, 419, 'A capital instrument', 0, 3),
(1677, 420, 'Exports exceed imports and income receivable exceeds income payable', 0, 0),
(1678, 420, 'Debits (imports and income payable) exceed credits (exports and income receivable)', 1, 1),
(1679, 420, 'The capital account is zero', 0, 2),
(1680, 420, 'Reserve assets have increased', 0, 3),
(1681, 421, 'A liability is forgiven by the creditor', 1, 0),
(1682, 421, 'A worker sends part of their wages home', 0, 1),
(1683, 421, 'A tourist buys a meal abroad', 0, 2),
(1684, 421, 'A firm pays for imported raw materials', 0, 3),
(1685, 422, 'A government bond', 0, 0),
(1686, 422, 'Mineral rights', 1, 1),
(1687, 422, 'Bank deposits', 0, 2),
(1688, 422, 'A direct-investment equity stake', 0, 3),
(1689, 423, 'A current transfer', 0, 0),
(1690, 423, 'A capital transfer (capital tax)', 1, 1),
(1691, 423, 'Earned income', 0, 2),
(1692, 423, 'A reserve asset', 0, 3),
(1693, 424, 'It is linked to the acquisition or disposal of an asset', 0, 0),
(1694, 424, 'It is not linked to an asset and directly affects disposable income', 1, 1),
(1695, 424, 'It is always made in kind', 0, 2),
(1696, 424, 'It is recorded in the financial account', 0, 3),
(1697, 425, 'The statistical discrepancy', 0, 0),
(1698, 425, 'Net lending (surplus) / net borrowing (deficit)', 1, 1),
(1699, 425, 'Gross domestic product', 0, 2),
(1700, 425, 'Reserve assets', 0, 3),
(1701, 426, 'Functional categories, financial instruments, institutional sectors, and maturity', 1, 0),
(1702, 426, 'Goods, services, income, and transfers', 0, 1),
(1703, 426, 'Assets, liabilities, equity, and reserves', 0, 2),
(1704, 426, 'Current, capital, financial, and reserve', 0, 3),
(1705, 427, '1% or more of voting power', 0, 0),
(1706, 427, '10% or more of voting power', 1, 1),
(1707, 427, '25% or more of voting power', 0, 2),
(1708, 427, '51% or more of voting power', 0, 3),
(1709, 428, 'Portfolio investment', 0, 0),
(1710, 428, 'Other investment', 0, 1),
(1711, 428, 'Reserve assets', 1, 2),
(1712, 428, 'Direct investment', 0, 3),
(1713, 429, 'Direct investment', 0, 0),
(1714, 429, 'Portfolio investment', 1, 1),
(1715, 429, 'Reserve assets', 0, 2),
(1716, 429, 'A financial derivative', 0, 3),
(1717, 430, 'Households and NPISH', 1, 0),
(1718, 430, 'Direct investors', 0, 1),
(1719, 430, 'Reserve managers', 0, 2),
(1720, 430, 'Exporters', 0, 3),
(1721, 431, 'Three months or less', 0, 0),
(1722, 431, 'One year or less', 1, 1),
(1723, 431, 'Two years or less', 0, 2),
(1724, 431, 'Five years or less', 0, 3),
(1725, 432, 'The country acquired more financial assets abroad than liabilities it incurred', 0, 0),
(1726, 432, 'Liabilities incurred exceed financial assets acquired — net capital is flowing in', 1, 1),
(1727, 432, 'Reserves have necessarily fallen', 0, 2),
(1728, 432, 'The current account is in surplus', 0, 3),
(1729, 433, 'A negative net IIP (net debtor)', 0, 0),
(1730, 433, 'A positive net IIP (net creditor)', 1, 1),
(1731, 433, 'A balanced current account', 0, 2),
(1732, 433, 'No reserve assets', 0, 3),
(1733, 434, 'Currency of denomination', 1, 0),
(1734, 434, 'Customs tariff line', 0, 1),
(1735, 434, 'Tax bracket', 0, 2),
(1736, 434, 'Industry of the importer', 0, 3),
(1737, 435, 'A financial-account transaction', 0, 0),
(1738, 435, 'A revaluation', 1, 1),
(1739, 435, 'An other volume change', 0, 2),
(1740, 435, 'A current transfer', 0, 3),
(1741, 436, 'Always indicates a surplus economy', 0, 0),
(1742, 436, 'May raise risks', 1, 1),
(1743, 436, 'Has no analytical meaning', 0, 2),
(1744, 436, 'Is the same as a balanced position', 0, 3),
(1745, 437, 'It records the same flows as the BOP', 0, 0),
(1746, 437, 'It shows the stock (position) while the BOP records the flows', 1, 1),
(1747, 437, 'It replaces the BOP', 0, 2),
(1748, 437, 'It covers only reserve assets', 0, 3),
(1749, 438, 'Customs data', 0, 0),
(1750, 438, 'Central-bank records', 1, 1),
(1751, 438, 'Stock-exchange records', 0, 2),
(1752, 438, 'Enterprise VAT returns', 0, 3),
(1753, 439, 'A standardized system that tracks how governments earn, spend, borrow and manage resources', 1, 0),
(1754, 439, 'A list of commercial bank interest rates', 0, 1),
(1755, 439, 'A register of private company profits', 0, 2),
(1756, 439, 'A weather and climate monitoring tool', 0, 3),
(1757, 440, 'When they occur, regardless of when cash moves', 1, 0),
(1758, 440, 'Only when cash is actually received or paid', 0, 1),
(1759, 440, 'Once a year at budget time', 0, 2),
(1760, 440, 'Only for foreign-currency items', 0, 3),
(1761, 441, 'The opening balance sheet plus the flows during the period', 1, 0),
(1762, 441, 'Only the transactions during the period', 0, 1),
(1763, 441, 'Total revenue minus total expenditure', 0, 2),
(1764, 441, 'The central bank\'s balance sheet', 0, 3),
(1765, 442, 'Taxes, social contributions, grants and other revenue', 1, 0),
(1766, 442, 'Compensation of employees', 0, 1),
(1767, 442, 'Interest and subsidies', 0, 2),
(1768, 442, 'Loans issued by the government', 0, 3),
(1769, 443, 'Total revenue minus total expenditure', 1, 0),
(1770, 443, 'Total assets minus total liabilities', 0, 1),
(1771, 443, 'Revenue as a percentage of GDP', 0, 2),
(1772, 443, 'The central bank policy rate', 0, 3),
(1773, 444, 'Transactions in financial assets and the net incurrence of liabilities', 1, 0),
(1774, 444, 'Revenue and expense only', 0, 1),
(1775, 444, 'Non-financial assets only', 0, 2),
(1776, 444, 'Grants from the central bank', 0, 3),
(1777, 445, 'General government and public corporations', 1, 0),
(1778, 445, 'Only the central government', 0, 1),
(1779, 445, 'Private banks and households', 0, 2),
(1780, 445, 'Insurance corporations only', 0, 3),
(1781, 446, 'Statements from national revenue authorities', 1, 0),
(1782, 446, 'Private household shopping receipts', 0, 1),
(1783, 446, 'Stock-market price tickers', 0, 2),
(1784, 446, 'Commercial advertising data', 0, 3),
(1785, 447, 'Its purpose — such as health, education and defence', 1, 0),
(1786, 447, 'The economic nature of the transaction', 0, 1),
(1787, 447, 'The currency of the payment', 0, 2),
(1788, 447, 'The maturity of the debt', 0, 3),
(1789, 448, 'To provide reliable, consistent information on government financial operations for decision-making and monitoring', 1, 0),
(1790, 448, 'To set commercial bank lending rates', 0, 1),
(1791, 448, 'To audit private companies', 0, 2),
(1792, 448, 'To forecast the weather', 0, 3),
(1793, 449, 'Revenue as a % of GDP, tax revenue as a % of GDP, public investment as a % of GDP', 1, 0),
(1794, 449, 'Commercial bank deposit rates and lending rates', 0, 1),
(1795, 449, 'Household grocery prices and rents', 0, 2),
(1796, 449, 'Company share prices and dividends', 0, 3),
(1797, 450, '3 percent of GDP', 1, 0),
(1798, 450, '6 percent of GDP', 0, 1),
(1799, 450, '50 percent of GDP', 0, 2),
(1800, 450, '10 percent of GDP', 0, 3),
(1801, 451, 'Total assets (financial and non-financial) minus total liabilities', 1, 0),
(1802, 451, 'Total revenue minus total expenditure', 0, 1),
(1803, 451, 'Revenue as a percentage of GDP', 0, 2),
(1804, 451, 'The sum of all grants received', 0, 3),
(1805, 452, 'A capital grant (revenue)', 1, 0),
(1806, 452, 'An expense', 0, 1),
(1807, 452, 'A non-financial asset', 0, 2),
(1808, 452, 'A reduction in revenue', 0, 3),
(1809, 453, 'Taxes', 1, 0),
(1810, 453, 'Dividends', 0, 1),
(1811, 453, 'Asset sales', 0, 2),
(1812, 453, 'Liabilities', 0, 3),
(1813, 454, 'To ensure fiscal sustainability', 1, 0),
(1814, 454, 'To increase the central bank policy rate', 0, 1),
(1815, 454, 'To avoid publishing GFS data', 0, 2),
(1816, 454, 'To raise commercial bank deposits', 0, 3),
(1817, 455, 'Fiscal transparency, debt sustainability and regional convergence', 1, 0),
(1818, 455, 'Higher household spending', 0, 1),
(1819, 455, 'Private company profits', 0, 2),
(1820, 455, 'Lower interest on bank deposits', 0, 3),
(1821, 456, 'A framework used for measuring and reporting public debt data', 1, 0),
(1822, 456, 'A register of private company profits', 0, 1),
(1823, 456, 'A schedule of central bank policy rates', 0, 2),
(1824, 456, 'A national population census', 0, 3),
(1825, 457, 'A financial claim requiring future payment of interest and/or principal by the debtor to the creditor', 1, 0),
(1826, 457, 'Any government building or piece of land', 0, 1),
(1827, 457, 'A grant that never has to be repaid', 0, 2),
(1828, 457, 'A tax on imported goods', 0, 3),
(1829, 458, 'The Public Sector Debt Statistics Guide (PSDSG) 2013', 1, 0),
(1830, 458, 'The Balance of Payments Manual (BPM6)', 0, 1),
(1831, 458, 'The Basel III accord', 0, 2),
(1832, 458, 'The COFOG classification', 0, 3),
(1833, 459, 'General government and public corporations', 1, 0),
(1834, 459, 'Only the central bank', 0, 1),
(1835, 459, 'Private households and firms', 0, 2),
(1836, 459, 'Foreign governments only', 0, 3),
(1837, 460, 'Treasury bonds and Treasury bills', 1, 0),
(1838, 460, 'Land and buildings', 0, 1),
(1839, 460, 'Tax revenue', 0, 2),
(1840, 460, 'Employee salaries', 0, 3),
(1841, 461, 'Published as memorandum items', 1, 0),
(1842, 461, 'Recorded as revenue', 0, 1),
(1843, 461, 'Ignored entirely', 0, 2),
(1844, 461, 'Counted as non-financial assets', 0, 3),
(1845, 462, 'On Partner States\' Ministries of Finance, Central Banks and NSOs websites, and the EAC Statistics Portal', 1, 0),
(1846, 462, 'Only in printed newspapers', 0, 1),
(1847, 462, 'On private company blogs', 0, 2),
(1848, 462, 'Only via commercial banks', 0, 3),
(1849, 463, 'One year or less', 1, 0),
(1850, 463, 'More than one year', 0, 1),
(1851, 463, 'Exactly ten years', 0, 2),
(1852, 463, 'More than thirty years', 0, 3),
(1853, 464, 'The debt of public financial and non-financial corporations', 1, 0),
(1854, 464, 'Private household mortgages', 0, 1),
(1855, 464, 'Foreign companies\' debt', 0, 2),
(1856, 464, 'Central bank policy rates', 0, 3),
(1857, 465, 'Guaranteed borrowing raises fiscal risk, so a fuller picture of exposure is needed', 1, 0),
(1858, 465, 'To make the debt total look smaller', 0, 1),
(1859, 465, 'Because it is required for the census', 0, 2),
(1860, 465, 'To set commercial interest rates', 0, 3),
(1861, 466, 'Debt owed to non-residents', 1, 0),
(1862, 466, 'Debt owed to residents', 0, 1),
(1863, 466, 'Debt with no interest', 0, 2),
(1864, 466, 'Debt of private firms only', 0, 3),
(1865, 467, 'All liabilities that are debt instruments', 1, 0),
(1866, 467, 'Only foreign-currency loans', 0, 1),
(1867, 467, 'Only short-term debt', 0, 2),
(1868, 467, 'Government buildings and land', 0, 3),
(1869, 468, 'Gross debt minus financial assets in corresponding debt instruments', 1, 0),
(1870, 468, 'Gross debt plus interest payments', 0, 1),
(1871, 468, 'Total revenue minus total expenditure', 0, 2),
(1872, 468, 'Gross debt times the interest rate', 0, 3),
(1873, 469, '(Total Public Debt ÷ GDP) × 100', 1, 0),
(1874, 469, '(GDP ÷ Total Public Debt) × 100', 0, 1),
(1875, 469, 'Total Public Debt − GDP', 0, 2),
(1876, 469, 'GDP × interest rate', 0, 3),
(1877, 470, '50 percent of GDP in net present value terms', 1, 0),
(1878, 470, '3 percent of GDP', 0, 1),
(1879, 470, '6 percent of GDP', 0, 2),
(1880, 470, '100 percent of GDP', 0, 3),
(1881, 471, 'Obligations that arise only if a particular future event occurs', 1, 0),
(1882, 471, 'Debts that must always be repaid on a fixed date', 0, 1),
(1883, 471, 'Grants that are never repaid', 0, 2),
(1884, 471, 'Government-owned land and buildings', 0, 3),
(1885, 472, 'A contractual arrangement giving rise to conditional payment requirements', 1, 0),
(1886, 472, 'A liability recognised only after the event, with no contract', 0, 1),
(1887, 472, 'A grant received from abroad', 0, 2),
(1888, 472, 'A short-term treasury bill', 0, 3),
(1889, 473, 'The debt service-to-revenue ratio', 1, 0),
(1890, 473, 'The debt-to-GDP ratio', 0, 1),
(1891, 473, 'The interest-to-GDP ratio', 0, 2),
(1892, 473, 'The debt-to-exports ratio', 0, 3),
(1893, 474, 'Is a bilateral postponement of debt service with new, extended maturities', 1, 0),
(1894, 474, 'Always cancels the entire debt', 0, 1),
(1895, 474, 'Never changes payment dates', 0, 2),
(1896, 474, 'Applies only to private firms', 0, 3),
(1901, 476, 'Its main centre of economic interest is outside the domestic economy', 1, 0),
(1902, 476, 'It is owned by foreign shareholders', 0, 1),
(1903, 476, 'Its staff are foreign nationals', 0, 2),
(1904, 476, 'It trades in foreign currency', 0, 3),
(1905, 477, 'An insurance company', 1, 0),
(1906, 477, 'A commercial bank', 0, 1),
(1907, 477, 'A deposit-taking SACCO', 0, 2),
(1908, 477, 'A Money Market Fund', 0, 3),
(1909, 478, 'Central bank liabilities — currency in circulation plus reserve deposits at the central bank', 1, 0),
(1910, 478, 'All deposits held by households in commercial banks', 0, 1),
(1911, 478, 'The government\'s tax revenue', 0, 2),
(1912, 478, 'Foreign currency held by exporters', 0, 3),
(1913, 479, 'What financial corporations own outside the economic territory minus what they owe the rest of the world', 1, 0),
(1914, 479, 'The total deposits of all households', 0, 1),
(1915, 479, 'Government securities held by the central bank only', 0, 2),
(1916, 479, 'The capital of commercial banks', 0, 3),
(1917, 480, 'Central Bank Survey + ODC Survey', 1, 0),
(1918, 480, 'ODC Survey + OFC Survey', 0, 1),
(1919, 480, 'Central Bank Survey + OFC Survey', 0, 2),
(1920, 480, 'Central Bank Survey only', 0, 3),
(1921, 481, 'M3', 1, 0),
(1922, 481, 'M1', 0, 1),
(1923, 481, 'M2', 0, 2),
(1924, 481, 'M6', 0, 3),
(1925, 482, 'OFCs do not take deposits, so their liabilities (e.g. insurance and pension obligations) are not part of broad money', 1, 0),
(1926, 482, 'OFCs are not regulated', 0, 1),
(1927, 482, 'OFCs only deal with non-residents', 0, 2),
(1928, 482, 'OFCs hold no assets', 0, 3),
(1929, 483, 'Depository Corporations Survey + OFC Survey', 1, 0),
(1930, 483, 'Central Bank Survey + ODC Survey', 0, 1),
(1931, 483, 'ODC Survey + OFC Survey', 0, 2),
(1932, 483, 'Central Bank Survey only', 0, 3),
(1933, 484, 'Reported as two separate line items', 1, 0),
(1934, 484, 'Merged into a single figure', 0, 1),
(1935, 484, 'Left out of the survey', 0, 2),
(1936, 484, 'Added to net foreign assets', 0, 3),
(1937, 485, 'The monetary policy direction of the central bank', 1, 0),
(1938, 485, 'The exchange rate against the US dollar', 0, 1),
(1939, 485, 'The price of treasury bills only', 0, 2),
(1940, 485, 'The profit of commercial banks', 0, 3),
(1941, 486, 'The industry or economic activity the borrower operates in', 1, 0),
(1942, 486, 'The size of the loan only', 0, 1),
(1943, 486, 'The currency of the loan', 0, 2),
(1944, 486, 'The age of the borrower', 0, 3),
(1957, 475, 'Who has money, who owes money, and how money flows through the economy', 1, 0),
(1958, 475, 'Only the government\'s annual budget', 0, 1),
(1959, 475, 'The retail prices of goods in shops', 0, 2),
(1960, 475, 'Company profit forecasts', 0, 3),
(1965, 488, 'To show who has money, who owes money, and how money flows through the economy', 1, 0),
(1966, 488, 'To measure international trade in goods only', 0, 1),
(1967, 488, 'To measure agricultural production and food supply', 0, 2),
(1968, 488, 'To record only government tax collections', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `assessment_questions`
--

CREATE TABLE `assessment_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `courseId` int(10) UNSIGNED NOT NULL,
  `questionType` enum('module_quiz','final') NOT NULL,
  `moduleId` varchar(100) DEFAULT NULL,
  `quizKey` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `questionText` text NOT NULL,
  `explanation` text DEFAULT NULL,
  `sortOrder` int(11) NOT NULL DEFAULT 0,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_questions`
--

INSERT INTO `assessment_questions` (`id`, `courseId`, `questionType`, `moduleId`, `quizKey`, `title`, `questionText`, `explanation`, `sortOrder`, `isActive`, `createdAt`, `updatedAt`) VALUES
(1, 1, 'final', 'm4', NULL, 'Final Assessment', 'Which pillar of food security primarily addresses the vulnerability of food systems to shocks such as price spikes and droughts?', 'Correct: Stability.', 0, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(2, 1, 'final', 'm4', NULL, 'Final Assessment', 'A high Food Price Volatility Index indicates:', 'Correct: Large fluctuations that reduce household purchasing power.', 1, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(3, 1, 'final', 'm4', NULL, 'Final Assessment', 'According to WHO classification, childhood anaemia prevalence ≥40% is considered:', 'Correct: Severe public health problem.', 2, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(4, 1, 'final', 'm4', NULL, 'Final Assessment', 'Which EAC countries currently have SEVERE childhood anaemia prevalence (≥40%)?', 'Correct: DRC, South Sudan, Tanzania, Uganda.', 3, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(5, 1, 'final', 'm4', NULL, 'Final Assessment', 'The most common cause of anaemia globally (approximately 50% of cases) is:', 'Correct: Iron deficiency.', 4, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(6, 1, 'final', 'm4', NULL, 'Final Assessment', 'Vitamin A supplementation for children 6–59 months in high-risk areas should be given:', 'Correct: Every 4–6 months.', 5, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(7, 1, 'final', 'm4', NULL, 'Final Assessment', 'Stunting primarily reflects:', 'Correct: Chronic or long-term undernutrition.', 6, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(8, 1, 'final', 'm4', NULL, 'Final Assessment', 'Which country in the EAC has the highest prevalence of stunting (52–56%)?', 'Correct: Burundi.', 7, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(9, 1, 'final', 'm4', NULL, 'Final Assessment', 'Global Acute Malnutrition (GAM) ≥15% indicates:', 'Correct: Critical emergency.', 8, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(10, 1, 'final', 'm4', NULL, 'Final Assessment', 'The “triple burden of malnutrition” in the EAC region includes all except:', 'Correct: Excessive physical activity.', 9, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(11, 1, 'final', 'm4', NULL, 'Final Assessment', 'Low birth weight is defined as birth weight less than:', 'Correct: 2,500 g.', 10, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(12, 1, 'final', 'm4', NULL, 'Final Assessment', 'The recommended software for analysing anthropometric data in children under 5 is:', 'Correct: WHO Anthro and/or ENA for SMART.', 11, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(13, 1, 'final', 'm4', NULL, 'Final Assessment', 'When stunting prevalence exceeds 40%, the appropriate response level is:', 'Correct: National emergency priority with multi-sectoral action.', 12, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(14, 1, 'final', 'm4', NULL, 'Final Assessment', 'The first 1,000 days (from conception to 2 years) is the critical window for preventing:', 'Correct: Irreversible stunting.', 13, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(15, 1, 'final', 'm4', NULL, 'Final Assessment', 'Which intervention is proven to reduce vitamin A deficiency and child mortality by up to 23%?', 'Correct: High-dose vitamin A supplementation every 6 months.', 14, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(16, 1, 'final', 'm4', NULL, 'Final Assessment', 'The WHO global target for anaemia in women of reproductive age by 2030 is a ___ reduction from 2019 levels.', 'Correct: 50%.', 15, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(17, 1, 'final', 'm4', NULL, 'Final Assessment', 'Which of the following is NOT a recommended quality assurance measure in nutrition surveys?', 'Correct: Skipping plausibility checks to save time.', 16, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(18, 1, 'final', 'm4', NULL, 'Final Assessment', 'Prevalence of wasting reflects:', 'Correct: Recent acute malnutrition.', 17, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(19, 1, 'final', 'm4', NULL, 'Final Assessment', 'The “hidden hunger” phenomenon in the EAC is primarily driven by:', 'Correct: Deficiencies of vitamins and minerals despite adequate energy intake.', 18, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(20, 1, 'final', 'm4', NULL, 'Final Assessment', 'Which is the most cost-effective intervention for preventing vitamin A deficiency in the EAC context?', 'Correct: All of the above are highly cost-effective.', 19, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(21, 1, 'final', 'm4', NULL, 'Final Assessment', 'In programmatic response matrices, when childhood anaemia is classified as “Severe”, the response should include:', 'Correct: Blanket iron-folic acid supplementation + fortification + malaria control.', 20, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(22, 1, 'final', 'm4', NULL, 'Final Assessment', 'Adolescent overweight in the EAC is an emerging component of:', 'Correct: The triple burden of malnutrition.', 21, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(23, 1, 'final', 'm4', NULL, 'Final Assessment', 'The preferred timing for nutrition surveys in most EAC countries to capture the hunger season is:', 'Correct: During or just before the lean/hunger season (often Feb–May).', 22, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(24, 1, 'final', 'm4', NULL, 'Final Assessment', 'Which indicator is most sensitive to recent shocks and is used in emergency contexts?', 'Correct: Wasting (Weight-for-Height).', 23, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(25, 1, 'final', 'm4', NULL, 'Final Assessment', 'Successful scale-up of anticipatory action and nutrition-sensitive programming in the EAC requires strong:', 'Correct: Regional frameworks and coordination (e.g., SADC, EAC strategies).', 24, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(26, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 1: Stunting is defined as:', 'Correct: Height-for-age < -2 SD.', 25, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(27, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 2: What is the critical intervention window for preventing stunting?', 'Correct: Pregnancy to 24 months (the first 1,000 days).', 26, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(28, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 3: A wasting prevalence of 12% in children under 5 indicates a:', 'Correct: Serious situation requiring humanitarian response.', 27, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(29, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 4: Which indicator reflects ACUTE malnutrition?', 'Correct: Wasting.', 28, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(30, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 5: What is the mortality risk multiplier for children with severe wasting?', 'Correct: 9 times higher.', 29, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(31, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 6: Which assessment type should be conducted annually or in emergencies to measure wasting?', 'Correct: SMART Survey.', 30, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(32, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 7: When should lean season nutritional assessments typically be conducted?', 'Correct: February-April (pre-harvest).', 31, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(33, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 8: What is the recommended frequency for equipment calibration during nutrition surveys?', 'Correct: Daily.', 32, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(34, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 9: When wasting prevalence ≥ 15%, what response is required?', 'Correct: Critical emergency humanitarian response (mass screening, CMAM scale-up, blanket feeding).', 33, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(35, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 10: How often should impact indicators (like stunting prevalence) be measured?', 'Correct: Every 2-5 years (major surveys).', 34, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(36, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 1: Which EAC country has the highest stunting prevalence?', 'Correct: Burundi (52-56%).', 35, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(37, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 2: A Coefficient of Variation (CV) greater than 30% for food prices indicates:', 'Correct: High volatility - significant market dysfunction.', 36, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(38, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 3: Four EAC countries have severe public health problems with childhood anemia. Which countries are they?', 'Correct: DRC, South Sudan, Tanzania, Uganda.', 37, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(39, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 4: What is the hemoglobin cutoff for anemia in children aged 6-59 months?', 'Correct: < 11.0 g/dL.', 38, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(40, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 5: The WHO global target for low birth weight is:', 'Correct: 30% reduction by 2025.', 39, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(41, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 6: Vitamin A supplementation for children 6-59 months should be provided:', 'Correct: Every 6 months.', 40, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(42, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 7: The custodian agency for the Food Price Index is:', 'Correct: FAO.', 41, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(43, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 8: Ready-to-Use Therapeutic Foods (RUTF) are used to treat:', 'Correct: Severe acute malnutrition without medical complications.', 42, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(44, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 9: SMART surveys typically take how long to complete?', 'Correct: 2-3 weeks.', 43, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(45, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 10: Which of the following is a cause of INTRAUTERINE growth restriction leading to low birth weight?', 'Correct: Maternal anemia and undernutrition.', 44, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(46, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 11: The \"double burden of malnutrition\" in the EAC refers to:', 'Correct: Undernutrition and overweight/obesity coexisting in the same population.', 45, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(47, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 12: What percentage of duplicate measurements is recommended during anthropometric surveys?', 'Correct: 5-10%.', 46, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(48, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 13: When stunting prevalence is > 40%, what level of response is required?', 'Correct: National emergency priority with multi-sectoral approach.', 47, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(49, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 14: Which software is recommended for analyzing anthropometric data for children under 5?', 'Correct: WHO Anthro and/or ENA for SMART.', 48, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(50, 1, 'final', 'm4', NULL, 'Final Assessment', 'Question 15: The primary cause of anemia worldwide is:', 'Correct: Iron deficiency (accounts for ~50% of cases).', 49, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(51, 1, 'final', 'm5', NULL, 'Final Assessment', 'What was the primary problem with regional FNS reporting before the EAC Framework was implemented?', 'Correct: Incompatible methodologies and indicators preventing valid regional aggregation.', 50, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(52, 1, 'final', 'm5', NULL, 'Final Assessment', 'The five-tier institutional architecture includes all of the following EXCEPT:', 'Correct: Provincial Coordination Level.', 51, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(53, 1, 'final', 'm5', NULL, 'Final Assessment', 'What is the primary function of the National Steering Committee?', 'Correct: Approve workplans, validate reports, provide policy guidance, and mobilize resources.', 52, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(54, 1, 'final', 'm5', NULL, 'Final Assessment', 'According to the Framework, how many staff should the EAC Regional FNS Monitoring Desk have?', 'Correct: 4 dedicated staff (coordinator, statistics/M&E officer, data analyst/GIS specialist, admin support).', 53, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(55, 1, 'final', 'm5', NULL, 'Final Assessment', 'Harmonization of FNS monitoring occurs across three dimensions. Which of the following is NOT one of these dimensions?', 'Correct: WHERE to measure (geographic targeting).', 54, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(56, 1, 'final', 'm5', NULL, 'Final Assessment', 'For measuring stunting (Indicator 17), which reference standard must ALL Partner States use?', 'Correct: WHO Child Growth Standards 2006.', 55, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(57, 1, 'final', 'm5', NULL, 'Final Assessment', 'What is the standardized main assessment window for conducting DHS and National Nutrition Surveys across the EAC?', 'Correct: July-September (post-harvest).', 56, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(58, 1, 'final', 'm5', NULL, 'Final Assessment', 'What is the deadline for Partner States to submit their annual FNS data to the EAC Secretariat?', 'Correct: March 31 of the following year.', 57, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(59, 1, 'final', 'm5', NULL, 'Final Assessment', 'Before an anthropometric survey, enumerators must pass a standardization test. What is the WHO criterion for height measurement precision?', 'Correct: Technical Error of Measurement (TEM) < 7mm.', 58, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(60, 1, 'final', 'm5', NULL, 'Final Assessment', 'What happens if a country\'s survey data does not meet the minimum \"GOOD\" data quality score?', 'Correct: Investigation triggered and data potentially excluded from regional reporting until issues resolved.', 59, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(61, 2, 'final', NULL, NULL, 'Final Assessment', 'Financial Soundness Indicators (FSIs) help show:', 'FSIs are numbers or measures that help show how healthy, stable and strong a country\'s financial system is.', 0, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(62, 2, 'final', NULL, NULL, 'Final Assessment', 'The EAC computes FSIs for how many sectors?', 'Five sectors: Deposit Takers, Other Financial Corporations, Households, Non-Financial Corporations and Real Estate Markets.', 1, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(63, 2, 'final', NULL, NULL, 'Final Assessment', 'Deposit Takers are best defined as:', 'DTs are financial institutions, such as banks, that accept deposits from the public and use those funds to provide loans and other financial services.', 2, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(64, 2, 'final', NULL, NULL, 'Final Assessment', 'The FSIs for Deposit Takers are largely prepared in line with:', 'DT FSIs follow the Basel Standards issued by the Basel Committee on Banking Supervision, covering capital, liquidity and leverage.', 3, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(65, 2, 'final', NULL, NULL, 'Final Assessment', 'Common Equity Tier 1 (CET1) is best described as:', 'CET1 is the highest-quality, most permanent capital (mainly ordinary shares and retained earnings).', 4, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(66, 2, 'final', NULL, NULL, 'Final Assessment', 'The EAC minimum regulatory CET1 ratio is:', 'The EAC minimum CET1 ratio is 8.5 percent.', 5, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(67, 2, 'final', NULL, NULL, 'Final Assessment', 'The EAC minimum Tier 1 and total regulatory capital ratios are, respectively:', 'The EAC minimum Tier 1 ratio is 10 percent and the total regulatory capital ratio is 12 percent.', 6, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(68, 2, 'final', NULL, NULL, 'Final Assessment', 'The leverage ratio serves mainly as:', 'The leverage ratio is a safeguard against rapid asset growth without corresponding capital injection.', 7, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(69, 2, 'final', NULL, NULL, 'Final Assessment', 'A loan becomes nonperforming (an NPL) when unpaid for:', 'An NPL is a loan that has not been repaid for 90 days.', 8, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(70, 2, 'final', NULL, NULL, 'Final Assessment', 'Provisions to NPLs shows:', 'It shows the extent to which a DT has set aside funds (provisions) to cover potential losses from its NPLs.', 9, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(71, 2, 'final', NULL, NULL, 'Final Assessment', 'Loan concentration by economic activity highlights the risk of:', 'It measures how loans are spread across sectors and the risk of lending predominantly to a few sectors.', 10, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(72, 2, 'final', NULL, NULL, 'Final Assessment', 'Return on Assets (ROA) measures:', 'ROA is the profit or income earned from the assets owned or controlled and investments made by the DT.', 11, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(73, 2, 'final', NULL, NULL, 'Final Assessment', 'Return on Equity (ROE) measures:', 'ROE is the profit or income earned from the DT\'s own funds (capital).', 12, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(74, 2, 'final', NULL, NULL, 'Final Assessment', 'Other than easily tradeable securities, liquid assets should have a maturity of:', 'Liquid assets should have a maturity of 3 months or less, except for easily tradeable securities.', 13, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(75, 2, 'final', NULL, NULL, 'Final Assessment', 'Liquid Assets to Total Assets indicates:', 'It indicates how much of a bank\'s assets can be quickly used to cover its cash needs, such as customers\' deposit withdrawals.', 14, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(76, 2, 'final', NULL, NULL, 'Final Assessment', 'The Liquidity Coverage Ratio (LCR) covers an urgent cash demand over:', 'The LCR measures the ability to meet an urgent demand for cash in a 30-day period; the EAC minimum is 100 percent.', 15, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(77, 2, 'final', NULL, NULL, 'Final Assessment', 'The Net Stable Funding Ratio (NSFR) covers a demand for cash over:', 'The NSFR measures the ability to meet a demand for cash over a one-year period; the EAC minimum is 100 percent.', 16, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(78, 2, 'final', NULL, NULL, 'Final Assessment', 'The net open position in foreign exchange to capital indicates vulnerability to:', 'It indicates how much a DT could be affected by changes in the value of foreign currency.', 17, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(79, 2, 'final', NULL, NULL, 'Final Assessment', 'How many additional FSIs are there for Deposit Takers?', 'There are 12 additional FSIs for DTs (the EAC-specific set has 13).', 18, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(80, 2, 'final', NULL, NULL, 'Final Assessment', 'Digital loans to gross loans captures the risk that:', 'It indicates vulnerability from online lending, where loans are approved quickly with limited information, reducing the chance of repayment.', 19, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(81, 2, 'final', NULL, NULL, 'Final Assessment', 'A wide spread between the highest and lowest interbank loan rates may indicate:', 'A wide gap may show stress or a lack of trust in the banking system.', 20, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(82, 2, 'final', NULL, NULL, 'Final Assessment', 'Life Insurance Companies (LICs) offer:', 'LICs offer long-term services such as life cover and pensions, where obligations stretch into the future.', 21, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(83, 2, 'final', NULL, NULL, 'Final Assessment', 'Non-Life (General) Insurance Companies (NLICs) typically settle claims:', 'NLICs offer short-term cover (health, motor, property) where claims are usually settled within a year.', 22, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(84, 2, 'final', NULL, NULL, 'Final Assessment', 'NLICs are encouraged to keep the combined ratio:', 'A combined ratio below 100 percent indicates the NLIC is profitable in its core business.', 23, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(85, 2, 'final', NULL, NULL, 'Final Assessment', 'Shareholders\' equity to invested assets acts as:', 'It safeguards against excessive asset growth without a corresponding capital injection and shows the ability to absorb losses.', 24, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(86, 2, 'final', NULL, NULL, 'Final Assessment', 'The retention ratio measures:', 'It shows how much risk an IC keeps for itself versus passing on to reinsurance.', 25, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(87, 2, 'final', NULL, NULL, 'Final Assessment', 'The penetration ratio indicates:', 'It measures the level of insurance coverage in an economy; generally, a higher ratio means a more developed sector.', 26, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(88, 2, 'final', NULL, NULL, 'Final Assessment', 'Net claims to net premiums compares:', 'It measures the proportion of claims paid relative to premiums received; a lower ratio indicates the IC receives enough to cover claims.', 27, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(89, 2, 'final', NULL, NULL, 'Final Assessment', 'ICs assets to GDP shows:', 'It shows the size of ICs relative to the economy; a higher ratio shows an increasing share and uptake of insurance products.', 28, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(90, 2, 'final', NULL, NULL, 'Final Assessment', 'Pension Funds (PFs) collect contributions and:', 'PFs collect contributions from workers and employers, invest the money, and pay it out with interest after retirement.', 29, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(91, 2, 'final', NULL, NULL, 'Final Assessment', 'The pension-fund liquidity ratio covers obligations over:', 'It checks whether a PF has enough accessible funds to cover short-term (12-month) obligations — members\' benefits.', 30, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(92, 2, 'final', NULL, NULL, 'Final Assessment', 'The funding ratio indicates whether a PF\'s available assets are enough to:', 'The funding ratio shows whether available assets are enough to cover future benefit payments.', 31, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(93, 2, 'final', NULL, NULL, 'Final Assessment', 'A high dependency ratio implies:', 'It compares retirees receiving benefits with active contributors; a high ratio means too few active members to support retirees.', 32, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(94, 2, 'final', NULL, NULL, 'Final Assessment', 'For the pension-fund efficiency ratio, a lower value means:', 'Lower = minimal operational cost — the PF spends little to generate income.', 33, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(95, 2, 'final', NULL, NULL, 'Final Assessment', 'A Money Market Fund invests in income-generating assets owned for:', 'MMFs invest in short-term assets owned for one year or less, such as Treasury bills.', 34, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(96, 2, 'final', NULL, NULL, 'Final Assessment', 'Sectoral distribution of MMFs\' investments highlights the risk of:', 'Concentration in a few sectors can cause significant losses if those sectors underperform; spreading across sectors reduces potential losses.', 35, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(97, 2, 'final', NULL, NULL, 'Final Assessment', 'A higher \'investment in real estate to total assets\' for a PF means:', 'A higher ratio shows the PF is highly vulnerable to changes in the value of the real estate market.', 36, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(98, 2, 'final', NULL, NULL, 'Final Assessment', 'The Residential Property Price Index (RPPI) measures price changes for:', 'The RPPI measures the change in prices of apartments and houses purchased by households for their own use.', 37, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(99, 2, 'final', NULL, NULL, 'Final Assessment', 'Why does a sharp fall in property prices matter for Deposit Takers?', 'A sharp drop in property prices may shrink collateral value, creating a loan exposure for DTs.', 38, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(100, 2, 'final', NULL, NULL, 'Final Assessment', 'For NFCs, Return on Equity (ROE) is:', 'For NFCs, ROE is the profit earned from their own funds.', 39, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(101, 2, 'final', NULL, NULL, 'Final Assessment', 'Debt-service coverage shows whether NFCs can:', 'It measures NFCs\' ability to repay their loans using their income; a lower ratio implies they can\'t fully repay liabilities from own income.', 40, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(102, 2, 'final', NULL, NULL, 'Final Assessment', 'The interest coverage ratio measures an NFC\'s ability to:', 'It is the ability to repay the interest on funds borrowed using their income.', 41, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(103, 2, 'final', NULL, NULL, 'Final Assessment', 'For FSI purposes, a household is:', 'A household can be one person or a group, such as a family, sharing money and expenses.', 42, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(104, 2, 'final', NULL, NULL, 'Final Assessment', 'A higher household debt-to-income ratio implies:', 'A higher ratio signals household indebtedness — borrowing is large relative to income.', 43, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(105, 2, 'final', NULL, NULL, 'Final Assessment', 'A high total-debt-to-equity ratio for NFCs means:', 'A high ratio means NFCs are heavily indebted, which raises vulnerability to an increase in lending rates.', 44, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(106, 2, 'final', NULL, NULL, 'Final Assessment', 'The Commercial Property Price Index (CPPI) covers:', 'The CPPI measures the change in prices of commercial properties (offices, shops, rental apartments, factories and warehouses).', 45, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(107, 3, 'final', NULL, NULL, 'Final Assessment', 'Which statement best defines Government Finance Statistics (GFS)?', 'GFS is a standardized system that tracks how governments earn, spend, borrow and manage resources — a financial health check for government.', 0, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(108, 3, 'final', NULL, NULL, 'Final Assessment', 'What is the EAC fiscal-deficit (including grants) goal referenced for GFS monitoring?', 'The EAMU convergence ceiling for the fiscal deficit including grants is 3% of GDP (excluding grants it is 6%).', 1, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(109, 3, 'final', NULL, NULL, 'Final Assessment', 'Which manual is used to compile GFS, and what is its latest version?', 'GFS is compiled using the IMF\'s Government Finance Statistics Manual (GFSM); the latest version is GFSM 2014.', 2, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(110, 3, 'final', NULL, NULL, 'Final Assessment', 'GFSM 2014 is aligned with which other international framework?', 'GFSM 2014 is aligned with other macroeconomic frameworks such as the System of National Accounts (SNA).', 3, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(111, 3, 'final', NULL, NULL, 'Final Assessment', 'Cash accounting records:', 'Cash accounting records actual cash received or paid — similar to household budgeting.', 4, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(112, 3, 'final', NULL, NULL, 'Final Assessment', 'Because most EAC Partner States are transitioning from cash to accrual, transactions are recorded on a:', 'GFSM 2014 recommends accrual, but EAC states in transition record on a modified cash basis.', 5, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(113, 3, 'final', NULL, NULL, 'Final Assessment', 'In the GFSM 2014 framework, the closing balance sheet equals:', 'Opening stocks plus the flows during the period (transactions and other economic flows) give the closing stocks.', 6, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(114, 3, 'final', NULL, NULL, 'Final Assessment', 'Which items are recorded as revenue in GFS?', 'Revenue comprises taxes, social contributions, grants and other revenue.', 7, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(115, 3, 'final', NULL, NULL, 'Final Assessment', 'Compensation of employees, use of goods and services, interest and subsidies are examples of:', 'These are components of expense.', 8, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(116, 3, 'final', NULL, NULL, 'Final Assessment', 'Fixed assets, inventories, valuables and non-produced assets are recorded under:', 'These fall under the net investment in non-financial assets (e.g. infrastructure, machinery).', 9, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(117, 3, 'final', NULL, NULL, 'Final Assessment', 'Net lending/net borrowing (the fiscal balance) is:', 'Net lending/net borrowing is total revenue minus total expenditure.', 10, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(118, 3, 'final', NULL, NULL, 'Final Assessment', 'The fiscal balance is financed by:', 'Financing comes from transactions in financial assets and the net incurrence of liabilities.', 11, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(119, 3, 'final', NULL, NULL, 'Final Assessment', 'A government runs a fiscal surplus when:', 'A surplus arises when revenue exceeds expenditure; a deficit when expenditure exceeds revenue.', 12, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(120, 3, 'final', NULL, NULL, 'Final Assessment', 'The public sector covered by GFS consists of:', 'The public sector is general government plus public corporations.', 13, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(121, 3, 'final', NULL, NULL, 'Final Assessment', 'Which of the following belongs to general government?', 'General government covers central, state/provincial and local governments; the central bank and public corporations are not general government.', 14, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(122, 3, 'final', NULL, NULL, 'Final Assessment', 'The central bank is classified within:', 'The central bank is a public financial corporation within public corporations.', 15, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(123, 3, 'final', NULL, NULL, 'Final Assessment', 'Which is a source of GFS data?', 'GFS sources include statements from national revenue authorities, treasury and accounting systems, budget execution reports, central bank data, and public entities\' financial statements.', 16, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(124, 3, 'final', NULL, NULL, 'Final Assessment', 'The functional classification (COFOG) classifies spending by:', 'COFOG classifies by purpose; the economic classification classifies by the nature of the transaction.', 17, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(125, 3, 'final', NULL, NULL, 'Final Assessment', 'The economic classification of expense classifies expenditure by:', 'The economic classification is based on the economic nature of the transaction.', 18, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(126, 3, 'final', NULL, NULL, 'Final Assessment', 'What is the primary objective of GFS?', 'GFS provides reliable, consistent information on government operations for decision-making, policy analysis and economic monitoring.', 19, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(127, 3, 'final', NULL, NULL, 'Final Assessment', 'Which indicators are commonly used in GFS international comparisons?', 'International comparisons use revenue as a % of GDP, tax revenue as a % of GDP, and public investment as a % of GDP.', 20, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(128, 3, 'final', NULL, NULL, 'Final Assessment', 'The EAMU convergence ceiling for the fiscal deficit including grants is:', 'Including grants the ceiling is 3% of GDP.', 21, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(129, 3, 'final', NULL, NULL, 'Final Assessment', 'The EAMU convergence ceiling for the fiscal deficit excluding grants is:', 'Excluding grants the ceiling is 6% of GDP.', 22, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(130, 3, 'final', NULL, NULL, 'Final Assessment', 'The EAMU ceiling for gross public debt is:', 'Gross public debt is capped at 50% of GDP in net present value terms.', 23, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(131, 3, 'final', NULL, NULL, 'Final Assessment', 'The net worth of a government is:', 'Net worth is total assets minus total liabilities.', 24, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(132, 3, 'final', NULL, NULL, 'Final Assessment', 'Infrastructure, buildings, equipment and land are examples of:', 'Non-financial assets are economic assets other than financial assets — tangible and intangible, such as infrastructure, buildings, equipment and land.', 25, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(133, 3, 'final', NULL, NULL, 'Final Assessment', 'In GFS, debt forgiveness is recorded as:', 'Debt forgiveness is recorded as a capital grant (revenue).', 26, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(134, 3, 'final', NULL, NULL, 'Final Assessment', 'Debt rescheduling is reflected in GFS as:', 'Debt rescheduling is reflected as changes in liabilities and interest payments.', 27, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(135, 3, 'final', NULL, NULL, 'Final Assessment', 'A debt-for-equity swap is treated as:', 'A debt-for-equity swap is a financial transaction affecting both assets and liabilities.', 28, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(136, 3, 'final', NULL, NULL, 'Final Assessment', 'Corporate income tax and royalties from extraction companies are classified as:', 'Taxes on extraction companies include corporate income tax and royalties.', 29, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(137, 3, 'final', NULL, NULL, 'Final Assessment', 'One-off revenues from the sale of natural resource assets are classified as:', 'Asset sales are one-off revenues from the sale of natural resource assets.', 30, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(138, 3, 'final', NULL, NULL, 'Final Assessment', 'Why are governments encouraged to distinguish recurrent revenues from one-off revenues?', 'Separating recurrent (taxes, royalties) from one-off (asset sales) revenues helps ensure fiscal sustainability.', 31, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(139, 3, 'final', NULL, NULL, 'Final Assessment', 'GFS supports the EAC by promoting:', 'GFS supports fiscal transparency, debt sustainability and regional convergence.', 32, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(140, 3, 'final', NULL, NULL, 'Final Assessment', 'Which of these is one of the questions GFS helps answer?', 'GFS helps assess whether tax revenues are used effectively, public debts are sustainable, and public services are adequately funded.', 33, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(141, 3, 'final', NULL, NULL, 'Final Assessment', 'Revenue less expense, before subtracting investment in non-financial assets, gives the:', 'Revenue minus expense is the net operating balance; subtracting net investment in non-financial assets then gives net lending/borrowing.', 34, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(142, 3, 'final', NULL, NULL, 'Final Assessment', 'Issuing debt securities to cover a deficit is recorded under:', 'Financing the balance runs through transactions in financial assets and the net incurrence of liabilities, such as issuing debt securities.', 35, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(143, 3, 'final', NULL, NULL, 'Final Assessment', 'Social security funds are part of:', 'Social security funds sit within general government (and may be shown as a separate subsector).', 36, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(144, 3, 'final', NULL, NULL, 'Final Assessment', 'Treasury and accounting systems are an example of a:', 'Treasury and accounting systems are one of the administrative sources GFS is compiled from.', 37, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(145, 3, 'final', NULL, NULL, 'Final Assessment', 'Public investment as a percent of GDP expresses:', 'It relates public investment (in non-financial assets) to the size of the economy for comparison.', 38, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(146, 3, 'final', NULL, NULL, 'Final Assessment', 'A debt-for-equity swap affects:', 'A debt-for-equity swap is a financial transaction affecting both assets and liabilities.', 39, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(147, 4, 'final', NULL, NULL, 'Final Assessment', 'What is Public Sector Debt Statistics (PSDS)?', 'PSDS is a framework for measuring and reporting public debt data; it records total gross public debt.', 0, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(148, 4, 'final', NULL, NULL, 'Final Assessment', 'A debt instrument is:', 'A debt instrument is a financial claim requiring payment(s) of interest and/or principal at a future date or dates.', 1, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(149, 4, 'final', NULL, NULL, 'Final Assessment', 'Total gross public debt consists of:', 'Gross public debt is all government liabilities that are debt instruments.', 2, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(150, 4, 'final', NULL, NULL, 'Final Assessment', 'PSDS statistics are used for:', 'PSDS supports analysis of fiscal sustainability and measurement of the government\'s risk exposure.', 3, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(151, 4, 'final', NULL, NULL, 'Final Assessment', 'Which standard guides the compilation of PSDS?', 'Compilation is guided by the PSDSG 2013 for consistency and comparability between countries.', 4, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(152, 4, 'final', NULL, NULL, 'Final Assessment', 'Which institutional units are included in PSDS compilation?', 'PSDS includes debt from general government (central, state, local) and public corporations (nonfinancial and financial).', 5, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(153, 4, 'final', NULL, NULL, 'Final Assessment', 'Central government in PSDS comprises:', 'Central government covers budgetary central government and extra-budgetary units.', 6, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(154, 4, 'final', NULL, NULL, 'Final Assessment', 'Under debt securities, PSDS records:', 'Debt securities comprise treasury bonds and treasury bills.', 7, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(155, 4, 'final', NULL, NULL, 'Final Assessment', 'Special Drawing Rights (SDRs) in PSDS refer to:', 'SDRs are IMF allocations to countries, recorded as a debt instrument.', 8, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(156, 4, 'final', NULL, NULL, 'Final Assessment', 'How are government guarantees treated in PSDS?', 'Government guarantees are published as memorandum items.', 9, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(157, 4, 'final', NULL, NULL, 'Final Assessment', 'Where is PSDS data found?', 'Data is found on the Partner States\' Ministries of Finance, Central Banks and NSOs websites, and on the EAC Statistics Portal.', 10, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(158, 4, 'final', NULL, NULL, 'Final Assessment', 'By residence of holder, domestic debt is:', 'Domestic debt is held by resident units; external debt is held by non-resident units.', 11, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(159, 4, 'final', NULL, NULL, 'Final Assessment', 'Under classification by maturity, long-term debt has a maturity of:', 'Long-term debt matures in more than one year; short-term in one year or less.', 12, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(160, 4, 'final', NULL, NULL, 'Final Assessment', 'By instrument type, marketable securities include:', 'Marketable securities are bonds and treasury bills; non-marketable debt includes loans and arrears.', 13, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(161, 4, 'final', NULL, NULL, 'Final Assessment', 'General Government Debt (GGD) is the debt of:', 'GGD is the debt of central, state and local governments.', 14, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(162, 4, 'final', NULL, NULL, 'Final Assessment', 'Public Sector Debt (PSD) equals:', 'PSD = GGD plus the debt of public financial and non-financial corporations.', 15, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(163, 4, 'final', NULL, NULL, 'Final Assessment', 'Why is the debt of public corporations included in PSDS?', 'Public corporations can borrow heavily under guarantees; including their debt shows the government\'s full fiscal exposure.', 16, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(164, 4, 'final', NULL, NULL, 'Final Assessment', 'External debt is debt owed to:', 'External debt is owed to non-residents; domestic debt is owed to residents.', 17, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(165, 4, 'final', NULL, NULL, 'Final Assessment', 'Gross debt consists of:', 'Gross debt is the total of all liabilities that are debt instruments.', 18, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(166, 4, 'final', NULL, NULL, 'Final Assessment', 'Net debt is calculated as:', 'Net debt is gross debt minus financial assets corresponding to debt instruments.', 19, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(167, 4, 'final', NULL, NULL, 'Final Assessment', 'The debt-to-GDP ratio is calculated as:', 'Debt-to-GDP = (Total Public Debt ÷ GDP) × 100.', 20, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(168, 4, 'final', NULL, NULL, 'Final Assessment', 'In terms of the debt-to-GDP ratio, a lower ratio is generally:', 'A lower debt-to-GDP ratio is generally considered more sustainable.', 21, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(169, 4, 'final', NULL, NULL, 'Final Assessment', 'The EAMU convergence ceiling for public debt is:', 'The EAMU ceiling is public debt in NPV of 50 percent of GDP.', 22, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(170, 4, 'final', NULL, NULL, 'Final Assessment', 'Contingent liabilities are:', 'Contingent liabilities arise only if a particular, discrete future event occurs — e.g. guarantees, lawsuits or PPP commitments.', 23, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(171, 4, 'final', NULL, NULL, 'Final Assessment', 'Why do contingent liabilities matter?', 'They matter because they can affect fiscal sustainability even when not recorded as direct liabilities.', 24, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(172, 4, 'final', NULL, NULL, 'Final Assessment', 'An explicit contingent liability is:', 'Explicit contingent liabilities are contractual; implicit ones arise without a legal or contractual source and are recognised after the event.', 25, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(173, 4, 'final', NULL, NULL, 'Final Assessment', 'Which indicator assesses the share of government revenue used for debt repayment?', 'The debt service-to-revenue ratio shows how much revenue goes to debt repayment.', 26, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(174, 4, 'final', NULL, NULL, 'Final Assessment', 'Which indicator shows the pressure of debt service on export income?', 'The debt service-to-exports ratio shows the pressure of debt service on export income.', 27, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(175, 4, 'final', NULL, NULL, 'Final Assessment', 'Debt rescheduling is:', 'Rescheduling is a bilateral postponement of debt service with extended maturities.', 28, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(176, 4, 'final', NULL, NULL, 'Final Assessment', 'Debt restructuring:', 'Restructuring alters the original terms of the debt and may involve third parties and partial forgiveness.', 29, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(177, 5, 'final', NULL, NULL, 'Final Assessment', 'In plain terms, what does Monetary &amp; Financial Statistics show?', 'MFS shows who has money, who owes money, and how money flows through the economy.', 0, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(178, 5, 'final', NULL, NULL, 'Final Assessment', 'How many broad institutional sectors are there in MFS?', 'There are five: households, financial corporations, non-financial corporations, general government and NPISH.', 1, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(179, 5, 'final', NULL, NULL, 'Final Assessment', 'What does NPISH stand for?', 'NPISH = Non-profit Institutions Serving Households (e.g. churches, mission hospitals, NGOs).', 2, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(180, 5, 'final', NULL, NULL, 'Final Assessment', 'An institutional unit is one that:', 'An institutional unit has its own balance sheet and can take on debts/liabilities and enter contracts on its own behalf.', 3, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(181, 5, 'final', NULL, NULL, 'Final Assessment', 'Which institution is a Depository Corporation (DC)?', 'Commercial banks take deposits, so they are DCs. Insurance, forex bureaus and pension funds are OFCs.', 4, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(182, 5, 'final', NULL, NULL, 'Final Assessment', 'Which institution is an Other Financial Corporation (OFC)?', 'Pension funds do not take deposits, so they are OFCs. The others are deposit-takers (DCs).', 5, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(183, 5, 'final', NULL, NULL, 'Final Assessment', 'A non-resident is best defined as a unit whose:', 'Residency follows the centre of economic interest, not nationality, ownership or currency.', 6, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(184, 5, 'final', NULL, NULL, 'Final Assessment', 'Public non-financial corporations are distinguished from general government because they:', 'Public non-financial corporations earn their own income (charging market prices); entities dependent on budget allocation are general government.', 7, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(185, 5, 'final', NULL, NULL, 'Final Assessment', 'Which of these is a Money Market Fund classified as in the EAC?', 'In the EAC, Money Market Funds are treated as Other Depository Corporations (ODCs).', 8, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(186, 5, 'final', NULL, NULL, 'Final Assessment', 'Money holding sectors are best described as:', 'Money holding sectors use money to spend, save or invest but do not create it.', 9, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(187, 5, 'final', NULL, NULL, 'Final Assessment', 'Which sectors are the money issuing sectors?', 'The Central Bank issues currency and ODCs create money by lending; together they are the money issuing sectors.', 10, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(188, 5, 'final', NULL, NULL, 'Final Assessment', 'Which sectors are money neutral?', 'Central Government and non-residents are the money neutral sectors.', 11, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(189, 5, 'final', NULL, NULL, 'Final Assessment', 'Broad money is money held by:', 'Broad money is defined as money held by the money holding sectors.', 12, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(190, 5, 'final', NULL, NULL, 'Final Assessment', 'The monetary base (high-powered money) consists of:', 'The monetary base is central bank liabilities: currency plus ODC/MHS deposits at the central bank.', 13, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(191, 5, 'final', NULL, NULL, 'Final Assessment', 'Net Foreign Assets (NFA) is:', 'NFA nets foreign-owned assets against liabilities to the rest of the world.', 14, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(192, 5, 'final', NULL, NULL, 'Final Assessment', 'Net Domestic Assets (NDA) represents:', 'NDA is domestic assets minus domestic liabilities — the financial sector\'s net position on the domestic economy.', 15, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(193, 5, 'final', NULL, NULL, 'Final Assessment', 'Net Credit to Government (NCG) is:', 'NCG nets lending to central government against government deposits and obligations the financial sector owes.', 16, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(194, 5, 'final', NULL, NULL, 'Final Assessment', 'Credit to the private sector covers lending to:', 'Credit to the private sector is lending to private companies, households and NPISH — the most direct measure of support to private activity.', 17, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(195, 5, 'final', NULL, NULL, 'Final Assessment', 'Capital, in a monetary survey, refers to:', 'Capital is the sector\'s own funds, representing its financial strength and resilience to shocks.', 18, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(196, 5, 'final', NULL, NULL, 'Final Assessment', 'Monetary statistics are presented through:', 'MFS is presented through analytical surveys (Central Bank, ODC, DCS, OFC, FCS).', 19, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(197, 5, 'final', NULL, NULL, 'Final Assessment', 'The headline output of the Central Bank Survey is:', 'The Central Bank Survey\'s headline output is the monetary base.', 20, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(198, 5, 'final', NULL, NULL, 'Final Assessment', 'The Depository Corporations Survey (DCS) equals:', 'DCS = Central Bank Survey + ODC Survey.', 21, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(199, 5, 'final', NULL, NULL, 'Final Assessment', 'The DCS is the source of which headline measure?', 'The DCS consolidates the depository sector and is the source of broad money.', 22, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35');
INSERT INTO `assessment_questions` (`id`, `courseId`, `questionType`, `moduleId`, `quizKey`, `title`, `questionText`, `explanation`, `sortOrder`, `isActive`, `createdAt`, `updatedAt`) VALUES
(200, 5, 'final', NULL, NULL, 'Final Assessment', 'For an instrument to be included in broad money, its maturity should generally be:', 'Deposits or close substitutes included in broad money should have a maturity of no more than 2 years.', 23, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(201, 5, 'final', NULL, NULL, 'Final Assessment', 'M1, the most liquid measure, is:', 'M1 = currency outside banks + transferable deposits of MHS (current accounts, mobile deposits).', 24, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(202, 5, 'final', NULL, NULL, 'Final Assessment', 'Which measure first adds foreign currency deposits of money holding sectors?', 'M3 = M2 + foreign currency deposits of MHS.', 25, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(203, 5, 'final', NULL, NULL, 'Final Assessment', 'M5 adds which instrument to M4?', 'M5 = M4 + Money Market Fund shares/units held by MHS.', 26, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(204, 5, 'final', NULL, NULL, 'Final Assessment', 'Broad money excludes:', 'Broad money excludes restricted deposits, fixed deposits over 2 years, and deposits at banks being closed.', 27, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(205, 5, 'final', NULL, NULL, 'Final Assessment', 'The OFC Survey covers:', 'The OFC Survey covers non-deposit-takers — insurance, pension funds, credit-only MFIs and forex bureaus.', 28, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(206, 5, 'final', NULL, NULL, 'Final Assessment', 'Most OFC liabilities are classified as non-liquid because:', 'As non-deposit-takers, OFC liabilities (insurance, pensions) are non-liquid and outside broad money.', 29, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(207, 5, 'final', NULL, NULL, 'Final Assessment', 'The Financial Corporations Survey (FCS) equals:', 'FCS = Depository Corporations Survey + OFC Survey — the whole financial sector consolidated.', 30, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(208, 5, 'final', NULL, NULL, 'Final Assessment', 'On any survey, capital and other items net should be:', 'Capital (own funds) and other items net (unclassified balances and adjustments) are distinct and reported separately.', 31, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(209, 5, 'final', NULL, NULL, 'Final Assessment', 'Other Items Net records:', 'Other Items Net is unclassified assets minus unclassified liabilities, plus consolidation adjustments.', 32, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(210, 5, 'final', NULL, NULL, 'Final Assessment', 'The FCS provides:', 'The FCS consolidates the whole financial sector — the most complete view of its claims and liabilities.', 33, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(211, 5, 'final', NULL, NULL, 'Final Assessment', 'Liquid liabilities on a survey are:', 'Liquid liabilities are the deposit-type liabilities that form part of broad money.', 34, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(212, 5, 'final', NULL, NULL, 'Final Assessment', 'Which survey\'s headline output is broad money?', 'The Depository Corporations Survey is the source of broad money.', 35, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(213, 5, 'final', NULL, NULL, 'Final Assessment', 'The Central Bank rate primarily signals:', 'The central bank rate indicates the policy stance — up to cool inflation, down to support growth.', 36, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(214, 5, 'final', NULL, NULL, 'Final Assessment', 'The interbank rate is the rate at which:', 'The interbank rate is what ODCs charge each other, usually overnight to 7 days, to cover temporary cash shortages.', 37, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(215, 5, 'final', NULL, NULL, 'Final Assessment', 'The reserve requirement ratio is:', 'It is the proportion of deposit liabilities banks must keep at the central bank; a higher ratio constrains lending.', 38, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(216, 5, 'final', NULL, NULL, 'Final Assessment', 'Treasury bill rates apply to instruments with maturities of:', 'Treasury bills are short-term — up to one year (91, 182 and 364 days). Bonds are over a year.', 39, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(217, 5, 'final', NULL, NULL, 'Final Assessment', 'Lending by economic activity classifies credit by:', 'It groups lending by the borrower\'s economic activity, following the standard industrial classification.', 40, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(218, 5, 'final', NULL, NULL, 'Final Assessment', 'Under the activity classification, breeding animals and growing crops fall under:', 'Growing crops, raising animals, forestry and fishing fall under Agriculture, forestry and fishing.', 41, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(219, 5, 'final', NULL, NULL, 'Final Assessment', 'The transformation of raw materials into new products is classified as:', 'Manufacturing is the physical or chemical transformation of materials into new products.', 42, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(220, 6, 'final', 'm1', NULL, 'Final Assessment', 'Which two frameworks are most commonly used to define and measure poverty?', 'The two dominant frameworks are monetary (income/consumption vs a line) and multidimensional (deprivations across dimensions). [Module 1]', 0, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(221, 6, 'final', 'm1', NULL, 'Final Assessment', 'A threshold fixed to the cost of basic human needs, used mainly in low- and middle-income countries, describes:', 'Absolute poverty uses a fixed minimum-needs threshold; relative poverty is defined against society\'s average. [Module 1]', 1, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(222, 6, 'final', 'm1', NULL, 'Final Assessment', 'A household that is poor for many years due to structural factors such as lack of education and long-term illness is experiencing:', 'Chronic poverty is long-term and structural; transient poverty is short-term and shock-driven. [Module 1]', 2, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(223, 6, 'final', 'm2', NULL, 'Final Assessment', 'Across the EAC Partner States, the welfare measure used for monetary poverty is:', 'All EAC Partner States use consumption, which is a better proxy than income in largely informal economies. [Module 2]', 3, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(224, 6, 'final', 'm2', NULL, 'Final Assessment', 'How does a durable good (e.g. a refrigerator) enter the consumption aggregate?', 'Durables enter as a service flow over their life (user-cost), not as a lump-sum purchase. [Module 2]', 4, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(225, 6, 'final', 'm2', NULL, 'Final Assessment', 'A household of 2 adults and 3 children consumes $10,000. Using the modified OECD scale (1.0 + 0.7 + 3×0.3 = 2.6), consumption per adult equivalent is:', '$10,000 ÷ 2.6 = $3,846 (vs $2,000 per capita). The scale changes the figure. [Module 2]', 5, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(226, 6, 'final', 'm2', NULL, 'Final Assessment', 'Why is rent imputed for owner-occupied homes when building the consumption aggregate?', 'Owners consume housing services too; imputing rent keeps them comparable to renters. [Module 2]', 6, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(227, 6, 'final', 'm3', NULL, 'Final Assessment', 'The World Bank\'s current international extreme-poverty line (2021 PPP) is:', '$3.00 (2021 PPP) is current; $1.90 and $2.15 are older vintages; $8.30 is the upper-middle-income line. [Module 3]', 7, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(228, 6, 'final', 'm3', NULL, 'Final Assessment', 'Under the Cost of Basic Needs approach, if the food line z_F = 1,500 and the non-food line z_NF = 587.3, the total absolute poverty line is:', 'z_CBN = z_F + z_NF = 1,500 + 587.3 = 2,087.3. [Module 3]', 8, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(229, 6, 'final', 'm3', NULL, 'Final Assessment', 'The International Poverty Line is computed as the ___ of the PPP-converted national lines of the world\'s poorest countries.', 'The IPL is the median of the poorest countries\' PPP-converted national lines. [Module 3]', 9, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(230, 6, 'final', 'm3', NULL, 'Final Assessment', 'The current World Bank line for lower-middle-income countries (2021 PPP) is:', 'In 2021 PPP the lower-middle-income line is $4.20 ($3.65 was the older 2017-PPP figure). [Module 3]', 10, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(231, 6, 'final', 'm4', NULL, 'Final Assessment', 'In the FGT formula, which value of the parameter α gives the headcount ratio (P₀)?', 'α = 0 → P₀ (headcount); α = 1 → P₁ (gap); α = 2 → P₂ (squared gap). [Module 4]', 11, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(232, 6, 'final', 'm4', NULL, 'Final Assessment', 'Which indicator is most useful for estimating the minimum budget needed to lift everyone to the poverty line (with perfect targeting)?', 'The sum of poverty gaps is the minimum cost of eliminating poverty under perfect targeting — P₁ is the budgeting indicator. [Module 4]', 12, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(233, 6, 'final', 'm4', NULL, 'Final Assessment', 'A Gini index of 0 represents:', 'Gini ranges 0 (perfect equality) to 100 (perfect inequality). [Module 4]', 13, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(234, 6, 'final', 'm5', NULL, 'Final Assessment', 'In a multidimensional poverty index, if the incidence H = 40% and the intensity A = 50%, the adjusted headcount ratio M₀ is:', 'M₀ = H × A = 0.40 × 0.50 = 0.20. [Module 5]', 14, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(235, 6, 'final', 'm5', NULL, 'Final Assessment', 'In the global MPI, a person is identified as multidimensionally poor if deprived in:', 'The dual-cutoff rule: poor if deprived in ≥ one-third of the weighted indicators. [Module 5]', 15, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(236, 6, 'final', 'm5', NULL, 'Final Assessment', 'Which statement about comparability of multidimensional poverty indices is correct?', 'Standardised measures (global, EAC regional) are comparable; bespoke national MPIs generally are not. [Module 5]', 16, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(237, 6, 'final', 'm6', NULL, 'Final Assessment', 'Why is fieldwork for an IHBS/HBS spread over a full 12 months?', 'A 12-month window captures seasonality so the data represents the whole year. [Module 6]', 17, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(238, 6, 'final', 'm6', NULL, 'Final Assessment', 'For collecting food consumption data in most poverty surveys, the preferred method is:', 'A 7-day recall balances accuracy and cost and is preferred for food consumption. [Module 6]', 18, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(239, 6, 'final', 'm6', NULL, 'Final Assessment', 'Computer-assisted personal interviewing (CAPI) is generally preferred over paper (PAPI) because it:', 'CAPI builds checks and skip patterns into the interview, speeding collection and improving quality. [Module 6]', 19, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(240, 7, 'final', NULL, NULL, 'Final Assessment', 'Which three interlinked elements make up the external accounts?', 'The external accounts comprise the BOP, the IIP, and the other changes in financial assets and liabilities accounts.', 0, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(241, 7, 'final', NULL, NULL, 'Final Assessment', 'What is the current standard manual for compiling BOP and IIP statistics, and when was it released?', 'BPM7 is the current standard, released by the IMF in March 2025 and aligned with SNA 2025.', 1, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(242, 7, 'final', NULL, NULL, 'Final Assessment', 'Which statement best defines the Balance of Payments?', 'The BOP records flows — transactions and other flows — between residents and nonresidents over a period.', 2, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(243, 7, 'final', NULL, NULL, 'Final Assessment', 'In the external accounts, the terms used for transactions in financial assets and liabilities are:', 'NAFA (net acquisition of financial assets) and NIL (net incurrence of liabilities) are used for financial transactions.', 3, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(244, 7, 'final', NULL, NULL, 'Final Assessment', 'Which accounting basis does the integrated framework of the SNA and external accounts favour?', 'The integrated framework favours accrual accounting, recording flows when economic value is created, transformed, exchanged, transferred or extinguished.', 4, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(245, 7, 'final', NULL, NULL, 'Final Assessment', 'Which is the basis for valuing transactions in the external accounts?', 'Exchange (market) prices are the basis for valuation in the external accounts.', 5, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(246, 7, 'final', NULL, NULL, 'Final Assessment', 'Residence of an institutional unit is determined by its:', 'Residence is the economic territory with which a unit has its strongest connection — its centre of predominant economic interest.', 6, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(247, 7, 'final', NULL, NULL, 'Final Assessment', 'Which of the following is NOT one of the eight data-quality criteria for ESS?', 'The eight criteria are relevance; accuracy & reliability; timeliness; consistency & comparability; accessibility & cost; coverage; stability & continuity; and confidentiality & legal compliance. Profitability is not among them.', 7, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(248, 7, 'final', NULL, NULL, 'Final Assessment', 'The current account comprises which three sub-accounts?', 'The current account comprises goods and services, earned income (formerly primary income) and transfer income (formerly secondary income).', 8, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(249, 7, 'final', NULL, NULL, 'Final Assessment', 'What is the primary data source for compiling general merchandise?', 'IMTS — primarily customs records — are the main source for general merchandise.', 9, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(250, 7, 'final', NULL, NULL, 'Final Assessment', 'Merchanting is recorded in the BOP of:', 'Merchanting is recorded only in the merchant\'s economy; the acquisition is a negative export and the sale a positive export there.', 10, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(251, 7, 'final', NULL, NULL, 'Final Assessment', 'In a processing arrangement where the principal owns the material inputs, the processor\'s fee is recorded under:', 'Because ownership of the goods does not change, only the processing fee is recorded — under manufacturing services.', 11, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(252, 7, 'final', NULL, NULL, 'Final Assessment', 'How many standard service categories does BPM7 have?', 'BPM7 has 17 first-level service categories — five more than BPM6.', 12, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(253, 7, 'final', NULL, NULL, 'Final Assessment', 'Which GATS mode of supply is NOT part of the BOP services account?', 'Mode 3 (resident-to-resident sales through a local affiliate of a nonresident) is not part of the services account.', 13, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(254, 7, 'final', NULL, NULL, 'Final Assessment', 'The BPM7 term \'earned income\' replaces which BPM6 term?', '\'Earned income\' replaces \'primary income\', harmonising with SNA 2025.', 14, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(255, 7, 'final', NULL, NULL, 'Final Assessment', 'A one-way provision of value with no return expected is a(n):', 'A transfer is a one-way provision without a direct return; an exchange involves a mutual provision of economic value.', 15, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(256, 7, 'final', NULL, NULL, 'Final Assessment', 'Is informal cross-border trade (ICBT) in goods included in merchandise trade data?', 'Yes — ICBT is included, and border-station data collection is encouraged to capture it.', 16, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(257, 7, 'final', NULL, NULL, 'Final Assessment', 'A current-account surplus occurs when:', 'A surplus arises when credits exceed debits — the country earns more abroad than it spends.', 17, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(258, 7, 'final', NULL, NULL, 'Final Assessment', 'Which is the full definition of a capital transfer?', 'A capital transfer is a one-time, unrequited transaction relating to the acquisition, disposal or forgiveness of assets or liabilities.', 18, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(259, 7, 'final', NULL, NULL, 'Final Assessment', 'Which condition would classify a transfer as a capital transfer?', 'Forgiveness of a liability by the creditor is one of the three conditions for a capital transfer.', 19, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(260, 7, 'final', NULL, NULL, 'Final Assessment', 'Which of the following is a nonproduced nonfinancial asset?', 'Natural resources such as land, mineral rights and sport players are nonproduced nonfinancial assets.', 20, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(261, 7, 'final', NULL, NULL, 'Final Assessment', 'An irregular tax on inheritances and the value of assets is classified as:', 'Capital taxes — including inheritances, gifts and legacies — are capital transfers, not ongoing tax revenue.', 21, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(262, 7, 'final', NULL, NULL, 'Final Assessment', 'Large, nonrecurring insurance payouts after a catastrophe may be recorded as:', 'Exceptional nonlife insurance claims, if exceptionally large and infrequent, may be recorded as capital transfers.', 22, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(263, 7, 'final', NULL, NULL, 'Final Assessment', 'Current-account balance + capital-account balance equals:', 'Their sum is net lending or net borrowing, which the financial account finances.', 23, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(264, 7, 'final', NULL, NULL, 'Final Assessment', 'The financial account is classified along which four dimensions?', 'It is classified by functional category, financial instrument, institutional sector, and maturity.', 24, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(265, 7, 'final', NULL, NULL, 'Final Assessment', 'A direct-investment relationship is typically evidenced by ownership of:', 'Direct investment is typically evidenced at 10% or more of voting power.', 25, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(266, 7, 'final', NULL, NULL, 'Final Assessment', 'The key feature of securities under portfolio investment is their:', 'Negotiability — the ability to be traded in financial markets — is the key feature of portfolio-investment securities.', 26, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(267, 7, 'final', NULL, NULL, 'Final Assessment', 'On financial derivatives, gains and losses are recorded as:', 'No income accrues on derivatives; gains and losses are revaluations in the other changes in financial assets and liabilities account.', 27, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(268, 7, 'final', NULL, NULL, 'Final Assessment', 'Which functional category may be held only by the monetary authorities?', 'Reserve assets are external assets readily available to and controlled by the monetary authorities.', 28, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(269, 7, 'final', NULL, NULL, 'Final Assessment', 'An investor buys units in a cross-border money-market fund. This is recorded as:', 'Investment fund shares in the form of securities are portfolio investment, regardless of the size of the holding.', 29, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(270, 7, 'final', NULL, NULL, 'Final Assessment', 'Short-term debt has an original maturity of:', 'Short-term debt has an original maturity of one year or less.', 30, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(271, 7, 'final', NULL, NULL, 'Final Assessment', 'The IIP is best described as:', 'The IIP shows the value and composition of external financial assets and liabilities at a point in time.', 31, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(272, 7, 'final', NULL, NULL, 'Final Assessment', 'A negative net IIP indicates that the country is a:', 'A negative net IIP (liabilities exceed assets) means the country is a net debtor.', 32, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(273, 7, 'final', NULL, NULL, 'Final Assessment', 'Which is one of the five IIP classification dimensions?', 'The five dimensions are functional category, financial instrument, institutional sector, maturity and currency.', 33, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(274, 7, 'final', NULL, NULL, 'Final Assessment', 'In the integrated IIP, debt write-offs and reclassifications are recorded as:', 'Write-offs and reclassifications are other volume changes; revaluations are exchange-rate and market-price changes.', 34, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(275, 7, 'final', NULL, NULL, 'Final Assessment', 'When assessing sustainability, a large negative net IIP as a share of GDP:', 'A large negative net IIP/GDP may raise sustainability risks; a positive ratio suggests a surplus economy.', 35, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(276, 7, 'final', NULL, NULL, 'Final Assessment', 'How does the IIP relate to the BOP?', 'The IIP is the stock/position statement; the BOP records the flows over time.', 36, 1, '2026-08-26 19:30:35', '2026-08-26 19:30:35'),
(277, 1, 'module_quiz', NULL, 'fm1q1', 'Knowledge Check', 'A community has abundant food in local markets, but most families cannot afford to purchase it due to high unemployment. This scenario represents a challenge primarily in which aspect of FNS?', '✅ <strong>Correct.</strong> Economic access.', 0, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(278, 1, 'module_quiz', NULL, 'fm1q2', 'Scenario Analysis', 'A rural community in Rwanda\'s Gicumbi District has experienced three consecutive seasons of drought. Crop yields have declined by 60%, and food prices in local markets have doubled. Families are selling their livestock and agricultural tools to buy food. Child wasting rates have increased from 3% to 8% in six months. Based on this scenario, what type of food insecurity is the community experiencing?', '✅ <strong>Correct.</strong> Transitory food insecurity transitioning toward acute crisis.', 1, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(279, 1, 'module_quiz', NULL, 'fm2q1', 'Knowledge check', 'What is Rwanda\'s Import Dependency Ratio for rice?', '✅ <strong>Correct.</strong> Import Dependency: 36%; Self-Sufficiency: 67% - Moderate vulnerability.', 2, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(280, 1, 'module_quiz', NULL, 'fm2q2', 'Knowledge check', 'Maria lives in Kigoma Region, western Tanzania, 25 km from the nearest town. Her household farms cassava and maize. This year\'s harvest was good. However:', '✅ <strong>Correct.</strong> Social access (primarily).', 3, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(281, 1, 'module_quiz', NULL, 'fm2q3', 'Knowledge check', 'Which intervention would most directly address the utilization failures?', '✅ <strong>Correct.</strong> Integrated nutrition program: dietary diversification + water/sanitation + micronutrient supplementation.', 4, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(282, 1, 'module_quiz', NULL, 'fm2q4', 'Knowledge check', 'District B in Uganda implements a new agricultural program providing improved seeds and fertilizer, increasing average production by 30%. Current situation:', '✅ <strong>Correct.</strong> Unlikely to be sufficient on its own.', 5, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(283, 1, 'module_quiz', NULL, 'fm2q5', 'Knowledge check', 'District X, Kenya (2024) Data:', '✅ <strong>Correct.</strong> Utilization (diet quality and WASH problems).', 6, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(284, 2, 'module_quiz', 'm1', 'm1q1', 'Knowledge check', 'For how many sectors does the EAC compute FSIs?', '✅ Correct. The five sectors are Deposit Takers, OFCs, Households, Non-Financial Corporations and Real Estate Markets.', 0, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(285, 2, 'module_quiz', 'm1', 'm1q2', 'Knowledge check', 'The FSIs for Deposit Takers are largely prepared in line with:', '✅ Correct. DT FSIs follow the Basel Standards on capital, liquidity and leverage, supporting comparability.', 1, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(286, 2, 'module_quiz', 'm1', 'm1q3', 'Knowledge check', 'What is the EAC minimum regulatory CET1 ratio?', '✅ Correct. The EAC minimum CET1 ratio is 8.5%, the Tier 1 minimum is 10%, and the total regulatory minimum is 12%.', 2, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(287, 2, 'module_quiz', 'm1', 'm1q4', 'Knowledge check', 'The leverage ratio serves mainly as:', '✅ Correct. It safeguards against rapid asset growth without a matching injection of capital.', 3, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(288, 2, 'module_quiz', 'm1', 'm1q5', 'Knowledge check', 'A loan is classified as nonperforming (an NPL) when it has not been repaid for:', '✅ Correct. NPLs are loans unpaid for 90 days.', 4, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(289, 2, 'module_quiz', 'm1', 'm1q6', 'Knowledge check', 'Provisions to NPLs shows:', '✅ Correct. It shows the extent to which a DT has set aside funds (provisions) to cover potential losses from its NPLs.', 5, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(290, 2, 'module_quiz', 'm2', 'm2q1', 'Knowledge check', 'Return on Equity (ROE) measures:', '✅ Correct. ROE measures the profit earned from the DT\'s own funds (capital).', 6, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(291, 2, 'module_quiz', 'm2', 'm2q2', 'Knowledge check', 'Other than easily tradeable securities, liquid assets should have a maturity of:', '✅ Correct. Liquid assets should have a maturity of 3 months or less, except for easily tradeable securities.', 7, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(292, 2, 'module_quiz', 'm2', 'm2q3', 'Knowledge check', 'The Liquidity Coverage Ratio (LCR) measures the ability to meet an urgent cash demand over what period, and its EAC minimum is:', '✅ Correct. The LCR covers a 30-day period and the EAC minimum is 100%.', 8, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(293, 2, 'module_quiz', 'm2', 'm2q4', 'Knowledge check', 'The net open position in foreign exchange to capital indicates a DT\'s vulnerability to:', '✅ Correct. It indicates how much a DT could be affected by changes in the value of foreign currency.', 9, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(294, 2, 'module_quiz', 'm2', 'm2q5', 'Knowledge check', 'How many additional FSIs are there for Deposit Takers?', '✅ Correct. There are 12 additional FSIs for Deposit Takers (and 13 EAC-specific ones).', 10, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(295, 2, 'module_quiz', 'm2', 'm2q6', 'Knowledge check', 'Which EAC-specific FSI captures risk from quickly approved loans issued over internet and mobile banking?', '✅ Correct. Digital loans to gross loans captures the vulnerability from online lending approved with limited information.', 11, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(296, 2, 'module_quiz', 'm3', 'm3q1', 'Knowledge check', 'Which type of insurer offers long-term cover such as life and pensions, with obligations stretching into the future?', '✅ Correct. LICs offer long-term cover such as life and pensions.', 12, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(297, 2, 'module_quiz', 'm3', 'm3q2', 'Knowledge check', 'NLICs are encouraged to maintain a combined ratio:', '✅ Correct. A combined ratio below 100 percent indicates the NLIC is profitable in its core business.', 13, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(298, 2, 'module_quiz', 'm3', 'm3q3', 'Knowledge check', 'The retention ratio measures:', '✅ Correct. It shows how much risk an IC keeps versus passing on to reinsurance.', 14, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(299, 2, 'module_quiz', 'm4', 'm4q1', 'Knowledge check', 'The pension-fund liquidity ratio checks whether a PF can cover its obligations over what period?', '✅ Correct. The PF liquidity ratio covers short-term (12-month) obligations — members\' benefits.', 15, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(300, 2, 'module_quiz', 'm4', 'm4q2', 'Knowledge check', 'The funding ratio indicates whether a PF\'s available assets are enough to:', '✅ Correct. The funding ratio shows whether available assets can cover future benefit payments.', 16, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(301, 2, 'module_quiz', 'm4', 'm4q3', 'Knowledge check', 'For the pension-fund efficiency ratio, a lower value means:', '✅ Correct. Lower = minimal operational cost — the PF spends little to generate income.', 17, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(302, 2, 'module_quiz', 'm4', 'm4q4', 'Knowledge check', 'A Money Market Fund invests in income-generating assets owned for a period of:', '✅ Correct. MMFs invest in short-term assets owned for one year or less, such as Treasury bills.', 18, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(303, 2, 'module_quiz', 'm5', 'm5q1', 'Knowledge check', 'The Residential Property Price Index (RPPI) measures the change in prices of:', '✅ Correct. The RPPI tracks prices of apartments and houses bought by households for their own use.', 19, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(304, 2, 'module_quiz', 'm5', 'm5q2', 'Knowledge check', 'Why does a sharp fall in property prices matter for Deposit Takers?', '✅ Correct. Falling prices shrink the value of collateral behind loans, creating a loan exposure for DTs.', 20, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(305, 2, 'module_quiz', 'm5', 'm5q3', 'Knowledge check', 'For NFCs, Return on Equity (ROE) is best described as:', '✅ Correct. ROE is the profit earned from NFCs\' own funds.', 21, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(306, 2, 'module_quiz', 'm5', 'm5q4', 'Knowledge check', 'The interest coverage ratio measures an NFC\'s ability to:', '✅ Correct. It measures the ability to repay the interest on borrowed funds using income.', 22, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(307, 2, 'module_quiz', 'm5', 'm5q5', 'Knowledge check', 'A household, for FSI purposes, is:', '✅ Correct. A household can be one person or a group, such as a family, sharing money and expenses.', 23, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(308, 2, 'module_quiz', 'm5', 'm5q6', 'Knowledge check', 'A higher household debt-to-income ratio implies:', '✅ Correct. A higher ratio signals household indebtedness — borrowing is large relative to income.', 24, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(357, 6, 'module_quiz', 'm1', 'm1q1', 'Knowledge Check', 'Which best describes the <strong>multidimensional</strong> poverty framework?', '✅ <strong>Correct.</strong> The multidimensional framework captures overlapping deprivations across dimensions — influenced by Sen\'s Capability Approach.', 0, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(358, 6, 'module_quiz', 'm1', 'm1q2', 'Knowledge Check', 'Tracking poverty against the SDGs over the years requires that statistics are:', '✅ <strong>Correct.</strong> Monitoring progress needs statistics that are comparable across years.', 1, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(359, 6, 'module_quiz', 'm1', 'm1q3', 'Scenario', 'A country defines the poor as those earning below 60% of the national median income. This is a:', '✅ <strong>Correct.</strong> A threshold tied to the society\'s median moves with average living standards — that is relative poverty.', 2, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(360, 6, 'module_quiz', 'm1', 'm1q4', 'Knowledge Check', 'The \'Ladder of Life\' question (placing yourself 0–10) is an example of:', '✅ <strong>Correct.</strong> It captures people\'s own perception of their position — a subjective measure.', 3, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(361, 6, 'module_quiz', 'm1', 'm1q5', 'Scenario', 'A farmer falls below the poverty line for three months after a failed harvest, then recovers when the next season succeeds. This is:', '✅ <strong>Correct.</strong> Short-term, shock-driven poverty with recovery is transient.', 4, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(362, 6, 'module_quiz', 'm1', 'm1q6', 'Knowledge Check', 'Vulnerability to poverty is best described as:', '✅ <strong>Correct.</strong> Vulnerability is about who <em>might</em> become poor, depending on exposure, coping capacity and resilience.', 5, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(363, 6, 'module_quiz', 'm1', 'm1q7', 'Knowledge Check', 'Which statement is true?', '✅ <strong>Correct.</strong> Inequality is about the whole distribution; a society can be unequal yet have little absolute poverty, and vice versa.', 6, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(364, 6, 'module_quiz', 'm2', 'm2q1', 'Knowledge Check', 'This module covers which step of monetary poverty measurement?', '✅ <strong>Correct.</strong> Step 1 is the welfare indicator — the consumption aggregate. The line (M3) and measures (M4) come next.', 7, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(365, 6, 'module_quiz', 'm2', 'm2q2', 'Scenario', 'In a rural EAC district with widespread subsistence farming and informal work, which welfare indicator is more reliable?', '✅ <strong>Correct.</strong> Where income is informal, seasonal and under-reported, consumption is the better proxy for living standards.', 8, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(366, 6, 'module_quiz', 'm2', 'm2q3', 'Knowledge Check', 'How does a durable good (e.g. a refrigerator) enter the consumption aggregate?', '✅ <strong>Correct.</strong> Durables enter as a flow of services over their life, not as a lump-sum purchase.', 9, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(367, 6, 'module_quiz', 'm2', 'm2q4', 'Knowledge Check', 'Maize a household grew and ate itself should be:', '✅ <strong>Correct.</strong> Own-produced food is valued at local market prices and included, or rural welfare is understated.', 10, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(368, 6, 'module_quiz', 'm2', 'm2q5', 'Knowledge Check', 'A unit value is calculated as:', '✅ <strong>Correct.</strong> Unit value = expenditure ÷ quantity, used to value non-cash items where direct prices are missing.', 11, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(369, 6, 'module_quiz', 'm2', 'm2q6', 'Scenario', 'Why do we impute rent for an owner-occupied home?', '✅ <strong>Correct.</strong> Owners consume housing services too; imputing rent keeps them comparable to renters.', 12, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(370, 6, 'module_quiz', 'm2', 'm2q7', 'Knowledge Check', 'Which durables method is preferred in practice?', '✅ <strong>Correct.</strong> User cost spreads the cost over the item\'s life plus the cost of tied-up money — sound and practical.', 13, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(371, 6, 'module_quiz', 'm2', 'm2q8', 'Knowledge Check', 'Which of these is EXCLUDED from the consumption aggregate?', '✅ <strong>Correct.</strong> Taxes are not consumption and provide no direct utility, so they\'re excluded.', 14, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(372, 6, 'module_quiz', 'm2', 'm2q9', 'Knowledge Check', 'Real consumption differs from nominal consumption because it:', '✅ <strong>Correct.</strong> Real consumption uses constant prices, isolating true changes in living standards.', 15, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(373, 6, 'module_quiz', 'm2', 'm2q10', 'Calculation', 'A household has 2 adults and 3 children and consumes $10,000. Using the modified OECD scale (1.0 + 0.7 + 3×0.3 = 2.6), per adult equivalent consumption is:', '✅ <strong>Correct.</strong> $10,000 ÷ 2.6 = $3,846 (vs $2,000 per capita) — the scale changes the figure.', 16, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(374, 6, 'module_quiz', 'm2', 'm2q11', 'Scenario', 'An urban household reports monthly consumption of 21, while a rural household reports 10. After adjusting for price differences using the Paasche index, the urban household\'s real consumption is 14 (Paasche index = 1.5) and the rural household\'s real consumption is 10 (Paasche index = 1.0). What does this result show?', '✅ <strong>Correct!</strong> While the urban household still has higher real consumption, adjusting for higher prices reduces the apparent difference in welfare. This shows why price adjustments are essential for fair comparison.', 17, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(375, 6, 'module_quiz', 'm3', 'm3q1', 'Knowledge Check', 'This module focuses on which type of poverty line, and why?', '✅ <strong>Correct.</strong> Absolute lines are objective and consistent — the EAC approach.', 18, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(376, 6, 'module_quiz', 'm3', 'm3q2', 'Knowledge Check', 'The current World Bank extreme-poverty line (2021 PPP) is:', '✅ <strong>Correct.</strong> $3.00 (2021 PPP) is the current extreme line; $1.90 and $2.15 are older vintages, $8.30 is the upper-middle line.', 19, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(377, 6, 'module_quiz', 'm3', 'm3q3', 'Knowledge Check', 'The Cost of Basic Needs approach builds a national line by:', '✅ <strong>Correct.</strong> CBN = food line + non-food line.', 20, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(378, 6, 'module_quiz', 'm3', 'm3q4', 'Calculation', 'A basket provides 1,955 kcal but the target is 2,250 kcal. The scaling factor applied to quantities is about:', '✅ <strong>Correct.</strong> 2,250 ÷ 1,955 ≈ 1.15 — scale every quantity up by 15%.', 21, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(379, 6, 'module_quiz', 'm3', 'm3q5', 'Knowledge Check', 'The non-food poverty line is estimated indirectly from households whose:', '✅ <strong>Correct.</strong> Those households just meet their food needs, so their other spending reveals essential non-food needs.', 22, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(380, 6, 'module_quiz', 'm3', 'm3q6', 'Calculation', 'If z_F = 1,500 and z_NF = 587.3, the total absolute poverty line z_CBN is:', '✅ <strong>Correct.</strong> z_CBN = z_F + z_NF = 1,500 + 587.3 = 2,087.3.', 23, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(381, 6, 'module_quiz', 'm3', 'm3q7', 'Knowledge Check', 'The International Poverty Line is computed as the ___ of the poorest countries\' national lines (PPP-converted).', '✅ <strong>Correct.</strong> The IPL is the median of the converted national lines of the poorest countries.', 24, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(382, 6, 'module_quiz', 'm3', 'm3q8', 'Scenario', 'A minister says \'our national poverty rate is 20% but the $3.00 rate is 30%, so the national line must be wrong.\' The best response is:', '✅ <strong>Correct.</strong> Different yardsticks measure different depths; use them together, not against each other.', 25, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(383, 6, 'module_quiz', 'm4', 'm4q1', 'Knowledge Check', 'In the FGT formula, which value of α gives the headcount ratio?', '✅ <strong>Correct.</strong> α = 0 → P₀ (headcount); α = 1 → P₁ (gap); α = 2 → P₂ (squared gap).', 26, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(384, 6, 'module_quiz', 'm4', 'm4q2', 'Calculation', '90 people are poor in a population of 450. The headcount ratio P₀ is:', '✅ <strong>Correct.</strong> P₀ = 90 / 450 = 0.20 = 20%.', 27, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(385, 6, 'module_quiz', 'm4', 'm4q3', 'Scenario', 'A finance ministry wants to estimate the minimum budget to lift everyone to the poverty line (with perfect targeting). Which indicator?', '✅ <strong>Correct.</strong> The sum of poverty gaps is the minimum cost of eliminating poverty under perfect targeting — P₁ is the budgeting indicator.', 28, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(386, 6, 'module_quiz', 'm4', 'm4q4', 'Knowledge Check', 'Two regions have equal P₀ and P₁, but Region A has a higher P₂. This means:', '✅ <strong>Correct.</strong> A higher P₂ at equal P₀/P₁ signals greater severity — the poorest are further below the line.', 29, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(387, 6, 'module_quiz', 'm4', 'm4q5', 'Calculation', 'For consumption 30, 60, 80, 90 against a $100 line (n = 10), the poverty gap P₁ is:', '✅ <strong>Correct.</strong> Gaps = 0.7+0.4+0.2+0.1 = 1.4; ÷ 10 = 0.14 (14% below the line on average).', 30, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(388, 6, 'module_quiz', 'm4', 'm4q6', 'Scenario', 'Poverty maps show a very high headcount in one remote region. The most directly justified response is:', '✅ <strong>Correct.</strong> Disaggregated indicators enable precision targeting of lagging regions.', 31, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(389, 6, 'module_quiz', 'm4', 'm4q7', 'Scenario', 'Over five years P₀ falls but P₂ rises. The best interpretation is:', '✅ <strong>Correct.</strong> A falling P₀ with rising P₂ signals deepening deprivation among those who remain poor.', 32, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(390, 6, 'module_quiz', 'm4', 'm4q8', 'Knowledge Check', 'A Gini index of 0 means:', '✅ <strong>Correct.</strong> Gini ranges 0 (perfect equality) to 100 (perfect inequality).', 33, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(391, 6, 'module_quiz', 'm5', 'm5q1', 'Knowledge Check', 'Multidimensional poverty differs from monetary poverty mainly because it:', '✅ <strong>Correct.</strong> It captures overlapping deprivations across dimensions like health, education and living standards.', 34, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(392, 6, 'module_quiz', 'm5', 'm5q2', 'Knowledge Check', 'The relationship between multidimensional and monetary poverty measures is best described as:', '✅ <strong>Correct.</strong> They complement each other; a person can be non-poor by income yet deprived in other ways.', 35, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(393, 6, 'module_quiz', 'm5', 'm5q3', 'Knowledge Check', 'The Capability Approach, which underpins multidimensional poverty, was developed by:', '✅ <strong>Correct.</strong> Sen\'s Capability Approach reframes poverty as deprivation of real freedoms and opportunities.', 36, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(394, 6, 'module_quiz', 'm5', 'm5q4', 'Knowledge Check', 'In the global MPI, a person is identified as multidimensionally poor if deprived in:', '✅ <strong>Correct.</strong> The dual-cutoff rule: poor if deprived in ≥ one-third of the weighted indicators.', 37, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(395, 6, 'module_quiz', 'm5', 'm5q5', 'Calculation', 'If H = 50% and A = 50%, the adjusted headcount ratio M₀ is:', '✅ <strong>Correct.</strong> M₀ = H × A = 0.50 × 0.50 = 0.25.', 38, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(396, 6, 'module_quiz', 'm5', 'm5q6', 'Knowledge Check', 'Disaggregating MPI results by region and sex mainly helps to:', '✅ <strong>Correct.</strong> Disaggregation exposes within-country inequality and sharpens targeting.', 39, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(397, 6, 'module_quiz', 'm5', 'm5q7', 'Scenario', 'Two EAC Partner States want to compare their multidimensional poverty directly. They should use:', '✅ <strong>Correct.</strong> The EAC regional MPI is built for comparability; national MPIs generally aren\'t comparable across countries.', 40, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(398, 6, 'module_quiz', 'm5', 'm5q8', 'Knowledge Check', 'A key advantage of M₀ over a simple headcount is that it:', '✅ <strong>Correct.</strong> Because M₀ = H × A, reducing the depth of deprivation lowers it — a richer signal than a headcount.', 41, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(399, 6, 'module_quiz', 'm6', 'm6q1', 'Knowledge Check', 'Why are household surveys described as the \'backbone\' of poverty measurement?', '✅ <strong>Correct.</strong> Every measure in the course depends on survey data.', 42, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(400, 6, 'module_quiz', 'm6', 'm6q2', 'Knowledge Check', 'The recommended frequency for poverty surveys is usually:', '✅ <strong>Correct.</strong> 3–5 years balances tracking progress with feasibility.', 43, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(401, 6, 'module_quiz', 'm6', 'm6q3', 'Scenario', 'Why is an IHBS fielded over a full 12 months rather than one month?', '✅ <strong>Correct.</strong> Twelve months of fieldwork captures seasonality, so the data represents the whole year.', 44, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(402, 6, 'module_quiz', 'm6', 'm6q4', 'Knowledge Check', 'The sampling design commonly used for poverty surveys is:', '✅ <strong>Correct.</strong> Multi-stage stratified cluster sampling, ideally from a census-based frame.', 45, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(403, 6, 'module_quiz', 'm6', 'm6q5', 'Knowledge Check', 'When designing food and non-food expenditure modules, which classification is recommended?', '✅ <strong>Correct.</strong> COICOP gives comprehensive, consistent, internationally aligned item coverage.', 46, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(404, 6, 'module_quiz', 'm6', 'm6q6', 'Knowledge Check', 'For collecting food consumption data in most poverty surveys, the preferred method is:', '✅ <strong>Correct.</strong> A 7-day recall balances accuracy and cost — the usual choice.', 47, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(405, 6, 'module_quiz', 'm6', 'm6q7', 'Knowledge Check', 'What distinguishes a pilot from a pre-test?', '✅ <strong>Correct.</strong> The pre-test checks the instrument; the pilot rehearses the entire questionnaire, supervision and logistics.', 48, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(406, 6, 'module_quiz', 'm6', 'm6q8', 'Knowledge Check', 'Why is CAPI generally preferred over PAPI for poverty surveys?', '✅ <strong>Correct.</strong> CAPI builds checks and skip patterns into the interview, speeding collection and improving quality.', 49, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(407, 6, 'module_quiz', 'm6', 'm6q9', 'Knowledge Check', 'In data processing, applying survey weights ensures that:', '✅ <strong>Correct.</strong> Weights scale the sample up to represent the population.', 50, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(408, 7, 'module_quiz', 'm1', 'm1q1', 'Knowledge check', 'The external accounts are composed of three interlinked elements. Which of the following correctly identifies them?', '✅ Correct. The three interlinked elements are the Balance of Payments, the International Investment Position, and the Other Changes in Financial Assets and Liabilities Account.', 0, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(409, 7, 'module_quiz', 'm1', 'm1q2', 'Knowledge check', 'Which statement describes the position and flow in the external accounts correctly?', '✅ Correct. A position is a level of assets/liabilities at a point in time; a flow is a transaction or other change over a period.', 1, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(410, 7, 'module_quiz', 'm1', 'm1q3', 'Knowledge check', 'Which of the following was <strong>not</strong> a driver of the revision from BPM6 to BPM7?', '✅ Correct. The IIP was not abolished — on the contrary, BPM7 reinforces the importance of the IIP as the stock counterpart to Balance of Payments flows. The genuine drivers were digitalization and digital financial assets, better coverage of global production and trade in services, and stronger alignment with the SNA.', 2, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(411, 7, 'module_quiz', 'm1', 'm1q4', 'Knowledge check', 'Which data-quality criterion asks whether the source covers all sectors — households, corporates and government?', '✅ Correct. Coverage ensures the completeness of the BOP/IIP accounts across all sectors.', 3, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(412, 7, 'module_quiz', 'm1', 'm1q5', 'Knowledge check', 'In transactions involving financial assets and liabilities, what do the terms NAFA and NIL refer to?', '✅ Correct. NAFA = net acquisition of financial assets; NIL = net incurrence of liabilities.', 4, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(413, 7, 'module_quiz', 'm1', 'm1q6', 'Knowledge check', 'How many institutional sectors are used to group units in the external accounts?', '✅ Correct. The five sectors are nonfinancial corporations, financial corporations, general government, NPISH, and households.', 5, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(414, 7, 'module_quiz', 'm2', 'm2q1', 'Knowledge check', 'How are imports of goods valued in the Balance of Payments framework?', '✅ Correct! For Balance of Payments purposes, imports are recorded on an FOB basis. This means the value of the goods is measured at the border of the exporting economy. International transport and insurance costs are recorded separately as services.', 6, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(415, 7, 'module_quiz', 'm2', 'm2q2', 'Knowledge check', 'In which economy\'s BOP is merchanting recorded?', '✅ Correct. Merchanting is recorded only in the BOP of the merchant\'s economy; both the acquisition (negative export) and the sale (positive export) appear there.', 7, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(416, 7, 'module_quiz', 'm2', 'm2q3', 'Knowledge check', 'When Country A imports a motor vehicle for 100 and pays immediately, what is the statistical discrepancy?', '✅ Correct. The financial account mirrors the current-account entry, so SD = FA − CA − KA = −100 − (−100) − 0 = 0.', 8, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15');
INSERT INTO `assessment_questions` (`id`, `courseId`, `questionType`, `moduleId`, `quizKey`, `title`, `questionText`, `explanation`, `sortOrder`, `isActive`, `createdAt`, `updatedAt`) VALUES
(417, 7, 'module_quiz', 'm2', 'm2q4', 'Knowledge check', 'Which GATS mode of supply is NOT part of the BOP services account?', '✅ Correct. Mode 3 (resident-to-resident sales through a local affiliate of a nonresident) is not part of the services account.', 9, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(418, 7, 'module_quiz', 'm2', 'm2q5', 'Knowledge check', 'Under BPM7, the former BPM6 \'other business services\' category was split into how many first-level categories?', '✅ Correct. It was split into R&D; professional and management consulting; nonfinancial intermediation; operating leasing; and technical, environmental and other business services.', 10, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(419, 7, 'module_quiz', 'm2', 'm2q6', 'Knowledge check', 'A remittance sent home by a worker abroad, with nothing provided in return, is an example of:', '✅ Correct. A one-way provision with no direct return is a transfer (here, a current transfer recorded under transfer income).', 11, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(420, 7, 'module_quiz', 'm2', 'm2q7', 'Knowledge check', 'A current-account deficit means:', '✅ Correct. A deficit arises when debits exceed credits — the country spends more abroad than it earns.', 12, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(421, 7, 'module_quiz', 'm3', 'm3q1', 'Knowledge check', 'Which of the following would classify a transfer as a capital transfer?', '✅ Correct. Forgiveness of a liability by the creditor is one of the three conditions for a capital transfer.', 13, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(422, 7, 'module_quiz', 'm3', 'm3q2', 'Knowledge check', 'Which of the following is a nonproduced nonfinancial asset recorded in the capital account?', '✅ Correct. Natural resources such as land, mineral rights and sport players are nonproduced nonfinancial assets.', 14, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(423, 7, 'module_quiz', 'm3', 'm3q3', 'Knowledge check', 'An inheritance tax levied irregularly on the value of assets is recorded as:', '✅ Correct. Capital taxes — including inheritances, gifts and legacies — are capital transfers, not ongoing tax revenue.', 15, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(424, 7, 'module_quiz', 'm3', 'm3q4', 'Knowledge check', 'Which feature best distinguishes a current transfer from a capital transfer?', '✅ Correct. Current transfers are not asset-linked and directly affect disposable income; capital transfers are asset-linked.', 16, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(425, 7, 'module_quiz', 'm3', 'm3q5', 'Knowledge check', 'Current-account balance + capital-account balance equals:', '✅ Correct. Their sum is net lending or net borrowing, which the financial account finances.', 17, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(426, 7, 'module_quiz', 'm4', 'm4q1', 'Knowledge check', 'Along which four dimensions is the financial account classified?', '✅ Correct. The financial account is classified by functional category, instrument, institutional sector, and maturity.', 18, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(427, 7, 'module_quiz', 'm4', 'm4q2', 'Knowledge check', 'What ownership threshold typically signals a direct-investment relationship?', '✅ Correct. A direct-investment relationship is typically evidenced at 10% or more of voting power.', 19, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(428, 7, 'module_quiz', 'm4', 'm4q3', 'Knowledge check', 'Which functional category may be held only by the monetary authorities?', '✅ Correct. Reserve assets are external assets controlled by the monetary authorities.', 20, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(429, 7, 'module_quiz', 'm4', 'm4q4', 'Knowledge check', 'A foreign investor buys 8% of the shares of a bank. This is recorded as:', '✅ Correct. Equity below 10% of voting power is portfolio investment.', 21, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(430, 7, 'module_quiz', 'm4', 'm4q5', 'Knowledge check', 'Which of the following is one of the six institutional sectors in the financial account?', '✅ Correct. The six sectors include households and NPISH, alongside the central bank, deposit-taking corporations, general government, other financial corporations, and nonfinancial corporations.', 22, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(431, 7, 'module_quiz', 'm4', 'm4q6', 'Knowledge check', 'Short-term debt is defined by which original maturity?', '✅ Correct. Short-term debt has an original maturity of one year or less.', 23, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(432, 7, 'module_quiz', 'm4', 'm4q7', 'Knowledge check', 'A financial-account position of net borrowing indicates that:', '✅ Correct. Net borrowing means liabilities incurred exceed assets acquired, financing a current-account deficit or building reserves.', 24, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(433, 7, 'module_quiz', 'm5', 'm5q1', 'Knowledge check', 'A country whose external assets exceed its external liabilities has:', '✅ Correct. Assets greater than liabilities gives a positive net IIP — a net creditor.', 25, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(434, 7, 'module_quiz', 'm5', 'm5q2', 'Knowledge check', 'Which of the following is one of the five IIP classification dimensions?', '✅ Correct. The five dimensions are functional category, financial instrument, institutional sector, maturity and currency.', 26, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(435, 7, 'module_quiz', 'm5', 'm5q3', 'Knowledge check', 'In the integrated IIP, a change in value due to exchange-rate movements is recorded as:', '✅ Correct. Exchange-rate and market-price changes are revaluations.', 27, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(436, 7, 'module_quiz', 'm5', 'm5q4', 'Knowledge check', 'When assessing sustainability, a large negative net IIP as a share of GDP:', '✅ Correct. A large negative net IIP/GDP may raise sustainability risks; a positive ratio suggests a surplus economy.', 28, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(437, 7, 'module_quiz', 'm5', 'm5q5', 'Knowledge check', 'How does the IIP relate to the Balance of Payments?', '✅ Correct. The IIP shows the position at a point in time; the BOP records flows over a period.', 29, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(438, 7, 'module_quiz', 'm5', 'm5q6', 'Knowledge check', 'Which source is used for reserve assets, SDR holdings and central-bank claims and liabilities?', '✅ Correct. Central-bank records provide reserve assets, SDR holdings and central-bank claims and liabilities.', 30, 1, '2026-08-26 19:33:15', '2026-08-26 19:33:15'),
(439, 3, 'module_quiz', 'm1', 'm1q1', 'Knowledge check', 'Which statement best defines Government Finance Statistics (GFS)?', '✅ Correct. GFS tracks government revenues, expenditures, borrowing and assets/liabilities — a financial health check for government.', 0, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(440, 3, 'module_quiz', 'm1', 'm1q2', 'Knowledge check', 'Accrual accounting records transactions:', '✅ Correct. Accrual records transactions when they occur; cash accounting records actual cash received or paid.', 1, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(441, 3, 'module_quiz', 'm2', 'm2q1', 'Knowledge check', 'In the GFSM 2014 framework, the closing balance sheet equals:', '✅ Correct. Opening stocks plus the period\'s flows (transactions and other economic flows) give the closing stocks.', 2, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(442, 3, 'module_quiz', 'm2', 'm2q2', 'Knowledge check', 'Which of the following is recorded as revenue in GFS?', '✅ Correct. Revenue comprises taxes, social contributions, grants and other revenue.', 3, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(443, 3, 'module_quiz', 'm2', 'm2q3', 'Knowledge check', 'Net lending/net borrowing (the fiscal balance) is:', '✅ Correct. It is total revenue minus total expenditure — a surplus or a deficit.', 4, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(444, 3, 'module_quiz', 'm2', 'm2q4', 'Knowledge check', 'The fiscal balance is financed by:', '✅ Correct. Financing comes from transactions in financial assets and the net incurrence of liabilities.', 5, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(445, 3, 'module_quiz', 'm3', 'm3q1', 'Knowledge check', 'The public sector covered by GFS consists of:', '✅ Correct. The public sector is general government plus public corporations.', 6, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(446, 3, 'module_quiz', 'm3', 'm3q2', 'Knowledge check', 'Which of the following is a source of GFS data?', '✅ Correct. National revenue authority statements, treasury and accounting systems, budget execution reports, central bank data and public entities\' financial statements are GFS sources.', 7, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(447, 3, 'module_quiz', 'm3', 'm3q3', 'Knowledge check', 'The functional classification (COFOG) classifies spending by:', '✅ Correct. COFOG classifies by purpose; the economic classification classifies by the nature of the transaction.', 8, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(448, 3, 'module_quiz', 'm4', 'm4q1', 'Knowledge check', 'What is the primary objective of GFS?', '✅ Correct. GFS gives policymakers, researchers and the public reliable, consistent information on government operations.', 9, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(449, 3, 'module_quiz', 'm4', 'm4q2', 'Knowledge check', 'Which indicators are commonly used in GFS international comparisons?', '✅ Correct. Revenue, tax revenue and public investment — each as a percentage of GDP — are the standardized comparison indicators.', 10, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(450, 3, 'module_quiz', 'm4', 'm4q3', 'Knowledge check', 'The EAMU convergence ceiling for the fiscal deficit including grants is:', '✅ Correct. Including grants the ceiling is 3% of GDP; excluding grants it is 6%; gross public debt is capped at 50% of GDP (NPV).', 11, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(451, 3, 'module_quiz', 'm4', 'm4q4', 'Knowledge check', 'The net worth of a government is:', '✅ Correct. Net worth is total assets minus total liabilities (revenue minus expenditure is the fiscal balance).', 12, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(452, 3, 'module_quiz', 'm5', 'm5q1', 'Knowledge check', 'In GFS, debt forgiveness is recorded as:', '✅ Correct. Debt forgiveness is recorded as a capital grant (revenue).', 13, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(453, 3, 'module_quiz', 'm5', 'm5q2', 'Knowledge check', 'Royalties and corporate income tax collected from extraction companies are classified as:', '✅ Correct. Taxes on extraction companies include corporate income tax and royalties.', 14, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(454, 3, 'module_quiz', 'm5', 'm5q3', 'Knowledge check', 'Why are governments encouraged to separate recurrent revenues from one-off revenues?', '✅ Correct. Distinguishing recurrent (taxes, royalties) from one-off (asset sales) revenues helps ensure fiscal sustainability.', 15, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(455, 3, 'module_quiz', 'm5', 'm5q4', 'Knowledge check', 'GFS supports the EAC by promoting:', '✅ Correct. GFS supports fiscal transparency, debt sustainability and regional convergence.', 16, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(456, 4, 'module_quiz', 'm1', 'm1q1', 'Knowledge check', 'What is Public Sector Debt Statistics (PSDS)?', '✅ Correct. PSDS is a framework for measuring and reporting public debt data, recording total gross public debt.', 0, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(457, 4, 'module_quiz', 'm1', 'm1q2', 'Knowledge check', 'A debt instrument is best defined as:', '✅ Correct. A debt instrument requires payment(s) of interest and/or principal at a future date or dates.', 1, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(458, 4, 'module_quiz', 'm1', 'm1q3', 'Knowledge check', 'Which international standard guides the compilation of PSDS?', '✅ Correct. Compilation is guided by the PSDSG 2013 for consistency and comparability between countries.', 2, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(459, 4, 'module_quiz', 'm2', 'm2q1', 'Knowledge check', 'Which institutional units are included in PSDS compilation?', '✅ Correct. PSDS includes debt from general government (central, state, local) and public corporations (nonfinancial and financial).', 3, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(460, 4, 'module_quiz', 'm2', 'm2q2', 'Knowledge check', 'Under debt securities, PSDS records:', '✅ Correct. Debt securities comprise treasury bonds and treasury bills.', 4, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(461, 4, 'module_quiz', 'm2', 'm2q3', 'Knowledge check', 'How are government guarantees treated in PSDS?', '✅ Correct. Government guarantees are published as memorandum items.', 5, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(462, 4, 'module_quiz', 'm2', 'm2q4', 'Knowledge check', 'Where is PSDS data found?', '✅ Correct. Data is found on the Partner States\' Ministries of Finance, Central Banks and NSOs websites, and on the EAC Statistics Portal.', 6, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(463, 4, 'module_quiz', 'm3', 'm3q1', 'Knowledge check', 'Under classification by maturity, short-term debt has a maturity of:', '✅ Correct. Short-term debt matures in one year or less; long-term debt in more than one year.', 7, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(464, 4, 'module_quiz', 'm3', 'm3q2', 'Knowledge check', 'Public Sector Debt (PSD) differs from General Government Debt (GGD) in that PSD also includes:', '✅ Correct. PSD = GGD plus the debt of public financial and non-financial corporations.', 8, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(465, 4, 'module_quiz', 'm3', 'm3q3', 'Knowledge check', 'Why is the debt of public corporations included in PSDS?', '✅ Correct. Public corporations can borrow heavily under guarantees, so including their debt shows the government\'s full fiscal exposure.', 9, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(466, 4, 'module_quiz', 'm3', 'm3q4', 'Knowledge check', 'External debt is:', '✅ Correct. External debt is owed to non-residents; domestic debt is owed to residents.', 10, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(467, 4, 'module_quiz', 'm4', 'm4q1', 'Knowledge check', 'Gross debt consists of:', '✅ Correct. Gross debt is the total of all liabilities that are debt instruments.', 11, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(468, 4, 'module_quiz', 'm4', 'm4q2', 'Knowledge check', 'Net debt is calculated as:', '✅ Correct. Net debt is gross debt minus financial assets corresponding to debt instruments.', 12, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(469, 4, 'module_quiz', 'm4', 'm4q3', 'Knowledge check', 'The debt-to-GDP ratio is calculated as:', '✅ Correct. Debt-to-GDP = (Total Public Debt ÷ GDP) × 100; a lower ratio is generally more sustainable.', 13, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(470, 4, 'module_quiz', 'm4', 'm4q4', 'Knowledge check', 'The EAMU convergence ceiling for public debt is:', '✅ Correct. The EAMU ceiling is public debt in NPV of 50 percent of GDP.', 14, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(471, 4, 'module_quiz', 'm5', 'm5q1', 'Knowledge check', 'Contingent liabilities are:', '✅ Correct. Contingent liabilities arise only if a particular, discrete future event occurs — e.g. guarantees, lawsuits or PPP commitments.', 15, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(472, 4, 'module_quiz', 'm5', 'm5q2', 'Knowledge check', 'An explicit contingent liability is:', '✅ Correct. Explicit contingent liabilities are contractual; implicit ones arise without a legal or contractual source and are recognised after the event.', 16, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(473, 4, 'module_quiz', 'm5', 'm5q3', 'Knowledge check', 'Which indicator assesses the share of government revenue used for debt repayment?', '✅ Correct. The debt service-to-revenue ratio shows how much revenue goes to debt repayment.', 17, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(474, 4, 'module_quiz', 'm5', 'm5q4', 'Knowledge check', 'Debt rescheduling differs from debt restructuring in that rescheduling:', '✅ Correct. Rescheduling is a bilateral postponement of debt service with extended maturities; restructuring alters the original terms more broadly.', 18, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(475, 5, 'module_quiz', 'm1', 'm1q1', 'Knowledge Check', 'In plain terms, what does Monetary &amp; Financial Statistics show?', '✅ Correct. MFS tracks money held, money owed and the flow of money through the economy.', 0, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(476, 5, 'module_quiz', 'm1', 'm1q2', 'Knowledge Check', 'What makes a unit a non-resident?', '✅ Correct. Residency follows the centre of economic interest, not nationality or ownership.', 1, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(477, 5, 'module_quiz', 'm1', 'm1q3', 'Knowledge Check', 'Which institution is an Other Financial Corporation (OFC), not a Depository Corporation?', '✅ Correct. Insurance companies do not take deposits, so they are OFCs. The others are deposit-takers (DCs).', 2, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(478, 5, 'module_quiz', 'm2', 'm2q1', 'Knowledge Check', 'Which best describes the monetary base?', '✅ Correct. The monetary base is central bank liabilities — currency plus reserve deposits — also called high-powered money.', 3, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(479, 5, 'module_quiz', 'm2', 'm2q2', 'Knowledge Check', 'Net Foreign Assets (NFA) is:', '✅ Correct. NFA nets foreign-owned assets against liabilities to the rest of the world.', 4, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(480, 5, 'module_quiz', 'm3', 'm3q1', 'Knowledge Check', 'The Depository Corporations Survey (DCS) is built as:', '✅ Correct. The DCS consolidates the Central Bank Survey and the ODC Survey.', 5, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(481, 5, 'module_quiz', 'm3', 'm3q2', 'Knowledge Check', 'Which broad money measure first adds foreign currency deposits of money holding sectors?', '✅ Correct. M3 = M2 + foreign currency deposits of MHS.', 6, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(482, 5, 'module_quiz', 'm4', 'm4q1', 'Knowledge Check', 'Why are most OFC liabilities classified as non-liquid?', '✅ Correct. OFCs are non-deposit-takers, so their obligations are non-liquid liabilities, not broad money.', 7, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(483, 5, 'module_quiz', 'm4', 'm4q2', 'Knowledge Check', 'The Financial Corporations Survey (FCS) equals:', '✅ Correct. FCS = DCS + OFC Survey — the whole financial sector.', 8, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(484, 5, 'module_quiz', 'm4', 'm4q3', 'Knowledge Check', 'On a survey, capital and other items net should be:', '✅ Correct. Capital and other items net measure different things and are reported separately.', 9, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(485, 5, 'module_quiz', 'm5', 'm5q1', 'Knowledge Check', 'What does the Central Bank rate primarily signal?', '✅ Correct. The central bank rate indicates the policy stance — up to cool spending and inflation, down to support growth.', 10, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(486, 5, 'module_quiz', 'm5', 'm5q2', 'Knowledge Check', 'Lending by economic activity classifies credit by:', '✅ Correct. It groups lending by the borrower\'s economic activity, following the standard industrial classification.', 11, 1, '2026-08-26 19:34:11', '2026-08-26 19:34:11'),
(488, 5, 'module_quiz', 'm1', 'm1q5', 'MFS Foundations Knowledge Check', 'What is the main purpose of Monetary and Financial Statistics (MFS)?', 'Monetary and Financial Statistics (MFS) help explain the financial relationships within an economy by showing who holds financial assets, who has financial liabilities, and how money and financial resources move between institutional sectors. Understanding these foundations is essential before studying financial corporations, deposits, credit, and other monetary indicators.', 0, 1, '2026-08-28 11:10:10', '2026-08-28 11:10:10');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_settings`
--

CREATE TABLE `assessment_settings` (
  `courseId` int(10) UNSIGNED NOT NULL,
  `questionsPerAttempt` smallint(5) UNSIGNED NOT NULL DEFAULT 20,
  `passMark` decimal(5,2) NOT NULL DEFAULT 80.00,
  `minutes` smallint(5) UNSIGNED NOT NULL DEFAULT 20,
  `intro` text DEFAULT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_settings`
--

INSERT INTO `assessment_settings` (`courseId`, `questionsPerAttempt`, `passMark`, `minutes`, `intro`, `updatedAt`) VALUES
(1, 20, 80.00, 20, 'This assessment draws on all modules. Each attempt serves a randomly selected 20 questions from a bank of 60, with a countdown timer. Passing score is 80%.', '2026-08-26 19:30:35'),
(2, 20, 75.00, 20, 'This assessment has 46 questions in its bank; you will be asked a randomly selected 20. The question order and the answer options are shuffled on every attempt, so refreshing or retaking the assessment mixes in new questions. You need 75% to pass and earn your certificate.', '2026-08-26 19:30:35'),
(3, 20, 75.00, 20, 'This assessment has 40 questions in its bank; you will be asked a randomly selected 20, with a 20-minute time limit. The question order and the answer options are shuffled on every attempt, so refreshing or retaking the assessment mixes in new questions. You need 75% to pass and earn your certificate.', '2026-08-26 19:30:35'),
(4, 20, 75.00, 20, 'This assessment has 30 questions in its bank; you will be asked a randomly selected 20. The question order and the answer options are shuffled on every attempt, so refreshing or retaking the assessment mixes in new questions. You need 75% to pass and earn your certificate.', '2026-08-26 19:30:35'),
(5, 20, 75.00, 20, 'This assessment has 43 questions in its bank; you will be asked a randomly selected 20, with a 20-minute time limit. The question order and the answer options are shuffled on every attempt, so refreshing or retaking the assessment mixes in new questions. You need 75% to pass and earn your certificate.', '2026-08-26 19:30:35'),
(6, 20, 75.00, 20, 'This assessment covers all six modules. Choose the single best answer for each question. You need {pass}% to pass and receive your certificate. Questions and options are shuffled, and you can retake the test if needed.', '2026-08-26 19:30:35'),
(7, 20, 75.00, 20, 'This assessment has 37 questions in its bank; you will be asked a randomly selected 20. The question order and the answer options are shuffled on every attempt, so a retake will mix in new questions. You need 75% to pass and earn your certificate.', '2026-08-26 19:30:35'),
(23, 20, 80.00, 20, '', '2026-08-28 11:49:08');

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

--
-- Dumping data for table `audit_logs`
--


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

INSERT INTO `courses` (`id`, `slug`, `title`, `description`, `category`, `difficulty`, `duration`, `contentPath`, `icon`, `rating`, `studentCount`, `publicationStatus`, `createdAt`) VALUES
(1, 'fns', 'Food and Nutrition Security', 'Statistical methods for agriculture and food security analysis across EAC partner states.', 'Agriculture', 'Intermediate', '4 weeks', 'courses/agriculture.php', 'book', 4.50, 3, 'published', '2026-08-13 12:24:46'),
(2, 'fsi', 'Financial Sector Indicators', 'Core indicators for monitoring financial sector stability and development in the EAC region.', 'Finance', 'Advanced', '4 weeks', 'courses/fsi.php', 'fa-chart-line', 4.50, 6, 'published', '2026-08-13 12:24:46'),
(3, 'gfs', 'Government Finance Statistics', 'Compilation and analysis of government revenue, expenditure, and fiscal balances.', 'Public Finance', 'Intermediate', '5 weeks', 'courses/gfs.php', 'fa-landmark', 4.50, 2, 'published', '2026-08-13 12:24:46'),
(4, 'psds', 'Public Sector Debt Statistics', 'Standards and practices for measuring and reporting public sector debt.', 'Public Finance', 'Advanced', '4 weeks', 'courses/psds.php', 'fa-file-invoice-dollar', 4.50, 2, 'published', '2026-08-13 12:24:46'),
(5, 'mfs', 'Monetary and Financial Statistics', 'Framework for monetary aggregates, credit, and financial market statistics.', 'Finance', 'Intermediate', '5 weeks', 'courses/mfs.php', 'book', 4.50, 5, 'published', '2026-08-13 12:24:46'),
(6, 'poverty', 'Poverty Statistics', 'Methodologies for poverty measurement, inequality analysis, and social indicators.', 'Social Statistics', 'Beginner', '4 weeks', 'courses/poverty.php', 'fa-users', 4.50, 1, 'published', '2026-08-13 12:24:46'),
(7, 'ess', 'External Sector Statistics', 'Balance of payments, international investment position, and trade statistics.', 'International Trade', 'Advanced', '5 weeks', 'courses/ess.php', 'fa-globe-africa', 4.50, 4, 'published', '2026-08-13 12:24:46'),
(23, 'population-and-demographic-statistics', 'Population and Demographic Statistics', 'Learn the fundamental concepts, methods, indicators, and data sources used in population and demographic statistics across East African Community Partner States. The course covers population structure, fertility, mortality, migration, censuses, surveys, and demographic indicators.', 'Population & Demography', 'Beginner', '6 weeks', 'courses/population-and-demographic-statistics.php', 'book', 4.50, 1, 'published', '2026-08-28 10:32:41');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Dumping data for table `course_progress`
--


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
-- Indexes for table `assessment_attempts`
--
ALTER TABLE `assessment_attempts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_assessment_attempt_token` (`tokenHash`),
  ADD KEY `idx_assessment_attempt_user_course` (`userId`,`courseId`,`submittedAt`),
  ADD KEY `idx_assessment_attempt_expiry` (`expiresAt`),
  ADD KEY `fk_assessment_attempt_course` (`courseId`);

--
-- Indexes for table `assessment_options`
--
ALTER TABLE `assessment_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_assessment_options_question` (`questionId`,`sortOrder`);

--
-- Indexes for table `assessment_questions`
--
ALTER TABLE `assessment_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_assessment_questions_course_type` (`courseId`,`questionType`,`isActive`,`sortOrder`),
  ADD KEY `idx_assessment_questions_quiz_key` (`courseId`,`quizKey`);

--
-- Indexes for table `assessment_settings`
--
ALTER TABLE `assessment_settings`
  ADD PRIMARY KEY (`courseId`);

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
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_courses_publication_status` (`publicationStatus`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assessment_attempts`
--
ALTER TABLE `assessment_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `assessment_options`
--
ALTER TABLE `assessment_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1969;

--
-- AUTO_INCREMENT for table `assessment_questions`
--
ALTER TABLE `assessment_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=489;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `course_feedback`
--
ALTER TABLE `course_feedback`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_progress`
--
ALTER TABLE `course_progress`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=793;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `learning_streaks`
--
ALTER TABLE `learning_streaks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievements`
--
ALTER TABLE `achievements`
  ADD CONSTRAINT `fk_achievement_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_attempts`
--
ALTER TABLE `assessment_attempts`
  ADD CONSTRAINT `fk_assessment_attempt_course` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_assessment_attempt_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assessment_options`
--
ALTER TABLE `assessment_options`
  ADD CONSTRAINT `fk_assessment_options_question` FOREIGN KEY (`questionId`) REFERENCES `assessment_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assessment_questions`
--
ALTER TABLE `assessment_questions`
  ADD CONSTRAINT `fk_assessment_questions_course` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assessment_settings`
--
ALTER TABLE `assessment_settings`
  ADD CONSTRAINT `fk_assessment_settings_course` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `eac_cleanup_inactive_student_accounts` ON SCHEDULE EVERY 1 DAY STARTS '2026-08-28 14:55:03' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM users
  WHERE role = 'student'
    AND COALESCE(lastLoginAt, createdAt) < (NOW() - INTERVAL 31 DAY)$$

CREATE DEFINER=`root`@`localhost` EVENT `eac_cleanup_revoked_sessions` ON SCHEDULE EVERY 1 DAY STARTS '2026-08-28 14:55:03' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM user_sessions
  WHERE revokedAt IS NOT NULL
    AND revokedAt < (NOW() - INTERVAL 31 DAY)$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- Non-destructive upgrade for the EAC Statistics e-Learning Platform.
-- Run after data/eac_stats_elearning.sql when upgrading an existing installation.
SET NAMES utf8mb4;

ALTER TABLE users ADD COLUMN IF NOT EXISTS firstName VARCHAR(120) NULL AFTER fullName;
ALTER TABLE users ADD COLUMN IF NOT EXISTS middleName VARCHAR(120) NULL AFTER firstName;
ALTER TABLE users ADD COLUMN IF NOT EXISTS surname VARCHAR(120) NULL AFTER middleName;
ALTER TABLE users ADD COLUMN IF NOT EXISTS sex VARCHAR(30) NULL AFTER surname;
ALTER TABLE users ADD COLUMN IF NOT EXISTS sector VARCHAR(150) NULL AFTER organization;
ALTER TABLE users ADD COLUMN IF NOT EXISTS country VARCHAR(100) NULL AFTER sector;
ALTER TABLE users ADD COLUMN IF NOT EXISTS jobTitle VARCHAR(180) NULL AFTER country;

CREATE TABLE IF NOT EXISTS notifications (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  userId INT UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  type VARCHAR(40) NOT NULL DEFAULT 'info',
  readAt DATETIME NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_notification_user (userId, readAt, createdAt),
  CONSTRAINT fk_notification_user FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS password_resets (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  userId INT UNSIGNED NOT NULL,
  tokenHash CHAR(64) NOT NULL,
  expiresAt DATETIME NOT NULL,
  usedAt DATETIME NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_password_reset_token (tokenHash),
  KEY idx_password_reset_user (userId, expiresAt),
  CONSTRAINT fk_password_reset_user FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS audit_logs (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  userId INT UNSIGNED NULL,
  action VARCHAR(100) NOT NULL,
  entityType VARCHAR(80) NULL,
  entityId INT UNSIGNED NULL,
  details JSON NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_audit_created (createdAt),
  KEY idx_audit_user (userId),
  CONSTRAINT fk_audit_user FOREIGN KEY (userId) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS course_feedback (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  userId INT UNSIGNED NOT NULL,
  courseId INT UNSIGNED NOT NULL,
  rating TINYINT UNSIGNED NOT NULL,
  comment TEXT NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updatedAt TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_feedback_user_course (userId, courseId),
  CONSTRAINT fk_feedback_user FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_feedback_course FOREIGN KEY (courseId) REFERENCES courses(id) ON DELETE CASCADE,
  CONSTRAINT chk_feedback_rating CHECK (rating BETWEEN 1 AND 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
-- Server-owned assessment sessions.
-- Each generated final-assessment token is single-use and expires at the
-- course-configured assessment deadline.

CREATE TABLE IF NOT EXISTS assessment_attempts (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  userId INT(10) UNSIGNED NOT NULL,
  courseId INT(10) UNSIGNED NOT NULL,
  tokenHash CHAR(64) NOT NULL,
  startedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  expiresAt DATETIME NOT NULL,
  submittedAt DATETIME NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_assessment_attempt_token (tokenHash),
  KEY idx_assessment_attempt_user_course (userId, courseId, submittedAt),
  KEY idx_assessment_attempt_expiry (expiresAt),
  CONSTRAINT fk_assessment_attempt_user
    FOREIGN KEY (userId) REFERENCES users(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_assessment_attempt_course
    FOREIGN KEY (courseId) REFERENCES courses(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- EAC Statistics e-Learning
-- Move built-in course launch paths to the shared course architecture.
UPDATE courses SET contentPath='courses/agriculture.php' WHERE id=1;
UPDATE courses SET contentPath='courses/fsi.php' WHERE id=2;
UPDATE courses SET contentPath='courses/gfs.php' WHERE id=3;
UPDATE courses SET contentPath='courses/psds.php' WHERE id=4;
UPDATE courses SET contentPath='courses/mfs.php' WHERE id=5;
UPDATE courses SET contentPath='courses/poverty.php' WHERE id=6;
UPDATE courses SET contentPath='courses/ess.php' WHERE id=7;
-- Integrity and security indexes for the EAC Statistics e-Learning platform.
-- This migration does not delete users, courses, or progress.

SET @db := DATABASE();

-- Remove duplicate enrollment rows while keeping the oldest record.
DELETE e1 FROM enrollments e1
JOIN enrollments e2
  ON e1.userId = e2.userId
 AND e1.courseId = e2.courseId
 AND e1.id > e2.id;

-- Add a unique enrollment constraint only if it does not already exist.
SET @idx_exists := (
  SELECT COUNT(*)
  FROM information_schema.statistics
  WHERE table_schema = @db
    AND table_name = 'enrollments'
    AND index_name = 'uq_enrollment_user_course'
);

SET @sql := IF(
  @idx_exists = 0,
  'ALTER TABLE enrollments ADD UNIQUE KEY uq_enrollment_user_course (userId, courseId)',
  'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Useful lookup indexes.
SET @idx_exists := (
  SELECT COUNT(*)
  FROM information_schema.statistics
  WHERE table_schema = @db
    AND table_name = 'course_progress'
    AND index_name = 'idx_course_progress_updated'
);
SET @sql := IF(
  @idx_exists = 0,
  'ALTER TABLE course_progress ADD KEY idx_course_progress_updated (updatedAt)',
  'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
-- EAC Statistics e-Learning
-- Adds non-destructive administration fields for the course publishing workflow.
-- Existing courses remain published so learners do not lose access after upgrade.

SET @db := DATABASE();

SET @column_exists := (
  SELECT COUNT(*)
  FROM information_schema.columns
  WHERE table_schema = @db
    AND table_name = 'courses'
    AND column_name = 'publicationStatus'
);

SET @sql := IF(
  @column_exists = 0,
  'ALTER TABLE courses ADD COLUMN publicationStatus ENUM(''draft'',''published'',''archived'') NOT NULL DEFAULT ''published'' AFTER studentCount',
  'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @index_exists := (
  SELECT COUNT(*)
  FROM information_schema.statistics
  WHERE table_schema = @db
    AND table_name = 'courses'
    AND index_name = 'idx_courses_publication_status'
);

SET @sql := IF(
  @index_exists = 0,
  'ALTER TABLE courses ADD KEY idx_courses_publication_status (publicationStatus)',
  'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
-- EAC Statistics e-Learning account retention + persistent sessions.
-- Policy:
--   * Authenticated sessions do not expire automatically.
--   * A session ends when the user signs out, the session is revoked,
--     or the account is deleted by the inactivity policy.
--   * Accounts with no activity for 31 days are deleted automatically.
--     "Activity" means a successful authenticated request/login.
--     A newly registered account with no authenticated use is therefore
--     eligible for deletion 31 days after creation.

SET @db := DATABASE();

-- Track last authenticated activity.
SET @exists := (
    SELECT COUNT(*) FROM information_schema.columns
    WHERE table_schema=@db AND table_name='users' AND column_name='lastLoginAt'
);
SET @sql := IF(
    @exists=0,
    'ALTER TABLE users ADD COLUMN lastLoginAt TIMESTAMP NULL DEFAULT NULL AFTER updatedAt',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Server-side sessions. No expiresAt column by design.
CREATE TABLE IF NOT EXISTS user_sessions (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    userId INT(10) UNSIGNED NOT NULL,
    tokenHash CHAR(64) NOT NULL,
    createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    lastActivityAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    revokedAt TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_user_session_token (tokenHash),
    KEY idx_user_sessions_user (userId),
    KEY idx_user_sessions_active (revokedAt),
    CONSTRAINT fk_user_sessions_user
        FOREIGN KEY (userId) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Delete inactive accounts daily.
-- Never delete administrators/instructors automatically.
DROP EVENT IF EXISTS eac_cleanup_inactive_student_accounts;
CREATE EVENT eac_cleanup_inactive_student_accounts
ON SCHEDULE EVERY 1 DAY
STARTS (CURRENT_TIMESTAMP + INTERVAL 1 DAY)
DO
  DELETE FROM users
  WHERE role = 'student'
    AND COALESCE(lastLoginAt, createdAt) < (NOW() - INTERVAL 31 DAY);

-- Remove revoked sessions periodically.
DROP EVENT IF EXISTS eac_cleanup_revoked_sessions;
CREATE EVENT eac_cleanup_revoked_sessions
ON SCHEDULE EVERY 1 DAY
STARTS (CURRENT_TIMESTAMP + INTERVAL 1 DAY)
DO
  DELETE FROM user_sessions
  WHERE revokedAt IS NOT NULL
    AND revokedAt < (NOW() - INTERVAL 31 DAY);

-- NOTE: MariaDB/MySQL must have the Event Scheduler enabled for the
-- automatic daily events above:
-- SET GLOBAL event_scheduler = ON;
-- Database-authored module quizzes and final assessments.
-- Safe to run more than once.

CREATE TABLE IF NOT EXISTS assessment_settings (
  courseId INT(10) UNSIGNED NOT NULL,
  questionsPerAttempt SMALLINT UNSIGNED NOT NULL DEFAULT 20,
  passMark DECIMAL(5,2) NOT NULL DEFAULT 80.00,
  minutes SMALLINT UNSIGNED NOT NULL DEFAULT 20,
  intro TEXT NULL,
  updatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (courseId),
  CONSTRAINT fk_assessment_settings_course FOREIGN KEY (courseId) REFERENCES courses(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS assessment_questions (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  courseId INT(10) UNSIGNED NOT NULL,
  questionType ENUM('module_quiz','final') NOT NULL,
  moduleId VARCHAR(100) NULL,
  quizKey VARCHAR(100) NULL,
  title VARCHAR(255) NULL,
  questionText TEXT NOT NULL,
  explanation TEXT NULL,
  sortOrder INT NOT NULL DEFAULT 0,
  isActive TINYINT(1) NOT NULL DEFAULT 1,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_assessment_questions_course_type (courseId, questionType, isActive, sortOrder),
  KEY idx_assessment_questions_quiz_key (courseId, quizKey),
  CONSTRAINT fk_assessment_questions_course FOREIGN KEY (courseId) REFERENCES courses(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS assessment_options (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  questionId BIGINT UNSIGNED NOT NULL,
  optionText TEXT NOT NULL,
  isCorrect TINYINT(1) NOT NULL DEFAULT 0,
  sortOrder SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  KEY idx_assessment_options_question (questionId, sortOrder),
  CONSTRAINT fk_assessment_options_question FOREIGN KEY (questionId) REFERENCES assessment_questions(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
