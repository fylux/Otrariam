-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 06-05-2013 a las 13:56:04
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `juego_navegador`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alianzas`
--

CREATE TABLE IF NOT EXISTS `alianzas` (
  `id_alianza` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `id_ciudad` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_alianza`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ataques`
--

CREATE TABLE IF NOT EXISTS `ataques` (
  `id_ataque` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `objetivo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_ciudad_atacante` int(11) unsigned NOT NULL,
  `id_ciudad_atacada` int(11) unsigned NOT NULL,
  `tropa1` int(11) unsigned NOT NULL,
  `tropa2` int(11) unsigned NOT NULL,
  `tropa3` int(11) unsigned NOT NULL,
  `tropa4` int(11) unsigned NOT NULL,
  `tropa5` int(11) unsigned NOT NULL,
  `tropa6` int(11) unsigned NOT NULL,
  `tropa7` int(11) unsigned NOT NULL,
  `tropa8` int(11) unsigned NOT NULL,
  `tropa9` int(11) unsigned NOT NULL,
  `tropa10` int(11) unsigned NOT NULL,
  `destruir` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_ataque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos_alianzas`
--

CREATE TABLE IF NOT EXISTS `cargos_alianzas` (
  `id_cargo` int(11) NOT NULL AUTO_INCREMENT,
  `cargo1` tinyint(1) NOT NULL,
  `cargo2` tinyint(1) NOT NULL,
  `cargo3` tinyint(1) NOT NULL,
  `cargo4` tinyint(1) NOT NULL,
  `cargo5` tinyint(1) NOT NULL,
  `cargo6` tinyint(1) NOT NULL,
  `cargo7` tinyint(1) NOT NULL,
  `cargo8` tinyint(1) NOT NULL,
  `cargo9` tinyint(1) NOT NULL,
  `cargo10` tinyint(1) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_alianza` int(11) NOT NULL,
  PRIMARY KEY (`id_cargo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cola_produccion`
--

CREATE TABLE IF NOT EXISTS `cola_produccion` (
  `id_produccion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tropa` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `n_tropas` int(11) unsigned NOT NULL,
  `n_tropas_reclutadas` int(11) unsigned NOT NULL,
  `id_ciudad` int(11) unsigned NOT NULL,
  `fecha` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_produccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costes_construcciones`
--

CREATE TABLE IF NOT EXISTS `costes_construcciones` (
  `id_costo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `edificio` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `nivel` int(11) unsigned NOT NULL,
  `produccion` double unsigned NOT NULL,
  `habitantes` int(11) unsigned NOT NULL,
  `madera` int(11) unsigned NOT NULL,
  `barro` int(11) unsigned NOT NULL,
  `hierro` int(11) unsigned NOT NULL,
  `cereal` int(11) unsigned NOT NULL,
  `tiempo` int(11) unsigned NOT NULL,
  `requisitos` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_costo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=213 ;

--
-- Volcado de datos para la tabla `costes_construcciones`
--

INSERT INTO `costes_construcciones` (`id_costo`, `edificio`, `nivel`, `produccion`, `habitantes`, `madera`, `barro`, `hierro`, `cereal`, `tiempo`, `requisitos`) VALUES
(49, 'barrera', 1, 4, 2, 30, 15, 30, 5, 172, ''),
(50, 'barrera', 2, 9, 4, 45, 23, 45, 10, 272, ''),
(51, 'barrera', 3, 14, 5, 55, 28, 55, 15, 344, ''),
(52, 'barrera', 4, 20, 7, 70, 35, 70, 20, 444, ''),
(53, 'barrera', 5, 27, 9, 100, 50, 100, 25, 622, ''),
(54, 'barrera', 6, 35, 12, 125, 63, 125, 30, 780, ''),
(55, 'barrera', 7, 44, 16, 145, 73, 145, 35, 916, ''),
(56, 'barrera', 8, 56, 20, 170, 85, 170, 40, 1082, ''),
(57, 'barrera', 9, 66, 26, 185, 93, 185, 45, 1200, ''),
(58, 'barrera', 10, 79, 30, 215, 108, 215, 50, 1394, ''),
(59, 'barrera', 11, 96, 39, 235, 118, 235, 65, 1576, ''),
(60, 'barrera', 12, 116, 45, 265, 133, 265, 70, 1788, ''),
(61, 'barrera', 13, 131, 50, 303, 152, 303, 75, 2028, ''),
(62, 'barrera', 14, 144, 56, 352, 176, 352, 80, 2320, ''),
(63, 'barrera', 15, 166, 63, 404, 202, 404, 85, 2648, ''),
(64, 'barrera', 16, 196, 70, 451, 226, 451, 90, 2968, ''),
(66, 'leñador', 1, 4, 2, 15, 38, 19, 5, 165, ''),
(67, 'leñador', 2, 9, 4, 23, 56, 28, 10, 261, ''),
(68, 'leñador', 3, 14, 5, 28, 69, 34, 15, 330, ''),
(69, 'leñador', 4, 20, 7, 35, 88, 44, 20, 427, ''),
(70, 'leñador', 5, 27, 9, 50, 125, 63, 25, 597, ''),
(71, 'leñador', 6, 35, 12, 63, 156, 78, 30, 749, ''),
(72, 'leñador', 7, 44, 16, 73, 181, 91, 35, 880, ''),
(73, 'leñador', 8, 56, 20, 85, 213, 106, 40, 1040, ''),
(74, 'leñador', 9, 66, 26, 93, 231, 116, 45, 1200, ''),
(75, 'leñador', 10, 79, 30, 108, 269, 134, 50, 1340, ''),
(76, 'leñador', 11, 96, 39, 118, 294, 147, 65, 1517, ''),
(77, 'leñador', 12, 116, 45, 133, 331, 116, 70, 1722, ''),
(78, 'leñador', 13, 131, 50, 152, 379, 189, 75, 1952, ''),
(79, 'leñador', 14, 144, 56, 176, 440, 220, 80, 2232, ''),
(80, 'leñador', 15, 166, 63, 202, 505, 253, 85, 2547, ''),
(81, 'leñador', 16, 196, 70, 226, 564, 282, 90, 2885, ''),
(122, 'mina', 1, 4, 2, 38, 30, 11, 5, 180, ''),
(123, 'mina', 2, 9, 4, 56, 45, 17, 10, 282, ''),
(124, 'mina', 3, 14, 5, 69, 55, 21, 15, 357, ''),
(125, 'mina', 4, 20, 7, 88, 70, 26, 20, 462, ''),
(126, 'mina', 5, 27, 9, 125, 100, 38, 25, 647, ''),
(127, 'mina', 6, 35, 12, 156, 125, 47, 30, 810, ''),
(128, 'mina', 7, 44, 16, 181, 145, 54, 35, 951, ''),
(129, 'mina', 8, 56, 20, 213, 170, 64, 40, 1125, ''),
(130, 'mina', 9, 66, 26, 231, 158, 69, 45, 1245, ''),
(131, 'mina', 10, 79, 30, 269, 215, 81, 50, 1447, ''),
(132, 'mina', 11, 96, 39, 294, 235, 88, 65, 1634, ''),
(133, 'mina', 12, 116, 45, 331, 265, 99, 70, 1853, ''),
(134, 'mina', 13, 131, 50, 379, 303, 114, 75, 2103, ''),
(135, 'mina', 14, 144, 56, 440, 352, 132, 80, 2408, ''),
(136, 'mina', 15, 166, 63, 505, 404, 152, 85, 2749, ''),
(137, 'mina', 16, 196, 70, 564, 451, 169, 90, 3080, ''),
(139, 'granja', 1, 4, 2, 30, 38, 15, 1, 179, ''),
(140, 'granja', 2, 9, 4, 45, 56, 23, 2, 279, ''),
(141, 'granja', 3, 14, 5, 55, 69, 28, 3, 348, ''),
(142, 'granja', 4, 20, 7, 70, 88, 35, 4, 447, ''),
(143, 'granja', 5, 27, 9, 100, 125, 50, 5, 632, ''),
(144, 'granja', 6, 35, 12, 125, 156, 63, 6, 795, ''),
(145, 'granja', 7, 44, 16, 145, 181, 73, 7, 933, ''),
(146, 'granja', 8, 56, 20, 170, 213, 85, 8, 1103, ''),
(147, 'granja', 9, 66, 26, 185, 231, 93, 9, 1221, ''),
(148, 'granja', 10, 79, 30, 215, 269, 108, 10, 1422, ''),
(149, 'granja', 11, 96, 39, 235, 294, 118, 11, 1586, ''),
(150, 'granja', 12, 116, 45, 265, 331, 133, 12, 1805, ''),
(151, 'granja', 13, 131, 50, 303, 379, 152, 13, 2056, ''),
(152, 'granja', 14, 144, 56, 352, 440, 176, 14, 2364, ''),
(153, 'granja', 15, 166, 63, 404, 505, 202, 15, 2710, ''),
(154, 'granja', 16, 196, 70, 451, 564, 226, 16, 3046, ''),
(155, 'almacen', 1, 1300, 3, 350, 290, 180, 30, 3230, ''),
(156, 'almacen', 2, 1700, 6, 600, 410, 300, 50, 4599, ''),
(157, 'almacen', 3, 2300, 10, 890, 630, 416, 100, 6519, ''),
(158, 'almacen', 4, 3000, 15, 1130, 800, 526, 135, 8409, ''),
(159, 'almacen', 5, 3900, 19, 1400, 1050, 780, 170, 10979, ''),
(160, 'almacen', 6, 4500, 26, 1850, 1325, 980, 200, 13322, ''),
(161, 'almacen', 7, 6000, 35, 2300, 1790, 1230, 270, 17438, ''),
(162, 'almacen', 8, 7900, 47, 2900, 2175, 1470, 300, 22188, ''),
(163, 'ayuntamiento', 1, 3, 6, 250, 320, 180, 10, 1538, ''),
(164, 'ayuntamiento', 2, 7, 15, 390, 500, 260, 20, 2384, ''),
(165, 'ayuntamiento', 3, 10, 23, 510, 720, 360, 45, 3336, ''),
(166, 'ayuntamiento', 4, 15, 30, 670, 900, 510, 80, 4410, ''),
(167, 'cuartel', 1, 0, 6, 310, 270, 195, 20, 1602, ''),
(168, 'cuartel', 2, 0, 11, 520, 465, 315, 35, 2692, ''),
(169, 'cuartel', 3, 0, 19, 735, 590, 395, 60, 3598, ''),
(170, 'cuartel', 4, 0, 23, 910, 765, 515, 85, 4596, ''),
(171, 'embajada', 1, 3, 4, 170, 230, 95, 15, 1034, ''),
(172, 'embajada', 2, 5, 8, 340, 480, 190, 30, 2106, ''),
(173, 'embajada', 3, 7, 13, 510, 760, 245, 40, 3150, ''),
(174, 'embajada', 4, 10, 19, 760, 1010, 410, 65, 4548, ''),
(175, 'embajada', 5, 15, 26, 910, 1300, 590, 70, 5882, ''),
(176, 'establo', 1, 0, 6, 415, 300, 165, 40, 1852, 'cuartel_3|ayuntamiento_4'),
(177, 'establo', 2, 0, 11, 625, 415, 290, 70, 2822, 'cuartel_3|ayuntamiento_4'),
(178, 'establo', 3, 0, 19, 795, 595, 340, 120, 3738, 'cuartel_3|ayuntamiento_4'),
(179, 'establo', 4, 0, 23, 910, 710, 590, 170, 4806, 'cuartel_3|ayuntamiento_4'),
(180, 'mercado', 1, 1, 4, 130, 185, 85, 10, 830, ''),
(181, 'mercado', 2, 2, 7, 210, 345, 160, 25, 1498, ''),
(182, 'mercado', 3, 3, 11, 390, 560, 215, 45, 2448, ''),
(183, 'mercado', 4, 4, 19, 510, 665, 345, 60, 3206, ''),
(184, 'mercado', 5, 5, 26, 690, 815, 400, 80, 4032, ''),
(185, 'escondite', 1, 100, 1, 49, 67, 38, 5, 520, ''),
(186, 'escondite', 2, 170, 3, 89, 103, 49, 9, 846, ''),
(187, 'taller', 1, 0, 11, 400, 630, 230, 30, 2602, 'establo_4'),
(188, 'taller', 2, 0, 19, 780, 950, 490, 50, 4578, 'establo_4'),
(189, 'escondite', 3, 230, 4, 110, 137, 72, 14, 1134, ''),
(190, 'escondite', 4, 325, 6, 135, 160, 95, 16, 1474, ''),
(191, 'escondite', 5, 410, 8, 160, 210, 104, 23, 1830, ''),
(192, 'escondite', 6, 560, 11, 195, 287, 136, 30, 2438, ''),
(193, 'escondite', 7, 700, 15, 265, 335, 187, 40, 3084, ''),
(194, 'escondite', 8, 880, 16, 325, 405, 236, 45, 3814, ''),
(195, 'escondite', 9, 1000, 17, 410, 480, 315, 50, 4544, ''),
(196, 'leñador', 17, 220, 78, 248, 619, 309, 95, 3138, ''),
(197, 'leñador', 18, 247, 85, 288, 720, 360, 100, 3600, ''),
(198, 'leñador', 19, 274, 90, 342, 855, 428, 105, 4187, ''),
(199, 'leñador', 20, 302, 98, 363, 906, 453, 110, 4465, ''),
(200, 'barrera', 17, 220, 78, 495, 248, 495, 95, 3262, ''),
(201, 'barrera', 18, 247, 85, 576, 288, 576, 100, 3744, ''),
(202, 'barrera', 19, 274, 90, 684, 342, 684, 105, 4358, ''),
(203, 'barrera', 20, 302, 98, 725, 363, 725, 110, 4646, ''),
(204, 'mina', 17, 220, 78, 619, 495, 186, 95, 3385, ''),
(205, 'mina', 18, 247, 85, 320, 576, 216, 100, 3888, ''),
(206, 'mina', 19, 274, 90, 855, 684, 257, 105, 4529, ''),
(207, 'mina', 20, 302, 98, 906, 725, 272, 110, 4826, ''),
(208, 'granja', 17, 220, 78, 495, 619, 248, 17, 3354, ''),
(209, 'granja', 18, 247, 85, 576, 720, 288, 18, 3868, ''),
(210, 'granja', 19, 274, 90, 684, 855, 342, 19, 4528, ''),
(211, 'granja', 20, 302, 98, 725, 906, 363, 20, 4829, ''),
(212, 'almacen', 9, 10000, 58, 3750, 3050, 2170, 365, 29090, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_tropas`
--

CREATE TABLE IF NOT EXISTS `datos_tropas` (
  `id_tropa` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tropa` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `ataque` int(11) unsigned NOT NULL,
  `defensa` int(11) unsigned NOT NULL,
  `defensa_caballeria` int(11) unsigned NOT NULL,
  `madera` int(11) unsigned NOT NULL,
  `barro` int(11) unsigned NOT NULL,
  `hierro` int(11) unsigned NOT NULL,
  `cereal` int(11) unsigned NOT NULL,
  `consumo` int(11) unsigned NOT NULL,
  `velocidad` int(11) unsigned NOT NULL,
  `capacidad` int(11) unsigned NOT NULL,
  `parte_ejercito` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tiempo` int(11) unsigned NOT NULL,
  `requisitos` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_tropa`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `datos_tropas`
--

INSERT INTO `datos_tropas` (`id_tropa`, `tropa`, `nombre`, `ataque`, `defensa`, `defensa_caballeria`, `madera`, `barro`, `hierro`, `cereal`, `consumo`, `velocidad`, `capacidad`, `parte_ejercito`, `tiempo`, `requisitos`) VALUES
(1, 'tropa1', 'legionario', 20, 40, 30, 70, 35, 70, 10, 1, 12, 60, 'infanteria', 75, 'cuartel_1'),
(2, 'tropa2', 'pretoriano', 50, 60, 50, 110, 60, 140, 20, 1, 12, 50, 'infanteria', 135, 'cuartel_2'),
(3, 'tropa3', 'triario', 100, 30, 80, 140, 85, 200, 40, 1, 12, 40, 'infanteria', 195, 'cuartel_3|ayuntamiento_1'),
(4, 'tropa4', 'caballeria_ligera', 50, 30, 45, 260, 165, 200, 100, 2, 25, 120, 'caballeria', 315, 'establo_1'),
(5, 'tropa5', 'caballeria_pesada', 200, 50, 100, 500, 300, 600, 300, 2, 20, 50, 'caballeria', 765, 'establo_3'),
(6, 'tropa6', 'general', 600, 490, 580, 1300, 700, 1800, 500, 4, 25, 0, 'caballeria', 2400, 'establo_4'),
(7, 'tropa7', 'ariete', 20, 20, 10, 600, 300, 550, 10, 4, 10, 10, 'artilleria', 800, 'taller_1'),
(8, 'tropa8', 'onagro', 60, 60, 40, 850, 620, 710, 100, 4, 10, 10, 'artilleria', 1000, 'taller_2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diplomacia_alianzas`
--

CREATE TABLE IF NOT EXISTS `diplomacia_alianzas` (
  `id_diplomacia` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_alianza_declara` int(11) NOT NULL,
  `id_alianza_acepta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_diplomacia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edificios_aldea`
--

CREATE TABLE IF NOT EXISTS `edificios_aldea` (
  `id_edificio` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `edificio` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `nivel` int(11) unsigned NOT NULL,
  `recurso` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `produccion` double unsigned NOT NULL,
  `habitantes` int(11) unsigned NOT NULL,
  `slot` int(10) unsigned NOT NULL,
  `id_ciudad` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_edificio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=487 ;

--
-- Volcado de datos para la tabla `edificios_aldea`
--

INSERT INTO `edificios_aldea` (`id_edificio`, `edificio`, `nivel`, `recurso`, `produccion`, `habitantes`, `slot`, `id_ciudad`) VALUES
(451, 'ayuntamiento', 0, 'ninguno', 0, 0, 0, 26),
(452, 'granja', 0, 'cereal', 3, 2, 0, 26),
(453, 'leñador', 0, 'madera', 3, 2, 0, 26),
(454, 'barrera', 0, 'barro', 3, 2, 0, 26),
(455, 'mina', 0, 'hierro', 3, 2, 0, 26),
(456, 'almacen', 0, 'capacidad', 800, 0, 0, 26),
(457, 'mercado', 0, 'comercio', 0, 0, 0, 26),
(458, 'cuartel', 0, 'tropas', 0, 0, 0, 26),
(459, 'establo', 0, 'tropas', 0, 0, 0, 26),
(460, 'taller', 0, 'tropas', 0, 0, 0, 26),
(461, 'embajada', 0, 'miembros', 0, 0, 0, 26),
(462, 'escondite', 0, 'escondidos', 0, 0, 0, 26),
(463, 'ayuntamiento', 0, 'ninguno', 0, 0, 0, 78),
(464, 'granja', 0, 'cereal', 3, 2, 0, 78),
(465, 'leñador', 0, 'madera', 3, 2, 0, 78),
(466, 'barrera', 0, 'barro', 3, 2, 0, 78),
(467, 'mina', 0, 'hierro', 3, 2, 0, 78),
(468, 'almacen', 0, 'capacidad', 800, 0, 0, 78),
(469, 'mercado', 0, 'comercio', 0, 0, 0, 78),
(470, 'cuartel', 0, 'tropas', 0, 0, 0, 78),
(471, 'establo', 0, 'tropas', 0, 0, 0, 78),
(472, 'taller', 0, 'tropas', 0, 0, 0, 78),
(473, 'embajada', 0, 'miembros', 0, 0, 0, 78),
(474, 'escondite', 0, 'escondidos', 0, 0, 0, 78),
(475, 'ayuntamiento', 0, 'ninguno', 0, 0, 0, 12),
(476, 'granja', 0, 'cereal', 3, 2, 0, 12),
(477, 'leñador', 0, 'madera', 3, 2, 0, 12),
(478, 'barrera', 0, 'barro', 3, 2, 0, 12),
(479, 'mina', 0, 'hierro', 3, 2, 0, 12),
(480, 'almacen', 0, 'capacidad', 800, 0, 0, 12),
(481, 'mercado', 0, 'comercio', 0, 0, 0, 12),
(482, 'cuartel', 0, 'tropas', 0, 0, 0, 12),
(483, 'establo', 0, 'tropas', 0, 0, 0, 12),
(484, 'taller', 0, 'tropas', 0, 0, 0, 12),
(485, 'embajada', 0, 'miembros', 0, 0, 0, 12),
(486, 'escondite', 0, 'escondidos', 0, 0, 0, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `errores`
--

CREATE TABLE IF NOT EXISTS `errores` (
  `id_error` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `error` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id_error`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE IF NOT EXISTS `eventos` (
  `id_evento` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `edificio` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `tiempo` int(11) unsigned NOT NULL,
  `slot` int(10) unsigned NOT NULL,
  `id_ciudad` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_evento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intercambios`
--

CREATE TABLE IF NOT EXISTS `intercambios` (
  `id_intercambio` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_ciudad_ofrece` int(11) unsigned NOT NULL,
  `recurso_ofrece` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad_ofrece` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `id_ciudad_busca` int(11) unsigned NOT NULL,
  `recurso_busca` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad_busca` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_intercambio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapa`
--

CREATE TABLE IF NOT EXISTS `mapa` (
  `id_casilla` int(11) NOT NULL AUTO_INCREMENT,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `habitantes` int(11) unsigned NOT NULL,
  `madera` double unsigned NOT NULL,
  `barro` double unsigned NOT NULL,
  `hierro` double unsigned NOT NULL,
  `cereal` double unsigned NOT NULL,
  `capital` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `last_update` double unsigned NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_casilla`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=101 ;

--
-- Volcado de datos para la tabla `mapa`
--

INSERT INTO `mapa` (`id_casilla`, `x`, `y`, `nombre`, `tipo`, `habitantes`, `madera`, `barro`, `hierro`, `cereal`, `capital`, `last_update`, `id_usuario`) VALUES
(1, 1, 1, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(2, 2, 1, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(3, 3, 1, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(4, 4, 1, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(5, 5, 1, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(6, 6, 1, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(7, 7, 1, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(8, 8, 1, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(9, 9, 1, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(10, 10, 1, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(11, 1, 2, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(12, 2, 2, 'Santuario de Murrel', 'Barbaros', 8, 500, 500, 500, 500, 'tesoro', 1365947380, 46),
(13, 3, 2, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(14, 4, 2, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(15, 5, 2, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(16, 6, 2, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(17, 7, 2, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(18, 8, 2, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(19, 9, 2, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(20, 10, 2, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(21, 1, 3, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(22, 2, 3, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(23, 3, 3, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(24, 4, 3, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(25, 5, 3, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(26, 6, 3, 'Templo de Murrata', 'Barbaros', 8, 500, 500.5, 500, 500, 'tesoro', 1365947938, 44),
(27, 7, 3, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(28, 8, 3, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(29, 9, 3, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(30, 10, 3, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(31, 1, 4, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(32, 2, 4, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(33, 3, 4, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(34, 4, 4, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(35, 5, 4, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(36, 6, 4, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(37, 7, 4, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(38, 8, 4, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(39, 9, 4, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(40, 10, 4, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(41, 1, 5, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(42, 2, 5, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(43, 3, 5, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(44, 4, 5, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(45, 5, 5, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(46, 6, 5, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(47, 7, 5, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(48, 8, 5, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(49, 9, 5, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(50, 10, 5, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(51, 1, 6, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(52, 2, 6, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(53, 3, 6, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(54, 4, 6, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(55, 5, 6, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(56, 6, 6, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(57, 7, 6, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(58, 8, 6, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(59, 9, 6, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(60, 10, 6, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(61, 1, 7, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(62, 2, 7, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(63, 3, 7, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(64, 4, 7, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(65, 5, 7, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(66, 6, 7, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(67, 7, 7, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(68, 8, 7, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(69, 9, 7, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(70, 10, 7, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(71, 1, 8, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(72, 2, 8, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(73, 3, 8, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(74, 4, 8, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(75, 5, 8, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(76, 6, 8, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(77, 7, 8, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(78, 8, 8, 'Ruinas de Marruta', 'Barbaros', 8, 500, 500, 500, 500, 'tesoro', 1365947313, 45),
(79, 9, 8, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(80, 10, 8, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(81, 1, 9, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(82, 2, 9, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(83, 3, 9, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(84, 4, 9, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(85, 5, 9, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(86, 6, 9, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(87, 7, 9, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(88, 8, 9, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(89, 9, 9, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(90, 10, 9, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(91, 1, 10, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(92, 2, 10, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(93, 3, 10, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(94, 4, 10, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(95, 5, 10, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(96, 6, 10, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(97, 7, 10, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(98, 8, 10, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(99, 9, 10, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0),
(100, 10, 10, 'Terreno Libre', 'Naturaleza', 0, 0, 0, 0, 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_emisor` int(11) unsigned NOT NULL,
  `id_destinatario` int(11) unsigned NOT NULL,
  `asunto` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `mensaje` text COLLATE utf8_spanish_ci NOT NULL,
  `leido_emisor` tinyint(4) NOT NULL,
  `leido_destinatario` tinyint(4) NOT NULL,
  `eliminado_emisor` tinyint(4) NOT NULL,
  `eliminado_destinatario` tinyint(4) NOT NULL,
  `fecha` date NOT NULL,
  `id_respuesta` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros_alianzas`
--

CREATE TABLE IF NOT EXISTS `miembros_alianzas` (
  `id_miembro` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_alianza` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_miembro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE IF NOT EXISTS `ofertas` (
  `id_oferta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recurso_ofrece` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad_ofrece` int(11) unsigned NOT NULL,
  `recurso_busca` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad_busca` int(11) unsigned NOT NULL,
  `id_ciudad` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_oferta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes_comercio`
--

CREATE TABLE IF NOT EXISTS `reportes_comercio` (
  `id_reporte` int(11) NOT NULL AUTO_INCREMENT,
  `id_ciudad_ofrece` int(11) NOT NULL,
  `recurso_ofrece` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad_ofrece` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `id_ciudad_busca` int(11) NOT NULL,
  `recurso_busca` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad_busca` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `leido_ofrece` tinyint(4) NOT NULL,
  `leido_busca` tinyint(4) NOT NULL,
  `fecha` int(11) NOT NULL,
  PRIMARY KEY (`id_reporte`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `reportes_comercio`
--

INSERT INTO `reportes_comercio` (`id_reporte`, `id_ciudad_ofrece`, `recurso_ofrece`, `cantidad_ofrece`, `id_ciudad_busca`, `recurso_busca`, `cantidad_busca`, `leido_ofrece`, `leido_busca`, `fecha`) VALUES
(3, 42, 'madera', '1', 33, 'barro', '1', 1, 1, 1365260750),
(4, 33, 'todo', '10', 42, 'enviar', '0', 1, 1, 1365210396),
(5, 33, 'todo', '-8', 42, 'enviar', '0', 1, 1, 1365202120),
(6, 33, 'todo', '1-2-3-4', 42, 'enviar', '0', 1, 1, 1365202201),
(7, 33, 'todo', '0-1-2-3', 42, 'enviar', '0', 1, 1, 1365601108);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes_tropas`
--

CREATE TABLE IF NOT EXISTS `reportes_tropas` (
  `id_reporte` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `objetivo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `botin` text COLLATE utf8_spanish_ci NOT NULL,
  `id_ciudad_atacante` int(11) unsigned NOT NULL,
  `id_ciudad_atacada` int(11) unsigned NOT NULL,
  `tropas_atacante` text COLLATE utf8_spanish_ci NOT NULL,
  `tropasp_atacante` text COLLATE utf8_spanish_ci NOT NULL,
  `tropas_atacadas` text COLLATE utf8_spanish_ci NOT NULL,
  `tropasp_atacadas` text COLLATE utf8_spanish_ci NOT NULL,
  `comentario` text COLLATE utf8_spanish_ci NOT NULL,
  `leido_atacante` tinyint(4) NOT NULL,
  `leido_atacada` tinyint(4) NOT NULL,
  `fecha` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_reporte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tesoros`
--

CREATE TABLE IF NOT EXISTS `tesoros` (
  `id_tesoro` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` int(11) NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  PRIMARY KEY (`id_tesoro`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tesoros`
--

INSERT INTO `tesoros` (`id_tesoro`, `nombre`, `fecha`, `id_ciudad`) VALUES
(1, 'Espada de Rómulo', 10000, 26),
(2, 'Memorias de Remo', 10000, 78),
(3, 'Amuleto de Marte', 10000, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tropas`
--

CREATE TABLE IF NOT EXISTS `tropas` (
  `id_tropas` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tropa1` int(11) unsigned NOT NULL,
  `tropa2` int(11) unsigned NOT NULL,
  `tropa3` int(11) unsigned NOT NULL,
  `tropa4` int(11) unsigned NOT NULL,
  `tropa5` int(11) unsigned NOT NULL,
  `tropa6` int(11) unsigned NOT NULL,
  `tropa7` int(11) unsigned NOT NULL,
  `tropa8` int(11) unsigned NOT NULL,
  `tropa9` int(11) unsigned NOT NULL,
  `tropa10` int(11) unsigned NOT NULL,
  `id_ciudad` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_tropas`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=45 ;

--
-- Volcado de datos para la tabla `tropas`
--

INSERT INTO `tropas` (`id_tropas`, `tropa1`, `tropa2`, `tropa3`, `tropa4`, `tropa5`, `tropa6`, `tropa7`, `tropa8`, `tropa9`, `tropa10`, `id_ciudad`) VALUES
(42, 80, 100, 20, 30, 30, 1, 0, 0, 0, 0, 26),
(43, 80, 100, 20, 30, 30, 1, 0, 0, 0, 0, 78),
(44, 80, 100, 20, 30, 30, 1, 0, 0, 0, 0, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tropas_refuerzos`
--

CREATE TABLE IF NOT EXISTS `tropas_refuerzos` (
  `id_refuerzos` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_ciudad_refuerza` int(11) unsigned NOT NULL,
  `id_ciudad_reforzada` int(11) unsigned NOT NULL,
  `tropa1` int(11) unsigned NOT NULL,
  `tropa2` int(11) unsigned NOT NULL,
  `tropa3` int(11) unsigned NOT NULL,
  `tropa4` int(11) unsigned NOT NULL,
  `tropa5` int(11) unsigned NOT NULL,
  `tropa6` int(11) unsigned NOT NULL,
  `tropa7` int(11) unsigned NOT NULL,
  `tropa8` int(11) unsigned NOT NULL,
  `tropa9` int(11) unsigned NOT NULL,
  `tropa10` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_refuerzos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `perfil` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `ip` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=47 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `password`, `correo`, `perfil`, `fecha_ingreso`, `ip`) VALUES
(44, 'Murrata', 'kjefn53aksdfnkjfdbj5', 'murratas', 'Uno de los tres Muhan.', '2013-04-14 15:47:47', 'muhan'),
(45, 'Marruta', 'dsknfkajd55jn', 'marrutas', 'Uno de los tres Muhan.', '2013-04-14 15:48:33', 'muhan'),
(46, 'Murrel', 'jnsififbus193', 'murrels', 'Uno de los tres Muhan.', '2013-04-14 15:49:40', 'muhan');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelta_ataques`
--

CREATE TABLE IF NOT EXISTS `vuelta_ataques` (
  `id_vuelta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `objetivo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `botin` text COLLATE utf8_spanish_ci NOT NULL,
  `id_ciudad_atacante` int(11) unsigned NOT NULL,
  `id_ciudad_atacada` int(11) unsigned NOT NULL,
  `tropa1` int(11) unsigned NOT NULL,
  `tropa2` int(11) unsigned NOT NULL,
  `tropa3` int(11) unsigned NOT NULL,
  `tropa4` int(11) unsigned NOT NULL,
  `tropa5` int(11) unsigned NOT NULL,
  `tropa6` int(11) unsigned NOT NULL,
  `tropa7` int(11) unsigned NOT NULL,
  `tropa8` int(11) unsigned NOT NULL,
  `tropa9` int(11) unsigned NOT NULL,
  `tropa10` int(11) unsigned NOT NULL,
  `fecha` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_vuelta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
