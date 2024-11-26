<?php
require_once('config/database.php'); // Ruta a la configuración de la base de datos

class RegisterModel 
{
    private $db;

    public function __construct() 
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Función para crear un usuario con los datos de nombre, email, contraseña, puesto y sucursal
    public function createUser($name, $email, $password, $puesto, $sucursal) 
    {
        // Hashea la contraseña para almacenarla de manera segura
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Paso 1: Inserta en la tabla `detalleusuarios` primero
        $sqlDetalle = "INSERT INTO detalleusuarios (intentos_fallidos, ultimo_intento, ultimo_acceso, reset_token, reset_expiry) VALUES (0, NULL, NULL, NULL, NULL)";
        $stmtDetalle = $this->db->prepare($sqlDetalle);

        if (!$stmtDetalle) {
            return false;
        }

        // Ejecuta la inserción en `detalleusuarios`
        $stmtDetalle->execute();

        // Verifica si se insertó correctamente
        if ($stmtDetalle->affected_rows === 1) {
            // Obtiene el ID insertado en `detalleusuarios`
            $detalleId = $this->db->insert_id;

            // Paso 2: Inserta el usuario en la tabla `usuarios` usando el ID de `detalleusuarios`
            $sqlUsuario = "INSERT INTO usuarios (nombre, correo, contraseña, rol, puesto, sucursal, detalle_id) VALUES (?, ?, ?, 0, ?, ?, ?)";
            $stmtUsuario = $this->db->prepare($sqlUsuario);

            if (!$stmtUsuario) {
                return false;
            }

            // Vincula los parámetros a la consulta SQL de `usuarios`
            $stmtUsuario->bind_param("sssssi", $name, $email, $hashedPassword, $puesto, $sucursal, $detalleId);
            $stmtUsuario->execute();

            // Verifica si se insertó correctamente en `usuarios`
            if ($stmtUsuario->affected_rows === 1) {
                return $this->db->insert_id; // Devuelve el ID del nuevo usuario
            }
        }
        return false;
    }

    // Función para obtener todas las sucursales desde la tabla `sucursales`
    public function getSucursales() 
    {
        $sucursales = [];
        $sql = "SELECT id, sucursal FROM sucursales ORDER BY sucursal ASC";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sucursales[] = $row;
            }
        }
        
        return $sucursales;
    }

    // Función para obtener todos los puestos desde la tabla `puestos`
    public function getPuestos() 
    {
        $puestos = [];
        $sql = "SELECT id, puesto FROM puestos ORDER BY puesto ASC";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $puestos[] = $row;
            }
        }

        return $puestos;
    }
}
?>