-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 16, 2024 at 08:24 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpe_web2`
--

-- --------------------------------------------------------

--
-- Table structure for table `Biblioteca`
--

CREATE TABLE `Biblioteca` (
  `id_usuario` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Biblioteca`
--

INSERT INTO `Biblioteca` (`id_usuario`, `id_libro`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Libros`
--

CREATE TABLE `Libros` (
  `id_libro` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `genero` varchar(100) NOT NULL,
  `paginas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Libros`
--

INSERT INTO `Libros` (`id_libro`, `titulo`, `autor`, `genero`, `paginas`) VALUES
(1, 'Titulo 1', 'autor', 'genero', 70),
(2, 'Titulo 2', 'autor', 'genero', 80),
(3, 'Titulo 3', 'autor', 'genero', 77),
(4, 'Titulo 4', 'autor', 'genero', 90);

-- --------------------------------------------------------

--
-- Table structure for table `Puntuacion`
--

CREATE TABLE `Puntuacion` (
  `id_usuario` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `puntuacion` double NOT NULL,
  `comentario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Puntuacion`
--

INSERT INTO `Puntuacion` (`id_usuario`, `id_libro`, `puntuacion`, `comentario`) VALUES
(1, 1, 5, ''),
(2, 2, 4, ''),
(3, 1, 3, ''),
(1, 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `Usuarios`
--

CREATE TABLE `Usuarios` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Usuarios`
--

INSERT INTO `Usuarios` (`id_usuario`, `email`, `password`) VALUES
(1, 'ejemplo@user.com', 'root'),
(2, 'ejemplo2@user.com', 'root'),
(3, 'ejemplo3@user.com', 'root');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Biblioteca`
--
ALTER TABLE `Biblioteca`
  ADD KEY `fk_Biblioteca_Usuarios` (`id_usuario`),
  ADD KEY `fk_Biblioteca_Libros` (`id_libro`);

--
-- Indexes for table `Libros`
--
ALTER TABLE `Libros`
  ADD PRIMARY KEY (`id_libro`);

--
-- Indexes for table `Puntuacion`
--
ALTER TABLE `Puntuacion`
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indexes for table `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Libros`
--
ALTER TABLE `Libros`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Biblioteca`
--
ALTER TABLE `Biblioteca`
  ADD CONSTRAINT `fk_Biblioteca_Libros` FOREIGN KEY (`id_libro`) REFERENCES `Libros` (`id_libro`),
  ADD CONSTRAINT `fk_Biblioteca_Usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id_usuario`);

--
-- Constraints for table `Puntuacion`
--
ALTER TABLE `Puntuacion`
  ADD CONSTRAINT `fk_Puntuacion_Libros` FOREIGN KEY (`id_libro`) REFERENCES `Libros` (`id_libro`),
  ADD CONSTRAINT `fk_Puntuacion_Usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
