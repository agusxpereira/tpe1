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
ALTER TABLE `Libros`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

### Insertar datos en la tabla Usuarios:

INSERT INTO Usuarios (email, password) VALUES
( 'user1@Gmail.com', 'password1'),
( 'user2@Gmail.com', 'password2'),
( 'user3@Gmail.com', 'password3');

### Insertar datos en la tabla Libros:

INSERT INTO Libros ( titulo, autor, genero, paginas) VALUES
( 'Cien años de soledad', 'Gabriel García Márquez', 'Realismo mágico', 417),
( 'Don Quijote de la Mancha', 'Miguel de Cervantes', 'Novela', 863),
( '1984', 'George Orwell', 'Distopía', 328),
( 'Orgullo y prejuicio', 'Jane Austen', 'Romántico', 432);

### Insertar datos en la tabla Biblioteca:

INSERT INTO Biblioteca (id_usuario, id_libro) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4),
(2, 1);
### Insertar datos en la tabla Puntuacion:

INSERT INTO Puntuacion (id_usuario, id_libro, puntuacion, comentario) VALUES
(1, 1, 4.5, 'Gran obra, me encantó la historia'),
(1, 2, 4.0, 'Una lectura clásica, aunque un poco larga'),
(2, 3, 5.0, 'Muy impactante, excelente crítica social'),
(3, 4, 4.8, 'Un clásico romántico lleno de emociones'),
(2, 1, 4.2, 'Una obra fascinante con muchos detalles');
--
-- AUTO_INCREMENT for table `Libros`
--

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
