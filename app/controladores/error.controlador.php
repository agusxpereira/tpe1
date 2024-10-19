<?php
require_once("./app/vistas/errors.vista.php");
class ControladorError{


    private $vista;
    //$modelo?
   
    function __construct(){
        
        $this->vista = new VistaError();
    }

    function mostrarError($mensaje){
        $this->vista->mostrarError($mensaje);
    }
}