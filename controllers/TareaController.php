<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;
use Model\Usuario;
use MVC\Router;

class TareaController
{
    /* Método principal */
    public static function index()
    {

        session_start();

        $proyectoId = $_GET['id']; // Obtenerel ID del protecto desde la URL.

        if (!$proyectoId) header('Location: /dashboard'); // Redirigir si no hay ID.

        $proyecto = Proyecto::where('url', $proyectoId); // Consultar la base de datos por medio de la URL obtenida. 

        if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) header('Location: /404'); // Redirigier si no existe el proyecto o si no es el propietario. 

        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);

        echo json_encode(['tareas' => $tareas]);
    }

    /* Método crear */
    public static function crear()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $proyectoId = $_POST['proyectoId'];

            $proyecto = Proyecto::where(
                'url',
                $proyectoId
            );

            // Verificar si el proyecto existe
            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {

                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Error al agregar la tarea.'
                ];

                echo json_encode($respuesta);
                return;
            }

            // Todo bien, instanciar y crear la tarea
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta =  [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Tarea creada correctamente',
                'proyectoId' => $proyecto->id
            ];

            echo json_encode($respuesta);
        }
    }

    /* Método actualizar */
    public static function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que el proyecto exista
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            session_start();

            // Verificar si el proyecto existe
            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {

                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Error al actualizar la tarea.'
                ];

                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;

            // Guardar la tarea actualizada.
            $resultado = $tarea->guardar();
            if ($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Actulaizado correctamente'
                ];
            }

            echo json_encode(['respuesta' => $respuesta]);
        }
    }

    /* Método Eliminar */
    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validar que el proyecto exista
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            session_start();

            // Verificar si el proyecto existe
            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {

                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Error al actualizar la tarea.'
                ];

                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tarea($_POST);
            $resultado = $tarea->eliminar();

            $resultado = [
                'resultado' => $resultado,
                'mensaje' => "Tarea eliminada correctamente",
                'tipo' => 'exito',
            ];

            echo json_encode($resultado);
        }
    }
}
