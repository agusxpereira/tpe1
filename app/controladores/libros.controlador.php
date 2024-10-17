<?php
require_once("./app/modelos/libros.modelo.php");
require_once("./app/vistas/libros.vistas.php");


class LibrosControlador{
    private $modelo;
    private $vista;

    public function __construct($res)
    {
        $this->modelo = new LibrosModelo();
        $this->vista = new LibrosVista($res->user);
        //a la vista le pasamos el usuario que tenemos en response, si no existe es null
    }

    function listarLibros(){

        $libros = $this->modelo->getLibros();
        $this->vista->showLibros($libros);
        return;
    }

    function detalleLibro($id){
        $libro = $this->modelo->getLibroById($id);
        $this->vista->showDetail($libro);
        return;
    }

    function mostrarAgregar($mensaje = null){
        $this->vista->mostrarAgregar($mensaje);
        
    }

    function agregarLibro(){

        if(isset($_POST['titulo']) && isset($_POST['autor'])&& isset($_POST['genero']) && isset($_POST['paginas'])){
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $genero = $_POST['genero'];
            $paginas = intval($_POST['paginas']);
            $cover = $_POST['cover'];
            
            $id = $this->modelo->agregarLibro($titulo, $autor, $genero, $paginas, $cover);
            if ($id!=null)
                return $this->mostrarAgregar("La tarea $id se insertó con éxito");
                
            else
                return $this->mostrarAgregar("La tarea $id no se pudo insertar");
                die();
        }

        else{
            $this->mostrarAgregar("No se especificaron los parametros");
            die();
        }

    }

    function editarLibro($id_libro){
        
        if($id_libro == null || !isset($id_libro)){
            header("Location:" . BASE_URL);
            return;
        }
        
        if(isset($_POST['titulo']) && isset($_POST['autor'])&& isset($_POST['genero']) && isset($_POST['paginas'])){
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $genero = $_POST['genero'];
            $paginas = intval($_POST['paginas']);
            $cover = $_POST['cover'];
            $id = $this->modelo->editarLibro($titulo, $autor, $genero, $paginas, $cover, intval($id_libro));       
            if ($id!=null){  
                header("Location:" . BASE_URL);
            }
            else{        
                return $this->vista->mensajeError("No se pudo editar la tarea");
                die();
            }
        }
        else{
            $libro = $this->modelo->getLibroById($id_libro);
            $genero = $this->modelo->obtenerNombreGenero($id_libro);
            
            return $this->vista->editarLibroForm("faltan parametros", $id_libro, $libro, $genero);
            //el id_libro es para no perder la referencia de que libro estoy editando en el formulario
        }
    }

    public function eliminarLibro($id_libro){
        
        $validacion = $this->modelo->eliminarLibro($id_libro);
        if($validacion > 0){
            header("Location:" . BASE_URL);
        }else{
            return $this->vista->mensajeError("No se pudo eliminar la tarea");
            die();
        }
    
    }

}