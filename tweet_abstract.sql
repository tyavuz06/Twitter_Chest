-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 18 Mar 2017, 01:38:24
-- Sunucu sürümü: 10.1.16-MariaDB
-- PHP Sürümü: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `140dev`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tweet_abstract`
--

CREATE TABLE `tweet_abstract` (
  `id` int(11) NOT NULL,
  `hafta` int(11) NOT NULL,
  `il` int(11) NOT NULL,
  `takim` int(11) NOT NULL,
  `counter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `tweet_abstract`
--

INSERT INTO `tweet_abstract` (`id`, `hafta`, `il`, `takim`, `counter`) VALUES
(1, 1, 0, 999, 0),
(2, 1, 1, 999, 0),
(3, 1, 2, 999, 0),
(4, 1, 3, 999, 0),
(5, 1, 4, 2, 9),
(6, 1, 5, 13, 2),
(7, 1, 6, 3, 1),
(8, 1, 7, 1, 1),
(9, 1, 8, 999, 0),
(10, 1, 9, 999, 0),
(11, 1, 10, 999, 0),
(12, 1, 11, 999, 0),
(13, 1, 12, 999, 0),
(14, 1, 13, 999, 0),
(15, 1, 14, 999, 0),
(16, 1, 15, 999, 0),
(17, 1, 16, 999, 0),
(18, 1, 17, 999, 0),
(19, 1, 18, 999, 0),
(20, 1, 19, 999, 0),
(21, 1, 20, 5, 18),
(22, 1, 21, 999, 0),
(23, 1, 22, 999, 0),
(24, 1, 23, 999, 0),
(25, 1, 24, 3, 206),
(26, 1, 25, 999, 0),
(27, 1, 26, 3, 1),
(28, 1, 27, 999, 0),
(29, 1, 28, 999, 0),
(30, 1, 29, 1, 1),
(31, 1, 30, 1, 1),
(32, 1, 31, 999, 0),
(33, 1, 32, 4, 1),
(34, 1, 33, 3, 2),
(35, 1, 34, 999, 0),
(36, 1, 35, 2, 1),
(37, 1, 36, 999, 0),
(38, 1, 37, 999, 0),
(39, 1, 38, 3, 2),
(40, 1, 39, 3, 1),
(41, 1, 40, 999, 0),
(42, 1, 41, 2, 3),
(43, 1, 42, 999, 0),
(44, 1, 43, 1, 5),
(45, 1, 44, 999, 0),
(46, 1, 45, 999, 0),
(47, 1, 46, 999, 0),
(48, 1, 47, 1, 1),
(49, 1, 48, 999, 0),
(50, 1, 49, 999, 0),
(51, 1, 50, 999, 0),
(52, 1, 51, 999, 0),
(53, 1, 52, 3, 1),
(54, 1, 53, 8, 3),
(55, 1, 54, 999, 0),
(56, 1, 55, 999, 0),
(57, 1, 56, 999, 0),
(58, 1, 57, 999, 0),
(59, 1, 58, 2, 4),
(60, 1, 59, 999, 0),
(61, 1, 60, 999, 0),
(62, 1, 61, 999, 0),
(63, 1, 62, 999, 0),
(64, 1, 63, 999, 0),
(65, 1, 64, 2, 2),
(66, 1, 65, 999, 0),
(67, 1, 66, 999, 0),
(68, 1, 67, 999, 0),
(69, 1, 68, 999, 0),
(70, 1, 69, 999, 0),
(71, 1, 70, 999, 0),
(72, 1, 71, 1, 1),
(73, 1, 72, 1, 2),
(74, 1, 73, 999, 0),
(75, 1, 74, 999, 0),
(76, 1, 75, 999, 0),
(77, 1, 76, 999, 0),
(78, 1, 77, 999, 0),
(79, 1, 78, 1, 1),
(80, 1, 79, 999, 0),
(81, 1, 80, 999, 0),
(82, 2, 0, 999, 0),
(83, 2, 1, 999, 0),
(84, 2, 2, 999, 0),
(85, 2, 3, 999, 0),
(86, 2, 4, 1, 3),
(87, 2, 5, 12, 1),
(88, 2, 6, 999, 0),
(89, 2, 7, 999, 0),
(90, 2, 8, 999, 0),
(91, 2, 9, 999, 0),
(92, 2, 10, 999, 0),
(93, 2, 11, 999, 0),
(94, 2, 12, 999, 0),
(95, 2, 13, 999, 0),
(96, 2, 14, 999, 0),
(97, 2, 15, 999, 0),
(98, 2, 16, 999, 0),
(99, 2, 17, 999, 0),
(100, 2, 18, 999, 0),
(101, 2, 19, 999, 0),
(102, 2, 20, 2, 2),
(103, 2, 21, 999, 0),
(104, 2, 22, 999, 0),
(105, 2, 23, 999, 0),
(106, 2, 24, 3, 19),
(107, 2, 25, 999, 0),
(108, 2, 26, 999, 0),
(109, 2, 27, 999, 0),
(110, 2, 28, 999, 0),
(111, 2, 29, 999, 0),
(112, 2, 30, 999, 0),
(113, 2, 31, 999, 0),
(114, 2, 32, 1, 1),
(115, 2, 33, 13, 1),
(116, 2, 34, 999, 0),
(117, 2, 35, 999, 0),
(118, 2, 36, 999, 0),
(119, 2, 37, 1, 1),
(120, 2, 38, 999, 0),
(121, 2, 39, 1, 2),
(122, 2, 40, 999, 0),
(123, 2, 41, 1, 1),
(124, 2, 42, 999, 0),
(125, 2, 43, 999, 0),
(126, 2, 44, 999, 0),
(127, 2, 45, 999, 0),
(128, 2, 46, 999, 0),
(129, 2, 47, 1, 1),
(130, 2, 48, 999, 0),
(131, 2, 49, 999, 0),
(132, 2, 50, 999, 0),
(133, 2, 51, 999, 0),
(134, 2, 52, 999, 0),
(135, 2, 53, 999, 0),
(136, 2, 54, 999, 0),
(137, 2, 55, 999, 0),
(138, 2, 56, 1, 1),
(139, 2, 57, 999, 0),
(140, 2, 58, 999, 0),
(141, 2, 59, 999, 0),
(142, 2, 60, 999, 0),
(143, 2, 61, 999, 0),
(144, 2, 62, 999, 0),
(145, 2, 63, 999, 0),
(146, 2, 64, 999, 0),
(147, 2, 65, 999, 0),
(148, 2, 66, 999, 0),
(149, 2, 67, 999, 0),
(150, 2, 68, 999, 0),
(151, 2, 69, 999, 0),
(152, 2, 70, 999, 0),
(153, 2, 71, 2, 1),
(154, 2, 72, 1, 1),
(155, 2, 73, 999, 0),
(156, 2, 74, 999, 0),
(157, 2, 75, 999, 0),
(158, 2, 76, 999, 0),
(159, 2, 77, 999, 0),
(160, 2, 78, 999, 0),
(161, 2, 79, 999, 0),
(162, 2, 80, 999, 0),
(163, 3, 0, 999, 0),
(164, 3, 1, 999, 0),
(165, 3, 2, 999, 0),
(166, 3, 3, 999, 0),
(167, 3, 4, 3, 1),
(168, 3, 5, 1, 1),
(169, 3, 6, 999, 0),
(170, 3, 7, 999, 0),
(171, 3, 8, 1, 2),
(172, 3, 9, 999, 0),
(173, 3, 10, 999, 0),
(174, 3, 11, 999, 0),
(175, 3, 12, 9, 1),
(176, 3, 13, 999, 0),
(177, 3, 14, 999, 0),
(178, 3, 15, 1, 1),
(179, 3, 16, 999, 0),
(180, 3, 17, 999, 0),
(181, 3, 18, 999, 0),
(182, 3, 19, 999, 0),
(183, 3, 20, 2, 6),
(184, 3, 21, 999, 0),
(185, 3, 22, 999, 0),
(186, 3, 23, 999, 0),
(187, 3, 24, 3, 96),
(188, 3, 25, 999, 0),
(189, 3, 26, 1, 1),
(190, 3, 27, 999, 0),
(191, 3, 28, 999, 0),
(192, 3, 29, 999, 0),
(193, 3, 30, 999, 0),
(194, 3, 31, 999, 0),
(195, 3, 32, 999, 0),
(196, 3, 33, 999, 0),
(197, 3, 34, 999, 0),
(198, 3, 35, 999, 0),
(199, 3, 36, 999, 0),
(200, 3, 37, 999, 0),
(201, 3, 38, 999, 0),
(202, 3, 39, 1, 1),
(203, 3, 40, 999, 0),
(204, 3, 41, 1, 1),
(205, 3, 42, 999, 0),
(206, 3, 43, 999, 0),
(207, 3, 44, 999, 0),
(208, 3, 45, 999, 0),
(209, 3, 46, 999, 0),
(210, 3, 47, 999, 0),
(211, 3, 48, 999, 0),
(212, 3, 49, 999, 0),
(213, 3, 50, 999, 0),
(214, 3, 51, 999, 0),
(215, 3, 52, 1, 1),
(216, 3, 53, 1, 1),
(217, 3, 54, 999, 0),
(218, 3, 55, 999, 0),
(219, 3, 56, 999, 0),
(220, 3, 57, 999, 0),
(221, 3, 58, 999, 0),
(222, 3, 59, 999, 0),
(223, 3, 60, 999, 0),
(224, 3, 61, 999, 0),
(225, 3, 62, 999, 0),
(226, 3, 63, 999, 0),
(227, 3, 64, 2, 1),
(228, 3, 65, 1, 1),
(229, 3, 66, 999, 0),
(230, 3, 67, 999, 0),
(231, 3, 68, 999, 0),
(232, 3, 69, 999, 0),
(233, 3, 70, 999, 0),
(234, 3, 71, 999, 0),
(235, 3, 72, 999, 0),
(236, 3, 73, 999, 0),
(237, 3, 74, 999, 0),
(238, 3, 75, 999, 0),
(239, 3, 76, 999, 0),
(240, 3, 77, 999, 0),
(241, 3, 78, 999, 0),
(242, 3, 79, 999, 0),
(243, 3, 80, 999, 0),
(244, 4, 0, 1, 2),
(245, 4, 1, 999, 0),
(246, 4, 2, 9, 1),
(247, 4, 3, 999, 0),
(248, 4, 4, 3, 4),
(249, 4, 5, 999, 0),
(250, 4, 6, 999, 0),
(251, 4, 7, 3, 1),
(252, 4, 8, 999, 0),
(253, 4, 9, 999, 0),
(254, 4, 10, 999, 0),
(255, 4, 11, 999, 0),
(256, 4, 12, 3, 1),
(257, 4, 13, 999, 0),
(258, 4, 14, 999, 0),
(259, 4, 15, 1, 1),
(260, 4, 16, 999, 0),
(261, 4, 17, 999, 0),
(262, 4, 18, 2, 1),
(263, 4, 19, 999, 0),
(264, 4, 20, 2, 45),
(265, 4, 21, 999, 0),
(266, 4, 22, 999, 0),
(267, 4, 23, 999, 0),
(268, 4, 24, 3, 130),
(269, 4, 25, 999, 0),
(270, 4, 26, 999, 0),
(271, 4, 27, 999, 0),
(272, 4, 28, 999, 0),
(273, 4, 29, 2, 1),
(274, 4, 30, 999, 0),
(275, 4, 31, 999, 0),
(276, 4, 32, 999, 0),
(277, 4, 33, 999, 0),
(278, 4, 34, 1, 1),
(279, 4, 35, 999, 0),
(280, 4, 36, 999, 0),
(281, 4, 37, 999, 0),
(282, 4, 38, 999, 0),
(283, 4, 39, 1, 2),
(284, 4, 40, 999, 0),
(285, 4, 41, 2, 2),
(286, 4, 42, 999, 0),
(287, 4, 43, 3, 2),
(288, 4, 44, 999, 0),
(289, 4, 45, 999, 0),
(290, 4, 46, 999, 0),
(291, 4, 47, 5, 1),
(292, 4, 48, 999, 0),
(293, 4, 49, 999, 0),
(294, 4, 50, 999, 0),
(295, 4, 51, 999, 0),
(296, 4, 52, 1, 1),
(297, 4, 53, 8, 1),
(298, 4, 54, 999, 0),
(299, 4, 55, 999, 0),
(300, 4, 56, 999, 0),
(301, 4, 57, 999, 0),
(302, 4, 58, 999, 0),
(303, 4, 59, 999, 0),
(304, 4, 60, 1, 1),
(305, 4, 61, 999, 0),
(306, 4, 62, 999, 0),
(307, 4, 63, 999, 0),
(308, 4, 64, 999, 0),
(309, 4, 65, 999, 0),
(310, 4, 66, 1, 1),
(311, 4, 67, 999, 0),
(312, 4, 68, 999, 0),
(313, 4, 69, 999, 0),
(314, 4, 70, 999, 0),
(315, 4, 71, 999, 0),
(316, 4, 72, 1, 1),
(317, 4, 73, 999, 0),
(318, 4, 74, 999, 0),
(319, 4, 75, 999, 0),
(320, 4, 76, 999, 0),
(321, 4, 77, 999, 0),
(322, 4, 78, 1, 1),
(323, 4, 79, 999, 0),
(324, 4, 80, 999, 0),
(325, 5, 0, 3, 49),
(326, 5, 1, 3, 4),
(327, 5, 2, 3, 8),
(328, 5, 3, 3, 2),
(329, 5, 4, 3, 258),
(330, 5, 5, 3, 105),
(331, 5, 6, 2, 3),
(332, 5, 7, 3, 28),
(333, 5, 8, 3, 7),
(334, 5, 9, 1, 15),
(335, 5, 10, 1, 2),
(336, 5, 11, 3, 8),
(337, 5, 12, 3, 50),
(338, 5, 13, 3, 12),
(339, 5, 14, 15, 2),
(340, 5, 15, 3, 4),
(341, 5, 16, 3, 2),
(342, 5, 17, 2, 1),
(343, 5, 18, 1, 9),
(344, 5, 19, 2, 3),
(345, 5, 20, 3, 131),
(346, 5, 21, 3, 108),
(347, 5, 22, 3, 97),
(348, 5, 23, 2, 10),
(349, 5, 24, 3, 1778),
(350, 5, 25, 3, 101),
(351, 5, 26, 3, 24),
(352, 5, 27, 1, 13),
(353, 5, 28, 3, 6),
(354, 5, 29, 2, 14),
(355, 5, 30, 2, 13),
(356, 5, 31, 3, 6),
(357, 5, 32, 3, 18),
(358, 5, 33, 3, 32),
(359, 5, 34, 3, 22),
(360, 5, 35, 3, 26),
(361, 5, 36, 3, 3),
(362, 5, 37, 999, 0),
(363, 5, 38, 2, 9),
(364, 5, 39, 3, 51),
(365, 5, 40, 1, 1),
(366, 5, 41, 3, 306),
(367, 5, 42, 3, 11),
(368, 5, 43, 3, 14),
(369, 5, 44, 3, 5),
(370, 5, 45, 2, 3),
(371, 5, 46, 2, 7),
(372, 5, 47, 3, 27),
(373, 5, 48, 999, 0),
(374, 5, 49, 3, 12),
(375, 5, 50, 3, 8),
(376, 5, 51, 2, 4),
(377, 5, 52, 3, 54),
(378, 5, 53, 3, 55),
(379, 5, 54, 2, 13),
(380, 5, 55, 3, 15),
(381, 5, 56, 3, 39),
(382, 5, 57, 3, 4),
(383, 5, 58, 3, 17),
(384, 5, 59, 999, 0),
(385, 5, 60, 1, 5),
(386, 5, 61, 1, 3),
(387, 5, 62, 3, 9),
(388, 5, 63, 1, 5),
(389, 5, 64, 3, 23),
(390, 5, 65, 3, 36),
(391, 5, 66, 3, 56),
(392, 5, 67, 3, 10),
(393, 5, 68, 1, 2),
(394, 5, 69, 3, 15),
(395, 5, 70, 2, 3),
(396, 5, 71, 3, 10),
(397, 5, 72, 3, 19),
(398, 5, 73, 3, 5),
(399, 5, 74, 4, 150),
(400, 5, 75, 2, 4),
(401, 5, 76, 3, 8),
(402, 5, 77, 2, 6),
(403, 5, 78, 1, 10),
(404, 5, 79, 3, 6),
(405, 5, 80, 3, 17),
(406, 6, 0, 1, 126),
(407, 6, 1, 3, 3),
(408, 6, 2, 3, 10),
(409, 6, 3, 3, 3),
(410, 6, 4, 3, 469),
(411, 6, 5, 3, 211),
(412, 6, 6, 3, 14),
(413, 6, 7, 1, 62),
(414, 6, 8, 1, 5),
(415, 6, 9, 3, 18),
(416, 6, 10, 1, 4),
(417, 6, 11, 4, 10),
(418, 6, 12, 1, 50),
(419, 6, 13, 2, 7),
(420, 6, 14, 1, 8),
(421, 6, 15, 1, 4),
(422, 6, 16, 1, 6),
(423, 6, 17, 1, 3),
(424, 6, 18, 1, 26),
(425, 6, 19, 1, 5),
(426, 6, 20, 5, 591),
(427, 6, 21, 1, 219),
(428, 6, 22, 1, 192),
(429, 6, 23, 1, 29),
(430, 6, 24, 3, 3265),
(431, 6, 25, 1, 197),
(432, 6, 26, 1, 56),
(433, 6, 27, 3, 23),
(434, 6, 28, 3, 22),
(435, 6, 29, 3, 24),
(436, 6, 30, 1, 27),
(437, 6, 31, 1, 7),
(438, 6, 32, 1, 28),
(439, 6, 33, 3, 50),
(440, 6, 34, 3, 41),
(441, 6, 35, 3, 37),
(442, 6, 36, 1, 12),
(443, 6, 37, 999, 0),
(444, 6, 38, 3, 38),
(445, 6, 39, 1, 106),
(446, 6, 40, 3, 3),
(447, 6, 41, 3, 583),
(448, 6, 42, 1, 23),
(449, 6, 43, 3, 27),
(450, 6, 44, 3, 6),
(451, 6, 45, 2, 4),
(452, 6, 46, 3, 16),
(453, 6, 47, 17, 136),
(454, 6, 48, 999, 0),
(455, 6, 49, 3, 9),
(456, 6, 50, 3, 8),
(457, 6, 51, 3, 9),
(458, 6, 52, 3, 111),
(459, 6, 53, 8, 230),
(460, 6, 54, 2, 30),
(461, 6, 55, 3, 33),
(462, 6, 56, 3, 38),
(463, 6, 57, 3, 11),
(464, 6, 58, 3, 25),
(465, 6, 59, 1, 4),
(466, 6, 60, 1, 9),
(467, 6, 61, 3, 8),
(468, 6, 62, 3, 32),
(469, 6, 63, 3, 26),
(470, 6, 64, 3, 40),
(471, 6, 65, 3, 67),
(472, 6, 66, 1, 112),
(473, 6, 67, 1, 21),
(474, 6, 68, 1, 4),
(475, 6, 69, 1, 10),
(476, 6, 70, 1, 2),
(477, 6, 71, 3, 31),
(478, 6, 72, 1, 50),
(479, 6, 73, 3, 17),
(480, 6, 74, 4, 830),
(481, 6, 75, 999, 0),
(482, 6, 76, 1, 14),
(483, 6, 77, 3, 12),
(484, 6, 78, 3, 19),
(485, 6, 79, 3, 7),
(486, 6, 80, 3, 29),
(487, 7, 0, 1, 59),
(488, 7, 1, 2, 5),
(489, 7, 2, 1, 5),
(490, 7, 3, 2, 2),
(491, 7, 4, 2, 209),
(492, 7, 5, 1, 112),
(493, 7, 6, 2, 3),
(494, 7, 7, 2, 20),
(495, 7, 8, 2, 6),
(496, 7, 9, 3, 9),
(497, 7, 10, 1, 2),
(498, 7, 11, 2, 10),
(499, 7, 12, 1, 27),
(500, 7, 13, 1, 4),
(501, 7, 14, 2, 5),
(502, 7, 15, 2, 2),
(503, 7, 16, 1, 2),
(504, 7, 17, 3, 2),
(505, 7, 18, 1, 10),
(506, 7, 19, 1, 6),
(507, 7, 20, 1, 133),
(508, 7, 21, 1, 130),
(509, 7, 22, 1, 122),
(510, 7, 23, 1, 12),
(511, 7, 24, 3, 1657),
(512, 7, 25, 1, 125),
(513, 7, 26, 1, 28),
(514, 7, 27, 1, 27),
(515, 7, 28, 3, 12),
(516, 7, 29, 2, 15),
(517, 7, 30, 2, 12),
(518, 7, 31, 2, 2),
(519, 7, 32, 3, 12),
(520, 7, 33, 2, 25),
(521, 7, 34, 2, 16),
(522, 7, 35, 2, 10),
(523, 7, 36, 1, 9),
(524, 7, 37, 999, 0),
(525, 7, 38, 3, 22),
(526, 7, 39, 2, 41),
(527, 7, 40, 3, 4),
(528, 7, 41, 2, 267),
(529, 7, 42, 1, 5),
(530, 7, 43, 3, 18),
(531, 7, 44, 1, 4),
(532, 7, 45, 2, 5),
(533, 7, 46, 2, 8),
(534, 7, 47, 17, 60),
(535, 7, 48, 2, 1),
(536, 7, 49, 3, 11),
(537, 7, 50, 2, 7),
(538, 7, 51, 3, 23),
(539, 7, 52, 2, 43),
(540, 7, 53, 8, 137),
(541, 7, 54, 2, 22),
(542, 7, 55, 2, 18),
(543, 7, 56, 1, 19),
(544, 7, 57, 1, 7),
(545, 7, 58, 2, 20),
(546, 7, 59, 3, 2),
(547, 7, 60, 1, 6),
(548, 7, 61, 2, 3),
(549, 7, 62, 2, 18),
(550, 7, 63, 1, 8),
(551, 7, 64, 1, 22),
(552, 7, 65, 2, 39),
(553, 7, 66, 1, 40),
(554, 7, 67, 1, 13),
(555, 7, 68, 3, 2),
(556, 7, 69, 2, 4),
(557, 7, 70, 999, 0),
(558, 7, 71, 1, 10),
(559, 7, 72, 2, 21),
(560, 7, 73, 1, 8),
(561, 7, 74, 4, 214),
(562, 7, 75, 1, 1),
(563, 7, 76, 1, 13),
(564, 7, 77, 1, 2),
(565, 7, 78, 2, 14),
(566, 7, 79, 1, 3),
(567, 7, 80, 3, 10),
(568, 8, 0, 1, 17),
(569, 8, 1, 999, 0),
(570, 8, 2, 1, 3),
(571, 8, 3, 999, 0),
(572, 8, 4, 1, 34),
(573, 8, 5, 1, 13),
(574, 8, 6, 1, 1),
(575, 8, 7, 1, 4),
(577, 8, 9, 1, 3),
(578, 8, 10, 1, 1),
(579, 8, 11, 1, 6),
(580, 8, 12, 1, 5),
(581, 8, 13, 3, 1),
(582, 8, 14, 999, 0),
(583, 8, 15, 3, 1),
(584, 8, 16, 1, 1),
(585, 8, 17, 999, 0),
(586, 8, 18, 1, 2),
(587, 8, 19, 1, 2),
(588, 8, 20, 1, 16),
(589, 8, 21, 1, 20),
(590, 8, 22, 1, 16),
(591, 8, 23, 1, 4),
(592, 8, 24, 1, 183),
(593, 8, 25, 1, 16),
(594, 8, 26, 1, 4),
(595, 8, 27, 2, 1),
(596, 8, 28, 999, 0),
(597, 8, 29, 2, 2),
(598, 8, 30, 1, 2),
(599, 8, 31, 999, 0),
(600, 8, 32, 1, 1),
(601, 8, 33, 1, 7),
(602, 8, 34, 1, 3),
(603, 8, 35, 4, 1),
(604, 8, 36, 999, 0),
(605, 8, 37, 999, 0),
(606, 8, 38, 1, 3),
(607, 8, 39, 2, 3),
(608, 8, 40, 999, 0),
(609, 8, 41, 1, 39),
(610, 8, 42, 1, 2),
(611, 8, 43, 3, 2),
(612, 8, 44, 2, 1),
(613, 8, 45, 999, 0),
(614, 8, 46, 1, 2),
(615, 8, 47, 1, 2),
(616, 8, 48, 999, 0),
(617, 8, 49, 999, 0),
(618, 8, 50, 999, 0),
(619, 8, 51, 999, 0),
(620, 8, 52, 1, 3),
(621, 8, 53, 1, 5),
(622, 8, 54, 1, 1),
(623, 8, 55, 1, 7),
(624, 8, 56, 1, 7),
(625, 8, 57, 3, 1),
(626, 8, 58, 1, 7),
(627, 8, 59, 999, 0),
(628, 8, 60, 2, 1),
(629, 8, 61, 1, 1),
(630, 8, 62, 999, 0),
(631, 8, 63, 1, 3),
(632, 8, 64, 1, 5),
(633, 8, 65, 3, 4),
(634, 8, 66, 1, 5),
(635, 8, 67, 1, 2),
(636, 8, 68, 999, 0),
(637, 8, 69, 999, 0),
(638, 8, 70, 999, 0),
(639, 8, 71, 999, 0),
(640, 8, 72, 1, 5),
(641, 8, 73, 3, 1),
(642, 8, 74, 4, 13),
(643, 8, 75, 999, 0),
(644, 8, 76, 1, 2),
(645, 8, 77, 999, 0),
(646, 8, 78, 1, 6),
(647, 8, 79, 3, 1),
(648, 8, 80, 1, 1),
(649, 8, 8, 999, 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `tweet_abstract`
--
ALTER TABLE `tweet_abstract`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `tweet_abstract`
--
ALTER TABLE `tweet_abstract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=650;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
