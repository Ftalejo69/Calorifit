document.addEventListener("DOMContentLoaded", () => {
    const userInfo = document.getElementById("user-info");
    const userMenu = document.getElementById("user-menu");

    // Mostrar/ocultar el menú al hacer clic en el avatar
    userInfo.addEventListener("click", () => {
        userMenu.classList.toggle("active");
    });

    // Cerrar el menú si se hace clic fuera de él
    document.addEventListener("click", (event) => {
        if (!userInfo.contains(event.target)) {
            userMenu.classList.remove("active");
        }
    });
});
