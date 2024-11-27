<?php
require_once('models/loginModel.php');
require_once('controllers/sessionManager.php');

<<<<<<< HEAD
class loginController {
    private $loginModel;

    public function __construct() 
    {
=======


class loginController {
    private $loginModel;

    public function __construct() {
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
        $this->loginModel = new loginModel();
    }

    public function showLoginForm() 
    {
        require('views/login.php');
    }

<<<<<<< HEAD
    public function showForgotForm()
    {
        require('views/forgotPass.php');
=======
    public function showForgotForm() 
    {
        require('comercial/views/forgotPass.php');
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
    }

    public function login() 
    {
        header('Content-Type: application/json'); // Configurar el encabezado para JSON
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['password'])) {
            $email = strtolower(trim($_POST['email']));
            $password = $_POST['password'];

            // Obtener usuario del modelo
            $user = $this->loginModel->getUserByEmailAndPassword($email, $password);
<<<<<<< HEAD

            if (is_array($user)) 
            {
                // Inicio de sesión exitoso
                SessionManager::createSession($user);
                echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso', 'redirect' => '../views/dashboard.php']);
                exit;
            } 
            else if ($user === 'blocked') 
            {
                // Usuario bloqueado
                error_log("Cuenta bloqueada para el usuario: {$email}");
                echo json_encode(['success' => false, 'message' => 'La cuenta está bloqueada temporalmente. Intente de nuevo más tarde.']);
                exit;
            } 
            else if ($user === 'incorrect_password') 
            {
                // Contraseña incorrecta
                error_log("Contraseña incorrecta para el usuario: {$email}");
                echo json_encode(['success' => false, 'message' => 'La contraseña ingresada es incorrecta.']);
                exit;
            } 
            else 
            {
                // Usuario no encontrado
                error_log("Usuario no encontrado: {$email}");
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado.']);
=======
            if (is_array($user)) 
            {
                SessionManager::createSession($user);
                $this->redirectUserBasedOnRole($user['rol']);
            } else if ($user === 'blocked') {
                $_SESSION['error'] = 'La cuenta está bloqueada temporalmente. Intente de nuevo más tarde.';
                error_log("Cuenta bloqueada para el usuario: {$email}");
                header('Location: ../index.php?action=showLoginForm');
                exit;
            } else 
            {
                $_SESSION['error'] = 'Credenciales inválidas.';
                error_log("Credenciales inválidas para el usuario: {$email}");
                header('Location: ../index.php?action=showLoginForm');
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
                exit;
            }
        } 
        else 
        {
            // Error en la solicitud (faltan datos)
            echo json_encode(['success' => false, 'message' => 'Correo y contraseña son obligatorios.']);
            exit;
        }
    }

<<<<<<< HEAD
    // Este método no se usa realmente en el flujo actual
    private function redirectUserBasedOnRole($role) 
    {
        // No hace falta esta redirección ya que la redirección ocurre directamente desde el frontend
        echo json_encode(['success' => true, 'redirect' => '../views/dashboard.php']);
        exit;
    }
}
?>
=======
    private function redirectUserBasedOnRole($role) 
    {
        header('Location: ../views/dashboard.php');
        exit;
    }
}

?>
>>>>>>> 4c9af026af87feae3cbeca5fada286962a632d95
