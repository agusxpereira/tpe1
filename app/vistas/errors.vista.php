<?php

class VistaError{

    public function mostrarError($mensaje=null){
       
        require_once("./plantillas/error/error.phtml");
    }

}