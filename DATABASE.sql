-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 10-01-2021 a las 13:14:41
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `usuarios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigos`
--

DROP TABLE IF EXISTS `amigos`;
CREATE TABLE IF NOT EXISTS `amigos` (
  `id_user1` int(11) NOT NULL,
  `id_user2` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user1`,`id_user2`),
  KEY `cf6` (`id_user2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `amigos`
--

INSERT INTO `amigos` (`id_user1`, `id_user2`, `estado`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apuestas`
--

DROP TABLE IF EXISTS `apuestas`;
CREATE TABLE IF NOT EXISTS `apuestas` (
  `id_apuesta` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cuota` float NOT NULL,
  PRIMARY KEY (`id_apuesta`),
  UNIQUE KEY `descripcion` (`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `apuestas`
--

INSERT INTO `apuestas` (`id_apuesta`, `descripcion`, `cuota`) VALUES
(1, '¿Vas a suspender?', 1.55),
(2, '¿Vas a aprobar?', 1.45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

DROP TABLE IF EXISTS `asignatura`;
CREATE TABLE IF NOT EXISTS `asignatura` (
  `nombre_asignatura` varchar(60) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `numero_creditos` int(11) NOT NULL,
  `id_asignatura` int(11) NOT NULL,
  `Curso` int(11) NOT NULL,
  `id_carrera` varchar(6) COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_asignatura`),
  UNIQUE KEY `nombre_asignatura` (`nombre_asignatura`),
  KEY `asignatura_carrera` (`id_carrera`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`nombre_asignatura`, `numero_creditos`, `id_asignatura`, `Curso`, `id_carrera`) VALUES
('Estadística', 6, 21714002, 1, 'GII'),
('Fundamentos Físicos y Electrónicos de la Informática', 6, 21714003, 1, 'GII'),
('Fundamentos de Estructura de Computadores', 6, 21714004, 1, 'GII'),
('Informática General', 6, 21714005, 1, 'GII'),
('Introducción a la Programación', 6, 21714006, 1, 'GII'),
('Metodología de la Programación', 6, 21714007, 1, 'GII'),
('Álgebra', 6, 21714008, 1, 'GII'),
('Cálculo', 6, 21714009, 1, 'GII'),
('Matemática Discreta', 6, 21714010, 1, 'GII'),
('Sistemas Digitales', 6, 21714084, 1, 'GII');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas_aprobadas`
--

DROP TABLE IF EXISTS `asignaturas_aprobadas`;
CREATE TABLE IF NOT EXISTS `asignaturas_aprobadas` (
  `id` int(11) NOT NULL,
  `id_asignatura` int(11) NOT NULL,
  PRIMARY KEY (`id`,`id_asignatura`),
  KEY `cf2` (`id_asignatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `asignaturas_aprobadas`
--

INSERT INTO `asignaturas_aprobadas` (`id`, `id_asignatura`) VALUES
(1, 21714002),
(1, 21714003),
(2, 21714009);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas_matriculadas`
--

DROP TABLE IF EXISTS `asignaturas_matriculadas`;
CREATE TABLE IF NOT EXISTS `asignaturas_matriculadas` (
  `id` int(11) NOT NULL,
  `id_asignatura` int(11) NOT NULL,
  PRIMARY KEY (`id`,`id_asignatura`),
  KEY `cf4` (`id_asignatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

DROP TABLE IF EXISTS `carrera`;
CREATE TABLE IF NOT EXISTS `carrera` (
  `id_carrera` varchar(6) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre_carrera` varchar(40) COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_carrera`),
  UNIQUE KEY `nombre_carrera` (`nombre_carrera`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`id_carrera`, `nombre_carrera`) VALUES
('GIA', 'Ingeniería Aeroespacial'),
('GII', 'Ingeniería Informática'),
('GIM', 'Ingeniería Mecánica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `Nombre` varchar(30) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `Apellidos` varchar(40) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `contrasena` varchar(15) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `identificador` varchar(10) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `pinfcoins` int(11) NOT NULL,
  `id_carrera` varchar(6) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`email`),
  UNIQUE KEY `identificador` (`identificador`),
  UNIQUE KEY `id` (`id`),
  KEY `cf` (`id_carrera`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Nombre`, `Apellidos`, `contrasena`, `email`, `identificador`, `pinfcoins`, `id_carrera`, `id`) VALUES
('Antonio', 'Morales Fernandez', 'hola', '123@gmail.com', 'ant990', 51, 'GII', 1),
('Alejandro', 'Serrano Fernández', 'hola1', '1234@gmail.com', 'ale', 60, 'GII', 2),
('Samuel', 'Limones Cruz', 'comeralgogordo', '12345@gmail.com', 'samuelo', 0, 'GII', 4),
('Pablo', 'Romero Arias', 'tonto', '123456@gmail.com', 'pablo980', 0, 'GIM', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `us_as_ap`
--

DROP TABLE IF EXISTS `us_as_ap`;
CREATE TABLE IF NOT EXISTS `us_as_ap` (
  `id_apuesta` int(11) NOT NULL,
  `id_asignatura` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `cf7` (`id_apuesta`),
  KEY `cf8` (`id_asignatura`),
  KEY `cf9` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `us_as_ap`
--

INSERT INTO `us_as_ap` (`id_apuesta`, `id_asignatura`, `id_usuario`, `id`) VALUES
(2, 21714003, 1, 1),
(2, 21714009, 1, 2);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD CONSTRAINT `cf5` FOREIGN KEY (`id_user1`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf6` FOREIGN KEY (`id_user2`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD CONSTRAINT `asignatura_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id_carrera`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignaturas_aprobadas`
--
ALTER TABLE `asignaturas_aprobadas`
  ADD CONSTRAINT `cf1` FOREIGN KEY (`id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf2` FOREIGN KEY (`id_asignatura`) REFERENCES `asignatura` (`id_asignatura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignaturas_matriculadas`
--
ALTER TABLE `asignaturas_matriculadas`
  ADD CONSTRAINT `cf3` FOREIGN KEY (`id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf4` FOREIGN KEY (`id_asignatura`) REFERENCES `asignatura` (`id_asignatura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `cf` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id_carrera`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `us_as_ap`
--
ALTER TABLE `us_as_ap`
  ADD CONSTRAINT `cf7` FOREIGN KEY (`id_apuesta`) REFERENCES `apuestas` (`id_apuesta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf8` FOREIGN KEY (`id_asignatura`) REFERENCES `asignatura` (`id_asignatura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cf9` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
