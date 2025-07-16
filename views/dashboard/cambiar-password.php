<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>

    <a href="/perfil" class="enlace">Volver</a>

    <form method="POST" class="formulario" action="perfil">
        <div class="campo">Contraseña actual </label>
            <input type="password" name="password_actual" placeholder="Tu contraseña actual">
        </div>

        <div class="campo">Contraseña nueva </label>
            <input type="password" name="password_nuevo" placeholder="Tu contraseña actual">
        </div>

        <input type="submit" value="Guardar cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>