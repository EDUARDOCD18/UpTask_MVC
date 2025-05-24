<?php

namespace Model;

/* MODELO DE USUARIOS */

#[\AllowDynamicProperties]
class Usuario extends ActiveRecord
{
    protected static $table = 'usuarios';
    protected static $columnsDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    /* Validación para cuentas nuevas */
    public function validarNuevaCuenta(){
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        }

        return self::$alertas;
    }
}
