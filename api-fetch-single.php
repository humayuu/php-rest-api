<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['sid'])) {
    $id = $data['sid'];

    require 'config.php';

    $stmt = $conn->prepare("SELECT * FROM student_tbl WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        echo json_encode([
            'message' => 'No Record Found',
            'status' => false
        ]);
    }
} else {
    echo json_encode([
        'message' => 'Missing sid parameter',
        'status' => false
    ]);
}
