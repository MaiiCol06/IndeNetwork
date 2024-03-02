-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 29-02-2024 a las 14:05:13
-- Versión del servidor: 10.5.20-MariaDB
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `id21450707_indenetwork`
--
CREATE DATABASE IF NOT EXISTS `id21450707_indenetwork` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `id21450707_indenetwork`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Grupos`
--

DROP TABLE IF EXISTS `Grupos`;
CREATE TABLE IF NOT EXISTS `Grupos` (
  `GrupoID` int(11) NOT NULL AUTO_INCREMENT,
  `NombreGrupo` varchar(255) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `FotoGrupo` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `Privacidad` enum('Publico','Privado','Cerrado') NOT NULL,
  `Categoria` enum('Extra Escolar','Escolar') NOT NULL,
  `Asignatura` enum('Español','Ingles','Matemáticas','C. Naturales','Química','Fisica','Edu. Fisica','Economía','Sociales','Religion','Filosofia','Estadistica','Geometria','Tecnología','Media Técnica') NOT NULL,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`GrupoID`),
  UNIQUE KEY `NombreGrupo` (`NombreGrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Likes`
--

DROP TABLE IF EXISTS `Likes`;
CREATE TABLE IF NOT EXISTS `Likes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fk_Publicacion` int(11) DEFAULT NULL,
  `fk_Usuario` int(11) DEFAULT NULL,
  `fk_Profesor` int(11) DEFAULT NULL,
  `FechaHora` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`),
  UNIQUE KEY `fk_Profesor` (`fk_Profesor`),
  KEY `fk_Publicacion` (`fk_Publicacion`),
  KEY `fk_Usuario` (`fk_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Profesores`
--

DROP TABLE IF EXISTS `Profesores`;
CREATE TABLE IF NOT EXISTS `Profesores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Documento` int(13) DEFAULT NULL,
  `Correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Contrasena` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Area` enum('Español','Ingles','Matemáticas','C. Naturales','Química','Física','Edu. Física','Economía','Sociales','Religión','Filosofía','Estadística','Geometría','Tecnología','Media Técnica') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `RutaImagenPerfil` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `Biografia` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Documento` (`Documento`),
  UNIQUE KEY `Correo` (`Correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Publicaciones`
--

DROP TABLE IF EXISTS `Publicaciones`;
CREATE TABLE IF NOT EXISTS `Publicaciones` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fk_Usuario` int(11) DEFAULT NULL,
  `TextoContenido` varchar(1000) DEFAULT NULL,
  `ImagenRuta` varchar(1000) DEFAULT NULL,
  `ArchivoRuta` varchar(1000) DEFAULT NULL,
  `FechaHora` timestamp NOT NULL DEFAULT current_timestamp(),
  `fk_Profesor` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_Usuario` (`fk_Usuario`),
  KEY `Publicaciones_ibfk_2` (`fk_Profesor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
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
  `Biografia` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `CorreoElectronico` (`CorreoElectronico`),
  UNIQUE KEY `CorreoElectronico_2` (`CorreoElectronico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Likes`
--
ALTER TABLE `Likes`
  ADD CONSTRAINT `Likes_ibfk_1` FOREIGN KEY (`fk_Publicacion`) REFERENCES `Publicaciones` (`ID`),
  ADD CONSTRAINT `Likes_ibfk_2` FOREIGN KEY (`fk_Usuario`) REFERENCES `usuarios` (`ID`),
  ADD CONSTRAINT `Likes_ibfk_3` FOREIGN KEY (`fk_Profesor`) REFERENCES `Profesores` (`ID`);

--
-- Filtros para la tabla `Publicaciones`
--
ALTER TABLE `Publicaciones`
  ADD CONSTRAINT `Publicaciones_ibfk_1` FOREIGN KEY (`fk_Usuario`) REFERENCES `usuarios` (`ID`),
  ADD CONSTRAINT `Publicaciones_ibfk_2` FOREIGN KEY (`fk_Profesor`) REFERENCES `Profesores` (`ID`);
COMMIT;
