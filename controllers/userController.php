<?php
require_once('../models/userModel.php');

class UserController 
{
    private $userModel;

    public function __construct() 
    {
        $this->userModel = new UserModel();
    }

    public function handleRequest() 
    {
        $action = $_GET['action'] ?? '';

        switch ($action) {
            case 'addUser':
                $this->addUser();
                break;

            case 'editUser':
                $this->editUser();
                break;

            case 'deleteUser':
                $this->deleteUser();
                break;

            default:
                echo json_encode(['success' => false, 'message' => 'Acción no válida']);
                break;
        }
    }

    public function addUser() 
    {
        $name = $_POST['nombre'] ?? '';
        $email = $_POST['correo'] ?? '';
        $password = $_POST['password'] ?? ''; // Corregido: 'contraseña' a 'password'
        $role = $_POST['rol'] ?? 0;
        $position = $_POST['puesto'] ?? 0;
        $branch = $_POST['sucursal'] ?? 0;

        if (empty($name) || empty($email) || empty($password) || !$role || !$position || !$branch) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
            return;
        }

        $result = $this->userModel->addUser($name, $email, $password, $role, $position, $branch);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Usuario agregado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al agregar usuario']);
        }
    }

    public function editUser() 
    {
        $id = $_POST['id'] ?? '';
        $name = $_POST['nombre'] ?? '';
        $email = $_POST['correo'] ?? '';
        $password = $_POST['password'] ?? ''; // Contraseña opcional para actualización
        $role = $_POST['rol'] ?? 0;
        $position = $_POST['puesto'] ?? 0;
        $branch = $_POST['sucursal'] ?? 0;
        $state = $_POST['estado'] ?? 'Activo';

        if (empty($id) || empty($name) || empty($email) || !$role || !$position || !$branch || empty($state)) {
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
            return;
        }

        $result = $this->userModel->updateUser($id, $name, $email, $role, $position, $branch, $state, $password);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar usuario']);
        }
    }

    public function deleteUser() 
    {
        $id = $_GET['id'] ?? ''; // Se espera que el ID venga como parámetro GET

        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'ID de usuario no proporcionado']);
            return;
        }

        $result = $this->userModel->deleteUser($id);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar usuario']);
        }
    }
}

$controller = new UserController();
$controller->handleRequest();
