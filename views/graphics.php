<?php 
$activePage = 'graphics';
include('components/header.php');

if (!isset($_SESSION['user'])) {
    header('Location: /comercial/index.php?action=showLoginForm');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos y Estadísticas</title>
    <link rel="stylesheet" href="../public/css/styleGraphics.css">
</head>
<body>
    <div class="main-container">
        <!-- Título principal -->
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
    <?php include('components/footer.php'); ?>
</body>
</html>
