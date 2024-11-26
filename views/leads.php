<?php 
$activePage = 'leads';
include('components/header.php'); 
require_once('../controllers/leadsController.php');

$leadsController = new LeadsController();
$leads = $leadsController->index();
?>

<!-- Incluir CSS de DataTables y Bootstrap -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../public/css/styleDashboard.css">

<!-- Incluir jQuery y DataTables -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>

<main class="container-fluid mt-5">
    <h1>Leads</h1>
    <div class="mb-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addLeadModal">Agregar nuevo lead</button>
    </div>

    <table class="table table-striped" id="leadsTable">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Localidad</th>
                <th>Giro</th>
                <th>Estado</th>
                <th>Fecha de Prospeccion</th>
                <th>Cotizacion</th>
                <th>Gerente Responsable</th>
                <th>Archivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($leads as $lead): ?>
                <tr>
                    <td><?= htmlspecialchars($lead['empresa'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['localidad'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['giro'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['estado'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['fecha_prospeccion'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['cotizacion'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['gerente_responsable'] ?? 'N/D') ?></td>
                    <td>
                        <?php if (!empty($lead['archivo'])): ?>
                            <a href="../Leads/<?= htmlspecialchars($lead['archivo']) ?>" target="_blank" download>Descargar archivo</a>
                        <?php else: ?>
                            N/D
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="viewLead.php?id=<?= $lead['id'] ?>" class="btn btn-info btn-sm">Detalle</a>
                        <a href="editLead.php?id=<?= $lead['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="deleteLead.php?id=<?= $lead['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que desea eliminar?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<!-- Modal para Agregar Nuevo Lead -->
<!-- Modal para Agregar Nuevo Lead -->
<div class="modal fade" id="addLeadModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar nuevo lead</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addLeadForm" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Columna Izquierda -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="empresa">Empresa</label>
                                <input type="text" class="form-control form-control-sm" id="empresa" name="empresa" required>
                            </div>
                            <div class="form-group">
                                <label for="localidad">Localidad</label>
                                <input type="text" class="form-control form-control-sm" id="localidad" name="localidad">
                            </div>
                            <div class="form-group">
                                <label for="giro">Giro</label>
                                <input type="text" class="form-control form-control-sm" id="giro" name="giro">
                            </div>
                            <div class="form-group">
                                <label for="sucursal">Sucursal</label>
                                <input type="text" class="form-control form-control-sm" id="sucursal" name="sucursal">
                            </div>
                            <div class="form-group">
                                <label for="contacto">Contacto</label>
                                <input type="text" class="form-control form-control-sm" id="contacto" name="contacto">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Telefono</label>
                                <input type="text" class="form-control form-control-sm" id="telefono" name="telefono">
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" class="form-control form-control-sm" id="correo" name="correo">
                            </div>
                        </div>
                        <!-- Columna Derecha -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medio_contacto">Medio de Contacto</label>
                                <select class="form-control form-control-sm" id="medio_contacto" name="medio_contacto" required>
                                    <option value="" selected>Seleccionar</option>
                                    <option value="Expo">Expo</option>
                                    <option value="Llamada">Llamada</option>
                                    <option value="WhatsApp">WhatsApp</option>
                                    <option value="Pagina web">Pagina Web</option>
                                    <option value="Generacion propia">Generacion Propia</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fecha_prospeccion">Fecha de Prospeccion</label>
                                <input type="date" class="form-control form-control-sm" id="fecha_prospeccion" name="fecha_prospeccion">
                            </div>
                            <div class="form-group">
                                <label for="cotizacion">Cotizacion</label>
                                <textarea class="form-control form-control-sm" id="cotizacion" name="cotizacion"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="gerente">Gerente Responsable</label>
                                <select class="form-control form-control-sm" id="gerente" name="gerente" required>
                                    <option value="" selected>Seleccionar</option>
                                    <option value="Ana Velez">Ana Velez - Saltillo / MTY</option>
                                    <option value="Bertha Diaz">Bertha Diaz - Cd. Juarez</option>
                                    <option value="Pamela Hernandez">Pamela Hernandez - Durango</option>
                                    <option value="Ivan Martinez">Iván Martinez - Puebla</option>
                                    <option value="Yaneth Gonzales">Yaneth Gonzales - Tijuana</option>
                                    <option value="Ajelet Sanchez">Ajelet Sanchez - Chihuahua</option>
                                    <option value="Paola Martinez">Paola Martinez - Queretaro / San Luis</option>
                                    <option value="Nadia Villanueva">Nadia Villanueva - Laguna</option>
                                    <option value="Sin Gerente">Sin Gerente - Leon</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="notas">Notas</label>
                                <textarea class="form-control form-control-sm" id="notas" name="notas"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="estatus">Estatus</label>
                                <select class="form-control form-control-sm" id="estatus" name="estatus" required>
                                    <option value="" selected>Seleccionar</option>
                                    <option value="Nuevo">Nuevo</option>
                                    <option value="Prospecto">Prospecto</option>
                                    <option value="En seguimiento">En seguimiento</option>
                                    <option value="Interesado">Interesado</option>
                                    <option value="Cotizacion">Cotizacion Enviada</option>
                                    <option value="Contactado">Contactado</option>
                                    <option value="No contesta">No contesta</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Inservible">Inservible</option>
                                    <option value="Cerrado-Ganado">Cerrado-Ganado</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="archivo">Archivo</label>
                                <input type="file" class="form-control form-control-sm" id="archivo" name="archivo" accept=".pdf">
                            </div>
                        </div>
                    </div>
                    <button type="submit" onclick="submitLeadForm()" class="btn btn-success btn-sm">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#addLeadModal').modal({ show: false });
});
</script>
<?php include('components/footer.php'); ?>
