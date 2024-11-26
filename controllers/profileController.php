<?php
require_once('../models/profileModel.php');

class ProfileController
{
    private $profileModel;

    public function __construct()
    {
        $this->profileModel = new ProfileModel();
    }

    // Obtener los datos del perfil utilizando el email almacenado en sesión.
    public function getProfileData()
    {
        $email = $_SESSION['user']['id'] ?? null;
        if (!$email) {
            throw new Exception("Usuario no autenticado."); // Asegúrate de manejar esta excepción donde llamas este método.
        }

        $profileData = $this->profileModel->getProfileByEmail($email);
        if (!$profileData) {
            throw new Exception("No se encontraron datos del perfil del usuario."); // Asegúrate de manejar esta excepción donde llamas este método.
        }

        return $profileData;
    }

    // Actualizar la foto de perfil del usuario.
    public function updateProfilePhoto()
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['foto_perfil'])) {
            throw new Exception("Solicitud no válida."); // Asegúrate de manejar esta excepción donde llamas este método.
        }

        $file = $_FILES['foto_perfil'];
        if (!$this->validateUpload($file)) {
            throw new Exception("Error al procesar el archivo."); // Asegúrate de manejar esta excepción donde llamas este método.
        }

        $destinationPath = "../../photos/" . uniqid() . "_" . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $destinationPath)) {
            if (!$this->profileModel->updateProfilePhoto($userId, $destinationPath)) {
                throw new Exception("Error al guardar la foto en la base de datos."); // Asegúrate de manejar esta excepción donde llamas este método.
            }
            $_SESSION['success'] = "Foto de perfil actualizada correctamente.";
        } else {
            throw new Exception("Error al subir el archivo."); // Asegúrate de manejar esta excepción donde llamas este método.
        }
    }

    // Validar el archivo subido.
    private function validateUpload($file)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        return in_array($file['type'], $allowedTypes);
    }
}