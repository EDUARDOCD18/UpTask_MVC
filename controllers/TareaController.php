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
            echo json_encode($_POST);
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
