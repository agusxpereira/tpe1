<?php
class AuthVista{
    private $user;

    function __construct($user)
    {
        $this->user = $user;
    }
    //el error por defecto está vacío
    public function showLogin($error = ''){
        require_once("./plantillas/auth/form_login.phtml");
    }
    
}