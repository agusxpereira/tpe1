create database if not exists DB_TPE;
Use DB_TPE;

CREATE TABLE if not exists `Usuarios` (
  `id_usuario` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Usuario` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL
) ;

INSERT INTO `Usuarios` (Usuario,password) VALUES
("webadmin","admin");

CREATE TABLE if not exists `Generos` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Nombre` varchar(150) NOT NULL,
  `Descripcion` varchar(255) NOT NULL
) ;

INSERT INTO `Generos` (Nombre, Descripcion) VALUES 
('Realismo', 'Narrativas que retratan la vida cotidiana y las experiencias humanas de manera fiel y veraz.'),
('Novela', 'Obra literaria extensa que narra una historia de ficción con personajes y tramas desarrolladas.'),
('Distopía', 'Relatos que presentan sociedades futuras caracterizadas por opresión y deshumanización.'),
('Romántico', 'Género que enfatiza las emociones, el amor y la belleza de las relaciones humanas.');

CREATE TABLE if not exists  `Libros` (
  `id_libro` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `paginas` int(11) NOT NULL,
  `id_genero` int(11) NOT NULL
) ;

ALTER TABLE `Libros`
  ADD CONSTRAINT `fk_Generos_Libros` FOREIGN KEY (`id_Genero`) REFERENCES `Generos` (`id`); 


INSERT INTO Libros ( titulo, autor, id_genero, paginas) VALUES
( 'Cien años de soledad', 'Gabriel García Márquez', 1, 417),
( 'Don Quijote de la Mancha', 'Miguel de Cervantes', 2, 863),
( '1984', 'George Orwell', 3, 328),
( 'Orgullo y prejuicio', 'Jane Austen', 4, 432);

