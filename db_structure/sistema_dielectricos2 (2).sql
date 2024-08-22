-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-08-2024 a las 23:38:59
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
-- Base de datos: `sistema_dielectricos2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acc_ord_aterra`
--

CREATE TABLE `acc_ord_aterra` (
  `idDetAcc` varchar(10) NOT NULL,
  `idDetOrdAterra` varchar(10) NOT NULL,
  `Pertiga` varchar(100) NOT NULL,
  `Varilla` varchar(100) NOT NULL,
  `Adaptador` varchar(100) NOT NULL,
  `Otros` varchar(100) NOT NULL,
  `Trifurcacion` varchar(100) NOT NULL,
  `FechaSolicitud` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_ord_aterra`
--

CREATE TABLE `det_ord_aterra` (
  `idDetOrdAterra` varchar(10) NOT NULL,
  `idOrdAterra` varchar(10) NOT NULL,
  `Serie` int(7) NOT NULL,
  `MLinea` varchar(50) NOT NULL,
  `LongitudA` varchar(20) NOT NULL,
  `SeccionA` varchar(20) NOT NULL,
  `MTierra` varchar(20) NOT NULL,
  `LongitudB` varchar(20) NOT NULL,
  `SeccionB` varchar(20) NOT NULL,
  `TLinea` varchar(20) NOT NULL,
  `LongitudX` varchar(20) NOT NULL,
  `SeccionX` varchar(20) NOT NULL,
  `TerminalX` varchar(20) NOT NULL,
  `TTierra` varchar(20) NOT NULL,
  `FechaSolicitud` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guantes`
--

CREATE TABLE `guantes` (
  `id` int(10) NOT NULL,
  `marca` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantdefectuoso`
--

CREATE TABLE `mantdefectuoso` (
  `IdMantDefectuoso` varchar(10) NOT NULL,
  `IdMantPrueba` varchar(10) NOT NULL,
  `Sintoma` varchar(300) NOT NULL,
  `Diagnostico` varchar(500) NOT NULL,
  `AccionesRealizadas` varchar(300) NOT NULL,
  `Conclusiones` varchar(100) NOT NULL,
  `FechaInforme` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantobservacion`
--

CREATE TABLE `mantobservacion` (
  `IdObs` varchar(10) NOT NULL,
  `Serie` varchar(100) NOT NULL,
  `Observacion` varchar(400) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `FechaCreada` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantprueba`
--

CREATE TABLE `mantprueba` (
  `IdMantPrueba` varchar(10) NOT NULL,
  `IdOrdMant` varchar(10) NOT NULL,
  `Serie` varchar(100) NOT NULL,
  `Aterramiento` varchar(200) NOT NULL,
  `Marca` varchar(100) NOT NULL,
  `Tramo` varchar(100) NOT NULL,
  `LongitudTotal` varchar(100) NOT NULL,
  `Seccion` varchar(100) NOT NULL,
  `CorrienteAplicada` varchar(100) NOT NULL,
  `ValorMedido` varchar(100) NOT NULL,
  `MaxPermisible` varchar(100) NOT NULL,
  `Estado` varchar(100) NOT NULL,
  `Estuche` varchar(100) NOT NULL,
  `FechaPrueba` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordaterra`
--

CREATE TABLE `ordaterra` (
  `idOrdAterra` varchar(10) NOT NULL,
  `Cliente` varchar(100) NOT NULL,
  `Ruc` varchar(11) NOT NULL,
  `Cantidad` int(100) NOT NULL,
  `Vendedor` varchar(10) NOT NULL,
  `TipoAterra` varchar(10) NOT NULL,
  `Estado` varchar(30) NOT NULL,
  `EstChico` varchar(100) DEFAULT NULL,
  `EstGrande` varchar(100) DEFAULT NULL,
  `EstMetalico` varchar(100) DEFAULT NULL,
  `EstPertiga` varchar(100) DEFAULT NULL,
  `FechaSolicitud` datetime NOT NULL,
  `FechaEntrega` datetime DEFAULT NULL,
  `FechaInforme` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_dielectrico`
--

CREATE TABLE `orden_dielectrico` (
  `id` int(11) NOT NULL,
  `cliente` varchar(255) DEFAULT NULL,
  `ruc` varchar(255) DEFAULT NULL,
  `equipo` varchar(255) DEFAULT NULL,
  `vendedor` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `items` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `salida` date DEFAULT NULL,
  `marcas` varchar(255) DEFAULT NULL,
  `humedad` varchar(255) DEFAULT NULL,
  `temperatura` varchar(255) DEFAULT NULL,
  `fecha_informe` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_dielectrico_m`
--

CREATE TABLE `orden_dielectrico_m` (
  `id` int(11) NOT NULL,
  `cliente` varchar(255) DEFAULT NULL,
  `ruc` varchar(255) DEFAULT NULL,
  `equipo` varchar(255) DEFAULT NULL,
  `vendedor` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `items` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `salida` date DEFAULT NULL,
  `marcas` varchar(255) DEFAULT NULL,
  `humedad` varchar(255) DEFAULT NULL,
  `temperatura` varchar(255) DEFAULT NULL,
  `fecha_informe` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_item`
--

CREATE TABLE `orden_item` (
  `id` int(11) NOT NULL,
  `id_orden` varchar(255) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `clase` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `nro_orden` int(255) DEFAULT NULL,
  `equipo` varchar(255) DEFAULT NULL,
  `n_informe` varchar(255) DEFAULT NULL,
  `vendedor` varchar(255) DEFAULT NULL,
  `empresa` varchar(255) DEFAULT NULL,
  `talla` varchar(255) DEFAULT NULL,
  `resultado` varchar(255) DEFAULT NULL,
  `longitud` varchar(255) DEFAULT NULL,
  `valor_izq` varchar(255) DEFAULT NULL,
  `valor_der` varchar(255) DEFAULT NULL,
  `otro` varchar(255) DEFAULT NULL,
  `serie_guante` varchar(255) DEFAULT NULL,
  `serie_manta` varchar(255) DEFAULT NULL,
  `serie_banqueta` varchar(255) DEFAULT NULL,
  `serie_pertiga` varchar(255) DEFAULT NULL,
  `serie_manga` varchar(255) DEFAULT NULL,
  `serie_edit` varchar(255) DEFAULT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_item_m`
--

CREATE TABLE `orden_item_m` (
  `id` int(11) NOT NULL,
  `id_orden` varchar(255) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `clase` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `nro_orden` varchar(255) DEFAULT NULL,
  `equipo` varchar(255) DEFAULT NULL,
  `n_informe` varchar(255) DEFAULT NULL,
  `vendedor` varchar(255) DEFAULT NULL,
  `empresa` varchar(255) DEFAULT NULL,
  `talla` varchar(255) DEFAULT NULL,
  `resultado` varchar(255) DEFAULT NULL,
  `longitud` varchar(255) DEFAULT NULL,
  `valor_izq` varchar(255) DEFAULT NULL,
  `valor_der` varchar(255) DEFAULT NULL,
  `otro` varchar(255) DEFAULT NULL,
  `serie_guante` varchar(255) DEFAULT NULL,
  `serie_manta` varchar(255) DEFAULT NULL,
  `serie_banqueta` varchar(255) DEFAULT NULL,
  `serie_pertiga` varchar(255) DEFAULT NULL,
  `serie_manga` varchar(255) DEFAULT NULL,
  `serie_edit` varchar(255) DEFAULT NULL,
  `obs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordmantenimiento`
--

CREATE TABLE `ordmantenimiento` (
  `IdOrdMant` varchar(10) NOT NULL,
  `Cliente` varchar(100) NOT NULL,
  `Ruc` varchar(11) NOT NULL,
  `Cantidad` int(100) NOT NULL,
  `FechaSolicitud` datetime NOT NULL,
  `FechaEntrega` datetime NOT NULL,
  `FechaInforme` datetime NOT NULL,
  `Estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordprueba`
--

CREATE TABLE `ordprueba` (
  `IdPrueba` varchar(11) NOT NULL,
  `Serie` int(7) NOT NULL,
  `Tramo` varchar(100) NOT NULL,
  `LongitudTotal` varchar(100) NOT NULL,
  `CorrienteAplicada` varchar(100) NOT NULL,
  `ValorMedido` varchar(100) NOT NULL,
  `MaxPermisible` varchar(100) NOT NULL,
  `Resultado` varchar(30) NOT NULL,
  `FechaPrueba` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pertigas`
--

CREATE TABLE `pertigas` (
  `id` int(40) NOT NULL,
  `marca` varchar(40) NOT NULL,
  `modelo` varchar(40) NOT NULL,
  `cuerpos` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acc_ord_aterra`
--
ALTER TABLE `acc_ord_aterra`
  ADD PRIMARY KEY (`idDetAcc`);

--
-- Indices de la tabla `det_ord_aterra`
--
ALTER TABLE `det_ord_aterra`
  ADD PRIMARY KEY (`idDetOrdAterra`);

--
-- Indices de la tabla `guantes`
--
ALTER TABLE `guantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mantdefectuoso`
--
ALTER TABLE `mantdefectuoso`
  ADD PRIMARY KEY (`IdMantDefectuoso`);

--
-- Indices de la tabla `mantobservacion`
--
ALTER TABLE `mantobservacion`
  ADD PRIMARY KEY (`IdObs`);

--
-- Indices de la tabla `mantprueba`
--
ALTER TABLE `mantprueba`
  ADD PRIMARY KEY (`IdMantPrueba`);

--
-- Indices de la tabla `ordaterra`
--
ALTER TABLE `ordaterra`
  ADD PRIMARY KEY (`idOrdAterra`);

--
-- Indices de la tabla `orden_dielectrico`
--
ALTER TABLE `orden_dielectrico`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden_dielectrico_m`
--
ALTER TABLE `orden_dielectrico_m`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden_item`
--
ALTER TABLE `orden_item`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden_item_m`
--
ALTER TABLE `orden_item_m`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ordmantenimiento`
--
ALTER TABLE `ordmantenimiento`
  ADD PRIMARY KEY (`IdOrdMant`);

--
-- Indices de la tabla `ordprueba`
--
ALTER TABLE `ordprueba`
  ADD PRIMARY KEY (`IdPrueba`);

--
-- Indices de la tabla `pertigas`
--
ALTER TABLE `pertigas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `guantes`
--
ALTER TABLE `guantes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_dielectrico`
--
ALTER TABLE `orden_dielectrico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_dielectrico_m`
--
ALTER TABLE `orden_dielectrico_m`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_item`
--
ALTER TABLE `orden_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_item_m`
--
ALTER TABLE `orden_item_m`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pertigas`
--
ALTER TABLE `pertigas`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
