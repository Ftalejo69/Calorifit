<link rel="stylesheet" href="../css/modal.css">
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

          <!-- Teléfono -->
          <div class="mb-3">
            <label for="telefono" class="form-label">
              <i class="fas fa-phone"></i> Teléfono
            </label>
            <!-- Mostrar el teléfono del usuario desde la sesión -->
            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ingrese su teléfono" value="<?= isset($usuario['telefono']) ? $usuario['telefono'] : ''; ?>" required>
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