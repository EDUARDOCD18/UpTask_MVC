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
        <label>Tarea</label>
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
        submitFormularioNuevaTarea();
      }
    });

    document.querySelector(".dashboard").appendChild(modal); // Agregal el modal al documento

    function submitFormularioNuevaTarea() {
      const tarea = document.querySelector("#tarea").value.trim();

      if (tarea === "") {
        // Mostrar alerta de que el nombre de la Tarea no debe ir vacío
        mostrarAlerta(
          "El nombre de la tarea es obligatorio",
          "error",
          document.querySelector(".formulario legend")
        );
        return;
      }
      // Al pasar las validaciones, llamar a:
      agregarTarea(tarea);
    }

    /* Función para mostrar la alerta */
    function mostrarAlerta(mensaje, tipo, referencia) {
      // Prevenir la creación de varias alertas
      const alertaPrevia = document.querySelector(".alerta");
      if (alertaPrevia) {
        alertaPrevia.remove();
      }

      const alerta = document.createElement("DIV");
      alerta.classList.add("alerta", tipo);
      alerta.textContent = mensaje;

      // Inserta la la alerta antes del legend
      referencia.parentElement.insertBefore(
        alerta,
        referencia.nextElementSibling
      );

      // Eliminar la alerta luego de 3 segundos
      setTimeout(() => {
        alerta.remove();
      }, 3000);
    }
  }

  /* Función para agregar la tarea. Consultar al servidor para agregar al proyecto actual */
  async function agregarTarea(tarea) {
    // Construir la petición
    const datos = new FormData();
    datos.append("nombre", tarea);
    console.log("1");

    try {
      const url = "http://localhost:3000/api/tarea";
      const respuesta = await fetch(url, {
        method: "POST",
        body: datos,
      });

      const resultado = await respuesta.json();
      console.log(resultado);
    } catch (error) {
      console.log(error);
    }
  }
})();
