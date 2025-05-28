<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginController
{
    /* LOGIN */
    public static function login(Router $router)
    {
        // En el caso de que el métido sea POST, se ejecuta el código
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }

        // Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Inciar Sesión'
        ]);
    }

    /* LOGOUT */
    public static function logout()
    {
        echo "Desde LogoutController";
    }

    /* CREACIÓN DE LA CUENTA */
    public static function crear(Router $router)
    {
        $usuario = new Usuario;
        $alertas = [];

        // En el caso de que el métido sea POST, se ejecuta el código
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Validar que el usuario no exista
            if (empty($alertas)) {

                $existeUsuario = Usuario::where('email', $usuario->email);

                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya está registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashearPassword();

                    // eliminar password2
                    unset($usuario->password2);

                    // Generar un token único
                    $usuario->crearToken();

                    // Crear nuevo usuario
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        // Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crea tu cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    /* FORMULARIO EN CASO DE QUE SE OLVIDE EL PASSWORD */
    public static function olvide(Router $router)
    {

        // En el caso de que el métido sea POST, se ejecuta el código
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }

        // Render a la vista
        $router->render('auth/olvide', [
            'titulo' => 'Recupera tu contraseña'
        ]);
    }

    /* COLOCARL EL NUEVO PASSWORD */
    public static function reestablecer(Router $router)
    {
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablece tu contraseña'
        ]);

        // En el caso de que el métido sea POST, se ejecuta el código
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }

    /* MENSAJE DE CONFIRMACIÓN DE CUENTA */
    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje', [
            'titulo' => 'Notificación'
        ]);
    }

    /* CONFIRMACIÓN DE CUENTA */
    public static function confirmar(Router $router)
    {
        $router->render('auth/confirmar', [
            'titulo' => 'Confirmación'
        ]);
    }
}
