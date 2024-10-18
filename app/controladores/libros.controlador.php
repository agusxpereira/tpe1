<?php
require_once("./app/modelos/libros.modelo.php");
require_once("./app/vistas/libros.vistas.php");



class LibrosControlador{
    private $modelo;

    private $vista;

    public function __construct($res)
    {

        $this->vista = new LibrosVista($res->user);
        //a la vista le pasamos el usuario que tenemos en response, si no existe es null
        
        try {
            $this->modelo = new LibrosModelo();
        }
        catch (PDOException $e){
            var_dump($e["message"]);
            $this->vista->mensajeError("No se pudo conectar a la base de datos; error $e");
            die();
        }
        }
    
    
    function listarLibros(){
        
        $libros = $this->modelo->getLibros();
        
        $this->vista->showLibros($libros);
        return;
    }

    function detalleLibro($id){
        $libro = $this->modelo->getLibroById($id);
        $nombreGenero = $this->modelo->obtenerNombreGenero($libro->id_genero);
        $this->vista->showDetail($libro, $nombreGenero);
        return;
    }

    function mostrarAgregar($mensaje = null){
        $listaGeneros = $this->modelo->obtenerGeneros();
        foreach ($listaGeneros as $key) {
            var_dump($key->nombre);
        }
        
        $this->vista->mostrarAgregar($mensaje, $listaGeneros);
        
    }

    function agregarLibro(){

        if(isset($_POST['titulo']) && isset($_POST['autor'])&& isset($_POST['genero']) && isset($_POST['paginas'])){
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $genero = $_POST['genero'];
            $paginas = intval($_POST['paginas']);
            $cover = empty($_POST['cover']) ? null :  $_POST['cover'];
            $id = $this->modelo->agregarLibro($titulo, $autor, $genero, $paginas, $cover);
            if ($id>0)
                return $this->mostrarAgregar("El libro $id se insertó con éxito");
            else
                return $this->vista->mensajeError("El libro $id no se pudo insertar");
                die();
        }

        else{
            $this->mostrarAgregar("No se especificaron los parametros");
            die();
        }

    }

    function mostrarEditar($id_libro){
        $listaGeneros = $this->modelo->obtenerGeneros();
        $libro = $this->modelo->getLibroById($id_libro);
        $this->vista->mostrarFormEditar('', $libro, $listaGeneros);
    }

    function editarLibro($id_libro){
        if(isset($_POST['titulo']) && isset($_POST['autor'])&& isset($_POST['genero']) && isset($_POST['paginas'])){
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $genero = $_POST['genero'];
            $paginas = intval($_POST['paginas']);
            $cover = $_POST['cover'];
            
            
            
            $id = $this->modelo->editarLibro($titulo, $autor, $genero, $paginas, $cover, intval($id_libro));       
            
            if ($id >= 0){  
               header("Location:" . BASE_URL);
            }else if($id == -1){
                return $this->vista->mensajeError("No existe esa categoria");
            } 
            
        }
        
    }

    public function eliminarLibro($id_libro){
        
        $validacion = $this->modelo->eliminarLibro($id_libro);
        if($validacion > 0){
            header("Location:" . BASE_URL);
        }else{
            return $this->vista->mensajeError("No se pudo eliminar el libro");
            die();
        }
    
    }

}