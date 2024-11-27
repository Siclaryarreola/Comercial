<?php
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
require_once('../models/profileModel.php'); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


<<<<<<< HEAD
=======
=======
require_once('../models/profileModel.php');

>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
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
<<<<<<< HEAD
        $email = $_SESSION['user']['id_user'] ?? null;
        if (!$email) {
            throw new Exception("Usuario no autenticado.");
=======
        $email = $_SESSION['user']['id'] ?? null;
        if (!$email) {
<<<<<<< HEAD
            throw new Exception("Usuario no autenticado.");
=======
            throw new Exception("Usuario no autenticado."); // Asegúrate de manejar esta excepción donde llamas este método.
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
        }

        $profileData = $this->profileModel->getProfileByEmail($email);
        if (!$profileData) {
<<<<<<< HEAD
            throw new Exception("No se encontraron datos del perfil del usuario.");
=======
<<<<<<< HEAD
            throw new Exception("No se encontraron datos del perfil del usuario.");
=======
            throw new Exception("No se encontraron datos del perfil del usuario."); // Asegúrate de manejar esta excepción donde llamas este método.
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
        }

        return $profileData;
    }

    // Actualizar la foto de perfil del usuario.
    public function updateProfilePhoto()
    {
<<<<<<< HEAD
        $userId = $_SESSION['user']['id_user'] ?? null;

        if (!$userId || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['foto_perfil'])) {
=======
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['foto_perfil'])) {
<<<<<<< HEAD
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
            $_SESSION['error'] = "Solicitud no válida.";
            header("Location: ../views/profile.php");
            exit;
        }

        $file = $_FILES['foto_perfil'];

        // Validar el archivo subido
        if (!$this->validateUpload($file)) {
            $_SESSION['error'] = "El archivo no cumple con los requisitos.";
            header("Location: ../views/profile.php");
            exit;
        }

        // Generar una ruta única para el archivo
        $destinationPath = "../photos/" . uniqid() . "_" . basename($file['name']);

        // Crear el directorio si no existe
        if (!is_dir('../photos/')) {
            mkdir('../photos/', 0777, true);
        }

        // Mover el archivo al directorio deseado
        if (move_uploaded_file($file['tmp_name'], $destinationPath)) {
            // Guardar la ruta del archivo en la base de datos
            if (!$this->profileModel->updateProfilePhoto($userId, $destinationPath)) {
                $_SESSION['error'] = "Error al guardar la foto en la base de datos.";
                header("Location: ../views/profile.php");
                exit;
            }
            $_SESSION['success'] = "Foto de perfil actualizada correctamente.";
        } else {
            $_SESSION['error'] = "Error al subir el archivo.";
            header("Location: ../views/profile.php");
            exit;
        }

        header("Location: profile.php");
        exit;
<<<<<<< HEAD
    }

    // Validar el archivo subido.
    private function validateUpload($file)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false; // Error en la carga del archivo.
        }

        // Tipos de archivo permitidos
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false; // Tipo de archivo no permitido.
        }

        // Validar el tamaño del archivo (2 MB máximo)
        $maxSize = 2 * 1024 * 1024; // 2 MB en bytes
        if ($file['size'] > $maxSize) {
            return false; // Tamaño no permitido.
        }

        return true; // El archivo es válido.
=======
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
    }

    // Validar el archivo subido.
    private function validateUpload($file)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false; // Error en la carga del archivo.
        }

        // Tipos de archivo permitidos
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false; // Tipo de archivo no permitido.
        }

        // Validar el tamaño del archivo (2 MB máximo)
        $maxSize = 2 * 1024 * 1024; // 2 MB en bytes
        if ($file['size'] > $maxSize) {
            return false; // Tamaño no permitido.
        }

        return true; // El archivo es válido.
=======
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
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
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