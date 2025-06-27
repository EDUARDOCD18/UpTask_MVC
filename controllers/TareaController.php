<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController
{
    /* Método principal */
    public static function index()
    {
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
            } else {
                $respuesta = [
                    'tipo' => 'exito',
                    'mensaje' => 'tarea agreda a tu proyecto.'
                ];
                echo json_encode($respuesta);
            }
        }
    }

    /* Método actualizar */
    public static function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }

    /* Método Eliminar */
    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }
}
