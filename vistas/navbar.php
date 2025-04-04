<!-- Navbar -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="../publico/css/nabvar.css">
<nav class="navbar navbar-expand-lg ">
    <div class="container">
        <a class="navbar-brand" href="../vistas/inicio.php">
            <span class="calori">Calori</span><span class="fit">Fit</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../vistas/planes.php">Acerca de</a></li>
                <li class="nav-item"><a class="nav-link" href="../vistas/rutinas.php">Rutinas</a></li>
                <li class="nav-item"><a class="nav-link" href="../vistas/ejercicios.php">Historial</a></li>
                <li class="nav-item"><a class="btn btn-danger m-1 " style="border-radius: 30px;" href="../vistas/index.php">Cerrar sesión</a></li>
                <!-- Botón para abrir el modal -->
                <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Ver Perfil
                </button>
            </ul>
        </div>
    </div>
</nav>

<!-- Modal for user profile -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content profile-modal">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mi Perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="../modelos/editar_perfil.php" id="perfilForm">
          <!-- Nombre (no editable) -->
          <div class="mb-3">
            <label for="nombre" class="form-label">
              <i class="fas fa-user"></i> Nombre
            </label>
            <input type="text" class="form-control" id="nombre" name="nombre" readonly value="<?= isset($usuario['nombre']) ? $usuario['nombre'] : ''; ?>">
          </div>

          <!-- Correo -->
          <div class="mb-3">
            <label for="correo" class="form-label">
              <i class="fas fa-envelope"></i> Correo
            </label>
            <input type="email" class="form-control" id="correo" name="correo" readonly value="<?= isset($usuario['correo']) ? $usuario['correo'] : ''; ?>">
          </div>

          <!-- Teléfono -->
          <div class="mb-3">
            <label for="telefono" class="form-label">
              <i class="fas fa-phone"></i> Teléfono
            </label>
            <input type="tel" class="form-control" id="telefono" name="telefono" readonly value="<?= isset($usuario['telefono']) ? $usuario['telefono'] : ''; ?>">
          </div>

          <!-- Fecha de nacimiento -->
          <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">
              <i class="fas fa-birthday-cake"></i> Fecha de Nacimiento
            </label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" readonly value="<?= isset($usuario['fecha_nacimiento']) ? $usuario['fecha_nacimiento'] : ''; ?>">
          </div>

          <!-- Género -->
          <div class="mb-3">
            <label for="genero" class="form-label">
              <i class="fas fa-venus-mars"></i> Género
            </label>
            <select class="form-select" id="genero" name="genero" disabled>
              <option value="M" <?= isset($usuario['genero']) && $usuario['genero'] == 'M' ? 'selected' : ''; ?>>Masculino</option>
              <option value="F" <?= isset($usuario['genero']) && $usuario['genero'] == 'F' ? 'selected' : ''; ?>>Femenino</option>
              <option value="Otro" <?= isset($usuario['genero']) && $usuario['genero'] == 'Otro' ? 'selected' : ''; ?>>Otro</option>
            </select>
          </div>

          <!-- Peso -->
          <div class="mb-3">
            <label for="peso" class="form-label">
              <i class="fas fa-weight"></i> Peso
            </label>
            <input type="number" class="form-control" id="peso" name="peso" readonly value="<?= isset($usuario['peso']) ? $usuario['peso'] : ''; ?>" step="0.1">
          </div>

          <!-- Altura -->
          <div class="mb-3">
            <label for="altura" class="form-label">
              <i class="fas fa-ruler-vertical"></i> Altura
            </label>
            <input type="number" class="form-control" id="altura" name="altura" readonly value="<?= isset($usuario['altura']) ? $usuario['altura'] : ''; ?>" step="0.1">
          </div>

          <!-- Fecha de Registro (no editable) -->
          <div class="mb-3">
            <label for="fecha_registro" class="form-label">
              <i class="fas fa-calendar-alt"></i> Fecha de Registro
            </label>
            <input type="text" class="form-control" id="fecha_registro" readonly value="<?= isset($usuario['fecha_registro']) ? $usuario['fecha_registro'] : ''; ?>">
          </div>

          <!-- Botones -->
          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-secondary ms-2" id="editarBtn">Editar</button>
            <button type="submit" class="btn btn-primary ms-2" id="guardarBtn" style="display: none;">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
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
</script>

