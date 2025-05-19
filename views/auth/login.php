<div class="contenedor">
    <h1>UpTask</h1>
    <p>Crea y Administra tus proyectos</p>

    <!-- Conetenedor para el apartado de inicio de sesión -->
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <!-- Formulario para el inicio de la sesión -->
        <form action="/" class="formulario" method="POST">
            <div class="campo">
                <!-- Solicitar correo -->
                <label for="email">Correo:</label>
                <input type="email" name="email" id="email" placeholder="Tu correo" required>

                <!-- Solicitar contrseña -->
                <label for="password">Constraseña:</label>
                <input type="password" name="password" id="password" placeholder="Constraseña" required>
            </div> <!-- fin .campo -->

            <!-- Enviar formulario -->
            <input type="submit" value="Iniciar Sesión" class="boton">

        </form> <!-- fin .formulario -->

        <div class="acciones">
            <a href="/crear">¿Aún no tienes cuenta? Crear una</a>
            <a href="/olvide">Olvidé mi contraseña</a>
        </div> <!-- fin .acciones -->
    </div> <!-- fin .contenedor-sm -->
</div>