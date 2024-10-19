<?php
require_once './app/modelos/generos.modelo.php';
require_once './app/vistas/generos.vista.php';
require_once("./app/modelos/libros.modelo.php");
require_once("./app/controladores/error.controlador.php");
class GenerosControlador
{
    private $modeloGeneros;
    private $modeloLibros;
    private $controladorError;

    private $vista;
    //Revisado
    public function __construct($res)
    {
        $this->controladorError = new ControladorError($res); 
        $this->vista = new GenerosVista($res->user);
        try {
            $this->modeloLibros = new LibrosModelo();
            $this->modeloGeneros = new GenerosModelo();
        } catch (PDOException $e) {
            $this->controladorError->mostrarError("No se pudo conectar a la base de datos");
            die();
        }
    }
    //mostrar
    public function mostrarGeneros()
    {
        // obtengo los géneros de la DB
        $generos = $this->modeloGeneros->obtenerGeneros();
        // mando los géneros a la vista
        return $this->vista->mostrarGeneros($generos);
    }

    public function mostrarGenero($id)
    {
        // obtengo los géneros de la DB
        $genero = $this->modeloGeneros->obtenerGeneroPorId($id);
        if ($genero <> null) {
            $libros = $this->modeloLibros->obtenerLibrosPorGenero($id);
            return $this->vista->detalleGenero($genero, $libros);
        }
        return $this->controladorError->mostrarError("No se ha encontrado el genero con id : $id");
    }

    //agregar

    public function mostrarFormularioCarga()
    {
      
        return $this->vista->mostrarFormularioCarga(null);
    }
    public function agregarGenero()
    {
        if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
            return $this->controladorError->mostrarError('Falta completar el título');
        }
        $ruta = (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) ? $this->procesarImagen() : null;

        //guardo los datos
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'] ?? null;
        $ruta_imagen =  $ruta;
        //mando a insertar
        $id = $this->modeloGeneros->agregarGenero($nombre, $descripcion, $ruta_imagen);
        if ($id > 0)
            return $this->mostrarGenero($id);
        else
        {
            unlink($ruta_imagen);
            return $this->controladorError->mostrarError("El genero $nombre no se pudo insertar. Es posible que ya exista un genero con el mismo nombre.");
        }
    }
    //procesamiento de imagen
    private function procesarImagen()
    { //devuelve una ruta de imagen si existe un archivo. sino retorna null. 
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $tipo = $_FILES['foto']['type'];
            if (($tipo == "image/jpg" || $tipo == "image/jpeg" || $tipo == "image/png")) {
                $archivo = $_FILES['foto']['name'];
                if ($archivo <> null) {
                    $informacion = pathinfo($archivo);
                    $fechaHoraActual = date('Y-m-d_H-i-s-ms');
                    $ruta = "img/" . $informacion['filename'] . $fechaHoraActual . '.' . $informacion['extension'];
                    move_uploaded_file($_FILES['foto']['tmp_name'], $ruta);
                    return $ruta;
                }
            }
        }
        return null;
    }
    //eliminar genero
    public function eliminarGenero($id)
    {
        // obtengo el género por id
        $genero = $this->modeloGeneros->obtenerGeneroPorId($id);
        if (!$genero) {
            return $this->controladorError->mostrarError("No existe el género con el id=$id");
        }
        //si existe reviso si tiene alguna relacion.
        $libros = $this->modeloLibros->obtenerLibrosPorGenero($id);
        if (!empty($libros)) {
            return $this->controladorError->mostrarError("No se pudo borrar el genero $genero->nombre por que tiene elementos relacionados.");
        } else {
            try {
                // borro el género y redirijo
                $this->modeloGeneros->eliminarGenero($id);
                unlink($genero->ruta_imagen);
                return  header('Location: ' . BASE_URL . "generos");
            } catch (PDOException $e) {
                return $this->controladorError->mostrarError("No se pudo borrar el genero $genero->nombre.");
            }
        }
    }

    //funcion para mostrar los datos de un genero y poder editarlos.
    public function datosGenero($id)
    {
        $genero = $this->modeloGeneros->obtenerGeneroPorId(intval($id));

        if (!$genero) {
            return $this->controladorError->mostrarError("No existe el género con el id=$id");
        }

        // muestra el género
        return $this->vista->mostrarFormularioCarga($genero);
    }


    public function editarGenero($id)
    {
        //verifico si existe
        $genero = $this->modeloGeneros->obtenerGeneroPorId(intval($id));
        if (!$genero) {
            return $this->controladorError->mostrarError("No existe el género con el id=$id");
        }
        //Proceso imagen en caso de ser necesario
        $ruta = $genero->ruta_imagen;
        if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {
            $ruta = $this->procesarImagen();
        }
        //Obtengo los datos del formulario para guardarlos en la BBDD
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'] ?? null;
        $ruta_imagen =  $ruta;

        try {
            // edito el género y redirijo
            $this->modeloGeneros->editarGenero(intval($id), $nombre, $descripcion, $ruta_imagen);
            if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {
                unlink($genero->ruta_imagen);
            }
            return  header('Location: ' . BASE_URL . "generos/$id");
        } catch (PDOException $e) {
            return $this->controladorError->mostrarError("No se pudo editar el genero $genero->nombre.");
        }
    }
}
