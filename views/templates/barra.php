<div class="barra">
    <p>
        Hola, <?php echo $_SESSION['nombre'] ?? 'Usuario'; ?> :D
    </p>

    <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
</div>