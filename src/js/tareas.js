(function () {
  obtenerTareas(); // Llamar a la función para obtener las tareas al cargar la página
  let tareas = [];
  let filtradas = [];

  // Botón para mostrar el Modal de Agregar tarea
  const nuevaTareaBtn = document.querySelector("#agregar-tarea");
  nuevaTareaBtn.addEventListener("click", function () {
    mostrarFormulario();
  });

  /* Filtros de búsqueda */
  const filtros = document.querySelectorAll('#filtros input[type="radio"]');

  filtros.forEach((radio) => {
    radio.addEventListener("input", filtrarTareas);
  });

  // console.log(filtros);

  // Función para filtrar las tareas
  function filtrarTareas(e) {
    const filtro = e.target.value;

    if (filtro !== "") {
      filtradas = tareas.filter((tarea) => tarea.estado === filtro);
    } else {
      filtradas = [];
    }

    // console.log(filtradas);
    mostrarTareas();
  }

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

  // Función para visualizar solo las tareas pendientes
  function totalPendientes() {
    const totalPendientes = tareas.filter((tareas) => tareas.estado === "0");
    const pendientesRadio = document.querySelector("#pendientes");

    if (totalPendientes.length === 0) {
      pendientesRadio.disabled = true;
    } else {
      pendientesRadio.disabled = false;
    }

    /*     console.log("Total: ");
    console.log(totalPendientes); */
  }

  // Función para visualizar solo las tareas completas
  function totalCompletas() {
    const totalCompletas = tareas.filter((tareas) => tareas.estado === "1");
    const completadasRadio = document.querySelector("#completadas");

    if (totalCompletas.length === 0) {
      completadasRadio.disabled = true;
    } else {
      completadasRadio.disabled = false;
    }

    /*     console.log("Total: ");
    console.log(totalCompletas); */
  }

  // Función para mostrar el fomrulario de agragar tarea
  function mostrarFormulario(editar = false, tarea = {}) {
    const modal = document.createElement("DIV"); // Crea el modal
    modal.classList.add("modal"); // Agrega la clase modal

    /* Crea el formulario HTML en el modal */
    modal.innerHTML = `
    <form class="formulario nueva-tarea">
      <legend>${editar ? "Editar tarea" : "Añade una nueva tarea"}</legend>
      <div class="campo">
        <label>Tarea</label>
        <input type="text" name="tarea" placeholder="${
          tarea.nombre ? "Edita la tarea" : "Añade una tarea al proyecto actual"
        }" id="tarea"
        value="${tarea.nombre ? tarea.nombre : ""}" />
      </div>

      <div class="opciones">
        <input type="submit" class="submit-nueva-tarea" value="${
          tarea.nombre ? "Editar la tarea" : "Añadir tarea"
        }" />
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
        const nombreTarea = document.querySelector("#tarea").value.trim();

        if (nombreTarea === "") {
          // Mostrar alerta de que el nombre de la Tarea no debe ir vacío
          mostrarAlerta(
            "El nombre de la tarea es obligatorio",
            "error",
            document.querySelector(".formulario legend")
          );
          return;
        }

        if (editar) {
          tarea.nombre = nombreTarea; // Asignar el nombre de la tarea al objeto tarea
          actualizarTarea(tarea); // Llamara a la función para editar la tarea
        } else {
          agregarTarea(nombreTarea); // Llamar a la función para agrgar la tarea
        }
      }
    });

    document.querySelector(".dashboard").appendChild(modal); // Agregal el modal al documento
  }

  // Fucnión para mostrar las tareas en el DOM
  function mostrarTareas() {
    // Limpiar el listado de tareas antes de mostrar
    limpiarTareas();
    totalPendientes();
    totalCompletas();

    const arrayTareas = filtradas.length ? filtradas : tareas;

    // Verificar si hay tareas
    if (arrayTareas.length === 0) {
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
    arrayTareas.forEach((tarea) => {
      const contenedorTarea = document.createElement("LI");
      contenedorTarea.dataset.tareaId = tarea.id; // Asignar el ID de la tarea al elemento LI
      contenedorTarea.classList.add("tarea");

      const nombreTarea = document.createElement("P");
      nombreTarea.textContent = tarea.nombre;

      // Editar el nombre de la tarea al hacer doble click
      nombreTarea.ondblclick = function () {
        mostrarFormulario((editar = true), { ...tarea });
      };

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
        Swal.fire(
          resultado.respuesta.mensaje,
          resultado.respuesta.mensaje,
          "success"
        );

        // Cerrar el modal
        const modal = document.querySelector(".modal");
        if (modal) {
          modal.remove();
        }
      }

      tareas = tareas.map((tareaMemoria) => {
        if (tareaMemoria.id === id) {
          tareaMemoria.estado = estado; // Actualizar el estado de la tarea en el arreglo de tareas.
          tareaMemoria.nombre = nombre; // Actualizar el estado de la tarea en el arreglo de tareas

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
