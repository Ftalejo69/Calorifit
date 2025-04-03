<!-- Navbar -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="../publico/css/nabvar.css">
<nav class="navbar navbar-expand-lg ">
        <div class="container">
            <a class="navbar-brand" href="../html/inicio.php">
                <span class="calori">Calori</span><span class="fit">Fit</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../vistas/planes.php">Planes</a></li>
                    <li class="nav-item"><a class="nav-link" href="../vistas/rutinas.php">Rutinas</a></li>
                    <li class="nav-item"><a class="nav-link" href="../vistas/ejercicios.php">Ejercicio</a></li>
                    
                    
                    <li class="nav-item"><a class="btn btn-danger m-1 " style="border-radius: 30px;" href="../php/index.php">Cerrar sesión</a></li>
                    <!-- Botón para abrir el modal -->
                    <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#exampleModal">
                          Ver Perfil
</button>
<!-- Modal para editar y mostrar los datos del usuario -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mi Perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="../php/editar_perfil.php">  <!-- Verifica que la acción sea la correcta -->
          
          <!-- Nombre (no editable) -->
          <div class="mb-3">
            <label for="nombre" class="form-label">
              <i class="fas fa-user"></i> Nombre
            </label>
            <!-- Mostrar el nombre del usuario desde la sesión -->
            <input type="text" class="form-control" id="nombre" placeholder="Ingrese su nombre" readonly value="<?= isset($usuario['nombre']) ? $usuario['nombre'] : ''; ?>" required>
          </div>

          <!-- Correo (editable) -->
          <div class="mb-3">
            <label for="correo" class="form-label">
              <i class="fas fa-envelope"></i> Correo
            </label>
            <!-- Mostrar el correo del usuario desde la sesión -->
            <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese su correo" value="<?= isset($usuario['correo']) ? $usuario['correo'] : ''; ?>" required>
          </div>

          <!-- Teléfono -->
          <div class="mb-3">
            <label for="telefono" class="form-label">
              <i class="fas fa-phone"></i> Teléfono
            </label>
            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ingrese su teléfono" value="<?= isset($usuario['telefono']) ? $usuario['telefono'] : ''; ?>" required>
          </div>

          <!-- Fecha de nacimiento -->
          <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">
              <i class="fas fa-birthday-cake"></i> Fecha de Nacimiento
            </label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= isset($usuario['fecha_nacimiento']) ? $usuario['fecha_nacimiento'] : ''; ?>" required>
          </div>

          <!-- Género -->
          <div class="mb-3">
            <label for="genero" class="form-label">
              <i class="fas fa-venus-mars"></i> Género
            </label>
            <select class="form-select" id="genero" name="genero" required>
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
            <input type="number" class="form-control" id="peso" name="peso" placeholder="Ingrese su peso" value="<?= isset($usuario['peso']) ? $usuario['peso'] : ''; ?>" step="0.1" required>
          </div>

          <!-- Altura -->
          <div class="mb-3">
            <label for="altura" class="form-label">
              <i class="fas fa-ruler-vertical"></i> Altura
            </label>
            <input type="number" class="form-control" id="altura" name="altura" placeholder="Ingrese su altura" value="<?= isset($usuario['altura']) ? $usuario['altura'] : ''; ?>" step="0.1" required>
          </div>

          <!-- Fecha de Registro (no editable) -->
          <div class="mb-3">
            <label for="fecha_registro" class="form-label">
              <i class="fas fa-calendar-alt"></i> Fecha de Registro
            </label>
            <input type="text" class="form-control" id="fecha_registro" placeholder="Fecha de Registro" readonly value="<?= isset($usuario['fecha_registro']) ? $usuario['fecha_registro'] : ''; ?>" required>
          </div>

          <!-- Botones -->
          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-warning ms-2" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-warning ms-2" name="action" value="update">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

                </ul>
            </div>
        </div>
    </nav>

