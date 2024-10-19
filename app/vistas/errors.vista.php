<?php

class VistaError{

    public $user = null;
    function __construct($user)
    {
        $this->user = $user;
    }

    public function mostrarError($mensaje=null){
       
        require_once("./plantillas/error/error.phtml");
    }

}