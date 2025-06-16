<?php

namespace Controllers;

use MVC\Router;
use Model\Proyecto;


class DashboardController
{
    public static function index(Router $router)
    {

        session_start();
        isAuth();

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos'
        ]);
    }

    /* Crear el proyecto */
    public static function crear_proyecto(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);
            
            // Validación
            $alertas = $proyecto->validarProyecto();

            // Si pasa la validación
            if(empty($alertas)){
                // Guardar el proyecto
                debuguear($proyecto);
            }
        }

        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas
        ]);
    }

    /* Perfil */
    public static function perfil(Router $router)
    {
        session_start();
        isAuth();

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil'
        ]);
    }
}
