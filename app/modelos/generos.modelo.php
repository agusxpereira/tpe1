<?php
require_once 'Modelo.base.php';
class GenerosModelo extends ModeloBase
{
    public function obtenerGeneros()
    {
        $consulta = $this->db->prepare('SELECT * FROM generos');
        $consulta->execute();
        $generos = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $generos;
    }
    public function obtenerIdPorNombreGenero($genero){
       
        $query = $this->db->prepare("SELECT id FROM generos WHERE nombre = ?");
        $query->execute([$genero]);
        $id = $query->fetchAll(PDO::FETCH_OBJ);
         if($id != null){
             return $id[0]->id;
         }
         else{
             return -1;
         }
          
     
     }
    public function obtenerGeneroPorId($id)
    {
        $consulta = $this->db->prepare('SELECT * FROM generos WHERE id = ?');
        $consulta->execute([$id]);
        $generos = $consulta->fetch(PDO::FETCH_OBJ);
        return $generos;
    }
    //agregar
    public function agregarGenero($nombre, $descripcion, $ruta_imagen)
    {//con default true deberia tener en cuenta siempre el activo y la fecha
        //Por defecto se crea activo
        try {
            $consulta = $this->db->prepare('INSERT INTO generos(nombre, descripcion, Ruta_imagen) VALUES (?, ?, ?)');
            $consulta->execute([$nombre, $descripcion, $ruta_imagen]);
            $id = $this->db->lastInsertId();
        } catch (\Throwable $th) {
            $id = -1;
        }
        return $id;
    }
    //editar
    public function editarGenero($id, $nombre, $descripcion, $ruta_imagen,$activo)
    {
        $consulta = $this->db->prepare('UPDATE generos SET nombre= ? , descripcion=? , ruta_imagen = ?, activo = ? WHERE id = ?');

        $consulta->execute([$nombre, $descripcion, $ruta_imagen,$activo, $id]);
        return $consulta->rowCount();
    }
    public function activarGenero($id, $activo)
    {
        $consulta = $this->db->prepare('UPDATE generos SET activo = ? WHERE id = ?');

        $consulta->execute([$activo, $id]);
        return $consulta->rowCount();
    }
   //Eliminar
    public function eliminarGenero($id)
    {

            $genero = $this->obtenerGeneroPorId($id);

            $consulta = $this->db->prepare('DELETE FROM generos WHERE id = ?');

            $consulta->execute([$id]);
            return $consulta->rowCount();

    }


}
