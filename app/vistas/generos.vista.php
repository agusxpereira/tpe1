<?php

class generosVista {
    public $user = null;
    function __construct($user)
    {
        $this->user = $user;
    }
    public function mostrarGeneros($generos) {
        // la vista define una nueva variable con la cantida de generos
        $count = count($generos);

        // NOTA: el template va a poder acceder a todas las variables y constantes que tienen alcance en esta funcion
        require 'plantillas/generos/lista_generos.phtml';
    }

    public function detalleGenero($genero,$libros) {
        // la vista define una nueva variable con la cantida de generos
        $count = count($libros);

        // NOTA: el template va a poder acceder a todas las variables y constantes que tienen alcance en esta funcion
        require 'plantillas/generos/detalle_genero.phtml';
    }

    public function mostrarError($mensaje) {
        require 'plantillas/error/error.phtml';
    }

    public function mostrarFormularioCarga($genero){
         require 'plantillas/layout/header.phtml' ;

        require 'plantillas/generos/form_alta_genero.phtml';}



}