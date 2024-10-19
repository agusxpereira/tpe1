<?php
class LibrosVista{
    public $user = null;
    public $saludo = "hola";
    function __construct($user)
    {
        $this->user = $user;
        //las plantilas tienen acceso a mis variabes, en este caso $user
    }


    function mostrarLibros($libros){
        
        require_once("./plantillas/libros/libros.phtml");

    }


    function mostrarDetalles($libro, $genero){
        require_once("./plantillas/libros/libro_detail.phtml");
    }

    function mostrarAgregar($mensaje, $listaGeneros){
        return require_once("./plantillas/libros/formularioAgregar.phtml");
    }

    function mostrarFormEditar($mensaje=null, $libro, $listaGeneros){
        var_dump($listaGeneros);
       
        return require_once("./plantillas/libros/formularioEditar.phtml");
    }
    public function mostrarError($mensaje = 'No se pudo inicializar la base de datos'){
        
        require_once("./plantillas/error/error.phtml");
    }

}