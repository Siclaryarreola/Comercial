<?php 
$activePage = 'graphics';
include('components/header.php');
<<<<<<< HEAD
require_once('../controllers/graphicsController.php');

// Obtener usuarios con puesto "Generador de Demanda"
$leadsController = new graphicsController();
$generadores = $leadsController->getGeneradoresDemanda();
=======

if (!isset($_SESSION['user'])) {
    header('Location: /comercial/index.php?action=showLoginForm');
    exit;
}
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Reporte Generación de Demanda</title>
=======
    <title>Gráficos y Estadísticas</title>
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
    <link rel="stylesheet" href="../public/css/styleGraphics.css">
</head>
<body>
    <div class="main-container">
        <!-- Título principal -->
<<<<<<< HEAD
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
=======
        <h1 class="text-center">Panel de Gráficos y Estadísticas</h1>

        <!-- Contenedor principal -->
        <div class="dashboard-container">
            <!-- Panel superior -->
            <div class="top-panel">
                <div class="stat-box">DÍAS TRANSCURRIDOS <span class="stat-value">60</span></div>
                <div class="stat-box">INVERSIÓN <span class="stat-value">$30,652.00</span></div>
                <div class="stat-box">COSTO POR LEAD <span class="stat-value">$729.81</span></div>
                <div class="stat-box">COSTO POR ADQUISICIÓN DEL CLIENTE <span class="stat-value">0</span></div>
            </div>

            <!-- Panel de métricas -->
            <div class="metrics-panel">
                <div class="metric-box">
                    <p>LEADS TOTALES</p>
                    <span class="metric-value">42</span>
                    <div class="progress-bar"><div style="width: 100%;"></div></div>
                </div>
                <div class="metric-box">
                    <p>CONTACTADOS</p>
                    <span class="metric-value">23</span>
                    <div class="progress-bar"><div style="width: 54.8%;"></div></div>
                </div>
                <div class="metric-box">
                    <p>LEADS CALIFICADOS</p>
                    <span class="metric-value">17</span>
                    <div class="progress-bar"><div style="width: 73.9%;"></div></div>
                </div>
                <div class="metric-box">
                    <p>PROSPECTOS</p>
                    <span class="metric-value">8</span>
                    <div class="progress-bar"><div style="width: 47.1%;"></div></div>
                </div>
                <div class="metric-box">
                    <p>OPORTUNIDADES</p>
                    <span class="metric-value">9</span>
                    <div class="progress-bar"><div style="width: 52.9%;"></div></div>
                </div>
            </div>

            <!-- Panel de gráficos -->
            <div class="charts-panel">
                <div class="chart-box">
                    <h4>Oportunidad</h4>
                    <div class="chart-bar">
                        <span>$6,084,348.43</span>
                        <div class="bar-container">
                            <div style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
                <div class="chart-box">
                    <h4>Venta Total</h4>
                    <div class="chart-bar">
                        <span>0</span>
                        <div class="bar-container">
                            <div style="width: 0%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen por empresa -->
            <div class="table-container">
                <h3>RESUMEN POR EMPRESA</h3>
                <table>
                    <thead>
                        <tr>
                            <th>EMPRESA</th>
                            <th>ESTATUS</th>
                            <th>LINEA DE NEGOCIO</th>
                            <th>COTIZACIÓN</th>
                            <th>¿QUIÉNES SON?</th>
                            <th>SUCURSALES</th>
                            <th>TAMAÑO DE EMPRESA</th>
                            <th>ACTUALIZACIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ZF</td>
                            <td>PROSPECTO</td>
                            <td>SISTEMAS DE ETIQUETADO, CODIFICADO Y RFID</td>
                            <td>0</td>
                            <td>Auto partes diversas</td>
                            <td>18 ubicaciones en México</td>
                            <td>Más de 25,000 empleados</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>WIREMASTERS</td>
                            <td>OPORTUNIDAD</td>
                            <td>SISTEMAS DE ETIQUETADO, CODIFICADO Y RFID</td>
                            <td>305</td>
                            <td>Proveedor de alambres y cables</td>
                            <td>Chihuahua, Querétaro</td>
                            <td>Internacional</td>
                            <td>Se realiza visita...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
    <?php include('components/footer.php'); ?>
</body>
</html>
