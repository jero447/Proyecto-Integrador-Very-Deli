-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2024 a las 19:32:54
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
  `comentario` varchar(100) DEFAULT NULL,
  `valor` float NOT NULL,
  `idUsuarioCalificado` int(11) DEFAULT NULL,
  `idUsuarioCalificador` int(11) DEFAULT NULL,
  `resultado` varchar(30) DEFAULT NULL,
  `idPublicacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `calificacion`
--

INSERT INTO `calificacion` (`idCalificacion`, `comentario`, `valor`, `idUsuarioCalificado`, `idUsuarioCalificador`, `resultado`, `idPublicacion`) VALUES
(40, '', 4, 27, 28, 'positiva', NULL),
(41, 'Te califico bruno', 5, 28, 27, 'positiva', NULL),
(45, 'Te califico Jero', 5, 28, 27, 'positiva', 94),
(49, '', 5, 27, 28, 'positiva', 99),
(50, '', 4, 28, 27, 'positiva', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidato_seleccionado`
--

CREATE TABLE `candidato_seleccionado` (
  `idSeleccion` int(11) NOT NULL,
  `idPostulacion` int(11) NOT NULL,
  `idPublicacion` int(11) NOT NULL,
  `idUsuarioDueño` int(11) NOT NULL,
  `idUsuarioSeleccionado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `candidato_seleccionado`
--

INSERT INTO `candidato_seleccionado` (`idSeleccion`, `idPostulacion`, `idPublicacion`, `idUsuarioDueño`, `idUsuarioSeleccionado`) VALUES
(47, 126, 94, 27, 28),
(48, 127, 95, 27, 28),
(49, 128, 99, 27, 28);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `idMensaje` int(11) NOT NULL,
  `idPublicacion` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `contenido` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`idMensaje`, `idPublicacion`, `idUsuario`, `contenido`) VALUES
(29, 94, 27, 'Hola Jero'),
(30, 94, 28, 'Hola Bruno');

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
(126, 0, '', 94, 28),
(127, 0, '', 95, 28),
(128, 0, '', 99, 28);

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
  `imagen` varchar(50) DEFAULT NULL,
  `estado` varchar(25) DEFAULT 'no resuelta',
  `estado_envio` varchar(40) DEFAULT 'no finalizada'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`idPublicacion`, `volumen`, `peso`, `idUsuario`, `titulo`, `descripcion`, `localidad_destino`, `localidad_origen`, `provincia_origen`, `provincia_destino`, `calle_origen`, `calle_destino`, `imagen`, `estado`, `estado_envio`) VALUES
(94, 123, 465, 27, 'Prueba', 'Prueba', 'Barrio Gasoducto', 'Gran Guardia', 'Formosa', 'Chubut', 'Av.Finur 976', 'Pasaje Colon 245', 'uploads/imagenGatito.jpg', 'resuelta', 'finalizada'),
(95, 456, 123, 27, 'Envio de mercaderia', 'demasiado texto', 'Chaupihuasi', '11va Sección', 'Mendoza', 'La Rioja', 'Av.Finur 976', 'Pasaje Colon 245', 'uploads/imagen-prueba.png', 'resuelta', 'no finalizada'),
(96, 789, 456, 27, 'Gato 2', 'demasiado texto', 'El Paraíso', 'Villa Basilio Nievas', 'San Juan', 'Tucumán', 'Av.Finur 976', 'Pasaje Colon 245', 'uploads/gato2.jpg', 'no resuelta', 'no finalizada'),
(99, 4, 50, 27, 'Flete de una cama', 'Una cama de dos plazas', '8va Sección', 'Leandro N. Alem', 'San Luis', 'Mendoza', 'Av.Finur 976', 'Pasaje Colon 245', '', 'resuelta', 'finalizada'),
(100, 0, 0, 27, '', '', '', '', '', '', '', '', '', 'no resuelta', 'no finalizada');

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
  `dni` int(11) NOT NULL,
  `estado_responsable` varchar(50) DEFAULT NULL,
  `publicaciones_activas` int(11) DEFAULT 0,
  `promedio_puntuacion` decimal(3,1) DEFAULT NULL,
  `postulaciones_activas` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `email`, `nombre_usuario`, `clave`, `dni`, `estado_responsable`, `publicaciones_activas`, `promedio_puntuacion`, `postulaciones_activas`) VALUES
(27, 'Jeronimo Sturniolo', 'jeronimosturniolo44@gmail.com', 'jero447', '$2y$10$rgcoByGbKrO/Ts/7aqYGDu66ZNkr0CHzMby6b6S4d3eL/0N9a7jRq', 44358758, NULL, 5, 4.5, 0),
(28, 'Bruno', 'bruno@gmail.com', 'bruno123', '$2y$10$62LnP.RHXgMH9xkwXJ/jnuNo2qJ5qyxFKvtpSacsFUzvuIPvnX8pC', 45347896, NULL, 3, 4.7, 1);

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
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD PRIMARY KEY (`idCalificacion`),
  ADD KEY `idUsuario` (`idUsuarioCalificado`),
  ADD KEY `fk_user_calificador` (`idUsuarioCalificador`),
  ADD KEY `fk_publicacion` (`idPublicacion`);

--
-- Indices de la tabla `candidato_seleccionado`
--
ALTER TABLE `candidato_seleccionado`
  ADD PRIMARY KEY (`idSeleccion`),
  ADD KEY `fk_candidato_postulacion` (`idPostulacion`),
  ADD KEY `fk_candidato_publicacion` (`idPublicacion`),
  ADD KEY `fk_candidato_usuarioDueño` (`idUsuarioDueño`),
  ADD KEY `fk_candidato_usuarioSeleccion` (`idUsuarioSeleccionado`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`idMensaje`),
  ADD KEY `idPublicacion` (`idPublicacion`),
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
  MODIFY `idCalificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `candidato_seleccionado`
--
ALTER TABLE `candidato_seleccionado`
  MODIFY `idSeleccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `idMensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `postulacion`
--
ALTER TABLE `postulacion`
  MODIFY `idPostulacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `idPublicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `reset_clave`
--
ALTER TABLE `reset_clave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  ADD CONSTRAINT `calificacion_ibfk_1` FOREIGN KEY (`idUsuarioCalificado`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `fk_publicacion` FOREIGN KEY (`idPublicacion`) REFERENCES `publicacion` (`idPublicacion`),
  ADD CONSTRAINT `fk_user_calificador` FOREIGN KEY (`idUsuarioCalificador`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `candidato_seleccionado`
--
ALTER TABLE `candidato_seleccionado`
  ADD CONSTRAINT `fk_candidato_postulacion` FOREIGN KEY (`idPostulacion`) REFERENCES `postulacion` (`idPostulacion`),
  ADD CONSTRAINT `fk_candidato_publicacion` FOREIGN KEY (`idPublicacion`) REFERENCES `publicacion` (`idPublicacion`),
  ADD CONSTRAINT `fk_candidato_usuarioDueño` FOREIGN KEY (`idUsuarioDueño`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `fk_candidato_usuarioSeleccion` FOREIGN KEY (`idUsuarioSeleccionado`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`idPublicacion`) REFERENCES `publicacion` (`idPublicacion`),
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

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
