<?php

namespace Controllers;

use MVC\Router;
use Model\Proyecto;
use Model\Usuario;


class DashboardController
{
    public static function index(Router $router)
    {

        session_start();
        isAuth();

        $id = $_SESSION['id'];

        $proyectos = Proyecto::belongsTo('propietarioId', $id);

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
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

            // validación
            $alertas = $proyecto->validarProyecto();

            if (empty($alertas)) {
                // Generar una URL única 
                $hash = md5(uniqid());
                $proyecto->url = $hash;

                // Almacenar el creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];

                // Guardar el Proyecto
                $proyecto->guardar();

                // Redireccionar
                header('Location: /proyecto?id=' . $proyecto->url);
            }
        }

        $router->render('dashboard/crear-proyecto', [
            'alertas' => $alertas,
            'titulo' => 'Crear Proyecto'
        ]);
    }

    /* Visualizar el proyecto */
    public static function proyecto(Router $router)
    {

        session_start();
        isAuth();

        $token = $_GET['id']; // Obtener el ID del proyecto desde la URL

        if (!$token) header('Location /dashboard'); // Si el ID no existe, redireccionar a proyectos

        // Validar que la persona que visita el proyecto es la misma que lo creó
        $proyecto = Proyecto::where('url', $token);
        if ($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }

    /* Método para el perfil */
    public static function perfil(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);
        // debuguear($usuario);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar_perfil();
            // debuguear($usuario);

            if (empty($aletas)) {
                // Guardar los cambios en la BDD
                $usuario->guardar(); // Guarda el registro

                Usuario::setAlerta('exito', 'Guardado correctamente');
                $alertas = $usuario->getAlertas();

                $_SESSION['nombre'] = $usuario->nombre; // Actualiza el nombre en la sesión en la barra.
            }
        }

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }
}
