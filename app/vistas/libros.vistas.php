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


    function showDetail($libro, $genero){
        require_once("./plantillas/libros/libro_detail.phtml");
    }

    function mostrarAgregar($mensaje, $listaGeneros){
        return require_once("./plantillas/libros/formularioAgregar.phtml");
    }

    function mostrarFormEditar($mensaje=null, $libro, $listaGeneros){
        return require_once("./plantillas/libros/formularioEditar.phtml");
    }
    public function mensajeError($mensaje = 'No se pudo inicializar la base de datos'){
        
        require_once("./plantillas/error/error.phtml");
    }

}