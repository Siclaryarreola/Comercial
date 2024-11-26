<?php
require_once('../config/database.php');

class UserModel 
{
    private $db;

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
        ";

        $result = $this->db->query($query);

        if ($result === false) {
            die("Error en la consulta SQL: " . $this->db->error);
        }

        $usuarios = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }

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
