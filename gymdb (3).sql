-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-04-2025 a las 05:27:17
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
-- Base de datos: `gymdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios`
--

CREATE TABLE `ejercicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `musculo_principal` enum('Pecho','Espalda','Piernas','Bíceps','Tríceps','Hombros','Abdomen','Cardio') DEFAULT NULL,
  `equipo_necesario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejercicios`
--

INSERT INTO `ejercicios` (`id`, `nombre`, `descripcion`, `musculo_principal`, `equipo_necesario`) VALUES
(1, 'Cinta de Correr', 'Ejercicio cardiovascular para quemar calorías.', 'Cardio', 'Cinta de correr'),
(2, 'Sentadillas', 'Ejercicio para fortalecer las piernas.', 'Piernas', 'Ninguno'),
(3, 'Plancha', 'Ejercicio para fortalecer el core.', 'Abdomen', 'Ninguno'),
(4, 'Press de Banca', 'Ejercicio para fortalecer el pecho.', 'Pecho', 'Banco y barra'),
(5, 'Dominadas', 'Ejercicio para fortalecer la espalda.', 'Espalda', 'Barra de dominadas'),
(6, 'Peso Muerto', 'Ejercicio para fortalecer la espalda baja y piernas.', 'Espalda', 'Barra'),
(7, 'Bicicleta Estática', 'Ejercicio cardiovascular para mantener la forma.', 'Cardio', 'Bicicleta estática'),
(8, 'Flexiones', 'Ejercicio para fortalecer el pecho y tríceps.', 'Pecho', 'Ninguno'),
(9, 'Abdominales', 'Ejercicio para fortalecer el abdomen.', 'Abdomen', 'Ninguno'),
(10, 'Press Militar', 'Ejercicio para desarrollar los hombros.', 'Hombros', 'Barra y discos'),
(11, 'Remo con Barra', 'Ejercicio para fortalecer la espalda media.', 'Espalda', 'Barra'),
(12, 'Extensiones de Tríceps', 'Ejercicio para aislar el tríceps.', 'Tríceps', 'Polea'),
(13, 'Curl de Bíceps', 'Ejercicio para desarrollar los bíceps.', 'Bíceps', 'Mancuernas'),
(14, 'Prensa de Piernas', 'Ejercicio para desarrollar cuádriceps.', 'Piernas', 'Máquina prensa'),
(15, 'Clean and Jerk', 'Levantamiento olímpico complejo.', 'Piernas', 'Barra olímpica'),
(16, 'Muscle Up', 'Ejercicio avanzado de calistenia.', 'Espalda', 'Barra dominadas'),
(17, 'Snatch', 'Levantamiento olímpico explosivo.', 'Piernas', 'Barra olímpica'),
(18, 'Handstand Push Up', 'Flexiones invertidas.', 'Hombros', 'Ninguno'),
(19, 'Dragon Flag', 'Ejercicio avanzado de core.', 'Abdomen', 'Banco plano');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre_rutina` varchar(255) NOT NULL,
  `nivel` varchar(100) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `membresia_id` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id`, `usuario_id`, `membresia_id`, `fecha_inicio`, `fecha_fin`) VALUES
(3, 14, 5, '2025-04-11', '2025-05-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresias`
--

CREATE TABLE `membresias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `duracion` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `beneficios` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membresias`
--

INSERT INTO `membresias` (`id`, `nombre`, `precio`, `duracion`, `descripcion`, `beneficios`) VALUES
(2, 'Plan BLACK', 80000.00, 30, 'mas premium', '[\"Spa y masajes\",\"Descuentos en marcas aliadas\",\"App personalizada\"]'),
(3, 'Plan CALO', 60000.00, 30, 'Acceso completo a todas las áreas y servicios.', '[\"App personalizada\"]'),
(5, 'FIT', 40000.00, 30, 'plan....', '[\"melo\"]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `metodo_pago` enum('Efectivo','Tarjeta','Transferencia') NOT NULL,
  `inscripcion_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `usuario_id`, `monto`, `fecha_pago`, `metodo_pago`, `inscripcion_id`) VALUES
(3, 14, 40000.00, '2025-04-11 01:21:07', '', 3),
(4, 14, 21313.00, '2025-04-11 01:21:17', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progreso_usuario`
--

CREATE TABLE `progreso_usuario` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `ejercicio_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `series` int(11) NOT NULL,
  `repeticiones` int(11) NOT NULL,
  `peso` decimal(5,2) NOT NULL,
  `historial_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT 'Sin especificar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'admin'),
(3, 'entrenador'),
(2, 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutinas`
--

CREATE TABLE `rutinas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `nivel` enum('Principiante','Intermedio','Avanzado') NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutinas`
--

INSERT INTO `rutinas` (`id`, `usuario_id`, `nombre`, `descripcion`, `fecha_creacion`, `nivel`, `imagen`) VALUES
(1, NULL, 'Bajar de Peso', 'Rutina diseñada para reducir grasa corporal.', '2025-04-08 12:26:14', 'Principiante', NULL),
(5, NULL, 'Bajar de Peso', 'Rutina para intermedios.', '2025-04-08 12:26:14', 'Intermedio', NULL),
(9, NULL, 'Ganar Músculo', 'Rutina para avanzados.', '2025-04-08 12:26:14', 'Avanzado', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutina_ejercicios`
--

CREATE TABLE `rutina_ejercicios` (
  `id` int(11) NOT NULL,
  `rutina_id` int(11) DEFAULT NULL,
  `ejercicio_id` int(11) DEFAULT NULL,
  `series` int(11) NOT NULL,
  `repeticiones` int(11) NOT NULL,
  `peso` decimal(5,2) NOT NULL,
  `descanso_seg` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutina_ejercicios`
--

INSERT INTO `rutina_ejercicios` (`id`, `rutina_id`, `ejercicio_id`, `series`, `repeticiones`, `peso`, `descanso_seg`) VALUES
(1, 1, 1, 1, 0, 0.00, 60),
(2, 1, 7, 1, 0, 0.00, 60),
(3, 1, 9, 4, 12, 0.00, 60),
(4, 1, 2, 4, 12, 5.00, 60),
(5, 1, 3, 4, 0, 0.00, 60),
(6, 1, 8, 4, 12, 0.00, 60),
(16, 5, 1, 1, 0, 0.00, 30),
(17, 5, 7, 1, 0, 0.00, 30),
(18, 5, 2, 4, 15, 15.00, 45),
(19, 5, 14, 4, 12, 40.00, 60),
(20, 5, 9, 4, 20, 0.00, 45),
(31, 9, 15, 5, 5, 50.00, 120),
(32, 9, 16, 5, 8, 0.00, 90),
(33, 9, 17, 5, 3, 40.00, 120);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `dia` varchar(50) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `rutina_id` int(11) DEFAULT NULL,
  `ejercicio_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` enum('M','F','Otro') DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `altura` decimal(5,2) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `token` int(255) DEFAULT NULL,
  `verificado` tinyint(1) NOT NULL,
  `token_recuperacion` varchar(64) DEFAULT NULL,
  `fecha_token` datetime DEFAULT NULL,
  `imagen` varchar(255) DEFAULT 'entrenador-default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contrasena`, `telefono`, `fecha_nacimiento`, `genero`, `peso`, `altura`, `fecha_registro`, `token`, `verificado`, `token_recuperacion`, `fecha_token`, `imagen`) VALUES
(2, 'juan', 'solano@gmail.com', '$2y$10$KyTNFJnQI8ZxEo8Sw6BUSuy5rQVqugQzQRF86MzAsK.T6tYAZBnbG', '321312', NULL, NULL, NULL, NULL, '2025-03-19 01:05:43', 80224, 0, NULL, NULL, 'solno.jpeg'),
(7, 'edewf', 'eddie@gmail.com', '$2y$10$i45UVy3ykLlRsThddjBH8Oli266us/st8t6mcjHE56nEyQXmpwYam', '1233566', NULL, NULL, NULL, NULL, '2025-04-08 12:50:57', 468843, 0, NULL, NULL, 'entrenador_67f88aadb5208.jpeg'),
(8, 'samuel', 'samuel@gmail.com', '$2y$10$mbtcfBeudMireqVSa2Hrg.t1zzWSpjVxXYCeaHLPMV3E4DxaBwI1q', '3123123', NULL, NULL, NULL, NULL, '2025-04-08 12:57:31', 76, 0, NULL, NULL, 'entrenador_67f88a96ae851.jpeg'),
(13, 'Administrador', 'admin@calorifit.com', '$2y$10$6R.L0ThwWYZJkhyxXnj9.uh1qQAmQIX71.p5p1Z3wVwGpyOgl34x2', '999999999', NULL, NULL, NULL, NULL, '2025-04-09 05:03:39', NULL, 1, NULL, NULL, 'entrenador-default.jpg'),
(14, 'samuel', 'alejovital42@gmail.com', '$2y$10$T.DwqlE.l7vBl17.kR5KTuc3qsMgQRsLlpCwaUdmsPCHpK.1cp0DC', '12312345', NULL, NULL, NULL, NULL, '2025-04-09 05:06:33', NULL, 1, NULL, NULL, 'entrenador-default.jpg'),
(21, 'samuel', 'samitobch@gmail.com', '$2y$10$zPq8ni.nWyDiWVxoJtrCPeoIVeKZQNWL6OR/B/J44VzPeS/EiiG.2', '312312', NULL, NULL, NULL, NULL, '2025-04-11 02:25:51', NULL, 1, NULL, NULL, 'entrenador-default.jpg'),
(23, 'wefwef7', 'admin@calorifi7t.com', '', '324235', NULL, NULL, NULL, NULL, '2025-04-11 03:24:05', NULL, 1, '8684a31dc3ca433f01cf65062cbb241c', '2025-04-10 22:24:05', 'entrenador_67f88b55671a1.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_roles`
--

CREATE TABLE `usuarios_roles` (
  `usuario_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_roles`
--

INSERT INTO `usuarios_roles` (`usuario_id`, `rol_id`) VALUES
(2, 3),
(7, 3),
(8, 3),
(13, 1),
(14, 1),
(21, 2),
(23, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `membresia_id` (`membresia_id`);

--
-- Indices de la tabla `membresias`
--
ALTER TABLE `membresias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `fk_inscripcion` (`inscripcion_id`);

--
-- Indices de la tabla `progreso_usuario`
--
ALTER TABLE `progreso_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario_ejercicio` (`usuario_id`,`ejercicio_id`),
  ADD KEY `fk_progreso_historial` (`historial_id`),
  ADD KEY `progreso_usuario_ibfk_2` (`ejercicio_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `rutinas`
--
ALTER TABLE `rutinas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `rutina_ejercicios`
--
ALTER TABLE `rutina_ejercicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rutina_id` (`rutina_id`),
  ADD KEY `ejercicio_id` (`ejercicio_id`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tareas_ibfk_1` (`usuario_id`),
  ADD KEY `tareas_ibfk_2` (`rutina_id`),
  ADD KEY `tareas_ibfk_3` (`ejercicio_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`correo`);

--
-- Indices de la tabla `usuarios_roles`
--
ALTER TABLE `usuarios_roles`
  ADD PRIMARY KEY (`usuario_id`,`rol_id`),
  ADD KEY `usuario_id_idx` (`usuario_id`),
  ADD KEY `rol_id_idx` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `membresias`
--
ALTER TABLE `membresias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `progreso_usuario`
--
ALTER TABLE `progreso_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `rutinas`
--
ALTER TABLE `rutinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `rutina_ejercicios`
--
ALTER TABLE `rutina_ejercicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `fk_historial_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`membresia_id`) REFERENCES `membresias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_inscripcion` FOREIGN KEY (`inscripcion_id`) REFERENCES `inscripciones` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `progreso_usuario`
--
ALTER TABLE `progreso_usuario`
  ADD CONSTRAINT `fk_progreso_ejercicio` FOREIGN KEY (`ejercicio_id`) REFERENCES `ejercicios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_progreso_historial` FOREIGN KEY (`historial_id`) REFERENCES `historial` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_progreso_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `progreso_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `progreso_usuario_ibfk_2` FOREIGN KEY (`ejercicio_id`) REFERENCES `ejercicios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rutinas`
--
ALTER TABLE `rutinas`
  ADD CONSTRAINT `rutinas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rutina_ejercicios`
--
ALTER TABLE `rutina_ejercicios`
  ADD CONSTRAINT `rutina_ejercicios_ibfk_1` FOREIGN KEY (`rutina_id`) REFERENCES `rutinas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rutina_ejercicios_ibfk_2` FOREIGN KEY (`ejercicio_id`) REFERENCES `ejercicios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tareas_ibfk_2` FOREIGN KEY (`rutina_id`) REFERENCES `rutinas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tareas_ibfk_3` FOREIGN KEY (`ejercicio_id`) REFERENCES `ejercicios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios_roles`
--
ALTER TABLE `usuarios_roles`
  ADD CONSTRAINT `usuarios_roles_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_roles_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
