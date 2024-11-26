<?php 
$activePage = 'users';
require_once('components/header.php');
require_once('../models/userModel.php');

// Instancia del modelo y obtención de datos
$userModel = new UserModel();
$usuarios = $userModel->getUsuarios();
$puestos = $userModel->getPuestos();
$sucursales = $userModel->getSucursales();

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

    <div class="mb-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Añadir Usuario</button>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Rol</th>
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
                        <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
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
                            <a href="../controllers/userController.php?action=deleteUser&id=<?php echo $usuario['id']; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No se encontraron usuarios.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<!-- Modal para Añadir Usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Añadir Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" action="../controllers/userController.php?action=addUser" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
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
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" action="../controllers/userController.php?action=editUser" method="POST">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña (Opcional)</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Dejar en blanco para no cambiarla">
                    </div>
                    <div class="form-group">
                        <label for="puesto">Puesto</label>
                        <select class="form-control" id="puesto" name="puesto" required>
                            <option value="" disabled>Seleccionar</option>
                            <?php foreach ($puestos as $puesto): ?>
                                <option value="<?php echo $puesto['id']; ?>"><?php echo $puesto['puesto']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sucursal">Sucursal</label>
                        <select class="form-control" id="sucursal" name="sucursal" required>
                            <option value="" disabled>Seleccionar</option>
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
                    <button type="submit" class="btn btn-success btn-block">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function fillEditModal(id, nombre, correo, puesto, sucursal, estado) {
        document.getElementById('id').value = id;
        document.getElementById('nombre').value = nombre;
        document.getElementById('correo').value = correo;
        document.getElementById('puesto').value = puesto;
        document.getElementById('sucursal').value = sucursal;
        document.getElementById('estado').value = estado;
    }
</script>

<?php include('components/footer.php'); ?>
