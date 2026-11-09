<?php

$host = getenv('DB_HOST') ?: 'db';
$db   = 'crm_db';
$user = 'crm_user';
$pass = 'crm_password';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    echo "Не вышло подключиться к БД " . $e->getMessage() . "\n";
    exit(1);
}

$testName = "Тестовый Клиент";
$testPhone = "+70000000000";

try {
    echo "Тест POST\n";
    $stmt = $pdo->prepare("INSERT INTO clients (full_name, phone, email, service_type, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$testName, $testPhone, 'test@test.ru', 'Кредит', 'Новый']);
    $newId = $pdo->lastInsertId();

    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$newId]);
    $client = $stmt->fetch();
    
    if (!$client || $client['full_name'] !== $testName) {
        throw new Exception("Запись не найдена в базе после добавления");
    }
    echo "POST успешно добавил $newId\n";

    echo "Тестируем DELETE\n";
    $stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");
    $stmt->execute([$newId]);
    
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$newId]);
    $clientAfterDelete = $stmt->fetch();
    
    if ($clientAfterDelete) {
        throw new Exception("Запись не удалилась из базы");
    }
    echo "\DELETE успешно удалил запись\n";
    
    echo "\nТесты пройдены\n";
    exit(0);

} catch (Exception $e) {
    echo "\nТест првоален " . $e->getMessage() . "\n";
    exit(1);
}
?>