<?php

namespace Model;

/* MODELO DE USUARIOS */

#[\AllowDynamicProperties]
class Usuario extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'token', 'confirmado'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $password2;
    public $password_actual;
    public $password_nuevo;
    public $token;
    public $confirmado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? null;
        $this->password_actual = $args['password_actual'] ?? null;
        $this->password_nuevo = $args['password_nuevo'] ?? null;
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    /* Validar el login de Usuarios */
    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El correo no es válido';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }

        return self::$alertas;
    }

    /* Validación para cuentas nuevas */
    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if (!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe tener al menos 6 caracteres';
        }

        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Las constraseñas no coinciden';
        }

        return self::$alertas;
    }

    /* Validar un email */
    public function validarEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El correo no es válido';
        }

        return self::$alertas;
    }

    /* Validar el password */
    public function validarPassword()
    {
        if (!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe tener al menos 6 caracteres';
        }

        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Las contraseñas no coinciden';
        }

        return self::$alertas;
    }

    /* Validar el perfil */
    public function validar_perfil()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El Correo es Obligatorio';
        }

        return self::$alertas;
    }

    /* Nuevo password */
    public function nuevo_password()
    {
        if (!$this->password_actual) {
            self::$alertas['error'][] = 'La contraseña actual no puede ir vaciá';
        }

        if (!$this->password_actual) {
            self::$alertas['error'][] = 'La contraseña nueva no puede ir vaciá';
        }

        if (strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'La contraseña debe tener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    /* Comnprobar que el password sea el correcto al momento de cambiarlo */
    public function comprobar_password(): bool
    {
        return password_verify($this->password_actual, $this->password);
        
    }

    /* Hashear el password */
    public function hashearPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    /* Generar un token único */
    public function crearToken(): void
    {
        $this->token = uniqid();
    }
}
