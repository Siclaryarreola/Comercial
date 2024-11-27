<?php
// Incluir el modelo y otras dependencias necesarias
require_once('../models/leadsModel.php');
define('BASE_PATH', dirname(__DIR__)); // Define la ruta base del proyecto

class LeadsController {
    private $leadModel;

    public function __construct() {
        $this->leadModel = new LeadModel();
    }

    public function index() {
        $filters = [];
        if (isset($_SESSION['user']['id_usuarios'])) {
            $filters['id_usuario'] = $_SESSION['user']['id_usuarios'];
        }
        return $this->leadModel->getLeads($filters);
    }

    // Método para manejar la acción 'addLead'
    public function addLead() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $archivo = $this->uploadFile($_FILES['archivo'] ?? null);

            $data = [
                'usuario_id' => $_SESSION['user']['id_usuarios'],
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
                'archivo' => $archivo,
                'estatus' => $_POST['estatus'] ?? 1,
                'periodo' => $_POST['periodo'] ?? 1,
                'medio_contacto' => $_POST['medio_contacto'] ?? 1,
                'gerente_responsable' => $_POST['gerente'] ?? 1
            ];

            $result = $this->leadModel->addLead($data);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Lead añadido correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al añadir el lead']);
            }
            exit();
        }
    }

    private function uploadFile($file) {
        if ($file && $file['error'] === 0 && $file['size'] <= 2 * 1024 * 1024) {
            $allowedTypes = ['application/pdf'];
            if (in_array($file['type'], $allowedTypes)) {
                $uploadDir = BASE_PATH . '/leads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $filename = uniqid() . '_' . basename($file['name']);
                if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                    return 'leads/' . $filename;
                }
            }
        }
        return null;
    }

    // Método para manejar la acción 'getLeadById'
    public function getLeadById($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $lead = $this->leadModel->getLeadById($id);
            if ($lead) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $lead]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Lead no encontrado']);
            }
            exit();
        }
    }

    // Método para obtener datos de dropdowns
    public function getDropdownData() {
        $db = Database::getInstance()->getConnection();

        $dropdownData = [];

        // Obtener estatus
        $query = "SELECT id_estatus AS id, estatus AS nombre_estatus FROM estatusleads";
        $dropdownData['estatus'] = $this->fetchDropdownData($db, $query);

        // Obtener contactos
        $query = "SELECT id_contacto AS id, contacto AS nombre_contacto FROM contactoleads";
        $dropdownData['contactos'] = $this->fetchDropdownData($db, $query);

        // Obtener periodos
        $query = "SELECT id_periodo AS id, periodo AS nombre_periodo FROM periodosleads";
        $dropdownData['periodos'] = $this->fetchDropdownData($db, $query);

        // Obtener gerentes
        $query = "SELECT id_gerente AS id, gerente AS nombre_gerente FROM gerentesleads";
        $dropdownData['gerentes'] = $this->fetchDropdownData($db, $query);

        return $dropdownData;
    }

    private function fetchDropdownData($db, $query) {
        $stmt = $db->prepare($query);
        if (!$stmt) {
            error_log("Error preparando la consulta para dropdown: " . $db->error);
            return [];
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Instanciar y llamar al método directamente si es una petición directa
if (isset($_GET['action'])) {
    session_start();
    $controller = new LeadsController();

    switch ($_GET['action']) {
        case 'addLead':
            $controller->addLead();
            break;
        case 'getLeadById':
            if (isset($_GET['id'])) {
                $controller->getLeadById((int)$_GET['id']);
            }
            break;
        case 'getDropdownData':
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'data' => $controller->getDropdownData()]);
            break;
        default:
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Acción no encontrada']);
            break;
    }
}
