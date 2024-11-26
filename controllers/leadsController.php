<?php
// Incluir el modelo y otras dependencias necesarias
require_once( '../models/leadsModel.php');
define('BASE_PATH', dirname(__DIR__)); // Esto define la ruta base del proyecto


// Clase del controlador
class LeadsController {
    private $leadModel;

    public function __construct() {
        $this->leadModel = new LeadModel();
    }

    public function index() {
        $filters = [];
        if ($_SESSION['user']['rol'] == 0) {
            $filters['usuario_id'] = $_SESSION['user']['id'];
        }
        return $this->leadModel->getLeads($filters);
    }

    // Método para manejar la acción 'addLead'
    public function addLead() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                
            // Crear el array de datos asegurándonos de que los valores opcionales tienen un valor por defecto adecuado.
            $data = [
                'usuario_id' => $_SESSION['user']['id'],
                'empresa' => $_POST['empresa'] ?? 'N/A',
                'localidad' => $_POST['localidad'] ?? 'N/A',
                'giro' => $_POST['giro'] ?? 'N/A',
                'estado' => $_POST['estado'] ?? 'N/A',
                'contacto' => $_POST['contacto'] ?? 'N/A',
                'telefono' => $_POST['telefono'] ?? 'N/A',
                'correo' => $_POST['correo'] ?? 'N/A@example.com',
                'fecha_prospeccion' => $_POST['fecha_prospeccion'] ?? date('Y-m-d'),
                'cotizacion' => $_POST['cotizacion'] ?? 'Sin cotización',
                'notas' => $_POST['notas'] ?? 'Sin notas',
                'archivo' => $this->uploadFile($_FILES['archivo'] ?? 'No archivo'),
                'estatus' => $_POST['estatus'] ?? 'Pendiente'
            ];
    
            // Intento de inserción en la base de datos
            $result = $this->leadModel->addLead($data);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Lead añadido correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al añadir el lead']);
            }
            exit();
        }
    }
    
    
    private function validateData($data) {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                return false; // Considera los datos inválidos si algún campo esencial está vacío o es N/A
            }
        }
        return true; // Todos los campos son válidos
    }
   private function uploadFile($file) {
    $uploadDir = BASE_PATH . '/leads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if ($file['error'] === 0 && $file['size'] <= 2 * 1024 * 1024) { // Tamaño máximo: 2MB
        $allowedTypes = ['application/pdf'];
        if (in_array($file['type'], $allowedTypes)) {
            $filename = uniqid() . '_' . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                return $filename;
            }
        }
    }
    return null;
}

    
}

// Instanciar y llamar al método directamente si es una petición directa
if (isset($_GET['action']) && $_GET['action'] === 'addLead') {
    session_start();  // Iniciar sesión si aún no está iniciada
    $controller = new LeadsController();
    $controller->addLead();
}
?>