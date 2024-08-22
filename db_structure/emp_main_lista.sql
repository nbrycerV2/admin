-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-08-2024 a las 23:49:33
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_laboratorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emp_main_lista`
--

CREATE TABLE `emp_main_lista` (
  `id` int(40) NOT NULL,
  `nombre` varchar(300) DEFAULT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `dpto` varchar(40) DEFAULT NULL,
  `central` varchar(40) DEFAULT NULL,
  `ruc` varchar(40) DEFAULT NULL,
  `estado` varchar(40) DEFAULT NULL,
  `pagina` varchar(70) DEFAULT NULL,
  `rubro` varchar(50) DEFAULT NULL,
  `detalle` text DEFAULT NULL,
  `user` varchar(10) DEFAULT NULL,
  `provincia` varchar(100) DEFAULT NULL,
  `distrito` varchar(100) DEFAULT NULL,
  `horario` varchar(80) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `emp_main_lista`
--
ALTER TABLE `emp_main_lista`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `emp_main_lista`
--
ALTER TABLE `emp_main_lista`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
