<?php
require_once('../config/database.php');

class GraphicsModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener usuarios con el puesto "Generador de Demanda"
    public function getGeneradoresDemanda() {
        $query = "
            SELECT 
                usuarios.id_usuarios AS usuario_id, 
                usuarios.nombre AS nombre
            FROM 
                usuarios
            INNER JOIN 
                puestos 
            ON 
                usuarios.puesto = puestos.id_puesto
            WHERE 
                puestos.puesto = 'Generador de Demanda'
        ";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            error_log("Error al preparar la consulta: " . $this->db->error);
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Método para obtener leads agrupados por sucursal
    public function getLeadsPorSucursal() {
        $query = "
            SELECT 
                sucursal, 
                COUNT(*) AS total 
            FROM 
                leads 
            GROUP BY 
                sucursal
        ";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            error_log("Error al preparar la consulta: " . $this->db->error);
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
