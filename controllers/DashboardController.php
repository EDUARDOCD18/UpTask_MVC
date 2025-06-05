<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Proyecto;


class DashboardController
{
    public static function index(Router $router)
    {

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos'
        ]);
    }
}
