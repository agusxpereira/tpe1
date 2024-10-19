<?php
require_once 'Modelo.base.php';
class LibrosModelo extends ModeloBase
{
    public function obtenerLibros()
    {
        $consulta = $this->db->prepare("SELECT * FROM libros");
        $consulta->execute();
        $libros = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $libros;
    }

    public function obtenerLibroPorId($id)
    {
        $consulta = $this->db->prepare("SELECT * FROM libros WHERE id_libro = ?");
        $consulta->execute([$id]);
        $libro = $consulta->fetch(PDO::FETCH_OBJ);
        return $libro;
    }


    public function obtenerLibrosPorGenero($id_genero)
    {
        $consulta = $this->db->prepare('SELECT libros.id_libro ,libros.titulo from generos inner join libros on generos.id = libros.id_genero where  generos.id = ?');
        $consulta->execute([$id_genero]);
        $libros = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $libros;
    }

    //agregar
    public function agregarLibro($titulo, $autor, $genero_id, $paginas, $cover)
    {
        $id = 0;
        try {

            $consulta = $this->db->prepare('INSERT INTO libros(titulo, autor, paginas, cover, id_genero) VALUES (?,?,?,?,?)');
            $consulta->execute([$titulo, $autor, $paginas, $cover, $genero_id]);
            $id = $this->db->lastInsertId();
        } catch (\Throwable $th) {
            $id = -1;
        }

        return $id;
    }



    //editar
    public function editarLibro($titulo, $autor, $id_genero, $paginas, $cover, $id_libro)
    {


        $consulta = $this->db->prepare("UPDATE libros SET titulo = ?, autor = ?, paginas = ?, cover = ?, id_genero = ? WHERE id_libro = ?");
        try {

            $consulta->execute([$titulo, $autor, intval($paginas), $cover, intval($id_genero), intval($id_libro)]);
            $validacion = $consulta->rowCount();
            return $validacion;
        } catch (Exception $e) {
            return -1;
        }
    }
    //Eliminar
    public function eliminarLibro($id)
    {
        $consulta = $this->db->prepare("DELETE FROM libros WHERE id_libro = ?");
        $consulta->execute([$id]);

        $validacion = $consulta->rowCount();

        return $validacion;
    }
}
