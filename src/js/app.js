const mobileMenuBtn = document.querySelector("#mobile-menu");
const cerrarMenuBtn = document.querySelector("#cerrar-menu");
const sidebar = document.querySelector(".sidebar");

/* Mostrar el menú mobile */
if (mobileMenuBtn) {
  mobileMenuBtn.addEventListener("click", function () {
    sidebar.classList.add("mostrar"); // Añande la clase que que muestra el menú mobile
  });
}

/* Remover el menú mobile */
if (cerrarMenuBtn) {
  cerrarMenuBtn.addEventListener("click", function () {
    sidebar.classList.add("ocultar");

    setTimeout(() => {
      sidebar.classList.remove("mostrar"); // Remueve la clase que que muestra el menú mobile
      sidebar.classList.remove("ocultar");
    }, 800);
  });
}

/* Elimina la clase de mostrar en tamaño de tablet o mayores */
window.addEventListener("resize", function () {
  const anchoPantalla = document.body.clientWidth;
  if (anchoPantalla >= 768) {
    sidebar.classList.remove("mostrar");
  }
});
