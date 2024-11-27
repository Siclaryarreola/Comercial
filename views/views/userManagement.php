<?php
$activePage = 'users';
require_once('components/header.php');
require_once('../models/userModel.php');

// Instancia del modelo y obtención de datos
$userModel = new UserModel();
$usuarios = $userModel->getUsuarios();
$puestos = $userModel->getPuestos();
$sucursales = $userModel->getSucursales();
$roles = $userModel->getRoles();

// Validación de permisos
$rolPermitido = 1;
if ($_SESSION['user']['rol'] != $rolPermitido) {
    header("HTTP/1.1 404 Not Found");
    include('404content.php');
    exit;
}
?>

<main class="container mt-4">
    <h1>Gestión de Usuarios</h1>
    <p>Listado y gestión de usuarios del sistema.</p>
    <!-- Contenedor de alerta para mostrar mensajes -->
    <div id="alertContainer" class="alert d-none" role="alert"></div>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Añadir Usuario</button>
        <div class="d-flex">
            <input type="text" id="userSearch" class="form-control mr-2" placeholder="Buscar usuario">
            <button class="btn btn-secondary" onclick="filterUsers()">Filtrar Usuarios</button>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre de Usuario</th>
                <th>Correo Electrónico</th>
                <th>Puesto</th>
                <th>Sucursal</th>
                <th>Estado</th>
                <th>Último Acceso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios) && count($usuarios) > 0): ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['puesto']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['sucursal']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['estado']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['ultimo_acceso'] ?? 'No registrado'); ?></td>
                        <td>
                            <button 
                                class="btn btn-sm btn-warning" 
                                data-toggle="modal" 
                                data-target="#editUserModal"
                                onclick="fillEditModal(
                                    '<?php echo $usuario['id']; ?>',
                                    '<?php echo $usuario['nombre']; ?>',
                                    '<?php echo $usuario['correo']; ?>',
                                    '<?php echo $usuario['puesto']; ?>',
                                    '<?php echo $usuario['sucursal']; ?>',
                                    '<?php echo $usuario['estado']; ?>'
                                )">Editar</button>
                            <a href="javascript:void(0);" 
                               class="btn btn-sm btn-danger" 
                               onclick="confirmDeleteUser('../controllers/userController.php?action=deleteUser&id=<?php echo $usuario['id']; ?>')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No se encontraron usuarios.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<script>
    function filterUsers() {
        const filterValue = document.getElementById('userSearch').value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const username = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            const email = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

            if (username.includes(filterValue) || email.includes(filterValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>

<!-- Modal for Adding a New User -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Añadir Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" action="../controllers/userController.php?action=addUser" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" required>
                            </div>
                            <div class="form-group">
                                <label for="rol">Rol</label>
                                <select class="form-control" id="rol" name="rol" required>
                                    <option value="" selected>Seleccionar</option>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?php echo $role['id']; ?>"><?php echo $role['rol']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="puesto">Puesto</label>
                                <select class="form-control" id="puesto" name="puesto" required>
                                    <option value="" selected>Seleccionar</option>
                                    <?php foreach ($puestos as $puesto): ?>
                                        <option value="<?php echo $puesto['id']; ?>"><?php echo $puesto['puesto']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sucursal">Sucursal</label>
                                <select class="form-control" id="sucursal" name="sucursal" required>
                                    <option value="" selected>Seleccionar</option>
                                    <?php foreach ($sucursales as $sucursal): ?>
                                        <option value="<?php echo $sucursal['id']; ?>"><?php echo $sucursal['sucursal']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing a User -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" action="../controllers/userController.php?action=editUser" method="POST">
                    <input type="hidden" id="editUserId" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editNombre">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="editNombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="editCorreo">Correo Electrónico</label>
                                <input type="email" class="form-control" id="editCorreo" name="correo" required>
                            </div>
                            <div class="form-group">
                                <label for="editPassword">Contraseña</label>
                                <input type="password" class="form-control" id="editPassword" name="password" autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label for="editRol">Rol</label>
                                <select class="form-control" id="editRol" name="rol" required>
                                    <option value="" selected>Seleccionar</option>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?php echo $role['id']; ?>"><?php echo $role['rol']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editPuesto">Puesto</label>
                                <select class="form-control" id="editPuesto" name="puesto" required>
                                    <option value="" selected>Seleccionar</option>
                                    <?php foreach ($puestos as $puesto): ?>
                                        <option value="<?php echo $puesto['id']; ?>"><?php echo $puesto['puesto']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editSucursal">Sucursal</label>
                                <select class="form-control" id="editSucursal" name="sucursal" required>
                                    <option value="" selected>Seleccionar</option>
                                    <?php foreach ($sucursales as $sucursal): ?>
                                        <option value="<?php echo $sucursal['id']; ?>"><?php echo $sucursal['sucursal']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editEstado">Estado</label>
                                <select class="form-control" id="editEstado" name="estado" required>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript para manejar la edición de usuarios
    function fillEditModal(id, nombre, correo, puesto, sucursal, estado) {
        document.getElementById('editUserId').value = id;
        document.getElementById('editNombre').value = nombre;
        document.getElementById('editCorreo').value = correo;
        document.getElementById('editPuesto').value = puesto;
        document.getElementById('editSucursal').value = sucursal;
        document.getElementById('editEstado').value = estado;
    }

    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            const alertContainer = document.getElementById('alertContainer');
            alertContainer.classList.remove('d-none');

            if (data.success) {
                alertContainer.classList.add('alert-success');
                alertContainer.classList.remove('alert-danger');
                alertContainer.textContent = data.message;
                setTimeout(() => location.reload(), 2000);
            } else {
                alertContainer.classList.add('alert-danger');
                alertContainer.classList.remove('alert-success');
                alertContainer.textContent = data.message;
            }
        })
        .catch(() => {
            const alertContainer = document.getElementById('alertContainer');
            alertContainer.classList.remove('d-none');
            alertContainer.classList.add('alert-danger');
            alertContainer.classList.remove('alert-success');
            alertContainer.textContent = 'Hubo un problema al procesar la solicitud.';
        });
    });

    // Confirmación antes de eliminar un usuario
    function confirmDeleteUser(url) {
        if (confirm('Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.')) {
            window.location.href = url;
        }
    }
</script>

<?php include('components/footer.php'); ?>
