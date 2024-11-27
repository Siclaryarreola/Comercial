<?php
require_once('../models/graphicsModel.php');

class GraphicsController {
    private $graphicsModel;

    public function __construct() {
        $this->graphicsModel = new GraphicsModel();
    }

    // Método para obtener generadores de demanda
    public function getGeneradoresDemanda() {
        return $this->graphicsModel->getGeneradoresDemanda();
    }

    // Método para obtener leads por sucursal
    public function getLeadsPorSucursal() {
        return $this->graphicsModel->getLeadsPorSucursal();
    }

    // Otros métodos relacionados con gráficos pueden agregarse aquí
}
?>
