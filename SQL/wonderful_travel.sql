-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-12-2022 a las 20:32:17
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `wonderful_travel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `continents`
--

CREATE TABLE `continents` (
  `continent` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `continents`
--

INSERT INTO `continents` (`continent`) VALUES
('Africa'),
('America'),
('Asia'),
('Europa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historic`
--

CREATE TABLE `historic` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `desti` varchar(45) NOT NULL,
  `preu` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `telefon` int(11) NOT NULL,
  `persones` int(11) NOT NULL,
  `cancelat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `historic`
--

INSERT INTO `historic` (`id`, `date`, `desti`, `preu`, `nom`, `telefon`, `persones`, `cancelat`) VALUES
(22, '2022-12-30', 'Tailandia', 1905, 'Aas', 603116026, 3, 1),
(24, '2022-12-20', 'Senegal', 2460, 'hjadf', 603116026, 3, 0),
(25, '2022-12-20', 'Bangladesh', 2820, 'uguh', 603116026, 5, 0),
(26, '2022-12-23', 'China', 3120, 'wrfrgr', 603116026, 6, 0),
(27, '2022-12-20', 'Alemania', 600, 'aefsfv', 603116026, 6, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paisos`
--

CREATE TABLE `paisos` (
  `pais` varchar(30) NOT NULL,
  `continent` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paisos`
--

INSERT INTO `paisos` (`pais`, `continent`) VALUES
('Alemania', 'Europa'),
('Argentina', 'America'),
('Bangladesh', 'Asia'),
('Belgica', 'Europa'),
('China', 'Asia'),
('Colombia', 'America'),
('Francia', 'Europa'),
('Ghana', 'Africa'),
('India', 'Asia'),
('Italia', 'Europa'),
('Mexico', 'America'),
('Peru', 'America'),
('Senegal', 'Africa'),
('Tailandia', 'Asia'),
('Uganda', 'Africa'),
('Zimbabwe', 'Africa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preus`
--

CREATE TABLE `preus` (
  `pais` varchar(30) NOT NULL,
  `preu` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `preus`
--

INSERT INTO `preus` (`pais`, `preu`) VALUES
('Alemania', 125),
('Argentina', 900),
('Bangladesh', 705),
('Belgica', 90),
('China', 650),
('Colombia', 700),
('Francia', 60),
('Ghana', 760),
('India', 550),
('Italia', 105),
('Mexico', 835),
('Peru', 740),
('Senegal', 820),
('Tailandia', 635),
('Uganda', 450),
('Zimbabwe', 600);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserves`
--

CREATE TABLE `reserves` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `desti` varchar(45) NOT NULL,
  `preu` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `telefon` int(11) NOT NULL,
  `persones` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reserves`
--

INSERT INTO `reserves` (`id`, `date`, `desti`, `preu`, `nom`, `telefon`, `persones`) VALUES
(24, '2022-12-20', 'Senegal', 2460, 'hjadf', 603116026, 3),
(25, '2022-12-20', 'Bangladesh', 2820, 'uguh', 603116026, 5),
(26, '2022-12-23', 'China', 3120, 'wrfrgr', 603116026, 6),
(27, '2022-12-20', 'Alemania', 600, 'aefsfv', 603116026, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `continents`
--
ALTER TABLE `continents`
  ADD PRIMARY KEY (`continent`);

--
-- Indices de la tabla `historic`
--
ALTER TABLE `historic`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paisos`
--
ALTER TABLE `paisos`
  ADD PRIMARY KEY (`pais`,`continent`),
  ADD KEY `fk_paisos_continents` (`continent`);

--
-- Indices de la tabla `preus`
--
ALTER TABLE `preus`
  ADD PRIMARY KEY (`pais`);

--
-- Indices de la tabla `reserves`
--
ALTER TABLE `reserves`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historic`
--
ALTER TABLE `historic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `reserves`
--
ALTER TABLE `reserves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `paisos`
--
ALTER TABLE `paisos`
  ADD CONSTRAINT `fk_paisos_continents` FOREIGN KEY (`continent`) REFERENCES `continents` (`continent`);

--
-- Filtros para la tabla `preus`
--
ALTER TABLE `preus`
  ADD CONSTRAINT `fk_preus_paisos` FOREIGN KEY (`pais`) REFERENCES `paisos` (`pais`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
