<div class="contenedor reestablecer">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Reestablece tu acceso</p>

        <!-- Formulario para registrar -->
        <form class="formulario" method="POST" action="/restablcer" novalidate>

            <!-- Campo para la contraseña -->
            <div class="campo">
                <label for="password">Contraseña</label>
                <input type="password" id="password" placeholder="Tu contraseña" name="password" />
            </div>

            <!-- Campo para verificar la contraseña -->
            <div class="campo">
                <label for="password2">Repetir la contraseña</label>
                <input type="password2" id="password2" placeholder="Repetir la contraseña" name="password2" />
            </div>

            <input type="submit" class="boton" value="Guardar contraseña">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar Seseión</a>
            <a href="/crear">¿Aún no tienes una cuenta? obtener una</a>

        </div>
    </div>
    <!--.contenedor-sm -->

</div>