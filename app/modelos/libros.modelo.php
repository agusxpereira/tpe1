<?php
require_once 'Modelo.base.php';
class LibrosModelo extends ModeloBase{

    
    public function getLibros(){
        $query = $this->db->prepare("SELECT * FROM libros");
        $query->execute();
        $libros = $query->fetchAll(PDO::FETCH_OBJ);
        return $libros;
    }

    public function getLibroById($id){
        
        $query = $this->db->prepare("SELECT * FROM libros WHERE id_libro = ?");
        $query->execute([$id]);
        
        $libro = $query->fetch(PDO::FETCH_OBJ);
        
        return $libro;

    }
    private function obtenerId($genero){
       
       $query = $this->db->prepare("SELECT `id` FROM `generos` WHERE nombre = ?");
       $query->execute([$genero]);
       $id = $query->fetchAll(PDO::FETCH_OBJ);
        if($id != null){
            return $id[0]->id;
        }
        else{
            return -1;
        }
         
    
    }
    public function obtenerNombreGenero($id){
        $query = $this->db->prepare("SELECT nombre FROM generos WHERE id = ?");
        $query->execute([$id]);
        $id = $query->fetch(PDO::FETCH_OBJ);
        if($id != null){
            return $id->nombre;
        }
        else{
            return null;
        }
    }

    public function obtenerGeneros(){
        $query = $this->db->prepare("SELECT `nombre` FROM `generos` WHERE ?");
        $query->execute([1]);
        $lista = $query->fetchAll(PDO::FETCH_OBJ);
        return $lista;
    }

    public function agregarLibro($titulo, $autor, $genero, $paginas, $cover){
        
        $id = 0;
        
        $genero_id = $this->obtenerId($genero);
        try {
            
            $query = $this->db->prepare('INSERT INTO libros(titulo, autor, paginas, cover, id_genero) VALUES (?,?,?,?,?)' );
            $query->execute([$titulo, $autor, $paginas, $cover, $genero_id]);
            $id = $this->db->lastInsertId();
            
        } catch (\Throwable $th) {
            $id = -1;
        }
        
        return $id;
    }

    public function editarLibro($titulo, $autor, $genero, $paginas, $cover, $id_libro){
        
        $id_genero = $this->obtenerId($genero);
        $query = $this->db->prepare("UPDATE libros SET titulo = ?, autor = ?, paginas = ?, cover = ?, id_genero = ? WHERE id_libro = ?");
        try{
            $query->execute([$titulo, $autor, intval($paginas), $cover, intval($id_genero), intval($id_libro)]);
            $validacion = $query->rowCount();
            return $validacion;
        }catch(Exception $e){
            return -1;
        }
        
    }
    public function eliminarLibro($id){
        $query = $this->db->prepare("DELETE FROM libros WHERE id_libro = ?");
        $query->execute([$id]);

        $validacion = $query->rowCount();
        
        return $validacion;
    
    }
}