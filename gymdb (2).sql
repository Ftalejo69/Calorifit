-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2025 a las 07:19:27
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

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id`, `usuario_id`, `nombre_rutina`, `nivel`, `fecha`) VALUES
(1, 9, 'Ganar Músculo', 'Intermedio', '2025-04-09');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresias`
--

CREATE TABLE `membresias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `duracion` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membresias`
--

INSERT INTO `membresias` (`id`, `nombre`, `precio`, `duracion`, `descripcion`) VALUES
(1, 'Plan FIT', 40000.00, 30, 'Acceso a contenido exclusivo.'),
(2, 'Plan BLACK', 60000.00, 30, 'Acceso premium con beneficios exclusivos.'),
(3, 'Plan CALO', 80000.00, 30, 'Acceso completo a todas las áreas y servicios.');

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

--
-- Volcado de datos para la tabla `progreso_usuario`
--

INSERT INTO `progreso_usuario` (`id`, `usuario_id`, `ejercicio_id`, `fecha`, `series`, `repeticiones`, `peso`, `historial_id`) VALUES
(1, 1, 1, '2025-04-08', 3, 12, 50.00, NULL),
(2, 1, 2, '2025-04-08', 4, 10, 60.00, NULL),
(3, 9, 4, '2025-04-09', 4, 10, 30.00, 1),
(4, 9, 11, '2025-04-09', 4, 10, 25.00, 1);

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
(2, 'usuario'),
(3, 'entrenador');

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
  `nivel` enum('Principiante','Intermedio','Avanzado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutinas`
--

INSERT INTO `rutinas` (`id`, `usuario_id`, `nombre`, `descripcion`, `fecha_creacion`, `nivel`) VALUES
(1, NULL, 'Bajar de Peso', 'Rutina diseñada para reducir grasa corporal.', '2025-04-08 12:26:14', 'Principiante'),
(2, NULL, 'Ganar Músculo', 'Rutina diseñada para aumentar masa muscular.', '2025-04-08 12:26:14', 'Principiante'),
(3, NULL, 'Mantenimiento', 'Rutina diseñada para mantener la forma física.', '2025-04-08 12:26:14', 'Principiante'),
(5, NULL, 'Bajar de Peso', 'Rutina para intermedios.', '2025-04-08 12:26:14', 'Intermedio'),
(6, NULL, 'Bajar de Peso', 'Rutina para avanzados.', '2025-04-08 12:26:14', 'Avanzado'),
(7, NULL, 'Ganar Músculo', 'Rutina para principiantes.', '2025-04-08 12:26:14', 'Principiante'),
(8, NULL, 'Ganar Músculo', 'Rutina para intermedios.', '2025-04-08 12:26:14', 'Intermedio'),
(9, NULL, 'Ganar Músculo', 'Rutina para avanzados.', '2025-04-08 12:26:14', 'Avanzado'),
(10, NULL, 'Mantenimiento', 'Rutina para principiantes.', '2025-04-08 12:26:14', 'Principiante'),
(11, NULL, 'Mantenimiento', 'Rutina para intermedios.', '2025-04-08 12:26:14', 'Intermedio'),
(12, NULL, 'Mantenimiento', 'Rutina para avanzados.', '2025-04-08 12:26:14', 'Avanzado');

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
(7, 2, 4, 4, 10, 20.00, 90),
(8, 2, 13, 3, 12, 10.00, 60),
(9, 2, 12, 3, 12, 15.00, 60),
(10, 2, 10, 4, 10, 15.00, 90),
(11, 2, 11, 4, 10, 20.00, 90),
(12, 3, 1, 1, 0, 0.00, 30),
(13, 3, 2, 3, 12, 0.00, 60),
(14, 3, 8, 3, 10, 0.00, 60),
(15, 3, 9, 3, 15, 0.00, 45),
(16, 5, 1, 1, 0, 0.00, 30),
(17, 5, 7, 1, 0, 0.00, 30),
(18, 5, 2, 4, 15, 15.00, 45),
(19, 5, 14, 4, 12, 40.00, 60),
(20, 5, 9, 4, 20, 0.00, 45),
(21, 6, 15, 5, 5, 40.00, 120),
(22, 6, 17, 5, 3, 30.00, 120),
(23, 6, 16, 4, 5, 0.00, 90),
(24, 6, 19, 3, 10, 0.00, 60),
(25, 7, 4, 3, 12, 10.00, 60),
(26, 7, 13, 3, 12, 5.00, 60),
(27, 7, 2, 3, 12, 5.00, 60),
(28, 8, 4, 4, 10, 30.00, 90),
(29, 8, 11, 4, 10, 25.00, 90),
(30, 8, 14, 4, 12, 50.00, 90),
(31, 9, 15, 5, 5, 50.00, 120),
(32, 9, 16, 5, 8, 0.00, 90),
(33, 9, 17, 5, 3, 40.00, 120),
(34, 10, 1, 1, 0, 0.00, 30),
(35, 10, 8, 3, 10, 0.00, 45),
(36, 10, 3, 3, 30, 0.00, 45),
(37, 11, 4, 4, 10, 25.00, 75),
(38, 11, 11, 4, 10, 20.00, 75),
(39, 11, 2, 4, 12, 20.00, 75),
(40, 12, 18, 4, 8, 0.00, 90),
(41, 12, 16, 4, 6, 0.00, 90),
(42, 12, 19, 4, 8, 0.00, 90);

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
  `fecha_token` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contrasena`, `telefono`, `fecha_nacimiento`, `genero`, `peso`, `altura`, `fecha_registro`, `token`, `verificado`, `token_recuperacion`, `fecha_token`) VALUES
(1, 'Juan', 'esteban@gmail.com', '$2y$10$TS4ARSE9N/ZC4ast07BjHOZOqyRaoH1QJ44JarWH5BZK058.2YRmK', '32133123', NULL, NULL, NULL, NULL, '2025-03-19 00:35:43', 2147483647, 0, NULL, NULL),
(2, 'juan', 'solano@gmail.com', '$2y$10$KyTNFJnQI8ZxEo8Sw6BUSuy5rQVqugQzQRF86MzAsK.T6tYAZBnbG', '321312', NULL, NULL, NULL, NULL, '2025-03-19 01:05:43', 80224, 0, NULL, NULL),
(3, 'Juanito', 'juanito@gmail.com', '$2y$10$isyYlIlaBOeZ9206uckStOKL1xIRW5zsKKhFFvMIaQRgQtxuqHGNK', '3123123', NULL, NULL, NULL, NULL, '2025-03-26 00:13:41', 3263, 0, NULL, NULL),
(4, 'juanchis', 'j2005solano@gmail.com', '$2y$10$YkRGmhf1UxIHSXanBwCdhO/YBF2F.fnFT1WykER2Aq84aroc2G8Rq', '3123213', NULL, NULL, NULL, NULL, '2025-03-26 00:22:59', 5, 0, NULL, NULL),
(7, 'edewf', 'eddie@gmail.com', '$2y$10$i45UVy3ykLlRsThddjBH8Oli266us/st8t6mcjHE56nEyQXmpwYam', '1233566', NULL, NULL, NULL, NULL, '2025-04-08 12:50:57', 468843, 0, NULL, NULL),
(8, 'samuel', 'samuel@gmail.com', '$2y$10$mbtcfBeudMireqVSa2Hrg.t1zzWSpjVxXYCeaHLPMV3E4DxaBwI1q', '3123123', NULL, NULL, NULL, NULL, '2025-04-08 12:57:31', 76, 0, NULL, NULL),
(9, 'samuel', 'alejo@gmail.com', '$2y$10$Hrmsdld1gshtIAce8ufKYuZGvOqmehUa7BCrskpdiHSrn2j1P9lHG', '2342344', NULL, NULL, NULL, NULL, '2025-04-09 04:22:51', 4, 0, NULL, NULL),
(13, 'Administrador', 'admin@calorifit.com', '$2y$10$6R.L0ThwWYZJkhyxXnj9.uh1qQAmQIX71.p5p1Z3wVwGpyOgl34x2', '999999999', NULL, NULL, NULL, NULL, '2025-04-09 05:03:39', NULL, 1, NULL, NULL),
(14, 'samuel', 'alejovital42@gmail.com', '$2y$10$T.DwqlE.l7vBl17.kR5KTuc3qsMgQRsLlpCwaUdmsPCHpK.1cp0DC', '12312345', NULL, NULL, NULL, NULL, '2025-04-09 05:06:33', NULL, 1, NULL, NULL),
(15, 'alejo', 'samitobch@gmail.com', '$2y$10$AnVXJu7/iFoBodnLPn9QsuxcqJD.z5IatqCjMNgJZUUHfdycZY5vi', '23424234', NULL, NULL, NULL, NULL, '2025-04-09 05:12:25', NULL, 1, NULL, NULL),
(16, 'Juan Solano', 'juan.solano@calorifit.com', '$2y$10$randomhash', '123456789', NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, 1, NULL, NULL),
(17, 'Ana García', 'ana.garcia@calorifit.com', '$2y$10$randomhash', '123456789', NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, 1, NULL, NULL),
(18, 'Carlos Mendoza', 'carlos.mendoza@calorifit.com', '$2y$10$randomhash', '123456789', NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, 1, NULL, NULL),
(19, 'María López', 'maria.lopez@calorifit.com', '$2y$10$randomhash', '123456789', NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, 1, NULL, NULL);

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
(13, 1),
(14, 1);

-- Asignar rol de entrenador a los nuevos usuarios
INSERT INTO `usuarios_roles` (`usuario_id`, `rol_id`)
SELECT `id`, 3 FROM `usuarios` 
WHERE `id` NOT IN (SELECT `usuario_id` FROM `usuarios_roles`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `membresias`
--
ALTER TABLE `membresias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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

--
-- Eliminar la tabla entrenadores
--
DROP TABLE IF EXISTS `entrenadores`;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
