SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `Grupos` (
  `GrupoID` int(11) NOT NULL,
  `NombreGrupo` varchar(255) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `FotoGrupo` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `Privacidad` enum('Publico','Privado','Cerrado') NOT NULL,
  `Categoria` enum('Extra Escolar','Escolar') NOT NULL,
  `Asignatura` enum('Español','Ingles','Matemáticas','C. Naturales','Química','Fisica','Edu. Fisica','Economía','Sociales','Religion','Filosofia','Estadistica','Geometria','Tecnología','Media Técnica') NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `Likes` (
  `ID` int(11) NOT NULL,
  `fk_Publicacion` int(11) DEFAULT NULL,
  `fk_Usuario` int(11) DEFAULT NULL,
  `fk_Profesor` int(11) DEFAULT NULL,
  `FechaHora` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `Profesores` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Documento` int(13) DEFAULT NULL,
  `Correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Contrasena` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Area` enum('Español','Artística','Ingles','Matemáticas','C. Naturales','Química','Física','Edu. Física','Economía','Sociales','Religión','Filosofía','Estadística','Geometría','Tecnología','Media Técnica') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `RutaImagenPerfil` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Biografia` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `Publicaciones` (
  `ID` int(11) NOT NULL,
  `fk_Usuario` int(11) DEFAULT NULL,
  `TextoContenido` varchar(1000) DEFAULT NULL,
  `ImagenRuta` varchar(1000) DEFAULT NULL,
  `ArchivoRuta` varchar(1000) DEFAULT NULL,
  `FechaHora` timestamp NOT NULL DEFAULT current_timestamp(),
  `fk_Profesor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Apellido` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CorreoElectronico` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `Contrasena` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FechaNacimiento` date DEFAULT NULL,
  `Grado` int(2) DEFAULT NULL,
  `Grupo` int(1) DEFAULT NULL,
  `Intereses` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `FechaRegistro` timestamp NOT NULL DEFAULT current_timestamp(),
  `RutaImagenPerfil` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Biografia` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


ALTER TABLE `Grupos`
  ADD PRIMARY KEY (`GrupoID`),
  ADD UNIQUE KEY `NombreGrupo` (`NombreGrupo`);

ALTER TABLE `Likes`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `fk_Profesor` (`fk_Profesor`),
  ADD KEY `fk_Publicacion` (`fk_Publicacion`),
  ADD KEY `fk_Usuario` (`fk_Usuario`);

ALTER TABLE `Profesores`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Documento` (`Documento`),
  ADD UNIQUE KEY `Correo` (`Correo`);

ALTER TABLE `Publicaciones`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_Usuario` (`fk_Usuario`),
  ADD KEY `Publicaciones_ibfk_2` (`fk_Profesor`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `CorreoElectronico` (`CorreoElectronico`),
  ADD UNIQUE KEY `CorreoElectronico_2` (`CorreoElectronico`);


ALTER TABLE `Grupos`
  MODIFY `GrupoID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Likes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Profesores`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Publicaciones`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `Likes`
  ADD CONSTRAINT `Likes_ibfk_1` FOREIGN KEY (`fk_Publicacion`) REFERENCES `Publicaciones` (`ID`),
  ADD CONSTRAINT `Likes_ibfk_2` FOREIGN KEY (`fk_Usuario`) REFERENCES `usuarios` (`ID`),
  ADD CONSTRAINT `Likes_ibfk_3` FOREIGN KEY (`fk_Profesor`) REFERENCES `Profesores` (`ID`);

ALTER TABLE `Publicaciones`
  ADD CONSTRAINT `Publicaciones_ibfk_1` FOREIGN KEY (`fk_Usuario`) REFERENCES `usuarios` (`ID`),
  ADD CONSTRAINT `Publicaciones_ibfk_2` FOREIGN KEY (`fk_Profesor`) REFERENCES `Profesores` (`ID`);
