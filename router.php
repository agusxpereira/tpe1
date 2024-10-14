<?php
require_once './libs/response.php';
require_once './app/middlewares/session.auth.middleware.php';
require_once 'app/controladores/libros.controlador.php';
require_once 'app/controladores/auth.controlador.php';
//conrtroladores Cateogira

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');


$res = new Response();

if(!empty($_GET['action'])){
    $action = $_GET['action'];
}else{
    $action = 'listar/libros';
}
    
$params = explode("/", $action);
    
switch ($params[0]) {
    case 'login':
        
        $controlador = new AuthController($res);
        $controlador->showLogin();
        break;
    case 'validar':
        $controlador = new AuthController($res);
        $controlador->login();
        break;
    case 'logout':
        //...
        break;
    

    case 'listar':
        sessionAuthMiddleware($res);
        if ($params[1] == "libros"){
            if(isset($params[2])){
                $id = $params[2];
                $controller = new LibrosControlador($res);
                $controller->detalleLibro($id);

            }else{
                $controller = new LibrosControlador($res);
                $controller->listarLibros();
            }
        }
        if ($params[1] == "categoria"){

        } 
        break;

    case 'agregar':
        sessionAuthMiddleware($res);       
        
        //Acá podemos especificar que agregar
        if($params[1] == 'libro'){
            $controlador = new LibrosControlador($res);
            $controlador->mostrarAgregar();
           
        }
        //esto lo tengo que editar para que funcione como el editar, que lo haga todo en /agregar/libro
        if($params[1] == 'aggLibro'){
            $controlador = new LibrosControlador($res);
            $controlador->agregarLibro();
           
        }
        break;

    case 'editar':
        sessionAuthMiddleware($res);
        //if params[1] == libro
        $controller = new LibrosControlador($res);
        if(isset($params[1])){
            $id_libro = $params[1];
            $controller->editarLibro($id_libro);
        }else{
            $controller->editarLibro(null);
        }
       
        break;
    case 'eliminar':
        sessionAuthMiddleware($res);
        //if params[1] == libro
        $controller = new LibrosControlador($res);
        if(isset($params[1])){
            $id_libro = intval($params[1]);
            
            $controller->eliminarLibro($id_libro);
            
        }else{
            header("Location:" . BASE_URL);
        }
        break;
    
        default:
    # code...
    break;
}
    
?>
