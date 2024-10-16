<?php
require_once './libs/response.php';
require_once './app/middlewares/session.auth.middleware.php';
require_once './app/middlewares/verify.auth.middleware.php';
require_once 'app/controladores/libros.controlador.php';
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
        $controller = new AuthController($res);
        $controller->login();
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

        $controller = new LibrosControlador($res);
        if (isset($params[1])) {
            $id_libro = $params[1];
            $controller->mostrarEditar($id_libro);
        }

        break;
    case 'validarEditar':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controller = new LibrosControlador($res);
        if ($params[1])
            $controller->editarLibro($params[1]);

        break;
    case 'eliminarLibro':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controller = new LibrosControlador($res);
        if (isset($params[1])) {
            $id_libro = intval($params[1]);
            $controller->eliminarLibro($id_libro);
        }
        break;
    case 'libros':
        sessionAuthMiddleware($res);
        //verifyAuthMiddleware($res);
        if (isset($params[1])) {
            $id = $params[1];
            $controlador = new LibrosControlador($res); // $res
            $controlador->detalleLibro($id);
        } else {
            $controlador = new LibrosControlador($res); // $res
            $controlador->listarLibros();
        }
        break;

        //Generos
    case 'agregarGenero':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controller = new GenerosControlador($res);
        $controller->mostrarFormularioCarga();
        break;
    case 'nuevoGenero':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controller = new GenerosControlador($res);
        $controller->agregarGenero();
        break;
    case 'datosGenero':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controller = new GenerosControlador($res);
        $controller->datosGenero($params[1]);
        break;
    case 'editarGenero':
        $controller = new GenerosControlador($res);
        $controller->editarGenero($params[1]);
        break;
    case 'eliminarGenero':
        $controller = new GenerosControlador($res);
        $controller->borrarGenero($params[1]);
        break;
    case "generos":
        sessionAuthMiddleware($res);
        $controlador = new GenerosControlador($res);
        if (isset($params[1]) && !empty($params[1])) {
            $controlador->mostrarGenero($params[1]);
        } else {
            $controlador->mostrarGeneros();
        }
        break;
    default:
        # code...
        break;
}
