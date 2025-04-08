const editarBtn = document.getElementById('editarBtn');
const guardarBtn = document.getElementById('guardarBtn');
const perfilForm = document.getElementById('perfilForm');

// Verificar si los campos de edición única ya han sido guardados
const isEditableOnce = !document.getElementById('fecha_nacimiento').value || 
                       !document.getElementById('altura').value || 
                       !document.getElementById('genero').value;

// Enable editing when "Editar" is clicked
editarBtn.addEventListener('click', function () {
  if (isEditableOnce) {
    // Habilitar campos de edición única si no han sido guardados
    perfilForm.querySelectorAll('#fecha_nacimiento, #altura, #genero').forEach(input => {
      input.removeAttribute('readonly');
      input.removeAttribute('disabled');
      input.classList.add('editable-active');
    });
  }

  // Habilitar siempre los campos editables múltiples
  perfilForm.querySelectorAll('#correo, #telefono, #peso').forEach(input => {
    input.removeAttribute('readonly');
    input.classList.add('editable-active');
  });

  guardarBtn.style.display = 'inline-block';
  editarBtn.style.display = 'none';
});

// Reset modal state when closed
document.getElementById('exampleModal').addEventListener('hidden.bs.modal', function () {
  perfilForm.reset(); // Reset form fields
  perfilForm.querySelectorAll('.form-control').forEach(input => input.setAttribute('readonly', true));
  perfilForm.querySelectorAll('.form-select').forEach(select => select.setAttribute('disabled', true));
  guardarBtn.style.display = 'none';
  editarBtn.style.display = 'inline-block';
});
