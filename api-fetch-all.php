<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    // Check if config.php exists
    if (!file_exists('config.php')) {
        throw new Exception('Config file not found');
    }

    require 'config.php';

    // Check if connection exists
    if (!isset($conn)) {
        throw new Exception('Database connection not established');
    }

    $stmt = $conn->prepare("SELECT * FROM student_tbl ORDER BY id");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        echo json_encode([
            'message' => 'No Record Found',
            'status' => false
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'message' => 'Error: ' . $e->getMessage(),
        'status' => false
    ]);
}
