<?php
class LibrosVista{
    public $user = null;
    function __construct($user)
    {
        $this->user = $user;
        //las plantilas tienen acceso a mis variabes, en este caso $user
    }


    function mostrarLibros($libros){        
        return require_once("./plantillas/libros/libros.phtml");
    }

    function mostrarDetalles($libro, $genero){
        return require_once("./plantillas/libros/libro_detail.phtml");
    }

    function mostrarAgregar($mensaje, $listaGeneros){
        return require_once("./plantillas/libros/formularioAgregar.phtml");
    }

    function mostrarFormEditar($libro, $listaGeneros){
        return require_once("./plantillas/libros/formularioEditar.phtml");
    }
    public function mostrarError($mensaje = null){
        require_once("./plantillas/error/error.phtml");
    }

}