<!-- Vista para el proyecto -->

<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <div class="contenedor-nueva-tarea">
        <button type="button" class="agregar-tarea" id="agregar-tarea">+ Nueva tarea</button>
    </div>

    <!-- Filtros para las tares -->
    <div class="filtros" id="filtros">
        <div class="filtros-inputs">
            <h2>Filtros:</h2>

            <!-- Filtrar por todas las tarea -->
            <div class="campo">
                <label for="todas">Todas</label>
                <input type="radio" id="todas" name="filtro" value="" checked>
            </div>

            <!-- Filtrar por completadas -->
            <div class="campo">
                <label for="todas">Completadas</label>
                <input type="radio" id="completadas" name="filtro" value="1">
            </div>

            <!-- Filtrar por pendientes -->
            <div class="campo">
                <label for="todas">Pendientes</label>
                <input type="radio" id="pendientes" name="filtro" value="0">
            </div>
        </div>
    </div>

    <ul id="listado-tareas" class="listado-tareas">

    </ul>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>

<?php $script .= '
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="build/js/tareas.js"></script>' ?>