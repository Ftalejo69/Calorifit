const editarBtn = document.getElementById('editarBtn');
const guardarBtn = document.getElementById('guardarBtn');
const perfilForm = document.getElementById('perfilForm');

// Enable editing when "Editar" is clicked
editarBtn.addEventListener('click', function () {
  perfilForm.querySelectorAll('.form-control').forEach(input => input.removeAttribute('readonly'));
  perfilForm.querySelectorAll('.form-select').forEach(select => select.removeAttribute('disabled'));
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
