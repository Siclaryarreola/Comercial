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

<<<<<<< HEAD
    /*
        // Paso 1: Inserta en la tabla `detalleusuarios` primero
        $sqlDetalle = "INSERT INTO detalleusuarios (intentos_fallidos) VALUES (0)";
        $stmtDetalle = $this->db->prepare($sqlDetalle);

        if (!$stmtDetalle) {
            error_log("Error preparando la consulta para detalleusuarios: " . $this->db->error);
            return false;
        }

       // Ejecuta la inserción en `detalleusuarios`
       if ($stmtDetalle->execute())
       {
            error_log("Error ejecutando la inserción en detalleusuarios: " . $stmtDetalle->error);
             return false;
       }
    */

     //Verifica si se insertó correctamente
       
           
        // Paso 2: Inserta el usuario en la tabla `usuarios` usando el ID de `detalleusuarios`
        $sqlUsuario = "INSERT INTO usuarios (nombre, correo, contraseña,  puesto, sucursal) VALUES (?, ?, ?, ?, ?)";
        $stmtUsuario = $this->db->prepare($sqlUsuario);

        if (!$stmtUsuario) {
            return false;
=======
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
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
        }

        // Vincula los parámetros a la consulta SQL de `usuarios`
        $stmtUsuario->bind_param("sssii", $name, $email, $hashedPassword, $puesto, $sucursal);
        
        if (!$stmtUsuario->execute()) {
            error_log("Error ejecutando la inserción en usuarios: " . $stmtUsuario->error);
            return false;
        }
        
        
        // Verifica si se insertó correctamente en `usuarios`
        if ($stmtUsuario->affected_rows === 1) {
            return $this->db->insert_id; // Devuelve el ID del nuevo usuario
        }
        else{
          error_log("No se pudo insertar el usuario en la tabla usuarios.");
        }
           
       
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

    //Función para obtener todos los puestos desde la tabla `puestos`
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