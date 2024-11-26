<?php
require_once('models/loginModel.php');
require_once('controllers/sessionManager.php');



class loginController {
    private $loginModel;

    public function __construct() {
        $this->loginModel = new loginModel();
    }

    public function showLoginForm() {
        require('views/login.php');
    }

    public function showForgotForm() 
    {
        require('comercial/views/forgotPass.php');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['password'])) {
            $email = strtolower(trim($_POST['email']));
            $password = $_POST['password'];

            $user = $this->loginModel->getUserByEmailAndPassword($email, $password);
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
                exit;
            }
        }
    }

    private function redirectUserBasedOnRole($role) 
    {
        header('Location: ../views/dashboard.php');
        exit;
    }
}

?>