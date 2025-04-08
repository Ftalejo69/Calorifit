document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.ejercicio-check');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const ejercicioItem = this.closest('.ejercicio');
            if (this.checked) {
                ejercicioItem.classList.add('completado');
            } else {
                ejercicioItem.classList.remove('completado');
            }
        });
    });
});
