<?php
//por ahora tanto el usuario como la contraseña estan en la DB y son admin/admin
require_once("./app/modelos/user.modelo.php");
require_once("./app/vistas/auth.vistas.php");
class AuthController {
    
    private $modelo;
    private $vista;

    function __construct($res){
        $this->modelo = new UserModelo();
        $this->vista = new AuthVista($res->user);
       
        
    }

    public function showLogin($mensaje = null){
        return $this->vista->showLogin($mensaje);
    }


    public function login(){
        if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
            return $this->vista->mensajeError('Falta completar el nombre de usuario');
        }
        if(!isset($_POST['password']) || empty($_POST['password'])){
            return $this->vista->mensajeError('Falta completar la contraseña del usuario');
        }

       
        $nombre = $_POST['nombre'];
        $password = $_POST['password'];

        $userDB = $this->modelo->getUserBynombre($nombre);
        if($userDB && ( password_verify($password,$userDB->password))){
            
            
            session_start();
            //iniciamos la sesion
            $_SESSION['USER_ID'] = $userDB->id_usuario; 
            $_SESSION['USER'] = $userDB->usuario;
            /* aca me daba un error por que los campos de userDB */
            header('Location: ' . BASE_URL);
        }else{
            return $this->vista->mensajeError('Credenciales incorrectas');
        }
    }
    public function logout() {
        session_start(); // Va a buscar la cookie
        session_destroy(); // Borra la cookie que se buscó
        header('Location: ' . BASE_URL);
    }
}