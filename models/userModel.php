<?php
require_once('../config/database.php');

class LeadModel {
    private $db;

<<<<<<< HEAD
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
=======
    public function __construct() 
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener todos los usuarios con roles, puestos y sucursales
    public function getUsuarios() 
    {
        $query = "
            SELECT 
                usuarios.id,
                usuarios.nombre,
                usuarios.correo,
                roles.rol AS rol,
                puestos.puesto AS puesto,
                sucursales.sucursal AS sucursal,
                usuarios.estado,
                usuarios.detalle_id,
                detalleusuarios.ultimo_acceso
            FROM 
                usuarios
            LEFT JOIN roles ON usuarios.rol = roles.id
            LEFT JOIN puestos ON usuarios.puesto = puestos.id
            LEFT JOIN sucursales ON usuarios.sucursal = sucursales.id
            LEFT JOIN detalleusuarios ON usuarios.detalle_id = detalleusuarios.id
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
        if (!$stmt) {
            error_log("Error preparando la consulta SQL: " . $this->db->error);
            return [];
        }

<<<<<<< HEAD
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
=======
        $usuarios = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
            }

<<<<<<< HEAD
            $stmtCliente->bind_param(
                "sssssssi",
                $data['contacto'
=======
        return $usuarios;
    }

    // Método para obtener todos los puestos
    public function getPuestos() 
    {
        $query = "SELECT id, puesto FROM puestos ORDER BY puesto ASC";
        $result = $this->db->query($query);

        if ($result === false) {
            die("Error en la consulta SQL: " . $this->db->error);
        }

        $puestos = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $puestos[] = $row;
            }
        }

        return $puestos;
    }

    // Método para obtener todas las sucursales
    public function getSucursales() 
    {
        $query = "SELECT id, sucursal FROM sucursales ORDER BY sucursal ASC";
        $result = $this->db->query($query);

        if ($result === false) {
            die("Error en la consulta SQL: " . $this->db->error);
        }

        $sucursales = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sucursales[] = $row;
            }
        }

        return $sucursales;
    }

<<<<<<< HEAD
    // Método para obtener todos los roles
    public function getRoles() 
    {
        $query = "SELECT id, rol FROM roles ORDER BY rol ASC";
        $result = $this->db->query($query);

        if ($result === false) {
            die("Error en la consulta SQL: " . $this->db->error);
        }

        $roles = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $roles[] = $row;
            }
        }

        return $roles;
    }

=======
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
    // Método para agregar un nuevo usuario
    public function addUser($name, $email, $password, $role, $position, $branch) 
    {
        $this->db->begin_transaction();

        try {
            // Paso 1: Inserta en la tabla `detalleusuarios`
            $sqlDetalle = "INSERT INTO detalleusuarios (intentos_fallidos, ultimo_acceso, ultimo_intento, reset_token, reset_expiry) VALUES (0, NULL, NULL, NULL, NULL)";
            $stmtDetalle = $this->db->prepare($sqlDetalle);
            $stmtDetalle->execute();

            if ($stmtDetalle->affected_rows !== 1) {
                throw new Exception("Error al insertar en la tabla detalleusuarios");
            }

            $detalleId = $this->db->insert_id;

            // Paso 2: Inserta en la tabla `usuarios`
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sqlUsuario = "INSERT INTO usuarios (nombre, correo, contraseña, rol, puesto, sucursal, estado, detalle_id) VALUES (?, ?, ?, ?, ?, ?, 'Activo', ?)";
            $stmtUsuario = $this->db->prepare($sqlUsuario);
            $stmtUsuario->bind_param("sssiiii", $name, $email, $hashedPassword, $role, $position, $branch, $detalleId);
            $stmtUsuario->execute();

            if ($stmtUsuario->affected_rows !== 1) {
                throw new Exception("Error al insertar en la tabla usuarios");
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Error al agregar usuario: " . $e->getMessage());
            return false;
        }
    }

    // Método para actualizar un usuario existente
    public function updateUser($id, $name, $email, $role, $position, $branch, $state) 
    {
        $sql = "
            UPDATE usuarios 
            SET nombre = ?, correo = ?, rol = ?, puesto = ?, sucursal = ?, estado = ? 
            WHERE id = ?
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssiiii", $name, $email, $role, $position, $branch, $state, $id);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    // Método para eliminar un usuario por ID
    public function deleteUser($id) 
    {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }
}
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
