<?php
require_once('../config/database.php');

class ProfileModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

<<<<<<< HEAD
    // Obtener los datos del perfil por correo electrónico.
=======
<<<<<<< HEAD
    // Obtener los datos del perfil por correo electrónico.
=======
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
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
<<<<<<< HEAD
                detalleusuarios.foto_perfil, -- Incluye el nuevo campo de archivo cargado
=======
<<<<<<< HEAD
                detalleusuarios.foto_perfil, -- Incluye el nuevo campo de archivo cargado
=======
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
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

<<<<<<< HEAD
    // Actualizar la foto de perfil de un usuario.
=======
<<<<<<< HEAD
    // Actualizar la foto de perfil de un usuario.
=======
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
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

<<<<<<< HEAD
    // Actualizar información básica del perfil de un usuario.
=======
<<<<<<< HEAD
    // Actualizar información básica del perfil de un usuario.
=======
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
    }

    // Actualizar la ruta del archivo cargado en la base de datos.
    public function updateUploadedFilePath($userId, $filePath)
    {
        $query = "
            UPDATE detalleusuarios 
            SET foto_perfil = ? 
            WHERE id = (SELECT detalle_id FROM usuarios WHERE id = ?)
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $filePath, $userId);

        return $stmt->execute();
<<<<<<< HEAD
=======
=======
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
    }
}
