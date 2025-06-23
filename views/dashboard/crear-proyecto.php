<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<!-- Contenido de la página crear-proyecto -->
<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>
    <!-- Importa la plantilla de alertas -->

    <form action="/crear-proyecto" class="formulario" method="POST">
        <?php include_once __DIR__ . '/formulario-proyecto.php'; ?>
        <input type="submit" value="Crear Proyecto">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>