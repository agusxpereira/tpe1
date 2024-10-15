<?php

class generosVista {
    public function mostrarGeneros($generos) {
        // la vista define una nueva variable con la cantida de generos
        $count = count($generos);

        // NOTA: el template va a poder acceder a todas las variables y constantes que tienen alcance en esta funcion
        require 'templates/lista_generos.phtml';
    }

    public function detalleGenero($genero,$libros) {
        // la vista define una nueva variable con la cantida de generos
        $count = count($libros);

        // NOTA: el template va a poder acceder a todas las variables y constantes que tienen alcance en esta funcion
        require 'templates/detalle_genero.phtml';
    }

    public function mostrarError($error) {
        require 'templates/error.phtml';
    }

    public function mostrarFormularioCarga($genero){
         require 'templates/layout/header.phtml' ;

        require 'templates/form_alta_genero.phtml';}



}