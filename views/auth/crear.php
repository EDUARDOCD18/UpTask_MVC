<div class="contenedor crear">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>
        <!-- Formulario para registrar -->
        <form class="formulario" method="POST" action="/crear" novalidate>

            <!-- Campo para el nombre de la persona -->
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu nombre" name="nombre" value="<?php echo is_object($usuario) ? $usuario->nombre : ''; ?>"/>
            </div>

            <div class="campo">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" placeholder="Tu apellido" name="apellido" value="<?php echo is_object($usuario) ? $usuario->apellido : ''; ?>"/>
            </div>

            <!-- Campo para el correo de la persona -->
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu Email" name="email" value="<?php echo is_object($usuario) ? $usuario->email : ''; ?>"/>
            </div>

            <!-- Campo para la contraseña -->
            <div class="campo">
                <label for="password">Contraseña</label>
                <input type="password" id="password" placeholder="Tu contraseña" name="password" />
            </div>

            <!-- Campo para verificar la contraseña -->
            <div class="campo">
                <label for="password2">Repetir la contraseña</label>
                <input type="password" id="password2" placeholder="Repetir la contraseña" name="password2" />
            </div>

            <input type="submit" class="boton" value="Crear cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar Seseión</a>
            <a href="/olvide">¿Olvidaste tu Password?</a>
        </div>
    </div>
    <!--.contenedor-sm -->

</div>