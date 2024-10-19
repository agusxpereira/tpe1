<?php
require_once("./app/vistas/errors.vista.php");

    class ControladorError{
        private $vista;
        //$modelo?
    
        function __construct($res){
            $this->vista = new VistaError($res->user);
        }

        function mostrarError($mensaje){
            $this->vista->mostrarError($mensaje);
        }
    }