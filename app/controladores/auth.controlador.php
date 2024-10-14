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

    public function showLogin($mensaje = ''){
        return $this->vista->showLogin($mensaje);
    }


    public function login(){
        if(!isset($_POST['email']) || empty($_POST['email'])){
            return $this->vista->showLogin('Falta completar el nombre de usuario');
        }
        if(!isset($_POST['password']) || empty($_POST['password'])){
            return $this->vista->showLogin('Falta completar la contraseña del usuario');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $userDB = $this->modelo->getUserByEmail($email);
        
        if($userDB && ($password == $userDB->password)){
            
            //Si el usuario existe y las contraseñas coinciden
            session_start();
            //iniciamos la sesion
            $_SESSION['USER_ID'] = $userDB->id_usuario; 
            $_SESSION['USER'] = $userDB->Usuario;
            /* aca me daba un error por que los campos de userDB */
            header('Location: ' . BASE_URL);
        }else{
            return $this->vista->showLogin('Credenciales incorrectas');
        }
    }
}