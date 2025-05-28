<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;

        // Configuración del servidor SMTP

    }

    /* Enviar la confirmación */
    public function enviarConfirmacion()
    {
        echo "Enviando email de confirmación a {$this->email}";
    }
}
