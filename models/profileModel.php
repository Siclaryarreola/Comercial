<?php
require_once('../config/database.php');

class ProfileModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getProfileByEmail($email)
    {
        $query = "
            SELECT 
                usuarios.id,
                usuarios.nombre,
                usuarios.correo,
                detalleusuarios.ultimo_acceso,
                detalleusuarios.fecha_creacion,
                IFNULL(detalleusuarios.foto_perfil, '../public/images/images_usuario.png') AS foto_perfil,
                detalleusuarios.genero,
                roles.rol AS rol
            FROM 
                usuarios
            LEFT JOIN detalleusuarios ON usuarios.detalle_id = detalleusuarios.id
            LEFT JOIN roles ON usuarios.rol = roles.id
            WHERE 
                usuarios.id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function updateProfilePhoto($userId, $photoPath)
    {
        $query = "
            UPDATE detalleusuarios 
            SET foto_perfil = ? 
            WHERE id = (SELECT detalle_id FROM usuarios WHERE id = ?)
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $photoPath, $userId);

        return $stmt->execute();
    }

    public function updateBasicProfileInfo($userId, $name, $gender)
    {
        $query = "
            UPDATE detalleusuarios 
            SET nombre = ?, genero = ? 
            WHERE id = (SELECT detalle_id FROM usuarios WHERE id = ?)
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssi", $name, $gender, $userId);

        return $stmt->execute();
    }
}
