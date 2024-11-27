<?php
require_once('../config/database.php');

class LeadModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener leads junto con la información del cliente y otras tablas relacionadas
    public function getLeads($filters = []) {
<<<<<<< HEAD
        // Consulta que une leads con clientesleads, periodosleads, estatusleads, gerentesleads, y contactoleads
        $query = "
            SELECT 
                l.*, 
                c.contacto, c.correo, c.telefono, c.empresa, c.giro, c.localidad, c.sucursal,
                p.periodo AS periodo_nombre,  -- Refleja el cambio de nombre_periodo a periodo
                e.estatus AS estatus_nombre, -- Refleja el cambio de nombre a estatus
                g.gerente AS gerente_nombre, -- Refleja el cambio de nombre a gerente
                m.contacto AS medio_contacto_nombre -- Refleja el cambio de nombre a contacto
            FROM leads l
            LEFT JOIN clientesleads c ON l.id_cliente = c.id
            LEFT JOIN periodosleads p ON l.periodo = p.id_periodo  -- Usando 'periodo' para enlazar correctamente con 'id_periodo'
            LEFT JOIN estatusleads e ON l.estatus = e.id_estatus
            LEFT JOIN gerentesleads g ON l.gerente_responsable = g.id_gerente
            LEFT JOIN contactoleads m ON l.medio_contacto = m.id_contacto
=======
        // Consulta que une leads con clientesleads
        $query = "
            SELECT l.*, c.contacto, c.correo, c.telefono, c.empresa, c.giro, c.localidad, c.sucursal
            FROM leads l
            LEFT JOIN clientesleads c ON l.id_cliente = c.id
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
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
<<<<<<< HEAD
        if (!$stmt) {
            error_log("Error preparando la consulta SQL: " . $this->db->error);
            return [];
        }

        if (!empty($params)) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
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
            if (!$stmtCliente) {
                throw new Exception("Error preparando la consulta para insertar en clientesleads: " . $this->db->error);
            }

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

            // Insertar datos en la tabla leads (incluyendo la ruta del archivo)
            $queryLead = "
                INSERT INTO leads (id_cliente, id_usuario, medio_contacto, estatus, cotizacion, linea_negocio, notas, archivo, fecha_generacion, periodo, gerente_responsable)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)
            ";

            $stmtLead = $this->db->prepare($queryLead);
            if (!$stmtLead) {
                throw new Exception("Error preparando la consulta para insertar en leads: " . $this->db->error);
            }

            $stmtLead->bind_param(
                "iissssssii",
                $idCliente,
                $data['usuario_id'],
                $data['medio_contacto'],
                $data['estatus'],
                $data['cotizacion'],
                $data['giro'],
                $data['notas'],
                $data['archivo'],
                $data['periodo'],
                $data['gerente_responsable']
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
=======
        if ($stmt) {
            if (!empty($params)) {
                $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
        }
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
<<<<<<< HEAD
            SELECT 
                l.*, 
                c.contacto, c.correo, c.telefono, c.empresa, c.giro, c.localidad, c.sucursal,
                p.periodo AS periodo_nombre, -- Refleja el cambio de nombre_periodo a periodo
                e.estatus AS estatus_nombre, -- Refleja el cambio de nombre a estatus
                g.gerente AS gerente_nombre, -- Refleja el cambio de nombre a gerente
                m.contacto AS medio_contacto_nombre -- Refleja el cambio de nombre a contacto
            FROM leads l
            LEFT JOIN clientesleads c ON l.id_cliente = c.id
            LEFT JOIN periodosleads p ON l.periodo = p.id_periodo
            LEFT JOIN estatusleads e ON l.estatus = e.id_estatus
            LEFT JOIN gerentesleads g ON l.gerente_responsable = g.id_gerente
            LEFT JOIN contactoleads m ON l.medio_contacto = m.id_contacto
=======
            SELECT l.*, c.contacto, c.correo, c.telefono, c.empresa, c.giro, c.localidad, c.sucursal
            FROM leads l
            LEFT JOIN clientesleads c ON l.id_cliente = c.id
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
            WHERE l.id = ?
        ";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            error_log("Error preparando la consulta para obtener lead por ID: " . $this->db->error);
            return null;
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
