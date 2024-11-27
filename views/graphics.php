<?php 
$activePage = 'graphics';
include('components/header.php');
require_once('../controllers/graphicsController.php');

// Obtener usuarios con puesto "Generador de Demanda"
$leadsController = new graphicsController();
$generadores = $leadsController->getGeneradoresDemanda();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Generación de Demanda</title>
    <link rel="stylesheet" href="../public/css/styleGraphics.css">
</head>
<body>
    <div class="main-container">
        <!-- Título principal -->
        <h1 class="text-center mb-4">REPORTE GENERACIÓN DE DEMANDA 2024</h1>

        <div class="dashboard-wrapper">
            <!-- Menú Izquierdo -->
            <aside class="sidebar">
                <h3 class="sidebar-title">Generadores de Demanda</h3>
                <ul class="sidebar-list">
                    <?php foreach ($generadores as $generador): ?>
                        <li class="sidebar-item">
                            <a href="?generador=<?= $generador['id'] ?>" class="sidebar-link">
                                <?= htmlspecialchars($generador['nombre']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>

            <!-- Contenido Principal -->
            <div class="content-container">
                <!-- Filtros -->
                <div class="filters">
                    <select class="form-control" id="selectPeriodo">
                        <option value="">Selecciona un periodo</option>
                        <option value="1">Primer Trimestre</option>
                        <option value="2">Segundo Trimestre</option>
                        <!-- Agregar más opciones según la base de datos -->
                    </select>
                    <select class="form-control" id="selectSucursal">
                        <option value="">Sucursal</option>
                        <option value="1">Querétaro</option>
                        <option value="2">Saltillo</option>
                        <!-- Agregar más opciones según la base de datos -->
                    </select>
                    <select class="form-control" id="selectLineaNegocio">
                        <option value="">Línea de Negocio</option>
                        <option value="MPS">MPS</option>
                        <option value="Sistemas">Sistemas</option>
                        <!-- Agregar más opciones según la base de datos -->
                    </select>
                    <button class="btn btn-primary" id="applyFilters">Aplicar Filtros</button>
                </div>

                <!-- Panel de Conversión de Leads -->
                <div class="conversion-panel">
                    <h3 class="text-center">CONVERSIÓN DE LEADS</h3>
                    <div class="row">
                        <div class="stat-box">
                            <p>LEADS TOTALES</p>
                            <span class="stat-value">21</span>
                        </div>
                        <div class="stat-box">
                            <p>TOTAL COTIZADO</p>
                            <span class="stat-value">$3,110,734</span>
                        </div>
                        <div class="stat-box">
                            <p>VENTAS TOTALES</p>
                            <span class="stat-value">135,000</span>
                        </div>
                        <div class="stat-box">
                            <p>TOTAL PERDIDO</p>
                            <span class="stat-value">$0</span>
                        </div>
                    </div>
                </div>

                <!-- Gráfica -->
                <div class="chart-container">
                    <h3 class="text-center">Desempeño por Sucursal</h3>
                    <canvas id="performanceChart"></canvas>
                </div>

                <!-- Información Detallada -->
                <div class="table-container">
                    <h3>INFORMACIÓN DETALLADA</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>FECHA</th>
                                <th>SUCURSAL</th>
                                <th>EMPRESA</th>
                                <th>ESTATUS</th>
                                <th>LINEA DE NEGOCIO</th>
                                <th>COMENTARIOS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>27 nov 2024</td>
                                <td>Puebla</td>
                                <td>USA SOLAR</td>
                                <td>CONTACTADO</td>
                                <td>MPS</td>
                                <td>Renta de equipo multifuncional a 36 meses</td>
                            </tr>
                            <tr>
                                <td>25 nov 2024</td>
                                <td>León</td>
                                <td>CCA LOGISTICS</td>
                                <td>COTIZACIÓN ENVIADA</td>
                                <td>MPS</td>
                                <td>Renta de equipo de impresión con demo solicitada, 24 meses</td>
                            </tr>
                            <tr>
                                <td>25 nov 2024</td>
                                <td>León</td>
                                <td>EDUCEM</td>
                                <td>COTIZACIÓN ENVIADA</td>
                                <td>MPS</td>
                                <td>Arrendamiento equipo Canon 3326i a 36 meses</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir el archivo de gráficos -->
    <script src="../public/js/graphics.js"></script>
    <?php include('components/footer.php'); ?>
</body>
</html>
