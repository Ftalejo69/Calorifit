document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.ejercicio-check');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const ejercicioItem = this.closest('.ejercicio');
            const ejercicioId = this.getAttribute('data-ejercicio-id');
            
            if (this.checked) {
                ejercicioItem.classList.add('completado');
                guardarProgreso(ejercicioId, true);
            } else {
                ejercicioItem.classList.remove('completado');
                guardarProgreso(ejercicioId, false);
            }
        });
    });
});

function guardarProgreso(ejercicioId, completado) {
    fetch('../controladores/guardar_progreso.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            ejercicio_id: ejercicioId,
            completado: completado
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert('Error al guardar el progreso');
        }
    });
}
