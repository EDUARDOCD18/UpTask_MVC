<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\DashboardController;
use MVC\Router;

$router = new Router();

/* LOGIN */
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);

/* LOGOUT */
$router->get('/logout', [LoginController::class, 'logout']);

/* CREACIÓN DE CUENTA*/
$router->get('/crear', [LoginController::class, 'crear']);
$router->post('/crear', [LoginController::class, 'crear']);

/* FORMULARIO EN CASO DE QUE SE OLVIDE EL PASSWORD */
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);

/* COLOCAR EL NUEVO PASSWORD */
$router->get('/reestablecer', [LoginController::class, 'reestablecer']);
$router->post('/reestablecer', [LoginController::class, 'reestablecer']);

/* MENSAJE DE CONFIRMACIÓN DE CUENTA */
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar', [LoginController::class, 'confirmar']);

/* ZONA DE PROYECTOS */
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/crear-proyecto', [DashboardController::class, 'crear_proyecto']);
$router->get('/perfil', [DashboardController::class, 'perfil']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
