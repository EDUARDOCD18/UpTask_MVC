(function () {
  obtenerTareas(); // Llamar a la función para obtener las tareas al cargar la página
  let tareas = [];

  // Botón para mostrar el Modal de Agregar tarea
  const nuevaTareaBtn = document.querySelector("#agregar-tarea");
  nuevaTareaBtn.addEventListener("click", mostrarFormulario);

  // Función para obtener las tareas del proyecto actual
  async function obtenerTareas() {
    try {
      const id = obtenerProyecto();
      const url = `/api/tareas?id=${id}`;
      const respuesta = await fetch(url);
      const resultado = await respuesta.json();

      tareas = resultado.tareas; // Asignar las tareas obtenidas a la variable tareas.

      // Llamar a la función para motrar las tareas
      mostrarTareas();
    } catch (error) {
      console.log(error);
    }
  }

  // Función para mostrar el fomrulario de agragar tarea
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
  }

  // Fucnión para mostrar las tareas en el DOM
  function mostrarTareas() {
    // Limpiar el listado de tareas antes de mostrar
    limpiarTareas();

    // Verificar si hay tareas
    if (tareas.length === 0) {
      const contenedorTareas = document.querySelector("#listado-tareas");
      const textoNoTareas = document.createElement("LI");

      textoNoTareas.textContent = "No hay tareas aún";
      textoNoTareas.classList.add("no-tareas");

      contenedorTareas.appendChild(textoNoTareas);
      return;
    }

    const estados = {
      0: "Pendiente",
      1: "Realizada",
    };

    // Iterar sobre las tareas y mostrarlas en el DOM
    tareas.forEach((tarea) => {
      const contenedorTarea = document.createElement("LI");
      contenedorTarea.dataset.tareaId = tarea.id; // Asignar el ID de la tarea al elemento LI
      contenedorTarea.classList.add("tarea");

      const nombreTarea = document.createElement("P");
      nombreTarea.textContent = tarea.nombre;

      const opcionesDiv = document.createElement("DIV");
      opcionesDiv.classList.add("opciones");

      // Botones

      /* Botón para cambiar el estado de la tarea */
      const btnEstadoTarea = document.createElement("BUTTON");
      btnEstadoTarea.classList.add("estado-tarea");
      btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`);
      btnEstadoTarea.textContent = estados[tarea.estado];
      btnEstadoTarea.dataset.estadoTarea = tarea.estado;
      btnEstadoTarea.ondblclick = function () {
        cambiarEstadoTarea({ ...tarea });
      };

      /* Botón para eliminar la tarea */
      const btnEliminarTarea = document.createElement("BUTTON");
      btnEliminarTarea.classList.add("eliminar-tarea");
      btnEliminarTarea.dataset.idTarea = tarea.id; // Asignar el ID de la tarea al botón.
      btnEliminarTarea.textContent = "Eliminar";
      btnEliminarTarea.ondblclick = function () {
        confirmarEliminarTarea({ ...tarea });
      };

      opcionesDiv.appendChild(btnEstadoTarea);
      opcionesDiv.appendChild(btnEliminarTarea);

      contenedorTarea.appendChild(nombreTarea);
      contenedorTarea.appendChild(opcionesDiv);

      const listadoTareas = document.querySelector("#listado-tareas");
      listadoTareas.appendChild(contenedorTarea);
    });
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
    }, 2500);
  }

  /* Función para agregar la tarea. Consultar al servidor para agregar al proyecto actual */
  async function agregarTarea(tarea) {
    // Construir la petición
    const datos = new FormData();
    datos.append("nombre", tarea); // Asignar el nombre de la tardea
    datos.append("proyectoId", obtenerProyecto()); // Asignar el ID del proyecto

    try {
      const url = "http://localhost:3000/api/tarea";
      const respuesta = await fetch(url, {
        method: "POST",
        body: datos,
      });

      const resultado = await respuesta.json();
      console.log(resultado);

      mostrarAlerta(
        resultado.mensaje,
        resultado.tipo,
        document.querySelector(".formulario legend")
      );

      // Cerrar el modal luego de agregar la tares
      if (resultado.tipo === "exito") {
        const modal = document.querySelector(".modal");

        setTimeout(() => {
          modal.remove();
        }, 2500);

        // Agregar el objeto de tarea al arreglo de tareas
        const tareaObj = {
          id: String(resultado.id),
          nombre: tarea,
          estado: 0,
          proyectoId: resultado.proyectoId,
        };

        tareas = [...tareas, tareaObj]; // Asignar el nuevo objeto de tarea al arreglo de tareas.
        mostrarTareas(); // Llamar a la función para mostrar las tareas en el DOM.

        console.log(tareaObj);
      }
    } catch (error) {
      console.log(error);
    }
  }

  /* Función para cambiar el estado de la tarea */
  function cambiarEstadoTarea(tarea) {
    const nuevoEstado = tarea.estado === "1" ? "0" : "1";
    tarea.estado = nuevoEstado;

    actualizarTarea(tarea); // Actualiza la tarea en el servidor
  }

  /* Función para actualizar la tarea */
  async function actualizarTarea(tarea) {
    const { estado, id, nombre, proyectoId } = tarea;

    const datos = new FormData();
    datos.append("id", id);
    datos.append("nombre", nombre);
    datos.append("estado", estado);
    datos.append("proyectoId", obtenerProyecto());

    // Ver en consola los datos que se envían
    /* for (let valor of datos.values()) {
      console.log(valor);
    } */

    try {
      const url = "http://localhost:3000/api/tarea/actualizar";
      const respuesta = await fetch(url, {
        method: "POST",
        body: datos,
      });

      const resultado = await respuesta.json();

      if (resultado.respuesta.tipo === "exito") {
        mostrarAlerta(
          resultado.respuesta.mensaje,
          resultado.respuesta.tipo,
          document.querySelector(".contenedor-nueva-tarea")
        );
      }

      tareas = tareas.map((tareaMemoria) => {
        if (tareaMemoria.id === id) {
          tareaMemoria.estado = estado; // Actualizar el estado de la tarea en el arreglo de tareas.

          // console.log("Esta sí es");
        } /* else{
          console.log('Esta no es');
        } */

        return tareaMemoria;
      });

      mostrarTareas(); // Llamar a la función para mostrar las tareas en el DOM.
    } catch (error) {
      console.log(error);
    }
  }

  /* Función para confirmar la eliminación de la tarea */
  function confirmarEliminarTarea(tarea) {
    Swal.fire({
      title: "¿Desea eliminar la tarea?",
      showCancelButton: true,
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "No, cancelar",
    }).then((result) => {
      // Si el usuario confirma la eliminación.
      if (result.isConfirmed) {
        eliminarTarea(tarea); // Llamar a lafunción para eliminar la tarea.
      }
    });
  }

  /* Función para eliminar la tarea */
  async function eliminarTarea(tarea) {
    const { estado, id, nombre } = tarea;

    const datos = new FormData();
    datos.append("id", id);
    datos.append("nombre", nombre);
    datos.append("estado", estado);
    datos.append("proyectoId", obtenerProyecto());

    try {
      const url = "http://localhost:3000/api/tarea/eliminar";
      const respuesta = await fetch(url, {
        method: "POST",
        body: datos,
      });

      // console.log(respuesta);

      const resultado = await respuesta.json();

      if (resultado.resultado) {
        /* mostrarAlerta(
          resultado.mensaje,
          resultado.tipo,
          document.querySelector(".contenedor-nueva-tarea")
        );
 */
        Swal.fire("eliminado", resultado.mensaje, "success");

        tareas = tareas.filter((tareaMemoria) => tareaMemoria.id !== tarea.id); // Filtrar las tareas para eliminar la tarea que se ha eliminado.
        mostrarTareas(); // Llamar a la función para mostrar las tareas en el DOM.
      }
    } catch (error) {
      console.log(error);
    }
  }

  /* Función para obtener el proyecto */
  function obtenerProyecto() {
    // Obtener el ID del proyecto desde la URL
    const proyectoParams = new URLSearchParams(window.location.search);
    const proyecto = Object.fromEntries(proyectoParams.entries());

    return proyecto.id;
  }

  /* Función para limpiar el listado de tareas */
  function limpiarTareas() {
    const listadoTareas = document.querySelector("#listado-tareas");

    while (listadoTareas.firstChild) {
      listadoTareas.removeChild(listadoTareas.firstChild);
    }
  }
})();
