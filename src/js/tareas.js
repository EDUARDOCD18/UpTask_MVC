(function () {
  // Botón para mostrar el Modal de Agregar tarea
  const nuevaTareaBtn = document.querySelector("#agregar-tarea");
  nuevaTareaBtn.addEventListener("click", function () {
    mostrarFormulario();
  });

  function mostrarFormulario() {
    const modal = document.createElement("DIV"); // Crea el modal
    modal.classList.add("modal"); // Agrega la clase modal

    /* Crea el formulario HTML en el modal */
    modal.innerHTML = `
    <form class="formulario nueva-tarea">
      <legend>Añade una nueva tarea</legend>
      <div class="campo">
        <label for="">Tarea</label>
        <input type="text" name="tarea" placeholder="Añadir tarea" id="tarea" />
      </div>

      <div class="opciones">
        <input type="submit" class="submit-nueva-tarea" value="Añadir" />
        <button type="button" class="cerrar-modal">Cancelar</button>
      </div>
    </form>
    `;

    document.querySelector("body").appendChild(modal); // Agregal el modal al documento
  }
})();
