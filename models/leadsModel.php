<?php
require_once('../config/database.php');

class LeadModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener leads junto con la información del cliente
    public function getLeads($filters = []) {
        // Consulta que une leads con clientesleads
        $query = "
            SELECT l.*, c.contacto, c.correo, c.telefono, c.empresa, c.giro, c.localidad, c.sucursal
            FROM leads l
            LEFT JOIN clientesleads c ON l.id_cliente = c.id
        ";
        
        $params = [];
        $conditions = [];
    
        // Agregar filtro por ID de usuario, si se proporciona
        if (!empty($filters['id_usuario'])) {
            $conditions[] = "l.id_usuario = ?";
            $params[] = $filters['id_usuario'];
        }
    
        // Agregar condiciones a la consulta si hay filtros
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
    
        // Ordenar resultados por fecha de generación
        $query .= " ORDER BY l.fecha_generacion DESC";
    
        $stmt = $this->db->prepare($query);
        if ($stmt) {
            if (!empty($params)) {
                $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Método para insertar un nuevo lead
    public function addLead($data) {
        $this->db->begin_transaction();

        try {
            // Insertar datos en la tabla clientesleads
            $queryCliente = "
                INSERT INTO clientesleads (contacto, correo, telefono, empresa, giro, localidad, sucursal, fechaCreacion, id_usuario)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)
            ";

            $stmtCliente = $this->db->prepare($queryCliente);
            $stmtCliente->bind_param(
                "sssssssi",
                $data['contacto'],
                $data['correo'],
                $data['telefono'],
                $data['empresa'],
                $data['giro'],
                $data['localidad'],
                $data['sucursal'],
                $data['usuario_id']
            );

            if (!$stmtCliente->execute()) {
                throw new Exception("Error al insertar en clientesleads: " . $stmtCliente->error);
            }

            // Obtener el ID del cliente insertado
            $idCliente = $this->db->insert_id;

            // Insertar datos en la tabla leads
            $queryLead = "
                INSERT INTO leads (id_cliente, id_usuario, medio_contacto, estatus, cotizacion, linea_negocio, notas, archivo, fecha_generacion)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ";

            $stmtLead = $this->db->prepare($queryLead);
            $stmtLead->bind_param(
                "iissssss",
                $idCliente,
                $data['usuario_id'],
                $data['medio_contacto'],
                $data['estatus'],
                $data['cotizacion'],
                $data['giro'],
                $data['notas'],
                $data['archivo']
            );

            if (!$stmtLead->execute()) {
                throw new Exception("Error al insertar en leads: " . $stmtLead->error);
            }

            // Confirmar transacción
            $this->db->commit();
            return true;

        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->db->rollback();
            error_log($e->getMessage());
            return false;
        }
    }

    // Método para obtener un lead específico por su ID
    public function getLeadById($id) {
        $query = "
            SELECT l.*, c.contacto, c.correo, c.telefono, c.empresa, c.giro, c.localidad, c.sucursal
            FROM leads l
            LEFT JOIN clientesleads c ON l.id_cliente = c.id
            WHERE l.id = ?
        ";

        $stmt = $this->db->prepare($query);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }
}
?>
