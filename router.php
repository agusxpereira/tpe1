<?php
require_once './libs/response.php';
require_once './app/middlewares///session.auth.middleware.php';
require_once 'app/controladores/libros.controlador.php';
require_once 'app/controladores/generos.controlador.php';
require_once 'app/controladores/auth.controlador.php';
//conrtroladores Cateogira

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

var_dump($_GET);

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'listar/libros';
}
var_dump($action);

$params = explode("/", $action);
var_dump($params);
// $res = new Response();
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
        ////sessionAuthMiddleware($res);
        if ($params[1] == "libros") {
            if (isset($params[2])) {
                $id = $params[2];
                $controlador = new LibrosControlador($res);
                $controlador->detalleLibro($id);
            } else {
                $controlador = new LibrosControlador($res);
                $controlador->listarLibros();
            }
        } else if ($params[1] == "generos") {
            $controlador = new GenerosControlador();
            if (isset($params[2]) && !empty($params[2])) {
                $controlador->mostrarGenero($params[2]);
            } else {
                $controlador->mostrarGeneros();
            }
        }
        break;

    case 'agregar':
        ////sessionAuthMiddleware($res);
        if ($params[1] == "libros") {
            //Acá podemos especificar que agregar
            if ($params[1] == 'libro') {
                $controlador = new LibrosControlador($res);
                $controlador->mostrarAgregar();
            }
            //esto lo tengo que editar para que funcione como el editar, que lo haga todo en /agregar/libro
            if ($params[1] == 'aggLibro') {
                $controlador = new LibrosControlador($res);
                $controlador->agregarLibro();
            }
        } else if ($params[1] == "genero") {
            $controller = new GenerosControlador();
            $controller->mostrarFormularioCarga();
        }
        break;
    case 'nuevoGenero':
        $controller = new GenerosControlador();
        $controller->agregarGenero();
        break;
    case 'datosGenero':
        $controller = new GenerosControlador();
        $controller->datosGenero($params[1]);
        break;
    case 'editar':
        //sessionAuthMiddleware($res);
        if ($params[1] == "libros") {
      
        $controller = new LibrosControlador($res);
        if (isset($params[1])) {
            $id_libro = $params[1];
            $controller->editarLibro($id_libro);
        } else {
            $controller->editarLibro(null);
        }} else if ($params[1] == "genero") {
            $controller = new GenerosControlador();
            $controller->editarGenero($params[2]); 
        }

        break;
    case 'eliminar':
        //sessionAuthMiddleware($res);
        if ($params[1] == "libros") {
        //if params[1] == libro
        $controller = new LibrosControlador($res);
        if (isset($params[1])) {
            $id_libro = intval($params[1]);

            $controller->eliminarLibro($id_libro);
        } else {
            header("Location:" . BASE_URL);
        }
    }else if ($params[1] == "genero") {
        $controller = new GenerosControlador();
        $controller->borrarGenero($params[2]);
    }
        break;

    default:
        # code...
        break;
}


