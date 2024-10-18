<?php
require_once './app/modelos/generos.modelo.php';
require_once './app/vistas/generos.vista.php';

class GenerosControlador
{
    private $modelo;
    private $vista;
    //Revisado
    public function __construct($res)
    {
        $this->modelo = new GenerosModelo();
        $this->vista = new GenerosVista($res->user);
    }
    //revisado
    public function mostrarGeneros()
    {
        // obtengo los géneros de la DB
        $generos = $this->modelo->obtenerGeneros();

        // mando los géneros a la vista
        return $this->vista->mostrarGeneros($generos);
    }

    public function mostrarGenero($id)
    {
        // obtengo los géneros de la DB
        $genero = $this->modelo->obtenerGenero($id);
        //obtiene los libros pertencientes a el genero.
        $libros = $this->modelo->obtenerLibros($id);
        // mando los géneros a la vista
        return $this->vista->detalleGenero($genero, $libros);
    }

    public function mostrarFormularioCarga()
    {
        return $this->vista->mostrarFormularioCarga(null);
    }

    private function procesarImagen()
    {
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $fileType = $_FILES['foto']['type'];
            if (($fileType == "image/jpg" || $fileType == "image/jpeg" || $fileType == "image/png" )) {


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

    //revisado
    public function agregarGenero()
    {
        if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
            return $this->vista->mostrarError('Falta completar el título');
        }

        $ruta = $this->procesarImagen();

        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'] ?? null;
        $ruta_imagen =  $ruta;

        $id = $this->modelo->insertarGenero($nombre, $descripcion, $ruta_imagen);

        // redirijo al home (también podríamos usar un método de una vista para mostrar un mensaje de éxito)
        header('Location: ' . BASE_URL);
    }

    public function borrarGenero($id)
    {
        // obtengo el género por id
        $genero = $this->modelo->obtenerGenero($id);

        if (!$genero) {
            return $this->vista->mostrarError("No existe el género con el id=$id");
        }

        // borro el género y redirijo
        $this->modelo->borrarGenero($id);

        header('Location: ' . BASE_URL . "generos");
    }
    public function datosGenero($id)
    {
        $genero = $this->modelo->obtenerGenero($id);

        if (!$genero) {
            return $this->vista->mostrarError("No existe el género con el id=$id");
        }

        // muestra el género
        return $this->vista->mostrarFormularioCarga($genero);
    }


    public function editarGenero($id)
    {
        $genero = $this->modelo->obtenerGenero($id);

        if (!$genero) {
            return $this->vista->mostrarError("No existe el género con el id=$id");
        }
        $ruta = $genero->ruta_imagen;

        if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {
            //BORRAR LA FOTO;

            $ruta = $this->procesarImagen();
        }

        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'] ?? null;
        $ruta_imagen =  $ruta;

        // actualiza el género
        $this->modelo->actualizarGenero($id, $nombre, $descripcion, $ruta_imagen);

        header('Location: ' . BASE_URL . "generos/$id");
    }
}
