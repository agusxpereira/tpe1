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
            var_dump($e["message"]);
            $this->vista->mensajeError("No se pudo conectar a la base de datos; error $e");
            die();
        }
        }
    
    
    function listarLibros(){
        
        $libros = $this->modeloLibros->getLibros();
        
        $this->vista->showLibros($libros);
        return;
    }

    /*    
    
    */

    function detalleLibro($id){
        $libro = $this->modeloLibros->getLibroById($id);
        //$nombreGenero = $this->modeloGeneros->obtenerNombreGenero($libro->id_genero);
        /*buscar esta funcion y pasarsela a Seba */
        $this->vista->showDetail($libro, $nombreGenero);
        return;
    }

    function mostrarAgregar($mensaje = null){
        $listaGeneros = $this->modeloGeneros->obtenerGeneros();
        
        $this->vista->mostrarAgregar($mensaje, $listaGeneros);
        
    }

    function agregarLibro(){

        if(isset($_POST['titulo']) && isset($_POST['autor'])&& isset($_POST['genero']) && isset($_POST['paginas'])){
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $genero = $_POST['genero'];
            $paginas = intval($_POST['paginas']);
            $cover = empty($_POST['cover']) ? null :  $_POST['cover'];
            
            $genero_id = $this->modeloGeneros->obtenerId($genero);
            
            
            
            $id = $this->modeloLibros->agregarLibro($titulo, $autor, $genero_id, $paginas, $cover);





            if ($id>0)
                return $this->mostrarAgregar("El libro $id se insertó con éxito");
            else
                return $this->vista->mensajeError("El libro $id no se pudo insertar");
                die();
        }

        else{
            $this->vista->mensajeError("No se especificaron los parametros");
            die();
        }

    }

    function mostrarEditar($id_libro){
        $listaGeneros = $this->modeloGeneros->obtenerGeneros();
        /* buscar esta funcion también */
        $libro = $this->modeloLibros->getLibroById($id_libro);
        $this->vista->mostrarFormEditar('', $libro, $listaGeneros);
    }

    function editarLibro($id_libro){
        if(isset($_POST['titulo']) && isset($_POST['autor'])&& isset($_POST['genero']) && isset($_POST['paginas'])){
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $genero = $_POST['genero'];
            $paginas = intval($_POST['paginas']);
            $cover = $_POST['cover'];
            
            $id_genero = $this->modeloGeneros->obtenerId($genero);

            $id = $this->modeloLibros->editarLibro($titulo, $autor, $id_genero, $paginas, $cover, intval($id_libro));       
            
            if ($id >= 0){  
               header("Location:" . BASE_URL);
            }else if($id == -1){
                return $this->vista->mensajeError("No existe esa categoria");
            } 
            
        }
        
    }

    public function eliminarLibro($id_libro){
        
        $validacion = $this->modeloLibros->eliminarLibro($id_libro);
        if($validacion > 0){
            header("Location:" . BASE_URL);
        }else{
            return $this->vista->mensajeError("No se pudo eliminar el libro");
            die();
        }
    
    }

}