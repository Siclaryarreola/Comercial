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

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
            case 'getRoles': // Endpoint for roles
                $this->getRoles();
                break;

<<<<<<< HEAD
=======
=======
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
            default:
                echo json_encode(['success' => false, 'message' => 'Acción no válida']);
                break;
        }
    }

    public function addUser() 
    {
        $name = $_POST['nombre'] ?? '';
        $email = $_POST['correo'] ?? '';
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
        $password = $_POST['password'] ?? ''; 
        $role = $_POST['rol'] ?? null;
        $position = $_POST['puesto'] ?? 0;
        $branch = $_POST['sucursal'] ?? 0;

        // Ajustar la validación para tener en cuenta el rol con valor '0'
        if (empty($name) || empty($email) || empty($password) || !isset($role) || !isset($position) || !isset($branch)) {
<<<<<<< HEAD
=======
=======
        $password = $_POST['password'] ?? ''; // Corregido: 'contraseña' a 'password'
        $role = $_POST['rol'] ?? 0;
        $position = $_POST['puesto'] ?? 0;
        $branch = $_POST['sucursal'] ?? 0;

        if (empty($name) || empty($email) || empty($password) || !$role || !$position || !$branch) {
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
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
<<<<<<< HEAD
        $password = $_POST['password'] ?? ''; 
        $role = $_POST['rol'] ?? null;
=======
<<<<<<< HEAD
        $password = $_POST['password'] ?? ''; 
        $role = $_POST['rol'] ?? null;
=======
        $password = $_POST['password'] ?? ''; // Contraseña opcional para actualización
        $role = $_POST['rol'] ?? 0;
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
        $position = $_POST['puesto'] ?? 0;
        $branch = $_POST['sucursal'] ?? 0;
        $state = $_POST['estado'] ?? 'Activo';

<<<<<<< HEAD
        if (empty($id) || empty($name) || empty($email) || !isset($role) || !isset($position) || !isset($branch) || empty($state)) {
=======
<<<<<<< HEAD
        if (empty($id) || empty($name) || empty($email) || !isset($role) || !isset($position) || !isset($branch) || empty($state)) {
=======
        if (empty($id) || empty($name) || empty($email) || !$role || !$position || !$branch || empty($state)) {
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
            echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
            return;
        }

<<<<<<< HEAD
        $result = $this->userModel->updateUser($id, $name, $email, $role, $position, $branch, $state);
=======
<<<<<<< HEAD
        $result = $this->userModel->updateUser($id, $name, $email, $role, $position, $branch, $state);
=======
        $result = $this->userModel->updateUser($id, $name, $email, $role, $position, $branch, $state, $password);
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar usuario']);
        }
    }

    public function deleteUser() 
    {
<<<<<<< HEAD
        $id = $_GET['id'] ?? ''; 
=======
<<<<<<< HEAD
        $id = $_GET['id'] ?? ''; 
=======
        $id = $_GET['id'] ?? ''; // Se espera que el ID venga como parámetro GET
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95

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
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95

    public function getRoles() 
    {
        $roles = $this->userModel->getRoles();
        echo json_encode(['success' => true, 'roles' => $roles]);
    }
<<<<<<< HEAD
=======
=======
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
}

$controller = new UserController();
$controller->handleRequest();
<<<<<<< HEAD
?>
=======
<<<<<<< HEAD
?>
=======
>>>>>>> cff45ffddbcb0e5238cf42eac9f40556b5905e72
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
