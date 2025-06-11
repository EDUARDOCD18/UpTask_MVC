<div class="barra">
    <p>
        Hola, <span><?php echo $_SESSION['nombre'] ?? 'Usuario'; ?> :D</span>
    </p>

    <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
</div>