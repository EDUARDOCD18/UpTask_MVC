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

    setTimeout(() => {
      const formulario = document.querySelector(".formulario");
      formulario.classList.add("animar");
    }, 0);

    modal.addEventListener("click", function (e) {
      e.preventDefault();

      if (e.target.classList.contains("cerrar-modal")) {
        const formulario = document.querySelector(".formulario");
        formulario.classList.add("cerrar");

        setTimeout(() => {
          modal.remove();
        }, 500);
      }

      if (e.target.classList.contains("submit-nueva-tarea")) {
        submitFomularioNuevaTarea();
      }
    });

    document.querySelector("body").appendChild(modal); // Agregal el modal al documento

    function submitFomularioNuevaTarea() {
      const tarea = document.querySelector("#tarea").value.trim();

      if (tarea === "") {
        // Mostrar alerta de que el nombre de la Tarea no debe ir vacío

        return;
      } 
    }
  }
})();
