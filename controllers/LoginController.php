<?php

namespace Controllers;

use Classes\Email;
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

                    // Enviar el email de confirmación
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

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
        $alertas = [];
        // En el caso de que el métido sea POST, se ejecuta el código
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if (empty($alertas)) {
                // Buscar al usuario por el correo
                $usuario = Usuario::where('email', $usuario->email);

                if ($usuario && $usuario->confirmado) {
                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2); // Eliminar el password2

                    // Actualizar el usuario con el nuevo token
                    $usuario->guardar();

                    // Enviar el email de recuperación
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // Imprimir alerta de éxito
                    Usuario::setAlerta('exito', 'Hemos enviado un correo con las instrucciones para reestablecer tu contraseña');
                } else {
                    // Si no existe el usuario, mostrar alerta
                    Usuario::setAlerta('error', 'El correo no existe o la cuenta no está confirmada');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        // Render a la vista
        $router->render('auth/olvide', [
            'titulo' => 'Recupera tu contraseña',
            'alertas' => $alertas
        ]);
    }

    /* COLOCARL EL NUEVO PASSWORD */
    public static function reestablecer(Router $router)
    {
        $alertas = [];
        $mostrar = true;
        $token = s($_GET['token'] ?? null);

        if (!$token) header('Location: /');

        // Buscar al usuario por el token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
            $mostrar = false;
        }

        $alertas = Usuario::getAlertas();

        // En el caso de que el métido sea POST, se ejecuta el código
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Añadir el nuevo password
            $usuario->sincronizar($_POST);

            // Validar el password
            $alertas = $usuario->validarPassword();

            if(empty($alertas)){
                //  Hashear el password
                $usuario->hashearPassword();
                unset($usuario->password2); // Eliminar el password2

                // Eliminar el token
                $usuario->token = '';

                // Guardar el nuevo password
                $resultado = $usuario->guardar();

                // Redireccionar al login
                if($resultado){
                    header('Location: /');
                }

            }
        }

        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablece tu contraseña',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
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
        $alertas = [];
        $token = s($_GET['token'] ?? null);

        if (!$token) header('Location: /');

        // Buscar al usuario por el token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // Si no existe el token
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            // confirmar la cuenta
            $usuario->confirmado = 1;
            unset($usuario->password2); // Eliminar el password2
            $usuario->token = ""; // Eliminar el token

            $usuario->guardar(); // Guardar los cambios

            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar', [
            'titulo' => 'Confirmación',
            'alertas' => $alertas
        ]);
    }
}
