<?php

namespace Controllers;

class LoginController
{
    /* LOGIN */
    public static function login()
    {
        echo "Desde LoginController";

        // En el caso de que el métido sea POST, se ejecuta el código
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }

    /* LOGOUT */
    public static function logout()
    {
        echo "Desde LogoutController";
    }

    /* CREACIÓN DE LA CUENTA */
    public static function crear()
    {
        echo "Desde CrearController";

        // En el caso de que el métido sea POST, se ejecuta el código
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }

    /* FORMULARIO EN CASO DE QUE SE OLVIDE EL PASSWORD */
    public static function olvide()
    {
        echo "Desde OlvideController";

        // En el caso de que el métido sea POST, se ejecuta el código
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }

    /* COLOCARL EL NUEVO PASSWORD */
    public static function restablecer()
    {
        echo "Desde RestablecerController";

        // En el caso de que el métido sea POST, se ejecuta el código
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }

    /* MENSAJE DE CONFIRMACIÓN DE CUENTA */
    public static function mensaje()
    {
        echo "Desde mensajeController";
    }

    /* CONFIRMACIÓN DE CUENTA */
    public static function confirmar()
    {
        echo "Desde confirmarController";
    }
}
