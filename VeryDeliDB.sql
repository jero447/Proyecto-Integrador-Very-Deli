-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-11-2024 a las 01:35:55
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
-- Base de datos: `feature`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `idCalificacion` int(11) NOT NULL,
  `descripccion` text DEFAULT NULL,
  `valor` float NOT NULL,
  `idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulacion`
--

CREATE TABLE `postulacion` (
  `idPostulacion` int(11) NOT NULL,
  `monto` float NOT NULL,
  `estado` varchar(20) NOT NULL,
  `idPublicacion` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `postulacion`
--

INSERT INTO `postulacion` (`idPostulacion`, `monto`, `estado`, `idPublicacion`, `idUsuario`) VALUES
(2, 0, '', 25, 5),
(3, 0, '', 28, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `idPublicacion` int(11) NOT NULL,
  `volumen` float NOT NULL,
  `peso` float NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `titulo` varchar(30) DEFAULT NULL,
  `descripcion` varchar(70) DEFAULT NULL,
  `localidad_destino` varchar(30) DEFAULT NULL,
  `localidad_origen` varchar(30) DEFAULT NULL,
  `provincia_origen` varchar(30) DEFAULT NULL,
  `provincia_destino` varchar(30) DEFAULT NULL,
  `calle_origen` varchar(30) DEFAULT NULL,
  `calle_destino` varchar(30) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`idPublicacion`, `volumen`, `peso`, `idUsuario`, `titulo`, `descripcion`, `localidad_destino`, `localidad_origen`, `provincia_origen`, `provincia_destino`, `calle_origen`, `calle_destino`, `imagen`) VALUES
(25, 331, 454, 5, 'chau', 'Prueba', 'Real Sayana', 'Real Sayana', 'Santiago del Estero', 'Santiago del Estero', 'Av.Finur 976', 'Pasaje Colon 245', 'uploads/imagenGatito.jpg'),
(27, 465, 1231, 5, 'Envio de mercaderia', 'Mercaderia de supermercado', 'Colonia Gutiérrez', 'La Lobería', 'Río Negro', 'San Juan', 'Av.Finur 976', 'Pasaje Colon 245', 'uploads/imagen-prueba.png'),
(28, 789, 456, 8, 'Prueba bruno', 'Prueba', 'Abralaite', 'Yavi', 'Jujuy', 'Jujuy', 'Av.Finur 976', 'Pasaje Colon 245', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reset_clave`
--

CREATE TABLE `reset_clave` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `vencimiento` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `clave` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dni` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `email`, `nombre_usuario`, `clave`, `dni`) VALUES
(1, 'Ramon Zapico', 'raramon.240@gmail.com', 'ramoncho12', '$2y$10$Epxsm2hGQ4qiK8RIn/PL/uJUJNFI8/awVyFn10STwnbrmsm7Z7Lf6', 43620901),
(4, 'Estela de Carlotto', 'raramiro.230@gmail.com', 'Estee44', '$2y$10$Nh9cvPDOUL81J16qtp1KcOCgWpC.VdNMdPkASiYrecIOral4vZfXq', 43620904),
(5, 'Jeronimo Sturniolo', 'jeronimostur@hotmail.com', 'jero447', '$2y$10$hN3gP2.mYjiTQgDrErMBuumDGRFnj97aymj5RqigcytO/399gjXcW', 44358758),
(6, 'Ramiro Gabriel Caceres', 'raramiro.240@gmail.com', 'ramaa24', '$2y$10$OosHn1CjTarnbodXNszXqOSuE9BrMOoq5EJFEsVof6JtTRh3s2v9O', 43620902),
(7, 'Samuel de Luque', 'vegetta777@gmail.com', 'Vegetta777', '$2y$10$7HzZDhnVbN4.QfKAdvAAXephUt1j27kWOxFO.GAB0rvv2twEG6nom', 43620777),
(8, 'Bruno ', 'bruno@gmail.com', 'bruno123', '$2y$10$ld/ZjKd1N24jcDKjFwYY9OFgo98dX7xc3Je.2SGUAf7m7Nahz8oJe', 48796531);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `idVehiculo` int(11) NOT NULL,
  `matricula` varchar(9) NOT NULL,
  `modelo` varchar(20) NOT NULL,
  `color` varchar(20) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`idVehiculo`, `matricula`, `modelo`, `color`, `idUsuario`) VALUES
(1, 'ABC 123', 'Corsa', 'Negro', 5),
(2, 'BCA 321', 'Corolla', 'Gris', 5),
(3, 'AFK 240', 'Peugeot 206', 'Azul', 6),
(4, 'PSG 777', 'Yamaha 110', 'Blanco', 6),
(5, 'MCD 777', 'Renault 12', 'Rojo', 7),
(6, 'SR 777 HG', 'Zanella 110', 'Negro', 7);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD PRIMARY KEY (`idCalificacion`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `postulacion`
--
ALTER TABLE `postulacion`
  ADD PRIMARY KEY (`idPostulacion`),
  ADD KEY `idPublicacion` (`idPublicacion`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`idPublicacion`),
  ADD KEY `fk_usuario_publicaciones` (`idUsuario`);

--
-- Indices de la tabla `reset_clave`
--
ALTER TABLE `reset_clave`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `nombre_usuario_UNIQUE` (`nombre_usuario`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`idVehiculo`),
  ADD UNIQUE KEY `matricula` (`matricula`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  MODIFY `idCalificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `postulacion`
--
ALTER TABLE `postulacion`
  MODIFY `idPostulacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `idPublicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `reset_clave`
--
ALTER TABLE `reset_clave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `idVehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD CONSTRAINT `calificacion_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `postulacion`
--
ALTER TABLE `postulacion`
  ADD CONSTRAINT `postulacion_ibfk_1` FOREIGN KEY (`idPublicacion`) REFERENCES `publicacion` (`idPublicacion`),
  ADD CONSTRAINT `postulacion_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `fk_usuario_publicaciones` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `vehiculo_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
