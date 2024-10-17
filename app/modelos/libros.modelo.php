<?php
require_once 'Modelo.base.php';
class LibrosModelo extends ModeloBase{
    public function getLibros(){
        $query = $this->db->prepare("SELECT * FROM Libros");
        $query->execute();
        $libros = $query->fetchAll(PDO::FETCH_OBJ);
        return $libros;
    }

    public function getLibroById($id){
        
        $query = $this->db->prepare("SELECT * FROM Libros WHERE id_libro = ?");
        $query->execute([$id]);
        
        $libro = $query->fetch(PDO::FETCH_OBJ);
        
        return $libro;

    }
    private function obtenerId($genero){
       
       $query = $this->db->prepare("SELECT `id` FROM `Generos` WHERE Nombre = ?");
       $query->execute([$genero]);
       $id = $query->fetchAll(PDO::FETCH_OBJ);
        if($id != null){
            return $id[0]->id;
        }
        else{
            return null;
        }
         
    
    }
    public function obtenerNombreGenero($id){
        $query = $this->db->prepare("SELECT `Nombre` FROM `Generos` WHERE id = ?");
        $query->execute([$id]);
        $id = $query->fetchAll(PDO::FETCH_OBJ);
       
        if($id != null){
            return $id[0]->Nombre;
        }
        else{
            return null;
        }
    }

    public function agregarLibro($titulo, $autor, $genero, $paginas, $cover){
    /*hacer una buena validacion de datos*/ 
        
        $id_genero = $this->obtenerId($genero);
        
        if($id_genero == null){
            echo "No se pudo insertar";
            return;
        }
        $query = $this->db->prepare('INSERT INTO Libros(titulo, autor, paginas, cover, id_genero) VALUES (?,?,?,?,?)' );
        var_dump($query);
        $query->execute([$titulo, $autor, $paginas, $cover, $id_genero]);
        $id = $this->db->lastInsertId();
        
        return $id;
    }

    

    public function editarLibro($titulo, $autor, $genero, $paginas, $cover, $id_libro){
        
        $id_genero = $this->obtenerId($genero);
        $query = $this->db->prepare("UPDATE Libros SET titulo = ?, autor = ?, paginas = ?, cover = ?, id_genero = ? WHERE id_libro = ?");
        
        $query->execute([$titulo, $autor, intval($paginas), $cover, intval($id_genero), intval($id_libro)]);
        
        $validacion = $query->rowCount();
        return $validacion;


    }
    public function eliminarLibro($id){
        $query = $this->db->prepare("DELETE FROM Libros WHERE id_libro = ?");
        $query->execute([$id]);

        $validacion = $query->rowCount();
        return $validacion;
    
    }
}