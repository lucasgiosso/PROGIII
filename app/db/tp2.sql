-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
<<<<<<< HEAD
-- Tiempo de generación: 21-06-2023 a las 01:22:44
=======
-- Tiempo de generación: 21-06-2023 a las 03:45:09
>>>>>>> 561cd04d31978d7eb71751c2b67fc5f7eb3abf09
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tp2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fechaBaja` date DEFAULT NULL,
  `fechaSuspension` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `rol`, `nombre`, `fechaBaja`, `fechaSuspension`) VALUES
(1, 'Mozo', 'Garrick', NULL, NULL),
(2, 'Cocinero', 'Spirit', NULL, NULL),
(3, 'Bartender', 'Westmacott', NULL, NULL),
<<<<<<< HEAD
(4, 'Cervecero', 'Newgrosh', NULL, NULL);
=======
(4, 'Cervecero', 'Newgrosh', NULL, NULL),
(5, 'Bartender', 'Juan', '0000-00-00', '0000-00-00'),
(6, 'Bartender', 'Pedro', '0000-00-00', '0000-00-00'),
(7, 'Bartender', 'Sergio', NULL, NULL),
(8, 'Bartender', 'Federico', NULL, NULL),
(9, 'Bartender', 'Alberto', NULL, NULL);
>>>>>>> 561cd04d31978d7eb71751c2b67fc5f7eb3abf09

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `descripcion`) VALUES
(1, 'Pendiente'),
(2, 'En preparación'),
(3, 'Listo para servir'),
(4, 'Con cliente esperando pedido'),
(5, 'Con cliente comiendo'),
(6, 'Con cliente pagando'),
(7, 'Cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `fechaBaja` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `codigoComanda` int(11) NOT NULL,
  `productos_id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `precio` float NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tiempoEstimado` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `fechaBaja` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

<<<<<<< HEAD
=======
--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `codigoComanda`, `productos_id`, `empleado_id`, `precio`, `cantidad`, `tiempoEstimado`, `estado`, `fechaBaja`) VALUES
(1, 0, 1, 2, 0, 2, 30, 'Pendiente', '0000-00-00');

>>>>>>> 561cd04d31978d7eb71751c2b67fc5f7eb3abf09
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` float NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `rol`) VALUES
(1, 'Milanesa a caballo', 2500, 'Cocinero'),
(2, 'Hamburguesa de garbanzo', 1500, 'Cocinero'),
(3, 'Corona', 800, 'Cervecero'),
<<<<<<< HEAD
(4, 'Daikiri', 1200, 'Bartender');
=======
(4, 'Daikiri', 1200, 'Bartender'),
(5, 'Gin Tonic', 1500, 'Bartender');
>>>>>>> 561cd04d31978d7eb71751c2b67fc5f7eb3abf09

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
<<<<<<< HEAD
  ADD PRIMARY KEY (`id`);
=======
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productos_id` (`productos_id`),
  ADD UNIQUE KEY `empleado_id` (`empleado_id`);
>>>>>>> 561cd04d31978d7eb71751c2b67fc5f7eb3abf09

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
<<<<<<< HEAD
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
>>>>>>> 561cd04d31978d7eb71751c2b67fc5f7eb3abf09

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
<<<<<<< HEAD
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
>>>>>>> 561cd04d31978d7eb71751c2b67fc5f7eb3abf09

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
<<<<<<< HEAD
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`);
>>>>>>> 561cd04d31978d7eb71751c2b67fc5f7eb3abf09
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
