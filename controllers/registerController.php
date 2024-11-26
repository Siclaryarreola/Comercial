<?php
require_once('models/registerModel.php'); // Ruta al modelo de registro

class RegisterController 
{
    private $registerModel;

    public function __construct() 
    {
        $this->registerModel = new RegisterModel();
    }

    public function showRegistrationForm() 
    {
        // Obtener las sucursales y los puestos desde el modelo
        $sucursales = $this->registerModel->getSucursales();
        $puestos = $this->registerModel->getPuestos();

        // Hacer que las variables estén disponibles en la vista
        // Incluir el archivo register.php y pasarle las variables necesarias
        require('views/register.php');
    }

    public function register() 
    {
        // Elimina espacios en blanco y valida los datos
        $nombre = trim($_POST['nombre'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = trim($_POST['password'] ?? '');
        $puesto = $_POST['puesto'] ?? '';
        $sucursal = $_POST['sucursal'] ?? '';
    
        if (!empty($nombre) && !empty($email) && !empty($password) && !empty($puesto) && !empty($sucursal)) 
        {
            try 
            {
                // Validación de formato de email
                if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@drg.mx')) 
                {
                    $_SESSION['error'] = 'Por favor, introduzca una dirección de correo electrónico válida que termine en @drg.mx';
                    header('Location: index.php?controller=register&action=showRegistrationForm');
                    exit();
                }
    
                // Validación de que la contraseña no tenga espacios
                if (preg_match('/\s/', $password)) 
                {
                    $_SESSION['error'] = 'La contraseña no puede contener espacios.';
                    header('Location: index.php?controller=register&action=showRegistrationForm');
                    exit();
                }
    
                // Intento de creación del usuario en el modelo
                $result = $this->registerModel->createUser($nombre, $email, $password, $puesto, $sucursal);
                if ($result) 
                {
                    $_SESSION['success'] = 'Registro exitoso';
                    header('Location: index.php?controller=login&action=showLoginForm');
                    exit();
                } 
                else 
                {
                    $_SESSION['error'] = 'Error en el registro. Es posible que el correo electrónico ya esté registrado.';
                    header('Location: index.php?controller=register&action=showRegistrationForm');
                    exit();
                }
            } 
            catch (Exception $e) 
            {
                // Captura y guarda el mensaje de error en la sesión
                $_SESSION['error'] = 'Se produjo un error en el registro: ' . $e->getMessage();
                header('Location: index.php?controller=register&action=showRegistrationForm');
                exit();
            }
        } 
        else 
        {
            // Redirige si faltan datos
            $_SESSION['error'] = 'Por favor, complete todos los campos.';
            header('Location: index.php?controller=register&action=showRegistrationForm');
            exit();
        }
    }
}
