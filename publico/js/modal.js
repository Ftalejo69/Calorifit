document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("profile-modal");
    const viewProfile = document.getElementById("view-profile");
    const closeModal = document.getElementById("close-modal");
    const editButton = document.getElementById("edit-button");
    const saveButton = document.getElementById("save-button");
    const inputs = document.querySelectorAll("#profile-form input");

    viewProfile.addEventListener("click", (e) => {
        e.preventDefault();
        modal.style.display = "flex";
    });

    closeModal.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Add hover effect for close button
    closeModal.addEventListener("mouseover", () => {
        closeModal.style.cursor = "pointer";
    });

    editButton.addEventListener("click", () => {
        inputs.forEach(input => input.disabled = false);
        saveButton.disabled = false;
    });

    document.getElementById("profile-form").addEventListener("submit", (e) => {
        e.preventDefault();
        alert("Datos guardados exitosamente.");
        inputs.forEach(input => input.disabled = true);
        saveButton.disabled = true;
        modal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});
