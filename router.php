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
    $action = 'listar/libros';
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
        break;
    case 'logout':
        $controlador = new AuthController($res);
        $controlador->logout();
        break;
        /* listar/libros/:id */
        /* listar/generos/:id */
    case 'listar':
        sessionAuthMiddleware($res);
        if ($params[1] == "libros") {
            if (isset($params[2])) {
                $id = $params[2];
                $controlador = new LibrosControlador($res); // $res
                $controlador->detalleLibro($id);
            } else {
                $controlador = new LibrosControlador($res); // $res
                $controlador->listarLibros();
            }
        } else if ($params[1] == "generos") {
            $controlador = new GenerosControlador($res);
            if (isset($params[2]) && !empty($params[2])) {
                $controlador->mostrarGenero($params[2]);
            } else {
                $controlador->mostrarGeneros();
            }
        }
        break;
    case 'agregar':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
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
            $controller = new GenerosControlador($res);
            $controller->mostrarFormularioCarga();
        }
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
    case 'editar':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        if ($params[1] == "libros") {

            $controller = new LibrosControlador($res);
            if (isset($params[1])) {
                $id_libro = $params[1];
                $controller->editarLibro($id_libro);
            } else {
                $controller->editarLibro(null);
            }
        } else if ($params[1] == "genero") {
            $controller = new GenerosControlador($res);
            $controller->editarGenero($params[2]);
        }

        break;
    case 'eliminar':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        if ($params[1] == "libros") {
            //if params[1] == libro
            $controller = new LibrosControlador($res);
            if (isset($params[1])) {
                $id_libro = intval($params[1]);

                $controller->eliminarLibro($id_libro);
            } else {
                header("Location:" . BASE_URL);
            }
        } else if ($params[1] == "genero") {
            $controller = new GenerosControlador($res);
            $controller->borrarGenero($params[2]);
        }
        break;

    default:
        # code...
        break;
}
