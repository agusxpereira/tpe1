<?php

class GenerosModelo {
    private $db;

    public function __construct() {
       $this->db = new PDO('mysql:host=localhost;dbname=db_tpe;charset=utf8', 'root', '');
    }
    //Revisado
    public function obtenerGeneros() {
        // 2. Ejecuto la consulta
        $query = $this->db->prepare('SELECT * FROM generos');
        $query->execute();
    
        // 3. Obtengo los datos en un arreglo de objetos
        $generos = $query->fetchAll(PDO::FETCH_OBJ); 
        return $generos;
      }
 
    public function obtenerGenero($id) {    
        $query = $this->db->prepare('SELECT * FROM generos WHERE id = ?');
        $query->execute([$id]);   
    
        $generos = $query->fetch(PDO::FETCH_OBJ);
    
        return $generos;
    }

    
    public function obtenerLibros($id) {    
        $query = $this->db->prepare('SELECT libros.titulo from generos inner join libros on generos.id = libros.id_genero  where   generos.id = ?');
        $query->execute([$id]);   
    
        $libros = $query->fetchAll(PDO::FETCH_OBJ);
        return $libros;
    }
    
    public function insertarGenero($nombre, $descripcion, $ruta_imagen ) { 
        $query = $this->db->prepare('INSERT INTO generos(nombre, descripcion, Ruta_imagen) VALUES (?, ?, ?)');
        $query->execute([$nombre, $descripcion, $ruta_imagen]);
    
        $id = $this->db->lastInsertId();
    
        return $id;
    }
 
    public function borrarGenero($id) {
        $libros = $this->obtenerLibros($id);
        if (empty($libros)){

            $genero = $this->obtenerGenero($id);
            $query = $this->db->prepare('DELETE FROM generos WHERE id = ?');
            $query->execute([$id]);   
            if ($genero->Ruta_Imagen <> null){
                unlink($genero->Ruta_Imagen);
            }
            return true;
        }

        return false;
            
    }

    public function actualizarGenero($id , $nombre,$descripcion,$ruta_imagen) {    
        echo "ENTREE";
        $query = $this->db->prepare('UPDATE generos SET nombre= ? , descripcion=? , ruta_imagen = ? WHERE id = ?');
        $query->execute([$nombre,$descripcion,$ruta_imagen,$id]);
        
    }
}