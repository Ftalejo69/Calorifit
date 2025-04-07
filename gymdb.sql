-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-03-2025 a las 01:25:01
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
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contrasena`, `telefono`, `fecha_nacimiento`, `genero`, `peso`, `altura`, `fecha_registro`, `token`, `verificado`) VALUES
(1, 'Juan', 'esteban@gmail.com', '$2y$10$TS4ARSE9N/ZC4ast07BjHOZOqyRaoH1QJ44JarWH5BZK058.2YRmK', '32133123', NULL, NULL, NULL, NULL, '2025-03-19 00:35:43', 2147483647, 0),
(2, 'juan', 'solano@gmail.com', '$2y$10$KyTNFJnQI8ZxEo8Sw6BUSuy5rQVqugQzQRF86MzAsK.T6tYAZBnbG', '321312', NULL, NULL, NULL, NULL, '2025-03-19 01:05:43', 80224, 0),
(3, 'Juanito', 'juanito@gmail.com', '$2y$10$isyYlIlaBOeZ9206uckStOKL1xIRW5zsKKhFFvMIaQRgQtxuqHGNK', '3123123', NULL, NULL, NULL, NULL, '2025-03-26 00:13:41', 3263, 0),
(4, 'juanchis', 'j2005solano@gmail.com', '$2y$10$YkRGmhf1UxIHSXanBwCdhO/YBF2F.fnFT1WykER2Aq84aroc2G8Rq', '3123213', NULL, NULL, NULL, NULL, '2025-03-26 00:22:59', 5, 0);

-- Verificar los datos en la tabla `usuarios`
SELECT * FROM usuarios;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `usuario_id` int(11) NOT NULL,
    `nombre_rutina` varchar(255) NOT NULL,
    `nivel` varchar(100) NOT NULL,
    `fecha` date NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_usuario_id` (`usuario_id`),
    CONSTRAINT `fk_historial_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios_historial`
--

CREATE TABLE `ejercicios_historial` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `historial_id` int(11) NOT NULL,
    `nombre_ejercicio` varchar(255) NOT NULL,
    `series` int(11) NOT NULL,
    `repeticiones` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_historial_id` (`historial_id`),
    CONSTRAINT `fk_ejercicios_historial` FOREIGN KEY (`historial_id`) REFERENCES `historial` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT 'Sin especificar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- Datos iniciales para la tabla `membresias`
INSERT INTO `membresias` (`id`, `nombre`, `precio`, `duracion`, `descripcion`) VALUES
(1, 'Plan FIT', 40000.00, 30, 'Acceso a contenido exclusivo.'),
(2, 'Plan BLACK', 60000.00, 30, 'Acceso premium con beneficios exclusivos.'),
(3, 'Plan CALO', 80000.00, 30, 'Acceso completo a todas las áreas y servicios.');

-- Verificar los datos en la tabla `membresias`
SELECT * FROM membresias;

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

-- Verificar los datos en la tabla `pagos`
SELECT * FROM pagos;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progreso_usuario`
--

CREATE TABLE `progreso_usuario` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `ejercicio_id` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `series` int(11) NOT NULL,
  `repeticiones` int(11) NOT NULL,
  `peso` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `categoria` varchar(50) DEFAULT NULL,
  `nivel` ENUM('Principiante', 'Intermedio', 'Avanzado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_roles`
--

CREATE TABLE `usuarios_roles` (
  `usuario_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `dia` varchar(50) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `rutina_id` int(11) DEFAULT NULL,
  `ejercicio_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Verificar los datos en la tabla `inscripciones`
SELECT * FROM inscripciones;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `ejercicio_id` (`ejercicio_id`);

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
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `membresias`
--
ALTER TABLE `membresias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `progreso_usuario`
--
ALTER TABLE `progreso_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rutinas`
--
ALTER TABLE `rutinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rutina_ejercicios`
--
ALTER TABLE `rutina_ejercicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

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
-- Filtros para la tabla `usuarios_roles`
--
ALTER TABLE `usuarios_roles`
  ADD CONSTRAINT `usuarios_roles_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_roles_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tareas_ibfk_2` FOREIGN KEY (`rutina_id`) REFERENCES `rutinas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tareas_ibfk_3` FOREIGN KEY (`ejercicio_id`) REFERENCES `ejercicios` (`id`) ON DELETE CASCADE;

-- Actualizar datos iniciales para incluir niveles
UPDATE `rutinas` SET `nivel` = 'Principiante' WHERE `nombre` = 'Bajar de Peso';
UPDATE `rutinas` SET `nivel` = 'Intermedio' WHERE `nombre` = 'Ganar Músculo';
UPDATE `rutinas` SET `nivel` = 'Avanzado' WHERE `nombre` = 'Mantenimiento';

-- Insertar nuevas rutinas para cada nivel y objetivo
INSERT INTO `rutinas` (`id`, `usuario_id`, `nombre`, `descripcion`, `fecha_creacion`, `nivel`) VALUES
(4, NULL, 'Bajar de Peso', 'Rutina para principiantes.', NOW(), 'Principiante'),
(5, NULL, 'Bajar de Peso', 'Rutina para intermedios.', NOW(), 'Intermedio'),
(6, NULL, 'Bajar de Peso', 'Rutina para avanzados.', NOW(), 'Avanzado'),
(7, NULL, 'Ganar Músculo', 'Rutina para principiantes.', NOW(), 'Principiante'),
(8, NULL, 'Ganar Músculo', 'Rutina para intermedios.', NOW(), 'Intermedio'),
(9, NULL, 'Ganar Músculo', 'Rutina para avanzados.', NOW(), 'Avanzado'),
(10, NULL, 'Mantenimiento', 'Rutina para principiantes.', NOW(), 'Principiante'),
(11, NULL, 'Mantenimiento', 'Rutina para intermedios.', NOW(), 'Intermedio'),
(12, NULL, 'Mantenimiento', 'Rutina para avanzados.', NOW(), 'Avanzado');

-- Datos iniciales para la tabla `rutinas`
INSERT INTO `rutinas` (`id`, `usuario_id`, `nombre`, `descripcion`, `fecha_creacion`) VALUES
(1, NULL, 'Bajar de Peso', 'Rutina diseñada para reducir grasa corporal.', NOW()),
(2, NULL, 'Ganar Músculo', 'Rutina diseñada para aumentar masa muscular.', NOW()),
(3, NULL, 'Mantenimiento', 'Rutina diseñada para mantener la forma física.', NOW());

-- Datos iniciales para la tabla `ejercicios`
INSERT INTO `ejercicios` (`id`, `nombre`, `descripcion`, `musculo_principal`, `equipo_necesario`) VALUES
(1, 'Cinta de Correr', 'Ejercicio cardiovascular para quemar calorías.', 'Cardio', 'Cinta de correr'),
(2, 'Sentadillas', 'Ejercicio para fortalecer las piernas.', 'Piernas', 'Ninguno'),
(3, 'Plancha', 'Ejercicio para fortalecer el core.', 'Abdomen', 'Ninguno'),
(4, 'Press de Banca', 'Ejercicio para fortalecer el pecho.', 'Pecho', 'Banco y barra'),
(5, 'Dominadas', 'Ejercicio para fortalecer la espalda.', 'Espalda', 'Barra de dominadas'),
(6, 'Peso Muerto', 'Ejercicio para fortalecer la espalda baja y piernas.', 'Espalda', 'Barra'),
(7, 'Bicicleta Estática', 'Ejercicio cardiovascular para mantener la forma.', 'Cardio', 'Bicicleta estática'),
(8, 'Flexiones', 'Ejercicio para fortalecer el pecho y tríceps.', 'Pecho', 'Ninguno'),
(9, 'Abdominales', 'Ejercicio para fortalecer el abdomen.', 'Abdomen', 'Ninguno');

-- Datos adicionales para ejercicios de nivel Intermedio
INSERT INTO `ejercicios` (`id`, `nombre`, `descripcion`, `musculo_principal`, `equipo_necesario`) VALUES
(10, 'Press Militar', 'Ejercicio para desarrollar los hombros.', 'Hombros', 'Barra y discos'),
(11, 'Remo con Barra', 'Ejercicio para fortalecer la espalda media.', 'Espalda', 'Barra'),
(12, 'Extensiones de Tríceps', 'Ejercicio para aislar el tríceps.', 'Tríceps', 'Polea'),
(13, 'Curl de Bíceps', 'Ejercicio para desarrollar los bíceps.', 'Bíceps', 'Mancuernas'),
(14, 'Prensa de Piernas', 'Ejercicio para desarrollar cuádriceps.', 'Piernas', 'Máquina prensa');

-- Datos adicionales para ejercicios de nivel Avanzado
INSERT INTO `ejercicios` (`id`, `nombre`, `descripcion`, `musculo_principal`, `equipo_necesario`) VALUES
(15, 'Clean and Jerk', 'Levantamiento olímpico complejo.', 'Piernas', 'Barra olímpica'),
(16, 'Muscle Up', 'Ejercicio avanzado de calistenia.', 'Espalda', 'Barra dominadas'),
(17, 'Snatch', 'Levantamiento olímpico explosivo.', 'Piernas', 'Barra olímpica'),
(18, 'Handstand Push Up', 'Flexiones invertidas.', 'Hombros', 'Ninguno'),
(19, 'Dragon Flag', 'Ejercicio avanzado de core.', 'Abdomen', 'Banco plano');

-- Datos iniciales para la tabla `rutina_ejercicios`
INSERT INTO `rutina_ejercicios` (`id`, `rutina_id`, `ejercicio_id`, `series`, `repeticiones`, `peso`, `descanso_seg`) VALUES
(1, 1, 1, 0, 0, 0, 0), -- Cinta de Correr (Bajar de Peso)
(2, 1, 2, 3, 15, 0, 60), -- Sentadillas (Bajar de Peso)
(3, 1, 3, 3, 1, 0, 30), -- Plancha (Bajar de Peso)
(4, 2, 4, 4, 10, 50, 90), -- Press de Banca (Ganar Músculo)
(5, 2, 5, 3, 8, 0, 60), -- Dominadas (Ganar Músculo)
(6, 2, 6, 4, 8, 70, 90), -- Peso Muerto (Ganar Músculo)
(7, 3, 7, 0, 0, 0, 0), -- Bicicleta Estática (Mantenimiento)
(8, 3, 8, 3, 12, 0, 45), -- Flexiones (Mantenimiento)
(9, 3, 9, 3, 20, 0, 30); -- Abdominales (Mantenimiento)

-- Datos adicionales para la tabla `rutina_ejercicios`
INSERT INTO `rutina_ejercicios` (`id`, `rutina_id`, `ejercicio_id`, `series`, `repeticiones`, `peso`, `descanso_seg`) VALUES
(10, 1, 7, 0, 0, 0, 0), -- Bicicleta Estática (Bajar de Peso)
(11, 1, 8, 3, 12, 0, 45), -- Flexiones (Bajar de Peso)
(12, 2, 2, 4, 10, 0, 60), -- Sentadillas (Ganar Músculo)
(13, 2, 3, 3, 1, 0, 30), -- Plancha (Ganar Músculo)
(14, 3, 4, 3, 8, 50, 60), -- Press de Banca (Mantenimiento)
(15, 3, 5, 3, 10, 0, 60); -- Dominadas (Mantenimiento)

-- Asignar ejercicios a rutinas de nivel Intermedio
INSERT INTO `rutina_ejercicios` (`rutina_id`, `ejercicio_id`, `series`, `repeticiones`, `peso`, `descanso_seg`) VALUES
(5, 10, 4, 12, 40, 90), -- Press Militar (Intermedio)
(5, 11, 4, 10, 60, 90), -- Remo con Barra (Intermedio)
(5, 12, 3, 15, 30, 60), -- Extensiones de Tríceps (Intermedio)
(5, 13, 3, 12, 15, 60), -- Curl de Bíceps (Intermedio)
(5, 14, 4, 12, 120, 120); -- Prensa de Piernas (Intermedio)

-- Asignar ejercicios a rutinas de nivel Avanzado
INSERT INTO `rutina_ejercicios` (`rutina_id`, `ejercicio_id`, `series`, `repeticiones`, `peso`, `descanso_seg`) VALUES
(6, 15, 5, 3, 80, 180), -- Clean and Jerk (Avanzado)
(6, 16, 4, 5, 0, 180), -- Muscle Up (Avanzado)
(6, 17, 5, 3, 70, 180), -- Snatch (Avanzado)
(6, 18, 4, 8, 0, 120), -- Handstand Push Up (Avanzado)
(6, 19, 3, 10, 0, 120); -- Dragon Flag (Avanzado)

-- Asignar ejercicios para Ganar Músculo nivel Intermedio (rutina_id = 8)
INSERT INTO `rutina_ejercicios` (`rutina_id`, `ejercicio_id`, `series`, `repeticiones`, `peso`, `descanso_seg`) VALUES
(8, 10, 5, 10, 50, 120), -- Press Militar con más peso
(8, 11, 4, 12, 70, 120), -- Remo con Barra pesado
(8, 12, 4, 12, 35, 90),  -- Extensiones de Tríceps
(8, 13, 4, 12, 20, 90),  -- Curl de Bíceps con más peso
(8, 14, 5, 10, 150, 150); -- Prensa de Piernas pesada

-- Asignar ejercicios para Ganar Músculo nivel Avanzado (rutina_id = 9)
INSERT INTO `rutina_ejercicios` (`rutina_id`, `ejercicio_id`, `series`, `repeticiones`, `peso`, `descanso_seg`) VALUES
(9, 15, 6, 4, 100, 180), -- Clean and Jerk pesado
(9, 16, 5, 8, 0, 180),   -- Muscle Ups
(9, 17, 6, 4, 90, 180),  -- Snatch pesado
(9, 18, 5, 10, 0, 150),  -- Handstand Push Ups
(9, 19, 4, 12, 0, 120);  -- Dragon Flag series largas

-- Asignar ejercicios para Mantenimiento nivel Intermedio (rutina_id = 11)
INSERT INTO `rutina_ejercicios` (`rutina_id`, `ejercicio_id`, `series`, `repeticiones`, `peso`, `descanso_seg`) VALUES
(11, 10, 3, 15, 30, 60),  -- Press Militar ligero
(11, 11, 3, 15, 40, 60),  -- Remo con Barra 
(11, 12, 4, 12, 25, 45),  -- Extensiones de Tríceps
(11, 13, 4, 12, 12, 45),  -- Curl de Bíceps
(11, 14, 3, 15, 100, 90); -- Prensa de Piernas

-- Asignar ejercicios para Mantenimiento nivel Avanzado (rutina_id = 12)
INSERT INTO `rutina_ejercicios` (`rutina_id`, `ejercicio_id`, `series`, `repeticiones`, `peso`, `descanso_seg`) VALUES
(12, 15, 4, 5, 60, 120),  -- Clean and Jerk técnica
(12, 16, 3, 6, 0, 120),   -- Muscle Ups controlados
(12, 17, 4, 5, 50, 120),  -- Snatch técnica
(12, 18, 3, 12, 0, 90),   -- Handstand Push Ups
(12, 19, 3, 15, 0, 90);   -- Dragon Flag resistencia

-- Verificar los datos en la tabla `rutinas`
SELECT * FROM rutinas;

-- Verificar los datos en la tabla `rutina_ejercicios`
SELECT * FROM rutina_ejercicios;

-- Verificar la estructura actualizada
DESCRIBE `usuarios`;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
