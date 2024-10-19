<?php
require_once './libs/response.php';
require_once './app/middlewares/session.auth.middleware.php';
require_once './app/middlewares/verify.auth.middleware.php';
require_once 'app/controladores/libros.controlador.php';
require_once("./app/controladores/error.controlador.php");
require_once 'app/controladores/generos.controlador.php';
require_once 'app/controladores/auth.controlador.php';
//conrtroladores Cateogira
define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');


if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action']; 
} else {
    $action = 'libros';
}

$params = explode("/", $action);
$res = new Response();
switch ($params[0]) {
        /* Credenciales*/
    case 'showLogin':
        $controller = new AuthController($res);
        $controller->showLogin();
        break;
    case 'login':
        $controlador = new AuthController($res);
        $controlador->login();
        break;
    case 'validar':
        $controlador = new AuthController($res);
        $controlador->login();
        sessionAuthMiddleware($res);
        break;
    case 'logout':
        $controlador = new AuthController($res);
        $controlador->logout();
        break;

        //Libros
    case 'agregarLibro':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);

        $controlador = new LibrosControlador($res);
        $controlador->mostrarAgregar();

        break;
    case 'confirmarAgregar':
        //esto lo tengo que editar para que funcione como el editar, que lo haga todo en /agregar/libro
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new LibrosControlador($res);
        $controlador->agregarLibro();

        break;
    case 'editarLibro':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);

        $controlador = new LibrosControlador($res);
        if ($params[1] && is_numeric($params[1])) {
            $id_libro = $params[1];
            $controlador->mostrarEditar($id_libro);
        }else{
            
            $controladorError = new ControladorError($res);
            $controladorError->mostrarError("No había ningún libro seleccionado para editar");
        }

        break;
    case 'validarEditar':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new LibrosControlador($res);
        if ($params[1] && !empty($params[1])){

            
            $controlador->editarLibro($params[1]);
        }
        else{      
            $controladorError = new ControladorError($res);
            $controladorError->mostrarError("No se puede editar");
        }
        break;
    case 'eliminarLibro':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new LibrosControlador($res);
        if (isset($params[1]) && is_numeric($params[1])) {
            $id_libro = intval($params[1]);
            $controlador->eliminarLibro($id_libro);
        }else{
            
            $controladorError = new ControladorError($res);
            $controladorError->mostrarError("No había ningún libro seleccionado");
        }
        break;
    case 'libros':
        sessionAuthMiddleware($res);
        if (isset($params[1]) && is_numeric($params[1])) {
            $id = $params[1];
            $controlador = new LibrosControlador($res); // $res
            $controlador->detalleLibro($id);
        }else if(isset($params[1]) && !is_numeric($params[1])){
            $controladorError = new ControladorError($res);
            $controladorError->mostrarError("No había ningún libro seleccionado");
        } 
        
        else  {
            $controlador = new LibrosControlador($res); // $res
            $controlador->listarLibros();
        }
        break;

      // Géneros
    case 'agregarGenero':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new GenerosControlador($res);
        $controlador->mostrarFormularioCarga();
        break;
    case 'nuevoGenero':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new GenerosControlador($res);
        $controlador->agregarGenero();
        break;
    case 'datosGenero':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new GenerosControlador($res);
        if (isset($params[1])) {
            $controlador->datosGenero($params[1]);
        } else {
            $controladorError = new ControladorError($res);
            $controladorError->mostrarError("No había ningún género seleccionado");
        }
        break;
    case 'editarGenero':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new GenerosControlador($res);
        if (isset($params[1])) {
            $controlador->editarGenero($params[1]);
        } else {
            $controladorError = new ControladorError($res);
            $controladorError->mostrarError("No había ningún género seleccionado");
        }
        break;
    case 'eliminarGenero':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controlador = new GenerosControlador($res);
        if (isset($params[1])) {
            $controlador->eliminarGenero($params[1]);
        } else {
            $controladorError = new ControladorError($res);
            $controladorError->mostrarError("No había ningún género seleccionado");
        }
        break;

    case 'generos':
        sessionAuthMiddleware($res);
        $controlador = new GenerosControlador($res);
        if (isset($params[1]) && !is_numeric($params[1])) {
            $controladorError = new ControladorError($res);
            $controladorError->mostrarError("No existe el género");
        } else if (isset($params[1]) && !empty($params[1])) {
            $controlador->mostrarGenero($params[1]);
        } else {
            $controlador->mostrarGeneros();
        }
        break;
    default:
        $controladorError = new ControladorError($res);
        $controladorError->mostrarError("No existe la página");
        //errores de parametros por ejemplo si se quiere editar un libro que no existe o no tiene parametros
        break;
}
