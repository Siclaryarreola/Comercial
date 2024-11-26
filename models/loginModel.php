<?php
require_once('config/database.php');

class LoginModel
{
    private $db;

    public function __construct() 
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getUserByEmailAndPassword($email, $password) 
    {
        $sql = "
            SELECT u.id, u.nombre, u.correo, u.contraseña, u.rol, u.puesto, u.sucursal, u.estado,
                   d.intentos_fallidos, d.ultimo_intento, d.ultimo_acceso, d.reset_token, d.reset_expiry
            FROM usuarios u
            INNER JOIN detalleusuarios d ON u.id = d.id
            WHERE u.correo = ?
        ";
        
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user) {
            if ($user['intentos_fallidos'] >= 3) {
                if ($user['ultimo_intento'] !== NULL) {
                    $lastAttemptTime = new DateTime($user['ultimo_intento']);
                    $currentTime = new DateTime();
                    if (($currentTime->getTimestamp() - $lastAttemptTime->getTimestamp()) < 180) 
                    { 
                        return 'blocked';
                    }
                }
            }

            // Verificar la contraseña
            if (password_verify($password, $user['contraseña'])) 
            {
                $this->resetFailedAttempts($user['id']);
                $this->updateLastAccess($user['id']);
                return $user;
            } else {
                $this->incrementFailedAttempts($user['id']);
                // Depuración: Mostrar mensaje si la contraseña no coincide
                error_log("Contraseña incorrecta para usuario: {$email}");
            }
        } else {
            // Depuración: Usuario no encontrado
            error_log("Usuario no encontrado: {$email}");
        }
        
        return null;
    }

    private function incrementFailedAttempts($userId) 
    {
        $sql = "UPDATE detalleusuarios SET intentos_fallidos = intentos_fallidos + 1, ultimo_intento = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    }

    private function resetFailedAttempts($userId)
    {
        $sql = "UPDATE detalleusuarios SET intentos_fallidos = 0 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    }

    private function updateLastAccess($userId)
    {
        $sql = "UPDATE detalleusuarios SET ultimo_acceso = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    }
}
?>
