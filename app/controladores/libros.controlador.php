<?php
require_once("./app/modelos/libros.modelo.php");
require_once("./app/vistas/libros.vistas.php");



class LibrosControlador{
    private $modeloLibros;
    private $modeloGeneros;


    private $vista;

    public function __construct($res)
    {

        $this->vista = new LibrosVista($res->user);
        //a la vista le pasamos el usuario que tenemos en response, si no existe es null
        
        try {
            $this->modeloLibros = new LibrosModelo();
            $this->modeloGeneros = new GenerosModelo();
        }
        catch (PDOException $e){
            $this->vista->mostrarError("No se pudo conectar a la base de datos.");
            die();
        }
        }
    
    
    function listarLibros(){
        
        $libros = $this->modeloLibros->obtenerLibros();
        
        $this->vista->mostrarLibros($libros);
        return;
    }

    function detalleLibro($id) {
        $libro = $this->modeloLibros->obtenerLibroPorId($id);
    
        // Verifica si el libro existe
        if (!$libro) {
            // Maneja el caso en que no se encuentra el libro
            $this->vista->mostrarError("El libro no fue encontrado.");
            return;
        }
    
        $nombreGenero = $this->modeloGeneros->obtenerGeneroPorId($libro->id_genero);
    
        // Verifica si el género existe
        if (!$nombreGenero) {
            // Maneja el caso en que no se encuentra el género
            $this->vista->mostrarError("El género no fue encontrado.");
            return;
        }
    
        $this->vista->mostrarDetalles($libro, $nombreGenero->nombre);
    }

    function mostrarAgregar($mensaje = null){
        $listaGeneros = $this->modeloGeneros->obtenerGeneros();
        
        $this->vista->mostrarAgregar($mensaje, $listaGeneros);
        
    }

    function agregarLibro(){

        if(
            (isset($_POST['titulo'])   && !empty($_POST['titulo']))&&
            (isset($_POST['autor'])   && !empty($_POST['autor'])) &&
            (isset($_POST['genero'])  && !empty($_POST['genero']))&& 
            (isset($_POST['paginas']) && !empty($_POST['paginas']))
          ){     
            
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $genero = $_POST['genero'];
            $paginas = $_POST['paginas'];
            
            
            $cover = empty($_POST['cover']) ? null :  $_POST['cover'];
            
            $genero_id = $this->modeloGeneros->obtenerIdPorNombreGenero($genero);
            
            
            
            $id = $this->modeloLibros->agregarLibro($titulo, $autor, $genero_id, $paginas, $cover);



            if ($id>0)
                return $this->mostrarAgregar("El libro $id se insertó con éxito");
            else
                return $this->vista->mostrarError("El libro $id no se pudo insertar");
        }
        else{
            $this->vista->mostrarError("No se especificaron los parametros");
            die();
        }

    }

    function mostrarEditar($id_libro){
        
        $libro = $this->modeloLibros->obtenerLibroPorId($id_libro);
        $listaGeneros = $this->modeloGeneros->obtenerGeneros();

        $this->vista->mostrarFormEditar('', $libro, $listaGeneros);
    }

    function editarLibro($id_libro){
       
        if(
            (isset($_POST['titulo'])   && !empty($_POST['titulo']))&&
            (isset($_POST['autor'])   && !empty($_POST['autor'])) &&
            (isset($_POST['genero'])  && !empty($_POST['genero']))&& 
            (isset($_POST['paginas']) && !empty($_POST['paginas']))
          ){   


            
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $genero = $_POST['genero'];
            $paginas = intval($_POST['paginas']);
            $cover = $_POST['cover'];
            
            $id_genero = $this->modeloGeneros->obtenerIdPorNombreGenero($genero);
            $id = $this->modeloLibros->editarLibro($titulo, $autor, $id_genero, $paginas, $cover, intval($id_libro));       
            
            if ($id >= 0){  
               header("Location:" . BASE_URL);
            }else if($id == -1){
                return $this->vista->mostrarError("No existe esa categoria");
            } 
            
        }else{
            $this->vista->mostrarError("Debes completar los campos");
        }
        
    }

    public function eliminarLibro($id_libro){
        
        $validacion = $this->modeloLibros->eliminarLibro($id_libro);
        if($validacion > 0){
            header("Location:" . BASE_URL);
        }else{
            return $this->vista->mostrarError("No se pudo eliminar el libro");
        }
    
    }

}