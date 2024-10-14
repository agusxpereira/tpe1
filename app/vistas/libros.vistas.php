<?php
class LibrosVista{
    public $user = null;
    public $saludo = "hola";
    function __construct($user)
    {
        $this->user = $user;
        //las plantilas tienen acceso a mis variabes, en este caso $user
    }


    function showLibros($libros){
        
        require_once("./plantillas/libros/libros.phtml");

    }


    function showDetail($libro){
        require_once("./plantillas/libros/libro_detail.phtml");
    }

    function mostrarAgregar(){
        return require_once("./plantillas/libros/formularioAgregar.phtml");
    }

    function editarLibroForm($mensaje=null, $id, $libro, $genero){
        return require_once("./plantillas/libros/formularioEditar.phtml");
    }
    public function mensajeError($mensaje){
        require_once("./plantillas/libros/mensajeError.phtml");
    }

}