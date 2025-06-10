<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Proyecto;


class DashboardController
{
    public static function index(Router $router)
    {

        session_start();

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos'
        ]);
    }
}
