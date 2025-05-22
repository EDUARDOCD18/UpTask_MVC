<div class="contenedor olvide">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu contraseña de UpTask</p>

        <!-- Formulario para registrar -->
        <form class="formulario" method="POST" action="/olvide" novalidate>

            <!-- Campo para el correo de la persona -->
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu Email" name="email" />
            </div>

            <input type="submit" class="boton" value="Enviar instrucciones">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar Seseión</a>
            <a href="/crear">¿Aún no tienes una cuenta? obtener una</a>
        </div>
    </div>
    <!--.contenedor-sm -->

</div>