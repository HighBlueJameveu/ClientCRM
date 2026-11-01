<?php
$host = 'db';
$db   = 'crm_db';
$user = 'crm_user';
$pass = 'crm_password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}

$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json; charset=utf-8');

if ($method === 'GET') {
    $stmt = $pdo->query("SELECT * FROM clients ORDER BY created_at DESC");
    $clients = $stmt->fetchAll();
    echo json_encode($clients, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data || empty($data['full_name']) || empty($data['phone'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Неверные данные']);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO clients (full_name, phone, email, service_type, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['full_name'],
        $data['phone'],
        $data['email'] ?? '',
        $data['service_type'] ?? 'Кредит',
        $data['status'] ?? 'Новый'
    ]);

    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    exit;
}
if ($method === 'DELETE') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
    }
    exit;
}
?>