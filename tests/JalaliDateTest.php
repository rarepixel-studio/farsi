<?php
namespace OpiloTest\Farsi;

use Opilo\Farsi\JalaliDate;
use PHPUnit_Framework_TestCase;

class JalaliDateTest extends PHPUnit_Framework_TestCase
{
    public function test_leap_years()
    {
        $this->assertTrue(JalaliDate::isLeapYear(9));
        $this->assertTrue(JalaliDate::isLeapYear(558));
        $this->assertTrue(JalaliDate::isLeapYear(1375));
        $this->assertTrue(JalaliDate::isLeapYear(1478));


        $this->assertTrue(JalaliDate::isLeapYear(1379));
        $this->assertTrue(JalaliDate::isLeapYear(1383));
        $this->assertTrue(JalaliDate::isLeapYear(1387));
        $this->assertTrue(JalaliDate::isLeapYear(1391));


        $this->assertFalse(JalaliDate::isLeapYear(10));
        $this->assertFalse(JalaliDate::isLeapYear(560));
        $this->assertFalse(JalaliDate::isLeapYear(1378));
        $this->assertFalse(JalaliDate::isLeapYear(1477));


        $this->assertFalse(JalaliDate::isLeapYear(1380));
        $this->assertFalse(JalaliDate::isLeapYear(1384));
        $this->assertFalse(JalaliDate::isLeapYear(1388));
        $this->assertFalse(JalaliDate::isLeapYear(1392));
    }

    public function test_day_of_year()
    {
        $this->assertSame(1, (new JalaliDate(2000, 1, 1))->dayOfYear());
        $this->assertSame(365, (new JalaliDate(1000, 12, 29))->dayOfYear());
        $this->assertSame(62, (new JalaliDate(2000, 2, 31))->dayOfYear());
        $this->assertSame(92, (new JalaliDate(2000, 3, 30))->dayOfYear());
        $this->assertSame(366, (new JalaliDate(1375, 12, 30))->dayOfYear());
    }

    public function test_number_of_leap_years_past()
    {
        $this->assertEquals(0, (new JalaliDatePublicized(4, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(1, (new JalaliDatePublicized(5, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(1, (new JalaliDatePublicized(9, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(2, (new JalaliDatePublicized(10, 1, 1))->publicNumberOfLeapYearsPast());

        $this->assertEquals(0, (new JalaliDatePublicized(4, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(1, (new JalaliDatePublicized(9, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(2, (new JalaliDatePublicized(13, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(3, (new JalaliDatePublicized(17, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(4, (new JalaliDatePublicized(21, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(5, (new JalaliDatePublicized(25, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(6, (new JalaliDatePublicized(29, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(7, (new JalaliDatePublicized(33, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(8, (new JalaliDatePublicized(37, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(9, (new JalaliDatePublicized(42, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(10, (new JalaliDatePublicized(46, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(11, (new JalaliDatePublicized(50, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(12, (new JalaliDatePublicized(54, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(13, (new JalaliDatePublicized(58, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(14, (new JalaliDatePublicized(62, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(15, (new JalaliDatePublicized(66, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(16, (new JalaliDatePublicized(71, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(17, (new JalaliDatePublicized(75, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(18, (new JalaliDatePublicized(79, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(19, (new JalaliDatePublicized(83, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(20, (new JalaliDatePublicized(87, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(21, (new JalaliDatePublicized(91, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(22, (new JalaliDatePublicized(95, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(23, (new JalaliDatePublicized(99, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(24, (new JalaliDatePublicized(104, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(25, (new JalaliDatePublicized(108, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(26, (new JalaliDatePublicized(112, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(27, (new JalaliDatePublicized(116, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(28, (new JalaliDatePublicized(120, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(29, (new JalaliDatePublicized(124, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(30, (new JalaliDatePublicized(128, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(31, (new JalaliDatePublicized(132, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(32, (new JalaliDatePublicized(137, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(33, (new JalaliDatePublicized(141, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(34, (new JalaliDatePublicized(145, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(35, (new JalaliDatePublicized(149, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(36, (new JalaliDatePublicized(153, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(37, (new JalaliDatePublicized(157, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(38, (new JalaliDatePublicized(161, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(39, (new JalaliDatePublicized(165, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(40, (new JalaliDatePublicized(170, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(41, (new JalaliDatePublicized(174, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(42, (new JalaliDatePublicized(178, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(43, (new JalaliDatePublicized(182, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(44, (new JalaliDatePublicized(186, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(45, (new JalaliDatePublicized(190, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(46, (new JalaliDatePublicized(194, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(47, (new JalaliDatePublicized(198, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(48, (new JalaliDatePublicized(203, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(49, (new JalaliDatePublicized(207, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(50, (new JalaliDatePublicized(211, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(51, (new JalaliDatePublicized(215, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(52, (new JalaliDatePublicized(219, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(53, (new JalaliDatePublicized(223, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(54, (new JalaliDatePublicized(227, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(55, (new JalaliDatePublicized(231, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(56, (new JalaliDatePublicized(236, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(57, (new JalaliDatePublicized(240, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(58, (new JalaliDatePublicized(244, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(59, (new JalaliDatePublicized(248, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(60, (new JalaliDatePublicized(252, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(61, (new JalaliDatePublicized(256, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(62, (new JalaliDatePublicized(260, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(63, (new JalaliDatePublicized(264, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(64, (new JalaliDatePublicized(269, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(65, (new JalaliDatePublicized(273, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(66, (new JalaliDatePublicized(277, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(67, (new JalaliDatePublicized(281, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(68, (new JalaliDatePublicized(285, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(69, (new JalaliDatePublicized(289, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(70, (new JalaliDatePublicized(293, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(71, (new JalaliDatePublicized(297, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(72, (new JalaliDatePublicized(302, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(73, (new JalaliDatePublicized(306, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(74, (new JalaliDatePublicized(310, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(75, (new JalaliDatePublicized(314, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(76, (new JalaliDatePublicized(318, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(77, (new JalaliDatePublicized(322, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(78, (new JalaliDatePublicized(326, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(79, (new JalaliDatePublicized(331, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(80, (new JalaliDatePublicized(335, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(81, (new JalaliDatePublicized(339, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(82, (new JalaliDatePublicized(343, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(83, (new JalaliDatePublicized(347, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(84, (new JalaliDatePublicized(351, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(85, (new JalaliDatePublicized(355, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(86, (new JalaliDatePublicized(359, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(87, (new JalaliDatePublicized(364, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(88, (new JalaliDatePublicized(368, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(89, (new JalaliDatePublicized(372, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(90, (new JalaliDatePublicized(376, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(91, (new JalaliDatePublicized(380, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(92, (new JalaliDatePublicized(384, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(93, (new JalaliDatePublicized(388, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(94, (new JalaliDatePublicized(392, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(95, (new JalaliDatePublicized(397, 1, 1))->publicNumberOfLeapYearsPast());

        $this->assertEquals(0, (new JalaliDatePublicized(3, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(1, (new JalaliDatePublicized(8, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(2, (new JalaliDatePublicized(12, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(3, (new JalaliDatePublicized(16, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(4, (new JalaliDatePublicized(20, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(5, (new JalaliDatePublicized(24, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(6, (new JalaliDatePublicized(28, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(7, (new JalaliDatePublicized(32, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(8, (new JalaliDatePublicized(36, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(9, (new JalaliDatePublicized(41, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(10, (new JalaliDatePublicized(45, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(11, (new JalaliDatePublicized(49, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(12, (new JalaliDatePublicized(53, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(13, (new JalaliDatePublicized(57, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(14, (new JalaliDatePublicized(61, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(15, (new JalaliDatePublicized(65, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(16, (new JalaliDatePublicized(70, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(17, (new JalaliDatePublicized(74, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(18, (new JalaliDatePublicized(78, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(19, (new JalaliDatePublicized(82, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(20, (new JalaliDatePublicized(86, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(21, (new JalaliDatePublicized(90, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(22, (new JalaliDatePublicized(94, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(23, (new JalaliDatePublicized(98, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(24, (new JalaliDatePublicized(103, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(25, (new JalaliDatePublicized(107, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(26, (new JalaliDatePublicized(111, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(27, (new JalaliDatePublicized(115, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(28, (new JalaliDatePublicized(119, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(29, (new JalaliDatePublicized(123, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(30, (new JalaliDatePublicized(127, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(31, (new JalaliDatePublicized(131, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(32, (new JalaliDatePublicized(136, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(33, (new JalaliDatePublicized(140, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(34, (new JalaliDatePublicized(144, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(35, (new JalaliDatePublicized(148, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(36, (new JalaliDatePublicized(152, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(37, (new JalaliDatePublicized(156, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(38, (new JalaliDatePublicized(160, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(39, (new JalaliDatePublicized(164, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(40, (new JalaliDatePublicized(169, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(41, (new JalaliDatePublicized(173, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(42, (new JalaliDatePublicized(177, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(43, (new JalaliDatePublicized(181, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(44, (new JalaliDatePublicized(185, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(45, (new JalaliDatePublicized(189, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(46, (new JalaliDatePublicized(193, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(47, (new JalaliDatePublicized(197, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(48, (new JalaliDatePublicized(202, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(49, (new JalaliDatePublicized(206, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(50, (new JalaliDatePublicized(210, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(51, (new JalaliDatePublicized(214, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(52, (new JalaliDatePublicized(218, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(53, (new JalaliDatePublicized(222, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(54, (new JalaliDatePublicized(226, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(55, (new JalaliDatePublicized(230, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(56, (new JalaliDatePublicized(235, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(57, (new JalaliDatePublicized(239, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(58, (new JalaliDatePublicized(243, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(59, (new JalaliDatePublicized(247, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(60, (new JalaliDatePublicized(251, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(61, (new JalaliDatePublicized(255, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(62, (new JalaliDatePublicized(259, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(63, (new JalaliDatePublicized(263, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(64, (new JalaliDatePublicized(268, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(65, (new JalaliDatePublicized(272, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(66, (new JalaliDatePublicized(276, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(67, (new JalaliDatePublicized(280, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(68, (new JalaliDatePublicized(284, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(69, (new JalaliDatePublicized(288, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(70, (new JalaliDatePublicized(292, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(71, (new JalaliDatePublicized(296, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(72, (new JalaliDatePublicized(301, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(73, (new JalaliDatePublicized(305, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(74, (new JalaliDatePublicized(309, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(75, (new JalaliDatePublicized(313, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(76, (new JalaliDatePublicized(317, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(77, (new JalaliDatePublicized(321, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(78, (new JalaliDatePublicized(325, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(79, (new JalaliDatePublicized(330, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(80, (new JalaliDatePublicized(334, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(81, (new JalaliDatePublicized(338, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(82, (new JalaliDatePublicized(342, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(83, (new JalaliDatePublicized(346, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(84, (new JalaliDatePublicized(350, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(85, (new JalaliDatePublicized(354, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(86, (new JalaliDatePublicized(358, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(87, (new JalaliDatePublicized(363, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(88, (new JalaliDatePublicized(367, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(89, (new JalaliDatePublicized(371, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(90, (new JalaliDatePublicized(375, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(91, (new JalaliDatePublicized(379, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(92, (new JalaliDatePublicized(383, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(93, (new JalaliDatePublicized(387, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(94, (new JalaliDatePublicized(391, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(95, (new JalaliDatePublicized(396, 1, 1))->publicNumberOfLeapYearsPast());

        $this->assertEquals(1, (new JalaliDatePublicized(5, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(2, (new JalaliDatePublicized(10, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(3, (new JalaliDatePublicized(14, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(4, (new JalaliDatePublicized(18, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(5, (new JalaliDatePublicized(22, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(6, (new JalaliDatePublicized(26, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(7, (new JalaliDatePublicized(30, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(8, (new JalaliDatePublicized(34, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(9, (new JalaliDatePublicized(38, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(10, (new JalaliDatePublicized(43, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(11, (new JalaliDatePublicized(47, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(12, (new JalaliDatePublicized(51, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(13, (new JalaliDatePublicized(55, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(14, (new JalaliDatePublicized(59, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(15, (new JalaliDatePublicized(63, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(16, (new JalaliDatePublicized(67, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(17, (new JalaliDatePublicized(72, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(18, (new JalaliDatePublicized(76, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(19, (new JalaliDatePublicized(80, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(20, (new JalaliDatePublicized(84, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(21, (new JalaliDatePublicized(88, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(22, (new JalaliDatePublicized(92, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(23, (new JalaliDatePublicized(96, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(24, (new JalaliDatePublicized(100, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(25, (new JalaliDatePublicized(105, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(26, (new JalaliDatePublicized(109, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(27, (new JalaliDatePublicized(113, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(28, (new JalaliDatePublicized(117, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(29, (new JalaliDatePublicized(121, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(30, (new JalaliDatePublicized(125, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(31, (new JalaliDatePublicized(129, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(32, (new JalaliDatePublicized(133, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(33, (new JalaliDatePublicized(138, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(34, (new JalaliDatePublicized(142, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(35, (new JalaliDatePublicized(146, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(36, (new JalaliDatePublicized(150, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(37, (new JalaliDatePublicized(154, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(38, (new JalaliDatePublicized(158, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(39, (new JalaliDatePublicized(162, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(40, (new JalaliDatePublicized(166, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(41, (new JalaliDatePublicized(171, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(42, (new JalaliDatePublicized(175, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(43, (new JalaliDatePublicized(179, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(44, (new JalaliDatePublicized(183, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(45, (new JalaliDatePublicized(187, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(46, (new JalaliDatePublicized(191, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(47, (new JalaliDatePublicized(195, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(48, (new JalaliDatePublicized(199, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(49, (new JalaliDatePublicized(204, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(50, (new JalaliDatePublicized(208, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(51, (new JalaliDatePublicized(212, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(52, (new JalaliDatePublicized(216, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(53, (new JalaliDatePublicized(220, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(54, (new JalaliDatePublicized(224, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(55, (new JalaliDatePublicized(228, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(56, (new JalaliDatePublicized(232, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(57, (new JalaliDatePublicized(237, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(58, (new JalaliDatePublicized(241, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(59, (new JalaliDatePublicized(245, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(60, (new JalaliDatePublicized(249, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(61, (new JalaliDatePublicized(253, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(62, (new JalaliDatePublicized(257, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(63, (new JalaliDatePublicized(261, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(64, (new JalaliDatePublicized(265, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(65, (new JalaliDatePublicized(270, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(66, (new JalaliDatePublicized(274, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(67, (new JalaliDatePublicized(278, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(68, (new JalaliDatePublicized(282, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(69, (new JalaliDatePublicized(286, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(70, (new JalaliDatePublicized(290, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(71, (new JalaliDatePublicized(294, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(72, (new JalaliDatePublicized(298, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(73, (new JalaliDatePublicized(303, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(74, (new JalaliDatePublicized(307, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(75, (new JalaliDatePublicized(311, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(76, (new JalaliDatePublicized(315, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(77, (new JalaliDatePublicized(319, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(78, (new JalaliDatePublicized(323, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(79, (new JalaliDatePublicized(327, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(80, (new JalaliDatePublicized(332, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(81, (new JalaliDatePublicized(336, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(82, (new JalaliDatePublicized(340, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(83, (new JalaliDatePublicized(344, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(84, (new JalaliDatePublicized(348, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(85, (new JalaliDatePublicized(352, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(86, (new JalaliDatePublicized(356, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(87, (new JalaliDatePublicized(360, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(88, (new JalaliDatePublicized(365, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(89, (new JalaliDatePublicized(369, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(90, (new JalaliDatePublicized(373, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(91, (new JalaliDatePublicized(377, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(92, (new JalaliDatePublicized(381, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(93, (new JalaliDatePublicized(385, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(94, (new JalaliDatePublicized(389, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(95, (new JalaliDatePublicized(393, 1, 1))->publicNumberOfLeapYearsPast());
        $this->assertEquals(96, (new JalaliDatePublicized(398, 1, 1))->publicNumberOfLeapYearsPast());
    }

    public function _testS()
    {
        JalaliDatePublicized::printLastDayOfFileYearLeaps();
    }
}

class JalaliDatePublicized extends JalaliDate
{

    public static function printLastDayOfFileYearLeaps()
    {
        for($i = 1; $i < count(static::$fiveLeapYears) - 1; $i++)
        {
            print((new static(static::$fiveLeapYears[$i], 12, 30))->toInteger() . "\n");
        }
    }

    public function publicNumberOfLeapYearsPast()
    {
        return parent::numberOfLeapYearsPast();
    }
}