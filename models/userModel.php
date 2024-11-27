<?php
require_once('../config/database.php');

class LeadModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener leads junto con la información del cliente y otras tablas relacionadas
    public function getLeads($filters = []) {
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
                $data['contacto'
